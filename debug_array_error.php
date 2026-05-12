<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Debug Array Key Error ===\n\n";

try {
    echo "1. Testing User model role access...\n";
    
    // Test with real users from database
    $users = \App\Models\User::limit(5)->get();
    
    foreach ($users as $user) {
        echo "User ID: {$user->id}, Role: {$user->role}, Name: {$user->name}\n";
        
        try {
            $roleName = $user->getRoleNameAttribute();
            echo "  Role Name: $roleName\n";
        } catch (Exception $e) {
            echo "  ERROR in getRoleNameAttribute: " . $e->getMessage() . "\n";
        }
        
        try {
            echo "  Department: ";
            if ($user->department) {
                if (is_object($user->department)) {
                    echo $user->department->name . "\n";
                } else {
                    echo $user->department . " (string)\n";
                }
            } else {
                echo "N/A\n";
            }
        } catch (Exception $e) {
            echo "  ERROR in department access: " . $e->getMessage() . "\n";
        }
        
        echo "\n";
    }
    
    echo "2. Testing AttendanceController stats...\n";
    
    $controller = new \App\Http\Controllers\AttendanceController();
    
    // Test getAttendanceStats method
    $testUsers = \App\Models\User::limit(3)->get();
    $today = new \Carbon\Carbon();
    
    try {
        $stats = $controller->getAttendanceStats($testUsers, $today);
        echo "Stats keys: " . implode(', ', array_keys($stats)) . "\n";
        foreach ($stats as $key => $value) {
            echo "  $key: $value\n";
        }
    } catch (Exception $e) {
        echo "  ERROR in getAttendanceStats: " . $e->getMessage() . "\n";
        echo "  File: " . $e->getFile() . "\n";
        echo "  Line: " . $e->getLine() . "\n";
    }
    
    echo "\n3. Testing getMonthlyStats method...\n";
    
    try {
        $monthlyStats = $controller->getMonthlyStats($testUsers);
        echo "Monthly Stats keys: " . implode(', ', array_keys($monthlyStats)) . "\n";
        foreach ($monthlyStats as $key => $value) {
            echo "  $key: $value\n";
        }
    } catch (Exception $e) {
        echo "  ERROR in getMonthlyStats: " . $e->getMessage() . "\n";
        echo "  File: " . $e->getFile() . "\n";
        echo "  Line: " . $e->getLine() . "\n";
    }
    
    echo "\n4. Testing MenuPermission model...\n";
    
    $menuPermissions = \App\Models\MenuPermission::limit(3)->get();
    
    foreach ($menuPermissions as $menu) {
        echo "Menu ID: {$menu->id}, Role ID: {$menu->role_id}, Name: {$menu->menu_name}\n";
        
        try {
            $roleName = $menu->getRoleNameAttribute();
            echo "  Role Name: $roleName\n";
        } catch (Exception $e) {
            echo "  ERROR in MenuPermission getRoleNameAttribute: " . $e->getMessage() . "\n";
        }
        
        echo "\n";
    }
    
    echo "\n=== Debug Complete ===\n";
    
} catch (Exception $e) {
    echo "FATAL ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
