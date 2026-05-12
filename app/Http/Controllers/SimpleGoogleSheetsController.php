<?php

namespace App\Http\Controllers;

use App\Services\SimpleGoogleSheetsService;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SimpleGoogleSheetsController extends Controller
{
    protected $googleSheetsService;

    public function __construct(SimpleGoogleSheetsService $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }

    /**
     * Display Google Sheets data
     */
    public function index()
    {
        try {
            $data = $this->googleSheetsService->getFormattedData();
            $headers = $this->googleSheetsService->getHeaders();
            $connectionTest = $this->googleSheetsService->testConnection();
            
            return view('googlesheet.index', compact('data', 'headers', 'connectionTest'));
        } catch (\Exception $e) {
            Log::error('Google Sheets Dashboard Error: ' . $e->getMessage());
            return view('googlesheet.index', [
                'data' => [],
                'headers' => [],
                'connectionTest' => ['success' => false, 'message' => $e->getMessage()]
            ]);
        }
    }

    /**
     * Sync data to database
     */
    public function sync(Request $request)
    {
        try {
            $data = $this->googleSheetsService->getFormattedData();
            $imported = 0;
            $skipped = 0;

            foreach ($data as $row) {
                // Check if lead already exists
                $exists = Lead::where('email', $row['EMAIL'] ?? '')
                              ->orWhere('phone', $row['WHATSAPP'] ?? '')
                              ->orWhere('name', $row['FULL NAME'] ?? '')
                              ->first();

                if (!$exists && !empty($row['FULL NAME'])) {
                    Lead::create([
                        'name' => $row['FULL NAME'] ?? '',
                        'company_name' => $row['BUSINESS NAME'] ?? '',
                        'email' => $row['EMAIL'] ?? '',
                        'phone' => $row['WHATSAPP'] ?? '',
                        'website' => $row['WEBSITE URL'] ?? '',
                        'business_type' => $row['BUSINESS TYPE'] ?? '',
                        'primary_goal' => $row['PRIMARY GOAL'] ?? '',
                        'budget' => $this->parseBudget($row['BUDGET RANGE'] ?? ''),
                        'score' => $row['SCORE'] ?? '',
                        'tier' => $row['TIER'] ?? '',
                        'source' => 'google_sheets',
                        'lead_status' => 'cold',
                        'priority' => 'medium'
                    ]);
                    $imported++;
                } else {
                    $skipped++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Imported {$imported} new leads. Skipped {$skipped} duplicates.",
                'imported' => $imported,
                'skipped' => $skipped
            ]);

        } catch (\Exception $e) {
            Log::error('Sync Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get new entries API endpoint
     */
    public function getNewEntries(Request $request)
    {
        try {
            $lastFetch = $request->get('last_fetch');
            $lastFetchDate = $lastFetch ? \Carbon\Carbon::parse($lastFetch) : null;
            
            $newEntries = $this->googleSheetsService->getNewEntries($lastFetchDate);
            
            return response()->json([
                'success' => true,
                'data' => $newEntries,
                'count' => count($newEntries),
                'last_fetch' => now()->toISOString()
            ]);

        } catch (\Exception $e) {
            Log::error('Get New Entries Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get new entries: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test connection API
     */
    public function testConnection()
    {
        try {
            $result = $this->googleSheetsService->testConnection();
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get column data API
     */
    public function getColumnData(Request $request)
    {
        try {
            $columns = $request->get('columns', ['FULL NAME', 'EMAIL', 'BUSINESS NAME']);
            $data = $this->googleSheetsService->getColumnData($columns);
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'count' => count($data)
            ]);

        } catch (\Exception $e) {
            Log::error('Get Column Data Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get column data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export to Excel
     */
    public function export()
    {
        try {
            $data = $this->googleSheetsService->getFormattedData();
            
            if (empty($data)) {
                return response()->json(['success' => false, 'message' => 'No data to export']);
            }

            $filename = 'google_sheets_export_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = array_keys($data[0]);
            $csvContent = implode(',', $headers) . "\n";
            
            foreach ($data as $row) {
                $csvRow = [];
                foreach ($headers as $header) {
                    $value = $row[$header] ?? '';
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
            Log::error('Export Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Export failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Parse budget value
     */
    private function parseBudget($budgetString)
    {
        if (empty($budgetString)) {
            return null;
        }

        // Extract numbers from budget string
        $numbers = preg_replace('/[^0-9.]/', '', $budgetString);
        return is_numeric($numbers) ? (float) $numbers : null;
    }
}
