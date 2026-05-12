<?php

echo "🔍 Debugging 'No Data Found' Issue\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "1. Testing Google Sheets Service Directly...\n";
    
    $service = new \App\Services\GoogleSheetsServicePublic();
    
    // Test raw data fetch
    echo "   Testing getSpreadsheetData()...\n";
    $rawData = $service->getSpreadsheetData();
    echo "   Raw data rows: " . count($rawData) . "\n";
    
    if (!empty($rawData)) {
        echo "   First row (headers): " . substr(implode(', ', array_slice($rawData[0], 0, 3)), 0, 50) . "...\n";
    } else {
        echo "   ❌ No raw data fetched\n";
    }
    
    // Test mapped data
    echo "\n   Testing getMappedData()...\n";
    $mappedData = $service->getMappedData();
    echo "   Mapped data rows: " . count($mappedData) . "\n";
    
    if (!empty($mappedData)) {
        echo "   First mapped row keys: " . implode(', ', array_slice(array_keys($mappedData[0]), 0, 3)) . "...\n";
        echo "   First mapped row sample: " . substr(implode(', ', array_slice($mappedData[0], 0, 3)), 0, 50) . "...\n";
    } else {
        echo "   ❌ No mapped data\n";
    }
    
    echo "\n2. Testing Controller with Fresh Request...\n";
    
    $controller = new \App\Http\Controllers\GoogleSheetsManagementController(app(\App\Services\GoogleSheetsServicePublic::class));
    $request = new \Illuminate\Http\Request();
    $response = $controller->index($request);
    
    if ($response instanceof \Illuminate\View\View) {
        $data = $response->getData();
        $pageData = $data['pageData'] ?? [];
        $headers = $data['headers'] ?? [];
        $totalRows = $data['totalRows'] ?? 0;
        
        echo "   Controller results:\n";
        echo "     Total Rows: {$totalRows}\n";
        echo "     Page Data Count: " . count($pageData) . "\n";
        echo "     Headers Count: " . count($headers) . "\n";
        
        if (!empty($headers)) {
            echo "     Headers: " . implode(', ', array_slice($headers, 0, 5)) . "...\n";
        }
        
        if (!empty($pageData)) {
            echo "     First page row sample: " . substr(implode(', ', array_slice($pageData[0], 0, 3)), 0, 50) . "...\n";
        }
        
        // Check if data is empty
        if (empty($pageData)) {
            echo "   ❌ Page data is empty - this is the issue!\n";
            
            // Debug why page data is empty
            echo "\n   Debugging empty page data:\n";
            
            // Check if mappedData has data
            if (!empty($mappedData)) {
                echo "     ✅ Mapped data has " . count($mappedData) . " rows\n";
                
                // Check pagination calculation
                $page = 1;
                $perPage = 50;
                $offset = ($page - 1) * $perPage;
                $pageDataFromMapped = array_slice($mappedData, $offset, $perPage);
                
                echo "     Offset: {$offset}, Per Page: {$perPage}\n";
                echo "     Page data from mapped: " . count($pageDataFromMapped) . "\n";
                
                if (!empty($pageDataFromMapped)) {
                    echo "     ✅ Should have page data!\n";
                } else {
                    echo "     ❌ No page data from mapped\n";
                }
            } else {
                echo "     ❌ Mapped data is empty\n";
            }
        } else {
            echo "   ✅ Page data has " . count($pageData) . " rows\n";
        }
    } else {
        echo "   ❌ Controller did not return view\n";
    }
    
    echo "\n3. Testing Google Sheets URL Directly...\n";
    
    $url = "https://docs.google.com/spreadsheets/d/1o0fn4TiF45i5I1SJrYawpT6JmShBbVYlBXRR9AUMHKg/export?format=csv&gid=0";
    
    $response = \Illuminate\Support\Facades\Http::get($url);
    
    echo "   URL: {$url}\n";
    echo "   Status: " . $response->status() . "\n";
    echo "   Successful: " . ($response->successful() ? 'YES' : 'NO') . "\n";
    echo "   Content length: " . strlen($response->body()) . " bytes\n";
    
    if ($response->successful()) {
        $lines = explode("\n", $response->body());
        echo "   CSV lines: " . count($lines) . "\n";
        
        if (!empty($lines)) {
            echo "   First line: " . substr($lines[0], 0, 50) . "...\n";
            echo "   Second line: " . substr($lines[1] ?? '', 0, 50) . "...\n";
        }
    } else {
        echo "   Error: " . $response->body() . "\n";
    }
    
    echo "\n4. Checking View Rendering...\n";
    
    try {
        $rendered = $response->render();
        echo "   View rendered successfully\n";
        echo "   Rendered length: " . number_format(strlen($rendered)) . " characters\n";
        
        // Check for "No data found" message
        if (strpos($rendered, 'No data found') !== false) {
            echo "   ❌ 'No data found' message found in rendered HTML\n";
        } else {
            echo "   ✅ No 'No data found' message\n";
        }
        
        // Check for table data
        if (strpos($rendered, '<td>') !== false) {
            echo "   ✅ Table data found in HTML\n";
        } else {
            echo "   ❌ No table data found in HTML\n";
        }
        
    } catch (\Exception $e) {
        echo "   ❌ View rendering failed: " . $e->getMessage() . "\n";
    }
    
    echo "\n5. Summary:\n";
    echo "   Google Sheets Service: " . (count($mappedData) > 0 ? 'WORKING' : 'NOT WORKING') . "\n";
    echo "   Controller: " . (!empty($pageData) ? 'WORKING' : 'NOT WORKING') . "\n";
    echo "   URL Access: " . ($response->successful() ? 'WORKING' : 'NOT WORKING') . "\n";
    echo "   Issue: " . (!empty($pageData) ? 'UNKNOWN' : 'PAGE DATA EMPTY') . "\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

?>
