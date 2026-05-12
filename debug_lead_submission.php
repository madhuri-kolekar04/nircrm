<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Debug Lead Form Submission ===\n\n";

// Test 1: Check if route exists
echo "1. Checking route 'leads.store.new'...\n";
$route = \Illuminate\Support\Facades\Route::getRoutes()->getByAction('App\Http\Controllers\Admin\LeadController@storeNew');
if ($route) {
    echo "✓ Route found: " . $route->uri() . "\n";
    echo "  Methods: " . implode(', ', $route->methods()) . "\n";
} else {
    echo "✗ Route NOT found\n";
}

echo "\n";

// Test 2: Check if Lead model methods work
echo "2. Testing Lead model methods...\n";
try {
    $statuses = \App\Models\Lead::getLeadStatuses();
    echo "✓ Lead statuses: " . json_encode($statuses) . "\n";
} catch (Exception $e) {
    echo "✗ Error getting statuses: " . $e->getMessage() . "\n";
}

try {
    $priorities = \App\Models\Lead::getPriorities();
    echo "✓ Lead priorities: " . json_encode($priorities) . "\n";
} catch (Exception $e) {
    echo "✗ Error getting priorities: " . $e->getMessage() . "\n";
}

try {
    $sources = \App\Models\Lead::getSources();
    echo "✓ Lead sources: " . json_encode($sources) . "\n";
} catch (Exception $e) {
    echo "✗ Error getting sources: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Check database connection and leads table
echo "3. Testing database connection...\n";
try {
    $leadCount = \App\Models\Lead::count();
    echo "✓ Database connection OK\n";
    echo "  Total leads in database: " . $leadCount . "\n";
} catch (Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Test creating a lead programmatically
echo "4. Testing lead creation...\n";
try {
    $testData = [
        'name' => 'Test Lead ' . date('Y-m-d H:i:s'),
        'email' => 'test' . time() . '@example.com',
        'lead_status' => 'lead',
        'priority' => 'medium',
        'source' => 'website',
        'created_by' => 1,
    ];
    
    $lead = \App\Models\Lead::create($testData);
    echo "✓ Lead created successfully with ID: " . $lead->id . "\n";
    
    // Clean up test lead
    $lead->delete();
    echo "✓ Test lead cleaned up\n";
} catch (Exception $e) {
    echo "✗ Error creating lead: " . $e->getMessage() . "\n";
    echo "  Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n";

// Test 5: Check users and departments
echo "5. Checking users and departments...\n";
try {
    $userCount = \App\Models\User::count();
    echo "✓ Total users: " . $userCount . "\n";
    
    if ($userCount > 0) {
        $firstUser = \App\Models\User::first();
        echo "  First user: " . $firstUser->name . " (ID: " . $firstUser->id . ")\n";
    }
} catch (Exception $e) {
    echo "✗ Error checking users: " . $e->getMessage() . "\n";
}

try {
    $deptCount = \App\Models\Department::count();
    echo "✓ Total departments: " . $deptCount . "\n";
    
    if ($deptCount > 0) {
        $firstDept = \App\Models\Department::first();
        echo "  First department: " . $firstDept->department . " (ID: " . $firstDept->id . ")\n";
    }
} catch (Exception $e) {
    echo "✗ Error checking departments: " . $e->getMessage() . "\n";
}

echo "\n=== Debug Complete ===\n";
