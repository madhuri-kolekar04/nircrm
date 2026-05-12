<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Quick Attendance Test ===\n\n";

try {
    // Test 1: Check if user is authenticated
    if (!Auth::check()) {
        // Get first active user for testing
        $user = \App\Models\User::where('is_active', true)->first();
        if ($user) {
            Auth::login($user);
            echo "✅ Logged in as user: {$user->name} (ID: {$user->id})\n";
        } else {
            echo "❌ No active users found\n";
            exit(1);
        }
    } else {
        $user = Auth::user();
        echo "✅ Already logged in as: {$user->name} (ID: {$user->id})\n";
    }
    
    // Test 2: Check if user can access attendance
    $today = Carbon\Carbon::today();
    echo "📅 Today's date: {$today}\n";
    
    $existingAttendance = \App\Models\Attendance::where('user_id', $user->id)
        ->where('date', $today)
        ->first();
    
    if ($existingAttendance) {
        if ($existingAttendance->check_in_time) {
            echo "⚠️  Already checked in today at: " . $existingAttendance->check_in_time->format('H:i:s') . "\n";
            echo "   This is normal behavior - you can only check in once per day.\n";
        } else {
            echo "ℹ️  Attendance record exists but no check-in time\n";
        }
    } else {
        echo "ℹ️  No attendance record for today - ready to check in\n";
    }
    
    // Test 3: Check database connectivity
    try {
        $attendanceCount = \App\Models\Attendance::count();
        echo "✅ Database connection OK ({$attendanceCount} attendance records)\n";
    } catch (Exception $e) {
        echo "❌ Database error: " . $e->getMessage() . "\n";
    }
    
    // Test 4: Check CSRF token
    try {
        $token = csrf_token();
        echo "✅ CSRF token generated successfully\n";
    } catch (Exception $e) {
        echo "❌ CSRF token error: " . $e->getMessage() . "\n";
    }
    
    // Test 5: Check mail configuration (common source of errors)
    try {
        $mailConfig = config('mail');
        if ($mailConfig) {
            echo "✅ Mail configuration loaded\n";
            if (isset($mailConfig['default'])) {
                echo "   Mail driver: " . $mailConfig['default'] . "\n";
            }
        } else {
            echo "⚠️  Mail configuration not found\n";
        }
    } catch (Exception $e) {
        echo "❌ Mail config error: " . $e->getMessage() . "\n";
    }
    
    echo "\n=== Recommendations ===\n";
    echo "1. Try marking attendance again in the browser\n";
    echo "2. If it still fails, check browser console (F12) for JavaScript errors\n";
    echo "3. Check Laravel logs at: storage/logs/laravel.log\n";
    echo "4. Make sure you're not already checked in today\n";
    echo "5. Ensure your user account is active\n";
    
    if ($existingAttendance && $existingAttendance->check_in_time) {
        echo "\n🎉 You are already checked in today! The system is working correctly.\n";
    } else {
        echo "\n🔧 The system appears ready for check-in. Try the attendance marking again.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Test failed: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
