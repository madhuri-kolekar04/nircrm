<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationRead extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_update_id',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification read.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the project update that was read.
     */
    public function projectUpdate()
    {
        return $this->belongsTo(ProjectUpdate::class);
    }

    /**
     * Mark a notification as read for a user
     */
    public static function markAsRead($userId, $projectUpdateId)
    {
        return self::updateOrCreate(
            ['user_id' => $userId, 'project_update_id' => $projectUpdateId],
            ['read_at' => now()]
        );
    }

    /**
     * Check if a notification is read by a user
     */
    public static function isRead($userId, $projectUpdateId)
    {
        return self::where('user_id', $userId)
                    ->where('project_update_id', $projectUpdateId)
                    ->whereNotNull('read_at')
                    ->exists();
    }

    /**
     * Get unread notifications count for a user
     */
    public static function getUnreadCount($userId)
    {
        // Get project updates that should be visible to this user
        $user = User::find($userId);
        if (!$user) return 0;

        $query = ProjectUpdate::query();

        if ($user->role == 1) {
            // Admin: All client request updates
            $query->whereNotNull('request_text');
        } elseif ($user->role == 2) {
            // Employee: Client request updates for their department
            $query->whereNotNull('request_text')
                  ->whereHas('invoice', function($q) use ($user) {
                      $q->where('department', $user->department);
                  });
        } elseif ($user->role == 3) {
            // Customer: Work updates for their invoices
            $query->whereNull('request_text')
                  ->whereHas('invoice', function($q) use ($user) {
                      $q->where('customer_email', $user->email);
                  });
        }

        // Get total visible updates minus read ones
        $totalVisible = $query->count();
        $readCount = self::where('user_id', $userId)
                        ->whereIn('project_update_id', $query->pluck('id'))
                        ->whereNotNull('read_at')
                        ->count();

        return max(0, $totalVisible - $readCount);
    }
}
