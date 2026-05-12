<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Panel Access Enabled</title>
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
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #28a745;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        .title {
            color: #333;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .content {
            margin-bottom: 30px;
        }
        .highlight {
            background-color: #f8f9ff;
            padding: 15px;
            border-left: 4px solid #28a745;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        .info-box {
            background-color: #e8f5e8;
            border: 1px solid #4caf50;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .credentials-box {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">NIRCRM</div>
            <h1 class="title">Customer Panel Access Enabled</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $lead->name }},</p>
            
            <p>Good news! Your customer panel access has been <strong>enabled</strong>. You can now log in to your account to track your lead status and manage your interactions with us.</p>
            
            <div class="info-box">
                <strong>Your Lead Details:</strong><br>
                Name: {{ $lead->name }}<br>
                Company: {{ $lead->company_name ?? 'N/A' }}<br>
                Email: {{ $lead->email ?? 'N/A' }}<br>
                Phone: {{ $lead->phone ?? 'N/A' }}<br>
                @if($lead->budget)
                Budget: {{ number_format($lead->budget, 2) }}<br>
                @endif
                Priority: {{ ucfirst($lead->priority) }}
            </div>
            
            <div class="highlight">
                <strong>What you can do with your customer panel:</strong>
                <ul>
                    <li>Track your lead status and progress</li>
                    <li>View assigned team members</li>
                    <li>Communicate with our sales team</li>
                    <li>Access quotation and invoice details</li>
                    <li>Update your contact information</li>
                </ul>
            </div>
            
            <p>To access your account, please click the button below:</p>
            
            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="button">Login to Your Account</a>
            </div>
            
            <div class="credentials-box">
                <strong>Your Login Credentials:</strong><br>
                <strong>Email/Username:</strong> {{ $lead->email }}<br>
                <strong>Password:</strong> 123456789<br>
                <em><strong>Important:</strong> Please change your password after first login for security reasons.</em>
            </div>
            
            <p><strong>First Time Login Instructions:</strong></p>
            <ol>
                <li>Visit the login page using the button above</li>
                <li>Enter your email address and the default password: <strong>123456789</strong></li>
                <li>Click "Login" to access your dashboard</li>
                <li>Navigate to "Profile" or "Settings" to change your password</li>
            </ol>
            
            <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
            
            <p>Thank you for choosing Niranjan Enterprises!</p>
            
            <p>Best regards,<br>
            The NIRCRM Team</p>
        </div>
        
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} Niranjan Enterprises. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
