<?php

echo "🔍 Testing Web Sync Endpoint Directly\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Simulate a web request to the sync endpoint
try {
    // Create a mock request
    $request = new \Illuminate\Http\Request();
    $request->setMethod('POST');
    $request->headers->set('Content-Type', 'application/json');
    $request->headers->set('X-Requested-With', 'XMLHttpRequest');
    
    // Create controller instance
    $controller = new \App\Http\Controllers\GoogleSheetsController(
        new \App\Services\GoogleSheetsServicePublic()
    );
    
    echo "1. Testing controller sync method...\n";
    
    // Call the sync method
    $response = $controller->sync($request);
    
    echo "Response status: " . $response->getStatusCode() . "\n";
    echo "Response content: " . $response->getContent() . "\n";
    
    if ($response->getStatusCode() == 200) {
        $data = json_decode($response->getContent(), true);
        if ($data['success']) {
            echo "✅ Sync successful!\n";
            echo "Message: " . $data['message'] . "\n";
            if (isset($data['imported'])) {
                echo "Imported: " . $data['imported'] . "\n";
            }
        } else {
            echo "❌ Sync failed: " . $data['message'] . "\n";
        }
    } else {
        echo "❌ HTTP Error: " . $response->getStatusCode() . "\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n2. Checking CSRF token setup...\n";
// Check if CSRF middleware is properly configured
echo "CSRF middleware should be active for web routes\n";
echo "Make sure your layout has: <meta name=\"csrf-token\" content=\"{{ csrf_token() }}\">\n";

?>
