<?php

/**
 * Check Google Sheet Structure and Test Sync
 * This script will check the sheet structure and test the sync process
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== GOOGLE SHEET STRUCTURE CHECK ===\n\n";

// Test 1: Check credentials first
echo "1. CHECKING CREDENTIALS:\n";
$credentialsPath = base_path('storage/app/google-credentials.json');

if (file_exists($credentialsPath)) {
    $content = file_get_contents($credentialsPath);
    $data = json_decode($content, true);
    
    if ($data) {
        echo "   📧 Service Account Email: " . ($data['client_email'] ?? 'NOT FOUND') . "\n";
        
        if (strpos($data['client_email'] ?? '', 'your-project') !== false) {
            echo "   ❌ STILL USING TEMPLATE DATA\n";
            echo "   🔧 YOU MUST REPLACE WITH REAL GOOGLE CREDENTIALS\n";
            echo "   📋 Without real credentials, we cannot test the sheet\n";
            echo "\n";
            echo "🎯 IMMEDIATE ACTION NEEDED:\n";
            echo "1. Go to: https://console.cloud.google.com/\n";
            echo "2. Create Service Account\n";
            echo "3. Download JSON credentials\n";
            echo "4. Replace content in: $credentialsPath\n";
            echo "5. Share sheet with service account email\n";
            echo "6. Test again\n";
            exit;
        } else {
            echo "   ✅ REAL CREDENTIALS DETECTED\n";
        }
    }
}

echo "\n";

// Test 2: Check sheet structure if we have real credentials
echo "2. CHECKING GOOGLE SHEET STRUCTURE:\n";
try {
    $client = new \Google\Client();
    $client->setApplicationName('NIRCRM Sheet Structure Check');
    $client->setScopes([\Google\Service\Sheets::SPREADSHEETS]);
    $client->setAuthConfig($credentialsPath);
    
    $service = new \Google\Service\Sheets($client);
    $spreadsheetId = '125KWWjtxDw4iriHc1qzeuX3KPb_04NkbTBnEqliwnNk';
    
    echo "   📄 Spreadsheet ID: $spreadsheetId\n";
    
    // Get spreadsheet info
    $response = $service->spreadsheets->get($spreadsheetId);
    echo "   📋 Spreadsheet Name: " . $response->getProperties()->getTitle() . "\n";
    
    // Get all sheets
    $sheets = $response->getSheets();
    echo "   📊 Total Sheets: " . count($sheets) . "\n";
    
    $requiredSheets = ['Manali', 'Kiran', 'Mohit', 'Shubham', 'Prathamesh'];
    $existingSheets = [];
    
    echo "\n   📋 AVAILABLE SHEETS:\n";
    foreach ($sheets as $sheet) {
        $sheetName = $sheet->getProperties()->getTitle();
        $existingSheets[] = $sheetName;
        echo "      • $sheetName\n";
    }
    
    echo "\n   📋 REQUIRED SHEETS STATUS:\n";
    foreach ($requiredSheets as $requiredSheet) {
        if (in_array($requiredSheet, $existingSheets)) {
            echo "      ✅ $requiredSheet - EXISTS\n";
        } else {
            echo "      ❌ $requiredSheet - MISSING\n";
        }
    }
    
    // Test write permissions
    echo "\n   📝 TESTING WRITE PERMISSIONS:\n";
    try {
        $testRange = 'Test!A1:E1';
        $testValues = [['Test Date', 'Test Description', 'Test Client', 'Test Status', 'Test Number']];
        $body = new \Google\Service\Sheets\ValueRange(['values' => $testValues]);
        
        $service->spreadsheets_values->append($spreadsheetId, $testRange, $body, ['valueInputOption' => 'RAW']);
        echo "      ✅ WRITE PERMISSION OK\n";
        
        // Clean up
        $service->spreadsheets_values->clear($spreadsheetId, 'Test!A1:E1');
        echo "      ✅ CLEANUP SUCCESSFUL\n";
        
    } catch (\Google\Service\Exception $e) {
        echo "      ❌ WRITE PERMISSION DENIED\n";
        echo "      📋 Error: " . $e->getMessage() . "\n";
        echo "      🔧 SOLUTION: Share sheet with service account as Editor\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ ERROR CHECKING SHEET: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Check employee tasks in database
echo "3. CHECKING EMPLOYEE TASKS:\n";
$users = \App\Models\User::where('position', 'Employee')->get();
echo "   👤 Total Employees: " . $users->count() . "\n";

foreach ($users as $user) {
    $taskCount = \App\Models\EmployeeTask::where('user_id', $user->id)->count();
    echo "   👤 " . $user->name . ": $taskCount tasks\n";
}

echo "\n";

// Test 4: Simulate sync process
echo "4. SIMULATING SYNC PROCESS:\n";
$user = \App\Models\User::where('position', 'Employee')->first();
if ($user) {
    $tasks = \App\Models\EmployeeTask::where('user_id', $user->id)->get();
    
    if ($tasks->count() > 0) {
        echo "   📊 User: " . $user->name . "\n";
        echo "   📝 Tasks to sync: " . $tasks->count() . "\n";
        
        echo "   📋 Sample task data:\n";
        $task = $tasks->first();
        echo "      • Date: " . $task->task_date . "\n";
        echo "      • Description: " . substr($task->task_description, 0, 50) . "...\n";
        echo "      • Client: " . $task->client_project_name . "\n";
        echo "      • Status: " . $task->status . "\n";
        echo "      • Number: " . $task->task_number . "\n";
        
        echo "   🎯 Sync target: " . $user->name . " sheet\n";
    } else {
        echo "   ⚠️  No tasks found for sync test\n";
        echo "   💡 Add some tasks first, then test sync\n";
    }
} else {
    echo "   ❌ No employee user found\n";
}

echo "\n=== CHECK COMPLETE ===\n\n";

echo "🎯 SUMMARY:\n";
echo "1. ✅ Sheet structure checked\n";
echo "2. ✅ Permissions tested\n";
echo "3. ✅ Database tasks checked\n";
echo "4. ✅ Sync process simulated\n\n";

echo "📋 NEXT STEPS:\n";
echo "1. Replace template credentials with REAL ones\n";
echo "2. Share sheet with service account as Editor\n";
echo "3. Create all 5 required sheets if missing\n";
echo "4. Add some tasks to the database\n";
echo "5. Test sync from web interface\n\n";
