<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Services\GoogleSheetsApiService;
use App\Models\Lead;
use App\Models\User;

class GoogleSheetsSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [60, 300, 900]; // 1min, 5min, 15min

    protected $syncType;
    protected $forceSync;

    /**
     * Create a new job instance.
     *
     * @param string $syncType (full, incremental)
     * @param bool $forceSync
     */
    public function __construct($syncType = 'incremental', $forceSync = false)
    {
        $this->syncType = $syncType;
        $this->forceSync = $forceSync;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GoogleSheetsApiService $googleSheetsService)
    {
        try {
            Log::info("Starting Google Sheets sync job: {$this->syncType}");

            $lastSync = $this->forceSync ? null : $googleSheetsService->getLastSyncTimestamp();
            $dateColumn = config('google-sheets.date_column', 'SUBMITTED AT');

            // Get data based on sync type
            if ($this->syncType === 'full' || $this->forceSync) {
                $data = $googleSheetsService->getSpreadsheetData();
                $data = $this->formatDataWithHeaders($data);
            } else {
                $data = $googleSheetsService->getIncrementalData($lastSync, $dateColumn);
            }

            if (empty($data)) {
                Log::info('No new data found in Google Sheets');
                return;
            }

            $importedCount = 0;
            $updatedCount = 0;
            $skippedCount = 0;
            $errors = [];

            // Get default user ID for created_by
            $defaultUser = User::first();
            $createdById = $defaultUser ? $defaultUser->id : 1;

            foreach ($data as $rowIndex => $rowData) {
                try {
                    // Map the row data to lead fields
                    $leadData = $this->mapToLeadFields($rowData);
                    
                    // Skip if no name is provided
                    if (empty($leadData['name'])) {
                        $skippedCount++;
                        continue;
                    }

                    // Check if lead already exists
                    $existingLead = $this->checkLeadExists($leadData);
                    
                    if ($existingLead) {
                        // Update existing lead if it's an incremental sync
                        if ($this->syncType === 'incremental') {
                            $existingLead->update($leadData);
                            $updatedCount++;
                        } else {
                            $skippedCount++;
                        }
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
            $googleSheetsService->updateLastSyncTimestamp();

            // Log results
            $message = "Google Sheets sync completed successfully!";
            if ($importedCount > 0) {
                $message .= " Imported {$importedCount} new leads.";
            }
            if ($updatedCount > 0) {
                $message .= " Updated {$updatedCount} existing leads.";
            }
            if ($skippedCount > 0) {
                $message .= " Skipped {$skippedCount} duplicates or empty rows.";
            }
            if (!empty($errors)) {
                $message .= " Errors: " . implode(', ', array_slice($errors, 0, 3));
                if (count($errors) > 3) {
                    $message .= " and " . (count($errors) - 3) . " more.";
                }
            }

            Log::info($message);

            // Dispatch notification if needed
            if ($importedCount > 0 || $updatedCount > 0) {
                $this->notifySyncResults($importedCount, $updatedCount, $skippedCount, $errors);
            }

        } catch (\Exception $e) {
            Log::error('Google Sheets sync job failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * The job failed to process.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {
        Log::error('Google Sheets sync job failed permanently: ' . $exception->getMessage());
        
        // Send notification to admin about the failure
        // You can implement email notification here
    }

    /**
     * Map Google Sheets columns to database fields
     */
    private function mapToLeadFields($rowData)
    {
        $fieldMapping = config('google-sheets.field_mapping', []);
        $leadData = [];

        foreach ($fieldMapping as $sheetColumn => $dbField) {
            $value = null;
            
            // Find the value in the row data
            foreach ($rowData as $column => $columnValue) {
                // Handle case-insensitive matching and partial matching
                if (strtolower($column) === strtolower($sheetColumn) || 
                    strpos(strtolower($column), strtolower($sheetColumn)) !== false) {
                    $value = $columnValue;
                    break;
                }
            }

            $leadData[$dbField] = $this->sanitizeFieldValue($value, $dbField);
        }

        return $leadData;
    }

    /**
     * Sanitize and format field values
     */
    private function sanitizeFieldValue($value, $field)
    {
        if (empty($value)) {
            return null;
        }

        $value = trim($value);
        
        switch ($field) {
            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : null;
            
            case 'phone':
                return preg_replace('/[^0-9+\s]/', '', $value);
            
            case 'website':
                if (!empty($value) && !preg_match('/^https?:\/\//', $value)) {
                    $value = 'https://' . $value;
                }
                return filter_var($value, FILTER_VALIDATE_URL) ? $value : null;
            
            case 'budget':
                $budget = preg_replace('/[^0-9.]/', '', $value);
                return is_numeric($budget) ? (float) $budget : null;
            
            case 'submitted_at':
                try {
                    return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    return null;
                }
            
            default:
                return $value;
        }
    }

    /**
     * Check if a lead already exists based on email and phone
     */
    private function checkLeadExists($leadData)
    {
        $query = Lead::query();
        
        if (!empty($leadData['email'])) {
            $query->orWhere('email', $leadData['email']);
        }
        
        if (!empty($leadData['phone'])) {
            $query->orWhere('phone', $leadData['phone']);
        }
        
        if (!empty($leadData['name'])) {
            $query->orWhere('name', $leadData['name']);
        }
        
        return $query->first();
    }

    /**
     * Format data with headers
     */
    private function formatDataWithHeaders($data)
    {
        if (empty($data) || count($data) < 2) {
            return [];
        }

        $headers = array_shift($data);
        $formattedData = [];

        foreach ($data as $row) {
            $rowData = [];
            foreach ($headers as $index => $header) {
                $header = trim($header);
                $value = isset($row[$index]) ? $row[$index] : '';
                $rowData[$header] = $value;
            }
            
            // Only add rows that have at least some data
            if (!empty(array_filter($rowData))) {
                $formattedData[] = $rowData;
            }
        }

        return $formattedData;
    }

    /**
     * Notify about sync results
     */
    private function notifySyncResults($importedCount, $updatedCount, $skippedCount, $errors)
    {
        // You can implement email notification here
        Log::info("Google Sheets sync notification: {$importedCount} imported, {$updatedCount} updated, {$skippedCount} skipped");
    }
}
