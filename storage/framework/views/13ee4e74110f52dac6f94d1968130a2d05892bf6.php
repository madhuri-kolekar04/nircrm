<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Status Updates</title>
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
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        .header .subtitle {
            margin-top: 10px;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 30px;
        }
        .project-info {
            background-color: #f8f9fa;
            border-left: 4px solid #28a745;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 4px;
        }
        .project-info h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 20px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 15px;
        }
        .info-item {
            margin: 5px 0;
        }
        .info-label {
            font-weight: 600;
            color: #555;
            display: inline-block;
            min-width: 100px;
        }
        .info-value {
            color: #333;
        }
        .task-updates {
            margin-top: 25px;
        }
        .task-updates h3 {
            color: #333;
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .task-item {
            background-color: #fff;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            position: relative;
            transition: all 0.3s ease;
        }
        .task-item:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
        .task-completed {
            border-left: 4px solid #28a745;
        }
        .task-completed::before {
            content: "✅";
            position: absolute;
            left: -12px;
            top: 15px;
            background-color: #28a745;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        .task-working {
            border-left: 4px solid #ffc107;
        }
        .task-working::before {
            content: "🔄";
            position: absolute;
            left: -12px;
            top: 15px;
            background-color: #ffc107;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        .task-pending {
            border-left: 4px solid #6c757d;
        }
        .task-pending::before {
            content: "⏳";
            position: absolute;
            left: -12px;
            top: 15px;
            background-color: #6c757d;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        .task-content {
            margin-left: 20px;
        }
        .task-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-working {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-pending {
            background-color: #f8f9fa;
            color: #6c757d;
        }
        .meta-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin-top: 25px;
            font-size: 14px;
            color: #6c757d;
        }
        .meta-item {
            margin: 5px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }
        .company-name {
            font-weight: 600;
            color: #333;
            margin-top: 10px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background-color: #218838;
            transform: translateY(-1px);
        }
        .summary-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 25px;
            text-align: center;
        }
        .summary-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 15px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }
        .stat-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
        }
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .container {
                margin: 10px;
            }
            .content {
                padding: 20px;
            }
            .summary-stats {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Task Status Updates</h1>
            <div class="subtitle">Your project tasks have been updated</div>
        </div>
        
        <div class="content">
            <div class="project-info">
                <h3><?php echo e($invoice->project_name); ?></h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Invoice:</span>
                        <span class="info-value"><?php echo e($invoice->invoice_number); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Department:</span>
                        <span class="info-value"><?php echo e($invoice->department); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Start Date:</span>
                        <span class="info-value"><?php echo e($invoice->start_date ? $invoice->start_date->format('M d, Y') : 'N/A'); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">End Date:</span>
                        <span class="info-value"><?php echo e($invoice->end_date ? $invoice->end_date->format('M d, Y') : 'N/A'); ?></span>
                    </div>
                </div>
            </div>

            <?php
                // Parse the work update text to extract tasks and statuses
                $workUpdateText = $workUpdate->update_point_1;
                $lines = explode("\n", $workUpdateText);
                $tasks = [];
                $completedCount = 0;
                $workingCount = 0;
                $pendingCount = 0;
                
                foreach ($lines as $line) {
                    $cleanLine = trim($line);
                    if (!empty($cleanLine)) {
                        $task = [
                            'text' => $cleanLine,
                            'status' => 'pending',
                            'clean_text' => $cleanLine
                        ];
                        
                        // Extract status from the task text
                        if (strpos($cleanLine, '✅') !== false) {
                            $task['status'] = 'completed';
                            $task['clean_text'] = trim(str_replace(['✅', '- Completed'], '', $cleanLine));
                            $completedCount++;
                        } elseif (strpos($cleanLine, '🔄') !== false) {
                            $task['status'] = 'working';
                            $task['clean_text'] = trim(str_replace(['🔄', '- Working'], '', $cleanLine));
                            $workingCount++;
                        } elseif (strpos($cleanLine, '⏳') !== false) {
                            $task['status'] = 'pending';
                            $task['clean_text'] = trim(str_replace(['⏳', '- Pending'], '', $cleanLine));
                            $pendingCount++;
                        }
                        
                        $tasks[] = $task;
                    }
                }
            ?>
            
            <div class="summary-box">
                <h4 style="margin: 0 0 10px 0; color: #333;">Task Progress Summary</h4>
                <div class="summary-stats">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo e($completedCount); ?></div>
                        <div class="stat-label">Completed</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo e($workingCount); ?></div>
                        <div class="stat-label">In Progress</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo e($pendingCount); ?></div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
            </div>

            <div class="task-updates">
                <h3>🎯 Task Status Details</h3>
                
                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="task-item task-<?php echo e($task['status']); ?>">
                        <div class="task-content">
                            <strong><?php echo e($index + 1); ?>.</strong> <?php echo e($task['clean_text']); ?>

                            <span class="task-status status-<?php echo e($task['status']); ?>">
                                <?php echo e(ucfirst($task['status'])); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="meta-info">
                <div class="meta-item">
                    <strong>Updated by:</strong> <?php echo e($user->name); ?> 
                    <?php if($user->role == 1 || $user->role == 5): ?> (Admin)
                    <?php elseif($user->role == 2): ?> (Employee)
                    <?php elseif($user->role == 3): ?> (Customer)
                    <?php endif; ?>
                </div>
                <div class="meta-item">
                    <strong>Date:</strong> <?php echo e($workUpdate->update_date->format('M d, Y H:i A')); ?>

                </div>
                <?php if($invoice->project_topic): ?>
                <div class="meta-item">
                    <strong>Topic:</strong> <?php echo e($invoice->project_topic); ?>

                </div>
                <?php endif; ?>
            </div>
            
            <?php if(!empty($workUpdate->attachment)): ?>
                <div class="meta-info" style="margin-top: 15px; border-top: 1px solid #e9ecef; padding-top: 15px;">
                    <div class="meta-item">
                        <strong>📎 Attachment:</strong> <?php echo e(basename($workUpdate->attachment)); ?>

                    </div>
                    <div class="meta-item">
                        <strong>Availability:</strong> 
                        File is attached to this email and available in project portal
                    </div>
                    <div class="meta-item" style="text-align: center; margin-top: 15px;">
                        <a href="<?php echo e(route('attachments.public.download', basename($workUpdate->attachment))); ?>" 
                           style="background-color: #28a745; 
                                  color: white; 
                                  padding: 12px 24px; 
                                  text-decoration: none; 
                                  border-radius: 6px; 
                                  display: inline-block; 
                                  font-weight: 600; 
                                  font-size: 14px;
                                  border: 1px solid #28a745;
                                  font-family: Arial, sans-serif;">
                            📎 Download Attachment
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <a href="<?php echo e(url('/project-updates/' . $invoice->id)); ?>" class="btn">
                View Full Project Details
            </a>
        </div>

        <div class="footer">
            <p>This is an automated notification from the project management system.</p>
            <div class="company-name">Niranjan Enterprises</div>
            <p>© <?php echo e(date('Y')); ?> All rights reserved.</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\nircrm\resources\views/mail/task-status-update.blade.php ENDPATH**/ ?>