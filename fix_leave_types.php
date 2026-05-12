<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== LEAVE TYPES DATA ===\n";
$leaveTypes = \App\Models\LeaveType::all();
foreach ($leaveTypes as $type) {
    echo $type->name . " (ID: " . $type->id . ")\n";
    echo "  Days per Year: " . ($type->days_per_year ?? 'NULL') . "\n";
    echo "  Is Active: " . ($type->is_active ? 'Yes' : 'No') . "\n";
    echo "  Is Paid: " . ($type->is_paid ? 'Yes' : 'No') . "\n";
    echo "\n";
}

echo "=== UPDATING LEAVE TYPES WITH DEFAULT VALUES ===\n";
foreach ($leaveTypes as $type) {
    if (is_null($type->days_per_year) || $type->days_per_year === '' || $type->days_per_year === 0) {
        $defaultDays = match($type->name) {
            'Sick Leave' => 12,
            'Casual Leave' => 15,
            'Annual Leave' => 21,
            'Maternity Leave' => 90,
            default => 10
        };
        
        $type->days_per_year = $defaultDays;
        $type->save();
        echo "✅ Updated {$type->name}: {$defaultDays} days per year\n";
    } else {
        echo "✅ {$type->name} already has {$type->days_per_year} days per year\n";
    }
}
