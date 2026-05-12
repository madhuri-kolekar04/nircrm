<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'user_id',
        'reaction_id',
        'type',
        'title',
        'message',
        'follow_up_date',
        'is_read',
        'is_email_sent',
        'email_sent_at',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
        'email_sent_at' => 'datetime',
        'is_read' => 'boolean',
        'is_email_sent' => 'boolean',
    ];

    /**
     * Get the lead associated with the notification
     */
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * Get the user who owns the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reaction that triggered the notification
     */
    public function reaction()
    {
        return $this->belongsTo(LeadReaction::class);
    }

    /**
     * Create a follow-up notification
     */
    public static function createFollowUpNotification($leadId, $userId, $reactionId, $followUpDate, $reactionTime = null)
    {
        $lead = Lead::find($leadId);
        
        $message = "Follow-up required for lead: {$lead->name} on " . $followUpDate->format('M d, Y');
        if ($reactionTime) {
            $message .= " at " . $reactionTime->format('g:i A');
        }
        
        return self::create([
            'lead_id' => $leadId,
            'user_id' => $userId,
            'reaction_id' => $reactionId,
            'type' => 'follow_up',
            'title' => 'Follow-up Required',
            'message' => $message,
            'follow_up_date' => $followUpDate,
            'follow_up_time' => $reactionTime,
            'is_read' => false,
            'is_email_sent' => false,
        ]);
    }

    /**
     * Get unread notifications for user
     */
    public static function getUnreadForUser($userId)
    {
        return self::where('user_id', $userId)
                    ->where('is_read', false)
                    ->with(['lead', 'reaction'])
                    ->orderBy('follow_up_date', 'asc')
                    ->get();
    }

    /**
     * Get notifications due today or overdue
     */
    public static function getDueNotifications()
    {
        return self::whereDate('follow_up_date', '<=', now())
                    ->where('is_read', false)
                    ->with(['lead', 'user'])
                    ->orderBy('follow_up_date', 'asc')
                    ->get();
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->is_read = true;
        $this->save();
    }

    /**
     * Mark email as sent
     */
    public function markEmailAsSent()
    {
        $this->is_email_sent = true;
        $this->email_sent_at = now();
        $this->save();
    }
}
