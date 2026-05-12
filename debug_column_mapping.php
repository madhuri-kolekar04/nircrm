<?php
require_once 'c:\xampp\htdocs\nircrm (1)\vendor\autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$excelFile = 'C:\xampp\htdocs\nircrm (1)\leads_template_data.xlsx';
$spreadsheet = IOFactory::load($excelFile);
$worksheet = $spreadsheet->getActiveSheet();

echo "=== DEBUGGING COLUMN MAPPING ===\n";

// Check first 10 rows for column mapping
for ($row = 2; $row <= 11; $row++) {
    $name = $worksheet->getCell('A' . $row)->getValue();
    if (!empty($name)) {
        echo "Row {$row}:\n";
        echo "  Name (A): '{$name}'\n";
        echo "  Work Status (B): '{$worksheet->getCell('B' . $row)->getValue()}'\n";
        echo "  Work Type (C): '{$worksheet->getCell('C' . $row)->getValue()}'\n";
        echo "  Current Service (D): '{$worksheet->getCell('D' . $row)->getValue()}'\n";
        echo "  Date of Completion (E): '{$worksheet->getCell('E' . $row)->getValue()}'\n";
        echo "  Email (F): '{$worksheet->getCell('F' . $row)->getValue()}'\n";
        echo "  Phone (G): '{$worksheet->getCell('G' . $row)->getValue()}'\n";
        echo "  Company (H): '{$worksheet->getCell('H' . $row)->getValue()}'\n";
        echo "  ---\n";
    }
}

echo "\n=== COLUMN HEADERS ===\n";
echo "A (Name): '{$worksheet->getCell('A1')->getValue()}'\n";
echo "B (Work Status): '{$worksheet->getCell('B1')->getValue()}'\n";
echo "C (Work Type): '{$worksheet->getCell('C1')->getValue()}'\n";
echo "D (Current Service): '{$worksheet->getCell('D1')->getValue()}'\n";
echo "E (Date of Completion): '{$worksheet->getCell('E1')->getValue()}'\n";
echo "F (Email): '{$worksheet->getCell('F1')->getValue()}'\n";
echo "G (Phone): '{$worksheet->getCell('G1')->getValue()}'\n";
echo "H (Company): '{$worksheet->getCell('H1')->getValue()}'\n";
