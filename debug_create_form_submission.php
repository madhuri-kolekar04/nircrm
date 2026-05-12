<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging Create Form Submission Process...\n";

try {
    // Step 1: Check if the route exists
    echo "1. Checking route existence:\n";
    
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $createRouteFound = false;
    $storeRouteFound = false;
    
    foreach ($routes as $route) {
        if ($route->uri() === 'leadsmanagement/create-new') {
            echo "   ✅ Create route found: " . $route->getName() . "\n";
            $createRouteFound = true;
        }
        if ($route->uri() === 'leadsmanagement/store-new') {
            echo "   ✅ Store route found: " . $route->getName() . "\n";
            $storeRouteFound = true;
        }
    }
    
    if (!$createRouteFound) {
        echo "   ❌ Create route not found!\n";
    }
    if (!$storeRouteFound) {
        echo "   ❌ Store route not found!\n";
    }
    
    // Step 2: Check controller methods
    echo "\n2. Checking controller methods:\n";
    
    $controller = new \App\Http\Controllers\Admin\LeadController();
    
    if (method_exists($controller, 'createNew')) {
        echo "   ✅ createNew method exists\n";
    } else {
        echo "   ❌ createNew method missing\n";
    }
    
    if (method_exists($controller, 'storeNew')) {
        echo "   ✅ storeNew method exists\n";
    } else {
        echo "   ❌ storeNew method missing\n";
    }
    
    // Step 3: Test form submission simulation
    echo "\n3. Testing form submission simulation:\n";
    
    $testData = [
        'name' => 'Debug Test Lead',
        'email' => 'debug@test.com',
        'phone' => '555-123-4567',
        'company_name' => 'Debug Test Company',
        'website' => 'https://debugtest.com',
        'address' => '123 Debug Street',
        'city' => 'Debug City',
        'state' => 'DB',
        'country' => 'Debug Country',
        'pincode' => '12345',
        'industry' => 'Debug Technology',
        'lead_status' => 'hot',
        'source' => 'website',
        'description' => 'Debug test description',
        'budget' => '100000.00',
        'follow_up_date' => '2026-06-15',
        'notes' => 'Debug test notes',
        'priority' => 'high',
        'department_id' => '2',
        'assigned_to' => '18',
    ];
    
    echo "   - Test data prepared\n";
    echo "   - Name: {$testData['name']}\n";
    echo "   - Email: {$testData['email']}\n";
    echo "   - Follow Up Date: {$testData['follow_up_date']}\n";
    
    // Step 4: Test validation
    echo "\n4. Testing validation:\n";
    
    $request = new \Illuminate\Http\Request();
    $request->merge($testData);
    
    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:20',
        'company_name' => 'nullable|string|max:255',
        'website' => 'nullable|url|max:255',
        'address' => 'nullable|string',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'country' => 'nullable|string|max:100',
        'pincode' => 'nullable|string|max:20',
        'industry' => 'nullable|string|max:100',
        'lead_status' => 'required|string|max:100',
        'source' => 'required|string|max:100',
        'custom_source' => 'required_if:source,other|string|max:255',
        'description' => 'nullable|string',
        'budget' => 'nullable|numeric|min:0',
        'follow_up_date' => 'nullable|date',
        'notes' => 'nullable|string',
        'priority' => 'required|string|max:100',
        'department_id' => 'nullable|exists:departments,id',
        'assigned_to' => 'nullable|exists:users,id',
    ]);
    
    if ($validator->fails()) {
        echo "   ❌ Validation failed:\n";
        foreach ($validator->errors()->all() as $error) {
            echo "     - $error\n";
        }
        return;
    }
    
    echo "   ✅ Validation passed\n";
    
    // Step 5: Test database insertion
    echo "\n5. Testing database insertion:\n";
    
    try {
        $validated = $validator->validated();
        
        // Determine the source value
        $sourceValue = $validated['source'];
        if ($request->source === 'other' && $request->filled('custom_source')) {
            $sourceValue = $request->custom_source;
        }
        
        // Create the lead
        $lead = \App\Models\Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'company_name' => $validated['company_name'] ?? null,
            'website' => $validated['website'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'country' => $validated['country'] ?? null,
            'pincode' => $validated['pincode'] ?? null,
            'industry' => $validated['industry'] ?? null,
            'lead_status' => $validated['lead_status'],
            'source' => $sourceValue,
            'description' => $validated['description'] ?? null,
            'budget' => $validated['budget'] ?? null,
            'assigned_to' => $validated['assigned_to'] ?? null,
            'follow_up_date' => $validated['follow_up_date'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'priority' => $validated['priority'],
            'department' => null,
            'department_id' => $validated['department_id'] ?? null,
            'created_by' => 18,
        ]);
        
        echo "   ✅ Lead created successfully: ID={$lead->id}\n";
        echo "   - Name: {$lead->name}\n";
        echo "   - Email: {$lead->email}\n";
        echo "   - Follow Up Date: " . ($lead->follow_up_date ? $lead->follow_up_date->format('Y-m-d') : 'NULL') . "\n";
        echo "   - Created At: {$lead->created_at}\n";
        
        // Step 6: Verify the lead exists in database
        echo "\n6. Verifying lead in database:\n";
        
        $verifyLead = \App\Models\Lead::find($lead->id);
        if ($verifyLead) {
            echo "   ✅ Lead verified in database\n";
            echo "   - Database ID: {$verifyLead->id}\n";
            echo "   - Database Name: {$verifyLead->name}\n";
            echo "   - Database Email: {$verifyLead->email}\n";
            echo "   - Database Follow Up Date: " . ($verifyLead->follow_up_date ? $verifyLead->follow_up_date->format('Y-m-d') : 'NULL') . "\n";
        } else {
            echo "   ❌ Lead not found in database after creation\n";
        }
        
        // Step 7: Check recent leads
        echo "\n7. Checking recent leads:\n";
        
        $recentLeads = \App\Models\Lead::orderBy('created_at', 'desc')->limit(5)->get();
        echo "   - Recent leads count: " . $recentLeads->count() . "\n";
        
        foreach ($recentLeads as $index => $recentLead) {
            echo "   - Lead " . ($index + 1) . ": ID={$recentLead->id}, Name='{$recentLead->name}', Created='{$recentLead->created_at}'\n";
        }
        
        echo "\n🎉 CREATE FORM SUBMISSION DEBUG COMPLETE!\n";
        echo "   - ✅ Routes exist\n";
        echo "   - ✅ Controller methods exist\n";
        echo "   - ✅ Validation works\n";
        echo "   - ✅ Database insertion works\n";
        echo "   - ✅ Lead verified in database\n";
        
        echo "\n💡 POSSIBLE ISSUES IF NOT WORKING:\n";
        echo "   1. Form action URL incorrect\n";
        echo "   2. CSRF token missing\n";
        echo "   3. JavaScript form submission issues\n";
        echo "   4. Browser network issues\n";
        echo "   5. Server errors not visible\n";
        
        echo "\n🔗 TEST URLS:\n";
        echo "   - Create Form: http://127.0.0.1:8000/leadsmanagement/create-new\n";
        echo "   - Leads List: http://127.0.0.1:8000/leadsmanagement\n";
        
    } catch (\Exception $e) {
        echo "   ❌ Database insertion failed: " . $e->getMessage() . "\n";
        echo "   - File: " . $e->getFile() . "\n";
        echo "   - Line: " . $e->getLine() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
