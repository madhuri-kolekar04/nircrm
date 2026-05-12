<?php

/**
 * Debug PDF Generation Issues
 * This script helps identify common PDF generation problems
 */

echo "<h1>PDF Generation Debug Tool</h1>";

// Check 1: Laravel PDF Library
echo "<h2>1. Checking Laravel PDF Library</h2>";
if (class_exists('Barryvdh\DomPDF\PDF')) {
    echo "✅ Laravel PDF library is installed<br>";
} else {
    echo "❌ Laravel PDF library not found. Install with: composer require barryvdh/laravel-dompdf<br>";
}

// Check 2: DomPDF
echo "<h2>2. Checking DomPDF</h2>";
if (class_exists('Dompdf\Dompdf')) {
    echo "✅ DomPDF is available<br>";
} else {
    echo "❌ DomPDF not found<br>";
}

// Check 3: Required PHP Extensions
echo "<h2>3. Checking PHP Extensions</h2>";
$required_extensions = ['mbstring', 'gd', 'xml', 'dom'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext extension is loaded<br>";
    } else {
        echo "❌ $ext extension is missing<br>";
    }
}

// Check 4: Font Directory
echo "<h2>4. Checking Font Directory</h2>";
$fontDir = public_path('fonts');
if (is_dir($fontDir)) {
    echo "✅ Font directory exists: $fontDir<br>";
    if (is_readable($fontDir)) {
        echo "✅ Font directory is readable<br>";
    } else {
        echo "❌ Font directory is not readable<br>";
    }
} else {
    echo "❌ Font directory not found: $fontDir<br>";
    echo "Creating font directory...<br>";
    if (mkdir($fontDir, 0755, true)) {
        echo "✅ Font directory created<br>";
    } else {
        echo "❌ Failed to create font directory<br>";
    }
}

// Check 5: Storage Directory
echo "<h2>5. Checking Storage Directory</h2>";
$storagePath = storage_path();
echo "Storage path: $storagePath<br>";
if (is_writable($storagePath)) {
    echo "✅ Storage directory is writable<br>";
} else {
    echo "❌ Storage directory is not writable<br>";
}

// Check 6: Test Simple PDF Generation
echo "<h2>6. Testing Simple PDF Generation</h2>";
try {
    $html = '<html><body><h1>Test PDF</h1><p>This is a test PDF generation.</p></body></html>';
    
    if (class_exists('Barryvdh\DomPDF\PDF')) {
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($html);
        $pdf->setPaper('A4');
        
        // Try to save to file instead of download
        $testFile = storage_path('test-pdf.pdf');
        $pdf->save($testFile);
        
        if (file_exists($testFile)) {
            echo "✅ Simple PDF generation successful<br>";
            echo "Test file created: $testFile<br>";
            unlink($testFile); // Clean up
        } else {
            echo "❌ PDF file not created<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ PDF generation failed: " . $e->getMessage() . "<br>";
}

// Check 7: Test Invoice Template
echo "<h2>7. Testing Invoice Template</h2>";
try {
    $templateData = [
        'invoiceNumber' => 'TEST-001',
        'invoiceDate' => date('d M Y'),
        'clientName' => 'Test Client',
        'total_payment' => 1000,
        'quotation' => new stdClass(),
        'invoice' => new stdClass(),
    ];
    
    $templatePath = base_path('resources/views/backend/accounts/invoice-pdf-custom.blade.php');
    if (file_exists($templatePath)) {
        echo "✅ Invoice template exists<br>";
        
        // Try to render template
        if (function_exists('view')) {
            try {
                $view = view('backend.accounts.invoice-pdf-custom', $templateData);
                echo "✅ Template renders successfully<br>";
            } catch (Exception $e) {
                echo "❌ Template rendering failed: " . $e->getMessage() . "<br>";
            }
        }
    } else {
        echo "❌ Invoice template not found: $templatePath<br>";
    }
} catch (Exception $e) {
    echo "❌ Template test failed: " . $e->getMessage() . "<br>";
}

// Check 8: Memory Limit
echo "<h2>8. Checking Memory Limit</h2>";
$memoryLimit = ini_get('memory_limit');
echo "Current memory limit: $memoryLimit<br>";
if (intval($memoryLimit) < 256) {
    echo "⚠️ Memory limit might be too low for PDF generation<br>";
} else {
    echo "✅ Memory limit should be sufficient<br>";
}

// Check 9: Execution Time
echo "<h2>9. Checking Execution Time</h2>";
$maxExecutionTime = ini_get('max_execution_time');
echo "Max execution time: $maxExecutionTime seconds<br>";
if ($maxExecutionTime < 60) {
    echo "⚠️ Execution time might be too low for complex PDFs<br>";
} else {
    echo "✅ Execution time should be sufficient<br>";
}

echo "<h2>Debug Complete!</h2>";
echo "<p>Check your Laravel logs for detailed error messages: <code>storage/logs/laravel.log</code></p>";

?>
