<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Debug Validation Values ===\n\n";

// Test 1: Check available statuses
echo "1. Available Lead Statuses:\n";
try {
    $statuses = \App\Models\Staprio::getActiveStatuses();
    foreach ($statuses as $value => $label) {
        echo "  - Value: '$value' => Label: '$label'\n";
    }
    if (empty($statuses)) {
        echo "  ✗ No statuses found in database!\n";
    }
} catch (Exception $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Check available priorities
echo "2. Available Priorities:\n";
try {
    $priorities = \App\Models\Staprio::getActivePriorities();
    foreach ($priorities as $value => $label) {
        echo "  - Value: '$value' => Label: '$label'\n";
    }
    if (empty($priorities)) {
        echo "  ✗ No priorities found in database!\n";
    }
} catch (Exception $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Check available sources
echo "3. Available Sources:\n";
try {
    $sources = \App\Models\Lead::getSources();
    foreach ($sources as $value => $label) {
        echo "  - Value: '$value' => Label: '$label'\n";
    }
} catch (Exception $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Test the user's form data
echo "4. Testing User's Form Data:\n";
$userData = [
    'name' => 'shubham zote',
    'email' => 'aimanustore000@gmail.com',
    'phone' => '9623083000',
    'website' => 'https://demo.com/',
    'company_name' => 'indigime',
    'industry' => 'Export Import',
    'lead_status' => 'Lead',
    'priority' => 'hello',
    'source' => 'Advertisment',
    'address' => 'testing',
    'city' => 'pune',
    'state' => 'Maharashtra',
    'pincode' => '411021',
    'assigned_to' => 'Gaurav Gore',
    'budget' => '20000',
    'description' => 'testing'
];

echo "  User data:\n";
foreach ($userData as $key => $value) {
    echo "    $key: '$value'\n";
}

echo "\n  Validation checks:\n";

// Check lead_status
if (isset($statuses[$userData['lead_status']])) {
    echo "  ✓ Lead status '{$userData['lead_status']}' is valid\n";
} else {
    echo "  ✗ Lead status '{$userData['lead_status']}' is NOT valid\n";
    echo "    Available values: " . implode(', ', array_keys($statuses)) . "\n";
}

// Check priority
if (isset($priorities[$userData['priority']])) {
    echo "  ✓ Priority '{$userData['priority']}' is valid\n";
} else {
    echo "  ✗ Priority '{$userData['priority']}' is NOT valid\n";
    echo "    Available values: " . implode(', ', array_keys($priorities)) . "\n";
}

// Check source
if (isset($sources[$userData['source']])) {
    echo "  ✓ Source '{$userData['source']}' is valid\n";
} else {
    echo "  ✗ Source '{$userData['source']}' is NOT valid\n";
    echo "    Available values: " . implode(', ', array_keys($sources)) . "\n";
}

echo "\n";

// Test 5: Check database for raw staprios data
echo "5. Raw staprios table data:\n";
try {
    $allStaprios = \App\Models\Staprio::all();
    echo "  Total records: " . $allStaprios->count() . "\n";
    
    $statuses = $allStaprios->where('type', 'status');
    $priorities = $allStaprios->where('type', 'priority');
    
    echo "  Statuses (" . $statuses->count() . "):\n";
    foreach ($statuses as $status) {
        echo "    - ID: {$status->id}, Name: '{$status->name}', Value: '{$status->value}', Active: " . ($status->is_active ? 'Yes' : 'No') . "\n";
    }
    
    echo "  Priorities (" . $priorities->count() . "):\n";
    foreach ($priorities as $priority) {
        echo "    - ID: {$priority->id}, Name: '{$priority->name}', Value: '{$priority->value}', Active: " . ($priority->is_active ? 'Yes' : 'No') . "\n";
    }
} catch (Exception $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Debug Complete ===\n";
