# Google Sheets Integration Setup Guide

This guide will help you set up automatic synchronization between your Google Sheets and the NIRCRM Leads Management system.

## Overview

The Google Sheets integration will:
- Automatically fetch data from your Google Sheets document
- Map columns to database fields
- Create/update leads in the system
- Show Google Sheets data with proper formatting in the Leads Management table
- Sync automatically every hour or on-demand

## Field Mapping

The system maps Google Sheets columns to database fields as follows:

| Google Sheets Column | Database Field | Notes |
|---------------------|---------------|-------|
| Name | name | Required field |
| Company Name | company_name | Optional |
| Email | email | Optional, validated |
| Phone | phone | Optional, formatted |
| Website | website | Optional, URL validated |
| Industry | industry | Optional |
| Business Type | business_type | Optional |
| Primary Goal | primary_goal | Optional |
| Description | description | Combined with other description fields |
| Budget | budget | Optional, numeric |
| Lead Status | lead_status | Normalized (hot/warm/cold/qualified/lost) |
| Tier | tier | Optional |
| Follow Up Date | follow_up_date | Date field |
| Submitted At | submitted_at | Date field |
| Score | score | Optional |
| Notes | notes | Combined with other notes fields |
| Audit Report | audit_report | Optional |
| Audit Report Plain | audit_report_plain | Optional |

## Setup Instructions

### 1. Google Cloud Project Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google Sheets API:
   - Go to "APIs & Services" > "Library"
   - Search for "Google Sheets API"
   - Click "Enable"

### 2. Create API Key

1. Go to "APIs & Services" > "Credentials"
2. Click "Create Credentials" > "API key"
3. Copy the API key
4. **Important**: Restrict the API key for security:
   - Click on the API key name
   - Under "Application restrictions", select "HTTP referrers"
   - Add your website domain (e.g., `127.0.0.1/*`)
   - Under "API restrictions", select "Restrict key"
   - Select "Google Sheets API"

### 3. Google Sheets Sharing

1. Open your Google Sheets document
2. Click "Share" button
3. Make the spreadsheet "Public on the web" or share with "Anyone with the link"
4. Set access to "Viewer" (at minimum)

### 4. Application Configuration

Add the following to your `.env` file:

```env
GOOGLE_SHEETS_SPREADSHEET_ID=your_spreadsheet_id_here
GOOGLE_SHEETS_API_KEY=your_api_key_here
```

To get your spreadsheet ID:
- Open your Google Sheets document
- Look at the URL: `https://docs.google.com/spreadsheets/d/SPREADSHEET_ID/edit`
- Copy the `SPREADSHEET_ID` part

### 5. Database Migration

The new fields should already be in your `leads` table fillable array. Run the migration:

```bash
php artisan migrate --path=database/migrations/2026_04_02_130000_add_google_sheets_fields_to_leads_table.php
```

### 6. Test the Integration

1. Test the connection:
   ```bash
   php artisan google-sheets:sync --force
   ```

2. Check the Leads Management page at `http://127.0.0.1:8000/leadsmanagement`

3. Click the "Sync Google Sheets" button to test manual sync

## Usage

### Manual Sync

1. Go to the Leads Management page
2. Click "Sync Google Sheets" button
3. Wait for the sync to complete
4. The page will reload with new data

### Automatic Sync

The system automatically syncs every hour via a scheduled job. You can also trigger it manually:

```bash
php artisan google-sheets:sync
```

### Force Sync

To bypass the 30-minute cooldown:

```bash
php artisan google-sheets:sync --force
```

## Data Processing

### Duplicate Prevention

The system prevents duplicate leads by checking:
- Email address
- Phone number  
- Name combination

### Data Normalization

- **Lead Status**: Automatically normalized to valid values (hot/warm/cold/qualified/lost)
- **Priority**: Normalized to (high/medium/low)
- **Email**: Validated and cleaned
- **Phone**: Formatted to remove special characters
- **Website**: Ensured to have proper URL format
- **Budget**: Converted to numeric format
- **Dates**: Standardized to Y-m-d format

### Description and Notes Fields

For better user experience, description and notes fields show the column names with data:

```
Description:
Primary Goal: Increase online sales
Business Type: E-commerce
Score: 8/10

Notes:
Audit Report: Qualified lead
Submitted At: 2024-01-15
```

## Troubleshooting

### Common Issues

1. **"Failed to connect to Google Sheets"**
   - Check that the service account email has access to the spreadsheet
   - Verify the spreadsheet ID is correct
   - Ensure the service account JSON file path is correct

2. **"No data found in Google Sheets"**
   - Check that the spreadsheet has data in the first sheet
   - Ensure headers are in the first row
   - Verify column names match the mapping

3. **"Permission denied"**
   - Ensure the service account has proper permissions
   - Check that the JSON file is readable by the application

### Debug Commands

Test connection:
```bash
curl -X POST http://127.0.0.1:8000/google-sheets/test-connection
```

View sync statistics:
```bash
curl -X GET http://127.0.0.1:8000/google-sheets/statistics
```

Check logs:
```bash
tail -f storage/logs/laravel.log | grep "Google Sheets"
```

## Security Considerations

1. **Service Account Key**: Keep the JSON file secure and never commit it to version control
2. **Spreadsheet Access**: Only give minimum required permissions to the service account
3. **Data Validation**: The system validates and sanitizes all imported data

## Advanced Configuration

### Custom Field Mapping

To modify field mapping, edit the `getFieldMapping()` method in:
`app/Services/GoogleSheetsService.php`

### Sync Frequency

To change the automatic sync frequency, edit:
`app/Console/Kernel.php`

Available options:
- `everyMinute()`
- `everyFiveMinutes()`
- `everyTenMinutes()`
- `everyThirtyMinutes()`
- `hourly()` (default)
- `daily()`

### Custom Processing

To add custom data processing, modify the `mapToLeadFields()` method in the GoogleSheetsService.

## Support

If you encounter issues:

1. Check the Laravel logs: `storage/logs/laravel.log`
2. Verify all configuration steps are completed
3. Test with a simple spreadsheet first
4. Check that all required columns are present

The integration is designed to be robust and handle errors gracefully, logging any issues for debugging.
