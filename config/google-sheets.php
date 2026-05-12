<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Sheets Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Google Sheets API integration
    |
    */

    'spreadsheet_id' => env('GOOGLE_SHEETS_SPREADSHEET_ID'),
    'api_key' => env('GOOGLE_SHEETS_API_KEY'),
    'service_account_file' => env('GOOGLE_SHEETS_SERVICE_ACCOUNT_FILE', 'google-service-account.json'),

    /*
    |--------------------------------------------------------------------------
    | Auto Sync Configuration
    |--------------------------------------------------------------------------
    |
    | Configure automatic data synchronization
    |
    */
    'auto_sync' => [
        'enabled' => env('GOOGLE_SHEETS_AUTO_SYNC_ENABLED', false),
        'frequency' => env('GOOGLE_SHEETS_SYNC_FREQUENCY', 'hourly'), // hourly, daily, weekly
        'timezone' => env('GOOGLE_SHEETS_SYNC_TIMEZONE', 'UTC'),
        'time_of_day' => env('GOOGLE_SHEETS_SYNC_TIME', '02:00'), // For daily/weekly syncs
    ],

    /*
    |--------------------------------------------------------------------------
    | Data Mapping Configuration
    |--------------------------------------------------------------------------
    |
    | Map Google Sheets columns to database fields
    |
    */
    'field_mapping' => [
        'full_name' => 'name',
        'business_name' => 'company_name',
        'email' => 'email',
        'whatsapp' => 'phone',
        'website_url' => 'website',
        'business_type' => 'business_type',
        'primary_goal' => 'primary_goal',
        'budget_range' => 'budget',
        'score' => 'score',
        'tier' => 'tier',
        'submitted_at' => 'submitted_at',
        'audit_report' => 'audit_report',
        'audit_report_plain' => 'audit_report_plain',
    ],

    /*
    |--------------------------------------------------------------------------
    | Date Column Configuration
    |--------------------------------------------------------------------------
    |
    | Configure which column to use for incremental syncs
    |
    */
    'date_column' => env('GOOGLE_SHEETS_DATE_COLUMN', 'SUBMITTED AT'),

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Configure caching for API responses
    |
    */
    'cache' => [
        'enabled' => env('GOOGLE_SHEETS_CACHE_ENABLED', true),
        'ttl' => env('GOOGLE_SHEETS_CACHE_TTL', 3600), // 1 hour
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure API rate limiting
    |
    */
    'rate_limiting' => [
        'enabled' => env('GOOGLE_SHEETS_RATE_LIMIT_ENABLED', true),
        'requests_per_minute' => env('GOOGLE_SHEETS_RATE_LIMIT', 60),
        'retry_attempts' => env('GOOGLE_SHEETS_RETRY_ATTEMPTS', 3),
        'retry_delay' => env('GOOGLE_SHEETS_RETRY_DELAY', 1000), // milliseconds
    ],
];
