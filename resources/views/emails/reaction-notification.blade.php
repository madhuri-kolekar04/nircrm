<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reaction Notification</title>
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
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 28px;
        }
        .header .emoji {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .overdue {
            border-left: 5px solid #dc3545;
        }
        .reminder {
            border-left: 5px solid #28a745;
        }
        .lead-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .lead-info h3 {
            margin-top: 0;
            color: #495057;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
        }
        .info-value {
            color: #495057;
        }
        .reaction-details {
            background: #e7f3ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        .reaction-type {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            margin: 10px 0;
        }
        .positive { background: #d4edda; color: #155724; }
        .negative { background: #f8d7da; color: #721c24; }
        .neutral { background: #fff3cd; color: #856404; }
        .follow_up { background: #d1ecf1; color: #0c5460; }
        .interested { background: #ffe4d6; color: #d84315; }
        .not_reachable { background: #e2e3e5; color: #383d41; }
        
        .follow-up-info {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 15px 0;
            font-weight: 600;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container {{ isset($data['is_overdue']) && $data['is_overdue'] ? 'overdue' : 'reminder' }}">
        <div class="header">
            <div class="emoji">{{ $data['reaction_emoji'] ?? '📅' }}</div>
            <h1>
                {{ isset($data['is_overdue']) && $data['is_overdue'] ? 'Overdue Follow-up Required' : 'Follow-up Reminder' }}
            </h1>
        </div>

        <div class="lead-info">
            <h3>Lead Information</h3>
            <div class="info-row">
                <span class="info-label">Name:</span>
                <span class="info-value">{{ $data['lead_name'] ?? 'N/A' }}</span>
            </div>
            @if($data['lead_email'] ?? null)
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $data['lead_email'] }}</span>
            </div>
            @endif
            @if($data['lead_phone'] ?? null)
            <div class="info-row">
                <span class="info-label">Phone:</span>
                <span class="info-value">{{ $data['lead_phone'] }}</span>
            </div>
            @endif
            @if($data['lead_company'] ?? null)
            <div class="info-row">
                <span class="info-label">Company:</span>
                <span class="info-value">{{ $data['lead_company'] }}</span>
            </div>
            @endif
        </div>

        <div class="reaction-details">
            <h3>Reaction Details</h3>
            <div class="info-row">
                <span class="info-label">Reaction Type:</span>
                <span class="reaction-type {{ $data['reaction_type'] ?? 'neutral' }}">
                    {{ ucfirst($data['reaction_type'] ?? 'Unknown') }} {{ $data['reaction_emoji'] ?? '' }}
                </span>
            </div>
            @if($data['reaction_notes'] ?? null)
            <div class="info-row">
                <span class="info-label">Notes:</span>
                <span class="info-value">{{ $data['reaction_notes'] }}</span>
            </div>
            @endif
            @if($data['call_duration'] ?? null)
            <div class="info-row">
                <span class="info-label">Call Duration:</span>
                <span class="info-value">{{ $data['call_duration'] }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">Created By:</span>
                <span class="info-value">{{ $data['created_by'] ?? 'System' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Reaction Date:</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($data['reaction_date'])->format('M d, Y') }}</span>
            </div>
        </div>

        <div class="follow-up-info">
            <h3>📅 Follow-up Information</h3>
            @if(isset($data['is_overdue']) && $data['is_overdue'])
                <p><strong>⚠️ This follow-up is OVERDUE!</strong></p>
            @endif
            <div class="info-row">
                <span class="info-label">Follow-up Date:</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($data['follow_up_date'])->format('M d, Y') }}</span>
            </div>
            @if($data['follow_up_time'] ?? null)
            <div class="info-row">
                <span class="info-label">Follow-up Time:</span>
                <span class="info-value">{{ $data['follow_up_time'] }}</span>
            </div>
            @endif
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/leadsmanagement') }}" class="btn">
                View Lead in CRM
            </a>
        </div>

        <div class="footer">
            <p>This is an automated notification from the CRM System.</p>
            <p>If you have any questions, please contact your system administrator.</p>
            <p>Generated on: {{ now()->format('M d, Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
