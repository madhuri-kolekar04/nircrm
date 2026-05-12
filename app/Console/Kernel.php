<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Send automatic follow-up emails every minute for precise timing
        $schedule->command('leads:send-follow-up-emails')->everyMinute()->withoutOverlapping();
        
        // Send reaction notifications every minute for precise timing
        $schedule->command('reactions:send-notifications')->everyMinute()->withoutOverlapping();
        
        // Clean up old notifications weekly (Sundays at 2 AM)
        $schedule->command('reactions:cleanup-notifications')->weekly()->sundays()->at('02:00')->withoutOverlapping();
        
        // Sync Google Sheets every hour
        $schedule->command('google-sheets:sync')->hourly()->withoutOverlapping();
        
        // Automated Google Sheets sync and notifications - every 2 minutes
        $schedule->command('sync:automated auto-sync')->everyTwoMinutes()->withoutOverlapping();
        
        // Check for new entries and send notifications - every minute
        $schedule->command('sync:automated check-notifications')->everyMinute()->withoutOverlapping();
        
        // Send due date reminders daily at 9:00 AM
        $schedule->command('duedate:send-reminders')->daily()->at('09:00')->withoutOverlapping();
        
        // Check for new call recordings and send notifications - every minute
        $schedule->command('recordings:check-new')->everyMinute()->withoutOverlapping();
        
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
