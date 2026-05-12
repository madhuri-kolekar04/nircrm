<?php
// Debug form submission issues
require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Invoice Form Debug ===\n\n";

try {
    // Get lead ID 104
    $lead = \App\Models\Lead::find(104);
    
    if (!$lead) {
        echo "❌ Lead ID 104 not found\n";
        exit;
    }
    
    echo "📋 Lead Found: {$lead->name} (ID: {$lead->id})\n";
    echo "📧 Email: {$lead->email}\n";
    echo "📱 Phone: {$lead->phone}\n\n";
    
    // Test the controller method directly
    $controller = new \App\Http\Controllers\Backend\DepartmentController();
    
    // Create a mock request with form data
    $request = new \Illuminate\Http\Request([
        '_token' => 'test-token',
        'invoice_date' => now()->format('Y-m-d'),
        'client_name' => $lead->name,
        'client_email' => $lead->email,
        'client_phone' => $lead->phone,
        'payment_status' => 'pending',
        'total_amount' => 1000.00,
        'advance_payment' => 0,
        'remaining_amount' => 1000.00,
        'save_only' => '1',
    ]);
    
    echo "🚀 Testing controller method...\n";
    echo "📋 Request data:\n";
    foreach ($request->all() as $key => $value) {
        echo "   $key: $value\n";
    }
    
    // Call the controller method
    $response = $controller->saveInvoiceFromLead($request, $lead);
    
    if ($response instanceof \Illuminate\Http\RedirectResponse) {
        echo "\n✅ Controller method executed successfully!\n";
        echo "📄 Redirecting to: " . $response->getTargetUrl() . "\n";
        
        // Check session for success messages
        $session = session()->all();
        echo "📋 Session messages:\n";
        foreach ($session as $key => $value) {
            if (is_string($value) && (str_contains($key, 'success') || str_contains($key, 'error'))) {
                echo "   $key: $value\n";
            }
        }
        
        // Check if invoice was created
        $latestInvoice = \DB::table('invoices')
            ->where('lead_id', $lead->id)
            ->orderBy('created_at', 'desc')
            ->first();
            
        if ($latestInvoice) {
            echo "\n📄 Invoice created successfully!\n";
            echo "📄 Invoice Number: {$latestInvoice->invoice_number}\n";
            echo "📄 Invoice ID: {$latestInvoice->id}\n";
            echo "📄 Total Amount: {$latestInvoice->total_payment}\n";
            echo "📧 Customer Email: {$latestInvoice->customer_email}\n";
            
            // Check if lead was updated
            $updatedLead = \App\Models\Lead::find($lead->id);
            echo "📋 Lead Invoice Status: {$updatedLead->invoice_status}\n";
            echo "📋 Lead Invoice Number: {$updatedLead->invoice_number}\n";
            
            echo "\n✅ SUCCESS: Everything is working!\n";
            echo "✅ Database storage: WORKING\n";
            echo "✅ Lead updates: WORKING\n";
            echo "✅ Controller logic: WORKING\n";
            
        } else {
            echo "\n❌ Invoice not found in database\n";
        }
    } else {
        echo "\n❌ Controller method failed\n";
        if ($response instanceof \Illuminate\Http\RedirectResponse) {
            echo "📄 Redirect URL: " . $response->getTargetUrl() . "\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Debug Complete ===\n";
echo "If this test passes, the issue is likely in the frontend form submission.\n";
echo "Check browser console for JavaScript errors.\n";
?>
