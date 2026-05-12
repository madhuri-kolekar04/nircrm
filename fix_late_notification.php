<?php

// Fix for sendLateCheckInNotification method to handle employees without departments
$controllerFile = 'app/Http/Controllers/AttendanceController.php';
$content = file_get_contents($controllerFile);

// Find and replace the sendLateCheckInNotification method
$oldMethod = '    private function sendLateCheckInNotification($user, $checkInTime)
    {
        $shift = $user->shift;
        
        // Determine recipient based on hierarchy for LATE check-in
        $recipient = null;
        $recipientRole = \'\';
        
        switch ($user->role) {
            case 1: // Admin - Self notification (no one above)
                $recipient = $user;
                $recipientRole = \'Admin\';
                break;
            case 5: // General Manager - Notify Admin
                $admin = User::where(\'role\', 1)->where(\'is_active\', true)->first();
                if ($admin) {
                    $recipient = $admin;
                    $recipientRole = \'Admin\';
                }
                break;
            case 4: // Manager - Notify General Manager
                $gm = User::where(\'role\', 5)->where(\'is_active\', true)->first();
                if ($gm) {
                    $recipient = $gm;
                    $recipientRole = \'General Manager\';
                }
                break;
            case 2: // Employee - Notify Department Manager
                if ($user->department_id) {
                    $manager = User::where(\'department_id\', $user->department_id)
                                  ->where(\'role\', 4)
                                  ->where(\'is_active\', true)
                                  ->first();
                    if ($manager) {
                        $recipient = $manager;
                        $recipientRole = \'Manager\';
                    }
                }
                break;
        }';

$newMethod = '    private function sendLateCheckInNotification($user, $checkInTime)
    {
        $shift = $user->shift;
        
        // Determine recipient based on hierarchy for LATE check-in
        $recipient = null;
        $recipientRole = \'\';
        
        switch ($user->role) {
            case 1: // Admin - Self notification (no one above)
                $recipient = $user;
                $recipientRole = \'Admin\';
                break;
            case 5: // General Manager - Notify Admin
                $admin = User::where(\'role\', 1)->where(\'is_active\', true)->first();
                if ($admin) {
                    $recipient = $admin;
                    $recipientRole = \'Admin\';
                }
                break;
            case 4: // Manager - Notify General Manager
                $gm = User::where(\'role\', 5)->where(\'is_active\', true)->first();
                if ($gm) {
                    $recipient = $gm;
                    $recipientRole = \'General Manager\';
                }
                break;
            case 2: // Employee - Notify Department Manager
                if ($user->department_id) {
                    // Try to find department manager first
                    $manager = User::where(\'department_id\', $user->department_id)
                                  ->where(\'role\', 4)
                                  ->where(\'is_active\', true)
                                  ->first();
                    if ($manager) {
                        $recipient = $manager;
                        $recipientRole = \'Manager\';
                    }
                } else {
                    // Fallback: Find any active manager if no department assigned
                    $manager = User::where(\'role\', 4)
                                  ->where(\'is_active\', true)
                                  ->first();
                    if ($manager) {
                        $recipient = $manager;
                        $recipientRole = \'Manager (Fallback)\';
                    }
                }
                break;
        }';

// Replace the method
$content = str_replace($oldMethod, $newMethod, $content);

if (file_put_contents($controllerFile, $content)) {
    echo "✅ Successfully updated sendLateCheckInNotification method\n";
} else {
    echo "❌ Failed to update the file\n";
}
