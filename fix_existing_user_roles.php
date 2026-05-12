<?php

echo "=== FIXING EXISTING USER ROLES ===\n\n";

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "1. 🔍 CHECKING EXISTING USERS\n\n";

// Get all users
$users = User::all();

if ($users->count() > 0) {
    echo "Found {$users->count()} users:\n\n";
    
    foreach ($users as $user) {
        echo "User: {$user->name}\n";
        echo "Email: {$user->email}\n";
        echo "Position: {$user->position}\n";
        echo "Role: {$user->role}\n";
        
        // Determine what role should be
        $expectedRole = 2; // Default to Employee
        if ($user->position === 'Admin' || $user->position === 'admin') {
            $expectedRole = 1;
        }
        
        echo "Expected Role: {$expectedRole}\n";
        
        if ($user->role !== $expectedRole) {
            echo "❌ NEEDS UPDATE: Current role = {$user->role}, Should be {$expectedRole}\n";
            
            // Update the role
            $user->role = $expectedRole;
            $user->save();
            echo "✅ UPDATED: Role set to {$expectedRole}\n";
        } else {
            echo "✅ CORRECT: Role already set to {$expectedRole}\n";
        }
        
        echo "------------------------\n";
    }
} else {
    echo "No users found in database.\n";
}

echo "\n2. 🎯 ROLE MAPPING RULES\n\n";
echo "Admin (position = 'Admin' or 'admin') → role = 1\n";
echo "Employee (position = 'Employee' or 'employee') → role = 2\n";
echo "Any other position → role = 2 (Employee)\n\n";

echo "3. 🔐 LOGIN AUTHORIZATION CHECK\n\n";
echo "Login allows roles: [1, 2]\n";
echo "Role 1 = Admin → Redirects to /admin/dashboard\n";
echo "Role 2 = Employee → Redirects to /niremptask\n\n";

echo "4. 🚀 TESTING AFTER FIX\n\n";
echo "After running this script:\n";
echo "1. Try logging in with existing employee credentials\n";
echo "2. Should redirect to correct dashboard based on role\n";
echo "3. Should NOT get 'not authorized' error\n\n";

echo "5. 📋 MANUAL ROLE UPDATE (if needed)\n\n";
echo "If you still have issues, manually update users:\n";
echo "UPDATE users SET role = 1 WHERE position IN ('Admin', 'admin');\n";
echo "UPDATE users SET role = 2 WHERE position IN ('Employee', 'employee') OR position IS NULL;\n\n";

echo "=== COMPLETED ===\n";
echo "✅ User roles have been checked and updated\n";
echo "✅ Existing employees should now work properly\n";
echo "✅ Login should redirect correctly\n";

?>
