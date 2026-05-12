<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AccountController;
use App\Models\Lead;

/*
|--------------------------------------------------------------------------
| Test Routes
|--------------------------------------------------------------------------
*/

// Test route for email functionality
Route::get('/test-customer-panel-email/{leadId}', function($leadId) {
    $lead = Lead::find($leadId);
    
    if (!$lead) {
        return response()->json(['error' => 'Lead not found'], 404);
    }
    
    $accountController = new AccountController();
    
    // Test enable email
    try {
        $accountController->sendLeadCustomerPanelEnabledEmail($lead);
        return response()->json([
            'success' => true,
            'message' => 'Customer panel enabled email sent successfully to: ' . $lead->email
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
})->name('test.customer-panel-email');

// Test disable email
Route::get('/test-customer-panel-disabled-email/{leadId}', function($leadId) {
    $lead = Lead::find($leadId);
    
    if (!$lead) {
        return response()->json(['error' => 'Lead not found'], 404);
    }
    
    $accountController = new AccountController();
    
    // Test disable email
    try {
        $accountController->sendLeadCustomerPanelDisabledEmail($lead);
        return response()->json([
            'success' => true,
            'message' => 'Customer panel disabled email sent successfully to: ' . $lead->email
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
})->name('test.customer-panel-disabled-email');
