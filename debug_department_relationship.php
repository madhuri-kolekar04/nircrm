<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging Department Relationship...\n";

try {
    // Step 1: Find a lead with department_id
    echo "1. Finding lead with department_id:\n";
    
    $testLead = \App\Models\Lead::whereNotNull('department_id')
        ->first();
    
    if ($testLead) {
        echo "   ✅ Found test lead: ID={$testLead->id}\n";
        echo "   - Name: {$testLead->name}\n";
        echo "   - Department ID: {$testLead->department_id}\n";
        
        // Step 2: Check the Lead model relationship
        echo "\n2. Checking Lead model relationships:\n";
        
        $leadModel = new \App\Models\Lead();
        
        // Check if department relationship exists
        if (method_exists($leadModel, 'department')) {
            echo "   ✅ Department relationship method exists\n";
        } else {
            echo "   ❌ Department relationship method missing\n";
        }
        
        // Check the actual relationship definition
        $reflection = new \ReflectionClass($leadModel);
        $methods = $reflection->getMethods();
        
        foreach ($methods as $method) {
            if ($method->getName() === 'department') {
                echo "   ✅ Department method found: " . $method->getName() . "\n";
                echo "   - Return type: " . $method->getReturnType()->getName() . "\n";
                echo "   - Parameters: " . implode(', ', array_map(function($p) { return $p->getName(); }, $method->getParameters())) . "\n";
                break;
            }
        }
        
        // Step 3: Test the show method
        echo "\n3. Testing show method:\n";
        
        $controller = new \App\Http\Controllers\Admin\LeadController();
        $response = $controller->show($testLead->id);
        
        if ($response instanceof \Illuminate\View\View) {
            echo "   ✅ Show method executed\n";
            
            $data = $response->getData();
            if (isset($data['lead'])) {
                $leadData = $data['lead'];
                echo "   - Lead data in view:\n";
                echo "     * Name: {$leadData->name}\n";
                echo "     * Department ID: " . ($leadData->department_id ?: 'NULL') . "\n";
                
                // Check if department relationship is loaded
                if (isset($leadData->department)) {
                    echo "     * Department relationship loaded: Yes\n";
                    echo "     * Department type: " . gettype($leadData->department) . "\n";
                    echo "     * Department value: ";
                    if (is_object($leadData->department)) {
                        echo "'{$leadData->department->department}'\n";
                    } else {
                        echo "'" . $leadData->department . "'\n";
                    }
                    echo "\n";
                } else {
                    echo "     * Department relationship: Not loaded\n";
                }
                
                echo "     * Budget: " . ($leadData->budget ?: 'NULL') . "\n";
            }
        }
        
        // Step 4: Check the database directly
        echo "\n4. Checking database directly:\n";
        
        $leadFromDb = \App\Models\Lead::find($testLead->id);
        
        if ($leadFromDb) {
            echo "   ✅ Lead from database: ID={$leadFromDb->id}\n";
            echo "   - Department ID: " . ($leadFromDb->department_id ?: 'NULL') . "\n";
            
            // Try to load the relationship
            $leadFromDb->load(['department']);
            
            echo "   - After load():\n";
            echo "     * Department ID: " . ($leadFromDb->department_id ?: 'NULL') . "\n";
            
            if (isset($leadFromDb->department)) {
                echo "     * Department relationship: Loaded\n";
                if (is_object($leadFromDb->department)) {
                    echo "     * Department Name: '{$leadFromDb->department->department}'\n";
                } else {
                    echo "     * Department Value: '{$leadFromDb->department}'\n";
                }
            } else {
                echo "     * Department relationship: Still not loaded\n";
            }
        }
        
    } else {
        echo "   ❌ No test lead found\n";
    }
    
    echo "\n🎯 DEPARTMENT RELATIONSHIP ANALYSIS:\n";
    echo "   - Issue: Department relationship not loading in show method\n";
    echo "   - Fix needed: Check Lead model relationship definition\n";
    echo "   - Fix needed: Ensure load() works correctly\n";
    
    echo "\n💡 POSSIBLE CAUSES:\n";
    echo "   1. Relationship not defined in Lead model\n";
    echo "   2. Foreign key constraint issue\n";
    echo "   3. Department model missing relationship method\n";
    echo "   4. Load() method not working properly\n";
    
    echo "\n🔗 NEXT STEPS:\n";
    echo "   1. Check Lead model for department relationship\n";
    echo "   2. Fix relationship definition if needed\n";
    echo "   3. Ensure load() works in show method\n";
    echo "   4. Test view page displays department correctly\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
