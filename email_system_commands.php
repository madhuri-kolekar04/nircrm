<?php

/**
 * Laravel Automatic Email System Commands
 * Complete guide for controlling automatic email sending
 */

echo "🚀 Laravel Automatic Email System Commands\n";
echo "==========================================\n\n";

echo "📧 1. CHECK SYSTEM STATUS:\n";
echo "   php artisan schedule:list\n";
echo "   Shows all scheduled tasks\n\n";

echo "⏰ 2. RUN SCHEDULER MANUALLY:\n";
echo "   php artisan schedule:run\n";
echo "   Triggers all scheduled tasks immediately\n\n";

echo "📨 3. SEND EMAILS NOW:\n";
echo "   php artisan reactions:send-notifications\n";
echo "   Sends all pending emails immediately\n\n";

echo "🔍 4. TEST EMAIL SYSTEM:\n";
echo "   php artisan reactions:send-notifications --verbose\n";
echo "   Shows detailed output of email sending process\n\n";

echo "📊 5. CHECK PENDING EMAILS:\n";
echo "   php artisan tinker\n";
echo "   Then run: \App\Models\LeadReaction::where('notification_sent', false)->count()\n\n";

echo "🗑️  6. CLEAN UP OLD NOTIFICATIONS:\n";
echo "   php artisan reactions:cleanup-notifications\n";
echo "   Removes old sent notifications (runs weekly)\n\n";

echo "📋 7. VIEW CRON JOB STATUS:\n";
echo "   crontab -l\n";
echo "   Shows current cron jobs on server\n\n";

echo "🔧 8. SYSTEM WORKFLOW:\n";
echo "   ┌─────────────────┐\n";
echo "   │ 1. User creates │\n";
echo "   │    reaction     │\n";
echo "   └─────────────────┘\n";
echo "           ↓\n";
echo "   ┌─────────────────┐\n";
echo "   │ 2. Stores in    │\n";
echo "   │    database     │\n";
echo "   └─────────────────┘\n";
echo "           ↓\n";
echo "   ┌─────────────────┐\n";
echo "   │ 3. Cron job     │\n";
echo "   │   runs every    │\n";
echo "   │    minute       │\n";
echo "   └─────────────────┘\n";
echo "           ↓\n";
echo "   ┌─────────────────┐\n";
echo "   │ 4. Laravel      │\n";
echo "   │   scheduler     │\n";
echo "   └─────────────────┘\n";
echo "           ↓\n";
echo "   ┌─────────────────┐\n";
echo "   │ 5. Email sent   │\n";
echo "   │  automatically  │\n";
echo "   └─────────────────┘\n\n";

echo "🎯 AUTOMATIC TIMING:\n";
echo "   ✅ Every minute: Cron job triggers\n";
echo "   ✅ Every minute: Laravel scheduler runs\n";
echo "   ✅ When time matches: Email sends\n";
echo "   ✅ No human intervention needed\n\n";

echo "⚡ PRODUCTION SETUP:\n";
echo "   1. Upload files to Hostinger\n";
echo "   2. Set cron job: * * * * * php artisan schedule:run\n";
echo "   3. Configure email in .env file\n";
echo "   4. System runs 24/7 automatically\n\n";

echo "🎉 YOUR SYSTEM IS READY!\n";
echo "   Emails will send automatically on scheduled dates/times\n";
?>
