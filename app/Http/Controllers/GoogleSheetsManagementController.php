<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetsServicePublic;
use App\Services\LeadNotificationService;
use App\Models\MeetingCallDetail;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class GoogleSheetsManagementController extends Controller
{
    protected $googleSheetsService;
    protected $leadNotificationService;

    public function __construct(GoogleSheetsServicePublic $googleSheetsService, LeadNotificationService $leadNotificationService)
    {
        $this->googleSheetsService = $googleSheetsService;
        $this->leadNotificationService = $leadNotificationService;
    }

    /**
     * Show the calling app login form
     */
    public function showLoginForm()
    {
        // If user is already logged in, redirect to calling app
        if (Auth::check()) {
            return redirect()->route('callingapp.index');
        }
        
        return view('admin.google-sheets.calling-app-login');
    }

    /**
     * Handle login request for calling app
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        // Add remember me functionality
        $remember = $request->has('remember');
        
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Check if user has appropriate role (1 for admin, 2 for employee)
            if (!in_array($user->role, [1, 2])) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'You do not have permission to access the Calling App. Only Admin and Employee roles are allowed.',
                ]);
            }
            
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();
            
            // Store user info in session for easy access
            session([
                'callingapp_user_id' => $user->id,
                'callingapp_user_name' => $user->name,
                'callingapp_user_role' => $user->role,
                'callingapp_user_email' => $user->email,
                'callingapp_login_time' => now()
            ]);
            
            return redirect()->intended(route('callingapp.index'));
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Handle logout request for calling app
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        // Clear calling app specific session data
        $request->session()->forget([
            'callingapp_user_id',
            'callingapp_user_name',
            'callingapp_user_role',
            'callingapp_user_email',
            'callingapp_login_time'
        ]);
        
        // Invalidate and regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('callingapp.login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Check for new entries and send email notifications
     */
    private function checkAndNotifyNewEntries($allData)
    {
        try {
            \Log::info('checkAndNotifyNewEntries called', ['total_entries' => count($allData)]);
            
            // Get the last checked timestamp from session or cache
            $lastChecked = session('last_entries_checked', now()->subMinutes(30));
            $current_time = now();
            
            \Log::info('Rate limit check', [
                'last_checked' => $lastChecked->format('Y-m-d H:i:s'),
                'current_time' => $current_time->format('Y-m-d H:i:s'),
                'minutes_diff' => $current_time->diffInMinutes($lastChecked)
            ]);
            
            // Only check if at least 1 minute has passed since last check
            if ($current_time->diffInMinutes($lastChecked) < 1) {
                \Log::info('Rate limited - skipping check');
                return;
            }
            
            \Log::info('Rate limit passed - checking for new entries');
            
            // Get recent entries (last 5 minutes)
            $recentEntries = array_filter($allData, function($row) use ($lastChecked) {
                // This is a simplified check - in production, you'd want proper timestamps
                return true; // For now, check all entries
            });
            
            // Check each entry against database to find new ones
            $newEntriesFound = 0;
            foreach (array_slice($recentEntries, 0, 5) as $entry) { // Check last 5 entries
                if (!empty($entry['full_name']) && !empty($entry['email'])) {
                    // Check if this entry already exists in our notification log
                    $entryKey = $entry['full_name'] . '|' . $entry['email'];
                    $notifiedEntries = session('notified_entries', []);
                    
                    \Log::info('Checking entry', [
                        'entry_key' => $entryKey,
                        'already_notified' => in_array($entryKey, $notifiedEntries)
                    ]);
                    
                    if (!in_array($entryKey, $notifiedEntries)) {
                        // This is a new entry - send notification
                        \Log::info('New entry found - sending notification', ['entry' => $entryKey]);
                        
                        $notificationData = [
                            'full_name' => $entry['full_name'],
                            'business_name' => $entry['business_name'] ?? '',
                            'email' => $entry['email'],
                            'whatsapp' => $entry['whatsapp'] ?? '',
                            'website_url' => $entry['website_url'] ?? '',
                            'submitted_at' => now()->format('M d, Y H:i A')
                        ];
                        
                        // Send notification
                        try {
                            $result = $this->leadNotificationService->sendNewLeadNotification($notificationData);
                            
                            if ($result['success'] && $result['sent'] > 0) {
                                // Mark as notified to avoid duplicate notifications
                                $notifiedEntries[] = $entryKey;
                                session(['notified_entries' => array_slice($notifiedEntries, -50)]); // Keep last 50
                                
                                $newEntriesFound++;
                                
                                \Log::info('Automatic notification sent for new entry', [
                                    'lead_name' => $entry['full_name'],
                                    'lead_email' => $entry['email'],
                                    'sent_to' => $result['sent']
                                ]);
                            }
                        } catch (\Exception $e) {
                            \Log::error('Failed to send automatic notification', [
                                'lead_name' => $entry['full_name'],
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                }
            }
            
            // Update last checked time
            session(['last_entries_checked' => $current_time]);
            
            \Log::info('Automatic email check completed', [
                'new_entries_found' => $newEntriesFound,
                'total_entries_checked' => min(5, count($allData))
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error in automatic entry checking: ' . $e->getMessage());
        }
    }

    /**
     * Display Google Sheets Management page
     */
    public function index(Request $request)
    {
        try {
            // Get pagination parameters
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 50);
            $search = $request->get('search', '');
            
            // Get all data from Google Sheets
            $allData = $this->googleSheetsService->getMappedData();
            
            // Reverse the data order so last entry appears first
            $allData = array_reverse($allData);
            
            // Apply search filter
            if (!empty($search)) {
                $allData = array_filter($allData, function($row) use ($search) {
                    foreach ($row as $value) {
                        if (stripos($value, $search) !== false) {
                            return true;
                        }
                    }
                    return false;
                });
            }
            
            // Get total rows
            $totalRows = count($allData);
            
            // Get headers
            $headers = [];
            if (!empty($allData)) {
                $headers = array_keys($allData[0]);
            }
            
            // Calculate pagination
            $totalPages = ceil($totalRows / $perPage);
            $offset = ($page - 1) * $perPage;
            
            // Get page data
            $pageData = array_slice($allData, $offset, $perPage);
            
            // Get last sync info
            $lastSync = $this->googleSheetsService->getLastSyncTimestamp();
            
            return view('admin.google-sheets.simple', [
                'pageData' => $pageData,
                'headers' => $headers,
                'totalRows' => $totalRows,
                'totalPages' => $totalPages,
                'currentPage' => $page,
                'perPage' => $perPage,
                'search' => $search,
                'lastSync' => $lastSync
            ]);
            
        } catch (\Exception $e) {
            Log::error('Google Sheets management page error: ' . $e->getMessage());
            
            return view('admin.google-sheets.simple', [
                'pageData' => [],
                'headers' => [],
                'totalRows' => 0,
                'totalPages' => 0,
                'currentPage' => 1,
                'perPage' => 50,
                'search' => '',
                'lastSync' => null,
                'error' => 'Failed to load Google Sheets data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Calculate and save best calling time based on call history, recordings, and meeting data
     */
    private function calculateBestCallingTime($leadFullName, $leadEmail, $leadWhatsApp, $leadBusinessName)
    {
        try {
            // Check if we already have saved data for this lead
            $existingLead = \App\Models\Lead::where('email', $leadEmail)
                ->where('name', $leadFullName)
                ->first();
            
            // If we have recent saved data (less than 24 hours old), return it
            if ($existingLead && $existingLead->best_calling_time_calculated_at) {
                $hoursSinceCalculation = now()->diffInHours($existingLead->best_calling_time_calculated_at);
                if ($hoursSinceCalculation < 24 && !empty($existingLead->best_calling_time_range)) {
                    \Log::info('Using cached best calling time for lead', [
                        'lead_name' => $leadFullName,
                        'hours_since_calculation' => $hoursSinceCalculation
                    ]);
                    
                    return [
                        'time_range' => $existingLead->best_calling_time_range,
                        'confidence' => $existingLead->best_calling_time_confidence,
                        'reason' => $existingLead->best_calling_time_reason,
                        'color' => $existingLead->best_calling_time_color,
                        'peak_hour' => $existingLead->best_calling_time_peak_hour,
                        'interaction_count' => $existingLead->best_calling_interaction_count
                    ];
                }
            }
            
            // Set timezone to Indian Standard Time
            $istTimezone = 'Asia/Kolkata';
            
            // Get call recordings for this lead
            $callRecordings = DB::table('call_recordings')
                ->where(function($query) use ($leadWhatsApp, $leadFullName) {
                    $query->where('customer_phone', $leadWhatsApp)
                          ->orWhere('customer_name', $leadFullName);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            // Get meeting/call history for this lead (more flexible matching)
            $meetingHistory = MeetingCallDetail::where(function($query) use ($leadFullName, $leadEmail, $leadBusinessName, $leadWhatsApp) {
                    // Try exact match first
                    $query->where('lead_full_name', $leadFullName)
                          ->orWhere('lead_email', $leadEmail);
                    
                    // If no exact match, try partial name matching
                    if (!empty($leadFullName)) {
                        $names = explode(' ', $leadFullName);
                        foreach ($names as $namePart) {
                            if (strlen($namePart) > 2) {
                                $query->orWhere('lead_full_name', 'LIKE', '%' . $namePart . '%');
                            }
                        }
                    }
                })
                ->orderBy('created_at', 'desc')
                ->get();

            // Analyze call recording times (convert to IST and filter office hours)
            $recordingHours = [];
            foreach ($callRecordings as $recording) {
                $hour = (int)\Carbon\Carbon::parse($recording->created_at)->setTimezone($istTimezone)->format('H');
                // Only include calls made during office hours (9 AM - 7 PM IST)
                if ($hour >= 9 && $hour <= 19) {
                    $recordingHours[] = $hour;
                }
            }

            // Analyze meeting/call times (convert to IST and filter office hours)
            $meetingHours = [];
            foreach ($meetingHistory as $meeting) {
                if ($meeting->created_at) {
                    $hour = (int)\Carbon\Carbon::parse($meeting->created_at)->setTimezone($istTimezone)->format('H');
                    // Only include calls made during office hours (9 AM - 7 PM IST)
                    if ($hour >= 9 && $hour <= 19) {
                        $meetingHours[] = $hour;
                    }
                }
            }

            // Combine all interaction times
            $allInteractionHours = array_merge($recordingHours, $meetingHours);

            if (empty($allInteractionHours)) {
                // No history - suggest office hours (9 AM to 7 PM IST) with stable time assignment
                // Use lead-specific hash for consistent time assignment
                $leadHash = crc32($leadFullName . $leadEmail);
                $timeRanges = [
                    ['range' => '9:00 AM - 11:00 AM', 'peak' => '10:00 AM'],   // Morning start
                    ['range' => '10:00 AM - 12:00 PM', 'peak' => '11:00 AM'], // Late morning
                    ['range' => '2:00 PM - 4:00 PM', 'peak' => '3:00 PM'],     // Afternoon
                    ['range' => '5:00 PM - 7:00 PM', 'peak' => '6:00 PM']      // Evening end
                ];
                
                // Use lead-specific hash for consistent time assignment (not current time)
                $index = abs($leadHash) % count($timeRanges);
                $selectedTime = $timeRanges[$index];
                
                $result = [
                    'time_range' => $selectedTime['range'],
                    'confidence' => 'Low',
                    'reason' => 'No call history - suggested office hours (9 AM - 7 PM IST)',
                    'color' => '#6c757d',
                    'peak_hour' => $selectedTime['peak'],
                    'interaction_count' => 0
                ];
            } else {
                // Count frequency of calls by hour
                $hourFrequency = array_count_values($allInteractionHours);
                
                // Find peak hours (most frequent calling times)
                arsort($hourFrequency);
                $peakHours = array_keys($hourFrequency, max($hourFrequency));

                // Determine best time range based on peak hours
                $bestHour = $peakHours[0];
                
                // Create a 2-hour window around the best time
                $startHour = $bestHour - 1;
                $endHour = $bestHour + 1;
                
                // Handle edge cases (office hours: 9 AM to 7 PM IST)
                if ($startHour < 9) $startHour = 9;
                if ($endHour > 19) $endHour = 19;
                
                // Convert to 12-hour format with AM/PM
                $startHour12 = $startHour % 12 ?: 12;
                $endHour12 = $endHour % 12 ?: 12;
                $startPeriod = $startHour >= 12 ? 'PM' : 'AM';
                $endPeriod = $endHour >= 12 ? 'PM' : 'AM';
                
                $timeRange = "{$startHour12}:00 {$startPeriod} - {$endHour12}:00 {$endPeriod}";
                
                // Determine confidence level based on data points
                $totalInteractions = count($allInteractionHours);
                
                // More lenient confidence calculation for current data availability
                if ($totalInteractions >= 2) {
                    $confidence = 'High';
                    $color = '#28a745';
                } elseif ($totalInteractions >= 1) {
                    $confidence = 'Medium';
                    $color = '#ffc107';
                } else {
                    $confidence = 'Low';
                    $color = '#6c757d';
                }
                
                // Calculate peak hour in 12-hour format
                $bestHour12 = $bestHour % 12 ?: 12;
                $period = $bestHour >= 12 ? 'PM' : 'AM';
                
                $reason = "Based on {$totalInteractions} previous " . ($totalInteractions == 1 ? 'interaction' : 'interactions') . " at this time (Office Hours: 9 AM - 7 PM IST)";
                
                $result = [
                    'time_range' => $timeRange,
                    'confidence' => $confidence,
                    'reason' => $reason,
                    'color' => $color,
                    'peak_hour' => "{$bestHour12}:00 {$period}",
                    'interaction_count' => $totalInteractions
                ];
            }
            
            // Save the calculated data to database for persistence
            $this->saveBestCallingTime($leadFullName, $leadEmail, $leadBusinessName, $leadWhatsApp, $result);
            
            return $result;
            
        } catch (\Exception $e) {
            \Log::error('Error calculating best calling time: ' . $e->getMessage());
            return [
                'time_range' => '10:00 AM - 12:00 PM',
                'confidence' => 'Low',
                'reason' => 'Error analyzing data - suggested office hours (9 AM - 7 PM IST)',
                'color' => '#dc3545',
                'peak_hour' => '11:00 AM',
                'interaction_count' => 0
            ];
        }
    }
    
    /**
     * Save best calling time data to leads table
     */
    private function saveBestCallingTime($leadFullName, $leadEmail, $leadBusinessName, $leadWhatsApp, $callingTimeData)
    {
        try {
            // Find existing lead or create new one
            $lead = \App\Models\Lead::firstOrCreate(
                ['email' => $leadEmail],
                [
                    'name' => $leadFullName,
                    'business_name' => $leadBusinessName,
                    'whatsapp' => $leadWhatsApp,
                    'source' => 'google_sheets',
                    'lead_status' => 'cold',
                    'priority' => 'medium'
                ]
            );
            
            // Update best calling time data
            $lead->update([
                'best_calling_time_range' => $callingTimeData['time_range'],
                'best_calling_time_confidence' => $callingTimeData['confidence'],
                'best_calling_time_peak_hour' => $callingTimeData['peak_hour'],
                'best_calling_interaction_count' => $callingTimeData['interaction_count'],
                'best_calling_time_reason' => $callingTimeData['reason'],
                'best_calling_time_color' => $callingTimeData['color'],
                'best_calling_time_calculated_at' => now()
            ]);
            
            \Log::info('Best calling time saved for lead', [
                'lead_name' => $leadFullName,
                'lead_email' => $leadEmail,
                'time_range' => $callingTimeData['time_range'],
                'confidence' => $callingTimeData['confidence']
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error saving best calling time: ' . $e->getMessage());
        }
    }

    /**
     * Display the calling app page - public access with mobile responsive view
     */
    public function callingApp(Request $request)
    {
        $startTime = microtime(true);
        
        // Check if this is an AJAX request
        $isAjax = $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest';
        
        try {
            // Get pagination parameters
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 50);
            $search = $request->get('search', '');
            
            Log::info('CallingApp: Starting page load');
            
            // Get all data from Google Sheets (using cache)
            $googleSheetsData = $this->googleSheetsService->getMappedData();
            
            Log::info('CallingApp: Google Sheets data loaded in ' . (microtime(true) - $startTime) . ' seconds');
            
            // Reverse the data order so last entry appears first
            $googleSheetsData = array_reverse($googleSheetsData);
            
            \Log::info('Calling app page loaded - displaying only Google Sheets data');
            
            // Get all call history in one query for better performance
            $allCallHistory = MeetingCallDetail::orderBy('created_at', 'desc')
                ->get(['lead_full_name', 'lead_business_name', 'lead_email', 'lead_whatsapp', 'called_by_employee_name']);
            
            // Create a lookup map for faster access
            $callHistoryMap = [];
            foreach ($allCallHistory as $call) {
                $key = ($call->lead_full_name ?? '') . '|' . ($call->lead_business_name ?? '') . '|' . ($call->lead_email ?? '') . '|' . ($call->lead_whatsapp ?? '');
                if (!isset($callHistoryMap[$key])) {
                    $callHistoryMap[$key] = $call->called_by_employee_name;
                }
            }
            
            // Process only Google Sheets data
            $allData = [];
            
            // Process Google Sheets data only
            foreach ($googleSheetsData as $row) {
                $filteredRow = [];
                $filteredRow['full_name'] = $row['full_name'] ?? '';
                $filteredRow['business_name'] = $row['business_name'] ?? '';
                $filteredRow['email'] = $row['email'] ?? '';
                $filteredRow['whatsapp'] = $row['whatsapp'] ?? '';
                
                // Get who called this lead from lookup map
                $key = ($row['full_name'] ?? '') . '|' . ($row['business_name'] ?? '') . '|' . ($row['email'] ?? '') . '|' . ($row['whatsapp'] ?? '');
                $filteredRow['who_called'] = $callHistoryMap[$key] ?? 'Not called yet';
                
                // Calculate best calling time based on history
                $bestCallingTime = $this->calculateBestCallingTime(
                    $row['full_name'] ?? '',
                    $row['email'] ?? '',
                    $row['whatsapp'] ?? '',
                    $row['business_name'] ?? ''
                );
                
                $filteredRow['best_calling_time'] = $bestCallingTime;
                $filteredRow['source'] = 'google'; // Mark as Google Sheets source
                $allData[] = $filteredRow;
            }
            
            // Apply search filter
            if (!empty($search)) {
                $allData = array_filter($allData, function($row) use ($search) {
                    foreach ($row as $value) {
                        if (stripos($value, $search) !== false) {
                            return true;
                        }
                    }
                    return false;
                });
            }
            
            // Get total rows
            $totalRows = count($allData);
            $filteredData = $allData;
            
            // Calculate pagination
            $totalPages = ceil($totalRows / $perPage);
            $offset = ($page - 1) * $perPage;
            
            // Get page data
            $pageData = array_slice($filteredData, $offset, $perPage);
            
            // Get headers for calling app
            $headers = ['full_name', 'business_name', 'email', 'whatsapp', 'who_called', 'best_calling_time'];
            
            $totalTime = microtime(true) - $startTime;
            Log::info('CallingApp: Total page load time: ' . $totalTime . ' seconds');
            
            // If AJAX request, return only the table content
            if ($isAjax) {
                return response()->view('admin.google-sheets.calling-app-table', compact(
                    'pageData',
                    'headers',
                    'page',
                    'totalPages',
                    'totalRows',
                    'perPage',
                    'search'
                ));
            }
            
            return view('admin.google-sheets.calling-app', compact(
                'pageData',
                'headers',
                'page',
                'totalPages',
                'totalRows',
                'perPage',
                'search'
            ));
            
        } catch (\Exception $e) {
            \Log::error('Calling App Error: ' . $e->getMessage());
            return view('admin.google-sheets.calling-app', [
                'pageData' => [],
                'headers' => ['full_name', 'business_name', 'email', 'whatsapp', 'who_called'],
                'currentPage' => 1,
                'totalPages' => 0,
                'totalRows' => 0,
                'perPage' => 50,
                'search' => '',
                'error' => 'Failed to load Google Sheets data. Please try again.'
            ]);
        }
    }

    /**
     * Sync Google Sheets data (shared method for both admin and calling app)
     */
    public function sync(Request $request)
    {
        try {
            $isAutoSync = $request->get('auto_sync', false);
            
            // Clear cache for manual sync, use cache for auto-sync
            if (!$isAutoSync) {
                $this->googleSheetsService->clearCache();
                Log::info('Manual sync - cache cleared');
            } else {
                Log::info('Auto sync - using cached data');
            }
            
            // Get all data from Google Sheets
            $data = $this->googleSheetsService->getMappedData();
            
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
            $defaultUser = \App\Models\User::first();
            $createdById = $defaultUser ? $defaultUser->id : 1;

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
                    
                    \Log::info('Lead duplicate check', [
                        'lead_name' => $leadData['name'],
                        'lead_email' => $leadData['email'],
                        'existing_lead_found' => $existingLead ? true : false,
                        'existing_lead_id' => $existingLead->id ?? null
                    ]);
                    
                    if ($existingLead) {
                        // Update existing lead
                        $existingLead->update($leadData);
                        $updatedCount++;
                        
                        \Log::info('Existing lead updated', [
                            'lead_name' => $leadData['name'],
                            'lead_email' => $leadData['email'],
                            'lead_id' => $existingLead->id
                        ]);
                    } else {
                        // Create new lead
                        $leadData['source'] = 'google_sheets';
                        $leadData['created_by'] = $createdById;
                        $leadData['lead_status'] = $leadData['lead_status'] ?? 'cold';
                        $leadData['priority'] = $leadData['priority'] ?? 'medium';
                        
                        $newLead = \App\Models\Lead::create($leadData);
                        $importedCount++;
                        
                        \Log::info('New lead created', [
                            'lead_name' => $leadData['name'],
                            'lead_email' => $leadData['email'],
                            'lead_id' => $newLead->id
                        ]);
                        
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
                            
                            $this->leadNotificationService->sendNewLeadNotification($notificationData);
                            
                            \Log::info('New lead notification sent', [
                                'lead_name' => $leadData['name'],
                                'lead_email' => $leadData['email'],
                                'lead_id' => $newLead->id
                            ]);
                            
                        } catch (\Exception $notificationError) {
                            \Log::error('Failed to send new lead notification', [
                                'lead_name' => $leadData['name'],
                                'lead_email' => $leadData['email'],
                                'error' => $notificationError->getMessage()
                            ]);
                            // Don't fail the sync if notification fails
                        }
                    }
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($rowIndex + 2) . ": " . $e->getMessage();
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
                'errors' => $errors,
                'table_data' => $this->getCallingAppData($request)
            ]);
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google Sheets sync error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export Google Sheets data to Excel
     */
    public function export(Request $request)
    {
        try {
            // Get all data from Google Sheets
            $allData = $this->googleSheetsService->getMappedData();
            
            if (empty($allData)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data available to export'
                ]);
            }

            // Get headers
            $headers = array_keys($allData[0]);
            
            // Prepare CSV data
            $csvData = [];
            $csvData[] = implode(',', array_map(function($header) {
                return '"' . str_replace('"', '""', $header) . '"';
            }, $headers));
            
            foreach ($allData as $row) {
                $csvRow = [];
                foreach ($headers as $header) {
                    $value = $row[$header] ?? '';
                    $csvRow[] = '"' . str_replace('"', '""', $value) . '"';
                }
                $csvData[] = implode(',', $csvRow);
            }
            
            $csvContent = implode("\n", $csvData);
            
            // Create response
            $response = response($csvContent);
            $response->header('Content-Type', 'text/csv');
            $response->header('Content-Disposition', 'attachment; filename="google_sheets_export_' . date('Y-m-d_H-i-s') . '.csv"');
            $response->header('Cache-Control', 'no-cache, must-revalidate');
            $response->header('Pragma', 'no-cache');
            $response->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
            
            return $response;
            
        } catch (\Exception $e) {
            Log::error('Export error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show full details of a lead entry
     */
    public function showLeadDetails($index)
    {
        try {
            // Check if this is a manual leads request
            $isManualLeads = request()->routeIs('callingapp.manual-leads') || request()->get('source') === 'manual';
            
            if ($isManualLeads) {
                // Get manual leads data with ALL fields
                $manuallyAddedLeads = \App\Models\Lead::where('source', 'callingapp')
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                // Process manual leads for display
                $allData = [];
                foreach ($manuallyAddedLeads as $lead) {
                    $filteredRow = [];
                    $filteredRow['full_name'] = $lead->name ?? '';
                    $filteredRow['business_name'] = $lead->company_name ?? '';
                    $filteredRow['email'] = $lead->email ?? '';
                    $filteredRow['whatsapp'] = $lead->phone ?? '';
                    $filteredRow['website_url'] = $lead->website ?? '';
                    $filteredRow['business_type'] = $lead->industry ?? '';
                    $filteredRow['primary_goal'] = $lead->description ?? '';
                    // Extract budget range from notes field (new format) or budget field (old format)
                    $budgetRange = '';
                    \Log::info('Lead details - notes field: ' . ($lead->notes ?? 'null'));
                    \Log::info('Lead details - budget field: ' . ($lead->budget ?? 'null'));
                    
                    // Try new format first (stored in notes)
                    if ($lead->notes && strpos($lead->notes, '|BUDGET:') !== false) {
                        $budgetParts = explode('|BUDGET:', $lead->notes);
                        if (isset($budgetParts[1])) {
                            $budgetRange = trim($budgetParts[1]);
                        }
                    }
                    // Fallback to old format (stored in budget decimal field)
                    elseif ($lead->budget) {
                        // For decimal budgets, show as single value without .00 if it's a whole number
                        if ($lead->budget == floor($lead->budget)) {
                            $budgetRange = number_format($lead->budget, 0);
                        } else {
                            $budgetRange = number_format($lead->budget, 2);
                        }
                    }
                    
                    \Log::info('Lead details - extracted budget: ' . $budgetRange);
                    $filteredRow['budget_range'] = $budgetRange ? '₹' . $budgetRange : '';
                    
                    // Debug WhatsApp field
                    \Log::info('Lead details - phone field: ' . ($lead->phone ?? 'null'));
                    \Log::info('Lead details - whatsapp display: ' . $filteredRow['whatsapp']);
                    \Log::info('Lead details - full lead data: ' . json_encode([
                        'id' => $lead->id,
                        'name' => $lead->name,
                        'phone' => $lead->phone,
                        'email' => $lead->email,
                        'company_name' => $lead->company_name
                    ]));
                    $filteredRow['score'] = $lead->score ?? '';
                    $filteredRow['tier'] = $lead->lead_status ?? '';
                    $filteredRow['submitted_at'] = $lead->follow_up_date ? $lead->follow_up_date->format('Y-m-d H:i:s') : ($lead->created_at ? $lead->created_at->format('Y-m-d H:i:s') : '');
                    $filteredRow['audit_report'] = $lead->description ?? '';
                    // Extract actual audit report plain text from notes field (remove budget data)
                    $auditReportPlain = $lead->notes ?? '';
                    if ($lead->notes && strpos($lead->notes, '|BUDGET:') !== false) {
                        $auditReportPlain = trim(explode('|BUDGET:', $lead->notes)[0]);
                    }
                    $filteredRow['audit_report_plain'] = $auditReportPlain;
                    $filteredRow['source'] = 'manual';
                    $allData[] = $filteredRow;
                }
            } else {
                // Get Google Sheets data
                $allData = $this->googleSheetsService->getMappedData();
                
                // Reverse the data order to match calling app
                $allData = array_reverse($allData);
                
                // Add source info
                foreach ($allData as &$row) {
                    $row['source'] = 'google';
                }
            }
            
            // Get the specific lead by index
            if (!isset($allData[$index])) {
                return redirect()->route('callingapp.index')->with('error', 'Lead not found');
            }
            
            $lead = $allData[$index];
            
            // Get call history for this specific lead only
            $leadCallHistory = MeetingCallDetail::where('lead_full_name', $lead['full_name'] ?? '')
                ->where('lead_email', $lead['email'] ?? '')
                ->where('lead_business_name', $lead['business_name'] ?? '')
                ->where('lead_whatsapp', $lead['whatsapp'] ?? '')
                ->orderBy('created_at', 'desc')
                ->get();
            
            return view('admin.google-sheets.lead-details', compact('lead', 'leadCallHistory'));
            
        } catch (\Exception $e) {
            Log::error('Lead details error: ' . $e->getMessage());
            
            return redirect()->route('callingapp.index')->with('error', 'Failed to load lead details');
        }
    }

    /**
     * Get all active employees for dropdown
     */
    public function getEmployees()
    {
        try {
            \Log::info('Fetching employees...');
            
            // Check if Employee model exists and query works
            $employees = Employee::active()->get(['id', 'name', 'email']);
            
            \Log::info('Employees query executed', [
                'count' => $employees->count(),
                'employees' => $employees->toArray()
            ]);
            
            return response()->json([
                'success' => true,
                'employees' => $employees
            ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
              ->header('Pragma', 'no-cache')
              ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
            
        } catch (\Exception $e) {
            \Log::error('Get employees error: ' . $e->getMessage());
            \Log::error('Error details', [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load employees: ' . $e->getMessage()
            ], 500)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }
    }

    /**
     * Add new employee
     */
    public function addEmployee(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:employees,email'
            ]);
            
            $employee = Employee::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'active' => true
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Employee added successfully',
                'employee' => $employee
            ]);
            
        } catch (\Exception $e) {
            Log::error('Add employee error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to add employee: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save meeting & call details
     */
    public function saveMeetingCallDetails(Request $request)
    {
        try {
            // Add debug logging
            \Log::info('Save call details request received', [
                'data' => $request->all(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            $validated = $request->validate([
                'lead_full_name' => 'required|string',
                'lead_business_name' => 'required|string',
                'lead_email' => 'required|email',
                'lead_whatsapp' => 'required|string',
                'lead_website_url' => 'required|string',
                'called_by_employee_name' => 'required|string',
                'called_by_employee_email' => 'required|email',
                'rating' => 'required|integer|min:1|max:5',
                'meeting_conclusion' => 'required|string',
                'next_call_date' => 'nullable|date',
                'additional_notes' => 'nullable|string'
            ]);
            
            \Log::info('Validation passed', ['validated' => $validated]);
            
            // Always create new meeting call detail record to preserve history
            $meetingMeetingCallDetail = MeetingCallDetail::create([
                'lead_full_name' => $validated['lead_full_name'],
                'lead_business_name' => $validated['lead_business_name'],
                'lead_email' => $validated['lead_email'],
                'lead_whatsapp' => $validated['lead_whatsapp'],
                'lead_website_url' => $validated['lead_website_url'],
                'called_by_employee_name' => $validated['called_by_employee_name'],
                'called_by_employee_email' => $validated['called_by_employee_email'],
                'rating' => $validated['rating'],
                'meeting_conclusion' => $validated['meeting_conclusion'],
                'next_call_date' => $validated['next_call_date'],
                'additional_notes' => $validated['additional_notes']
            ]);
            
            \Log::info('Meeting call detail created', ['id' => $meetingMeetingCallDetail->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Meeting & call details saved successfully',
                'meeting_call_detail' => $meetingMeetingCallDetail,
                'action' => 'created'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->errors()->all()),
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            \Log::error('Save meeting call details error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save meeting & call details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test database connection
     */
    public function testConnection(Request $request)
    {
        try {
            // Test database connection by trying to create a simple query
            $count = MeetingCallDetail::count();
            
            return response()->json([
                'success' => true,
                'message' => 'Database connection successful',
                'meeting_call_details_count' => $count
            ]);
            
        } catch (\Exception $e) {
            Log::error('Database connection test error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Database connection failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get meeting & call details for a specific lead using all lead fields for accurate matching
     */
    public function getMeetingCallDetailsByLead(Request $request)
    {
        try {
            // Get all lead parameters
            $fullName = $request->get('full_name', '');
            $businessName = $request->get('business_name', '');
            $email = $request->get('email', '');
            $whatsapp = $request->get('whatsapp', '');
            
            // Build query with all lead fields for accurate matching
            $query = MeetingCallDetail::query();
            
            if (!empty($fullName)) {
                $query->where('lead_full_name', $fullName);
            }
            if (!empty($businessName)) {
                $query->where('lead_business_name', $businessName);
            }
            if (!empty($email)) {
                $query->where('lead_email', $email);
            }
            if (!empty($whatsapp)) {
                $query->where('lead_whatsapp', $whatsapp);
            }
            
            // Get meeting call details ordered by most recent first
            $meetingCallDetails = $query->orderBy('created_at', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'meeting_details' => $meetingCallDetails
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get meeting call details by lead error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load meeting & call details'
            ], 500);
        }
    }

    /**
     * Show Call History page with all entries
     */
    public function showCallHistoryPage(Request $request)
    {
        try {
            // Get all call history ordered by most recent first
            $query = MeetingCallDetail::orderBy('created_at', 'desc');
            
            // Apply filters if provided via URL parameters
            if ($request->has('lead_name')) {
                $query->where('lead_full_name', 'like', '%' . $request->lead_name . '%');
            }
            if ($request->has('lead_email')) {
                $query->where('lead_email', 'like', '%' . $request->lead_email . '%');
            }
            if ($request->has('lead_business')) {
                $query->where('lead_business_name', 'like', '%' . $request->lead_business . '%');
            }
            if ($request->has('lead_whatsapp')) {
                $query->where('lead_whatsapp', 'like', '%' . $request->lead_whatsapp . '%');
            }
            
            $allCallHistory = $query->get();
            
            return view('admin.google-sheets.call-history', compact('allCallHistory'));
            
        } catch (\Exception $e) {
            Log::error('Show call history page error: ' . $e->getMessage());
            
            return view('admin.google-sheets.call-history', [
                'allCallHistory' => collect([]),
                'error' => 'Failed to load call history: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get meeting & call details for a specific lead
     */
    public function getMeetingCallDetails($email)
    {
        try {
            // Get meeting call details
            $meetingMeetingCallDetails = MeetingCallDetail::where('lead_email', $email)
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'meeting_call_details' => $meetingMeetingCallDetails
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get meeting call details error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load meeting & call details'
            ], 500);
        }
    }

    /**
     * Get today's follow-up count
     */
    public function getTodayFollowupCount()
    {
        try {
            $today = now()->format('Y-m-d');
            
            // Count entries with today's date in next_call_date
            $todayCount = MeetingCallDetail::whereDate('next_call_date', $today)
                ->whereNotNull('next_call_date')
                ->count();
            
            return response()->json([
                'success' => true,
                'today_count' => $todayCount,
                'today_date' => $today
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get today follow-up count error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to get today\'s follow-up count'
            ], 500);
        }
    }

    /**
     * Get a specific meeting call detail for editing
     */
    public function getMeetingCallDetail($id)
    {
        try {
            $meetingMeetingCallDetail = MeetingCallDetail::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'meeting_call_detail' => $meetingMeetingCallDetail
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get meeting call detail error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load meeting call detail'
            ], 500);
        }
    }

    /**
     * Update meeting call detail
     */
    public function updateMeetingCallDetail(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'lead_full_name' => 'required|string',
                'lead_business_name' => 'required|string',
                'lead_email' => 'required|email',
                'lead_whatsapp' => 'required|string',
                'lead_website_url' => 'required|string',
                'called_by_employee_name' => 'required|string',
                'called_by_employee_email' => 'required|email',
                'rating' => 'required|integer|min:1|max:5',
                'meeting_conclusion' => 'required|string',
                'next_call_date' => 'nullable|date',
                'additional_notes' => 'nullable|string',
                'meeting_status' => 'required|string|in:scheduled,completed,cancelled',
                'meeting_date_time' => 'nullable|date',
                'meeting_location' => 'nullable|string',
                'meeting_type' => 'nullable|string|in:phone,video,in-person',
                'meeting_duration_hours' => 'nullable|numeric|min:0|max:24',
                'meeting_outcome' => 'nullable|string',
                'follow_up_actions' => 'nullable|string',
                'is_converted' => 'nullable|boolean',
                'deal_value' => 'nullable|numeric|min:0'
            ]);
            
            $meetingMeetingCallDetail = MeetingCallDetail::findOrFail($id);
            $meetingMeetingCallDetail->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Meeting & call details updated successfully',
                'meeting_call_detail' => $meetingMeetingCallDetail
            ]);
            
        } catch (\Exception $e) {
            Log::error('Update meeting call detail error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update meeting & call details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show follow-up page with entries for specific date
     */
    public function showFollowupPage(Request $request)
    {
        try {
            // Get the date from request or default to today
            $selectedDate = $request->get('date', now()->format('Y-m-d'));
            
            // Validate date format
            if (!\DateTime::createFromFormat('Y-m-d', $selectedDate)) {
                $selectedDate = now()->format('Y-m-d');
            }
            
            // Get follow-up entries for the selected date
            $followupEntries = MeetingCallDetail::whereDate('next_call_date', $selectedDate)
                ->whereNotNull('next_call_date')
                ->orderBy('next_call_date', 'asc')
                ->get();
            
            // Get today's count for the header
            $today = now()->format('Y-m-d');
            $todayCount = MeetingCallDetail::whereDate('next_call_date', $today)
                ->whereNotNull('next_call_date')
                ->count();
            
            return view('admin.google-sheets.followup', compact(
                'followupEntries',
                'selectedDate',
                'todayCount'
            ));
            
        } catch (\Exception $e) {
            Log::error('Show follow-up page error: ' . $e->getMessage());
            
            return view('admin.google-sheets.followup', [
                'followupEntries' => collect([]),
                'selectedDate' => now()->format('Y-m-d'),
                'todayCount' => 0,
                'error' => 'Failed to load follow-up data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get follow-up entries for a specific date (AJAX)
     */
    public function getFollowupEntries(Request $request)
    {
        try {
            $selectedDate = $request->get('date', now()->format('Y-m-d'));
            
            // Validate date format
            if (!\DateTime::createFromFormat('Y-m-d', $selectedDate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid date format'
                ], 400);
            }
            
            // Get follow-up entries for the selected date
            $followupEntries = MeetingCallDetail::whereDate('next_call_date', $selectedDate)
                ->whereNotNull('next_call_date')
                ->orderBy('next_call_date', 'asc')
                ->get();
            
            return response()->json([
                'success' => true,
                'followup_entries' => $followupEntries,
                'selected_date' => $selectedDate,
                'count' => $followupEntries->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get follow-up entries error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load follow-up entries'
            ], 500);
        }
    }

    /**
     * Get calling app data for AJAX updates
     */
    private function getCallingAppData(Request $request)
    {
        try {
            // Get pagination parameters
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 50);
            $search = $request->get('search', '');
            
            // Get all data from Google Sheets
            $allData = $this->googleSheetsService->getMappedData();
            
            // Reverse the data order to show last entry first
            $allData = array_reverse($allData);
            
            // Apply search filter
            if (!empty($search)) {
                $allData = array_filter($allData, function($row) use ($search) {
                    foreach ($row as $value) {
                        if (stripos($value, $search) !== false) {
                            return true;
                        }
                    }
                    return false;
                });
            }
            
            // Get total rows
            $totalRows = count($allData);
            
            // Get only the specific columns we want for calling app
            $filteredData = [];
            foreach ($allData as $row) {
                $filteredRow = [];
                $filteredRow['full_name'] = $row['full_name'] ?? '';
                $filteredRow['business_name'] = $row['business_name'] ?? '';
                $filteredRow['email'] = $row['email'] ?? '';
                $filteredRow['whatsapp'] = $row['whatsapp'] ?? '';
                
                // Get who called this lead last - match all lead fields for accuracy
                $lastCall = MeetingCallDetail::where('lead_full_name', $row['full_name'] ?? '')
                    ->where('lead_business_name', $row['business_name'] ?? '')
                    ->where('lead_email', $row['email'] ?? '')
                    ->where('lead_whatsapp', $row['whatsapp'] ?? '')
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                $filteredRow['who_called'] = $lastCall ? $lastCall->called_by_employee_name : 'Not called yet';
                
                // Calculate best calling time based on history (now with persistent data)
                $bestCallingTime = $this->calculateBestCallingTime(
                    $row['full_name'] ?? '',
                    $row['email'] ?? '',
                    $row['whatsapp'] ?? '',
                    $row['business_name'] ?? ''
                );
                
                $filteredRow['best_calling_time'] = $bestCallingTime;
                $filteredData[] = $filteredRow;
            }
            
            // Calculate pagination
            $totalPages = ceil($totalRows / $perPage);
            $offset = ($page - 1) * $perPage;
            
            // Get page data
            $pageData = array_slice($filteredData, $offset, $perPage);
            
            return [
                'pageData' => $pageData,
                'headers' => ['full_name', 'business_name', 'email', 'whatsapp', 'who_called', 'best_calling_time'],
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRows' => $totalRows,
                'perPage' => $perPage,
                'search' => $search
            ];
            
        } catch (\Exception $e) {
            Log::error('Get calling app data error: ' . $e->getMessage());
            return [
                'pageData' => [],
                'headers' => ['full_name', 'business_name', 'email', 'whatsapp', 'who_called', 'best_calling_time'],
                'page' => 1,
                'totalPages' => 0,
                'totalRows' => 0,
                'perPage' => 50,
                'search' => ''
            ];
        }
    }

    /**
     * Show manual leads page
     */
    public function showManualLeads(Request $request)
    {
        // Check if this is an AJAX request
        $isAjax = $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest';
        
        try {
            // Get pagination parameters
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 50);
            $search = $request->get('search', '');
            
            // Get manually added leads from database
            $query = \App\Models\Lead::where('source', 'callingapp')
                ->orderBy('created_at', 'desc');
            
            // Apply search if provided
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('company_name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
                });
            }
            
            $manuallyAddedLeads = $query->get();
            
            // Debug: Log what we found
            \Log::info('Manual leads query executed: ' . $query->toSql());
            \Log::info('Manual leads found: ' . count($manuallyAddedLeads) . ' leads');
            \Log::info('Manual leads data: ' . json_encode($manuallyAddedLeads->toArray()));
            
            \Log::info('Manual leads page loaded - displaying only manually added leads');
            
            // Process manually added leads for display
            $pageData = [];
            foreach ($manuallyAddedLeads as $lead) {
                $filteredRow = [];
                $filteredRow['full_name'] = $lead->name ?? '';
                $filteredRow['business_name'] = $lead->company_name ?? '';
                $filteredRow['email'] = $lead->email ?? '';
                $filteredRow['whatsapp'] = $lead->phone ?? '';
                $filteredRow['who_called'] = 'Not called yet';
                $filteredRow['website_url'] = $lead->website ?? '';
                $filteredRow['business_type'] = $lead->industry ?? '';
                $filteredRow['primary_goal'] = $lead->description ?? '';
                // Extract budget range from notes field (new format) or budget field (old format)
                $budgetRange = '';
                
                // Try new format first (stored in notes)
                if ($lead->notes && strpos($lead->notes, '|BUDGET:') !== false) {
                    $budgetParts = explode('|BUDGET:', $lead->notes);
                    if (isset($budgetParts[1])) {
                        $budgetRange = trim($budgetParts[1]);
                    }
                }
                // Fallback to old format (stored in budget decimal field)
                elseif ($lead->budget) {
                    // For decimal budgets, show as single value without .00 if it's a whole number
                    if ($lead->budget == floor($lead->budget)) {
                        $budgetRange = number_format($lead->budget, 0);
                    } else {
                        $budgetRange = number_format($lead->budget, 2);
                    }
                }
                
                $filteredRow['budget_range'] = $budgetRange ? '₹' . $budgetRange : '';
                $filteredRow['score'] = $lead->score ?? '';
                $filteredRow['tier'] = $lead->lead_status ?? '';
                $filteredRow['submitted_at'] = $lead->follow_up_date ? $lead->follow_up_date->format('Y-m-d H:i:s') : ($lead->created_at ? $lead->created_at->format('Y-m-d H:i:s') : '');
                $filteredRow['audit_report'] = $lead->description ?? '';
                // Extract actual audit report plain text from notes field (remove budget data)
                $auditReportPlain = $lead->notes ?? '';
                if ($lead->notes && strpos($lead->notes, '|BUDGET:') !== false) {
                    $auditReportPlain = trim(explode('|BUDGET:', $lead->notes)[0]);
                }
                $filteredRow['audit_report_plain'] = $auditReportPlain;
                
                // Add best calling time (placeholder for manual leads)
                $filteredRow['best_calling_time'] = [
                    'time_range' => '9:00 AM - 11:00 AM',
                    'confidence' => 'low',
                    'interaction_count' => 0
                ];
                
                $pageData[] = $filteredRow;
            }
            
            // Calculate pagination
            $totalRows = count($pageData);
            $totalPages = ceil($totalRows / $perPage);
            $offset = ($page - 1) * $perPage;
            
            // Get page data
            $pageData = array_slice($pageData, $offset, $perPage);
            
            // If AJAX request, return only the table content
            if ($isAjax) {
                return response()->view('admin.google-sheets.calling-app-table', [
                    'pageData' => $pageData,
                    'headers' => ['full_name', 'business_name', 'email', 'whatsapp', 'who_called', 'best_calling_time'],
                    'page' => $page,
                    'totalPages' => $totalPages,
                    'totalRows' => $totalRows,
                    'perPage' => $perPage,
                    'search' => $search,
                    'error' => null
                ]);
            }
            
            return view('admin.google-sheets.calling-app', [
                'pageData' => $pageData,
                'headers' => ['full_name', 'business_name', 'email', 'whatsapp', 'who_called', 'best_calling_time'],
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRows' => $totalRows,
                'perPage' => $perPage,
                'search' => $search,
                'error' => null
            ]);
            
        } catch (\Exception $e) {
            Log::error('Show manual leads error: ' . $e->getMessage());
            
            return view('admin.google-sheets.calling-app', [
                'pageData' => [],
                'headers' => ['full_name', 'business_name', 'email', 'whatsapp', 'who_called', 'best_calling_time'],
                'page' => 1,
                'totalPages' => 0,
                'totalRows' => 0,
                'perPage' => 50,
                'search' => '',
                'error' => 'Failed to load manual leads. Please try again.'
            ]);
        }
    }

    /**
     * Show add leads form
     */
    public function showAddLeadsForm()
    {
        try {
            return view('admin.google-sheets.add-leads-form');
        } catch (\Exception $e) {
            Log::error('Show add leads form error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load add leads form');
        }
    }

    /**
     * Store lead from calling app
     */
    public function storeLeadFromCallingApp(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'business_name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'whatsapp' => 'nullable|string|max:20',
                'website_url' => 'nullable|url|max:255',
                'business_type' => 'nullable|string|max:255',
                'primary_goal' => 'nullable|string|max:255',
                'budget_range' => 'nullable|string|max:255',
                'score' => 'nullable|numeric',
                'tier' => 'nullable|string|in:hot,warm,cold,qualified,lost',
                'submitted_at' => 'nullable|date',
                'audit_report' => 'nullable|string',
                'audit_report_plain' => 'nullable|string',
            ]);

            // Store budget as text to preserve range format
            $budgetText = $validated['budget_range'] ?? null;

            // Create new lead
            $lead = \App\Models\Lead::create([
                'name' => $validated['full_name'],
                'company_name' => $validated['business_name'] ?? null,
                'email' => $validated['email'] ?? null,
                'phone' => $validated['whatsapp'] ?? null,
                'website' => $validated['website_url'] ?? null,
                'industry' => $validated['business_type'] ?? null, // industry field exists in database
                'description' => $validated['primary_goal'] ?? null, // description field exists
                'budget' => null, // Keep decimal field null, store range in description
                'lead_status' => $validated['tier'] ?? 'cold', // lead_status field exists
                'follow_up_date' => $validated['submitted_at'] ?? null, // follow_up_date field exists
                'notes' => ($validated['audit_report_plain'] ?? '') . '|BUDGET:' . ($budgetText ?? ''), // Store budget in notes
                'source' => 'callingapp',
                'created_by' => auth()->id() ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Debug: Log the created lead
            \Log::info('Lead created successfully: ' . json_encode([
                'id' => $lead->id,
                'name' => $lead->name,
                'company_name' => $lead->company_name,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'source' => $lead->source
            ]));

            return redirect()->route('callingapp.manual-leads')->with('success', 'Lead added successfully!');

        } catch (\Exception $e) {
            Log::error('Store lead error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add lead: ' . $e->getMessage());
        }
    }

    /**
     * Get lead data for transfer to leads management
     */
    public function getLeadDataForTransfer($index)
    {
        try {
            // Get all data from Google Sheets
            $allData = $this->googleSheetsService->getMappedData();
            
            // Reverse the data order to match calling app
            $allData = array_reverse($allData);
            
            // Get the specific lead by index
            if (!isset($allData[$index])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lead not found'
                ], 404);
            }
            
            $lead = $allData[$index];
            
            // Map the fields according to the requirements
            $mappedData = [
                'name' => $lead['full_name'] ?? '',
                'company_name' => $lead['business_name'] ?? '',
                'email' => $lead['email'] ?? '',
                'phone' => $lead['whatsapp'] ?? '',
                'website' => $lead['website_url'] ?? '',
                'industry' => $lead['business_type'] ?? '',
                'budget' => $lead['budget_range'] ?? '',
                'lead_status' => $this->mapTierToStatus($lead['tier'] ?? ''),
                'description' => $lead['audit_report'] ?? '',
                'notes' => $lead['audit_report_plain'] ?? '',
                // Additional fields that don't have direct mapping
                'primary_goal' => $lead['primary_goal'] ?? '',
                'score' => $lead['score'] ?? '',
                'submitted_at' => $lead['submitted_at'] ?? '',
                'tier' => $lead['tier'] ?? ''
            ];
            
            return response()->json([
                'success' => true,
                'lead_data' => $mappedData
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get lead data for transfer error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to get lead data'
            ], 500);
        }
    }
}
