<?php
/**
 * NIRCRM Individual PDF Generator
 * 
 * This script generates individual PDF files for each markdown documentation file
 * Requires: mPDF library (composer require mpdf/mpdf)
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Mpdf\Mpdf;
use Mpdf\HTMLParserMode;

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

echo "Starting PDF generation...\n";
echo "Output directory: $outputDir\n\n";

foreach ($documents as $file => $title) {
    $inputPath = __DIR__ . '/' . $file;
    $outputPath = $outputDir . $title . '.pdf';
    
    if (!file_exists($inputPath)) {
        echo "⚠️  Warning: File $file not found, skipping...\n";
        continue;
    }
    
    try {
        echo "📄 Processing: $file -> $title.pdf\n";
        
        // Initialize mPDF for this document
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 20,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10,
        ]);

        // Set metadata
        $mpdf->SetTitle("NIRCRM - $title");
        $mpdf->SetAuthor('Niranjan Enterprises');
        $mpdf->SetSubject('CRM System Documentation');
        $mpdf->SetKeywords('CRM, NIRCRM, Documentation, Laravel');
        $mpdf->SetCreator('NIRCRM Documentation Generator');

        // Add document header
        $mpdf->SetHTMLHeader('<div style="text-align: right; border-bottom: 1px solid #25D366; padding-bottom: 5px;">
            <span style="font-size: 12px; color: #666;">' . $title . '</span>
        </div>');

        // Add footer
        $mpdf->SetHTMLFooter('<div style="text-align: center; border-top: 1px solid #ccc; padding-top: 5px;">
            <span style="font-size: 10px; color: #666;">NIRCRM Documentation - Page {PAGENO} of {nbpg}</span>
        </div>');

        // Read markdown content
        $content = file_get_contents($inputPath);
        
        // Convert markdown to HTML
        $html = markdownToHtml($content);
        
        // Add styling
        $styledHtml = '
        <style>
            body { 
                font-family: "Inter", Arial, sans-serif; 
                line-height: 1.6; 
                color: #111B21; 
                font-size: 14px;
            }
            h1 { 
                color: #25D366; 
                border-bottom: 2px solid #25D366; 
                padding-bottom: 10px; 
                font-size: 28px;
                margin-top: 30px;
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
            }
            blockquote { 
                border-left: 4px solid #25D366; 
                padding-left: 20px; 
                margin: 20px 0; 
                font-style: italic; 
                color: #667781;
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
            .toc {
                background-color: #f9f9f9;
                padding: 20px;
                border-radius: 5px;
                margin: 20px 0;
                border-left: 4px solid #25D366;
            }
            .toc h3 {
                margin-top: 0;
                color: #25D366;
            }
            .page-break {
                page-break-before: always;
            }
        </style>' . $html;
        
        // Write to PDF
        $mpdf->WriteHTML($styledHtml);
        
        // Save PDF
        $mpdf->Output($outputPath, 'F');
        
        $fileSize = filesize($outputPath);
        echo "✅ Success: $title.pdf created (Size: " . number_format($fileSize / 1024, 2) . " KB)\n";
        
    } catch (Exception $e) {
        echo "❌ Error generating PDF for $file: " . $e->getMessage() . "\n";
    }
}

echo "\n🎉 PDF generation complete!\n";
echo "📁 PDF files saved in: $outputDir\n";

// List generated files
echo "\n📋 Generated PDF files:\n";
$pdfFiles = glob($outputDir . '*.pdf');
foreach ($pdfFiles as $pdfFile) {
    $fileName = basename($pdfFile);
    $fileSize = filesize($pdfFile);
    echo "  📄 $fileName (" . number_format($fileSize / 1024, 2) . " KB)\n";
}

echo "\n💡 Note: This script requires mPDF library to be installed.\n";
echo "   Install with: composer require mpdf/mpdf\n";

/**
 * Enhanced Markdown to HTML converter
 */
function markdownToHtml($markdown) {
    // Remove any HTML tags first
    $markdown = strip_tags($markdown);
    
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
    $markdown = preg_replace('/\|(.+)\|/m', '<tr><td>$1</td></tr>', $markdown);
    $markdown = preg_replace('/<tr><td>(.+)<\/td><\/tr>\s*<tr><td>(.+)<\/td><\/tr>/', '<table><tr><th>$1</th></tr><tr><td>$2</td></tr></table>', $markdown);
    
    // Lists (basic)
    $lines = explode("\n", $markdown);
    $inList = false;
    $listType = '';
    $result = [];
    
    foreach ($lines as $line) {
        if (preg_match('/^- (.*)$/', $line, $matches)) {
            if (!$inList || $listType != 'ul') {
                if ($inList) $result[] = '</' . $listType . '>';
                $result[] = '<ul>';
                $inList = true;
                $listType = 'ul';
            }
            $result[] = '<li>' . $matches[1] . '</li>';
        } elseif (preg_match('/^\d+\. (.*)$/', $line, $matches)) {
            if (!$inList || $listType != 'ol') {
                if ($inList) $result[] = '</' . $listType . '>';
                $result[] = '<ol>';
                $inList = true;
                $listType = 'ol';
            }
            $result[] = '<li>' . $matches[1] . '</li>';
        } else {
            if ($inList) {
                $result[] = '</' . $listType . '>';
                $inList = false;
                $listType = '';
            }
            $result[] = $line;
        }
    }
    
    if ($inList) {
        $result[] = '</' . $listType . '>';
    }
    
    $markdown = implode("\n", $result);
    
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
