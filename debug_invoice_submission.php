<?php
// Debug script to check invoice submission
echo "=== Invoice Submission Debug ===\n\n";

// Check if we can access the database
try {
    require_once 'vendor/autoload.php';
    
    // Initialize Laravel
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "✅ Laravel initialized successfully\n\n";
    
    // Check if leads table exists and has data
    try {
        $leads = \App\Models\Lead::where('lead_status', 'qualified')->limit(5)->get();
        echo "📋 Found " . $leads->count() . " qualified leads:\n";
        foreach ($leads as $lead) {
            echo "   - Lead ID: {$lead->id}, Name: {$lead->name}, Email: {$lead->email}\n";
        }
    } catch (\Exception $e) {
        echo "❌ Error accessing leads: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
    
    // Check if invoices table exists
    try {
        $invoices = \App\Models\Invoice::latest()->limit(3)->get();
        echo "📄 Latest invoices:\n";
        foreach ($invoices as $invoice) {
            echo "   - Invoice #: {$invoice->invoice_number}, Status: {$invoice->status}, Created: {$invoice->created_at}\n";
        }
    } catch (\Exception $e) {
        echo "❌ Error accessing invoices: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
    
    // Check email configuration
    $mailConfig = [
        'driver' => config('mail.default'),
        'host' => config('mail.mailers.smtp.host'),
        'port' => config('mail.mailers.smtp.port'),
        'from' => config('mail.from.address'),
        'from_name' => config('mail.from.name'),
    ];
    
    echo "📧 Email Configuration:\n";
    foreach ($mailConfig as $key => $value) {
        echo "   - $key: " . ($value ?: 'NOT SET') . "\n";
    }
    
    echo "\n=== Debug Complete ===\n";
    echo "If you see this message, the system is ready.\n";
    echo "Try creating an invoice and check the Laravel logs for detailed debugging.\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>
