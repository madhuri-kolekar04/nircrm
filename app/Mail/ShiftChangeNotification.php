<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShiftChangeNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $shift;
    public $oldShiftData;
    public $action;

    public function __construct($shift, $oldShiftData = null, $action = 'updated')
    {
        $this->shift = $shift;
        $this->oldShiftData = $oldShiftData;
        $this->action = $action;
    }

    public function build()
    {
        $subject = match($this->action) {
            'assigned' => 'New Shift Assignment - NIRCRM',
            'updated' => 'Shift Schedule Updated - NIRCRM',
            default => 'Shift Change Notification - NIRCRM'
        };

        return $this->subject($subject)
                    ->view('emails.shift_change')
                    ->with([
                        'shift' => $this->shift,
                        'oldShiftData' => $this->oldShiftData,
                        'action' => $this->action
                    ]);
    }
}
