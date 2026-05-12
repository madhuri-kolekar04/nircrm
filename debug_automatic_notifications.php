<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\GoogleSheetsServicePublic;
use App\Services\LeadNotificationService;
use Illuminate\Support\Facades\Log;

echo "=== DEBUG AUTOMATIC NOTIFICATIONS ===\n\n";

try {
    // 1. Get current Google Sheets data
    echo "1. Getting Google Sheets data...\n";
    $googleSheetsService = new GoogleSheetsServicePublic();
    $allData = $googleSheetsService->getMappedData();
    
    if (empty($allData)) {
        echo "❌ No data found in Google Sheets\n";
        exit;
    }
    
    echo "✅ Found " . count($allData) . " entries in Google Sheets\n";
    
    // Reverse to match calling app order
    $allData = array_reverse($allData);
    
    // Show first few entries
    echo "\nFirst 3 entries:\n";
    foreach (array_slice($allData, 0, 3) as $index => $entry) {
        echo "   " . ($index + 1) . ". " . (isset($entry['full_name']) ? $entry['full_name'] : 'No name') . 
             " (" . (isset($entry['email']) ? $entry['email'] : 'No email') . ")\n";
    }
    
    // 2. Check session state
    echo "\n2. Checking session state...\n";
    $notifiedEntries = session('notified_entries', []);
    $lastChecked = session('last_entries_checked', null);
    
    echo "   Notified entries in session: " . count($notifiedEntries) . "\n";
    echo "   Last checked: " . ($lastChecked ? $lastChecked->format('Y-m-d H:i:s') : 'Never') . "\n";
    
    if (!empty($notifiedEntries)) {
        echo "   Already notified entries:\n";
        foreach (array_slice($notifiedEntries, -3) as $entry) {
            echo "     - {$entry}\n";
        }
    }
    
    // 3. Simulate the checkAndNotifyNewEntries logic
    echo "\n3. Simulating automatic notification check...\n";
    
    $current_time = now();
    echo "   Current time: " . $current_time->format('Y-m-d H:i:s') . "\n";
    
    if ($lastChecked && $current_time->diffInMinutes($lastChecked) < 1) {
        echo "   ⏰ Rate limited - only " . $current_time->diffInMinutes($lastChecked) . " minutes since last check\n";
        echo "   Need to wait at least 1 minute between checks\n";
    } else {
        echo "   ✅ Rate limit passed - can check for new entries\n";
        
        // Check for new entries
        $newEntriesFound = 0;
        foreach (array_slice($allData, 0, 5) as $entry) {
            if (!empty($entry['full_name']) && !empty($entry['email'])) {
                $entryKey = $entry['full_name'] . '|' . $entry['email'];
                
                if (!in_array($entryKey, $notifiedEntries)) {
                    echo "   🆕 NEW ENTRY FOUND: {$entryKey}\n";
                    $newEntriesFound++;
                    
                    // Try to send notification
                    $notificationData = [
                        'full_name' => $entry['full_name'],
                        'business_name' => isset($entry['business_name']) ? $entry['business_name'] : '',
                        'email' => $entry['email'],
                        'whatsapp' => isset($entry['whatsapp']) ? $entry['whatsapp'] : '',
                        'website_url' => isset($entry['website_url']) ? $entry['website_url'] : '',
                        'submitted_at' => now()->format('M d, Y H:i A')
                    ];
                    
                    echo "   📧 Attempting to send notification...\n";
                    
                    try {
                        $notificationService = new LeadNotificationService();
                        $result = $notificationService->sendNewLeadNotification($notificationData);
                        
                        if ($result['success']) {
                            echo "   ✅ Notification sent successfully!\n";
                            echo "      Sent to: {$result['sent']} employees\n";
                            echo "      Failed: {$result['failed']} employees\n";
                            
                            // Add to notified entries
                            $notifiedEntries[] = $entryKey;
                            session(['notified_entries' => array_slice($notifiedEntries, -50)]);
                            
                        } else {
                            echo "   ❌ Notification failed: {$result['error']}\n";
                        }
                    } catch (\Exception $e) {
                        echo "   ❌ Exception: " . $e->getMessage() . "\n";
                    }
                } else {
                    echo "   ✅ Already notified: {$entryKey}\n";
                }
            }
        }
        
        // Update last checked time
        session(['last_entries_checked' => $current_time]);
        
        echo "\n   📊 Summary: Found {$newEntriesFound} new entries\n";
    }
    
    // 4. Check email configuration
    echo "\n4. Email configuration check...\n";
    $notificationService = new LeadNotificationService();
    $emailEnabled = $notificationService->isEmailNotificationEnabled();
    echo "   Email notifications enabled: " . ($emailEnabled ? '✅ Yes' : '❌ No') . "\n";
    
    if (!$emailEnabled) {
        echo "   ❌ Email notifications are disabled - this is the problem!\n";
        echo "   Fix: Check your .env file mail settings\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== DEBUG COMPLETE ===\n";
