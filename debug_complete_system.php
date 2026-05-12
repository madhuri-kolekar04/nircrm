<?php

// Complete system debugging tool
echo "=== COMPLETE LEAD REACTION SYSTEM DEBUG ===\n\n";

// Check all components
echo "1. CHECKING DATABASE CONNECTION...\n";
try {
    $pdo = new PDO('mysql:host=localhost;dbname=nircrm', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "   ✅ Database connection: SUCCESS\n";
    
    // Check table structure
    echo "2. CHECKING lead_reactions TABLE...\n";
    $stmt = $pdo->query("DESCRIBE lead_reactions");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "   ✅ Table exists with " . count($columns) . " columns\n";
    
    // Check if we can do a simple insert
    echo "3. TESTING DIRECT DATABASE INSERT...\n";
    $testSql = "INSERT INTO lead_reactions (lead_id, user_id, reaction_type, notes, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";
    $testStmt = $pdo->prepare($testSql);
    $testResult = $testStmt->execute([65, 3, 'test', 'Direct test']);
    
    if ($testResult) {
        $testId = $pdo->lastInsertId();
        echo "   ✅ Direct insert SUCCESS: ID $testId\n";
        
        // Clean up test data
        $deleteStmt = $pdo->prepare("DELETE FROM lead_reactions WHERE id = ?");
        $deleteStmt->execute([$testId]);
        echo "   ✅ Test data cleaned up\n";
    } else {
        echo "   ❌ Direct insert FAILED\n";
        $error = $testStmt->errorInfo();
        echo "   Error: " . $error[2] . "\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ EXCEPTION: " . $e->getMessage() . "\n";
}

echo "\n4. CHECKING LARAVEL ENVIRONMENT...\n";
try {
    // Check if Laravel is properly configured
    if (file_exists('bootstrap/app.php')) {
        echo "   ✅ bootstrap/app.php exists\n";
    } else {
        echo "   ❌ bootstrap/app.php missing\n";
    }
    
    if (file_exists('.env')) {
        echo "   ✅ .env file exists\n";
    } else {
        echo "   ❌ .env file missing\n";
    }
    
    // Check key Laravel files
    $laravelFiles = [
        'config/app.php',
        'routes/web.php',
        'app/Http/Controllers/Admin/LeadController.php',
        'app/Models/LeadReaction.php'
    ];
    
    foreach ($laravelFiles as $file) {
        if (file_exists($file)) {
            echo "   ✅ $file exists\n";
        } else {
            echo "   ❌ $file missing\n";
        }
    }
    
} catch (Exception $e) {
    echo "   ❌ EXCEPTION: " . $e->getMessage() . "\n";
}

echo "\n5. CHECKING WEB SERVER...\n";
echo "   Testing if web server is running on port 8000...\n";
$webServerTest = @fsockopen('127.0.0.1', 8000, $errno, $errstr, 30);
if ($webServerTest) {
    echo "   ✅ Web server is running on port 8000\n";
    fclose($webServerTest);
} else {
    echo "   ❌ Web server not accessible on port 8000\n";
    echo "   Error: $errstr ($errno)\n";
}

echo "\n6. RECOMMENDATIONS FOR FIXING STORAGE ISSUE...\n";
echo "   If reactions are not storing, check:\n";
echo "   1. Laravel logs: tail -f storage/logs/laravel.log\n";
echo "   2. Database permissions: GRANT ALL on nircrm.* TO 'root'@'localhost'\n";
echo "   3. PHP errors: Check error_log or PHP error reporting\n";
echo "   4. Form submission: Check browser network tab for failed AJAX requests\n";
echo "   5. CSRF token: Ensure page is refreshed before submitting\n";
echo "   6. Session: Verify user is logged in and session is active\n";
echo "   7. Database connection: Test with simple PDO connection\n";
echo "   8. Migrations: Run php artisan migrate:refresh\n";

echo "\n7. STEP-BY-STEP TESTING...\n";
echo "   Step 1: Clear all caches\n";
echo "   Step 2: Restart web server\n";
echo "   Step 3: Login to application\n";
echo "   Step 4: Go to reaction page\n";
echo "   Step 5: Fill form completely\n";
echo "   Step 6: Submit reaction\n";
echo "   Step 7: Check database for new record\n";
echo "   Step 8: Check reaction history section\n";

echo "\n=== DEBUGGING COMPLETE ===\n";
