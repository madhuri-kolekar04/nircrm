<?php

// Simple API test without Laravel framework
require_once 'vendor/autoload.php';

echo "=== SIMPLE API TEST ===\n\n";

// Test the API endpoint directly
$testEmail = 'mohitpatil900@gmail.com';
$url = "http://127.0.0.1:8000/callingapp/call-details/{$testEmail}";

echo "Testing URL: {$url}\n";

// Use file_get_contents as a simple test
$context = stream_context_create([
    'http' => [
        'header' => 'Accept: application/json',
        'timeout' => 10
    ]
]);

$response = file_get_contents($url, false, $context);

if ($response === false) {
    echo "❌ Failed to get response\n";
} else {
    echo "✅ Response received:\n";
    echo $response . "\n\n";
    
    // Try to decode as JSON
    $decoded = json_decode($response, true);
    
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "✅ Valid JSON\n";
        if (isset($decoded['success'])) {
            echo "✅ Success: " . ($decoded['success'] ? 'true' : 'false') . "\n";
        }
        if (isset($decoded['meeting_call_details'])) {
            echo "✅ meeting_call_details count: " . count($decoded['meeting_call_details']) . "\n";
        } else {
            echo "❌ meeting_call_details not found\n";
        }
    } else {
        echo "❌ Invalid JSON: " . json_last_error_msg() . "\n";
    }
}

echo "\n=== TEST COMPLETED ===\n";
