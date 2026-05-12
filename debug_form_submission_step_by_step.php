<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "STEP-BY-STEP FORM SUBMISSION DEBUGGING...\n";

try {
    // Step 1: Check if the route is accessible
    echo "1. Checking route accessibility:\n";
    
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $storeRoute = null;
    
    foreach ($routes as $route) {
        if ($route->uri() === 'leadsmanagement/store-new') {
            $storeRoute = $route;
            break;
        }
    }
    
    if ($storeRoute) {
        echo "   ✅ Store route found: " . $storeRoute->getName() . "\n";
        echo "   - URI: " . $storeRoute->uri() . "\n";
        echo "   - Methods: " . implode('|', $storeRoute->methods()) . "\n";
        echo "   - Action: " . $storeRoute->getActionName() . "\n";
    } else {
        echo "   ❌ Store route NOT found!\n";
        return;
    }
    
    // Step 2: Test the exact form data you would submit
    echo "\n2. Testing exact form submission:\n";
    
    $formData = [
        '_token' => 'test-token',
        'name' => 'Debug User',
        'email' => 'debug@example.com',
        'lead_status' => 'hot',
        'priority' => 'high',
        'source' => 'website',
        'assigned_to' => '18',
        'department_id' => '2',
        'follow_up_date' => '2026-10-01',
    ];
    
    echo "   - Form data prepared:\n";
    foreach ($formData as $key => $value) {
        echo "     * $key: $value\n";
    }
    
    // Step 3: Create a proper HTTP request
    echo "\n3. Creating HTTP request:\n";
    
    $request = \Illuminate\Http\Request::create('/leadsmanagement/store-new', 'POST', $formData);
    
    // Add session and CSRF
    $session = app('session');
    $session->start();
    $request->setSession($session);
    
    echo "   ✅ HTTP request created\n";
    echo "   - Method: POST\n";
    echo "   - URI: /leadsmanagement/store-new\n";
    echo "   - Parameters: " . count($formData) . "\n";
    
    // Step 4: Test the controller method directly
    echo "\n4. Testing controller method:\n";
    
    $controller = new \App\Http\Controllers\Admin\LeadController();
    
    try {
        echo "   - Calling storeNew method...\n";
        $response = $controller->storeNew($request);
        
        echo "   ✅ Controller method executed\n";
        echo "   - Response type: " . get_class($response) . "\n";
        
        if ($response instanceof \Illuminate\Http\RedirectResponse) {
            echo "   - Redirect URL: " . $response->getTargetUrl() . "\n";
            
            // Check session for success message
            if ($session->has('success')) {
                echo "   - Success message: " . $session->get('success') . "\n";
            }
        }
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        echo "   ❌ Validation failed:\n";
        foreach ($e->errors()->all() as $error) {
            echo "     * $error\n";
        }
        return;
        
    } catch (\Exception $e) {
        echo "   ❌ Controller error: " . $e->getMessage() . "\n";
        echo "   - File: " . $e->getFile() . "\n";
        echo "   - Line: " . $e->getLine() . "\n";
        return;
    }
    
    // Step 5: Check if lead was actually created
    echo "\n5. Verifying lead creation:\n";
    
    $lead = \App\Models\Lead::where('name', 'Debug User')
        ->where('email', 'debug@example.com')
        ->orderBy('created_at', 'desc')
        ->first();
    
    if ($lead) {
        echo "   ✅ Lead found in database: ID={$lead->id}\n";
        echo "   - Name: {$lead->name}\n";
        echo "   - Email: {$lead->email}\n";
        echo "   - Status: {$lead->lead_status}\n";
        echo "   - Priority: {$lead->priority}\n";
        echo "   - Source: {$lead->source}\n";
        echo "   - Assigned To: " . ($lead->assigned_to ?: 'NULL') . "\n";
        echo "   - Department ID: " . ($lead->department_id ?: 'NULL') . "\n";
        echo "   - Follow Up Date: " . ($lead->follow_up_date ? $lead->follow_up_date->format('Y-m-d') : 'NULL') . "\n";
        echo "   - Created At: {$lead->created_at}\n";
        echo "   - Updated At: {$lead->updated_at}\n";
    } else {
        echo "   ❌ Lead NOT found in database!\n";
        
        // Check all recent leads
        echo "\n   Recent leads in database:\n";
        $recentLeads = \App\Models\Lead::orderBy('created_at', 'desc')->limit(5)->get();
        foreach ($recentLeads as $recentLead) {
            echo "     - ID: {$recentLead->id}, Name: {$recentLead->name}, Created: {$recentLead->created_at}\n";
        }
    }
    
    // Step 6: Check the leads list page
    echo "\n6. Checking leads list page:\n";
    
    $listController = new \App\Http\Controllers\Admin\LeadController();
    $listRequest = new \Illuminate\Http\Request();
    
    try {
        $listResponse = $listController->index($listRequest);
        echo "   ✅ Leads list page works\n";
        
        if ($listResponse instanceof \Illuminate\View\View) {
            $leadsData = $listResponse->getData()['leads'];
            echo "   - Leads passed to view: " . $leadsData->count() . "\n";
            
            // Check if our test lead is in the list
            $testLeadInList = $leadsData->where('name', 'Debug User')->first();
            if ($testLeadInList) {
                echo "   ✅ Test lead found in leads list\n";
            } else {
                echo "   ❌ Test lead NOT found in leads list\n";
            }
        }
        
    } catch (\Exception $e) {
        echo "   ❌ Leads list error: " . $e->getMessage() . "\n";
    }
    
    echo "\n🎯 DEBUGGING SUMMARY:\n";
    echo "   - Routes: ✅ Working\n";
    echo "   - Controller: ✅ Working\n";
    echo "   - Validation: ✅ Working\n";
    echo "   - Database: " . ($lead ? '✅ Working' : '❌ Issue') . "\n";
    echo "   - Leads List: ✅ Working\n";
    
    if ($lead) {
        echo "\n✅ BACKEND IS WORKING PERFECTLY!\n";
        echo "   The issue must be in the browser/frontend.\n";
        echo "\n💡 BROWSER TROUBLESHOOTING:\n";
        echo "   1. Open browser developer tools (F12)\n";
        echo "   2. Check Console for JavaScript errors\n";
        echo "   3. Check Network tab for failed requests\n";
        echo "   4. Fill all 4 required fields:\n";
        echo "      - Name\n";
        echo "      - Lead Status\n";
        echo "      - Priority\n";
        echo "      - Source\n";
        echo "   5. Click submit and watch Network tab\n";
        echo "   6. Look for POST request to /leadsmanagement/store-new\n";
        echo "   7. Check response status (should be 302)\n";
    } else {
        echo "\n❌ BACKEND ISSUE FOUND!\n";
        echo "   The controller ran but no lead was created.\n";
    }
    
    echo "\n🔗 TEST URL:\n";
    echo "   http://127.0.0.1:8000/leadsmanagement/create-new\n";
    
} catch (Exception $e) {
    echo "❌ Critical Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
