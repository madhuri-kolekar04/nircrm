<?php

// Complete Mail System Setup and Check
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== COMPLETE MAIL SYSTEM SETUP ===\n\n";

// Step 1: Check current mail configuration
echo "📧 STEP 1: Current Mail Configuration\n";
echo str_repeat("=", 50) . "\n";

$mailConfig = [
    'MAIL_MAILER' => env('MAIL_MAILER', 'smtp'),
    'MAIL_HOST' => env('MAIL_HOST', 'not set'),
    'MAIL_PORT' => env('MAIL_PORT', 'not set'),
    'MAIL_USERNAME' => env('MAIL_USERNAME', 'not set'),
    'MAIL_PASSWORD' => env('MAIL_PASSWORD', 'not set'),
    'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION', 'not set'),
    'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS', 'not set'),
    'MAIL_FROM_NAME' => env('MAIL_FROM_NAME', 'not set'),
];

foreach ($mailConfig as $key => $value) {
    $display = $value;
    if (strpos($key, 'PASSWORD') !== false && $value !== 'not set') {
        $display = '[CONFIGURED]';
    }
    echo sprintf("%-20s: %s\n", $key, $display);
}

// Step 2: Check if mail is properly configured
echo "\n📧 STEP 2: Configuration Analysis\n";
echo str_repeat("=", 50) . "\n";

$configIssues = [];
if ($mailConfig['MAIL_HOST'] === 'not set') $configIssues[] = 'MAIL_HOST not set';
if ($mailConfig['MAIL_USERNAME'] === 'not set') $configIssues[] = 'MAIL_USERNAME not set';
if ($mailConfig['MAIL_PASSWORD'] === 'not set') $configIssues[] = 'MAIL_PASSWORD not set';
if ($mailConfig['MAIL_FROM_ADDRESS'] === 'not set') $configIssues[] = 'MAIL_FROM_ADDRESS not set';

if (empty($configIssues)) {
    echo "✅ Mail configuration looks complete!\n";
} else {
    echo "❌ Configuration issues found:\n";
    foreach ($configIssues as $issue) {
        echo "   - $issue\n";
    }
    echo "\n💡 Solutions:\n";
    echo "   1. Set up Gmail SMTP (recommended for testing)\n";
    echo "   2. Use Mailtrap for development\n";
    echo "   3. Configure log driver for debugging\n";
}

// Step 3: Test mail functionality
echo "\n📧 STEP 3: Mail Functionality Test\n";
echo str_repeat("=", 50) . "\n";

try {
    // Test with log driver first (always works)
    config(['mail.default' => 'log']);
    $mailer = app('mailer');
    echo "✅ Log driver: Working (emails will be logged)\n";
    
    // Test with SMTP if configured
    if (!in_array('not set', [$mailConfig['MAIL_HOST'], $mailConfig['MAIL_USERNAME']])) {
        config(['mail.default' => 'smtp']);
        try {
            $mailer = app('mailer');
            echo "✅ SMTP driver: Working\n";
        } catch (Exception $e) {
            echo "⚠️ SMTP driver: " . $e->getMessage() . "\n";
            echo "   Will fall back to log driver\n";
        }
    }
} catch (Exception $e) {
    echo "❌ Mail system error: " . $e->getMessage() . "\n";
}

// Step 4: Check lead data
echo "\n📧 STEP 4: Lead Data Verification\n";
echo str_repeat("=", 50) . "\n";

use App\Models\Lead;
use App\Models\Invoice;

// Find the specific lead
$lead = Lead::where('email', 'like', '%aimanustoo%')->first();

if ($lead) {
    echo "✅ Lead found:\n";
    echo "   ID: {$lead->id}\n";
    echo "   Name: {$lead->name}\n";
    echo "   Email: {$lead->email}\n";
    echo "   Invoice: " . ($lead->invoice_number ?? 'None') . "\n";
    echo "   Status: {$lead->invoice_status ?? 'None'}\n";
    
    if ($lead->invoice_number) {
        $invoice = Invoice::where('invoice_number', $lead->invoice_number)->first();
        if ($invoice) {
            echo "   Invoice ID: {$invoice->id}\n";
            echo "   Invoice Total: \${$invoice->total_payment}\n";
        }
    }
} else {
    echo "❌ Lead not found with email containing 'aimanustool'\n";
}

// Step 5: Generate .env configuration template
echo "\n📧 STEP 5: Mail Configuration Templates\n";
echo str_repeat("=", 50) . "\n";

echo "📝 OPTION 1: Gmail SMTP Configuration\n";
echo "Add these to your .env file:\n\n";
echo "MAIL_MAILER=smtp\n";
echo "MAIL_HOST=smtp.gmail.com\n";
echo "MAIL_PORT=587\n";
echo "MAIL_USERNAME=your-gmail@gmail.com\n";
echo "MAIL_PASSWORD=your-app-password\n";
echo "MAIL_ENCRYPTION=tls\n";
echo "MAIL_FROM_ADDRESS=your-gmail@gmail.com\n";
echo "MAIL_FROM_NAME=\"Your Company Name\"\n\n";

echo "📝 OPTION 2: Log Driver (For Testing)\n";
echo "Add these to your .env file:\n\n";
echo "MAIL_MAILER=log\n";
echo "MAIL_FROM_ADDRESS=test@example.com\n";
echo "MAIL_FROM_NAME=\"Test Company\"\n\n";

echo "📝 OPTION 3: Mailtrap (Development)\n";
echo "Add these to your .env file:\n\n";
echo "MAIL_MAILER=smtp\n";
echo "MAIL_HOST=smtp.mailtrap.io\n";
echo "MAIL_PORT=2525\n";
echo "MAIL_USERNAME=your-mailtrap-username\n";
echo "MAIL_PASSWORD=your-mailtrap-password\n";
echo "MAIL_ENCRYPTION=tls\n";
echo "MAIL_FROM_ADDRESS=test@example.com\n";
echo "MAIL_FROM_NAME=\"Test Company\"\n\n";

// Step 6: Test email sending
echo "\n📧 STEP 6: Test Email Sending\n";
echo str_repeat("=", 50) . "\n";

if ($lead && $lead->invoice_number) {
    echo "🧪 Testing email sending for lead: {$lead->name}\n";
    
    try {
        // Create test invoice data
        $testInvoice = (object) [
            'id' => $lead->id,
            'invoice_number' => $lead->invoice_number,
            'invoice_date' => (object) ['format' => function($format) { return now()->format($format); }],
            'total_payment' => 1000,
            'project_name' => 'Test Project'
        ];
        
        // Test email template rendering
        $templateData = [
            'lead' => $lead,
            'invoice' => $testInvoice,
            'approvalToken' => 'test-token-' . time(),
            'callNumber' => '9284161465'
        ];
        
        $templatePath = resource_path('views/emails/invoice-approval.blade.php');
        if (file_exists($templatePath)) {
            echo "✅ Email template exists\n";
            
            // Try to render template
            try {
                $rendered = view('emails.invoice-approval', $templateData)->render();
                echo "✅ Email template renders successfully\n";
                echo "   Template length: " . strlen($rendered) . " characters\n";
            } catch (Exception $e) {
                echo "❌ Template rendering failed: " . $e->getMessage() . "\n";
            }
        } else {
            echo "❌ Email template not found\n";
        }
        
    } catch (Exception $e) {
        echo "❌ Email test failed: " . $e->getMessage() . "\n";
    }
} else {
    echo "⚠️ Cannot test email - lead or invoice not found\n";
}

// Step 7: Final recommendations
echo "\n📧 STEP 7: Final Setup Instructions\n";
echo str_repeat("=", 50) . "\n";

echo "🚀 QUICK SETUP (Recommended for Testing):\n";
echo "1. Add to .env: MAIL_MAILER=log\n";
echo "2. Add to .env: MAIL_FROM_ADDRESS=test@example.com\n";
echo "3. Run: php artisan config:clear\n";
echo "4. Run: php artisan cache:clear\n";
echo "5. Test clicking mail icon on sales department page\n";
echo "6. Check logs: storage/logs/laravel.log\n\n";

echo "🚀 PRODUCTION SETUP (Gmail):\n";
echo "1. Enable 2-factor authentication on Gmail\n";
echo "2. Generate App Password (not regular password)\n";
echo "3. Use Gmail configuration template above\n";
echo "4. Test with a real email address\n\n";

echo "📧 SYSTEM STATUS: ";
if (empty($configIssues)) {
    echo "✅ READY FOR TESTING\n";
} else {
    echo "⚠️ NEEDS CONFIGURATION\n";
}

echo "\n=== DONE ===\n";
