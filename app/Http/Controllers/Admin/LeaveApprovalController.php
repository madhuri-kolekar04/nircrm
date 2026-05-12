<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\LeaveApproval;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveApprovalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get leaves pending for current user's approval
        $pendingApprovals = Leave::whereHas('approvals', function ($query) use ($user) {
            $query->where('approver_id', $user->id)
                  ->where('status', 'pending');
        })->with(['user', 'leaveType', 'approvals' => function ($query) use ($user) {
            $query->where('approver_id', $user->id);
        }])->get();

        // Get current user's leave requests
        $myRequests = Leave::where('user_id', $user->id)
                           ->with(['leaveType', 'approvals.approver'])
                           ->orderBy('created_at', 'desc')
                           ->get();

        // Statistics
        $stats = [
            'pending_for_me' => $pendingApprovals->count(),
            'my_pending' => $myRequests->where('status', 'pending')->count(),
            'my_approved' => $myRequests->where('status', 'approved')->count(),
            'my_rejected' => $myRequests->where('status', 'rejected')->count(),
        ];

        return view('admin.approval-status.leave-index', compact(
            'pendingApprovals',
            'myRequests',
            'stats',
            'user'
        ));
    }

    public function approve(Request $request, Leave $leave)
    {
        $user = Auth::user();
        
        if (!$leave->canBeApprovedBy($user)) {
            return back()->with('error', 'You are not authorized to approve this leave request.');
        }

        $request->validate([
            'comments' => 'nullable|string|max:500'
        ]);

        $leave->approve($user, $request->comments);

        return back()->with('success', 'Leave request approved successfully.');
    }

    public function reject(Request $request, Leave $leave)
    {
        $user = Auth::user();
        
        if (!$leave->canBeApprovedBy($user)) {
            return back()->with('error', 'You are not authorized to reject this leave request.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $leave->reject($user, $request->rejection_reason);

        return back()->with('success', 'Leave request rejected successfully.');
    }

    public function show(Leave $leave)
    {
        $user = Auth::user();
        
        // Check if user can view this leave
        if ($leave->user_id !== $user->id && !$leave->canBeApprovedBy($user)) {
            abort(403);
        }

        $leave->load(['user', 'leaveType', 'approvals.approver']);

        return view('admin.approval-status.leave-show', compact('leave', 'user'));
    }
}
