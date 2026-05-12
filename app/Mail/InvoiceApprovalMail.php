<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $quotation;
    public $invoice;
    public $approvalToken;
    public $callNumber;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->quotation = $data['quotation'];
        $this->invoice = $data['invoice'];
        $this->approvalToken = $data['approvalToken'];
        $this->callNumber = $data['callNumber'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Approval Required - ' . $this->invoice->invoice_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice-approval-new',
            with: [
                'quotation' => $this->quotation,
                'invoice' => $this->invoice,
                'approvalToken' => $this->approvalToken,
                'callNumber' => $this->callNumber
            ]
        );
    }
}
