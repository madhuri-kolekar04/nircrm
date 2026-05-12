<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $count = DB::table('call_recordings')->count();
    echo "Total recordings in database: " . $count . "\n";
    
    if ($count > 0) {
        $recordings = DB::table('call_recordings')->get();
        echo "\nRecent recordings:\n";
        foreach ($recordings->take(5) as $recording) {
            echo "- ID: {$recording->id}, Phone: {$recording->customer_phone}, File: {$recording->file_name}, Created: {$recording->created_at}\n";
        }
    }
    
    // Check if recordings directory exists and is writable
    $recordingsPath = public_path('recordings');
    echo "\nRecordings directory: " . $recordingsPath . "\n";
    echo "Directory exists: " . (file_exists($recordingsPath) ? "Yes" : "No") . "\n";
    echo "Directory writable: " . (is_writable($recordingsPath) ? "Yes" : "No") . "\n";
    
    // Check files in directory
    if (file_exists($recordingsPath)) {
        $files = glob($recordingsPath . '/*');
        echo "Files in directory: " . count($files) . "\n";
        if (!empty($files)) {
            echo "Files:\n";
            foreach ($files as $file) {
                echo "- " . basename($file) . " (" . filesize($file) . " bytes)\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
