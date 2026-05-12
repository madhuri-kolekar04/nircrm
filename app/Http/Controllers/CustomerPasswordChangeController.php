<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomerPasswordChangeController extends Controller
{
    /**
     * Show the password change form for customers who need to change their password.
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Handle the password change request.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        
        // Update the password and mark password change as completed
        $user->update([
            'password' => Hash::make($request->password),
            'password_change_required' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully!'
        ]);
    }

    /**
     * Check if the current user needs to change their password.
     */
    public function checkPasswordChangeRequired()
    {
        $user = Auth::user();
        
        return response()->json([
            'password_change_required' => $user->password_change_required ?? false
        ]);
    }
}
