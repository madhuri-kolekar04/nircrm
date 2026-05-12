<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        try {
            $user = Auth::user();
            $today = now()->format('Y-m-d');
            
            // Get today's attendance for current user
            $todayAttendance = Attendance::where('user_id', $user->id)
                ->where('date', $today)
                ->first();
            
            // Get this week's attendance
            $weekStart = now()->startOfWeek();
            $weekEnd = now()->endOfWeek();
            $weekAttendances = Attendance::where('user_id', $user->id)
                ->whereBetween('date', [$weekStart, $weekEnd])
                ->orderBy('date')
                ->get();
            
            // Get this month's statistics
            $monthStart = now()->startOfMonth();
            $monthEnd = now()->endOfMonth();
            
            $monthStats = Attendance::where('user_id', $user->id)
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->selectRaw('
                    COUNT(*) as total_days,
                    SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_days,
                    SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_days,
                    SUM(CASE WHEN status = "on_leave" THEN 1 ELSE 0 END) as leave_days,
                    SUM(CASE WHEN status = "half_day" THEN 1 ELSE 0 END) as half_days,
                    SUM(working_hours) as total_hours,
                    SUM(overtime_hours) as total_overtime
                ')
                ->first();
            
            // Get recent attendances
            $recentAttendances = Attendance::where('user_id', $user->id)
                ->orderBy('date', 'desc')
                ->limit(10)
                ->get();
            
            return view('admin.attendance.dashboard-test', compact(
                'todayAttendance',
                'weekAttendances',
                'monthStats',
                'recentAttendances'
            ));
            
        } catch (\Exception $e) {
            // Return error for debugging
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $today = now()->format('Y-m-d');
        
        // Check if already checked in today
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();
        
        if ($existingAttendance && $existingAttendance->check_in_time) {
            return response()->json([
                'success' => false,
                'message' => 'You have already checked in today!'
            ]);
        }
        
        // Create or update attendance record
        $checkInTime = now()->format('H:i:s');
        $workShift = $user->work_shift ?? '9:00-18:00';
        $shiftStart = explode('-', $workShift)[0];
        
        $attendance = Attendance::updateOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            [
                'check_in_time' => $checkInTime,
                'status' => 'present',
                'ip_address' => $request->ip(),
                'location' => $request->input('location', 'Office'),
                'is_late' => $checkInTime > $shiftStart . ':00'
            ]
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Checked in successfully at ' . $checkInTime,
            'attendance' => $attendance
        ]);
    }

    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $today = now()->format('Y-m-d');
        
        // Get today's attendance
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();
        
        if (!$attendance || !$attendance->check_in_time) {
            return response()->json([
                'success' => false,
                'message' => 'You need to check in first!'
            ]);
        }
        
        if ($attendance->check_out_time) {
            return response()->json([
                'success' => false,
                'message' => 'You have already checked out today!'
            ]);
        }
        
        // Update check out time
        $checkOutTime = now()->format('H:i:s');
        $workShift = $user->work_shift ?? '9:00-18:00';
        $shiftEnd = explode('-', $workShift)[1];
        
        $attendance->check_out_time = $checkOutTime;
        $attendance->is_early_checkout = $checkOutTime < $shiftEnd . ':00';
        
        // Calculate working hours
        $attendance->calculateWorkingHours();
        
        return response()->json([
            'success' => true,
            'message' => 'Checked out successfully at ' . $checkOutTime,
            'attendance' => $attendance
        ]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Check permissions
        if (!$user->canApproveLeave()) {
            // Employees can only see their own attendance
            $attendances = $user->attendances()
                ->orderBy('date', 'desc')
                ->paginate(30);
        } else {
            // Managers and Admins can see team attendance
            $query = Attendance::with('user');
            
            // Filter by role permissions
            if ($user->role === 4) { // Manager
                $subordinateIds = $user->getSubordinatesIds();
                $departmentIds = $user->getDepartmentUsersIds();
                $visibleUserIds = array_merge($subordinateIds, $departmentIds, [$user->id]);
                $query->whereIn('user_id', $visibleUserIds);
            }
            
            // Apply filters
            if ($request->user_id) {
                $query->where('user_id', $request->user_id);
            }
            
            if ($request->date_from) {
                $query->where('date', '>=', $request->date_from);
            }
            
            if ($request->date_to) {
                $query->where('date', '<=', $request->date_to);
            }
            
            if ($request->status) {
                $query->where('status', $request->status);
            }
            
            $attendances = $query->orderBy('date', 'desc')->paginate(30);
        }
        
        // Get users for filter dropdown (only for managers/admins)
        $users = [];
        if ($user->canApproveLeave()) {
            $usersQuery = User::active();
            
            if ($user->role === 4) { // Manager
                $subordinateIds = $user->getSubordinatesIds();
                $departmentIds = $user->getDepartmentUsersIds();
                $visibleUserIds = array_merge($subordinateIds, $departmentIds, [$user->id]);
                $usersQuery->whereIn('id', $visibleUserIds);
            }
            
            $users = $usersQuery->orderBy('name')->get();
        }
        
        return view('admin.attendance.index', compact('attendances', 'users'));
    }

    public function reports(Request $request)
    {
        $user = Auth::user();
        
        // Check permissions
        if (!$user->canApproveLeave()) {
            return redirect()->route('attendance.dashboard')
                ->with('error', 'You do not have permission to view reports.');
        }
        
        $startDate = $request->date_from ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->date_to ?? now()->format('Y-m-d');
        
        $query = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate]);
        
        // Apply filters based on role
        if ($user->role === 4) { // Manager
            $subordinateIds = $user->getSubordinatesIds();
            $departmentIds = $user->getDepartmentUsersIds();
            $visibleUserIds = array_merge($subordinateIds, $departmentIds, [$user->id]);
            $query->whereIn('user_id', $visibleUserIds);
        }
        
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->department_id) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });
        }
        
        $attendances = $query->orderBy('date')->get();
        
        // Generate summary statistics
        $summary = $attendances->groupBy('user_id')->map(function($userAttendances) {
            return [
                'user' => $userAttendances->first()->user,
                'total_days' => $userAttendances->count(),
                'present_days' => $userAttendances->where('status', 'present')->count(),
                'absent_days' => $userAttendances->where('status', 'absent')->count(),
                'leave_days' => $userAttendances->where('status', 'on_leave')->count(),
                'half_days' => $userAttendances->where('status', 'half_day')->count(),
                'total_hours' => $userAttendances->sum('working_hours'),
                'total_overtime' => $userAttendances->sum('overtime_hours'),
                'late_count' => $userAttendances->where('is_late', true)->count(),
                'early_checkout_count' => $userAttendances->where('is_early_checkout', true)->count(),
            ];
        });
        
        // Get users and departments for filters
        $users = User::active()->orderBy('name')->get();
        $departments = \App\Models\Department::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.attendance.reports', compact(
            'attendances',
            'summary',
            'users',
            'departments',
            'startDate',
            'endDate'
        ));
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->canApproveLeave()) {
            return redirect()->back()->with('error', 'Permission denied');
        }
        
        $startDate = $request->date_from ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->date_to ?? now()->format('Y-m-d');
        
        $query = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate]);
        
        // Apply filters based on role
        if ($user->role === 4) { // Manager
            $subordinateIds = $user->getSubordinatesIds();
            $departmentIds = $user->getDepartmentUsersIds();
            $visibleUserIds = array_merge($subordinateIds, $departmentIds, [$user->id]);
            $query->whereIn('user_id', $visibleUserIds);
        }
        
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        
        $attendances = $query->orderBy('date')->orderBy('user_id')->get();
        
        // Generate CSV
        $filename = "attendance_report_{$startDate}_to_{$endDate}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($attendances) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, [
                'Date',
                'Employee Name',
                'Employee ID',
                'Department',
                'Check In',
                'Check Out',
                'Status',
                'Working Hours',
                'Overtime Hours',
                'Late',
                'Early Checkout'
            ]);
            
            // CSV Data
            foreach ($attendances as $attendance) {
                fputcsv($file, [
                    $attendance->date,
                    $attendance->user->full_name,
                    $attendance->user->employee_id ?? 'N/A',
                    $attendance->user->department->name ?? 'N/A',
                    $attendance->check_in_time,
                    $attendance->check_out_time,
                    $attendance->status,
                    $attendance->working_hours,
                    $attendance->overtime_hours,
                    $attendance->is_late ? 'Yes' : 'No',
                    $attendance->is_early_checkout ? 'Yes' : 'No'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
