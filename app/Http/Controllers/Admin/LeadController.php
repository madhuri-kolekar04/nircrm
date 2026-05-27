<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LeadsImport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Display a listing of the leads.
     */
    public function index(Request $request)
    {
        $query = Lead::with(['creator', 'assignedUser']);
        
        // Apply search filter
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('phone', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('company_name', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        
        // Apply status filter
        if ($request->filled('filter_type') && $request->filled('filter_value') && $request->input('filter_type') === 'status') {
            $filterValue = $request->input('filter_value');
            $query->where('lead_status', $filterValue);
        }
        
        // Apply priority filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }
        
        // Apply source filter
        if ($request->filled('source')) {
            $query->where('source', $request->input('source'));
        }
        
        // Apply work status filter
        if ($request->filled('work_status')) {
            $query->where('work_status', $request->input('work_status'));
        }
        
        $leads = $query->latest()->paginate(10);
        
        // Preserve filter parameters in pagination
        $leads->appends($request->query());
        
        // Get today's due date count
        $todayDueDateCount = Lead::whereDate('due_date', today()->toDateString())->count();
        
        // Calculate empty fields count for each lead
        $leads->getCollection()->transform(function ($lead) {
            $lead->empty_fields_count = $lead->getEmptyFieldsCount();
            return $lead;
        });
        
        return view('admin.leads.index', compact('leads', 'todayDueDateCount'));
    }

    /**
     * Show the form for creating a new lead manually.
     */
    public function create()
    {
        $users = User::orderBy('name', 'asc')->get();
        $departments = Department::all();
        $leadStatuses = Lead::getLeadStatuses();
        $sources = Lead::getSources();
        $priorities = Lead::getPriorities();
        
        return view('admin.leads.create', compact('users', 'departments', 'leadStatuses', 'sources', 'priorities'));
    }

    /**
     * Show the form for creating a new lead (SIMPLE VERSION - NO JAVASCRIPT).
     */
    public function createNew(Request $request)
    {
        // Get departments like the /categories page does
        $categories = \App\Models\Department::latest()->get();
        $users = \App\Models\User::orderBy('name')->get();
        
        // Check if this is coming from callingapp with lead data
        $leadIndex = $request->get('lead_index');
        $preFilledData = [];
        
        if ($leadIndex !== null) {
            try {
                // Make API call to get lead data from callingapp
                $response = \Http::get(url("/callingapp/lead-data/{$leadIndex}"));
                
                if ($response->successful() && $response->json('success')) {
                    $preFilledData = $response->json('lead_data');
                }
            } catch (\Exception $e) {
                \Log::error('Failed to fetch lead data from callingapp: ' . $e->getMessage());
            }
        }
        
        return view('admin.leads.create_new_simple', compact('categories', 'users', 'preFilledData'));
    }

    /**
     * Show NEW fresh edit form for a lead.
     */
    public function editNew($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->load(['creator', 'assignedUser', 'department']);
        // Get departments like /categories page does (same as create form)
        $categories = \App\Models\Department::latest()->get();
        $users = \App\Models\User::orderBy('name', 'asc')->get();
        
        return view('admin.leads.edit_new_simple', compact('lead', 'categories', 'users'));
    }

    /**
     * Store a newly created lead in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'industry' => 'nullable|string|max:100',
            'lead_status' => 'required_without:new_lead_status|in:' . implode(',', \App\Models\Staprio::where('type', 'status')->where('is_active', true)->pluck('value')->toArray()) . ',add_new_status',
            'new_lead_status' => 'required_if:lead_status,add_new_status|string|max:100|unique:staprios,name,NULL,id,type,status',
            'source' => 'required|in:website,referral,social_media,email,phone,advertisement,other',
            'custom_source' => 'required_if:source,other|string|max:255',
            'description' => 'nullable|string',
            'budget' => 'nullable|numeric|min:0',
            'assigned_to' => 'nullable|exists:users,id',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'priority' => 'required_without:new_priority|in:' . implode(',', \App\Models\Staprio::where('type', 'priority')->where('is_active', true)->pluck('value')->toArray()) . ',add_new_priority',
            'new_priority' => 'required_if:priority,add_new_priority|string|max:100|unique:staprios,name,NULL,id,type,priority',
            'department' => 'nullable|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'customer_panel' => 'nullable|boolean',
        ], [
            'lead_status.required_without' => 'Please select a lead status or enter a new one.',
            'lead_status.in' => 'Please select a valid lead status.',
            'new_lead_status.required_if' => 'Please enter a new lead status name.',
            'new_lead_status.unique' => 'This lead status already exists. Please choose a different name.',
            'priority.required_without' => 'Please select a priority or enter a new one.',
            'priority.in' => 'Please select a valid priority.',
            'new_priority.required_if' => 'Please enter a new priority name.',
            'new_priority.unique' => 'This priority already exists. Please choose a different name.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Determine the source value
        $sourceValue = $request->source;
        if ($request->source === 'other' && $request->filled('custom_source')) {
            $sourceValue = $request->custom_source;
        }

        // Handle new lead status creation
        $leadStatusValue = $request->lead_status;
        if ($request->lead_status === 'add_new_status' && $request->filled('new_lead_status')) {
            $newStatusName = $request->new_lead_status;
            $newStatusValue = strtolower(str_replace(' ', '_', $newStatusName));
            
            // Create new status in staprios table
            \App\Models\Staprio::create([
                'name' => $newStatusName,
                'value' => $newStatusValue,
                'type' => 'status',
                'color' => '#6c757d', // Default gray color
                'is_protected' => false,
                'sort_order' => \App\Models\Staprio::getNextSortOrder('status'),
                'is_active' => true,
            ]);
            
            $leadStatusValue = $newStatusValue;
        } elseif ($request->lead_status !== 'add_new_status') {
            // Use existing status value
            $leadStatusValue = $request->lead_status;
        }

        // Handle new priority creation
        $priorityValue = $request->priority;
        if ($request->priority === 'add_new_priority' && $request->filled('new_priority')) {
            $newPriorityName = $request->new_priority;
            $newPriorityValue = strtolower(str_replace(' ', '_', $newPriorityName));
            
            // Create new priority in staprios table
            \App\Models\Staprio::create([
                'name' => $newPriorityName,
                'value' => $newPriorityValue,
                'type' => 'priority',
                'color' => '#6c757d', // Default gray color
                'is_protected' => false,
                'sort_order' => \App\Models\Staprio::getNextSortOrder('priority'),
                'is_active' => true,
            ]);
            
            $priorityValue = $newPriorityValue;
        } elseif ($request->priority !== 'add_new_priority') {
            // Use existing priority value
            $priorityValue = $request->priority;
        }

        // Ensure created_by is set to a valid user ID
        $createdBy = auth()->id();
        if (!$createdBy || !User::find($createdBy)) {
            // Fallback to first available user if auth user not found
            $firstUser = User::first();
            if (!$firstUser) {
                return redirect()->back()
                    ->with('error', 'No users found in the system. Please create a user first.')
                    ->withInput();
            }
            $createdBy = $firstUser->id;
        }

        $lead = Lead::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'website' => $request->website,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'pincode' => $request->pincode,
            'industry' => $request->industry,
            'lead_status' => $leadStatusValue,
            'source' => $sourceValue,
            'description' => $request->description,
            'budget' => $request->budget ?: null,
            'assigned_to' => $request->assigned_to,
            'follow_up_date' => $request->follow_up_date ?: null,
            'notes' => $request->notes,
            'priority' => $priorityValue,
            'department' => $request->department ? json_encode($request->department) : null,
            'department_id' => $request->department_id,
            'created_by' => $createdBy,
            'customer_panel' => $request->customer_panel ?? false,
        ]);

        // Create customer account if customer_panel is enabled
        if ($request->customer_panel && $lead->email) {
            $this->createCustomerAccountForLead($lead);
        }

        return redirect()->route('leads.index')
            ->with('success', 'Lead created successfully!');
    }

    /**
     * Store a newly created lead from the NEW fresh form.
     */
    public function storeNew(Request $request)
    {
        // Simple validation for the new form - NO REQUIRED FIELDS
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'lead_status' => 'nullable|string|max:100',
            'priority' => 'nullable|string|max:100',
            'source' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'industry' => 'nullable|string|max:100',
            'custom_source' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'budget' => 'nullable|numeric|min:0',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'assigned_to' => 'nullable|exists:users,id',
            'work_status' => 'nullable|string|max:255',
            'work_type' => 'nullable|string|max:255',
            'current_service' => 'nullable|string|max:255',
            'date_of_completion' => 'nullable|date',
            'due_date' => 'nullable|date',
        ]);

        // Handle empty budget properly
        if (empty($validated['budget'])) {
            $validated['budget'] = null;
        }

        try {
            // Determine the source value
            $sourceValue = $validated['source'] ?? null;
            if ($request->source === 'other' && $request->filled('custom_source')) {
                $sourceValue = $request->custom_source;
            }
            
            // Create the lead with simple, direct approach
            $lead = Lead::create([
                'name' => $validated['name'] ?? null,
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'company_name' => $validated['company_name'] ?? null,
                'website' => $validated['website'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'state' => $validated['state'] ?? null,
                'country' => $validated['country'] ?? null,
                'pincode' => $validated['pincode'] ?? null,
                'industry' => $validated['industry'] ?? null,
                'lead_status' => $validated['lead_status'] ?? null,
                'source' => $sourceValue ?? null,
                'description' => $validated['description'] ?? null,
                'budget' => $validated['budget'] ?: null,
                'assigned_to' => $validated['assigned_to'] ?? null,
                'follow_up_date' => $validated['follow_up_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'priority' => $validated['priority'] ?? null,
                'department' => null,
                'department_id' => $validated['department_id'] ?? null,
                'created_by' => auth()->id() ?: 18, // Fallback to user ID 18
                'work_status' => $validated['work_status'] ?? null,
                'work_type' => $validated['work_type'] ?? null,
                'current_service' => $validated['current_service'] ?? null,
                'date_of_completion' => $validated['date_of_completion'] ?? null,
                'due_date' => $validated['due_date'] ?? null,
            ]);

            return redirect()->route('leads.index')
                ->with('success', 'Lead created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating lead: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update a newly created lead from NEW fresh form.
     */
    public function updateNew(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        
        // Simple validation for new edit form
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'lead_status' => 'nullable|string|max:100',
            'priority' => 'nullable|string|max:100',
            'source' => 'nullable|string|max:100',
            'custom_source' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'industry' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'budget' => 'nullable|numeric|min:0',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'assigned_to' => 'nullable|exists:users,id',
            'customer_panel' => 'nullable|boolean',
            'work_status' => 'nullable|string|max:255',
            'work_type' => 'nullable|string|max:255',
            'current_service' => 'nullable|string|max:255',
            'date_of_completion' => 'nullable|date',
            'due_date' => 'nullable|date',
        ]);

        try {
            // Determine the source value
            $sourceValue = $validated['source'];
            if ($request->source === 'other' && $request->filled('custom_source')) {
                $sourceValue = $request->custom_source;
            }
            
            // Update lead with simple, direct approach
            $lead->update([
                'name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'company_name' => $validated['company_name'] ?? null,
                'website' => $validated['website'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'state' => $validated['state'] ?? null,
                'country' => $validated['country'] ?? null,
                'pincode' => $validated['pincode'] ?? null,
                'industry' => $validated['industry'] ?? null,
                'lead_status' => $validated['lead_status'],
                'source' => $sourceValue,
                'description' => $validated['description'] ?? null,
                'budget' => $validated['budget'] ?? null,
                'assigned_to' => $validated['assigned_to'] ?? null,
                'follow_up_date' => $validated['follow_up_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'priority' => $validated['priority'],
                'department' => null,
                'department_id' => $validated['department_id'] ?? null,
                'customer_panel' => $validated['customer_panel'] ?? false,
                'work_status' => $validated['work_status'] ?? null,
                'work_type' => $validated['work_type'] ?? null,
                'current_service' => $validated['current_service'] ?? null,
                'date_of_completion' => $validated['date_of_completion'] ?? null,
                'due_date' => $validated['due_date'] ?? null,
            ]);

            return redirect()->route('leads.index')
                ->with('success', 'Lead updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating lead: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the direct Excel upload form with preview.
     */
    public function directUploadForm()
    {
        $users = User::where('department', 'Sales')
                     ->where('position', 'Employee')
                     ->get();
        $departments = Department::all();
        $leadStatuses = Lead::getLeadStatuses();
        $sources = Lead::getSources();
        $priorities = Lead::getPriorities();
        
        return view('admin.leads.direct-upload', compact(
            'users', 
            'departments', 
            'leadStatuses', 
            'sources', 
            'priorities'
        ));
    }

    /**
     * Process Excel file and return preview data.
     */
    public function processExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file: ' . $validator->errors()->first()
            ], 400);
        }

        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            
            $leads = [];
            
            // Start from row 2 (assuming row 1 is headers)
            for ($row = 2; $row <= min($highestRow, 100); $row++) { // Limit to 100 rows for preview
                $rowData = [];
                
                // Read each column
                $rowData['name'] = $this->handleExcelValue($worksheet->getCell('A' . $row)->getValue());
                $rowData['work_status'] = $this->handleExcelValue($worksheet->getCell('E' . $row)->getValue());
                $rowData['work_type'] = $this->handleExcelValue($worksheet->getCell('F' . $row)->getValue());
                $rowData['current_service'] = $this->handleExcelValue($worksheet->getCell('G' . $row)->getValue());
                $rowData['date_of_completion'] = $this->handleExcelDateValue($worksheet->getCell('H' . $row));
                
                // Add work-related columns
                $rowData['work_status'] = $this->handleExcelValue($worksheet->getCell('E' . $row)->getValue());
                $rowData['work_type'] = $this->handleExcelValue($worksheet->getCell('F' . $row)->getValue());
                $rowData['current_service'] = $this->handleExcelValue($worksheet->getCell('G' . $row)->getValue());
                $rowData['date_of_completion'] = $this->handleExcelDateValue($worksheet->getCell('H' . $row));
                
                $rowData['email'] = $this->handleExcelValue($worksheet->getCell('I' . $row)->getValue());
                $rowData['phone'] = $this->handleExcelValue($worksheet->getCell('J' . $row)->getValue());
                $rowData['company_name'] = $this->handleExcelValue($worksheet->getCell('K' . $row)->getValue());
                $rowData['website'] = $this->handleExcelValue($worksheet->getCell('L' . $row)->getValue());
                $rowData['address'] = $this->handleExcelValue($worksheet->getCell('M' . $row)->getValue());
                $rowData['city'] = $this->handleExcelValue($worksheet->getCell('N' . $row)->getValue());
                $rowData['state'] = $this->handleExcelValue($worksheet->getCell('O' . $row)->getValue());
                $rowData['country'] = $this->handleExcelValue($worksheet->getCell('P' . $row)->getValue());
                $rowData['pincode'] = $this->handleExcelValue($worksheet->getCell('Q' . $row)->getValue());
                $rowData['industry'] = $this->handleExcelValue($worksheet->getCell('R' . $row)->getValue());
                $rowData['lead_status'] = $this->handleExcelValue($worksheet->getCell('S' . $row)->getValue());
                $rowData['source'] = $this->handleExcelValue($worksheet->getCell('T' . $row)->getValue());
                $rowData['description'] = $this->handleExcelValue($worksheet->getCell('U' . $row)->getValue());
                $rowData['budget'] = $this->handleExcelValue($worksheet->getCell('V' . $row)->getValue());
                $rowData['follow_up_date'] = $this->handleExcelDateValue($worksheet->getCell('W' . $row));
                $rowData['notes'] = $this->handleExcelValue($worksheet->getCell('X' . $row)->getValue());
                $rowData['priority'] = $this->handleExcelValue($worksheet->getCell('Y' . $row)->getValue());
                $rowData['department'] = $this->handleExcelValue($worksheet->getCell('Z' . $row)->getValue());
                $rowData['state'] = $this->handleExcelValue($worksheet->getCell('M' . $row)->getValue());
                $rowData['country'] = $this->handleExcelValue($worksheet->getCell('N' . $row)->getValue());
                $rowData['pincode'] = $this->handleExcelValue($worksheet->getCell('O' . $row)->getValue());
                $rowData['industry'] = $this->handleExcelValue($worksheet->getCell('P' . $row)->getValue());
                $rowData['lead_status'] = $this->handleExcelValue($worksheet->getCell('Q' . $row)->getValue());
                $rowData['source'] = $this->handleExcelValue($worksheet->getCell('R' . $row)->getValue());
                $rowData['description'] = $this->handleExcelValue($worksheet->getCell('S' . $row)->getValue());
                $rowData['budget'] = $this->handleExcelValue($worksheet->getCell('T' . $row)->getValue());
                $rowData['follow_up_date'] = $this->handleExcelDateValue($worksheet->getCell('U' . $row));
                $rowData['notes'] = $this->handleExcelValue($worksheet->getCell('V' . $row)->getValue());
                $rowData['priority'] = $this->handleExcelValue($worksheet->getCell('W' . $row)->getValue());
                $rowData['department'] = $this->handleExcelValue($worksheet->getCell('X' . $row)->getValue());
                
                // Skip empty rows
                if (empty($rowData['name'])) {
                    continue;
                }
                
                // Normalize the dropdown values
                $rowData['lead_status'] = $this->normalizeLeadStatus($rowData['lead_status']);
                $rowData['source'] = $this->normalizeSource($rowData['source']);
                $rowData['priority'] = $this->normalizePriority($rowData['priority']);
                
                $leads[] = $rowData;
            }
            
            return response()->json([
                'success' => true,
                'leads' => $leads,
                'total_rows' => count($leads)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save the processed leads.
     */
    public function saveDirectUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leads' => 'required|array',
            'leads.*.name' => 'required|string|max:255',
            'leads.*.email' => 'nullable|email|max:255',
            'leads.*.lead_status' => 'required|in:' . implode(',', \App\Models\Staprio::where('type', 'status')->where('is_active', true)->pluck('value')->toArray()),
            'leads.*.source' => 'required|in:website,referral,social_media,email,phone,advertisement,other',
            'leads.*.priority' => 'required|in:' . implode(',', \App\Models\Staprio::where('type', 'priority')->where('is_active', true)->pluck('value')->toArray()),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . $validator->errors()->first()
            ], 400);
        }

        try {
            $leadsData = $request->leads;
            $importedCount = 0;
            $errors = [];

            foreach ($leadsData as $leadData) {
                try {
                    Lead::create([
                        'name' => $this->handleArrayValue($leadData, 'name'),
                        'email' => $this->handleArrayValue($leadData, 'email'),
                        'phone' => $this->handleArrayValue($leadData, 'phone'),
                        'company_name' => $this->handleArrayValue($leadData, 'company_name'),
                        'website' => $this->handleArrayValue($leadData, 'website'),
                        'address' => $this->handleArrayValue($leadData, 'address'),
                        'city' => $this->handleArrayValue($leadData, 'city'),
                        'state' => $this->handleArrayValue($leadData, 'state'),
                        'country' => $this->handleArrayValue($leadData, 'country'),
                        'pincode' => $this->handleArrayValue($leadData, 'pincode'),
                        'industry' => $this->handleArrayValue($leadData, 'industry'),
                        'lead_status' => $this->handleArrayValue($leadData, 'lead_status'),
                        'source' => $this->handleArrayValue($leadData, 'source'),
                        'description' => $this->handleArrayValue($leadData, 'description'),
                        'budget' => $this->handleArrayValue($leadData, 'budget'),
                        'assigned_to' => $this->handleArrayValue($leadData, 'assigned_to'),
                        'follow_up_date' => $this->handleArrayValue($leadData, 'follow_up_date'),
                        'notes' => $this->handleArrayValue($leadData, 'notes'),
                        'priority' => $this->handleArrayValue($leadData, 'priority'),
                        'department' => $this->handleArrayValue($leadData, 'department'),
                        'created_by' => auth()->id(),
                        'work_status' => $this->handleArrayValue($leadData, 'work_status'),
                        'work_type' => $this->handleArrayValue($leadData, 'work_type'),
                        'current_service' => $this->handleArrayValue($leadData, 'current_service'),
                        'date_of_completion' => $this->handleArrayValue($leadData, 'date_of_completion'),
                    ]);
                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Error saving lead '{$leadData['name']}': " . $e->getMessage();
                }
            }

            $message = "Successfully imported {$importedCount} leads!";
            if (!empty($errors)) {
                $message .= " Some errors occurred: " . implode(', ', $errors);
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'imported_count' => $importedCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving leads: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for uploading leads via Excel.
     */
    public function uploadForm()
    {
        return view('admin.leads.upload');
    }

    /**
     * Process Excel file upload.
     */
    public function uploadExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $import = new LeadsImport();
            Excel::import($import, $request->file('excel_file'));
            
            $importedCount = $import->getRowCount();
            $errors = $import->getErrors();
            
            $message = "Successfully imported {$importedCount} leads!";
            
            if (!empty($errors)) {
                $message .= " However, there were some errors: " . implode(', ', $errors);
            }
            
            return redirect()->route('leads.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing file: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Download dummy Excel template.
     */
    public function downloadTemplate(): BinaryFileResponse
    {
        $filePath = public_path('templates/leads_template.xlsx');
        
        if (!file_exists($filePath)) {
            // Create the template if it doesn't exist
            $this->createTemplateFile();
        }
        
        return response()->download($filePath, 'leads_template.xlsx');
    }

    /**
     * Create the Excel template file.
     */
    private function createTemplateFile()
    {
        $templatePath = public_path('templates');
        
        if (!is_dir($templatePath)) {
            mkdir($templatePath, 0755, true);
        }
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set headers
        $headers = [
            'Name*',
            'Work Status',
            'Work Type',
            'Current Service',
            'Date of Completion',
            'Email',
            'Phone',
            'Company Name',
            'Status 16 feb',
            'Website',
            'Address',
            'City',
            'State',
            'Country',
            'Pincode',
            'Industry',
            'Lead Status* (hot/cold/warm/qualified/lost)',
            'Source* (website/referral/social_media/email/phone/advertisement/other)',
            'Description',
            'Budget',
            'Follow Up Date (YYYY-MM-DD)',
            'Notes',
            'Priority* (low/medium/high)',
            'Department'
        ];
        
        $sheet->fromArray($headers, null, 'A1');
        
        // Style the header row
        $sheet->getStyle('A1:X1')->getFont()->setBold(true);
        $sheet->getStyle('A1:X1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE6E6FA');
        
        // Set column widths
        foreach (range('A', 'X') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Add data validation for dropdown lists using direct string formula
        
        // Lead Status dropdown (Column Q) - use formatted labels
        $leadStatusOptions = implode(',', array_values(Lead::getLeadStatuses()));
        $leadStatusValidation = $sheet->getCell('Q2')->getDataValidation();
        $leadStatusValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $leadStatusValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
        $leadStatusValidation->setAllowBlank(true);
        $leadStatusValidation->setShowDropDown(true);
        $leadStatusValidation->setFormula1('"' . $leadStatusOptions . '"');
        $sheet->setDataValidation('Q2:Q1000', $leadStatusValidation);
        
        // Source dropdown (Column R) - use formatted labels
        $sourceOptions = implode(',', array_values(Lead::getSources()));
        $sourceValidation = $sheet->getCell('R2')->getDataValidation();
        $sourceValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $sourceValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
        $sourceValidation->setAllowBlank(true);
        $sourceValidation->setShowDropDown(true);
        $sourceValidation->setFormula1('"' . $sourceOptions . '"');
        $sheet->setDataValidation('R2:R1000', $sourceValidation);
        
        // Priority dropdown (Column W) - use formatted labels
        $priorityOptions = implode(',', array_values(Lead::getPriorities()));
        $priorityValidation = $sheet->getCell('W2')->getDataValidation();
        $priorityValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $priorityValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
        $priorityValidation->setAllowBlank(true);
        $priorityValidation->setShowDropDown(true);
        $priorityValidation->setFormula1('"' . $priorityOptions . '"');
        $sheet->setDataValidation('W2:W1000', $priorityValidation);
        
        // Email validation (Column F) - optional but if provided, must be valid email format
        for ($row = 2; $row <= 1000; $row++) {
            $emailValidation = $sheet->getCell('F' . $row)->getDataValidation();
            $emailValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_CUSTOM);
            $emailValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_WARNING);
            $emailValidation->setAllowBlank(true);
            $emailValidation->setShowDropDown(false);
            $emailValidation->setFormula1('AND(ISNUMBER(SEARCH("@",F' . $row . ')),ISNUMBER(SEARCH(".",F' . $row . ')),LEN(F' . $row . ')>5)');
            $sheet->setDataValidation('F' . $row, $emailValidation);
        }
        
        // Phone validation (Column G) - optional but if provided, should be numeric
        for ($row = 2; $row <= 1000; $row++) {
            $phoneValidation = $sheet->getCell('G' . $row)->getDataValidation();
            $phoneValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_CUSTOM);
            $phoneValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_WARNING);
            $phoneValidation->setAllowBlank(true);
            $phoneValidation->setShowDropDown(false);
            $phoneValidation->setFormula1('OR(ISBLANK(G' . $row . '),ISNUMBER(VALUE(G' . $row . ')))');
            $sheet->setDataValidation('G' . $row, $phoneValidation);
        }
        
        // Date validation for Follow Up Date (Column U)
        for ($row = 2; $row <= 1000; $row++) {
            $dateValidation = $sheet->getCell('U' . $row)->getDataValidation();
            $dateValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_DATE);
            $dateValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_WARNING);
            $dateValidation->setAllowBlank(true);
            $dateValidation->setShowDropDown(false);
            $dateValidation->setFormula1('DATE(2020,1,1)');
            $dateValidation->setFormula2('DATE(2030,12,31)');
            $sheet->setDataValidation('U' . $row, $dateValidation);
        }
        
        // Budget validation (Column T) - optional but if provided, should be numeric
        for ($row = 2; $row <= 1000; $row++) {
            $budgetValidation = $sheet->getCell('T' . $row)->getDataValidation();
            $budgetValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_DECIMAL);
            $budgetValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_WARNING);
            $budgetValidation->setAllowBlank(true);
            $budgetValidation->setShowDropDown(false);
            $budgetValidation->setOperator(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::OPERATOR_GREATERTHANOREQUAL);
            $budgetValidation->setFormula1(0);
            $sheet->setDataValidation('T' . $row, $budgetValidation);
        }
        
        // Add some sample data with proper formatting
        $sampleData = [
            'John Doe',
            'john@example.com',
            '+1234567890',
            'ABC Company',
            'https://abc.com',
            '123 Main St',
            'New York',
            'NY',
            'USA',
            '10001',  // Records column data
            'Technology',
            'Cold',  // Use formatted label
            'Website',  // Use formatted label
            'Sample description',
            '5000.00',
            '2026-02-15',
            'Sample remarks',  // Changed from notes
            'Medium',  // Use formatted label
            'Sales'
        ];
        
        $sheet->fromArray($sampleData, null, 'A2');
        
        // Add instructions sheet
        $instructionSheet = $spreadsheet->createSheet();
        $instructionSheet->setTitle('Instructions');
        
        $instructions = [
            'LEAD IMPORT INSTRUCTIONS',
            '',
            'REQUIRED FIELDS:',
            '• Name*: This field is mandatory',
            '',
            'OPTIONAL FIELDS:',
            '• Email: Must be a valid email format if provided',
            '• Phone: Numeric values only if provided',
            '• Company Name: Text field',
            '• Website: URL format preferred',
            '• Address: Complete address',
            '• City: City name',
            '• State: State/Province name',
            '• Country: Country name',
            '• Pincode: Postal/ZIP code (shown as Records column)',
            '• Industry: Industry type',
            '',
            'FIELDS WITH DROPDOWN VALIDATION:',
            '• Lead Status*: Choose from: Hot, Cold, Warm, Qualified, Lost',
            '• Source*: Choose from: Website, Referral, Social Media, Email, Phone, Advertisement, Other',
            '• Priority*: Choose from: Low, Medium, High',
            '',
            'OTHER FIELDS:',
            '• Description: Free text field',
            '• Budget: Numeric values only',
            '• Follow Up Date: Date format (YYYY-MM-DD)',
            '• Remarks: Free text field (shown as Remarks column)',
            '• Department: Department name',
            '',
            'IMPORTANT NOTES:',
            '• Fields marked with * are required',
            '• Use the dropdown lists for Lead Status, Source, and Priority',
            '• Date format should be YYYY-MM-DD',
            '• Email and Phone fields have validation but are optional',
            '• Budget should be numeric if provided',
            '',
            'SAMPLE DATA:',
            'Row 2 contains sample data that you can use as reference'
        ];
        
        $instructionSheet->fromArray($instructions, null, 'A1');
        $instructionSheet->getStyle('A1:A1')->getFont()->setBold(true)->setSize(14);
        $instructionSheet->getStyle('A3:A3')->getFont()->setBold(true);
        $instructionSheet->getStyle('A6:A6')->getFont()->setBold(true);
        $instructionSheet->getStyle('A15:A15')->getFont()->setBold(true);
        $instructionSheet->getStyle('A23:A23')->getFont()->setBold(true);
        $instructionSheet->getStyle('A25:A25')->getFont()->setBold(true);
        
        $instructionSheet->getColumnDimension('A')->setWidth(80);
        $instructionSheet->getStyle('A1:A30')->getAlignment()->setWrapText(true);
        
        $filePath = $templatePath . '/leads_template.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    /**
     * Display the specified lead.
     */
    public function show($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->load(['creator', 'assignedUser', 'department']);
        
        // Also get department directly for display
        $department = null;
        if ($lead->department_id) {
            $department = \App\Models\Department::find($lead->department_id);
        }
        
        return view('admin.leads.show', compact('lead', 'department'));
    }

    /**
     * Show the form for editing the specified lead.
     */
    public function edit(Lead $lead)
    {
        $users = User::all(); // Get all users initially
        $departments = Department::all();
        $leadStatuses = Lead::getLeadStatuses();
        $sources = Lead::getSources();
        $priorities = Lead::getPriorities();
        
        return view('admin.leads.edit', compact(
            'lead', 
            'users', 
            'departments', 
            'leadStatuses', 
            'sources', 
            'priorities'
        ));
    }

    /**
     * Update the specified lead in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'industry' => 'nullable|string|max:100',
            'lead_status' => 'required|in:' . implode(',', \App\Models\Staprio::where('type', 'status')->where('is_active', true)->pluck('value')->toArray()),
            'source' => 'required|in:website,referral,social_media,email,phone,advertisement,other',
            'custom_source' => 'required_if:source,other|string|max:255',
            'description' => 'nullable|string',
            'budget' => 'nullable|numeric|min:0',
            'assigned_to' => 'nullable|exists:users,id',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'priority' => 'required|in:' . implode(',', \App\Models\Staprio::where('type', 'priority')->where('is_active', true)->pluck('value')->toArray()),
            'department' => 'nullable|string|max:100',
            'customer_panel' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Determine the source value
        $sourceValue = $request->source;
        if ($request->source === 'other' && $request->filled('custom_source')) {
            $sourceValue = $request->custom_source;
        }

        $lead->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'website' => $request->website,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'pincode' => $request->pincode,
            'industry' => $request->industry,
            'lead_status' => $request->lead_status,
            'source' => $sourceValue,
            'description' => $request->description,
            'budget' => $request->budget,
            'assigned_to' => $request->assigned_to,
            'follow_up_date' => $request->follow_up_date,
            'notes' => $request->notes,
            'priority' => $request->priority,
            'department' => $request->department ? json_encode($request->department) : null,
            'customer_panel' => $request->customer_panel ?? false,
        ]);

        return redirect()->route('leads.index')
            ->with('success', 'Lead updated successfully!');
    }

    /**
     * Get users by department for AJAX requests
     */
    public function getUsersByDepartment($department)
    {
        $users = User::where('department', $department)->get(['id', 'name']);
        return response()->json($users);
    }

    /**
     * Update specific lead field via AJAX.
     */
    public function updateField(Request $request, Lead $lead)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        // Debug logging
        \Log::info('updateField called', [
            'lead_id' => $lead->id,
            'field' => $field,
            'value' => $value,
            'request_all' => $request->all()
        ]);

        // Validate field and value
        $allowedFields = ['lead_status', 'priority', 'source'];
        
        if (!in_array($field, $allowedFields)) {
            \Log::error('Invalid field specified', ['field' => $field]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid field specified'
            ], 400);
        }

        // Define validation rules based on field
        $rules = [];
        if ($field === 'lead_status') {
            $validStatuses = \App\Models\Staprio::where('type', 'status')
                ->where('is_active', true)
                ->pluck('value')
                ->toArray();
            $rules[$field] = 'required|in:' . implode(',', $validStatuses);
        } elseif ($field === 'priority') {
            $validPriorities = \App\Models\Staprio::where('type', 'priority')
                ->where('is_active', true)
                ->pluck('value')
                ->toArray();
            $rules[$field] = 'required|in:' . implode(',', $validPriorities);
        } elseif ($field === 'source') {
            $rules[$field] = 'required|in:website,referral,social_media,email,phone,advertisement,other';
        }

        $validator = Validator::make([$field => $value], $rules);

        if ($validator->fails()) {
            \Log::error('Validation failed', [
                'field' => $field,
                'value' => $value,
                'errors' => $validator->errors()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid value for ' . $field
            ], 400);
        }

        try {
            $lead->update([$field => $value]);
            
            \Log::info('Lead updated successfully', [
                'lead_id' => $lead->id,
                'field' => $field,
                'new_value' => $value
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Lead updated successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating lead', [
                'lead_id' => $lead->id,
                'field' => $field,
                'value' => $value,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating lead: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified lead from storage.
     */
    public function destroy(Lead $lead)
    {
        try {
            $lead->delete();
            
            // Return JSON response for AJAX requests
            if (request()->ajax() || request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lead deleted successfully!'
                ]);
            }
            
            // Return redirect for traditional form submissions
            return redirect()->route('leads.index')
                ->with('success', 'Lead deleted successfully!');
                
        } catch (\Exception $e) {
            // Return JSON error response for AJAX requests
            if (request()->ajax() || request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting lead: ' . $e->getMessage()
                ], 500);
            }
            
            // Return redirect with error for traditional form submissions
            return redirect()->route('leads.index')
                ->with('error', 'Error deleting lead: ' . $e->getMessage());
        }
    }

    // Helper functions for normalization
    private function normalizeLeadStatus($value): string
    {
        if ($value === null || $value === '') {
            return 'cold';
        }
        
        $value = strtolower(trim($value));
        
        // Handle various case formats and common variations
        if (in_array($value, ['hot', 'h', 'hot lead', 'hot_lead', 'hotlead'])) {
            return 'hot';
        }
        if (in_array($value, ['cold', 'c', 'cold lead', 'cold_lead', 'coldlead'])) {
            return 'cold';
        }
        if (in_array($value, ['warm', 'w', 'warm lead', 'warm_lead', 'warmlead'])) {
            return 'warm';
        }
        if (in_array($value, ['qualified', 'q', 'qualified lead', 'qualified_lead', 'qualifiedlead'])) {
            return 'qualified';
        }
        if (in_array($value, ['lost', 'l', 'lost lead', 'lost_lead', 'lostlead'])) {
            return 'lost';
        }
        
        return 'cold'; // Return database default if no match
    }

    private function normalizeSource($value): string
    {
        if ($value === null || $value === '') {
            return 'other';
        }
        
        $value = strtolower(trim($value));
        
        // Handle various case formats and common variations
        if (in_array($value, ['website', 'web', 'site', 'online'])) {
            return 'website';
        }
        if (in_array($value, ['referral', 'ref', 'refer'])) {
            return 'referral';
        }
        if (in_array($value, ['social media', 'social_media', 'social', 'fb', 'instagram', 'linkedin', 'twitter'])) {
            return 'social_media';
        }
        if (in_array($value, ['email', 'mail', 'e-mail'])) {
            return 'email';
        }
        if (in_array($value, ['phone', 'call', 'mobile', 'telephone'])) {
            return 'phone';
        }
        if (in_array($value, ['advertisement', 'ad', 'ads', 'marketing'])) {
            return 'advertisement';
        }
        if (in_array($value, ['other', 'others', 'misc', 'miscellaneous'])) {
            return 'other';
        }
        
        return 'other'; // Return database default if no match
    }

    private function normalizePriority($value): string
    {
        if ($value === null || $value === '') {
            return 'medium';
        }
        
        $value = strtolower(trim($value));
        
        // Handle various case formats and common variations
        if (in_array($value, ['low', 'l', 'low priority', 'lowpriority'])) {
            return 'low';
        }
        if (in_array($value, ['medium', 'med', 'm', 'medium priority', 'mediumpriority'])) {
            return 'medium';
        }
        if (in_array($value, ['high', 'h', 'high priority', 'urgent', 'highpriority'])) {
            return 'high';
        }
        
        return 'medium'; // Return database default if no match
    }

    private function normalizeDepartment($value): string
    {
        if ($value === null || $value === '') {
            return '';
        }
        
        return trim($value); // Return as-is since departments can be custom
    }

    /**
     * Send email to lead(s)
     */
    public function sendEmail(Request $request)
    {
        try {
            $request->validate([
                'email_to' => 'required|string',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
                'lead_name' => 'nullable|string'
            ]);

            $emailTo = $request->input('email_to');
            $subject = $request->input('subject');
            $message = $request->input('message');
            $leadName = $request->input('lead_name', 'Valued Customer');
            $senderName = auth()->user()->name;
            $senderEmail = auth()->user()->email;

            // Parse multiple email addresses (comma separated)
            $emails = array_map('trim', explode(',', $emailTo));
            $emails = array_filter($emails, function($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            });

            if (empty($emails)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid email addresses found'
                ], 400);
            }

            // Create attractive HTML email template
            $htmlTemplate = $this->createEmailTemplate($leadName, $message, $senderName, $senderEmail, $subject);

            // Log email details for debugging
            \Log::info('Attempting to send email', [
                'to' => $emails,
                'subject' => $subject,
                'lead_name' => $leadName,
                'from' => config('mail.from.address'),
                'from_name' => config('mail.from.name'),
                'mailer' => config('mail.default'),
                'recipient_count' => count($emails)
            ]);

            // Check mail configuration
            if (!config('mail.from.address')) {
                \Log::error('Mail from address not configured');
                return response()->json([
                    'success' => false,
                    'message' => 'Mail not properly configured. Please check mail settings.'
                ], 500);
            }

            // Send separate emails to each recipient for privacy
            $sentCount = 0;
            $failedEmails = [];
            
            foreach ($emails as $email) {
                try {
                    Mail::html($htmlTemplate, function ($message) use ($email, $subject) {
                        $message->to($email)
                            ->subject($subject)
                            ->from(config('mail.from.address'), config('mail.from.name'));
                    });
                    $sentCount++;
                    \Log::info('Email sent successfully to: ' . $email);
                } catch (\Exception $e) {
                    \Log::error('Failed to send email to ' . $email . ': ' . $e->getMessage());
                    $failedEmails[] = $email;
                }
            }

            \Log::info('Bulk email sending completed. Sent: ' . $sentCount . ', Failed: ' . count($failedEmails));

            $message = 'Email sent successfully to ' . $sentCount . ' recipient' . ($sentCount !== 1 ? 's' : '');
            if (!empty($failedEmails)) {
                $message .= '. Failed to send to: ' . implode(', ', $failedEmails);
            }
            
            return response()->json([
                'success' => $sentCount > 0,
                'message' => $message,
                'sent_count' => $sentCount,
                'failed_count' => count($failedEmails),
                'failed_emails' => $failedEmails
            ]);

        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
            \Log::error('Email error trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create attractive HTML email template
     */
    private function createEmailTemplate($leadName, $message, $senderName, $senderEmail, $subject)
    {
        $companyName = "Niranjan Enterprises Digital Solutions";
        $companyWebsite = "https://niranjanenterprises.com";
        $currentDate = date('F j, Y');
 $logoUrl = asset('n-logo.png');
        
        return "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$subject}</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    line-height: 1.6;
                    color: #2c3e50;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    margin: 0;
                    padding: 20px;
                    -webkit-font-smoothing: antialiased;
                    -moz-osx-font-smoothing: grayscale;
                }
                
                .email-wrapper {
                    max-width: 650px;
                    margin: 0 auto;
                    background: transparent;
                }
                
                .email-container {
                    background: #ffffff;
                    border-radius: 16px;
                    overflow: hidden;
                    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                    margin-bottom: 20px;
                }
                
                .header {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    padding: 40px 30px;
                    text-align: center;
                    position: relative;
                }
                
                .header::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"25\" cy=\"25\" r=\"1\" fill=\"rgba(255,255,255,0.1)\"/><circle cx=\"75\" cy=\"75\" r=\"1\" fill=\"rgba(255,255,255,0.1)\"/><circle cx=\"50\" cy=\"10\" r=\"0.5\" fill=\"rgba(255,255,255,0.05)\"/><circle cx=\"10\" cy=\"50\" r=\"0.5\" fill=\"rgba(255,255,255,0.05)\"/><circle cx=\"90\" cy=\"30\" r=\"0.5\" fill=\"rgba(255,255,255,0.05)\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"/></svg>');
                    opacity: 0.3;
                }
                
                .logo-container {
                    position: relative;
                    z-index: 2;
                    margin-bottom: 20px;
                }
                
                .company-logo {
                    max-width: 180px;
                    height: auto;
                    border-radius: 12px;
                    background: rgba(255, 255, 255, 0.1);
                    padding: 15px;
                    backdrop-filter: blur(10px);
                }
                
                .company-name {
                    color: #ffffff;
                    font-size: 32px;
                    font-weight: 700;
                    margin: 0;
                    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
                    position: relative;
                    z-index: 2;
                }
                
                .company-tagline {
                    color: rgba(255, 255, 255, 0.9);
                    font-size: 16px;
                    margin: 8px 0 0 0;
                    font-weight: 300;
                    position: relative;
                    z-index: 2;
                }
                
                .content {
                    padding: 40px 30px;
                }
                
                .greeting {
                    color: #2c3e50;
                    font-size: 24px;
                    font-weight: 600;
                    margin-bottom: 25px;
                    border-left: 4px solid #667eea;
                    padding-left: 15px;
                }
                
                .message-box {
                    background: linear-gradient(135deg, #f8f9ff 0%, #e8ecff 100%);
                    border: 1px solid #e1e8ff;
                    border-radius: 12px;
                    padding: 25px;
                    margin: 25px 0;
                    position: relative;
                    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
                }
                
                .message-box::before {
                    content: '';
                    position: absolute;
                    top: -2px;
                    left: -2px;
                    right: -2px;
                    bottom: -2px;
                    background: linear-gradient(135deg, #667eea, #764ba2);
                    border-radius: 12px;
                    z-index: -1;
                    opacity: 0.1;
                }
                
                .message-content {
                    color: #2c3e50;
                    font-size: 16px;
                    line-height: 1.7;
                    white-space: pre-wrap;
                    margin: 0;
                }
                
                .signature {
                    margin-top: 35px;
                    padding-top: 25px;
                    border-top: 1px solid #e1e8ff;
                }
                
                .signature-text {
                    color: #7f8c8d;
                    font-size: 14px;
                    margin-bottom: 15px;
                }
                
                .sender-info {
                    margin-top: 20px;
                }
                
                .sender-name {
                    color: #2c3e50;
                    font-size: 18px;
                    font-weight: 600;
                    margin: 0 0 5px 0;
                }
                
                .sender-email {
                    color: #667eea;
                    font-size: 14px;
                    margin: 0 0 5px 0;
                }
                
                .sender-company {
                    color: #2c3e50;
                    font-size: 16px;
                    font-weight: 500;
                    margin: 5px 0 0 0;
                }
                
                .footer {
                    background: #f8f9fa;
                    padding: 30px;
                    text-align: center;
                    border-top: 1px solid #e1e8ff;
                }
                
                .footer-content {
                    color: #7f8c8d;
                    font-size: 12px;
                    line-height: 1.6;
                }
                
                .footer-links {
                    margin-top: 15px;
                }
                
                .footer-links a {
                    color: #667eea;
                    text-decoration: none;
                    margin: 0 10px;
                    font-size: 12px;
                    transition: color 0.3s ease;
                }
                
                .footer-links a:hover {
                    color: #764ba2;
                    text-decoration: underline;
                }
                
                .social-bar {
                    margin-top: 20px;
                    padding-top: 20px;
                    border-top: 1px solid #e1e8ff;
                }
                
                .social-icon {
                    display: inline-block;
                    width: 32px;
                    height: 32px;
                    background: linear-gradient(135deg, #667eea, #764ba2);
                    border-radius: 50%;
                    margin: 0 8px;
                    text-align: center;
                    line-height: 32px;
                    color: white;
                    font-size: 14px;
                    transition: transform 0.3s ease;
                }
                
                .social-icon:hover {
                    transform: translateY(-2px);
                }
                
                /* Responsive Design */
                @media only screen and (max-width: 600px) {
                    body {
                        padding: 10px;
                    }
                    
                    .email-container {
                        border-radius: 12px;
                    }
                    
                    .header {
                        padding: 30px 20px;
                    }
                    
                    .company-logo {
                        max-width: 140px;
                        padding: 10px;
                    }
                    
                    .company-name {
                        font-size: 26px;
                    }
                    
                    .company-tagline {
                        font-size: 14px;
                    }
                    
                    .content {
                        padding: 30px 20px;
                    }
                    
                    .greeting {
                        font-size: 20px;
                        padding-left: 10px;
                    }
                    
                    .message-box {
                        padding: 20px;
                        margin: 20px 0;
                    }
                    
                    .message-content {
                        font-size: 15px;
                    }
                    
                    .sender-name {
                        font-size: 16px;
                    }
                    
                    .sender-company {
                        font-size: 14px;
                    }
                    
                    .footer {
                        padding: 20px;
                    }
                    
                    .footer-links a {
                        display: block;
                        margin: 5px 0;
                    }
                    
                    .social-icon {
                        width: 28px;
                        height: 28px;
                        line-height: 28px;
                        font-size: 12px;
                        margin: 0 5px;
                    }
                }
                
                @media only screen and (max-width: 480px) {
                    .header {
                        padding: 25px 15px;
                    }
                    
                    .content {
                        padding: 25px 15px;
                    }
                    
                    .footer {
                        padding: 15px;
                    }
                    
                    .company-name {
                        font-size: 22px;
                    }
                    
                    .greeting {
                        font-size: 18px;
                    }
                    
                    .message-content {
                        font-size: 14px;
                    }
                }
            </style>
        </head>
        <body>
            <div class='email-wrapper'>
                <div class='email-container'>
                    <div class='header'>
                        <div class='logo-container'>
                            <img src='{$logoUrl}' alt='{$companyName} Logo' class='company-logo'>
                        </div>
                        <h1 class='company-name'>{$companyName}</h1>
                        <p class='company-tagline'>Professional CRM & Business Solutions</p>
                    </div>
                    
                    <div class='content'>
                        <h2 class='greeting'></h2>
                        
                        <div class='message-box'>
                            <p class='message-content'>{$message}</p>
                        </div>
                        
                       
                    </div>
                    
                    <div class='footer'>
                        <div class='footer-content'>
                            <p>This email was sent from the {$companyName} CRM System</p>
                            <p>Sent on {$currentDate} at " . date('g:i A') . "</p>
                            <p>&copy; " . date('Y') . " {$companyName}. All rights reserved.</p>
                            
                            <div class='footer-links'>
                                <a href='{$companyWebsite}/privacy'>Privacy Policy</a>
                                <a href='{$companyWebsite}/terms'>Terms of Service</a>
                                <a href='{$companyWebsite}'>Visit Website</a>
                            </div>
                            
                           
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Handle Excel values by converting them to strings or returning null.
     */
    private function handleExcelValue($value): ?string
    {
        // If it's an array, convert to comma-separated string
        if (is_array($value)) {
            return implode(', ', array_filter($value, function($item) {
                return $item !== null && $item !== '';
            }));
        }
        
        // Handle RichText objects or other complex types
        if (is_object($value)) {
            // Convert to string if possible
            if (method_exists($value, '__toString')) {
                $value = (string) $value;
            } else {
                $value = json_encode($value);
            }
        }
        
        // Convert to string and trim
        if (is_null($value) || $value === '') {
            return null;
        }
        
        return trim((string) $value);
    }

    /**
     * Handle Excel date values by converting Excel date numbers to Y-m-d format.
     */
    private function handleExcelDateValue($cell): ?string
    {
        $value = $cell->getValue();
        
        // If empty, return null
        if (is_null($value) || $value === '') {
            return null;
        }
        
        // If it's a numeric Excel date, convert it
        if (is_numeric($value)) {
            try {
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
                return $date->format('Y-m-d');
            } catch (\Exception $e) {
                // If conversion fails, return null
                return null;
            }
        }
        
        // If it's already a string, try to parse it
        if (is_string($value)) {
            try {
                $date = new \DateTime($value);
                return $date->format('Y-m-d');
            } catch (\Exception $e) {
                // If parsing fails, return null
                return null;
            }
        }
        
        return null;
    }

    /**
     * Handle array values by converting them to strings or returning null.
     */
    private function handleArrayValue($data, $key): ?string
    {
        if (!isset($data[$key])) {
            return null;
        }
        
        $value = $data[$key];
        
        // If it's an array, convert to comma-separated string
        if (is_array($value)) {
            return implode(', ', array_filter($value, function($item) {
                return $item !== null && $item !== '';
            }));
        }
        
        // Convert to string and trim
        return is_null($value) ? null : trim((string) $value);
    }

    /**
     * Test email configuration
     */
    public function testEmail()
    {
        try {
            \Log::info('Testing email configuration...');
            \Log::info('Mail driver: ' . config('mail.default'));
            \Log::info('Mail from address: ' . config('mail.from.address'));
            \Log::info('Mail from name: ' . config('mail.from.name'));

            Mail::raw('Test email from CRM', function ($message) {
                $message->to('test@example.com')
                    ->subject('CRM Email Test')
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            return response()->json([
                'success' => true,
                'message' => 'Test email sent'
            ]);

        } catch (\Exception $e) {
            \Log::error('Test email failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Test email failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the reaction management page for a specific lead
     */
    public function reaction($id)
    {
        $lead = Lead::with(['creator', 'assignedUser', 'department'])->findOrFail($id);
        
        // Get existing reactions for this lead
        $reactions = \App\Models\LeadReaction::where('lead_id', $id)
            ->with(['user', 'department'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get reaction types
        $reactionTypes = [
            'positive' => [
                'emoji' => '😊',
                'label' => 'Positive',
                'color' => '#28a745',
                'description' => 'Interested, Willing to proceed'
            ],
            'neutral' => [
                'emoji' => '😐',
                'label' => 'Neutral',
                'color' => '#ffc107',
                'description' => 'Needs more information, Thinking'
            ],
            'negative' => [
                'emoji' => '😞',
                'label' => 'Negative',
                'color' => '#dc3545',
                'description' => 'Not interested, Rejected'
            ],
            'follow_up' => [
                'emoji' => '📞',
                'label' => 'Follow Up Required',
                'color' => '#17a2b8',
                'description' => 'Call back needed, Pending decision'
            ],
            'interested' => [
                'emoji' => '🔥',
                'label' => 'Highly Interested',
                'color' => '#fd7e14',
                'description' => 'Very interested, Hot lead'
            ],
            'not_reachable' => [
                'emoji' => '📵',
                'label' => 'Not Reachable',
                'color' => '#6c757d',
                'description' => 'Phone not working, No response'
            ]
        ];
        
        return view('admin.leads.reaction_pro', compact('lead', 'reactions', 'reactionTypes'));
    }

    /**
     * Store a new reaction for a lead
     */
    public function storeReaction(Request $request, $id)
    {
        // Enhanced validation
        $validator = Validator::make($request->all(), [
            'reaction_type' => 'required|string|in:positive,neutral,negative,follow_up,interested,not_reachable',
            'notes' => 'nullable|string|max:1000',
            'call_duration' => 'nullable|integer|min:1|max:9999',
            'next_follow_up' => 'nullable|date|after_or_equal:today',
            'reaction_time' => 'nullable|string',
            'lead_id' => 'required|exists:leads,id'
        ], [
            'reaction_type.required' => 'Please select a reaction type',
            'reaction_type.in' => 'Invalid reaction type selected',
            'notes.max' => 'Notes cannot exceed 1000 characters',
            'call_duration.min' => 'Call duration must be at least 1 second',
            'call_duration.max' => 'Call duration cannot exceed 9999 seconds',
            'next_follow_up.after_or_equal' => 'Follow-up date cannot be in the past',
            'lead_id.exists' => 'Lead not found'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Find lead with eager loading
            $lead = Lead::with('assignedUser')->find($id);
            if (!$lead) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lead not found in database'
                ], 404);
            }
            
            // Get current authenticated user with department
            $currentUser = auth()->user();
            if (!$currentUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            // Create reaction with all fields
            $departmentId = is_numeric($currentUser->department) ? (int)$currentUser->department : null;
            
            $reactionData = [
                'lead_id' => $id,
                'user_id' => $currentUser->id,
                'department_id' => $departmentId,
                'reaction_type' => $request->reaction_type,
                'notes' => $request->notes,
                'next_follow_up' => $request->next_follow_up ? date('Y-m-d', strtotime($request->next_follow_up)) : null,
                'call_duration' => $request->call_duration ? (int)$request->call_duration : null,
                'reaction_date' => date('Y-m-d'),
                'reaction_time' => $request->reaction_time ? date('H:i:s', strtotime($request->reaction_time)) : date('H:i:s'),
                'email_sent' => false, // Reset email sent flag for new reactions
            ];
            
            // Create reaction with transaction
            \DB::beginTransaction();
            $reaction = \App\Models\LeadReaction::create($reactionData);
            \DB::commit();

            // Verify reaction was actually saved
            $savedReaction = \App\Models\LeadReaction::with(['user', 'lead'])->find($reaction->id);
            if (!$savedReaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save reaction to database'
                ], 500);
            }

            // Create follow-up notifications if date is set
            if ($request->next_follow_up) {
                $this->createFollowUpNotifications($lead, $reaction, $request->next_follow_up);
                
                // Also send immediate email if time is now or in the past
                $this->sendImmediateFollowUpEmail($lead, $reaction, $request->next_follow_up, $request->reaction_time);
            }

            // Send reaction notification email
            $this->sendReactionNotification($lead, $reaction, $request->reaction_type);

            return response()->json([
                'success' => true,
                'message' => 'Reaction recorded successfully!',
                'reaction' => $savedReaction->load('user'),
                'redirect_url' => route('leads.reaction', $id)
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error recording reaction: ' . $e->getMessage(),
                'error_code' => 'REACTION_STORE_ERROR'
            ], 500);
        }
    }

    /**
     * Create follow-up notifications for assigned user and General Manager
     */
    private function createFollowUpNotifications($lead, $reaction, $followUpDate)
    {
        try {
            $followUpDate = \Carbon\Carbon::parse($followUpDate);
            $reactionTime = \Carbon\Carbon::parse($reaction->reaction_time);
            
            // Create notification for assigned user
            if ($lead->assigned_to && $lead->assignedUser) {
                \App\Models\LeadNotification::createFollowUpNotification(
                    $lead->id,
                    $lead->assignedUser->id,
                    $reaction->id,
                    $followUpDate,
                    $reactionTime
                );
                
                // Send email to assigned user
                $this->sendFollowUpEmail($lead, $reaction, $followUpDate, $reactionTime, $lead->assignedUser);
            }
            
            // Create notification for all General Managers (role = 5)
            $generalManagers = User::where('role', 5)->get();
            foreach ($generalManagers as $gm) {
                \App\Models\LeadNotification::createFollowUpNotification(
                    $lead->id,
                    $gm->id,
                    $reaction->id,
                    $followUpDate,
                    $reactionTime
                );
                
                // Send email to General Manager
                $this->sendFollowUpEmail($lead, $reaction, $followUpDate, $reactionTime, $gm);
            }
            
        } catch (\Exception $e) {
            // Continue without failing the main process
        }
    }

    /**
     * Send follow-up email notification
     */
    private function sendFollowUpEmail($lead, $reaction, $followUpDate, $reactionTime, $recipient)
{
    try {
        $data = [
            'lead' => $lead,
            'reaction' => $reaction,
            'followUpDate' => $followUpDate,
            'reactionTime' => $reactionTime,
            'recipientName' => $recipient->name,
            'recordedBy' => auth()->user()->name,
            'recipientRole' => $recipient->role == 5 ? 'General Manager' : 'Assigned User',
        ];

        Mail::send('emails.lead-followup-notification', $data, function ($message) use ($recipient, $lead, $followUpDate, $reactionTime) {
            $message->to($recipient->email, $recipient->name)
                ->subject('Follow-up Reminder: ' . $lead->name . ' - ' . $followUpDate->format('M d, Y') . ' at ' . $reactionTime->format('g:i A'));
        });
        
    } catch (\Exception $e) {
        \Log::error('Error sending follow-up email: ' . $e->getMessage());
    }
}

    private function sendReactionNotification($lead, $reaction, $reactionType)
    {
    try {
        $recipientEmail = null;
        $recipientName = null;
        
        // Check if lead is assigned to a user
        if ($lead->assigned_to && $lead->assignedUser) {
            $recipientEmail = $lead->assignedUser->email;
            $recipientName = $lead->assignedUser->name;
        }
        // If no assigned user, send to department manager
        elseif ($lead->department_id && $lead->department) {
            $manager = User::where('department', $lead->department->name)
                ->where('position', 'Manager')
                ->first();
            
            if ($manager) {
                $recipientEmail = $manager->email;
                $recipientName = $manager->name;
            }
        }

        if ($recipientEmail) {
            $reactionTypes = [
                'positive' => 'Positive 😊',
                'neutral' => 'Neutral 😐',
                'negative' => 'Negative 😞',
                'follow_up' => 'Follow Up Required 📞',
                'interested' => 'Highly Interested 🔥',
                'not_reachable' => 'Not Reachable 📵'
            ];

            $data = [
                'lead' => $lead,
                'reaction' => $reaction,
                'reactionType' => $reactionTypes[$reactionType] ?? $reactionType,
                'recipientName' => $recipientName,
                'recordedBy' => auth()->user()->name,
            ];

            Mail::send('emails.lead-reaction-notification', $data, function ($message) use ($recipientEmail, $recipientName, $lead) {
                $message->to($recipientEmail, $recipientName)
                    ->subject('New Reaction Recorded for Lead: ' . $lead->name)
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

                \Log::info('Reaction notification sent to: ' . $recipientEmail);
            }
        } catch (\Exception $e) {
            \Log::error('Error sending reaction notification: ' . $e->getMessage());
        }
    }
    
    /**
     * Send immediate follow-up email if time is now or in the past
     */
    private function sendImmediateFollowUpEmail($lead, $reaction, $followUpDate, $reactionTime)
    {
        try {
            $now = \Carbon\Carbon::now();
            $followUp = \Carbon\Carbon::parse($followUpDate);
            $reactionTime = \Carbon\Carbon::parse($reactionTime);
            
            // Create the full follow-up datetime properly
            $followUpDateTime = $followUp->copy()->setTimeFrom($reactionTime);
            
            // Send immediately if follow-up time is now or in the past
            if ($followUpDateTime->lte($now)) {
                // Send to assigned user
                if ($lead->assigned_to && $lead->assignedUser) {
                    $this->sendFollowUpEmail($lead, $reaction, $followUp, $reactionTime, $lead->assignedUser, 'Assigned User');
                }
                
                // Send to General Managers
                $generalManagers = User::where('role', 5)->get();
                foreach ($generalManagers as $gm) {
                    $this->sendFollowUpEmail($lead, $reaction, $followUp, $reactionTime, $gm, 'General Manager');
                }
                
                // Mark as sent
                $reaction->update(['email_sent' => true]);
                
                \Log::info('Immediate follow-up emails sent for reaction ID: ' . $reaction->id);
            }
        } catch (\Exception $e) {
            \Log::error('Error sending immediate follow-up email: ' . $e->getMessage());
        }
    }

    /**
     * Create customer account for lead when customer panel is enabled
     */
    private function createCustomerAccountForLead(Lead $lead)
    {
        try {
            \Log::info('Creating customer account for lead: ' . $lead->id);
            \Log::info('Lead email: ' . $lead->email);
            \Log::info('Lead name: ' . $lead->name);
            
            // Check if customer account already exists
            $existingUser = User::where('email', $lead->email)->first();
            
            if ($existingUser) {
                \Log::info('User already exists with email: ' . $lead->email . '. Current role: ' . $existingUser->role);
                
                // Update existing user to customer role if not already
                if ($existingUser->role != 3) {
                    \Log::info('Updating existing user role to customer (role=3)');
                    $existingUser->update([
                        'role' => 3,
                        'position' => 'Customer',
                        'department' => 'Customer',
                        'contact_number' => $lead->phone ?? $existingUser->contact_number,
                        'comapny_name' => $lead->company_name ?? $existingUser->comapny_name,
                        'password' => Hash::make('123456789'), // Set default password
                        'password_change_required' => true, // Force password change on first login
                    ]);
                    \Log::info('Existing user updated successfully with default password');
                } else {
                    // Even if user already has customer role, update password to default
                    $existingUser->update([
                        'password' => Hash::make('123456789'), // Set default password
                        'password_change_required' => true, // Force password change on first login
                    ]);
                    \Log::info('Customer password updated to default password');
                }
                return;
            }

            // Use default password as requested
            $defaultPassword = '123456789';
            \Log::info('Using default password for new customer: ' . $defaultPassword);
            
            // Create new customer user
            $userData = [
                'name' => $lead->name,
                'email' => $lead->email,
                'contact_number' => $lead->phone ?? '',
                'comapny_name' => $lead->company_name ?? '',
                'pan_number' => '',
                'aadhar_number' => '',
                'department' => 'Customer',
                'password' => Hash::make($defaultPassword),
                'password_change_required' => true, // Force password change on first login
                'role' => 3, // Customer role
                'position' => 'Customer',
            ];

            $user = User::create($userData);
            \Log::info('Customer user created successfully with ID: ' . $user->id . ' and default password');

            // TODO: Send welcome email with password to customer
            \Log::info('Customer account creation completed for lead: ' . $lead->id);

        } catch (\Exception $e) {
            \Log::error('Failed to create customer account for lead ' . $lead->id . ': ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Display due date management page.
     */
    public function dueDateIndex(Request $request)
    {
        $query = Lead::whereNotNull('due_date');
        
        // Apply search filter
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('phone', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('company_name', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        
        // Filter by due date range
        if ($request->filled('due_date_from')) {
            $query->where('due_date', '>=', $request->due_date_from);
        }
        
        if ($request->filled('due_date_to')) {
            $query->where('due_date', '<=', $request->due_date_to);
        }
        
        // Filter by urgency (days until due)
        if ($request->filled('urgency')) {
            $today = now()->startOfDay();
            switch ($request->urgency) {
                case 'overdue':
                    $query->where('due_date', '<', $today);
                    break;
                case 'today':
                    $query->where('due_date', '=', $today);
                    break;
                case 'this_week':
                    $weekEnd = $today->copy()->endOfWeek();
                    $query->whereBetween('due_date', [$today, $weekEnd]);
                    break;
                case 'this_month':
                    $monthEnd = $today->copy()->endOfMonth();
                    $query->whereBetween('due_date', [$today, $monthEnd]);
                    break;
                case 'next_month':
                    $nextMonthStart = $today->copy()->addMonth()->startOfMonth();
                    $nextMonthEnd = $today->copy()->addMonth()->endOfMonth();
                    $query->whereBetween('due_date', [$nextMonthStart, $nextMonthEnd]);
                    break;
            }
        }
        
        $leads = $query->orderBy('due_date', 'asc')->paginate(15);
        
        // Calculate days until due for each lead
        $leads->getCollection()->transform(function ($lead) {
            $today = now()->startOfDay();
            $dueDate = $lead->due_date->startOfDay();
            $daysUntilDue = $today->diffInDays($dueDate, false);
            
            $lead->days_until_due = $daysUntilDue;
            $lead->urgency_status = $this->getUrgencyStatus($daysUntilDue);
            
            return $lead;
        });
        
        return view('admin.leads.duedate', compact('leads'));
    }


//main dashboard
public function dashboardMain()
{
    // Leads Table Data
    $leads = Lead::whereNotNull('due_date')
                 ->orderBy('due_date', 'asc')
                 ->paginate(15);

    // Add urgency calculations
    $leads->getCollection()->transform(function ($lead) {

        $today = now()->startOfDay();

        $dueDate = $lead->due_date->startOfDay();

        $daysUntilDue = $today->diffInDays($dueDate, false);

        $lead->days_until_due = $daysUntilDue;

        $lead->urgency_status = $this->getUrgencyStatus($daysUntilDue);

        return $lead;
    });

    // Dashboard Statistics
    $dashboardData = [

        'totalLeads' => Lead::count(),

        'qualifiedLeads' => Lead::where('lead_status', 'qualified')
                                ->count(),

        'pipelineLeads' => Lead::whereIn('lead_status', [
                        'cold',
                        'warm',
                        'hot'
                    ])->count(),

        'activeClients' => Lead::whereNotNull('due_date')
                        ->where('due_date', '>', now()->startOfDay())
                        ->count(),

        'overdueLeads' => Lead::whereNotNull('due_date')
                              ->where('due_date', '<', now()->startOfDay())
                              ->count(),

        'dueTodayLeads' => Lead::whereDate('due_date', today())
                               ->count(),

        'thisWeekLeads' => Lead::whereBetween(
                                'due_date',
                                [
                                    now()->startOfDay(),
                                    now()->endOfWeek()
                                ]
                            )->count(),

        'thisMonthLeads' => Lead::whereBetween(
                                'due_date',
                                [
                                    now()->startOfDay(),
                                    now()->endOfMonth()
                                ]
                            )->count(),

        'onTrackLeads' => Lead::where('due_date', '>', now()->addDays(7))
                              ->count(),
    ];

    return view('admin.leads.dashboard_main', compact(
        'dashboardData',
        'leads'
    ));
}
    /**
     * Send due date reminder email to a specific lead.
     */
    public function sendDueDateReminder(Request $request, $leadId)
    {
        try {
            $lead = Lead::findOrFail($leadId);
            
            if (!$lead->due_date) {
                return response()->json([
                    'success' => false,
                    'message' => 'This lead does not have a due date set.'
                ]);
            }
            
            if (!$lead->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'This lead does not have an email address.'
                ]);
            }
            
            $customMessage = $request->input('custom_message', null);
            
            // Send email to lead
            $this->sendDueDateEmail($lead, $customMessage);
            
            // Send email to general managers
            $this->sendDueDateEmailToManagers($lead, $customMessage);
            
            return response()->json([
                'success' => true,
                'message' => 'Due date reminder sent successfully to ' . $lead->name . ' and general managers.'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Failed to send due date reminder for lead ' . $leadId . ': ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send due date reminder: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Send bulk due date reminders.
     */
    public function sendBulkDueDateReminders(Request $request)
    {
        try {
            $leadIds = $request->input('lead_ids', []);
            
            if (empty($leadIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No leads selected.'
                ]);
            }
            
            $successCount = 0;
            $errorCount = 0;
            $errors = [];
            
            foreach ($leadIds as $leadId) {
                try {
                    $lead = Lead::findOrFail($leadId);
                    
                    if (!$lead->due_date || !$lead->email) {
                        $errorCount++;
                        $errors[] = "Lead {$lead->name} missing due date or email";
                        continue;
                    }
                    
                    // Send email to lead
                    $this->sendDueDateEmail($lead);
                    
                    // Send email to general managers
                    $this->sendDueDateEmailToManagers($lead);
                    
                    $successCount++;
                    
                } catch (\Exception $e) {
                    $errorCount++;
                    $errors[] = "Failed to send reminder for lead ID {$leadId}: " . $e->getMessage();
                }
            }
            
            $message = "Successfully sent {$successCount} reminders.";
            if ($errorCount > 0) {
                $message .= " Failed to send {$errorCount} reminders.";
                if (!empty($errors)) {
                    $message .= " Errors: " . implode(', ', array_slice($errors, 0, 3));
                    if (count($errors) > 3) {
                        $message .= " and " . (count($errors) - 3) . " more...";
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'success_count' => $successCount,
                'error_count' => $errorCount
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Failed to send bulk due date reminders: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send bulk reminders: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Get urgency status based on days until due.
     */
    private function getUrgencyStatus($daysUntilDue)
    {
        if ($daysUntilDue < 0) {
            return [
                'status' => 'overdue',
                'label' => 'Overdue',
                'color' => 'danger',
                'days_text' => abs($daysUntilDue) . ' days overdue'
            ];
        } elseif ($daysUntilDue == 0) {
            return [
                'status' => 'today',
                'label' => 'Due Today',
                'color' => 'danger',
                'days_text' => 'Due today'
            ];
        } elseif ($daysUntilDue <= 7) {
            return [
                'status' => 'urgent',
                'label' => 'Urgent',
                'color' => 'warning',
                'days_text' => $daysUntilDue . ' days left'
            ];
        } elseif ($daysUntilDue <= 30) {
            return [
                'status' => 'soon',
                'label' => 'Due Soon',
                'color' => 'info',
                'days_text' => $daysUntilDue . ' days left'
            ];
        } else {
            return [
                'status' => 'normal',
                'label' => 'On Track',
                'color' => 'success',
                'days_text' => $daysUntilDue . ' days left'
            ];
        }
    }
    
    /**
     * Send due date email to lead.
     */
    private function sendDueDateEmail($lead, $customMessage = null)
    {
        $daysUntilDue = now()->startOfDay()->diffInDays($lead->due_date->startOfDay(), false);
        $urgencyStatus = $this->getUrgencyStatus($daysUntilDue);
        
        $subject = "Important: Due Date Reminder - " . $lead->name;
        
        // Add custom message styling if present
        $customMessageStyle = '';
        if ($customMessage) {
            $customMessageStyle = "
                .custom-message { 
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                    color: white; 
                    padding: 20px; 
                    border-radius: 8px; 
                    margin: 15px 0; 
                    border-left: 5px solid #4a5568;
                }
                .custom-message h4 {
                    color: #ffd700;
                    margin-bottom: 10px;
                    font-size: 18px;
                }
                .custom-message p {
                    margin: 0;
                    font-size: 16px;
                    line-height: 1.5;
                }
            ";
        }

        $emailContent = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .header { background: #f8f9fa; padding: 20px; border-bottom: 3px solid #007bff; }
                    .content { padding: 20px; }
                    .due-date { background: #fff3cd; padding: 15px; border-radius: 5px; margin: 15px 0; }
                    .footer { background: #f8f9fa; padding: 15px; border-top: 1px solid #dee2e6; font-size: 12px; }
                    .urgent { color: #dc3545; font-weight: bold; }
                    $customMessageStyle
                </style>
            </head>
            <body>
                <div class='header'>
                    <h2>Due Date Reminder</h2>
                </div>
                <div class='content'>
                    <p>Dear {$lead->name},</p>
                    <p>This is a friendly reminder regarding your upcoming due date:</p>
                    <div class='due-date'>
                        <h3>Due Date Details:</h3>
                        <p><strong>Due Date:</strong> {$lead->due_date->format('l, F j, Y')}</p>
                        <p><strong>Status:</strong> <span class='urgent'>{$urgencyStatus['label']}</span></p>
                        <p><strong>Time Remaining:</strong> {$urgencyStatus['days_text']}</p>
                        " . ($customMessage ? "
                        <div class='custom-message'>
                            <h4>Personal Message:</h4>
                            <p>" . htmlspecialchars($customMessage) . "</p>
                        </div>
                        " : "") . "
                    </div>
                    <p>Please ensure all necessary arrangements are made before the due date. If you have any questions or need assistance, please don't hesitate to contact us.</p>
                    <p>Best regards,<br>CRM Team</p>
                </div>
                <div class='footer'>
                    <p>This is an automated message. Please do not reply to this email.</p>
                </div>
            </body>
            </html>
        ";
        
        Mail::html($emailContent, function ($message) use ($lead, $subject) {
            $message->to($lead->email)
                    ->subject($subject)
                    ->from(config('mail.from.address'), config('mail.from.name'));
        });
    }
    
    /**
     * Send due date email to general managers.
     */
    private function sendDueDateEmailToManagers($lead, $customMessage = null)
    {
        $generalManagers = User::where('role', 5)->get(); // General Manager role ID
        
        if ($generalManagers->isEmpty()) {
            \Log::info('No general managers found to send due date notification');
            return;
        }
        
        $daysUntilDue = now()->startOfDay()->diffInDays($lead->due_date->startOfDay(), false);
        $urgencyStatus = $this->getUrgencyStatus($daysUntilDue);
        
        $subject = "Manager Alert: Due Date Reminder - " . $lead->name;
        
        $emailContent = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .header { background: #f8f9fa; padding: 20px; border-bottom: 3px solid #dc3545; }
                    .content { padding: 20px; }
                    .lead-info { background: #e9ecef; padding: 15px; border-radius: 5px; margin: 15px 0; }
                    .due-date { background: #fff3cd; padding: 15px; border-radius: 5px; margin: 15px 0; }
                    .footer { background: #f8f9fa; padding: 15px; border-top: 1px solid #dee2e6; font-size: 12px; }
                    .urgent { color: #dc3545; font-weight: bold; }
                </style>
            </head>
            <body>
                <div class='header'>
                    <h2>Manager Alert: Due Date Reminder</h2>
                </div>
                <div class='content'>
                    <p>Dear General Manager,</p>
                    <p>This is an automated notification regarding a lead with an upcoming due date:</p>
                    <div class='lead-info'>
                        <h3>Lead Information:</h3>
                        <p><strong>Name:</strong> {$lead->name}</p>
                        <p><strong>Email:</strong> {$lead->email}</p>
                        <p><strong>Phone:</strong> {$lead->phone}</p>
                        <p><strong>Company:</strong> {$lead->company_name}</p>
                        <p><strong>Status:</strong> {$lead->lead_status}</p>
                        <p><strong>Priority:</strong> {$lead->priority}</p>
                    </div>
                    <div class='due-date'>
                        <h3>Due Date Information:</h3>
                        <p><strong>Due Date:</strong> {$lead->due_date->format('l, F j, Y')}</p>
                        <p><strong>Status:</strong> <span class='urgent'>{$urgencyStatus['label']}</span></p>
                        <p><strong>Time Remaining:</strong> {$urgencyStatus['days_text']}</p>
                        " . ($customMessage ? "
                        <div style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px; border-radius: 5px; margin: 10px 0;'>
                            <h4 style='color: #ffd700; margin-bottom: 8px;'>Personal Message:</h4>
                            <p style='margin: 0; font-size: 14px;'>" . htmlspecialchars($customMessage) . "</p>
                        </div>
                        " : "") . "
                    </div>
                    <p>Please review this lead and take appropriate action if necessary.</p>
                    <p>Best regards,<br>CRM System</p>
                </div>
                <div class='footer'>
                    <p>This is an automated message. Please do not reply to this email.</p>
                </div>
            </body>
            </html>
        ";
        
        foreach ($generalManagers as $manager) {
            try {
                Mail::html($emailContent, function ($message) use ($manager, $subject) {
                    $message->to($manager->email)
                            ->subject($subject)
                            ->from(config('mail.from.address'), config('mail.from.name'));
                });
            } catch (\Exception $e) {
                \Log::error('Failed to send due date email to manager ' . $manager->email . ': ' . $e->getMessage());
            }
        }
    }
}
