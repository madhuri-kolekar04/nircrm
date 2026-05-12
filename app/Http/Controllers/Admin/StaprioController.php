<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staprio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StaprioController extends Controller
{
    /**
     * Get all statuses.
     */
    public function getStatuses(): JsonResponse
    {
        $statuses = Staprio::getAllStatuses();
        return response()->json($statuses);
    }

    /**
     * Get all priorities.
     */
    public function getPriorities(): JsonResponse
    {
        $priorities = Staprio::getAllPriorities();
        return response()->json($priorities);
    }

    /**
     * Add new status or priority.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:status,priority',
            'color' => 'nullable|string|max:7',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'type' => $request->type,
                'value' => strtolower(str_replace(' ', '_', $request->name)),
                'color' => $request->color ?: $this->getDefaultColor($request->type),
                'sort_order' => Staprio::getNextSortOrder($request->type),
                'is_active' => true,
                'is_protected' => false,
            ];

            $staprio = Staprio::addStaprio($data);

            return response()->json([
                'success' => true,
                'message' => ucfirst($request->type) . ' added successfully',
                'data' => $staprio
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update status or priority.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'value' => strtolower(str_replace(' ', '_', $request->name)),
                'color' => $request->color,
            ];

            Staprio::updateStaprio($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Delete status or priority.
     */
    public function destroy($id): JsonResponse
    {
        try {
            Staprio::deleteStaprio($id);

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get default color for type.
     */
    private function getDefaultColor(string $type): string
    {
        return match($type) {
            'status' => '#6c757d',
            'priority' => '#ffc107',
            default => '#6c757d',
        };
    }
}
