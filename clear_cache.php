<?php

// Cache clearing script
require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Clearing Laravel Caches ===\n\n";

try {
    // Clear route cache
    $routeCache = $app->make('cache')->forget('routes');
    echo "✅ Route cache cleared\n";
} catch (Exception $e) {
    echo "❌ Error clearing route cache: " . $e->getMessage() . "\n";
}

try {
    // Clear config cache
    $configCache = $app->make('cache')->forget('config');
    echo "✅ Config cache cleared\n";
} catch (Exception $e) {
    echo "❌ Error clearing config cache: " . $e->getMessage() . "\n";
}

try {
    // Clear application cache
    $appCache = $app->make('cache')->flush();
    echo "✅ Application cache cleared\n";
} catch (Exception $e) {
    echo "❌ Error clearing application cache: " . $e->getMessage() . "\n";
}

echo "\n=== Verifying Routes ===\n";

// Get the route collection
$routes = app('router')->getRoutes();

$foundRoutes = [];
foreach ($routes as $route) {
    $uri = $route->uri();
    if (strpos($uri, 'sales-department') !== false) {
        $foundRoutes[] = [
            'uri' => $uri,
            'methods' => implode(', ', $route->methods()),
            'name' => $route->getName() ?: 'No name'
        ];
    }
}

if (!empty($foundRoutes)) {
    echo "✅ Found " . count($foundRoutes) . " sales-department routes:\n";
    foreach ($foundRoutes as $route) {
        echo "  - {$route['uri']} [{$route['methods']}] ({$route['name']})\n";
    }
} else {
    echo "❌ No sales-department routes found!\n";
}

echo "\n=== Test Route URL ===\n";

try {
    $sampleLeadId = 107;
    $url = url('/sales-department/' . $sampleLeadId . '/send-approval-email');
    echo "Sample URL: {$url}\n";
    echo "✅ URL generation successful\n";
} catch (Exception $e) {
    echo "❌ Error generating URL: " . $e->getMessage() . "\n";
}

echo "\n=== Done ===\n";
echo "\nNext steps:\n";
echo "1. Refresh the sales department page\n";
echo "2. Try clicking the mail icon again\n";
echo "3. The route should now be found\n";
