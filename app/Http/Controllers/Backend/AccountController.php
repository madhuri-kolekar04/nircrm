<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\User;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    /**
     * Clean and validate phone number to ensure only numeric values
     */
    private function cleanPhoneNumber($phone)
    {
        if (empty($phone)) {
            return null;
        }
        
        // Remove all non-numeric characters
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        
        // If after cleaning we have no digits, return null
        if (empty($cleanPhone)) {
            return null;
        }
        
        // Validate that it's a reasonable phone number length (between 6 and 15 digits)
        if (strlen($cleanPhone) < 6 || strlen($cleanPhone) > 15) {
            return null;
        }
        
        return $cleanPhone;
    }

    /**
     * Move a qualified lead to quotation (Account Management)
     */
    public function moveLeadToQuotation(Lead $lead)
    {
        try {
            // Check if lead is qualified
            if ($lead->lead_status !== 'qualified') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only qualified leads can be moved to Account Management.'
                ], 422);
            }

            // Check if quotation already exists for this lead
            $existingQuotation = Quotation::where('lead_id', $lead->id)->first();
            if ($existingQuotation) {
                return response()->json([
                    'success' => false,
                    'message' => 'A quotation already exists for this lead.'
                ], 422);
            }

            // Generate unique quotation number
            $quotationNumber = 'Q-' . date('Y') . '-' . str_pad($lead->id, 4, '0', STR_PAD_LEFT);
            
            // Ensure unique quotation number
            $counter = 1;
            while (Quotation::where('quotation_number', $quotationNumber)->exists()) {
                $quotationNumber = 'Q-' . date('Y') . '-' . str_pad($lead->id, 4, '0', STR_PAD_LEFT) . '-' . $counter;
                $counter++;
            }

            // Create quotation from lead
            $leadBudget = $lead->budget ?? 0;
            $quotation = Quotation::create([
                'quotation_number' => $quotationNumber,
                'lead_id' => $lead->id,
                'client_contact_name' => $lead->name,
                'client_business_name' => $lead->company_name ?? '',
                'client_email' => $lead->email ?? '',
                'client_phone' => $lead->phone ?? '',
                'executive_summary' => $lead->requirements ?? 'Quotation created from qualified lead',
                'total_cost' => $leadBudget,
                'gst_amount' => 0, // Default GST amount
                'final_amount' => $leadBudget,
                'status' => 'draft',
                'approval_status' => 'waiting',
                'invoice_status' => 'pending',
                'payment_status' => 'pending',
                'customer_panel' => $lead->customer_panel ?? false, // Preserve customer panel status
                'created_by' => auth()->id(), // Add current user ID
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Update lead status to indicate it's been converted
            $lead->update([
                'lead_status' => 'converted',
                'converted_at' => now()
            ]);

            Log::info('Lead moved to quotation successfully', [
                'lead_id' => $lead->id,
                'quotation_id' => $quotation->id,
                'quotation_number' => $quotation->quotation_number
            ]);

            return response()->json([
                'success' => true,
                'message' => "Lead successfully moved to Account Management! Quotation Number: {$quotation->quotationNumber}",
                'quotation_id' => $quotation->id,
                'quotation_number' => $quotation->quotationNumber
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to move lead to quotation', [
                'lead_id' => $lead->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to move lead to Account Management: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Move a quotation back to lead (Leads Qualified)
     */
    public function moveQuotationToLead(Quotation $quotation, Lead $lead)
    {
        try {
            // Verify this quotation belongs to this lead
            if ($quotation->lead_id != $lead->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'This quotation does not belong to the specified lead.'
                ], 422);
            }

            // Delete the quotation
            $quotationNumber = $quotation->quotation_number;
            
            // Preserve customer panel status before deleting quotation
            $customerPanelStatus = $quotation->customer_panel ?? false;
            $quotation->delete();

            // Restore lead status to qualified and preserve customer panel status
            $lead->update([
                'lead_status' => 'qualified',
                'converted_at' => null,
                'customer_panel' => $customerPanelStatus // Preserve customer panel status
            ]);

            Log::info('Quotation moved back to lead successfully', [
                'quotation_id' => $quotation->id,
                'quotation_number' => $quotationNumber,
                'lead_id' => $lead->id
            ]);

            return response()->json([
                'success' => true,
                'message' => "Quotation {$quotationNumber} successfully moved back to Leads Qualified!",
                'lead_id' => $lead->id,
                'quotation_number' => $quotationNumber
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to move quotation back to lead', [
                'quotation_id' => $quotation->id,
                'lead_id' => $lead->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to move quotation back to Leads Qualified: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of approved quotations for account management.
     */
    public function index()
    {
        // Allow all authenticated users to access this page

        // Get all quotations without approval status filter
        $quotations = Quotation::orderBy('created_at', 'desc')
            ->paginate(15);

        // Get qualified leads for the new table
        $qualifiedLeads = Lead::where('lead_status', 'qualified')
            ->latest()
            ->get();

        // Sync invoice status from leads to quotations
        foreach ($quotations as $quotation) {
            if ($quotation->lead_id) {
                $lead = Lead::find($quotation->lead_id);
                if ($lead && $lead->invoice_status) {
                    // Update quotation invoice status to match lead's invoice status
                    $quotation->invoice_status = $lead->invoice_status;
                    $quotation->save();
                    
                    // Update approval status based on invoice status
                    if ($lead->invoice_status === 'approved') {
                        $quotation->approval_status = 'approved';
                        $quotation->approved_at = now();
                    } elseif ($lead->invoice_status === 'rejected') {
                        $quotation->approval_status = 'rejected';
                    } elseif ($lead->invoice_status === 'waiting_for_approval' || $lead->invoice_status === 'waiting for approval') {
                        $quotation->approval_status = 'waiting'; // Use 'waiting' instead of 'pending'
                    } else {
                        $quotation->approval_status = 'waiting'; // Use 'waiting' as default
                    }
                    $quotation->save();
                    
                    Log::info('Quotation synced from lead status', [
                        'quotation_id' => $quotation->id,
                        'lead_id' => $lead->id,
                        'lead_invoice_status' => $lead->invoice_status,
                        'quotation_invoice_status' => $quotation->invoice_status,
                        'quotation_approval_status' => $quotation->approval_status
                    ]);
                }
            }
        }

        return view('backend.accounts.index', compact('quotations', 'qualifiedLeads'));
    }

    /**
     * Update payment status for a quotation
     */
    public function updatePaymentStatus(Request $request, Quotation $quotation)
    {
        // Allow all authenticated users to update payment status

        $request->validate([
            'payment_status' => 'required|in:pending,partial,completed,overdue,cancelled',
        ]);

        $oldStatus = $quotation->payment_status;
        $newStatus = $request->payment_status;
        
        // Normalize status to lowercase for comparison
        $normalizedNewStatus = strtolower($newStatus);
        
        $quotation->payment_status = $newStatus;
        $quotation->payment_updated_at = now();
        $quotation->save();

        // Payment status updated - no automatic account creation
        // Customer accounts are now created only via Customer Panel toggle
        \Log::info('Payment status updated from ' . $oldStatus . ' to ' . $newStatus . ' for quotation ' . $quotation->id . '.');

        return redirect()->route('accounts.index')
            ->with('success', 'Payment status updated successfully.');
    }

    /**
     * Create customer account when payment is completed
     */
    private function createCustomerAccount(Quotation $quotation)
    {
        try {
            \Log::info('Starting customer account creation for quotation: ' . $quotation->id);
            \Log::info('Client email: ' . $quotation->client_email);
            \Log::info('Client name: ' . $quotation->client_contact_name);
            
            // Validate email exists
            if (empty($quotation->client_email)) {
                throw new \Exception('Cannot create customer account: Quotation does not have a valid email address.');
            }
            
            // Check if customer account already exists
            $existingUser = User::where('email', $quotation->client_email)->first();
            
            if ($existingUser) {
                \Log::info('User already exists with email: ' . $quotation->client_email . '. Current role: ' . $existingUser->role);
                
                // Update existing user to customer role if not already
                if ($existingUser->role != 3) {
                    \Log::info('Updating existing user role to customer (role=3)');
                    $cleanPhone = $this->cleanPhoneNumber($quotation->client_phone);
                    $existingUser->update([
                        'role' => 3,
                        'position' => 'Customer',
                        'department' => 'Customer',
                        'contact_number' => $cleanPhone ?: $existingUser->contact_number,
                        'comapny_name' => $quotation->client_business_name ?: $existingUser->comapny_name,
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
            
            // Clean and validate phone number
            $cleanPhone = $this->cleanPhoneNumber($quotation->client_phone);
            
            // Create new customer user
            $userData = [
                'name' => $quotation->client_contact_name,
                'email' => $quotation->client_email,
                'contact_number' => $cleanPhone,
                'comapny_name' => $quotation->client_business_name ?: null,
                'pan_number' => null,
                'aadhar_number' => null,
                'department' => 'Customer',
                'password' => Hash::make($defaultPassword),
                'password_change_required' => true, // Force password change on first login
                'role' => 3, // Customer role
                'position' => 'Customer',
            ];

            $user = User::create($userData);
            \Log::info('Customer user created successfully with ID: ' . $user->id . ' and default password');

            // TODO: Send welcome email with password to customer
            \Log::info('Customer account creation completed for quotation: ' . $quotation->id);

        } catch (\Exception $e) {
            \Log::error('Failed to create customer account for quotation ' . $quotation->id . ': ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Store session data for invoice creation
     */
    public function storeSessionData(Request $request)
    {
        // Allow all authenticated users to store session data

        $data = $request->all();
        session(['invoice_data' => $data]);

        return response()->json(['success' => true]);
    }

    /**
     * Confirm payment plan and create invoice
     */
    public function confirmPaymentPlan(Request $request, Quotation $quotation)
    {
        // Allow all authenticated users to confirm payment plan

        try {
            $request->validate([
                'payment_status' => 'required|in:pending,partial,completed,overdue,cancelled',
                'total_amount' => 'required|numeric|min:0',
                'advance_payment' => 'required|numeric|min:0',
            ]);

            // Update quotation with payment details
            $quotation->update([
                'payment_status' => $request->payment_status,
                'total_amount' => $request->total_amount,
                'advance_payment' => $request->advance_payment,
                'payment_updated_at' => now(),
            ]);

            return redirect()->route('accounts.index')
                ->with('success', 'Payment plan confirmed successfully.');

        } catch (\Exception $e) {
            \Log::error('Failed to confirm payment plan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to confirm payment plan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle customer panel access for quotations
     */
    public function toggleCustomerPanel(Request $request, Quotation $quotation)
    {
        // Allow all authenticated users to toggle customer panel access

        try {
            // Get customer_panel from request
            $enable = $request->get('customer_panel', false);
            
            if ($enable) {
                // Enable customer panel - create or activate account
                $this->enableCustomerPanelForQuotation($quotation);
                $message = 'Customer panel access enabled successfully. Default password: 123456789';
                
                // Send email notification to customer
                $this->sendQuotationCustomerPanelEnabledEmail($quotation);
                
            } else {
                // Disable customer panel - suspend account
                $this->disableCustomerPanelForQuotation($quotation);
                $message = 'Customer panel access disabled successfully.';
                
                // Send email notification to customer
                $this->sendQuotationCustomerPanelDisabledEmail($quotation);
            }

            // Update the quotation's customer panel status
            $quotation->customer_panel = $enable;
            $quotation->save();

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to toggle customer panel: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle customer panel: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enable customer panel for quotation
     */
    private function enableCustomerPanelForQuotation(Quotation $quotation)
    {
        // Check if email exists
        if (empty($quotation->client_email)) {
            throw new \Exception('Cannot enable customer panel: Lead/Quotation does not have a valid email address.');
        }
        
        // Check if customer account exists
        $customer = User::where('email', $quotation->client_email)->first();
        
        if ($customer) {
            \Log::info('Found existing customer account: ' . $customer->id);
            
            // Enable login access for existing customer
            $customer->update([
                'role' => 3, // Ensure customer role
                'password' => Hash::make('123456789'), // Reset to default password
                'password_change_required' => true,
                'email_verified_at' => now(), // Ensure email is verified (using correct field name)
                'department' => 'Customer',
                'position' => 'Customer',
            ]);
            
            \Log::info('Customer account enabled successfully');
        } else {
            \Log::info('No existing customer account found, creating new one');
            // Create new customer account
            $this->createCustomerAccount($quotation);
        }
    }

    /**
     * Disable customer panel for quotation
     */
    private function disableCustomerPanelForQuotation(Quotation $quotation)
    {
        // Find customer account
        $customer = User::where('email', $quotation->client_email)->first();
        
        if ($customer && $customer->role == 3) {
            \Log::info('Found customer account, disabling access: ' . $customer->id);
            
            // Disable customer access by changing password to random string
            $randomPassword = Str::random(32);
            $customer->update([
                'password' => Hash::make($randomPassword),
                'password_change_required' => true,
            ]);
            
            \Log::info('Customer account disabled successfully');
        } else {
            \Log::info('No customer account found to disable');
        }
    }

    /**
     * Toggle customer panel access for leads (same logic as quotations)
     */
    public function toggleCustomerPanelForLead(Request $request, Lead $lead)
    {
        // Allow all authenticated users to toggle customer panel access

        try {
            // Get customer_panel from request
            $enable = $request->get('customer_panel', false);
            
            if ($enable) {
                // Enable customer panel - create or activate account
                $this->enableCustomerPanelForLead($lead);
                $message = 'Customer panel access enabled successfully. Default password: 123456789';
                
                // Send email notification to customer
                $this->sendLeadCustomerPanelEnabledEmail($lead);
                
            } else {
                // Disable customer panel - suspend account
                $this->disableCustomerPanelForLead($lead);
                $message = 'Customer panel access disabled successfully.';
                
                // Send email notification to customer
                $this->sendLeadCustomerPanelDisabledEmail($lead);
            }

            // Update the lead's customer panel status
            $lead->customer_panel = $enable;
            $lead->save();

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to toggle customer panel for lead: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle customer panel: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enable customer panel for lead
     */
    private function enableCustomerPanelForLead(Lead $lead)
    {
        // Check if email exists
        if (empty($lead->email)) {
            throw new \Exception('Cannot enable customer panel: Lead does not have a valid email address.');
        }
        
        // Check if customer account exists
        $customer = User::where('email', $lead->email)->first();
        
        if ($customer) {
            \Log::info('Found existing customer account: ' . $customer->id);
            
            // Enable login access for existing customer
            $customer->update([
                'role' => 3, // Ensure customer role
                'password' => Hash::make('123456789'), // Reset to default password
                'password_change_required' => true,
                'email_verified_at' => now(), // Ensure email is verified (using correct field name)
                'department' => 'Customer',
                'position' => 'Customer',
            ]);
            
            \Log::info('Customer account enabled successfully');
        } else {
            \Log::info('No existing customer account found, creating new one');
            // Create new customer account
            $this->createCustomerAccountForLead($lead);
        }
    }

    /**
     * Disable customer panel for lead
     */
    private function disableCustomerPanelForLead(Lead $lead)
    {
        // Find customer account
        $customer = User::where('email', $lead->email)->first();
        
        if ($customer && $customer->role == 3) {
            \Log::info('Found customer account, disabling access: ' . $customer->id);
            
            // Disable customer access by changing password to random string
            $randomPassword = Str::random(32);
            $customer->update([
                'password' => Hash::make($randomPassword),
                'password_change_required' => true,
            ]);
            
            \Log::info('Customer account disabled successfully');
        } else {
            \Log::info('No customer account found to disable');
        }
    }

    /**
     * Create customer account for lead (same as createCustomerAccount)
     */
    private function createCustomerAccountForLead(Lead $lead)
    {
        try {
            \Log::info('Starting customer account creation for lead: ' . $lead->id);
            \Log::info('Lead email: ' . $lead->email);
            \Log::info('Lead name: ' . $lead->name);
            
            // Validate email exists
            if (empty($lead->email)) {
                throw new \Exception('Cannot create customer account: Lead does not have a valid email address.');
            }
            
            // Check if customer account already exists (same as quotations)
            $existingUser = User::where('email', $lead->email)->first();
            
            if ($existingUser) {
                \Log::info('User already exists with email: ' . $lead->email . '. Current role: ' . $existingUser->role);
                
                // Update existing user to customer role if not already (same as quotations)
                if ($existingUser->role != 3) {
                    \Log::info('Updating existing user role to customer (role=3)');
                    $cleanPhone = $this->cleanPhoneNumber($lead->phone);
                    $existingUser->update([
                        'role' => 3,
                        'position' => 'Customer',
                        'department' => 'Customer',
                        'contact_number' => $cleanPhone ?: $existingUser->contact_number,
                        'comapny_name' => $lead->company_name ?: $existingUser->comapny_name,
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

            // Use default password as requested (same as quotations)
            $defaultPassword = '123456789';
            \Log::info('Using default password for new customer: ' . $defaultPassword);
            
            // Clean and validate phone number
            $cleanPhone = $this->cleanPhoneNumber($lead->phone);
            
            // Create new customer user (same as quotations)
            $userData = [
                'name' => $lead->name,
                'email' => $lead->email,
                'contact_number' => $cleanPhone,
                'comapny_name' => $lead->company_name ?: null,
                'pan_number' => null,
                'aadhar_number' => null,
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
     * Edit quotation
     */
    public function editQuotation(Quotation $quotation)
    {
        // Allow all authenticated users to edit quotations

        return view('backend.accounts.edit-quotation', compact('quotation'));
    }

    /**
     * Generate invoice for a quotation
     */
    public function generateInvoice(Quotation $quotation)
    {
        // Allow all authenticated users to generate invoices

        // Generate unique invoice number
        $baseInvoiceNumber = 'INV-' . date('Y') . '-' . str_pad($quotation->id, 4, '0', STR_PAD_LEFT);
        $counter = 1;
        
        do {
            $invoiceNumber = $baseInvoiceNumber . ($counter > 1 ? '-' . $counter : '');
            $exists = \App\Models\Invoice::where('invoice_number', $invoiceNumber)->exists();
            $counter++;
        } while ($exists);

        return view('backend.accounts.create-invoice', compact('quotation', 'invoiceNumber'));
    }

    /**
     * Save invoice from quotation
     */
    public function simpleSaveInvoice(Request $request, Quotation $quotation)
    {
        // Allow all authenticated users to save invoices

        try {
            $request->validate([
                'invoice_date' => 'nullable|date',
                'client_name' => 'nullable|string|max:255',
                'client_email' => 'nullable|email|max:255',
                'client_phone' => 'nullable|string|max:20',
                'payment_status' => 'nullable|in:pending,partial,completed,overdue,cancelled',
                'total_amount' => 'nullable|numeric|min:0',
                'advance_payment' => 'nullable|numeric|min:0',
                'remaining_amount' => 'nullable|numeric|min:0',
                'advance_payment_date' => 'nullable|date',
                'bank_account_number' => 'nullable|string|max:20',
                'ifsc_code' => 'nullable|string|max:11',
                'mobile_bank_number' => 'nullable|string|max:10',
                'company_pan' => 'nullable|string|max:10',
                'gst_number' => 'nullable|string|max:20',
                'place_of_supply' => 'nullable|string|max:100',
                'hsn_code' => 'nullable|string|max:20',
                'payment_terms' => 'nullable|string',
                'privacy_policy' => 'nullable|string',
                'notes' => 'nullable|string',
                'service_amounts' => 'nullable|array',
                'service_amounts.*' => 'nullable|numeric|min:0',
                'manual_subtotal' => 'nullable|numeric|min:0',
                'manual_gst' => 'nullable|numeric|min:0',
                'manual_total' => 'nullable|numeric|min:0',
                'installment_amounts' => 'nullable|array',
                'installment_amounts.*' => 'nullable|numeric|min:0',
            ]);

            Log::info('AccountController: simpleSaveInvoice called', [
                'quotation_id' => $quotation->id,
                'quotation_number' => $quotation->quotation_number,
                'client_email' => $quotation->client_email,
                'request_data' => $request->all()
            ]);

            // Create invoice record
            $invoice = new \App\Models\Invoice();
            
            // Generate unique invoice number
            $baseInvoiceNumber = 'INV-' . date('Y') . '-' . str_pad($quotation->id, 4, '0', STR_PAD_LEFT);
            $counter = 1;
            
            do {
                $invoiceNumber = $baseInvoiceNumber . ($counter > 1 ? '-' . $counter : '');
                $exists = \App\Models\Invoice::where('invoice_number', $invoiceNumber)->exists();
                $counter++;
            } while ($exists);
            
            $invoice->invoice_number = $invoiceNumber;
            $invoice->invoice_date = $request->invoice_date ?? now()->format('Y-m-d');
            $invoice->customer_name = $request->client_name ?? $quotation->client_contact_name;
            $invoice->customer_email = $request->client_email ?? $quotation->client_email;
            $invoice->customer_phone = $request->client_phone ?? $quotation->client_phone;
            $invoice->customer_address = $request->client_business ?? $quotation->client_business_name ?? '';
            $invoice->project_name = $quotation->quotation_number;
            $invoice->project_topic = 'Invoice for Quotation: ' . $quotation->quotation_number;
            $invoice->project_full_details = $quotation->executive_summary ?? 'Professional Services as per quotation';
            $invoice->department = 'Accounts';
            $invoice->start_date = $request->invoice_date ?? now()->format('Y-m-d');
            $invoice->end_date = $request->invoice_date ?? now()->format('Y-m-d');
            $invoice->advance_payment = $request->advance_payment ?? 0;
            $invoice->remaining_payment = $request->remaining_amount ?? $quotation->final_amount;
            $invoice->gst = $quotation->gst_amount;
            $invoice->total_payment = $request->total_amount ?? $quotation->final_amount;
            $invoice->status = $request->payment_status ?? 'pending';
            $invoice->installments = json_encode([]);

            // Save additional invoice data with defaults
            $invoice->bank_account_number = $request->bank_account_number ?? '';
            $invoice->ifsc_code = $request->ifsc_code ?? '';
            $invoice->mobile_bank_number = $request->mobile_bank_number ?? '';
            $invoice->company_pan = $request->company_pan ?? '';
            $invoice->gst_number = $request->gst_number ?? '';
            $invoice->place_of_supply = $request->place_of_supply ?? 'Maharashtra';
            $invoice->hsn_code = $request->hsn_code ?? '998314';
            $invoice->payment_terms = $request->payment_terms ?? 'Payment to be made within 15 days from invoice date. Late payment charges @ 18% per annum will be applicable.';
            $invoice->privacy_policy = $request->privacy_policy ?? 'We respect your privacy and are committed to protecting your personal data. This invoice and all related information are confidential and intended solely for the use of the addressee. Any unauthorized use or disclosure is prohibited. All business transactions are subject to our terms of service and privacy policy available at our website.';
            $invoice->notes = $request->notes ?? 'Thank you for your business! We appreciate your trust in our services.';

            $invoice->save();

            // Handle manual totals override
            $useManualTotals = false;
            $manualSubtotal = $request->manual_subtotal ?? null;
            $manualGst = $request->manual_gst ?? null;
            $manualTotal = $request->manual_total ?? null;
            
            if ($manualSubtotal !== null || $manualGst !== null || $manualTotal !== null) {
                $useManualTotals = true;
                Log::info('Using manual totals override', [
                    'manual_subtotal' => $manualSubtotal,
                    'manual_gst' => $manualGst,
                    'manual_total' => $manualTotal
                ]);
                
                // Validate manual totals
                if ($manualSubtotal !== null && $manualTotal !== null && $manualTotal < $manualSubtotal) {
                    throw new \Exception('Total amount cannot be less than subtotal');
                }
                
                // Set defaults if some values are missing
                $finalSubtotal = $manualSubtotal ?? ($manualTotal - ($manualGst ?? 0));
                $finalGst = $manualGst ?? ($manualTotal - $finalSubtotal);
                $finalTotal = $manualTotal ?? ($finalSubtotal + $finalGst);
                
                // Update quotation with manual totals
                $quotation->update([
                    'total_cost' => $finalSubtotal,
                    'gst_amount' => $finalGst,
                    'final_amount' => $finalTotal
                ]);
                
                Log::info('Quotation updated with manual totals', [
                    'final_subtotal' => $finalSubtotal,
                    'final_gst' => $finalGst,
                    'final_total' => $finalTotal
                ]);
            }

            // Handle installment amounts if provided
            if ($request->has('installment_amounts') && is_array($request->installment_amounts)) {
                Log::info('Processing installment amounts', ['installment_amounts' => $request->installment_amounts]);
                
                $installments = [];
                foreach ($request->installment_amounts as $index => $amount) {
                    if ($amount > 0) {
                        $installments[] = [
                            'installment_number' => $index + 1,
                            'amount' => $amount,
                            'created_at' => now()
                        ];
                        
                        Log::info('Added installment', [
                            'installment_number' => $index + 1,
                            'amount' => $amount
                        ]);
                    }
                }
                
                // Save installments to invoice record
                $invoice->installments = json_encode($installments);
                $invoice->save();
                
                Log::info('Installments saved to invoice', [
                    'invoice_id' => $invoice->id,
                    'installments_count' => count($installments)
                ]);
            }

            // Handle service amounts if provided (only if not using manual totals)
            if (!$useManualTotals && $request->has('service_amounts') && is_array($request->service_amounts)) {
                Log::info('Processing service amounts', ['service_amounts' => $request->service_amounts]);
                
                foreach ($request->service_amounts as $serviceId => $newAmount) {
                    if ($newAmount > 0) {
                        // Update the service pivot table with new amount
                        $quotation->services()->updateExistingPivot($serviceId, [
                            'subtotal' => $newAmount
                        ]);
                        
                        Log::info('Updated service amount', [
                            'service_id' => $serviceId,
                            'new_amount' => $newAmount
                        ]);
                    }
                }
                
                // Recalculate quotation totals based on updated service amounts
                $this->recalculateQuotationTotals($quotation);
            }

            Log::info('Invoice saved successfully', ['invoice_id' => $invoice->id, 'invoice_number' => $invoice->invoice_number]);

            // Update quotation invoice status to waiting for approval
            $quotation->invoice_status = 'waiting for approval';
            $quotation->payment_status = $request->payment_status;
            $quotation->payment_updated_at = now();
            $quotation->save();

            Log::info('Quotation updated with invoice status', [
                'quotation_id' => $quotation->id,
                'invoice_status' => $quotation->invoice_status,
                'payment_status' => $quotation->payment_status
            ]);

            // Send email with approval and call buttons
            $this->sendInvoiceApprovalEmail($quotation, $invoice);

            Log::info('Email sending initiated for invoice approval');

            // Handle different save options with success messages
            if ($request->has('save_only') || $request->has('save_without_pdf')) {
                Log::info('Redirecting to accounts.index with success');
                return redirect()->route('accounts.index')
                    ->with('success', '✅ Invoice created successfully! Invoice Number: ' . $invoice->invoice_number . ' and approval email sent to ' . $quotation->client_email)
                    ->with('email_sent', '📧 Approval email has been sent to ' . $quotation->client_email);
            } else {
                // Generate PDF (placeholder - you can implement PDF generation here)
                Log::info('Redirecting to accounts.index with PDF success');
                return redirect()->route('accounts.index')
                    ->with('success', '✅ Invoice created successfully! Invoice Number: ' . $invoice->invoice_number . ', approval email sent to ' . $quotation->client_email . '. PDF generation can be implemented.')
                    ->with('email_sent', '📧 Approval email has been sent to ' . $quotation->client_email);
            }

        } catch (\Exception $e) {
            Log::error('Failed to save invoice from quotation', [
                'error' => $e->getMessage(),
                'quotation_id' => $quotation->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', '❌ Failed to create invoice: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Send invoice approval email for accounts
     */
    private function sendInvoiceApprovalEmail(Quotation $quotation, \App\Models\Invoice $invoice)
    {
        try {
            $approvalToken = Str::random(32);
            session(['invoice_approval_' . $invoice->id => $approvalToken]);

            $data = [
                'quotation' => $quotation,
                'invoice' => $invoice,
                'approvalToken' => $approvalToken,
                'callNumber' => '9284161465'
            ];

            Log::info('Preparing to send invoice approval email from accounts', [
                'quotation_id' => $quotation->id,
                'quotation_number' => $quotation->quotation_number,
                'client_email' => $quotation->client_email,
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'approval_token' => $approvalToken
            ]);

            // Check mail configuration
            $mailConfig = [
                'from_address' => config('mail.from.address'),
                'from_name' => config('mail.from.name'),
                'mail_driver' => config('mail.default'),
                'mail_host' => config('mail.mailers.smtp.host'),
                'mail_port' => config('mail.mailers.smtp.port'),
                'mail_username' => config('mail.mailers.smtp.username'),
            ];
            
            Log::info('Mail configuration', $mailConfig);

            \Mail::send('emails.invoice-approval', $data, function($message) use ($quotation, $invoice) {
                $message->to($quotation->client_email)
                        ->subject('Invoice Approval Required - ' . $invoice->invoice_number)
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info('Invoice approval email sent successfully from accounts', [
                'to' => $quotation->client_email,
                'subject' => 'Invoice Approval Required - ' . $invoice->invoice_number,
                'approval_url' => url('/invoice/approve/' . $approvalToken)
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send invoice approval email from accounts', [
                'error' => $e->getMessage(),
                'quotation_id' => $quotation->id,
                'invoice_id' => $invoice->id,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Approve invoice from accounts
     */
    public function approveInvoice($token)
    {
        try {
            // Find invoice by session token
            $invoiceId = null;
            foreach(session()->all() as $key => $value) {
                if (str_starts_with($key, 'invoice_approval_') && $value === $token) {
                    $invoiceId = str_replace('invoice_approval_', '', $key);
                    break;
                }
            }

            if (!$invoiceId) {
                return view('errors.invoice-approval', [
                    'status' => 'error',
                    'message' => 'Invalid or expired approval token.'
                ]);
            }

            $invoice = \App\Models\Invoice::find($invoiceId);
            if (!$invoice) {
                return view('errors.invoice-approval', [
                    'status' => 'error',
                    'message' => 'Invoice not found.'
                ]);
            }

            // Find quotation by invoice number
            $quotation = Quotation::where('quotation_number', $invoice->project_name)->first();
            if (!$quotation) {
                return view('errors.invoice-approval', [
                    'status' => 'error',
                    'message' => 'Quotation not found for this invoice.'
                ]);
            }

            // Update quotation invoice status
            $quotation->invoice_status = 'approved';
            $quotation->save();

            // Update invoice status
            $invoice->status = 'approved';
            $invoice->save();

            // Sync status back to lead if quotation has lead_id
            if ($quotation->lead_id) {
                $lead = Lead::find($quotation->lead_id);
                if ($lead) {
                    $lead->invoice_status = 'approved';
                    $lead->save();
                    
                    Log::info('Lead status synced from accounts approval', [
                        'lead_id' => $lead->id,
                        'quotation_id' => $quotation->id,
                        'invoice_id' => $invoice->id,
                        'new_status' => 'approved'
                    ]);
                }
            }

            // Clear session token
            session()->forget('invoice_approval_' . $invoiceId);

            Log::info('Invoice approved successfully from accounts', [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'quotation_id' => $quotation->id,
                'quotation_number' => $quotation->quotation_number
            ]);

            return view('errors.invoice-approval', [
                'status' => 'success',
                'message' => 'Invoice ' . $invoice->invoice_number . ' has been approved successfully!',
                'invoice' => $invoice,
                'quotation' => $quotation
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to approve invoice from accounts: ' . $e->getMessage());
            return view('errors.invoice-approval', [
                'status' => 'error',
                'message' => 'An error occurred while approving the invoice. Please contact support.'
            ]);
        }
    }

    /**
     * Get invoice statuses for real-time updates
     */
    public function getInvoiceStatuses()
    {
        try {
            // Get all quotations with invoice status
            $quotations = Quotation::select('id', 'quotation_number', 'invoice_status')
                ->whereNotNull('invoice_status')
                ->get();

            $statuses = [];
            foreach ($quotations as $quotation) {
                $statuses[] = [
                    'quotationId' => $quotation->id,
                    'invoiceNumber' => $quotation->quotation_number,
                    'invoiceStatus' => $quotation->invoice_status ?: 'pending'
                ];
            }

            return response()->json($statuses);
        } catch (\Exception $e) {
            Log::error('Failed to get invoice statuses: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch invoice statuses'], 500);
        }
    }

    /**
     * Send email notification when customer panel is enabled for a lead
     */
    private function sendLeadCustomerPanelEnabledEmail(Lead $lead)
    {
        try {
            if (!$lead->email) {
                Log::warning('Cannot send customer panel enabled email - lead has no email address', [
                    'lead_id' => $lead->id,
                    'lead_name' => $lead->name
                ]);
                return;
            }

            $loginUrl = route('login');
            
            $data = [
                'lead' => $lead,
                'loginUrl' => $loginUrl
            ];

            Mail::send('emails.lead-customer-panel-enabled', $data, function($message) use ($lead) {
                $message->to($lead->email)
                        ->subject('Customer Panel Access Enabled - Niranjan Enterprises')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info('Customer panel enabled email sent successfully', [
                'lead_id' => $lead->id,
                'lead_name' => $lead->name,
                'lead_email' => $lead->email
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send customer panel enabled email for lead: ' . $e->getMessage(), [
                'lead_id' => $lead->id,
                'lead_email' => $lead->email,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send email notification when customer panel is disabled for a lead
     */
    private function sendLeadCustomerPanelDisabledEmail(Lead $lead)
    {
        try {
            if (!$lead->email) {
                Log::warning('Cannot send customer panel disabled email - lead has no email address', [
                    'lead_id' => $lead->id,
                    'lead_name' => $lead->name
                ]);
                return;
            }

            $data = [
                'lead' => $lead
            ];

            Mail::send('emails.lead-customer-panel-disabled', $data, function($message) use ($lead) {
                $message->to($lead->email)
                        ->subject('Customer Panel Access Disabled - Niranjan Enterprises')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info('Customer panel disabled email sent successfully', [
                'lead_id' => $lead->id,
                'lead_name' => $lead->name,
                'lead_email' => $lead->email
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send customer panel disabled email for lead: ' . $e->getMessage(), [
                'lead_id' => $lead->id,
                'lead_email' => $lead->email,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send email notification when customer panel is enabled for a quotation
     */
    private function sendQuotationCustomerPanelEnabledEmail(Quotation $quotation)
    {
        try {
            if (!$quotation->client_email) {
                Log::warning('Cannot send customer panel enabled email - quotation has no email address', [
                    'quotation_id' => $quotation->id,
                    'quotation_number' => $quotation->quotation_number
                ]);
                return;
            }

            // Find or create the user account
            $user = User::where('email', $quotation->client_email)->first();
            if (!$user) {
                Log::warning('Cannot find user account for quotation email notification', [
                    'quotation_id' => $quotation->id,
                    'client_email' => $quotation->client_email
                ]);
                return;
            }

            $loginUrl = route('login');
            $defaultPassword = '123456789';
            
            $data = [
                'user' => $user,
                'quotation' => $quotation,
                'loginUrl' => $loginUrl,
                'password' => $defaultPassword
            ];

            Mail::send('emails.customer-welcome', $data, function($message) use ($quotation) {
                $message->to($quotation->client_email)
                        ->subject('Customer Panel Access Enabled - NIRCRM')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info('Customer panel enabled email sent successfully for quotation', [
                'quotation_id' => $quotation->id,
                'quotation_number' => $quotation->quotation_number,
                'client_email' => $quotation->client_email
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send customer panel enabled email for quotation: ' . $e->getMessage(), [
                'quotation_id' => $quotation->id,
                'client_email' => $quotation->client_email,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send email notification when customer panel is disabled for a quotation
     */
    private function sendQuotationCustomerPanelDisabledEmail(Quotation $quotation)
    {
        try {
            if (!$quotation->client_email) {
                Log::warning('Cannot send customer panel disabled email - quotation has no email address', [
                    'quotation_id' => $quotation->id,
                    'quotation_number' => $quotation->quotation_number
                ]);
                return;
            }

            // Find the user account
            $user = User::where('email', $quotation->client_email)->first();
            if (!$user) {
                Log::warning('Cannot find user account for quotation deactivation email', [
                    'quotation_id' => $quotation->id,
                    'client_email' => $quotation->client_email
                ]);
                return;
            }

            $data = [
                'user' => $user,
                'quotation' => $quotation
            ];

            Mail::send('emails.customer-deactivation', $data, function($message) use ($quotation) {
                $message->to($quotation->client_email)
                        ->subject('Customer Panel Access Disabled - Niranjan Enterprises')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info('Customer panel disabled email sent successfully for quotation', [
                'quotation_id' => $quotation->id,
                'quotation_number' => $quotation->quotation_number,
                'client_email' => $quotation->client_email
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send customer panel disabled email for quotation: ' . $e->getMessage(), [
                'quotation_id' => $quotation->id,
                'client_email' => $quotation->client_email,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Recalculate quotation totals based on updated service amounts
     */
    private function recalculateQuotationTotals(Quotation $quotation)
    {
        try {
            // Calculate new subtotal from service amounts
            $newSubtotal = 0;
            foreach ($quotation->services as $service) {
                $newSubtotal += $service->pivot->subtotal;
            }
            
            // Calculate GST (18%)
            $gstRate = 0.18;
            $newGstAmount = $newSubtotal * $gstRate;
            
            // Calculate final amount
            $newFinalAmount = $newSubtotal + $newGstAmount;
            
            // Update quotation with new totals
            $quotation->update([
                'total_cost' => $newSubtotal,
                'gst_amount' => $newGstAmount,
                'final_amount' => $newFinalAmount
            ]);
            
            Log::info('Quotation totals recalculated', [
                'quotation_id' => $quotation->id,
                'new_subtotal' => $newSubtotal,
                'new_gst_amount' => $newGstAmount,
                'new_final_amount' => $newFinalAmount
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to recalculate quotation totals', [
                'quotation_id' => $quotation->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
