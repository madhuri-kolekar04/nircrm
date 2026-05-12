<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Clean Up User ID 0 ===\n\n";

try {
    // Find the user with ID 0
    $userWithZeroId = \App\Models\User::where('id', 0)->first();
    
    if ($userWithZeroId) {
        echo "Found user with ID 0: {$userWithZeroId->name}\n";
        
        // Check if this user has any attendance records
        $attendanceCount = \App\Models\Attendance::where('user_id', 0)->count();
        echo "Attendance records with user_id 0: $attendanceCount\n";
        
        if ($attendanceCount == 0) {
            echo "✅ Safe to delete user with ID 0 (no attendance records)\n";
            
            // Delete the problematic user
            $deleted = \App\Models\User::where('id', 0)->delete();
            
            if ($deleted) {
                echo "✅ Deleted user with ID 0\n";
                echo "✅ This prevents future 'Attempt to read property user on string' errors\n";
            } else {
                echo "❌ Failed to delete user with ID 0\n";
            }
        } else {
            echo "⚠️  User with ID 0 has attendance records - NOT deleting\n";
            echo "  Would need to reassign attendance records first\n";
        }
    } else {
        echo "✅ No user with ID 0 found\n";
    }
    
    echo "\n🎯 **Verification:**\n";
    
    // Verify no more users with ID 0
    $remainingZeroUsers = \App\Models\User::where('id', 0)->count();
    echo "Remaining users with ID 0: $remainingZeroUsers\n";
    
    if ($remainingZeroUsers == 0) {
        echo "✅ SUCCESS: No more users with ID 0 in database\n";
        echo "✅ 'Attempt to read property user on string' error should be resolved\n";
    } else {
        echo "❌ WARNING: Still have users with ID 0\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
