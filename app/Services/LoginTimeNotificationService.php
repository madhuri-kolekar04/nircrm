<?php

namespace App\Services;

use App\Models\User;
use App\Mail\LoginTimeNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class LoginTimeNotificationService
{
    public function sendLoginTimeNotification($user, $loginType = 'late')
    {
        $loginTime = Carbon::now();
        $shiftTime = $this->getShiftTime($user);
        
        if (!$shiftTime) {
            return false;
        }

        $recipient = $this->getNotificationRecipient($user);
        
        if ($recipient) {
            try {
                Mail::to($recipient->email)->send(new LoginTimeNotification(
                    $user,
                    $loginTime,
                    $shiftTime,
                    $loginType,
                    $recipient->role
                ));
                
                \Log::info("Login time notification sent to {$recipient->name} for {$user->name}");
                return true;
            } catch (\Exception $e) {
                \Log::error("Failed to send login time notification: " . $e->getMessage());
                return false;
            }
        }
        
        return false;
    }

    private function getShiftTime($user)
    {
        if ($user->shift) {
            return $user->shift->start_time;
        }
        return null;
    }

    public function getNotificationRecipient($user)
    {
        $role = $user->role;
        
        switch ($role) {
            case 1: // Admin -> Admin self
                return $user;
                
            case 2: // Employee -> Manager
                if ($user->manager_id) {
                    return User::find($user->manager_id);
                }
                return $this->getGeneralManager();
                
            case 3: // Customer -> Manager
                if ($user->manager_id) {
                    return User::find($user->manager_id);
                }
                return $this->getGeneralManager();
                
            case 4: // Manager -> General Manager
                return $this->getGeneralManager();
                
            case 5: // General Manager -> Admin
                return $this->getAdmin();
                
            default:
                return null;
        }
    }

    private function getGeneralManager()
    {
        return User::where('role', 5)->where('is_active', true)->first();
    }

    private function getAdmin()
    {
        return User::where('role', 1)->where('is_active', true)->first();
    }
}
