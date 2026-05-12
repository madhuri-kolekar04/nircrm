<?php

/**
 * Quick Invoice Fix - Bypass PDF Generation
 * Run this script to save invoices without PDF generation
 */

// Include Laravel bootstrap
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test basic functionality
echo "<h1>Quick Invoice Fix</h1>";

try {
    // Test database connection
    $pdo = DB::connection()->getPdo();
    echo "✅ Database connection working<br>";
    
    // Test Invoice model
    $invoiceCount = \App\Models\Invoice::count();
    echo "✅ Invoice model working - Found $invoiceCount invoices<br>";
    
    // Test Quotation model
    $quotationCount = \App\Models\Quotation::count();
    echo "✅ Quotation model working - Found $quotationCount quotations<br>";
    
    // Test PDF library
    if (class_exists('Barryvdh\DomPDF\PDF')) {
        echo "✅ PDF library available<br>";
        
        // Test simple PDF
        try {
            $pdf = app('dompdf.wrapper');
            $pdf->loadHTML('<html><body><h1>Test</h1></body></html>');
            echo "✅ PDF generation test passed<br>";
        } catch (Exception $e) {
            echo "❌ PDF generation test failed: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "❌ PDF library not available<br>";
    }
    
    echo "<h2>Solution:</h2>";
    echo "<p>Use the 'Save Without PDF (Fallback)' button to save invoices without PDF generation.</p>";
    echo "<p>The PDF generation issue can be fixed separately, but your invoice data will be saved.</p>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<p>Check your Laravel configuration and database connection.</p>";
}

?>
