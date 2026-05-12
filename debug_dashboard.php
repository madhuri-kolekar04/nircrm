<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Debug Dashboard Method ===\n\n";

try {
    // Simulate authenticated user
    $user = \App\Models\User::find(3); // Admin User
    
    if (!$user) {
        echo "No admin user found with ID 3\n";
        $user = \App\Models\User::first(); // Use first available user
    }
    
    echo "Testing with user: {$user->name} (Role: {$user->role})\n\n";
    
    // Create controller instance
    $controller = new \App\Http\Controllers\AttendanceController();
    
    // Use reflection to call private methods for testing
    $reflection = new ReflectionClass($controller);
    
    echo "1. Testing getFilteredUsers...\n";
    $getFilteredUsers = $reflection->getMethod('getFilteredUsers');
    $getFilteredUsers->setAccessible(true);
    
    $users = $getFilteredUsers->invoke($controller, $user);
    echo "  Users found: " . $users->count() . "\n";
    
    echo "\n2. Testing getAttendanceStats...\n";
    $getAttendanceStats = $reflection->getMethod('getAttendanceStats');
    $getAttendanceStats->setAccessible(true);
    
    $today = new \Carbon\Carbon();
    $stats = $getAttendanceStats->invoke($controller, $users, $today);
    echo "  Stats keys: " . implode(', ', array_keys($stats)) . "\n";
    
    // Check each stat key
    $expectedKeys = ['total', 'present', 'absent', 'onLeave', 'halfDay', 'notMarked'];
    foreach ($expectedKeys as $key) {
        if (array_key_exists($key, $stats)) {
            echo "  ✅ $key: " . $stats[$key] . "\n";
        } else {
            echo "  ❌ MISSING $key\n";
        }
    }
    
    echo "\n3. Testing getMonthlyStats...\n";
    $getMonthlyStats = $reflection->getMethod('getMonthlyStats');
    $getMonthlyStats->setAccessible(true);
    
    $monthlyStats = $getMonthlyStats->invoke($controller, $users);
    echo "  Monthly Stats keys: " . implode(', ', array_keys($monthlyStats)) . "\n";
    
    // Check each monthly stat key
    $expectedMonthlyKeys = ['totalDays', 'workingDays', 'weekends', 'totalPresent', 'totalAbsent', 'totalLeave', 'totalHalfDay'];
    foreach ($expectedMonthlyKeys as $key) {
        if (array_key_exists($key, $monthlyStats)) {
            echo "  ✅ $key: " . $monthlyStats[$key] . "\n";
        } else {
            echo "  ❌ MISSING $key\n";
        }
    }
    
    echo "\n4. Testing canApproveLeave method...\n";
    if (method_exists($user, 'canApproveLeave')) {
        $canApprove = $user->canApproveLeave();
        echo "  canApproveLeave: " . ($canApprove ? 'true' : 'false') . "\n";
    } else {
        echo "  ❌ canApproveLeave method does not exist\n";
    }
    
    echo "\n5. Testing actual dashboard view data preparation...\n";
    
    // Test the actual dashboard method
    try {
        // Mock auth
        \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);
        
        $dashboardData = $controller->dashboard();
        echo "  ✅ Dashboard method executed successfully\n";
        echo "  View data prepared for rendering\n";
        
    } catch (Exception $e) {
        echo "  ❌ Dashboard method error: " . $e->getMessage() . "\n";
        echo "  File: " . $e->getFile() . "\n";
        echo "  Line: " . $e->getLine() . "\n";
        
        // Check if it's an array key error
        if (strpos($e->getMessage(), 'Undefined array key') !== false) {
            echo "  🚨 THIS IS THE ARRAY KEY ERROR!\n";
        }
    }
    
    echo "\n=== Debug Complete ===\n";
    
} catch (Exception $e) {
    echo "FATAL ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    
    // Check if it's an array key error
    if (strpos($e->getMessage(), 'Undefined array key') !== false) {
        echo "🚨 ARRAY KEY ERROR DETECTED!\n";
        
        // Extract the key number
        if (preg_match('/Undefined array key (\d+)/', $e->getMessage(), $matches)) {
            echo "Missing key: " . $matches[1] . "\n";
        }
    }
    
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
