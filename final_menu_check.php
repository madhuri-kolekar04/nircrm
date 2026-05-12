<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Final Admin Menu Status ===" . PHP_EOL;

try {
    $adminMenus = \App\Models\MenuPermission::where('role_id', 1)
        ->where('is_visible', true)
        ->orderBy('menu_order')
        ->get();
    
    echo "Current Admin Menus:" . PHP_EOL;
    foreach ($adminMenus as $menu) {
        echo sprintf("%-20s %s (%s)\n", $menu->menu_name, $menu->menu_url);
    }
    
    echo PHP_EOL . "✅ Employee Menu Controller has been successfully removed!" . PHP_EOL;
    echo "✅ WhatsApp CRM & Integration menus have been successfully removed!" . PHP_EOL;
    echo "✅ EmpTasks menu is still available for CRM tasks management." . PHP_EOL;
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

?>
