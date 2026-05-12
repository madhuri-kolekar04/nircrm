<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WhatsAppController extends Controller
{
    /**
     * Display WhatsApp dashboard
     */
    public function index(Request $request)
    {
        $leads = Lead::whereNotNull('phone')
                     ->orderBy('created_at', 'desc')
                     ->paginate(20);
        
        // Get pre-filled data from URL parameters
        $prefillData = [];
        if ($request->has('lead_id') && $request->has('lead_name') && $request->has('lead_phone')) {
            $prefillData = [
                'lead_id' => $request->lead_id,
                'lead_name' => $request->lead_name,
                'lead_phone' => $request->lead_phone
            ];
        }
        
        return view('admin.whatsapp.whatsapp-crm', compact('leads', 'prefillData'));
    }

    /**
     * Send WhatsApp message to lead
     */
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lead_id' => 'required|exists:leads,id',
            'message' => 'required|string|max:1000',
            'message_type' => 'required|in:text,image,document'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $lead = Lead::findOrFail($request->lead_id);
        
        try {
            $response = $this->sendWhatsAppMessage($lead->phone, $request->message, $request->message_type);
            
            // Log the message
            Log::info('WhatsApp message sent', [
                'lead_id' => $lead->id,
                'phone' => $lead->phone,
                'message' => $request->message,
                'response' => $response
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'response' => $response
            ]);

        } catch (\Exception $e) {
            Log::error('WhatsApp message failed', [
                'lead_id' => $lead->id,
                'phone' => $lead->phone,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send message: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send bulk WhatsApp messages
     */
    public function sendBulkMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lead_ids' => 'required|array',
            'lead_ids.*' => 'exists:leads,id',
            'message' => 'required|string|max:1000',
            'message_type' => 'required|in:text'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $results = [];
        $successCount = 0;
        $failureCount = 0;

        foreach ($request->lead_ids as $leadId) {
            $lead = Lead::find($leadId);
            
            if ($lead && $lead->phone) {
                try {
                    $response = $this->sendWhatsAppMessage($lead->phone, $request->message, 'text');
                    $results[$leadId] = ['success' => true, 'response' => $response];
                    $successCount++;
                } catch (\Exception $e) {
                    $results[$leadId] = ['success' => false, 'error' => $e->getMessage()];
                    $failureCount++;
                }
            } else {
                $results[$leadId] = ['success' => false, 'error' => 'Lead not found or no phone number'];
                $failureCount++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Bulk messaging completed. Success: {$successCount}, Failed: {$failureCount}",
            'results' => $results,
            'summary' => [
                'total' => count($request->lead_ids),
                'success' => $successCount,
                'failed' => $failureCount
            ]
        ]);
    }

    /**
     * Get WhatsApp templates
     */
    public function getTemplates()
    {
        $templates = [
            'follow_up' => [
                'name' => 'Follow Up',
                'message' => 'Hello {name}, this is a follow-up regarding your inquiry. We would love to discuss how we can help you with {service}. Please let us know a convenient time to connect.',
                'variables' => ['name', 'service']
            ],
            'quotation_sent' => [
                'name' => 'Quotation Sent',
                'message' => 'Dear {name}, we have sent you the quotation for {service}. Please review it and let us know if you have any questions. Looking forward to your response.',
                'variables' => ['name', 'service']
            ],
            'appointment_reminder' => [
                'name' => 'Appointment Reminder',
                'message' => 'Hi {name}, this is a reminder about your appointment on {date} at {time}. We look forward to meeting you.',
                'variables' => ['name', 'date', 'time']
            ],
            'new_service' => [
                'name' => 'New Service Announcement',
                'message' => 'Hello {name}, we are excited to announce our new {service}! Contact us for special introductory offers.',
                'variables' => ['name', 'service']
            ]
        ];

        return response()->json([
            'success' => true,
            'templates' => $templates
        ]);
    }

    /**
     * Send message using WhatsApp API
     */
    private function sendWhatsAppMessage($phone, $message, $type = 'text')
    {
        // Remove any non-digit characters from phone number
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Add country code if missing (assuming India for this example)
        if (strlen($phone) === 10) {
            $phone = '91' . $phone;
        }

        $apiUrl = config('services.whatsapp.api_url', 'https://graph.facebook.com/v15.0');
        $accessToken = config('services.whatsapp.access_token');
        $phoneNumberId = config('services.whatsapp.phone_number_id');

        if (!$accessToken || !$phoneNumberId) {
            throw new \Exception('WhatsApp API credentials not configured');
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $phone,
            'type' => $type,
            $type => [
                'preview_url' => false,
                'body' => $message
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ])->post($apiUrl . '/' . $phoneNumberId . '/messages', $payload);

        if (!$response->successful()) {
            throw new \Exception('WhatsApp API error: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Get message history for a lead
     */
    public function getMessageHistory($leadId)
    {
        $lead = Lead::findOrFail($leadId);
        
        // This would typically fetch from a messages table
        // For now, return a placeholder response
        return response()->json([
            'success' => true,
            'lead' => $lead,
            'messages' => []
        ]);
    }

    /**
     * Check WhatsApp API status
     */
    public function checkStatus()
    {
        try {
            $accessToken = config('services.whatsapp.access_token');
            $phoneNumberId = config('services.whatsapp.phone_number_id');

            if (!$accessToken || !$phoneNumberId) {
                return response()->json([
                    'success' => false,
                    'status' => 'not_configured',
                    'message' => 'WhatsApp API credentials not configured'
                ]);
            }

            $apiUrl = config('services.whatsapp.api_url', 'https://graph.facebook.com/v15.0');
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken
            ])->get($apiUrl . '/' . $phoneNumberId);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'status' => 'connected',
                    'message' => 'WhatsApp API is connected',
                    'phone_number_info' => $response->json()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 'error',
                    'message' => 'Failed to connect to WhatsApp API',
                    'error' => $response->body()
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'WhatsApp API check failed: ' . $e->getMessage()
            ]);
        }
    }
}
