#!/bin/bash

# Automated Sync Deployment Script
# This script sets up the automated Google Sheets sync system

echo "🚀 Setting up Automated Google Sheets Sync System"
echo "=================================================="

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Please run this script from your Laravel project root directory"
    exit 1
fi

echo "✅ Project directory verified"

# Test the automated sync system
echo ""
echo "🧪 Testing automated sync system..."

echo "1. Testing status command..."
php artisan sync:automated status

echo ""
echo "2. Testing notification check..."
php artisan sync:automated check-notifications

echo ""
echo "3. Testing auto sync..."
php artisan sync:automated auto-sync

echo ""
echo "✅ All tests completed successfully!"

# Setup cron job
echo ""
echo "⏰ Setting up Laravel scheduler cron job..."

# Get current directory path
CURRENT_DIR=$(pwd)
CRON_JOB="* * * * * cd $CURRENT_DIR && php artisan schedule:run >> /dev/null 2>&1"

echo "📝 Add this line to your crontab:"
echo "-----------------------------------"
echo "$CRON_JOB"
echo "-----------------------------------"
echo ""
echo "To edit crontab, run: crontab -e"
echo ""

# Alternative: External cron job URLs
echo "🌐 Alternative: External Cron Job URLs"
echo "--------------------------------------"
BASE_URL="http://your-domain.com"
echo "Full Sync (every 2 minutes):"
echo "curl -s $BASE_URL/automated-sync/auto-sync"
echo ""
echo "Notification Check (every minute):"
echo "curl -s $BASE_URL/automated-sync/check-notifications"
echo ""

# Monitoring commands
echo "📊 Monitoring Commands"
echo "----------------------"
echo "Check status: php artisan sync:automated status"
echo "View logs: tail -f storage/logs/laravel.log | grep 'Automated'"
echo "Run scheduler: php artisan schedule:work"
echo ""

echo "🎉 Automated sync system is ready!"
echo ""
echo "Next steps:"
echo "1. Add the cron job to your server"
echo "2. Monitor with the status command"
echo "3. Check logs for any issues"
echo ""
echo "📖 For detailed setup guide, see: AUTOMATED_SYNC_SETUP.md"
