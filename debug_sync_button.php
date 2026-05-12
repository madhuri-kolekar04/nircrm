<?php

echo "🔧 Debugging Sync Google Sheets Button\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "1. Testing Google Sheets Service...\n";
    
    $service = new \App\Services\GoogleSheetsServicePublic();
    
    // Test if service can fetch data
    echo "   Testing getMappedData()...\n";
    $mappedData = $service->getMappedData();
    echo "   ✅ Got " . count($mappedData) . " rows from Google Sheets\n";
    
    // Test checkLeadExists method
    echo "\n2. Testing checkLeadExists method...\n";
    if (!empty($mappedData)) {
        $testRow = $mappedData[0];
        $leadData = $service->mapToLeadFields($testRow);
        
        echo "   Test row data:\n";
        echo "     Name: " . ($leadData['name'] ?? 'N/A') . "\n";
        echo "     Email: " . ($leadData['email'] ?? 'N/A') . "\n";
        echo "     Phone: " . ($leadData['phone'] ?? 'N/A') . "\n";
        
        // Check if method exists
        if (method_exists($service, 'checkLeadExists')) {
            echo "   ✅ checkLeadExists method exists\n";
            
            try {
                $existingLead = $service->checkLeadExists($leadData);
                if ($existingLead) {
                    echo "   ✅ Found existing lead: ID " . $existingLead->id . "\n";
                } else {
                    echo "   ✅ No existing lead found (new lead)\n";
                }
            } catch (\Exception $e) {
                echo "   ❌ checkLeadExists error: " . $e->getMessage() . "\n";
            }
        } else {
            echo "   ❌ checkLeadExists method does NOT exist\n";
        }
    }
    
    // Test getLastSyncTimestamp method
    echo "\n3. Testing getLastSyncTimestamp method...\n";
    if (method_exists($service, 'getLastSyncTimestamp')) {
        echo "   ✅ getLastSyncTimestamp method exists\n";
        
        try {
            $lastSync = $service->getLastSyncTimestamp();
            if ($lastSync) {
                echo "   ✅ Last sync: " . $lastSync->format('Y-m-d H:i:s') . "\n";
            } else {
                echo "   ✅ No previous sync timestamp\n";
            }
        } catch (\Exception $e) {
            echo "   ❌ getLastSyncTimestamp error: " . $e->getMessage() . "\n";
        }
    } else {
        echo "   ❌ getLastSyncTimestamp method does NOT exist\n";
    }
    
    // Test updateLastSyncTimestamp method
    echo "\n4. Testing updateLastSyncTimestamp method...\n";
    if (method_exists($service, 'updateLastSyncTimestamp')) {
        echo "   ✅ updateLastSyncTimestamp method exists\n";
        
        try {
            $service->updateLastSyncTimestamp();
            echo "   ✅ Sync timestamp updated\n";
        } catch (\Exception $e) {
            echo "   ❌ updateLastSyncTimestamp error: " . $e->getMessage() . "\n";
        }
    } else {
        echo "   ❌ updateLastSyncTimestamp method does NOT exist\n";
    }
    
    // Test the sync endpoint directly
    echo "\n5. Testing Sync Endpoint...\n";
    
    $controller = new \App\Http\Controllers\GoogleSheetsManagementController(app(\App\Services\GoogleSheetsServicePublic::class));
    
    // Simulate POST request
    $request = new \Illuminate\Http\Request();
    $response = $controller->sync($request);
    
    echo "   Sync endpoint response:\n";
    echo "   Status: " . $response->getStatusCode() . "\n";
    echo "   Content: " . $response->getContent() . "\n";
    
    // Check if response is JSON
    $content = $response->getContent();
    $jsonResponse = json_decode($content, true);
    
    if ($jsonResponse) {
        echo "   ✅ JSON response decoded successfully\n";
        echo "   Success: " . ($jsonResponse['success'] ? 'YES' : 'NO') . "\n";
        echo "   Message: " . ($jsonResponse['message'] ?? 'No message') . "\n";
        
        if (isset($jsonResponse['imported_count'])) {
            echo "   Imported: " . $jsonResponse['imported_count'] . "\n";
        }
        if (isset($jsonResponse['updated_count'])) {
            echo "   Updated: " . $jsonResponse['updated_count'] . "\n";
        }
        if (isset($jsonResponse['errors'])) {
            echo "   Errors: " . count($jsonResponse['errors']) . "\n";
        }
    } else {
        echo "   ❌ Response is not valid JSON\n";
    }
    
    echo "\n6. Testing JavaScript Sync Function...\n";
    
    // Check if the JavaScript function exists in the view
    $viewPath = resource_path('views/admin/google-sheets/simple.blade.php');
    if (file_exists($viewPath)) {
        $viewContent = file_get_contents($viewPath);
        
        if (strpos($viewContent, 'function syncGoogleSheets()') !== false) {
            echo "   ✅ syncGoogleSheets() JavaScript function exists\n";
            
            if (strpos($viewContent, '/googlesheet/sync') !== false) {
                echo "   ✅ Correct sync endpoint found in JavaScript\n";
            } else {
                echo "   ❌ Wrong sync endpoint in JavaScript\n";
            }
            
            if (strpos($viewContent, 'fetch(') !== false) {
                echo "   ✅ JavaScript fetch() used\n";
            } else {
                echo "   ❌ JavaScript fetch() not found\n";
            }
            
            if (strpos($viewContent, 'syncBtn') !== false) {
                echo "   ✅ syncBtn element found\n";
            } else {
                echo "   ❌ syncBtn element not found\n";
            }
        } else {
            echo "   ❌ syncGoogleSheets() JavaScript function NOT found\n";
        }
    } else {
        echo "   ❌ View file not found: {$viewPath}\n";
    }
    
    echo "\n7. Summary:\n";
    echo "   Google Sheets Service: " . (count($mappedData) > 0 ? 'WORKING' : 'NOT WORKING') . "\n";
    echo "   Service Methods: " . (method_exists($service, 'checkLeadExists') ? 'COMPLETE' : 'INCOMPLETE') . "\n";
    echo "   Sync Endpoint: " . ($jsonResponse['success'] ?? false ? 'WORKING' : 'NOT WORKING') . "\n";
    echo "   JavaScript Function: " . (strpos($viewContent, 'syncGoogleSheets()') !== false ? 'EXISTS' : 'MISSING') . "\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

?>
