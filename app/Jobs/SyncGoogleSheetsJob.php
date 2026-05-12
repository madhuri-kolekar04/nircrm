<?php

namespace App\Jobs;

use App\Services\GoogleSheetsServicePublic;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncGoogleSheetsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $retryAfter = 60;

    /**
     * Execute the job.
     */
    public function handle(GoogleSheetsServicePublic $googleSheetsService)
    {
        try {
            Log::info('Starting Google Sheets sync job');
            
            $data = $googleSheetsService->getMappedData();
            
            if (empty($data)) {
                Log::info('No data found in Google Sheets');
                return;
            }

            $importedCount = 0;
            $updatedCount = 0;
            $skippedCount = 0;

            // Get default user ID for created_by
            $defaultUser = User::first();
            $createdById = $defaultUser ? $defaultUser->id : 1;

            foreach ($data as $rowIndex => $rowData) {
                try {
                    // Map the row data to lead fields
                    $leadData = $googleSheetsService->mapToLeadFields($rowData);
                    
                    // Skip if no name is provided
                    if (empty($leadData['name'])) {
                        $skippedCount++;
                        continue;
                    }

                    // Check if lead already exists
                    $existingLead = $googleSheetsService->checkLeadExists($leadData);
                    
                    if ($existingLead) {
                        // Update existing lead only if there are meaningful changes
                        $hasChanges = false;
                        foreach ($leadData as $field => $value) {
                            if ($value !== null && $existingLead->$field !== $value) {
                                $hasChanges = true;
                                break;
                            }
                        }

                        if ($hasChanges) {
                            $existingLead->update($leadData);
                            $updatedCount++;
                            Log::info("Updated lead: {$existingLead->name}");
                        }
                    } else {
                        // Create new lead
                        $leadData['source'] = 'google_sheets';
                        $leadData['created_by'] = $createdById;
                        $leadData['lead_status'] = $leadData['lead_status'] ?? 'cold';
                        $leadData['priority'] = $leadData['priority'] ?? 'medium';

                        Lead::create($leadData);
                        $importedCount++;
                        Log::info("Imported new lead: {$leadData['name']}");
                    }

                } catch (\Exception $e) {
                    Log::error("Error processing row " . ($rowIndex + 2) . ": " . $e->getMessage());
                }
            }

            // Update last sync timestamp
            $googleSheetsService->updateLastSyncTimestamp();

            Log::info("Google Sheets sync completed: {$importedCount} imported, {$updatedCount} updated, {$skippedCount} skipped");

        } catch (\Exception $e) {
            Log::error('Google Sheets sync job failed: ' . $e->getMessage());
            $this->fail($e);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::error('Google Sheets sync job failed permanently: ' . $exception->getMessage());
    }
}
