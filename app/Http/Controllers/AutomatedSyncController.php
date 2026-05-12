<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetsServicePublic;
use App\Services\LeadNotificationService;
use App\Models\MeetingCallDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AutomatedSyncController extends Controller
{
    protected $googleSheetsService;
    protected $leadNotificationService;

    public function __construct(GoogleSheetsServicePublic $googleSheetsService, LeadNotificationService $leadNotificationService)
    {
        $this->googleSheetsService = $googleSheetsService;
        $this->leadNotificationService = $leadNotificationService;
    }

    /**
     * Automated sync endpoint that can be called by cron job or scheduler
     * This works without any user interaction
     */
    public function autoSync(Request $request)
    {
        try {
            Log::info('Automated sync started at: ' . now());

            // Rate limiting - only sync if at least 2 minutes have passed since last sync
            $lastSyncTime = Cache::get('automated_sync_last_run', now()->subMinutes(10));
            $current_time = now();
            
            if ($current_time->diffInMinutes($lastSyncTime) < 2) {
                Log::info('Automated sync rate limited - skipping');
                return response()->json([
                    'success' => true,
                    'message' => 'Sync skipped due to rate limiting',
                    'last_sync' => $lastSyncTime->format('Y-m-d H:i:s')
                ]);
            }

            // Get all data from Google Sheets
            $data = $this->googleSheetsService->getMappedData();
            
            if (empty($data)) {
                Log::warning('No data found in Google Sheets during automated sync');
                return response()->json([
                    'success' => false,
                    'message' => 'No data found in Google Sheets'
                ]);
            }

            $importedCount = 0;
            $updatedCount = 0;
            $skippedCount = 0;
            $newLeadsNotified = 0;

            // Get default user ID for created_by
            $defaultUser = \App\Models\User::first();
            $createdById = $defaultUser ? $defaultUser->id : 1;

            // Process each row
            foreach ($data as $rowIndex => $rowData) {
                try {
                    // Map row data to lead fields
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
                        
                        $newLead = \App\Models\Lead::create($leadData);
                        $importedCount++;
                        
                        // Send email notification to all employees for new lead
                        try {
                            $notificationData = [
                                'full_name' => $leadData['name'],
                                'business_name' => $leadData['business_name'] ?? '',
                                'email' => $leadData['email'],
                                'whatsapp' => $leadData['whatsapp'],
                                'website_url' => $leadData['website_url'] ?? '',
                                'submitted_at' => now()->format('M d, Y H:i A')
                            ];
                            
                            $result = $this->leadNotificationService->sendNewLeadNotification($notificationData);
                            
                            if ($result['success'] && $result['sent'] > 0) {
                                $newLeadsNotified++;
                                Log::info('Automated notification sent for new lead', [
                                    'lead_name' => $leadData['name'],
                                    'lead_id' => $newLead->id,
                                    'sent_to' => $result['sent']
                                ]);
                            }
                            
                        } catch (\Exception $notificationError) {
                            Log::error('Failed to send automated notification', [
                                'lead_name' => $leadData['name'],
                                'error' => $notificationError->getMessage()
                            ]);
                            // Don't fail the sync if notification fails
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Error processing row during automated sync: ' . $e->getMessage(), [
                        'row_index' => $rowIndex
                    ]);
                }
            }

            // Update last sync timestamp
            $this->googleSheetsService->updateLastSyncTimestamp();
            
            // Update cache for rate limiting
            Cache::put('automated_sync_last_run', now(), now()->addMinutes(10));

            $message = "Automated sync completed successfully!";
            if ($importedCount > 0) {
                $message .= " Imported {$importedCount} new leads.";
            }
            if ($updatedCount > 0) {
                $message .= " Updated {$updatedCount} existing leads.";
            }
            if ($skippedCount > 0) {
                $message .= " Skipped {$skippedCount} empty rows.";
            }
            if ($newLeadsNotified > 0) {
                $message .= " Sent notifications for {$newLeadsNotified} new leads.";
            }

            Log::info('Automated sync completed', [
                'imported' => $importedCount,
                'updated' => $updatedCount,
                'skipped' => $skippedCount,
                'notified' => $newLeadsNotified
            ]);

            return response()->json([
                'success' => true,
                'message' => $message,
                'imported_count' => $importedCount,
                'updated_count' => $updatedCount,
                'skipped_count' => $skippedCount,
                'new_leads_notified' => $newLeadsNotified,
                'timestamp' => now()->toISOString()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Automated sync error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Automated sync failed: ' . $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 500);
        }
    }

    /**
     * Check for new entries and send notifications only
     * This is a lightweight method that doesn't sync data
     */
    public function checkNewEntriesAndNotify(Request $request)
    {
        try {
            Log::info('Checking for new entries for notifications at: ' . now());

            // Rate limiting - only check if at least 1 minute has passed since last check
            $lastCheckTime = Cache::get('notification_check_last_run', now()->subMinutes(5));
            $current_time = now();
            
            if ($current_time->diffInMinutes($lastCheckTime) < 1) {
                Log::info('Notification check rate limited - skipping');
                return response()->json([
                    'success' => true,
                    'message' => 'Notification check skipped due to rate limiting',
                    'last_check' => $lastCheckTime->format('Y-m-d H:i:s')
                ]);
            }

            // Get all data from Google Sheets
            $allData = $this->googleSheetsService->getMappedData();
            
            if (empty($allData)) {
                Log::warning('No data found in Google Sheets during notification check');
                return response()->json([
                    'success' => false,
                    'message' => 'No data found in Google Sheets'
                ]);
            }

            // Reverse data to check newest entries first
            $allData = array_reverse($allData);
            
            $newEntriesFound = 0;
            $notificationsSent = 0;
            $recentEntries = array_slice($allData, 0, 10); // Check last 10 entries

            foreach ($recentEntries as $entry) {
                if (!empty($entry['full_name']) && !empty($entry['email'])) {
                    // Create a unique key for this entry
                    $entryKey = $entry['full_name'] . '|' . $entry['email'];
                    
                    // Check if we've already notified about this entry
                    $notifiedEntries = Cache::get('notified_entries', []);
                    
                    if (!in_array($entryKey, $notifiedEntries)) {
                        // Check if this lead exists in database (to avoid notifying about very old entries)
                        $existingLead = \App\Models\Lead::where('name', $entry['full_name'])
                            ->where('email', $entry['email'])
                            ->first();

                        // Only notify if lead is recent (created in last 24 hours) or doesn't exist yet
                        if (!$existingLead || $existingLead->created_at > now()->subHours(24)) {
                            // This is a new entry - send notification
                            Log::info('New entry found - sending notification', ['entry' => $entryKey]);
                            
                            $notificationData = [
                                'full_name' => $entry['full_name'],
                                'business_name' => $entry['business_name'] ?? '',
                                'company_name' => $entry['business_name'] ?? '',
                                'email' => $entry['email'],
                                'whatsapp' => $entry['whatsapp'] ?? '',
                                'website_url' => $entry['website_url'] ?? '',
                                'submitted_at' => now()->format('M d, Y H:i A')
                            ];
                            
                            try {
                                $result = $this->leadNotificationService->sendNewLeadNotification($notificationData);
                                
                                if ($result['success'] && $result['sent'] > 0) {
                                    // Mark as notified
                                    $notifiedEntries[] = $entryKey;
                                    Cache::put('notified_entries', array_slice($notifiedEntries, -100), now()->addDays(7)); // Keep last 100 for 7 days
                                    
                                    $newEntriesFound++;
                                    $notificationsSent++;
                                    
                                    Log::info('Automatic notification sent for new entry', [
                                        'lead_name' => $entry['full_name'],
                                        'lead_email' => $entry['email'],
                                        'sent_to' => $result['sent']
                                    ]);
                                }
                            } catch (\Exception $e) {
                                Log::error('Failed to send automatic notification', [
                                    'lead_name' => $entry['full_name'],
                                    'error' => $e->getMessage()
                                ]);
                            }
                        } else {
                            // Mark old existing leads as notified to avoid checking them again
                            $notifiedEntries[] = $entryKey;
                            Cache::put('notified_entries', array_slice($notifiedEntries, -100), now()->addDays(7));
                        }
                    }
                }
            }
            
            // Update last check time
            Cache::put('notification_check_last_run', now(), now()->addMinutes(10));

            $message = "Notification check completed!";
            if ($newEntriesFound > 0) {
                $message .= " Found {$newEntriesFound} new entries and sent {$notificationsSent} notifications.";
            } else {
                $message .= " No new entries found.";
            }

            Log::info('Notification check completed', [
                'new_entries_found' => $newEntriesFound,
                'notifications_sent' => $notificationsSent
            ]);

            return response()->json([
                'success' => true,
                'message' => $message,
                'new_entries_found' => $newEntriesFound,
                'notifications_sent' => $notificationsSent,
                'timestamp' => now()->toISOString()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Notification check error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Notification check failed: ' . $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 500);
        }
    }

    /**
     * Get status of automated sync system
     */
    public function getStatus(Request $request)
    {
        try {
            $lastSyncTime = Cache::get('automated_sync_last_run', null);
            $lastCheckTime = Cache::get('notification_check_last_run', null);
            $lastGoogleSync = $this->googleSheetsService->getLastSyncTimestamp();
            
            return response()->json([
                'success' => true,
                'status' => [
                    'last_automated_sync' => $lastSyncTime ? $lastSyncTime->format('Y-m-d H:i:s') : 'Never',
                    'last_notification_check' => $lastCheckTime ? $lastCheckTime->format('Y-m-d H:i:s') : 'Never',
                    'last_google_sheets_sync' => $lastGoogleSync,
                    'current_time' => now()->format('Y-m-d H:i:s'),
                    'system_active' => true
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Status check error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Status check failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
