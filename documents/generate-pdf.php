<?php
/**
 * NIRCRM Documentation PDF Generator
 * 
 * This script combines all markdown documentation files into a single PDF
 * Requires: mPDF library or similar PDF generation tool
 */

// Include mPDF library (install via composer: composer require mpdf/mpdf)
require_once __DIR__ . '/../vendor/autoload.php';

use Mpdf\Mpdf;
use Mpdf\HTMLParserMode;

// Configuration
$config = [
    'title' => 'NIRCRM - Complete Documentation',
    'author' => 'Niranjan Enterprises',
    'subject' => 'CRM System Documentation',
    'keywords' => 'CRM, NIRCRM, Documentation, Laravel',
    'creator' => 'NIRCRM Documentation Generator'
];

// Document files in order
$documents = [
    '00-Documentation-Index.md' => 'Documentation Index',
    '01-Technical-Overview.md' => 'Technical Overview',
    '02-Models-Database-Schema.md' => 'Models & Database Schema',
    '03-Controllers-API-Documentation.md' => 'Controllers & API Documentation',
    '04-UI-UX-Design-System.md' => 'UI/UX Design System',
    '05-User-Manual-Roles.md' => 'User Manual for Different Roles',
    '06-Installation-Deployment-Guide.md' => 'Installation & Deployment Guide'
];

// Initialize mPDF
try {
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
    $mpdf->SetTitle($config['title']);
    $mpdf->SetAuthor($config['author']);
    $mpdf->SetSubject($config['subject']);
    $mpdf->SetKeywords($config['keywords']);
    $mpdf->SetCreator($config['creator']);

    // Add cover page
    $mpdf->AddPage();
    $coverHtml = '
    <div style="text-align: center; margin-top: 100px;">
        <h1 style="font-size: 48px; color: #25D366; margin-bottom: 30px;">NIRCRM</h1>
        <h2 style="font-size: 32px; color: #075E54; margin-bottom: 20px;">Complete Documentation</h2>
        <p style="font-size: 18px; color: #667781; margin-bottom: 40px;">Niranjan Enterprises Customer Relationship Management</p>
        
        <div style="border-top: 2px solid #25D366; margin: 40px auto; width: 200px;"></div>
        
        <h3 style="font-size: 24px; color: #111B21; margin-top: 40px;">Documentation Contents</h3>
        <ul style="text-align: left; display: inline-block; font-size: 16px; line-height: 1.8;">
            <li>Technical Overview</li>
            <li>Models & Database Schema</li>
            <li>Controllers & API Documentation</li>
            <li>UI/UX Design System</li>
            <li>User Manual for Different Roles</li>
            <li>Installation & Deployment Guide</li>
        </ul>
        
        <p style="margin-top: 60px; font-size: 14px; color: #667781;">
            Version 1.0.0<br>
            February 2026<br>
            ' . date('Y') . ' Niranjan Enterprises
        </p>
    </div>';
    
    $mpdf->WriteHTML($coverHtml);

    // Add table of contents
    $mpdf->AddPage();
    $tocHtml = '
    <h1 style="color: #25D366; border-bottom: 2px solid #25D366; padding-bottom: 10px;">Table of Contents</h1>
    <div style="margin-top: 30px;">';
    
    foreach ($documents as $file => $title) {
        $tocHtml .= '<p style="font-size: 14px; margin: 8px 0;"><strong>' . $title . '</strong></p>';
    }
    
    $tocHtml .= '</div>';
    $mpdf->WriteHTML($tocHtml);

    // Process each document
    foreach ($documents as $file => $title) {
        $filePath = __DIR__ . '/' . $file;
        
        if (!file_exists($filePath)) {
            echo "Warning: File $file not found, skipping...\n";
            continue;
        }
        
        echo "Processing: $file\n";
        
        // Add new page for each document
        $mpdf->AddPage();
        
        // Add document header
        $mpdf->SetHTMLHeader('<div style="text-align: right; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
            <span style="font-size: 12px; color: #666;">' . $title . '</span>
        </div>');
        
        // Read markdown content
        $content = file_get_contents($filePath);
        
        // Convert markdown to HTML (basic conversion)
        $html = markdownToHtml($content);
        
        // Add some styling
        $styledHtml = '
        <style>
            body { font-family: "Inter", Arial, sans-serif; line-height: 1.6; color: #111B21; }
            h1 { color: #25D366; border-bottom: 2px solid #25D366; padding-bottom: 10px; }
            h2 { color: #075E54; border-bottom: 1px solid #075E54; padding-bottom: 5px; }
            h3 { color: #111B21; }
            h4 { color: #667781; }
            code { background-color: #f4f4f4; padding: 2px 4px; border-radius: 3px; font-family: "Courier New", monospace; }
            pre { background-color: #f4f4f4; padding: 15px; border-radius: 5px; overflow-x: auto; }
            blockquote { border-left: 4px solid #25D366; padding-left: 20px; margin: 20px 0; font-style: italic; }
            table { border-collapse: collapse; width: 100%; margin: 20px 0; }
            th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
            th { background-color: #25D366; color: white; }
            ul, ol { margin: 15px 0; padding-left: 30px; }
            li { margin: 5px 0; }
            a { color: #25D366; text-decoration: none; }
            a:hover { text-decoration: underline; }
        </style>' . $html;
        
        // Write to PDF
        $mpdf->WriteHTML($styledHtml);
    }

    // Add footer
    $mpdf->SetHTMLFooter('<div style="text-align: center; border-top: 1px solid #ccc; padding-top: 5px;">
        <span style="font-size: 10px; color: #666;">NIRCRM Documentation - Page {PAGENO} of {nbpg}</span>
    </div>');

    // Save PDF
    $outputFile = __DIR__ . '/NIRCRM-Complete-Documentation.pdf';
    $mpdf->Output($outputFile, 'F');
    
    echo "PDF generated successfully: $outputFile\n";
    echo "File size: " . filesize($outputFile) . " bytes\n";

} catch (Exception $e) {
    echo "Error generating PDF: " . $e->getMessage() . "\n";
    echo "Please ensure mPDF library is installed: composer require mpdf/mpdf\n";
}

/**
 * Basic Markdown to HTML converter
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
    $markdown = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $markdown);
    
    // Lists (basic)
    $markdown = preg_replace('/^- (.*?)$/m', '<li>$1</li>', $markdown);
    $markdown = preg_replace('/(\n<li>.*<\/li>\n)+/', '<ul>$0</ul>', $markdown);
    
    // Line breaks
    $markdown = preg_replace('/\n\n/', '</p><p>', $markdown);
    $markdown = '<p>' . $markdown . '</p>';
    
    // Clean up
    $markdown = str_replace('<p></p>', '', $markdown);
    $markdown = str_replace('<p><h', '<h', $markdown);
    $markdown = str_replace('</h1></p>', '</h1>', $markdown);
    $markdown = str_replace('</h2></p>', '</h2>', $markdown);
    $markdown = str_replace('</h3></p>', '</h3>', $markdown);
    $markdown = str_replace('</h4></p>', '</h4>', $markdown);
    $markdown = str_replace('</h5></p>', '</h5>', $markdown);
    $markdown = str_replace('</h6></p>', '</h6>', $markdown);
    $markdown = str_replace('<p><pre>', '<pre>', $markdown);
    $markdown = str_replace('</pre></p>', '</pre>', $markdown);
    $markdown = str_replace('<p><ul>', '<ul>', $markdown);
    $markdown = str_replace('</ul></p>', '</ul>', $markdown);
    
    return $markdown;
}

echo "\nPDF Generation Complete!\n";
echo "Note: This script requires mPDF library to be installed.\n";
echo "Install with: composer require mpdf/mpdf\n";
?>
