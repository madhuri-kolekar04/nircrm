<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Email Configuration Check ===\n\n";

// Check mail configuration
$mailConfig = [
    'MAIL_MAILER' => env('MAIL_MAILER', 'not set'),
    'MAIL_HOST' => env('MAIL_HOST', 'not set'),
    'MAIL_PORT' => env('MAIL_PORT', 'not set'),
    'MAIL_USERNAME' => env('MAIL_USERNAME', 'not set'),
    'MAIL_PASSWORD' => env('MAIL_PASSWORD', 'not set') ? '[hidden]' : 'not set',
    'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION', 'not set'),
    'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS', 'not set'),
    'MAIL_FROM_NAME' => env('MAIL_FROM_NAME', 'not set'),
];

echo "Current Mail Configuration:\n";
foreach ($mailConfig as $key => $value) {
    echo "- {$key}: {$value}\n";
}

echo "\n=== Issues Found ===\n";

$issues = [];

if (env('MAIL_MAILER') === 'log') {
    $issues[] = "MAIL_MAILER is set to 'log' - emails are only logged, not sent";
}

if (!env('MAIL_HOST')) {
    $issues[] = "MAIL_HOST is not configured";
}

if (!env('MAIL_USERNAME')) {
    $issues[] = "MAIL_USERNAME is not configured";
}

if (!env('MAIL_PASSWORD')) {
    $issues[] = "MAIL_PASSWORD is not configured";
}

if (!env('MAIL_FROM_ADDRESS')) {
    $issues[] = "MAIL_FROM_ADDRESS is not configured";
}

if (empty($issues)) {
    echo "✅ No configuration issues found!\n";
    echo "\nTo test email sending, run:\n";
    echo "php artisan tinker\n";
    echo "Mail::raw('Test email', function(\$message) { \$message->to('your-email@example.com')->subject('Test'); });\n";
} else {
    echo "❌ Configuration issues:\n";
    foreach ($issues as $issue) {
        echo "- {$issue}\n";
    }
    
    echo "\n=== Solution ===\n";
    echo "To fix email notifications, update your .env file with:\n\n";
    echo "MAIL_MAILER=smtp\n";
    echo "MAIL_HOST=smtp.gmail.com\n";
    echo "MAIL_PORT=587\n";
    echo "MAIL_USERNAME=your-email@gmail.com\n";
    echo "MAIL_PASSWORD=your-app-password\n";
    echo "MAIL_ENCRYPTION=tls\n";
    echo "MAIL_FROM_ADDRESS=your-email@gmail.com\n";
    echo "MAIL_FROM_NAME=NIRCRM\n";
    echo "\nNote: For Gmail, use an App Password, not your regular password.\n";
}

echo "\n=== Check Complete ===\n";
