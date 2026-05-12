<?php
/**
 * Simple PDF Generator for NIRCRM Documentation
 * 
 * This script creates HTML versions of the documentation that can be printed to PDF
 * from the browser without requiring external libraries
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

echo "Creating HTML files for PDF generation...\n";
echo "Output directory: $outputDir\n\n";

foreach ($documents as $file => $title) {
    $inputPath = __DIR__ . '/' . $file;
    $outputPath = $outputDir . $title . '.html';
    
    if (!file_exists($inputPath)) {
        echo "⚠️  Warning: File $file not found, skipping...\n";
        continue;
    }
    
    try {
        echo "📄 Processing: $file -> $title.html\n";
        
        // Read markdown content
        $content = file_get_contents($inputPath);
        
        // Convert markdown to HTML
        $html = markdownToHtml($content);
        
        // Create complete HTML document with print-friendly styling
        $fullHtml = createPrintableHtml($title, $html);
        
        // Save HTML file
        file_put_contents($outputPath, $fullHtml);
        
        $fileSize = filesize($outputPath);
        echo "✅ Success: $title.html created (Size: " . number_format($fileSize / 1024, 2) . " KB)\n";
        echo "   💡 Open this file in browser and use Ctrl+P to save as PDF\n";
        
    } catch (Exception $e) {
        echo "❌ Error generating HTML for $file: " . $e->getMessage() . "\n";
    }
}

echo "\n🎉 HTML files generation complete!\n";
echo "📁 Files saved in: $outputDir\n";
echo "\n📋 Generated HTML files:\n";
$htmlFiles = glob($outputDir . '*.html');
foreach ($htmlFiles as $htmlFile) {
    $fileName = basename($htmlFile);
    $fileSize = filesize($htmlFile);
    echo "  📄 $fileName (" . number_format($fileSize / 1024, 2) . " KB)\n";
}

echo "\n💡 How to create PDFs:\n";
echo "   1. Open any HTML file in your web browser\n";
echo "   2. Use Ctrl+P (or Cmd+P on Mac) to open print dialog\n";
echo "   3. Select 'Save as PDF' as destination\n";
echo "   4. Adjust settings if needed (margins, paper size)\n";
echo "   5. Click 'Save' to create PDF\n";

/**
 * Create printable HTML document
 */
function createPrintableHtml($title, $content) {
    return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIRCRM - ' . $title . '</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");
        
        * {
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        
        body {
            line-height: 1.6;
            color: #111B21;
            font-size: 14px;
            max-width: 100%;
            margin: 0;
            padding: 20px;
            background: white;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
                font-size: 12px;
            }
            
            .no-print {
                display: none !important;
            }
            
            h1 {
                page-break-before: auto;
                page-break-after: avoid;
            }
            
            h2, h3, h4 {
                page-break-after: avoid;
            }
            
            pre, blockquote {
                page-break-inside: avoid;
            }
            
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #25D366;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #25D366;
            font-size: 32px;
            margin: 0;
        }
        
        .header p {
            color: #667781;
            margin: 5px 0 0 0;
            font-size: 16px;
        }
        
        h1 { 
            color: #25D366; 
            border-bottom: 2px solid #25D366; 
            padding-bottom: 10px; 
            font-size: 28px;
            margin-top: 30px;
            page-break-before: auto;
        }
        
        h2 { 
            color: #075E54; 
            border-bottom: 1px solid #075E54; 
            padding-bottom: 5px; 
            font-size: 22px;
            margin-top: 25px;
        }
        
        h3 { 
            color: #111B21; 
            font-size: 18px;
            margin-top: 20px;
        }
        
        h4 { 
            color: #667781; 
            font-size: 16px;
            margin-top: 15px;
        }
        
        h5, h6 { 
            color: #667781; 
            font-size: 14px;
            margin-top: 15px;
        }
        
        code { 
            background-color: #f4f4f4; 
            padding: 2px 4px; 
            border-radius: 3px; 
            font-family: "Courier New", monospace; 
            font-size: 13px;
        }
        
        pre { 
            background-color: #f4f4f4; 
            padding: 15px; 
            border-radius: 5px; 
            overflow-x: auto; 
            font-size: 12px;
            line-height: 1.4;
            border: 1px solid #ddd;
        }
        
        blockquote { 
            border-left: 4px solid #25D366; 
            padding-left: 20px; 
            margin: 20px 0; 
            font-style: italic; 
            color: #667781;
            background-color: #f9f9f9;
            padding: 15px 20px;
            border-radius: 0 5px 5px 0;
        }
        
        table { 
            border-collapse: collapse; 
            width: 100%; 
            margin: 20px 0; 
            font-size: 12px;
        }
        
        th, td { 
            border: 1px solid #ddd; 
            padding: 12px; 
            text-align: left; 
            vertical-align: top;
        }
        
        th { 
            background-color: #25D366; 
            color: white; 
            font-weight: bold;
        }
        
        ul, ol { 
            margin: 15px 0; 
            padding-left: 30px; 
        }
        
        li { 
            margin: 5px 0; 
        }
        
        a { 
            color: #25D366; 
            text-decoration: none; 
        }
        
        a:hover { 
            text-decoration: underline; 
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #667781;
            font-size: 12px;
        }
        
        .no-print {
            background: #f0f8ff;
            border: 1px solid #25D366;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .instructions {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="no-print">
        <div class="instructions">
            <h3>📋 PDF Generation Instructions</h3>
            <p><strong>To create a PDF from this HTML file:</strong></p>
            <ol>
                <li>Use Ctrl+P (or Cmd+P on Mac) to open the print dialog</li>
                <li>Select "Save as PDF" as the destination</li>
                <li>Adjust settings if needed (margins: 0.5cm, paper size: A4)</li>
                <li>Click "Save" to create your PDF</li>
            </ol>
            <p><em>This section will not appear in the printed PDF.</em></p>
        </div>
    </div>
    
    <div class="header">
        <h1>NIRCRM Documentation</h1>
        <p>' . $title . '</p>
        <p><small>Generated on ' . date('Y-m-d H:i:s') . '</small></p>
    </div>
    
    <div class="content">
        ' . $content . '
    </div>
    
    <div class="footer">
        <p>NIRCRM - Niranjan Enterprises Customer Relationship Management</p>
        <p>Documentation Version 1.0.0 | February 2026</p>
        <p>Generated from markdown documentation</p>
    </div>
</body>
</html>';
}

/**
 * Enhanced Markdown to HTML converter
 */
function markdownToHtml($markdown) {
    // Headers
    $markdown = preg_replace('/^# (.*?)$/m', '<h1>$1</h1>', $markdown);
    $markdown = preg_replace('/^## (.*?)$/m', '<h2>$1</h2>', $markdown);
    $markdown = preg_replace('/^### (.*?)$/m', '<h3>$1</h3>', $markdown);
    $markdown = preg_replace('/^#### (.*?)$/m', '<h4>$1</h4>', $markdown);
    $markdown = preg_replace('/^##### (.*?)$/m', '<h5>$1</h5>', $markdown);
    $markdown = preg_replace('/^###### (.*?)$/m', '<h6>$1</h6>', $markdown);
    
    // Bold and italic
    $markdown = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $markdown);
    $markdown = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $markdown);
    
    // Code blocks
    $markdown = preg_replace('/```(.*?)```/s', '<pre><code>$1</code></pre>', $markdown);
    $markdown = preg_replace('/`(.*?)`/', '<code>$1</code>', $markdown);
    
    // Links
    $markdown = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2" target="_blank">$1</a>', $markdown);
    
    // Tables (basic support)
    $lines = explode("\n", $markdown);
    $inTable = false;
    $result = [];
    
    foreach ($lines as $line) {
        if (strpos($line, '|') !== false && trim($line) !== '') {
            if (!$inTable) {
                $result[] = '<table>';
                $inTable = true;
            }
            $cells = explode('|', trim($line));
            $cells = array_filter($cells, function($cell) { return trim($cell) !== ''; });
            $tag = !empty($result) && end($result) === '<table>' ? 'th' : 'td';
            $rowHtml = '<tr>';
            foreach ($cells as $cell) {
                $rowHtml .= "<$tag>" . trim($cell) . "</$tag>";
            }
            $rowHtml .= '</tr>';
            $result[] = $rowHtml;
        } else {
            if ($inTable) {
                $result[] = '</table>';
                $inTable = false;
            }
            $result[] = $line;
        }
    }
    
    if ($inTable) {
        $result[] = '</table>';
    }
    
    $markdown = implode("\n", $result);
    
    // Lists (basic)
    $markdown = preg_replace('/^- (.*?)$/m', '<li>$1</li>', $markdown);
    $markdown = preg_replace('/(\n<li>.*<\/li>\n)+/', '<ul>$0</ul>', $markdown);
    $markdown = preg_replace('/^\d+\. (.*?)$/m', '<li>$1</li>', $markdown);
    
    // Line breaks and paragraphs
    $markdown = preg_replace('/\n\n/', '</p><p>', $markdown);
    $markdown = '<p>' . $markdown . '</p>';
    
    // Clean up paragraph tags around headers and lists
    $markdown = preg_replace('/<p><h([1-6])>/', '<h$1>', $markdown);
    $markdown = preg_replace('/<\/h([1-6])><\/p>/', '</h$1>', $markdown);
    $markdown = preg_replace('/<p><pre>/', '<pre>', $markdown);
    $markdown = preg_replace('/<\/pre><\/p>/', '</pre>', $markdown);
    $markdown = preg_replace('/<p><ul>/', '<ul>', $markdown);
    $markdown = preg_replace('/<\/ul><\/p>/', '</ul>', $markdown);
    $markdown = preg_replace('/<p><ol>/', '<ol>', $markdown);
    $markdown = preg_replace('/<\/ol><\/p>/', '</ol>', $markdown);
    $markdown = preg_replace('/<p><table>/', '<table>', $markdown);
    $markdown = preg_replace('/<\/table><\/p>/', '</table>', $markdown);
    
    // Clean up empty paragraphs
    $markdown = preg_replace('/<p><\/p>/', '', $markdown);
    $markdown = preg_replace('/<p>\s*<\/p>/', '', $markdown);
    
    return $markdown;
}
?>
