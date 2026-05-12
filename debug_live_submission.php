<?php

// Debug live form submission
echo "=== LIVE FORM SUBMISSION DEBUG ===\n\n";

// Check recent database entries
try {
    $pdo = new PDO('mysql:host=localhost;dbname=nircrm', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "1. CHECKING RECENT REACTIONS IN DATABASE...\n";
    $stmt = $pdo->prepare("SELECT * FROM lead_reactions ORDER BY created_at DESC LIMIT 5");
    $stmt->execute();
    $reactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($reactions) > 0) {
        echo "   Recent reactions found:\n";
        foreach ($reactions as $reaction) {
            echo "   ID: {$reaction['id']} - Type: {$reaction['reaction_type']} - Time: {$reaction['reaction_time']} - Duration: {$reaction['call_duration']} - Follow-up: {$reaction['next_follow_up']} - Notes: " . substr($reaction['notes'], 0, 30) . "...\n";
        }
    } else {
        echo "   ❌ NO REACTIONS FOUND IN DATABASE!\n";
    }
    
    echo "\n2. CHECKING LARAVEL LOGS FOR ERRORS...\n";
    $logFile = 'storage/logs/laravel.log';
    if (file_exists($logFile)) {
        $lines = file($logFile);
        $recentLines = array_slice($lines, -20); // Last 20 lines
        
        echo "   Recent Laravel log entries:\n";
        foreach ($recentLines as $line) {
            if (strpos($line, 'storeReaction') !== false || strpos($line, 'ERROR') !== false || strpos($line, 'Exception') !== false) {
                echo "   " . trim($line) . "\n";
            }
        }
    } else {
        echo "   ❌ Laravel log file not found\n";
    }
    
    echo "\n3. TESTING CONTROLLER ACCESS...\n";
    
    // Test if we can access the controller route
    $url = 'http://127.0.0.1:8000/leads/65/reaction';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true); // Just get headers
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "   Route access test - HTTP Code: $httpCode\n";
    if ($httpCode == 200) {
        echo "   ✅ Route is accessible\n";
    } else {
        echo "   ❌ Route not accessible (Code: $httpCode)\n";
    }
    
    echo "\n4. CHECKING USER AUTHENTICATION...\n";
    
    // Check if users table has valid users
    $userStmt = $pdo->prepare("SELECT id, name, email FROM users WHERE id IN (3, 5, 7, 13, 18, 19, 20, 21, 22)");
    $userStmt->execute();
    $users = $userStmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($users) > 0) {
        echo "   Available users for authentication:\n";
        foreach ($users as $user) {
            echo "   ID: {$user['id']} - Name: {$user['name']} - Email: {$user['email']}\n";
        }
    } else {
        echo "   ❌ No valid users found\n";
    }
    
    echo "\n5. TESTING SIMULATED FORM SUBMISSION...\n";
    
    // Simulate exact form data
    $testData = [
        'lead_id' => 65,
        'reaction_type' => 'interested',
        'reaction_time' => '16:30',
        'call_duration' => 240,
        'next_follow_up' => '2026-02-22',
        'notes' => 'This is a test reaction from debug script',
        '_token' => 'test-token'
    ];
    
    echo "   Simulating POST request with data:\n";
    foreach ($testData as $key => $value) {
        if ($key !== '_token') {
            echo "     $key: $value\n";
        }
    }
    
    // Try to submit via cURL
    $postCh = curl_init();
    curl_setopt($postCh, CURLOPT_URL, $url);
    curl_setopt($postCh, CURLOPT_POST, true);
    curl_setopt($postCh, CURLOPT_POSTFIELDS, http_build_query($testData));
    curl_setopt($postCh, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($postCh, CURLOPT_HEADER, true);
    
    $postResponse = curl_exec($postCh);
    $postHttpCode = curl_getinfo($postCh, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($postCh, CURLINFO_HEADER_SIZE);
    $postBody = substr($postResponse, $headerSize);
    
    curl_close($postCh);
    
    echo "   POST submission result - HTTP Code: $postHttpCode\n";
    echo "   Response body: " . substr($postBody, 0, 200) . "...\n";
    
    if ($postHttpCode == 419) {
        echo "   ❌ CSRF TOKEN ISSUE - This is likely the problem!\n";
        echo "   Solution: Refresh the page before submitting\n";
    } elseif ($postHttpCode == 401) {
        echo "   ❌ AUTHENTICATION ISSUE - User not logged in\n";
        echo "   Solution: Login to the application\n";
    } elseif ($postHttpCode == 422) {
        echo "   ❌ VALIDATION ERROR - Form data invalid\n";
        echo "   Check the response body for validation errors\n";
    } elseif ($postHttpCode == 500) {
        echo "   ❌ SERVER ERROR - Check Laravel logs\n";
    } elseif ($postHttpCode == 200) {
        echo "   ✅ SUCCESS - Form submitted successfully\n";
    } else {
        echo "   ❌ UNKNOWN ERROR - HTTP Code: $postHttpCode\n";
    }
    
} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}

echo "\n=== TROUBLESHOOTING STEPS ===\n";
echo "1. Refresh the reaction page completely (F5)\n";
echo "2. Make sure you're logged in to the application\n";
echo "3. Fill all required fields (reaction type is required)\n";
echo "4. Click 'Record Reaction' button\n";
echo "5. Check browser console for JavaScript errors\n";
echo "6. Check browser Network tab for failed requests\n";
echo "7. Check this debug output again after submission\n";
