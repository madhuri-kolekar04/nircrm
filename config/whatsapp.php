<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp API Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your WhatsApp API settings for the
    | WhatsApp Business API. These settings are used by the
    | WhatsAppController to send messages.
    |
    */

    'api_url' => env('WHATSAPP_API_URL', 'https://graph.facebook.com/v15.0'),
    
    'access_token' => env('WHATSAPP_ACCESS_TOKEN'),
    
    'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
    
    'webhook_verify_token' => env('WHATSAPP_WEBHOOK_VERIFY_TOKEN'),
    
    'webhook_url' => env('WHATSAPP_WEBHOOK_URL'),
    
    /*
    |--------------------------------------------------------------------------
    | Message Templates
    |--------------------------------------------------------------------------
    |
    | Pre-defined message templates that can be used for quick messaging.
    | These templates support variable substitution.
    |
    */
    
    'templates' => [
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
        ],
        'welcome' => [
            'name' => 'Welcome Message',
            'message' => 'Welcome {name}! Thank you for your interest in our services. We will get back to you shortly.',
            'variables' => ['name']
        ],
        'thank_you' => [
            'name' => 'Thank You',
            'message' => 'Thank you {name} for choosing us! We appreciate your business and look forward to serving you.',
            'variables' => ['name']
        ]
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting for WhatsApp API calls to avoid hitting
    | the API limits. Values are in seconds.
    |
    */
    
    'rate_limit' => [
        'messages_per_second' => env('WHATSAPP_RATE_LIMIT', 1),
        'messages_per_minute' => env('WHATSAPP_RATE_LIMIT_MINUTE', 30),
        'messages_per_hour' => env('WHATSAPP_RATE_LIMIT_HOUR', 1000),
        'messages_per_day' => env('WHATSAPP_RATE_LIMIT_DAY', 10000)
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Webhook Events
    |--------------------------------------------------------------------------
    |
    | Configure which webhook events you want to handle.
    |
    */
    
    'webhook_events' => [
        'messages' => true,
        'message_reactions' => false,
        'message_edits' => false,
        'message_reads' => false,
        'message_delivery' => true
    ]
];
