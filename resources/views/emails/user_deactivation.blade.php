<!DOCTYPE html>
<html>
<head>
    <title>Account Deactivated</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #6c757d; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .deactivation-notice { background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin: 15px 0; border-radius: 5px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Account Deactivated</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $targetUser->name }},</p>
            
            <div class="deactivation-notice">
                <strong>Important Notice:</strong> Your NIRCRM account has been deactivated by the administrator.
            </div>
            
            <h3>Deactivation Details:</h3>
            <p><strong>Deactivated By:</strong> {{ $adminUser->name }} {{ $adminUser->last_name ?? '' }}</p>
            <p><strong>Deactivation Date:</strong> {{ $targetUser->deactivated_at->format('d M Y H:i:s') }}</p>
            @if($targetUser->deactivation_reason)
                <p><strong>Reason:</strong> {{ $targetUser->deactivation_reason }}</p>
            @endif
            
            <h3>What this means:</h3>
            <ul>
                <li>You will no longer be able to log in to the NIRCRM system</li>
                <li>Your access to all system features and data has been revoked</li>
                <li>You will not receive system notifications or emails</li>
                <li>Your attendance tracking has been suspended</li>
            </ul>
            
            <h3>Next Steps:</h3>
            <p>If you believe this deactivation was made in error, or if you need to discuss this matter further:</p>
            <ul>
                <li>Contact your immediate supervisor or manager</li>
                <li>Reach out to the HR department</li>
                <li>Email the system administrator at admin@nircrm.com</li>
            </ul>
            
            <p>For any urgent matters regarding your employment status, please contact the HR department directly.</p>
            
            <p>Thank you for your understanding.</p>
            
            <p>Best regards,<br>NIRCRM Administration</p>
        </div>
        
        <div class="footer">
            <p>This is an automated notification. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} NIRCRM. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
