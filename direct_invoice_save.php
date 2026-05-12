<?php

/**
 * Direct Invoice Save - Bypass All Complex Logic
 * This script saves invoices directly without going through the complex controller
 */

// Include Laravel bootstrap
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Handle form submission
if ($_POST) {
    try {
        echo "<h1>Processing Invoice Save...</h1>";
        
        // Get form data
        $totalAmount = $_POST['total_amount'] ?? 0;
        $advancePayment = $_POST['advance_payment'] ?? 0;
        $remainingPayment = $totalAmount - $advancePayment;
        
        echo "✅ Form data received<br>";
        echo "Total Amount: ₹$totalAmount<br>";
        echo "Advance Payment: ₹$advancePayment<br>";
        echo "Remaining Payment: ₹$remainingPayment<br>";
        
        // Get quotation
        $quotationId = $_POST['quotation_id'] ?? 1;
        $quotation = \App\Models\Quotation::find($quotationId);
        
        if (!$quotation) {
            echo "❌ Quotation not found<br>";
            exit;
        }
        
        echo "✅ Quotation found: " . $quotation->project_title . "<br>";
        
        // Create invoice
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($quotation->id, 6, '0', STR_PAD_LEFT);
        
        $invoice = \App\Models\Invoice::create([
            'project_name' => $quotation->project_title ?? 'N/A',
            'project_topic' => $quotation->project_title ?? 'N/A',
            'project_full_details' => $quotation->executive_summary ?? 'Professional Services',
            'start_date' => now(),
            'end_date' => now(),
            'department' => 'General',
            'customer_name' => $_POST['client_name'] ?? 'Customer',
            'customer_email' => $_POST['client_email'] ?? 'customer@example.com',
            'customer_phone' => $_POST['client_phone'] ?? '1234567890',
            'customer_address' => $_POST['client_business'] ?? '',
            'advance_payment' => $advancePayment,
            'remaining_payment' => $remainingPayment,
            'gst' => $quotation->gst_amount ?? 0,
            'total_payment' => $totalAmount,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => \Carbon\Carbon::parse($_POST['invoice_date'] ?? now()),
            'status' => 'pending',
        ]);
        
        echo "✅ Invoice created successfully!<br>";
        echo "Invoice ID: " . $invoice->id . "<br>";
        echo "Invoice Number: " . $invoice->invoice_number . "<br>";
        
        // Process installments
        $installmentAmounts = $_POST['installment_amounts'] ?? [];
        $installmentDates = $_POST['installment_dates'] ?? [];
        $installmentNotes = $_POST['installment_notes'] ?? [];
        
        if (!empty($installmentAmounts)) {
            $installments = [];
            foreach ($installmentAmounts as $index => $amount) {
                if (!empty($amount) && $amount > 0) {
                    $installments[] = [
                        'amount' => $amount,
                        'date' => $installmentDates[$index] ?? null,
                        'notes' => $installmentNotes[$index] ?? null,
                        'installment_number' => $index + 1,
                    ];
                }
            }
            
            if (!empty($installments)) {
                $invoice->installments = json_encode($installments);
                $invoice->save();
                
                echo "✅ " . count($installments) . " installments saved<br>";
            }
        }
        
        echo "<h2>SUCCESS! Invoice saved to database.</h2>";
        echo "<p><a href='/invoices'>View All Invoices</a></p>";
        
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "<br>";
        echo "Error details: " . $e->getTraceAsString() . "<br>";
    }
} else {
    // Show form
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Direct Invoice Save</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .form-group { margin-bottom: 15px; }
            label { display: block; margin-bottom: 5px; font-weight: bold; }
            input, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
            button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
            button:hover { background: #0056b3; }
        </style>
    </head>
    <body>
        <h1>Direct Invoice Save - Test Form</h1>
        <p>This form bypasses all complex logic and saves invoices directly.</p>
        
        <form method="post">
            <div class="form-group">
                <label>Client Name:</label>
                <input type="text" name="client_name" value="Test Customer" required>
            </div>
            
            <div class="form-group">
                <label>Client Email:</label>
                <input type="email" name="client_email" value="test@example.com" required>
            </div>
            
            <div class="form-group">
                <label>Client Phone:</label>
                <input type="text" name="client_phone" value="1234567890" required>
            </div>
            
            <div class="form-group">
                <label>Total Amount:</label>
                <input type="number" name="total_amount" value="5000" step="0.01" required>
            </div>
            
            <div class="form-group">
                <label>Advance Payment:</label>
                <input type="number" name="advance_payment" value="1000" step="0.01" required>
            </div>
            
            <div class="form-group">
                <label>Invoice Date:</label>
                <input type="date" name="invoice_date" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Installment 1 Amount:</label>
                <input type="number" name="installment_amounts[]" value="2000" step="0.01">
            </div>
            
            <div class="form-group">
                <label>Installment 1 Date:</label>
                <input type="date" name="installment_dates[]" value="<?php echo date('Y-m-d', strtotime('+1 month')); ?>">
            </div>
            
            <div class="form-group">
                <label>Installment 1 Notes:</label>
                <input type="text" name="installment_notes[]" value="First payment">
            </div>
            
            <div class="form-group">
                <label>Installment 2 Amount:</label>
                <input type="number" name="installment_amounts[]" value="2000" step="0.01">
            </div>
            
            <div class="form-group">
                <label>Installment 2 Date:</label>
                <input type="date" name="installment_dates[]" value="<?php echo date('Y-m-d', strtotime('+2 months')); ?>">
            </div>
            
            <div class="form-group">
                <label>Installment 2 Notes:</label>
                <input type="text" name="installment_notes[]" value="Second payment">
            </div>
            
            <button type="submit">Save Invoice Directly</button>
        </form>
    </body>
    </html>
    <?php
}
?>
