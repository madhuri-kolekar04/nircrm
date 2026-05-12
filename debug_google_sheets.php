<?php

/**
 * Google Sheets Sync Debug Script
 * 
 * This script helps debug Google Sheets sync issues
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Google Sheets Sync Debug ===\n\n";

// Test 1: Check if credentials file exists
echo "1. Checking credentials file...\n";
$credentialsPath = base_path('storage/app/google-credentials.json');
if (file_exists($credentialsPath)) {
    echo "   ✅ Credentials file found: $credentialsPath\n";
    
    // Check if it's readable
    if (is_readable($credentialsPath)) {
        echo "   ✅ File is readable\n";
        
        // Check content
        $content = file_get_contents($credentialsPath);
        $data = json_decode($content, true);
        
        if ($data) {
            echo "   ✅ Valid JSON format\n";
            
            // Check for required fields
            $requiredFields = ['type', 'project_id', 'private_key', 'client_email'];
            $missingFields = [];
            
            foreach ($requiredFields as $field) {
                if (!isset($data[$field])) {
                    $missingFields[] = $field;
                }
            }
            
            if (empty($missingFields)) {
                echo "   ✅ All required fields present\n";
                
                // Check if it's template or real data
                if (strpos($data['client_email'], 'your-project') !== false) {
                    echo "   ⚠️  WARNING: Still using template data\n";
                    echo "   📝 You need to replace with real Google credentials\n";
                } else {
                    echo "   ✅ Real credentials detected\n";
                }
            } else {
                echo "   ❌ Missing fields: " . implode(', ', $missingFields) . "\n";
            }
        } else {
            echo "   ❌ Invalid JSON format\n";
        }
    } else {
        echo "   ❌ File is not readable\n";
    }
} else {
    echo "   ❌ Credentials file NOT found: $credentialsPath\n";
    echo "   📝 Please create this file with your Google credentials\n";
}
echo "\n";

// Test 2: Check Google Sheets API availability
echo "2. Testing Google Sheets API...\n";
try {
    if (class_exists('Google\Client')) {
        echo "   ✅ Google API Client available\n";
    } else {
        echo "   ❌ Google API Client not available\n";
    }
    
    if (class_exists('Google\Service\Sheets')) {
        echo "   ✅ Google Sheets Service available\n";
    } else {
        echo "   ❌ Google Sheets Service not available\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error checking API: " . $e->getMessage() . "\n";
}
echo "\n";

// Test 3: Test Google Sheets connection
echo "3. Testing Google Sheets connection...\n";
try {
    $credentialsPath = base_path('storage/app/google-credentials.json');
    
    if (file_exists($credentialsPath)) {
        $client = new \Google\Client();
        $client->setApplicationName('NIRCRM Employee Task Sync Test');
        $client->setScopes([\Google\Service\Sheets::SPREADSHEETS]);
        $client->setAuthConfig($credentialsPath);
        
        $service = new \Google\Service\Sheets($client);
        
        // Test reading the spreadsheet
        $spreadsheetId = '125KWWjtxDw4iriHc1qzeuX3KPb_04NkbTBnEqliwnNk';
        $range = 'Manali!A1:E1'; // Small test range
        
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();
        
        if ($values !== null) {
            echo "   ✅ Successfully connected to Google Sheets\n";
            echo "   ✅ Spreadsheet accessible\n";
            echo "   ✅ Test data retrieved\n";
        } else {
            echo "   ✅ Connected but no data found (this is OK)\n";
        }
    }
} catch (\Google\Service\Exception $e) {
    echo "   ❌ Google Sheets API Error: " . $e->getMessage() . "\n";
    echo "   📋 Error details: " . json_encode($e->getErrors()) . "\n";
} catch (Exception $e) {
    echo "   ❌ General Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Test 4: Check employee tasks
echo "4. Checking employee tasks...\n";
try {
    $tasks = \App\Models\EmployeeTask::count();
    echo "   ✅ Employee tasks table accessible\n";
    echo "   📊 Total tasks in database: $tasks\n";
    
    if ($tasks > 0) {
        echo "   ✅ Sample data available for sync\n";
    } else {
        echo "   ⚠️  No tasks found - add some tasks first\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error accessing tasks: " . $e->getMessage() . "\n";
}
echo "\n";

echo "=== Debug Complete ===\n\n";

echo "📋 Next Steps:\n";
echo "1. If credentials file missing → Create it with real Google credentials\n";
echo "2. If using template data → Replace with real credentials\n";
echo "3. If connection fails → Check service account permissions\n";
echo "4. If no tasks → Add some tasks first, then sync\n\n";

echo "📝 Quick Fix Commands:\n";
echo "• Add tasks: http://localhost/nircrm/niremptask\n";
echo "• Test sync: Click 'Sync to Sheets' button\n";
echo "• Check logs: storage/logs/laravel.log\n\n";
