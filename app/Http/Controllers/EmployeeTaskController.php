<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTask;
use App\Models\User;
use App\Models\BiometricCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Google\Client as GoogleClient;
use Google\Service\Sheets as GoogleSheets;
use Google\Service\Sheets\ValueRange;

class EmployeeTaskController extends Controller
{
    /**
     * Show employee login page
     */
    public function showLogin()
    {
        return view('employee.login');
    }

    /**
     * Handle employee login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        // Check if user exists and has valid role
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
        
        // Allow access if user has valid role or no role set (for backward compatibility)
        if ($user->role && !in_array($user->role, [1, 2])) {
            return back()->withErrors([
                'email' => 'You are not authorized to access this system.',
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Store login origin in session for logout redirection
            $loginOrigin = $request->input('login_origin', 'employee_portal');
            $request->session()->put('login_origin', $loginOrigin);
            
            // Set cookie for "stay logged in" functionality using Laravel's built-in remember
            if ($request->has('remember')) {
                $rememberDuration = 43200; // 30 days
                cookie()->queue('employee_remember', 'true', $rememberDuration);
            }
            
            // Redirect based on user role
            $user = Auth::user();
            
            // Determine user role
            $userRole = $user->role;
            $userPosition = strtolower($user->position ?? '');
            
            // If role is not set, determine from position
            if (!$userRole) {
                if ($userPosition === 'admin') {
                    $userRole = 1;
                } else {
                    $userRole = 2; // Default to employee
                }
            }
            
            if ($userRole === 1) {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/niremptask');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Show employee task dashboard
     */
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user();
        $tasks = EmployeeTask::where('user_id', $user->id)
            ->orderBy('task_date', 'desc')
            ->orderBy('task_number', 'asc')
            ->get();

        // Calculate statistics
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'completed')->count();
        $pendingTasks = $tasks->where('status', 'pending')->count();
        $inProgressTasks = $tasks->where('status', 'in_progress')->count();

        return view('employee.dashboard', compact('tasks', 'user', 'totalTasks', 'completedTasks', 'pendingTasks', 'inProgressTasks'));
    }

    /**
     * Get filtered tasks for employee
     */
    public function getFilteredTasks(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $user = Auth::user();
            $query = EmployeeTask::where('user_id', $user->id);

            // Debug: Log request data
            Log::info('Filter request received:', [
                'user_id' => $user->id,
                'all_request_data' => $request->all(),
                'date_from' => $request->input('date_from'),
                'date_to' => $request->input('date_to'),
                'status' => $request->input('status'),
                'search' => $request->input('search'),
                'client' => $request->input('client'),
                'is_mobile' => $request->header('User-Agent') ? preg_match('/Mobile|Android|iPhone|iPad/', $request->header('User-Agent')) : false
            ]);

            // Filter by date range
            if ($request->filled('date_from')) {
                Log::info('Applying date_from filter: ' . $request->date_from);
                $query->whereDate('task_date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                Log::info('Applying date_to filter: ' . $request->date_to);
                $query->whereDate('task_date', '<=', $request->date_to);
            }

            // Filter by status (handle both single value and array)
            if ($request->filled('status')) {
                if (is_array($request->status)) {
                    // Handle array from checkboxes
                    Log::info('Applying status array filter: ' . json_encode($request->status));
                    if (!empty(array_filter($request->status))) {
                        $query->whereIn('status', $request->status);
                    }
                } else {
                    // Handle single value from dropdown
                    Log::info('Applying single status filter: ' . $request->status);
                    $query->where('status', $request->status);
                }
            }

            // Filter by search term (task description and client project name)
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                Log::info('Applying search filter: ' . $searchTerm);
                $query->where(function($q) use ($searchTerm) {
                    $q->where('task_description', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('client_project_name', 'LIKE', "%{$searchTerm}%");
                });
            }

            // Filter by client/project name specifically
            if ($request->filled('client')) {
                Log::info('Applying client filter: ' . $request->client);
                $query->where('client_project_name', 'LIKE', "%{$request->client}%");
            }

            $tasks = $query->orderBy('task_date', 'desc')
                            ->orderBy('task_number', 'desc')
                            ->get();

            Log::info('Filter results: ' . $tasks->count() . ' tasks found');

            return response()->json([
                'success' => true,
                'tasks' => $tasks,
                'total' => $tasks->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error filtering tasks: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error filtering tasks. Please try again.'
            ], 500);
        }
    }

    /**
     * Store a new task
     */
    public function storeTask(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'task_date' => 'required|date',
            'task_description' => 'required|string',
            'client_project_name' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed,stopped,on_hold',
        ]);

        try {
            $user = Auth::user();
            
            // Get the next task number for the given date
            $lastTask = EmployeeTask::where('user_id', $user->id)
                ->whereDate('task_date', $request->task_date)
                ->orderBy('task_number', 'desc')
                ->first();
            
            $taskNumber = $lastTask ? $lastTask->task_number + 1 : 1;

            $task = EmployeeTask::create([
                'user_id' => $user->id,
                'task_date' => $request->task_date,
                'task_description' => $request->task_description,
                'client_project_name' => $request->client_project_name,
                'status' => $request->status,
                'task_number' => $taskNumber,
            ]);

            // Debug: Log the created task data
            Log::info('Task created successfully:', [
                'task_id' => $task->id,
                'task_number' => $task->task_number,
                'task_description' => $task->task_description,
                'client_project_name' => $task->client_project_name,
                'status' => $task->status,
                'task_date' => $task->task_date,
                'user_id' => $task->user_id,
            ]);

            // Email notification removed - use daily tasks email feature instead
            // This prevents spamming admins with individual task emails

            return response()->json([
                'success' => true,
                'message' => 'Task added successfully',
                'task' => $task
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating task: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show task for editing
     */
    public function editTask($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $task = EmployeeTask::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'task' => [
                'id' => $task->id,
                'task_date' => $task->task_date->format('Y-m-d\TH:i'),
                'task_description' => $task->task_description,
                'client_project_name' => $task->client_project_name,
                'status' => $task->status,
            ]
        ]);
    }

    /**
     * Update a task
     */
    public function updateTask(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $task = EmployeeTask::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'task_date' => 'required|date',
            'task_description' => 'required|string',
            'client_project_name' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed,stopped,on_hold',
        ]);

        try {
            $task->update([
                'task_date' => $request->task_date,
                'task_description' => $request->task_description,
                'client_project_name' => $request->client_project_name,
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully',
                'task' => $task
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating task: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a task
     */
    public function deleteTask($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $task = EmployeeTask::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        try {
            $task->delete();
            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting task: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sync tasks to Google Sheets
     */
    public function syncToGoogleSheets(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'employee_name' => 'required|string|in:Manali,Kiran,Mohit,Shubham,Prathamesh'
        ]);

        try {
            $user = Auth::user();
            $tasks = EmployeeTask::where('user_id', $user->id)->get();

            // Initialize Google Sheets API
            $client = new GoogleClient();
            $client->setApplicationName('NIRCRM Employee Task Sync');
            $client->setScopes([GoogleSheets::SPREADSHEETS]);
            $client->setAuthConfig(base_path('storage/app/google-credentials.json'));
            
            $service = new GoogleSheets($client);
            
            $spreadsheetId = '125KWWjtxDw4iriHc1qzeuX3KPb_04NkbTBnEqliwnNk';
            $range = $request->employee_name . '!A:E'; // Columns: Date, Task Description, Client/Project, Status, Task Number
            
            // Prepare data for Google Sheets
            $values = [];
            foreach ($tasks as $task) {
                $values[] = [
                    $task->task_date->format('Y-m-d H:i:s'),
                    $task->task_number . '. ' . $task->task_description,
                    $task->client_project_name,
                    $task->status,
                    $task->task_number
                ];
            }
            
            $body = new ValueRange(['values' => $values]);
            $params = ['valueInputOption' => 'RAW'];
            
            // Clear existing data and insert new data
            $service->spreadsheets_values->clear($spreadsheetId, $range);
            $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);

            Log::info('Tasks synced to Google Sheets for user: ' . $user->email . ', Employee: ' . $request->employee_name);

            return response()->json([
                'success' => true,
                'message' => 'Tasks synced successfully to Google Sheets',
                'updated_cells' => $result->getUpdates()->getUpdatedCells()
            ]);

        } catch (\Exception $e) {
            Log::error('Error syncing to Google Sheets: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error syncing to Google Sheets: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get task details for admin modal
     */
    public function getTaskDetails($taskId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $task = EmployeeTask::with(['user' => function($query) {
                $query->select('id', 'name', 'email');
            }])
            ->findOrFail($taskId);

        return response()->json($task);
    }

    /**
     * Show all CRM tasks for admin
     */
    public function adminCrmTasks(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        // Get all employee tasks with user information
        $tasks = EmployeeTask::with(['user' => function($query) {
                $query->select('id', 'name', 'email');
            }])
            ->orderBy('task_date', 'desc')
            ->orderBy('task_number', 'asc')
            ->get();

        // Get task statistics
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'completed')->count();
        $pendingTasks = $tasks->where('status', 'pending')->count();
        $inProgressTasks = $tasks->where('status', 'in_progress')->count();

        return view('admin.crm-tasks', compact('tasks', 'totalTasks', 'completedTasks', 'pendingTasks', 'inProgressTasks'));
    }

    /**
     * Logout employee
     */
    public function logout(Request $request)
    {
        // Get login origin before logout
        $loginOrigin = session('login_origin', 'employee_portal');
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Clear remember cookie
        cookie()->queue(cookie()->forget('employee_remember'));
        
        // Redirect based on login origin
        if ($loginOrigin === 'crmlogin') {
            // User logged in from CRM login, redirect back to CRM login
            return redirect()->route('crmlogin')->with('clear_splash', true);
        } else {
            // User logged in from employee portal, redirect to home page
            return redirect('/')->with('clear_splash', true);
        }
    }

    /**
     * Get biometric challenge for authentication
     */
    public function getBiometricChallenge(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $challenge = random_bytes(32);
        $challengeBase64 = base64_encode($challenge);
        
        // Store challenge in session for verification
        session(['biometric_challenge' => $challengeBase64]);
        
        // Get existing biometric credentials for this user
        $credentials = BiometricCredential::forUser($user->id)
            ->active()
            ->get(['credential_id', 'device_name', 'biometric_type']);

        return response()->json([
            'challenge' => $challengeBase64,
            'user_id' => $user->id,
            'credentials' => $credentials,
            'allowCredentials' => $credentials->map(function($cred) {
                return [
                    'id' => $cred->credential_id,
                    'type' => 'public-key',
                    'transports' => ['internal', 'usb', 'nfc', 'ble'],
                ];
            })->toArray()
        ]);
    }

    /**
     * Register new biometric credential
     */
    public function registerBiometric(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'credential_id' => 'required|string',
            'public_key' => 'required|string',
            'device_name' => 'nullable|string|max:255',
            'biometric_type' => 'nullable|string|in:fingerprint,face_id,voice,pattern',
        ]);

        $user = Auth::user();

        try {
            // Check if credential already exists
            $existingCredential = BiometricCredential::where('credential_id', $request->credential_id)
                ->where('user_id', $user->id)
                ->first();

            if ($existingCredential) {
                // Update existing credential
                $existingCredential->update([
                    'public_key' => $request->public_key,
                    'device_name' => $request->device_name,
                    'biometric_type' => $request->biometric_type,
                    'last_used_at' => now(),
                ]);
            } else {
                // Create new credential
                BiometricCredential::create([
                    'user_id' => $user->id,
                    'credential_id' => $request->credential_id,
                    'public_key' => $request->public_key,
                    'device_name' => $request->device_name ?: 'Unknown Device',
                    'biometric_type' => $request->biometric_type ?: 'fingerprint',
                    'last_used_at' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Biometric credential registered successfully',
            ]);

        } catch (\Exception $e) {
            Log::error('Error registering biometric credential: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error registering biometric credential',
            ], 500);
        }
    }

    /**
     * Authenticate with biometric
     */
    public function authenticateBiometric(Request $request)
    {
        $request->validate([
            'credential_id' => 'required|string',
            'authenticator_data' => 'required|string',
            'signature' => 'required|string',
            'client_data' => 'required|string',
        ]);

        try {
            // Get stored challenge from session
            $storedChallenge = session('biometric_challenge');
            if (!$storedChallenge) {
                return response()->json(['error' => 'No challenge found'], 400);
            }

            // Find biometric credential
            $credential = BiometricCredential::where('credential_id', $request->credential_id)
                ->with('user')
                ->first();

            if (!$credential) {
                return response()->json(['error' => 'Credential not found'], 404);
            }

            // Verify the signature (simplified for demo)
            // In production, you'd use proper WebAuthn verification
            $isValid = $this->verifyBiometricSignature(
                $request->authenticator_data,
                $request->signature,
                $request->client_data,
                $storedChallenge,
                $credential->public_key
            );

            if ($isValid) {
                // Update last used timestamp
                $credential->update(['last_used_at' => now()]);
                
                // Clear challenge from session
                session()->forget('biometric_challenge');
                
                // Login the user
                Auth::login($credential->user);
                $request->session()->regenerate();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Biometric authentication successful',
                    'redirect' => $credential->user->role === 1 ? '/admin/dashboard' : '/niremptask'
                ]);
            } else {
                return response()->json(['error' => 'Invalid biometric signature'], 401);
            }

        } catch (\Exception $e) {
            Log::error('Error during biometric authentication: ' . $e->getMessage());
            return response()->json(['error' => 'Authentication failed'], 500);
        }
    }

    /**
     * Verify biometric signature (simplified version)
     */
    private function verifyBiometricSignature($authenticatorData, $signature, $clientData, $challenge, $publicKey)
    {
        // This is a simplified verification for demonstration
        // In production, use proper WebAuthn verification libraries
        
        try {
            // For demo purposes, we'll accept valid base64 data
            // Real implementation would verify cryptographic signature
            $decodedSignature = base64_decode($signature);
            $decodedPublicKey = base64_decode($publicKey);
            
            // Basic validation - check if data exists and is properly formatted
            if (!empty($decodedSignature) && !empty($decodedPublicKey) && !empty($challenge)) {
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('Signature verification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete biometric credential
     */
    public function deleteBiometricCredential(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'credential_id' => 'required|string',
        ]);

        $user = Auth::user();

        try {
            $credential = BiometricCredential::where('credential_id', $request->credential_id)
                ->where('user_id', $user->id)
                ->first();

            if (!$credential) {
                return response()->json(['error' => 'Credential not found'], 404);
            }

            // Delete the credential
            $credential->delete();

            return response()->json([
                'success' => true,
                'message' => 'Biometric credential deleted successfully',
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting biometric credential: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting biometric credential',
            ], 500);
        }
    }

    
    /**
     * Send daily tasks email
     */
    public function sendDailyTasksEmail(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'date_label' => 'required|string',
            'tasks' => 'required|array',
            'tasks.*.id' => 'required|integer',
            'tasks.*.task_number' => 'required|integer',
            'tasks.*.task_description' => 'required|string',
            'tasks.*.client_project_name' => 'required|string',
            'tasks.*.status' => 'required|string',
            'tasks.*.task_date' => 'required|string',
        ]);

        try {
            Log::info('sendDailyTasksEmail called with request data:', [
                'date_label' => $request->date_label,
                'tasks_count' => is_array($request->tasks) ? count($request->tasks) : 'not an array',
                'tasks_data' => $request->tasks
            ]);

            $user = Auth::user();
            $dateLabel = $request->date_label;
            $tasks = $request->tasks;

            Log::info('User and basic data extracted:', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'date_label' => $dateLabel
            ]);

            // Get all admin users (role = 1)
            $adminUsers = User::where('role', 1)->where('email', '!=', $user->email)->get();
            
            Log::info('Admin users found:', ['count' => $adminUsers->count()]);
            
            // Additional specified email addresses
            $additionalEmails = [
                'kiran@niranjanenterprises.com',
                'contact@niranjanenterprises.com'
            ];
            
            // Combine admin emails and additional emails, remove duplicates
            $recipients = [];
            
            // Add admin user emails
            foreach ($adminUsers as $admin) {
                if (!empty($admin->email)) {
                    $recipients[] = $admin->email;
                }
            }
            
            // Add additional specified emails
            $recipients = array_merge($recipients, $additionalEmails);
            
            // Remove duplicates and filter empty values
            $recipients = array_unique(array_filter($recipients));
            
            if (empty($recipients)) {
                Log::warning('No valid email recipients found for daily tasks email');
                return response()->json([
                    'success' => false,
                    'message' => 'No valid email recipients found'
                ], 400);
            }
            
            $data = [
                'user' => $user,
                'dateLabel' => $dateLabel,
                'tasks' => $tasks,
                'totalTasks' => count($tasks)
            ];
            
            Log::info('Sending daily tasks email:', [
                'user_id' => $user->id,
                'date_label' => $dateLabel,
                'total_tasks' => count($tasks),
                'recipients' => $recipients
            ]);
            
            // Send email to all recipients
            Log::info('Attempting to send email with data:', [
                'template' => 'mail.daily-tasks-notification',
                'recipients' => $recipients,
                'subject' => "Daily Tasks Summary - {$dateLabel} by {$user->name}",
                'from_address' => config('mail.from.address'),
                'from_name' => config('mail.from.name')
            ]);

            try {
                Mail::send('mail.daily-tasks-notification', $data, function ($message) use ($user, $dateLabel, $recipients) {
                    $message->to($recipients)
                            ->subject("Daily Tasks Summary - {$dateLabel} by {$user->name}")
                            ->from(config('mail.from.address'), config('mail.from.name'));
                });
                
                Log::info('Daily tasks email sent successfully to recipients: ' . implode(', ', $recipients));
            } catch (\Exception $mailError) {
                Log::error('Mail sending failed with error: ' . $mailError->getMessage());
                Log::error('Mail error details: ', [
                    'error' => $mailError->getMessage(),
                    'file' => $mailError->getFile(),
                    'line' => $mailError->getLine(),
                    'trace' => $mailError->getTraceAsString()
                ]);
                throw $mailError;
            }

            return response()->json([
                'success' => true,
                'message' => 'Daily tasks email sent successfully to ' . count($recipients) . ' recipient(s)',
                'total_tasks' => count($tasks),
                'recipients' => $recipients
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending daily tasks email: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sending daily tasks email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send task notification email to all admins and specified recipients
     */
    private function sendTaskNotificationEmail($user, $task)
    {
        // Get all admin users (role = 1)
        $adminUsers = User::where('role', 1)->where('email', '!=', $user->email)->get();
        
        // Additional specified email addresses
        $additionalEmails = [
            'kiran@niranjanenterprises.com',
            'contact@niranjanenterprises.com'
        ];
        
        // Combine admin emails and additional emails, remove duplicates
        $recipients = [];
        
        // Add admin user emails
        foreach ($adminUsers as $admin) {
            if (!empty($admin->email)) {
                $recipients[] = $admin->email;
            }
        }
        
        // Add additional specified emails
        $recipients = array_merge($recipients, $additionalEmails);
        
        // Remove duplicates and filter empty values
        $recipients = array_unique(array_filter($recipients));
        
        if (empty($recipients)) {
            Log::warning('No valid email recipients found for task notification');
            return;
        }
        
        $data = [
            'user' => $user,
            'task' => $task,
        ];
        
        // Debug logging to verify task data
        Log::info('Task data being sent to email:', [
            'task_id' => $task->id,
            'task_number' => $task->task_number,
            'task_description' => $task->task_description,
            'client_project_name' => $task->client_project_name,
            'status' => $task->status,
            'task_date' => $task->task_date,
        ]);
        
        // Send email to all recipients
        Mail::send('mail.new-task-notification', $data, function ($message) use ($user, $task, $recipients) {
            $message->to($recipients)
                    ->subject('New Task Created - #' . $task->task_number . ' by ' . $user->name)
                    ->from(config('mail.from.address'), config('mail.from.name'));
        });
        
        Log::info('Task notification email sent to recipients: ' . implode(', ', $recipients));
    }
}
