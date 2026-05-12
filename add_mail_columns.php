<?php
// Add mail columns to invoices table
require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Adding Mail Columns to Invoices Table ===\n\n";

try {
    // Check if columns already exist
    $columns = \Schema::getColumnListing('invoices');
    
    $neededColumns = ['mail_id', 'mail_sent_at'];
    
    foreach ($neededColumns as $column) {
        if (in_array($column, $columns)) {
            echo "✅ Column '$column' already exists\n";
        } else {
            echo "🔧 Adding column '$column'...\n";
            
            switch ($column) {
                case 'mail_id':
                    \Schema::table('invoices', function ($table) {
                        $table->string('mail_id')->nullable()->after('approved_at');
                    });
                    break;
                case 'mail_sent_at':
                    \Schema::table('invoices', function ($table) {
                        $table->timestamp('mail_sent_at')->nullable()->after('mail_id');
                    });
                    break;
            }
            
            echo "✅ Column '$column' added successfully\n";
        }
    }
    
    echo "\n📋 Updated invoices table columns:\n";
    $newColumns = \Schema::getColumnListing('invoices');
    foreach ($newColumns as $i => $column) {
        echo sprintf("%2d. %s\n", $i + 1, $column);
    }
    
    echo "\n✅ Mail columns added successfully!\n";
    echo "The invoice email system should work now.\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>
