<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging view data issue...\n";

try {
    // Simulate the exact controller call
    echo "1. Simulating exact controller behavior:\n";
    
    $request = new \Illuminate\Http\Request();
    
    // Replicate the exact controller logic
    $query = \App\Models\Lead::with(['creator', 'assignedUser']);
    
    // Apply search filter
    if ($request->filled('search')) {
        $searchTerm = $request->input('search');
        $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('phone', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('company_name', 'LIKE', '%' . $searchTerm . '%');
        });
    }
    
    // Apply status filter
    if ($request->filled('filter_type') && $request->filled('filter_value') && $request->input('filter_type') === 'status') {
        $filterValue = $request->input('filter_value');
        $query->where('lead_status', $filterValue);
    }
    
    // Apply priority filter
    if ($request->filled('priority')) {
        $query->where('priority', $request->input('priority'));
    }
    
    // Apply source filter
    if ($request->filled('source')) {
        $query->where('source', $request->input('source'));
    }
    
    $leads = $query->latest()->paginate(10);
    
    // Preserve filter parameters in pagination
    $leads->appends($request->query());
    
    echo "   - Leads count: " . $leads->count() . "\n";
    echo "   - Total leads: " . $leads->total() . "\n";
    echo "   - Current page: " . $leads->currentPage() . "\n";
    
    // Check if the leads variable has data
    if ($leads->count() > 0) {
        echo "\n2. First few leads that should be in the view:\n";
        foreach ($leads->take(3) as $index => $lead) {
            echo "   - Lead " . ($index + 1) . ": ID={$lead->id}, Name={$lead->name}, Email=" . ($lead->email ?? 'NULL') . "\n";
        }
        
        // Test what the view should render
        echo "\n3. Testing view rendering logic:\n";
        echo "   - @forelse(\$leads as \$index => \$lead) should execute\n";
        echo "   - @empty section should NOT execute\n";
        echo "   - Table rows should be rendered\n";
        
        // Simulate the @forelse logic
        $leadData = [];
        foreach ($leads as $index => $lead) {
            $leadData[] = [
                'row_number' => ($leads->currentPage() - 1) * $leads->perPage() + $index + 1,
                'id' => $lead->id,
                'name' => $lead->name,
                'email' => $lead->email ?? '-',
                'phone' => $lead->phone ?? '-',
                'company_name' => $lead->company_name ?? '-',
            ];
        }
        
        echo "\n4. Simulated table data:\n";
        foreach ($leadData as $row) {
            echo "   - Row {$row['row_number']}: {$row['name']} ({$row['email']})\n";
        }
        
        echo "\n✅ VIEW SHOULD DISPLAY THESE LEADS!\n";
        
    } else {
        echo "\n❌ NO LEADS TO DISPLAY - This would trigger @empty section\n";
    }
    
    echo "\n💡 NEXT STEPS TO DEBUG:\n";
    echo "   1. Check browser console for JavaScript errors\n";
    echo "   2. Check browser network tab for failed requests\n";
    echo "   3. View page source to see if HTML table is rendered\n";
    echo "   4. Check if CSS is hiding the table\n";
    echo "   5. Try accessing the page in incognito mode\n";
    
    echo "\n🔧 QUICK FIXES TO TRY:\n";
    echo "   1. Clear browser cache completely\n";
    echo "   2. Restart the web server\n";
    echo "   3. Try a different browser\n";
    echo "   4. Check if any browser extensions are interfering\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
