<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Reset Notification Tracking ===\n\n";

// Clear session data for notifications
session(['notified_entries' => []]);
session(['last_entries_checked' => now()->subMinutes(30)]);

echo "✅ Notification tracking reset\n";
echo "✅ Cleared notified entries list\n";
echo "✅ Reset last checked time\n";

echo "\nNow visit: http://127.0.0.1:8000/callingapp\n";
echo "Automatic email notifications will be triggered for new entries!\n";

echo "\n=== Reset Complete ===\n";
