<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Notification</title>
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
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-danger {
            background: #dc3545;
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
        <h1>📅 Leave Request Notification</h1>
        <p>New leave request requires your attention</p>
    </div>
    
    <div class="content">
        <p>Hello,</p>
        
        <p>A new leave request has been submitted by <strong>{{ $user->full_name }}</strong> and requires your approval.</p>
        
        <div class="leave-details">
            <h3>Leave Details</h3>
            
            <div class="detail-row">
                <span class="detail-label">Employee:</span>
                <span class="detail-value">{{ $user->full_name }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Employee ID:</span>
                <span class="detail-value">{{ $user->employee_id ?? 'N/A' }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Department:</span>
                <span class="detail-value">
                    @if(isset($user->department) && is_object($user->department))
                        {{ $user->department->name }}
                    @elseif(isset($user->department) && is_string($user->department))
                        {{ $user->department }}
                    @else
                        N/A
                    @endif
                </span>
            </div>
            
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
                <span class="detail-label">Applied On:</span>
                <span class="detail-value">{{ $leave->created_at->format('M d, Y h:i A') }}</span>
            </div>
        </div>
        
        <p><strong>Action Required:</strong> Please review this leave request and take appropriate action.</p>
        
        <div style="text-align: center;">
            <a href="{{ url('/leave/' . $leave->id) }}" class="btn btn-primary">View Details</a>
            <a href="{{ url('/leave') }}" class="btn btn-success">Review All Requests</a>
        </div>
        
        <div class="footer">
            <p>This is an automated notification from the Attendance Management System.</p>
            <p>If you have any questions, please contact the HR department.</p>
        </div>
    </div>
</body>
</html>
