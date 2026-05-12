<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

try {
    // Check if meeting_call_details table exists and has data
    $count = \App\Models\MeetingCallDetail::count();
    echo "Meeting Call Details Table:\n";
    echo "Total Records: " . $count . "\n\n";
    
    if ($count > 0) {
        echo "Recent Records:\n";
        $records = \App\Models\MeetingCallDetail::orderBy('created_at', 'desc')->limit(5)->get();
        
        foreach ($records as $record) {
            echo "ID: {$record->id}\n";
            echo "Lead: {$record->lead_full_name} ({$record->lead_email})\n";
            echo "Employee: {$record->called_by_employee_name}\n";
            echo "Rating: {$record->rating}\n";
            echo "Conclusion: " . substr($record->meeting_conclusion, 0, 50) . "...\n";
            echo "Created: {$record->created_at}\n";
            echo "------------------------\n";
        }
    } else {
        echo "No records found in meeting_call_details table.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
