<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUGGING POSITION UPDATE ISSUE ===\n";

// Get Ganesh's current data
$ganesh = \App\Models\User::where('email', 'ganeshshendye@gmail.com')->first();

if ($ganesh) {
    echo "Current employee data:\n";
    echo "  ID: " . $ganesh->id . "\n";
    echo "  Name: " . $ganesh->name . "\n";
    echo "  Email: " . $ganesh->email . "\n";
    echo "  Position: '" . $ganesh->position . "'\n";
    echo "  Designation: '" . $ganesh->designation . "'\n";
    echo "  Department: '" . $ganesh->department . "'\n";
    echo "  Updated at: " . $ganesh->updated_at . "\n";
    
    // Check if position column exists in database
    echo "\n=== Checking Database Schema ===\n";
    try {
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing('users');
        echo "Columns in users table:\n";
        foreach ($columns as $column) {
            if (strpos($column, 'position') !== false || strpos($column, 'design') !== false) {
                echo "  ✓ $column\n";
            }
        }
    } catch (Exception $e) {
        echo "Error checking schema: " . $e->getMessage() . "\n";
    }
    
    // Test manual update
    echo "\n=== Testing Manual Update ===\n";
    try {
        $ganesh->position = 'Employee';
        $ganesh->save();
        echo "Manual update successful\n";
        
        // Refresh and check
        $ganesh->refresh();
        echo "Position after manual update: '" . $ganesh->position . "'\n";
    } catch (Exception $e) {
        echo "Manual update failed: " . $e->getMessage() . "\n";
    }
    
    // Check recent logs for any errors
    echo "\n=== Checking Recent Logs ===\n";
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        $logs = file_get_contents($logFile);
        $recentLogs = substr($logs, -2000); // Last 2000 characters
        if (strpos($recentLogs, 'ERROR') !== false) {
            echo "Recent errors found in logs:\n";
            $lines = explode("\n", $recentLogs);
            foreach ($lines as $line) {
                if (strpos($line, 'ERROR') !== false) {
                    echo "  " . trim($line) . "\n";
                }
            }
        } else {
            echo "No recent errors in logs\n";
        }
    } else {
        echo "Log file not found\n";
    }
    
} else {
    echo "User not found!\n";
}

echo "\n=== DEBUG COMPLETE ===\n";
