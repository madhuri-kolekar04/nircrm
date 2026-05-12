<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShiftChangeNotification;

class ShiftController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Only Admin and General Manager can view shifts
        if (!in_array($user->role, [1, 5])) {
            abort(403, 'Unauthorized to view shifts.');
        }

        $shifts = Shift::with('users')->get();
        return view('shifts.index', compact('shifts'));
    }

    public function create()
    {
        $user = Auth::user();
        
        // Only Admin and General Manager can create shifts
        if (!in_array($user->role, [1, 5])) {
            abort(403, 'Unauthorized to create shifts.');
        }

        return view('shifts.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Only Admin and General Manager can create shifts
        if (!in_array($user->role, [1, 5])) {
            abort(403, 'Unauthorized to create shifts.');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'grace_period_minutes' => 'required|integer|min:0|max:60',
            'description' => 'nullable|string'
        ]);

        $shift = Shift::create($request->all());

        return redirect()->route('shifts.index')
            ->with('success', 'Shift created successfully.');
    }

    public function edit(Shift $shift)
    {
        $user = Auth::user();
        
        // Only Admin and General Manager can edit shifts
        if (!in_array($user->role, [1, 5])) {
            abort(403, 'Unauthorized to edit shifts.');
        }

        return view('shifts.edit', compact('shift'));
    }

    public function update(Request $request, Shift $shift)
    {
        $user = Auth::user();
        
        // Only Admin and General Manager can update shifts
        if (!in_array($user->role, [1, 5])) {
            abort(403, 'Unauthorized to update shifts.');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'grace_period_minutes' => 'required|integer|min:0|max:60',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $oldShiftData = $shift->toArray();
        $shift->update($request->all());

        // Send email notifications to all users assigned to this shift
        if ($this->shiftTimingChanged($oldShiftData, $request->all())) {
            $users = $shift->users;
            foreach ($users as $user) {
                try {
                    Mail::to($user->email)->send(new ShiftChangeNotification($shift, $oldShiftData));
                } catch (\Exception $e) {
                    // Log error but don't fail the update
                    \Log::error('Failed to send shift change email to user ' . $user->id . ': ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('shifts.index')
            ->with('success', 'Shift updated successfully.');
    }

    public function destroy(Shift $shift)
    {
        $user = Auth::user();
        
        // Only Admin can delete shifts
        if ($user->role !== 1) {
            abort(403, 'Unauthorized to delete shifts.');
        }

        // Check if shift has users assigned
        if ($shift->users()->count() > 0) {
            return redirect()->route('shifts.index')
                ->with('error', 'Cannot delete shift. Users are assigned to this shift.');
        }

        $shift->delete();

        return redirect()->route('shifts.index')
            ->with('success', 'Shift deleted successfully.');
    }

    public function assignShift(Request $request)
    {
        $user = Auth::user();
        
        // Only Admin and General Manager can assign shifts
        if (!in_array($user->role, [1, 5])) {
            return redirect()->back()->with('error', 'Unauthorized to assign shifts.');
        }

        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'shift_id' => 'required|exists:shifts,id'
            ]);

            $targetUser = User::findOrFail($request->user_id);
            $oldShiftId = $targetUser->shift_id;
            
            $targetUser->shift_id = $request->shift_id;
            $targetUser->save();

            // Send email notification if shift changed
            if ($oldShiftId != $request->shift_id && $request->shift_id) {
                $newShift = Shift::find($request->shift_id);
                try {
                    Mail::to($targetUser->email)->send(new ShiftChangeNotification($newShift, null, 'assigned'));
                } catch (\Exception $e) {
                    // Log error but don't fail assignment
                    \Log::error('Failed to send shift assignment email: ' . $e->getMessage());
                }
            }

            return redirect()->back()->with('success', 'Shift assigned successfully to ' . $targetUser->name);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Shift assignment error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to assign shift: ' . $e->getMessage());
        }
    }

    private function shiftTimingChanged($oldData, $newData)
    {
        return $oldData['start_time'] !== $newData['start_time'] ||
               $oldData['end_time'] !== $newData['end_time'] ||
               $oldData['grace_period_minutes'] !== $newData['grace_period_minutes'];
    }
}
