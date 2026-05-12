<?php
require_once 'c:\xampp\htdocs\nircrm (1)\bootstrap\app.php';

use App\Models\Lead;

echo "Starting targeted update of specific leads with work-related data...\n";

// List of names provided by user
$targetNames = [
    'Awanindra Kumar',
    'Rajendra Korde', 
    'Sarika sirsat',
    'Prasanna Singankulli',
    'Sachin Magar',
    'Pratik Dhamale',
    'Meena Lokhande',
    'Arun Patil',
    'Poonam Dhanwate',
    'Anil Maurya',
    'Rajesh Ahire',
    'Jyoti',
    'Sonali Agate',
    'Pralhad Jadhav',
    'Arun Kumar',
    'Pranav Kerkar',
    'MILIND PALVEKAR',
    'Shalmali Khadke',
    'Swapneel Pagare',
    'Indraneel Madkholkar',
    'Raj Dupare',
    'Dr. Yogesh Jadhav',
    'Gotan Jain',
    'Sanadiip Shrawastie',
    'Pranav Palse',
    'Sagar Dhongade',
    'Bhushan Puranik',
    'Nielesh Paste',
    'Vanita',
    'Anway Chavan',
    'Swapnil Shirgave',
    'Yogesh Kamthe',
    'Vinod Bagadie',
    'Bhavna Patil',
    'Vishal Vagare',
    'Salome Landge',
    'Dhawal Rajan Salvi',
    'Supriya Kothadia',
    'Harshad Koli',
    'Chetan Bhoir',
    'Pratik Jadhav',
    'Jaydeep Bagul',
    'Rushikesh Kale',
    'Sharayu Sangle',
    'Manoj Patki',
    'Herambh Pathak',
    'Ajay Divekar',
    'Tripti Kemkha',
    'Prashant Gupta'
];

try {
    $excelFile = 'C:\xampp\htdocs\nircrm (1)\leads_template_data.xlsx';
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFile);
    $worksheet = $spreadsheet->getActiveSheet();
    $highestRow = $worksheet->getHighestRow();
    
    echo "Found {$highestRow} rows in Excel file\n";
    echo "Processing " . count($targetNames) . " target leads\n";
    
    // Create a mapping of Excel data by name
    $excelData = [];
    
    // Read all Excel data first
    for ($row = 2; $row <= $highestRow; $row++) {
        $name = $worksheet->getCell('A' . $row)->getValue();
        
        if (empty($name)) {
            continue;
        }
        
        // Get the work-related data from columns E, F, G, H
        $excelData[$name] = [
            'work_status' => $worksheet->getCell('E' . $row)->getValue() ?? null,
            'work_type' => $worksheet->getCell('F' . $row)->getValue() ?? null,
            'current_service' => $worksheet->getCell('G' . $row)->getValue() ?? null,
            'date_of_completion' => $worksheet->getCell('H' . $row)->getValue() ?? null,
        ];
    }
    
    $updatedCount = 0;
    $notFoundCount = 0;
    $noDataCount = 0;
    
    // Process each target name
    foreach ($targetNames as $targetName) {
        echo "Processing: {$targetName}\n";
        
        // Find the lead by name
        $lead = Lead::where('name', $targetName)->first();
        
        if ($lead) {
            echo "  - Found lead: {$lead->name} (ID: {$lead->id})\n";
            
            // Check if we have Excel data for this name
            if (isset($excelData[$targetName])) {
                $data = $excelData[$targetName];
                
                $updateData = [
                    'work_status' => $data['work_status'],
                    'work_type' => $data['work_type'],
                    'current_service' => $data['current_service'],
                    'date_of_completion' => $data['date_of_completion'] ? \Carbon\Carbon::parse($data['date_of_completion'])->format('Y-m-d') : null,
                ];
                
                // Remove null values to keep existing data intact
                $updateData = array_filter($updateData, function($value) {
                    return $value !== null && $value !== '';
                });
                
                if (!empty($updateData)) {
                    $lead->update($updateData);
                    $updatedCount++;
                    echo "  - Updated with work data:\n";
                    echo "    - Work Status: {$data['work_status']}\n";
                    echo "    - Work Type: {$data['work_type']}\n";
                    echo "    - Current Service: {$data['current_service']}\n";
                    echo "    - Date of Completion: {$data['date_of_completion']}\n";
                } else {
                    echo "  - No work data found in Excel for this lead\n";
                    $noDataCount++;
                }
            } else {
                echo "  - No Excel data found for this lead\n";
                $noDataCount++;
            }
        } else {
            echo "  - Lead not found in database\n";
            $notFoundCount++;
        }
        
        echo "---\n";
    }
    
    echo "\n=== UPDATE SUMMARY ===\n";
    echo "Total target leads: " . count($targetNames) . "\n";
    echo "Leads updated: {$updatedCount}\n";
    echo "Leads not found: {$notFoundCount}\n";
    echo "Leads with no Excel data: {$noDataCount}\n";
    
    if ($updatedCount > 0) {
        echo "\n" . str_repeat("=", 50) . "\n";
        echo "  SUCCESSFULLY UPDATED {$updatedCount} LEADS!\n";
        echo str_repeat("=", 50) . "\n";
        echo "\nThe following leads have been updated with work-related data:\n";
        
        foreach ($targetNames as $targetName) {
            $lead = Lead::where('name', $targetName)->first();
            if ($lead && isset($excelData[$targetName])) {
                $data = $excelData[$targetName];
                if (!empty($data['work_status']) || !empty($data['work_type']) || !empty($data['current_service'])) {
                    echo "  - {$targetName}: Work Status = {$data['work_status']}, Work Type = {$data['work_type']}, Service = {$data['current_service']}\n";
                }
            }
        }
    } else {
        echo "\nNo leads were updated. Please check:\n";
        echo "1. Excel file contains data for these names\n";
        echo "2. Names match exactly in the database\n";
        echo "3. Excel file path is correct\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
