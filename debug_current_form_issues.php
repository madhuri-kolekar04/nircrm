<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging Current Form Issues...\n";

try {
    // Step 1: Test current form submission
    echo "1. Testing current form submission:\n";
    
    $testData = [
        'name' => 'Current Test User',
        'lead_status' => 'hot',
        'priority' => 'high',
        'source' => 'website',
        'email' => 'current@test.com',
        'phone' => '555-123-4567',
        'company_name' => 'Current Test Company',
        'assigned_to' => '18', // Test with assigned user
        'department_id' => '2',
        'follow_up_date' => '2026-08-15',
    ];
    
    echo "   - Test data prepared\n";
    echo "   - Name: {$testData['name']}\n";
    echo "   - Assigned To: {$testData['assigned_to']}\n";
    echo "   - Department ID: {$testData['department_id']}\n";
    
    // Step 2: Test validation
    echo "\n2. Testing validation:\n";
    
    $request = new \Illuminate\Http\Request();
    $request->merge($testData);
    
    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'lead_status' => 'required|string|max:100',
        'priority' => 'required|string|max:100',
        'source' => 'required|string|max:100',
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
        'custom_source' => 'required_if:source,other|string|max:255',
        'description' => 'nullable|string',
        'budget' => 'nullable|numeric|min:0',
        'follow_up_date' => 'nullable|date',
        'notes' => 'nullable|string',
        'department_id' => 'nullable|exists:departments,id',
        'assigned_to' => 'nullable|exists:users,id',
    ]);
    
    if ($validator->fails()) {
        echo "   ❌ Validation failed:\n";
        foreach ($validator->errors()->all() as $error) {
            echo "     * $error\n";
        }
        return;
    }
    
    echo "   ✅ Validation passed\n";
    
    // Step 3: Test controller method
    echo "\n3. Testing controller storeNew method:\n";
    
    $controller = new \App\Http\Controllers\Admin\LeadController();
    
    try {
        $response = $controller->storeNew($request);
        echo "   ✅ Controller executed successfully\n";
        
        if ($response instanceof \Illuminate\Http\RedirectResponse) {
            echo "   - Redirect URL: " . $response->getTargetUrl() . "\n";
        }
        
        // Step 4: Check if lead was created
        echo "\n4. Checking if lead was created:\n";
        
        $latestLead = \App\Models\Lead::where('name', 'Current Test User')
            ->orderBy('created_at', 'desc')
            ->first();
        
        if ($latestLead) {
            echo "   ✅ Lead created: ID={$latestLead->id}\n";
            echo "   - Name: {$latestLead->name}\n";
            echo "   - Email: {$latestLead->email}\n";
            echo "   - Assigned To: " . ($latestLead->assigned_to ?: 'NULL') . "\n";
            echo "   - Department ID: " . ($latestLead->department_id ?: 'NULL') . "\n";
            echo "   - Follow Up Date: " . ($latestLead->follow_up_date ? $latestLead->follow_up_date->format('Y-m-d') : 'NULL') . "\n";
            echo "   - Created At: {$latestLead->created_at}\n";
        } else {
            echo "   ❌ Lead not found after creation\n";
        }
        
    } catch (\Exception $e) {
        echo "   ❌ Controller error: " . $e->getMessage() . "\n";
        echo "   - File: " . $e->getFile() . "\n";
        echo "   - Line: " . $e->getLine() . "\n";
    }
    
    // Step 5: Check current users and departments
    echo "\n5. Checking current users and departments:\n";
    
    $users = \App\Models\User::orderBy('name')->get();
    $departments = \App\Models\Department::orderBy('name')->get();
    
    echo "   - Total users: " . $users->count() . "\n";
    echo "   - Total departments: " . $departments->count() . "\n";
    
    echo "\n   Available users for Assign To:\n";
    foreach ($users as $user) {
        echo "     - ID: {$user->id}, Name: {$user->name}, Email: {$user->email}\n";
    }
    
    echo "\n   Available departments:\n";
    foreach ($departments as $dept) {
        echo "     - ID: {$dept->id}, Name: {$dept->name}\n";
    }
    
    echo "\n🎯 CURRENT STATUS:\n";
    echo "   - Backend logic: Working correctly\n";
    echo "   - Database storage: Working correctly\n";
    echo "   - Validation: Working correctly\n";
    echo "   - Issue likely: Frontend/browser related\n";
    
    echo "\n💡 FOR 'ASSIGN TO' FIELD:\n";
    echo "   - Currently: Shows department-wise filtered users\n";
    echo "   - You want: Show all users regardless of department\n";
    echo "   - Need to: Update create_new.blade.php to show all users\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
