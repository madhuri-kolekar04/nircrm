<?php
require_once 'c:\xampp\htdocs\nircrm (1)\bootstrap\app.php';

use App\Models\Lead;

// Read the Excel file
$excelFile = 'C:\xampp\htdocs\nircrm (1)\sample_work_data.xlsx';

echo "Processing lead updates...\n";

try {
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFile);
    $worksheet = $spreadsheet->getActiveSheet();
    $highestRow = $worksheet->getHighestRow();
    
    echo "Found {$highestRow} rows in Excel file\n";
    
    // Process each row starting from row 2 (assuming row 1 is headers)
    for ($row = 2; $row <= $highestRow; $row++) {
        $name = $worksheet->getCell('A' . $row)->getValue();
        
        if (empty($name)) {
            echo "Skipping empty row {$row}\n";
            continue;
        }
        
        echo "Processing: {$name}\n";
        
        // Get the work-related data from columns E, F, G, H
        $workStatus = $worksheet->getCell('E' . $row)->getValue() ?? null;
        $workType = $worksheet->getCell('F' . $row)->getValue() ?? null;
        $currentService = $worksheet->getCell('G' . $row)->getValue() ?? null;
        $dateOfCompletion = $worksheet->getCell('H' . $row)->getValue() ?? null;
        
        // Find the lead by name
        $lead = Lead::where('name', $name)->first();
        
        if ($lead) {
            echo "Found lead: {$lead->name} (ID: {$lead->id})\n";
            
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
                echo "Updated lead {$lead->id} with work data\n";
                echo "  - Work Status: {$workStatus}\n";
                echo "  - Work Type: {$workType}\n";
                echo "  - Current Service: {$currentService}\n";
                echo "  - Date of Completion: {$dateOfCompletion}\n";
            } else {
                echo "No work data to update for lead {$lead->id}\n";
            }
        } else {
            echo "Lead not found: {$name}\n";
        }
        
        echo "---\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
