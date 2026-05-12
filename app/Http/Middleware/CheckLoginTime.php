<?php

namespace App\Http\Middleware;

use App\Services\LoginTimeNotificationService;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLoginTime
{
    protected $notificationService;

    public function __construct(LoginTimeNotificationService $notificationService)
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
        // Only check login time for authenticated users
        if (Auth::check()) {
            $user = Auth::user();
            
            // Skip check for certain roles or if user has no shift
            if ($this->shouldSkipCheck($user)) {
                return $next($request);
            }

            // Check if this is a fresh login (not just page navigation)
            if ($this->isFreshLogin($request, $user)) {
                $this->checkLoginTime($user);
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

        // Skip for admin (self-notification)
        if ($user->role == 1) {
            return true;
        }

        return false;
    }

    private function isFreshLogin($request, $user)
    {
        // Check if user just logged in (within last 30 seconds)
        $lastLogin = $user->last_login_at;
        $now = Carbon::now();
        
        if (!$lastLogin) {
            return true; // First time login
        }

        $timeSinceLogin = $now->diffInMinutes($lastLogin);
        
        // Consider it fresh login if within 30 seconds of last login
        return $timeSinceLogin <= 0.5;
    }

    private function checkLoginTime($user)
    {
        $now = Carbon::now();
        $shiftStartTime = $this->getShiftStartTime($user);
        
        if (!$shiftStartTime) {
            return;
        }

        // Create datetime objects for comparison
        $shiftStart = Carbon::today()->setTimeFromTimeString($shiftStartTime->format('H:i:s'));
        $loginTime = $now;

        // Check if late (more than 5 minutes after shift start)
        $lateThreshold = $shiftStart->copy()->addMinutes(5);
        if ($loginTime->greaterThan($lateThreshold)) {
            $this->notificationService->sendLoginTimeNotification($user, 'late');
        }
        
        // Check if early (more than 30 minutes before shift start)
        $earlyThreshold = $shiftStart->copy()->subMinutes(30);
        if ($loginTime->lessThan($earlyThreshold)) {
            $this->notificationService->sendLoginTimeNotification($user, 'early');
        }
    }

    private function getShiftStartTime($user)
    {
        if ($user->shift) {
            return $user->shift->start_time;
        }
        return null;
    }
}
