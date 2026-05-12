<?php
/**
 * Page Monitoring Script for Lead Detection
 * Monitors /callingapp page for new entries and sends email notifications
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Services\LeadNotificationService;

class PageMonitor
{
    private $cacheKey = 'callingapp_lead_count';
    private $callingAppUrl = 'https://nircrmupdate.talktonitesh.com/callingapp';
    
    public function monitorAndNotify()
    {
        try {
            // Get current lead count from page
            $currentCount = $this->extractLeadCount();
            
            if ($currentCount === null) {
                Log::error('PageMonitor: Could not extract lead count from callingapp page');
                return false;
            }
            
            // Get previous count from cache
            $previousCount = Cache::get($this->cacheKey, 0);
            
            Log::info("PageMonitor: Current count: $currentCount, Previous count: $previousCount");
            
            // Check if new leads detected
            if ($currentCount > $previousCount) {
                $newLeadsCount = $currentCount - $previousCount;
                Log::info("PageMonitor: Detected $newLeadsCount new leads");
                
                // Get latest lead details
                $leadDetails = $this->getLatestLeadDetails();
                
                if ($leadDetails) {
                    // Send notifications to all employees
                    $this->sendNotifications($leadDetails, $newLeadsCount);
                    
                    // Update cache with new count
                    Cache::put($this->cacheKey, $currentCount, now()->addHours(24));
                    
                    return true;
                }
            }
            
            // Update cache even if no new leads (to prevent false positives)
            Cache::put($this->cacheKey, $currentCount, now()->addHours(24));
            
            return false;
            
        } catch (Exception $e) {
            Log::error("PageMonitor Error: " . $e->getMessage());
            return false;
        }
    }
    
    private function extractLeadCount()
    {
        try {
            // Fetch the callingapp page
            $response = Http::timeout(30)->get($this->callingAppUrl);
            
            if (!$response->successful()) {
                Log::error("PageMonitor: Failed to fetch callingapp page - " . $response->status());
                return null;
            }
            
            $content = $response->body();
            
            // Pattern 1: Look for "Total Leads: X" pattern
            if (preg_match('/Total\s+Leads:\s*(\d+)/i', $content, $matches)) {
                return (int)$matches[1];
            }
            
            // Pattern 2: Look for just numbers with "leads" or "entries" context
            if (preg_match('/(\d+)\s*(leads?|entries?)?/i', $content, $matches)) {
                return (int)$matches[1];
            }
            
            // Pattern 3: Look for table row count (fallback)
            if (preg_match_all('/<tr[^>]*>.*?<\/tr>/s', $content, $rows)) {
                // Subtract header rows (usually 1-2 rows)
                $dataRows = count($rows[0]) - 2;
                if ($dataRows > 0) {
                    return $dataRows;
                }
            }
            
            // Pattern 4: Look for any standalone number that could be lead count
            if (preg_match('/>\s*(\d{2,})\s*</', $content, $matches)) {
                return (int)$matches[1];
            }
            
            Log::warning("PageMonitor: Could not extract lead count from callingapp page");
            return null;
            
        } catch (Exception $e) {
            Log::error("PageMonitor extraction error: " . $e->getMessage());
            return null;
        }
    }
    
    private function getLatestLeadDetails()
    {
        try {
            // For now, create a generic lead entry
            // In a real implementation, you might parse the page for actual details
            return [
                'full_name' => 'New Lead Detected',
                'business_name' => 'Business Name',
                'email' => 'email@example.com',
                'whatsapp' => '1234567890',
                'website_url' => 'https://example.com',
                'submitted_at' => now()->format('M d, Y H:i A'),
                'source' => 'Google Sheets via CallingApp Monitor'
            ];
            
        } catch (Exception $e) {
            Log::error("PageMonitor: Could not get lead details - " . $e->getMessage());
            return null;
        }
    }
    
    private function sendNotifications($leadDetails, $newLeadsCount)
    {
        try {
            $notificationService = app(LeadNotificationService::class);
            
            // Add multiple leads info to notification
            $leadDetails['new_leads_count'] = $newLeadsCount;
            $leadDetails['detection_time'] = now()->format('M d, Y H:i A');
            $leadDetails['monitoring_source'] = 'CallingApp Page Monitor';
            
            $result = $notificationService->sendNewLeadNotification($leadDetails);
            
            if ($result['success']) {
                Log::info("PageMonitor: Successfully sent notifications to {$result['sent']} employees");
                Log::info("PageMonitor: New leads count: $newLeadsCount, Employees notified: {$result['sent']}");
            } else {
                Log::error("PageMonitor: Failed to send notifications - " . ($result['message'] ?? 'Unknown error'));
            }
            
            return $result;
            
        } catch (Exception $e) {
            Log::error("PageMonitor notification error: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

// Run the monitor
$monitor = new PageMonitor();
$result = $monitor->monitorAndNotify();

if ($result) {
    echo "SUCCESS: New leads detected and notifications sent\n";
} else {
    echo "INFO: No new leads detected or monitoring completed\n";
}
