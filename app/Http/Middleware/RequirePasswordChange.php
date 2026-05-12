<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequirePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and is a customer (role 3)
        if (Auth::check() && Auth::user()->role == 3) {
            // Check if password change is required
            if (Auth::user()->password_change_required) {
                // Allow access to password change routes and logout
                $allowedRoutes = [
                    'password.change',
                    'password.check.required',
                    'logout',
                    'admin.logout'
                ];
                
                if (!$request->routeIs($allowedRoutes)) {
                    // Return JSON response for AJAX requests
                    if ($request->expectsJson()) {
                        return response()->json([
                            'password_change_required' => true,
                            'message' => 'You must change your password before continuing.'
                        ], 403);
                    }
                    
                    // For regular requests, continue and let the modal handle it
                    // The modal will be shown via the JavaScript check
                }
            }
        }
        
        return $next($request);
    }
}
