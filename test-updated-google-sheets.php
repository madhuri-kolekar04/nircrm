<?php

echo "🔍 Testing Updated Google Sheets Management Page\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Test the updated controller
    $controller = new \App\Http\Controllers\GoogleSheetsManagementController();
    
    echo "1. Testing updated controller...\n";
    $request = new \Illuminate\Http\Request();
    $response = $controller->index($request);
    
    echo "Response type: " . get_class($response) . "\n";
    
    if ($response instanceof \Illuminate\View\View) {
        echo "View name: " . $response->getName() . "\n";
        $data = $response->getData();
        echo "Data keys: " . implode(', ', array_keys($data)) . "\n";
        
        echo "\n2. Checking database structure:\n";
        echo "Total rows: " . ($data['totalRows'] ?? 'N/A') . "\n";
        echo "Headers count: " . count($data['headers'] ?? []) . "\n";
        echo "Page data count: " . count($data['pageData'] ?? []) . "\n";
        
        echo "\n3. Database headers:\n";
        if (!empty($data['headers'])) {
            foreach (array_slice($data['headers'], 0, 10) as $header) {
                echo "  - $header\n";
            }
            if (count($data['headers']) > 10) {
                echo "  ... and " . (count($data['headers']) - 10) . " more fields\n";
            }
        }
        
        echo "\n4. Sample lead data:\n";
        if (!empty($data['pageData'])) {
            $firstLead = $data['pageData'][0];
            echo "  ID: " . $firstLead->id . "\n";
            echo "  Name: " . substr($firstLead->name, 0, 30) . "...\n";
            echo "  Email: " . substr($firstLead->email, 0, 30) . "...\n";
            echo "  Phone: " . substr($firstLead->phone, 0, 20) . "...\n";
            echo "  Company: " . substr($firstLead->company_name, 0, 30) . "...\n";
            echo "  Status: " . $firstLead->lead_status . "\n";
            echo "  Created: " . $firstLead->created_at . "\n";
        }
        
        echo "\n5. Testing view rendering...\n";
        try {
            $rendered = $response->render();
            echo "✅ View renders successfully\n";
            echo "Rendered length: " . strlen($rendered) . " characters\n";
        } catch (\Exception $e) {
            echo "❌ View rendering failed: " . $e->getMessage() . "\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Controller error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

?>
