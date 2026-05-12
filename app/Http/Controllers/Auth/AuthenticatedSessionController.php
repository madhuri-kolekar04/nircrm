<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     * 
     * 
     * 
     */
     
     
     
     
     
     
     
    
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        
        // Store login origin in session for logout redirection
        $loginOrigin = $request->input('login_origin', 'employee_portal');
        $request->session()->put('login_origin', $loginOrigin);
        
        // Check if user has profile image and show splash screen
        if (!empty($user->profile_photo_path)) {
            // Store intended URL in session for redirect after splash
            $intendedUrl = $this->getIntendedUrl($user);
            session(['url.intended' => $intendedUrl]);
            
            return redirect()->route('profile.splash');
        }
        
        // Check customer panel access for customer role users
        if ($user->role == 3) {
            // Check both quotations and leads for panel access
            $hasQuotationAccess = \App\Models\Quotation::where('client_email', $user->email)
                                                          ->where('customer_panel', true)
                                                          ->exists();
            
            $hasLeadAccess = \App\Models\Lead::where('email', $user->email)
                                             ->where('customer_panel', true)
                                             ->exists();
            
            $hasPanelAccess = $hasQuotationAccess || $hasLeadAccess;
            
            if (!$hasPanelAccess) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')
                    ->with('error', 'Your customer panel access has been disabled. Please contact support for assistance.');
            }
        }
        
        // Redirect based on user role
        if ($user->role == 1 || $user->role == 5) {
            return redirect()->route('attendance.dashboard')->with('show_attendance_popup', true);
        } elseif ($user->role == 4 || $user->position == 'Manager') {
            return redirect()->route('employees.index');
        } elseif ($user->role == 2) {
            return redirect()->route('project-updates.index')->with('show_attendance_popup', true);
        } elseif ($user->role == 3) {
            return redirect()->route('invoices.index');
        } elseif ($user->role == 6 || $user->position == 'Marketing') {
            return redirect()->route('manage-product');
        } elseif ($user->role == 7 || $user->position == 'Sales') {
            return redirect()->route('manage-product');
        } elseif ($user->role == 8 || $user->position == 'Account') {
            return redirect()->route('manage-product');
        } else {
            return redirect()->route('manage-product');
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Get login origin before logout
        $loginOrigin = session('login_origin', 'employee_portal');
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirect based on login origin
        if ($loginOrigin === 'crmlogin') {
            // User logged in from CRM login, redirect back to CRM login
            return redirect()->route('crmlogin')->with('clear_splash', true);
        } else {
            // User logged in from employee portal, redirect to home page
            return redirect('/')->with('clear_splash', true);
        }
    }

    /**
     * Get the intended redirect URL based on user role
     *
     * @param  \App\Models\User  $user
     * @return string
     */
    private function getIntendedUrl($user)
    {
        // Redirect based on user role
        if ($user->role == 1 || $user->role == 5) {
            return route('attendance.dashboard');
        } elseif ($user->role == 4 || $user->position == 'Manager') {
            return route('employees.index');
        } elseif ($user->role == 2) {
            return route('project-updates.index');
        } elseif ($user->role == 3) {
            return route('invoices.index');
        } elseif ($user->role == 6 || $user->position == 'Marketing') {
            return route('manage-product');
        } elseif ($user->role == 7 || $user->position == 'Sales') {
            return route('manage-product');
        } elseif ($user->role == 8 || $user->position == 'Account') {
            return route('manage-product');
        } else {
            return route('manage-product');
        }
    }
}
