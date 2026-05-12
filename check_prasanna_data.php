<?php
require_once 'c:\xampp\htdocs\nircrm (1)\vendor\autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$excelFile = 'C:\xampp\htdocs\nircrm (1)\leads_template_data.xlsx';
$spreadsheet = IOFactory::load($excelFile);
$worksheet = $spreadsheet->getActiveSheet();

echo "Checking Prasanna Singankulli data:\n";
for ($row = 2; $row <= 100; $row++) {
    $name = $worksheet->getCell('A' . $row)->getValue();
    if ($name === 'Prasanna Singankulli') {
        echo "Row {$row}:\n";
        echo "Name: " . $name . "\n";
        echo "B (Work Status): " . $worksheet->getCell('B' . $row)->getValue() . "\n";
        echo "C (Work Type): " . $worksheet->getCell('C' . $row)->getValue() . "\n";
        echo "D (Current Service): " . $worksheet->getCell('D' . $row)->getValue() . "\n";
        echo "E (Date of Completion): " . $worksheet->getCell('E' . $row)->getValue() . "\n";
        echo "F (Email): " . $worksheet->getCell('F' . $row)->getValue() . "\n";
        echo "G (Phone): " . $worksheet->getCell('G' . $row)->getValue() . "\n";
        echo "H (Company Name): " . $worksheet->getCell('H' . $row)->getValue() . "\n";
        break;
    }
}

echo "\nFirst 10 rows of Work Status column (B):\n";
for ($row = 2; $row <= 11; $row++) {
    $name = $worksheet->getCell('A' . $row)->getValue();
    $workStatus = $worksheet->getCell('B' . $row)->getValue();
    echo "Row {$row}: {$name} -> Work Status: {$workStatus}\n";
}
