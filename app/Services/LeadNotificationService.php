<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class LeadNotificationService
{
    /**
     * Send new lead notification to all active employees
     */
    public function sendNewLeadNotification(array $leadData)
    {
        try {
            \Log::info('Starting new lead notification process', ['lead' => $leadData['full_name'] ?? 'Unknown']);
            
            // Get all active employees
            $employees = Employee::active()->get();
            
            if ($employees->isEmpty()) {
                \Log::warning('No active employees found to send notifications');
                return false;
            }
            
            $sentCount = 0;
            $failedCount = 0;
            
            foreach ($employees as $employee) {
                try {
                    // Send email to each employee
                    Mail::to($employee->email)->send(new \App\Mail\NewLeadNotification($leadData));
                    
                    \Log::info('Notification sent to employee', [
                        'employee' => $employee->name,
                        'email' => $employee->email
                    ]);
                    
                    $sentCount++;
                    
                } catch (\Exception $e) {
                    \Log::error('Failed to send notification to employee', [
                        'employee' => $employee->name,
                        'email' => $employee->email,
                        'error' => $e->getMessage()
                    ]);
                    
                    $failedCount++;
                }
            }
            
            \Log::info('Lead notification process completed', [
                'total_employees' => $employees->count(),
                'sent' => $sentCount,
                'failed' => $failedCount
            ]);
            
            return [
                'success' => true,
                'sent' => $sentCount,
                'failed' => $failedCount,
                'total' => $employees->count()
            ];
            
        } catch (\Exception $e) {
            \Log::error('Lead notification service error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'lead_data' => $leadData
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Check if email notifications are enabled
     */
    public function isEmailNotificationEnabled()
    {
        return config('mail.default') && 
               config('mail.mailers.' . config('mail.default')) &&
               config('mail.default') !== 'log';
    }
    
    /**
     * Get notification statistics
     */
    public function getNotificationStats()
    {
        return [
            'total_active_employees' => Employee::active()->count(),
            'email_enabled' => $this->isEmailNotificationEnabled(),
            'last_notification' => session('last_notification_sent', null)
        ];
    }
}
