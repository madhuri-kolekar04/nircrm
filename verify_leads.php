<?php
require_once 'c:\xampp\htdocs\nircrm (1)\vendor\autoload.php';

use App\Models\Lead;

echo "=== VERIFICATION: Checking updated leads in database ===\n";

// Check Prasanna Singankulli
$prasanna = Lead::where('name', 'Prasanna Singankulli')->first();
if ($prasanna) {
    echo "Prasanna Singankulli (ID: {$prasanna->id}):\n";
    echo "  Work Status: " . ($prasanna->work_status ?? 'NULL') . "\n";
    echo "  Work Type: " . ($prasanna->work_type ?? 'NULL') . "\n";
    echo "  Current Service: " . ($prasanna->current_service ?? 'NULL') . "\n";
    echo "  Date of Completion: " . ($prasanna->date_of_completion ?? 'NULL') . "\n";
    echo "---\n";
}

// Check Sagar Dhongade  
$sagar = Lead::where('name', 'Sagar Dhongade')->first();
if ($sagar) {
    echo "Sagar Dhongade (ID: {$sagar->id}):\n";
    echo "  Work Status: " . ($sagar->work_status ?? 'NULL') . "\n";
    echo "  Work Type: " . ($sagar->work_type ?? 'NULL') . "\n";
    echo "  Current Service: " . ($sagar->current_service ?? 'NULL') . "\n";
    echo "  Date of Completion: " . ($sagar->date_of_completion ?? 'NULL') . "\n";
    echo "---\n";
}

// Check Dhawal Rajan Salvi
$dhawal = Lead::where('name', 'Dhawal Rajan Salvi')->first();
if ($dhawal) {
    echo "Dhawal Rajan Salvi (ID: {$dhawal->id}):\n";
    echo "  Work Status: " . ($dhawal->work_status ?? 'NULL') . "\n";
    echo "  Work Type: " . ($dhawal->work_type ?? 'NULL') . "\n";
    echo "  Current Service: " . ($dhawal->current_service ?? 'NULL') . "\n";
    echo "  Date of Completion: " . ($dhawal->date_of_completion ?? 'NULL') . "\n";
    echo "---\n";
}

// Check Mayur patil (should have no data)
$mayur = Lead::where('name', 'Mayur patil')->first();
if ($mayur) {
    echo "Mayur patil (ID: {$mayur->id}):\n";
    echo "  Work Status: " . ($mayur->work_status ?? 'NULL') . "\n";
    echo "  Work Type: " . ($mayur->work_type ?? 'NULL') . "\n";
    echo "  Current Service: " . ($mayur->current_service ?? 'NULL') . "\n";
    echo "  Date of Completion: " . ($mayur->date_of_completion ?? 'NULL') . "\n";
    echo "---\n";
}

echo "=== VERIFICATION COMPLETE ===\n";
