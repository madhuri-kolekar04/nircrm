<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Attendance Marking Issue Debug ===\n\n";

try {
    // Check current user authentication
    echo "1. Checking Authentication Status:\n";
    if (Auth::check()) {
        $user = Auth::user();
        echo "✅ User Authenticated: ID {$user->id}, Name: {$user->name}, Role: {$user->role}\n";
        echo "   Is Active: " . ($user->is_active ? 'YES' : 'NO') . "\n";
    } else {
        echo "❌ No User Authenticated\n";
        exit(1);
    }
    
    echo "\n2. Checking Today's Attendance Record:\n";
    $today = Carbon\Carbon::today();
    $existingAttendance = \App\Models\Attendance::where('user_id', $user->id)
        ->where('date', $today)
        ->first();
    
    if ($existingAttendance) {
        echo "✅ Found Existing Attendance Record:\n";
        echo "   ID: {$existingAttendance->id}\n";
        echo "   Check-in Time: " . ($existingAttendance->check_in_time ? $existingAttendance->check_in_time->format('H:i:s') : 'NULL') . "\n";
        echo "   Check-out Time: " . ($existingAttendance->check_out_time ? $existingAttendance->check_out_time->format('H:i:s') : 'NULL') . "\n";
        echo "   Status: {$existingAttendance->status}\n";
        
        if ($existingAttendance->check_in_time) {
            echo "⚠️  Already checked in today!\n";
        }
    } else {
        echo "ℹ️  No attendance record found for today\n";
    }
    
    echo "\n3. Testing Check-in Process:\n";
    
    // Test the validation rules
    echo "   Testing user validation...\n";
    if (!$user->is_active) {
        echo "❌ User account is deactivated\n";
    } else {
        echo "✅ User account is active\n";
    }
    
    // Test shift information
    echo "   Testing shift information...\n";
    if ($user->shift) {
        echo "✅ User has shift: {$user->shift->name}\n";
        echo "   Shift Time: {$user->shift->start_time->format('H:i')} - {$user->shift->end_time->format('H:i')}\n";
    } else {
        echo "ℹ️  No shift assigned, using default shift\n";
    }
    
    echo "\n4. Testing Database Connection:\n";
    try {
        $testAttendance = new \App\Models\Attendance();
        $testAttendance->user_id = $user->id;
        $testAttendance->date = $today;
        $testAttendance->status = 'test';
        echo "✅ Database connection working\n";
        unset($testAttendance);
    } catch (Exception $e) {
        echo "❌ Database error: " . $e->getMessage() . "\n";
    }
    
    echo "\n5. Checking Email Configuration:\n";
    try {
        $config = config('mail');
        echo "✅ Mail configuration loaded\n";
        echo "   Mail Driver: " . ($config['default'] ?? 'not set') . "\n";
    } catch (Exception $e) {
        echo "❌ Mail configuration error: " . $e->getMessage() . "\n";
    }
    
    echo "\n6. Testing CSRF Token:\n";
    try {
        $token = csrf_token();
        echo "✅ CSRF Token generated: " . substr($token, 0, 10) . "...\n";
    } catch (Exception $e) {
        echo "❌ CSRF Token error: " . $e->getMessage() . "\n";
    }
    
    echo "\n=== Debug Complete ===\n";
    echo "If all tests pass, the issue might be in the JavaScript/AJAX request.\n";
    echo "Check browser console for JavaScript errors.\n";
    
} catch (Exception $e) {
    echo "❌ Debug Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
