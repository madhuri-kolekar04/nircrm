<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Employee;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

echo "=== SERVER EMAIL TROUBLESHOOTING ===\n\n";

// 1. Check Laravel Environment
echo "1. Laravel Environment Check:\n";
echo "   Environment: " . app()->environment() . "\n";
echo "   Debug Mode: " . (config('app.debug') ? 'ON' : 'OFF') . "\n";

// 2. Check Mail Configuration
echo "\n2. Mail Configuration:\n";
$mailConfig = [
    'default' => config('mail.default'),
    'driver' => config('mail.default'),
    'host' => config('mail.mailers.smtp.host'),
    'port' => config('mail.mailers.smtp.port'),
    'encryption' => config('mail.mailers.smtp.encryption'),
    'username' => config('mail.mailers.smtp.username'),
    'from_address' => config('mail.from.address'),
    'from_name' => config('mail.from.name'),
];

foreach ($mailConfig as $key => $value) {
    if ($key === 'password') {
        echo "   {$key}: [HIDDEN]\n";
    } else {
        echo "   {$key}: " . ($value ?: 'NOT SET') . "\n";
    }
}

// 3. Check Employees
echo "\n3. Employee Check:\n";
$employees = Employee::active()->get();
echo "   Active Employees: " . $employees->count() . "\n";
foreach ($employees as $employee) {
    echo "   - {$employee->name}: {$employee->email}\n";
}

// 4. Test Basic Mail Function
echo "\n4. Basic Mail Test:\n";
try {
    $testEmail = 'test@example.com'; // Change this to your test email
    Mail::raw('This is a test email from NIRCRM server', function($message) use ($testEmail) {
        $message->to($testEmail)
                ->subject('NIRCRM Server Email Test')
                ->from(config('mail.from.address'), config('mail.from.name'));
    });
    echo "   ✅ Basic mail sent successfully to {$testEmail}\n";
} catch (\Exception $e) {
    echo "   ❌ Mail test failed: " . $e->getMessage() . "\n";
}

// 5. Check Server Mail Logs
echo "\n5. Server Mail Logs:\n";
$logPath = storage_path('logs/laravel.log');
if (file_exists($logPath)) {
    $logs = file_get_contents($logPath);
    $emailLogs = [];
    $lines = explode("\n", $logs);
    
    foreach ($lines as $line) {
        if (strpos($line, 'mail') !== false || strpos($line, 'notification') !== false) {
            $emailLogs[] = $line;
        }
    }
    
    if (!empty($emailLogs)) {
        echo "   Recent email-related logs:\n";
        foreach (array_slice($emailLogs, -10) as $log) {
            echo "   " . trim($log) . "\n";
        }
    } else {
        echo "   No email-related logs found\n";
    }
} else {
    echo "   Log file not found\n";
}

echo "\n=== COMMON SERVER EMAIL ISSUES ===\n";
echo "1. Firewall blocking SMTP ports (25, 587, 465)\n";
echo "2. Server IP blacklisted by email providers\n";
echo "3. Missing SSL/TLS certificates\n";
echo "4. Incorrect SMTP credentials\n";
echo "5. Server requires SPF/DKIM records\n";
echo "6. Cloud provider restrictions (AWS, DigitalOcean, etc.)\n";

echo "\n=== QUICK FIXES ===\n";
echo "1. Use transactional email service (SendGrid, Mailgun, SES)\n";
echo "2. Configure SPF/DKIM/DMARC records\n";
echo "3. Check server firewall rules\n";
echo "4. Verify SMTP credentials work on server\n";
echo "5. Use app passwords for Gmail\n";

echo "\n=== TEST COMMANDS ===\n";
echo "Test SMTP connection:\n";
echo "   telnet smtp.gmail.com 587\n";
echo "   telnet your-smtp-host.com 587\n\n";

echo "Test Laravel mail:\n";
echo "   php artisan tinker\n";
echo "   Mail::raw('Test', function(\$m) { \$m->to('your@email.com')->subject('Test'); });\n\n";

echo "Check logs:\n";
echo "   tail -f storage/logs/laravel.log\n";

echo "\n=== TROUBLESHOOTING COMPLETE ===\n";
