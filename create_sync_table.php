<?php

echo "🔧 Creating external_leads_sync table manually...\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Create the table manually with proper index names
    $sql = "
        CREATE TABLE IF NOT EXISTS external_leads_sync (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            external_database_name VARCHAR(255) NOT NULL COMMENT 'Name of the external database',
            external_table_name VARCHAR(255) NOT NULL COMMENT 'Name of the external table',
            external_lead_id BIGINT UNSIGNED NOT NULL COMMENT 'ID from external database',
            lead_id BIGINT UNSIGNED NULL COMMENT 'NIRCRM lead ID',
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NULL,
            phone VARCHAR(255) NULL,
            company_name VARCHAR(255) NULL,
            website VARCHAR(255) NULL,
            address TEXT NULL,
            city VARCHAR(255) NULL,
            state VARCHAR(255) NULL,
            country VARCHAR(255) NULL,
            pincode VARCHAR(255) NULL,
            industry VARCHAR(255) NULL,
            lead_status VARCHAR(255) DEFAULT 'cold',
            source VARCHAR(255) DEFAULT 'external_sync',
            description TEXT NULL,
            budget DECIMAL(12,2) NULL,
            assigned_to BIGINT UNSIGNED NULL,
            follow_up_date DATE NULL,
            customer_panel BOOLEAN DEFAULT FALSE,
            invoice_status VARCHAR(255) NULL,
            invoice_number VARCHAR(255) NULL,
            invoice_created_at TIMESTAMP NULL,
            notes TEXT NULL,
            priority VARCHAR(255) DEFAULT 'medium',
            created_by BIGINT UNSIGNED NULL,
            department VARCHAR(255) NULL,
            department_id BIGINT UNSIGNED NULL,
            business_type VARCHAR(255) NULL,
            primary_goal VARCHAR(255) NULL,
            score INT NULL,
            tier VARCHAR(255) NULL,
            submitted_at TIMESTAMP NULL,
            audit_report TEXT NULL,
            audit_report_plain TEXT NULL,
            last_synced_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            
            INDEX idx_external_db_lead (external_database_name(100), external_lead_id),
            INDEX idx_last_synced (last_synced_at),
            INDEX idx_created (created_at),
            INDEX idx_lead_id (lead_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    echo "Executing SQL to create table...\n";
    \Illuminate\Support\Facades\DB::unprepared($sql);
    echo "✅ Table created successfully!\n";
    
    // Check if table exists now
    $tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES LIKE "external_leads_sync"');
    if (!empty($tables)) {
        echo "✅ Table exists in database\n";
        
        // Check table structure
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing('external_leads_sync');
        echo "✅ Table has " . count($columns) . " columns\n";
        
        // Check for Kiran CRM Test specifically
        echo "\n🔍 Checking for 'Kiran CRM Test' in sync table:\n";
        
        $kiranSync = \Illuminate\Support\Facades\DB::table('external_leads_sync')
            ->where('name', 'LIKE', '%Kiran%')
            ->orWhere('name', 'LIKE', '%kiran%')
            ->get();
        
        echo "Found " . $kiranSync->count() . " sync records with 'Kiran'\n";
        
        foreach ($kiranSync as $sync) {
            echo "  - {$sync->name} (External ID: {$sync->external_lead_id}, NIRCRM ID: {$sync->lead_id})\n";
        }
        
    } else {
        echo "❌ Table was not created\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

?>
