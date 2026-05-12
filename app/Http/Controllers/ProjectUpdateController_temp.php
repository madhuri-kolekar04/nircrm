<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectCompletionStatus;
use App\Models\Product;
use App\Models\Invoice;

// Add this to the existing ProjectUpdateController class

    /**
     * Update progress from interactive progress bar
     */
    public function updateProgress(Request $request, $id)
    {
        $user = Auth::user();
        
        // Restrict access for customer role (3) and customer position
        if ($user->role == 3 || strtolower($user->position ?? '') == 'customer') {
            abort(403, 'Unauthorized access. Customers cannot update progress.');
        }
        
        $request->validate([
            'completed_indexes' => 'required|array',
            'total_percentage' => 'required|integer|min:0|max:100',
            'completed_segments' => 'required|integer|min:0',
        ]);
        
        // Find the completion status
        $completionStatus = ProjectCompletionStatus::findOrFail($id);
        
        // Get the status items
        $statusItems = $completionStatus->status_items;
        $completedIndexes = $request->completed_indexes;
        $totalPercentage = $request->total_percentage;
        $completedSegments = $request->completed_segments;
        
        // Update status items with completion status
        $updatedItems = [];
        foreach ($statusItems as $index => $item) {
            $updatedItems[] = [
                'text' => $item,
                'completed' => in_array($index, $completedIndexes)
            ];
        }
        
        // Store the progress data in the model
        $completionStatus->update([
            'progress_data' => json_encode($updatedItems),
            'current_percentage' => $totalPercentage,
            'completed_segments_count' => $completedSegments,
        ]);
        
        return redirect()->route('project-updates.show', $completionStatus->project_id ?? $completionStatus->invoice_id)
            ->with('success', 'Progress updated successfully! Current completion: ' . $request->total_percentage . '%');
    }
