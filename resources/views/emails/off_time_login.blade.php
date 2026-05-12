<!DOCTYPE html>
<html>
<head>
    <title>Off-Time Login Alert</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #dc3545; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .alert-box { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; margin: 15px 0; border-radius: 5px; }
        .login-details { background: white; padding: 15px; margin: 15px 0; border-left: 4px solid #dc3545; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>⚠️ Off-Time Login Alert</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $recipientRole }},</p>
            
            <div class="alert-box">
                <strong>Alert:</strong> An employee has logged in outside their scheduled shift time.
            </div>
            
            <div class="login-details">
                <h3>Login Details:</h3>
                <p><strong>Employee:</strong> {{ $user->name }} {{ $user->last_name ?? '' }}</p>
                <p><strong>Role:</strong> {{ $user->role_name }}</p>
                @if($user->department)
                    <p><strong>Department:</strong> {{ $user->department->name }}</p>
                @endif
                <p><strong>Login Time:</strong> {{ $loginTime->format('d M Y H:i:s') }}</p>
                <p><strong>Login IP:</strong> {{ request()->ip() }}</p>
                
                @if($shift)
                    <p><strong>Assigned Shift:</strong> {{ $shift->name }}</p>
                    <p><strong>Shift Time:</strong> {{ $shift->start_time->format('H:i') }} - {{ $shift->end_time->format('H:i') }}</p>
                @else
                    <p><strong>Assigned Shift:</strong> Default Shift (09:00 - 18:00)</p>
                @endif
            </div>
            
            <p>This login occurred outside the employee's scheduled working hours. Please review this activity and take appropriate action if necessary.</p>
            
            <p>Reasons for off-time login may include:</p>
            <ul>
                <li>Overtime work</li>
                <li>Weekend work</li>
                <li>Special projects</li>
                <li>System access for emergencies</li>
            </ul>
            
            <p>If this login was not authorized, please contact the employee and the IT department immediately.</p>
            
            <p>Best regards,<br>NIRCRM Attendance System</p>
        </div>
        
        <div class="footer">
            <p>This is an automated security alert. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} NIRCRM. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
