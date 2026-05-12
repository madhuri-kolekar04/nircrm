<?php

echo "🔍 Debugging Google Sheets View\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Test the controller and view rendering
    $controller = new \App\Http\Controllers\GoogleSheetsManagementController(
        new \App\Services\GoogleSheetsServicePublic()
    );
    
    echo "1. Testing controller...\n";
    $request = new \Illuminate\Http\Request();
    $response = $controller->index($request);
    
    echo "Response type: " . get_class($response) . "\n";
    
    if ($response instanceof \Illuminate\View\View) {
        echo "View name: " . $response->getName() . "\n";
        $data = $response->getData();
        echo "Data keys: " . implode(', ', array_keys($data)) . "\n";
        
        echo "\n2. Checking data structure:\n";
        echo "Total rows: " . ($data['totalRows'] ?? 'N/A') . "\n";
        echo "Headers count: " . count($data['headers'] ?? []) . "\n";
        echo "Page data count: " . count($data['pageData'] ?? []) . "\n";
        
        echo "\n3. Sample headers:\n";
        if (!empty($data['headers'])) {
            foreach (array_slice($data['headers'], 0, 5) as $header) {
                echo "  - $header\n";
            }
        }
        
        echo "\n4. Sample row data:\n";
        if (!empty($data['pageData'])) {
            $firstRow = $data['pageData'][0];
            foreach (array_slice($firstRow, 0, 3) as $key => $value) {
                echo "  $key: " . substr($value, 0, 50) . "...\n";
            }
        }
        
        echo "\n5. Testing view rendering...\n";
        try {
            $rendered = $response->render();
            echo "✅ View renders successfully\n";
            echo "Rendered length: " . strlen($rendered) . " characters\n";
            
            // Check for common errors in rendered output
            if (strpos($rendered, 'syntax error') !== false) {
                echo "❌ Syntax error found in rendered output\n";
            }
            if (strpos($rendered, 'ErrorException') !== false) {
                echo "❌ ErrorException found in rendered output\n";
            }
            if (strpos($rendered, 'Undefined variable') !== false) {
                echo "❌ Undefined variable found in rendered output\n";
            }
            
        } catch (\Exception $e) {
            echo "❌ View rendering failed: " . $e->getMessage() . "\n";
            echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Controller error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

?>
