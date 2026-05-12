<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

// Test the full OTP flow
echo "=== Testing Full OTP Flow ===\n\n";

// 1. Test OTP generation and email sending
$otp = rand(100000, 999999);
$customerData = [
    'name' => 'Test Customer',
    'email' => 'agent@nisargramya.com', // Using the email from the screenshot
    'phone' => '1234567890',
    'company_name' => 'Test Company',
    'pan_number' => 'ABCDE1234F',
    'aadhar_number' => '123456789012',
    'password' => Hash::make('password123'),
    'role' => 3,
    'otp' => $otp,
    'otp_expires_at' => Carbon::now()->addMinutes(10),
];

echo "Generated OTP: {$otp}\n";
echo "OTP expires at: " . $customerData['otp_expires_at'] . "\n\n";

// 2. Test email configuration
echo "=== Email Configuration ===\n";
echo "Mail driver: " . config('mail.default') . "\n";
echo "Mail host: " . config('mail.mailers.smtp.host') . "\n";
echo "Mail port: " . config('mail.mailers.smtp.port') . "\n";
echo "Mail from address: " . config('mail.from.address') . "\n";
echo "Mail from name: " . config('mail.from.name') . "\n\n";

// 3. Test email sending
echo "=== Testing Email Sending ===\n";
try {
    Mail::raw("Your OTP for customer account creation is: {$otp}\n\nThis OTP will expire in 10 minutes.\n\nThank you,\nNiranjan Enterprises", function ($message) use ($customerData) {
        $message->to($customerData['email'])
            ->subject('🔐 Customer Account Verification OTP - Niranjan Enterprises')
            ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), config('mail.from.name', 'Niranjan Enterprises'));
    });
    echo "SUCCESS: OTP email sent to {$customerData['email']}\n";
} catch (\Exception $e) {
    echo "ERROR: Failed to send OTP email: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Testing OTP Verification ===\n";

// 4. Test OTP verification logic
$testOtp = $otp; // Simulating correct OTP
echo "Testing with OTP: {$testOtp}\n";

if ($testOtp != $customerData['otp']) {
    echo "ERROR: Invalid OTP\n";
} else {
    echo "SUCCESS: OTP matches\n";
}

if (Carbon::now()->gt($customerData['otp_expires_at'])) {
    echo "ERROR: OTP expired\n";
} else {
    echo "SUCCESS: OTP not expired\n";
}

// 5. Test customer creation with exact data from controller
echo "\n=== Testing Customer Creation ===\n";
try {
    $customer = User::create([
        'name' => $customerData['name'],
        'email' => $customerData['email'],
        'contact_number' => $customerData['phone'], // Using contact_number like in controller
        'comapny_name' => $customerData['company_name'], // Using typo like in controller
        'pan_number' => $customerData['pan_number'],
        'aadhar_number' => $customerData['aadhar_number'],
        'department' => 'Customer', // Default department for customers
        'password' => $customerData['password'],
        'role' => $customerData['role'],
    ]);
    echo "SUCCESS: Customer created with ID: " . $customer->id . "\n";
    
    // Clean up
    $customer->delete();
    echo "Test customer deleted successfully.\n";
    
} catch (\Exception $e) {
    echo "ERROR: Customer creation failed: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
