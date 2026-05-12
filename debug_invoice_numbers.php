<?php

/**
 * Debug Invoice Number Generation
 */

echo "<h1>Debug Invoice Number Generation</h1>";

// Include Laravel bootstrap
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "<h2>1. Check existing invoices in database</h2>";
    
    $allInvoices = \App\Models\Invoice::orderBy('invoice_number', 'desc')->take(10)->get();
    echo "Found " . $allInvoices->count() . " recent invoices:<br>";
    foreach ($allInvoices as $inv) {
        echo "- " . $inv->invoice_number . "<br>";
    }
    
    echo "<h2>2. Check current month pattern</h2>";
    $prefix = 'INV-';
    $year = date('Y');
    $month = date('m');
    $pattern = $prefix . $year . $month . '%';
    echo "Looking for pattern: $pattern<br>";
    
    $currentMonthInvoices = \App\Models\Invoice::where('invoice_number', 'like', $pattern)->get();
    echo "Found " . $currentMonthInvoices->count() . " invoices for current month:<br>";
    foreach ($currentMonthInvoices as $inv) {
        echo "- " . $inv->invoice_number . "<br>";
    }
    
    echo "<h2>3. Test single generation</h2>";
    
    // Test the method step by step
    $lastInvoice = \App\Models\Invoice::where('invoice_number', 'like', $pattern)
                        ->orderBy('invoice_number', 'desc')
                        ->first();
    
    if ($lastInvoice) {
        echo "Last invoice found: " . $lastInvoice->invoice_number . "<br>";
        $lastNumber = intval(substr($lastInvoice->invoice_number, -4));
        echo "Last number: $lastNumber<br>";
        $newNumber = $lastNumber + 1;
    } else {
        echo "No last invoice found for current month<br>";
        $newNumber = 1;
    }
    
    echo "New number: $newNumber<br>";
    
    $invoiceNumber = $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    echo "Generated invoice number: $invoiceNumber<br>";
    
    // Check if it exists
    $exists = \App\Models\Invoice::where('invoice_number', $invoiceNumber)->exists();
    echo "Exists in database: " . ($exists ? "YES" : "NO") . "<br>";
    
    echo "<h2>4. Test multiple generations with database persistence</h2>";
    
    // Create a test invoice to see if the sequence works
    $testInvoice = \App\Models\Invoice::create([
        'project_name' => 'Test Project',
        'project_topic' => 'Test Topic',
        'project_full_details' => 'Test Details',
        'start_date' => now(),
        'end_date' => now(),
        'department' => 'Test',
        'customer_name' => 'Test Customer',
        'customer_email' => 'test' . uniqid() . '@example.com',
        'customer_phone' => '1234567890',
        'customer_address' => 'Test Address',
        'advance_payment' => 1000,
        'remaining_payment' => 2000,
        'gst' => 0,
        'total_payment' => 3000,
        'invoice_number' => $invoiceNumber,
        'invoice_date' => now(),
        'status' => 'pending',
    ]);
    
    echo "✅ Created test invoice: " . $testInvoice->invoice_number . "<br>";
    
    // Now generate next number
    $nextInvoiceNumber = \App\Models\Invoice::generateInvoiceNumber();
    echo "Next generated number: $nextInvoiceNumber<br>";
    
    // Clean up
    $testInvoice->delete();
    echo "✅ Cleaned up test invoice<br>";
    
    echo "<h2>5. Test the actual method multiple times</h2>";
    
    for ($i = 1; $i <= 3; $i++) {
        $num = \App\Models\Invoice::generateInvoiceNumber();
        echo "Generation #$i: $num<br>";
        
        // Create and delete to test progression
        $temp = \App\Models\Invoice::create([
            'project_name' => "Temp $i",
            'project_topic' => "Temp $i",
            'project_full_details' => "Temp $i",
            'start_date' => now(),
            'end_date' => now(),
            'department' => 'Temp',
            'customer_name' => "Temp $i",
            'customer_email' => "temp$i" . uniqid() . '@example.com',
            'customer_phone' => '1234567890',
            'customer_address' => 'Temp',
            'advance_payment' => 1000,
            'remaining_payment' => 2000,
            'gst' => 0,
            'total_payment' => 3000,
            'invoice_number' => $num,
            'invoice_date' => now(),
            'status' => 'pending',
        ]);
        $temp->delete();
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "Trace: " . $e->getTraceAsString() . "<br>";
}

?>
