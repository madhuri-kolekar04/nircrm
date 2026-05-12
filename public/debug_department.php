<?php
// Debug script to check user department and invoices
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Invoice;

// Get current user
$user = Auth::user();

echo "=== CURRENT USER INFO ===\n";
echo "User ID: " . $user->id . "\n";
echo "User Name: " . $user->name . "\n";
echo "User Email: " . $user->email . "\n";
echo "User Role: " . $user->role . "\n";
echo "User Department: '" . $user->department . "'\n";
echo "Department Length: " . strlen($user->department) . "\n";
echo "Department is empty: " . (empty($user->department) ? 'YES' : 'NO') . "\n";
echo "\n";

echo "=== ALL INVOICES DEPARTMENTS ===\n";
$allInvoices = Invoice::select('id', 'invoice_number', 'department', 'project_name')->get();
foreach ($allInvoices as $inv) {
    echo "Invoice #{$inv->invoice_number} | Dept: '" . $inv->department . "' | Project: {$inv->project_name}\n";
}
echo "\nTotal invoices: " . $allInvoices->count() . "\n\n";

echo "=== FILTERED INVOICES (User's Department) ===\n";
echo "Searching for department: '" . $user->department . "'\n";
$filteredInvoices = Invoice::where('department', $user->department)->get();
echo "Found: " . $filteredInvoices->count() . " invoices\n";
foreach ($filteredInvoices as $inv) {
    echo "Invoice #{$inv->invoice_number} | Dept: '" . $inv->department . "'\n";
}

// Try case-insensitive search
echo "\n=== CASE INSENSITIVE SEARCH ===\n";
$ciInvoices = Invoice::whereRaw('LOWER(TRIM(department)) = ?', [strtolower(trim($user->department))])->get();
echo "Case-insensitive found: " . $ciInvoices->count() . " invoices\n";
