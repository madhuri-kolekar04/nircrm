<?php

namespace App\Console\Commands;

use App\Services\GoogleSheetsApiService;
use App\Jobs\GoogleSheetsSyncJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncGoogleSheets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google-sheets:sync {--force : Force sync even if recently synced} {--type=incremental : Sync type (full|incremental)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync leads from Google Sheets with automatic time-based fetching';

    /**
     * Execute the console command.
     */
    public function handle(GoogleSheetsApiService $googleSheetsService)
    {
        $this->info('Starting Google Sheets sync...');
        $syncType = $this->option('type');
        $forceSync = $this->option('force');

        try {
            // Check if auto-sync is enabled
            if (!config('google-sheets.auto_sync.enabled') && !$forceSync) {
                $this->info('Auto-sync is disabled. Use --force to override.');
                return 0;
            }

            // Test connection first
            $connectionTest = $googleSheetsService->testConnection();
            $hasValidConnection = false;

            if (isset($connectionTest['oauth']['success']) && $connectionTest['oauth']['success']) {
                $this->info('OAuth connection successful! Spreadsheet: ' . $connectionTest['oauth']['spreadsheet_name']);
                $hasValidConnection = true;
            }

            if (isset($connectionTest['api_key']['success']) && $connectionTest['api_key']['success']) {
                $this->info('API Key connection successful! Spreadsheet: ' . $connectionTest['api_key']['spreadsheet_name']);
                $hasValidConnection = true;
            }

            if (!$hasValidConnection) {
                $this->error('No valid connection available. Please check your API credentials.');
                return 1;
            }

            // Get metadata
            $metadata = $googleSheetsService->getSpreadsheetMetadata();
            $this->info('Spreadsheet: ' . $metadata['title']);
            $this->info('Sheets: ' . implode(', ', array_column($metadata['sheets'], 'title')));
            $this->info('Timezone: ' . $metadata['time_zone']);

            // Check if recently synced (unless forced)
            if (!$forceSync) {
                $lastSync = $googleSheetsService->getLastSyncTimestamp();
                if ($lastSync) {
                    $lastSyncTime = \Carbon\Carbon::parse($lastSync);
                    $minutesSinceSync = $lastSyncTime->diffInMinutes(now());
                    
                    $this->info('Last sync: ' . $lastSyncTime->diffForHumans());
                    
                    // Check minimum interval based on sync frequency
                    $frequency = config('google-sheets.auto_sync.frequency', 'hourly');
                    $minInterval = $frequency === 'hourly' ? 30 : ($frequency === 'daily' ? 120 : 480); // 30min, 2hr, 8hr
                    
                    if ($minutesSinceSync < $minInterval) {
                        $this->info("Sync was performed recently ({$minutesSinceSync} minutes ago). Minimum interval for {$frequency} sync is {$minInterval} minutes. Use --force to override.");
                        return 0;
                    }
                }
            }

            // Dispatch the sync job
            $this->info("Dispatching {$syncType} sync job...");
            GoogleSheetsSyncJob::dispatch($syncType, $forceSync);

            $this->info('Google Sheets sync job has been dispatched successfully!');
            
            // Show next sync time
            $frequency = config('google-sheets.auto_sync.frequency', 'hourly');
            $nextSync = $this->calculateNextSyncTime($frequency);
            $this->info('Next scheduled sync: ' . $nextSync->format('Y-m-d H:i:s'));
            
            return 0;

        } catch (\Exception $e) {
            $this->error('Sync failed: ' . $e->getMessage());
            Log::error('Google Sheets sync command failed: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Calculate next sync time based on frequency
     */
    private function calculateNextSyncTime($frequency)
    {
        $timezone = config('google-sheets.auto_sync.timezone', 'UTC');
        $timeOfDay = config('google-sheets.auto_sync.time_of_day', '02:00');
        
        switch ($frequency) {
            case 'hourly':
                return now($timezone)->addHour();
                
            case 'daily':
                $nextSync = now($timezone)->addDay();
                list($hour, $minute) = explode(':', $timeOfDay);
                return $nextSync->setTime($hour, $minute);
                
            case 'weekly':
                $nextSync = now($timezone)->addWeek();
                list($hour, $minute) = explode(':', $timeOfDay);
                return $nextSync->setTime($hour, $minute);
                
            default:
                return now($timezone)->addHour();
        }
    }
}
