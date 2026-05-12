<?php
require_once 'c:\xampp\htdocs\nircrm (1)\bootstrap\app.php';

$app = require_once 'c:\xampp\htdocs\nircrm (1)\bootstrap\app.php';

echo "=== VERIFICATION: Checking updated leads in database ===\n";

// Check Prasanna Singankulli
$prasanna = \App\Models\Lead::where('name', 'Prasanna Singankulli')->first();
if ($prasanna) {
    echo "Prasanna Singankulli (ID: {$prasanna->id}):\n";
    echo "  Work Status: " . ($prasanna->work_status ?? 'NULL') . "\n";
    echo "  Work Type: " . ($prasanna->work_type ?? 'NULL') . "\n";
    echo "  Current Service: " . ($prasanna->current_service ?? 'NULL') . "\n";
    echo "  Date of Completion: " . ($prasanna->date_of_completion ?? 'NULL') . "\n";
    echo "---\n";
}

// Check Mayur patil (should have no data)
$mayur = \App\Models\Lead::where('name', 'Mayur patil')->first();
if ($mayur) {
    echo "Mayur patil (ID: {$mayur->id}):\n";
    echo "  Work Status: " . ($mayur->work_status ?? 'NULL') . "\n";
    echo "  Work Type: " . ($mayur->work_type ?? 'NULL') . "\n";
    echo "  Current Service: " . ($mayur->current_service ?? 'NULL') . "\n";
    echo "  Date of Completion: " . ($mayur->date_of_completion ?? 'NULL') . "\n";
    echo "---\n";
}

echo "=== VERIFICATION COMPLETE ===\n";
