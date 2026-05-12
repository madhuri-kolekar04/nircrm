<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ActivityLog;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class LogsController extends Controller
{
    /**
     * Display the logs page.
     */
    public function index()
    {
        $adminData = Auth::user();
        $user = Auth::user();
        
        // Get statistics for the dashboard - user-specific if not admin
        $logsQuery = ActivityLog::query();
        
        if ($user->role != 1) {
            $logsQuery->where('user_id', $user->id);
        }
        
        $totalLogs = $logsQuery->count();
        $unreadLogs = $logsQuery->whereNull('read_at')->count();
        $todayLogs = $logsQuery->whereDate('created_at', today())->count();
        $criticalLogs = $logsQuery->where('level', 'error')->count();
        
        // Get recent logs for display - user-specific if not admin
        $logsQuery = ActivityLog::with('user')
            ->orderBy('created_at', 'desc');
            
        if ($user->role != 1) {
            $logsQuery->where('user_id', $user->id);
        }
        
        $logs = $logsQuery->paginate(20);
            
        // Get all users for filter dropdown (only for admin)
        $users = ($user->role == 1) ? User::orderBy('name')->get() : collect([$user]);
        
        // Log that user viewed logs page
        ActivityLog::logActivity('logs_view', 'You opened activity logs page', 'navigation', 'info');
        
        return view('admin.logs.index', compact('adminData', 'logs', 'totalLogs', 'unreadLogs', 'todayLogs', 'criticalLogs', 'users'));
    }

    /**
     * Get logs data for AJAX requests.
     */
    public function getLogs(Request $request)
    {
        $user = Auth::user();
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 20);
        $offset = ($page - 1) * $limit;
        $type = $request->get('type', '');
        $date = $request->get('date', '');
        $search = $request->get('search', '');

        // Get real activity logs from database
        $query = ActivityLog::with('user')
            ->orderBy('created_at', 'desc');

        // Filter by user if not admin
        if ($user->role != 1) {
            $query->where('user_id', $user->id);
        }

        // Apply filters
        if ($type) {
            $query->where('type', $type);
        }

        if ($date) {
            switch ($date) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', yesterday());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
            }
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        $totalLogs = $query->count();
        $logs = $query->offset($offset)->limit($limit)->get();

        // Format logs for display
        $formattedLogs = $logs->map(function($log) {
            return $log->getFormattedData();
        })->toArray();

        return response()->json([
            'logs' => $formattedLogs,
            'total' => $totalLogs,
            'page' => $page,
            'total_pages' => ceil($totalLogs / $limit),
            'has_more' => $offset + $limit < $totalLogs
        ]);
    }

    /**
     * Mark a specific log as read.
     */
    public function markAsRead($id)
    {
        $log = ActivityLog::find($id);
        
        if ($log) {
            $log->update(['read_at' => now()]);
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * Mark all logs as read.
     */
    public function markAllAsRead()
    {
        ActivityLog::whereNull('read_at')->update(['read_at' => now()]);
        
        return response()->json(['success' => true]);
    }

    /**
     * Delete a specific log.
     */
    public function deleteLog($id)
    {
        $log = ActivityLog::find($id);
        
        if ($log) {
            $log->delete();
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * Log user activity (called from JavaScript).
     */
    public function logActivity(Request $request)
    {
        $action = $request->get('action');
        $description = $request->get('description');
        $type = $request->get('type', 'user_action');
        $level = $request->get('level', 'info');
        $additionalData = $request->get('additional_data', []);

        if ($action) {
            $log = ActivityLog::logActivity($action, $description, $type, $level, $additionalData);
            
            return response()->json([
                'success' => true,
                'log_id' => $log ? $log->id : null,
                'message' => 'Activity logged successfully'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No action provided'], 400);
    }

    /**
     * Get activity statistics.
     */
    public function getStats(Request $request)
    {
        $user = Auth::user();
        $userId = $user->role == 1 ? null : $user->id;

        $stats = ActivityLog::getActivityStats($userId);

        return response()->json($stats);
    }

    /**
     * Get real-time activities (for live updates).
     */
    public function getRealTimeActivities(Request $request)
    {
        $user = Auth::user();
        $lastId = $request->get('last_id', 0);
        $limit = $request->get('limit', 10);

        $query = ActivityLog::with('user')
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'desc')
            ->limit($limit);

        // Filter by user if not admin
        if ($user->role != 1) {
            $query->where('user_id', $user->id);
        }

        $activities = $query->get();

        return response()->json([
            'activities' => $activities->map(function($activity) {
                return $activity->getFormattedData();
            })->toArray(),
            'has_more' => $activities->count() >= $limit
        ]);
    }
}
