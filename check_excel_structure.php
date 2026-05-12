<?php
require_once 'c:\xampp\htdocs\nircrm (1)\vendor\autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$excelFile = 'C:\xampp\htdocs\nircrm (1)\leads_template_data.xlsx';
$spreadsheet = IOFactory::load($excelFile);
$worksheet = $spreadsheet->getActiveSheet();

echo "Excel Structure:\n";
echo "A1: " . $worksheet->getCell('A1')->getValue() . "\n";
echo "B1: " . $worksheet->getCell('B1')->getValue() . "\n";
echo "C1: " . $worksheet->getCell('C1')->getValue() . "\n";
echo "D1: " . $worksheet->getCell('D1')->getValue() . "\n";
echo "E1: " . $worksheet->getCell('E1')->getValue() . "\n";
echo "F1: " . $worksheet->getCell('F1')->getValue() . "\n";
echo "G1: " . $worksheet->getCell('G1')->getValue() . "\n";
echo "H1: " . $worksheet->getCell('H1')->getValue() . "\n";
echo "I1: " . $worksheet->getCell('I1')->getValue() . "\n";
echo "J1: " . $worksheet->getCell('J1')->getValue() . "\n";

echo "\nPrasanna Singankulli data:\n";
for ($row = 2; $row <= 10; $row++) {
    $name = $worksheet->getCell('A' . $row)->getValue();
    if ($name === 'Prasanna Singankulli') {
        echo "Row {$row}:\n";
        echo "Name: " . $name . "\n";
        echo "E: " . $worksheet->getCell('E' . $row)->getValue() . "\n";
        echo "F: " . $worksheet->getCell('F' . $row)->getValue() . "\n";
        echo "G: " . $worksheet->getCell('G' . $row)->getValue() . "\n";
        echo "H: " . $worksheet->getCell('H' . $row)->getValue() . "\n";
        break;
    }
}
