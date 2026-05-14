<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Notification</title>
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
            background: #4e73df;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f8f9fc;
            padding: 30px;
            border: 1px solid #e3e6f0;
            border-top: none;
        }
        .footer {
            background: #f8f9fc;
            padding: 20px;
            text-align: center;
            border: 1px solid #e3e6f0;
            border-top: none;
            border-radius: 0 0 5px 5px;
            font-size: 12px;
            color: #858796;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .alert-warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }
        .alert-info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }
        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .details {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e3e6f0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #5a5c69;
        }
        .detail-value {
            color: #333;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-present {
            background: #d4edda;
            color: #155724;
        }
        .status-absent {
            background: #f8d7da;
            color: #721c24;
        }
        .status-late {
            background: #fff3cd;
            color: #856404;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #4e73df;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Attendance Management System</h1>
        <p>Automated Attendance Notification</p>
    </div>

    <div class="content">
        <?php switch($notificationType):
            case ('late_check_in'): ?>
                <div class="alert alert-warning">
                    <h3>⚠️ Late Check-In Alert</h3>
                    <p><strong><?php echo e($user->name); ?></strong> has checked in late today.</p>
                </div>
                <?php break; ?>

            <?php case ('early_checkout'): ?>
                <div class="alert alert-warning">
                    <h3>⚠️ Early Checkout Alert</h3>
                    <p><strong><?php echo e($user->name); ?></strong> has checked out early today.</p>
                </div>
                <?php break; ?>

            <?php case ('marked_by_admin'): ?>
                <div class="alert alert-info">
                    <h3>📝 Attendance Marked</h3>
                    <p>Your attendance for <strong><?php echo e($attendance->date->format('d M Y')); ?></strong> has been marked by the administrator.</p>
                </div>
                <?php break; ?>

            <?php case ('absent'): ?>
                <div class="alert alert-warning">
                    <h3>❌ Absent Notification</h3>
                    <p><strong><?php echo e($user->name); ?></strong> was marked absent today.</p>
                </div>
                <?php break; ?>

            <?php case ('daily_summary'): ?>
                <div class="alert alert-success">
                    <h3>📊 Daily Attendance Summary</h3>
                    <p>Here's the attendance summary for <strong><?php echo e($attendance->date->format('d M Y')); ?></strong>.</p>
                </div>
                <?php break; ?>

            <?php default: ?>
                <div class="alert alert-info">
                    <h3>📋 Attendance Notification</h3>
                    <p>This is an automated attendance notification.</p>
                </div>
        <?php endswitch; ?>

        <div class="details">
            <h4>Attendance Details</h4>
            
            <div class="detail-row">
                <span class="detail-label">Employee Name:</span>
                <span class="detail-value"><?php echo e($user->name); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Employee ID:</span>
                <span class="detail-value"><?php echo e($user->employeeID ?? 'N/A'); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Department:</span>
                <span class="detail-value">
                    <?php if($user->department): ?>
                        <?php if(is_object($user->department)): ?>
                            <?php echo e($user->department->name); ?>

                        <?php else: ?>
                            <?php echo e($user->department); ?>

                        <?php endif; ?>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Date:</span>
                <span class="detail-value"><?php echo e($attendance->date->format('d M Y')); ?></span>
            </div>
            
            <?php if($attendance->check_in_time): ?>
                <div class="detail-row">
                    <span class="detail-label">Check In Time:</span>
                    <span class="detail-value">
                        <?php echo e($attendance->check_in_time->format('h:i A')); ?>

                        <?php if($attendance->is_late): ?>
                            <span class="status-badge status-late">LATE</span>
                        <?php endif; ?>
                    </span>
                </div>
            <?php endif; ?>
            
            <?php if($attendance->check_out_time): ?>
                <div class="detail-row">
                    <span class="detail-label">Check Out Time:</span>
                    <span class="detail-value">
                        <?php echo e($attendance->check_out_time->format('h:i A')); ?>

                        <?php if($attendance->is_early_checkout): ?>
                            <span class="status-badge status-late">EARLY</span>
                        <?php endif; ?>
                    </span>
                </div>
            <?php endif; ?>
            
            <?php if($attendance->working_hours): ?>
                <div class="detail-row">
                    <span class="detail-label">Working Hours:</span>
                    <span class="detail-value"><?php echo e(number_format($attendance->working_hours, 2)); ?> hours</span>
                </div>
            <?php endif; ?>
            
            <?php if($attendance->overtime_hours > 0): ?>
                <div class="detail-row">
                    <span class="detail-label">Overtime:</span>
                    <span class="detail-value"><?php echo e(number_format($attendance->overtime_hours, 2)); ?> hours</span>
                </div>
            <?php endif; ?>
            
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value">
                    <span class="status-badge status-<?php echo e($attendance->status); ?>">
                        <?php echo e(ucfirst($attendance->status)); ?>

                    </span>
                </span>
            </div>
            
            <?php if($attendance->notes): ?>
                <div class="detail-row">
                    <span class="detail-label">Notes:</span>
                    <span class="detail-value"><?php echo e($attendance->notes); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if($attendance->location): ?>
                <div class="detail-row">
                    <span class="detail-label">Location:</span>
                    <span class="detail-value"><?php echo e($attendance->location); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <?php if($notificationType === 'late_check_in' || $notificationType === 'early_checkout'): ?>
            <div class="alert alert-warning">
                <p><strong>Action Required:</strong> Please review this attendance record and take appropriate action if necessary.</p>
                <p>You can contact the employee directly or update their attendance record in the system.</p>
            </div>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 30px;">
            <a href="<?php echo e(url('/attendance/dashboard')); ?>" class="btn">View Attendance Dashboard</a>
        </div>
    </div>

    <div class="footer">
        <p>This is an automated message from the Attendance Management System.</p>
        <p>If you believe this was sent in error, please contact your system administrator.</p>
        <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.</p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/emails/attendance/notification.blade.php ENDPATH**/ ?>