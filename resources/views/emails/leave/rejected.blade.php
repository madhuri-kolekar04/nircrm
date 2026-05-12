<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Rejected</title>
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
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
        .rejection-info {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
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
        .btn-outline {
            background: transparent;
            color: #007bff;
            border: 2px solid #007bff;
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
        <h1>❌ Leave Request Rejected</h1>
        <p>Your leave request has been rejected</p>
    </div>
    
    <div class="content">
        <p>Dear {{ $user->full_name }},</p>
        
        <p>We regret to inform you that your leave request has been <strong>rejected</strong> by {{ $approver->full_name }}.</p>
        
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
                <span class="detail-value" style="color: #dc3545; font-weight: bold;">❌ Rejected</span>
            </div>
        </div>
        
        <div class="rejection-info">
            <h4>Rejection Information</h4>
            <p><strong>Rejected by:</strong> {{ $approver->full_name }}</p>
            <p><strong>Rejection Date:</strong> {{ $leave->approval_date->format('M d, Y h:i A') }}</p>
            <p><strong>Reason for Rejection:</strong></p>
            <p style="background: white; padding: 10px; border-radius: 4px; margin-top: 10px;">
                {{ $leave->rejection_reason }}
            </p>
        </div>
        
        <p>If you have any questions about this decision or would like to discuss alternative arrangements, please contact your manager or the HR department.</p>
        
        <p>You may submit a new leave request with updated information if needed.</p>
        
        <div style="text-align: center;">
            <a href="{{ url('/leave/create') }}" class="btn btn-primary">Submit New Request</a>
            <a href="{{ url('/leave/' . $leave->id) }}" class="btn btn-outline">View Details</a>
        </div>
        
        <div class="footer">
            <p>This is an automated notification from the Attendance Management System.</p>
            <p>If you believe this rejection was made in error, please contact HR immediately.</p>
        </div>
    </div>
</body>
</html>
