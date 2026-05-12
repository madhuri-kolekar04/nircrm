<?php

// Debug the exact form submission
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

try {
    echo "=== DEBUGGING FORM SUBMISSION ===\n\n";
    
    // Simulate the exact data from your URL
    $formData = [
        'lead_id' => 65,
        'reaction_type' => 'positive',
        'call_duration' => 6,
        'next_follow_up' => '2026-02-21',
        'notes' => 'jhjgjhghj',
        '_token' => 'igaglidSFEn1hACiXe4ys7YkVlmQY8S3Wq51Yne6'
    ];
    
    echo "Form Data Received:\n";
    foreach ($formData as $key => $value) {
        echo "  $key: $value\n";
    }
    
    echo "\nTesting with Laravel's LeadReaction model...\n";
    
    // Test 1: Direct model creation
    try {
        $reaction = new \App\Models\LeadReaction();
        $reaction->lead_id = $formData['lead_id'];
        $reaction->user_id = 3; // Use valid user ID
        $reaction->department_id = 1;
        $reaction->reaction_type = $formData['reaction_type'];
        $reaction->notes = $formData['notes'];
        $reaction->next_follow_up = $formData['next_follow_up'];
        $reaction->call_duration = $formData['call_duration'];
        $reaction->reaction_date = date('Y-m-d');
        $reaction->reaction_time = date('H:i:s');
        $reaction->created_at = date('Y-m-d H:i:s');
        $reaction->updated_at = date('Y-m-d H:i:s');
        
        echo "Model object created:\n";
        echo "  lead_id: {$reaction->lead_id}\n";
        echo "  user_id: {$reaction->user_id}\n";
        echo "  reaction_type: {$reaction->reaction_type}\n";
        echo "  notes: {$reaction->notes}\n";
        echo "  next_follow_up: {$reaction->next_follow_up}\n";
        echo "  call_duration: {$reaction->call_duration}\n";
        echo "  reaction_date: {$reaction->reaction_date}\n";
        echo "  reaction_time: {$reaction->reaction_time}\n";
        
        $saveResult = $reaction->save();
        echo "Save result: " . ($saveResult ? 'SUCCESS' : 'FAILED') . "\n";
        
        if ($saveResult) {
            echo "Saved ID: {$reaction->id}\n";
        } else {
            echo "Save errors:\n";
            print_r($reaction->getErrors());
        }
        
    } catch (Exception $e) {
        echo "Model creation exception: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . "\n";
        echo "Line: " . $e->getLine() . "\n";
    }
    
    echo "\nTesting 2: Direct DB insert (like controller)...\n";
    
    // Test 2: Direct database insert (exactly like controller)
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=nircrm', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "INSERT INTO lead_reactions 
            (lead_id, user_id, department_id, reaction_type, notes, next_follow_up, call_duration, reaction_date, reaction_time, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $insertData = [
            $formData['lead_id'],      // lead_id
            3,                        // user_id (valid)
            1,                        // department_id
            $formData['reaction_type'], // reaction_type
            $formData['notes'],         // notes
            $formData['next_follow_up'], // next_follow_up
            $formData['call_duration'], // call_duration
            date('Y-m-d'),           // reaction_date
            date('H:i:s'),           // reaction_time
            date('Y-m-d H:i:s'),    // created_at
            date('Y-m-d H:i:s')     // updated_at
        ];
        
        echo "SQL: $sql\n";
        echo "Parameters: " . count($insertData) . "\n";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($insertData);
        
        if ($result) {
            $newId = $pdo->lastInsertId();
            echo "SUCCESS: Direct insert created with ID: $newId\n";
            
            // Verify
            $verify = $pdo->prepare("SELECT * FROM lead_reactions WHERE id = ?");
            $verify->execute([$newId]);
            $saved = $verify->fetch(PDO::FETCH_ASSOC);
            
            if ($saved) {
                echo "VERIFIED: Record in database\n";
                echo "  ID: {$saved['id']}\n";
                echo "  Type: {$saved['reaction_type']}\n";
                echo "  Notes: {$saved['notes']}\n";
                echo "  Date: {$saved['reaction_date']}\n";
            }
            
        } else {
            echo "FAILED: Direct insert failed\n";
            $error = $stmt->errorInfo();
            echo "SQL Error: {$error[2]}\n";
        }
        
    } catch (Exception $e) {
        echo "Direct insert exception: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "Overall exception: " . $e->getMessage() . "\n";
}
