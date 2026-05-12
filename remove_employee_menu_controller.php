<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Removing Employee Menu Controller ===" . PHP_EOL;

try {
    // Find Employee Menu Controller menu
    $employeeMenuController = \App\Models\MenuPermission::where('menu_name', 'Employee Menu Controller')->first();
    if ($employeeMenuController) {
        echo "Found Employee Menu Controller menu, deleting..." . PHP_EOL;
        $employeeMenuController->delete();
        echo "Employee Menu Controller menu deleted successfully!" . PHP_EOL;
    } else {
        echo "Employee Menu Controller menu not found." . PHP_EOL;
    }
    
    echo PHP_EOL . "=== Verification ===" . PHP_EOL;
    
    // Verify removal
    $remainingMenus = \App\Models\MenuPermission::where('menu_name', 'like', '%Employee%')->get();
    
    echo "Remaining Employee-related menus: " . $remainingMenus->count() . PHP_EOL;
    foreach ($remainingMenus as $menu) {
        echo "- " . $menu->menu_name . " (" . $menu->menu_url . ")" . PHP_EOL;
    }
    
    if ($remainingMenus->count() === 0) {
        echo "All Employee Menu Controller items have been successfully removed!" . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

?>
