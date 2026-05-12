<?php

// Simple test to verify Google Sheets API key
$spreadsheetId = '1o0fn4TiF45i5I1SJrYawpT6JmShBbVYlBXRR9AUMHKg';
$apiKey = 'YOUR_API_KEY_HERE'; // Replace with your actual API key

$url = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}?key={$apiKey}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status: " . $httpCode . "\n";
echo "Response: " . $response . "\n";

if ($httpCode == 200) {
    echo "✅ API Key works! Your sheet is accessible.\n";
} else {
    echo "❌ Error: Check your API key and sheet sharing settings.\n";
}

?>
