<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Shift Assignment Debug ===\n\n";

// Test the route
echo "Route Check:\n";
$route = \Illuminate\Support\Facades\Route::getRoutes()->match(['POST'], 'shifts/assign');
if ($route) {
    echo "✓ Route found: shifts.assign\n";
    echo "  Action: " . $route->getAction('uses') . "\n";
    echo "  Middleware: " . implode(', ', $route->middleware()) . "\n";
} else {
    echo "✗ Route not found\n";
}

echo "\n";

// Test current user
$user = \App\Models\User::find(3);
echo "Current User (ID 3):\n";
echo "- Name: " . $user->name . "\n";
echo "- Role: " . $user->role . " (1=Admin, 2=Employee, 3=Customer, 4=Manager, 5=GM)\n";
echo "- Can Assign Shifts: " . (in_array($user->role, [1, 5]) ? 'Yes' : 'No') . "\n";

echo "\n";

// Test shift assignment functionality
echo "Testing Shift Assignment:\n";
$testUser = \App\Models\User::where('role', '!=', 3)->where('is_active', true)->first();
$testShift = \App\Models\Shift::first();

echo "- Test User: " . $testUser->name . " (ID: " . $testUser->id . ")\n";
echo "- Test Shift: " . $testShift->name . " (ID: " . $testShift->id . ")\n";
echo "- Current Shift ID: " . ($testUser->shift_id ?? 'null') . "\n";

// Simulate the assignShift method
$controller = new \App\Http\Controllers\ShiftController();

echo "\nSimulating shift assignment...\n";

// Create a mock request
$request = new \Illuminate\Http\Request([
    'user_id' => $testUser->id,
    'shift_id' => $testShift->id
]);

// Set up auth
\Illuminate\Support\Facades\Auth::login($user);

try {
    // This will test the actual method
    $response = $controller->assignShift($request);
    echo "✓ Method executed successfully\n";
    echo "Response: " . $response->getContent() . "\n";
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}

echo "\n=== Debug Complete ===\n";
