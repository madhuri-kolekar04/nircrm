<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckNewRecordings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordings:check-new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for new call recordings and send mobile app notifications';

    /**
     * Track the last checked timestamp
     *
     * @var string
     */
    protected $lastCheckedFile;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->lastCheckedFile = storage_path('app/last_recording_check.txt');
        
        // Get the last check time
        $lastChecked = $this->getLastCheckedTime();
        
        // Find new recordings since last check
        $newRecordings = DB::table('call_recordings')
            ->where('created_at', '>', $lastChecked)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($newRecordings->isEmpty()) {
            $this->info('No new recordings found.');
            return 0;
        }

        $this->info("Found {$newRecordings->count()} new recording(s).");

        // Send notifications for each new recording
        foreach ($newRecordings as $recording) {
            $this->sendNotification($recording);
        }

        // Update the last checked time
        $this->updateLastCheckedTime();

        $this->info('Notifications sent successfully.');
        return 0;
    }

    /**
     * Get the last checked time from file
     *
     * @return string
     */
    private function getLastCheckedTime()
    {
        if (!file_exists($this->lastCheckedFile)) {
            // If file doesn't exist, check from the last 5 minutes to avoid missing anything
            return now()->subMinutes(5)->toDateTimeString();
        }

        $lastChecked = file_get_contents($this->lastCheckedFile);
        return $lastChecked ?: now()->subMinutes(5)->toDateTimeString();
    }

    /**
     * Update the last checked time
     *
     * @return void
     */
    private function updateLastCheckedTime()
    {
        $directory = dirname($this->lastCheckedFile);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($this->lastCheckedFile, now()->toDateTimeString());
    }

    /**
     * Send Firebase notification for new recording
     *
     * @param object $recording
     * @return void
     */
    private function sendNotification($recording)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        // Get Firebase Server Key from environment variables
        $serverKey = env('FIREBASE_SERVER_KEY', 'YOUR_FIREBASE_SERVER_KEY_HERE');
        
        // Don't send notification if server key is not configured
        if ($serverKey === 'YOUR_FIREBASE_SERVER_KEY_HERE' || empty($serverKey)) {
            Log::warning('Firebase notification not sent - Server key not configured');
            return;
        }

        $title = "New Call Recording";
        $message = "New recording from {$recording->customer_name} ({$recording->customer_phone})";
        $targetUrl = url('/allrecordingcall');

        $data = [
            "to" => "/topics/all_users",
            "notification" => [
                "title" => $title,
                "body" => $message,
                "sound" => "default",
                "click_action" => "FLUTTER_NOTIFICATION_CLICK"
            ],
            "data" => [
                "title" => $title,
                "message" => $message,
                "target_url" => $targetUrl,
                "recording_id" => $recording->id,
                "customer_name" => $recording->customer_name,
                "customer_phone" => $recording->customer_phone,
                "file_url" => $recording->file_url,
                "sync_type" => $recording->sync_type,
                "created_at" => $recording->created_at
            ],
            "priority" => "high"
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\nAuthorization: key=" . $serverKey . "\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ],
        ];

        $context = stream_context_create($options);
        
        try {
            $result = file_get_contents($url, false, $context);
            Log::info('New recording notification sent', [
                'recording_id' => $recording->id,
                'customer_name' => $recording->customer_name,
                'response' => $result
            ]);
            
            $this->line("Notification sent for recording ID: {$recording->id}");
        } catch (\Exception $e) {
            Log::error('Failed to send new recording notification', [
                'recording_id' => $recording->id,
                'error' => $e->getMessage()
            ]);
            
            $this->error("Failed to send notification for recording ID: {$recording->id} - {$e->getMessage()}");
        }
    }
}
