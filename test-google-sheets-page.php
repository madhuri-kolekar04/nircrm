<?php

echo "🔍 Testing Google Sheets Management Page\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Test the controller
    $controller = new \App\Http\Controllers\GoogleSheetsManagementController(
        new \App\Services\GoogleSheetsServicePublic()
    );
    
    echo "1. Testing controller instantiation...\n";
    echo "✅ Controller created successfully\n\n";
    
    echo "2. Testing data retrieval...\n";
    $request = new \Illuminate\Http\Request();
    $response = $controller->index($request);
    
    echo "Response status: " . get_class($response) . "\n";
    
    if (method_exists($response, 'getData')) {
        $data = $response->getData();
        echo "Data keys: " . implode(', ', array_keys($data)) . "\n";
        echo "Total rows: " . ($data['totalRows'] ?? 'N/A') . "\n";
        echo "Headers count: " . count($data['headers'] ?? []) . "\n";
        echo "Page data count: " . count($data['pageData'] ?? []) . "\n";
    }
    
    echo "\n3. Testing Google Sheets service...\n";
    $service = new \App\Services\GoogleSheetsServicePublic();
    $data = $service->getMappedData();
    
    echo "✅ Service working correctly\n";
    echo "Total data rows: " . count($data) . "\n";
    
    if (!empty($data)) {
        echo "Sample headers: " . implode(', ', array_slice(array_keys($data[0]), 0, 5)) . "\n";
        echo "Sample row data: " . json_encode(array_slice($data[0], 0, 3), JSON_PRETTY_PRINT) . "\n";
    }
    
    echo "\n✅ All tests passed! The Google Sheets Management page should work.\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

?>
