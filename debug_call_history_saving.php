<?php

// Debug call history saving and loading
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CALL HISTORY SAVING DEBUG ===\n\n";

use App\Models\MeetingCallDetail;

try {
    echo "🔍 CHECKING RECENT CALL HISTORY SAVES...\n";
    
    // Get all recent call details from last 24 hours
    $recentCalls = MeetingCallDetail::where('created_at', '>=', now()->subHours(24))
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get(['lead_email', 'called_by_employee_name', 'meeting_conclusion', 'rating', 'created_at']);
    
    if ($recentCalls->isEmpty()) {
        echo "❌ No recent call history found in last 24 hours\n";
        echo "This suggests data might not be saving properly\n";
    } else {
        echo "✅ Found " . $recentCalls->count() . " recent call history records:\n";
        
        foreach ($recentCalls as $index => $call) {
            echo ($index + 1) . ". {$call->lead_email} -> {$call->called_by_employee_name}\n";
            echo "   Rating: {$call->rating}/5\n";
            echo "   Date: {$call->created_at}\n";
            echo "   Conclusion: " . substr($call->meeting_conclusion, 0, 50) . "...\n\n";
        }
    }
    
    echo "\n🔍 CHECKING SPECIFIC LEAD EMAILS...\n";
    
    // Check emails that should have call history
    $leadEmailsWithHistory = MeetingCallDetail::distinct('lead_email')
        ->pluck('lead_email')
        ->take(5)
        ->toArray();
    
    echo "Emails with call history: " . implode(', ', $leadEmailsWithHistory) . "\n";
    
    // Check if mohitpatil900@gmail.com is in the list
    if (in_array('mohitpatil900@gmail.com', $leadEmailsWithHistory)) {
        echo "✅ mohitpatil900@gmail.com found in call history\n";
    } else {
        echo "❌ mohitpatil900@gmail.com NOT found in call history\n";
        echo "This explains why no history is showing for this lead\n";
    }
    
    echo "\n🔍 TESTING API ENDPOINT DIRECTLY...\n";
    
    // Test the API endpoint that should return data
    $testEmail = 'mohitpatil900@gmail.com';
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/callingapp/call-details/{$testEmail}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if ($response === false) {
        echo "❌ cURL request failed\n";
    } else {
        echo "✅ API Response Status: {$httpCode}\n";
        
        // Parse headers
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);
        
        echo "📋 Response Headers:\n";
        echo $headers . "\n\n";
        
        echo "📋 Response Body:\n";
        echo $body . "\n\n";
        
        // Try to decode JSON
        $decoded = json_decode($body, true);
        
        if (json_last_error() === JSON_ERROR_NONE) {
            echo "✅ Valid JSON response\n";
            echo "📊 Response Structure:\n";
            echo json_encode($decoded, JSON_PRETTY_PRINT) . "\n\n";
            
            if (isset($decoded['success'])) {
                echo "✅ Success flag: " . ($decoded['success'] ? 'true' : 'false') . "\n";
            }
            
            if (isset($decoded['meeting_call_details'])) {
                echo "✅ meeting_call_details found: " . count($decoded['meeting_call_details']) . " records\n";
            } elseif (isset($decoded['call_details'])) {
                echo "⚠️  call_details found (old property name): " . count($decoded['call_details']) . " records\n";
            } else {
                echo "❌ No call details property found in response\n";
            }
            
        } else {
            echo "❌ Invalid JSON: " . json_last_error_msg() . "\n";
        }
    }
    
    curl_close($ch);
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

echo "\n=== DEBUG COMPLETED ===\n";
