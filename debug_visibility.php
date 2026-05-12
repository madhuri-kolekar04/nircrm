<?php

require_once 'vendor/autoload.php';

use App\Models\RoleElementVisibility;
use Illuminate\Database\Capsule\Manager as Capsule;

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VISIBILITY DEBUG REPORT ===\n\n";

// Check database connection
try {
    Capsule::connection()->getPdo();
    echo "✓ Database connection: OK\n";
} catch (Exception $e) {
    echo "✗ Database connection: FAILED - " . $e->getMessage() . "\n";
    exit;
}

// Check table exists
try {
    $tableExists = Capsule::schema()->hasTable('role_element_visibility');
    echo $tableExists ? "✓ Table exists: role_element_visibility\n" : "✗ Table missing: role_element_visibility\n";
} catch (Exception $e) {
    echo "✗ Table check failed: " . $e->getMessage() . "\n";
}

// Get all visibility settings
try {
    $allSettings = RoleElementVisibility::all();
    echo "\n--- Current Visibility Settings ---\n";
    echo "Total records: " . $allSettings->count() . "\n\n";
    
    foreach ($allSettings as $setting) {
        echo "Page: " . $setting->page_url . "\n";
        echo "Role ID: " . $setting->role_id . "\n";
        echo "Element: " . $setting->element_identifier . " (" . $setting->element_type . ")\n";
        echo "Visible: " . ($setting->is_visible ? 'YES' : 'NO') . "\n";
        echo "Name: " . $setting->element_name . "\n";
        echo "---\n";
    }
} catch (Exception $e) {
    echo "✗ Failed to get settings: " . $e->getMessage() . "\n";
}

// Test specific role/page combinations
$testCases = [
    ['page' => '/employees', 'role' => 2], // Employee role on employees page
    ['page' => '/leads', 'role' => 2],     // Employee role on leads page
    ['page' => '/employees', 'role' => 1], // Admin role on employees page
];

echo "\n--- Test Visibility Retrieval ---\n";
foreach ($testCases as $case) {
    try {
        $visibility = RoleElementVisibility::getVisibilityForPage($case['page'], $case['role']);
        echo "Page: " . $case['page'] . ", Role: " . $case['role'] . "\n";
        echo "Settings found: " . $visibility->count() . "\n";
        
        foreach ($visibility as $elementId => $setting) {
            echo "  - " . $elementId . ": " . ($setting->is_visible ? 'VISIBLE' : 'HIDDEN') . "\n";
        }
        echo "---\n";
    } catch (Exception $e) {
        echo "✗ Failed test case: " . $e->getMessage() . "\n";
    }
}

echo "\n=== END DEBUG REPORT ===\n";
