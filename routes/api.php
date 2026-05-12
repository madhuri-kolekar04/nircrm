<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RecordingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes for Android App
Route::get('/get-recording-count', function (Request $request) {
    $totalRows = DB::table('call_recordings')->count();
    
    // Safety check: Get latest row or null
    $latest = DB::table('call_recordings')->orderBy('id', 'desc')->first();

    return response()->json([
        'count' => (int)$totalRows,
        'status' => 'success',
        // Fixed: Added null checks to prevent 500 errors if table is empty
        'last_employee' => $latest ? $latest->employee_name : 'Team',
        'latest_name'   => $latest ? $latest->customer_name : 'New Entry',
        'latest_phone'  => $latest ? $latest->customer_phone : '',
    ]);
});

Route::post('/sync-recording', [RecordingController::class, 'sync']);
