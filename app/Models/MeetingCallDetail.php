<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingCallDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_full_name',
        'lead_business_name',
        'lead_email',
        'lead_whatsapp',
        'lead_website_url',
        'called_by_employee_name',
        'called_by_employee_email',
        'rating',
        'meeting_conclusion',
        'next_call_date',
        'additional_notes'
    ];

    protected $casts = [
        'next_call_date' => 'datetime',
        'rating' => 'integer'
    ];

    /**
     * Get meetings for a specific lead
     */
    public function scopeForLead($query, $email)
    {
        return $query->where('lead_email', $email);
    }

    /**
     * Get meetings by employee
     */
    public function scopeByEmployee($query, $email)
    {
        return $query->where('called_by_employee_email', $email);
    }

    /**
     * Get scheduled meetings
     */
    public function scopeScheduled($query)
    {
        return $query->where('meeting_status', 'scheduled');
    }

    /**
     * Get completed meetings
     */
    public function scopeCompleted($query)
    {
        return $query->where('meeting_status', 'completed');
    }

    /**
     * Get converted leads
     */
    public function scopeConverted($query)
    {
        return $query->where('is_converted', true);
    }

    /**
     * Get upcoming meetings
     */
    public function scopeUpcoming($query)
    {
        return $query->where('meeting_date_time', '>', now())
                    ->where('meeting_status', 'scheduled');
    }

    /**
     * Format meeting duration
     */
    public function getFormattedDurationAttribute()
    {
        return $this->meeting_duration_hours ? $this->meeting_duration_hours . ' hours' : 'N/A';
    }

    /**
     * Format deal value
     */
    public function getFormattedDealValueAttribute()
    {
        return $this->deal_value ? '₹' . number_format($this->deal_value, 2) : 'N/A';
    }

    /**
     * Get the employee relationship
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'called_by_employee_email', 'email');
    }
}
