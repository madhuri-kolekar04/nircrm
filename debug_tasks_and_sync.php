<?php

/**
 * Debug Tasks and Sync Process
 * This script will check your tasks and identify why they're not syncing to Google Sheets
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TASKS AND SYNC DEBUG ===\n\n";

// Test 1: Check if you have tasks in database
echo "1. CHECKING DATABASE TASKS:\n";
$users = \App\Models\User::where('position', 'Employee')->get();
echo "   👤 Total Employees: " . $users->count() . "\n\n";

foreach ($users as $user) {
    $tasks = \App\Models\EmployeeTask::where('user_id', $user->id)->get();
    echo "   👤 " . $user->name . " (ID: " . $user->id . "):\n";
    echo "      📊 Total Tasks: " . $tasks->count() . "\n";
    
    if ($tasks->count() > 0) {
        echo "      📋 Task Details:\n";
        foreach ($tasks as $task) {
            echo "         • Task #" . $task->task_number . ": " . substr($task->task_description, 0, 50) . "...\n";
            echo "           📅 Date: " . $task->task_date . "\n";
            echo "           🏢 Client: " . $task->client_project_name . "\n";
            echo "           📊 Status: " . $task->status . "\n";
            echo "           🆔 Task ID: " . $task->id . "\n\n";
        }
    } else {
        echo "      ⚠️  No tasks found\n\n";
    }
}

// Test 2: Check if credentials are real
echo "2. CHECKING GOOGLE SHEETS CREDENTIALS:\n";
$credentialsPath = base_path('storage/app/google-credentials.json');

if (file_exists($credentialsPath)) {
    $content = file_get_contents($credentialsPath);
    $data = json_decode($content, true);
    
    if ($data) {
        echo "   📧 Service Account Email: " . ($data['client_email'] ?? 'NOT FOUND') . "\n";
        
        if (strpos($data['client_email'] ?? '', 'your-project') !== false) {
            echo "   ❌ STILL USING TEMPLATE DATA\n";
            echo "   🔧 THIS IS WHY SYNC IS NOT WORKING!\n";
            echo "   📋 Template credentials cannot authenticate with Google\n";
        } else {
            echo "   ✅ REAL CREDENTIALS DETECTED\n";
        }
    }
} else {
    echo "   ❌ CREDENTIALS FILE NOT FOUND\n";
}

// Test 3: Try to simulate the exact sync process
echo "\n3. SIMULATING SYNC PROCESS:\n";
$user = \App\Models\User::where('position', 'Employee')->first();

if ($user) {
    $tasks = \App\Models\EmployeeTask::where('user_id', $user->id)->get();
    
    if ($tasks->count() > 0) {
        echo "   👤 Testing sync for: " . $user->name . "\n";
        echo "   📊 Tasks to sync: " . $tasks->count() . "\n";
        
        // Check if we can connect to Google Sheets
        try {
            $client = new \Google\Client();
            $client->setApplicationName('NIRCRM Employee Task Sync');
            $client->setScopes([\Google\Service\Sheets::SPREADSHEETS]);
            $client->setAuthConfig($credentialsPath);
            
            $service = new \Google\Service\Sheets($client);
            $spreadsheetId = '125KWWjtxDw4iriHc1qzeuX3KPb_04NkbTBnEqliwnNk';
            
            echo "   🔍 Testing Google Sheets connection...\n";
            
            // Test if we can access the spreadsheet
            $response = $service->spreadsheets->get($spreadsheetId);
            echo "   ✅ Spreadsheet accessible: " . $response->getProperties()->getTitle() . "\n";
            
            // Check if employee sheet exists
            $sheets = $response->getSheets();
            $sheetNames = [];
            foreach ($sheets as $sheet) {
                $sheetNames[] = $sheet->getProperties()->getTitle();
            }
            
            echo "   📋 Available sheets: " . implode(', ', $sheetNames) . "\n";
            
            if (in_array($user->name, $sheetNames)) {
                echo "   ✅ Employee sheet exists: " . $user->name . "\n";
                
                // Test write permissions
                try {
                    $testRange = $user->name . '!A1:E1';
                    $testValues = [['Test Date', 'Test Description', 'Test Client', 'Test Status', 'Test Number']];
                    $body = new \Google\Service\Sheets\ValueRange(['values' => $testValues]);
                    
                    $service->spreadsheets_values->append($spreadsheetId, $testRange, $body, ['valueInputOption' => 'RAW']);
                    echo "   ✅ Write permission OK\n";
                    
                    // Clean up test
                    $service->spreadsheets_values->clear($spreadsheetId, $user->name . '!A1:E1');
                    echo "   ✅ Test cleanup successful\n";
                    
                    // Show what data would be synced
                    echo "   📋 Data that would be synced:\n";
                    foreach ($tasks as $task) {
                        echo "      • [" . $task->task_date . "] " . $task->task_description . "\n";
                    }
                    
                } catch (\Google\Service\Exception $e) {
                    echo "   ❌ Write permission error: " . $e->getMessage() . "\n";
                    echo "   🔧 SOLUTION: Share sheet with service account as Editor\n";
                }
                
            } else {
                echo "   ❌ Employee sheet NOT found: " . $user->name . "\n";
                echo "   🔧 SOLUTION: Create sheet named '" . $user->name . "' in Google Sheets\n";
            }
            
        } catch (\Google\Service\Exception $e) {
            echo "   ❌ Google Sheets API error: " . $e->getMessage() . "\n";
            echo "   🔧 SOLUTION: Check credentials and permissions\n";
        } catch (Exception $e) {
            echo "   ❌ General error: " . $e->getMessage() . "\n";
            echo "   🔧 SOLUTION: Check credentials file format\n";
        }
        
    } else {
        echo "   ⚠️  No tasks to sync for " . $user->name . "\n";
        echo "   💡 Add some tasks first, then try to sync\n";
    }
} else {
    echo "   ❌ No employee user found\n";
}

echo "\n=== DEBUG COMPLETE ===\n\n";

echo "🎯 WHY TASKS ARE NOT SYNCING:\n";
echo "1. ❌ Still using template credentials (most likely)\n";
echo "2. ❌ Google Sheet not shared with service account\n";
echo "3. ❌ Service account doesn't have Editor permissions\n";
echo "4. ❌ Employee sheet doesn't exist in Google Sheets\n";
echo "5. ❌ No tasks in database to sync\n\n";

echo "🛠️ IMMEDIATE ACTIONS:\n";
echo "1. Replace template credentials with REAL Google credentials\n";
echo "2. Share Google Sheet with service account as Editor\n";
echo "3. Create employee sheets (Manali, Kiran, Mohit, Shubham, Prathamesh)\n";
echo "4. Add tasks to database via web interface\n";
echo "5. Test sync from web interface\n\n";

echo "📋 QUICK TEST:\n";
echo "• Add a task at: http://localhost/nircrm/niremptask\n";
echo "• Click 'Sync to Sheets' button\n";
echo "• Select your name\n";
echo "• Check if error occurs\n\n";
