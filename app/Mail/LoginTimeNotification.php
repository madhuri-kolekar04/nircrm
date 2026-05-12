<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginTimeNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $loginTime;
    public $shiftTime;
    public $loginType;
    public $recipientRole;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $loginTime
     * @param $shiftTime
     * @param $loginType
     * @param $recipientRole
     */
    public function __construct($user, $loginTime, $shiftTime, $loginType, $recipientRole)
    {
        $this->user = $user;
        $this->loginTime = $loginTime;
        $this->shiftTime = $shiftTime;
        $this->loginType = $loginType; // 'late' or 'early'
        $this->recipientRole = $recipientRole;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = '';
        $icon = '';
        
        if ($this->loginType === 'late') {
            $subject = 'Late Login Alert - ' . $this->user->name;
            $icon = '⏰';
        } else {
            $subject = 'Early Login Alert - ' . $this->user->name;
            $icon = '🌅';
        }

        return $this->subject($subject)
                    ->view('emails.login-time-notification')
                    ->with([
                        'user' => $this->user,
                        'loginTime' => $this->loginTime,
                        'shiftTime' => $this->shiftTime,
                        'loginType' => $this->loginType,
                        'recipientRole' => $this->recipientRole,
                        'icon' => $icon
                    ]);
    }
}
