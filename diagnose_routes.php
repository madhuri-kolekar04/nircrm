<?php

// Quick diagnostic script
echo "=== Laravel Route Diagnostic ===\n\n";

// Check if we're in the right directory
if (!file_exists('artisan')) {
    echo "❌ Error: artisan file not found. Make sure you're in the Laravel root directory.\n";
    exit(1);
}

echo "✅ Found artisan file\n";

// Check if routes file has syntax errors
echo "\n=== Checking routes/web.php syntax ===\n";
$output = [];
$return_var = 0;
exec('php -l routes/web.php 2>&1', $output, $return_var);

if ($return_var === 0) {
    echo "✅ routes/web.php syntax is valid\n";
} else {
    echo "❌ Syntax error in routes/web.php:\n";
    foreach ($output as $line) {
        echo "  {$line}\n";
    }
    exit(1);
}

// Check if Laravel can boot
echo "\n=== Testing Laravel bootstrap ===\n";
try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make('Illuminate\Contracts\Console\Kernel');
    $kernel->bootstrap();
    echo "✅ Laravel boots successfully\n";
} catch (Exception $e) {
    echo "❌ Laravel bootstrap failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Check routes
echo "\n=== Checking Route Registration ===\n";
$routes = app('router')->getRoutes();

$targetRoutes = [
    'sales.department.send-approval-email',
    'sales.department.send-approval-email.backup'
];

$found = false;
foreach ($targetRoutes as $routeName) {
    foreach ($routes as $route) {
        if ($route->getName() === $routeName) {
            echo "✅ Found route: {$routeName}\n";
            echo "   URI: {$route->uri()}\n";
            echo "   Methods: " . implode(', ', $route->methods()) . "\n";
            $found = true;
            break;
        }
    }
}

if (!$found) {
    echo "❌ Target routes not found. Listing all sales-department routes:\n";
    foreach ($routes as $route) {
        if (strpos($route->uri(), 'sales-department') !== false) {
            echo "   - {$route->uri()} [" . implode(', ', $route->methods()) . "] ({$route->getName()})\n";
        }
    }
}

// Test URL generation
echo "\n=== Testing URL Generation ===\n";
try {
    $url = url('/sales-department/107/send-approval-email');
    echo "✅ URL generated: {$url}\n";
} catch (Exception $e) {
    echo "❌ URL generation failed: " . $e->getMessage() . "\n";
}

echo "\n=== Recommendations ===\n";
echo "1. If routes are not found, run: php artisan route:clear\n";
echo "2. If server is not running, start with: php artisan serve\n";
echo "3. Refresh browser after clearing cache\n";
echo "4. Check for any syntax errors in routes files\n";

echo "\n=== Done ===\n";
