<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SendInvoiceApprovalEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $lead;
    protected $invoice;

    /**
     * Create a new job instance.
     *
     * @param Lead $lead
     * @param Invoice $invoice
     */
    public function __construct(Lead $lead, Invoice $invoice)
    {
        $this->lead = $lead;
        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $approvalToken = Str::random(32);
            
            // Store approval token in database
            $this->invoice->approval_token = $approvalToken;
            $this->invoice->save();
            
            $data = [
                'lead' => $this->lead,
                'invoice' => $this->invoice,
                'approvalToken' => $approvalToken,
                'callNumber' => '9284161465'
            ];
            
            Log::info('Sending invoice approval email from queue job', [
                'lead_id' => $this->lead->id,
                'lead_email' => $this->lead->email,
                'invoice_id' => $this->invoice->id,
                'invoice_number' => $this->invoice->invoice_number
            ]);
            
            Mail::send('emails.invoice-approval', $data, function($message) {
                $message->to($this->lead->email)
                        ->subject('Invoice Approval Required - ' . $this->invoice->invoice_number)
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            Log::info('Invoice approval email sent successfully from queue', [
                'to' => $this->lead->email,
                'subject' => 'Invoice Approval Required - ' . $this->invoice->invoice_number
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send invoice approval email from queue: ' . $e->getMessage(), [
                'lead_id' => $this->lead->id,
                'invoice_id' => $this->invoice->id,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
