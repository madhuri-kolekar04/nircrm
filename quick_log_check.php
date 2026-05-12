<?php

// Quick debug of Laravel logs
$logFile = 'storage/logs/laravel.log';

if (file_exists($logFile)) {
    $logs = file_get_contents($logFile);
    $recentLogs = substr($logs, -2000); // Get last 2000 characters
    
    echo "=== RECENT LARAVEL LOGS ===\n";
    echo $recentLogs . "\n";
    
    // Look for recent errors
    if (strpos($recentLogs, 'getMeetingCallDetails') !== false) {
        echo "✅ Found getMeetingCallDetails calls in logs\n";
    }
    
    if (strpos($recentLogs, '500') !== false) {
        echo "❌ Found 500 errors in logs\n";
    }
    
    if (strpos($recentLogs, 'ArgumentCountError') !== false) {
        echo "⚠️  Found ArgumentCountError - this is the issue!\n";
    }
    
} else {
    echo "❌ Log file not found\n";
}

echo "\n=== DEBUG COMPLETE ===\n";
