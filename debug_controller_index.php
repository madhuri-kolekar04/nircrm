<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging LeadController@index method...\n";

try {
    // Simulate exactly what the controller does
    echo "1. Simulating LeadController@index method:\n";
    
    // Create a mock request (no filters)
    $request = new \Illuminate\Http\Request();
    
    $query = \App\Models\Lead::with(['creator', 'assignedUser']);
    
    echo "   - Base query created\n";
    
    // Apply search filter (none in this case)
    if ($request->filled('search')) {
        $searchTerm = $request->input('search');
        $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('phone', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('company_name', 'LIKE', '%' . $searchTerm . '%');
        });
        echo "   - Search filter applied: $searchTerm\n";
    } else {
        echo "   - No search filter\n";
    }
    
    // Apply status filter
    if ($request->filled('filter_type') && $request->filled('filter_value') && $request->input('filter_type') === 'status') {
        $filterValue = $request->input('filter_value');
        $query->where('lead_status', $filterValue);
        echo "   - Status filter applied: $filterValue\n";
    } else {
        echo "   - No status filter\n";
    }
    
    // Apply priority filter
    if ($request->filled('priority')) {
        $query->where('priority', $request->input('priority'));
        echo "   - Priority filter applied: " . $request->input('priority') . "\n";
    } else {
        echo "   - No priority filter\n";
    }
    
    // Apply source filter
    if ($request->filled('source')) {
        $query->where('source', $request->input('source'));
        echo "   - Source filter applied: " . $request->input('source') . "\n";
    } else {
        echo "   - No source filter\n";
    }
    
    echo "\n2. Executing query and paginating:\n";
    
    $leads = $query->latest()->paginate(10);
    
    echo "   - Total leads found: " . $leads->total() . "\n";
    echo "   - Current page leads: " . $leads->count() . "\n";
    echo "   - Current page: " . $leads->currentPage() . "\n";
    echo "   - Per page: " . $leads->perPage() . "\n";
    
    if ($leads->count() > 0) {
        echo "\n3. Leads that should be displayed:\n";
        foreach ($leads as $index => $lead) {
            echo "   - " . ($index + 1) . ". ID: {$lead->id}, Name: {$lead->name}, Email: " . ($lead->email ?? 'NULL') . "\n";
        }
        
        echo "\n✅ CONTROLLER LOGIC IS WORKING!\n";
        echo "   The controller should be passing these leads to the view.\n";
        
    } else {
        echo "\n❌ NO LEADS FOUND BY CONTROLLER!\n";
        echo "   This explains why the view shows 'No leads found'.\n";
    }
    
    // Test with a direct query to see if there's an issue
    echo "\n4. Testing direct query (bypassing all filters):\n";
    
    $directLeads = \App\Models\Lead::latest()->take(10)->get();
    echo "   - Direct query results: " . $directLeads->count() . " leads\n";
    
    if ($directLeads->count() > 0) {
        foreach ($directLeads as $lead) {
            echo "   - ID: {$lead->id}, Name: {$lead->name}\n";
        }
    }
    
    echo "\n💡 POSSIBLE ISSUES:\n";
    echo "   1. Session/Request data is applying filters unexpectedly\n";
    echo "   2. View caching is preventing updates\n";
    echo "   3. The controller is not being called correctly\n";
    echo "   4. There's a middleware interfering with the request\n";
    echo "   5. The view file is not being updated properly\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
