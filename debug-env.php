<?php

// Debug environment variables
echo "=== Environment Variables Debug ===\n\n";

// Check if .env file exists
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    echo "✅ .env file exists\n";
    echo "File path: " . $envFile . "\n";
    echo "File size: " . filesize($envFile) . " bytes\n";
    echo "Last modified: " . date('Y-m-d H:i:s', filemtime($envFile)) . "\n\n";
    
    // Read last 10 lines of .env
    echo "Last 10 lines of .env:\n";
    $lines = file($envFile);
    $lastLines = array_slice($lines, -10);
    foreach ($lastLines as $line) {
        echo trim($line) . "\n";
    }
} else {
    echo "❌ .env file NOT found at: " . $envFile . "\n";
}

echo "\n=== Environment Variables ===\n";

// Check specific environment variables
$vars = [
    'GOOGLE_SHEETS_SPREADSHEET_ID',
    'GOOGLE_SHEETS_API_KEY',
    'APP_ENV'
];

foreach ($vars as $var) {
    $value = getenv($var);
    echo "$var: " . ($value ? 'SET' : 'NOT SET') . "\n";
    if ($value && $var !== 'GOOGLE_SHEETS_API_KEY') {
        echo "  Value: $value\n";
    } elseif ($value && $var === 'GOOGLE_SHEETS_API_KEY') {
        echo "  Value: " . substr($value, 0, 10) . "...\n";
    }
}

echo "\n=== Laravel Config ===\n";

// Load Laravel
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check Laravel config
$spreadsheetId = config('services.google.sheets.spreadsheet_id');
$apiKey = config('services.google.sheets.api_key');

echo "services.google.sheets.spreadsheet_id: " . ($spreadsheetId ?: 'NOT SET') . "\n";
echo "services.google.sheets.api_key: " . ($apiKey ? 'SET' : 'NOT SET') . "\n";

?>
