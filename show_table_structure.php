<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=nircrm', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== LEAD_REACTIONS TABLE STRUCTURE ===\n";
    echo "Table: lead_reactions\n";
    echo "Purpose: Stores all lead reaction records\n\n";
    
    $stmt = $pdo->prepare("DESCRIBE lead_reactions");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Columns:\n";
    foreach ($columns as $column) {
        $null = $column['Null'] == 'NO' ? 'NOT NULL' : 'NULL';
        $key = $column['Key'] ? " ({$column['Key']})" : '';
        echo "  - {$column['Field']} ({$column['Type']}) {$null}{$key}\n";
    }
    
    echo "\n=== FOREIGN KEY CONSTRAINTS ===\n";
    $fkStmt = $pdo->prepare("
        SELECT 
            COLUMN_NAME,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME
        FROM 
            INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
        WHERE 
            TABLE_SCHEMA = 'nircrm' 
            AND TABLE_NAME = 'lead_reactions'
            AND REFERENCED_TABLE_NAME IS NOT NULL
    ");
    $fkStmt->execute();
    $foreignKeys = $fkStmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($foreignKeys as $fk) {
        echo "  - {$fk['COLUMN_NAME']} → {$fk['REFERENCED_TABLE_NAME']}.{$fk['REFERENCED_COLUMN_NAME']}\n";
    }
    
    echo "\n=== SAMPLE DATA ===\n";
    $dataStmt = $pdo->prepare("SELECT * FROM lead_reactions ORDER BY created_at DESC LIMIT 3");
    $dataStmt->execute();
    $data = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($data) > 0) {
        foreach ($data as $row) {
            echo "Reaction ID: {$row['id']}\n";
            echo "  Lead ID: {$row['lead_id']}\n";
            echo "  User ID: {$row['user_id']}\n";
            echo "  Type: {$row['reaction_type']}\n";
            echo "  Notes: " . substr($row['notes'], 0, 50) . "...\n";
            echo "  Date: {$row['reaction_date']}\n";
            echo "  Time: {$row['reaction_time']}\n";
            echo "  Created: {$row['created_at']}\n";
            echo "  ---\n";
        }
    } else {
        echo "No data found in lead_reactions table\n";
    }
    
} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}
