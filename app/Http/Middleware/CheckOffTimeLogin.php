<?php

namespace App\Http\Middleware;

use App\Services\OffTimeLoginNotificationService;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOffTimeLogin
{
    protected $notificationService;

    public function __construct(OffTimeLoginNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Only check for authenticated users
        if (Auth::check()) {
            $user = Auth::user();
            
            // Skip check for certain roles
            if ($this->shouldSkipCheck($user)) {
                return $next($request);
            }

            // Check if this is a fresh login and user is currently off-time
            if ($this->isOffTimeLogin($request, $user)) {
                // Store session flag to show modal
                session(['show_off_time_modal' => true, 'off_time_details' => [
                    'user_id' => $user->id,
                    'login_time' => Carbon::now()->format('H:i'),
                    'shift_time' => $this->getShiftTime($user),
                    'user_role' => $user->role
                ]]);
            }
        }

        return $next($request);
    }

    private function shouldSkipCheck($user)
    {
        // Skip if user has no shift
        if (!$user->shift) {
            return true;
        }

        return false;
    }

    private function isOffTimeLogin($request, $user)
    {
        // Check if user just logged in (within last 30 seconds)
        $lastLogin = $user->last_login_at;
        $now = Carbon::now();
        
        if (!$lastLogin) {
            return false; // First time login
        }

        $timeSinceLogin = $now->diffInMinutes($lastLogin);
        
        // Consider it fresh login if within 30 seconds
        if ($timeSinceLogin > 0.5) {
            return false;
        }

        // Check if current time is off-time (not during shift hours)
        return $this->isOffTime($now, $user);
    }

    private function isOffTime($currentTime, $user)
    {
        if (!$user->shift) {
            return false;
        }

        $shiftStart = Carbon::today()->setTimeFromTimeString($user->shift->start_time->format('H:i:s'));
        $shiftEnd = Carbon::today()->setTimeFromTimeString($user->shift->end_time->format('H:i:s'));

        // Check if current time is outside shift hours
        return $currentTime->lessThan($shiftStart) || $currentTime->greaterThan($shiftEnd);
    }

    private function getShiftTime($user)
    {
        if ($user->shift) {
            return $user->shift->start_time;
        }
        return null;
    }
}
