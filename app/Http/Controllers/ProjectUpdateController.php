<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProjectUpdate;
use App\Models\Invoice;
use App\Models\User;
use App\Models\ProjectCompletionStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProjectUpdateController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all employees for the report dropdown
        $employees = User::whereIn('role', [2, 4, 6, 7, 8]) // Employees, Manager, Marketing, Sales, Account
                        ->whereNotNull('department')
                        ->orderBy('name')
                        ->get();
        
        // Get user's department name
        $userDepartmentName = null;
        if ($user->department_id) {
            $department = \App\Models\Department::find($user->department_id);
            $userDepartmentName = $department ? $department->department : null;
        } elseif ($user->department) {
            $userDepartmentName = $user->department;
        }
        
        // Department-wise filtering for Employee (role 2) and Manager (role 4)
        if ($user->role == 2 || $user->role == 4) {
            // For Employee and Manager roles, show only their department's invoices
            if ($userDepartmentName) {
                $invoices = \App\Models\Invoice::where('department', $userDepartmentName)
                    ->latest()
                    ->get();
            } else {
                $invoices = collect(); // Empty collection if no department assigned
            }
        }
        // For customer role (role 3), show only their invoices
        elseif ($user->role == 3) {
            $invoices = \App\Models\Invoice::where('customer_email', $user->email)
                ->latest()
                ->get();
        }
        // For Admin (role 1), CEO (role 5), and other roles, show all invoices
        else {
            $invoices = \App\Models\Invoice::latest()->get();
        }
        
        return view('project_updates.customer_invoices', compact('invoices', 'employees'));
    }
    
    public function projectDashboard()
    {
        $user = Auth::user();
        
        // Get all employees for the report dropdown
        $employees = User::whereIn('role', [2, 4, 6, 7, 8]) // Employees, Manager, Marketing, Sales, Account
                        ->whereNotNull('department')
                        ->orderBy('name')
                        ->get();
        
        // Get project-wise data based on user role with department filtering
        $projectData = $this->getProjectWiseData($user);
        
        // Get user's department name
        $userDepartmentName = null;
        if ($user->department_id) {
            $department = \App\Models\Department::find($user->department_id);
            $userDepartmentName = $department ? $department->department : null;
        } elseif ($user->department) {
            $userDepartmentName = $user->department;
        }
        
        // Department-wise filtering for Employee (role 2) and Manager (role 4)
        if ($user->role == 2 || $user->role == 4) {
            // For Employee and Manager roles, show only their department's invoices
            if ($userDepartmentName) {
                $invoices = \App\Models\Invoice::where('department', $userDepartmentName)
                    ->latest()
                    ->get();
            } else {
                $invoices = collect(); // Empty collection if no department assigned
            }
        }
        // For customer role (role 3), show only their invoices
        elseif ($user->role == 3) {
            $invoices = \App\Models\Invoice::where('customer_email', $user->email)
                ->latest()
                ->get();
        }
        // For Admin (role 1), CEO (role 5), and other roles, show all invoices
        else {
            $invoices = \App\Models\Invoice::latest()->get();
        }
        
        return view('project_updates.index', compact('invoices', 'employees', 'projectData'));
    }
    
    private function getProjectWiseData($user)
    {
        // Build query for projects with updates
        $query = Product::with(['projectUpdates.user', 'category', 'customer', 'departmentfuc']);
        
        // Get user's department name
        $userDepartmentName = null;
        if ($user->department_id) {
            $department = \App\Models\Department::find($user->department_id);
            $userDepartmentName = $department ? $department->department : null;
        } elseif ($user->department) {
            $userDepartmentName = $user->department;
        }
        
        // Department-wise filtering for Employee (role 2) and Manager (role 4)
        if ($user->role == 2 || $user->role == 4) {
            if ($userDepartmentName) {
                // Filter projects by department name through the department relationship
                $query->whereHas('departmentfuc', function($q) use ($userDepartmentName) {
                    $q->where('department', $userDepartmentName);
                });
            } else {
                // If no department assigned, return empty result
                return collect();
            }
        }
        // Admin (role 1), CEO (role 5), and other roles can see all projects
        // Customer (role 3) sees only their assigned projects
        
        $projects = $query->latest()->get();
        
        // Additional filtering for customers - show only their assigned projects
        if ($user->role == 3) {
            $projects = $projects->where('customerlist', $user->id);
        }
        
        // Process project data
        $projectData = [];
        foreach ($projects as $project) {
            $updates = $project->projectUpdates;
            
            $projectData[] = [
                'project' => $project,
                'total_updates' => $updates->count(),
                'recent_updates' => $updates->take(5),
                'last_update' => $updates->first() ? $updates->first()->update_date : null,
                'employees_involved' => $updates->pluck('user.name')->unique()->filter()->values(),
                'update_frequency' => $this->calculateUpdateFrequency($updates),
                'status' => $this->getProjectStatus($project, $updates),
                'completion_percentage' => $this->calculateCompletionPercentage($project, $updates)
            ];
        }
        
        // Sort by last update date
        usort($projectData, function($a, $b) {
            if ($a['last_update'] === null) return 1;
            if ($b['last_update'] === null) return -1;
            return $b['last_update']->gt($a['last_update']) ? 1 : -1;
        });
        
        return collect($projectData);
    }
    
    private function calculateUpdateFrequency($updates)
    {
        if ($updates->isEmpty()) return 'none';
        
        $recentUpdates = $updates->where('update_date', '>=', now()->subDays(7));
        $count = $recentUpdates->count();
        
        if ($count >= 5) return 'high';
        elseif ($count >= 2) return 'medium';
        else return 'low';
    }
    
    private function getProjectStatus($project, $updates)
    {
        if ($updates->isEmpty()) return 'no_updates';
        
        $lastUpdate = $updates->first();
        $daysSinceLastUpdate = now()->diffInDays($lastUpdate->update_date);
        
        if ($daysSinceLastUpdate <= 2) return 'active';
        elseif ($daysSinceLastUpdate <= 7) return 'moderate';
        else return 'inactive';
    }
    
    private function calculateCompletionPercentage($project, $updates)
    {
        // This is a simplified calculation - you can enhance this based on your business logic
        if ($updates->isEmpty()) return 0;
        
        // Consider factors like number of updates, recency, etc.
        $updateScore = min($updates->count() * 10, 70); // Max 70% from updates
        
        // Add recency bonus
        $lastUpdate = $updates->first();
        if ($lastUpdate) {
            $daysSinceLastUpdate = now()->diffInDays($lastUpdate->update_date);
            $recencyBonus = max(0, 30 - ($daysSinceLastUpdate * 2)); // Max 30% from recency
            $updateScore += $recencyBonus;
        }
        
        return min($updateScore, 100);
    }
    
    public function show($id)
    {
        $user = Auth::user();
        
        // Get user's department name
        $userDepartmentName = null;
        if ($user->department_id) {
            $department = \App\Models\Department::find($user->department_id);
            $userDepartmentName = $department ? $department->department : null;
        } elseif ($user->department) {
            $userDepartmentName = $user->department;
        }
        
        // Check if it's an invoice first
        $invoice = Invoice::find($id);
        if ($invoice) {
            // Department-wise filtering for Employee (role 2) and Manager (role 4)
            if ($user->role == 2 || $user->role == 4) {
                // Only allow access to invoices from their department
                if ($invoice->department !== $userDepartmentName) {
                    abort(403, 'Unauthorized access to this invoice');
                }
            }
            // For customer role (role 3), only allow access to their own invoices
            elseif ($user->role == 3) {
                if ($invoice->customer_email !== $user->email) {
                    abort(403, 'Unauthorized access to this invoice');
                }
            }
            
            $updates = ProjectUpdate::where('invoice_id', $invoice->id)
                ->with('user')
                ->latest()
                ->get() ?? collect();
            return view('project_updates.invoice_update', compact('invoice', 'updates'));
        }
        
        // If not an invoice, try to find project by invoice number
        $project = Product::with(['projectUpdates.user', 'category', 'departmentfuc'])->findOrFail($id);
        
        // Department-wise filtering for Employee (role 2) and Manager (role 4)
        if ($user->role == 2 || $user->role == 4) {
            // Only allow access to projects from their department
            if ($project->departmentfuc && $project->departmentfuc->department !== $userDepartmentName) {
                abort(403, 'Unauthorized access to this project');
            }
        }
        // For customer role (role 3), only allow access to their assigned projects
        elseif ($user->role == 3) {
            if ($project->customerlist !== $user->id) {
                abort(403, 'Unauthorized access to this project');
            }
        }
        
        $updates = $project->projectUpdates()->with('user')->latest()->get() ?? collect();
        
        // Get related invoice if it exists
        $invoice = Invoice::where('product_id', $project->id)->first();
        
        return view('project_updates.show', compact('project', 'updates', 'invoice'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'update_text' => 'required|string',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,zip,rar',
        ]);
        
        $user = Auth::user();
        $formSource = $request->input('form_source', 'work'); // Default to 'work' if not specified
        
        // Parse the numbered text into separate points
        $updateText = $request->update_text;
        $lines = explode("\n", $updateText);
        
        $updatePoint1 = '';
        $updatePoint2 = '';
        $updatePoint3 = '';
        $allPoints = [];
        
        foreach ($lines as $index => $line) {
            $cleanLine = trim($line);
            // Remove numbering from the beginning of the line
            $cleanLine = preg_replace('/^[\d\.\-\s]+/', '', $cleanLine);
            
            if (!empty($cleanLine)) {
                $allPoints[] = $cleanLine;
                
                // Store first 3 points in existing columns for backward compatibility
                if (empty($updatePoint1)) {
                    $updatePoint1 = $cleanLine;
                } elseif (empty($updatePoint2)) {
                    $updatePoint2 = $cleanLine;
                } elseif (empty($updatePoint3)) {
                    $updatePoint3 = $cleanLine;
                }
            }
        }
        
        // Store all points as JSON in update_point_3 if we have more than 3 points
        if (count($allPoints) > 3) {
            $updatePoint3 = json_encode($allPoints);
        }
        
        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('attachments', $fileName, 'public');
            $attachmentPath = 'storage/' . $filePath;
        }
        
        // For customers, handle invoice update requests
        if ($user->role == 3) {
            $invoice = Invoice::where('customer_email', $user->email)->findOrFail($request->product_id);
            
            // Create update request for invoice
            $updateData = [
                'product_id' => null,
                'invoice_id' => $invoice->id,
                'user_id' => $user->id,
                'update_date' => Carbon::now(),
                'attachment' => $attachmentPath,
            ];
            
            // If it's a request update, store in request_text field
            if ($formSource === 'request') {
                $updateData['request_text'] = $updateText;
                // Add task due date and priority if provided
                $updateData['task_due_date'] = $request->input('task_due_date');
                $updateData['task_priority'] = $request->input('task_priority');
            } else {
                // Otherwise store as work update
                $updateData['update_point_1'] = $updatePoint1;
                $updateData['update_point_2'] = $updatePoint2;
                $updateData['update_point_3'] = $updatePoint3;
            }
            
            $update = ProjectUpdate::create($updateData);
            
            // Send appropriate notification
            if ($formSource === 'request') {
                $this->sendCustomerUpdateRequestNotification($invoice, $update, $user);
                return redirect()->back()->with('success', 'Update request submitted successfully! Admin will review your request.');
            } else {
                $this->sendWorkUpdateNotificationToCustomer($invoice, $update, $user);
                return redirect()->back()->with('success', 'Work update submitted successfully!');
            }
        }
        
        // For employees, handle invoice update requests
        if ($user->role == 2) {
            $userDepartment = $user->department;
           $invoice = Invoice::find($request->product_id);

            if (!$invoice) {
              return redirect()->back()->with('error', 'Invoice not found');
            }
            
            // Create update request for invoice
            $updateData = [
                'product_id' => null,
                'invoice_id' => $invoice->id,
                'user_id' => $user->id,
                'update_date' => Carbon::now(),
                'attachment' => $attachmentPath,
            ];
            
            // If it's a request update, store in request_text field
            if ($formSource === 'request') {
                $updateData['request_text'] = $updateText;
                // Add task due date and priority if provided
                $updateData['task_due_date'] = $request->input('task_due_date');
                $updateData['task_priority'] = $request->input('task_priority');
            } else {
                // Otherwise store as work update
                $updateData['update_point_1'] = $updatePoint1;
                $updateData['update_point_2'] = $updatePoint2;
                $updateData['update_point_3'] = $updatePoint3;
            }
            
            $update = ProjectUpdate::create($updateData);
            
            // Send appropriate notification
            if ($formSource === 'request') {
                $this->sendCustomerUpdateRequestNotification($invoice, $update, $user);
                return redirect()->back()->with('success', 'Update request submitted successfully! Admin will review your request.');
            } else {
                $this->sendWorkUpdateNotificationToCustomer($invoice, $update, $user);
                return redirect()->back()->with('success', 'Work update submitted successfully!');
            }
        }
        
        // For admin (role 1) and CEO (role 5), handle both invoice and project updates
        if ($user->role == 1 || $user->role == 5) {
            // First try to find an invoice with this ID
            $invoice = Invoice::find($request->product_id);
            if ($invoice) {
                // It's an invoice, handle with form_source logic
                $updateData = [
                    'product_id' => null,
                    'invoice_id' => $invoice->id,
                    'user_id' => $user->id,
                    'update_date' => Carbon::now(),
                    'attachment' => $attachmentPath,
                ];
                
                // If it's a request update, store in request_text field
                if ($formSource === 'request') {
                    $updateData['request_text'] = $updateText;
                    // Add task due date and priority if provided
                    $updateData['task_due_date'] = $request->input('task_due_date');
                    $updateData['task_priority'] = $request->input('task_priority');
                } else {
                    // Otherwise store as work update
                    $updateData['update_point_1'] = $updatePoint1;
                    $updateData['update_point_2'] = $updatePoint2;
                    $updateData['update_point_3'] = $updatePoint3;
                }
                
                $update = ProjectUpdate::create($updateData);
                
                // Send appropriate notification
                if ($formSource === 'request') {
                    $this->sendCustomerUpdateRequestNotification($invoice, $update, $user);
                    return redirect()->back()->with('success', 'Update request submitted successfully!');
                } else {
                    $this->sendWorkUpdateNotificationToCustomer($invoice, $update, $user);
                    return redirect()->back()->with('success', 'Invoice update added successfully!');
                }
            }
            
            // If not an invoice, handle as project update
            $project = Product::with('category')->findOrFail($request->product_id);
            
            $updateData = [
                'product_id' => $request->product_id,
                'user_id' => $user->id,
                'update_date' => Carbon::now(),
                'attachment' => $attachmentPath,
            ];
            
            // If it's a request update, store in request_text field
            if ($formSource === 'request') {
                $updateData['request_text'] = $updateText;
                // Add task due date and priority if provided
                $updateData['task_due_date'] = $request->input('task_due_date');
                $updateData['task_priority'] = $request->input('task_priority');
            } else {
                // Otherwise store as work update
                $updateData['update_point_1'] = $updatePoint1;
                $updateData['update_point_2'] = $updatePoint2;
                $updateData['update_point_3'] = $updatePoint3;
            }
            
            $update = ProjectUpdate::create($updateData);
            
            // Send appropriate notification
            if ($formSource === 'request') {
                $this->sendCustomerProjectUpdateNotification($project, $update, $user);
                return redirect()->back()->with('success', 'Project update request submitted successfully!');
            } else {
                // Send email notification
                $this->sendUpdateNotification($project, $update, $user);
                return redirect()->back()->with('success', 'Project update added successfully!');
            }
        }
        
        // For employees, handle project updates
        $project = Product::with('category')->findOrFail($request->product_id);
        
        // Allow all authenticated users to access any project update
        
        $updateData = [
            'product_id' => $request->product_id,
            'user_id' => $user->id,
            'update_date' => Carbon::now(),
            'attachment' => $attachmentPath,
        ];
        
        // If it's a request update, store in request_text field
        if ($formSource === 'request') {
            $updateData['request_text'] = $updateText;
        } else {
            // Otherwise store as work update
            $updateData['update_point_1'] = $updatePoint1;
            $updateData['update_point_2'] = $updatePoint2;
            $updateData['update_point_3'] = $updatePoint3;
        }
        
        $update = ProjectUpdate::create($updateData);
        
        // Send appropriate notification
        if ($formSource === 'request') {
            $this->sendCustomerProjectUpdateNotification($project, $update, $user);
            return redirect()->back()->with('success', 'Project update request submitted successfully!');
        } else {
            // Send email notification
            $this->sendUpdateNotification($project, $update, $user);
            return redirect()->back()->with('success', 'Project update added successfully!');
        }
    }
    
    private function sendUpdateNotification($project, $update, $user)
    {
        try {
            // Get customer email if customer exists
            $customerEmail = null;
            if ($project->customerlist) {
                $customer = User::find($project->customerlist);
                $customerEmail = $customer ? $customer->email : null;
            }
            
            // Send to customer
            if ($customerEmail) {
                Mail::raw("Project Update Notification\n\nProject: {$project->product_name_en}\nUpdated by: {$user->name}\nDate: {$update->update_date->format('M d, Y H:i')}\n\nUpdates:\n1. {$update->update_point_1}" . 
                    ($update->update_point_2 ? "\n2. {$update->update_point_2}" : "") . 
                    ($update->update_point_3 ? "\n3. {$update->update_point_3}" : "") . 
                    "\n\nThank you,\nNiranjan Enterprises", 
                    function($message) use ($customerEmail, $project) {
                        $message->to($customerEmail)
                                ->subject("📋 Project Update - {$project->product_name_en}")
                                ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), 'Niranjan Enterprises');
                    });
            }
            
            // Send to admin
            $admin = User::where('role', 1)->first();
            if ($admin) {
                Mail::raw("Project Update Notification\n\nProject: {$project->product_name_en}\nUpdated by: {$user->name}\nDate: {$update->update_date->format('M d, Y H:i')}\n\nUpdates:\n1. {$update->update_point_1}" . 
                        ($update->update_point_2 ? "\n2. {$update->update_point_2}" : "") . 
                        ($update->update_point_3 ? "\n3. {$update->update_point_3}" : "") . 
                        "\n\nThank you,\nNiranjan Enterprises", 
                        function($message) use ($admin, $project) {
                            $message->to($admin->email)
                                    ->subject("📋 Project Update - {$project->product_name_en}")
                                    ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), 'Niranjan Enterprises');
                        });
            }
            
        } catch (\Exception $e) {
            \Log::error('Failed to send project update notification: ' . $e->getMessage());
        }
    }
    
    private function sendCustomerProjectUpdateNotification($project, $update, $user)
    {
        try {
            // Send to admin
            $admin = User::where('role', 1)->first();
            if ($admin) {
                Mail::raw("Customer Project Update\n\nProject: {$project->product_name_en}\nCustomer: {$user->name} ({$user->email})\nDate: {$update->update_date->format('M d, Y H:i')}\n\nUpdates:\n1. {$update->update_point_1}" . 
                        ($update->update_point_2 ? "\n2. {$update->update_point_2}" : "") . 
                        ($update->update_point_3 ? "\n3. {$update->update_point_3}" : "") . 
                        "\n\nPlease review and take appropriate action.\n\nThank you,\nNiranjan Enterprises", 
                        function($message) use ($admin, $project) {
                            $message->to($admin->email)
                                    ->subject("📋 Customer Project Update - {$project->product_name_en}")
                                    ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), 'Niranjan Enterprises');
                        });
            }
            
        } catch (\Exception $e) {
            \Log::error('Failed to send customer project update notification: ' . $e->getMessage());
        }
    }
    
    private function sendWorkUpdateNotificationToCustomer($invoice, $update, $user)
    {
        try {
            // Send email to invoice customer
            if ($invoice->customer_email) {
                $email = Mail::send('mail.work-update', [
                    'invoice' => $invoice,
                    'update' => $update,
                    'user' => $user
                ], function($message) use ($invoice, $user, $update) {
                    $message->to($invoice->customer_email)
                            ->subject("📋 Work Update - {$invoice->project_name}")
                            ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), 'Niranjan Enterprises');
                    
                    // Attach file if exists
                    if (!empty($update->attachment)) {
                        $attachmentPath = storage_path('app/public/' . $update->attachment);
                        if (file_exists($attachmentPath)) {
                            $message->attach($attachmentPath, [
                                'as' => basename($update->attachment),
                                'mime' => mime_content_type($attachmentPath)
                            ]);
                        }
                    }
                });
            }
            
            // Also send to admin for notification
            $admin = User::where('role', 1)->first();
            if ($admin) {
                $roleName = $user->role == 1 ? 'Admin' : 'Employee';
                
                Mail::send('mail.work-update', [
                    'invoice' => $invoice,
                    'update' => $update,
                    'user' => $user
                ], function($message) use ($admin, $invoice, $roleName, $update) {
                    $message->to($admin->email)
                            ->subject("📋 {$roleName} Work Update - {$invoice->project_name}")
                            ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), 'Niranjan Enterprises');
                    
                    // Attach file if exists
                    if (!empty($update->attachment)) {
                        $attachmentPath = storage_path('app/public/' . $update->attachment);
                        if (file_exists($attachmentPath)) {
                            $message->attach($attachmentPath, [
                                'as' => basename($update->attachment),
                                'mime' => mime_content_type($attachmentPath)
                            ]);
                        }
                    }
                });
            }
            
        } catch (\Exception $e) {
            \Log::error('Failed to send work update notification to customer: ' . $e->getMessage());
        }
    }
    
    private function sendCustomerUpdateRequestNotification($invoice, $update, $user)
    {
        try {
            // Send to admin with attachment
            $admin = User::where('role', 1)->first();
            if ($admin) {
                $roleName = $user->role == 3 ? 'Customer' : 'Employee';
                
                $attachmentInfo = "";
                if (!empty($update->attachment)) {
                    $attachmentInfo = "\n\n📎 Attachment: " . basename($update->attachment) . "\nFile is available for download in project portal.";
                }
                
                Mail::raw("{$roleName} Update Request\n\nInvoice: {$invoice->invoice_number}\nProject: {$invoice->project_name}\n{$roleName}: {$user->name} ({$user->email})\nDate: {$update->update_date->format('M d, Y H:i')}\n\nUpdate Requests:\n1. {$update->update_point_1}" . 
                        ($update->update_point_2 ? "\n2. {$update->update_point_2}" : "") . 
                        ($update->update_point_3 ? "\n3. {$update->update_point_3}" : "") . 
                        $attachmentInfo . 
                        "\n\nPlease review and take appropriate action.\n\nThank you,\nNiranjan Enterprises", 
                        function($message) use ($admin, $invoice, $roleName) {
                            $message->to($admin->email)
                                    ->subject("📋 {$roleName} Update Request - {$invoice->project_name}")
                                    ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), 'Niranjan Enterprises');
                        });
            }
            
            // Send attractive HTML email to all employees in the same department
            // Debug logging
            \Log::info('Customer Update Request - Debug Info:');
            \Log::info('Project Department: ' . $invoice->department);
            \Log::info('Customer ID: ' . $user->id);
            \Log::info('Customer Role: ' . $user->role);
            
            // Normalize department names for comparison (case insensitive)
            $projectDepartment = strtolower(trim($invoice->department));
            \Log::info('Normalized Project Department: ' . $projectDepartment);
            
            $departmentEmployees = User::whereIn('role', [2, 4, 6, 7, 8]) // Employees, Manager, Marketing, Sales, Account
                                     ->whereRaw('LOWER(TRIM(department)) = ?', [$projectDepartment])
                                     ->where('id', '!=', $user->id) // Exclude the requesting user if they're an employee
                                     ->get();
            
            \Log::info('Found ' . $departmentEmployees->count() . ' employees and managers in department: ' . $projectDepartment);
            
            // If no employees found with case-insensitive match, try exact match
            if ($departmentEmployees->count() === 0) {
                \Log::info('No employees found with case-insensitive match, trying exact match...');
                $departmentEmployees = User::whereIn('role', [2, 4, 6, 7, 8])
                                         ->where('department', $invoice->department)
                                         ->where('id', '!=', $user->id)
                                         ->get();
                \Log::info('Found ' . $departmentEmployees->count() . ' employees and managers with exact match for: ' . $invoice->department);
            }
            
            // If still no employees found, try partial match
            if ($departmentEmployees->count() === 0) {
                \Log::info('No employees found with exact match, trying partial match...');
                $departmentEmployees = User::whereIn('role', [2, 4, 6, 7, 8])
                                         ->where('department', 'LIKE', '%' . $invoice->department . '%')
                                         ->where('id', '!=', $user->id)
                                         ->get();
                \Log::info('Found ' . $departmentEmployees->count() . ' employees and managers with partial match for: ' . $invoice->department);
            }
            
            foreach ($departmentEmployees as $employee) {
                \Log::info('Sending email to employee/manager: ' . $employee->name . ' (' . $employee->email . ') - Department: ' . $employee->department);
                
                Mail::send('mail.customer-request-update', [
                    'invoice' => $invoice,
                    'update' => $update,
                    'user' => $user,
                    'employee' => $employee
                ], function($message) use ($employee, $invoice, $user) {
                    $message->to($employee->email)
                            ->subject("🚨 Customer Update Request - {$invoice->project_name}")
                            ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), 'Niranjan Enterprises');
                });
            }
            
        } catch (\Exception $e) {
            \Log::error('Failed to send update request notification: ' . $e->getMessage());
        }
    }
    
    /**
     * Send task status update email with attractive formatting
     */
    private function sendTaskStatusUpdateEmail($originalUpdate, $workUpdate, $user)
    {
        try {
            $invoice = $originalUpdate->invoice;
            if (!$invoice) {
                \Log::error('No invoice found for task status update email');
                return;
            }
            
            // Send email to invoice customer
            if ($invoice->customer_email) {
                \Log::info('Attempting to send task status update email to: ' . $invoice->customer_email);
                \Log::info('Invoice data: ' . json_encode([
                    'invoice_number' => $invoice->invoice_number,
                    'project_name' => $invoice->project_name,
                    'customer_email' => $invoice->customer_email,
                    'department' => $invoice->department
                ]));
                
                // Add attachment info for customer email
                $attachmentInfo = "";
                if (!empty($workUpdate->attachment)) {
                    $attachmentInfo = "\n\n📎 Attachment: " . basename($workUpdate->attachment) . "\nFile is available for download in project portal.";
                }
                
                Mail::send('mail.task-status-update', [
                    'invoice' => $invoice,
                    'originalUpdate' => $originalUpdate,
                    'workUpdate' => $workUpdate,
                    'user' => $user,
                    'attachmentInfo' => $attachmentInfo
                ], function($message) use ($invoice, $user, $workUpdate) {
                    $message->to($invoice->customer_email)
                            ->subject("📋 Task Status Updates - {$invoice->project_name}")
                            ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), 'Niranjan Enterprises');
                    
                    // Attach file if exists
                    if (!empty($workUpdate->attachment)) {
                        $attachmentPath = storage_path('app/public/' . $workUpdate->attachment);
                        if (file_exists($attachmentPath)) {
                            $message->attach($attachmentPath, [
                                'as' => basename($workUpdate->attachment),
                                'mime' => mime_content_type($attachmentPath)
                            ]);
                        }
                    }
                });
                
                \Log::info('Task status update email sent successfully to customer: ' . $invoice->customer_email);
            } else {
                \Log::error('No customer email found for invoice: ' . $invoice->invoice_number);
            }
            
            // Also send to admin for notification
            $admin = User::where('role', 1)->first();
            if ($admin) {
                $roleName = $user->role == 1 ? 'Admin' : 'Employee';
                
                $attachmentInfo = "";
                if (!empty($workUpdate->attachment)) {
                    $attachmentInfo = "\n\n📎 Attachment: " . basename($workUpdate->attachment) . "\nFile is available for download in project portal.";
                }
                
                Mail::send('mail.task-status-update', [
                    'invoice' => $invoice,
                    'originalUpdate' => $originalUpdate,
                    'workUpdate' => $workUpdate,
                    'user' => $user,
                    'attachmentInfo' => $attachmentInfo
                ], function($message) use ($admin, $invoice, $roleName, $workUpdate) {
                    $message->to($admin->email)
                            ->subject("📋 {$roleName} Task Status Update - {$invoice->project_name}")
                            ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), 'Niranjan Enterprises');
                    
                    // Attach file if exists
                    if (!empty($workUpdate->attachment)) {
                        $attachmentPath = storage_path('app/public/' . $workUpdate->attachment);
                        if (file_exists($attachmentPath)) {
                            $message->attach($attachmentPath, [
                                'as' => basename($workUpdate->attachment),
                                'mime' => mime_content_type($attachmentPath)
                            ]);
                        }
                    }
                });
            }
            
        } catch (\Exception $e) {
            \Log::error('Failed to send task status update email: ' . $e->getMessage());
        }
    }
    
    public function employeeReportIndex()
    {
        $user = Auth::user();
        
        // Allow all roles to access reports
        // if (!in_array($user->role, [1, 4, 5])) {
        //     abort(403, 'Unauthorized access');
        // }
        
        // Get all employees for filtering
        $employees = User::whereIn('role', [2, 4, 6, 7, 8]) // Employees, Manager, Marketing, Sales, Account
                        ->whereNotNull('department')
                        ->orderBy('name')
                        ->get();
        
        // Get all departments for filtering
        $departments = User::whereIn('role', [2, 4, 6, 7, 8])
                        ->whereNotNull('department')
                        ->distinct()
                        ->pluck('department')
                        ->sort();
        
        // Default to last 30 days
        $startDate = Carbon::now()->subDays(30)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        
        // Get comprehensive employee performance data
        $employeePerformanceData = $this->getEmployeePerformanceData($startDate, $endDate);
        
        // Calculate performance percentages
        $performancePercentages = $this->calculatePerformancePercentages($employeePerformanceData);
        
        return view('project_updates.employee_performance_report', compact(
            'employees',
            'departments', 
            'employeePerformanceData',
            'performancePercentages',
            'startDate', 
            'endDate'
        ));
    }
    
    /**
     * Calculate performance percentages for employees
     */
    private function calculatePerformancePercentages($performanceData)
    {
        $percentages = [];
        
        foreach ($performanceData as $employeeId => $data) {
            $totalTasks = $data['total_assigned_tasks'] + $data['total_work_updates'];
            $completedTasks = $data['completed_tasks'];
            
            // Calculate completion percentage
            $completionPercentage = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
            
            // Calculate efficiency based on task completion vs time
            $efficiencyScore = $this->calculateEfficiencyScore($data);
            
            // Calculate response time score
            $responseScore = $this->calculateResponseScore($data);
            
            // Overall performance score
            $overallScore = ($completionPercentage * 0.5) + ($efficiencyScore * 0.3) + ($responseScore * 0.2);
            
            $percentages[$employeeId] = [
                'completion_percentage' => round($completionPercentage, 2),
                'efficiency_score' => round($efficiencyScore, 2),
                'response_score' => round($responseScore, 2),
                'overall_score' => round($overallScore, 2),
                'grade' => $this->getPerformanceGrade($overallScore)
            ];
        }
        
        return $percentages;
    }
    
    /**
     * Calculate efficiency score based on task completion
     */
    private function calculateEfficiencyScore($data)
    {
        $totalTasks = $data['total_assigned_tasks'] + $data['total_work_updates'];
        $completedTasks = $data['completed_tasks'];
        
        if ($totalTasks == 0) return 0;
        
        // Base efficiency on completion rate
        $baseEfficiency = ($completedTasks / $totalTasks) * 100;
        
        // Bonus for high work update count (shows productivity)
        $productivityBonus = min($data['total_work_updates'] * 2, 20);
        
        return min($baseEfficiency + $productivityBonus, 100);
    }
    
    /**
     * Calculate response score based on average response time
     */
    private function calculateResponseScore($data)
    {
        $avgResponseTime = $data['avg_response_time_hours'] ?? 0;
        
        if ($avgResponseTime == 0) return 100; // Perfect score for immediate response
        
        // Score decreases as response time increases
        if ($avgResponseTime <= 1) return 100;
        if ($avgResponseTime <= 6) return 80;
        if ($avgResponseTime <= 24) return 60;
        if ($avgResponseTime <= 48) return 40;
        
        return 20; // Poor score for very slow response
    }
    
    /**
     * Get performance grade based on score
     */
    private function getPerformanceGrade($score)
    {
        if ($score >= 90) return 'A+';
        if ($score >= 80) return 'A';
        if ($score >= 70) return 'B';
        if ($score >= 60) return 'C';
        if ($score >= 50) return 'D';
        
        return 'F';
    }
    
    /**
     * Check if a specific task is completed based on work updates
     */
    private function isTaskCompleted($userId, $taskText, $startDate, $endDate)
    {
        // Look for work updates that mention the task and have completed status
        $workUpdates = ProjectUpdate::where('user_id', $userId)
            ->whereBetween('update_date', [$startDate, $endDate])
            ->whereNull('request_text')
            ->where(function($query) use ($taskText) {
                // Look for task keywords in work updates
                $taskKeywords = $this->extractTaskKeywords($taskText);
                foreach ($taskKeywords as $keyword) {
                    $query->orWhere('update_point_1', 'like', '%' . $keyword . '%')
                          ->orWhere('update_point_2', 'like', '%' . $keyword . '%')
                          ->orWhere('update_point_3', 'like', '%' . $keyword . '%');
                }
            })
            ->get();
        
        foreach ($workUpdates as $update) {
            $updateText = $update->update_point_1 . ' ' . $update->update_point_2 . ' ' . $update->update_point_3;
            
            // Check for completion indicators
            if (stripos($updateText, 'completed') !== false || 
                stripos($updateText, 'done') !== false || 
                stripos($updateText, 'finished') !== false ||
                stripos($updateText, 'ready') !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Extract keywords from task text for matching
     */
    private function extractTaskKeywords($taskText)
    {
        // Remove task number and extract key terms
        $cleanText = preg_replace('/^\d+\.\s*/', '', $taskText);
        
        // Split into words and filter out common words
        $words = explode(' ', strtolower($cleanText));
        $keywords = [];
        
        $stopWords = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by', 'is', 'are', 'was', 'were', 'be', 'been', 'being', 'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'should', 'could', 'may', 'might', 'must', 'can', 'shall', 'add', 'create', 'update', 'modify', 'change', 'fix', 'implement', 'develop', 'design', 'build', 'make', 'set', 'get', 'show', 'hide', 'enable', 'disable'];
        
        foreach ($words as $word) {
            $word = trim($word);
            if (strlen($word) > 2 && !in_array($word, $stopWords)) {
                $keywords[] = $word;
            }
        }
        
        return array_slice($keywords, 0, 3); // Return top 3 keywords
    }
    
    /**
     * Calculate average response time for an employee
     */
    private function calculateAverageResponseTime($userId, $startDate, $endDate)
    {
        // Get request updates for the employee
        $requestUpdates = ProjectUpdate::where('user_id', $userId)
            ->whereBetween('update_date', [$startDate, $endDate])
            ->whereNotNull('request_text')
            ->orderBy('update_date', 'asc')
            ->get();
        
        $totalResponseTime = 0;
        $responseCount = 0;
        
        foreach ($requestUpdates as $request) {
            // Find the first work update that responds to this request
            $workUpdate = ProjectUpdate::where('user_id', $userId)
                ->where('update_date', '>', $request->update_date)
                ->whereNull('request_text')
                ->orderBy('update_date', 'asc')
                ->first();
            
            if ($workUpdate) {
                $responseTime = $request->update_date->diffInHours($workUpdate->update_date);
                $totalResponseTime += $responseTime;
                $responseCount++;
            }
        }
        
        return $responseCount > 0 ? round($totalResponseTime / $responseCount, 2) : 0;
    }
    
 private function getEmployeePerformanceData($startDate, $endDate, $employeeId = null, $department = null)
    {
        // Build query for project updates
        $query = ProjectUpdate::with(['user', 'product', 'invoice'])
            ->whereBetween('update_date', [$startDate, $endDate]);
        
        // Filter by employee if specified
        if ($employeeId) {
            $query->where('user_id', $employeeId);
        }
        
        // Filter by department if specified
        if ($department) {
            $query->whereHas('user', function($q) use ($department) {
                $q->where('department', $department);
            });
        }
        
        $updates = $query->orderBy('update_date', 'desc')->get();
        
        // Group and analyze data by employee
        $employeeData = [];
        foreach ($updates as $update) {
            $employeeId = $update->user_id;
            if (!isset($employeeData[$employeeId])) {
                $employeeData[$employeeId] = [
                    'employee' => $update->user,
                    'updates' => [],
                    'total_updates' => 0,
                    'total_assigned_tasks' => 0,
                    'completed_tasks' => 0,
                    'total_work_updates' => 0,
                    'project_updates' => 0,
                    'invoice_updates' => 0,
                    'projects' => [],
                    'invoices' => [],
                    'daily_activity' => [],
                    'avg_response_time_hours' => 0,
                    'performance_metrics' => [
                        'avg_updates_per_day' => 0,
                        'most_active_day' => null,
                        'project_diversity' => 0,
                        'update_frequency' => 'low'
                    ]
                ];
            }
            
            $employeeData[$employeeId]['updates'][] = $update;
            $employeeData[$employeeId]['total_updates']++;
            
            // Count work updates (non-request updates)
            if (!$update->request_text) {
                $employeeData[$employeeId]['total_work_updates']++;
            }
            
            // Count assigned tasks (request updates)
            if ($update->request_text) {
                $employeeData[$employeeId]['total_assigned_tasks']++;
                
                // Parse request text to count tasks
                $requestLines = explode("\n", $update->request_text);
                foreach ($requestLines as $line) {
                    $cleanLine = trim($line);
                    if (!empty($cleanLine) && preg_match('/^\d+\./', $cleanLine)) {
                        $employeeData[$employeeId]['total_assigned_tasks']++;
                        
                        // Check if task is completed (look for completed status in work updates)
                        $isCompleted = $this->isTaskCompleted($update->user_id, $cleanLine, $startDate, $endDate);
                        if ($isCompleted) {
                            $employeeData[$employeeId]['completed_tasks']++;
                        }
                    }
                }
            }
            
            // Track projects
            if ($update->product_id && $update->product) {
                $employeeData[$employeeId]['project_updates']++;
                $projectName = $update->product->product_name_en;
                if (!isset($employeeData[$employeeId]['projects'][$projectName])) {
                    $employeeData[$employeeId]['projects'][$projectName] = 0;
                }
                $employeeData[$employeeId]['projects'][$projectName]++;
            }
            
            // Track invoices
            if ($update->invoice_id && $update->invoice) {
                $employeeData[$employeeId]['invoice_updates']++;
                $invoiceKey = $update->invoice->invoice_number . ' - ' . $update->invoice->project_name;
                if (!isset($employeeData[$employeeId]['invoices'][$invoiceKey])) {
                    $employeeData[$employeeId]['invoices'][$invoiceKey] = 0;
                }
                $employeeData[$employeeId]['invoices'][$invoiceKey]++;
            }
            
            // Track daily activity
            $dateKey = $update->update_date->format('Y-m-d');
            if (!isset($employeeData[$employeeId]['daily_activity'][$dateKey])) {
                $employeeData[$employeeId]['daily_activity'][$dateKey] = 0;
            }
            $employeeData[$employeeId]['daily_activity'][$dateKey]++;
        }
        
        // Calculate performance metrics for each employee
        foreach ($employeeData as $employeeId => &$data) {
            $totalDays = $startDate->diffInDays($endDate) + 1;
            $data['performance_metrics']['avg_updates_per_day'] = round($data['total_updates'] / $totalDays, 2);
            
            // Calculate average response time
            $data['avg_response_time_hours'] = $this->calculateAverageResponseTime($employeeId, $startDate, $endDate);
            
            // Find most active day
            if (!empty($data['daily_activity'])) {
                $maxActivity = max($data['daily_activity']);
                $mostActiveDay = array_search($maxActivity, $data['daily_activity']);
                $data['performance_metrics']['most_active_day'] = Carbon::parse($mostActiveDay)->format('M d, Y');
            }
            
            // Calculate project diversity
            $data['performance_metrics']['project_diversity'] = count($data['projects']);
            
            // Determine update frequency
            if ($data['performance_metrics']['avg_updates_per_day'] >= 3) {
                $data['performance_metrics']['update_frequency'] = 'high';
            } elseif ($data['performance_metrics']['avg_updates_per_day'] >= 1) {
                $data['performance_metrics']['update_frequency'] = 'medium';
            } else {
                $data['performance_metrics']['update_frequency'] = 'low';
            }
        }
        
        return $employeeData;
    }


   
    
    public function generateEmployeeReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'employee_id' => 'nullable|exists:users,id',
            'department' => 'nullable|string',
        ]);
        
        $user = Auth::user();
        
        // Only allow admin, CEO, and managers to generate reports
        if (!in_array($user->role, [1, 4, 5])) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized access'], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized access');
        }
        
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        
        // Get comprehensive employee performance data
        $employeePerformanceData = $this->getEmployeePerformanceData(
            $startDate, 
            $endDate, 
            $request->employee_id, 
            $request->department
        );
        
        // Calculate performance percentages
        $performancePercentages = $this->calculatePerformancePercentages($employeePerformanceData);
        
        // Get employees and departments for filters
        $employees = User::whereIn('role', [2, 4, 6, 7, 8])
                        ->whereNotNull('department')
                        ->orderBy('name')
                        ->get();
        
        $departments = User::whereIn('role', [2, 4, 6, 7, 8])
                        ->whereNotNull('department')
                        ->distinct()
                        ->pluck('department')
                        ->sort();
        
        return view('project_updates.employee_performance_report', compact(
            'employees',
            'departments', 
            'employeePerformanceData',
            'performancePercentages',
            'startDate', 
            'endDate'
        ));
    }
    
    public function sendEmployeeReportEmail(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'employee_id' => 'nullable|exists:users,id',
            'department' => 'nullable|string',
            'email_recipients' => 'required|string',
        ]);
        
        $user = Auth::user();
        
        // Only allow admin, CEO, and managers to send reports
        if (!in_array($user->role, [1, 4, 5])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access'], 403);
        }
        
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        
        // Get comprehensive employee performance data
        $employeePerformanceData = $this->getEmployeePerformanceData(
            $startDate, 
            $endDate, 
            $request->employee_id, 
            $request->department
        );
        
        // Parse email recipients
        $recipients = array_map('trim', explode(',', $request->email_recipients));
        
        try {
            foreach ($recipients as $recipient) {
                if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                    Mail::send('mail.employee-performance-report', [
                        'employeePerformanceData' => $employeePerformanceData,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'requestedBy' => $user
                    ], function($message) use ($recipient, $startDate, $endDate) {
                        $message->to($recipient)
                                ->subject("📊 Employee Performance Report - {$startDate->format('M d, Y')} to {$endDate->format('M d, Y')}")
                                ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), 'Niranjan Enterprises');
                    });
                }
            }
            
            return response()->json(['success' => true, 'message' => 'Report sent successfully!']);
            
        } catch (\Exception $e) {
            \Log::error('Failed to send employee report email: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send report: ' . $e->getMessage()], 500);
        }
    }
    
    public function updateTaskStatus(Request $request)
    {
        $request->validate([
            'task_update_id' => 'required|exists:project_updates,id',
            'task_count' => 'required|integer|min:1',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,zip,rar',
        ]);
        
        $user = Auth::user();
        
        // Only allow employees, managers, and admins to update task status
        if (!in_array($user->role, [1, 2, 4])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access'], 403);
        }
        
        try {
            $update = ProjectUpdate::find($request->task_update_id);
            
            if (!$update) {
                return response()->json(['success' => false, 'message' => 'Update not found'], 404);
            }
            
            // Check if user has permission to update this task
            if ($user->role == 2 && $update->invoice) {
                $userDepartment = $user->department;
                $invoiceDepartment = $update->invoice->department;
                
                if (strtolower(trim($userDepartment)) !== strtolower(trim($invoiceDepartment))) {
                    return response()->json(['success' => false, 'message' => 'You can only update tasks from your department'], 403);
                }
            }
            
            // Parse the request text to get individual tasks
            $requestText = $update->request_text;
            $lines = explode("\n", $requestText);
            $tasks = [];
            
            foreach ($lines as $index => $line) {
                $cleanLine = trim($line);
                if (!empty($cleanLine)) {
                    $tasks[] = $cleanLine;
                }
            }
            
            // Create a new work update with task statuses
            $workUpdateText = "";
            $taskCount = $request->task_count;
            
            for ($i = 1; $i <= $taskCount; $i++) {
                $statusFieldName = 'task_status_' . $i;
                $status = $request->input($statusFieldName, 'pending');
                
                if (isset($tasks[$i - 1])) {
                    $taskText = $tasks[$i - 1];
                    $statusIcon = '';
                    
                    switch ($status) {
                        case 'completed':
                            $statusIcon = '✅ ';
                            break;
                        case 'working':
                            $statusIcon = '🔄 ';
                            break;
                        case 'pending':
                            $statusIcon = '⏳ ';
                            break;
                    }
                    
                    $workUpdateText .= $statusIcon . $taskText . " - " . ucfirst($status) . "\n";
                }
            }
            
            // Handle file upload
            $attachmentPath = $update->attachment; // Default to original attachment
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('attachments', $fileName, 'public');
                $attachmentPath = 'storage/' . $filePath;
            }
            
            // Create the work update
            $workUpdate = ProjectUpdate::create([
                'product_id' => $update->product_id,
                'invoice_id' => $update->invoice_id,
                'user_id' => $user->id,
                'update_point_1' => $workUpdateText,
                'attachment' => $attachmentPath,
                'update_date' => Carbon::now(),
            ]);
            
            // Update the original request update status
            $update->task_status = 'completed'; // Mark as completed since work update was created
            $update->save();
            
            // Send email notification with task status updates
            $this->sendTaskStatusUpdateEmail($update, $workUpdate, $user);
            
            return response()->json([
                'success' => true, 
                'message' => "Successfully created work update with task statuses and sent email notification"
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Failed to update task status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update task status'], 500);
        }
    }
    
    
 public function destroy($id)
    {
        $user = Auth::user();
        
        \Log::info('Delete request for update ID: ' . $id . ' by user: ' . $user->id . ' with role: ' . $user->role);
        
        // Only allow admins, managers, and the original creator to delete updates
        if (!in_array($user->role, [1, 4])) {
            $update = ProjectUpdate::find($id);
            if (!$update || $update->user_id != $user->id) {
                \Log::warning('Unauthorized delete attempt for update ID: ' . $id);
                return redirect()->back()->with('error', 'Unauthorized access');
            }
        }
        
        try {
            $update = ProjectUpdate::findOrFail($id);
            
            // Check if user has permission to delete this update
            // if ($user->role == 2 && $update->invoice) {
            //     $userDepartment = $user->department;
            //     $invoiceDepartment = $update->invoice->department;
                
            //     if (strtolower(trim($userDepartment)) !== strtolower(trim($invoiceDepartment))) {
            //         \Log::warning('Department mismatch for user: ' . $userDepartment . ' vs invoice: ' . $invoiceDepartment);
            //         return redirect()->back()->with('error', 'You can only delete updates from your department');
            //     }
            // }
            

            if ($user->role == 2) {

                  // Employee can only delete own updates
                if ($update->user_id != $user->id) {

                 return redirect()->back()->with('error', 'Unauthorized access');

         }

}

            \Log::info('Deleting update ID: ' . $id);
            $update->delete();
            
            return redirect()->back()->with('success', 'Update deleted successfully');
            
        } catch (\Exception $e) {
            \Log::error('Failed to delete update: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete update: ' . $e->getMessage());
        }
    }
    
    public function exportEmployeeReport(Request $request)
    {
        $user = Auth::user();
        
        // Only allow admin, CEO, and managers to export reports
        if (!in_array($user->role, [1, 4, 5])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access'], 403);
        }
        
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        
        // Get comprehensive employee performance data
        $employeePerformanceData = $this->getEmployeePerformanceData(
            $startDate, 
            $endDate, 
            $request->employee_id, 
            $request->department
        );
        
        // Calculate performance percentages
        $performancePercentages = $this->calculatePerformancePercentages($employeePerformanceData);
        
        // Generate CSV data
        $csvData = [];
        $csvData[] = [
            'Employee Name',
            'Department',
            'Completion %',
            'Efficiency %',
            'Response %',
            'Overall %',
            'Grade',
            'Total Tasks',
            'Completed',
            'Work Updates'
        ];
        
        foreach ($employeePerformanceData as $employeeId => $data) {
            $performance = $performancePercentages[$employeeId] ?? [];
            $csvData[] = [
                $data['employee']->name,
                $data['employee']->department,
                $performance['completion_percentage'] ?? 0,
                $performance['efficiency_score'] ?? 0,
                $performance['response_score'] ?? 0,
                $performance['overall_score'] ?? 0,
                $performance['grade'] ?? 'F',
                $data['total_assigned_tasks'] + $data['total_work_updates'],
                $data['completed_tasks'],
                $data['total_work_updates']
            ];
        }
        
        // Generate filename
        $filename = 'employee_performance_report_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv';
        
        // Create CSV response
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Show project completion status creation form
     */
    public function createCompletionStatus($id)
    {
        $user = Auth::user();
        
        // Restrict access for customer role (3) and customer position
        if ($user->role == 3 || strtolower($user->position ?? '') == 'customer') {
            abort(403, 'Unauthorized access. Customers cannot access this page.');
        }
        
        // Check if it's an invoice first
        $invoice = Invoice::find($id);
        if ($invoice) {
            $completionStatus = ProjectCompletionStatus::getLatestStatus(null, $invoice->id);
            return view('project_updates.completion_status', compact('invoice', 'completionStatus'));
        }
        
        // If not an invoice, treat as project
        $project = Product::findOrFail($id);
        
        $completionStatus = ProjectCompletionStatus::getLatestStatus($project->id, null);
        return view('project_updates.completion_status', compact('project', 'completionStatus'));
    }
    
    /**
     * Store project completion status
     */
    public function storeCompletionStatus(Request $request, $id)
    {
        $user = Auth::user();
        
        // Restrict access for customer role (3) and customer position
        if ($user->role == 3 || strtolower($user->position ?? '') == 'customer') {
            abort(403, 'Unauthorized access. Customers cannot create completion status.');
        }
        
        $request->validate([
            'status_items' => 'required|array|min:1',
            'status_items.*' => 'required|string|min:1|max:255',
        ]);
        
        // Filter out empty items
        $statusItems = array_filter($request->status_items, function($item) {
            return !empty(trim($item));
        });
        
        if (empty($statusItems)) {
            return redirect()->back()->with('error', 'At least one status item is required.');
        }
        
        // Check if it's an invoice first
        $invoice = Invoice::find($id);
        if ($invoice) {
            ProjectCompletionStatus::create([
                'invoice_id' => $invoice->id,
                'user_id' => $user->id,
                'status_items' => array_values($statusItems),
                'total_percentage' => 100.00,
            ]);
            
            return redirect()->route('project-updates.show', $invoice->id)
                ->with('success', 'Project completion status created successfully!');
        }
        
        // If not an invoice, treat as project
        $project = Product::findOrFail($id);
        
        ProjectCompletionStatus::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'status_items' => array_values($statusItems),
            'total_percentage' => 100.00,
        ]);
        
        return redirect()->route('project-updates.show', $project->id)
            ->with('success', 'Project completion status created successfully!');
    }
    
    /**
     * Update project completion status
     */
    public function updateCompletionStatus(Request $request, $id)
    {
        $user = Auth::user();
        
        // Restrict access for customer role (3) and customer position
        if ($user->role == 3 || strtolower($user->position ?? '') == 'customer') {
            abort(403, 'Unauthorized access. Customers cannot update completion status.');
        }
        
        $completionStatus = ProjectCompletionStatus::findOrFail($id);
        
        $request->validate([
            'status_items' => 'required|array|min:1',
            'status_items.*' => 'required|string|min:1|max:255',
        ]);
        
        // Filter out empty items
        $statusItems = array_filter($request->status_items, function($item) {
            return !empty(trim($item));
        });
        
        if (empty($statusItems)) {
            return redirect()->back()->with('error', 'At least one status item is required.');
        }
        
        $completionStatus->update([
            'status_items' => array_values($statusItems),
            'total_percentage' => 100.00,
        ]);
        
        $redirectId = $completionStatus->project_id ?? $completionStatus->invoice_id;
        
        return redirect()->route('project-updates.show', $redirectId)
            ->with('success', 'Project completion status updated successfully!');
    }
    
    /**
     * Update progress from interactive progress bar
     */
    public function updateProgress(Request $request, $id)
    {
        \Log::info("updateProgress called with ID: {$id}");
        \Log::info("Request data: " . json_encode($request->all()));
        \Log::info("Request method: " . $request->method());
        \Log::info("Request headers: " . json_encode($request->headers->all()));
        \Log::info("Is AJAX request: " . ($request->ajax() ? 'YES' : 'NO'));
        \Log::info("Wants JSON: " . ($request->wantsJson() ? 'YES' : 'NO'));
        
        // Check authentication first
        if (!Auth::check()) {
            \Log::error("User not authenticated for progress update");
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated. Please log in again.'
                ], 401);
            }
            abort(401, 'User not authenticated. Please log in again.');
        }
        
        $user = Auth::user();
        \Log::info("Authenticated user: " . $user->name . " (Role: " . $user->role . ", Position: " . ($user->position ?? 'N/A') . ")");
        
        // Restrict access for customer role (3) and customer position
        if ($user->role == 3 || strtolower($user->position ?? '') == 'customer') {
            \Log::error("User access denied - Role: " . $user->role . ", Position: " . ($user->position ?? 'N/A'));
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Customers cannot update progress.'
                ], 403);
            }
            abort(403, 'Unauthorized access. Customers cannot update progress.');
        }
        
        try {
            $request->validate([
                'exact_percentage' => 'required|integer|min:0|max:100',
                'total_percentage' => 'required|integer|min:0|max:100',
            ]);
            \Log::info("Validation passed");
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error("Validation failed: " . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . $e->getMessage(),
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }
        
        // Find the completion status for this project/invoice
        $completionStatus = ProjectCompletionStatus::where('project_id', $id)
            ->orWhere('invoice_id', $id)
            ->first();
            
        if (!$completionStatus) {
            \Log::error("Completion status not found for ID: {$id}");
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Completion status not found. Please create one first.'
                ], 404);
            }
            return redirect()->back()->with('error', 'Completion status not found. Please create one first.');
        }
        
        \Log::info("Found completion status ID: {$completionStatus->id} for project/invoice ID: {$id}");
        
        // Get the exact percentage from mouse position
        $exactPercentage = $request->exact_percentage;
        $totalPercentage = $request->total_percentage;
        \Log::info("Processing percentage: {$exactPercentage}%");
        
        // Get the status items
        $statusItems = $completionStatus->status_items;
        \Log::info("Status items count: " . count($statusItems));
        
        // Calculate which segments are completed based on exact percentage
        $updatedItems = [];
        $accumulatedPercentage = 0;
        
        foreach ($statusItems as $index => $item) {
            $segmentPercentage = 100 / count($statusItems); // Equal distribution
            $segmentEnd = $accumulatedPercentage + $segmentPercentage;
            
            $isCompleted = $segmentEnd <= $exactPercentage;
            $isPartial = ($accumulatedPercentage < $exactPercentage && $exactPercentage < $segmentEnd);
            
            $updatedItems[] = [
                'text' => $item,
                'completed' => $isCompleted,
                'partial' => $isPartial,
                'completion_percentage' => $isPartial ? (($exactPercentage - $accumulatedPercentage) / $segmentPercentage) * 100 : ($isCompleted ? 100 : 0)
            ];
            
            \Log::info("Segment {$index}: {$item} - Completed: " . ($isCompleted ? 'YES' : 'NO') . " - Partial: " . ($isPartial ? 'YES' : 'NO'));
            
            $accumulatedPercentage = $segmentEnd;
        }
        
        \Log::info("Updated items: " . json_encode($updatedItems));
        
        // Store the progress data in the model
        try {
            $completionStatus->update([
                'progress_data' => json_encode($updatedItems),
                'current_percentage' => $exactPercentage,
                'exact_percentage' => $exactPercentage,
            ]);
            \Log::info("Database update successful");
        } catch (\Exception $e) {
            \Log::error("Database update failed: " . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Database update failed: ' . $e->getMessage()
                ], 500);
            }
            throw $e;
        }
        
        // Check if this is an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Progress updated successfully!',
                'percentage' => $request->total_percentage
            ]);
        }
        
        return redirect()->route('project-updates.show', $completionStatus->project_id ?? $completionStatus->invoice_id)
            ->with('success', 'Progress updated successfully! Current completion: ' . $request->total_percentage . '%');
    }
}
