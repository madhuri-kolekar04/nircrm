<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Approved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
        .leave-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #666;
        }
        .detail-value {
            color: #333;
        }
        .approval-info {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 5px;
            text-align: center;
            font-weight: bold;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>✅ Leave Request Approved</h1>
        <p>Your leave request has been approved</p>
    </div>
    
    <div class="content">
        <p>Dear {{ $user->full_name }},</p>
        
        <p>Good news! Your leave request has been <strong>approved</strong> by {{ $approver->full_name }}.</p>
        
        <div class="leave-details">
            <h3>Leave Details</h3>
            
            <div class="detail-row">
                <span class="detail-label">Leave Type:</span>
                <span class="detail-value">{{ $leaveType->name }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Duration:</span>
                <span class="detail-value">
                    {{ $leave->start_date->format('M d, Y') }} 
                    @if($leave->start_date->format('Y-m-d') !== $leave->end_date->format('Y-m-d'))
                        to {{ $leave->end_date->format('M d, Y') }}
                    @endif
                    ({{ $leave->total_days }} day(s))
                    @if($leave->is_half_day)
                        - {{ ucfirst($leave->half_day_type) }}
                    @endif
                </span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Reason:</span>
                <span class="detail-value">{{ $leave->reason }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value" style="color: #28a745; font-weight: bold;">✅ Approved</span>
            </div>
        </div>
        
        <div class="approval-info">
            <h4>Approval Information</h4>
            <p><strong>Approved by:</strong> {{ $approver->full_name }}</p>
            <p><strong>Approval Date:</strong> {{ $leave->approval_date->format('M d, Y h:i A') }}</p>
            @if($leave->approval_notes)
                <p><strong>Notes:</strong> {{ $leave->approval_notes }}</p>
            @endif
        </div>
        
        <p>Please make sure to:</p>
        <ul>
            <li>Complete any pending work before your leave</li>
            <li>Set up out-of-office auto-reply for your email</li>
            <li>Inform your team members about your absence</li>
            <li>Hand over any critical responsibilities if needed</li>
        </ul>
        
        <div style="text-align: center;">
            <a href="{{ url('/leave/' . $leave->id) }}" class="btn btn-primary">View Details</a>
        </div>
        
        <div class="footer">
            <p>This is an automated notification from the Attendance Management System.</p>
            <p>Have a great leave! 🎉</p>
        </div>
    </div>
</body>
</html>
