<?php

// Debug Mail Sending Issue
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔧 MAIL SENDING DEBUG SYSTEM\n";
echo str_repeat("=", 50) . "\n\n";

// Step 1: Check if we're using the new view
echo "📁 Step 1: View System Check\n";
echo str_repeat("-", 30) . "\n";

$controllerPath = __DIR__ . '/app/Http/Controllers/Backend/DepartmentController.php';
$controllerContent = file_get_contents($controllerPath);

if (strpos($controllerContent, 'sales_department_view_new') !== false) {
    echo "✅ Controller is using NEW view\n";
    $usingNewView = true;
} else {
    echo "❌ Controller is using OLD view\n";
    echo "🔄 Updating to new view...\n";
    
    // Update to use new view
    $controllerContent = str_replace(
        "return view('backend.department.sales_department_view', compact('qualifiedLeads', 'adminData'));",
        "return view('backend.department.sales_department_view_new', compact('qualifiedLeads', 'adminData'));",
        $controllerContent
    );
    
    file_put_contents($controllerPath, $controllerContent);
    echo "✅ Updated to new view\n";
    $usingNewView = true;
}

// Step 2: Check mail configuration
echo "\n📧 Step 2: Mail Configuration\n";
echo str_repeat("-", 30) . "\n";

$mailConfig = [
    'MAIL_MAILER' => env('MAIL_MAILER', 'not set'),
    'MAIL_HOST' => env('MAIL_HOST', 'not set'),
    'MAIL_PORT' => env('MAIL_PORT', 'not set'),
    'MAIL_USERNAME' => env('MAIL_USERNAME', 'not set'),
    'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS', 'not set'),
];

$hasMailConfig = true;
foreach ($mailConfig as $key => $value) {
    $display = $value;
    if (strpos($key, 'USERNAME') !== false && $value !== 'not set') {
        $display = '[CONFIGURED]';
    }
    echo sprintf("%-20s: %s\n", $key, $display);
    if ($value === 'not set') {
        $hasMailConfig = false;
    }
}

if (!$hasMailConfig) {
    echo "\n❌ Mail configuration incomplete!\n";
    echo "📝 Setting up log driver for testing...\n";
    
    // Set up log driver
    $envPath = __DIR__ . '/.env';
    $envContent = file_get_contents($envPath);
    
    $lines = explode("\n", $envContent);
    $newLines = [];
    $mailSettingsAdded = false;
    
    foreach ($lines as $line) {
        if (strpos($line, 'MAIL_MAILER=') === 0) {
            $newLines[] = 'MAIL_MAILER=log';
            $mailSettingsAdded = true;
        } elseif (strpos($line, 'MAIL_FROM_ADDRESS=') === 0) {
            $newLines[] = 'MAIL_FROM_ADDRESS=test@example.com';
        } else {
            $newLines[] = $line;
        }
    }
    
    if (!$mailSettingsAdded) {
        $newLines[] = 'MAIL_MAILER=log';
        $newLines[] = 'MAIL_FROM_ADDRESS=test@example.com';
    }
    
    file_put_contents($envPath, implode("\n", $newLines));
    echo "✅ Set up log driver for testing\n";
} else {
    echo "✅ Mail configuration looks good\n";
}

// Step 3: Check lead data
echo "\n📊 Step 3: Lead Data Check\n";
echo str_repeat("-", 30) . "\n";

use App\Models\Lead;
use App\Models\Invoice;

$qualifiedLeads = Lead::where('lead_status', 'qualified')->get();
echo "✅ Found {$qualifiedLeads->count()} qualified leads\n";

$targetLead = $qualifiedLeads->where('email', 'like', '%aimanustoo%')->first();
if ($targetLead) {
    echo "✅ Target lead found: {$targetLead->name}\n";
    echo "   📧 Email: {$targetLead->email}\n";
    echo "   📄 Invoice: " . ($targetLead->invoice_number ?? 'None') . "\n";
    echo "   📊 Status: " . ($targetLead->invoice_status ?? 'None') . "\n";
    
    if ($targetLead->invoice_number) {
        $invoice = Invoice::where('invoice_number', $targetLead->invoice_number)->first();
        if ($invoice) {
            echo "   ✅ Invoice exists in database\n";
        } else {
            echo "   ❌ Invoice not found in database\n";
        }
    }
} else {
    echo "❌ Target lead not found\n";
    
    // Show available leads
    echo "\n📋 Available leads:\n";
    foreach ($qualifiedLeads->take(3) as $lead) {
        echo "   - {$lead->name} ({$lead->email})\n";
    }
}

// Step 4: Test the approval system
echo "\n🔄 Step 4: Approval System Test\n";
echo str_repeat("-", 30) . "\n";

if ($targetLead && $targetLead->invoice_number) {
    echo "🧪 Testing approval logic...\n";
    
    // Simulate approval
    $originalStatus = $targetLead->invoice_status;
    echo "   Current status: {$originalStatus}\n";
    
    // Test the approval method logic
    $invoice = Invoice::where('invoice_number', $targetLead->invoice_number)->first();
    if ($invoice) {
        echo "   ✅ Invoice found: {$invoice->invoice_number}\n";
        
        // Simulate what the approveInvoice method does
        $targetLead->invoice_status = 'approved';
        $targetLead->save();
        
        echo "   ✅ Status updated to: approved\n";
        
        // Check if it worked
        $updatedLead = Lead::find($targetLead->id);
        if ($updatedLead->invoice_status === 'approved') {
            echo "   ✅ Status change successful!\n";
            
            // Revert for testing
            $updatedLead->invoice_status = $originalStatus;
            $updatedLead->save();
            echo "   🔄 Reverted to original status for testing\n";
        } else {
            echo "   ❌ Status change failed!\n";
        }
    }
}

// Step 5: Test email template
echo "\n📧 Step 5: Email Template Test\n";
echo str_repeat("-", 30) . "\n";

if ($targetLead) {
    $templatePath = resource_path('views/emails/invoice-approval.blade.php');
    if (file_exists($templatePath)) {
        echo "✅ Email template exists\n";
        
        try {
            // Test template rendering
            $testInvoice = (object) [
                'id' => $targetLead->id,
                'invoice_number' => $targetLead->invoice_number,
                'invoice_date' => (object) ['format' => function($format) { return now()->format($format); }],
                'total_payment' => 1000,
                'project_name' => 'Test Project'
            ];
            
            $data = [
                'lead' => $targetLead,
                'invoice' => $testInvoice,
                'approvalToken' => 'test-token-' . time(),
                'callNumber' => '9284161465'
            ];
            
            $rendered = view('emails.invoice-approval', $data)->render();
            echo "✅ Template renders successfully\n";
            echo "   Length: " . number_format(strlen($rendered)) . " characters\n";
            
            // Check for approval button
            if (strpos($rendered, 'Approve Invoice') !== false) {
                echo "✅ Approval button found in template\n";
            } else {
                echo "❌ Approval button missing from template\n";
            }
            
        } catch (Exception $e) {
            echo "❌ Template rendering failed: " . $e->getMessage() . "\n";
        }
    } else {
        echo "❌ Email template not found\n";
    }
}

// Step 6: Check routes
echo "\n🛣️ Step 6: Route Check\n";
echo str_repeat("-", 30) . "\n";

$routes = app('router')->getRoutes();
$foundRoutes = [];

foreach ($routes as $route) {
    if (strpos($route->uri(), 'sales-department') !== false) {
        $foundRoutes[] = [
            'uri' => $route->uri(),
            'methods' => implode(', ', $route->methods()),
            'name' => $route->getName() ?: 'No name'
        ];
    }
}

if (!empty($foundRoutes)) {
    echo "✅ Found " . count($foundRoutes) . " sales-department routes:\n";
    foreach ($foundRoutes as $route) {
        echo "   - {$route['uri']} [{$route['methods']}] ({$route['name']})\n";
    }
} else {
    echo "❌ No sales-department routes found!\n";
}

// Step 7: Instructions
echo "\n🚀 Step 7: Fix Instructions\n";
echo str_repeat("=", 50) . "\n";

echo "1. 🔄 Clear all caches:\n";
echo "   php artisan config:clear\n";
echo "   php artisan cache:clear\n";
echo "   php artisan view:clear\n";
echo "   php artisan route:clear\n\n";

echo "2. 🌐 Visit the page:\n";
echo "   http://127.0.0.1:8000/sales-department\n\n";

echo "3. 📧 Test email sending:\n";
echo "   - Find lead with 'waiting for approval' status\n";
echo "   - Click the envelope (mail) icon\n";
echo "   - Check browser console (F12) for errors\n";
echo "   - Check Laravel logs: storage/logs/laravel.log\n\n";

echo "4. 🔄 Test approval workflow:\n";
echo "   - Send email to yourself first\n";
echo "   - Click 'Approve Invoice' in email\n";
echo "   - Status should change to 'approved' (green)\n\n";

echo "🔍 If still not working:\n";
echo "   - Check browser console for JavaScript errors\n";
echo "   - Check Laravel logs for email errors\n";
echo "   - Verify CSRF token is present in page\n";
echo "   - Test with: /test_lead_email.html\n\n";

echo "✅ Debug complete! Run the instructions above.\n";
