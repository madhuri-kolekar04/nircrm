<?php
require_once 'c:\xampp\htdocs\nircrm (1)\vendor\autoload.php';

// Bootstrap Laravel
$app = require_once 'c:\xampp\htdocs\nircrm (1)\bootstrap\app.php';

echo "=== VERIFYING DATES IN DATABASE ===\n";

// Check specific leads
$targetNames = ['Rajendra Korde', 'Prasanna Singankulli', 'Sachin Magar', 'Chetan Bhoir'];

foreach ($targetNames as $targetName) {
    $lead = \App\Models\Lead::where('name', $targetName)->first();
    if ($lead) {
        echo "\n--- {$targetName} (ID: {$lead->id}) ---\n";
        echo "Work Status: " . ($lead->work_status ?? 'NULL') . "\n";
        echo "Work Type: " . ($lead->work_type ?? 'NULL') . "\n";
        echo "Current Service: " . ($lead->current_service ?? 'NULL') . "\n";
        echo "Date of Completion: " . ($lead->date_of_completion ?? 'NULL') . "\n";
        echo "Date Type: " . gettype($lead->date_of_completion) . "\n";
    } else {
        echo "\n--- {$targetName} ---\n";
        echo "Lead not found in database\n";
    }
}

echo "\n=== VERIFICATION COMPLETE ===\n";
