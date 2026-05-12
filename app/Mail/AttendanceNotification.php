<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Attendance;

class AttendanceNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $attendance;
    public $notificationType;
    public $user;
    public $manager;

    /**
     * Create a new message instance.
     */
    public function __construct(Attendance $attendance, string $notificationType)
    {
        $this->attendance = $attendance;
        $this->notificationType = $notificationType;
        $this->user = $attendance->user;
        $this->manager = $attendance->user->manager;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->notificationType) {
            'late_check_in' => 'Late Check-In Alert - ' . $this->user->name,
            'early_checkout' => 'Early Checkout Alert - ' . $this->user->name,
            'marked_by_admin' => 'Attendance Marked - ' . $this->user->name,
            'absent' => 'Absent Notification - ' . $this->user->name,
            'daily_summary' => 'Daily Attendance Summary',
            default => 'Attendance Notification'
        };

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
            view: 'emails.attendance.notification',
            with: [
                'attendance' => $this->attendance,
                'notificationType' => $this->notificationType,
                'user' => $this->user,
                'manager' => $this->manager,
            ]
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
}
