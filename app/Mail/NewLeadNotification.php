<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewLeadNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $leadData;
    public $callingAppUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(array $leadData)
    {
        $this->leadData = $leadData;
        $this->callingAppUrl = 'https://nircrmupdate.talktonitesh.com/callingapp';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $leadName = $this->leadData['full_name'] ?? 'New Lead';
        $businessName = $this->leadData['business_name'] ?? '';
        
        $subject = "🔔 New Lead Alert: {$leadName}";
        
        if ($businessName) {
            $subject .= " from {$businessName}";
        }
        
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new-lead-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    
    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.new-lead-notification')
                    ->with([
                        'leadData' => $this->leadData,
                        'callingAppUrl' => $this->callingAppUrl
                    ]);
    }
}
