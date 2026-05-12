<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Cancelled</title>
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
            background: #dc3545;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border: 1px solid #dee2e6;
            border-top: none;
        }
        .footer {
            background: #6c757d;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 0 0 5px 5px;
            font-size: 12px;
        }
        .info-box {
            background: white;
            padding: 15px;
            border-left: 4px solid #dc3545;
            margin: 15px 0;
        }
        .label {
            font-weight: bold;
            color: #495057;
        }
        .value {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Leave Cancelled</h1>
    </div>
    
    <div class="content">
        <p>Dear <strong>{{ $recipient->name }}</strong>,</p>
        
        <p>This is to inform you that the leave request has been <strong>cancelled</strong> by the employee.</p>
        
        <div class="info-box">
            <div class="value">
                <span class="label">Employee Name:</span> {{ $applicant->name }}
            </div>
            <div class="value">
                <span class="label">Employee ID:</span> {{ $applicant->employee_id ?? 'N/A' }}
            </div>
            <div class="value">
                <span class="label">Department:</span> {{ $applicant->department->name ?? 'N/A' }}
            </div>
            <div class="value">
                <span class="label">Leave Type:</span> {{ $leave->leaveType->name }}
            </div>
            @if($leave->is_half_day)
                <div class="value">
                    <span class="label">Leave Date:</span> {{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}
                </div>
                <div class="value">
                    <span class="label">Duration:</span> Half Day ({{ ucfirst($leave->half_day_type) }})
                </div>
            @else
                <div class="value">
                    <span class="label">Start Date:</span> {{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}
                </div>
                <div class="value">
                    <span class="label">End Date:</span> {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}
                </div>
                <div class="value">
                    <span class="label">Total Days:</span> {{ $leave->total_days }}
                </div>
            @endif
            <div class="value">
                <span class="label">Reason:</span> {{ $leave->reason }}
            </div>
            <div class="value">
                <span class="label">Cancelled On:</span> {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
            </div>
        </div>
        
        <p>No further action is required from your end regarding this leave request.</p>
        
        <p>Best regards,<br>
        HR Management System</p>
    </div>
    
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
