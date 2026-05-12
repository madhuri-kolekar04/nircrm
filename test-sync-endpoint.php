<?php

echo "🔍 Testing Google Sheets Sync Endpoint\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Test the sync endpoint
    $controller = new \App\Http\Controllers\GoogleSheetsManagementController(
        new \App\Services\GoogleSheetsServicePublic()
    );
    
    echo "1. Testing sync endpoint...\n";
    $request = new \Illuminate\Http\Request();
    $response = $controller->sync($request);
    
    echo "Response type: " . get_class($response) . "\n";
    echo "Status code: " . $response->getStatusCode() . "\n";
    
    if ($response instanceof \Illuminate\Http\JsonResponse) {
        $data = $response->getData(true);
        echo "Response data:\n";
        echo json_encode($data, JSON_PRETTY_PRINT) . "\n";
        
        if ($data['success']) {
            echo "✅ Sync endpoint working\n";
        } else {
            echo "❌ Sync failed: " . $data['message'] . "\n";
        }
    } else {
        echo "❌ Unexpected response type\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Sync error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

?>
