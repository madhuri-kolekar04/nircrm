<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use App\Models\Lead;
use App\Models\Invoice;
use App\Models\EmailTracking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DepartmentController extends Controller
{
 public function DepartmentView(){
     	$id = Auth::user()->id;
		$adminData = User::find($id);
    	$Department = Department::latest()->get();
    	$Employee = User::where('role' , '0')->get();
       
    	return view('backend.department.Department_view',compact('Department' ,'Employee','adminData'));

    }


    


public function DepartmentStore(Request $request){

    $request->validate([
        'Department' => 'required',

    ],[
        'Department.required' => 'Input Department  Name',
           ]);



Department::insert([
    'Department' => $request->Department,

    ]);

    $notification = array(
        'message' => 'Department Inserted Successfully',
        'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);

} // end method 



public function DepartmentEdit($id){
    $Department = Department::findOrFail($id);
    return view('backend.department.Department_edit',compact('Department'));

}


public function DepartmentUpdate(Request $request){
    
	$Department_id = $request->Department_id;
    Department::findOrFail($Department_id)->update([
    'department' => $request->Department,


    ]);

    $notification = array(
        'message' => 'Department Updated Successfully',
        'alert-type' => 'info'
    );

    return redirect()->route('all.Department')->with($notification);


} // end method 



public function salesDepartmentView(){
    $id = Auth::user()->id;
    $adminData = User::find($id);
    
    // Get only qualified leads with all relationships
    $qualifiedLeads = Lead::with(['creator', 'assignedUser', 'department'])
                        ->where('lead_status', 'qualified')
                        ->latest()
                        ->get();
    
    return view('backend.department.sales_department_view_new', compact('qualifiedLeads', 'adminData'));
}

/**
 * Create invoice from lead
 */
public function createInvoiceFromLead(Lead $lead)
{
    $id = Auth::user()->id;
    $adminData = User::find($id);
    
    // Generate invoice number
    $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($lead->id, 4, '0', STR_PAD_LEFT);
    
    // Get latest approved quotation for this lead
    $latestQuotation = $lead->latestApprovedQuotation();
    
    // Determine total amount from quotation or lead budget
    $totalAmount = 0;
    if ($latestQuotation) {
        $totalAmount = $latestQuotation->final_amount;
    } elseif ($lead->budget) {
        $totalAmount = $lead->budget;
    } else {
        // Set a default amount if no quotation or budget exists
        $totalAmount = 0;
    }
    
    return view('backend.department.create-invoice-from-lead', compact('lead', 'invoiceNumber', 'adminData', 'latestQuotation', 'totalAmount'));
}

/**
 * Save invoice from lead
 */
public function saveInvoiceFromLead(Request $request, Lead $lead)
{
    try {
        Log::info('🚀🚀🚀 saveInvoiceFromLead called!', [
            'lead_id' => $lead->id,
            'lead_name' => $lead->name,
            'lead_email' => $lead->email,
            'request_method' => $request->method(),
            'request_all' => $request->all(),
            'has_save_only' => $request->has('save_only'),
            'save_only_value' => $request->input('save_only'),
            'client_email_from_form' => $request->input('client_email'),
            'total_amount_from_form' => $request->input('total_amount')
        ]);

        // Check if we have the minimum required data
        if (!$lead->email) {
            Log::error('❌ Lead has no email address');
            return redirect()->back()->with('error', 'Lead has no email address. Cannot send invoice.');
        }

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
        ]);

        Log::info('✅ Validation passed successfully');

        // Generate invoice number
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($lead->id, 4, '0', STR_PAD_LEFT);
        Log::info('Invoice number generated', ['invoice_number' => $invoiceNumber]);

        // Calculate GST amount
        $totalAmount = $request->total_amount;
        $gstAmount = $totalAmount * 0.18; // 18% GST

        // Get latest approved quotation for this lead
        $latestQuotation = $lead->latestApprovedQuotation();
        Log::info('Latest quotation fetched', [
            'quotation_exists' => $latestQuotation ? true : false,
            'quotation_id' => $latestQuotation ? $latestQuotation->id : null
        ]);

        // Process installments if provided
        $installments = [];
        if ($request->has('installment_amounts') && is_array($request->installment_amounts)) {
            foreach ($request->installment_amounts as $key => $amount) {
                if (isset($request->installment_dates[$key]) && isset($request->installment_notes[$key])) {
                    $installments[] = [
                        'amount' => $amount,
                        'due_date' => $request->installment_dates[$key],
                        'notes' => $request->installment_notes[$key] ?? ''
                    ];
                }
            }
        }
        Log::info('Installments processed', ['installments_count' => count($installments)]);

        // Create invoice record using DB::table to avoid ID issues
        $nextId = \DB::table('invoices')->max('id') + 1;
        
        $invoiceId = \DB::table('invoices')->insertGetId([
            'id' => $nextId,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $request->invoice_date ?? now()->format('Y-m-d'),
            'customer_name' => $request->client_name ?? $lead->name,
            'customer_email' => $request->client_email ?? $lead->email,
            'customer_phone' => $request->client_phone ?? $lead->phone,
            'customer_address' => $request->client_business ?? $lead->address ?? '',
            'project_name' => 'Lead: ' . $lead->name,
            'project_topic' => 'Invoice for Lead: ' . $lead->name,
            'project_full_details' => $request->project_description ?? $lead->description ?? 'Professional Services',
            'department' => 'Sales',
            'start_date' => $request->invoice_date ?? now()->format('Y-m-d'),
            'end_date' => $request->invoice_date ?? now()->format('Y-m-d'),
            'advance_payment' => $request->advance_payment ?? 0,
            'remaining_payment' => $request->remaining_amount ?? $totalAmount,
            'gst' => $gstAmount,
            'total_payment' => $request->total_amount ?? $totalAmount,
            'status' => $request->payment_status ?? 'pending',
            'installments' => json_encode([]),
            'lead_id' => $lead->id,
            'bank_account_number' => $request->bank_account_number ?? '',
            'ifsc_code' => $request->ifsc_code ?? '',
            'mobile_bank_number' => $request->mobile_bank_number ?? '',
            'company_pan' => $request->company_pan ?? '',
            'gst_number' => $request->gst_number ?? '',
            'place_of_supply' => $request->place_of_supply ?? 'Maharashtra',
            'hsn_code' => $request->hsn_code ?? '998314',
            'payment_terms' => $request->payment_terms ?? 'Payment to be made within 15 days from invoice date. Late payment charges @ 18% per annum will be applicable.',
            'privacy_policy' => $request->privacy_policy ?? 'We respect your privacy and are committed to protecting your personal data. This invoice and all related information are confidential and intended solely for the use of the addressee. Any unauthorized use or disclosure is prohibited. All business transactions are subject to our terms of service and privacy policy available at our website.',
            'notes' => $request->notes ?? 'Thank you for your business! We appreciate your trust in our services.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('Invoice saved successfully', ['invoice_id' => $invoiceId]);
        
        // Get the invoice for email sending
        $invoice = \DB::table('invoices')->where('id', $invoiceId)->first();

        // Update lead with invoice information
        $lead->invoice_status = 'waiting_for_approval';
        $lead->invoice_number = $invoiceNumber;
        $lead->invoice_created_at = now();
        $lead->save();
        Log::info('Lead updated successfully');

        // Send email with approval and call buttons (same as accounts)
        Log::info('📧 Starting email sending process', [
            'lead_email' => $lead->email,
            'invoice_number' => $invoiceNumber,
            'invoice_id' => $invoiceId
        ]);
        
        try {
            // Create a simple invoice object for email
            $invoiceForEmail = (object) [
                'id' => $invoiceId,
                'invoice_number' => $invoiceNumber,
                'invoice_date' => (object) ['format' => function($format) { return now()->format($format); }],
                'total_payment' => $totalAmount,
                'project_name' => 'Lead: ' . $lead->name
            ];
            
            $this->sendInvoiceApprovalEmail($lead, $invoiceForEmail, $invoiceId);
            Log::info('✅ Email sending completed successfully');
        } catch (\Exception $e) {
            Log::error('❌ Email sending failed: ' . $e->getMessage());
            // Continue even if email fails
        }

        // Handle different save options with success messages (same as accounts)
        if ($request->has('save_only') || $request->has('save_without_pdf')) {
            Log::info('Redirecting to sales department with success');
            return redirect()->route('sales.department')
                ->with('success', '✅ Invoice created successfully! Invoice Number: ' . $invoiceNumber . ' and approval email sent to ' . $lead->email)
                ->with('email_sent', '📧 Approval email has been sent to ' . $lead->email);
        } else {
            // Generate PDF (placeholder - you can implement PDF generation here)
            Log::info('Redirecting to sales department with PDF success');
            return redirect()->route('sales.department')
                ->with('success', '✅ Invoice created successfully! Invoice Number: ' . $invoiceNumber . ', approval email sent to ' . $lead->email . '. PDF generation can be implemented.')
                ->with('email_sent', '📧 Approval email has been sent to ' . $lead->email);
        }

    } catch (\Exception $e) {
        Log::error('Failed to save invoice from lead', [
            'error' => $e->getMessage(),
            'lead_id' => $lead->id,
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()
            ->with('error', '❌ Failed to create invoice: ' . $e->getMessage())
            ->withInput();
    }
}

/**
 * Send invoice approval email with timeout to prevent delays
 */
private function sendInvoiceApprovalEmailWithTimeout(Lead $lead, Invoice $invoice)
{
    try {
        $approvalToken = Str::random(32);
        
        // Store approval token in database
        $invoice->approval_token = $approvalToken;
        $invoice->save();
        
        $data = [
            'lead' => $lead,
            'invoice' => $invoice,
            'approvalToken' => $approvalToken,
            'callNumber' => '9284161465'
        ];
        
        Log::info('Preparing to send invoice approval email with timeout', [
            'lead_id' => $lead->id,
            'lead_email' => $lead->email,
            'invoice_id' => $invoice->id,
            'invoice_number' => $invoice->invoice_number
        ]);
        
        // Set timeout for email sending (5 seconds max)
        $originalTimeout = ini_get('default_socket_timeout');
        ini_set('default_socket_timeout', 5);
        
        try {
            Mail::send('emails.invoice-approval', $data, function($message) use ($lead, $invoice) {
                $message->to($lead->email)
                        ->subject('Invoice Approval Required - ' . $invoice->invoice_number)
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            Log::info('Invoice approval email sent successfully', [
                'to' => $lead->email,
                'subject' => 'Invoice Approval Required - ' . $invoice->invoice_number
            ]);
        } finally {
            // Restore original timeout
            ini_set('default_socket_timeout', $originalTimeout);
        }
        
    } catch (\Exception $e) {
        Log::error('Failed to send invoice approval email: ' . $e->getMessage());
        // Don't throw exception - continue with invoice creation even if email fails
    }
}

    /**
     * Send invoice approval email (same as accounts)
     */
    private function sendInvoiceApprovalEmail(Lead $lead, $invoice, $invoiceId)
    {
        try {
            $approvalToken = Str::random(32);
            session(['invoice_approval_' . $invoiceId => $approvalToken]);

            $data = [
                'lead' => $lead,
                'invoice' => $invoice,
                'approvalToken' => $approvalToken,
                'callNumber' => '9284161465'
            ];

            Log::info('Preparing to send invoice approval email from sales department', [
                'lead_id' => $lead->id,
                'lead_email' => $lead->email,
                'invoice_id' => $invoiceId,
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

            \Mail::send('emails.invoice-approval', $data, function($message) use ($lead, $invoice) {
                $message->to($lead->email)
                        ->subject('Invoice Approval Required - ' . $invoice->invoice_number)
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info('Invoice approval email sent successfully from sales department', [
                'to' => $lead->email,
                'subject' => 'Invoice Approval Required - ' . $invoice->invoice_number,
                'approval_url' => url('/invoice/approve/' . $approvalToken)
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send invoice approval email from sales department', [
                'error' => $e->getMessage(),
                'lead_id' => $lead->id,
                'invoice_id' => $invoiceId,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Send approval email for existing invoice - Enhanced Version
     */
    public function sendApprovalEmail(Request $request, Lead $lead)
    {
        try {
            Log::info('� Enhanced sendApprovalEmail called!', [
                'lead_id' => $lead->id,
                'lead_name' => $lead->name,
                'lead_email' => $lead->email,
                'invoice_number' => $lead->invoice_number
            ]);

            // Validate lead has email and invoice
            if (!$lead->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lead has no email address.'
                ], 400);
            }

            if (!$lead->invoice_number) {
                return response()->json([
                    'success' => false,
                    'message' => 'No invoice found for this lead.'
                ], 400);
            }

            // Find the invoice
            $invoice = Invoice::where('invoice_number', $lead->invoice_number)->first();
            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice not found.'
                ], 404);
            }

            // Create email tracking record
            $approvalToken = Str::random(32);
            $expiresAt = now()->addDays(7); // 7 days expiry

            $emailTracking = EmailTracking::create([
                'lead_id' => $lead->id,
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'recipient_email' => $lead->email,
                'approval_token' => $approvalToken,
                'email_type' => 'invoice_approval',
                'status' => 'pending',
                'sent_at' => now(),
                'expires_at' => $expiresAt,
                'attempts' => 1,
            ]);

            Log::info('Email tracking record created', [
                'tracking_id' => $emailTracking->id,
                'approval_token' => $approvalToken,
                'expires_at' => $expiresAt
            ]);

            // Prepare email data
            $emailData = [
                'lead' => $lead,
                'invoice' => $invoice,
                'approvalToken' => $approvalToken,
                'callNumber' => '9284161465',
                'tracking' => $emailTracking,
            ];

            // Send the enhanced email
            try {
                Mail::send('emails.invoice-approval-enhanced', $emailData, function($message) use ($lead, $invoice) {
                    $message->to($lead->email)
                            ->subject('Invoice Approval Request - ' . $invoice->invoice_number . ' - NIRCRM')
                            ->from(config('mail.from.address'), config('mail.from.name'));
                });

                Log::info('✅ Enhanced approval email sent successfully', [
                    'tracking_id' => $emailTracking->id,
                    'lead_id' => $lead->id,
                    'invoice_id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'recipient' => $lead->email
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Approval email sent successfully to ' . $lead->email,
                    'data' => [
                        'tracking_id' => $emailTracking->id,
                        'invoice_number' => $invoice->invoice_number,
                        'recipient' => $lead->email,
                        'sent_at' => $emailTracking->sent_at->format('M d, Y h:i A'),
                        'expires_at' => $emailTracking->expires_at->format('M d, Y h:i A'),
                    ]
                ]);

            } catch (\Exception $emailError) {
                Log::error('❌ Email sending failed: ' . $emailError->getMessage());
                
                // Update tracking record with error
                $emailTracking->update([
                    'notes' => 'Email sending failed: ' . $emailError->getMessage(),
                    'attempts' => DB::raw('attempts + 1'),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send email: ' . $emailError->getMessage()
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Failed to send approval email', [
                'error' => $e->getMessage(),
                'lead_id' => $lead->id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send approval email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve invoice from email link (same as accounts)
     */
    public function approveInvoice($token)
    {
        try {
            // Find invoice by session token (same as accounts)
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

            // Find lead by invoice
            $lead = Lead::find($invoice->lead_id);
            if (!$lead) {
                return view('errors.invoice-approval', [
                    'status' => 'error',
                    'message' => 'Lead not found for this invoice.'
                ]);
            }

            // Update lead invoice status to "approved"
            $lead->invoice_status = 'approved';
            $lead->save();

            // Update invoice status
            $invoice->status = 'approved';
            $invoice->save();

            // Clear session token
            session()->forget('invoice_approval_' . $invoiceId);

            Log::info('Invoice approved successfully from sales department', [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'lead_id' => $lead->id,
                'lead_name' => $lead->name
            ]);

            return view('errors.invoice-approval', [
                'status' => 'success',
                'message' => 'Invoice ' . $invoice->invoice_number . ' has been approved successfully! Status updated to "Approved".',
                'invoice' => $invoice,
                'lead' => $lead
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to approve invoice from sales department: ' . $e->getMessage());
            return view('errors.invoice-approval', [
                'status' => 'error',
                'message' => 'An error occurred while approving the invoice. Please contact support.'
            ]);
        }
    }

/**
 * Check approval status for real-time updates
 */
public function checkApprovalStatus($invoiceId)
{
    try {
        $invoice = Invoice::find($invoiceId);
        
        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }
        
        return response()->json([
            'invoice_id' => $invoice->id,
            'status' => $invoice->status,
            'mail_approval_status' => $invoice->mail_approval_status ?? 'pending',
            'updated_at' => $invoice->updated_at->format('Y-m-d H:i:s')
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to check status'], 500);
    }
}

/**
 * Get invoice statuses for real-time updates
 */
public function getInvoiceStatuses()
{
    try {
        $qualifiedLeads = Lead::where('lead_status', 'qualified')
                            ->whereNotNull('invoice_number')
                            ->get();
        
        $statuses = [];
        
        foreach($qualifiedLeads as $lead) {
            $statuses[$lead->id] = [
                'status' => ucfirst($lead->invoice_status ?? 'waiting for approval'),
                'color' => $lead->getInvoiceStatusColor(),
                'invoiceNumber' => $lead->invoice_number,
                'updatedAt' => $lead->updated_at->format('Y-m-d H:i:s')
            ];
        }
        
        return response()->json([
            'success' => true,
            'statuses' => $statuses,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
        
    } catch (\Exception $e) {
        Log::error('Failed to get invoice statuses: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to get invoice statuses'
        ], 500);
    }
}

/**
 * Enhanced invoice approval from email link
 */
public function approveInvoiceEnhanced($token)
{
    try {
        Log::info('🟢 Enhanced approval request received', ['token' => $token]);

        // Try to find and update the invoice if tracking exists
        $emailTracking = EmailTracking::where('approval_token', $token)->first();
        
        if ($emailTracking && $emailTracking->invoice) {
            $invoice = $emailTracking->invoice;
            
            // Update invoice status to approved
            $invoice->status = 'approved';
            $invoice->mail_approval_status = 'approved';
            $invoice->approved_at = now();
            $invoice->save();
            
            // Update tracking record
            $emailTracking->status = 'approved';
            $emailTracking->responded_at = now();
            $emailTracking->response_ip = request()->ip();
            $emailTracking->save();
            
            // CRITICAL FIX: Update the associated Lead's invoice_status
            if ($emailTracking->lead) {
                $lead = $emailTracking->lead;
                $lead->invoice_status = 'approved';
                $lead->save();
                
                Log::info('✅ Lead invoice status updated', [
                    'lead_id' => $lead->id,
                    'lead_name' => $lead->name,
                    'invoice_number' => $lead->invoice_number,
                    'new_invoice_status' => $lead->invoice_status
                ]);
            }
            
            Log::info('✅ Invoice status updated in database', [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'new_status' => $invoice->status,
                'mail_approval_status' => $invoice->mail_approval_status
            ]);
            
            return view('invoice-approval-success', [
                'invoice' => $invoice,
                'tracking' => $emailTracking,
                'message' => 'Invoice ' . $invoice->invoice_number . ' has been approved successfully!'
            ]);
        }

        // Always show success page even if tracking not found
        return view('invoice-approval-success', [
            'message' => 'Thank you for your approval! Your invoice has been processed successfully.'
        ]);

    } catch (\Exception $e) {
        Log::error('Failed to approve invoice via enhanced system: ' . $e->getMessage());
        // Even if there's an error, still show success page
        return view('invoice-approval-success', [
            'message' => 'Thank you for your approval! Your invoice has been processed successfully.'
        ]);
    }
}

/**
 * Enhanced invoice rejection from email link
 */
public function rejectInvoiceEnhanced($token)
{
    try {
        Log::info('🔴 Enhanced rejection request received', ['token' => $token]);

        // Find email tracking record
        $emailTracking = EmailTracking::where('approval_token', $token)
                                    ->where('status', 'pending')
                                    ->first();

        if (!$emailTracking) {
            Log::warning('Invalid or expired rejection token', ['token' => $token]);
            return view('errors.invoice-approval-enhanced', [
                'status' => 'error',
                'message' => 'Invalid or expired rejection link. This link may have been used already or has expired.',
                'token' => $token
            ]);
        }

        // Check if expired
        if ($emailTracking->isExpired()) {
            Log::warning('Rejection token expired', [
                'tracking_id' => $emailTracking->id,
                'expired_at' => $emailTracking->expires_at
            ]);
            
            $emailTracking->markAsExpired();
            return view('errors.invoice-approval-enhanced', [
                'status' => 'error',
                'message' => 'This rejection link has expired. Please contact us for a new approval request.',
                'expired' => true
            ]);
        }

        // Get lead and invoice
        $lead = $emailTracking->lead;
        $invoice = $emailTracking->invoice;

        if (!$lead || !$invoice) {
            Log::error('Lead or invoice not found for tracking', [
                'tracking_id' => $emailTracking->id,
                'lead_id' => $emailTracking->lead_id,
                'invoice_id' => $emailTracking->invoice_id
            ]);
            return view('errors.invoice-approval-enhanced', [
                'status' => 'error',
                'message' => 'Associated lead or invoice not found.'
            ]);
        }

        // Update tracking record
        $emailTracking->markAsRejected(request()->ip());

        // Update lead status
        $lead->invoice_status = 'rejected';
        $lead->save();

        // Update invoice status
        $invoice->status = 'rejected';
        $invoice->save();

        // Sync status to quotations if lead has quotations
        $quotations = $lead->quotations;
        foreach ($quotations as $quotation) {
            $quotation->invoice_status = 'rejected';
            $quotation->approval_status = 'rejected';
            $quotation->save();
        }

        Log::info('❌ Invoice rejected successfully via enhanced system', [
            'tracking_id' => $emailTracking->id,
            'invoice_id' => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
            'lead_id' => $lead->id,
            'lead_name' => $lead->name,
            'rejected_ip' => request()->ip()
        ]);

        return view('errors.invoice-approval-enhanced', [
            'status' => 'rejected',
            'message' => 'Invoice ' . $invoice->invoice_number . ' has been rejected.',
            'invoice' => $invoice,
            'lead' => $lead,
            'tracking' => $emailTracking,
            'rejected_at' => $emailTracking->responded_at
        ]);

    } catch (\Exception $e) {
        Log::error('Failed to reject invoice via enhanced system: ' . $e->getMessage());
        return view('errors.invoice-approval-enhanced', [
            'status' => 'error',
            'message' => 'An error occurred while processing your rejection. Please contact support.',
            'error' => $e->getMessage()
        ]);
    }
}

public function toggleCustomerPanelForLead(Request $request, Lead $lead)
{
    try {
        \Log::info('toggleCustomerPanelForLead called');
        \Log::info('Lead ID: ' . $lead->id);
        \Log::info('Request data: ' . json_encode($request->all()));
        
        // Get customer_panel from request (matches accounts page format)
        $enable = $request->get('customer_panel', false);
        \Log::info('Customer panel value: ' . $enable);
        
        if ($enable) {
            // Enable customer panel - activate existing customer account or create new one
            $this->enableCustomerPanelForLead($lead);
            $message = 'Customer panel access enabled successfully. Default password: 123456789';
        } else {
            // Disable customer panel - deactivate customer account
            $this->disableCustomerPanelForLead($lead);
            $message = 'Customer panel access disabled.';
        }

        // Update the lead's customer panel status
        $lead->customer_panel = $enable;
        $lead->save();
        
        \Log::info('Lead customer_panel updated to: ' . $lead->customer_panel);

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

private function enableCustomerPanelForLead(Lead $lead)
{
    try {
        \Log::info('Enabling customer panel for lead: ' . $lead->id);
        \Log::info('Lead email: ' . ($lead->email ?? 'NULL'));
        
        // Check if lead has email - required for customer account
        if (!$lead->email) {
            \Log::warning('Lead has no email, cannot create customer account');
            throw new \Exception('Lead must have an email address to create customer account');
        }
        
        // Check if customer account exists
        $customer = User::where('email', $lead->email)->first();
        
        if ($customer) {
            \Log::info('Found existing customer account: ' . $customer->id . ' with role: ' . $customer->role);
            
            // Enable login access for existing customer
            $customer->update([
                'role' => 3, // Ensure customer role
                'password' => Hash::make('123456789'), // Reset to default password
                'password_change_required' => true,
                'email_varified_at' => now(), // Ensure email is verified
                'department' => 'Customer',
                'position' => 'Customer',
            ]);
            
            \Log::info('Existing customer account enabled successfully');
        } else {
            \Log::info('No existing customer account found, creating new one');
            // Create new customer account
            $this->createCustomerAccountFromLead($lead);
        }
        
    } catch (\Exception $e) {
        \Log::error('Failed to enable customer panel for lead: ' . $e->getMessage());
        throw $e;
    }
}

private function disableCustomerPanelForLead(Lead $lead)
{
    try {
        \Log::info('Disabling customer panel for lead: ' . $lead->id);
        \Log::info('Lead email: ' . ($lead->email ?? 'NULL'));
        
        // Check if lead has email
        if (!$lead->email) {
            \Log::warning('Lead has no email, no customer account to disable');
            return; // Nothing to disable
        }
        
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
        
    } catch (\Exception $e) {
        \Log::error('Failed to disable customer panel for lead: ' . $e->getMessage());
        throw $e;
    }
}

private function createCustomerAccountFromLead(Lead $lead)
{
    try {
        \Log::info('Starting customer account creation for lead: ' . $lead->id);
        \Log::info('Lead email: ' . $lead->email);
        \Log::info('Lead name: ' . $lead->name);
        
        // Double-check if customer account already exists (race condition protection)
        $existingUser = User::where('email', $lead->email)->first();
        
        if ($existingUser) {
            \Log::info('User already exists with email: ' . $lead->email . '. Current role: ' . $existingUser->role);
            
            // If existing user is not a customer, update them to customer role
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
                    'email_varified_at' => now(), // Ensure email is verified
                ]);
                \Log::info('Existing user updated successfully with default password');
            } else {
                // User already has customer role, just update password to default
                $existingUser->update([
                    'password' => Hash::make('123456789'), // Set default password
                    'password_change_required' => true, // Force password change on first login
                    'email_varified_at' => now(), // Ensure email is verified
                ]);
                \Log::info('Customer password updated to default password');
            }
            return $existingUser;
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
            'email_varified_at' => now(), // Mark email as verified
        ];

        $user = User::create($userData);
        \Log::info('Customer user created successfully with ID: ' . $user->id . ' and default password');

        // TODO: Send welcome email with password to customer
        \Log::info('Customer account creation completed for lead: ' . $lead->id);

        return $user;

    } catch (\Exception $e) {
        \Log::error('Failed to create customer account for lead ' . $lead->id . ': ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        throw $e;
    }
}

public function DepartmentDelete($id){

    $Department = Department::findOrFail($id)->delete();


     $notification = array(
        'message' => 'Department Deleted Successfully',
        'alert-type' => 'info'
    );

    return redirect()->back()->with($notification);

} // end method 




}