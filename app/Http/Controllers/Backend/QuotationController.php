<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\Service;
use App\Models\Lead;
use App\Models\QuotationEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;
use Dompdf\Options;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotation::with(['creator', 'lead', 'services'])
            ->latest()
            ->paginate(10);
            
        return view('backend.quotations.index', compact('quotations'));
    }

    public function create()
    {
        $services = Service::where('status', true)->get();
        $leadId = request()->get('lead_id');
        $lead = $leadId ? Lead::find($leadId) : null;
        
        return view('backend.quotations.create', compact('services', 'lead'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_business_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'client_contact_name' => 'required|string|max:255',
            'executive_summary' => 'nullable|string',
            'valid_until' => 'nullable|date',
            'terms_conditions' => 'nullable|string',
            'services' => 'nullable|array',
            'services.*.selected' => 'nullable',
            'services.*.quantity' => 'nullable|integer|min:1',
            'services.*.price' => 'nullable|numeric|min:0',
        ]);

        // Check if at least one service is selected
        $selectedServicesCount = 0;
        if ($request->services) {
            foreach ($request->services as $serviceData) {
                if (isset($serviceData['selected'])) {
                    $selectedServicesCount++;
                }
            }
        }
        
        if ($selectedServicesCount === 0) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['services' => 'Please select at least one service for the quotation.']);
        }

        // Generate quotation number
        $quotationNumber = Quotation::generateQuotationNumber();
        
        // Calculate totals
        $totalCost = 0;
        $selectedServices = [];
        
        foreach ($request->services as $serviceId => $serviceData) {
            if (isset($serviceData['selected'])) {
                $service = Service::find($serviceId);
                $quantity = $serviceData['quantity'];
                // Use custom price from form if provided, otherwise use service price
                $price = isset($serviceData['price']) ? floatval($serviceData['price']) : $service->price;
                $subtotal = $price * $quantity;
                
                $totalCost += $subtotal;
                $selectedServices[] = [
                    'service_id' => $serviceId,
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
            }
        }
        
        $gstAmount = $totalCost * 0.18;
        $finalAmount = $totalCost + $gstAmount;
        
        // Create quotation
        $quotation = Quotation::create([
            'quotation_number' => $quotationNumber,
            'client_business_name' => $request->client_business_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'client_contact_name' => $request->client_contact_name,
            'executive_summary' => $request->executive_summary ?? '',
            'total_cost' => $totalCost,
            'gst_amount' => $gstAmount,
            'final_amount' => $finalAmount,
            'valid_until' => $request->valid_until,
            'terms_conditions' => $request->terms_conditions ?? '',
            'created_by' => Auth::id(),
            'lead_id' => $request->lead_id ?? null,
        ]);
        
        // Attach services to quotation
        foreach ($selectedServices as $serviceData) {
            $quotation->services()->attach($serviceData['service_id'], [
                'price' => $serviceData['price'],
                'quantity' => $serviceData['quantity'],
                'subtotal' => $serviceData['subtotal']
            ]);
        }
        
        return redirect()->route('quotations.show', $quotation->id)
            ->with('success', 'Quotation created successfully!');
    }

    public function show(Quotation $quotation)
    {
        return view('backend.quotations.show', compact('quotation'));
    }

    public function edit(Quotation $quotation)
    {
        $services = Service::where('status', true)->get();
        return view('backend.quotations.edit', compact('quotation', 'services'));
    }

    public function update(Request $request, Quotation $quotation)
    {
        $request->validate([
            'client_business_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'client_contact_name' => 'required|string|max:255',
            'executive_summary' => 'nullable|string',
            'valid_until' => 'nullable|date',
            'terms_conditions' => 'nullable|string',
            'status' => 'required|in:draft,sent,approved,rejected',
            'services' => 'nullable|array',
            'services.*.selected' => 'nullable',
            'services.*.quantity' => 'nullable|integer|min:1',
            'services.*.price' => 'nullable|numeric|min:0',
        ]);

        // Check if at least one service is selected
        $selectedServicesCount = 0;
        if ($request->services) {
            foreach ($request->services as $serviceData) {
                if (isset($serviceData['selected'])) {
                    $selectedServicesCount++;
                }
            }
        }
        
        if ($selectedServicesCount === 0) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['services' => 'Please select at least one service for the quotation.']);
        }

        // Calculate totals
        $totalCost = 0;
        $selectedServices = [];
        
        foreach ($request->services as $serviceId => $serviceData) {
            if (isset($serviceData['selected'])) {
                $service = Service::find($serviceId);
                $quantity = $serviceData['quantity'];
                // Use custom price from form if provided, otherwise use service price
                $price = isset($serviceData['price']) ? floatval($serviceData['price']) : $service->price;
                $subtotal = $price * $quantity;
                
                $totalCost += $subtotal;
                $selectedServices[] = [
                    'service_id' => $serviceId,
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
            }
        }
        
        $gstAmount = $totalCost * 0.18;
        $finalAmount = $totalCost + $gstAmount;
        
        // Update quotation
        $quotation->update([
            'client_business_name' => $request->client_business_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'client_contact_name' => $request->client_contact_name,
            'executive_summary' => $request->executive_summary ?? '',
            'total_cost' => $totalCost,
            'gst_amount' => $gstAmount,
            'final_amount' => $finalAmount,
            'valid_until' => $request->valid_until,
            'terms_conditions' => $request->terms_conditions ?? '',
            'status' => $request->status,
        ]);
        
        // Sync services to quotation
        $syncData = [];
        foreach ($selectedServices as $serviceData) {
            $syncData[$serviceData['service_id']] = [
                'price' => $serviceData['price'],
                'quantity' => $serviceData['quantity'],
                'subtotal' => $serviceData['subtotal']
            ];
        }
        $quotation->services()->sync($syncData);
        
        return redirect()->route('quotations.show', $quotation->id)
            ->with('success', 'Quotation updated successfully!');
    }

    public function destroy(Quotation $quotation)
    {
        $quotation->delete();
        return redirect()->route('quotations.index')->with('success', 'Quotation deleted successfully!');
    }

    public function sendEmail(Quotation $quotation)
    {
        try {
            \Log::info('Attempting to send quotation email', ['quotation_id' => $quotation->id, 'email' => $quotation->client_email]);
            
            // Generate PDF
            $pdf = $this->generatePDF($quotation);
            \Log::info('PDF generated successfully');
            
            // Generate approval token only
            $approveToken = $this->generateApprovalToken($quotation);
            \Log::info('Approval token generated');
            
            // Reset approval status to waiting when resending
            $quotation->update(['approval_status' => 'waiting']);
            \Log::info('Quotation status updated to waiting');
            
            // Send email
            $data = [
                'quotation' => $quotation,
                'subject' => 'Business Proposal: ' . $quotation->quotation_number . ' - ' . $quotation->client_business_name,
                'approveToken' => $approveToken,
            ];
            
            \Log::info('Preparing to send email', ['to' => $quotation->client_email, 'subject' => $data['subject']]);
            
            Mail::send('emails.quotation_simple', $data, function($message) use ($quotation, $pdf) {
                $message->to($quotation->client_email, $quotation->client_contact_name)
                        ->subject('Business Proposal: ' . $quotation->quotation_number . ' - ' . $quotation->client_business_name)
                        ->attachData($pdf->output(), 'quotation-' . $quotation->quotation_number . '.pdf', [
                            'mime' => 'application/pdf',
                        ]);
            });
            
            \Log::info('Email sent successfully');
            
            // Track email send
            QuotationEmail::create([
                'quotation_id' => $quotation->id,
                'sent_by' => Auth::id(),
                'recipient_email' => $quotation->client_email,
                'recipient_name' => $quotation->client_contact_name,
                'subject' => 'Business Proposal: ' . $quotation->quotation_number . ' - ' . $quotation->client_business_name,
                'message' => 'Business proposal with PDF attachment and approval link',
                'has_attachment' => true,
                'attachment_path' => 'quotation-' . $quotation->quotation_number . '.pdf',
                'status' => 'sent',
                'sent_at' => now(),
            ]);
            
            // Update quotation status
            $quotation->update(['status' => 'sent']);
            
            return redirect()->route('quotations.show', $quotation->id)
                ->with('success', 'Quotation sent successfully to ' . $quotation->client_email);
                
        } catch (\Exception $e) {
            \Log::error('Failed to send quotation email', [
                'quotation_id' => $quotation->id,
                'email' => $quotation->client_email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Track failed email
            QuotationEmail::create([
                'quotation_id' => $quotation->id,
                'sent_by' => Auth::id() ?? 1, // Default to user ID 1 if not authenticated
                'recipient_email' => $quotation->client_email,
                'recipient_name' => $quotation->client_contact_name,
                'subject' => 'Business Proposal: ' . $quotation->quotation_number . ' - ' . $quotation->client_business_name,
                'message' => 'Business proposal with PDF attachment and approval link',
                'has_attachment' => true,
                'attachment_path' => 'quotation-' . $quotation->quotation_number . '.pdf',
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'sent_at' => now(),
            ]);
            
            return redirect()->route('quotations.show', $quotation->id)
                ->with('error', 'Failed to send quotation: ' . $e->getMessage());
        }
    }

    public function downloadPDF(Quotation $quotation)
    {
        $pdf = $this->generatePDF($quotation);
        
        return $pdf->stream('quotation-' . $quotation->quotation_number . '.pdf');
    }

    public function getEmailHistory(Quotation $quotation)
    {
        $emails = $quotation->emails()->with('sender')->get()->map(function ($email) {
            return [
                'id' => $email->id,
                'sender_name' => $email->sender->name,
                'sender_email' => $email->sender->email,
                'recipient_name' => $email->recipient_name,
                'recipient_email' => $email->recipient_email,
                'subject' => $email->subject,
                'message' => $email->message,
                'has_attachment' => $email->has_attachment,
                'attachment_path' => $email->attachment_path,
                'status' => $email->status,
                'status_color' => $email->status_color,
                'status_icon' => $email->status_icon,
                'formatted_sent_at' => $email->formatted_sent_at,
                'time_ago' => $email->sent_at->diffForHumans(),
                'error_message' => $email->error_message,
            ];
        });

        return response()->json([
            'quotation' => [
                'id' => $quotation->id,
                'quotation_number' => $quotation->quotation_number,
                'client_business_name' => $quotation->client_business_name,
            ],
            'emails' => $emails,
        ]);
    }

    public function generatePDF(Quotation $quotation)
    {
        // Configure DOMPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        
        // Instantiate DOMPDF
        $dompdf = new Dompdf($options);
        
        // Load HTML content
        $html = View::make('backend.quotations.pdf', compact('quotation'))->render();
        $dompdf->loadHtml($html);
        
        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        
        // Render the HTML as PDF
        $dompdf->render();
        
        return $dompdf;
    }

    public function approveQuotation($token)
    {
        try {
            // Decode token to get quotation ID and email
            $decoded = base64_decode($token);
            $data = json_decode($decoded, true);
            
            if (!$data || !isset($data['quotation_id']) || !isset($data['email'])) {
                return view('backend.quotations.approval-error', [
                    'error' => 'Invalid approval link.',
                    'message' => 'The approval link you clicked is not valid or has expired.'
                ]);
            }
            
            $quotation = Quotation::findOrFail($data['quotation_id']);
            
            // Verify email matches
            if ($quotation->client_email !== $data['email']) {
                return view('backend.quotations.approval-error', [
                    'error' => 'Unauthorized approval attempt.',
                    'message' => 'You are not authorized to approve this quotation.'
                ]);
            }
            
            // Check if already approved/rejected
            if ($quotation->approval_status !== 'waiting') {
                return view('backend.quotations.approval-error', [
                    'error' => 'Already processed.',
                    'message' => 'This quotation has already been ' . $quotation->approval_status . '.'
                ]);
            }
            
            // Approve the quotation
            $quotation->approve('Approved via email link');
            
            // Update lead status to qualified if quotation is linked to a lead
            if ($quotation->lead_id) {
                $lead = Lead::find($quotation->lead_id);
                if ($lead) {
                    $lead->update(['lead_status' => 'qualified']);
                }
            }
            
            // Show thank you page
            return view('backend.quotations.approval-thank-you', compact('quotation'));
            
        } catch (\Exception $e) {
            return view('backend.quotations.approval-error', [
                'error' => 'Error approving quotation.',
                'message' => 'An error occurred while processing your approval: ' . $e->getMessage()
            ]);
        }
    }

    public function rejectQuotation($token)
    {
        try {
            // Decode token to get quotation ID and email
            $decoded = base64_decode($token);
            $data = json_decode($decoded, true);
            
            if (!$data || !isset($data['quotation_id']) || !isset($data['email'])) {
                return redirect()->route('home')->with('error', 'Invalid rejection link.');
            }
            
            $quotation = Quotation::findOrFail($data['quotation_id']);
            
            // Verify email matches
            if ($quotation->client_email !== $data['email']) {
                return redirect()->route('home')->with('error', 'Unauthorized rejection attempt.');
            }
            
            // Check if already approved/rejected
            if ($quotation->approval_status !== 'waiting') {
                return redirect()->route('home')->with('info', 'This quotation has already been ' . $quotation->approval_status . '.');
            }
            
            // Reject the quotation
            $quotation->reject('Rejected via email link');
            
            return redirect()->route('home')->with('success', 'Quotation ' . $quotation->quotation_number . ' has been rejected.');
            
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error rejecting quotation: ' . $e->getMessage());
        }
    }

    private function generateApprovalToken($quotation)
    {
        $data = [
            'quotation_id' => $quotation->id,
            'email' => $quotation->client_email,
            'timestamp' => now()->timestamp,
        ];
        
        return base64_encode(json_encode($data));
    }
}
