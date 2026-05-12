<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LeadReaction;
use Carbon\Carbon;

class ReactionNotificationCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reactions:cleanup-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old reaction notifications and optimize database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting reaction notification cleanup...');

        // Clean up notifications older than 30 days
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        
        $oldNotifications = LeadReaction::where('notification_sent', true)
            ->where('notification_sent_at', '<', $thirtyDaysAgo)
            ->count();

        if ($oldNotifications > 0) {
            // Archive old notifications instead of deleting them
            LeadReaction::where('notification_sent', true)
                ->where('notification_sent_at', '<', $thirtyDaysAgo)
                ->update([
                    'notification_sent' => false,
                    'notification_sent_at' => null
                ]);

            $this->info("✅ Archived {$oldNotifications} old notifications");
        }

        // Reset notification flags for reactions that are too old (older than 90 days)
        $ninetyDaysAgo = Carbon::now()->subDays(90);
        
        $veryOldReactions = LeadReaction::where('reaction_date', '<', $ninetyDaysAgo)
            ->where('notification_sent', true)
            ->count();

        if ($veryOldReactions > 0) {
            LeadReaction::where('reaction_date', '<', $ninetyDaysAgo)
                ->where('notification_sent', true)
                ->update([
                    'notification_sent' => false,
                    'notification_sent_at' => null
                ]);

            $this->info("✅ Reset notification flags for {$veryOldReactions} very old reactions");
        }

        // Get statistics
        $totalReactions = LeadReaction::count();
        $sentNotifications = LeadReaction::where('notification_sent', true)->count();
        $pendingNotifications = LeadReaction::where('notification_sent', false)
            ->where('next_follow_up', '>=', now()->format('Y-m-d'))
            ->count();

        $this->info("\n=== Cleanup Summary ===");
        $this->info("Total reactions: {$totalReactions}");
        $this->info("Sent notifications: {$sentNotifications}");
        $this->info("Pending notifications: {$pendingNotifications}");
        $this->info("Cleanup completed at: " . Carbon::now()->format('Y-m-d H:i:s'));

        return Command::SUCCESS;
    }
}
