<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== RECORDING SYNC DEBUG ===\n\n";

// 1. Check database connection
echo "1. DATABASE CONNECTION:\n";
try {
    $count = DB::table('call_recordings')->count();
    echo "   Connection: SUCCESS\n";
    echo "   Current recordings: $count\n";
} catch (Exception $e) {
    echo "   Connection: FAILED - " . $e->getMessage() . "\n";
}
echo "\n";

// 2. Check table structure
echo "2. TABLE STRUCTURE:\n";
try {
    $columns = DB::select('DESCRIBE call_recordings');
    echo "   Table exists: YES\n";
    echo "   Columns:\n";
    foreach ($columns as $column) {
        echo "   - {$column->Field} ({$column->Type})\n";
    }
} catch (Exception $e) {
    echo "   Table check: FAILED - " . $e->getMessage() . "\n";
}
echo "\n";

// 3. Test database insert
echo "3. TEST DATABASE INSERT:\n";
try {
    $testData = [
        'customer_phone' => '1234567890',
        'customer_name'  => 'Test Customer',
        'file_name'      => 'test_file.mp3',
        'employee_name'  => 'Test Employee',
        'sync_type'      => 'Manual',
        'file_url'       => 'https://test.com/test_file.mp3',
        'created_at'     => now(),
        'updated_at'     => now(),
    ];
    
    $inserted = DB::table('call_recordings')->insert($testData);
    echo "   Insert test: SUCCESS\n";
    echo "   Test data inserted\n";
    
    // Clean up test data
    DB::table('call_recordings')->where('customer_phone', '1234567890')->delete();
    echo "   Test data cleaned up\n";
    
} catch (Exception $e) {
    echo "   Insert test: FAILED - " . $e->getMessage() . "\n";
    echo "   This is likely why recordings aren't saving!\n";
}
echo "\n";

// 4. Check directory permissions
echo "4. DIRECTORY PERMISSIONS:\n";
$recordingsPath = public_path('recordings');
echo "   Path: $recordingsPath\n";
echo "   Exists: " . (file_exists($recordingsPath) ? "YES" : "NO") . "\n";
echo "   Writable: " . (is_writable($recordingsPath) ? "YES" : "NO") . "\n";
echo "\n";

// 5. Check recent Laravel logs
echo "5. RECENT ERRORS (if any):\n";
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $logs = file_get_contents($logFile);
    $recentLogs = substr($logs, -2000); // Last 2000 characters
    if (strpos($recentLogs, 'ERROR') !== false) {
        echo "   Recent errors found in laravel.log\n";
        echo "   Check the full log file for details\n";
    } else {
        echo "   No recent errors found\n";
    }
} else {
    echo "   Log file not found\n";
}
echo "\n";

echo "=== DEBUG COMPLETE ===\n";
echo "If the database insert test failed, that's your problem!\n";

?>
