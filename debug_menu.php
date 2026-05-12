<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Mock a user with Employee role (role_id = 2)
$mockUser = new stdClass();
$mockUser->id = 1;
$mockUser->name = 'Test Employee';
$mockUser->role = 2; // Employee role

// Mock auth
auth()->shouldReceive('user')->andReturn($mockUser);
auth()->shouldReceive('check')->andReturn(true);

echo "Testing getVisibleMenusForCurrentUser() for Employee role:\n";
echo "======================================================\n";

// Include the helpers file to get access to the function
require_once __DIR__ . '/app/Helpers/helpers.php';

$menus = getVisibleMenusForCurrentUser();

echo "Found " . count($menus) . " visible menus:\n\n";

foreach ($menus as $index => $menu) {
    echo ($index + 1) . ". {$menu['name']} - {$menu['url']}\n";
}

echo "\nExpected visible menus for Employee (from database):\n";
echo "===================================================\n";

$employeeMenus = App\Models\MenuPermission::where('role_id', 2)
                                          ->where('is_visible', true)
                                          ->orderBy('menu_order')
                                          ->get();

foreach ($employeeMenus as $menu) {
    echo "- {$menu->menu_name} ({$menu->menu_url})\n";
}
