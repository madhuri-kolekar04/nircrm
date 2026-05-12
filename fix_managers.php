<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'Assigning Manager User to IT Department...' . PHP_EOL;
$manager = \App\Models\User::where('name', 'Manager User')->first();
if ($manager) {
    $manager->department_id = 2; // IT Department
    $manager->save();
    echo 'Manager User assigned to IT Department' . PHP_EOL;
} else {
    echo 'Manager User not found' . PHP_EOL;
}

echo 'Creating/Assigning manager for HR Department...' . PHP_EOL;
$hrManager = \App\Models\User::where('email', 'hr.manager@niranjanenterprises.com')->first();
if (!$hrManager) {
    $hrManager = new \App\Models\User();
    $hrManager->name = 'HR Manager';
    $hrManager->email = 'hr.manager@niranjanenterprises.com';
    $hrManager->password = bcrypt('password');
    $hrManager->role = 4;
    $hrManager->department_id = 3; // HR Department
    $hrManager->department = 'HR Department'; // Set department field as well
    $hrManager->is_active = true;
    $hrManager->save();
    echo 'HR Manager created and assigned to HR Department' . PHP_EOL;
} else {
    $hrManager->department_id = 3;
    $hrManager->department = 'HR Department';
    $hrManager->save();
    echo 'Existing HR Manager assigned to HR Department' . PHP_EOL;
}

echo PHP_EOL . 'Verification:' . PHP_EOL;
$managers = \App\Models\User::where('role', 4)->where('is_active', true)->get();
foreach ($managers as $mgr) {
    $deptName = 'None';
    if ($mgr->department_id) {
        $dept = \App\Models\Department::find($mgr->department_id);
        $deptName = $dept ? $dept->name : 'Unknown';
    }
    echo $mgr->name . ' -> Dept: ' . $deptName . PHP_EOL;
}
