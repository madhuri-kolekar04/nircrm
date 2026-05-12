<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging potential browser submission issues...\n";

try {
    // Check the most recent leads to see if any were created recently
    echo "1. Checking recent lead creation activity:\n";
    
    $recentLeads = \App\Models\Lead::orderBy('created_at', 'desc')->take(5)->get();
    
    if ($recentLeads->count() > 0) {
        echo "   Recent leads:\n";
        foreach ($recentLeads as $lead) {
            $timeAgo = \Carbon\Carbon::parse($lead->created_at)->diffForHumans();
            echo "   - ID: {$lead->id}, Name: {$lead->name}, Created: {$lead->created_at} ({$timeAgo})\n";
        }
    } else {
        echo "   No leads found in database!\n";
    }
    
    // Check if there are any leads created in the last 10 minutes
    echo "\n2. Checking for leads created in last 10 minutes:\n";
    
    $recentLeads10Min = \App\Models\Lead::where('created_at', '>=', \Carbon\Carbon::now()->subMinutes(10))->get();
    
    if ($recentLeads10Min->count() > 0) {
        echo "   Found {$recentLeads10Min->count()} leads created in last 10 minutes:\n";
        foreach ($recentLeads10Min as $lead) {
            echo "   - ID: {$lead->id}, Name: {$lead->name}, Email: " . ($lead->email ?? 'NULL') . "\n";
        }
        echo "   ✅ This indicates form submission IS working!\n";
    } else {
        echo "   ❌ No leads created in last 10 minutes.\n";
        echo "   This suggests form submission might not be working.\n";
    }
    
    // Test a simple manual creation to ensure database is working
    echo "\n3. Testing manual database creation:\n";
    
    $testLead = \App\Models\Lead::create([
        'name' => 'Manual Test ' . time(),
        'email' => 'manual@test.com',
        'lead_status' => 'hot',
        'source' => 'website',
        'priority' => 'high',
        'created_by' => 18,
    ]);
    
    echo "   ✅ Manual creation successful - ID: {$testLead->id}\n";
    
    // Verify it was saved
    $savedTestLead = \App\Models\Lead::find($testLead->id);
    echo "   ✅ Verification successful - Name: {$savedTestLead->name}\n";
    
    echo "\n4. Troubleshooting checklist:\n";
    echo "   If you're still experiencing issues, check:\n";
    echo "   \n";
    echo "   🔍 BROWSER ISSUES:\n";
    echo "   - Clear browser cache and cookies\n";
    echo "   - Check browser console for JavaScript errors (F12 → Console)\n";
    echo "   - Try using a different browser\n";
    echo "   - Check Network tab in F12 for failed requests\n";
    echo "   \n";
    echo "   🔍 FORM ISSUES:\n";
    echo "   - Make sure all required fields are filled (Name, Status, Source, Priority)\n";
    echo "   - Check if form validation is showing errors\n";
    echo "   - Verify CSRF token is present (view page source)\n";
    echo "   - Try submitting without JavaScript enabled\n";
    echo "   \n";
    echo "   🔍 SERVER ISSUES:\n";
    echo "   - Check Laravel logs: storage/logs/laravel.log\n";
    echo "   - Verify web server is running correctly\n";
    echo "   - Check if session is working\n";
    echo "   \n";
    echo "   🔍 ROUTE ISSUES:\n";
    echo "   - Run: php artisan route:list | grep leads\n";
    echo "   - Verify routes are registered correctly\n";
    echo "   - Check .htaccess or nginx configuration\n";
    
    echo "\n✅ DATABASE IS WORKING CORRECTLY!\n";
    echo "   The issue is likely in the browser or form submission process.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
