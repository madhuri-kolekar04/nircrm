<?php

namespace App\Services;

use App\Models\User;
use App\Mail\OffTimeLoginNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class OffTimeLoginNotificationService
{
    public function sendOffTimeLoginNotification($user, $loginTime, $shiftTime)
    {
        $recipients = $this->getNotificationRecipients($user);
        
        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient->email)->send(new OffTimeLoginNotification(
                    $user,
                    $loginTime,
                    $shiftTime,
                    $recipient->role
                ));
                
                \Log::info("Off-time login notification sent to {$recipient->name} ({$recipient->getRoleName()}) for {$user->name}");
            } catch (\Exception $e) {
                \Log::error("Failed to send off-time login notification to {$recipient->name}: " . $e->getMessage());
            }
        }
        
        return true;
    }

    public function getNotificationRecipients($user)
    {
        $userRole = $user->role;
        $recipients = [];
        
        switch ($userRole) {
            case 1: // Admin -> Admin self
                $recipients[] = $user;
                break;
                
            case 2: // Employee -> Manager, then General Manager, then Admin
                if ($user->manager_id) {
                    $manager = User::find($user->manager_id);
                    if ($manager) $recipients[] = $manager;
                }
                
                $gm = $this->getGeneralManager();
                if ($gm) $recipients[] = $gm;
                
                $admin = $this->getAdmin();
                if ($admin) $recipients[] = $admin;
                break;
                
            case 3: // Customer -> Manager, then General Manager, then Admin
                if ($user->manager_id) {
                    $manager = User::find($user->manager_id);
                    if ($manager) $recipients[] = $manager;
                }
                
                $gm = $this->getGeneralManager();
                if ($gm) $recipients[] = $gm;
                
                $admin = $this->getAdmin();
                if ($admin) $recipients[] = $admin;
                break;
                
            case 4: // Manager -> General Manager, then Admin
                $gm = $this->getGeneralManager();
                if ($gm) $recipients[] = $gm;
                
                $admin = $this->getAdmin();
                if ($admin) $recipients[] = $admin;
                break;
                
            case 5: // General Manager -> Admin
                $admin = $this->getAdmin();
                if ($admin) $recipients[] = $admin;
                break;
                
            default:
                break;
        }
        
        return array_unique($recipients);
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
