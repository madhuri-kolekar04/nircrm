<?php

namespace App\Mail;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $leave;

    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Leave Request Rejected - ' . $this->leave->user->full_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.leave.rejected',
            with: [
                'leave' => $this->leave,
                'user' => $this->leave->user,
                'leaveType' => $this->leave->leaveType,
                'approver' => $this->leave->approver,
            ]
        );
    }
}
