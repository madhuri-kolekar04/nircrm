<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadReaction;
use App\Models\LeadNotification;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionNotificationController extends Controller
{
    /**
     * Get all reaction and follow-up notifications for the authenticated user
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
                'is_read' => $notification->is_read,
                'reaction_type' => $notification->reaction ? $notification->reaction->getReactionDetails()['label'] : 'Follow-up',
                'reaction_emoji' => $notification->reaction ? $notification->reaction->getReactionDetails()['emoji'] : '📅'
            ];
        }

        // Get recent reactions for leads assigned to user
        $recentReactions = LeadReaction::whereHas('lead', function($query) use ($user) {
                $query->where('assigned_to', $user->id);
            })
            ->with(['lead', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        foreach ($recentReactions as $reaction) {
            $details = $reaction->getReactionDetails();
            $isRecent = $reaction->created_at->diffInHours(now()) <= 24;
            
            $notifications[] = [
                'id' => 'reaction_' . $reaction->id,
                'type' => 'lead_reaction',
                'title' => 'New Reaction Recorded',
                'message' => "New {$details['label']} reaction recorded for {$reaction->lead->name}",
                'lead_name' => $reaction->lead->name,
                'lead_id' => $reaction->lead->id,
                'reaction_type' => $details['label'],
                'reaction_emoji' => $details['emoji'],
                'is_overdue' => false,
                'is_today' => $isRecent,
                'priority' => $isRecent ? 'medium' : 'low',
                'created_at' => $reaction->created_at->format('M d, Y H:i'),
                'redirect_url' => route('leads.reaction', $reaction->lead->id),
                'is_read' => false,
                'recorded_by' => $reaction->user->name
            ];
        }

        // If user is General Manager, get all follow-ups from all leads
        if ($user->role == 5) {
            $allFollowUps = LeadNotification::where('is_read', false)
                ->whereHas('lead', function($query) {
                    $query->whereNotNull('assigned_to');
                })
                ->with(['lead', 'reaction'])
                ->orderBy('follow_up_date', 'asc')
                ->get();

            foreach ($allFollowUps as $notification) {
                $isOverdue = $notification->follow_up_date < now();
                $isToday = $notification->follow_up_date->isToday();
                
                $message = "Follow-up required for {$notification->lead->name} (Assigned to: " . 
                    ($notification->lead->assignedUser ? $notification->lead->assignedUser->name : 'Unassigned') . ")";
                
                $notifications[] = [
                    'id' => 'gm_' . $notification->id,
                    'type' => 'all_followups',
                    'title' => 'Team Follow-up Required',
                    'message' => $message,
                    'lead_name' => $notification->lead->name,
                    'lead_id' => $notification->lead->id,
                    'follow_up_date' => $notification->follow_up_date->format('M d, Y'),
                    'is_overdue' => $isOverdue,
                    'is_today' => $isToday,
                    'priority' => $isOverdue ? 'high' : ($isToday ? 'medium' : 'low'),
                    'created_at' => $notification->created_at->format('M d, Y H:i'),
                    'redirect_url' => route('leads.reaction', $notification->lead->id),
                    'is_read' => $notification->is_read,
                    'assigned_to' => $notification->lead->assignedUser ? $notification->lead->assignedUser->name : 'Unassigned',
                    'reaction_type' => $notification->reaction ? $notification->reaction->getReactionDetails()['label'] : 'Follow-up',
                    'reaction_emoji' => $notification->reaction ? $notification->reaction->getReactionDetails()['emoji'] : '📅'
                ];
            }
        }

        // Sort notifications by priority and date
        usort($notifications, function($a, $b) {
            $priorityOrder = ['high' => 3, 'medium' => 2, 'low' => 1];
            
            if ($a['priority'] !== $b['priority']) {
                return $priorityOrder[$b['priority']] - $priorityOrder[$a['priority']];
            }
            
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        // Get unread count
        $unreadCount = LeadNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => array_slice($notifications, 0, 20), // Limit to 20 most recent
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

        // Count recent reactions for assigned leads
        $recentReactionsCount = LeadReaction::whereHas('lead', function($query) use ($user) {
                $query->where('assigned_to', $user->id);
            })
            ->where('created_at', '>=', now()->subHours(24))
            ->count();

        $totalCount = $unreadCount + $recentReactionsCount;

        return response()->json([
            'unread_count' => $totalCount,
            'overdue_count' => $overdueCount,
            'recent_reactions' => $recentReactionsCount,
            'show_alert' => $overdueCount > 0 || $recentReactionsCount > 0
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        
        // Handle different notification types
        if (strpos($id, 'reaction_') === 0) {
            // This is a reaction notification, no database record to mark
            return response()->json([
                'success' => true,
                'unread_count' => LeadNotification::where('user_id', $user->id)->where('is_read', false)->count()
            ]);
        } elseif (strpos($id, 'gm_') === 0) {
            // This is a GM notification
            $notificationId = str_replace('gm_', '', $id);
            $notification = LeadNotification::where('id', $notificationId)->first();
        } else {
            // Regular lead notification
            $notification = LeadNotification::where('id', $id)
                ->where('user_id', $user->id)
                ->first();
        }

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
     * Mark all notifications as read for user
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
