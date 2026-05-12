# Google Sheets API Setup Guide

This guide will help you set up automatic time-based data fetching from Google Sheets using the enhanced API integration.

## 🚀 Features

- **Automatic Time-Based Fetching**: Fetch data based on timestamps
- **OAuth 2.0 Authentication**: Secure service account authentication
- **Incremental Sync**: Only fetch new/updated records
- **Scheduled Jobs**: Automatic syncing at configurable intervals
- **Real-time Dashboard**: Monitor sync status and statistics
- **Export Functionality**: Export data to Excel/CSV
- **Error Handling**: Comprehensive error handling and retry logic

## 📋 Setup Instructions

### 1. Get Google Sheets API Credentials

#### Option A: API Key (for public spreadsheets)
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable Google Sheets API
4. Create API Key from Credentials section
5. Make your spreadsheet public (File > Share > Publish to web)

#### Option B: Service Account (recommended for private spreadsheets)
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable Google Sheets API
4. Create Service Account from Credentials section
5. Download the JSON key file
6. Share your Google Sheet with the service account email

### 2. Configure Environment Variables

Add these to your `.env` file:

```env
# Google Sheets Configuration
GOOGLE_SHEETS_SPREADSHEET_ID=your_spreadsheet_id_here
GOOGLE_SHEETS_API_KEY=your_api_key_here
GOOGLE_SHEETS_SERVICE_ACCOUNT_FILE=google-service-account.json

# Auto Sync Configuration
GOOGLE_SHEETS_AUTO_SYNC_ENABLED=true
GOOGLE_SHEETS_SYNC_FREQUENCY=hourly  # hourly, daily, weekly
GOOGLE_SHEETS_SYNC_TIMEZONE=UTC
GOOGLE_SHEETS_SYNC_TIME=02:00  # For daily/weekly syncs

# Date Column for Incremental Sync
GOOGLE_SHEETS_DATE_COLUMN=SUBMITTED AT

# Cache Configuration
GOOGLE_SHEETS_CACHE_ENABLED=true
GOOGLE_SHEETS_CACHE_TTL=3600

# Rate Limiting
GOOGLE_SHEETS_RATE_LIMIT_ENABLED=true
GOOGLE_SHEETS_RATE_LIMIT=60
GOOGLE_SHEETS_RETRY_ATTEMPTS=3
GOOGLE_SHEETS_RETRY_DELAY=1000
```

### 3. Upload Service Account File

If using Service Account authentication:
1. Upload the JSON key file to `storage/app/google-service-account.json`
2. Make sure the file is readable by the application

### 4. Configure Scheduler

Add the scheduler to your `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Google Sheets Auto Sync
    $frequency = config('google-sheets.auto_sync.frequency', 'hourly');
    $timezone = config('google-sheets.auto_sync.timezone', 'UTC');
    
    switch ($frequency) {
        case 'hourly':
            $schedule->command('google-sheets:sync')
                    ->hourly()
                    ->timezone($timezone)
                    ->withoutOverlapping();
            break;
            
        case 'daily':
            $timeOfDay = config('google-sheets.auto_sync.time_of_day', '02:00');
            $schedule->command('google-sheets:sync')
                    ->dailyAt($timeOfDay)
                    ->timezone($timezone)
                    ->withoutOverlapping();
            break;
            
        case 'weekly':
            $timeOfDay = config('google-sheets.auto_sync.time_of_day', '02:00');
            $schedule->command('google-sheets:sync')
                    ->weeklyOn(1, $timeOfDay) // Monday
                    ->timezone($timezone)
                    ->withoutOverlapping();
            break;
    }
}
```

### 5. Add Routes

Add these routes to your `routes/web.php`:

```php
// Google Sheets Management Routes
Route::get('/googlesheet', [GoogleSheetsApiController::class, 'index'])->name('googlesheet.index');
Route::prefix('api/googlesheets')->group(function () {
    Route::get('/test-connection', [GoogleSheetsApiController::class, 'testConnection']);
    Route::get('/metadata', [GoogleSheetsApiController::class, 'getMetadata']);
    Route::get('/preview', [GoogleSheetsApiController::class, 'preview']);
    Route::get('/incremental', [GoogleSheetsApiController::class, 'getIncrementalData']);
    Route::post('/sync', [GoogleSheetsApiController::class, 'sync']);
    Route::get('/statistics', [GoogleSheetsApiController::class, 'statistics']);
    Route::post('/config', [GoogleSheetsApiController::class, 'updateAutoSyncConfig']);
    Route::get('/export', [GoogleSheetsApiController::class, 'exportToExcel']);
    Route::get('/realtime', [GoogleSheetsApiController::class, 'getRealTimeData']);
});
```

## 🎯 Usage

### Manual Sync Commands

```bash
# Incremental sync (default)
php artisan google-sheets:sync

# Full sync
php artisan google-sheets:sync --type=full

# Force sync (ignore time limits)
php artisan google-sheets:sync --force

# Full force sync
php artisan google-sheets:sync --type=full --force
```

### API Endpoints

#### Test Connection
```http
GET /api/googlesheets/test-connection
```

#### Get Spreadsheet Metadata
```http
GET /api/googlesheets/metadata
```

#### Preview Data
```http
GET /api/googlesheets/preview?limit=10&sheet=Sheet1
```

#### Get Incremental Data
```http
GET /api/googlesheets/incremental
```

#### Manual Sync
```http
POST /api/googlesheets/sync
Content-Type: application/json

{
    "type": "incremental",  // or "full"
    "force": false
}
```

#### Get Statistics
```http
GET /api/googlesheets/statistics
```

#### Export to Excel
```http
GET /api/googlesheets/export?sync_type=incremental
```

## 📊 Date Column Configuration

The system uses a date column to determine which records are new or updated. By default, it looks for a column named "SUBMITTED AT".

### Supported Date Formats
- `Y-m-d H:i:s` (2024-03-15 14:30:00)
- `Y-m-d` (2024-03-15)
- `d/m/Y H:i` (15/03/2024 14:30)
- `d/m/Y` (15/03/2024)
- `m/d/Y H:i` (03/15/2024 14:30)
- `m/d/Y` (03/15/2024)
- `M d, Y H:i` (Mar 15, 2024 14:30)
- `M d, Y` (Mar 15, 2024)

### Custom Date Column
To use a different date column, update your `.env` file:
```env
GOOGLE_SHEETS_DATE_COLUMN=Your_Date_Column_Name
```

## 🔧 Field Mapping

The system automatically maps Google Sheets columns to database fields. The default mapping is:

| Google Sheets Column | Database Field |
|---------------------|----------------|
| FULL NAME | name |
| BUSINESS NAME | company_name |
| EMAIL | email |
| WHATSAPP | phone |
| WEBSITE URL | website |
| BUSINESS TYPE | business_type |
| PRIMARY GOAL | primary_goal |
| BUDGET RANGE | budget |
| SCORE | score |
| TIER | tier |
| SUBMITTED AT | submitted_at |
| AUDIT REPORT | audit_report |
| AUDIT REPORT PLAIN | audit_report_plain |

### Custom Field Mapping
To customize the mapping, edit `config/google-sheets.php`:

```php
'field_mapping' => [
    'your_sheet_column' => 'your_database_field',
    // ... other mappings
],
```

## 📈 Monitoring and Logging

### Log Files
Check `storage/logs/laravel.log` for detailed sync information:
- Sync start/end times
- Number of records processed
- Errors and warnings
- API response details

### Dashboard Statistics
The dashboard shows:
- Last sync time
- Total leads from sheets
- Recent leads (last 7 days)
- New records since last sync
- Connection status

## 🚨 Troubleshooting

### Common Issues

#### 1. Authentication Errors
- **API Key Error**: Make sure the spreadsheet is public
- **OAuth Error**: Check service account permissions and JSON file location

#### 2. Date Parsing Errors
- Verify date column name matches exactly
- Check date format compatibility
- Ensure dates are not empty

#### 3. Rate Limiting
- Reduce sync frequency if hitting limits
- Check Google Sheets API quotas
- Implement exponential backoff

#### 4. Memory Issues
- Use incremental sync for large datasets
- Increase PHP memory limit
- Process data in batches

### Debug Commands

```bash
# Test connection
php artisan google-sheets:sync --force

# Check configuration
php artisan config:cache
php artisan config:clear

# View logs
tail -f storage/logs/laravel.log | grep "Google Sheets"
```

## 🔄 Automatic Sync Behavior

### Sync Frequencies
- **Hourly**: Every hour at minute 0
- **Daily**: At specified time (default 02:00)
- **Weekly**: Every Monday at specified time

### Minimum Intervals
- **Hourly**: 30 minutes minimum between syncs
- **Daily**: 2 hours minimum between syncs
- **Weekly**: 8 hours minimum between syncs

### Sync Logic
1. Check last sync timestamp
2. Fetch incremental data based on date column
3. Compare with existing records
4. Create new records or update existing ones
5. Update last sync timestamp
6. Log results and statistics

## 📝 Best Practices

1. **Use Service Account** for better security and private spreadsheet access
2. **Set Appropriate Sync Frequency** based on your data update patterns
3. **Monitor Logs** regularly for errors and performance issues
4. **Test Connection** before enabling auto-sync
5. **Use Incremental Sync** for large datasets
6. **Backup Data** regularly before major sync operations
7. **Monitor API Quotas** to avoid rate limiting

## 🎉 You're Ready!

Your Google Sheets integration is now set up with automatic time-based data fetching. The system will:

- Automatically sync data at configured intervals
- Only fetch new/updated records based on timestamps
- Handle errors and retry failed operations
- Provide real-time statistics and monitoring
- Allow manual sync and export operations

Visit `/googlesheet` to access your dashboard and monitor the sync status!
