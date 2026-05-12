<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OffTimeLoginNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $loginTime;
    public $shift;
    public $recipientRole;

    public function __construct($user, $loginTime, $shift, $recipientRole)
    {
        $this->user = $user;
        $this->loginTime = $loginTime;
        $this->shift = $shift;
        $this->recipientRole = $recipientRole;
    }

    public function build()
    {
        $subject = "Off-Time Login Alert - {$this->user->name} - NIRCRM";
        
        return $this->subject($subject)
                    ->view('emails.off_time_login')
                    ->with([
                        'user' => $this->user,
                        'loginTime' => $this->loginTime,
                        'shift' => $this->shift,
                        'recipientRole' => $this->recipientRole
                    ]);
    }
}
