<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Lead Notification - NIRCRM</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .header {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            text-align: center;
            color: white;
        }
        
        .logo {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .tagline {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .content {
            background: white;
            padding: 40px 30px;
        }
        
        .notification-title {
            color: #667eea;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .lead-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
        }
        
        .lead-info h3 {
            color: #333;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 15px;
            align-items: center;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
            min-width: 120px;
            display: flex;
            align-items: center;
        }
        
        .info-label i {
            margin-right: 8px;
            color: #667eea;
            width: 16px;
        }
        
        .info-value {
            color: #333;
            flex: 1;
        }
        
        .cta-section {
            text-align: center;
            margin: 30px 0;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: bold;
            text-decoration: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        
        .footer p {
            margin: 0;
        }
        
        .social-links {
            margin-top: 15px;
        }
        
        .social-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-size: 18px;
        }
        
        .timestamp {
            background: #e8f4fd;
            color: #0066cc;
            padding: 10px 15px;
            border-radius: 20px;
            font-size: 12px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 10px;
            }
            
            .content {
                padding: 30px 20px;
            }
            
            .info-row {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .info-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <i class="fas fa-phone-alt"></i> NIRCRM
            </div>
            <p class="tagline">Intelligent Customer Relationship Management</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="timestamp">
                <i class="fas fa-clock"></i> {{ $leadData['submitted_at'] ?? 'Just now' }}
            </div>
            
            <h2 class="notification-title">
                <i class="fas fa-bell"></i> New Lead Alert!
            </h2>
            
            <div class="lead-info">
                <h3><i class="fas fa-user-plus"></i> New Lead Details</h3>
                
                <div class="info-row">
                    <div class="info-label">
                        <i class="fas fa-user"></i> Name:
                    </div>
                    <div class="info-value">
                        <strong>{{ $leadData['full_name'] ?? 'N/A' }}</strong>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">
                        <i class="fas fa-building"></i> Business:
                    </div>
                    <div class="info-value">
                        {{ $leadData['company_name'] ?? 'N/A' }}
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">
                        <i class="fas fa-envelope"></i> Email:
                    </div>
                    <div class="info-value">
                        <a href="mailto:{{ $leadData['email'] ?? '#' }}" style="color: #667eea; text-decoration: none;">
                            {{ $leadData['email'] ?? 'N/A' }}
                        </a>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">
                        <i class="fas fa-phone"></i> WhatsApp:
                    </div>
                    <div class="info-value">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9+]/', '', $leadData['whatsapp'] ?? '') }}" target="_blank" style="color: #25d366; text-decoration: none;">
                            {{ $leadData['whatsapp'] ?? 'N/A' }}
                        </a>
                    </div>
                </div>
                
                @if (!empty($leadData['website_url']))
                <div class="info-row">
                    <div class="info-label">
                        <i class="fas fa-globe"></i> Website:
                    </div>
                    <div class="info-value">
                        <a href="{{ $leadData['website_url'] }}" target="_blank" style="color: #667eea; text-decoration: none;">
                            {{ $leadData['website_url'] }}
                        </a>
                    </div>
                </div>
                @endif
            </div>
            
            <div class="cta-section">
                <a href="{{ $callingAppUrl }}" class="cta-button">
                    <i class="fas fa-external-link-alt"></i> View in NIRCRM
                </a>
            </div>
            
            <p style="text-align: center; color: #666; font-size: 14px;">
                <i class="fas fa-info-circle"></i> This is an automated notification from NIRCRM system.
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} NIRCRM - All rights reserved</p>
            <div class="social-links">
                <a href="#"><i class="fas fa-globe"></i></a>
                <a href="#"><i class="fas fa-envelope"></i></a>
                <a href="#"><i class="fas fa-phone"></i></a>
            </div>
        </div>
    </div>
</body>
</html>
