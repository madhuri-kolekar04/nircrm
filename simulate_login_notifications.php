<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Simulating Login Time Notifications ===\n\n";

// Get test users
$users = \App\Models\User::with('shift')->limit(3)->get();

foreach ($users as $user) {
    $roles = [1 => 'Admin', 2 => 'Employee', 3 => 'Customer', 4 => 'Manager', 5 => 'General Manager'];
echo "Testing user: " . $user->name . " (Role: " . ($roles[$user->role] ?? 'Unknown') . ")\n";
    
    if ($user->shift) {
        echo "  Shift: " . $user->shift->name . " (" . $user->shift->start_time->format('H:i') . " - " . $user->shift->end_time->format('H:i') . ")\n";
        
        // Simulate login time (current time)
        $now = \Carbon\Carbon::now();
        $shiftStart = \Carbon\Carbon::today()->setTimeFromTimeString($user->shift->start_time->format('H:i:s'));
        
        echo "  Current time: " . $now->format('H:i:s') . "\n";
        echo "  Shift start: " . $shiftStart->format('H:i:s') . "\n";
        
        // Determine if late or early
        $lateThreshold = $shiftStart->copy()->addMinutes(5);
        $earlyThreshold = $shiftStart->copy()->subMinutes(30);
        
        if ($now->greaterThan($lateThreshold)) {
            echo "  Status: LATE (should send notification)\n";
            $service = new \App\Services\LoginTimeNotificationService();
            $result = $service->sendLoginTimeNotification($user, 'late');
            echo "  Notification sent: " . ($result ? 'YES' : 'NO') . "\n";
        } elseif ($now->lessThan($earlyThreshold)) {
            echo "  Status: EARLY (should send notification)\n";
            $service = new \App\Services\LoginTimeNotificationService();
            $result = $service->sendLoginTimeNotification($user, 'early');
            echo "  Notification sent: " . ($result ? 'YES' : 'NO') . "\n";
        } else {
            echo "  Status: NORMAL (no notification needed)\n";
        }
    } else {
        echo "  No shift assigned\n";
    }
    
    echo "\n";
}

echo "=== Simulation Complete ===\n";
echo "\nTo actually test the system:\n";
echo "1. Log in to the CRM system with different user accounts\n";
echo "2. The system will automatically check login time on each login\n";
echo "3. If login is late (>5 min after shift) or early (>30 min before shift), notifications will be sent\n";
echo "4. Check Laravel logs: tail -f storage/logs/laravel.log\n";
echo "5. Configure email settings in .env file to receive actual emails\n";
