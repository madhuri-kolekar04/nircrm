# New Recording Notification Cron Job Setup

## Overview
This cron job checks for new entries in the `call_recordings` table every minute and sends mobile app notifications via Firebase Cloud Messaging (FCM).

## Files Created/Modified

### 1. New Command: `app/Console/Commands/CheckNewRecordings.php`
- Checks for new recordings since last run
- Sends Firebase notifications to mobile app
- Tracks last check time to avoid duplicate notifications

### 2. Modified: `app/Console/Kernel.php`
- Added new cron job: `recordings:check-new` running every minute

## Cron Job Configuration

### Laravel Scheduler Setup
The cron job is already configured in Laravel's scheduler. To enable it, add this to your system crontab:

```bash
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

### Manual Testing
Test the command manually:

```bash
php artisan recordings:check-new
```

## Firebase Configuration

### Required Environment Variables
Add these to your `.env` file:

```env
FIREBASE_SERVER_KEY=your_firebase_server_key_here
```

### Notification Data Sent
The cron job sends the following data to mobile apps:
- `title`: "New Call Recording"
- `message`: "New recording from {customer_name} ({customer_phone})"
- `target_url`: URL to recordings page
- `recording_id`: Database ID
- `customer_name`: Customer name
- `customer_phone`: Customer phone
- `file_url`: Recording file URL
- `sync_type`: Manual/AutoSync
- `created_at`: Recording timestamp

## How It Works

### 1. Tracking System
- Uses `storage/app/last_recording_check.txt` to track last check time
- Prevents duplicate notifications
- Handles first run gracefully (checks last 5 minutes)

### 2. Notification Process
- Queries `call_recordings` table for entries newer than last check
- For each new recording, sends Firebase notification to `/topics/all_users`
- Logs success/failure for debugging

### 3. Error Handling
- Gracefully handles missing Firebase configuration
- Logs errors for troubleshooting
- Continues processing other recordings if one fails

## Mobile App Integration

### Flutter/Dart Example
```dart
// Handle incoming notification
FirebaseMessaging.onMessage.listen((RemoteMessage message) {
  if (message.data.containsKey('recording_id')) {
    // This is a new recording notification
    final recordingId = message.data['recording_id'];
    final customerName = message.data['customer_name'];
    final customerPhone = message.data['customer_phone'];
    
    // Show notification or navigate to recording details
    showNotification(
      title: message.notification?.title ?? 'New Recording',
      body: message.notification?.body ?? 'New call recording available',
      data: message.data,
    );
  }
});
```

## Monitoring

### Log Files
Check Laravel logs for notification status:
- `storage/logs/laravel.log`

### Log Messages
- `INFO: New recording notification sent` - Success
- `ERROR: Failed to send new recording notification` - Failure
- `WARNING: Firebase notification not sent - Server key not configured` - Config issue

## Troubleshooting

### Common Issues
1. **No notifications received**
   - Check Firebase server key in `.env`
   - Verify mobile app is subscribed to `/topics/all_users`
   - Check logs for errors

2. **Duplicate notifications**
   - Check if `storage/app/last_recording_check.txt` is writable
   - Verify cron job isn't running multiple instances

3. **Command not found**
   - Run `php artisan optimize:clear` to clear caches
   - Verify command file exists in `app/Console/Commands/`

## Performance Considerations

### Database Impact
- Query uses indexed `created_at` column
- Runs every minute but minimal overhead
- Uses `withoutOverlapping()` to prevent conflicts

### Network Impact
- Only sends notifications when new recordings exist
- Firebase requests are lightweight HTTP calls
- Failed requests are logged but don't stop processing

## Security Notes

- Firebase server key should be kept secure
- Notifications contain customer data - ensure mobile app handles appropriately
- File URLs are public - consider access restrictions if needed
