<?php
require_once 'c:\xampp\htdocs\nircrm (1)\vendor\autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$excelFile = 'C:\xampp\htdocs\nircrm (1)\leads_template_data.xlsx';
$spreadsheet = IOFactory::load($excelFile);
$worksheet = $spreadsheet->getActiveSheet();

echo "=== CHECKING DATE OF COMPLETION DATA ===\n";

// Check specific names that should have date data
$targetNames = ['Rajendra Korde', 'Prasanna Singankulli', 'Sachin Magar', 'Meena Lokhande', 'Arun Patil'];

foreach ($targetNames as $targetName) {
    for ($row = 2; $row <= 100; $row++) {
        $name = $worksheet->getCell('A' . $row)->getValue();
        if ($name === $targetName) {
            echo "\n--- {$targetName} (Row {$row}) ---\n";
            echo "Name (A): '{$name}'\n";
            echo "Work Status (B): '{$worksheet->getCell('B' . $row)->getValue()}'\n";
            echo "Work Type (C): '{$worksheet->getCell('C' . $row)->getValue()}'\n";
            echo "Current Service (D): '{$worksheet->getCell('D' . $row)->getValue()}'\n";
            echo "Date of Completion (E): '{$worksheet->getCell('E' . $row)->getValue()}'\n";
            
            $dateValue = $worksheet->getCell('E' . $row)->getValue();
            echo "Date Value Type: " . gettype($dateValue) . "\n";
            echo "Date Value Length: " . strlen($dateValue) . "\n";
            
            if (is_numeric($dateValue)) {
                echo "Date is numeric: {$dateValue}\n";
                try {
                    $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateValue);
                    echo "Converted Date: " . $date->format('Y-m-d') . "\n";
                } catch (Exception $e) {
                    echo "Date conversion error: " . $e->getMessage() . "\n";
                }
            }
            break;
        }
    }
}

echo "\n=== COLUMN HEADER VERIFICATION ===\n";
echo "E Column Header: '{$worksheet->getCell('E1')->getValue()}'\n";
