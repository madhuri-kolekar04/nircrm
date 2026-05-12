<?php

echo "🔧 Adding lead_id column to external_leads_sync table...\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Add the lead_id column
    $sql = "ALTER TABLE external_leads_sync ADD COLUMN lead_id BIGINT UNSIGNED NULL AFTER external_lead_id";
    
    echo "Executing: ALTER TABLE external_leads_sync ADD COLUMN lead_id...\n";
    \Illuminate\Support\Facades\DB::unprepared($sql);
    echo "✅ lead_id column added successfully!\n";
    
    // Add index for lead_id
    $sql = "ALTER TABLE external_leads_sync ADD INDEX idx_lead_id (lead_id)";
    \Illuminate\Support\Facades\DB::unprepared($sql);
    echo "✅ lead_id index added successfully!\n";
    
    // Check table structure
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('external_leads_sync');
    echo "✅ Table now has " . count($columns) . " columns\n";
    echo "   Columns: " . implode(', ', array_slice($columns, 0, 10)) . "...\n";
    
    // Now add the test record
    echo "\n🔍 Adding test sync record for 'Kiran CRM Test'...\n";
    
    // First find the test lead we created
    $testLead = \Illuminate\Support\Facades\DB::table('leads')
        ->where('name', 'Kiran CRM Test')
        ->first();
    
    if ($testLead) {
        $syncData = [
            'external_database_name' => 'test_external',
            'external_table_name' => 'test_table',
            'external_lead_id' => 999,
            'lead_id' => $testLead->id,
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
        echo "✅ Sync record added successfully!\n";
        echo "   Lead ID: {$testLead->id}\n";
        echo "   External Lead ID: 999\n";
    } else {
        echo "❌ Test lead not found\n";
    }
    
    // Verify the sync record
    echo "\n🔍 Verifying sync record:\n";
    $syncRecord = \Illuminate\Support\Facades\DB::table('external_leads_sync')
        ->where('name', 'Kiran CRM Test')
        ->first();
    
    if ($syncRecord) {
        echo "✅ Sync record found:\n";
        echo "   ID: {$syncRecord->id}\n";
        echo "   Name: {$syncRecord->name}\n";
        echo "   Lead ID: {$syncRecord->lead_id}\n";
        echo "   External Lead ID: {$syncRecord->external_lead_id}\n";
        echo "   Last Synced: {$syncRecord->last_synced_at}\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

?>
