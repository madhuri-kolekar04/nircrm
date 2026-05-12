<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReactionCreatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $reaction;

    public function __construct($reaction)
    {
        $this->reaction = $reaction;
    }

    public function build()
    {
        return $this->subject('New Reaction Recorded - ' . ($this->reaction->lead->name ?? 'Unknown Lead'))
                    ->view('emails.reaction-created')
                    ->with(['reaction' => $this->reaction]);
    }
}
