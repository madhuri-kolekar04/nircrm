<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadReaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'user_id',
        'department_id',
        'reaction_type',
        'notes',
        'next_follow_up',
        'call_duration',
        'reaction_date',
        'reaction_time',
        'notification_sent',
        'notification_sent_at',
    ];

    protected $casts = [
        'reaction_date' => 'date',
        'next_follow_up' => 'date',
        'reaction_time' => 'datetime:H:i:s',
        'call_duration' => 'integer',
        'notification_sent' => 'boolean',
        'notification_sent_at' => 'datetime',
    ];

    /**
     * Get the lead that owns the reaction
     */
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * Get the user who recorded the reaction
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department associated with the reaction
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get reaction type details
     */
    public function getReactionDetails()
    {
        $types = [
            'positive' => [
                'emoji' => '😊',
                'label' => 'Positive',
                'color' => '#28a745',
                'description' => 'Interested, Willing to proceed'
            ],
            'neutral' => [
                'emoji' => '😐',
                'label' => 'Neutral',
                'color' => '#ffc107',
                'description' => 'Needs more information, Thinking'
            ],
            'negative' => [
                'emoji' => '😞',
                'label' => 'Negative',
                'color' => '#dc3545',
                'description' => 'Not interested, Rejected'
            ],
            'follow_up' => [
                'emoji' => '📞',
                'label' => 'Follow Up Required',
                'color' => '#17a2b8',
                'description' => 'Call back needed, Pending decision'
            ],
            'interested' => [
                'emoji' => '🔥',
                'label' => 'Highly Interested',
                'color' => '#fd7e14',
                'description' => 'Very interested, Hot lead'
            ],
            'not_reachable' => [
                'emoji' => '📵',
                'label' => 'Not Reachable',
                'color' => '#6c757d',
                'description' => 'Phone not working, No response'
            ]
        ];

        return $types[$this->reaction_type] ?? [
            'emoji' => '❓',
            'label' => 'Unknown',
            'color' => '#6c757d',
            'description' => 'Unknown reaction type'
        ];
    }

    /**
     * Get the emoji for the reaction type
     */
    public function getReactionEmoji()
    {
        $details = $this->getReactionDetails();
        return $details['emoji'];
    }

    /**
     * Format call duration for display
     */
    public function getFormattedCallDurationAttribute()
    {
        if (!$this->call_duration) {
            return 'N/A';
        }

        $minutes = floor($this->call_duration / 60);
        $seconds = $this->call_duration % 60;

        if ($minutes > 0) {
            return $minutes . 'm ' . $seconds . 's';
        }

        return $seconds . 's';
    }

    /**
     * Get formatted reaction date and time
     */
    public function getFormattedDateTimeAttribute()
    {
        return $this->reaction_date->format('M d, Y') . ' at ' . $this->reaction_time;
    }
}
