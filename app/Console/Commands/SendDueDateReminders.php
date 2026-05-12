<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendDueDateReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'duedate:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automated due date reminders to leads and general managers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting due date reminder process...');
        
        $today = now()->startOfDay();
        $oneMonthFromNow = $today->copy()->addMonth();
        
        // Find leads with due dates exactly one month from today
        $leads = Lead::whereNotNull('due_date')
                    ->whereNotNull('email')
                    ->whereDate('due_date', '=', $oneMonthFromNow)
                    ->get();
        
        if ($leads->isEmpty()) {
            $this->info('No leads with due dates exactly one month from today.');
            return 0;
        }
        
        $this->info("Found {$leads->count()} leads with due dates one month from today.");
        
        $successCount = 0;
        $errorCount = 0;
        
        foreach ($leads as $lead) {
            try {
                // Send email to lead
                $this->sendOneMonthReminderToLead($lead);
                
                // Send email to general managers
                $this->sendOneMonthReminderToManagers($lead);
                
                $successCount++;
                $this->info("Sent reminder to lead: {$lead->name} ({$lead->email})");
                
            } catch (\Exception $e) {
                $errorCount++;
                $this->error("Failed to send reminder to lead {$lead->id}: " . $e->getMessage());
                Log::error("Failed to send one-month reminder to lead {$lead->id}: " . $e->getMessage());
            }
        }
        
        $this->info("Process completed. Success: {$successCount}, Errors: {$errorCount}");
        
        return $errorCount === 0 ? 0 : 1;
    }
    
    /**
     * Send one-month reminder email to lead.
     */
    private function sendOneMonthReminderToLead($lead)
    {
        $subject = "Important: Your Due Date is One Month Away - " . $lead->name;
        
        $emailContent = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; color: white; text-align: center; }
                    .content { padding: 30px; }
                    .reminder-box { background: #f8f9fa; border-left: 4px solid #007bff; padding: 20px; margin: 20px 0; border-radius: 5px; }
                    .due-date { background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
                    .footer { background: #f8f9fa; padding: 20px; border-top: 1px solid #dee2e6; font-size: 12px; text-align: center; }
                    .highlight { color: #007bff; font-weight: bold; }
                    .btn { display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 10px 0; }
                </style>
            </head>
            <body>
                <div class='header'>
                    <h1>Due Date Reminder</h1>
                    <p>Important Notice - One Month Advance</p>
                </div>
                <div class='content'>
                    <p>Dear <span class='highlight'>{$lead->name}</span>,</p>
                    
                    <p>We hope this message finds you well. This is a <strong>friendly reminder</strong> that your due date is approaching exactly one month from today.</p>
                    
                    <div class='due-date'>
                        <h2>Due Date Details</h2>
                        <p style='font-size: 24px; margin: 15px 0;'><strong>{$lead->due_date->format('l, F j, Y')}</strong></p>
                        <p style='font-size: 18px; color: #dc3545;'><strong>30 days remaining</strong></p>
                    </div>
                    
                    <div class='reminder-box'>
                        <h3>What You Should Do:</h3>
                        <ul>
                            <li>Review all requirements and ensure everything is in order</li>
                            <li>Contact us if you need any assistance or have questions</li>
                            <li>Make necessary preparations to meet the deadline</li>
                            <li>Keep track of important milestones leading up to the due date</li>
                        </ul>
                    </div>
                    
                    <p>This advance notice gives you <strong>ample time</strong> to prepare and ensure everything is completed on time. We're here to support you throughout this process.</p>
                    
                    <p>If you have any questions or need to discuss your requirements, please don't hesitate to reach out to our team.</p>
                    
                    <p>Best regards,<br>
                    <strong>CRM Team</strong><br>
                    Customer Support Department</p>
                </div>
                <div class='footer'>
                    <p>This is an automated reminder sent 30 days before your due date.</p>
                    <p>If you believe this message was sent in error, please contact our support team.</p>
                    <p>&copy; " . date('Y') . " CRM System. All rights reserved.</p>
                </div>
            </body>
            </html>
        ";
        
        Mail::html($emailContent, function ($message) use ($lead, $subject) {
            $message->to($lead->email)
                    ->subject($subject)
                    ->from(config('mail.from.address'), config('mail.from.name'));
        });
    }
    
    /**
     * Send one-month reminder email to general managers.
     */
    private function sendOneMonthReminderToManagers($lead)
    {
        $generalManagers = User::where('role', 5)->get(); // General Manager role ID
        
        if ($generalManagers->isEmpty()) {
            Log::info('No general managers found to send one-month due date notification');
            return;
        }
        
        $subject = "Manager Alert: One Month Due Date Reminder - " . $lead->name;
        
        $emailContent = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .header { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); padding: 30px; color: white; text-align: center; }
                    .content { padding: 30px; }
                    .lead-info { background: #e9ecef; padding: 20px; border-radius: 8px; margin: 20px 0; }
                    .due-date { background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
                    .footer { background: #f8f9fa; padding: 20px; border-top: 1px solid #dee2e6; font-size: 12px; text-align: center; }
                    .highlight { color: #dc3545; font-weight: bold; }
                    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin: 15px 0; }
                    .info-item { background: #f8f9fa; padding: 10px; border-radius: 5px; }
                </style>
            </head>
            <body>
                <div class='header'>
                    <h1>Manager Alert</h1>
                    <p>One Month Due Date Reminder</p>
                </div>
                <div class='content'>
                    <p>Dear <strong>General Manager</strong>,</p>
                    
                    <p>This is an <strong>automated notification</strong> regarding a lead whose due date is exactly one month from today. Please review the details below:</p>
                    
                    <div class='lead-info'>
                        <h3>Lead Information</h3>
                        <div class='info-grid'>
                            <div class='info-item'><strong>Name:</strong> {$lead->name}</div>
                            <div class='info-item'><strong>Email:</strong> {$lead->email}</div>
                            <div class='info-item'><strong>Phone:</strong> {$lead->phone}</div>
                            <div class='info-item'><strong>Company:</strong> {$lead->company_name}</div>
                            <div class='info-item'><strong>Status:</strong> {$lead->lead_status}</div>
                            <div class='info-item'><strong>Priority:</strong> {$lead->priority}</div>
                        </div>
                    </div>
                    
                    <div class='due-date'>
                        <h3>Due Date Information</h3>
                        <p style='font-size: 24px; margin: 15px 0;'><strong>{$lead->due_date->format('l, F j, Y')}</strong></p>
                        <p style='font-size: 18px; color: #dc3545;'><span class='highlight'>30 days remaining</span></p>
                        <p><strong>Automated reminder sent to lead</strong></p>
                    </div>
                    
                    <h3>Recommended Actions:</h3>
                    <ul>
                        <li>Review lead progress and current status</li>
                        <li>Ensure all requirements are being tracked</li>
                        <li>Assign additional resources if needed</li>
                        <li>Monitor progress closely as the due date approaches</li>
                        <li>Prepare contingency plans if potential delays are anticipated</li>
                    </ul>
                    
                    <p>This <strong>one-month advance notice</strong> allows for proactive management and ensures adequate time for any necessary interventions.</p>
                    
                    <p>Best regards,<br>
                    <strong>CRM System</strong><br>
                    Automated Notification Service</p>
                </div>
                <div class='footer'>
                    <p>This is an automated manager notification sent 30 days before lead due date.</p>
                    <p>&copy; " . date('Y') . " CRM System. All rights reserved.</p>
                </div>
            </body>
            </html>
        ";
        
        foreach ($generalManagers as $manager) {
            try {
                Mail::html($emailContent, function ($message) use ($manager, $subject) {
                    $message->to($manager->email)
                            ->subject($subject)
                            ->from(config('mail.from.address'), config('mail.from.name'));
                });
                
                Log::info("Sent one-month reminder to manager: {$manager->email} for lead: {$lead->name}");
                
            } catch (\Exception $e) {
                Log::error("Failed to send one-month reminder to manager {$manager->email}: " . $e->getMessage());
            }
        }
    }
}
