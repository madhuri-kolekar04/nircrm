<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Department;
use App\Models\Leave;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AttendanceNotification;
use App\Mail\LeaveRequestNotification;
use App\Mail\OffTimeLoginNotification;

class AttendanceController extends Controller
{
    public function dashboard()
    {
        try {
            $user = Auth::user();
            $today = Carbon::today();
            
            // Get users based on role and department filtering
            $users = $this->getFilteredUsers($user);
            
            // Get today's attendance for filtered users
            $todayAttendances = Attendance::with('user')
                ->whereIn('user_id', $users->pluck('id'))
                ->where('date', $today)
                ->get()
                ->keyBy('user_id');
            
            // Get attendance statistics
            $stats = $this->getAttendanceStats($users, $today);
            
            // Get recent leave requests (for managers and admins)
            $recentLeaves = collect();
            if ($user->canApproveLeave()) {
                $recentLeaves = Leave::with(['user', 'leaveType'])
                    ->whereIn('user_id', $users->pluck('id'))
                    ->pending()
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
            }
            
            // Get monthly attendance summary
            $monthlyStats = $this->getMonthlyStats($users);
            
            // Get shifts for user management modal
            $shifts = \App\Models\Shift::where('is_active', true)->get();
            
            return view('attendance.dashboard', compact(
                'users', 
                'todayAttendances', 
                'stats', 
                'recentLeaves', 
                'monthlyStats',
                'user',
                'shifts'
            ));
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Dashboard Error: ' . $e->getMessage());
            
            // Return a simple error view
            return view('errors.500', [
                'error' => 'Dashboard loading failed: ' . $e->getMessage()
            ]);
        }
    }
    
    private function getFilteredUsers($user)
    {
        $query = User::where('is_active', true)->with(['department', 'shift']);
        
        switch ($user->role) {
            case 1: // Admin - Can see all users
                break;
            case 5: // General Manager - Can see all users
                break;
            case 4: // Manager - Can see department users and subordinates
                $query->where(function ($q) use ($user) {
                    // Get department users
                    if ($user->department_id) {
                        $q->where('department_id', $user->department_id);
                    }
                    // Get direct subordinates
                    $q->orWhere('manager_id', $user->id);
                    // Get all subordinate IDs recursively
                    $subordinateIds = $user->getSubordinatesIds();
                    if (!empty($subordinateIds)) {
                        $q->orWhereIn('id', $subordinateIds);
                    }
                });
                break;
            case 2: // Employee - Can only see themselves
                $query->where('id', $user->id);
                break;
            case 3: // Customer - Limited access
                $query->where('id', $user->id);
                break;
            default:
                $query->where('id', $user->id);
        }
        
        return $query->get();
    }
    
    private function getAttendanceStats($users, $date)
    {
        $userIds = $users->pluck('id');
        $attendances = Attendance::whereIn('user_id', $userIds)
            ->where('date', $date)
            ->get();
        
        $total = $users->count();
        $present = $attendances->where('status', 'present')->count();
        $absent = $attendances->where('status', 'absent')->count();
        $onLeave = $attendances->where('status', 'on_leave')->count();
        $halfDay = $attendances->where('status', 'half_day')->count();
        $notMarked = $total - $attendances->count();
        
        // Ensure all keys are present with default values
        return [
            'total' => $total ?? 0,
            'present' => $present ?? 0,
            'absent' => $absent ?? 0,
            'onLeave' => $onLeave ?? 0,
            'halfDay' => $halfDay ?? 0,
            'notMarked' => $notMarked ?? 0
        ];
    }
    
    private function getMonthlyStats($users)
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $attendances = Attendance::whereIn('user_id', $users->pluck('id'))
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get();
        
        $workingDays = Carbon::now()->diffInDays($startOfMonth) + 1;
        $weekends = 0;
        
        for ($date = $startOfMonth->copy(); $date <= $endOfMonth; $date->addDay()) {
            if ($date->isWeekend()) {
                $weekends++;
            }
        }
        
        $totalWorkingDays = $workingDays - $weekends;
        
        // Ensure all keys are present with default values
        return [
            'totalDays' => $workingDays ?? 0,
            'workingDays' => $totalWorkingDays ?? 0,
            'weekends' => $weekends ?? 0,
            'totalPresent' => $attendances->where('status', 'present')->count() ?? 0,
            'totalAbsent' => $attendances->where('status', 'absent')->count() ?? 0,
            'totalLeave' => $attendances->where('status', 'on_leave')->count() ?? 0,
            'totalHalfDay' => $attendances->where('status', 'half_day')->count() ?? 0,
        ];
    }
    
    public function checkIn(Request $request)
    {
        try {
            \Log::info('Check-in attempt started', [
                'user_id' => Auth::id(),
                'ip' => $request->ip(),
                'request_data' => $request->all()
            ]);
            
            $user = Auth::user();
            $today = Carbon::today();
            
            // Check if user is active
            if (!$user->is_active) {
                \Log::warning('Check-in denied: User inactive', ['user_id' => $user->id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is deactivated. Please contact administrator.'
                ]);
            }
            
            // Check if already checked in
            $existingAttendance = Attendance::where('user_id', $user->id)
                ->where('date', $today)
                ->first();
                
            if ($existingAttendance && $existingAttendance->check_in_time) {
                \Log::info('Check-in denied: Already checked in', [
                    'user_id' => $user->id,
                    'existing_time' => $existingAttendance->check_in_time
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Already checked in today'
                ]);
            }
            
            // Create or update attendance
            $attendance = $existingAttendance ?: new Attendance();
            $attendance->user_id = $user->id;
            $attendance->date = $today;
            $attendance->check_in_time = Carbon::now();
            $attendance->status = 'present';
            $attendance->ip_address = $request->ip();
            $attendance->location = $request->input('location', 'Office');
            
            // Check if within shift time and late arrival
            $currentTime = Carbon::now();
            $isOffTime = false;
            
            if ($user->shift) {
                $shift = $user->shift;
                $attendance->is_late = $shift->isLateCheckIn($currentTime);
                $isOffTime = !$shift->isWithinShiftTime($currentTime);
            } else {
                // Default shift logic (9:00 AM to 6:00 PM)
                $startTime = Carbon::parse('09:00:00');
                $attendance->is_late = $currentTime->greaterThan($startTime);
                $isOffTime = $currentTime->hour < 9 || $currentTime->hour >= 18;
            }
            
            $attendance->save();
            
            \Log::info('Check-in successful', [
                'attendance_id' => $attendance->id,
                'user_id' => $user->id,
                'check_in_time' => $attendance->check_in_time,
                'is_late' => $attendance->is_late,
                'is_off_time' => $isOffTime
            ]);
            
            // Send email notifications for late check-in
            if ($attendance->is_late) {
                try {
                    $this->sendLateCheckInNotification($user, $currentTime);
                } catch (\Exception $e) {
                    \Log::error('Late check-in notification failed', [
                        'error' => $e->getMessage(),
                        'user_id' => $user->id
                    ]);
                }
            }
            
            // Send off-time login notification to hierarchy
            if ($isOffTime) {
                try {
                    $this->sendOffTimeLoginNotification($user, $currentTime);
                } catch (\Exception $e) {
                    \Log::error('Off-time notification failed', [
                        'error' => $e->getMessage(),
                        'user_id' => $user->id
                    ]);
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Checked in successfully',
                'data' => $attendance,
                'is_off_time' => $isOffTime
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Check-in failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Check-in failed: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        
        // Check if user is active
        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is deactivated. Please contact administrator.'
            ]);
        }
        
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();
            
        if (!$attendance || !$attendance->check_in_time) {
            return response()->json([
                'success' => false,
                'message' => 'No check-in record found for today'
            ]);
        }
        
        if ($attendance->check_out_time) {
            return response()->json([
                'success' => false,
                'message' => 'Already checked out today'
            ]);
        }
        
        $attendance->check_out_time = Carbon::now();
        $attendance->location = $request->input('location', 'Office');
        
        // Check if early checkout based on shift
        $checkOutTime = Carbon::parse($attendance->check_out_time);
        
        if ($user->shift) {
            $shift = $user->shift;
            $attendance->is_early_checkout = $shift->isEarlyCheckout($checkOutTime);
        } else {
            // Default shift logic (6:00 PM end time)
            $endTime = Carbon::parse('18:00:00');
            $attendance->is_early_checkout = $checkOutTime->lessThan($endTime);
        }
        
        $attendance->calculateWorkingHours();
        $attendance->save();
        
        // Send email notification to manager if early checkout
        if ($attendance->is_early_checkout && $user->manager) {
            Mail::to($user->manager->email)->send(new AttendanceNotification($attendance, 'early_checkout'));
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Checked out successfully',
            'data' => $attendance
        ]);
    }
    
    public function show($attendance)
    {
        $user = Auth::user();
        
        // Load the attendance record with user relationship
        $attendance = Attendance::with('user', 'user.department')->findOrFail($attendance);
        
        // Check if user can view this attendance record
        if (!$this->canViewAttendance($user, $attendance)) {
            abort(403, 'Unauthorized to view this attendance record.');
        }
        
        return view('attendance.show', compact('attendance', 'user'));
    }
    
    public function edit($attendance)
    {
        $user = Auth::user();
        
        // Only Admin and General Manager can edit attendance
        if (!in_array($user->role, [1, 5])) {
            abort(403, 'Unauthorized to edit attendance records.');
        }
        
        // Load the attendance record with user relationship
        $attendance = Attendance::with('user', 'user.department')->findOrFail($attendance);
        
        return view('attendance.edit', compact('attendance', 'user'));
    }
    
    private function canViewAttendance($user, $attendance)
    {
        if ($user->role === 1 || $user->role === 5) return true; // Admin and General Manager
        if ($attendance->user_id === $user->id) return true; // Own attendance
        
        if ($user->role === 4) { // Manager
            return $attendance->user->manager_id === $user->id || 
                   $attendance->user->department_id === $user->department_id;
        }
        
        if ($user->role === 2) { // Employee - Can only see own attendance
            return $attendance->user_id === $user->id;
        }
        
        return false;
    }
    
    public function report(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());
        
        $users = $this->getFilteredUsers($user);
        $userIds = $users->pluck('id');
        
        $attendances = Attendance::with('user')
            ->whereIn('user_id', $userIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->orderBy('check_in_time', 'asc')
            ->get();
        
        // Group by user for summary
        $userSummaries = $attendances->groupBy('user_id')->map(function ($userAttendances) {
            $user = $userAttendances->first()->user;
            $totalDays = $userAttendances->count();
            $present = $userAttendances->where('status', 'present')->count();
            $absent = $userAttendances->where('status', 'absent')->count();
            $onLeave = $userAttendances->where('status', 'on_leave')->count();
            $halfDay = $userAttendances->where('status', 'half_day')->count();
            $totalHours = $userAttendances->sum('working_hours');
            $overtimeHours = $userAttendances->sum('overtime_hours');
            
            return compact('user', 'totalDays', 'present', 'absent', 'onLeave', 'halfDay', 'totalHours', 'overtimeHours');
        });
        
        return view('attendance.report', compact(
            'attendances', 
            'userSummaries', 
            'startDate', 
            'endDate',
            'user'
        ));
    }
    
    public function markAttendance(Request $request)
    {
        $user = Auth::user();
        
        // Only Admin and General Manager can mark attendance for others
        if (!in_array($user->role, [1, 5])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to mark attendance for others'
            ]);
        }
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,half_day,on_leave,holiday,weekend',
            'notes' => 'nullable|string'
        ]);
        
        $attendance = Attendance::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'date' => $request->date
            ],
            [
                'status' => $request->status,
                'notes' => $request->notes,
                'ip_address' => $request->ip()
            ]
        );
        
        // Send email notification to the user
        Mail::to($attendance->user->email)->send(new AttendanceNotification($attendance, 'marked_by_admin'));
        
        return response()->json([
            'success' => true,
            'message' => 'Attendance marked successfully',
            'data' => $attendance
        ]);
    }
    
    public function getAttendanceData(Request $request)
    {
        $user = Auth::user();
        $date = $request->input('date', Carbon::today());
        
        $users = $this->getFilteredUsers($user);
        $attendances = Attendance::with('user')
            ->whereIn('user_id', $users->pluck('id'))
            ->where('date', $date)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $attendances
        ]);
    }
    
    public function sendEmailReport(Request $request)
    {
        $user = Auth::user();
        
        // Only Admin and General Manager can send reports
        if (!in_array($user->role, [1, 5])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to send reports'
            ]);
        }
        
        $request->validate([
            'recipient_email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
            'email_content' => 'required|string',
            'include_summary' => 'boolean',
            'include_detailed' => 'boolean'
        ]);
        
        try {
            // Send email using Laravel's Mail facade
            Mail::send([
                'recipient' => $request->recipient_email,
                'subject' => $request->subject,
                'html' => $request->email_content
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Report sent successfully'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage()
            ]);
        }
    }
    
    private function sendLateCheckInNotification($user, $checkInTime)
    {
        $shift = $user->shift;
        
        // Determine recipient based on hierarchy for LATE check-in
        $recipient = null;
        $recipientRole = '';
        
        switch ($user->role) {
            case 1: // Admin - Self notification (no one above)
                $recipient = $user;
                $recipientRole = 'Admin';
                break;
            case 5: // General Manager - Notify Admin
                $admin = User::where('role', 1)->where('is_active', true)->first();
                if ($admin) {
                    $recipient = $admin;
                    $recipientRole = 'Admin';
                }
                break;
            case 4: // Manager - Notify General Manager
                $gm = User::where('role', 5)->where('is_active', true)->first();
                if ($gm) {
                    $recipient = $gm;
                    $recipientRole = 'General Manager';
                }
                break;
            case 2: // Employee - Notify Department Manager
                if ($user->department_id) {
                    // Try to find department manager first
                    $manager = User::where('department_id', $user->department_id)
                                  ->where('role', 4)
                                  ->where('is_active', true)
                                  ->first();
                    if ($manager) {
                        $recipient = $manager;
                        $recipientRole = 'Manager';
                    }
                } else {
                    // Fallback: Find any active manager if no department assigned
                    $manager = User::where('role', 4)
                                  ->where('is_active', true)
                                  ->first();
                    if ($manager) {
                        $recipient = $manager;
                        $recipientRole = 'Manager (Fallback)';
                    }
                }
                break;
        }
        
        // Send notification if recipient found
        if ($recipient) {
            try {
                // Get today's attendance record for the email
                $today = Carbon::today();
                $attendance = Attendance::where('user_id', $user->id)
                    ->where('date', $today)
                    ->first();
                
                if ($attendance) {
                    Mail::to($recipient->email)->send(new AttendanceNotification($attendance, 'late_check_in'));
                    
                    // Log the notification for debugging
                    \Log::info("Late check-in notification sent", [
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'user_role' => $user->role,
                        'recipient_id' => $recipient->id,
                        'recipient_name' => $recipient->name,
                        'recipient_role' => $recipientRole,
                        'check_in_time' => $checkInTime->format('H:i:s'),
                        'shift' => $shift ? $shift->name : 'Default Shift'
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error("Failed to send late check-in notification: " . $e->getMessage());
            }
        } else {
            \Log::warning("No recipient found for late check-in notification", [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
                'department_id' => $user->department_id
            ]);
        }
    }
    
    private function sendOffTimeLoginNotification($user, $loginTime)
    {
        $shift = $user->shift;
        
        // Determine recipient based on hierarchy
        $recipient = null;
        $recipientRole = '';
        
        switch ($user->role) {
            case 1: // Admin - Self notification
                $recipient = $user;
                $recipientRole = 'Admin';
                break;
            case 5: // General Manager - Notify Admin
                $admin = User::where('role', 1)->where('is_active', true)->first();
                if ($admin) {
                    $recipient = $admin;
                    $recipientRole = 'Admin';
                }
                break;
            case 4: // Manager - Notify General Manager
                $gm = User::where('role', 5)->where('is_active', true)->first();
                if ($gm) {
                    $recipient = $gm;
                    $recipientRole = 'General Manager';
                }
                break;
            case 2: // Employee - Notify Department Manager
                if ($user->department_id) {
                    $manager = User::where('department_id', $user->department_id)
                                  ->where('role', 4)
                                  ->where('is_active', true)
                                  ->first();
                    if ($manager) {
                        $recipient = $manager;
                        $recipientRole = 'Manager';
                    }
                }
                break;
        }
        
        // Send notification if recipient found
        if ($recipient) {
            Mail::to($recipient->email)->send(new OffTimeLoginNotification($user, $loginTime, $shift, $recipientRole));
        }
    }
    
    public function checkAttendanceStatus(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        
        // Skip for customers (role 3)
        if ($user->role == 3) {
            return response()->json([
                'show_attendance' => false,
                'message' => 'Attendance not required for customers'
            ]);
        }
        
        // Check if user is active
        if (!$user->is_active) {
            return response()->json([
                'show_attendance' => false,
                'message' => 'Your account is deactivated. Please contact administrator.'
            ]);
        }
        
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();
        
        $currentTime = Carbon::now();
        $isOnTime = true;
        $statusMessage = 'On Time';
        
        if ($user->shift) {
            $shift = $user->shift;
            $isWithinShift = $shift->isWithinShiftTime($currentTime);
            $isLate = $attendance && $attendance->check_in_time ? $shift->isLateCheckIn(Carbon::parse($attendance->check_in_time)) : false;
            
            if (!$isWithinShift) {
                $isOnTime = false;
                $statusMessage = 'Off Time';
            } elseif ($isLate) {
                $isOnTime = false;
                $statusMessage = 'Late';
            }
        } else {
            // Default shift logic - 11:00 AM to 6:00 PM
            $startTime = Carbon::parse('11:00:00');
            $endTime = Carbon::parse('18:00:00');
            
            if ($currentTime->hour < 11 || $currentTime->hour >= 18) {
                $isOnTime = false;
                $statusMessage = 'Off Time';
            } elseif ($attendance && $attendance->check_in_time && Carbon::parse($attendance->check_in_time)->greaterThan($startTime)) {
                $isOnTime = false;
                $statusMessage = 'Late';
            }
        }
        
        return response()->json([
            'show_attendance' => true,
            'already_checked_in' => $attendance && $attendance->check_in_time,
            'already_checked_out' => $attendance && $attendance->check_out_time,
            'is_on_time' => $isOnTime,
            'status_message' => $statusMessage,
            'shift_name' => $user->shift ? $user->shift->name : 'Default Shift',
            'shift_time' => $user->shift ? $user->shift->start_time->format('H:i') . ' - ' . $user->shift->end_time->format('H:i') : '09:00 - 18:00'
        ]);
    }
}
