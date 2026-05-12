<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AutomatedSyncController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AutomatedSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:automated {action=auto-sync : The action to perform (auto-sync, check-notifications, status)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run automated Google Sheets sync and email notifications without user interaction';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $action = $this->argument('action');
        
        $this->info("Starting automated sync: {$action} at " . now());
        Log::info("Console command started", ['action' => $action, 'timestamp' => now()]);
        
        try {
            $controller = new AutomatedSyncController(app(\App\Services\GoogleSheetsServicePublic::class), app(\App\Services\LeadNotificationService::class));
            $request = new Request();
            
            switch ($action) {
                case 'auto-sync':
                    $response = $controller->autoSync($request);
                    break;
                    
                case 'check-notifications':
                    $response = $controller->checkNewEntriesAndNotify($request);
                    break;
                    
                case 'status':
                    $response = $controller->getStatus($request);
                    break;
                    
                default:
                    $this->error("Unknown action: {$action}");
                    return Command::FAILURE;
            }
            
            $data = json_decode($response->getContent(), true);
            
            if ($data['success']) {
                // Handle status response differently
                if ($action === 'status' && isset($data['status'])) {
                    $this->info("System Status Retrieved Successfully");
                    
                    $this->table(
                        ['Metric', 'Value'],
                        [
                            ['Last Automated Sync', $data['status']['last_automated_sync']],
                            ['Last Notification Check', $data['status']['last_notification_check']],
                            ['Last Google Sheets Sync', $data['status']['last_google_sheets_sync'] ?? 'Unknown'],
                            ['Current Time', $data['status']['current_time']],
                            ['System Active', $data['status']['system_active'] ? 'Yes' : 'No']
                        ]
                    );
                } else {
                    // For other actions, show the message
                    $this->info($data['message']);
                }
                
                Log::info("Console command completed successfully", ['action' => $action, 'data' => $data]);
                return Command::SUCCESS;
            } else {
                $errorMessage = $data['message'] ?? 'Unknown error occurred';
                $this->error($errorMessage);
                Log::error("Console command failed", ['action' => $action, 'data' => $data]);
                return Command::FAILURE;
            }
            
        } catch (\Exception $e) {
            $this->error("Command failed: " . $e->getMessage());
            Log::error("Console command exception", ['action' => $action, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return Command::FAILURE;
        }
    }
}
