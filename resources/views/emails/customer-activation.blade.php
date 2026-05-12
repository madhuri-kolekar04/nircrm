<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Panel Access Activated</title>
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
            border-bottom: 2px solid #667eea;
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
            border-left: 4px solid #667eea;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">NIRCRM</div>
            <h1 class="title">Customer Panel Access Activated</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $user->name }},</p>
            
            <p>Good news! Your customer panel access has been <strong>activated</strong>. You can now log in to your account to view your quotation details and manage your services.</p>
            
            <div class="info-box">
                <strong>Quotation Details:</strong><br>
                Quotation Number: {{ $quotation->quotation_number }}<br>
                Business Name: {{ $quotation->client_business_name }}<br>
                Final Amount: {{ $quotation->formatted_final_amount }}
            </div>
            
            <div class="highlight">
                <strong>What you can do with your customer panel:</strong>
                <ul>
                    <li>View your quotation details</li>
                    <li>Check payment status</li>
                    <li>Download invoices</li>
                    <li>Communicate with our team</li>
                </ul>
            </div>
            
            <p>To access your account, please click the button below:</p>
            
            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="button">Login to Your Account</a>
            </div>
            
            <p><strong>Login Information:</strong><br>
            Email: {{ $user->email }}<br>
            Password: Your existing password</p>
            
            <p>If you have forgotten your password, you can use the "Forgot Password" link on the login page to reset it.</p>
            
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
