<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ReactionsSystem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reactions_system';

    protected $fillable = [
        'lead_id',
        'user_id',
        'customer_id',
        'department_id',
        'reaction_type',
        'notes',
        'reaction_details',
        'reaction_date',
        'reaction_time',
        'reaction_timestamp',
        'next_follow_up',
        'follow_up_time',
        'follow_up_priority',
        'follow_up_notes',
        'call_duration',
        'call_type',
        'phone_number',
        'meeting_date',
        'meeting_time',
        'meeting_location',
        'meeting_agenda',
        'status',
        'priority',
        'rating',
        'source',
        'campaign',
        'value',
        'tags',
        'email_sent',
        'sms_sent',
        'notification_sent',
        'last_notification_sent'
    ];

    protected $casts = [
        'reaction_date' => 'date',
        'reaction_time' => 'time',
        'reaction_timestamp' => 'datetime',
        'next_follow_up' => 'date',
        'follow_up_time' => 'time',
        'meeting_date' => 'date',
        'meeting_time' => 'time',
        'last_notification_sent' => 'datetime',
        'value' => 'decimal:2',
        'email_sent' => 'boolean',
        'sms_sent' => 'boolean',
        'notification_sent' => 'boolean',
        'rating' => 'integer'
    ];

    protected $dates = [
        'reaction_date',
        'next_follow_up',
        'meeting_date',
        'last_notification_sent',
        'deleted_at'
    ];

    // Relationships
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // Scopes for common queries
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByLead($query, $leadId)
    {
        return $query->where('lead_id', $leadId);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeUpcomingFollowUp($query)
    {
        return $query->where('next_follow_up', '>=', now()->toDateString())
                    ->where('status', 'active');
    }

    public function scopeOverdueFollowUp($query)
    {
        return $query->where('next_follow_up', '<', now()->toDateString())
                    ->where('status', 'active');
    }

    // Accessors and Mutators
    public function getReactionTypeLabelAttribute(): string
    {
        $labels = [
            'positive' => '😊 Positive',
            'neutral' => '😐 Neutral',
            'negative' => '😞 Negative',
            'follow_up' => '📞 Follow Up Required',
            'interested' => '🔥 Highly Interested',
            'not_reachable' => '📵 Not Reachable',
            'hot_lead' => '🔥 Hot Lead',
            'cold_lead' => '❄️ Cold Lead',
            'appointment_set' => '📅 Appointment Set',
            'meeting_scheduled' => '🤝 Meeting Scheduled',
            'proposal_sent' => '📄 Proposal Sent',
            'negotiation' => '💰 Negotiation',
            'closed_won' => '✅ Closed Won',
            'closed_lost' => '❌ Closed Lost'
        ];

        return $labels[$this->reaction_type] ?? '❓ Unknown';
    }

    public function getPriorityLabelAttribute(): string
    {
        $labels = [
            'low' => '🟢 Low',
            'medium' => '🟡 Medium',
            'high' => '🟠 High',
            'urgent' => '🔴 Urgent'
        ];

        return $labels[$this->priority] ?? '🟡 Medium';
    }

    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'active' => '🔄 Active',
            'completed' => '✅ Completed',
            'cancelled' => '❌ Cancelled',
            'postponed' => '⏸️ Postponed'
        ];

        return $labels[$this->status] ?? '🔄 Active';
    }

    public function getFormattedCallDurationAttribute(): string
    {
        if (!$this->call_duration) {
            return 'N/A';
        }

        $minutes = floor($this->call_duration / 60);
        $seconds = $this->call_duration % 60;

        return $minutes > 0 ? "{$minutes}m {$seconds}s" : "{$seconds}s";
    }

    public function getFormattedFollowUpDateAttribute(): string
    {
        if (!$this->next_follow_up) {
            return 'Not set';
        }

        $date = Carbon::parse($this->next_follow_up);
        $time = $this->follow_up_time ?? '00:00:00';
        
        return $date->format('M d, Y') . ' at ' . date('g:i A', strtotime($time));
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->next_follow_up && 
               Carbon::parse($this->next_follow_up)->isPast() && 
               $this->status === 'active';
    }

    public function getIsTodayAttribute(): bool
    {
        return $this->next_follow_up && 
               Carbon::parse($this->next_follow_up)->isToday();
    }

    public function getTagsArrayAttribute(): array
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }

    // Methods for notification system
    public function markNotificationSent(): void
    {
        $this->update([
            'notification_sent' => true,
            'last_notification_sent' => now()
        ]);
    }

    public function markEmailSent(): void
    {
        $this->update(['email_sent' => true]);
    }

    public function markSmsSent(): void
    {
        $this->update(['sms_sent' => true]);
    }

    public function complete(): void
    {
        $this->update(['status' => 'completed']);
    }

    public function postpone(): void
    {
        $this->update(['status' => 'postponed']);
    }

    public function cancel(): void
    {
        $this->update(['status' => 'cancelled']);
    }
}
