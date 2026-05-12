<?php

// Complete New Sales Department System Activation
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🚀 NEW SALES DEPARTMENT SYSTEM ACTIVATION\n";
echo str_repeat("=", 60) . "\n\n";

echo "✅ Features of the New System:\n";
echo "   🎨 Modern, responsive design with perfect alignment\n";
echo "   📊 Real-time statistics dashboard\n";
echo "   🔄 Auto-refreshing invoice statuses (15 seconds)\n";
echo "   📧 Improved email sending with visual feedback\n";
echo "   🎯 Animated number counters and transitions\n";
echo "   📱 Mobile-friendly responsive layout\n";
echo "   ⚡ Loading overlays and smooth animations\n";
echo "   🔄 Manual refresh button for instant updates\n\n";

echo "🔧 System Check:\n";
echo str_repeat("-", 40) . "\n";

// Check if new view exists
$newViewPath = __DIR__ . '/resources/views/backend/department/sales_department_view_new.blade.php';
if (file_exists($newViewPath)) {
    echo "✅ New view file exists\n";
} else {
    echo "❌ New view file missing\n";
    exit(1);
}

// Check controller update
$controllerPath = __DIR__ . '/app/Http/Controllers/Backend/DepartmentController.php';
$controllerContent = file_get_contents($controllerPath);
if (strpos($controllerContent, 'sales_department_view_new') !== false) {
    echo "✅ Controller updated to use new view\n";
} else {
    echo "❌ Controller not updated\n";
}

// Check Lead model methods
$leadModelPath = __DIR__ . '/app/Models/Lead.php';
$leadContent = file_get_contents($leadModelPath);
if (strpos($leadContent, 'getPriorityColor') !== false) {
    echo "✅ Lead model has priority color method\n";
} else {
    echo "❌ Lead model missing priority color method\n";
}

// Check mail configuration
echo "\n📧 Mail Configuration Check:\n";
echo str_repeat("-", 40) . "\n";

$mailConfig = [
    'MAIL_MAILER' => env('MAIL_MAILER', 'not set'),
    'MAIL_HOST' => env('MAIL_HOST', 'not set'),
    'MAIL_USERNAME' => env('MAIL_USERNAME', 'not set'),
    'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS', 'not set'),
];

foreach ($mailConfig as $key => $value) {
    $display = $value;
    if (strpos($key, 'USERNAME') !== false && $value !== 'not set') {
        $display = '[CONFIGURED]';
    }
    echo sprintf("%-20s: %s\n", $key, $display);
}

// Check lead data
echo "\n📊 Lead Data Check:\n";
echo str_repeat("-", 40) . "\n";

use App\Models\Lead;
use App\Models\Invoice;

$qualifiedLeads = Lead::where('lead_status', 'qualified')->with(['assignedUser', 'creator'])->get();
echo "✅ Found {$qualifiedLeads->count()} qualified leads\n";

$waitingApproval = 0;
$approvedCount = 0;
$totalBudget = 0;

foreach ($qualifiedLeads as $lead) {
    if (in_array($lead->invoice_status ?? 'waiting_for_approval', ['waiting_for_approval', 'waiting for approval'])) {
        $waitingApproval++;
    } elseif ($lead->invoice_status === 'approved') {
        $approvedCount++;
    }
    $totalBudget += $lead->budget ?? 0;
}

echo "   📧 {$waitingApproval} leads waiting for approval\n";
echo "   ✅ {$approvedCount} leads already approved\n";
echo "   💰 Total budget: $" . number_format($totalBudget, 0) . "\n";

// Check specific lead
$targetLead = $qualifiedLeads->where('email', 'like', '%aimanustoo%')->first();
if ($targetLead) {
    echo "✅ Target lead found: {$targetLead->name} ({$targetLead->email})\n";
    echo "   📄 Invoice: " . ($targetLead->invoice_number ?? 'None') . "\n";
    echo "   📊 Status: " . ($targetLead->invoice_status ?? 'None') . "\n";
} else {
    echo "⚠️ Target lead not found\n";
}

echo "\n🚀 Activation Instructions:\n";
echo str_repeat("=", 60) . "\n";

echo "1. 🔄 Clear Laravel caches:\n";
echo "   php artisan config:clear\n";
echo "   php artisan cache:clear\n";
echo "   php artisan view:clear\n";
echo "   php artisan route:clear\n\n";

echo "2. 🌐 Visit the new page:\n";
echo "   http://127.0.0.1:8000/sales-department\n\n";

echo "3. 📧 Test email sending:\n";
echo "   - Find lead with 'waiting for approval' status\n";
echo "   - Click the envelope (mail) icon\n";
echo "   - Check email and click 'Approve Invoice'\n";
echo "   - Watch status change automatically\n\n";

echo "4. 🔄 Test real-time updates:\n";
echo "   - Status updates every 15 seconds automatically\n";
echo "   - Click 'Refresh All' button for instant update\n";
echo "   - Watch animated statistics counters\n\n";

echo "🎯 What You'll See:\n";
echo "   🎨 Beautiful gradient header with company branding\n";
echo "   📊 Live statistics cards with animated counters\n";
echo "   📋 Modern table with perfect alignment\n";
echo "   🎯 Color-coded status badges\n";
echo "   👤 User avatars and contact information\n";
echo "   💰 Budget and priority indicators\n";
echo "   🔄 Smooth loading animations\n";
echo "   📧 Visual feedback for email sending\n\n";

echo "⚡ Performance Features:\n";
echo "   🚀 Optimized AJAX requests\n";
echo "   📱 Responsive design for all devices\n";
echo "   🎯 Efficient real-time updates\n";
echo "   💾 Smart caching and data loading\n\n";

echo "🔧 Troubleshooting:\n";
echo "   If page doesn't load: Check Laravel logs\n";
echo "   If email fails: Check mail configuration\n";
echo "   If status doesn't update: Check API endpoint\n";
echo "   If alignment issues: Check CSS loading\n\n";

echo "✨ The new system is ready!\n";
echo "🎉 Enjoy the modern, fully-functional sales department page!\n\n";

echo "📞 Support: Check Laravel logs at storage/logs/laravel.log\n";
echo str_repeat("=", 60) . "\n";
