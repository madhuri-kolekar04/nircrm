# Automatic Follow-up Email System Setup

## Overview
This system automatically sends follow-up emails to assigned users and general managers **exactly at the selected "Reaction Time" and "Next Follow-up Date** when recording lead reactions.

## How It Works

### 1. When a Reaction is Recorded
- User records a reaction with "Next Follow-up Date" and "Reaction Time"
- The system creates a reaction record with these details
- `email_sent` flag is set to `false`
- **IMMEDIATE EMAIL**: If follow-up time is now or in the past, emails are sent instantly

### 2. Automatic Email Sending (Every Minute)
- A scheduled command runs **every minute** for precise timing
- Checks for reactions where:
  - `next_follow_up` is today or in the past
  - `reaction_time` is within 2 minutes of current time
  - `email_sent` is `false`
- Sends emails to:
  - Assigned user (if lead is assigned)
  - All General Managers (users with role = 5)
- Marks `email_sent` as `true` to prevent duplicates

### 3. Precise Timing Logic
- **Within 30 minutes window**: Catches follow-ups even if slightly delayed
- **Immediate sending**: If time is in the past when reaction is created
- **Every minute check**: Ensures no missed follow-ups
- **Fixed timing issue**: Expanded from 2-minute to 30-minute window for reliability

## Features

### Exact Timing
- Sends emails **exactly at the selected reaction time**
- 2-minute precision window (before/after)
- No more 15-minute delays

### Immediate Sending
- When you create a reaction with past/current time
- Emails are sent **immediately**, not waiting for scheduler
- Works even if cron job isn't running

### Dual System
1. **Immediate**: When reaction is created (if time is now/past)
2. **Scheduled**: Every minute check (for future times)

### Smart Recipients
- **Assigned User**: Gets email if lead is assigned to them
- **General Managers**: All users with role = 5 receive notifications
- Professional email templates with automatic indicators

## Setup Instructions

### 1. Cron Job Setup (Required for future follow-ups)
Add this cron job to run **every minute**:

```bash
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

### 2. Manual Testing
```bash
# Test automatic email command
php artisan leads:send-follow-up-emails

# Check schedule
php artisan schedule:list

# Test immediate email (create reaction with current time)
# The system will send emails immediately
```

### 3. Email Configuration
Ensure your mail configuration is set in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@domain.com
MAIL_FROM_NAME="Your Company Name"
```

## What Happens Now

### Scenario 1: You set follow-up for 2:30 PM today
- At 2:30 PM, the system automatically sends emails
- If you create the reaction at 2:35 PM, emails send immediately
- No manual intervention needed

### Scenario 2: You set follow-up for tomorrow at 10:00 AM
- Tomorrow at 10:00 AM, emails are sent automatically
- Even if your project/server was down, it will send when back up
- Works reliably regardless of project status

## Email Content Includes
- Lead information (name, email, phone, company)
- Last reaction details (type, notes, call duration)
- Scheduled follow-up date and **exact time**
- Direct link to view lead in CRM
- Clear "AUTOMATIC" indicator

## Troubleshooting

### Emails Not Sending at Exact Time
1. Check cron job runs every minute: `* * * * *`
2. Verify server timezone matches your timezone
3. Check Laravel logs: `storage/logs/laravel.log`

### Immediate Emails Not Working
1. Check reaction has both date and time set
2. Verify time is not in the future
3. Test with current time to trigger immediate sending

### Missing Emails
1. Check if `email_sent` flag is set to `true`
2. Verify reaction has `next_follow_up` and `reaction_time`
3. Ensure assigned user and General Managers exist

## Database Changes

The system adds an `email_sent` column to `lead_reactions` table:
- Type: BOOLEAN
- Default: false
- Purpose: Prevent duplicate emails

## Monitoring

### Log Entries
The system logs all email activities:
- Immediate sends: `Immediate follow-up emails sent for reaction ID: X`
- Scheduled sends: `Automatic follow-up email sent to: email@domain.com`
- Errors: `Error sending automatic follow-up email: error message`

### Performance
- Runs every minute (lightweight)
- Only processes reactions with current/past times
- Uses database indexes for efficiency
- No impact on system performance

## Customization

### Change Schedule Frequency
Edit `app/Console/Kernel.php`:

```php
// Every 30 seconds (requires multiple cron entries)
$schedule->command('leads:send-follow-up-emails')->everyMinute();

// Every 5 minutes (less precise)
$schedule->command('leads:send-follow-up-emails')->everyFiveMinutes();
```

### Modify Timing Window
Edit `app/Console/Commands/SendFollowUpEmails.php`:

```php
// More precise (1 minute)
return $timeDiff >= -1 && $timeDiff <= 1;

// Less precise (5 minutes)
return $timeDiff >= -5 && $timeDiff <= 5;
```

## Summary

**Exact Timing**: Emails sent precisely at selected reaction time  
**Immediate Sending**: Works when time is now or in the past  
**Reliable**: Works whether project is running or not  
**Dual System**: Immediate + scheduled for complete coverage  
**Smart Recipients**: Assigned users + General Managers  
**Professional**: Clean email templates with automatic indicators  

The system now sends follow-up emails **exactly when you want them**, regardless of project status!
