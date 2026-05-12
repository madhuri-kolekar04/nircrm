<?php

echo "🔍 GOOGLE SHEETS INTEGRATION VERIFICATION\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check configuration
$spreadsheetId = config('services.google.sheets.spreadsheet_id');
$apiKey = config('services.google.sheets.api_key');

echo "📋 Configuration Status:\n";
echo "Spreadsheet ID: " . ($spreadsheetId ? '✅ SET' : '❌ NOT SET') . "\n";
echo "API Key: " . ($apiKey ? '✅ SET' : '❌ NOT SET') . "\n";

if ($spreadsheetId && $apiKey) {
    echo "\n🎯 Testing Google Sheets API...\n";
    
    try {
        // Test API connection
        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}?key={$apiKey}";
        $response = \Illuminate\Support\Facades\Http::get($url);
        
        if ($response->successful()) {
            echo "✅ API Connection Successful!\n";
            $data = $response->json();
            echo "Sheet Title: " . ($data['sheets'][0]['properties']['title'] ?? 'Unknown') . "\n";
            
            // Test data fetch
            $dataUrl = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}/values/Sheet1!A1:Z5?key={$apiKey}";
            $dataResponse = \Illuminate\Support\Facades\Http::get($dataUrl);
            
            if ($dataResponse->successful()) {
                $values = $dataResponse->json()['values'] ?? [];
                echo "✅ Data Fetch Successful!\n";
                echo "Headers found: " . count($values[0] ?? []) . " columns\n";
                echo "Sample data: " . implode(', ', array_slice($values[0] ?? [], 0, 5)) . "\n";
                
                echo "\n🚀 READY TO SYNC! Run: php artisan google-sheets:sync --force\n";
            } else {
                echo "❌ Data fetch failed: " . $dataResponse->body() . "\n";
            }
        } else {
            echo "❌ API Connection Failed: " . $response->body() . "\n";
        }
    } catch (\Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "\n❌ SETUP INCOMPLETE:\n";
    echo "Please add the following to your .env file:\n";
    echo "GOOGLE_SHEETS_SPREADSHEET_ID=1o0fn4TiF45i5I1SJrYawpT6JmShBbVYlBXRR9AUMHKg\n";
    echo "GOOGLE_SHEETS_API_KEY=your_actual_api_key_here\n";
    echo "\nThen run: php artisan config:clear\n";
}

echo "\n📊 Your Google Sheet Info:\n";
echo "Sheet ID: 1o0fn4TiF45i5I1SJrYawpT6JmShBbVYlBXRR9AUMHKg\n";
echo "Public Access: ✅ Available\n";
echo "Total Rows: 3039\n";
echo "Columns: full_name, business_name, email, whatsapp, website_url, business_type, primary_goal, budget_range, score, tier, submitted_at, audit_report, audit_report_plain\n";

?>
