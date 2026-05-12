<?php

/**
 * Standalone Email Sender - Works independently without Laravel
 * Can be run directly via cron job
 */

// Database configuration
$db_host = '127.0.0.1';
$db_name = 'u314035009_nircrm';
$db_user = 'u314035009_nircrm';
$db_pass = 'mL*28$vqY8';

// Email configuration
$email_host = 'smtp.gmail.com';
$email_port = 587;
$email_user = 'shubhamdixitcorpo@gmail.com';
$email_pass = 'dffg qfwg cywp bhmr';
$email_from = 'shubhamdixitcorpo@gmail.com';
$email_from_name = 'NIRCRM';

// Timezone
date_default_timezone_set('Asia/Kolkata');
$current_time = date('Y-m-d H:i:s');
$current_date = date('Y-m-d');
$current_hour_min = date('H:i');

echo "🚀 Standalone Email Sender - {$current_time}\n";

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Database connected\n";
    
    // Find reactions that need emails
    $sql = "SELECT lr.*, l.name as lead_name, l.email as lead_email, l.phone as lead_phone, 
                   u.name as user_name
            FROM lead_reactions lr 
            LEFT JOIN leads l ON lr.lead_id = l.id 
            LEFT JOIN users u ON lr.user_id = u.id 
            WHERE lr.notification_sent = 0 
            AND (
                lr.next_follow_up < :current_date 
                OR (lr.next_follow_up = :current_date AND lr.reaction_time <= :current_time)
            )
            AND l.email IS NOT NULL AND l.email != ''";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':current_date' => $current_date,
        ':current_time' => $current_hour_min
    ]);
    
    $reactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "📧 Found " . count($reactions) . " reactions to process\n";
    
    $sent_count = 0;
    foreach ($reactions as $reaction) {
        if (send_email($reaction)) {
            // Mark as sent
            $update_sql = "UPDATE lead_reactions SET notification_sent = 1, notification_sent_at = NOW() WHERE id = :id";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute([':id' => $reaction['id']]);
            
            $sent_count++;
            echo "✅ Email sent to {$reaction['lead_email']} for {$reaction['lead_name']}\n";
        } else {
            echo "❌ Failed to send email to {$reaction['lead_email']}\n";
        }
    }
    
    echo "🎉 Process completed. Sent {$sent_count} emails.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

function send_email($reaction) {
    global $email_host, $email_port, $email_user, $email_pass, $email_from, $email_from_name;
    
    $to = $reaction['lead_email'];
    $subject = "Follow-up Reminder - NIRCRM";
    $message = generate_email_body($reaction);
    $headers = "From: {$email_from_name} <{$email_from}>\r\n";
    $headers .= "Reply-To: {$email_from}\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    // Try PHP mail first (simpler)
    if (mail($to, $subject, $message, $headers)) {
        return true;
    }
    
    // Fallback to SMTP if PHP mail fails
    return send_smtp_email($to, $subject, $message, $reaction);
}

function generate_email_body($reaction) {
    $emoji = get_reaction_emoji($reaction['reaction_type']);
    $follow_up_date = date('d M Y', strtotime($reaction['next_follow_up']));
    $follow_up_time = $reaction['reaction_time'] ? date('h:i A', strtotime($reaction['reaction_time'])) : 'Any time';
    
    return "
    <html>
    <head><title>Follow-up Reminder</title></head>
    <body style='font-family: Arial, sans-serif; padding: 20px;'>
        <div style='max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 30px; border-radius: 10px;'>
            <h2 style='color: #333;'>{$emoji} Follow-up Reminder</h2>
            <p>Dear {$reaction['lead_name']},</p>
            <p>This is a follow-up reminder regarding your recent interaction with NIRCRM.</p>
            
            <div style='background: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                <h3>Follow-up Details:</h3>
                <p><strong>Date:</strong> {$follow_up_date}</p>
                <p><strong>Time:</strong> {$follow_up_time}</p>
                <p><strong>Type:</strong> {$reaction['reaction_type']}</p>
                <p><strong>Notes:</strong> " . nl2br(isset($reaction['notes']) ? $reaction['notes'] : 'No notes') . "</p>
            </div>
            
            <p>Best regards,<br>" . (isset($reaction['user_name']) ? $reaction['user_name'] : 'NIRCRM Team') . "</p>
            <hr style='border: none; border-top: 1px solid #ddd; margin: 30px 0;'>
            <p style='font-size: 12px; color: #666;'>This is an automated message. Please do not reply to this email.</p>
        </div>
    </body>
    </html>";
}

function get_reaction_emoji($type) {
    $emojis = [
        'positive' => '😊',
        'neutral' => '😐',
        'negative' => '😞',
        'follow_up' => '📞',
        'interested' => '🔥',
        'not_reachable' => '📵',
        'hot_lead' => '🔥',
        'cold_lead' => '❄️',
        'appointment_set' => '📅',
        'meeting_scheduled' => '🤝'
    ];
    return $emojis[$type] ?? '📋';
}

function send_smtp_email($to, $subject, $message, $reaction) {
    // This would require PHPMailer or similar library
    // For now, return false to indicate it needs implementation
    return false;
}
?>
