<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetsApiService;
use App\Jobs\GoogleSheetsSyncJob;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GoogleSheetsApiController extends Controller
{
    protected $googleSheetsService;

    public function __construct(GoogleSheetsApiService $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }

    /**
     * Display the Google Sheets management dashboard
     */
    public function index()
    {
        try {
            $lastSync = $this->googleSheetsService->getLastSyncTimestamp();
            $connectionTest = $this->googleSheetsService->testConnection();
            $metadata = $this->googleSheetsService->getSpreadsheetMetadata();
            $autoSyncConfig = config('google-sheets.auto_sync');
            
            // Get statistics
            $totalLeads = Lead::where('source', 'google_sheets')->count();
            $recentLeads = Lead::where('source', 'google_sheets')
                              ->where('created_at', '>=', now()->subDays(7))
                              ->count();
            
            return view('google-sheets.index', compact(
                'lastSync', 
                'connectionTest', 
                'metadata', 
                'autoSyncConfig',
                'totalLeads',
                'recentLeads'
            ));
        } catch (\Exception $e) {
            Log::error('Google Sheets Dashboard Error: ' . $e->getMessage());
            return view('google-sheets.index', [
                'lastSync' => null,
                'connectionTest' => ['oauth' => ['success' => false, 'message' => $e->getMessage()]],
                'metadata' => null,
                'autoSyncConfig' => config('google-sheets.auto_sync'),
                'totalLeads' => 0,
                'recentLeads' => 0
            ]);
        }
    }

    /**
     * Test connection to Google Sheets
     */
    public function testConnection()
    {
        try {
            $result = $this->googleSheetsService->testConnection();
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('Connection test failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get spreadsheet metadata
     */
    public function getMetadata()
    {
        try {
            $metadata = $this->googleSheetsService->getSpreadsheetMetadata();
            return response()->json([
                'success' => true,
                'data' => $metadata
            ]);
        } catch (\Exception $e) {
            Log::error('Metadata fetch failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch metadata: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Preview data from Google Sheets
     */
    public function preview(Request $request)
    {
        try {
            $limit = $request->get('limit', 10);
            $sheet = $request->get('sheet', 'Sheet1');
            $range = $request->get('range', $sheet . '!A:Z');
            
            $data = $this->googleSheetsService->getSpreadsheetData($range);
            
            if (empty($data) || count($data) < 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data found in Google Sheets'
                ]);
            }

            $headers = array_shift($data);
            $preview = array_slice($data, 0, $limit);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'headers' => $headers,
                    'rows' => $preview,
                    'total_rows' => count($data)
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Preview failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to preview data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get incremental data (new/updated since last sync)
     */
    public function getIncrementalData(Request $request)
    {
        try {
            $lastSync = $this->googleSheetsService->getLastSyncTimestamp();
            $dateColumn = config('google-sheets.date_column', 'SUBMITTED AT');
            
            $data = $this->googleSheetsService->getIncrementalData($lastSync, $dateColumn);
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'last_sync' => $lastSync,
                'count' => count($data)
            ]);
        } catch (\Exception $e) {
            Log::error('Incremental data fetch failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch incremental data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Manual sync trigger
     */
    public function sync(Request $request)
    {
        try {
            $syncType = $request->get('type', 'incremental');
            $forceSync = $request->get('force', false);
            
            // Validate sync type
            if (!in_array($syncType, ['full', 'incremental'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid sync type. Must be "full" or "incremental".'
                ], 422);
            }

            // Dispatch sync job
            GoogleSheetsSyncJob::dispatch($syncType, $forceSync);
            
            return response()->json([
                'success' => true,
                'message' => ucfirst($syncType) . ' sync job has been dispatched successfully!',
                'sync_type' => $syncType,
                'force' => $forceSync
            ]);
        } catch (\Exception $e) {
            Log::error('Manual sync failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to start sync: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get sync statistics
     */
    public function statistics()
    {
        try {
            $lastSync = $this->googleSheetsService->getLastSyncTimestamp();
            $totalLeads = Lead::where('source', 'google_sheets')->count();
            $recentLeads = Lead::where('source', 'google_sheets')
                              ->where('created_at', '>=', now()->subDays(7))
                              ->count();
            
            // Get incremental data count
            $dateColumn = config('google-sheets.date_column', 'SUBMITTED AT');
            $incrementalData = $this->googleSheetsService->getIncrementalData($lastSync, $dateColumn);
            $newRecordsCount = count($incrementalData);

            return response()->json([
                'success' => true,
                'data' => [
                    'last_sync' => $lastSync,
                    'total_leads_from_sheets' => $totalLeads,
                    'recent_leads' => $recentLeads,
                    'new_records_since_last_sync' => $newRecordsCount,
                    'auto_sync_enabled' => config('google-sheets.auto_sync.enabled'),
                    'sync_frequency' => config('google-sheets.auto_sync.frequency'),
                    'connection_status' => $this->googleSheetsService->testConnection()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Statistics failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update auto-sync configuration
     */
    public function updateAutoSyncConfig(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enabled' => 'boolean',
            'frequency' => 'required_if:enabled,true|in:hourly,daily,weekly',
            'timezone' => 'required_if:enabled,true|string',
            'time_of_day' => 'required_if:enabled,true|date_format:H:i'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // This would typically update the .env file or a database table
            // For now, we'll just return success (you'll need to implement the actual update)
            
            return response()->json([
                'success' => true,
                'message' => 'Auto-sync configuration updated successfully',
                'config' => $request->all()
            ]);

        } catch (\Exception $e) {
            Log::error('Auto-sync config update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update configuration: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export Google Sheets data to Excel
     */
    public function exportToExcel(Request $request)
    {
        try {
            $syncType = $request->get('sync_type', 'incremental');
            $dateColumn = config('google-sheets.date_column', 'SUBMITTED AT');
            
            if ($syncType === 'incremental') {
                $lastSync = $this->googleSheetsService->getLastSyncTimestamp();
                $data = $this->googleSheetsService->getIncrementalData($lastSync, $dateColumn);
            } else {
                $range = $request->get('range', 'Sheet1!A:Z');
                $rawData = $this->googleSheetsService->getSpreadsheetData($range);
                $headers = array_shift($rawData);
                $data = [];
                
                foreach ($rawData as $row) {
                    $rowData = [];
                    foreach ($headers as $index => $header) {
                        $header = trim($header);
                        $value = isset($row[$index]) ? $row[$index] : '';
                        $rowData[$header] = $value;
                    }
                    if (!empty(array_filter($rowData))) {
                        $data[] = $rowData;
                    }
                }
            }

            if (empty($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data available to export'
                ]);
            }

            // Convert to CSV format for Excel compatibility
            $filename = 'google_sheets_export_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = array_keys($data[0]);
            $csvContent = implode(',', $headers) . "\n";
            
            foreach ($data as $row) {
                $csvRow = [];
                foreach ($headers as $header) {
                    $value = $row[$header] ?? '';
                    // Escape commas and quotes in CSV
                    if (strpos($value, ',') !== false || strpos($value, '"') !== false) {
                        $value = '"' . str_replace('"', '""', $value) . '"';
                    }
                    $csvRow[] = $value;
                }
                $csvContent .= implode(',', $csvRow) . "\n";
            }

            return response($csvContent)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        } catch (\Exception $e) {
            Log::error('Export failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get real-time data (for dashboard updates)
     */
    public function getRealTimeData(Request $request)
    {
        try {
            $lastSync = $this->googleSheetsService->getLastSyncTimestamp();
            $dateColumn = config('google-sheets.date_column', 'SUBMITTED AT');
            
            // Get incremental data count
            $incrementalData = $this->googleSheetsService->getIncrementalData($lastSync, $dateColumn);
            $newRecordsCount = count($incrementalData);
            
            // Get recent leads from database
            $recentLeads = Lead::where('source', 'google_sheets')
                              ->where('created_at', '>=', now()->subHours(24))
                              ->orderBy('created_at', 'desc')
                              ->take(5)
                              ->get(['name', 'email', 'company_name', 'created_at']);

            return response()->json([
                'success' => true,
                'data' => [
                    'new_records_count' => $newRecordsCount,
                    'last_sync' => $lastSync,
                    'recent_leads' => $recentLeads,
                    'auto_sync_enabled' => config('google-sheets.auto_sync.enabled'),
                    'timestamp' => now()->toISOString()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Real-time data fetch failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch real-time data: ' . $e->getMessage()
            ], 500);
        }
    }
}
