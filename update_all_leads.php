<?php
require_once 'c:\xampp\htdocs\nircrm (1)\vendor\autoload.php';

$app = require_once 'c:\xampp\htdocs\nircrm (1)\bootstrap\app.php';

use App\Models\Lead;

echo "Starting bulk update of all leads with work-related data...\n";

try {
    $excelFile = 'C:\xampp\htdocs\nircrm (1)\sample_work_data.xlsx';
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFile);
    $worksheet = $spreadsheet->getActiveSheet();
    $highestRow = $worksheet->getHighestRow();
    
    echo "Found {$highestRow} rows in Excel file\n";
    
    // Get all leads from database
    $allLeads = Lead::all();
    
    echo "Processing " . count($allLeads) . " leads from database\n";
    
    $updatedCount = 0;
    $skippedCount = 0;
    $notFoundCount = 0;
    
    // Process each row starting from row 2 (assuming row 1 is headers)
    for ($row = 2; $row <= $highestRow; $row++) {
        $name = $worksheet->getCell('A' . $row)->getValue();
        
        if (empty($name)) {
            echo "Skipping empty row {$row}\n";
            $skippedCount++;
            continue;
        }
        
        echo "Processing: {$name}\n";
        
        // Get the work-related data from columns E, F, G, H
        $workStatus = $worksheet->getCell('E' . $row)->getValue() ?? null;
        $workType = $worksheet->getCell('F' . $row)->getValue() ?? null;
        $currentService = $worksheet->getCell('G' . $row)->getValue() ?? null;
        $dateOfCompletion = $worksheet->getCell('H' . $row)->getValue() ?? null;
        
        // Find the lead by name
        $lead = $allLeads->where('name', $name)->first();
        
        if ($lead) {
            echo "✓ Found lead: {$lead->name} (ID: {$lead->id})\n";
            
            // Update the lead with work-related data
            $updateData = [
                'work_status' => $workStatus,
                'work_type' => $workType,
                'current_service' => $currentService,
                'date_of_completion' => $dateOfCompletion ? \Carbon\Carbon::parse($dateOfCompletion)->format('Y-m-d') : null,
            ];
            
            // Remove null values to keep existing data intact
            $updateData = array_filter($updateData, function($value) {
                return $value !== null && $value !== '';
            });
            
            if (!empty($updateData)) {
                $lead->update($updateData);
                $updatedCount++;
                echo "  ✓ Updated with work data:\n";
                echo "    - Work Status: {$workStatus}\n";
                echo "    - Work Type: {$workType}\n";
                echo "    - Current Service: {$currentService}\n";
                echo "    - Date of Completion: {$dateOfCompletion}\n";
            } else {
                echo "  - No work data to update\n";
            }
        } else {
            echo "✗ Lead not found: {$name}\n";
            $notFoundCount++;
        }
        
        echo "---\n";
    }
    
    echo "\n=== UPDATE SUMMARY ===\n";
    echo "Total leads processed: " . ($highestRow - 1) . "\n";
    echo "Leads updated: {$updatedCount}\n";
    echo "Leads skipped: {$skippedCount}\n";
    echo "Leads not found: {$notFoundCount}\n";
    
    if ($updatedCount > 0) {
        echo "\n🎉 SUCCESS: {$updatedCount} leads have been updated with work-related data!\n";
    } else {
        echo "\n⚠️  No leads were updated. Please check if the Excel file contains data for existing leads.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
