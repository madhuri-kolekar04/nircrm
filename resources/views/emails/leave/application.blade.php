<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Leave Application</title>
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
            text-align: right;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }
        .btn-success {
            background: #28a745;
        }
        .btn-danger {
            background: #dc3545;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 12px;
        }
        .badge {
            background: #007bff;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📅 New Leave Application</h1>
        <p>A new leave request requires your attention</p>
    </div>

    <div class="content">
        <p>Hello <strong>{{ $approver->name }}</strong>,</p>
        
        <p>You have received a new leave application from <strong>{{ $applicant->name }} {{ $applicant->last_name ?? '' }}</strong> that requires your approval.</p>

        <div class="leave-details">
            <h3>Leave Details</h3>
            <div class="detail-row">
                <span class="detail-label">Employee:</span>
                <span class="detail-value">{{ $applicant->name }} {{ $applicant->last_name ?? '' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Department:</span>
                <span class="detail-value">{{ $applicant->department->name ?? 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Leave Type:</span>
                <span class="detail-value"><span class="badge">{{ $leave->leaveType->name }}</span></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Duration Type:</span>
                <span class="detail-value">
                    @if($leave->is_full_day)
                        <span class="badge" style="background: #28a745;">Full Day Leave</span>
                    @elseif($leave->is_half_day)
                        <span class="badge" style="background: #ffc107; color: #000;">Half Day Leave</span>
                    @else
                        <span class="badge">Unknown</span>
                    @endif
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Duration:</span>
                <span class="detail-value">{{ $leave->total_days }} day(s)</span>
            </div>
            @if($leave->is_half_day && $leave->half_day_type)
            <div class="detail-row">
                <span class="detail-label">Half Day Type:</span>
                <span class="detail-value">{{ $leave->half_day_type == 'first_half' ? 'First Half' : 'Second Half' }}</span>
            </div>
            @endif
            <div class="detail-row">
                <span class="detail-label">Start Date:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">End Date:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Applied On:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($leave->created_at)->format('d M Y H:i') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Reason:</span>
                <span class="detail-value">{{ $leave->reason }}</span>
            </div>
            @if($leave->emergency_contact)
            <div class="detail-row">
                <span class="detail-label">Emergency Contact:</span>
                <span class="detail-value">{{ $leave->emergency_contact }}</span>
            </div>
            @endif
        </div>

        <p><strong>Action Required:</strong></p>
        <p>Please review this leave request and take appropriate action. You can approve or reject this request by clicking the buttons below:</p>

        <div style="text-align: center;">
            <a href="{{ config('app.url') }}/approval-status/leave/{{ $leave->id }}" class="btn btn-success">✅ Approve</a>
            <a href="{{ config('app.url') }}/approval-status/leave/{{ $leave->id }}" class="btn btn-danger">❌ Reject</a>
        </div>

        <p>Alternatively, you can view all pending leave requests by visiting the approval dashboard:</p>
        <div style="text-align: center;">
            <a href="{{ config('app.url') }}/approval-status/leave" class="btn">📋 View All Pending Requests</a>
        </div>

        <div class="footer">
            <p>This is an automated message from the Leave Management System. Please do not reply to this email.</p>
            <p>If you have any questions, please contact the HR department.</p>
        </div>
    </div>
</body>
</html>
