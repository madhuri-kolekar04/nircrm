<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Mail;
use Illuminate\Support\Facades\Auth;

class InvoiceManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display invoice management page for a quotation
     */
    public function management($quotationId)
    {
        try {
            Log::info('InvoiceManagementController: management called', ['quotation_id' => $quotationId]);
            
            $quotation = Quotation::find($quotationId);
            
            if (!$quotation) {
                Log::error('Quotation not found', ['quotation_id' => $quotationId]);
                return redirect()->route('accounts.index')
                    ->with('error', 'Quotation not found');
            }
            
            Log::info('Quotation found', ['quotation_id' => $quotation->id, 'quotation_number' => $quotation->quotation_number]);
            
            $invoices = Invoice::where('project_name', $quotation->quotation_number)
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info('Invoices loaded', ['count' => $invoices->count()]);

            return view('backend.invoices.management', compact('quotation', 'invoices'));
            
        } catch (\Exception $e) {
            Log::error('Error in invoice management: ' . $e->getMessage(), [
                'quotation_id' => $quotationId ?? 'null',
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('accounts.index')
                ->with('error', 'Failed to load invoice management: ' . $e->getMessage());
        }
    }

    /**
     * Create a new installment invoice
     */
    public function createInstallment(Quotation $quotation, $installmentLetter)
    {
        try {
            // URL decode the installment letter to handle spaces and special characters
            $installmentLetter = urldecode($installmentLetter);
            
            // Get existing invoices for this quotation
            $existingInvoices = Invoice::where('project_name', $quotation->quotation_number)
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Generate unique invoice number with installment letter
            $baseInvoiceNumber = 'INV-' . date('Y') . '-' . str_pad($quotation->id, 4, '0', STR_PAD_LEFT) . '-' . $installmentLetter;
            $counter = 1;
            
            do {
                $invoiceNumber = $baseInvoiceNumber . ($counter > 1 ? '-' . $counter : '');
                $exists = Invoice::where('invoice_number', $invoiceNumber)->exists();
                $counter++;
            } while ($exists);

            // Get the last invoice to copy bank details and other information
            $lastInvoice = $existingInvoices->first();
            
            return view('backend.invoices.create-installment', compact(
                'quotation', 
                'invoiceNumber', 
                'installmentLetter',
                'existingInvoices',
                'lastInvoice'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error in createInstallment: ' . $e->getMessage(), [
                'quotation_id' => $quotation->id,
                'installment_letter' => $installmentLetter,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Failed to load installment creation page: ' . $e->getMessage());
        }
    }

    /**
     * Save installment invoice
     */
    public function saveInstallment(Request $request, Quotation $quotation, $installmentLetter)
    {
        try {
            // URL decode the installment letter to handle spaces and special characters
            $installmentLetter = urldecode($installmentLetter);
            
            $request->validate([
                'invoice_date' => 'required|date',
                'client_name' => 'required|string|max:255',
                'client_email' => 'required|email|max:255',
                'client_phone' => 'required|string|max:20',
                'payment_status' => 'required|in:pending,partial,completed,overdue,cancelled',
                'total_amount' => 'required|numeric|min:0',
                'advance_payment' => 'nullable|numeric|min:0',
                'remaining_amount' => 'nullable|numeric|min:0',
                'installment_number' => 'required|string|max:50',
                'installment_due_date' => 'required|date',
                'payment_terms' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);

            Log::info('InvoiceController: saveInstallment called', [
                'quotation_id' => $quotation->id,
                'installment_letter' => $installmentLetter,
                'request_data' => $request->all()
            ]);

            // Generate unique invoice number with installment letter
            $baseInvoiceNumber = 'INV-' . date('Y') . '-' . str_pad($quotation->id, 4, '0', STR_PAD_LEFT) . '-' . $installmentLetter;
            $counter = 1;
            
            do {
                $invoiceNumber = $baseInvoiceNumber . ($counter > 1 ? '-' . $counter : '');
                $exists = Invoice::where('invoice_number', $invoiceNumber)->exists();
                $counter++;
            } while ($exists);

            // Create invoice record
            $invoice = new Invoice();
            $invoice->invoice_number = $invoiceNumber;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->customer_name = $request->client_name;
            $invoice->customer_email = $request->client_email;
            $invoice->customer_phone = $request->client_phone;
            $invoice->customer_address = $request->client_business ?? $quotation->client_business_name ?? '';
            $invoice->project_name = $quotation->quotation_number;
            $invoice->project_topic = 'Installment ' . $installmentLetter . ' Invoice for Quotation: ' . $quotation->quotation_number;
            $invoice->project_full_details = $request->project_full_details ?? 'Installment ' . $installmentLetter . ' payment for ' . $quotation->quotation_number;
            $invoice->department = 'Accounts';
            $invoice->start_date = $request->invoice_date;
            $invoice->end_date = $request->installment_due_date;
            $invoice->advance_payment = $request->advance_payment ?? 0;
            $invoice->remaining_payment = $request->remaining_amount ?? $request->total_amount;
            $invoice->gst = $request->gst ?? ($request->total_amount * 0.18);
            $invoice->total_payment = $request->total_amount;
            $invoice->status = $request->payment_status;
            $invoice->mail_approval_status = 'pending';
            $invoice->installments = json_encode([
                'installment_letter' => $installmentLetter,
                'installment_number' => $request->installment_number,
                'due_date' => $request->installment_due_date,
                'amount' => $request->total_amount
            ]);

            // Save additional invoice data
            $invoice->bank_account_number = $request->bank_account_number ?? '';
            $invoice->ifsc_code = $request->ifsc_code ?? '';
            $invoice->mobile_bank_number = $request->mobile_bank_number ?? '';
            $invoice->company_pan = $request->company_pan ?? '';
            $invoice->gst_number = $request->gst_number ?? '';
            $invoice->place_of_supply = $request->place_of_supply ?? 'Maharashtra';
            $invoice->hsn_code = $request->hsn_code ?? '998314';
            $invoice->payment_terms = $request->payment_terms ?? 'Payment to be made within 15 days from invoice date.';
            $invoice->privacy_policy = $request->privacy_policy ?? 'We respect your privacy and are committed to protecting your personal data.';
            $invoice->notes = $request->notes ?? 'Thank you for your business! We appreciate your trust in our services.';

            $invoice->save();

            Log::info('Installment invoice saved successfully', ['invoice_id' => $invoice->id, 'invoice_number' => $invoice->invoice_number]);

            // Update quotation invoice status
            $quotation->invoice_status = 'waiting for approval';
            $quotation->payment_status = $request->payment_status;
            $quotation->payment_updated_at = now();
            $quotation->save();

            // Send approval email
            $this->sendInstallmentApprovalEmail($quotation, $invoice, $installmentLetter);

            return redirect()->route('invoices.management', $quotation->id)
                ->with('success', '✅ Installment ' . $installmentLetter . ' Invoice created successfully! Invoice Number: ' . $invoice->invoice_number)
                ->with('email_sent', '📧 Approval email has been sent to ' . $invoice->customer_email);

        } catch (\Exception $e) {
            Log::error('Failed to save installment invoice: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', '❌ Failed to create installment invoice: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Send installment approval email
     */
    private function sendInstallmentApprovalEmail(Quotation $quotation, Invoice $invoice, $installmentLetter)
    {
        try {
            $approvalToken = Str::random(32);
            session(['invoice_approval_' . $invoice->id => $approvalToken]);
            
            // Store approval token in database for reliable validation
            $invoice->approval_token = $approvalToken;
            $invoice->save();

            $data = [
                'quotation' => $quotation,
                'invoice' => $invoice,
                'installmentLetter' => $installmentLetter,
                'approvalToken' => $approvalToken,
                'callNumber' => '9284161465'
            ];

            Mail::send('emails.installment-invoice-approval', $data, function($message) use ($quotation, $invoice, $installmentLetter) {
                $message->to($quotation->client_email)
                        ->subject('Installment ' . $installmentLetter . ' Invoice Approval Required - ' . $invoice->invoice_number)
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info('Installment invoice approval email sent', [
                'invoice_id' => $invoice->id,
                'quotation_id' => $quotation->id,
                'installment_letter' => $installmentLetter
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send installment invoice approval email', [
                'error' => $e->getMessage(),
                'quotation_id' => $quotation->id,
                'invoice_id' => $invoice->id,
                'installment_letter' => $installmentLetter,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * View invoice details
     */
    public function view(Invoice $invoice)
    {
        try {
            Log::info('InvoiceManagementController: view called', ['invoice_id' => $invoice->id]);
            
            $quotation = Quotation::where('quotation_number', $invoice->project_name)->first();
            
            if (!$quotation) {
                Log::warning('Quotation not found for invoice', ['invoice_id' => $invoice->id, 'project_name' => $invoice->project_name]);
            }
            
            Log::info('Rendering invoice view', ['invoice_id' => $invoice->id, 'quotation_id' => $quotation?->id]);
            
            return view('backend.invoices.view', compact('invoice', 'quotation'));
            
        } catch (\Exception $e) {
            Log::error('Error in invoice view: ' . $e->getMessage(), [
                'invoice_id' => $invoice->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Failed to load invoice: ' . $e->getMessage());
        }
    }

    /**
     * Delete invoice
     */
    public function delete(Invoice $invoice)
    {
        try {
            $quotation = Quotation::where('quotation_number', $invoice->project_name)->first();
            
            $invoice->delete();

            Log::info('Invoice deleted', ['invoice_id' => $invoice->id, 'invoice_number' => $invoice->invoice_number]);

            return redirect()->route('invoices.management', $quotation->id)
                ->with('success', '✅ Invoice ' . $invoice->invoice_number . ' deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to delete invoice: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', '❌ Failed to delete invoice: ' . $e->getMessage());
        }
    }

    /**
     * Get invoice statuses for real-time updates
     */
    public function getInvoiceStatuses(Request $request)
    {
        $quotationIds = $request->input('quotation_ids', []);
        
        $invoices = Invoice::whereIn('project_name', function($query) use ($quotationIds) {
            $query->select('quotation_number')
                  ->from('quotations')
                  ->whereIn('id', $quotationIds);
        })->get();

        return response()->json([
            'invoices' => $invoices->map(function($invoice) {
                return [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'project_name' => $invoice->project_name,
                    'status' => $invoice->status,
                    'total_payment' => $invoice->total_payment,
                    'created_at' => $invoice->created_at->format('Y-m-d H:i:s')
                ];
            })
        ]);
    }
    
    /**
     * Send approval email for invoice
     */
    public function sendApprovalEmail(Request $request)
    {
        try {
            Log::info('sendApprovalEmail called', $request->all());
            
            $invoiceId = $request->input('invoice_id');
            $customerEmail = $request->input('customer_email');
            $invoiceNumber = $request->input('invoice_number');
            
            Log::info('Email request data', [
                'invoice_id' => $invoiceId,
                'customer_email' => $customerEmail,
                'invoice_number' => $invoiceNumber,
                'mail_id' => $request->input('mail_id')
            ]);
            
            $invoice = Invoice::find($invoiceId);
            if (!$invoice) {
                Log::error('Invoice not found', ['invoice_id' => $invoiceId]);
                return response()->json(['success' => false, 'message' => 'Invoice not found'], 404);
            }
            
            $quotation = Quotation::where('quotation_number', $invoice->project_name)->first();
            if (!$quotation) {
                Log::error('Quotation not found', ['project_name' => $invoice->project_name]);
                return response()->json(['success' => false, 'message' => 'Quotation not found'], 404);
            }
            
            // Generate approval token and create email tracking record
            $approvalToken = Str::random(32);
            $expiresAt = now()->addDays(7); // 7 days expiry
            
            // Create email tracking record
            $emailTracking = \App\Models\EmailTracking::create([
                'lead_id' => $quotation->lead_id ?? null,
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'recipient_email' => $customerEmail,
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
            
            // Update invoice with mail ID and status first
            $invoice->mail_id = 'INV-' . strtoupper(substr(uniqid(), 0, 8));
            $invoice->status = 'pending'; // Reset to pending when approval email is sent
            $invoice->mail_approval_status = 'pending'; // Set to pending when email is sent
            $invoice->mail_sent_at = now();
            $invoice->save();
            
            Log::info('Invoice updated with mail info', [
                'mail_id' => $invoice->mail_id,
                'status' => $invoice->status
            ]);
            
            // Send approval email
            $data = [
                'quotation' => $quotation,
                'invoice' => $invoice,
                'approvalToken' => $approvalToken,
                'callNumber' => '9284161465'
            ];
            
            try {
                // Test basic email sending first
                Log::info('Attempting to send email to: ' . $customerEmail);
                
                // Simple test email
                Mail::raw('This is a test email from NIRCRM', function($message) use ($customerEmail, $invoiceNumber) {
                    $message->to($customerEmail)
                            ->subject('Test Email - ' . $invoiceNumber);
                });
                
                Log::info('Test email sent successfully');
                
                // Now send the actual approval email
                Mail::to($customerEmail)->send(new \App\Mail\InvoiceApprovalMail($data));
                Log::info('Approval email sent successfully', [
                    'invoice_id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'mail_id' => $invoice->mail_id,
                    'customer_email' => $customerEmail,
                    'tracking_id' => $emailTracking->id
                ]);
            } catch (\Exception $mailException) {
                Log::error('Failed to send email', [
                    'error' => $mailException->getMessage(),
                    'invoice_id' => $invoice->id,
                    'customer_email' => $customerEmail,
                    'tracking_id' => $emailTracking->id
                ]);
                
                // Update tracking record with error
                $emailTracking->update([
                    'notes' => 'Email sending failed: ' . $mailException->getMessage(),
                    'attempts' => \Illuminate\Support\Facades\DB::raw('attempts + 1'),
                ]);
                
                return response()->json(['success' => false, 'message' => 'Failed to send email: ' . $mailException->getMessage()], 500);
            }
            
            return response()->json([
                'success' => true, 
                'message' => 'Approval email sent successfully',
                'mail_id' => $invoice->mail_id,
                'tracking_id' => $emailTracking->id,
                'expires_at' => $emailTracking->expires_at->format('M d, Y h:i A')
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in sendApprovalEmail: ' . $e->getMessage(), [
                'invoice_id' => $request->input('invoice_id'),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['success' => false, 'message' => 'Failed to send approval email: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Test email configuration
     */
    public function testEmail()
    {
        try {
            Log::info('Testing email configuration...');
            
            // Test basic email sending
            Mail::raw('This is a test email from NIRCRM Invoice System', function($message) {
                $message->to('contact@niranjanenterprises.com')
                        ->subject('NIRCRM Email Test');
            });
            
            Log::info('Test email sent successfully to contact@niranjanenterprises.com');
            
            return response()->json([
                'success' => true, 
                'message' => 'Test email sent successfully to contact@niranjanenterprises.com'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Test email failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Test email failed: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Approve invoice from email link
     */
    public function approveInvoice($token)
    {
        try {
            Log::info('approveInvoice called with token: ' . $token);
            
            // Find invoice by approval token
            $invoiceId = null;
            foreach (session()->all() as $key => $value) {
                if (str_starts_with($key, 'invoice_approval_') && $value === $token) {
                    $invoiceId = str_replace('invoice_approval_', '', $key);
                    break;
                }
            }
            
            if (!$invoiceId) {
                Log::error('Invalid or expired approval token', ['token' => $token]);
                return view('emails.approval-error', [
                    'message' => 'Invalid or expired approval link. Please contact support.',
                    'callNumber' => '9284161465'
                ]);
            }
            
            $invoice = Invoice::find($invoiceId);
            if (!$invoice) {
                Log::error('Invoice not found for approval', ['invoice_id' => $invoiceId]);
                return view('emails.approval-error', [
                    'message' => 'Invoice not found. Please contact support.',
                    'callNumber' => '9284161465'
                ]);
            }
            
            // Update invoice status to approved
            $invoice->status = 'approved';
            $invoice->approved_at = now();
            $invoice->save();
            
            Log::info('Invoice approved successfully', [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number
            ]);
            
            // Clear the approval token from session
            session()->forget('invoice_approval_' . $invoiceId);
            
            return view('emails.approval-success', [
                'invoice' => $invoice,
                'callNumber' => '9284161465'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in approveInvoice: ' . $e->getMessage(), [
                'token' => $token,
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('emails.approval-error', [
                'message' => 'An error occurred while processing your approval. Please contact support.',
                'callNumber' => '9284161465'
            ]);
        }
    }
}
