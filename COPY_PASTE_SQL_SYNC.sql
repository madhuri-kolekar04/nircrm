-- =====================================================
-- COMPLETE AUTOMATIC SYNC SQL - COPY & PASTE READY
-- =====================================================
-- INSTRUCTIONS:
-- 1. REPLACE 'your_external_table_name' with your actual table name
-- 2. REPLACE 'nircrm' with your NIRCRM database name if different
-- 3. Run this in your EXTERNAL database
-- =====================================================

-- VERSION 1: SIMPLE INSERT TRIGGER (Most Common Use)
-- =====================================================

DELIMITER //

CREATE TRIGGER after_insert_lead_sync
AFTER INSERT ON your_external_table_name
FOR EACH ROW
BEGIN
    -- Insert new lead directly into NIRCRM database
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
        1,
        NOW(),
        NOW()
    );
END//

DELIMITER ;

-- =====================================================
-- VERSION 2: INSERT TRIGGER WITH SYNC TRACKING
-- =====================================================

DELIMITER //

CREATE TRIGGER after_insert_lead_sync_with_tracking
AFTER INSERT ON your_external_table_name
FOR EACH ROW
BEGIN
    DECLARE new_lead_id BIGINT;
    
    -- Insert new lead into NIRCRM database
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
        1,
        NOW(),
        NOW()
    );
    
    -- Get the new lead ID
    SET new_lead_id = LAST_INSERT_ID();
    
    -- Log the sync for tracking
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
        new_lead_id,
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

-- =====================================================
-- VERSION 3: COMPLETE SYNC (INSERT + UPDATE + DELETE)
-- =====================================================

-- INSERT TRIGGER
DELIMITER //

CREATE TRIGGER after_insert_lead_sync_complete
AFTER INSERT ON your_external_table_name
FOR EACH ROW
BEGIN
    DECLARE new_lead_id BIGINT;
    
    -- Insert into NIRCRM leads table
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
        1,
        NOW(),
        NOW()
    );
    
    SET new_lead_id = LAST_INSERT_ID();
    
    -- Log in sync table
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
        new_lead_id,
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

-- UPDATE TRIGGER
DELIMITER //

CREATE TRIGGER after_update_lead_sync_complete
AFTER UPDATE ON your_external_table_name
FOR EACH ROW
BEGIN
    -- Update existing lead in NIRCRM
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

-- DELETE TRIGGER (Optional)
DELIMITER //

CREATE TRIGGER after_delete_lead_sync_complete
AFTER DELETE ON your_external_table_name
FOR EACH ROW
BEGIN
    -- Mark lead as deleted in NIRCRM (soft delete)
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
-- TESTING COMMANDS
-- =====================================================

-- Test if trigger was created successfully
SHOW TRIGGERS LIKE '%lead_sync%';

-- Check current leads in NIRCRM
SELECT COUNT(*) as total_leads FROM nircrm.leads;

-- Check sync records
SELECT COUNT(*) as total_sync_records FROM nircrm.external_leads_sync;

-- =====================================================
-- QUICK COPY & PASTE VERSION (Just replace table name)
-- =====================================================

DELIMITER //

CREATE TRIGGER after_insert_lead_sync
AFTER INSERT ON your_external_table_name
FOR EACH ROW
BEGIN
    INSERT INTO nircrm.leads (
        name, email, phone, company_name, website, address, city, state, country, 
        pincode, industry, lead_status, source, description, budget, business_type, 
        primary_goal, score, tier, submitted_at, created_by, created_at, updated_at
    ) VALUES (
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
        1,
        NOW(),
        NOW()
    );
END//

DELIMITER ;
