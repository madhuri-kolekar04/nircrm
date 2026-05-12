<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging form submission issues...\n";

try {
    // Check the most recent lead to see what data was actually stored
    echo "1. Checking most recent lead in database:\n";
    
    $latestLead = \App\Models\Lead::orderBy('created_at', 'desc')->first();
    
    if ($latestLead) {
        echo "   Lead ID: " . $latestLead->id . "\n";
        echo "   Name: " . $latestLead->name . "\n";
        echo "   Email: " . ($latestLead->email ?? 'NULL') . "\n";
        echo "   Phone: " . ($latestLead->phone ?? 'NULL') . "\n";
        echo "   Company: " . ($latestLead->company_name ?? 'NULL') . "\n";
        echo "   Website: " . ($latestLead->website ?? 'NULL') . "\n";
        echo "   Address: " . ($latestLead->address ?? 'NULL') . "\n";
        echo "   City: " . ($latestLead->city ?? 'NULL') . "\n";
        echo "   State: " . ($latestLead->state ?? 'NULL') . "\n";
        echo "   Country: " . ($latestLead->country ?? 'NULL') . "\n";
        echo "   Pincode: " . ($latestLead->pincode ?? 'NULL') . "\n";
        echo "   Industry: " . ($latestLead->industry ?? 'NULL') . "\n";
        echo "   Status: " . $latestLead->lead_status . "\n";
        echo "   Source: " . $latestLead->source . "\n";
        echo "   Description: " . ($latestLead->description ?? 'NULL') . "\n";
        echo "   Budget: " . ($latestLead->budget ?? 'NULL') . "\n";
        echo "   Assigned To: " . ($latestLead->assigned_to ?? 'NULL') . "\n";
        echo "   Follow Up Date: " . ($latestLead->follow_up_date ?? 'NULL') . "\n";
        echo "   Notes: " . ($latestLead->notes ?? 'NULL') . "\n";
        echo "   Priority: " . $latestLead->priority . "\n";
        echo "   Department ID: " . ($latestLead->department_id ?? 'NULL') . "\n";
        echo "   Created At: " . $latestLead->created_at . "\n";
        
        // Check what fields are NULL/empty
        echo "\n2. Checking for NULL/empty fields:\n";
        $fields = [
            'email', 'phone', 'company_name', 'website', 'address', 'city', 
            'state', 'country', 'pincode', 'industry', 'description', 
            'budget', 'assigned_to', 'follow_up_date', 'notes', 'department_id'
        ];
        
        $emptyFields = [];
        foreach ($fields as $field) {
            $value = $latestLead->$field;
            if ($value === null || $value === '') {
                $emptyFields[] = $field;
                echo "   ❌ $field is NULL/empty\n";
            } else {
                echo "   ✅ $field has data: " . $value . "\n";
            }
        }
        
        if (!empty($emptyFields)) {
            echo "\n⚠️  Fields that are empty: " . implode(', ', $emptyFields) . "\n";
            echo "\nThis suggests the form might not be submitting all fields properly.\n";
        } else {
            echo "\n✅ All fields have data!\n";
        }
        
    } else {
        echo "   No leads found in database!\n";
    }
    
    // Check if there are any leads with missing data
    echo "\n3. Checking for leads with incomplete data:\n";
    
    $incompleteLeads = \App\Models\Lead::where(function($query) {
        $query->whereNull('email')
              ->orWhereNull('phone')
              ->orWhereNull('company_name')
              ->orWhereNull('address')
              ->orWhereNull('city');
    })->limit(3)->get();
    
    if ($incompleteLeads->count() > 0) {
        echo "   Found " . $incompleteLeads->count() . " leads with incomplete data:\n";
        foreach ($incompleteLeads as $lead) {
            echo "   - Lead ID {$lead->id}: {$lead->name} (Created: {$lead->created_at})\n";
        }
    } else {
        echo "   ✅ No leads with obviously incomplete data found.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
