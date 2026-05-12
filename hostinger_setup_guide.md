# 🚀 Hostinger Setup Guide - Automatic Email System

## 📋 Step-by-Step Instructions

### 1. Upload Files to Hostinger
```bash
# Upload these files to your Hostinger server:
- All Laravel application files
- .env file (with correct configuration)
- create_test_4_47.php (for testing)
- debug_pending_reactions.php (for debugging)
```

### 2. Set File Permissions
```bash
chmod 755 /home/u314035009/domains/talktonitesh.com/public_html/nircrm
chmod 755 /home/u314035009/domains/talktonitesh.com/public_html/nircrm/storage
chmod 755 /home/u314035009/domains/talktonitesh.com/public_html/nircrm/bootstrap/cache
```

### 3. Configure .env File
Update your Hostinger .env file:
```env
APP_NAME="NIRCRM"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://talktonitesh.com/nircrm
APP_TIMEZONE=Asia/Kolkata

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u314035009_nircrm
DB_USERNAME=u314035009_nircrm
DB_PASSWORD=mL*28$vqY8

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME="shubhamdixitcorpo@gmail.com"
MAIL_PASSWORD="dffg qfwg cywp bhmr"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="shubhamdixitcorpo@gmail.com"
MAIL_FROM_NAME="NIRCRM"
```

### 4. Install Dependencies
```bash
cd /home/u314035009/domains/talktonitesh.com/public_html/nircrm
composer install --no-dev --optimize-autoloader
```

### 5. Set Up Cron Job
In Hostinger Control Panel > Cron Jobs:

**Schedule**: Every Minute (* * * * *)
**Command**:
```bash
cd /home/u314035009/domains/talktonitesh.com/public_html/nircrm && php artisan schedule:run >> /dev/null 2>&1
```

### 6. Test the System
```bash
# Test manually via SSH
cd /home/u314035009/domains/talktonitesh.com/public_html/nircrm

# Check scheduler status
php artisan schedule:list

# Run scheduler manually
php artisan schedule:run

# Test email sending
php artisan reactions:send-notifications --verbose

# Create test reaction
php create_test_4_47.php

# Debug pending reactions
php debug_pending_reactions.php
```

### 7. Monitor the System
```bash
# Check logs
tail -f storage/logs/laravel.log

# Check cron job status
crontab -l

# Verify cron is working
grep "schedule:run" /var/log/cron 2>/dev/null || echo "Check Hostinger logs"
```

## 🎯 What This Achieves

✅ **24/7 Automatic Email Sending**
- Cron job runs every minute
- Laravel scheduler processes notifications
- Emails send automatically on scheduled dates/times
- No human intervention required

✅ **Works Independently**
- No login needed
- No website access needed
- No Hostinger panel access needed
- Runs completely automatically

✅ **Reliable Email Delivery**
- Gmail SMTP configuration
- Error handling and logging
- Overdue notification processing
- Automatic retry system

## 📧 Testing Your System

### Test 1: Create Immediate Reaction
```bash
# Create reaction for next minute
php create_test_4_47.php
```

### Test 2: Check Pending
```bash
# Check what's pending
php debug_pending_reactions.php
```

### Test 3: Force Send
```bash
# Send all pending emails
php artisan reactions:send-notifications --verbose
```

## 🚨 Troubleshooting

### If Emails Don't Send:
1. Check .env email configuration
2. Verify Gmail App Password
3. Check Laravel logs: `tail storage/logs/laravel.log`
4. Test email manually: `php test_email.php`

### If Cron Job Not Working:
1. Verify command path is correct
2. Check file permissions
3. Test manually: `php artisan schedule:run`
4. Check Hostinger cron job logs

### If Database Issues:
1. Verify DB credentials in .env
2. Test connection: `php artisan tinker`
3. Check migrations: `php artisan migrate:status`

## ✅ Final Verification

Your system should:
- ✅ Send emails automatically every minute
- ✅ Work without any human intervention
- ✅ Handle overdue notifications
- ✅ Log all activities for debugging
- ✅ Run 24/7 on Hostinger server

## 🎉 Success Criteria

When you see this output, your system is working:
```
Starting reaction notification system...
Found X reactions to process
✅ [OVERDUE] Notification sent to email@example.com
Total notifications sent: X
Errors encountered: 0
```

**Your automatic email system is now ready for production!** 🚀
