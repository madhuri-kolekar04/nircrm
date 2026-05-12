<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

// Test customer creation data
$customerData = [
    'name' => 'Test Customer',
    'email' => 'test' . time() . '@example.com',
    'phone' => '1234567890',
    'company_name' => 'Test Company',
    'pan_number' => 'ABCDE1234F',
    'aadhar_number' => '123456789012',
    'password' => Hash::make('password123'),
    'role' => 3,
    'department' => 'Customer',
];

echo "Testing customer creation with data:\n";
print_r($customerData);

try {
    $customer = User::create($customerData);
    echo "SUCCESS: Customer created with ID: " . $customer->id . "\n";
    
    // Clean up
    $customer->delete();
    echo "Test customer deleted successfully.\n";
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

// Test with contact_number field
$customerData2 = [
    'name' => 'Test Customer 2',
    'email' => 'test2' . time() . '@example.com',
    'contact_number' => '1234567890', // Using contact_number instead of phone
    'company_name' => 'Test Company',
    'pan_number' => 'ABCDE1234F',
    'aadhar_number' => '123456789012',
    'password' => Hash::make('password123'),
    'role' => 3,
    'department' => 'Customer',
];

echo "\nTesting customer creation with contact_number field:\n";
print_r($customerData2);

try {
    $customer2 = User::create($customerData2);
    echo "SUCCESS: Customer created with ID: " . $customer2->id . "\n";
    
    // Clean up
    $customer2->delete();
    echo "Test customer deleted successfully.\n";
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
