<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectUpdate;
use App\Models\Invoice;
use App\Models\NotificationRead;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get real-time notifications for the authenticated user
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $notifications = [];
        
        // Get the latest notification timestamp from the request
        $lastCheck = $request->input('last_check', now()->subMinutes(30)->timestamp);
        
        if ($user->role == 1) {
            // Admin: Get all client request updates
            $requestUpdates = ProjectUpdate::where('request_text', '!=', null)
                ->where('created_at', '>', date('Y-m-d H:i:s', $lastCheck))
                ->with(['user', 'invoice'])
                ->latest()
                ->limit(10)
                ->get();
                
            foreach ($requestUpdates as $update) {
                $isRead = NotificationRead::isRead($user->id, $update->id);
                $notifications[] = [
                    'id' => $update->id,
                    'type' => 'client_request',
                    'title' => 'Client Request Update',
                    'message' => $update->user->name . ' requested update for ' . ($update->invoice ? $update->invoice->project_name : 'Project'),
                    'details' => $this->getUpdateDetails($update->request_text),
                    'invoice_id' => $update->invoice_id,
                    'created_at' => $update->created_at->format('M d, Y H:i'),
                    'redirect_url' => route('project-updates.show', $update->invoice_id),
                    'is_read' => $isRead
                ];
            }
            
        } elseif ($user->role == 2) {
            // Employee: Get client request updates for their department
            $requestUpdates = ProjectUpdate::where('request_text', '!=', null)
                ->whereHas('invoice', function($query) use ($user) {
                    $query->where('department', $user->department);
                })
                ->where('created_at', '>', date('Y-m-d H:i:s', $lastCheck))
                ->with(['user', 'invoice'])
                ->latest()
                ->limit(10)
                ->get();
                
            foreach ($requestUpdates as $update) {
                $isRead = NotificationRead::isRead($user->id, $update->id);
                $notifications[] = [
                    'id' => $update->id,
                    'type' => 'client_request',
                    'title' => 'Client Request Update',
                    'message' => $update->user->name . ' requested update for ' . ($update->invoice ? $update->invoice->project_name : 'Project'),
                    'details' => $this->getUpdateDetails($update->request_text),
                    'invoice_id' => $update->invoice_id,
                    'created_at' => $update->created_at->format('M d, Y H:i'),
                    'redirect_url' => route('project-updates.show', $update->invoice_id),
                    'is_read' => $isRead
                ];
            }
            
        } elseif ($user->role == 3) {
            // Customer: Get work updates for their invoices
            $workUpdates = ProjectUpdate::where('request_text', null)
                ->whereHas('invoice', function($query) use ($user) {
                    $query->where('customer_email', $user->email);
                })
                ->where('created_at', '>', date('Y-m-d H:i:s', $lastCheck))
                ->with(['user', 'invoice'])
                ->latest()
                ->limit(10)
                ->get();
                
            foreach ($workUpdates as $update) {
                $isRead = NotificationRead::isRead($user->id, $update->id);
                $notifications[] = [
                    'id' => $update->id,
                    'type' => 'work_update',
                    'title' => 'Work Update',
                    'message' => $update->user->name . ' updated ' . ($update->invoice ? $update->invoice->project_name : 'Project'),
                    'details' => $this->getWorkUpdateDetails($update),
                    'invoice_id' => $update->invoice_id,
                    'created_at' => $update->created_at->format('M d, Y H:i'),
                    'redirect_url' => route('project-updates.show', $update->invoice_id),
                    'is_read' => $isRead
                ];
            }
        }
        
        // Get unread count
        $unreadCount = NotificationRead::getUnreadCount($user->id);
        
        return response()->json([
            'notifications' => $notifications,
            'count' => count($notifications),
            'unread_count' => $unreadCount,
            'timestamp' => now()->timestamp
        ]);
    }
    
    /**
     * Get first 2 lines of request text
     */
    private function getUpdateDetails($requestText)
    {
        if (empty($requestText)) return '';
        
        $lines = explode("\n", $requestText);
        $details = [];
        
        foreach ($lines as $line) {
            $cleanLine = trim($line);
            if (!empty($cleanLine)) {
                $details[] = $cleanLine;
                if (count($details) >= 2) break;
            }
        }
        
        return implode(' | ', $details);
    }
    
    /**
     * Get first 2 lines of work update
     */
    private function getWorkUpdateDetails($update)
    {
        $details = [];
        
        if (!empty($update->update_point_1)) {
            $details[] = $update->update_point_1;
        }
        
        if (!empty($update->update_point_2) && count($details) < 2) {
            $details[] = $update->update_point_2;
        }
        
        if (count($details) < 2 && !empty($update->update_point_3)) {
            // Check if it's JSON
            $decoded = json_decode($update->update_point_3, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                foreach ($decoded as $point) {
                    if (!empty(trim($point)) && count($details) < 2) {
                        $details[] = $point;
                    }
                }
            } else {
                $details[] = $update->update_point_3;
            }
        }
        
        return implode(' | ', array_slice($details, 0, 2));
    }
    
    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        
        // Verify user has access to this notification
        $update = ProjectUpdate::find($id);
        if (!$update) {
            return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
        }
        
        // Check if user should see this notification
        if (!$this->userCanSeeNotification($user, $update)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        // Mark as read
        NotificationRead::markAsRead($user->id, $id);
        
        return response()->json([
            'success' => true,
            'unread_count' => NotificationRead::getUnreadCount($user->id)
        ]);
    }
    
    /**
     * Mark all notifications as read for user
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        
        // Get all visible updates for this user
        $updates = $this->getVisibleUpdatesForUser($user);
        
        // Mark all as read
        foreach ($updates as $update) {
            NotificationRead::markAsRead($user->id, $update->id);
        }
        
        return response()->json([
            'success' => true,
            'unread_count' => 0
        ]);
    }
    
    /**
     * Check if user can see notification
     */
    private function userCanSeeNotification($user, $update)
    {
        if ($user->role == 1) {
            // Admin can see all client requests
            return !empty($update->request_text);
        } elseif ($user->role == 2) {
            // Employee can see client requests for their department
            if (empty($update->request_text)) return false;
            return $update->invoice && $update->invoice->department === $user->department;
        } elseif ($user->role == 3) {
            // Customer can see work updates for their invoices
            if (!empty($update->request_text)) return false;
            return $update->invoice && $update->invoice->customer_email === $user->email;
        }
        
        return false;
    }
    
    /**
     * Get all visible updates for user
     */
    private function getVisibleUpdatesForUser($user)
    {
        $query = ProjectUpdate::query();
        
        if ($user->role == 1) {
            $query->whereNotNull('request_text');
        } elseif ($user->role == 2) {
            $query->whereNotNull('request_text')
                  ->whereHas('invoice', function($q) use ($user) {
                      $q->where('department', $user->department);
                  });
        } elseif ($user->role == 3) {
            $query->whereNull('request_text')
                  ->whereHas('invoice', function($q) use ($user) {
                      $q->where('customer_email', $user->email);
                  });
        }
        
        return $query->get();
    }
}
