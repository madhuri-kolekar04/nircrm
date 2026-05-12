<?php

namespace App\Mail;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $leave;
    public $recipient;
    public $applicant;

    public function __construct(Leave $leave, User $recipient)
    {
        $this->leave = $leave;
        $this->recipient = $recipient;
        $this->applicant = $leave->user;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Leave Cancelled: ' . $this->applicant->name . ' - ' . $this->leave->leaveType->name,
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.leave.cancelled',
            with: [
                'leave' => $this->leave,
                'recipient' => $this->recipient,
                'applicant' => $this->applicant,
            ]
        );
    }

    public function attachments()
    {
        return [];
    }
}
