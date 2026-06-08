<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔍 Debug Pending Reactions\n";
echo "========================\n\n";

// Check current time
$currentTime = now('Asia/Kolkata');
echo "📊 Current Indian Time: " . $currentTime->format('Y-m-d H:i:s') . "\n";
echo "📅 Current Date: " . $currentTime->format('Y-m-d') . "\n";
echo "⏰ Current Time: " . $currentTime->format('H:i') . "\n\n";

// Check all reactions
$allReactions = \App\Models\LeadReaction::with('lead')->get();
echo "📈 Total Reactions: " . $allReactions->count() . "\n\n";

// Check pending reactions
$pendingReactions = \App\Models\LeadReaction::where('notification_sent', false)->with('lead')->get();
echo "⏳ Pending Reactions: " . $pendingReactions->count() . "\n\n";

if ($pendingReactions->count() > 0) {
    foreach ($pendingReactions as $reaction) {
        echo "🆔 ID: " . $reaction->id . "\n";
        echo "👤 Lead: " . ($reaction->lead ? $reaction->lead->name : 'N/A') . "\n";
        echo "📧 Email: " . ($reaction->lead ? $reaction->lead->email : 'N/A') . "\n";
        echo "📅 Follow-up Date: " . $reaction->next_follow_up . "\n";
        echo "⏰ Follow-up Time: " . $reaction->reaction_time . "\n";
        echo "📝 Notes: " . $reaction->notes . "\n";
        echo "🔔 Notification Sent: " . ($reaction->notification_sent ? 'Yes' : 'No') . "\n";
        echo "---\n";
    }
} else {
    echo "❌ No pending reactions found!\n\n";
    
    // Check recently created reactions
    echo "🔍 Checking recently created reactions...\n";
    $recentReactions = \App\Models\LeadReaction::where('created_at', '>=', now()->subMinutes(30))->get();
    echo "📈 Recent Reactions (last 30 min): " . $recentReactions->count() . "\n";
    
    foreach ($recentReactions as $reaction) {
        echo "🆔 ID: " . $reaction->id . " - Created: " . $reaction->created_at->format('H:i:s') . "\n";
        echo "📅 Scheduled: " . $reaction->next_follow_up . " " . $reaction->reaction_time . "\n";
        echo "🔔 Status: " . ($reaction->notification_sent ? 'Sent' : 'Pending') . "\n";
        echo "---\n";
    }
}

// Create a test reaction for next minute
echo "\n🧪 Creating test reaction for next minute...\n";
$nextMinute = $currentTime->copy()->addMinute();
$testLead = \App\Models\Lead::where('email', 'contact@niranjanenterprises.com')->first();
$user = \App\Models\User::first();

if ($testLead && $user) {
    $testReaction = \App\Models\LeadReaction::create([
        'lead_id' => $testLead->id,
        'user_id' => $user->id,
        'reaction_type' => 'follow_up',
        'notes' => 'Test reaction for automatic email - Next minute test',
        'reaction_date' => $nextMinute->format('Y-m-d'),
        'reaction_time' => $nextMinute->format('H:i'),
        'reaction_timestamp' => now(),
        'next_follow_up' => $nextMinute->format('Y-m-d'),
        'follow_up_time' => $nextMinute->format('H:i'),
        'follow_up_priority' => 'high',
        'notification_sent' => false,
        'status' => 'active'
    ]);
    
    echo "✅ Test reaction created!\n";
    echo "🆔 ID: " . $testReaction->id . "\n";
    echo "⏰ Scheduled for: " . $nextMinute->format('Y-m-d H:i') . "\n";
    echo "📧 Will send to: " . $testLead->email . "\n";
    echo "⏱️  Check in 1-2 minutes for automatic email!\n";
} else {
    echo "❌ Could not create test reaction - missing lead or user\n";
}

echo "\n🎯 Next Steps:\n";
echo "1. Wait 1-2 minutes\n";
echo "2. Run: php artisan reactions:send-notifications --verbose\n";
echo "3. Check email at contact@niranjanenterprises.com\n";
echo "4. Email should arrive automatically!\n";
?>
