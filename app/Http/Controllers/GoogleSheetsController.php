<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetsServicePublic;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GoogleSheetsController extends Controller
{
    protected $googleSheetsService;

    public function __construct(GoogleSheetsServicePublic $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }

    /**
     * Display the Google Sheets integration dashboard
     */
    public function index()
    {
        try {
            $lastSync = $this->googleSheetsService->getLastSyncTimestamp();
            $connectionTest = $this->googleSheetsService->testConnection();
            
            return view('google-sheets.index', compact('lastSync', 'connectionTest'));
        } catch (\Exception $e) {
            Log::error('Google Sheets Dashboard Error: ' . $e->getMessage());
            return view('google-sheets.index', [
                'lastSync' => null,
                'connectionTest' => ['success' => false, 'message' => $e->getMessage()]
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
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Connection test failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Preview data from Google Sheets before importing
     */
    public function preview()
    {
        try {
            $data = $this->googleSheetsService->getMappedData();
            $preview = array_slice($data, 0, 10); // Show first 10 rows
            
            return response()->json([
                'success' => true,
                'data' => $preview,
                'total_rows' => count($data)
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
     * Import all data from Google Sheets
     */
    public function import(Request $request)
    {
        try {
            $data = $this->googleSheetsService->getMappedData();
            
            if (empty($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data found in Google Sheets'
                ]);
            }

            $importedCount = 0;
            $skippedCount = 0;
            $errors = [];

            // Get default user ID for created_by
            $defaultUser = User::first();
            $createdById = auth()->id() ?: ($defaultUser ? $defaultUser->id : 1);

            foreach ($data as $rowIndex => $rowData) {
                try {
                    // Map the row data to lead fields
                    $leadData = $this->googleSheetsService->mapToLeadFields($rowData);
                    
                    // Skip if no name is provided
                    if (empty($leadData['name'])) {
                        $skippedCount++;
                        continue;
                    }

                    // Check if lead already exists
                    $existingLead = $this->googleSheetsService->checkLeadExists($leadData);
                    if ($existingLead) {
                        $skippedCount++;
                        continue;
                    }

                    // Set default values and additional fields
                    $leadData['source'] = 'google_sheets';
                    $leadData['created_by'] = $createdById;
                    $leadData['lead_status'] = $leadData['lead_status'] ?? 'cold';
                    $leadData['priority'] = $leadData['priority'] ?? 'medium';

                    // Create the lead
                    Lead::create($leadData);
                    $importedCount++;

                } catch (\Exception $e) {
                    $errors[] = "Row " . ($rowIndex + 2) . ": " . $e->getMessage();
                    Log::error("Error importing row " . ($rowIndex + 2) . ": " . $e->getMessage());
                }
            }

            // Update last sync timestamp
            $this->googleSheetsService->updateLastSyncTimestamp();

            $message = "Successfully imported {$importedCount} leads!";
            if ($skippedCount > 0) {
                $message .= " Skipped {$skippedCount} duplicates or empty rows.";
            }
            if (!empty($errors)) {
                $message .= " Some errors occurred: " . implode(', ', array_slice($errors, 0, 3));
                if (count($errors) > 3) {
                    $message .= " and " . (count($errors) - 3) . " more errors.";
                }
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'imported_count' => $importedCount,
                'skipped_count' => $skippedCount,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            Log::error('Import failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sync only new/updated data from Google Sheets
     */
    public function sync(Request $request)
    {
        try {
            $data = $this->googleSheetsService->getMappedData();
            $lastSync = $this->googleSheetsService->getLastSyncTimestamp();
            
            if (empty($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data found in Google Sheets'
                ]);
            }

            $importedCount = 0;
            $updatedCount = 0;
            $skippedCount = 0;
            $errors = [];

            // Get default user ID for created_by
            $defaultUser = User::first();
            $createdById = auth()->id() ?: ($defaultUser ? $defaultUser->id : 1);

            foreach ($data as $rowIndex => $rowData) {
                try {
                    // Map the row data to lead fields
                    $leadData = $this->googleSheetsService->mapToLeadFields($rowData);
                    
                    // Skip if no name is provided
                    if (empty($leadData['name'])) {
                        $skippedCount++;
                        continue;
                    }

                    // Check if lead already exists
                    $existingLead = $this->googleSheetsService->checkLeadExists($leadData);
                    
                    if ($existingLead) {
                        // Update existing lead
                        $existingLead->update($leadData);
                        $updatedCount++;
                    } else {
                        // Create new lead
                        $leadData['source'] = 'google_sheets';
                        $leadData['created_by'] = $createdById;
                        $leadData['lead_status'] = $leadData['lead_status'] ?? 'cold';
                        $leadData['priority'] = $leadData['priority'] ?? 'medium';

                        Lead::create($leadData);
                        $importedCount++;
                    }

                } catch (\Exception $e) {
                    $errors[] = "Row " . ($rowIndex + 2) . ": " . $e->getMessage();
                    Log::error("Error syncing row " . ($rowIndex + 2) . ": " . $e->getMessage());
                }
            }

            // Update last sync timestamp
            $this->googleSheetsService->updateLastSyncTimestamp();

            $message = "Sync completed!";
            if ($importedCount > 0) {
                $message .= " Imported {$importedCount} new leads.";
            }
            if ($updatedCount > 0) {
                $message .= " Updated {$updatedCount} existing leads.";
            }
            if ($skippedCount > 0) {
                $message .= " Skipped {$skippedCount} empty rows.";
            }
            if (!empty($errors)) {
                $message .= " Some errors occurred: " . implode(', ', array_slice($errors, 0, 3));
                if (count($errors) > 3) {
                    $message .= " and " . (count($errors) - 3) . " more errors.";
                }
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'imported_count' => $importedCount,
                'updated_count' => $updatedCount,
                'skipped_count' => $skippedCount,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            Log::error('Sync failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the configuration form
     */
    public function configuration()
    {
        return view('google-sheets.configuration');
    }

    /**
     * Update Google Sheets configuration
     */
    public function updateConfiguration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'spreadsheet_id' => 'required|string',
            'service_account_file' => 'required|string',
            'auto_sync_enabled' => 'boolean',
            'sync_frequency' => 'required|in:hourly,daily,weekly'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Update configuration in .env file or database
            // This is a simplified version - you might want to store this in the database
            
            // Test the connection with new configuration
            $result = $this->googleSheetsService->testConnection();
            
            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Connection test failed with new configuration: ' . $result['message']
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'Configuration updated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Configuration update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update configuration: ' . $e->getMessage()
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

            return response()->json([
                'success' => true,
                'data' => [
                    'last_sync' => $lastSync,
                    'total_leads_from_sheets' => $totalLeads,
                    'recent_leads' => $recentLeads,
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
}
