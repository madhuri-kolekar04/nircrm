<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ApprovalStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of pending approvals for the current user
     */
    public function index()
    {
        $user = Auth::user();
        $pendingApprovals = ApprovalStatus::where('status', 'pending')
            ->whereJsonContains('required_approvals', $user->id)
            ->whereJsonDoesntContain('current_approvals', $user->id)
            ->with(['requester', 'target'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get user's own approval requests
        $myRequests = ApprovalStatus::where('requested_by', $user->id)
            ->with(['requester', 'target'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.approval-status.index', compact('pendingApprovals', 'myRequests'));
    }

    /**
     * Show the form for creating a new approval request
     */
    public function create()
    {
        return view('admin.approval-status.create');
    }

    /**
     * Store a new approval request
     */
    public function store(Request $request)
    {
        $request->validate([
            'action_type' => 'required|in:delete,update,create',
            'target_type' => 'required|in:employee,customer',
            'target_id' => 'required|integer',
            'reason' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        
        // Get target data
        $target = null;
        if ($request->target_type === 'employee' || $request->target_type === 'customer') {
            $target = User::find($request->target_id);
        }

        if (!$target) {
            return back()->with('error', 'Target not found.');
        }

        // Determine required approvals based on hierarchy
        $requiredApprovals = $this->getRequiredApprovals($user, $target);

        if (empty($requiredApprovals)) {
            return back()->with('error', 'No approval chain found for this action.');
        }

        // Create approval request
        $approval = ApprovalStatus::create([
            'action_type' => $request->action_type,
            'target_type' => $request->target_type,
            'target_id' => $request->target_id,
            'target_data' => $target->toArray(),
            'requested_by' => $user->id,
            'status' => 'pending',
            'reason' => $request->reason,
            'required_approvals' => $requiredApprovals,
            'current_approvals' => [],
        ]);

        return redirect()->route('approval-status.index')
            ->with('success', 'Approval request created successfully.');
    }

    /**
     * Approve an approval request
     */
    public function approve($id)
    {
        $user = Auth::user();
        $approval = ApprovalStatus::findOrFail($id);

        if (!$approval->canBeApprovedBy($user)) {
            return back()->with('error', 'You cannot approve this request.');
        }

        if ($approval->addApproval($user->id)) {
            // If all approvals are obtained, execute the action
            if ($approval->status === 'approved') {
                $this->executeApprovedAction($approval);
                return back()->with('success', 'Request approved and action completed successfully.');
            }
            
            return back()->with('success', 'Request approved successfully.');
        }

        return back()->with('error', 'Failed to approve request.');
    }

    /**
     * Reject an approval request
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        $approval = ApprovalStatus::findOrFail($id);

        if ($approval->reject($user->id, $request->rejection_reason)) {
            return back()->with('success', 'Request rejected successfully.');
        }

        return back()->with('error', 'Failed to reject request.');
    }

    /**
     * Show details of a specific approval request
     */
    public function show($id)
    {
        $approval = ApprovalStatus::with(['requester', 'target'])
            ->findOrFail($id);

        // Get approver details
        $approverIds = $approval->required_approvals ?? [];
        $approvers = User::whereIn('id', $approverIds)->get()->keyBy('id');

        return view('admin.approval-status.show', compact('approval', 'approvers'));
    }

    /**
     * Get required approvals based on corporate hierarchy
     */
    private function getRequiredApprovals($requester, $target)
    {
        $approvals = [];

        // Get requester's role/position
        $requesterRole = $requester->role;
        $requesterPosition = $requester->position;

        // Define hierarchy: Admin > General Manager > Manager > Employee
        if (in_array($requesterRole, [1, 5])) {
            // Admin actions need General Manager and Manager approval
            $generalManagers = User::where('role', 1)
                ->where('position', 'General Manager')
                ->pluck('id')
                ->toArray();
            
            $managers = User::where('position', 'Manager')
                ->pluck('id')
                ->toArray();
            
            $approvals = array_merge($generalManagers, $managers);
        } elseif ($requesterPosition === 'General Manager') {
            // General Manager actions need Manager approval
            $managers = User::where('position', 'Manager')
                ->pluck('id')
                ->toArray();
            
            $approvals = $managers;
        } elseif ($requesterPosition === 'Manager') {
            // Manager actions need Admin approval
            $admins = User::whereIn('role', [1, 5])
                ->pluck('id')
                ->toArray();
            
            $approvals = $admins;
        } elseif ($requesterRole == 2) {
            // Employee actions need Manager and Admin approval
            $managers = User::where('position', 'Manager')
                ->pluck('id')
                ->toArray();
            
            $admins = User::whereIn('role', [1, 5])
                ->pluck('id')
                ->toArray();
            
            $approvals = array_merge($managers, $admins);
        }

        return array_unique($approvals);
    }

    /**
     * Execute the approved action
     */
    private function executeApprovedAction($approval)
    {
        try {
            DB::beginTransaction();

            switch ($approval->action_type) {
                case 'delete':
                    if ($approval->target_type === 'employee' || $approval->target_type === 'customer') {
                        $target = User::find($approval->target_id);
                        if ($target) {
                            $target->delete();
                        }
                    }
                    break;

                case 'update':
                    // Handle update actions if needed
                    break;

                case 'create':
                    // Handle create actions if needed
                    break;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to execute approved action: ' . $e->getMessage());
        }
    }

    /**
     * Get approval statistics
     */
    public function statistics()
    {
        $user = Auth::user();
        
        $stats = [
            'pending_for_me' => ApprovalStatus::where('status', 'pending')
                ->whereJsonContains('required_approvals', $user->id)
                ->whereJsonDoesntContain('current_approvals', $user->id)
                ->count(),
            
            'my_pending_requests' => ApprovalStatus::where('requested_by', $user->id)
                ->where('status', 'pending')
                ->count(),
            
            'my_approved_requests' => ApprovalStatus::where('requested_by', $user->id)
                ->where('status', 'approved')
                ->count(),
            
            'my_rejected_requests' => ApprovalStatus::where('requested_by', $user->id)
                ->where('status', 'rejected')
                ->count(),
        ];

        return response()->json($stats);
    }
}
