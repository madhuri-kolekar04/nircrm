<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Reaction Notification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        .content {
            padding: 30px;
        }
        .lead-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }
        .lead-info h3 {
            margin: 0 0 15px 0;
            color: #007bff;
            font-size: 20px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
            color: #666;
        }
        .info-value {
            flex: 1;
        }
        .reaction-details {
            background: linear-gradient(135deg, #28a74515 0%, #20c99715 100%);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }
        .reaction-type {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: 500;
        }
        .btn:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
        }
        .timestamp {
            background: #e9ecef;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 12px;
            color: #666;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 New Lead Reaction Recorded</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $data['lead_name'] }},</p>
            
            <p>This is a follow-up notification regarding your recent interaction with our team.</p>
            
            <div class="lead-info">
                <h3>📋 Your Information</h3>
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value">{{ $data['lead_name'] }}</span>
                </div>
                @if($data['lead_email'])
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $data['lead_email'] }}</span>
                </div>
                @endif
                @if($data['lead_phone'])
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">{{ $data['lead_phone'] }}</span>
                </div>
                @endif
                @if($data['lead_company'])
                <div class="info-row">
                    <span class="info-label">Company:</span>
                    <span class="info-value">{{ $data['lead_company'] }}</span>
                </div>
                @endif
            </div>
            
            <div class="reaction-details">
                <h3>💭 Follow-up Details</h3>
                <div class="reaction-type">{{ $data['reaction_emoji'] }} {{ ucfirst($data['reaction_type']) }}</div>
                
                @if($data['reaction_notes'])
                <p><strong>Notes:</strong> {{ $data['reaction_notes'] }}</p>
                @endif
                
                @if($data['follow_up_date'])
                <p><strong>Follow-up Date:</strong> {{ \Carbon\Carbon::parse($data['follow_up_date'])->format('F d, Y') }}</p>
                @endif
                
                @if($data['follow_up_time'])
                <p><strong>Follow-up Time:</strong> {{ $data['follow_up_time'] }}</p>
                @endif
                
                <div class="timestamp">
                    Recorded on: {{ \Carbon\Carbon::parse($data['reaction_date'])->format('F d, Y') }} by {{ $data['created_by'] }}
                </div>
            </div>
            
            <p>We look forward to continuing our conversation with you. Please feel free to reach out if you have any questions.</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/leadsmanagement') }}" class="btn">
                    Visit Our Website
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p>Best regards,<br>Niranjan Enterprises Team</p>
            <p><small>This email was sent automatically based on your recent interaction with us.</small></p>
        </div>
    </div>
</body>
</html>
