<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_date',
        'task_description',
        'client_project_name',
        'status',
        'task_number',
    ];

    protected $casts = [
        'task_date' => 'datetime',
    ];

    /**
     * Get the user that owns the task.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted task description with number
     */
    public function getFormattedDescriptionAttribute(): string
    {
        return $this->task_number . '. ' . $this->task_description;
    }

    /**
     * Get status badge HTML
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'in_progress' => '<span class="badge bg-info">In Progress</span>',
            'completed' => '<span class="badge bg-success">Completed</span>',
            'stopped' => '<span class="badge bg-danger">Stopped</span>',
            'on_hold' => '<span class="badge bg-secondary">On Hold</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }
}
