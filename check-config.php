<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check configuration
$spreadsheetId = config('services.google.sheets.spreadsheet_id');
$apiKey = config('services.google.sheets.api_key');

echo "Spreadsheet ID: " . ($spreadsheetId ?: 'NOT SET') . "\n";
echo "API Key: " . ($apiKey ? 'SET (' . substr($apiKey, 0, 10) . '...)' : 'NOT SET') . "\n";

if (!$spreadsheetId) {
    echo "❌ GOOGLE_SHEETS_SPREADSHEET_ID not found in config\n";
} else {
    echo "✅ Spreadsheet ID found: $spreadsheetId\n";
}

if (!$apiKey) {
    echo "❌ GOOGLE_SHEETS_API_KEY not found in config\n";
} else {
    echo "✅ API Key found\n";
}

?>
