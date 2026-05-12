<?php

echo "🔧 Debugging Google Sheet Structure\n\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "1. Getting Raw Google Sheet Data...\n";
    
    $service = new \App\Services\GoogleSheetsServicePublic();
    
    // Get raw data (not mapped)
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('getSpreadsheetData');
    $method->setAccessible(true);
    $rawData = $method->invoke($service);
    
    if (empty($rawData)) {
        echo "   ❌ No raw data found\n";
        exit;
    }
    
    echo "   ✅ Found " . count($rawData) . " total rows (including header)\n";
    
    // Get headers
    $headers = array_shift($rawData);
    echo "   ✅ Headers: " . implode(', ', $headers) . "\n";
    echo "   ✅ Total columns: " . count($headers) . "\n";
    
    // Look for audit report content in first few rows
    echo "\n2. Analyzing First 5 Rows for Audit Content:\n";
    
    $auditContentFound = false;
    $rowIndex = 0;
    
    foreach ($rawData as $index => $row) {
        if ($index >= 5) break; // Check first 5 data rows
        
        echo "\n   Row " . ($index + 2) . " (after header):\n";
        
        foreach ($headers as $colIndex => $header) {
            $value = isset($row[$colIndex]) ? trim($row[$colIndex]) : '';
            
            if (!empty($value)) {
                // Check if this looks like audit report content
                if (stripos($value, 'FREE AI MARKETING AUDIT REPORT') !== false || 
                    stripos($value, 'Website First Impression') !== false ||
                    stripos($value, 'SEO & Google Visibility') !== false ||
                    stripos($value, 'Lead Generation Gaps') !== false ||
                    stripos($value, 'Quick Win') !== false) {
                    
                    echo "      🎯 AUDIT CONTENT FOUND in column '{$header}': " . substr($value, 0, 100) . "...\n";
                    $auditContentFound = true;
                } elseif (strlen($value) > 200) { // Long content might be audit report
                    echo "      📄 LONG CONTENT in column '{$header}': " . substr($value, 0, 100) . "...\n";
                } else {
                    echo "      📝 {$header}: {$value}\n";
                }
            }
        }
    }
    
    // Look for rows that contain audit report content
    echo "\n3. Searching for Audit Report Content in All Rows...\n";
    
    $auditReportRows = [];
    $auditReportPlainRows = [];
    
    foreach ($rawData as $rowIndex => $row) {
        foreach ($headers as $colIndex => $header) {
            $value = isset($row[$colIndex]) ? trim($row[$colIndex]) : '';
            
            if (stripos($value, 'FREE AI MARKETING AUDIT REPORT') !== false) {
                $auditReportRows[] = $rowIndex + 2; // +2 because header is row 1, and array is 0-indexed
            }
            
            if (stripos($value, 'Loading Speed') !== false && 
                stripos($value, 'Mobile Experience') !== false &&
                stripos($value, 'Trust Signals') !== false) {
                $auditReportPlainRows[] = $rowIndex + 2;
            }
        }
    }
    
    if (!empty($auditReportRows)) {
        echo "   ✅ Found audit_report content in rows: " . implode(', ', $auditReportRows) . "\n";
    }
    
    if (!empty($auditReportPlainRows)) {
        echo "   ✅ Found audit_report_plain content in rows: " . implode(', ', $auditReportPlainRows) . "\n";
    }
    
    // Check specific rows mentioned by user
    echo "\n4. Checking Specific Rows Mentioned by User...\n";
    
    $targetRows = [2680, 2610]; // User mentioned these rows
    
    foreach ($targetRows as $targetRow) {
        $actualIndex = $targetRow - 2; // Convert to array index (header is row 1)
        
        if (isset($rawData[$actualIndex])) {
            echo "\n   Row {$targetRow}:\n";
            $row = $rawData[$actualIndex];
            
            foreach ($headers as $colIndex => $header) {
                $value = isset($row[$colIndex]) ? trim($row[$colIndex]) : '';
                
                if (!empty($value)) {
                    $displayValue = strlen($value) > 150 ? substr($value, 0, 150) . '...' : $value;
                    echo "      📝 {$header}: {$displayValue}\n";
                }
            }
        } else {
            echo "\n   Row {$targetRow}: Not found (sheet has " . count($rawData) . " data rows)\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

?>
