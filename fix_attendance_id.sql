-- Fix attendance table ID field auto-increment issue
-- Run this SQL command in your database (phpMyAdmin, MySQL CLI, etc.)

-- First, check if there are any existing records
SELECT COUNT(*) as total_records FROM attendances;

-- If there are records, get the maximum ID to set the auto_increment start
SELECT MAX(id) as max_id FROM attendances;

-- Fix the ID column to be auto-increment
ALTER TABLE attendances MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;

-- Verify the fix
SHOW COLUMNS FROM attendances WHERE Field = 'id';

-- Test insert (optional - you can run this to verify)
-- INSERT INTO attendances (user_id, date, check_in_time, status, ip_address, location, is_late, created_at, updated_at) 
-- VALUES (1, CURDATE(), NOW(), 'present', '127.0.0.1', 'Test', 0, NOW(), NOW());

-- If test insert works, remove it:
-- DELETE FROM attendances WHERE location = 'Test' AND status = 'present';
