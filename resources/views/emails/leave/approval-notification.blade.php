<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application Approved</title>
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
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 12px;
        }
        .badge {
            background: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .approval-info {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .checkmark {
            color: #28a745;
            font-size: 48px;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>✅ Leave Application Approved</h1>
        <p>Your leave request has been approved</p>
    </div>

    <div class="content">
        <div class="checkmark" style="text-align: center;">✅</div>
        
        <p>Dear <strong>{{ $applicant->name }}</strong>,</p>
        
        <p>Good news! Your leave application has been <strong>approved</strong> by <strong>{{ $approver->name }}</strong>.</p>

        <div class="approval-info">
            <h4>Approval Details</h4>
            <div class="detail-row">
                <span class="detail-label">Approved By:</span>
                <span class="detail-value">{{ $approver->name }} ({{ $approver->designation ?? 'Approver' }})</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Approval Date:</span>
                <span class="detail-value">{{ \Carbon\Carbon::now()->format('d M Y H:i') }}</span>
            </div>
            @if($leave->approval_notes)
            <div class="detail-row">
                <span class="detail-label">Approval Notes:</span>
                <span class="detail-value">{{ $leave->approval_notes }}</span>
            </div>
            @endif
        </div>

        <div class="leave-details">
            <h3>Your Approved Leave</h3>
            <div class="detail-row">
                <span class="detail-label">Leave Type:</span>
                <span class="detail-value"><span class="badge">{{ $leave->leaveType->name }}</span></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Duration:</span>
                <span class="detail-value">{{ $leave->total_days }} day(s)</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Start Date:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">End Date:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value"><span class="badge">✅ Approved</span></span>
            </div>
        </div>

        <h4>Important Reminders:</h4>
        <ul>
            <li>Please ensure all your pending work is completed or delegated before your leave starts</li>
            <li>Set up an out-of-office auto-reply for your email</li>
            <li>Inform your team members about your absence</li>
            <li>Complete any necessary handover documentation</li>
        </ul>

        <div style="text-align: center;">
            <a href="{{ url('/leave') }}" class="btn">📅 View My Leave History</a>
        </div>

        <p><strong>Wishing you a pleasant and refreshing leave!</strong></p>

        <div class="footer">
            <p>This is an automated message from the Leave Management System. Please do not reply to this email.</p>
            <p>If you have any questions, please contact HR or your manager.</p>
        </div>
    </div>
</body>
</html>
