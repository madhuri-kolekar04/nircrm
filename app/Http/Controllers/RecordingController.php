<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleSheetsServicePublic;

class RecordingController extends Controller
{
    protected $googleSheetsService;
    
    public function __construct(GoogleSheetsServicePublic $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }
    
    /**
     * Send Firebase notification to all users
     */
    private function sendFirebaseNotification($title, $message, $targetUrl)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        // Get Firebase Server Key from environment variables
        $serverKey = env('FIREBASE_SERVER_KEY', 'YOUR_FIREBASE_SERVER_KEY_HERE');
        
        // Don't send notification if server key is not configured
        if ($serverKey === 'YOUR_FIREBASE_SERVER_KEY_HERE' || empty($serverKey)) {
            \Log::warning('Firebase notification not sent - Server key not configured');
            return false;
        }

        $data = [
            "to" => "/topics/all_users", // Send to everyone subscribed to "all_users"
            "notification" => [
                "title" => $title,
                "body" => $message,
                "sound" => "default",
                "click_action" => "FLUTTER_NOTIFICATION_CLICK"
            ],
            "data" => [
                "title" => $title,
                "message" => $message,
                "target_url" => $targetUrl
            ],
            "priority" => "high"
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\nAuthorization: key=" . $serverKey . "\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ],
        ];

        $context = stream_context_create($options);
        
        try {
            $result = file_get_contents($url, false, $context);
            \Log::info('Firebase notification sent successfully', ['response' => $result]);
            return $result;
        } catch (\Exception $e) {
            \Log::error('Firebase notification failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
    public function sync(Request $request)
    {
        // Log incoming request data for debugging
        \Log::info('Recording sync attempt', [
            'has_file' => $request->hasFile('audio'),
            'all_data' => $request->all(),
            'files' => $request->files->all()
        ]);

        // 1. Validate the incoming request
        // The keys here must match the @Part names in your Android ApiService.kt
        try {
            $request->validate([
                'customer_phone' => 'required',
                'customer_name'  => 'required',
                'file_name'      => 'required',
                'employee_name'  => 'required',
                'sync_type'      => 'required',
                'audio'          => 'required|file|mimes:mp3,wav,m4a,amr,3gp', // Validate file type
            ]);
            \Log::info('Validation passed');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed: ' . implode(', ', $e->errors()->all())
            ], 422);
        }

        try {
            // 2. Handle the File Upload (Direct Public Storage - No storage:link needed)
            if ($request->hasFile('audio')) {
                $file = $request->file('audio');
                $fileName = $request->file_name;
                
                \Log::info('File upload started', [
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType()
                ]);
                
                // Create public/recordings directory if it doesn't exist
                $publicPath = public_path('recordings');
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0755, true);
                    \Log::info('Created recordings directory');
                }
                
                // Move file directly to public/recordings (no storage system needed)
                $file->move($publicPath, $fileName);
                \Log::info('File moved successfully', ['path' => $publicPath . '/' . $fileName]);
                
                // Generate direct URL for web access
                $fileUrl = url('recordings/' . $fileName);
                \Log::info('URL generated', ['file_url' => $fileUrl]);

                // 3. Insert into Database
                $insertData = [
                    'customer_phone' => $request->customer_phone,
                    'customer_name'  => $request->customer_name,
                    'file_name'      => $request->file_name,
                    'employee_name'  => $request->employee_name,
                    'sync_type'      => $request->sync_type,
                    'file_url'       => $fileUrl, // Direct public URL
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
                
                \Log::info('Attempting database insert', ['data' => $insertData]);
                
                DB::table('call_recordings')->insert($insertData);
                
                \Log::info('Database insert successful');
                
                // Send Firebase notification after successful recording
                $notificationTitle = "New Recording";
                $notificationMessage = "A new call from {$request->customer_name} ({$request->customer_phone}) was recorded";
                $targetUrl = url('/allrecordingcall');
                
                $this->sendFirebaseNotification($notificationTitle, $notificationMessage, $targetUrl);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Recording stored successfully',
                    'file_url' => $fileUrl
                ], 200);
            }

            \Log::error('No audio file found in request');
            return response()->json(['status' => 'error', 'message' => 'No audio file found'], 400);

        } catch (\Exception $e) {
            \Log::error('Sync failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Sync failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCount(Request $request)
    {
        // Get phone number from request (optional)
        $phone = $request->input('phone');
        
        if ($phone) {
            // Count recordings for specific phone number
            $count = DB::table('call_recordings')
                ->where('customer_phone', $phone)
                ->count();
                
            return response()->json([
                'status' => 'success',
                'phone' => $phone,
                'recording_count' => $count,
                'message' => "Found {$count} recordings for phone {$phone}"
            ], 200);
        } else {
            // Count all recordings
            $totalCount = DB::table('call_recordings')->count();
            $manualCount = DB::table('call_recordings')->where('sync_type', 'Manual')->count();
            $autoSyncCount = DB::table('call_recordings')->where('sync_type', 'AutoSync')->count();
            
            return response()->json([
                'status' => 'success',
                'total_recordings' => $totalCount,
                'manual_sync_count' => $manualCount,
                'auto_sync_count' => $autoSyncCount,
                'message' => "Total recordings: {$totalCount}"
            ], 200);
        }
    }

    public function allRecordings()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('callingapp.login')->with('error', 'Please login to access recordings.');
        }
        
        $user = Auth::user();
        
        // Get recordings based on user role
        $query = DB::table('call_recordings')->orderBy('created_at', 'desc');
        
        // If user is Employee (role 2), show only their own recordings
        if ($user->role == 2) {
            $query->where('employee_name', $user->name);
        }
        // If user is Admin (role 1), show all recordings (no additional filter needed)
        
        $recordings = $query->get();
            
        // Get Google Sheets data to match customer names using the injected service
        // Use cache to prevent network-dependent behavior
        $phoneToNameMap = Cache::remember('google_sheets_phone_name_map', 300, function () {
            try {
                $allCustomers = $this->googleSheetsService->getMappedData();
                
                // Create phone to name mapping from Google Sheets
                $map = [];
                foreach ($allCustomers as $customer) {
                    $phone = $customer['whatsapp'] ?? '';
                    $fullName = $customer['full_name'] ?? '';
                    if (!empty($phone) && !empty($fullName)) {
                        $map[$phone] = $fullName;
                    }
                }
                
                \Log::info('Google Sheets data cached successfully', ['count' => count($map)]);
                return $map;
            } catch (\Exception $e) {
                // If Google Sheets fails, return empty mapping and log error
                \Log::error('Google Sheets fetch error in recordings: ' . $e->getMessage());
                return [];
            }
        });
        
        // Add customer full name to each recording (from cached data)
        foreach ($recordings as $recording) {
            $recording->customer_full_name = $phoneToNameMap[$recording->customer_phone] ?? null;
        }
        
        // Organize recordings by date
        $todayRecordings = [];
        $yesterdayRecordings = [];
        $pastRecordings = [];
        
        $today = now()->startOfDay();
        $yesterday = now()->subDay()->startOfDay();
        
        foreach ($recordings as $recording) {
            $recordingDate = \Carbon\Carbon::parse($recording->created_at)->startOfDay();
            
            if ($recordingDate->eq($today)) {
                $todayRecordings[] = $recording;
            } elseif ($recordingDate->eq($yesterday)) {
                $yesterdayRecordings[] = $recording;
            } else {
                $pastRecordings[] = $recording;
            }
        }
            
        return view('allrecordingcall', compact('todayRecordings', 'yesterdayRecordings', 'pastRecordings', 'recordings'));
    }
}
