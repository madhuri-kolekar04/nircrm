<!DOCTYPE html>
<html>
<head>
    <title>Shift Change Notification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #007bff; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .shift-details { background: white; padding: 15px; margin: 15px 0; border-left: 4px solid #007bff; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Shift Change Notification</h2>
        </div>
        
        <div class="content">
            <p>Dear Employee,</p>
            
            @if($action == 'assigned')
                <p>You have been assigned to a new shift effective immediately.</p>
            @else
                <p>Your shift schedule has been updated. Please note the following changes:</p>
            @endif
            
            <div class="shift-details">
                <h3>New Shift Details:</h3>
                <p><strong>Shift Name:</strong> {{ $shift->name }}</p>
                <p><strong>Start Time:</strong> {{ $shift->start_time->format('H:i') }}</p>
                <p><strong>End Time:</strong> {{ $shift->end_time->format('H:i') }}</p>
                <p><strong>Grace Period:</strong> {{ $shift->grace_period_minutes }} minutes</p>
                @if($shift->description)
                    <p><strong>Description:</strong> {{ $shift->description }}</p>
                @endif
            </div>
            
            @if($oldShiftData && $action == 'updated')
                <div class="shift-details">
                    <h3>Previous Shift Details:</h3>
                    <p><strong>Start Time:</strong> {{ $oldShiftData['start_time'] }}</p>
                    <p><strong>End Time:</strong> {{ $oldShiftData['end_time'] }}</p>
                    <p><strong>Grace Period:</strong> {{ $oldShiftData['grace_period_minutes'] }} minutes</p>
                </div>
            @endif
            
            <p>Please ensure you adhere to your new shift timings for attendance purposes.</p>
            
            <p>If you have any questions or concerns, please contact your manager or the HR department.</p>
            
            <p>Best regards,<br>NIRCRM Team</p>
        </div>
        
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} NIRCRM. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
