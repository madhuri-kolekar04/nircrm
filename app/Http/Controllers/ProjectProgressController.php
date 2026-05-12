<?php

namespace App\Http\Controllers;

use App\Models\ProjectProgress;
use App\Models\ProjectProgressUpdate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProjectProgressController extends Controller
{
    /**
     * Display project progress tracking page.
     */
    public function index($projectId = null, $invoiceId = null)
    {
        $user = Auth::user();
        
        // Determine if it's project or invoice
        if ($invoiceId) {
            $project = \App\Models\Invoice::findOrFail($invoiceId);
            $type = 'invoice';
        } else {
            $project = \App\Models\Product::findOrFail($projectId);
            $type = 'project';
        }
        
        // Get milestones with their updates
        $milestones = ProjectProgress::when($projectId, function($query) use ($projectId) {
                return $query->forProject($projectId);
            })
            ->when($invoiceId, function($query) use ($invoiceId) {
                return $query->forInvoice($invoiceId);
            })
            ->with(['user', 'updates' => function($query) {
                $query->latest()->limit(5);
            }])
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Get overall progress
        $overallProgress = ProjectProgress::getOverallProgress($projectId, $invoiceId);
        
        // Get milestones by status for dashboard
        $milestonesByStatus = ProjectProgress::getMilestonesByStatus($projectId, $invoiceId);
        
        // Get recent updates
        $recentUpdates = ProjectProgressUpdate::when($projectId, function($query) use ($projectId) {
                $query->whereHas('projectProgress', function($subQuery) use ($projectId) {
                    $subQuery->where('project_id', $projectId);
                });
            })
            ->when($invoiceId, function($query) use ($invoiceId) {
                $query->whereHas('projectProgress', function($subQuery) use ($invoiceId) {
                    $subQuery->where('invoice_id', $invoiceId);
                });
            })
            ->with(['user', 'projectProgress'])
            ->latest()
            ->limit(10)
            ->get();
        
        return view('project-progress.index', compact(
            'project', 
            'type', 
            'milestones', 
            'overallProgress', 
            'milestonesByStatus', 
            'recentUpdates'
        ));
    }
    
    /**
     * Show the form for creating a new milestone.
     */
    public function create($projectId = null, $invoiceId = null)
    {
        $user = Auth::user();
        
        // Check permissions
        if ($user->role == 3) {
            return back()->with('error', 'Customers cannot create milestones.');
        }
        
        return view('project-progress.create', compact('projectId', 'invoiceId'));
    }
    
    /**
     * Store a newly created milestone.
     */
    public function store(Request $request, $projectId = null, $invoiceId = null)
    {
        $user = Auth::user();
        
        // Check permissions
        if ($user->role == 3) {
            return back()->with('error', 'Customers cannot create milestones.');
        }
        
        $validated = $request->validate([
            'milestone_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed,delayed,cancelled',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'estimated_hours' => 'nullable|numeric|min:0',
            'priority' => 'required|in:low,medium,high,critical',
            'notes' => 'nullable|string',
            'attachments' => 'nullable|array',
        ]);
        
        $milestoneData = array_merge($validated, [
            'project_id' => $projectId,
            'invoice_id' => $invoiceId,
            'user_id' => $user->id,
        ]);
        
        $milestone = ProjectProgress::create($milestoneData);
        
        // Create initial update record
        ProjectProgressUpdate::create([
            'project_progress_id' => $milestone->id,
            'user_id' => $user->id,
            'title' => 'Milestone Created',
            'description' => "Milestone '{$milestone->milestone_title}' has been created with status: {$milestone->status}",
            'previous_percentage' => 0,
            'new_percentage' => $milestone->progress_percentage,
            'update_type' => 'milestone_created',
        ]);
        
        return redirect()
            ->route($invoiceId ? 'project-progress.index.invoice' : 'project-progress.index.project', 
                    [$projectId ?? $invoiceId])
            ->with('success', 'Milestone created successfully!');
    }
    
    /**
     * Display the specified milestone.
     */
    public function show($id)
    {
        $milestone = ProjectProgress::with(['user', 'updates.user', 'project', 'invoice'])
            ->findOrFail($id);
            
        return view('project-progress.show', compact('milestone'));
    }
    
    /**
     * Show the form for editing the specified milestone.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $milestone = ProjectProgress::findOrFail($id);
        
        // Check permissions
        if ($user->role == 3) {
            return back()->with('error', 'Customers cannot edit milestones.');
        }
        
        // Check if user can edit this milestone
        if ($user->role != 1 && $milestone->user_id != $user->id) {
            return back()->with('error', 'You can only edit your own milestones.');
        }
        
        return view('project-progress.edit', compact('milestone'));
    }
    
    /**
     * Update the specified milestone.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $milestone = ProjectProgress::findOrFail($id);
        
        // Check permissions
        if ($user->role == 3) {
            return back()->with('error', 'Customers cannot update milestones.');
        }
        
        if ($user->role != 1 && $milestone->user_id != $user->id) {
            return back()->with('error', 'You can only update your own milestones.');
        }
        
        $validated = $request->validate([
            'milestone_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed,delayed,cancelled',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'actual_end_date' => 'nullable|date',
            'estimated_hours' => 'nullable|numeric|min:0',
            'actual_hours' => 'nullable|numeric|min:0',
            'priority' => 'required|in:low,medium,high,critical',
            'notes' => 'nullable|string',
        ]);
        
        $previousPercentage = $milestone->progress_percentage;
        $previousStatus = $milestone->status;
        
        $milestone->update($validated);
        
        // Create update record if status or percentage changed
        if ($previousPercentage != $milestone->progress_percentage || $previousStatus != $milestone->status) {
            $updateType = $previousStatus != $milestone->status ? 'status_change' : 'progress_update';
            
            ProjectProgressUpdate::create([
                'project_progress_id' => $milestone->id,
                'user_id' => $user->id,
                'title' => $previousStatus != $milestone->status ? 'Status Changed' : 'Progress Updated',
                'description' => $previousStatus != $milestone->status 
                    ? "Status changed from {$previousStatus} to {$milestone->status}"
                    : "Progress updated from {$previousPercentage}% to {$milestone->progress_percentage}%",
                'previous_percentage' => $previousPercentage,
                'new_percentage' => $milestone->progress_percentage,
                'update_type' => $updateType,
            ]);
        }
        
        return redirect()
            ->route('project-progress.show', $milestone->id)
            ->with('success', 'Milestone updated successfully!');
    }
    
    /**
     * Remove the specified milestone.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $milestone = ProjectProgress::findOrFail($id);
        
        // Check permissions
        if ($user->role == 3) {
            return back()->with('error', 'Customers cannot delete milestones.');
        }
        
        if ($user->role != 1 && $milestone->user_id != $user->id) {
            return back()->with('error', 'You can only delete your own milestones.');
        }
        
        $milestone->delete();
        
        return back()->with('success', 'Milestone deleted successfully!');
    }
    
    /**
     * Add quick progress update to milestone.
     */
    public function addUpdate(Request $request, $id)
    {
        $user = Auth::user();
        $milestone = ProjectProgress::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'update_type' => 'required|in:progress_update,status_change,note,issue',
        ]);
        
        ProjectProgressUpdate::create([
            'project_progress_id' => $milestone->id,
            'user_id' => $user->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'previous_percentage' => $milestone->progress_percentage,
            'new_percentage' => $milestone->progress_percentage,
            'update_type' => $validated['update_type'],
        ]);
        
        return back()->with('success', 'Update added successfully!');
    }
    
    /**
     * Get progress data for AJAX requests.
     */
    public function getProgressData($projectId = null, $invoiceId = null)
    {
        $milestones = ProjectProgress::when($projectId, function($query) use ($projectId) {
                return $query->forProject($projectId);
            })
            ->when($invoiceId, function($query) use ($invoiceId) {
                return $query->forInvoice($invoiceId);
            })
            ->with(['user', 'updates'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        return response()->json([
            'milestones' => $milestones,
            'overallProgress' => ProjectProgress::getOverallProgress($projectId, $invoiceId),
        ]);
    }
    
    /**
     * Export progress data to Excel.
     */
    public function export($projectId = null, $invoiceId = null)
    {
        $user = Auth::user();
        
        if ($user->role == 3) {
            return back()->with('error', 'Customers cannot export progress data.');
        }
        
        $milestones = ProjectProgress::when($projectId, function($query) use ($projectId) {
                return $query->forProject($projectId);
            })
            ->when($invoiceId, function($query) use ($invoiceId) {
                return $query->forInvoice($invoiceId);
            })
            ->with(['user', 'updates'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        $filename = 'project_progress_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($milestones) {
            $file = fopen('php://output', 'w');
            
            // CSV header
            fputcsv($file, [
                'ID', 'Milestone Title', 'Description', 'Status', 'Progress %', 
                'Start Date', 'End Date', 'Actual End Date', 
                'Priority', 'Created By', 'Created At'
            ]);
            
            // CSV data
            foreach ($milestones as $milestone) {
                fputcsv($file, [
                    $milestone->id,
                    $milestone->milestone_title,
                    $milestone->description,
                    $milestone->status,
                    $milestone->progress_percentage . '%',
                    $milestone->start_date,
                    $milestone->end_date,
                    $milestone->actual_end_date,
                    $milestone->priority,
                    $milestone->user->name,
                    $milestone->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
