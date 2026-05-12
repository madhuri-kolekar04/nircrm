<?php

// Simple database test without Laravel
try {
    $pdo = new PDO('mysql:host=localhost;dbname=nircrm', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connection: SUCCESS\n";
    
    // Check if table exists
    $stmt = $pdo->prepare("SHOW TABLES LIKE 'lead_reactions'");
    $stmt->execute();
    $table = $stmt->fetch();
    
    if ($table) {
        echo "Table 'lead_reactions' exists\n";
        
        // Get table structure
        $descStmt = $pdo->prepare("DESCRIBE lead_reactions");
        $descStmt->execute();
        $columns = $descStmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "\nTable structure:\n";
        foreach ($columns as $column) {
            echo "  - {$column['Field']} ({$column['Type']})\n";
        }
        
        // Test insert
        echo "\nTesting insert...\n";
        $insertStmt = $pdo->prepare("INSERT INTO lead_reactions (lead_id, user_id, reaction_type, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
        
        $result = $insertStmt->execute([65, 1, 'positive']);
        
        if ($result) {
            $id = $pdo->lastInsertId();
            echo "SUCCESS: Inserted reaction with ID: $id\n";
            
            // Verify
            $checkStmt = $pdo->prepare("SELECT * FROM lead_reactions WHERE id = ?");
            $checkStmt->execute([$id]);
            $reaction = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
            if ($reaction) {
                echo "VERIFIED: Found reaction in database\n";
                echo "  ID: {$reaction['id']}\n";
                echo "  Lead ID: {$reaction['lead_id']}\n";
                echo "  User ID: {$reaction['user_id']}\n";
                echo "  Type: {$reaction['reaction_type']}\n";
            } else {
                echo "ERROR: Reaction not found after insert\n";
            }
        } else {
            echo "ERROR: Failed to insert\n";
            $error = $insertStmt->errorInfo();
            echo "SQL Error: {$error[2]}\n";
        }
        
    } else {
        echo "ERROR: Table 'lead_reactions' does not exist!\n";
    }
    
} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}
