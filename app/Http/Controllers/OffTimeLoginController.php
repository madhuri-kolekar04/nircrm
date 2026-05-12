<?php

namespace App\Http\Controllers;

use App\Services\OffTimeLoginNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class OffTimeLoginController extends Controller
{
    protected $notificationService;

    public function __construct(OffTimeLoginNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Send notification to seniors about off-time login
     */
    public function notifySeniors(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }

        try {
            $loginTime = Carbon::now();
            $shiftTime = $this->getShiftTime($user);
            
            if ($shiftTime) {
                $this->notificationService->sendOffTimeLoginNotification($user, $loginTime, $shiftTime);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Notifications sent to senior management',
                    'data' => [
                        'user_name' => $user->name,
                        'login_time' => $loginTime->format('H:i:s'),
                        'shift_time' => $shiftTime->format('H:i:s'),
                        'notified_recipients' => $this->getRecipientCount($user)
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No shift assigned to user'
                ]);
            }
            
        } catch (\Exception $e) {
            \Log::error('Error sending off-time login notification: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send notifications: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear the off-time modal session
     */
    public function clearModal(Request $request)
    {
        Session::forget('show_off_time_modal');
        Session::forget('off_time_details');
        
        return response()->json(['success' => true]);
    }

    private function getShiftTime($user)
    {
        if ($user->shift) {
            return $user->shift->start_time;
        }
        return null;
    }

    private function getRecipientCount($user)
    {
        $userRole = $user->role;
        $count = 0;
        
        switch ($userRole) {
            case 1: // Admin -> 1 (self)
                $count = 1;
                break;
            case 2: // Employee -> Manager + GM + Admin
                $count = 3;
                break;
            case 3: // Customer -> Manager + GM + Admin
                $count = 3;
                break;
            case 4: // Manager -> GM + Admin
                $count = 2;
                break;
            case 5: // General Manager -> Admin
                $count = 1;
                break;
        }
        
        return $count;
    }
}
