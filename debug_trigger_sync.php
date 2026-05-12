<?php

echo "🔍 Debugging Trigger Sync Issue\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "1. Checking recent leads in NIRCRM database:\n";
    
    // Get most recent leads
    $recentLeads = \App\Models\Lead::orderBy('created_at', 'desc')->limit(10)->get();
    
    echo "   Total leads: " . \App\Models\Lead::count() . "\n";
    echo "   Recent leads (last 10):\n";
    
    foreach ($recentLeads as $lead) {
        echo "     ID: {$lead->id}, Name: " . substr($lead->name, 0, 30) . 
             ", Source: {$lead->source}, Created: {$lead->created_at}\n";
    }
    
    echo "\n2. Checking external sync records:\n";
    
    $syncRecords = \Illuminate\Support\Facades\DB::table('external_leads_sync')
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();
    
    echo "   Total sync records: " . \Illuminate\Support\Facades\DB::table('external_leads_sync')->count() . "\n";
    echo "   Recent sync records:\n";
    
    foreach ($syncRecords as $sync) {
        echo "     External ID: {$sync->external_lead_id}, Name: " . substr($sync->name, 0, 30) . 
             ", NIRCRM ID: {$sync->lead_id}, Synced: {$sync->last_synced_at}\n";
    }
    
    echo "\n3. Looking for leads with 'external_sync' source:\n";
    
    $externalSyncLeads = \App\Models\Lead::where('source', 'external_sync')->get();
    echo "   Found " . $externalSyncLeads->count() . " leads from external sync\n";
    
    foreach ($externalSyncLeads as $lead) {
        echo "     ID: {$lead->id}, Name: " . substr($lead->name, 0, 30) . 
             ", Created: {$lead->created_at}\n";
    }
    
    echo "\n4. Checking leads created in last 1 hour:\n";
    
    $recentHourLeads = \App\Models\Lead::where('created_at', '>', now()->subHour())
                                      ->orderBy('created_at', 'desc')
                                      ->get();
    
    echo "   Found " . $recentHourLeads->count() . " leads in last hour\n";
    
    foreach ($recentHourLeads as $lead) {
        echo "     ID: {$lead->id}, Name: " . substr($lead->name, 0, 30) . 
             ", Created: {$lead->created_at}\n";
    }
    
    echo "\n5. Testing Google Sheets page controller:\n";
    
    $controller = new \App\Http\Controllers\GoogleSheetsManagementController();
    $request = new \Illuminate\Http\Request();
    $response = $controller->index($request);
    
    if ($response instanceof \Illuminate\View\View) {
        $data = $response->getData();
        $pageData = $data['pageData'] ?? [];
        
        echo "   Controller returns " . count($pageData) . " leads for display\n";
        echo "   Page shows leads from position 1 to " . count($pageData) . "\n";
        
        // Check if any external_sync leads are in page data
        $externalInPage = 0;
        foreach ($pageData as $lead) {
            if ($lead->source === 'external_sync') {
                $externalInPage++;
            }
        }
        
        echo "   External sync leads in page: {$externalInPage}\n";
        
        if ($externalInPage > 0) {
            echo "   ✅ External sync leads are showing in page!\n";
        } else {
            echo "   ❌ External sync leads NOT showing in page\n";
            
            // Check if external_sync leads exist but not in page
            if ($externalSyncLeads->count() > 0) {
                echo "   ⚠️  External sync leads exist but not in page data\n";
                echo "   This could be due to:\n";
                echo "     - Pagination (leads are on page 2+)\n";
                echo "     - Ordering (leads are sorted by created_at desc)\n";
                echo "     - Filter issues\n";
            }
        }
    }
    
    echo "\n6. Manual test - Add external_sync lead directly:\n";
    
    // Add a test lead to verify system works
    $testLead = [
        'name' => 'External Sync Test Lead',
        'email' => 'external.test@example.com',
        'phone' => '9876543210',
        'company_name' => 'External Test Company',
        'lead_status' => 'cold',
        'source' => 'external_sync',
        'created_by' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ];
    
    $newLeadId = \Illuminate\Support\Facades\DB::table('leads')->insertGetId($testLead);
    echo "   ✅ Added test external_sync lead with ID: {$newLeadId}\n";
    
    // Check if it appears in controller
    $response2 = $controller->index($request);
    $data2 = $response2->getData();
    $pageData2 = $data2['pageData'] ?? [];
    
    $foundTestLead = false;
    foreach ($pageData2 as $lead) {
        if ($lead->id == $newLeadId) {
            $foundTestLead = true;
            break;
        }
    }
    
    if ($foundTestLead) {
        echo "   ✅ Test external_sync lead appears in page!\n";
        echo "   ✅ System is working correctly!\n";
    } else {
        echo "   ❌ Test external_sync lead NOT in page\n";
        echo "   ❌ There may be a system issue\n";
    }
    
    echo "\n7. Summary:\n";
    echo "   Total leads in database: " . \App\Models\Lead::count() . "\n";
    echo "   External sync leads: " . $externalSyncLeads->count() . "\n";
    echo "   Leads shown per page: " . count($pageData) . "\n";
    echo "   External leads in page: {$externalInPage}\n";
    echo "   Test lead ID: {$newLeadId}\n";
    
    echo "\n🎯 What to check:\n";
    echo "   1. Did you add a new lead to external database?\n";
    echo "   2. Is the trigger active? Run: SHOW TRIGGERS LIKE '%lead_sync%'\n";
    echo "   3. Check external database connection\n";
    echo "   4. Look for test lead ID {$newLeadId} in your page\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

?>
