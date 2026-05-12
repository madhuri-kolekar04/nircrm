<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CSRF Token Debug ===\n\n";

try {
    // Test 1: Check if CSRF token is generated
    echo "1. Testing CSRF Token Generation...\n";
    $token = csrf_token();
    echo "   ✓ CSRF Token Generated: " . substr($token, 0, 20) . "...\n\n";

    // Test 2: Check session configuration
    echo "2. Testing Session Configuration...\n";
    $sessionDriver = config('session.driver');
    echo "   ✓ Session Driver: $sessionDriver\n";
    
    $sessionLifetime = config('session.lifetime');
    echo "   ✓ Session Lifetime: $sessionLifetime minutes\n";
    
    $sessionPath = config('session.files');
    echo "   ✓ Session Path: $sessionPath\n\n";

    // Test 3: Check if session is working
    echo "3. Testing Session Storage...\n";
    session_start();
    $_SESSION['test'] = 'CSRF Debug Test';
    echo "   ✓ Session Storage: Working\n";
    echo "   ✓ Session ID: " . session_id() . "\n\n";

    // Test 4: Check encryption
    echo "4. Testing Encryption Key...\n";
    $key = config('app.key');
    if ($key && $key !== 'base64:' && strlen($key) > 30) {
        echo "   ✓ Encryption Key: Present and valid\n";
    } else {
        echo "   ⚠ Encryption Key: May be invalid\n";
    }
    echo "   ✓ Key Length: " . strlen($key) . " characters\n\n";

    // Test 5: Check web middleware group
    echo "5. Testing Web Middleware...\n";
    $webMiddleware = config('middleware.web');
    if (is_array($webMiddleware)) {
        echo "   ✓ Web Middleware Count: " . count($webMiddleware) . "\n";
        if (in_array(\Illuminate\Session\Middleware\StartSession::class, $webMiddleware)) {
            echo "   ✓ StartSession Middleware: Found\n";
        }
        if (in_array(\Illuminate\View\Middleware\ShareErrorsFromSession::class, $webMiddleware)) {
            echo "   ✓ ShareErrorsFromSession Middleware: Found\n";
        }
    }
    echo "\n";

    // Test 6: Check file permissions
    echo "6. Testing File Permissions...\n";
    $storagePath = storage_path('framework/sessions');
    if (is_dir($storagePath)) {
        echo "   ✓ Sessions Directory: Exists\n";
        if (is_writable($storagePath)) {
            echo "   ✓ Sessions Directory: Writable\n";
        } else {
            echo "   ⚠ Sessions Directory: Not writable\n";
        }
    } else {
        echo "   ⚠ Sessions Directory: Does not exist\n";
    }
    echo "\n";

    echo "=== Solutions ===\n";
    echo "If you're still getting CSRF token mismatch, try these steps:\n\n";
    echo "1. Clear browser cookies and cache\n";
    echo "2. Run: php artisan config:cache\n";
    echo "3. Run: php artisan session:table\n";
    echo "4. Run: php artisan migrate\n";
    echo "5. Check APP_DOMAIN in .env file\n";
    echo "6. Ensure session domain is set correctly\n";
    echo "7. Try using database session driver\n\n";

    echo "=== Quick Fix Commands ===\n";
    echo "php artisan cache:clear\n";
    echo "php artisan config:clear\n";
    echo "php artisan session:table\n";
    echo "php artisan migrate\n";
    echo "php artisan config:cache\n\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
