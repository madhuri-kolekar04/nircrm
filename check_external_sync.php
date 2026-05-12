<?php

echo "🔍 Checking External Database Sync Status\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "1. Current NIRCRM database status:\n";
    echo "   Total leads: " . \App\Models\Lead::count() . "\n";
    echo "   Recent leads (last 5):\n";
    
    $recentLeads = \App\Models\Lead::orderBy('created_at', 'desc')->limit(5)->get();
    foreach ($recentLeads as $lead) {
        echo "     - ID: {$lead->id}, Name: " . substr($lead->name, 0, 25) . ", Created: {$lead->created_at}\n";
    }
    
    echo "\n2. External sync table status:\n";
    echo "   Total sync records: " . \Illuminate\Support\Facades\DB::table('external_leads_sync')->count() . "\n";
    
    $syncRecords = \Illuminate\Support\Facades\DB::table('external_leads_sync')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
    echo "   Recent sync records:\n";
    foreach ($syncRecords as $sync) {
        echo "     - External ID: {$sync->external_lead_id}, Name: " . substr($sync->name, 0, 25) . ", Synced: {$sync->last_synced_at}\n";
    }
    
    echo "\n3. Looking for 'Kiran CRM Test':\n";
    
    // Check if it exists in main leads table
    $kiranInLeads = \App\Models\Lead::where('name', 'LIKE', '%Kiran CRM Test%')->get();
    echo "   In leads table: " . $kiranInLeads->count() . " records\n";
    
    // Check if it exists in sync table
    $kiranInSync = \Illuminate\Support\Facades\DB::table('external_leads_sync')
        ->where('name', 'LIKE', '%Kiran CRM Test%')
        ->get();
    echo "   In sync table: " . $kiranInSync->count() . " records\n";
    
    echo "\n4. Checking if triggers are set up:\n";
    
    // Check if we have external database connection configured
    $connections = config('database.connections');
    if (isset($connections['external'])) {
        echo "   ✅ External database connection configured\n";
        
        try {
            // Try to connect to external database
            \Illuminate\Support\Facades\DB::connection('external')->getPdo();
            echo "   ✅ Can connect to external database\n";
            
            // Check if external table exists
            $externalTables = \Illuminate\Support\Facades\Schema::connection('external')->getTableListing();
            echo "   External database tables: " . implode(', ', array_slice($externalTables, 0, 5)) . "\n";
            
        } catch (\Exception $e) {
            echo "   ❌ Cannot connect to external database: " . $e->getMessage() . "\n";
        }
    } else {
        echo "   ❌ External database connection NOT configured\n";
        echo "   Available connections: " . implode(', ', array_keys($connections)) . "\n";
    }
    
    echo "\n5. Manual sync test:\n";
    
    // Let's try to manually add "Kiran CRM Test" to see if it works
    $testLead = [
        'name' => 'Kiran CRM Test',
        'email' => 'kiran.test@example.com',
        'phone' => '1234567890',
        'company_name' => 'Test Company',
        'lead_status' => 'cold',
        'source' => 'external_sync',
        'created_by' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ];
    
    echo "   Adding test lead to check system...\n";
    
    $leadId = \Illuminate\Support\Facades\DB::table('leads')->insertGetId($testLead);
    echo "   ✅ Test lead added with ID: {$leadId}\n";
    
    // Add to sync table
    $syncData = [
        'external_database_name' => 'test_external',
        'external_table_name' => 'test_table',
        'external_lead_id' => 999,
        'lead_id' => $leadId,
        'name' => 'Kiran CRM Test',
        'email' => 'kiran.test@example.com',
        'phone' => '1234567890',
        'company_name' => 'Test Company',
        'lead_status' => 'cold',
        'source' => 'external_sync',
        'last_synced_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ];
    
    \Illuminate\Support\Facades\DB::table('external_leads_sync')->insert($syncData);
    echo "   ✅ Sync record added\n";
    
    echo "\n6. Verification:\n";
    
    // Check if it appears in the system
    $verifyLead = \App\Models\Lead::find($leadId);
    if ($verifyLead) {
        echo "   ✅ Test lead found in database\n";
        echo "   Name: {$verifyLead->name}\n";
        echo "   Email: {$verifyLead->email}\n";
        echo "   Should now appear in Google Sheets page!\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

?>
