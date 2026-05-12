@echo off
REM Automated Sync Deployment Script for Windows
REM This script sets up the automated Google Sheets sync system

echo 🚀 Setting up Automated Google Sheets Sync System
echo ==================================================

REM Check if we're in the right directory
if not exist "artisan" (
    echo ❌ Error: Please run this script from your Laravel project root directory
    pause
    exit /b 1
)

echo ✅ Project directory verified

REM Test the automated sync system
echo.
echo 🧪 Testing automated sync system...

echo 1. Testing status command...
php artisan sync:automated status

echo.
echo 2. Testing notification check...
php artisan sync:automated check-notifications

echo.
echo 3. Testing auto sync...
php artisan sync:automated auto-sync

echo.
echo ✅ All tests completed successfully!

REM Setup instructions
echo.
echo ⏰ Laravel Scheduler Setup
echo -------------------------
echo Add this to your Windows Task Scheduler:
echo.
echo Program: php
echo Arguments: artisan schedule:run
echo Start in: %CD%
echo Trigger: Every minute
echo.
echo Or use Laravel's built-in scheduler:
echo php artisan schedule:work

echo.
echo 🌐 Alternative: External Cron Job URLs
echo --------------------------------------
echo Full Sync (every 2 minutes):
echo curl -s http://your-domain.com/automated-sync/auto-sync
echo.
echo Notification Check (every minute):
echo curl -s http://your-domain.com/automated-sync/check-notifications

echo.
echo 📊 Monitoring Commands
echo ----------------------
echo Check status: php artisan sync:automated status
echo View logs: type storage\logs\laravel.log | findstr "Automated"
echo Run scheduler: php artisan schedule:work

echo.
echo 🎉 Automated sync system is ready!
echo.
echo Next steps:
echo 1. Set up Windows Task Scheduler or use schedule:work
echo 2. Monitor with the status command
echo 3. Check logs for any issues
echo.
echo 📖 For detailed setup guide, see: AUTOMATED_SYNC_SETUP.md
echo.
pause
