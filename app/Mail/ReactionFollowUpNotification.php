<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReactionFollowUpNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $reaction;
    public $followUpDate;

    public function __construct($reaction, $followUpDate)
    {
        $this->reaction = $reaction;
        $this->followUpDate = $followUpDate;
    }

    public function build()
    {
        return $this->subject('Follow-up Reminder - ' . ($this->reaction->lead->name ?? 'Unknown Lead'))
                    ->view('emails.reaction-followup')
                    ->with([
                        'reaction' => $this->reaction,
                        'followUpDate' => $this->followUpDate
                    ]);
    }
}
