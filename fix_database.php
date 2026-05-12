<?php
// Fix the database ID issue
require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Database Fix ===\n\n";

try {
    // Get the next ID
    $nextId = \DB::table('invoices')->max('id') + 1;
    echo "🔢 Next ID will be: $nextId\n";
    
    // Test inserting with explicit ID
    $testData = [
        'id' => $nextId,
        'invoice_number' => 'TEST-' . date('Y-m-d-His'),
        'invoice_date' => now()->format('Y-m-d'),
        'customer_name' => 'Test Customer',
        'customer_email' => 'test@example.com',
        'customer_phone' => '1234567890',
        'customer_address' => 'Test Address',
        'project_name' => 'Test Project',
        'project_topic' => 'Test Topic',
        'project_full_details' => 'Test Details',
        'department' => 'Test',
        'start_date' => now()->format('Y-m-d'),
        'end_date' => now()->format('Y-m-d'),
        'advance_payment' => 0,
        'remaining_payment' => 1000,
        'gst' => 0,
        'total_payment' => 1000,
        'status' => 'pending',
        'installments' => json_encode([]),
        'lead_id' => 1,
        'bank_account_number' => '',
        'ifsc_code' => '',
        'mobile_bank_number' => '',
        'company_pan' => '',
        'gst_number' => '',
        'place_of_supply' => 'Maharashtra',
        'hsn_code' => '998314',
        'payment_terms' => 'Test terms',
        'privacy_policy' => 'Test policy',
        'notes' => 'Test notes',
        'created_at' => now(),
        'updated_at' => now(),
    ];
    
    echo "💾 Inserting test record...\n";
    \DB::table('invoices')->insert($testData);
    
    echo "✅ Test record inserted successfully!\n";
    
    // Clean up the test record
    \DB::table('invoices')->where('id', $nextId)->delete();
    echo "🧹 Test record cleaned up\n";
    
    echo "\n✅ Database is working with explicit IDs!\n";
    echo "The invoice system should work now.\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>
