<?php
require_once 'c:\xampp\htdocs\nircrm (1)\vendor\autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$excelFile = 'C:\xampp\htdocs\nircrm (1)\leads_template_data.xlsx';
$spreadsheet = IOFactory::load($excelFile);
$worksheet = $spreadsheet->getActiveSheet();

echo "Checking Chandrakant Wagh data in detail:\n";
for ($row = 2; $row <= 100; $row++) {
    $name = $worksheet->getCell('A' . $row)->getValue();
    if ($name === 'Chandrakant Wagh') {
        echo "Row {$row}:\n";
        echo "Name: '{$name}'\n";
        echo "B (Work Status): '{$worksheet->getCell('B' . $row)->getValue()}'\n";
        echo "C (Work Type): '{$worksheet->getCell('C' . $row)->getValue()}'\n";
        echo "D (Current Service): '{$worksheet->getCell('D' . $row)->getValue()}'\n";
        echo "E (Date of Completion): '{$worksheet->getCell('E' . $row)->getValue()}'\n";
        echo "F (Email): '{$worksheet->getCell('F' . $row)->getValue()}'\n";
        echo "G (Phone): '{$worksheet->getCell('G' . $row)->getValue()}'\n";
        echo "H (Company Name): '{$worksheet->getCell('H' . $row)->getValue()}'\n";
        
        // Check if values are truly empty
        $workStatus = $worksheet->getCell('B' . $row)->getValue();
        $workType = $worksheet->getCell('C' . $row)->getValue();
        $currentService = $worksheet->getCell('D' . $row)->getValue();
        $dateOfCompletion = $worksheet->getCell('E' . $row)->getValue();
        
        echo "\n--- Empty Checks ---\n";
        echo "Work Status empty: " . (empty($workStatus) ? 'YES' : 'NO') . "\n";
        echo "Work Type empty: " . (empty($workType) ? 'YES' : 'NO') . "\n";
        echo "Current Service empty: " . (empty($currentService) ? 'YES' : 'NO') . "\n";
        echo "Date of Completion empty: " . (empty($dateOfCompletion) ? 'YES' : 'NO') . "\n";
        
        echo "\n--- String Lengths ---\n";
        echo "Work Status length: " . strlen(trim($workStatus ?? '')) . "\n";
        echo "Work Type length: " . strlen(trim($workType ?? '')) . "\n";
        echo "Current Service length: " . strlen(trim($currentService ?? '')) . "\n";
        echo "Date of Completion length: " . strlen(trim($dateOfCompletion ?? '')) . "\n";
        
        break;
    }
}

echo "\nFirst 5 rows around Chandrakant Wagh:\n";
for ($row = max(2, 61 - 2); $row <= min(61 + 3, 100); $row++) {
    $name = $worksheet->getCell('A' . $row)->getValue();
    echo "Row {$row}: '{$name}'\n";
}
