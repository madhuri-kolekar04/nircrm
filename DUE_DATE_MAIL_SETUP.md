# Due Date Mail System Setup Guide

## Overview
The Due Date Management system includes a comprehensive email notification system that sends:
1. **Automated reminders** 1 month before due date (daily at 9:00 AM)
2. **Manual reminders** from the Due Date management page
3. **Bulk reminders** for multiple leads

## SMTP Configuration

### Step 1: Configure .env file
Add or update the following mail settings in your `.env` file:

```env
# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host.com
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@domain.com
MAIL_FROM_NAME="Your Company Name"
```

### Step 2: Common SMTP Providers

#### Gmail/Google Workspace
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Your Company"
```

#### Outlook/Microsoft 365
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME=your-email@outlook.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@outlook.com
MAIL_FROM_NAME="Your Company"
```

#### SendGrid
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=YOUR_SENDGRID_API_KEY
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@domain.com
MAIL_FROM_NAME="Your Company"
```

### Step 3: Important Notes

1. **App Passwords**: For Gmail/Outlook, use an "App Password" instead of your regular password
2. **2FA Required**: Enable 2-factor authentication on your email account
3. **Firewall**: Ensure SMTP ports (587, 465, 25) are not blocked
4. **Rate Limits**: Be aware of your provider's sending limits

## Testing the Mail System

### Method 1: Run the command manually
```bash
php artisan duedate:send-reminders
```

### Method 2: Test from Due Date page
1. Go to `/leadsmanagement` page
2. Click the calendar icon (Due Date Management)
3. Click the envelope icon next to any lead
4. Check if email is received

### Method 3: Create a test lead
1. Create a lead with a due date exactly 1 month from today
2. The automated system will send an email at 9:00 AM
3. Or run the command manually to test immediately

## Automated Schedule

The system is configured to run automatically:
- **Frequency**: Daily at 9:00 AM
- **Command**: `php artisan duedate:send-reminders`
- **Target**: Leads with due dates exactly 30 days from today

### Cron Job Setup (Linux/Mac)
Add this to your crontab:
```bash
0 9 * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

### Windows Task Scheduler
1. Open Task Scheduler
2. Create new task
3. Trigger: Daily at 9:00 AM
4. Action: Run `php artisan schedule:run`
5. Set working directory to your project path

## Email Templates

The system includes professional email templates:

### Lead Email Template
- Personalized greeting
- Due date details
- Urgency status
- Action items
- Professional branding

### Manager Email Template  
- Lead information summary
- Due date details
- Recommended actions
- Management alerts

## Troubleshooting

### Common Issues

1. **Email not sending**
   - Check SMTP credentials
   - Verify firewall settings
   - Check email provider's sending limits

2. **Command not found**
   - Run `php artisan optimize:clear`
   - Ensure command is registered in Kernel.php

3. **No emails received**
   - Check spam/junk folders
   - Verify FROM address is correct
   - Check email logs

### Debug Mode
Add this to your `.env` for debugging:
```env
MAIL_LOG_CHANNEL=stack
```

Check logs at:
```bash
php artisan log:clear
tail -f storage/logs/laravel.log
```

## Features Summary

### Due Date Management Page (`/duedate`)
- **Statistics Dashboard**: Shows overdue, today, this week, this month counts
- **Advanced Filtering**: By urgency, date range, search
- **Bulk Actions**: Select multiple leads for bulk reminders
- **Individual Actions**: Send reminders to specific leads
- **Responsive Design**: Works on all devices

### Email Notifications
- **Automated**: 30-day advance notices
- **Manual**: On-demand reminders
- **Bulk**: Multiple leads at once
- **Professional**: HTML templates with branding

### Integration
- **Leads Management**: Due date column in main table
- **Forms**: Due date field in create/edit forms
- **Database**: Properly indexed and optimized
- **Security**: CSRF protection and validation

## Support

For issues or questions:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify SMTP configuration
3. Test with different email providers
4. Check firewall and network settings

The system is now ready for production use with proper SMTP configuration!
