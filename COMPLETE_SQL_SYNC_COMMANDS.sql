-- =====================================================
-- AUTOMATIC EXTERNAL DATABASE SYNC SQL COMMANDS
-- =====================================================
-- Run these commands in your EXTERNAL DATABASE
-- This will automatically sync new leads to NIRCRM
-- =====================================================

-- 1. CREATE TRIGGER FOR AUTOMATIC SYNC
-- This trigger fires when new lead is added to external database
-- and automatically inserts it into NIRCRM database

DELIMITER //

CREATE TRIGGER after_insert_lead_sync
AFTER INSERT ON your_external_table_name
FOR EACH ROW
BEGIN
    -- Insert new lead directly into NIRCRM leads table
    INSERT INTO nircrm.leads (
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
        created_by,
        created_at,
        updated_at
    ) VALUES (
        -- Map external fields to NIRCRM fields
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
        1, -- Default created_by user ID
        NOW(),
        NOW()
    );
    
    -- Also log the sync for tracking
    INSERT INTO nircrm.external_leads_sync (
        external_database_name,
        external_table_name,
        external_lead_id,
        lead_id,
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
        last_synced_at,
        created_at,
        updated_at
    ) VALUES (
        DATABASE(),
        'your_external_table_name',
        NEW.id,
        LAST_INSERT_ID(),
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
        NOW(),
        NOW(),
        NOW()
    );
END//

DELIMITER ;

-- 2. CREATE UPDATE TRIGGER (Optional but recommended)
-- This trigger updates existing leads when they are modified in external database

DELIMITER //

CREATE TRIGGER after_update_lead_sync
AFTER UPDATE ON your_external_table_name
FOR EACH ROW
BEGIN
    -- Update existing lead in NIRCRM database
    UPDATE nircrm.leads SET
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
        updated_at = NOW()
    WHERE id = (
        SELECT lead_id FROM nircrm.external_leads_sync 
        WHERE external_database_name = DATABASE() 
        AND external_table_name = 'your_external_table_name' 
        AND external_lead_id = NEW.id 
        LIMIT 1
    );
    
    -- Update sync tracking
    UPDATE nircrm.external_leads_sync SET
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
        last_synced_at = NOW(),
        updated_at = NOW()
    WHERE external_database_name = DATABASE() 
    AND external_table_name = 'your_external_table_name' 
    AND external_lead_id = NEW.id;
END//

DELIMITER ;

-- 3. CREATE DELETE TRIGGER (Optional)
-- This trigger handles deleted leads

DELIMITER //

CREATE TRIGGER after_delete_lead_sync
AFTER DELETE ON your_external_table_name
FOR EACH ROW
BEGIN
    -- Mark lead as deleted in NIRCRM (or actually delete)
    UPDATE nircrm.leads SET 
        lead_status = 'deleted',
        updated_at = NOW()
    WHERE id = (
        SELECT lead_id FROM nircrm.external_leads_sync 
        WHERE external_database_name = DATABASE() 
        AND external_table_name = 'your_external_table_name' 
        AND external_lead_id = OLD.id 
        LIMIT 1
    );
END//

DELIMITER ;

-- =====================================================
-- SETUP INSTRUCTIONS:
-- =====================================================
-- 
-- 1. REPLACE 'your_external_table_name' with your actual table name
-- 2. REPLACE 'nircrm' with your NIRCRM database name if different
-- 3. Run these commands in your EXTERNAL database
-- 4. Test by adding a new lead to external database
-- 5. Check NIRCRM - the lead should appear automatically!
--
-- =====================================================
