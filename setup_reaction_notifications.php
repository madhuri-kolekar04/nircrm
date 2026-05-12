<?php

/**
 * Reaction Notification System Setup Script
 * 
 * This script helps set up and verify the reaction notification system
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== REACTION NOTIFICATION SYSTEM SETUP ===\n\n";

// 1. Check database connection
echo "1. CHECKING DATABASE CONNECTION...\n";
try {
    $pdo = DB::connection()->getPdo();
    echo "   ✅ Database connection: SUCCESS\n";
} catch (Exception $e) {
    echo "   ❌ Database connection: FAILED - " . $e->getMessage() . "\n";
    exit(1);
}

// 2. Check lead_reactions table structure
echo "\n2. CHECKING lead_reactions TABLE STRUCTURE...\n";
try {
    $columns = DB::getSchemaBuilder()->getColumnListing('lead_reactions');
    $requiredFields = ['notification_sent', 'notification_sent_at'];
    
    foreach ($requiredFields as $field) {
        if (in_array($field, $columns)) {
            echo "   ✅ Field '{$field}': EXISTS\n";
        } else {
            echo "   ❌ Field '{$field}': MISSING\n";
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error checking table structure: " . $e->getMessage() . "\n";
}

// 3. Check reaction data
echo "\n3. CHECKING REACTION DATA...\n";
try {
    $totalReactions = DB::table('lead_reactions')->count();
    $scheduledNotifications = DB::table('lead_reactions')
        ->where('notification_sent', false)
        ->where('next_follow_up', '>=', date('Y-m-d'))
        ->count();
    $sentToday = DB::table('lead_reactions')
        ->where('notification_sent', true)
        ->whereDate('notification_sent_at', date('Y-m-d'))
        ->count();
    $overdueNotifications = DB::table('lead_reactions')
        ->where('notification_sent', false)
        ->where('next_follow_up', '<', date('Y-m-d'))
        ->count();
    
    echo "   📊 Total reactions: {$totalReactions}\n";
    echo "   ⏰ Scheduled notifications: {$scheduledNotifications}\n";
    echo "   📧 Sent today: {$sentToday}\n";
    echo "   ⚠️  Overdue notifications: {$overdueNotifications}\n";
} catch (Exception $e) {
    echo "   ❌ Error checking reaction data: " . $e->getMessage() . "\n";
}

// 4. Check email configuration
echo "\n4. CHECKING EMAIL CONFIGURATION...\n";
$mailConfig = [
    'MAIL_MAILER' => env('MAIL_MAILER', 'Not set'),
    'MAIL_HOST' => env('MAIL_HOST', 'Not set'),
    'MAIL_PORT' => env('MAIL_PORT', 'Not set'),
    'MAIL_USERNAME' => env('MAIL_USERNAME', 'Not set'),
    'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION', 'Not set'),
    'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS', 'Not set'),
];

foreach ($mailConfig as $key => $value) {
    if ($value !== 'Not set' && !empty($value)) {
        echo "   ✅ {$key}: " . (strpos($key, 'USERNAME') !== false || strpos($key, 'PASSWORD') !== false ? '***CONFIGURED***' : $value) . "\n";
    } else {
        echo "   ⚠️  {$key}: NOT SET\n";
    }
}

// 5. Test notification command
echo "\n5. TESTING NOTIFICATION COMMAND...\n";
try {
    Artisan::call('reactions:send-notifications');
    $output = Artisan::output();
    echo "   ✅ Command executed successfully\n";
    echo "   📝 Output: " . substr($output, 0, 200) . "...\n";
} catch (Exception $e) {
    echo "   ❌ Command failed: " . $e->getMessage() . "\n";
}

// 6. Check scheduler
echo "\n6. CHECKING SCHEDULER CONFIGURATION...\n";
try {
    $schedule = Artisan::call('schedule:list');
    $output = Artisan::output();
    
    if (strpos($output, 'reactions:send-notifications') !== false) {
        echo "   ✅ Reaction notifications scheduled\n";
    } else {
        echo "   ❌ Reaction notifications not found in schedule\n";
    }
    
    if (strpos($output, 'reactions:cleanup-notifications') !== false) {
        echo "   ✅ Cleanup command scheduled\n";
    } else {
        echo "   ❌ Cleanup command not found in schedule\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error checking scheduler: " . $e->getMessage() . "\n";
}

// 7. System recommendations
echo "\n7. SYSTEM RECOMMENDATIONS...\n";

// Check if cron job is set up
echo "   📋 To set up automated scheduling, add this to your crontab:\n";
echo "      * * * * * cd " . __DIR__ . " && php artisan schedule:run >> /dev/null 2>&1\n";

// Check email settings
if (env('MAIL_HOST') === null) {
    echo "   ⚠️  Configure email settings in .env file\n";
}

echo "\n=== SETUP COMPLETE ===\n";
echo "Reaction notification system is ready to use!\n";
echo "Access the management interface at: /reactions-system\n";
echo "View reaction statistics on the main dashboard\n\n";

echo "Quick test commands:\n";
echo "  php artisan reactions:send-notifications    # Send notifications\n";
echo "  php artisan reactions:cleanup-notifications  # Clean up old data\n";
echo "  php artisan schedule:run                    # Run scheduler\n\n";

echo "For detailed documentation, see: REACTION_NOTIFICATION_SYSTEM.md\n";
