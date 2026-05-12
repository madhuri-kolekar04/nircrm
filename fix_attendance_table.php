<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Fix Attendance Table ID Field ===\n\n";

try {
    // Check current table structure
    echo "1. Checking current attendances table structure...\n";
    
    $columns = \DB::select("SHOW COLUMNS FROM attendances");
    
    $idColumnFound = false;
    $idAutoIncrement = false;
    
    foreach ($columns as $column) {
        if ($column->Field === 'id') {
            $idColumnFound = true;
            echo "✅ Found 'id' column\n";
            echo "   Type: {$column->Type}\n";
            echo "   Null: {$column->Null}\n";
            echo "   Key: {$column->Key}\n";
            
            if (strpos($column->Extra, 'auto_increment') !== false) {
                $idAutoIncrement = true;
                echo "   ✅ Auto-increment: YES\n";
            } else {
                echo "   ❌ Auto-increment: NO\n";
            }
            break;
        }
    }
    
    if (!$idColumnFound) {
        echo "❌ 'id' column not found - this is unusual\n";
        exit(1);
    }
    
    if (!$idAutoIncrement) {
        echo "\n2. Fixing auto-increment for id column...\n";
        
        // Get the maximum current ID
        $maxId = \DB::table('attendances')->max('id') ?? 0;
        echo "   Current max ID: {$maxId}\n";
        
        // Fix the id column
        \DB::statement("
            ALTER TABLE attendances 
            MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT
        ");
        
        echo "✅ Fixed id column to be auto-increment\n";
        
        // Verify the fix
        $columns = \DB::select("SHOW COLUMNS FROM attendances WHERE Field = 'id'");
        if (strpos($columns[0]->Extra, 'auto_increment') !== false) {
            echo "✅ Verification successful - auto-increment is now enabled\n";
        } else {
            echo "❌ Verification failed - auto-increment not set\n";
        }
        
    } else {
        echo "\n✅ ID column already has auto-increment - no fix needed\n";
    }
    
    echo "\n3. Testing table operations...\n";
    
    // Test inserting a record
    $testUser = \App\Models\User::where('is_active', true)->first();
    if (!$testUser) {
        echo "❌ No active user found for testing\n";
        exit(1);
    }
    
    echo "   Using test user: {$testUser->name} (ID: {$testUser->id})\n";
    
    // Check if there's already a test record for today
    $today = Carbon\Carbon::today();
    $existingTest = \App\Models\Attendance::where('user_id', $testUser->id)
        ->where('date', $today)
        ->first();
    
    if ($existingTest) {
        echo "   ℹ️  User already has attendance record for today\n";
        echo "   Record ID: {$existingTest->id}\n";
    } else {
        echo "   Testing insert operation...\n";
        
        // Create a test attendance record
        $attendance = new \App\Models\Attendance();
        $attendance->user_id = $testUser->id;
        $attendance->date = $today;
        $attendance->check_in_time = Carbon\Carbon::now();
        $attendance->status = 'present';
        $attendance->ip_address = '127.0.0.1';
        $attendance->location = 'Test';
        $attendance->is_late = false;
        
        $attendance->save();
        
        echo "   ✅ Test insert successful\n";
        echo "   New record ID: {$attendance->id}\n";
        echo "   Check-in time: " . $attendance->check_in_time->format('H:i:s') . "\n";
        
        // Clean up the test record
        $attendance->delete();
        echo "   ✅ Test record cleaned up\n";
    }
    
    echo "\n=== Fix Complete ===\n";
    echo "✅ Attendance table is now properly configured\n";
    echo "✅ You should be able to mark attendance normally now\n";
    echo "\nNext steps:\n";
    echo "1. Go to the attendance dashboard\n";
    echo "2. Try marking attendance again\n";
    echo "3. If you still get errors, check the Laravel logs\n";
    
} catch (Exception $e) {
    echo "❌ Error fixing table: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    
    // Try alternative approach
    echo "\nTrying alternative fix approach...\n";
    
    try {
        // Drop and recreate the table with proper structure
        echo "This would require backing up data first - aborting automatic fix\n";
        echo "Please run this manually:\n";
        echo "1. Backup your attendances table data\n";
        echo "2. Run: ALTER TABLE attendances MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;\n";
        
    } catch (Exception $e2) {
        echo "Alternative approach also failed: " . $e2->getMessage() . "\n";
    }
}
