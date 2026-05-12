<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Fix Attendance User ID ===\n\n";

try {
    // Get the first user (should have ID > 0)
    $firstUser = \App\Models\User::first();
    
    if ($firstUser) {
        echo "First user found: ID {$firstUser->id}, Name: {$firstUser->name}\n";
        
        // Update the attendance record to use a valid user_id
        $updated = \App\Models\Attendance::where('id', 1)
            ->update(['user_id' => $firstUser->id]);
            
        if ($updated) {
            echo "✅ Updated attendance record ID 1 to use user_id {$firstUser->id}\n";
            echo "✅ This should fix the 'Attempt to read property user on string' error\n";
        } else {
            echo "❌ Failed to update attendance record\n";
        }
    } else {
        echo "❌ No users found in database\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
