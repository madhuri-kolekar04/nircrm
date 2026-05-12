-- =====================================================
-- EXTERNAL DATABASE DIAGNOSTIC COMMANDS
-- Run these in your EXTERNAL DATABASE to debug sync issues
-- =====================================================

-- STEP 1: CHECK IF TRIGGER EXISTS
-- =====================================================
SHOW TRIGGERS LIKE '%lead_sync%';

-- STEP 2: CHECK YOUR EXTERNAL TABLE DATA
-- =====================================================
-- Replace 'your_external_table_name' with your actual table name
SELECT 
    id,
    name,
    email,
    phone,
    company_name,
    created_at,
    updated_at
FROM your_external_table_name 
ORDER BY created_at DESC 
LIMIT 10;

-- STEP 3: CHECK IF TRIGGER IS WORKING
-- =====================================================
-- Manually insert a test record
INSERT INTO your_external_table_name (
    name,
    email,
    phone,
    company_name,
    created_at,
    updated_at
) VALUES (
    'Manual Test Lead',
    'test@example.com',
    '1234567890',
    'Test Company',
    NOW(),
    NOW()
);

-- Check if it appeared in NIRCRM
SELECT 
    id,
    name,
    email,
    source,
    created_at
FROM nircrm.leads 
WHERE name = 'Manual Test Lead'
ORDER BY created_at DESC;

-- STEP 4: CHECK FOR ERRORS
-- =====================================================
-- Check recent errors
SHOW ENGINE INNODB STATUS;

-- Check trigger definition
SELECT 
    TRIGGER_NAME,
    EVENT_MANIPULATION,
    EVENT_OBJECT_TABLE,
    ACTION_TIMING,
    ACTION_STATEMENT
FROM information_schema.TRIGGERS 
WHERE TRIGGER_NAME LIKE '%lead_sync%';

-- STEP 5: CLEAN UP TEST DATA
-- =====================================================
-- Remove the test record
DELETE FROM your_external_table_name 
WHERE name = 'Manual Test Lead';

DELETE FROM nircrm.leads 
WHERE name = 'Manual Test Lead' 
AND source = 'external_sync';

-- =====================================================
-- QUICK COPY-PASTE VERSION
-- =====================================================

-- Just replace 'your_external_table_name' and run:

SHOW TRIGGERS LIKE '%lead_sync%';

SELECT id, name, email, phone, company_name, created_at 
FROM your_external_table_name 
ORDER BY created_at DESC LIMIT 5;

INSERT INTO your_external_table_name (name, email, phone, company_name, created_at, updated_at) 
VALUES ('Manual Test Lead', 'test@example.com', '1234567890', 'Test Company', NOW(), NOW());

SELECT id, name, email, source, created_at 
FROM nircrm.leads 
WHERE name = 'Manual Test Lead' 
ORDER BY created_at DESC;
