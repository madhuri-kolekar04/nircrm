<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'status',
        'approver_id',
        'approval_date',
        'approval_notes',
        'rejection_reason',
        'attachments',
        'is_half_day',
        'is_full_day',
        'half_day_type',
        'emergency_contact',
        'is_paid_leave',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approval_date' => 'datetime',
        'attachments' => 'array',
        'is_half_day' => 'boolean',
        'is_paid_leave' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(LeaveApproval::class);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->where(function ($q) use ($startDate, $endDate) {
            $q->whereBetween('start_date', [$startDate, $endDate])
              ->orWhereBetween('end_date', [$startDate, $endDate])
              ->orWhere(function ($q) use ($startDate, $endDate) {
                  $q->where('start_date', '<=', $startDate)
                    ->where('end_date', '>=', $endDate);
              });
        });
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'cancelled' => 'secondary',
            'on_hold' => 'info',
            default => 'secondary'
        };
    }

    public function getStatusBadgeAttribute()
    {
        return '<span class="badge bg-' . $this->status_color . '">' . ucfirst($this->status) . '</span>';
    }

    public function getNextApprovalLevel()
    {
        $applicantRole = $this->user->role;
        
        // Employee (role 2) -> Manager (role 4) -> General Manager (role 5) -> Admin (role 1)
        if ($applicantRole == 2) { // Employee
            return 'manager';
        } elseif ($applicantRole == 4) { // Manager
            return 'general_manager';
        } elseif ($applicantRole == 5) { // General Manager
            return 'admin';
        }
        
        return null; // Admin doesn't need approval
    }

    public function getNextApprover()
    {
        $level = $this->getNextApprovalLevel();
        
        if ($level == 'manager') {
            // Get department manager first (strict hierarchy)
            $manager = User::where('role', 4)
                          ->where('department_id', $this->user->department_id)
                          ->first();
            
            // If no department manager, fall back to any manager
            if (!$manager) {
                $manager = User::where('role', 4)->first();
            }
            
            return $manager;
        } elseif ($level == 'general_manager') {
            // Get general manager (strict hierarchy)
            return User::where('role', 5)->first();
        } elseif ($level == 'admin') {
            // Get admin (strict hierarchy)
            return User::where('role', 1)->first();
        }
        
        return null;
    }

    public function canBeApprovedBy($user)
    {
        $nextLevel = $this->getNextApprovalLevel();
        
        if (!$nextLevel) return false;
        
        if ($nextLevel == 'manager' && $user->role == 4) {
            // Manager can approve if they're in the same department or if no department manager exists
            return $user->department_id == $this->user->department_id || 
                   !User::where('role', 4)->where('department_id', $this->user->department_id)->where('id', '!=', $user->id)->exists();
        }
        
        if ($nextLevel == 'general_manager' && $user->role == 5) {
            return true;
        }
        
        if ($nextLevel == 'admin' && $user->role == 1) {
            return true;
        }
        
        return false;
    }

    public function createApprovalChain()
    {
        $approvals = [];
        $nextLevel = $this->getNextApprovalLevel();
        
        if ($nextLevel) {
            $approver = $this->getNextApprover();
            if ($approver) {
                $approvals[] = [
                    'leave_id' => $this->id,
                    'approver_id' => $approver->id,
                    'approval_level' => $nextLevel,
                    'status' => 'pending',
                ];
            }
        }
        
        return $approvals;
    }

    public function approve($approver, $notes = null)
    {
        // Create or update approval record
        $approval = $this->approvals()
                        ->where('approver_id', $approver->id)
                        ->first();
        
        if (!$approval) {
            $approval = new LeaveApproval([
                'approver_id' => $approver->id,
                'approval_level' => $this->getNextApprovalLevel(),
            ]);
            $this->approvals()->save($approval);
        }
        
        $approval->approve($notes);
        
        // Check if all required approvals are completed
        $this->updateStatus();
        
        // Send notification to applicant
        try {
            \Mail::to($this->user->email)->send(new \App\Mail\LeaveApprovalNotification($this, $approver));
            \Log::info("Leave approval notification sent to applicant: " . $this->user->email . " for leave ID: " . $this->id);
        } catch (\Exception $e) {
            \Log::error("Failed to send approval notification to applicant: " . $this->user->email . " Error: " . $e->getMessage());
        }
        
        // If leave is still pending (needs more approvals), notify next level
        if ($this->status === 'pending') {
            $this->notifyNextLevelApprover();
        }
        
        return $this;
    }

    public function reject($approver, $reason)
    {
        // Create or update approval record
        $approval = $this->approvals()
                        ->where('approver_id', $approver->id)
                        ->first();
        
        if (!$approval) {
            $approval = new LeaveApproval([
                'approver_id' => $approver->id,
                'approval_level' => $this->getNextApprovalLevel(),
            ]);
            $this->approvals()->save($approval);
        }
        
        $approval->reject($reason);
        
        // Update leave status to rejected
        $this->status = 'rejected';
        $this->approver_id = $approver->id;
        $this->approval_date = now();
        $this->rejection_reason = $reason;
        $this->save();

        // Send email notification
        \Mail::to($this->user->email)->send(new \App\Mail\LeaveRejected($this));
        
        return $this;
    }

    public function updateStatus()
    {
        $pendingApprovals = $this->approvals()->pending()->count();
        
        if ($pendingApprovals === 0) {
            $this->status = 'approved';
            $this->approval_date = now();
            $this->save();
        } else {
            $this->status = 'pending';
            $this->save();
        }
    }
    
    public function notifyNextLevelApprover()
    {
        $nextApprover = $this->getNextApprover();
        
        if ($nextApprover && $nextApprover->email) {
            try {
                \Mail::to($nextApprover->email)->send(new \App\Mail\LeaveApplicationNotification($this, $nextApprover));
                \Log::info("Next level approval notification sent to: " . $nextApprover->email . " for leave ID: " . $this->id);
            } catch (\Exception $e) {
                \Log::error("Failed to send next level approval notification to: " . $nextApprover->email . " Error: " . $e->getMessage());
            }
        } else {
            \Log::warning("No next level approver found for leave ID: " . $this->id);
        }
    }
}
