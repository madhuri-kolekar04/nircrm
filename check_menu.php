<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Admin Menu Check ===" . PHP_EOL;

try {
    $adminMenus = \App\Models\MenuPermission::where('role_id', 1)
        ->where('is_visible', true)
        ->orderBy('menu_order')
        ->get();
    
    echo "Current Admin Menus:" . PHP_EOL;
    foreach ($adminMenus as $menu) {
        echo "- " . $menu->menu_name . " (" . $menu->menu_url . ")" . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

?>
