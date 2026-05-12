<?php

// Test Google Sheets API directly without Laravel
$spreadsheetId = '1o0fn4TiF45i5I1SJrYawpT6JmShBbVYlBXRR9AUMHKg';
$apiKey = 'AIzaSyBxxxxx'; // This is a placeholder - you need to replace with your actual API key

echo "=== Google Sheets API Test ===\n\n";

// Test 1: Check if sheet is publicly accessible (without API key)
echo "1. Testing public access...\n";
$url = "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/export?format=csv";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Public access HTTP Status: " . $httpCode . "\n";
if ($httpCode == 200) {
    echo "✅ Sheet is publicly accessible\n";
    $lines = explode("\n", $response);
    echo "Found " . count($lines) . " rows\n";
    if (!empty($lines[0])) {
        echo "Headers: " . $lines[0] . "\n";
    }
} else {
    echo "❌ Sheet is not publicly accessible\n";
}

echo "\n2. Testing API access (requires API key)...\n";
$apiUrl = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}?key={$apiKey}";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "API access HTTP Status: " . $httpCode . "\n";
echo "Response: " . substr($response, 0, 200) . "...\n";

if ($httpCode == 200) {
    echo "✅ API access works\n";
} else {
    echo "❌ API access failed - check API key\n";
}

echo "\n=== Instructions ===\n";
echo "1. Get API key from: https://console.cloud.google.com/\n";
echo "2. Add to .env file:\n";
echo "   GOOGLE_SHEETS_SPREADSHEET_ID={$spreadsheetId}\n";
echo "   GOOGLE_SHEETS_API_KEY=your_actual_api_key_here\n";
echo "3. Clear cache: php artisan config:clear\n";
echo "4. Test sync: php artisan google-sheets:sync --force\n";

?>
