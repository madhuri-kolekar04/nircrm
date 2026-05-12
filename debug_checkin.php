<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Attendance Check-In Debug ===\n\n";

try {
    // Test database connection
    echo "1. Testing database connection...\n";
    $pdo = DB::connection()->getPdo();
    echo "✓ Database connection: OK\n\n";

    // Test attendance table structure
    echo "2. Checking attendance table structure...\n";
    $columns = DB::select("DESCRIBE attendances");
    foreach ($columns as $column) {
        echo "- {$column->Field}: {$column->Type}\n";
    }
    echo "\n";

    // Test current user
    echo "3. Testing authentication...\n";
    if (Auth::check()) {
        $user = Auth::user();
        echo "✓ Current user: {$user->name} (ID: {$user->id})\n";
        echo "✓ User role: {$user->role}\n";
        echo "✓ User active: " . ($user->is_active ? 'Yes' : 'No') . "\n";
    } else {
        echo "✗ No authenticated user\n";
        exit(1);
    }
    echo "\n";

    // Test today's attendance
    echo "4. Checking today's attendance...\n";
    $today = date('Y-m-d');
    $attendance = DB::table('attendances')
        ->where('user_id', $user->id)
        ->where('date', $today)
        ->first();
    
    if ($attendance) {
        echo "✓ Found attendance record for today\n";
        echo "- Check-in time: " . ($attendance->check_in_time ?? 'Not set') . "\n";
        echo "- Check-out time: " . ($attendance->check_out_time ?? 'Not set') . "\n";
        echo "- Status: {$attendance->status}\n";
    } else {
        echo "✗ No attendance record for today\n";
    }
    echo "\n";

    // Test check-in process simulation
    echo "5. Simulating check-in process...\n";
    
    // Check if already checked in
    if ($attendance && $attendance->check_in_time) {
        echo "✗ Already checked in today\n";
    } else {
        echo "✓ Can check in - proceeding with simulation\n";
        
        // Test creating attendance record
        try {
            $now = date('Y-m-d H:i:s');
            $attendanceId = DB::table('attendances')->insertGetId([
                'user_id' => $user->id,
                'date' => $today,
                'check_in_time' => $now,
                'status' => 'present',
                'ip_address' => request()->ip() ?? '127.0.0.1',
                'location' => 'Office',
                'created_at' => $now,
                'updated_at' => $now
            ]);
            
            echo "✓ Attendance record created with ID: {$attendanceId}\n";
            
            // Clean up test record
            DB::table('attendances')->where('id', $attendanceId)->delete();
            echo "✓ Test record cleaned up\n";
            
        } catch (\Exception $e) {
            echo "✗ Error creating attendance record: " . $e->getMessage() . "\n";
        }
    }
    echo "\n";

    // Test required migrations
    echo "6. Checking required migrations...\n";
    $migrations = DB::table('migrations')->pluck('migration')->toArray();
    
    $requiredMigrations = [
        '2024_02_19_150001_add_missing_user_columns',
        '2024_02_19_150000_create_attendances_table',
        '2024_02_19_150002_create_shifts_table'
    ];
    
    foreach ($requiredMigrations as $migration) {
        if (in_array($migration, $migrations)) {
            echo "✓ {$migration}\n";
        } else {
            echo "✗ {$migration} - Missing\n";
        }
    }

} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Debug Complete ===\n";
