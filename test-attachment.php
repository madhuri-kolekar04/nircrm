<?php

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Mail;

// Create test data
$testUpdate = new stdClass();
$testUpdate->attachment = '1778135396_1778074637_slider menu first 6 pages.png';

$attachmentPath = storage_path('app/public/' . $testUpdate->attachment);

echo "Testing email attachment system...\n";
echo "Attachment exists: " . file_exists($attachmentPath) . "\n";
echo "Attachment path: " . $attachmentPath . "\n";

// Test sending email with attachment
try {
    Mail::raw("Test Email with Attachment

This is a test email with file attachment.

Attachment: " . basename($testUpdate->attachment) . "

File is available for download in project portal.", 
        function($message) {
            $message->to('test@example.com')
                    ->subject('Test Attachment Email')
                    ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), 'Niranjan Enterprises');
            
            // Attach file if exists
            if (file_exists($attachmentPath)) {
                $message->attach($attachmentPath, [
                    'as' => basename($testUpdate->attachment),
                    'mime' => mime_content_type($attachmentPath)
                ]);
                echo "File attached successfully!\n";
            } else {
                echo "File not found for attachment!\n";
            }
        });
    
    echo "Test completed successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
