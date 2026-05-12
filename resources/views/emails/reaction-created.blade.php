<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Reaction Recorded</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .reaction-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: 600;
            min-width: 150px;
            color: #667eea;
        }
        .detail-value {
            flex: 1;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }
        .badge {
            background: #667eea;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔔 New Reaction Recorded</h1>
        <p>A new reaction has been recorded in the CRM system</p>
    </div>

    <div class="content">
        <div class="reaction-info">
            <h3>Reaction Details</h3>
            
            <div class="detail-row">
                <div class="detail-label">Lead Name:</div>
                <div class="detail-value">{{ $reaction->lead->name ?? 'Unknown' }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Reaction Type:</div>
                <div class="detail-value">
                    <span class="badge">{{ $reaction->reaction_type_label }}</span>
                </div>
            </div>
            
            @if($reaction->user)
            <div class="detail-row">
                <div class="detail-label">Recorded By:</div>
                <div class="detail-value">{{ $reaction->user->name }}</div>
            </div>
            @endif
            
            @if($reaction->notes)
            <div class="detail-row">
                <div class="detail-label">Notes:</div>
                <div class="detail-value">{{ $reaction->notes }}</div>
            </div>
            @endif
            
            @if($reaction->next_follow_up)
            <div class="detail-row">
                <div class="detail-label">Next Follow-up:</div>
                <div class="detail-value">{{ $reaction->formatted_follow_up_date }}</div>
            </div>
            @endif
            
            @if($reaction->call_duration)
            <div class="detail-row">
                <div class="detail-label">Call Duration:</div>
                <div class="detail-value">{{ $reaction->formatted_call_duration }}</div>
            </div>
            @endif
            
            <div class="detail-row">
                <div class="detail-label">Priority:</div>
                <div class="detail-value">{{ $reaction->priority_label }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Recorded At:</div>
                <div class="detail-value">{{ $reaction->reaction_timestamp->format('M d, Y H:i') }}</div>
            </div>
        </div>

        <div class="footer">
            <p>This is an automated notification from the CRM System.</p>
            <p>Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
