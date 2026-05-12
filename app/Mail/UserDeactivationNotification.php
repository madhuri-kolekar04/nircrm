<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDeactivationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $targetUser;
    public $adminUser;

    public function __construct($targetUser, $adminUser)
    {
        $this->targetUser = $targetUser;
        $this->adminUser = $adminUser;
    }

    public function build()
    {
        return $this->subject('Account Deactivated - NIRCRM')
                    ->view('emails.user_deactivation')
                    ->with([
                        'targetUser' => $this->targetUser,
                        'adminUser' => $this->adminUser
                    ]);
    }
}
