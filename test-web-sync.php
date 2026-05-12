<?php

echo "🔍 Testing Web Sync Endpoint\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test the Google Sheets service directly
try {
    $service = new \App\Services\GoogleSheetsServicePublic();
    
    echo "1. Testing connection...\n";
    $connection = $service->testConnection();
    echo "Connection result: " . json_encode($connection, JSON_PRETTY_PRINT) . "\n\n";
    
    echo "2. Testing data fetch...\n";
    $data = $service->getMappedData();
    echo "Data rows found: " . count($data) . "\n";
    
    if (!empty($data)) {
        echo "Sample data keys: " . implode(', ', array_keys($data[0])) . "\n";
        echo "First row sample: " . json_encode(array_slice($data[0], 0, 3), JSON_PRETTY_PRINT) . "\n";
    }
    
    echo "\n3. Testing field mapping...\n";
    if (!empty($data)) {
        $mappedData = $service->mapToLeadFields($data[0]);
        echo "Mapped fields: " . implode(', ', array_keys($mappedData)) . "\n";
        echo "Name: " . ($mappedData['name'] ?? 'N/A') . "\n";
        echo "Email: " . ($mappedData['email'] ?? 'N/A') . "\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n4. Checking routes...\n";
$routeCollection = \Illuminate\Support\Facades\Route::getRoutes();
$googleSheetsRoutes = [];

foreach ($routeCollection as $route) {
    if (strpos($route->uri(), 'google-sheets') !== false) {
        $googleSheetsRoutes[] = [
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri(),
            'action' => $route->getActionName()
        ];
    }
}

echo "Google Sheets routes found:\n";
foreach ($googleSheetsRoutes as $route) {
    echo "  {$route['method']} {$route['uri']} -> {$route['action']}\n";
}

?>
