<?php

/**
 * Create Google Credentials File Helper
 * 
 * This script helps create the google-credentials.json file
 * Run this script and then copy your JSON content
 */

echo "=== Google Credentials File Creator ===\n\n";

$targetPath = __DIR__ . '/storage/app/google-credentials.json';
$directory = dirname($targetPath);

echo "Target file: $targetPath\n";
echo "Directory: $directory\n\n";

// Check if directory exists
if (!is_dir($directory)) {
    echo "Creating directory: $directory\n";
    mkdir($directory, 0755, true);
}

// Create empty JSON file with template
$template = [
    'type' => 'service_account',
    'project_id' => 'your-project-id-here',
    'private_key_id' => 'your-private-key-id-here',
    'private_key' => "-----BEGIN PRIVATE KEY-----\nYOUR_PRIVATE_KEY_HERE\n-----END PRIVATE KEY-----\n",
    'client_email' => 'your-service-account@your-project.iam.gserviceaccount.com',
    'client_id' => 'your-client-id-here',
    'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
    'token_uri' => 'https://oauth2.googleapis.com/token',
    'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
    'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/your-service-account%40your-project.iam.gserviceaccount.com'
];

$jsonContent = json_encode($template, JSON_PRETTY_PRINT);

if (file_put_contents($targetPath, $jsonContent)) {
    echo "✅ SUCCESS: Template file created at: $targetPath\n\n";
    echo "Next steps:\n";
    echo "1. Go to: https://console.cloud.google.com/\n";
    echo "2. Create Service Account\n";
    echo "3. Download JSON credentials\n";
    echo "4. Copy the content from your downloaded JSON\n";
    echo "5. Replace the template content in: $targetPath\n";
    echo "6. Save the file\n\n";
    
    echo "Current template content:\n";
    echo $jsonContent . "\n\n";
    
    echo "📝 Edit the file now? (y/n): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    fclose($handle);
    
    if (trim(strtolower($line)) === 'y') {
        // Try to open with notepad
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            system("notepad \"$targetPath\"");
        } else {
            system("nano \"$targetPath\"");
        }
    }
    
} else {
    echo "❌ ERROR: Could not create file at: $targetPath\n";
    echo "Check directory permissions.\n";
}

echo "\n=== Helper Complete ===\n";
