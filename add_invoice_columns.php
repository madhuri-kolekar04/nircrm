<?php
// Add invoice columns to leads table
require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Adding Invoice Columns to Leads Table ===\n\n";

try {
    // Check if columns already exist
    $columns = \Schema::getColumnListing('leads');
    
    $neededColumns = ['invoice_status', 'invoice_number', 'invoice_created_at'];
    
    foreach ($neededColumns as $column) {
        if (in_array($column, $columns)) {
            echo "✅ Column '$column' already exists\n";
        } else {
            echo "🔧 Adding column '$column'...\n";
            
            switch ($column) {
                case 'invoice_status':
                    \Schema::table('leads', function ($table) {
                        $table->string('invoice_status')->default('pending')->after('department_id');
                    });
                    break;
                case 'invoice_number':
                    \Schema::table('leads', function ($table) {
                        $table->string('invoice_number')->nullable()->after('invoice_status');
                    });
                    break;
                case 'invoice_created_at':
                    \Schema::table('leads', function ($table) {
                        $table->timestamp('invoice_created_at')->nullable()->after('invoice_number');
                    });
                    break;
            }
            
            echo "✅ Column '$column' added successfully\n";
        }
    }
    
    echo "\n📋 Updated leads table columns:\n";
    $newColumns = \Schema::getColumnListing('leads');
    foreach ($newColumns as $i => $column) {
        echo sprintf("%2d. %s\n", $i + 1, $column);
    }
    
    echo "\n✅ Invoice columns added successfully!\n";
    echo "The invoice system should work now.\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>
