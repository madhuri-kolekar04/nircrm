<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RoleElementVisibility;
use Illuminate\Http\Request;

class RoleElementVisibilityController extends Controller
{
    public function getVisibility(Request $request)
    {
        $pageUrl = $request->input('page_url');
        $roleId = $request->input('role_id');

        if (!$pageUrl || !$roleId) {
            return response()->json(['error' => 'Missing parameters'], 400);
        }

        $visibility = RoleElementVisibility::getVisibilityForPage($pageUrl, $roleId);
        
        return response()->json([
            'success' => true,
            'data' => $visibility
        ]);
    }

    public function updateVisibility(Request $request)
    {
        $request->validate([
            'page_url' => 'required|string',
            'role_id' => 'required|integer',
            'element_identifier' => 'required|string',
            'element_type' => 'required|string',
            'element_name' => 'required|string',
            'is_visible' => 'required|boolean'
        ]);

        $visibility = RoleElementVisibility::updateOrCreate(
            [
                'page_url' => $request->page_url,
                'role_id' => $request->role_id,
                'element_identifier' => $request->element_identifier
            ],
            [
                'element_type' => $request->element_type,
                'element_name' => $request->element_name,
                'is_visible' => $request->is_visible,
                'element_metadata' => $request->element_metadata ?? null
            ]
        );

        return response()->json([
            'success' => true,
            'data' => $visibility
        ]);
    }

    public function getRoles()
    {
        try {
            \Log::info('Getting all available roles');
            
            // Define role mapping
            $roleMapping = [
                1 => 'Admin',
                2 => 'Employee', 
                3 => 'Customer',
                4 => 'Manager',
                5 => 'General Manager'
            ];
            
            // Get all unique roles from users table
            $uniqueRoles = \App\Models\User::distinct('role')
                ->orderBy('role')
                ->pluck('role')
                ->filter()
                ->values();
            
            $roles = $uniqueRoles->map(function($roleId) use ($roleMapping) {
                $roleName = $roleMapping[$roleId] ?? 'Unknown Role';
                return [
                    'id' => $roleId,
                    'name' => $roleName,
                    'display_name' => $roleName
                ];
            })->values();
            
            \Log::info('Roles retrieved:', $roles->toArray());

            return response()->json([
                'success' => true,
                'data' => $roles
            ]);

        } catch (\Exception $e) {
            \Log::error('Error getting roles', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error loading roles: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkUpdate(Request $request)
    {
        \Log::info('RoleElementVisibility bulkUpdate called', [
            'request_data' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        // Temporarily simplify validation for debugging
        try {
            $validated = $request->validate([
                'page_url' => 'required|string',
                'role_id' => 'required|integer',
                'elements' => 'required|array'
            ]);

            \Log::info('Basic validation passed', $validated);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->errors())
            ], 422);
        }

        $pageUrl = $request->page_url;
        $roleId = $request->role_id;
        $elements = $request->elements;

        \Log::info('Processing bulk update', [
            'page_url' => $pageUrl,
            'role_id' => $roleId,
            'elements_count' => count($elements)
        ]);

        try {
            // Delete existing visibility settings for this page and role
            RoleElementVisibility::where('page_url', $pageUrl)
                               ->where('role_id', $roleId)
                               ->delete();

            // Create new visibility settings
            foreach ($elements as $element) {
                RoleElementVisibility::create([
                    'page_url' => $pageUrl,
                    'role_id' => $roleId,
                    'element_type' => $element['element_type'] ?? 'unknown',
                    'element_identifier' => $element['element_identifier'] ?? 'unknown',
                    'element_name' => $element['element_name'] ?? 'Unknown Element',
                    'is_visible' => $element['is_visible'] ?? true,
                    'element_metadata' => $element['element_metadata'] ?? null
                ]);
            }

            \Log::info('Bulk update completed successfully');

            return response()->json([
                'success' => true,
                'message' => 'Visibility settings updated successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in bulk update', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function applyVisibility(Request $request)
    {
        $pageUrl = $request->input('page_url');
        $roleId = $request->input('role_id');

        if (!$pageUrl || !$roleId) {
            return response()->json(['error' => 'Missing parameters'], 400);
        }

        $visibility = RoleElementVisibility::getVisibilityForPage($pageUrl, $roleId);
        
        return response()->json([
            'success' => true,
            'data' => $visibility
        ]);
    }
}
