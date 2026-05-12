<?php

namespace App\Mail;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveApprovalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $leave;
    public $approver;
    public $applicant;

    public function __construct(Leave $leave, User $approver)
    {
        $this->leave = $leave;
        $this->approver = $approver;
        $this->applicant = $leave->user;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Leave Application Approved: ' . $this->leave->leaveType->name,
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.leave.approval-notification',
            with: [
                'leave' => $this->leave,
                'approver' => $this->approver,
                'applicant' => $this->applicant,
            ]
        );
    }

    public function attachments()
    {
        return [];
    }
}
