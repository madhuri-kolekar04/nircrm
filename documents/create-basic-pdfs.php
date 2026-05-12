<?php
/**
 * Basic PDF Generator for NIRCRM Documentation
 * Creates simple PDF files without external libraries
 */

// Document files to convert
$documents = [
    '00-Documentation-Index.md' => 'Documentation-Index',
    '01-Technical-Overview.md' => 'Technical-Overview',
    '02-Models-Database-Schema.md' => 'Models-Database-Schema',
    '03-Controllers-API-Documentation.md' => 'Controllers-API-Documentation',
    '04-UI-UX-Design-System.md' => 'UI-UX-Design-System',
    '05-User-Manual-Roles.md' => 'User-Manual-Roles',
    '06-Installation-Deployment-Guide.md' => 'Installation-Deployment-Guide',
    'README.md' => 'README'
];

// Output directory
$outputDir = __DIR__ . '/pdf/';

// Create output directory if it doesn't exist
if (!file_exists($outputDir)) {
    mkdir($outputDir, 0755, true);
}

echo "Creating basic PDF files...\n";
echo "Output directory: $outputDir\n\n";

foreach ($documents as $file => $title) {
    $inputPath = __DIR__ . '/' . $file;
    $outputPath = $outputDir . $title . '.pdf';
    
    if (!file_exists($inputPath)) {
        echo "⚠️  Warning: File $file not found, skipping...\n";
        continue;
    }
    
    try {
        echo "📄 Creating PDF: $file -> $title.pdf\n";
        
        // Read markdown content
        $content = file_get_contents($inputPath);
        
        // Create simple PDF
        $pdfContent = createSimplePDF($title, $content);
        
        // Save PDF file
        file_put_contents($outputPath, $pdfContent);
        
        $fileSize = filesize($outputPath);
        echo "✅ Success: $title.pdf created (Size: " . number_format($fileSize / 1024, 2) . " KB)\n";
        
    } catch (Exception $e) {
        echo "❌ Error creating PDF for $file: " . $e->getMessage() . "\n";
    }
}

echo "\n🎉 Basic PDF creation complete!\n";
echo "📁 PDF files saved in: $outputDir\n";

// List generated files
echo "\n📋 Generated PDF files:\n";
$pdfFiles = glob($outputDir . '*.pdf');
foreach ($pdfFiles as $pdfFile) {
    $fileName = basename($pdfFile);
    $fileSize = filesize($pdfFile);
    echo "  📄 $fileName (" . number_format($fileSize / 1024, 2) . " KB)\n";
}

echo "\n💡 Note: These are basic PDF files. For better quality, use the HTML files:\n";
echo "   1. Open HTML files in browser\n";
echo "   2. Use Ctrl+P to save as PDF\n";
echo "   3. This will create higher quality PDFs\n";

/**
 * Create a simple PDF using basic PDF format
 */
function createSimplePDF($title, $content) {
    // Convert markdown to plain text for PDF
    $textContent = markdownToPlainText($content);
    
    // Basic PDF header
    $pdf = "%PDF-1.4\n";
    $objCount = 0;
    $objects = [];
    
    // Catalog object
    $objCount++;
    $catalogId = $objCount;
    $objects[$catalogId] = "<< /Type /Catalog /Pages $objCount 0 R >>\n";
    
    // Pages object
    $objCount++;
    $pagesId = $objCount;
    $objects[$pagesId] = "<< /Type /Pages /Kids [$objCount 0 R] /Count 1 >>\n";
    
    // Page object
    $objCount++;
    $pageId = $objCount;
    $pageWidth = 612; // 8.5 inches * 72 points
    $pageHeight = 792; // 11 inches * 72 points
    $objects[$pageId] = "<< /Type /Page /Parent $pagesId 0 R /MediaBox [0 0 $pageWidth $pageHeight] /Contents $objCount 0 R /Resources << /Font << /F1 $objCount 0 R >> >> >>\n";
    
    // Content stream
    $objCount++;
    $contentId = $objCount;
    $contentStream = createContentStream($title, $textContent, $pageWidth, $pageHeight);
    $objects[$contentId] = "<< /Length " . strlen($contentStream) . " >>\nstream\n" . $contentStream . "\nendstream\n";
    
    // Font object (Helvetica)
    $objCount++;
    $fontId = $objCount;
    $objects[$fontId] = "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\n";
    
    // Build PDF
    $xref = "xref\n0 " . ($objCount + 1) . "\n0000000000 65535 f \n";
    
    $offset = strlen($pdf);
    foreach ($objects as $id => $object) {
        $xref .= sprintf("%010d 00000 n \n", $offset);
        $pdf .= $id . " 0 obj\n" . $object . "endobj\n";
        $offset += strlen($id . " 0 obj\n" . $object . "endobj\n");
    }
    
    // Trailer
    $pdf .= "trailer\n<< /Size " . ($objCount + 1) . " /Root $catalogId 0 R >>\nstartxref\n" . $offset . "\n%%EOF\n";
    
    return $pdf;
}

/**
 * Create content stream for PDF page
 */
function createContentStream($title, $content, $pageWidth, $pageHeight) {
    $stream = "BT\n";
    
    // Set font
    $stream .= "/F1 12 Tf\n";
    
    // Title
    $yPos = $pageHeight - 50;
    $stream .= "72 $yPos Td\n";
    $stream .= "(" . escapePdfString($title) . ") Tj\n";
    
    // Content (simplified - just basic text)
    $stream .= "/F1 10 Tf\n";
    $yPos -= 30;
    $lines = explode("\n", wordwrap($content, 80));
    
    foreach ($lines as $line) {
        if ($yPos < 50) break; // Stop if we run out of space
        
        $stream .= "72 $yPos Td\n";
        $stream .= "(" . escapePdfString(trim($line)) . ") Tj\n";
        $stream .= "0 -12 Td\n"; // Move to next line
        $yPos -= 12;
    }
    
    $stream .= "ET\n";
    
    return $stream;
}

/**
 * Escape strings for PDF
 */
function escapePdfString($string) {
    $string = str_replace('\\', '\\\\', $string);
    $string = str_replace('(', '\\(', $string);
    $string = str_replace(')', '\\)', $string);
    $string = str_replace("\r", '', $string);
    return $string;
}

/**
 * Convert markdown to plain text
 */
function markdownToPlainText($markdown) {
    // Remove markdown formatting
    $text = $markdown;
    
    // Headers
    $text = preg_replace('/^#+\s*(.*)$/m', '$1', $text);
    
    // Bold and italic
    $text = preg_replace('/\*\*(.*?)\*\*/', '$1', $text);
    $text = preg_replace('/\*(.*?)\*/', '$1', $text);
    
    // Code blocks
    $text = preg_replace('/```(.*?)```/s', '$1', $text);
    $text = preg_replace('/`(.*?)`/', '$1', $text);
    
    // Links
    $text = preg_replace('/\[(.*?)\]\(.*?\)/', '$1', $text);
    
    // Tables (remove table formatting)
    $text = preg_replace('/\|.*?\|/', '', $text);
    
    // Lists
    $text = preg_replace('/^[-*+]\s*(.*)$/m', '• $1', $text);
    $text = preg_replace('/^\d+\.\s*(.*)$/m', '• $1', $text);
    
    // Clean up extra whitespace
    $text = preg_replace('/\n\s*\n\s*\n/', "\n\n", $text);
    $text = trim($text);
    
    return $text;
}
?>
