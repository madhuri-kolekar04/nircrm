<?php

namespace App\Services;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use Carbon\Carbon;

class LeaveBalanceService
{
    public function getUserLeaveBalance($userId, $leaveTypeId = null)
    {
        $user = User::findOrFail($userId);
        $currentYear = Carbon::now()->year;
        
        if ($leaveTypeId) {
            $leaveType = LeaveType::findOrFail($leaveTypeId);
            return $this->calculateBalanceForType($user, $leaveType, $currentYear);
        }
        
        $balances = [];
        $leaveTypes = LeaveType::where('is_active', true)->get();
        
        foreach ($leaveTypes as $type) {
            $balances[$type->id] = $this->calculateBalanceForType($user, $type, $currentYear);
        }
        
        return $balances;
    }
    
    private function calculateBalanceForType($user, $leaveType, $year)
    {
        $totalDays = $leaveType->days_per_year;
        
        // Adjust based on years of service
        $yearsOfService = Carbon::parse($user->joining_date ?? $user->created_at)->diffInYears(Carbon::now());
        if ($yearsOfService >= 5) {
            $totalDays += 2; // Additional days for long service
        } elseif ($yearsOfService >= 3) {
            $totalDays += 1;
        }
        
        // Calculate used days in current year
        $usedDays = Leave::where('user_id', $user->id)
                        ->where('leave_type_id', $leaveType->id)
                        ->where('status', 'approved')
                        ->whereYear('start_date', $year)
                        ->sum('total_days');
        
        // Calculate pending days
        $pendingDays = Leave::where('user_id', $user->id)
                           ->where('leave_type_id', $leaveType->id)
                           ->where('status', 'pending')
                           ->whereYear('start_date', $year)
                           ->sum('total_days');
        
        return [
            'total_days' => $totalDays,
            'used_days' => $usedDays,
            'pending_days' => $pendingDays,
            'available_days' => $totalDays - $usedDays,
            'remaining_after_pending' => $totalDays - $usedDays - $pendingDays,
            'usage_percentage' => $totalDays > 0 ? round(($usedDays / $totalDays) * 100, 2) : 0,
        ];
    }
    
    public function getLeaveStatistics($userId = null)
    {
        $query = Leave::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        $currentYear = Carbon::now()->year;
        
        return [
            'total_leaves' => $query->count(),
            'approved_this_year' => $query->where('status', 'approved')->whereYear('start_date', $currentYear)->count(),
            'pending_this_year' => $query->where('status', 'pending')->whereYear('start_date', $currentYear)->count(),
            'rejected_this_year' => $query->where('status', 'rejected')->whereYear('start_date', $currentYear)->count(),
            'total_days_taken_this_year' => $query->where('status', 'approved')->whereYear('start_date', $currentYear)->sum('total_days'),
            'most_common_leave_type' => $this->getMostCommonLeaveType($userId),
            'average_leave_duration' => $query->where('status', 'approved')->avg('total_days'),
        ];
    }
    
    private function getMostCommonLeaveType($userId = null)
    {
        $query = Leave::selectRaw('leave_type_id, COUNT(*) as count')
                      ->with('leaveType')
                      ->groupBy('leave_type_id')
                      ->orderByDesc('count')
                      ->limit(1);
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        $result = $query->first();
        
        return $result ? $result->leaveType->name : 'N/A';
    }
    
    public function getUpcomingLeaves($userId = null, $days = 30)
    {
        $query = Leave::with(['user', 'leaveType'])
                     ->where('status', 'approved')
                     ->where('start_date', '>=', Carbon::now())
                     ->where('start_date', '<=', Carbon::now()->addDays($days))
                     ->orderBy('start_date');
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        return $query->get();
    }
    
    public function getDepartmentLeaveSummary($departmentId, $year = null)
    {
        $year = $year ?? Carbon::now()->year;
        
        return Leave::join('users', 'leaves.user_id', '=', 'users.id')
                   ->join('leave_types', 'leaves.leave_type_id', '=', 'leave_types.id')
                   ->where('users.department_id', $departmentId)
                   ->whereYear('leaves.start_date', $year)
                   ->groupBy('leave_types.name')
                   ->selectRaw('
                       leave_types.name as leave_type,
                       COUNT(*) as total_requests,
                       SUM(CASE WHEN leaves.status = "approved" THEN 1 ELSE 0 END) as approved,
                       SUM(CASE WHEN leaves.status = "pending" THEN 1 ELSE 0 END) as pending,
                       SUM(CASE WHEN leaves.status = "rejected" THEN 1 ELSE 0 END) as rejected,
                       SUM(CASE WHEN leaves.status = "approved" THEN leaves.total_days ELSE 0 END) as total_days_taken
                   ')
                   ->get();
    }
}
