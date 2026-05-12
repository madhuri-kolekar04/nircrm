<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lead;
use App\Models\LeadReaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendFollowUpEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leads:send-follow-up-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automatic follow-up emails to assigned users and general managers based on reaction time and follow-up date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting follow-up email sending process...');
        
        $now = Carbon::now();
        $currentTime = $now->format('H:i');
        $currentDate = $now->format('Y-m-d');
        
        $this->info("Current time: {$currentTime}, Current date: {$currentDate}");
        
        // Get all reactions that have follow-up dates and times
        $reactions = LeadReaction::with(['lead', 'lead.assignedUser', 'user'])
            ->whereNotNull('next_follow_up')
            ->whereNotNull('reaction_time')
            ->where('next_follow_up', '<=', $currentDate)
            ->where('email_sent', false)
            ->get();
            
        $this->info("Found {$reactions->count()} reactions to process");
        
        $emailsSent = 0;
        
        foreach ($reactions as $reaction) {
            $followUpDate = Carbon::parse($reaction->next_follow_up);
            $reactionTime = Carbon::parse($reaction->reaction_time);
            
            // Check if it's time to send the email (within 15 minutes window)
            if ($this->shouldSendEmail($followUpDate, $reactionTime, $now)) {
                $this->info("Processing reaction ID: {$reaction->id} for lead: {$reaction->lead->name}");
                
                // Send email to assigned user
                if ($reaction->lead->assigned_to && $reaction->lead->assignedUser) {
                    $this->sendFollowUpEmail($reaction->lead, $reaction, $followUpDate, $reactionTime, $reaction->lead->assignedUser, 'Assigned User');
                    $emailsSent++;
                }
                
                // Send emails to all General Managers (role = 5)
                $generalManagers = User::where('role', 5)->get();
                foreach ($generalManagers as $gm) {
                    $this->sendFollowUpEmail($reaction->lead, $reaction, $followUpDate, $reactionTime, $gm, 'General Manager');
                    $emailsSent++;
                }
                
                // Mark as email sent to prevent duplicates
                $reaction->update(['email_sent' => true]);
                
                $this->info("Emails sent for reaction ID: {$reaction->id}");
            }
        }
        
        $this->info("Process completed. Total emails sent: {$emailsSent}");
        
        return 0;
    }
    
    /**
     * Determine if email should be sent based on date and time
     */
    private function shouldSendEmail($followUpDate, $reactionTime, $now)
    {
        // Create the full follow-up datetime
        $followUpDateTime = $followUpDate->copy()->setTimeFrom($reactionTime);
        
        // If follow-up date is today, check if reaction time is current or past
        if ($followUpDate->isToday()) {
            $timeDiff = $now->diffInMinutes($followUpDateTime, false);
            
            // Send if reaction time is within 30 minutes in the past
            // This ensures emails are sent even if slightly delayed
            return $timeDiff >= -30 && $timeDiff <= 30; // Within 30 minutes window
        }
        
        // If follow-up date is in the past, send immediately
        return $followUpDate->isPast();
    }
    
    /**
     * Send follow-up email to recipient
     */
    private function sendFollowUpEmail($lead, $reaction, $followUpDate, $reactionTime, $recipient, $recipientRole)
    {
        try {
            $data = [
                'lead' => $lead,
                'reaction' => $reaction,
                'followUpDate' => $followUpDate->format('M d, Y'),
                'followUpTime' => $reactionTime->format('g:i A'),
                'recipientName' => $recipient->name,
                'recordedBy' => $reaction->user ? $reaction->user->name : 'Unknown',
                'recipientRole' => $recipientRole,
                'isAutomatic' => true,
            ];

            Mail::send('emails.lead-followup-notification', $data, function ($message) use ($recipient, $lead, $followUpDate, $reactionTime) {
                $message->to($recipient->email, $recipient->name)
                    ->subject('📅 AUTOMATIC Follow-up Reminder: ' . $lead->name . ' - ' . $followUpDate->format('M d, Y') . ' at ' . $reactionTime->format('g:i A'))
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            Log::info('Automatic follow-up email sent to: ' . $recipient->email . ' for lead: ' . $lead->name);
            
        } catch (\Exception $e) {
            Log::error('Error sending automatic follow-up email: ' . $e->getMessage());
        }
    }
}
