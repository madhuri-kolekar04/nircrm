

<?php $__env->startSection('page-title', 'Invoice Update - ' . $invoice->project_name); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Invoice Details</h5>
                    <a href="<?php echo e(route('project-updates.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Invoices
                    </a>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Invoice Details Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Invoice Information</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Invoice Number:</strong> <?php echo e($invoice->invoice_number); ?></p>
                                            <p><strong>Project Name:</strong> <?php echo e($invoice->project_name); ?></p>
                                            <p><strong>Project Topic:</strong> <?php echo e($invoice->project_topic ?? 'N/A'); ?></p>
                                            <p><strong>Project Details:</strong> <?php echo e($invoice->project_full_details ?? 'N/A'); ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Start Date:</strong> <?php echo e(\Carbon\Carbon::parse($invoice->start_date)->format('d-m-Y')); ?></p>
                                            <p><strong>End Date:</strong> <?php echo e(\Carbon\Carbon::parse($invoice->end_date)->format('d-m-Y')); ?></p>
                                            <p><strong>Department:</strong> <?php echo e($invoice->department); ?></p>
                                            <p><strong>Mail Id:</strong> <?php echo e($invoice->customer_email ?? 'N/A'); ?></p>
                                            <?php if(auth()->user()->role == 1): ?> <!-- Show only to admin -->
                                                <p><strong>Total Payment:</strong> ₹<?php echo e(number_format($invoice->total_payment, 2)); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                     <!-- Project Completion Status Section -->
                    <?php
                        $completionStatus = \App\Models\ProjectCompletionStatus::getLatestStatus(null, $invoice->id);
                    ?>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0">Overall Project Completion Status</h6>
                                    <?php if(Auth::user()->role != 3 && strtolower(Auth::user()->position ?? '') != 'customer'): ?>
                                        <a href="<?php echo e(route('project-updates.completion-status.create', $invoice->id)); ?>" class="btn btn-<?php echo e($completionStatus ? 'warning' : 'primary'); ?>">
                                            <i class="fas fa-<?php echo e($completionStatus ? 'edit' : 'plus'); ?>"></i> <?php echo e($completionStatus ? 'Edit' : 'Create'); ?> Status
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <?php if($completionStatus): ?>
                                        <!-- Interactive Progress Bar with Mouse Position -->
                                        <div class="progress-container mb-3" style="position: relative;">
                                            <!-- Mouse Position Indicator -->
                                            <div class="mouse-indicator" id="mouseIndicatorInvoice" style="display: none; position: absolute; top: -30px; transform: translateX(-50%); z-index: 1000;">
                                                <div class="mouse-percentage-badge">
                                                    <span id="mousePercentageInvoice">0%</span>
                                                </div>
                                                <div class="mouse-indicator-line"></div>
                                            </div>
                                            
                                            <div class="progress" style="height: 35px; cursor: pointer;" id="interactiveProgressBarInvoice">
                                                <?php $__currentLoopData = $completionStatus->formatted_status_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $progressData = json_decode($completionStatus->progress_data ?? '[]', true) ?? [];
                                                        $isCompleted = false;
                                                        $isPartial = false;
                                                        $completionPercentage = 0;
                                                        
                                                        if (is_array($progressData) && isset($progressData[$index])) {
                                                            $isCompleted = isset($progressData[$index]['completed']) && ($progressData[$index]['completed'] === 'true' || $progressData[$index]['completed'] === true || $progressData[$index]['completed'] === 1);
                                                            $isPartial = isset($progressData[$index]['partial']) && ($progressData[$index]['partial'] === 'true' || $progressData[$index]['partial'] === true || $progressData[$index]['partial'] === 1);
                                                            $completionPercentage = $progressData[$index]['completion_percentage'] ?? 0;
                                                        }
                                                    ?>
                                                    <div class="progress-segment" 
                                                         data-index="<?php echo e($index); ?>" 
                                                         data-completed="<?php echo e($isCompleted ? 'true' : ($isPartial ? 'partial' : 'false')); ?>"
                                                         <?php if($isCompleted): ?>
                                                             style="width: <?php echo e($item['percentage']); ?>%; background-color: #28a745; border-right: 1px solid #fff;"
                                                             title="<?php echo e($item['text']); ?>: <?php echo e($item['percentage']); ?>%">
                                                            <span class="segment-text" style="color: #ffffff;"><?php echo e($item['text']); ?></span>
                                                         <?php elseif($isPartial): ?>
                                                             style="width: <?php echo e($item['percentage']); ?>%; background: linear-gradient(to right, #28a745 0%, #28a745 <?php echo e($completionPercentage); ?>%, #e9ecef <?php echo e($completionPercentage); ?>%, #e9ecef 100%); border-right: 1px solid #fff;"
                                                             title="<?php echo e($item['text']); ?>: <?php echo e($item['percentage']); ?>%">
                                                            <span class="segment-text" style="color: <?php echo e($isCompleted || ($isPartial && $completionPercentage > 50) ? '#ffffff' : '#6c757d'); ?>;"><?php echo e($item['text']); ?></span>
                                                         <?php else: ?>
                                                             style="width: <?php echo e($item['percentage']); ?>%; background-color: #e9ecef; border-right: 1px solid #fff;"
                                                             title="<?php echo e($item['text']); ?>: <?php echo e($item['percentage']); ?>%">
                                                            <span class="segment-text" style="color: #6c757d;"><?php echo e($item['text']); ?></span>
                                                         <?php endif; ?>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            
                                            <!-- Progress Info -->
                                            <div class="row mt-2">
                                                <div class="col-md-4">
                                                    <small class="text-muted">Completed: <span id="completedCountInvoice" class="fw-bold text-success">
                                                        <?php
                                                            $completedSegments = 0;
                                                            $progressData = json_decode($completionStatus->progress_data ?? '[]', true) ?? [];
                                                            if (is_array($progressData)) {
                                                                foreach($progressData as $data) {
                                                                    if (isset($data['completed']) && ($data['completed'] === 'true' || $data['completed'] === true || $data['completed'] === 1)) {
                                                                                $completedSegments++;
                                                                            }
                                                                        }
                                                                    }
                                                            echo $completedSegments;
                                                        ?>
                                                    </span> / <?php echo e(count($completionStatus->formatted_status_items)); ?></small>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <small class="text-muted">Mouse Position: <span id="mousePositionTextInvoice" class="fw-bold text-primary">-</span></small>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <small class="text-muted">Progress: <span id="progressTextInvoice" class="fw-bold"><?php echo e($completionStatus->exact_percentage ?? 0); ?>%</span></small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Status Items Grid -->
                                        <div class="row">
                                            <?php $__currentLoopData = $completionStatus->formatted_status_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-md-6 col-lg-4 mb-3">
                                                    <div class="card border-left" style="border-left-color: <?php echo e($item['color']); ?> !important; border-left-width: 4px !important;">
                                                        <div class="card-body py-2">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <small class="text-muted">Stage <?php echo e($item['order']); ?></small>
                                                                <span class="badge bg-<?php echo e($item['color']); ?> text-white"><?php echo e($item['percentage']); ?>%</span>
                                                            </div>
                                                            <h6 class="mb-1"><?php echo e($item['text']); ?></h6>
                                                            <div class="progress mb-2" style="height: 8px;">
                                                                <div class="progress-bar" style="width: <?php echo e($item['percentage']); ?>%; background-color: <?php echo e($item['color']); ?>;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        
                                        <div class="mt-3 pt-3 border-top">
                                            <small class="text-muted">
                                                Total Completion: <?php echo e($completionStatus->total_percentage); ?>% | 
                                                Created by: <?php echo e($completionStatus->user->name); ?> on <?php echo e($completionStatus->created_at->format('M d, Y')); ?>

                                            </small>
                                        </div>
                                    <?php else: ?>
                                        <?php if(Auth::user()->role == 3): ?>
                                            <div class="text-center py-4">
                                                <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">No completion status defined yet.</p>
                                                <a href="<?php echo e(route('project-updates.completion-status.create', $invoice->id)); ?>" class="btn btn-primary">
                                                    <i class="fas fa-plus-circle"></i> Create Completion Status
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-center py-4">
                                                <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">No completion status defined yet. Customer will define the project completion stages.</p>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <!-- Updates Section with Two Column Layout -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Project Updates</h6>
                                </div>
                                <div class="card-body p-0">
                                    <!-- Main Container with Resizable Layout -->
                                    <div class="updates-container d-flex" style="height: 600px; position: relative;">
                                        
                                        <!-- Left Column - Work Updates -->
                                        <div id="workUpdatesColumn" class="work-updates-column" style="width: 50%; border-right: 1px solid #dee2e6; overflow-y: auto; padding: 20px;">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="text-primary mb-0">
                                                    <i class="fas fa-tools"></i> Work Updates
                                                </h6>
                                                 <?php if((auth()->user()->role == 2) || (auth()->user()->role == 1) || (auth()->user()->role == 4) || (auth()->user()->role == 5)): ?>
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="showWorkUpdateModal()">
                                                        <i class="fas fa-plus"></i> Add Work Update
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <?php
                                                // Ensure $updates is always a collection
                                                if (!isset($updates)) {
                                                    $updates = collect([]);
                                                }
                                                
                                                $workUpdates = [];
                                                $requestUpdates = [];
                                                
                                                // Separate work updates and request updates
                                                foreach($updates as $update) {
                                                    if($update->request_text) {
                                                        $requestUpdates[] = $update;
                                                    } else {
                                                        $workUpdates[] = $update;
                                                    }
                                                }
                                            ?>
                                            
                                            <?php $__empty_1 = true; $__currentLoopData = $workUpdates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $update): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <div class="update-item mb-3 p-3 border rounded bg-light">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <strong>Updated by:</strong> <?php echo e($update->user->name); ?>

                                                            <span class="text-muted">(
                                                                <?php if(isset($update->user->department) && is_object($update->user->department)): ?>
                                                                    <?php echo e($update->user->department->name ?? 'Administration'); ?>

                                                                <?php elseif(isset($update->user->department) && is_string($update->user->department)): ?>
                                                                    <?php
                                                                        $deptData = json_decode($update->user->department);
                                                                        if ($deptData && isset($deptData->name)) {
                                                                            echo $deptData->name;
                                                                        } elseif ($deptData && isset($deptData->department)) {
                                                                            echo $deptData->department;
                                                                        } else {
                                                                            echo 'Administration';
                                                                        }
                                                                    ?>
                                                                <?php else: ?>
                                                                    <?php echo e($update->user->department ?? 'Administration'); ?>

                                                                <?php endif; ?>
                                                            )</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <small class="text-muted me-2">
                                                                <i class="fas fa-clock"></i> <?php echo e($update->update_date->format('M d, Y H:i')); ?>

                                                            </small>
                                                            <?php if((auth()->user()->role == 1) || (auth()->user()->role == 4) || (auth()->user()->id == $update->user_id)): ?>
                                                                <form action="<?php echo e(route('project-updates.destroy', $update->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this work update?');" style="display: inline;">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="update-points">
                                                        <?php
                                                            // Parse update points from JSON or individual columns
                                                            $updatePoint3 = $update->update_point_3;
                                                            $isJson = false;
                                                            $allPoints = [];
                                                            
                                                            if (!empty($updatePoint3)) {
                                                                $decoded = json_decode($updatePoint3, true);
                                                                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                                                    $isJson = true;
                                                                    $allPoints = $decoded;
                                                                }
                                                            }
                                                           
                                                            // Collect all tasks in an array
                                                            $allTasks = [];
                                                            
                                                            if ($isJson) {
                                                                // Display all points from JSON
                                                                foreach ($allPoints as $index => $point) {
                                                                    if (!empty(trim($point))) {
                                                                        $cleanPoint = str_replace(' - Status:', ' -', e($point));
                                                                        $allTasks[] = $cleanPoint;
                                                                    }
                                                                }
                                                            } else {
                                                                // Display individual points (backward compatibility)
                                                                if (!empty($update->update_point_1)) {
                                                                    $cleanPoint = str_replace(' - Status:', ' -', e($update->update_point_1));
                                                                    $allTasks[] = $cleanPoint;
                                                                }
                                                                if (!empty($update->update_point_2)) {
                                                                    $cleanPoint = str_replace(' - Status:', ' -', e($update->update_point_2));
                                                                    $allTasks[] = $cleanPoint;
                                                                }
                                                                if (!empty($update->update_point_3)) {
                                                                    $cleanPoint = str_replace(' - Status:', ' -', e($update->update_point_3));
                                                                    $allTasks[] = $cleanPoint;
                                                                }
                                                            }
                                                            
                                                            // Display all tasks in a single container
                                                            if (!empty($allTasks)) {
                                                                echo '<div class="task-container">';
                                                                foreach ($allTasks as $task) {
                                                                    echo '<div class="task-item">' . $task . '</div>';
                                                                }
                                                                echo '</div>';
                                                            }
                                                        ?>
                                                    </div>
                                                    
                                                    <!-- Attachment Display for Work Updates -->
                                                    <?php if(!empty($update->attachment)): ?>
                                                        <div class="attachment mt-3 pt-2 border-top">
                                                            <small class="text-muted">
                                                                <i class="fas fa-paperclip"></i> 
                                                                <strong>Attachment:</strong>
                                                                <a href="<?php echo e(route('attachments.view', basename($update->attachment))); ?>" target="_blank" class="btn btn-sm btn-outline-info ms-2">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                                <a href="<?php echo e(route('attachments.public.download', basename($update->attachment))); ?>" class="btn btn-sm btn-outline-primary ms-1">
                                                                    <i class="fas fa-download"></i> Download
                                                                </a>
                                                            </small>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <div class="text-center text-muted py-4">
                                                    <i class="fas fa-tools fa-3x mb-3 d-block"></i>
                                                    No work updates yet.
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Resizable Divider -->
                                        <div class="resizable-divider" style="width: 8px; background: #f8f9fa; cursor: col-resize; position: relative; display: flex; align-items: center; justify-content: center; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6;">
                                            <button class="resize-handle-btn" style="background: #6c757d; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: col-resize; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                                <i class="fas fa-grip-lines-vertical"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Right Column - Request Updates -->
                                        <div id="requestUpdatesColumn" class="request-updates-column" style="width: calc(50% - 8px); overflow-y: auto; padding: 20px;">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="text-warning mb-0">
                                                    <i class="fas fa-comment-dots"></i> Request Updates
                                                </h6>
                                                <?php if((auth()->user()->role == 3) || (auth()->user()->role == 1)): ?>
                                                    <button type="button" class="btn btn-secondary btn-sm" onclick="showRequestUpdateModal()">
                                                        <i class="fas fa-plus"></i> Request Updates
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <?php $__empty_1 = true; $__currentLoopData = $requestUpdates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $update): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <div class="update-item mb-3 p-3 border rounded bg-light" style="border-left: 4px solid #ffc107;">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <strong>Requested by:</strong> <?php echo e($update->user->name); ?>

                                                            <span class="text-muted">(
                                                                <?php if(isset($update->user->department) && is_object($update->user->department)): ?>
                                                                    <?php echo e($update->user->department->name ?? 'Customer'); ?>

                                                                <?php elseif(isset($update->user->department) && is_string($update->user->department)): ?>
                                                                    <?php
                                                                        $deptData = json_decode($update->user->department);
                                                                        if ($deptData && isset($deptData->name)) {
                                                                            echo $deptData->name;
                                                                        } elseif ($deptData && isset($deptData->department)) {
                                                                            echo $deptData->department;
                                                                        } else {
                                                                            echo 'Customer';
                                                                        }
                                                                    ?>
                                                                <?php else: ?>
                                                                    <?php echo e($update->user->department ?? 'Customer'); ?>

                                                                <?php endif; ?>
                                                            )</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <small class="text-muted me-2">
                                                                <i class="fas fa-clock"></i> <?php echo e($update->update_date->format('M d, Y H:i')); ?>

                                                            </small>
                                                            <?php if((auth()->user()->role == 1) || (auth()->user()->role == 4) || (auth()->user()->id == $update->user_id)): ?>
                                                                <form action="<?php echo e(route('project-updates.destroy', $update->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this request update?');" style="display: inline;">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="update-points">
                                                        <?php
                                                            // Display request text (stored as full text)
                                                            $requestText = $update->request_text;
                                                            if (!empty($requestText)) {
                                                                $lines = explode("\n", $requestText);
                                                                foreach ($lines as $index => $line) {
                                                                    $cleanLine = trim($line);
                                                                    if (!empty($cleanLine)) {
                                                                        echo '<div class="mb-2"><strong>' . ($index + 1) . '.</strong> ' . e($cleanLine) . '</div>';
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                    
                                                    <!-- Task Due Date and Priority Display -->
                                                    <?php if(!empty($update->task_due_date) || !empty($update->task_priority)): ?>
                                                        <div class="task-meta mt-3 pt-2 border-top d-flex gap-3">
                                                            <?php if(!empty($update->task_due_date)): ?>
                                                                <div class="task-due-date">
                                                                    <small class="text-muted">
                                                                        <i class="fas fa-calendar-alt"></i> 
                                                                        <strong>Due:</strong> <?php echo e(\Carbon\Carbon::parse($update->task_due_date)->format('M d, Y')); ?>

                                                                    </small>
                                                                </div>
                                                            <?php endif; ?>
                                                            <?php if(!empty($update->task_priority)): ?>
                                                                <div class="task-priority">
                                                                    <small class="badge bg-<?php echo e($update->task_priority == 'urgent' ? 'danger' : ($update->task_priority == 'high' ? 'warning' : ($update->task_priority == 'medium' ? 'info' : 'success'))); ?>">
                                                                        <?php echo e(strtoupper($update->task_priority)); ?>

                                                                    </small>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <!-- Attachment Display -->
                                                    <?php if(!empty($update->attachment)): ?>
                                                        <div class="attachment mt-3 pt-2 border-top">
                                                            <small class="text-muted">
                                                                <i class="fas fa-paperclip"></i> 
                                                                <strong>Attachment:</strong>
                                                                <a href="<?php echo e(route('attachments.view', basename($update->attachment))); ?>" target="_blank" class="btn btn-sm btn-outline-info ms-2">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                                <a href="<?php echo e(route('attachments.public.download', basename($update->attachment))); ?>" class="btn btn-sm btn-outline-primary ms-1">
                                                                    <i class="fas fa-download"></i> Download
                                                                </a>
                                                            </small>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <!-- Done Button for Employee, Manager, Admin -->
                                                    <?php if((auth()->user()->role == 2) || (auth()->user()->role == 4) || (auth()->user()->role == 1)): ?>
                                                        <div class="mt-2 text-end">
                                                            <button type="button" class="btn btn-success btn-sm" onclick="showWorkUpdateModalWithTasks(<?php echo e($update->id); ?>)">
                                                                <i class="fas fa-check"></i> Done
                                                            </button>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <div class="text-center text-muted py-4">
                                                    <i class="fas fa-comment-dots fa-3x mb-3 d-block"></i>
                                                    No request updates yet.
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Work Update Simple Modal -->
<div id="workUpdateModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; opacity: 0; visibility: hidden; transition: all 0.3s ease;">
    <div style="position: relative; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; max-width: 500px; width: 90%; max-height: 70vh; overflow-y: auto; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); border: 1px solid #e5e7eb;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px;">
            <h5 style="margin: 0; color: #212529; font-size: 1.1rem; font-weight: 600;">Work Update</h5>
            <button type="button" onclick="hideWorkUpdateModal()" style="background: none; border: none; font-size: 1.2rem; color: #6b7280; cursor: pointer; padding: 0; line-height: 1;">&times;</button>
        </div>
        
        <!-- Default Work Update Form -->
        <div id="defaultWorkUpdateForm">
            <form action="<?php echo e(route('project-updates.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($invoice->id); ?>">
                <input type="hidden" name="form_source" value="work">
                <div class="mb-3">
                    <label for="workUpdateText" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 5px; display: block; font-size: 0.9rem;">Work Updates *</label>
                    <textarea class="form-control" id="workUpdateText" name="update_text" rows="4" required 
                              placeholder="1. "
                              style="border: 1px solid #ced4da; border-radius: 6px; padding: 8px; font-size: 0.9rem; line-height: 1.4; resize: vertical; min-height: 80px;"
                              onfocus="initializeNumbering(this)"
                              onkeydown="handleKeydown(event, this)"></textarea>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 15px;">
                    <button type="button" onclick="hideWorkUpdateModal()" style="padding: 8px 16px; border: 1px solid #6b7280; background: white; color: #6b7280; border-radius: 4px; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease;">Cancel</button>
                    <button type="submit" style="padding: 8px 16px; border: none; background: #667eea; color: white; border-radius: 4px; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease;">Submit Update</button>
                </div>
            </form>
        </div>
        
        <!-- Task-based Update Form (hidden by default) -->
        <div id="taskBasedUpdateForm" style="display: none;">
            <form id="taskStatusForm" action="<?php echo e(route('project-updates.update-status')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="taskUpdateId" name="task_update_id" value="">
                
                <div class="mb-3">
                    <h6 class="text-primary mb-3" style="font-size: 0.95rem;">Task Status Updates</h6>
                    <div id="taskListContainer" style="max-height: 40vh; overflow-y: auto;">
                        <!-- Tasks will be dynamically added here -->
                    </div>
                </div>
                
                                
                <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 15px;">
                    <button type="button" onclick="hideWorkUpdateModal()" style="padding: 8px 16px; border: 1px solid #6b7280; background: white; color: #6b7280; border-radius: 4px; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease;">Cancel</button>
                    <button type="submit" style="padding: 8px 16px; border: none; background: #28a745; color: white; border-radius: 4px; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease;">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Request Update Simple Modal -->
<div id="requestUpdateModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; opacity: 0; visibility: hidden; transition: all 0.3s ease;">
    <div style="position: relative; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 25px; border-radius: 12px; max-width: 650px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); border: 1px solid #e5e7eb;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e5e7eb; padding-bottom: 15px;">
            <h5 style="margin: 0; color: #212529; font-size: 1.25rem; font-weight: 600;">Request Update</h5>
            <button type="button" onclick="hideRequestUpdateModal()" style="background: none; border: none; font-size: 1.5rem; color: #6b7280; cursor: pointer; padding: 0; line-height: 1;">&times;</button>
        </div>
        <form action="<?php echo e(route('project-updates.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="product_id" value="<?php echo e($invoice->id); ?>">
            <input type="hidden" name="form_source" value="request">
            <div class="mb-3">
                <label for="requestUpdateText" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 8px; display: block;">Update Requests *</label>
                <textarea class="form-control" id="requestUpdateText" name="update_text" rows="6" required 
                          placeholder="1. "
                          style="border: 1px solid #ced4da; border-radius: 6px; padding: 12px; font-size: 1rem; line-height: 1.5; resize: vertical; min-height: 120px;"
                          onfocus="initializeNumbering(this)"
                          onkeydown="handleKeydown(event, this)"></textarea>
            </div>
            
            <!-- Task Due Date and Priority Options -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="taskDueDate" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 8px; display: block;">Task Due Date</label>
                        <input type="date" class="form-control" id="taskDueDate" name="task_due_date" 
                               style="border: 1px solid #ced4da; border-radius: 6px; padding: 12px; font-size: 1rem;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="taskPriority" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 8px; display: block;">Priority</label>
                        <select class="form-control" id="taskPriority" name="task_priority" 
                                style="border: 1px solid #ced4da; border-radius: 6px; padding: 12px; font-size: 1rem;">
                            <option value="">Select Priority</option>
                            <option value="urgent">🔴 Urgent</option>
                            <option value="high">🟠 High</option>
                            <option value="medium">🟡 Medium</option>
                            <option value="low">🟢 Low</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Attachment File -->
            <div class="mb-3">
                <label for="attachment" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 8px; display: block;">
                    <i class="fas fa-paperclip"></i> Attachment (Optional)
                </label>
                <input type="file" class="form-control" id="attachment" name="attachment" 
                       accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.zip,.rar"
                       style="border: 1px solid #ced4da; border-radius: 6px; padding: 12px; font-size: 1rem;">
                <small class="text-muted">Allowed formats: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, GIF, ZIP, RAR (Max 10MB)</small>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="hideRequestUpdateModal()" style="padding: 10px 20px; border: 1px solid #6b7280; background: white; color: #6b7280; border-radius: 6px; cursor: pointer; font-size: 1rem; transition: all 0.2s ease;">Cancel</button>
                <button type="submit" style="padding: 10px 20px; border: none; background: #667eea; color: white; border-radius: 6px; cursor: pointer; font-size: 1rem; transition: all 0.2s ease;">Submit Request</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Fix Modal Styling Issues */
.modal {
    z-index: 1050 !important;
}

.modal-backdrop {
    z-index: 1040 !important;
    background-color: rgba(0, 0, 0, 0.5) !important;
}

.modal-content {
    background-color: white !important;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    border-radius: 0.375rem 0.375rem 0 0;
}

.modal-body {
    background-color: white !important;
    color: #212529 !important;
}

.modal-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
    border-radius: 0 0 0.375rem 0.375rem;
}

.form-control {
    background-color: white !important;
    color: #212529 !important;
    border: 1px solid #ced4da;
}

.form-control:focus {
    background-color: white !important;
    color: #212529 !important;
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Simple Modal Styles */
#simpleModal {
    background: rgba(0, 0, 0, 0.5) !important;
}

#simpleModal > div {
    background: white !important;
    color: #212529 !important;
    border: 1px solid #dee2e6;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

/* Resizable Layout Styles */
.updates-container {
    min-height: 500px;
    border: 1px solid #dee2e6;
}

.work-updates-column,
.request-updates-column {
    transition: width 0.1s ease-out;
}

.resizable-divider {
    transition: background-color 0.2s ease;
    flex-shrink: 0;
}

.resize-handle-btn {
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.resize-handle-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.resize-handle-btn:active {
    transform: scale(0.95);
}

/* Update item styling */
.update-item {
    transition: all 0.2s ease;
    border-left: 3px solid transparent !important;
}

.update-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.work-updates-column .update-item:hover {
    border-left-color: #0d6efd !important;
}

.request-updates-column .update-item:hover {
    border-left-color: #ffc107 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .updates-container {
        flex-direction: column;
        height: auto !important;
    }
    
    .work-updates-column,
    .request-updates-column {
        width: 100% !important;
        border-right: none !important;
        border-bottom: 1px solid #dee2e6;
        min-height: 300px;
    }
    
    .resizable-divider {
        width: 100% !important;
        height: 8px !important;
        cursor: row-resize !important;
        border-left: none !important;
        border-right: none !important;
        border-top: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
        flex-direction: row !important;
    }
    
    .resize-handle-btn {
        transform: rotate(90deg);
    }
    
    .resize-handle-btn i {
        transform: rotate(90deg);
    }
}

/* Scrollbar styling */
.work-updates-column::-webkit-scrollbar,
.request-updates-column::-webkit-scrollbar {
    width: 6px;
}

.work-updates-column::-webkit-scrollbar-track,
.request-updates-column::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.work-updates-column::-webkit-scrollbar-thumb,
.request-updates-column::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.work-updates-column::-webkit-scrollbar-thumb:hover,
.request-updates-column::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Task item alignment */
.task-container {
    background: transparent;
    border: none;
    border-radius: 0;
    padding: 0;
    margin-top: 5px;
}

.task-item {
    line-height: 1.4;
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: pre-wrap;
    padding: 3px 0;
    border-bottom: none;
    margin-bottom: 2px;
}

.task-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
    margin-bottom: 0;
}

.task-item:first-child {
    padding-top: 0;
}

.task-item strong {
    color: #495057;
    font-weight: 600;
}
</style>

<!-- Simple Inline Modal (Alternative to Bootstrap Modal) -->
<div id="simpleModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; opacity: 0; visibility: hidden; transition: all 0.3s ease;">
    <div style="position: relative; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 25px; border-radius: 12px; max-width: 650px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); border: 1px solid #e5e7eb;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e5e7eb; padding-bottom: 15px;">
            <h5 style="margin: 0; color: #212529; font-size: 1.25rem; font-weight: 600;">Quick Update</h5>
            <button type="button" onclick="hideSimpleModal()" style="background: none; border: none; font-size: 1.5rem; color: #6b7280; cursor: pointer; padding: 0; line-height: 1;">&times;</button>
        </div>
        <form action="<?php echo e(route('project-updates.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="product_id" value="<?php echo e($invoice->id); ?>">
            <div class="mb-3">
                <label for="simpleUpdateText" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 8px; display: block;">Update Details *</label>
                <textarea class="form-control" id="simpleUpdateText" name="update_text" rows="6" required 
                          placeholder="1. "
                          style="border: 1px solid #ced4da; border-radius: 6px; padding: 12px; font-size: 1rem; line-height: 1.5; resize: vertical; min-height: 120px;"
                          onfocus="initializeNumbering(this)"
                          onkeydown="handleKeydown(event, this)"></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="hideSimpleModal()" style="padding: 10px 20px; border: 1px solid #6b7280; background: white; color: #6b7280; border-radius: 6px; cursor: pointer; font-size: 1rem; transition: all 0.2s ease;">Cancel</button>
                <button type="submit" style="padding: 10px 20px; border: none; background: #667eea; color: white; border-radius: 6px; cursor: pointer; font-size: 1rem; transition: all 0.2s ease;">Submit Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Simple JavaScript to ensure modal works -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, initializing modals...');
    
    // Fix any existing modal backdrop issues
    setTimeout(function() {
        // Remove any leftover modal backdrops
        document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
            backdrop.remove();
        });
        
        // Reset body classes
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }, 100);
    
    // Initialize resizable divider functionality
    initializeResizableDivider();
    
    // Initialize all modals with proper configuration
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        var bsModal = new bootstrap.Modal(modal, {
            backdrop: true,
            keyboard: true,
            focus: true
        });
        
        // Store bootstrap modal instance
        modal.bsModal = bsModal;
        
        // Ensure proper z-index when modal is shown
        modal.addEventListener('shown.bs.modal', function () {
            console.log('Modal shown:', modal.id);
            
            // Find and fix backdrop
            var backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.style.zIndex = '1040';
                backdrop.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            }
            
            // Fix modal z-index
            modal.style.zIndex = '1050';
            
            // Focus on textarea and initialize numbering
            var textarea = modal.querySelector('textarea');
            if (textarea) {
                setTimeout(function() {
                    textarea.focus();
                    initializeNumbering(textarea);
                }, 200);
            }
        });
        
        // Clean up when modal is hidden
        modal.addEventListener('hidden.bs.modal', function () {
            console.log('Modal hidden:', modal.id);
            
            // Remove backdrop
            var backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            
            // Reset body
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });
    });
    
    // Manual modal opening function for testing
    window.openModalManually = function() {
        console.log('Opening modal manually...');
        var modalElement = document.getElementById('requestUpdateModal');
        if (modalElement && modalElement.bsModal) {
            modalElement.bsModal.show();
        }
    };
    
    // Simple modal functions
    window.showSimpleModal = function() {
        console.log('Showing simple modal...');
        var modal = document.getElementById('simpleModal');
        if (modal) {
            // Show modal with fade-in effect
            modal.style.display = 'block';
            setTimeout(function() {
                modal.style.opacity = '1';
                modal.style.visibility = 'visible';
            }, 10);
            
            var textarea = document.getElementById('simpleUpdateText');
            if (textarea) {
                setTimeout(function() {
                    textarea.focus();
                    initializeNumbering(textarea);
                }, 300);
            }
        }
    };
    
    window.hideSimpleModal = function() {
        console.log('Hiding simple modal...');
        var modal = document.getElementById('simpleModal');
        if (modal) {
            modal.style.display = 'none';
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
        }
    };
    
    // Work Update modal functions
    window.showWorkUpdateModal = function() {
        console.log('Showing work update modal...');
        var modal = document.getElementById('workUpdateModal');
        if (modal) {
            // Show default form
            document.getElementById('defaultWorkUpdateForm').style.display = 'block';
            document.getElementById('taskBasedUpdateForm').style.display = 'none';
            
            // Show modal with fade-in effect
            modal.style.display = 'block';
            setTimeout(function() {
                modal.style.opacity = '1';
                modal.style.visibility = 'visible';
            }, 10);
            
            var textarea = document.getElementById('workUpdateText');
            if (textarea) {
                setTimeout(function() {
                    textarea.focus();
                    initializeNumbering(textarea);
                }, 300);
            }
        }
    };
    
    // New function to show work update modal with specific tasks
    window.showWorkUpdateModalWithTasks = function(updateId) {
        console.log('Showing work update modal with tasks for update ID:', updateId);
        var modal = document.getElementById('workUpdateModal');
        if (modal) {
            // Hide default form and show task-based form
            document.getElementById('defaultWorkUpdateForm').style.display = 'none';
            document.getElementById('taskBasedUpdateForm').style.display = 'block';
            
            // Set the update ID
            document.getElementById('taskUpdateId').value = updateId;
            
            // Load tasks for this update
            loadTasksForUpdate(updateId);
            
            // Show modal with fade-in effect
            modal.style.display = 'block';
            setTimeout(function() {
                modal.style.opacity = '1';
                modal.style.visibility = 'visible';
            }, 10);
        }
    };
    
    // Function to load tasks for a specific update
    function loadTasksForUpdate(updateId) {
        // Find the update data from the page
        var updateData = <?php echo json_encode($requestUpdates, 15, 512) ?>;
        var targetUpdate = updateData.find(function(update) {
            return update.id == updateId;
        });
        
        if (targetUpdate) {
            var taskContainer = document.getElementById('taskListContainer');
            taskContainer.innerHTML = '';
            
            // Parse the request text into individual tasks
            var requestText = targetUpdate.request_text;
            if (requestText) {
                var lines = requestText.split('\n');
                var taskIndex = 0;
                
                lines.forEach(function(line) {
                    var cleanLine = line.trim();
                    if (cleanLine) {
                        taskIndex++;
                        // Extract task number and description
                        var taskMatch = cleanLine.match(/^(\d+)\.\s*(.+)$/);
                        var taskNumber = taskMatch ? taskMatch[1] : taskIndex;
                        var taskDescription = taskMatch ? taskMatch[2] : cleanLine;
                        
                        // Create compact task element with status dropdown
                        var taskElement = document.createElement('div');
                        taskElement.className = 'task-item-modal';
                        taskElement.style.cssText = 'padding: 8px 0; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;';
                        taskElement.innerHTML = `
                            <div style="flex-grow-1; font-size: 0.85rem; line-height: 1.3;">
                                <strong>${taskNumber}.</strong> ${taskDescription}
                            </div>
                            <div style="margin-left: 10px;">
                                <select name="task_status_${taskIndex}" class="form-select form-select-sm" style="width: auto; font-size: 0.8rem; padding: 4px 8px;">
                                    <option value="pending">Pending</option>
                                    <option value="working">Working</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        `;
                        taskContainer.appendChild(taskElement);
                    }
                });
                
                // Add hidden input for task count
                var taskCountInput = document.createElement('input');
                taskCountInput.type = 'hidden';
                taskCountInput.name = 'task_count';
                taskCountInput.value = taskIndex;
                taskContainer.appendChild(taskCountInput);
            }
        }
    }
    
    window.hideWorkUpdateModal = function() {
        console.log('Hiding work update modal...');
        var modal = document.getElementById('workUpdateModal');
        if (modal) {
            modal.style.display = 'none';
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
        }
    };
    
    // Request Update modal functions
    window.showRequestUpdateModal = function() {
        console.log('Showing request update modal...');
        var modal = document.getElementById('requestUpdateModal');
        if (modal) {
            // Show modal with fade-in effect
            modal.style.display = 'block';
            setTimeout(function() {
                modal.style.opacity = '1';
                modal.style.visibility = 'visible';
            }, 10);
            
            var textarea = document.getElementById('requestUpdateText');
            if (textarea) {
                setTimeout(function() {
                    textarea.focus();
                    initializeNumbering(textarea);
                }, 300);
            }
        }
    };
    
    window.hideRequestUpdateModal = function() {
        console.log('Hiding request update modal...');
        var modal = document.getElementById('requestUpdateModal');
        if (modal) {
            modal.style.display = 'none';
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
        }
    };
    
    // Close simple modal when clicking outside
    document.getElementById('simpleModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideSimpleModal();
        }
    });
    
    // Close work update modal when clicking outside
    document.getElementById('workUpdateModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideWorkUpdateModal();
        }
    });
    
    // Close request update modal when clicking outside
    document.getElementById('requestUpdateModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideRequestUpdateModal();
        }
    });
    
    // Close any modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideSimpleModal();
            hideWorkUpdateModal();
            hideRequestUpdateModal();
        }
    });
    
    // Fix form submissions
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submitting...');
            
            // Handle task status form with AJAX
            if (form.id === 'taskStatusForm') {
                e.preventDefault();
                
                var formData = new FormData(form);
                var submitButton = form.querySelector('button[type="submit"]');
                var originalText = submitButton.innerHTML;
                
                // Show loading state
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                submitButton.disabled = true;
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        alert(data.message);
                        hideWorkUpdateModal();
                        // Reload page to show updated status
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to update task status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating task status');
                })
                .finally(() => {
                    // Reset button state
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                });
                
                return false;
            }
            
            // Let other forms submit normally (including delete forms)
        });
    });
});

// Resizable Divider Functionality
function initializeResizableDivider() {
    const container = document.querySelector('.updates-container');
    const divider = document.querySelector('.resizable-divider');
    const leftColumn = document.getElementById('workUpdatesColumn');
    const rightColumn = document.getElementById('requestUpdatesColumn');
    const resizeHandle = document.querySelector('.resize-handle-btn');
    
    if (!container || !divider || !leftColumn || !rightColumn || !resizeHandle) {
        console.log('Resizable divider elements not found');
        return;
    }
    
    let isResizing = false;
    let startX = 0;
    let startLeftWidth = 0;
    
    // Mouse down on divider or handle
    function startResize(e) {
        isResizing = true;
        startX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
        startLeftWidth = leftColumn.offsetWidth;
        
        // Add visual feedback
        divider.style.background = '#e9ecef';
        resizeHandle.style.background = '#495057';
        
        // Add global cursor style
        document.body.style.cursor = 'col-resize';
        document.body.style.userSelect = 'none';
        
        e.preventDefault();
    }
    
    // Mouse move
    function doResize(e) {
        if (!isResizing) return;
        
        const currentX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
        const deltaX = currentX - startX;
        const containerWidth = container.offsetWidth;
        
        // Calculate new left column width (in pixels)
        let newLeftWidth = startLeftWidth + deltaX;
        
        // Constrain to minimum and maximum widths (20% to 80% of container)
        const minWidth = containerWidth * 0.2;
        const maxWidth = containerWidth * 0.8;
        
        newLeftWidth = Math.max(minWidth, Math.min(maxWidth, newLeftWidth));
        
        // Calculate percentage
        const leftPercentage = (newLeftWidth / containerWidth) * 100;
        const rightPercentage = 100 - leftPercentage - (divider.offsetWidth / containerWidth) * 100;
        
        // Apply new widths
        leftColumn.style.width = leftPercentage + '%';
        rightColumn.style.width = rightPercentage + '%';
        
        // Store the current split ratio in localStorage for persistence
        localStorage.setItem('updatesSplitRatio', leftPercentage);
    }
    
    // Mouse up
    function stopResize() {
        if (!isResizing) return;
        
        isResizing = false;
        
        // Remove visual feedback
        divider.style.background = '#f8f9fa';
        resizeHandle.style.background = '#6c757d';
        
        // Remove global cursor style
        document.body.style.cursor = '';
        document.body.style.userSelect = '';
    }
    
    // Event listeners
    resizeHandle.addEventListener('mousedown', startResize);
    divider.addEventListener('mousedown', startResize);
    
    document.addEventListener('mousemove', doResize);
    document.addEventListener('mouseup', stopResize);
    
    // Touch events for mobile
    resizeHandle.addEventListener('touchstart', startResize);
    divider.addEventListener('touchstart', startResize);
    
    document.addEventListener('touchmove', doResize);
    document.addEventListener('touchend', stopResize);
    
    // Restore saved split ratio if exists
    const savedRatio = localStorage.getItem('updatesSplitRatio');
    if (savedRatio) {
        const leftPercentage = parseFloat(savedRatio);
        const rightPercentage = 100 - leftPercentage - (divider.offsetWidth / container.offsetWidth) * 100;
        
        leftColumn.style.width = leftPercentage + '%';
        rightColumn.style.width = rightPercentage + '%';
    }
    
    // Keyboard support
    document.addEventListener('keydown', function(e) {
        if (e.target === resizeHandle || divider.contains(e.target)) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                adjustWidth(-5); // Decrease left column by 5%
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                adjustWidth(5); // Increase left column by 5%
            }
        }
    });
    
    function adjustWidth(percentageChange) {
        const containerWidth = container.offsetWidth;
        const currentLeftWidth = leftColumn.offsetWidth;
        const newLeftWidth = currentLeftWidth + (containerWidth * percentageChange / 100);
        
        // Constrain to minimum and maximum widths
        const minWidth = containerWidth * 0.2;
        const maxWidth = containerWidth * 0.8;
        
        const finalWidth = Math.max(minWidth, Math.min(maxWidth, newLeftWidth));
        const leftPercentage = (finalWidth / containerWidth) * 100;
        const rightPercentage = 100 - leftPercentage - (divider.offsetWidth / containerWidth) * 100;
        
        leftColumn.style.width = leftPercentage + '%';
        rightColumn.style.width = rightPercentage + '%';
        
        localStorage.setItem('updatesSplitRatio', leftPercentage);
    }
    
    // Add hover effects
    divider.addEventListener('mouseenter', function() {
        if (!isResizing) {
            divider.style.background = '#e9ecef';
            resizeHandle.style.background = '#495057';
        }
    });
    
    divider.addEventListener('mouseleave', function() {
        if (!isResizing) {
            divider.style.background = '#f8f9fa';
            resizeHandle.style.background = '#6c757d';
        }
    });
    
    console.log('Resizable divider initialized successfully');
}

// Auto-numbering functions
function initializeNumbering(textarea) {
    // If textarea is empty, start with "1. "
    if (textarea.value.trim() === '') {
        textarea.value = '1. ';
        // Set cursor to end of line
        setCaretPosition(textarea, textarea.value.length);
    }
}

function handleKeydown(event, textarea) {
    // Handle Enter key for auto-numbering
    if (event.key === 'Enter') {
        var lines = textarea.value.split('\n');
        var currentLineIndex = textarea.value.substring(0, textarea.selectionStart).split('\n').length - 1;
        var currentLine = lines[currentLineIndex];
        
        // Only auto-number if current line is empty or just has a number (with or without text)
        if (currentLine.trim() === '' || currentLine.match(/^\d+\.\s*(.*)$/)) {
            event.preventDefault();
            
            // Add new line with next number
            var nextNumber = currentLineIndex + 2;
            var newLine = '\n' + nextNumber + '. ';
            
            // Insert new line
            var startPos = textarea.selectionStart;
            var endPos = textarea.selectionEnd;
            var value = textarea.value;
            
            textarea.value = value.substring(0, startPos) + newLine + value.substring(endPos);
            
            // Set cursor position after the new number
            var newCursorPos = startPos + newLine.length;
            setCaretPosition(textarea, newCursorPos);
        }
    }
}

function setCaretPosition(textarea, position) {
    textarea.setSelectionRange(position, position);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\nircrm\resources\views/project_updates/invoice_update.blade.php ENDPATH**/ ?>