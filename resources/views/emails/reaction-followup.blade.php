<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Follow-up Reminder</title>
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
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
        .followup-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #f5576c;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: 600;
            min-width: 150px;
            color: #f5576c;
        }
        .detail-value {
            flex: 1;
        }
        .alert {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }
        .badge {
            background: #f5576c;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            margin-top: 10px;
        }
        .time-highlight {
            background: #e8f5e8;
            color: #2e7d32;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📅 Follow-up Reminder</h1>
        <p>You have a follow-up scheduled</p>
    </div>

    <div class="content">
        <div class="alert">
            <strong>⏰ Reminder:</strong> A follow-up has been scheduled and requires your attention.
        </div>

        <div class="followup-info">
            <h3>Follow-up Details</h3>
            
            <div class="detail-row">
                <div class="detail-label">Lead Name:</div>
                <div class="detail-value">{{ $lead->name }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Follow-up Date:</div>
                <div class="detail-value">
                    <span class="badge">{{ \Carbon\Carbon::parse($followUpDate)->format('M d, Y') }}</span>
                </div>
            </div>
            
            @if($reactionTime)
            <div class="detail-row">
                <div class="detail-label">Follow-up Time:</div>
                <div class="detail-value">
                    <span class="time-highlight">{{ \Carbon\Carbon::parse($reactionTime)->format('g:i A') }}</span>
                </div>
            </div>
            @endif
            
            <div class="detail-row">
                <div class="detail-label">Priority:</div>
                <div class="detail-value">{{ $reaction->priority_label ?? 'Medium' }}</div>
            </div>
            
            @if($reaction->follow_up_notes)
            <div class="detail-row">
                <div class="detail-label">Follow-up Notes:</div>
                <div class="detail-value">{{ $reaction->follow_up_notes }}</div>
            </div>
            @endif
            
            @if($reaction->notes)
            <div class="detail-row">
                <div class="detail-label">Original Notes:</div>
                <div class="detail-value">{{ $reaction->notes }}</div>
            </div>
            @endif
            
            @if($reaction->reaction_type)
            <div class="detail-row">
                <div class="detail-label">Reaction Type:</div>
                <div class="detail-value">{{ $reaction->reaction_type_label ?? $reaction->reaction_type }}</div>
            </div>
            @endif
            
            <div class="detail-row">
                <div class="detail-label">Scheduled By:</div>
                <div class="detail-value">{{ $recordedBy ?? 'System' }}</div>
            </div>
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/leadsmanagement/' . $reaction->lead_id . '/reaction') }}" class="btn">
                View Lead Details
            </a>
        </div>

        <div class="footer">
            <p>This is an automated follow-up reminder from the CRM System.</p>
            <p>Please complete the follow-up and update the status accordingly.</p>
            <p><strong>Follow-up scheduled for:</strong> {{ \Carbon\Carbon::parse($followUpDate)->format('l, F j, Y') }}@if($reactionTime) at {{ \Carbon\Carbon::parse($reactionTime)->format('g:i A') }}@endif</p>
        </div>
    </div>
</body>
</html>
