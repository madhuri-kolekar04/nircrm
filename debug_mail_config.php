<?php

// Simple mail configuration test
require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test mail configuration
echo "=== Mail Configuration Test ===\n\n";

echo "MAIL_MAILER: " . env('MAIL_MAILER', 'not set') . "\n";
echo "MAIL_HOST: " . env('MAIL_HOST', 'not set') . "\n";
echo "MAIL_PORT: " . env('MAIL_PORT', 'not set') . "\n";
echo "MAIL_USERNAME: " . (env('MAIL_USERNAME') ? 'set' : 'not set') . "\n";
echo "MAIL_PASSWORD: " . (env('MAIL_PASSWORD') ? 'set' : 'not set') . "\n";
echo "MAIL_ENCRYPTION: " . env('MAIL_ENCRYPTION', 'not set') . "\n";
echo "MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS', 'not set') . "\n";
echo "MAIL_FROM_NAME: " . env('MAIL_FROM_NAME', 'not set') . "\n";

echo "\n=== Config Values ===\n";
echo "Default Mailer: " . config('mail.default') . "\n";
echo "From Address: " . config('mail.from.address') . "\n";
echo "From Name: " . config('mail.from.name') . "\n";

echo "\n=== Testing Mail Driver ===\n";
try {
    $mailer = app('mailer');
    echo "Mail driver loaded successfully\n";
} catch (Exception $e) {
    echo "Error loading mail driver: " . $e->getMessage() . "\n";
}

echo "\n=== Done ===\n";
