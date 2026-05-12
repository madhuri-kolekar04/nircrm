<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalStatus extends Model
{
    use HasFactory;

    protected $table = 'approval_status';

    protected $fillable = [
        'action_type',
        'target_type',
        'target_id',
        'target_data',
        'requested_by',
        'status',
        'reason',
        'approval_chain',
        'current_approvals',
        'required_approvals',
        'rejection_reason',
        'approved_at',
        'rejected_at',
    ];

    protected $casts = [
        'target_data' => 'array',
        'approval_chain' => 'array',
        'current_approvals' => 'array',
        'required_approvals' => 'array',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /**
     * Get the user who requested the approval
     */
    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    /**
     * Get the target model based on target_type and target_id
     */
    public function target()
    {
        return $this->belongsTo(User::class, 'target_id');
    }

    /**
     * Check if the current user can approve this request
     */
    public function canBeApprovedBy($user): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        $requiredApprovals = $this->required_approvals ?? [];
        $currentApprovals = $this->current_approvals ?? [];

        // Check if user is in the required approval chain and hasn't approved yet
        return in_array($user->id, $requiredApprovals) && !in_array($user->id, $currentApprovals);
    }

    /**
     * Check if all required approvals have been obtained
     */
    public function hasAllApprovals(): bool
    {
        $requiredApprovals = $this->required_approvals ?? [];
        $currentApprovals = $this->current_approvals ?? [];

        // Check if all required approvers have approved
        return empty(array_diff($requiredApprovals, $currentApprovals));
    }

    /**
     * Get the next required approvers
     */
    public function getNextApprovers(): array
    {
        $requiredApprovals = $this->required_approvals ?? [];
        $currentApprovals = $this->current_approvals ?? [];

        // Return users who are required but haven't approved yet
        return array_diff($requiredApprovals, $currentApprovals);
    }

    /**
     * Add approval from a user
     */
    public function addApproval($userId): bool
    {
        if (!$this->canBeApprovedBy($userId)) {
            return false;
        }

        $currentApprovals = $this->current_approvals ?? [];
        $currentApprovals[] = $userId;
        $this->current_approvals = $currentApprovals;

        // Check if all approvals are obtained
        if ($this->hasAllApprovals()) {
            $this->status = 'approved';
            $this->approved_at = now();
        }

        $this->save();
        return true;
    }

    /**
     * Reject the approval request
     */
    public function reject($userId, $reason = null): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        $requiredApprovals = $this->required_approvals ?? [];
        if (!in_array($userId, $requiredApprovals)) {
            return false;
        }

        $this->status = 'rejected';
        $this->rejected_at = now();
        $this->rejection_reason = $reason;
        $this->save();

        return true;
    }

    /**
     * Determine required approval chain based on corporate hierarchy
     */
    public static function getRequiredApprovals($requesterRole, $targetUserRole = null): array
    {
        $approvals = [];

        // Define hierarchy: Admin > General Manager > Manager > Employee
        switch ($requesterRole) {
            case 1: // Admin
            case 5: // Admin (alternative)
                // Admin actions need General Manager and Manager approval
                $generalManagers = User::where('role', 1)->where('position', 'General Manager')->pluck('id')->toArray();
                $managers = User::where('position', 'Manager')->pluck('id')->toArray();
                $approvals = array_merge($generalManagers, $managers);
                break;

            case 'General Manager':
                // General Manager actions need Manager approval
                $managers = User::where('position', 'Manager')->pluck('id')->toArray();
                $approvals = $managers;
                break;

            case 'Manager':
                // Manager actions need Admin approval
                $admins = User::whereIn('role', [1, 5])->pluck('id')->toArray();
                $approvals = $admins;
                break;

            case 2: // Employee
                // Employee actions need Manager and Admin approval
                $managers = User::where('position', 'Manager')->pluck('id')->toArray();
                $admins = User::whereIn('role', [1, 5])->pluck('id')->toArray();
                $approvals = array_merge($managers, $admins);
                break;
        }

        return array_unique($approvals);
    }
}
