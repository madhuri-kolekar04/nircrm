<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'grace_period_minutes',
        'is_active',
        'description'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'is_active' => 'boolean'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function isWithinShiftTime($currentTime = null)
    {
        $currentTime = $currentTime ?: now();
        $startTime = $this->start_time;
        $endTime = $this->end_time;

        // Handle overnight shifts (e.g., 22:00 to 07:00)
        if ($endTime < $startTime) {
            return $currentTime->format('H:i:s') >= $startTime->format('H:i:s') || 
                   $currentTime->format('H:i:s') <= $endTime->format('H:i:s');
        }

        return $currentTime->format('H:i:s') >= $startTime->format('H:i:s') && 
               $currentTime->format('H:i:s') <= $endTime->format('H:i:s');
    }

    public function isLateCheckIn($checkInTime)
    {
        $startTime = $this->start_time->copy()->addMinutes($this->grace_period_minutes);
        return $checkInTime->greaterThan($startTime);
    }

    public function isEarlyCheckout($checkOutTime)
    {
        $endTime = $this->end_time;
        return $checkOutTime->lessThan($endTime);
    }

    public function getShiftDurationHours()
    {
        $startTime = $this->start_time;
        $endTime = $this->end_time;

        // Handle overnight shifts
        if ($endTime < $startTime) {
            $endTime = $endTime->addDay();
        }

        return $startTime->diffInHours($endTime);
    }
}
