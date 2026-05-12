<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'check_in_time',
        'check_out_time',
        'status',
        'working_hours',
        'overtime_hours',
        'notes',
        'ip_address',
        'location',
        'is_late',
        'is_early_checkout',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime:H:i',
        'check_out_time' => 'datetime:H:i',
        'working_hours' => 'decimal:2',
        'overtime_hours' => 'decimal:2',
        'is_late' => 'boolean',
        'is_early_checkout' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function calculateWorkingHours()
    {
        if ($this->check_in_time && $this->check_out_time) {
            $checkIn = \Carbon\Carbon::createFromTime($this->check_in_time->hour, $this->check_in_time->minute);
            $checkOut = \Carbon\Carbon::createFromTime($this->check_out_time->hour, $this->check_out_time->minute);
            
            $totalMinutes = $checkOut->diffInMinutes($checkIn);
            $hours = $totalMinutes / 60;
            
            // Calculate overtime (assuming 8 hours is standard)
            $overtime = $hours > 8 ? $hours - 8 : 0;
            
            $this->working_hours = $hours;
            $this->overtime_hours = $overtime;
            $this->save();
        }
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'present' => 'success',
            'absent' => 'danger',
            'half_day' => 'warning',
            'on_leave' => 'info',
            'holiday' => 'primary',
            'weekend' => 'secondary',
            default => 'secondary'
        };
    }
}
