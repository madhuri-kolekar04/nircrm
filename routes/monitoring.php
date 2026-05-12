<?php

// Monitoring routes for production server
use Illuminate\Support\Facades\Route;

Route::prefix('monitoring')->middleware(['throttle:60,1'])->group(function () {
    
    // System status endpoint
    Route::get('/status', function () {
        try {
            $scheduledCount = \App\Models\LeadReaction::where('notification_sent', false)
                ->where('next_follow_up', '>=', now()->format('Y-m-d'))
                ->count();
                
            $sentTodayCount = \App\Models\LeadReaction::where('notification_sent', true)
                ->whereDate('notification_sent_at', today())
                ->count();
                
            $overdueCount = \App\Models\LeadReaction::where('notification_sent', false)
                ->where('next_follow_up', '<', now()->format('Y-m-d'))
                ->count();
                
            $lastRun = \Cache::get('notification_last_run', 'Never');
            
            return response()->json([
                'status' => 'healthy',
                'timestamp' => now()->toISOString(),
                'statistics' => [
                    'scheduled' => $scheduledCount,
                    'sent_today' => $sentTodayCount,
                    'overdue' => $overdueCount
                ],
                'system' => [
                    'last_run' => $lastRun,
                    'php_version' => PHP_VERSION,
                    'laravel_version' => app()->version(),
                    'timezone' => config('app.timezone'),
                    'server_time' => now()->format('Y-m-d H:i:s')
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 500);
        }
    });
    
    // Test email endpoint (for debugging)
    Route::get('/test-email', function () {
        try {
            $testReaction = \App\Models\LeadReaction::with('lead')
                ->where('notification_sent', false)
                ->first();
                
            if (!$testReaction) {
                return response()->json([
                    'message' => 'No pending reactions found for testing'
                ]);
            }
            
            // Send test email
            \Illuminate\Support\Facades\Mail::to($testReaction->lead->email)
                ->send(new \App\Mail\ReactionNotificationMail([
                    'lead_name' => $testReaction->lead->name,
                    'lead_email' => $testReaction->lead->email,
                    'reaction_type' => $testReaction->reaction_type,
                    'reaction_emoji' => $testReaction->getReactionEmoji(),
                    'follow_up_date' => $testReaction->next_follow_up,
                    'follow_up_time' => $testReaction->reaction_time,
                    'created_by' => 'System Test',
                    'is_overdue' => false
                ]));
                
            return response()->json([
                'message' => 'Test email sent successfully',
                'sent_to' => $testReaction->lead->email,
                'lead_name' => $testReaction->lead->name
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    // Recent notifications log
    Route::get('/recent-notifications', function () {
        $recentNotifications = \App\Models\LeadReaction::with(['lead', 'user'])
            ->where('notification_sent', true)
            ->orderBy('notification_sent_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'lead_name' => $notification->lead->name,
                    'lead_email' => $notification->lead->email,
                    'reaction_type' => $notification->reaction_type,
                    'sent_at' => $notification->notification_sent_at->toISOString(),
                    'created_by' => $notification->user ? $notification->user->name : 'System'
                ];
            });
            
        return response()->json($recentNotifications);
    });
});
