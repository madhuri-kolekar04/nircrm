<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-dashboard', function() {
    try {
        // Get a test user
        $user = \App\Models\User::first();
        
        if (!$user) {
            return "No users found in database";
        }
        
        // Simulate authentication
        auth()->login($user);
        
        // Test the dashboard controller
        $controller = new \App\Http\Controllers\AttendanceController();
        $response = $controller->dashboard();
        
        return "Dashboard controller executed successfully. Response type: " . get_class($response);
        
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage() . "\n\nStack trace:\n" . $e->getTraceAsString();
    }
});
