<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Time Notification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .alert-late {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }
        .alert-early {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        .info-item {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
        }
        .info-value {
            color: #333;
            font-size: 16px;
            margin-top: 5px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .role-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .role-admin { background-color: #dc3545; color: white; }
        .role-gm { background-color: #6f42c1; color: white; }
        .role-manager { background-color: #fd7e14; color: white; }
        .role-employee { background-color: #28a745; color: white; }
        .role-customer { background-color: #17a2b8; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">{{ $icon }}</div>
            <h1>{{ $loginType === 'late' ? 'Late Login Alert' : 'Early Login Alert' }}</h1>
            <p>Niranjan Enterprises - Attendance System</p>
        </div>

        <div class="alert {{ $loginType === 'late' ? 'alert-late' : 'alert-early' }}">
            <strong>{{ $user->name }}</strong> has logged {{ $loginType === 'late' ? 'in late' : 'in early' }} today.
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Employee Name</div>
                <div class="info-value">{{ $user->name }} {{ $user->last_name ?? '' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Employee ID</div>
                <div class="info-value">{{ $user->employee_id ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Department</div>
                <div class="info-value">{{ $user->department->name ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Position</div>
                <div class="info-value">{{ $user->position ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Shift Time</div>
                <div class="info-value">{{ $shiftTime ? $shiftTime->format('H:i') : 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Login Time</div>
                <div class="info-value">{{ $loginTime->format('H:i:s') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Date</div>
                <div class="info-value">{{ $loginTime->format('Y-m-d') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">User Role</div>
                <div class="info-value">
                    <span class="role-badge role-{{ $user->getRoleName() }}">{{ $user->getRoleName() }}</span>
                </div>
            </div>
        </div>

        <div style="margin: 20px 0; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
            <h3 style="margin-top: 0; color: #495057;">Notification Details</h3>
            <p style="margin-bottom: 0;">This notification was sent to you as the responsible authority for monitoring attendance compliance.</p>
            <p style="margin-bottom: 0;"><strong>Your Role:</strong> 
                <span class="role-badge role-{{ $recipientRole === 1 ? 'admin' : ($recipientRole === 5 ? 'gm' : ($recipientRole === 4 ? 'manager' : 'employee')) }}">
                    {{ $recipientRole === 1 ? 'Admin' : ($recipientRole === 5 ? 'General Manager' : ($recipientRole === 4 ? 'Manager' : 'Employee')) }}
                </span>
            </p>
        </div>

        <div class="footer">
            <p>This is an automated notification from the Niranjan Enterprises Attendance System.</p>
            <p>If you believe this notification was sent in error, please contact the system administrator.</p>
            <p style="margin-bottom: 0; font-size: 10px;">Notification sent: {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
