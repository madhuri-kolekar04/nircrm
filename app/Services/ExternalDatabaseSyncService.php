<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Models\Lead;

class ExternalDatabaseSyncService
{
    /**
     * Sync leads from external database to NIRCRM
     */
    public function syncFromExternalDatabase($externalDbConfig)
    {
        try {
            // Configure external database connection
            config([
                'database.connections.external' => [
                    'driver' => 'mysql',
                    'host' => $externalDbConfig['host'],
                    'port' => $externalDbConfig['port'] ?? '3306',
                    'database' => $externalDbConfig['database'],
                    'username' => $externalDbConfig['username'],
                    'password' => $externalDbConfig['password'],
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => '',
                    'strict' => true,
                    'engine' => null,
                ]
            ]);

            // Get external leads
            $externalLeads = DB::connection('external')->table($externalDbConfig['table'])
                ->where('created_at', '>', now()->subHours(1)) // Get recent leads
                ->get();

            $syncedCount = 0;
            $updatedCount = 0;
            $errors = [];

            foreach ($externalLeads as $externalLead) {
                try {
                    // Check if already synced
                    $existingSync = DB::table('external_leads_sync')
                        ->where('external_database_name', $externalDbConfig['database'])
                        ->where('external_lead_id', $externalLead->id)
                        ->first();

                    if ($existingSync) {
                        // Update existing lead
                        $leadData = $this->mapExternalToLeadFields($externalLead, $externalDbConfig);
                        Lead::where('id', $existingSync->lead_id)->update($leadData);
                        
                        // Update sync record
                        DB::table('external_leads_sync')
                            ->where('id', $existingSync->id)
                            ->update(['last_synced_at' => now()]);
                        
                        $updatedCount++;
                    } else {
                        // Create new lead
                        $leadData = $this->mapExternalToLeadFields($externalLead, $externalDbConfig);
                        $leadData['source'] = 'external_sync';
                        $leadData['lead_status'] = $leadData['lead_status'] ?? 'cold';
                        $leadData['priority'] = $leadData['priority'] ?? 'medium';
                        
                        $lead = Lead::create($leadData);
                        
                        // Create sync record
                        DB::table('external_leads_sync')->insert([
                            'external_database_name' => $externalDbConfig['database'],
                            'external_table_name' => $externalDbConfig['table'],
                            'external_lead_id' => $externalLead->id,
                            'lead_id' => $lead->id,
                            'last_synced_at' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        
                        $syncedCount++;
                    }
                } catch (\Exception $e) {
                    $errors[] = "External Lead ID {$externalLead->id}: " . $e->getMessage();
                }
            }

            return [
                'success' => true,
                'synced_count' => $syncedCount,
                'updated_count' => $updatedCount,
                'errors' => $errors
            ];

        } catch (\Exception $e) {
            Log::error('External database sync error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Map external lead data to NIRCRM lead fields
     */
    private function mapExternalToLeadFields($externalLead, $externalDbConfig)
    {
        // Default field mapping - customize based on your external database structure
        return [
            'name' => $externalLead->name ?? $externalLead->full_name ?? $externalLead->contact_name ?? 'Unknown',
            'email' => $externalLead->email ?? null,
            'phone' => $externalLead->phone ?? $externalLead->mobile ?? $externalLead->whatsapp ?? null,
            'company_name' => $externalLead->company_name ?? $externalLead->business_name ?? $externalLead->company ?? null,
            'website' => $externalLead->website ?? $externalLead->website_url ?? null,
            'address' => $externalLead->address ?? null,
            'city' => $externalLead->city ?? null,
            'state' => $externalLead->state ?? null,
            'country' => $externalLead->country ?? null,
            'pincode' => $externalLead->pincode ?? $externalLead->postal_code ?? null,
            'industry' => $externalLead->industry ?? null,
            'lead_status' => $externalLead->lead_status ?? $externalLead->status ?? 'cold',
            'description' => $externalLead->description ?? $externalLead->message ?? null,
            'budget' => $externalLead->budget ?? null,
            'business_type' => $externalLead->business_type ?? null,
            'primary_goal' => $externalLead->primary_goal ?? null,
            'score' => $externalLead->score ?? null,
            'tier' => $externalLead->tier ?? null,
            'submitted_at' => $externalLead->submitted_at ?? $externalLead->created_at ?? now(),
            'audit_report' => $externalLead->audit_report ?? null,
            'audit_report_plain' => $externalLead->audit_report_plain ?? null,
            'created_by' => 1, // Default admin user
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Create database trigger for automatic sync
     */
    public function createDatabaseTrigger($externalDbConfig)
    {
        $triggerName = "after_insert_lead_sync";
        $databaseName = $externalDbConfig['database'];
        $tableName = $externalDbConfig['table'];

        $triggerSql = "
            DELIMITER //
            CREATE TRIGGER IF NOT EXISTS {$triggerName}
            AFTER INSERT ON {$tableName}
            FOR EACH ROW
            BEGIN
                -- Insert into sync queue table
                INSERT INTO nircrm.external_leads_sync_queue (
                    external_database_name,
                    external_table_name,
                    external_lead_id,
                    action_type,
                    created_at
                ) VALUES (
                    '{$databaseName}',
                    '{$tableName}',
                    NEW.id,
                    'INSERT',
                    NOW()
                );
            END//
            DELIMITER ;
        ";

        try {
            DB::connection('external')->unprepared($triggerSql);
            return ['success' => true, 'message' => 'Database trigger created successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Create SQL commands for manual setup
     */
    public function generateSQLCommands($externalDbConfig)
    {
        $databaseName = $externalDbConfig['database'];
        $tableName = $externalDbConfig['table'];
        $nircrmDatabase = env('DB_DATABASE');

        return [
            'create_sync_table' => "
                USE {$nircrmDatabase};
                
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
                    
                    INDEX idx_external_id (external_database_name, external_lead_id),
                    INDEX idx_last_synced (last_synced_at),
                    INDEX idx_created (created_at)
                );
            ",
            
            'create_trigger' => "
                USE {$databaseName};
                
                DELIMITER //
                DROP TRIGGER IF EXISTS after_insert_lead_sync//
                
                CREATE TRIGGER after_insert_lead_sync
                AFTER INSERT ON {$tableName}
                FOR EACH ROW
                BEGIN
                    -- Insert into NIRCRM sync table
                    INSERT INTO {$nircrmDatabase}.external_leads_sync (
                        external_database_name,
                        external_table_name,
                        external_lead_id,
                        name,
                        email,
                        phone,
                        company_name,
                        website,
                        address,
                        city,
                        state,
                        country,
                        pincode,
                        industry,
                        lead_status,
                        source,
                        description,
                        budget,
                        business_type,
                        primary_goal,
                        score,
                        tier,
                        submitted_at,
                        audit_report,
                        audit_report_plain,
                        created_by,
                        created_at,
                        updated_at
                    ) VALUES (
                        '{$databaseName}',
                        '{$tableName}',
                        NEW.id,
                        COALESCE(NEW.name, NEW.full_name, NEW.contact_name, 'Unknown'),
                        NEW.email,
                        COALESCE(NEW.phone, NEW.mobile, NEW.whatsapp),
                        COALESCE(NEW.company_name, NEW.business_name, NEW.company),
                        COALESCE(NEW.website, NEW.website_url),
                        NEW.address,
                        NEW.city,
                        NEW.state,
                        NEW.country,
                        COALESCE(NEW.pincode, NEW.postal_code),
                        NEW.industry,
                        COALESCE(NEW.lead_status, NEW.status, 'cold'),
                        'external_sync',
                        NEW.description,
                        NEW.budget,
                        NEW.business_type,
                        NEW.primary_goal,
                        NEW.score,
                        NEW.tier,
                        COALESCE(NEW.submitted_at, NEW.created_at, NOW()),
                        NEW.audit_report,
                        NEW.audit_report_plain,
                        1,
                        NOW(),
                        NOW()
                    );
                END//
                DELIMITER ;
            ",
            
            'create_update_trigger' => "
                USE {$databaseName};
                
                DELIMITER //
                DROP TRIGGER IF EXISTS after_update_lead_sync//
                
                CREATE TRIGGER after_update_lead_sync
                AFTER UPDATE ON {$tableName}
                FOR EACH ROW
                BEGIN
                    -- Update existing sync record
                    UPDATE {$nircrmDatabase}.external_leads_sync
                    SET 
                        name = COALESCE(NEW.name, NEW.full_name, NEW.contact_name, 'Unknown'),
                        email = NEW.email,
                        phone = COALESCE(NEW.phone, NEW.mobile, NEW.whatsapp),
                        company_name = COALESCE(NEW.company_name, NEW.business_name, NEW.company),
                        website = COALESCE(NEW.website, NEW.website_url),
                        address = NEW.address,
                        city = NEW.city,
                        state = NEW.state,
                        country = NEW.country,
                        pincode = COALESCE(NEW.pincode, NEW.postal_code),
                        industry = NEW.industry,
                        lead_status = COALESCE(NEW.lead_status, NEW.status, 'cold'),
                        description = NEW.description,
                        budget = NEW.budget,
                        business_type = NEW.business_type,
                        primary_goal = NEW.primary_goal,
                        score = NEW.score,
                        tier = NEW.tier,
                        submitted_at = COALESCE(NEW.submitted_at, NEW.created_at, NOW()),
                        audit_report = NEW.audit_report,
                        audit_report_plain = NEW.audit_report_plain,
                        updated_at = NOW(),
                        last_synced_at = NOW()
                    WHERE external_database_name = '{$databaseName}'
                    AND external_table_name = '{$tableName}'
                    AND external_lead_id = NEW.id;
                END//
                DELIMITER ;
            ",
            
            'create_procedure' => "
                USE {$nircrmDatabase};
                
                DELIMITER //
                DROP PROCEDURE IF EXISTS sync_external_leads_to_nircrm//
                
                CREATE PROCEDURE sync_external_leads_to_nircrm()
                BEGIN
                    DECLARE done INT DEFAULT FALSE;
                    DECLARE sync_id, external_lead_id, lead_id_val BIGINT;
                    DECLARE sync_db_name, sync_table_name VARCHAR(255);
                    DECLARE sync_name, sync_email, sync_phone, sync_company VARCHAR(255);
                    DECLARE sync_lead_status VARCHAR(255);
                    DECLARE sync_cursor CURSOR FOR 
                        SELECT id, external_database_name, external_table_name, external_lead_id, 
                               name, email, phone, company_name, lead_status
                        FROM external_leads_sync 
                        WHERE lead_id IS NULL 
                        OR last_synced_at < DATE_SUB(NOW(), INTERVAL 1 HOUR);
                    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
                    
                    OPEN sync_cursor;
                    
                    read_loop: LOOP
                        FETCH sync_cursor INTO sync_id, sync_db_name, sync_table_name, external_lead_id,
                                              sync_name, sync_email, sync_phone, sync_company, sync_lead_status;
                        IF done THEN
                            LEAVE read_loop;
                        END IF;
                        
                        -- Insert or update lead in NIRCRM
                        INSERT INTO leads (
                            name, email, phone, company_name, lead_status, 
                            source, created_by, created_at, updated_at
                        ) VALUES (
                            sync_name, sync_email, sync_phone, sync_company, 
                            sync_lead_status, 'external_sync', 1, NOW(), NOW()
                        )
                        ON DUPLICATE KEY UPDATE
                            name = VALUES(name),
                            email = VALUES(email),
                            phone = VALUES(phone),
                            company_name = VALUES(company_name),
                            lead_status = VALUES(lead_status),
                            updated_at = NOW();
                        
                        -- Update sync record
                        UPDATE external_leads_sync
                        SET lead_id = LAST_INSERT_ID(),
                            last_synced_at = NOW()
                        WHERE id = sync_id;
                    END LOOP;
                    
                    CLOSE sync_cursor;
                END//
                DELIMITER ;
            "
        ];
    }
}
