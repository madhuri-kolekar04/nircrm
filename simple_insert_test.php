<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=nircrm', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== SIMPLE INSERT TEST ===\n";
    
    // Test with minimal required fields only
    $sql = "INSERT INTO lead_reactions (lead_id, user_id, reaction_type, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";
    echo "SQL: $sql\n";
    echo "Parameters: 3\n";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([65, 3, 'positive']);
    
    if ($result) {
        $id = $pdo->lastInsertId();
        echo "SUCCESS: Simple reaction created with ID: $id\n";
        
        // Verify it
        $check = $pdo->prepare("SELECT * FROM lead_reactions WHERE id = ?");
        $check->execute([$id]);
        $reaction = $check->fetch(PDO::FETCH_ASSOC);
        
        if ($reaction) {
            echo "VERIFIED: Reaction in database\n";
            echo "ID: {$reaction['id']}, Type: {$reaction['reaction_type']}, Created: {$reaction['created_at']}\n";
        }
        
    } else {
        echo "FAILED: Could not insert simple reaction\n";
        $error = $stmt->errorInfo();
        print_r($error);
    }
    
} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}
