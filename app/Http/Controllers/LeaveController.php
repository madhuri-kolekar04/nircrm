<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\LeaveApproval;
use App\Models\User;
use App\Services\LeaveBalanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveRequestNotification;
use App\Mail\LeaveApproved;
use App\Mail\LeaveRejected;
use App\Mail\LeaveApplicationNotification;

class LeaveController extends Controller
{
    protected $balanceService;
    
    public function __construct(LeaveBalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }
    public function index()
    {
        $user = Auth::user();
        $leaves = $this->getFilteredLeaves($user);
        
        return view('leave.index', compact('leaves', 'user'));
    }
    
    public function create()
    {
        $user = Auth::user();
        $leaveTypes = LeaveType::where('is_active', true)->get();
        $leaveBalances = $this->balanceService->getUserLeaveBalance($user->id);
        $statistics = $this->balanceService->getLeaveStatistics($user->id);
        $upcomingLeaves = $this->balanceService->getUpcomingLeaves($user->id);
        
        return view('leave.create', compact('leaveTypes', 'user', 'leaveBalances', 'statistics', 'upcomingLeaves'));
    }
    
    public function store(Request $request)
    {
        $leaveDuration = $request->input('leave_duration');
        
        // Validate that leave duration is selected
        if (!$leaveDuration || !in_array($leaveDuration, ['full_day', 'half_day'])) {
            return back()->with('error', 'Please select either Full Day Leave or Half Day Leave.');
        }
        
        if ($leaveDuration === 'full_day') {
            $request->validate([
                'leave_type_id' => 'required|exists:leave_types,id',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'required|string|min:10',
                'emergency_contact' => 'nullable|string',
                'attachments' => 'nullable|array',
                'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
            ]);
            
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $totalDays = $startDate->diffInDays($endDate) + 1;
            $isHalfDay = false;
            $isFullDay = true;
        } else { // Half day
            $request->validate([
                'leave_type_id' => 'required|exists:leave_types,id',
                'half_day_date' => 'required|date|after_or_equal:today',
                'reason' => 'required|string|min:10',
                'half_day_type' => 'required|in:first_half,second_half',
                'emergency_contact' => 'nullable|string',
                'attachments' => 'nullable|array',
                'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
            ]);
            
            // For half day, set both start and end date to the same date
            $startDate = Carbon::parse($request->half_day_date);
            $endDate = Carbon::parse($request->half_day_date);
            $totalDays = 0.5;
            $isHalfDay = true;
            $isFullDay = false;
        }
        
        $user = Auth::user();
        
        // Check for overlapping leaves
        $overlappingLeaves = Leave::where('user_id', $user->id)
            ->where('status', '!=', 'rejected')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->exists();
        
        if ($overlappingLeaves) {
            return back()->with('error', 'You already have a leave request for this period.');
        }
        
        // Handle file attachments
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('leave_attachments', 'public');
                $attachments[] = $path;
            }
        }
        
        $leave = Leave::create([
            'user_id' => $user->id,
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'total_days' => $totalDays,
            'reason' => $request->reason,
            'is_half_day' => $isHalfDay,
            'is_full_day' => $isFullDay,
            'half_day_type' => $request->half_day_type,
            'emergency_contact' => $request->emergency_contact,
            'attachments' => $attachments,
            'is_paid_leave' => $this->isPaidLeave($user, $request->leave_type_id, $totalDays),
            'status' => 'pending'
        ]);
        
        // Create approval chain
        try {
            $approvalChain = $leave->createApprovalChain();
            foreach ($approvalChain as $approvalData) {
                $approval = new LeaveApproval();
                $approval->leave_id = $approvalData['leave_id'];
                $approval->approver_id = $approvalData['approver_id'];
                $approval->approval_level = $approvalData['approval_level'];
                $approval->status = $approvalData['status'];
                $approval->save();
            }
            \Log::info("Approval chain created for leave ID: " . $leave->id);
        } catch (\Exception $e) {
            \Log::error("Failed to create approval chain for leave ID: " . $leave->id . " Error: " . $e->getMessage());
        }
        
        // Send notification to hierarchy-based approvers
        try {
            $this->sendHierarchyBasedLeaveNotification($leave);
            \Log::info("Leave notification sent for leave ID: " . $leave->id);
        } catch (\Exception $e) {
            \Log::error("Failed to send leave notification for leave ID: " . $leave->id . " Error: " . $e->getMessage());
        }
        
        return redirect()->route('leave.index')
            ->with('success', 'Leave request submitted successfully and sent for approval.');
    }
    
    public function show(Leave $leave)
    {
        $user = Auth::user();
        
        // Check if user can view this leave
        if (!$this->canViewLeave($user, $leave)) {
            abort(403);
        }
        
        return view('leave.show', compact('leave', 'user'));
    }
    
    public function approve(Request $request, Leave $leave)
    {
        $user = Auth::user();
        
        if (!$leave->canBeApprovedBy($user)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to approve this leave.'
            ], 403);
        }
        
        $request->validate([
            'approval_notes' => 'nullable|string'
        ]);
        
        $leave->approve($user, $request->approval_notes);
        
        return response()->json([
            'success' => true,
            'message' => 'Leave approved successfully.'
        ]);
    }
    
    public function reject(Request $request, Leave $leave)
    {
        $user = Auth::user();
        
        if (!$leave->canBeApprovedBy($user)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to reject this leave.'
            ], 403);
        }
        
        $request->validate([
            'rejection_reason' => 'required|string|min:5'
        ]);
        
        $leave->reject($user, $request->rejection_reason);
        
        return response()->json([
            'success' => true,
            'message' => 'Leave rejected successfully.'
        ]);
    }
    
    public function cancel(Request $request, Leave $leave)
    {
        $user = Auth::user();
        
        // Only the leave owner can cancel their own pending leave
        if ($leave->user_id !== $user->id || $leave->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'You cannot cancel this leave request.'
            ]);
        }
        
        $leave->status = 'cancelled';
        $leave->save();
        
        // Send email notification to managers about cancellation
        $this->sendLeaveCancellationNotification($leave);
        
        return response()->json([
            'success' => true,
            'message' => 'Leave request cancelled successfully.'
        ]);
    }
    
    public function calendarData(Request $request)
    {
        $user = Auth::user();
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));
        $departmentId = $request->get('department_id');
        $leaveTypeId = $request->get('leave_type_id');
        $userId = $request->get('user_id');
        $status = $request->get('status');
        
        $query = Leave::with(['user', 'leaveType', 'approver', 'user.department'])
            ->whereMonth('start_date', '<=', $month)
            ->whereMonth('end_date', '>=', $month)
            ->whereYear('start_date', '<=', $year)
            ->whereYear('end_date', '>=', $year);
        
        // Apply role-based filtering
        switch ($user->role) {
            case 1: // Admin - Can see all leaves
                break;
            case 5: // General Manager - Can see all leaves
                break;
            case 4: // Manager - Can see department and subordinate leaves
                $query->where(function ($q) use ($user) {
                    $q->whereHas('user', function ($subQ) use ($user) {
                        $subQ->where('department_id', $user->department_id)
                             ->orWhere('manager_id', $user->id);
                    });
                });
                break;
            case 2: // Employee - Can see all users for calendar view
                break;
            case 3: // Customer - Limited access
                $query->where('user_id', $user->id);
                break;
            default:
                $query->where('user_id', $user->id);
                break;
        }
        
        // Apply additional filters
        if ($departmentId) {
            $query->whereHas('user', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }
        
        if ($leaveTypeId) {
            $query->where('leave_type_id', $leaveTypeId);
        }
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $leaves = $query->orderBy('start_date')->get();
        
        // Format for calendar display
        $calendarEvents = [];
        foreach ($leaves as $leave) {
            $startDate = Carbon::parse($leave->start_date);
            $endDate = Carbon::parse($leave->end_date);
            
            // Create event for each day of the leave
            $currentDate = $startDate->copy();
            while ($currentDate <= $endDate) {
                $calendarEvents[] = [
                    'id' => $leave->id,
                    'title' => $leave->user->name . ' - ' . $leave->leave_type->name,
                    'start' => $currentDate->format('Y-m-d'),
                    'backgroundColor' => $this->getEventColor($leave->status),
                    'borderColor' => $this->getEventBorderColor($leave->status),
                    'textColor' => '#fff',
                    'extendedProps' => [
                        'employee' => $leave->user->name,
                        'department' => $leave->user->department->name ?? 'N/A',
                        'leave_type' => $leave->leave_type->name,
                        'status' => $leave->status,
                        'reason' => $leave->reason,
                        'total_days' => $leave->total_days,
                        'is_half_day' => $leave->is_half_day,
                        'half_day_type' => $leave->half_day_type,
                        'approver' => $leave->approver ? $leave->approver->name : null,
                        'approval_date' => $leave->approval_date,
                        'can_approve' => $leave->canBeApprovedBy($user),
                        'can_cancel' => $leave->user_id === $user->id && $leave->status === 'pending'
                    ]
                ];
                $currentDate->addDay();
            }
        }
        
        return response()->json([
            'events' => $calendarEvents,
            'statistics' => $this->getCalendarStatistics($leaves, $month, $year)
        ]);
    }
    
    public function calendar(Request $request)
    {
        $user = Auth::user();
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));
        
        // Validate month and year
        $month = max(1, min(12, (int)$month));
        $year = max(2020, min(2030, (int)$year));
        
        // Get filtered leaves based on user role
        $leaves = $this->getCalendarLeaves($user, $month, $year);
        
        // Get departments for filtering
        $departments = \App\Models\Department::where('is_active', true)->get();
        
        // Get leave types for filtering
        $leaveTypes = LeaveType::where('is_active', true)->get();
        
        // Get users for filtering (based on role)
        $users = $this->getFilteredUsers($user);
        
        // Calculate statistics
        $statistics = $this->getCalendarStatistics($leaves, $month, $year);
        
        return view('leave.calendar', compact(
            'leaves', 
            'user', 
            'departments', 
            'leaveTypes', 
            'users',
            'month',
            'year',
            'statistics'
        ));
    }
    
    public function balance()
    {
        return view('leave.balance', [
            'user' => auth()->user(),
            'leaveBalances' => [],
            'statistics' => [
                'total_leaves' => 0,
                'approved_this_year' => 0,
                'pending_this_year' => 0,
                'rejected_this_year' => 0,
                'total_days_taken_this_year' => 0,
                'average_leave_duration' => 0
            ],
            'upcomingLeaves' => collect([]),
            'departmentSummary' => collect([])
        ]);
    }
    
    private function getFilteredUsers($user)
    {
        $query = User::where('is_active', true)->with(['department', 'shift']);
        
        switch ($user->role) {
            case 1: // Admin - Can see all users
                break;
            case 5: // General Manager - Can see all users
                break;
            case 4: // Manager - Can see department users
                $query->where('department_id', $user->department_id);
                break;
            case 2: // Employee - Can see all users for calendar
                break;
            case 3: // Customer - Limited access
                $query->where('id', $user->id);
                break;
            default:
                $query->where('id', $user->id);
                break;
        }
        
        return $query->get();
    }
    
    private function getCalendarLeaves($user, $month, $year)
    {
        $query = Leave::with(['user', 'leaveType', 'approver', 'user.department'])
            ->whereMonth('start_date', '<=', $month)
            ->whereMonth('end_date', '>=', $month)
            ->whereYear('start_date', '<=', $year)
            ->whereYear('end_date', '>=', $year);
        
        // Apply role-based filtering
        switch ($user->role) {
            case 1: // Admin - Can see all leaves
                break;
            case 5: // General Manager - Can see all leaves
                break;
            case 4: // Manager - Can see department and subordinate leaves
                $query->where(function ($q) use ($user) {
                    $q->whereHas('user', function ($subQ) use ($user) {
                        $subQ->where('department_id', $user->department_id)
                             ->orWhere('manager_id', $user->id);
                    });
                });
                break;
            case 2: // Employee - Can see all users for calendar view
                break;
            case 3: // Customer - Limited access
                $query->where('user_id', $user->id);
                break;
            default:
                $query->where('user_id', $user->id);
                break;
        }
        
        return $query->orderBy('start_date')->get();
    }
    
    private function getCalendarStatistics($leaves, $month, $year)
    {
        $currentMonthLeaves = $leaves->filter(function ($leave) use ($month, $year) {
            $startDate = Carbon::parse($leave->start_date);
            $endDate = Carbon::parse($leave->end_date);
            return ($startDate->month <= $month && $startDate->year <= $year) &&
                   ($endDate->month >= $month && $endDate->year >= $year);
        });
        
        return [
            'total_leaves' => $currentMonthLeaves->count(),
            'approved' => $currentMonthLeaves->where('status', 'approved')->count(),
            'pending' => $currentMonthLeaves->where('status', 'pending')->count(),
            'rejected' => $currentMonthLeaves->where('status', 'rejected')->count(),
            'total_days' => $currentMonthLeaves->sum('total_days'),
            'unique_employees' => $currentMonthLeaves->unique('user_id')->count(),
            'by_type' => $currentMonthLeaves->groupBy('leave_type.name')->map->count(),
            'by_status' => $currentMonthLeaves->groupBy('status')->map->count()
        ];
    }
    
    private function getFilteredLeaves($user)
    {
        $query = Leave::with(['user', 'leaveType', 'approver'])
                    ->whereHas('user'); // Ensure only leaves with existing users are loaded
        
        switch ($user->role) {
            case 1: // Admin - Can see all leaves
                break;
            case 5: // General Manager - Can see all leaves
                break;
            case 4: // Manager - Can see department and subordinate leaves
                $query->where(function ($q) use ($user) {
                    $q->whereHas('user', function ($subQ) use ($user) {
                        $subQ->where('department_id', $user->department_id)
                             ->orWhere('manager_id', $user->id);
                    });
                });
                break;
            case 2: // Employee - Can see own leaves
                $query->where('user_id', $user->id);
                break;
            case 3: // Customer - Limited access
                $query->where('user_id', $user->id);
                break;
        }
        
        return $query->orderBy('created_at', 'desc')->paginate(20);
    }
    
    private function canViewLeave($user, $leave)
    {
        if ($user->role === 1 || $user->role === 5) return true;
        if ($leave->user_id === $user->id) return true;
        if ($user->role === 4) {
            return $leave->user->manager_id === $user->id || 
                   $leave->user->department_id === $user->department_id;
        }
        return false;
    }
    
    private function sendHierarchyBasedLeaveNotification($leave)
    {
        try {
            $applicant = $leave->user;
            if (!$applicant) {
                \Log::error("Cannot send notification: Leave record has no associated user. Leave ID: " . $leave->id);
                return;
            }
            
            $applicantRole = $applicant->role;
            
            // Determine recipients based on hierarchy
            $recipients = [];
            
            if ($applicantRole == 2) { // Employee -> Department Manager
                $manager = User::where('role', 4)
                              ->where('department_id', $applicant->department_id)
                              ->where('is_active', true)
                              ->first();
                
                if ($manager && $manager->email) {
                    $recipients[] = $manager;
                }
                
            } elseif ($applicantRole == 4) { // Manager -> General Manager
                $generalManager = User::where('role', 5)
                                     ->where('is_active', true)
                                     ->first();
                
                if ($generalManager && $generalManager->email) {
                    $recipients[] = $generalManager;
                }
                
            } elseif ($applicantRole == 5) { // General Manager -> Admin
                $admin = User::where('role', 1)
                            ->where('is_active', true)
                            ->first();
                
                if ($admin && $admin->email) {
                    $recipients[] = $admin;
                }
            }
            
            // Send emails to all recipients
            foreach ($recipients as $recipient) {
                try {
                    Mail::to($recipient->email)->send(new LeaveApplicationNotification($leave, $recipient));
                    \Log::info("Leave notification sent to: " . $recipient->email . " for leave ID: " . $leave->id);
                } catch (\Exception $e) {
                    \Log::error("Failed to send leave notification to: " . $recipient->email . " Error: " . $e->getMessage());
                }
            }
            
            // Log if no recipients found
            if (empty($recipients)) {
                \Log::warning("No valid recipients found for leave notification. Applicant role: " . $applicantRole . ", Department: " . ($applicant->department_id ?? 'N/A'));
            }
        } catch (\Exception $e) {
            \Log::error("Error in sendHierarchyBasedLeaveNotification: " . $e->getMessage());
        }
    }
    
    private function sendLeaveCancellationNotification($leave)
    {
        $applicant = $leave->user;
        $applicantRole = $applicant->role;
        
        // Determine recipients based on hierarchy (same as original notification)
        $recipients = [];
        
        if ($applicantRole == 2) { // Employee -> Department Manager
            $manager = User::where('role', 4)
                          ->where('department_id', $applicant->department_id)
                          ->where('is_active', true)
                          ->first();
            
            if ($manager && $manager->email) {
                $recipients[] = $manager;
            }
            
        } elseif ($applicantRole == 4) { // Manager -> General Manager
            $generalManager = User::where('role', 5)
                                 ->where('is_active', true)
                                 ->first();
            
            if ($generalManager && $generalManager->email) {
                $recipients[] = $generalManager;
            }
            
        } elseif ($applicantRole == 5) { // General Manager -> Admin
            $admin = User::where('role', 1)
                        ->where('is_active', true)
                        ->first();
            
            if ($admin && $admin->email) {
                $recipients[] = $admin;
            }
        }
        
        // Send cancellation emails to all recipients
        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient->email)->send(new \App\Mail\LeaveCancelled($leave, $recipient));
                \Log::info("Leave cancellation notification sent to: " . $recipient->email . " for leave ID: " . $leave->id);
            } catch (\Exception $e) {
                \Log::error("Failed to send leave cancellation notification to: " . $recipient->email . " Error: " . $e->getMessage());
            }
        }
        
        // Log if no recipients found
        if (empty($recipients)) {
            \Log::warning("No valid recipients found for leave cancellation notification. Applicant role: " . $applicantRole . ", Department: " . $applicant->department_id);
        }
    }
    
    private function isPaidLeave($user, $leaveTypeId, $totalDays)
    {
        $leaveType = LeaveType::find($leaveTypeId);
        
        if (!$leaveType || !$leaveType->is_paid) {
            return false;
        }
        
        // Check if user has enough paid leave balance
        $used = Leave::where('user_id', $user->id)
            ->where('leave_type_id', $leaveTypeId)
            ->where('status', 'approved')
            ->whereYear('start_date', Carbon::now()->year)
            ->sum('total_days');
        
        return ($used + $totalDays) <= $leaveType->days_per_year;
    }
    
    public function calendarLeavesData(Request $request)
    {
        $user = Auth::user();
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));
        $departmentId = $request->get('department_id');
        $leaveTypeId = $request->get('leave_type_id');
        $userId = $request->get('user_id');
        $status = $request->get('status');
        
        $query = Leave::with(['user', 'leaveType', 'approver', 'user.department'])
            ->whereMonth('start_date', '<=', $month)
            ->whereMonth('end_date', '>=', $month)
            ->whereYear('start_date', '<=', $year)
            ->whereYear('end_date', '>=', $year);
        
        // Apply role-based filtering
        switch ($user->role) {
            case 1: // Admin - Can see all leaves
                break;
            case 5: // General Manager - Can see all leaves
                break;
            case 4: // Manager - Can see department and subordinate leaves
                $query->where(function ($q) use ($user) {
                    $q->whereHas('user', function ($subQ) use ($user) {
                        $subQ->where('department_id', $user->department_id)
                             ->orWhere('manager_id', $user->id);
                    });
                });
                break;
            case 2: // Employee - Can see all users for calendar view
                break;
            case 3: // Customer - Limited access
                $query->where('user_id', $user->id);
                break;
            default:
                $query->where('user_id', $user->id);
                break;
        }
        
        // Apply additional filters
        if ($departmentId) {
            $query->whereHas('user', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }
        
        if ($leaveTypeId) {
            $query->where('leave_type_id', $leaveTypeId);
        }
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $leaves = $query->orderBy('start_date')->get();
        
        // Format for calendar display
        $calendarEvents = [];
        foreach ($leaves as $leave) {
            $startDate = Carbon::parse($leave->start_date);
            $endDate = Carbon::parse($leave->end_date);
            
            // Create event for each day of the leave
            $currentDate = $startDate->copy();
            while ($currentDate <= $endDate) {
                $calendarEvents[] = [
                    'id' => $leave->id,
                    'title' => $leave->user->name . ' - ' . $leave->leave_type->name,
                    'start' => $currentDate->format('Y-m-d'),
                    'backgroundColor' => $this->getEventColor($leave->status),
                    'borderColor' => $this->getEventBorderColor($leave->status),
                    'textColor' => '#fff',
                    'extendedProps' => [
                        'type' => 'leave',
                        'employee' => $leave->user->name,
                        'department' => $leave->user->department->name ?? 'N/A',
                        'leave_type' => $leave->leave_type->name,
                        'status' => $leave->status,
                        'reason' => $leave->reason,
                        'total_days' => $leave->total_days,
                        'is_half_day' => $leave->is_half_day,
                        'half_day_type' => $leave->half_day_type,
                        'approver' => $leave->approver ? $leave->approver->name : null,
                        'approval_date' => $leave->approval_date,
                        'can_approve' => method_exists($leave, 'canBeApprovedBy') ? $leave->canBeApprovedBy($user) : false,
                        'can_cancel' => $leave->user_id === $user->id && $leave->status === 'pending'
                    ]
                ];
                $currentDate->addDay();
            }
        }
        
        return response()->json([
            'leaves' => $calendarEvents,
            'holidays' => $this->getCompanyHolidays($year)
        ]);
    }
    
    public function calendarLeaves(Request $request)
    {
        $user = Auth::user();
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));
        
        // Get all leaves for the calendar
        $leaves = $this->getCalendarLeaves($user, $month, $year);
        
        // Get company holidays (demo data)
        $holidays = $this->getCompanyHolidays($year);
        
        // Get departments for filtering
        $departments = \App\Models\Department::where('is_active', true)->get();
        
        // Get leave types for filtering
        $leaveTypes = LeaveType::where('is_active', true)->get();
        
        // Get users for filtering (based on role)
        $users = $this->getFilteredUsers($user);
        
        return view('leave.calendar-leaves', compact(
            'leaves', 
            'user', 
            'departments', 
            'leaveTypes', 
            'users',
            'month',
            'year',
            'holidays'
        ));
    }
    
    public function leaveBucket(Request $request)
    {
        $user = Auth::user();
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));
        
        // Get demo data for leave bucket
        $bucketData = $this->getLeaveBucketDemoData($month, $year);
        
        // Get monthly statistics
        $monthlyStats = $this->getMonthlyLeaveStatistics($month, $year);
        
        // Get leave type breakdown
        $leaveTypeBreakdown = $this->getLeaveTypeBreakdown($month, $year);
        
        // Get departments for filtering
        $departments = \App\Models\Department::where('is_active', true)->get();
        
        return view('leave.leave-bucket', compact(
            'user',
            'bucketData',
            'monthlyStats',
            'leaveTypeBreakdown',
            'departments',
            'month',
            'year'
        ));
    }
    
    private function getCompanyHolidays($year)
    {
        // Demo company holidays
        return [
            [
                'date' => $year . '-01-01',
                'name' => 'New Year\'s Day',
                'type' => 'national'
            ],
            [
                'date' => $year . '-01-26',
                'name' => 'Republic Day',
                'type' => 'national'
            ],
            [
                'date' => $year . '-08-15',
                'name' => 'Independence Day',
                'type' => 'national'
            ],
            [
                'date' => $year . '-10-02',
                'name' => 'Gandhi Jayanti',
                'type' => 'national'
            ],
            [
                'date' => $year . '-12-25',
                'name' => 'Christmas',
                'type' => 'national'
            ],
            [
                'date' => $year . '-03-15',
                'name' => 'Company Foundation Day',
                'type' => 'company'
            ],
            [
                'date' => $year . '-05-01',
                'name' => 'Maharashtra Day',
                'type' => 'regional'
            ]
        ];
    }
    
    private function getLeaveBucketDemoData($month, $year)
    {
        // Demo data for leave bucket
        return [
            'total_employees' => 150,
            'total_leaves_this_month' => 45,
            'casual_leaves' => 18,
            'sick_leaves' => 12,
            'maternity_leaves' => 3,
            'paternity_leaves' => 2,
            'earned_leaves' => 8,
            'unpaid_leaves' => 2,
            'pending_approval' => 8,
            'approved_leaves' => 37,
            'rejected_leaves' => 0,
            'average_leave_duration' => 2.5,
            'peak_leave_days' => ['Monday', 'Friday'],
            'department_wise' => [
                'IT' => ['total' => 15, 'approved' => 12, 'pending' => 3],
                'HR' => ['total' => 8, 'approved' => 7, 'pending' => 1],
                'Sales' => ['total' => 12, 'approved' => 10, 'pending' => 2],
                'Finance' => ['total' => 6, 'approved' => 5, 'pending' => 1],
                'Operations' => ['total' => 4, 'approved' => 3, 'pending' => 1]
            ]
        ];
    }
    
    private function getMonthlyLeaveStatistics($month, $year)
    {
        // Demo monthly statistics
        return [
            'working_days' => 22,
            'weekends' => 8,
            'holidays' => 2,
            'total_leave_days' => 112,
            'productivity_impact' => '5.1%',
            'attendance_rate' => '94.9%',
            'leave_trend' => '+12% from last month'
        ];
    }
    
    private function getLeaveTypeBreakdown($month, $year)
    {
        // Demo leave type breakdown
        return [
            'Casual Leave' => ['count' => 18, 'percentage' => 40, 'color' => '#007bff'],
            'Sick Leave' => ['count' => 12, 'percentage' => 27, 'color' => '#28a745'],
            'Earned Leave' => ['count' => 8, 'percentage' => 18, 'color' => '#ffc107'],
            'Maternity Leave' => ['count' => 3, 'percentage' => 7, 'color' => '#e83e8c'],
            'Paternity Leave' => ['count' => 2, 'percentage' => 4, 'color' => '#6f42c1'],
            'Unpaid Leave' => ['count' => 2, 'percentage' => 4, 'color' => '#6c757d']
        ];
    }
    
    private function getEventColor($status)
    {
        return match($status) {
            'approved' => '#28a745',
            'pending' => '#ffc107',
            'rejected' => '#dc3545',
            'cancelled' => '#6c757d',
            'on_hold' => '#fd7e14',
            default => '#17a2b8'
        };
    }
    
    private function getEventBorderColor($status)
    {
        return match($status) {
            'approved' => '#1e7e34',
            'pending' => '#d39e00',
            'rejected' => '#bd2130',
            'cancelled' => '#545b62',
            'on_hold' => '#e55a00',
            default => '#117a8b'
        };
    }
    
    public function test()
    {
        return 'LeaveController is working!';
    }
}
