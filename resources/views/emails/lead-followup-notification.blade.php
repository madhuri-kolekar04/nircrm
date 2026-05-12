<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Follow-up Reminder</title>
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
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            margin: -30px -30px 30px -30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .alert-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #f39c12;
        }
        .lead-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .lead-info h3 {
            margin-top: 0;
            color: #667eea;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #666;
        }
        .info-value {
            color: #333;
        }
        .reaction-details {
            background: #e8f5e8;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        .emoji {
            font-size: 20px;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                @if(isset($isAutomatic) && $isAutomatic)
                    <span class="emoji">🤖</span>AUTOMATIC Follow-up Reminder
                @else
                    <span class="emoji">📅</span>Follow-up Reminder
                @endif
            </h1>
        </div>

        @if(isset($isAutomatic) && $isAutomatic)
        <div class="alert-box" style="background: #e3f2fd; border-color: #2196f3; border-left-color: #2196f3;">
            <strong><span class="emoji">🤖</span>Automatic Notification:</strong> This email was sent automatically based on the follow-up schedule set in the CRM system.
        </div>
        @endif

        <div class="alert-box">
            <strong><span class="emoji">⏰</span>Reminder:</strong> 
            @if(isset($followUpTime))
                You have a follow-up scheduled for <strong>{{ $followUpDate }}</strong> at <strong>{{ $followUpTime }}</strong>
            @else
                You have a follow-up scheduled for <strong>{{ $followUpDate }}</strong>
            @endif
        </div>

        <div class="lead-info">
            <h3><span class="emoji">👤</span>Lead Information</h3>
            <div class="info-row">
                <span class="info-label">Lead Name:</span>
                <span class="info-value">{{ $lead->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $lead->email ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Phone:</span>
                <span class="info-value">{{ $lead->phone ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Company:</span>
                <span class="info-value">{{ $lead->company_name ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">{{ App\Models\Lead::getLeadStatuses()[$lead->lead_status] ?? $lead->lead_status }}</span>
            </div>
        </div>

        <div class="reaction-details">
            <h4><span class="emoji">📝</span>Last Reaction Details</h4>
            <p><strong>Type:</strong> {{ $reaction->getReactionDetails()['label'] }} {{ $reaction->getReactionDetails()['emoji'] }}</p>
            @if($reaction->notes)
                <p><strong>Notes:</strong> {{ $reaction->notes }}</p>
            @endif
            @if($reaction->call_duration)
                <p><strong>Call Duration:</strong> {{ $reaction->formatted_call_duration }}</p>
            @endif
            <p><strong>Recorded by:</strong> {{ $recordedBy }}</p>
            <p><strong>Recorded on:</strong> {{ $reaction->reaction_date->format('M d, Y') }} at {{ $reaction->reaction_time }}</p>
        </div>

        <p>Hello <strong>{{ $recipientName }}</strong>,</p>
        <p>This is a reminder to follow up with the lead mentioned above on <strong>{{ $followUpDate }}</strong>. Please review the last reaction details and prepare accordingly.</p>
        
        <p><strong>Your Role:</strong> {{ $recipientRole }}</p>

        <div style="text-align: center;">
            <a href="{{ route('leads.reaction', $lead->id) }}" class="btn">
                <span class="emoji">👁️</span>View Lead Details
            </a>
        </div>

        <div class="footer">
            <p>This is an automated notification from your CRM system.</p>
            <p>If you have any questions, please contact your system administrator.</p>
        </div>
    </div>
</body>
</html>
