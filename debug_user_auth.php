<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// Check current user and role
echo "Checking current user authentication and role...\n";

if (Auth::check()) {
    $user = Auth::user();
    echo "✓ User is authenticated\n";
    echo "✓ User ID: " . $user->id . "\n";
    echo "✓ User Name: " . $user->name . "\n";
    echo "✓ User Role: " . $user->role . "\n";
    echo "✓ User Department ID: " . ($user->department_id ?: 'null') . "\n";
    echo "✓ User Department: " . ($user->department ? $user->department->name : 'No department') . "\n";
    echo "✓ User is_active: " . ($user->is_active ? 'true' : 'false') . "\n";
} else {
    echo "✗ User is not authenticated\n";
}

// Test getFilteredUsers method
echo "\nTesting getFilteredUsers method...\n";
if (Auth::check()) {
    $user = Auth::user();
    
    // Manually call the method
    $users = $user->getFilteredUsers($user);
    echo "✓ getFilteredUsers returned: " . $users->count() . " users\n";
    
    // Test attendance query
    $userIds = $users->pluck('id');
    $startDate = Carbon\Carbon::now()->startOfMonth();
    $endDate = Carbon\Carbon::now()->endOfMonth();
    
    $attendances = \App\Models\Attendance::with('user')
        ->whereIn('user_id', $userIds)
        ->whereBetween('date', [$startDate, $endDate])
        ->orderBy('date', 'desc')
        ->orderBy('check_in_time', 'asc')
        ->get();
    
    echo "✓ Attendances found: " . $attendances->count() . "\n";
    
    if ($attendances->count() > 0) {
        echo "✓ Sample attendance record:\n";
        $sample = $attendances->first();
        echo "  - User: " . $sample->user->name . "\n";
        echo "  - Date: " . $sample->date->format('Y-m-d') . "\n";
        echo "  - Status: " . $sample->status . "\n";
    }
}
