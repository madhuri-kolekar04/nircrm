<?php

namespace App\Http\Controllers;

use App\Models\LeadNotification;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadNotificationController extends Controller
{
    /**
     * Get lead notifications for the authenticated user
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $notifications = [];
        
        // Get lead follow-up notifications
        $leadNotifications = LeadNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->with(['lead', 'reaction'])
            ->orderBy('follow_up_date', 'asc')
            ->get();

        foreach ($leadNotifications as $notification) {
            $isOverdue = $notification->follow_up_date < now();
            $isToday = $notification->follow_up_date->isToday();
            
            $notifications[] = [
                'id' => $notification->id,
                'type' => 'lead_followup',
                'title' => $notification->title,
                'message' => $notification->message,
                'lead_name' => $notification->lead->name,
                'lead_id' => $notification->lead->id,
                'follow_up_date' => $notification->follow_up_date->format('M d, Y'),
                'is_overdue' => $isOverdue,
                'is_today' => $isToday,
                'priority' => $isOverdue ? 'high' : ($isToday ? 'medium' : 'low'),
                'created_at' => $notification->created_at->format('M d, Y H:i'),
                'redirect_url' => route('leads.reaction', $notification->lead->id),
                'is_read' => $notification->is_read
            ];
        }

        // Get unread count
        $unreadCount = LeadNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'count' => count($notifications),
            'unread_count' => $unreadCount,
            'timestamp' => now()->timestamp
        ]);
    }

    /**
     * Get notifications count for header display
     */
    public function getNotificationCount(Request $request)
    {
        $user = Auth::user();
        
        $unreadCount = LeadNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        // Check for overdue notifications
        $overdueCount = LeadNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->whereDate('follow_up_date', '<', now())
            ->count();

        return response()->json([
            'unread_count' => $unreadCount,
            'overdue_count' => $overdueCount,
            'show_alert' => $overdueCount > 0
        ]);
    }

    /**
     * Mark lead notification as read
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        
        $notification = LeadNotification::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$notification) {
            return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'unread_count' => LeadNotification::where('user_id', $user->id)->where('is_read', false)->count()
        ]);
    }

    /**
     * Mark all lead notifications as read for user
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        
        LeadNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'unread_count' => 0
        ]);
    }

    /**
     * Get upcoming follow-ups for dashboard
     */
    public function getUpcomingFollowUps(Request $request)
    {
        $user = Auth::user();
        $days = $request->get('days', 7); // Default next 7 days
        
        $followUps = LeadNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->whereDate('follow_up_date', '>=', now())
            ->whereDate('follow_up_date', '<=', now()->addDays($days))
            ->with(['lead', 'reaction'])
            ->orderBy('follow_up_date', 'asc')
            ->get();

        $upcoming = [];
        foreach ($followUps as $followUp) {
            $upcoming[] = [
                'id' => $followUp->id,
                'lead_name' => $followUp->lead->name,
                'lead_id' => $followUp->lead->id,
                'follow_up_date' => $followUp->follow_up_date->format('M d, Y'),
                'days_until' => now()->diffInDays($followUp->follow_up_date),
                'reaction_type' => $followUp->reaction->getReactionDetails()['label'],
                'notes' => $followUp->reaction->notes,
            ];
        }

        return response()->json([
            'upcoming_followups' => $upcoming,
            'count' => count($upcoming)
        ]);
    }
}
