<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LeadReaction;
use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ReactionNotificationMail;

class SendReactionNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reactions:send-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automated email notifications for scheduled reactions to leads';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $startTime = now();
        $this->info('Starting reaction notification system...');
        $this->info('Server Time: ' . $startTime->format('Y-m-d H:i:s'));
        
        // Get current time in Indian timezone
        $indianTime = Carbon::now('Asia/Kolkata');
        $currentTime = $indianTime->format('H:i');
        $currentDate = $indianTime->format('Y-m-d');
        
        $this->info("Indian Time: {$currentTime} on {$currentDate}");
        
        // Log to file for monitoring
        Log::info("Reaction notification system started", [
            'timestamp' => $startTime->toISOString(),
            'indian_time' => $currentTime,
            'indian_date' => $currentDate
        ]);
        
        // Get reactions that need notifications sent at the exact current Indian time or are overdue
        $reactions = LeadReaction::with(['lead', 'user'])
            ->where('notification_sent', false)
            ->where(function($query) use ($currentDate, $currentTime) {
                // Overdue notifications (past dates) - send immediately
                $query->where('next_follow_up', '<', $currentDate)
                      // OR exact current time matching for today
                      ->orWhere(function($subQuery) use ($currentDate, $currentTime) {
                          $subQuery->where('next_follow_up', '=', $currentDate)
                                   ->where('reaction_time', '=', $currentTime);
                      });
            })
            ->get();
            
        $this->info("Found {$reactions->count()} reactions to process");
        
        $sentCount = 0;
        $errorCount = 0;
        $processedIds = [];
        
        foreach ($reactions as $reaction) {
            try {
                $this->info("Processing reaction {$reaction->id}: Date={$reaction->next_follow_up}, Time={$reaction->reaction_time}");
                
                // Check if lead has an email address
                if ($reaction->lead && $reaction->lead->email) {
                    
                    // Prepare email data
                    $isOverdue = $reaction->next_follow_up < $currentDate || 
                                ($reaction->next_follow_up == $currentDate && $reaction->reaction_time < $currentTime);
                    
                    $emailData = [
                        'lead_name' => $reaction->lead->name,
                        'lead_email' => $reaction->lead->email,
                        'lead_phone' => $reaction->lead->phone,
                        'lead_company' => $reaction->lead->company_name,
                        'reaction_type' => $reaction->reaction_type,
                        'reaction_emoji' => $reaction->getReactionEmoji(),
                        'reaction_notes' => $reaction->notes,
                        'follow_up_date' => $reaction->next_follow_up,
                        'follow_up_time' => $reaction->reaction_time,
                        'call_duration' => $reaction->formatted_call_duration,
                        'reaction_date' => $reaction->reaction_date,
                        'created_by' => $reaction->user ? $reaction->user->name : 'System',
                        'is_overdue' => $isOverdue,
                    ];
                    
                    // Send email to lead
                    Mail::to($reaction->lead->email)->send(new ReactionNotificationMail($emailData));
                    
                    // Mark notification as sent
                    $reaction->notification_sent = true;
                    $reaction->notification_sent_at = $indianTime;
                    $reaction->save();
                    
                    $status = $isOverdue ? 'OVERDUE' : 'ON TIME';
                    $this->info("✅ [{$status}] Notification sent to {$reaction->lead->email} for lead: {$reaction->lead->name}");
                    
                    // Log successful delivery
                    Log::info("Notification sent successfully", [
                        'reaction_id' => $reaction->id,
                        'lead_email' => $reaction->lead->email,
                        'lead_name' => $reaction->lead->name,
                        'scheduled_time' => $reaction->next_follow_up . ' ' . $reaction->reaction_time,
                        'sent_time' => $indianTime->toISOString(),
                        'status' => $status
                    ]);
                    
                    $sentCount++;
                    $processedIds[] = $reaction->id;
                    
                } else {
                    $this->warn("⚠️  Lead {$reaction->lead_id} has no email address");
                    Log::warning("Lead has no email address", ['lead_id' => $reaction->lead_id]);
                }
                
            } catch (\Exception $e) {
                $this->error("❌ Failed to send notification for reaction {$reaction->id}: " . $e->getMessage());
                Log::error("Failed to send notification", [
                    'reaction_id' => $reaction->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $errorCount++;
            }
        }
        
        // Also check for reactions that are overdue (time has passed but notification not sent)
        $this->info("\nChecking for overdue notifications...");
        
        $overdueReactions = LeadReaction::with(['lead', 'user'])
            ->where('next_follow_up', '<=', $currentDate)
            ->where('notification_sent', false)
            ->where(function($query) use ($currentTime) {
                $query->where('reaction_time', '<', $currentTime)
                      ->orWhereNull('reaction_time');
            })
            ->get();
            
        $this->info("Found {$overdueReactions->count()} overdue reactions");
        
        foreach ($overdueReactions as $reaction) {
            try {
                // Check if lead has an email address
                if ($reaction->lead && $reaction->lead->email) {
                    
                    // Prepare email data
                    $isOverdue = true;
                    
                    $emailData = [
                        'lead_name' => $reaction->lead->name,
                        'lead_email' => $reaction->lead->email,
                        'lead_phone' => $reaction->lead->phone,
                        'lead_company' => $reaction->lead->company_name,
                        'reaction_type' => $reaction->reaction_type,
                        'reaction_emoji' => $reaction->getReactionEmoji(),
                        'reaction_notes' => $reaction->notes,
                        'follow_up_date' => $reaction->next_follow_up,
                        'follow_up_time' => $reaction->reaction_time,
                        'call_duration' => $reaction->formatted_call_duration,
                        'reaction_date' => $reaction->reaction_date,
                        'created_by' => $reaction->user ? $reaction->user->name : 'System',
                        'is_overdue' => $isOverdue,
                    ];
                    
                    // Send email to lead
                    Mail::to($reaction->lead->email)->send(new ReactionNotificationMail($emailData));
                    
                    // Mark notification as sent
                    $reaction->notification_sent = true;
                    $reaction->notification_sent_at = $indianTime;
                    $reaction->save();
                    
                    $this->info("✅ Overdue notification sent to {$reaction->lead->email} for lead: {$reaction->lead->name}");
                    $sentCount++;
                } else {
                    $this->warn("⚠️  Lead {$reaction->lead_id} has no email address");
                    Log::warning("Lead has no email address", ['lead_id' => $reaction->lead_id]);
                }
                
            } catch (\Exception $e) {
                $this->error("❌ Failed to send overdue notification for reaction {$reaction->id}: " . $e->getMessage());
                Log::error("Failed to send overdue notification", [
                    'reaction_id' => $reaction->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $errorCount++;
            }
        }
        
        $this->info("\n=== Notification Summary ===");
        $this->info("Total notifications sent: {$sentCount}");
        $this->info("Errors encountered: {$errorCount}");
        $this->info("Process completed at: " . $indianTime->format('Y-m-d H:i:s'));
        
        // Cache last run time for monitoring
        \Cache::put('notification_last_run', $indianTime->toISOString(), 3600); // Cache for 1 hour
        
        // Log completion
        Log::info("Reaction notification system completed", [
            'sent_count' => $sentCount,
            'error_count' => $errorCount,
            'processed_ids' => $processedIds,
            'duration' => $startTime->diffInSeconds($indianTime),
            'completed_at' => $indianTime->toISOString()
        ]);
        
        return Command::SUCCESS;
    }
}
