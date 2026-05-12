<?php

use Illuminate\Support\Facades\DB;

echo "Updating leads with work-related data...\n";

try {
    // Update Sarika sirsat
    $sarikaUpdated = DB::table('leads')
        ->where('name', 'Sarika sirsat')
        ->update([
            'work_status' => 'Active',
            'work_type' => 'Web Development', 
            'current_service' => 'Website Design',
            'date_of_completion' => '2024-01-15'
        ]);
    
    echo "✓ Sarika sirsat updated: " . $sarikaUpdated . " rows affected\n";
    
    // Update John Doe
    $johnUpdated = DB::table('leads')
        ->where('name', 'John Doe')
        ->update([
            'work_status' => 'NO',
            'work_type' => 'Mobile App Development',
            'current_service' => 'E-commerce Platform',
            'date_of_completion' => '2024-02-20'
        ]);
    
    echo "✓ John Doe updated: " . $johnUpdated . " rows affected\n";
    
    // Update Jane Smith
    $janeUpdated = DB::table('leads')
        ->where('name', 'Jane Smith')
        ->update([
            'work_status' => 'Active',
            'work_type' => 'UI/UX Design',
            'current_service' => 'Frontend Development',
            'date_of_completion' => '2024-03-10'
        ]);
    
    echo "✓ Jane Smith updated: " . $janeUpdated . " rows affected\n";
    
    echo "\n=== UPDATE COMPLETE ===\n";
    echo "Total leads updated: 3\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
