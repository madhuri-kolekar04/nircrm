<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

try {
    // Test database connection
    $db = Illuminate\Support\Facades\DB::connection();
    echo "Database connection: " . ($db->getPdo() ? "OK\n" : "FAILED\n");
    
    // Test user model
    $userCount = App\Models\User::count();
    echo "Users count: $userCount\n";
    
    // Test attendance model
    $attendanceCount = App\Models\Attendance::count();
    echo "Attendance records: $attendanceCount\n";
    
    // Test shift model
    $shiftCount = App\Models\Shift::count();
    echo "Shifts count: $shiftCount\n";
    
    // Test dashboard method
    echo "Testing dashboard method...\n";
    
    // Create a mock user
    $testUser = App\Models\User::first();
    if (!$testUser) {
        echo "No users found in database!\n";
        exit;
    }
    
    echo "Test user: " . $testUser->name . " (ID: " . $testUser->id . ")\n";
    
    // Simulate authentication
    Illuminate\Support\Facades\Auth::login($testUser);
    
    // Test the dashboard method
    $controller = new App\Http\Controllers\AttendanceController();
    $response = $controller->dashboard();
    
    echo "Dashboard method executed successfully!\n";
    echo "Response type: " . get_class($response) . "\n";
    
    if (method_exists($response, 'getData')) {
        $data = $response->getData();
        echo "View data keys: " . implode(', ', array_keys($data)) . "\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
