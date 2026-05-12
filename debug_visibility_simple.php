<?php

// Simple database check without Laravel bootstrap
$host = 'localhost';
$dbname = 'nircrm'; // Update with your database name
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== VISIBILITY DEBUG REPORT ===\n\n";
    echo "✓ Database connection: OK\n\n";
    
    // Check table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'role_element_visibility'");
    $tableExists = $stmt->rowCount() > 0;
    echo $tableExists ? "✓ Table exists: role_element_visibility\n" : "✗ Table missing: role_element_visibility\n";
    
    if ($tableExists) {
        // Get all records
        $stmt = $pdo->query("SELECT * FROM role_element_visibility ORDER BY page_url, role_id");
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "\n--- Current Visibility Settings ---\n";
        echo "Total records: " . count($records) . "\n\n";
        
        if (count($records) > 0) {
            foreach ($records as $record) {
                echo "Page: " . $record['page_url'] . "\n";
                echo "Role ID: " . $record['role_id'] . "\n";
                echo "Element: " . $record['element_identifier'] . " (" . $record['element_type'] . ")\n";
                echo "Visible: " . ($record['is_visible'] ? 'YES' : 'NO') . "\n";
                echo "Name: " . $record['element_name'] . "\n";
                echo "Created: " . $record['created_at'] . "\n";
                echo "---\n";
            }
        } else {
            echo "No visibility settings found in database.\n";
        }
        
        // Test specific queries
        echo "\n--- Test Specific Queries ---\n";
        $testQueries = [
            "SELECT COUNT(*) as count FROM role_element_visibility WHERE page_url = '/employees' AND role_id = 2",
            "SELECT COUNT(*) as count FROM role_element_visibility WHERE page_url = '/leads' AND role_id = 2",
            "SELECT COUNT(*) as count FROM role_element_visibility WHERE role_id = 2"
        ];
        
        foreach ($testQueries as $query) {
            $stmt = $pdo->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "Query: " . $query . "\n";
            echo "Result: " . $result['count'] . " records\n\n";
        }
    }
    
} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    echo "Please check your database credentials in the script.\n";
}

echo "\n=== END DEBUG REPORT ===\n";
