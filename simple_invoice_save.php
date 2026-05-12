<?php

/**
 * Simple Invoice Save - Minimal Version
 * This creates a basic invoice without any complex logic
 */

echo "<h1>Simple Invoice Save Test</h1>";

// Include Laravel bootstrap
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "<h2>Creating Minimal Invoice</h2>";
    
    // Get a sample quotation
    $quotation = \App\Models\Quotation::first();
    if (!$quotation) {
        echo "❌ No quotation found. Please create a quotation first.<br>";
        exit;
    }
    
    echo "✅ Using quotation ID: " . $quotation->id . "<br>";
    
    // Create minimal invoice data
    $invoiceData = [
        'project_name' => 'Test Project',
        'project_topic' => 'Test Topic',
        'project_full_details' => 'Test Details',
        'start_date' => now(),
        'end_date' => now(),
        'department' => 'General',
        'customer_name' => 'Test Customer',
        'customer_email' => 'test@example.com',
        'customer_phone' => '1234567890',
        'customer_address' => 'Test Address',
        'advance_payment' => 1000,
        'remaining_payment' => 2000,
        'gst' => 0,
        'total_payment' => 3000,
        'invoice_number' => 'SIMPLE-' . date('Y-m-d-His'),
        'invoice_date' => now(),
        'status' => 'pending',
    ];
    
    echo "Attempting to create invoice...<br>";
    
    $invoice = \App\Models\Invoice::create($invoiceData);
    
    echo "✅ SUCCESS! Invoice created with ID: " . $invoice->id . "<br>";
    echo "✅ Invoice Number: " . $invoice->invoice_number . "<br>";
    echo "✅ Total Amount: ₹" . $invoice->total_payment . "<br>";
    
    // Test installments
    echo "<h2>Adding Test Installments</h2>";
    
    $installments = [
        [
            'amount' => 1000,
            'date' => now()->addMonth()->format('Y-m-d'),
            'notes' => 'First installment',
            'installment_number' => 1,
        ],
        [
            'amount' => 1000,
            'date' => now()->addMonths(2)->format('Y-m-d'),
            'notes' => 'Second installment',
            'installment_number' => 2,
        ]
    ];
    
    $invoice->installments = json_encode($installments);
    $invoice->save();
    
    echo "✅ Installments added successfully<br>";
    echo "✅ Total installments: " . count($installments) . "<br>";
    
    echo "<h2>Verification</h2>";
    
    // Verify the invoice was saved
    $savedInvoice = \App\Models\Invoice::find($invoice->id);
    if ($savedInvoice) {
        echo "✅ Invoice verified in database<br>";
        echo "✅ Invoice Number: " . $savedInvoice->invoice_number . "<br>";
        echo "✅ Customer: " . $savedInvoice->customer_name . "<br>";
        echo "✅ Total: ₹" . $savedInvoice->total_payment . "<br>";
        
        if ($savedInvoice->installments) {
            $savedInstallments = json_decode($savedInvoice->installments, true);
            echo "✅ Installments saved: " . count($savedInstallments) . "<br>";
        }
    } else {
        echo "❌ Invoice not found in database<br>";
    }
    
    echo "<h2>Next Steps</h2>";
    echo "<p>If this test works, the issue is in the form submission process.</p>";
    echo "<p>Check the following in your form:</p>";
    echo "<ul>";
    echo "<li>All required fields are present</li>";
    echo "<li>Form submission is working</li>";
    echo "<li>JavaScript is not blocking submission</li>";
    echo "<li>CSRF token is valid</li>";
    echo "</ul>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "Error details: " . $e->getTraceAsString() . "<br>";
}

?>
