<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging leads display issue...\n";

try {
    // 1. Check if leads are being created
    echo "1. Checking recent lead creation:\n";
    
    $allLeads = \App\Models\Lead::orderBy('created_at', 'desc')->take(10)->get();
    echo "   Total leads in database: " . \App\Models\Lead::count() . "\n";
    
    if ($allLeads->count() > 0) {
        echo "   Recent leads:\n";
        foreach ($allLeads as $lead) {
            echo "   - ID: {$lead->id}, Name: {$lead->name}, Email: " . ($lead->email ?? 'NULL') . ", Created: {$lead->created_at}\n";
        }
    } else {
        echo "   ❌ No leads found in database!\n";
        return;
    }
    
    // 2. Simulate the exact query that LeadController@index uses
    echo "\n2. Testing LeadController@index query:\n";
    
    $query = \App\Models\Lead::with(['creator', 'assignedUser']);
    
    // Apply the same logic as the controller
    $leads = $query->latest()->paginate(10);
    
    echo "   Leads found by controller query: " . $leads->count() . "\n";
    
    if ($leads->count() > 0) {
        echo "   Leads that should be displayed:\n";
        foreach ($leads as $lead) {
            echo "   - ID: {$lead->id}, Name: {$lead->name}, Status: {$lead->lead_status}\n";
        }
    } else {
        echo "   ❌ No leads found by controller query!\n";
    }
    
    // 3. Check for any filters that might be hiding leads
    echo "\n3. Checking for potential filter issues:\n";
    
    // Check if there are any leads with null/invalid data that might cause display issues
    $problematicLeads = \App\Models\Lead::whereNull('name')
        ->orWhereNull('lead_status')
        ->orWhereNull('priority')
        ->limit(5)
        ->get();
    
    if ($problematicLeads->count() > 0) {
        echo "   Found {$problematicLeads->count()} leads with problematic data:\n";
        foreach ($problematicLeads as $lead) {
            echo "   - ID: {$lead->id}, Name: " . ($lead->name ?? 'NULL') . "\n";
        }
    } else {
        echo "   ✅ No problematic leads found\n";
    }
    
    // 4. Check the leads index view file
    echo "\n4. Checking leads index view file:\n";
    
    $indexPath = base_path('resources/views/admin/leads/index.blade.php');
    if (file_exists($indexPath)) {
        echo "   ✅ Index view file exists\n";
        
        // Check if the view has any issues
        $viewContent = file_get_contents($indexPath);
        if (strpos($viewContent, '@foreach') !== false) {
            echo "   ✅ View has foreach loop for displaying leads\n";
        } else {
            echo "   ❌ View might be missing foreach loop\n";
        }
        
        if (strpos($viewContent, '$leads') !== false) {
            echo "   ✅ View references \$leads variable\n";
        } else {
            echo "   ❌ View might not be using \$leads variable\n";
        }
    } else {
        echo "   ❌ Index view file not found!\n";
    }
    
    // 5. Test a specific recent lead to make sure it should be displayable
    echo "\n5. Testing specific lead display:\n";
    
    $latestLead = \App\Models\Lead::orderBy('created_at', 'desc')->first();
    if ($latestLead) {
        echo "   Latest lead details:\n";
        echo "   - ID: {$latestLead->id}\n";
        echo "   - Name: {$latestLead->name}\n";
        echo "   - Email: " . ($latestLead->email ?? 'NULL') . "\n";
        echo "   - Status: {$latestLead->lead_status}\n";
        echo "   - Priority: {$latestLead->priority}\n";
        echo "   - Created At: {$latestLead->created_at}\n";
        echo "   - Should be visible: YES\n";
    }
    
    echo "\n💡 POSSIBLE CAUSES:\n";
    echo "   1. View file has errors or missing data\n";
    echo "   2. Pagination is hiding recent leads\n";
    echo "   3. Filters are applied by default\n";
    echo "   4. JavaScript is hiding leads on the frontend\n";
    echo "   5. Cache issues (browser or Laravel cache)\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
