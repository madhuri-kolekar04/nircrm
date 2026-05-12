<?php

echo "🔍 Debug: Checking for 'Kiran CRM Test' lead\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "1. Checking NIRCRM leads table for 'Kiran CRM Test':\n";
    
    $kiranLeads = \App\Models\Lead::where('name', 'LIKE', '%Kiran%')
                                   ->orWhere('name', 'LIKE', '%kiran%')
                                   ->get();
    
    echo "Found " . $kiranLeads->count() . " leads with 'Kiran' in name:\n";
    
    foreach ($kiranLeads as $lead) {
        echo "  ID: {$lead->id}\n";
        echo "  Name: {$lead->name}\n";
        echo "  Email: {$lead->email}\n";
        echo "  Phone: {$lead->phone}\n";
        echo "  Company: {$lead->company_name}\n";
        echo "  Status: {$lead->lead_status}\n";
        echo "  Source: {$lead->source}\n";
        echo "  Created: {$lead->created_at}\n";
        echo "  Updated: {$lead->updated_at}\n";
        echo "  -------------------\n";
    }
    
    echo "\n2. Checking external_leads_sync table:\n";
    
    $syncRecords = \Illuminate\Support\Facades\DB::table('external_leads_sync')
        ->where('name', 'LIKE', '%Kiran%')
        ->orWhere('name', 'LIKE', '%kiran%')
        ->get();
    
    echo "Found " . $syncRecords->count() . " sync records with 'Kiran' in name:\n";
    
    foreach ($syncRecords as $sync) {
        echo "  Sync ID: {$sync->id}\n";
        echo "  External DB: {$sync->external_database_name}\n";
        echo "  External Table: {$sync->external_table_name}\n";
        echo "  External Lead ID: {$sync->external_lead_id}\n";
        echo "  NIRCRM Lead ID: {$sync->lead_id}\n";
        echo "  Name: {$sync->name}\n";
        echo "  Email: {$sync->email}\n";
        echo "  Last Synced: {$sync->last_synced_at}\n";
        echo "  Created: {$sync->created_at}\n";
        echo "  -------------------\n";
    }
    
    echo "\n3. Checking all recent leads (last 10):\n";
    
    $recentLeads = \App\Models\Lead::orderBy('created_at', 'desc')
                                   ->limit(10)
                                   ->get();
    
    foreach ($recentLeads as $lead) {
        echo "  ID: {$lead->id}, Name: " . substr($lead->name, 0, 30) . 
             ", Created: {$lead->created_at}\n";
    }
    
    echo "\n4. Total counts:\n";
    echo "  Total leads in NIRCRM: " . \App\Models\Lead::count() . "\n";
    echo "  Total sync records: " . \Illuminate\Support\Facades\DB::table('external_leads_sync')->count() . "\n";
    
    echo "\n5. Checking if triggers exist:\n";
    
    // Check if we can connect to external database
    try {
        // Try to get external connection info
        $externalConnections = config('database.connections');
        echo "  Available database connections: " . implode(', ', array_keys($externalConnections)) . "\n";
        
        if (isset($externalConnections['external'])) {
            echo "  External connection configured: Yes\n";
        } else {
            echo "  External connection configured: No\n";
        }
    } catch (\Exception $e) {
        echo "  Error checking connections: " . $e->getMessage() . "\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

?>
