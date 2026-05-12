<?php

/**
 * Complete Google Sheets Sync Fix
 * 
 * This script provides comprehensive fix for Google Sheets sync issues
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Google Sheets Sync Fix ===\n\n";

// Step 1: Verify credentials file
echo "1. Checking and fixing credentials file...\n";
$credentialsPath = base_path('storage/app/google-credentials.json');

if (!file_exists($credentialsPath)) {
    echo "   ❌ Creating credentials file...\n";
    
    // Create the directory if it doesn't exist
    $dir = dirname($credentialsPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    // Create a proper template
    $template = [
        'type' => 'service_account',
        'project_id' => 'PROJECT_ID_HERE',
        'private_key_id' => 'KEY_ID_HERE', 
        'private_key' => '-----BEGIN PRIVATE KEY-----\nYOUR_PRIVATE_KEY_HERE\n-----END PRIVATE KEY-----\n',
        'client_email' => 'SERVICE_ACCOUNT@PROJECT_ID.iam.gserviceaccount.com',
        'client_id' => 'CLIENT_ID_HERE',
        'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
        'token_uri' => 'https://oauth2.googleapis.com/token',
        'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
        'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/SERVICE_ACCOUNT%40PROJECT_ID.iam.gserviceaccount.com'
    ];
    
    file_put_contents($credentialsPath, json_encode($template, JSON_PRETTY_PRINT));
    echo "   ✅ Template credentials file created\n";
    echo "   📝 You MUST replace with real credentials\n\n";
} else {
    echo "   ✅ Credentials file exists\n";
    
    // Check if it's template or real
    $content = file_get_contents($credentialsPath);
    $data = json_decode($content, true);
    
    if ($data && isset($data['client_email'])) {
        if (strpos($data['client_email'], 'PROJECT_ID_HERE') !== false || 
            strpos($data['client_email'], 'your-project') !== false) {
            echo "   ⚠️  Still using template data\n";
            echo "   🔧 Fix needed: Replace with real Google credentials\n\n";
            
            echo "📋 Instructions:\n";
            echo "1. Go to: https://console.cloud.google.com/\n";
            echo "2. Create Service Account\n";
            echo "3. Download JSON credentials\n";
            echo "4. Copy content from downloaded file\n";
            echo "5. Replace everything in: $credentialsPath\n";
            echo "6. Save the file\n\n";
        } else {
            echo "   ✅ Real credentials detected\n";
        }
    }
}

// Step 2: Test Google API connection with better error handling
echo "2. Testing Google API connection...\n";
try {
    if (file_exists($credentialsPath)) {
        $client = new \Google\Client();
        $client->setApplicationName('NIRCRM Employee Task Sync');
        $client->setScopes([\Google\Service\Sheets::SPREADSHEETS]);
        $client->setAuthConfig($credentialsPath);
        
        // Test authentication
        $service = new \Google\Service\Sheets($client);
        $spreadsheetId = '125KWWjtxDw4iriHc1qzeuX3KPb_04NkbTBnEqliwnNk';
        
        // Test with a simple read operation
        $response = $service->spreadsheets_values->get($spreadsheetId, 'Manali!A1:A1');
        
        echo "   ✅ Google API authentication successful\n";
        echo "   ✅ Spreadsheet accessible\n";
        
        // Test write permissions
        $range = 'Test!A1:B1';
        $values = [['Test', 'Data']];
        $body = new \Google\Service\Sheets\ValueRange(['values' => $values]);
        
        try {
            $service->spreadsheets_values->append($spreadsheetId, $range, $body, ['valueInputOption' => 'RAW']);
            echo "   ✅ Write permissions working\n";
            
            // Clean up test data
            $service->spreadsheets_values->clear($spreadsheetId, 'Test!A1:B1');
            echo "   ✅ Test cleanup completed\n";
            
        } catch (\Google\Service\Exception $e) {
            echo "   ⚠️  Write permission issue: " . $e->getMessage() . "\n";
            echo "   🔧 Fix: Ensure service account has Editor access\n";
        }
        
    }
} catch (\Google\Service\Exception $e) {
    echo "   ❌ Google API Error: " . $e->getMessage() . "\n";
    
    // Provide specific error solutions
    $message = strtolower($e->getMessage());
    
    if (strpos($message, 'invalid') !== false && strpos($message, 'credentials') !== false) {
        echo "   🔧 Solution: Check credentials file content\n";
    } elseif (strpos($message, 'permission') !== false || strpos($message, 'forbidden') !== false) {
        echo "   🔧 Solution: Share sheet with service account email\n";
        echo "   📧 Service account email: " . ($data['client_email'] ?? 'Check your JSON file') . "\n";
    } elseif (strpos($message, 'not found') !== false) {
        echo "   🔧 Solution: Check spreadsheet ID and sheet names\n";
    } elseif (strpos($message, 'openssl') !== false) {
        echo "   🔧 Solution: Check private key format\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ General Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Step 3: Check sheet names
echo "3. Verifying required sheets exist...\n";
$requiredSheets = ['Manali', 'Kiran', 'Mohit', 'Shubham', 'Prathamesh'];
echo "   Required sheets: " . implode(', ', $requiredSheets) . "\n";

try {
    if (file_exists($credentialsPath) && isset($data) && strpos($data['client_email'], 'your-project') === false) {
        $client = new \Google\Client();
        $client->setAuthConfig($credentialsPath);
        $service = new \Google\Service\Sheets($client);
        
        $spreadsheetId = '125KWWjtxDw4iriHc1qzeuX3KPb_04NkbTBnEqliwnNk';
        $response = $service->spreadsheets->get($spreadsheetId);
        $sheets = $response->getSheets();
        
        $existingSheets = [];
        foreach ($sheets as $sheet) {
            $existingSheets[] = $sheet->getProperties()->getTitle();
        }
        
        echo "   Found sheets: " . implode(', ', $existingSheets) . "\n";
        
        $missingSheets = array_diff($requiredSheets, $existingSheets);
        if (!empty($missingSheets)) {
            echo "   ❌ Missing sheets: " . implode(', ', $missingSheets) . "\n";
            echo "   🔧 Solution: Create these sheets in your Google Sheet\n";
        } else {
            echo "   ✅ All required sheets exist\n";
        }
    }
} catch (Exception $e) {
    echo "   ⚠️  Could not verify sheets: " . $e->getMessage() . "\n";
}

echo "\n=== Fix Complete ===\n\n";

echo "🎯 QUICK ACTIONS:\n";
echo "1. Replace template credentials with REAL ones\n";
echo "2. Share sheet with service account email\n";
echo "3. Create all 5 sheets (Manali, Kiran, Mohit, Shubham, Prathamesh)\n";
echo "4. Test sync again\n\n";

echo "📞 If still failing:\n";
echo "• Check Laravel logs: storage/logs/laravel.log\n";
echo "• Verify spreadsheet ID: 125KWWjtxDw4iriHc1qzeuX3KPb_04NkbTBnEqliwnNk\n";
echo "• Test with manual API call\n\n";
