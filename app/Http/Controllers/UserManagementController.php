<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserDeactivationNotification;

class UserManagementController extends Controller
{
    public function toggleUserStatus(Request $request)
    {
        $user = Auth::user();
        
        // Only Admin and General Manager can toggle user status
        if (!in_array($user->role, [1, 5])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to manage users.'
            ]);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'is_active' => 'required|boolean'
        ]);

        $targetUser = User::findOrFail($request->user_id);
        
        // Don't allow deactivating self or higher role users
        if ($targetUser->id === $user->id || $targetUser->role <= $user->role) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot change status for this user.'
            ]);
        }

        $oldStatus = $targetUser->is_active;
        $targetUser->is_active = $request->is_active;
        
        if (!$request->is_active) {
            $targetUser->deactivated_at = now();
            $targetUser->deactivated_by = $user->id;
            $targetUser->deactivation_reason = $request->input('reason', 'Deactivated by administrator');
        } else {
            $targetUser->deactivated_at = null;
            $targetUser->deactivated_by = null;
            $targetUser->deactivation_reason = null;
        }
        
        $targetUser->save();

        // Send email notification if deactivated
        if (!$request->is_active && $oldStatus) {
            Mail::to($targetUser->email)->send(new UserDeactivationNotification($targetUser, $user));
        }

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully.'
        ]);
    }

    public function getUsersWithShifts()
    {
        $user = Auth::user();
        
        // Only Admin and General Manager can view user management
        if (!in_array($user->role, [1, 5])) {
            abort(403, 'Unauthorized');
        }

        $users = User::with(['department', 'shift'])
            ->where('role', '!=', 1) // Exclude other admins unless you're the main admin
            ->where('id', '!=', $user->id)
            ->get();

        $shifts = Shift::where('is_active', true)->get();

        return view('user-management.index', compact('users', 'shifts'));
    }

    public function bulkAssignShift(Request $request)
    {
        $user = Auth::user();
        
        // Only Admin and General Manager can bulk assign shifts
        if (!in_array($user->role, [1, 5])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to assign shifts.'
            ]);
        }

        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'shift_id' => 'nullable|exists:shifts,id'
        ]);

        $users = User::whereIn('id', $request->user_ids)->get();
        $shift = $request->shift_id ? Shift::find($request->shift_id) : null;

        foreach ($users as $targetUser) {
            $oldShiftId = $targetUser->shift_id;
            $targetUser->shift_id = $request->shift_id;
            $targetUser->save();

            // Send email notification if shift changed
            if ($oldShiftId != $request->shift_id && $shift) {
                Mail::to($targetUser->email)->send(new \App\Mail\ShiftChangeNotification($shift, null, 'assigned'));
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Shifts assigned successfully.'
        ]);
    }
}
