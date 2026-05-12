<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to NIRCRM - Your Account Details</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }
        
        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: slideIn 0.6s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 50px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            position: relative;
            z-index: 1;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .header p {
            margin: 10px 0 0 0;
            font-size: 18px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .welcome-card {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-left: 5px solid #2196f3;
            padding: 30px;
            margin: 25px 0;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .welcome-card::before {
            content: '🎉';
            position: absolute;
            top: -20px;
            right: -20px;
            font-size: 80px;
            opacity: 0.1;
            transform: rotate(-15deg);
        }
        
        .welcome-card h2 {
            color: #1565c0;
            margin-bottom: 15px;
            font-size: 24px;
        }
        
        .credentials-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px solid #dee2e6;
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
        }
        
        .credentials-box h3 {
            color: #495057;
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 20px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .credential-row {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .credential-row:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .credential-label {
            font-weight: 600;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .credential-value {
            font-family: 'Courier New', monospace;
            background: #f8f9fa;
            padding: 8px 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }
        
        .login-button-container {
            text-align: center;
            margin: 40px 0;
        }
        
        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 18px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .login-button:hover::before {
            left: 100%;
        }
        
        .login-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(40, 167, 69, 0.4);
        }
        
        .quotation-card {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 1px solid #ffeaa7;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.2);
        }
        
        .quotation-card h3 {
            color: #856404;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }
        
        .info-item {
            background: rgba(255,255,255,0.7);
            padding: 10px 15px;
            border-radius: 8px;
            border-left: 3px solid #856404;
        }
        
        .security-box {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border: 1px solid #bee5eb;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            color: #0c5460;
            box-shadow: 0 5px 15px rgba(13, 202, 240, 0.2);
        }
        
        .security-box h4 {
            margin-bottom: 15px;
            color: #0c5460;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .next-steps {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
        }
        
        .next-steps h3 {
            color: #495057;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .steps-list {
            list-style: none;
            padding: 0;
        }
        
        .steps-list li {
            background: white;
            margin: 10px 0;
            padding: 15px 20px;
            border-radius: 10px;
            border-left: 4px solid #007bff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .steps-list li:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .contact-box {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.2);
        }
        
        .contact-box h3 {
            color: #1565c0;
            margin-bottom: 20px;
        }
        
        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .contact-item {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .footer {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        
        .footer h3 {
            margin-bottom: 10px;
            font-size: 20px;
        }
        
        .badge-success {
            background: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .credential-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .contact-info {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🚀 Welcome to NIRCRM!</h1>
            <p>Your Premium Customer Account Has Been Created</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="welcome-card">
                <h2>Hello {{ $user->name }}! 👋</h2>
                <p>Congratulations! Your payment has been successfully processed and your exclusive customer account has been created. Welcome to the NIRCRM family! You now have access to your personal dashboard where you can track projects, communicate with our team, and manage your digital journey with us.</p>
            </div>

            <!-- Login Credentials -->
            <div class="credentials-box">
                <h3>🔐 Your Secure Login Credentials</h3>
                
                <div class="credential-row">
                    <span class="credential-label">
                        📧 Email Address:
                    </span>
                    <span class="credential-value">{{ $user->email }}</span>
                </div>
                
                <div class="credential-row">
                    <span class="credential-label">
                        🔑 Password:
                    </span>
                    <span class="credential-value">{{ $password }}</span>
                </div>
            </div>

            <!-- Security Note -->
            <div class="security-box">
                <h4>🔒 Security Notice</h4>
                <p>Your account security is our top priority. Please keep your login credentials safe and consider changing your password after your first login for enhanced protection. Never share your credentials with anyone.</p>
            </div>

            <!-- Login Button -->
            <div class="login-button-container">
                <a href="{{ $loginUrl }}" class="login-button">
                    🚀 Open Your Dashboard Now
                </a>
            </div>

            <!-- Quotation Information -->
            @if(isset($quotation))
            <div class="quotation-card">
                <h3>📋 Your Approved Quotation Details</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <strong>Quotation Number:</strong><br>
                        {{ $quotation->quotation_number }}
                    </div>
                    <div class="info-item">
                        <strong>Business Name:</strong><br>
                        {{ $quotation->client_business_name }}
                    </div>
                    <div class="info-item">
                        <strong>Total Amount:</strong><br>
                        {{ $quotation->formatted_final_amount }}
                    </div>
                    <div class="info-item">
                        <strong>Payment Status:</strong><br>
                        <span class="badge-success">Completed</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Next Steps -->
            <div class="next-steps">
                <h3>📈 What Can You Do Next?</h3>
                <ul class="steps-list">
                    <li>🎯 Login to your personalized customer dashboard</li>
                    <li>📊 View real-time project details and progress updates</li>
                    <li>💬 Communicate directly with our dedicated team</li>
                    <li>📥 Download invoices and important documents</li>
                    <li>🎯 Track milestones and upcoming deliverables</li>
                    <li>⭐ Provide feedback and rate our services</li>
                </ul>
            </div>

            <!-- Contact Information -->
            <div class="contact-box">
                <h3>📞 Need Assistance? We're Here for You!</h3>
                <p>Our dedicated support team is ready to help you with any questions or assistance you may need.</p>
                <div class="contact-info">
                    <div class="contact-item">
                        <strong>📱 Phone:</strong><br>
                        +91-9220518202
                    </div>
                    <div class="contact-item">
                        <strong>📧 Email:</strong><br>
                        udyami.nircrm24@gmail.com
                    </div>
                    <div class="contact-item">
                        <strong>🌐 Website:</strong><br>
                        www.nircrm.com
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h3>✨ NIRCRM - Digital Innovation Partner</h3>
            <p>We're thrilled to partner with you and transform your digital vision into reality!</p>
            <p>&copy; {{ date('Y') }} NIRCRM. All rights reserved. | Privacy Policy | Terms of Service</p>
        </div>
    </div>
</body>
</html>
