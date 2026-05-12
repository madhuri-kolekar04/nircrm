# Automated Google Sheets Sync & Email Notification System

## Overview

This system automatically syncs Google Sheets data and sends email notifications to all employees when new entries are added, **without requiring anyone to manually open the `/callingapp` page**.

## How It Works

The system has three main components:

1. **AutomatedSyncController** - Handles background sync and notifications
2. **Console Command** - Allows running sync via command line
3. **Laravel Scheduler** - Runs the process automatically every few minutes

## Setup Instructions

### 1. Laravel Scheduler Setup (Recommended)

The scheduler is already configured in `app/Console/Kernel.php` to run:
- **Auto Sync**: Every 2 minutes
- **Notification Check**: Every minute

To enable the scheduler, add this cron job to your server:

```bash
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

### 2. Manual Testing

You can test the system manually:

```bash
# Check system status
php artisan sync:automated status

# Run full sync
php artisan sync:automated auto-sync

# Check for new entries and send notifications
php artisan sync:automated check-notifications
```

### 3. External Cron Job (Alternative)

If you prefer external cron jobs, use these URLs:

```bash
# Full sync and notifications
curl http://your-domain.com/automated-sync/auto-sync

# Check for new entries only (lighter weight)
curl http://your-domain.com/automated-sync/check-notifications

# Check system status
curl http://your-domain.com/automated-sync/status
```

## Features

### ✅ Automatic Sync
- Syncs Google Sheets data every 2 minutes
- Creates new leads and updates existing ones
- No manual intervention required

### ✅ Email Notifications
- Automatically sends emails to all employees when new entries are found
- Checks for new entries every minute
- Prevents duplicate notifications using smart tracking

### ✅ Rate Limiting
- Sync runs maximum once every 2 minutes
- Notification checks run maximum once per minute
- Prevents server overload

### ✅ Error Handling
- Comprehensive logging for debugging
- Graceful error handling
- Continues working even if individual notifications fail

## Monitoring

### Check System Status
```bash
php artisan sync:automated status
```

### View Logs
```bash
tail -f storage/logs/laravel.log | grep "Automated"
```

### API Endpoints
- `GET /automated-sync/status` - View system status
- `GET /automated-sync/auto-sync` - Trigger manual sync
- `GET /automated-sync/check-notifications` - Check for new entries

## Server Deployment

### For Production Servers

1. **Enable Laravel Scheduler** (Recommended):
```bash
# Add to your crontab
* * * * * cd /var/www/html/nircrm && php artisan schedule:run >> /dev/null 2>&1
```

2. **Or Use External Cron Jobs**:
```bash
# Add these to your hosting control panel cron jobs
*/2 * * * * curl -s http://your-domain.com/automated-sync/auto-sync
* * * * * curl -s http://your-domain.com/automated-sync/check-notifications
```

### For Local Development

```bash
# Run scheduler manually
php artisan schedule:work

# Or test individual commands
php artisan sync:automated auto-sync
```

## Troubleshooting

### If sync is not working:

1. Check logs: `tail -f storage/logs/laravel.log`
2. Test manually: `php artisan sync:automated status`
3. Verify Google Sheets connection
4. Check email configuration

### If emails are not sending:

1. Check mail configuration in `.env`
2. Test email system: `php artisan sync:automated check-notifications`
3. Verify employee email addresses

### Common Issues:

- **Rate Limiting**: System prevents running too frequently
- **Google Sheets API**: Ensure credentials are valid
- **Email Configuration**: Check SMTP settings in `.env`

## Benefits

✅ **No Manual Intervention** - Works completely in background  
✅ **Real-time Notifications** - Emails sent within 1 minute of new entries  
✅ **Server Friendly** - Rate limited and efficient  
✅ **Reliable** - Error handling and logging  
✅ **Scalable** - Works for any number of entries  
✅ **Production Ready** - Tested and monitored  

## Security

- All endpoints are rate limited
- No sensitive data exposed in responses
- Comprehensive error logging
- Safe for production use

---

**Your automated system is now ready!** The sync will run automatically and emails will be sent to all employees when new entries are added to Google Sheets, without anyone needing to open the calling app page.
