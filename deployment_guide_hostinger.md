# Hostinger Deployment Guide for 24/7 Email Notifications

## 🚀 Setup Instructions

### 1. Upload Files to Hostinger
- Upload all Laravel files to `/public_html/` directory
- Ensure `.env` file is properly configured

### 2. Set File Permissions
```bash
chmod 755 /home/username/public_html
chmod 755 /home/username/public_html/storage
chmod 755 /home/username/public_html/bootstrap/cache
```

### 3. Configure Environment
Edit `.env` file on Hostinger:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=your-email@yourdomain.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@yourdomain.com
MAIL_FROM_NAME="Your Company Name"
```

### 4. Install Dependencies via SSH
```bash
cd /home/username/public_html
composer install --no-dev --optimize-autoloader
```

### 5. Set Up Cron Job
In Hostinger Control Panel > Cron Jobs:

**Command**: 
```
cd /home/username/public_html && php artisan schedule:run >> /dev/null 2>&1
```

**Schedule**: Every minute (* * * * *)

### 6. Test the System
```bash
# Test manually via SSH
cd /home/username/public_html
php artisan reactions:send-notifications
```

## 📧 Email Configuration Options

### Option 1: Hostinger SMTP (Recommended)
- Use Hostinger's built-in email service
- Reliable delivery rates
- Easy setup

### Option 2: External SMTP (Gmail, SendGrid, etc.)
```env
# Gmail Example
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### Option 3: SendGrid API
```env
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=your-sendgrid-api-key
```

## 🔍 Monitoring & Logging

### Enable Logging
Add to `.env`:
```env
LOG_CHANNEL=stack
LOG_LEVEL=info
```

### Check Logs
```bash
# View recent logs
tail -f /home/username/public_html/storage/logs/laravel.log
```

## ⚡ Performance Optimization

### 1. Enable Laravel Cache
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Optimize Autoloader
```bash
composer dump-autoload --optimize
```

### 3. Use Laravel Queue (Optional)
For high-volume notifications:
```bash
php artisan queue:work --daemon
```

## 🛡️ Security Considerations

1. **Secure .env file**: Ensure it's not publicly accessible
2. **Database credentials**: Use strong passwords
3. **Email credentials**: Use app-specific passwords
4. **SSL certificate**: Ensure HTTPS is enabled

## 📊 Monitoring Dashboard

Create a simple monitoring endpoint:
```php
// routes/web.php
Route::get('/notifications-status', function() {
    $scheduled = \App\Models\LeadReaction::where('notification_sent', false)
        ->where('next_follow_up', '>=', now()->format('Y-m-d'))
        ->count();
    
    $sentToday = \App\Models\LeadReaction::where('notification_sent', true)
        ->whereDate('notification_sent_at', today())
        ->count();
    
    return [
        'scheduled' => $scheduled,
        'sent_today' => $sentToday,
        'last_run' => now()->format('Y-m-d H:i:s')
    ];
});
```

## 🚨 Troubleshooting

### Common Issues:
1. **Cron job not running**: Check command path and permissions
2. **Email not sending**: Verify SMTP credentials
3. **Database connection**: Check DB credentials in .env
4. **File permissions**: Ensure storage directory is writable

### Debug Commands:
```bash
# Test scheduler
php artisan schedule:run --verbose

# Test email
php artisan reactions:send-notifications

# Check queue status
php artisan queue:failed
```

## 📞 Support

If issues persist:
1. Check Hostinger error logs
2. Verify Laravel logs
3. Test SMTP connection manually
4. Contact Hostinger support for server issues

---

## ✅ Deployment Checklist

- [ ] Upload all files to Hostinger
- [ ] Configure .env file
- [ ] Set proper file permissions
- [ ] Install composer dependencies
- [ ] Configure email settings
- [ ] Set up cron job
- [ ] Test notification system
- [ ] Enable SSL certificate
- [ ] Monitor initial performance

Your 24/7 email notification system will now run automatically on Hostinger!
