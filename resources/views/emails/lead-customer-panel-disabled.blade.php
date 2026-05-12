<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Panel Access Disabled</title>
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
            border-bottom: 2px solid #dc3545;
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
            background-color: #fff3cd;
            padding: 15px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
        }
        .warning-box {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 15px;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">NIRCRM</div>
            <h1 class="title">Customer Panel Access Disabled</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $lead->name }},</p>
            
            <div class="warning-box">
                <strong>Important Notice:</strong> Your customer panel access has been <strong>disabled</strong>. You can no longer log in to your account.
            </div>
            
            <div class="highlight">
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
            
            <p>This action was taken by our administrative team. The deactivation of your account access means:</p>
            
            <ul>
                <li>You can no longer log in to your customer panel</li>
                <li>You cannot track your lead status online</li>
                <li>You cannot access quotation or invoice details through the portal</li>
                <li>Your account access has been temporarily suspended</li>
            </ul>
            
            <p><strong>What to do next:</strong></p>
            
            <ul>
                <li>If you believe this is an error, please contact our support team immediately</li>
                <li>For any questions about your lead status or quotations, please reach out to your assigned sales representative</li>
                <li>If you need to reactivate your account, please contact our support team</li>
            </ul>
            
            <p><strong>Contact Information:</strong><br>
            Email: support@niranjanenterprises.com<br>
            Phone: [Your Phone Number]<br>
            Business Hours: Monday to Friday, 9:00 AM - 6:00 PM</p>
            
            <p>We appreciate your understanding and cooperation. Our team is still working on your lead and will contact you if needed.</p>
            
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
