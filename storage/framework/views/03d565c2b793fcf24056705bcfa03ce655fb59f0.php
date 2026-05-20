<?php $__env->startSection('page-title', 'Invoice Details - View Only'); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-eye me-2"></i>Invoice Details (View Only)
                    </h5>
                    <div class="btn-group">
                        <?php if(auth()->user()->role == 1 || auth()->user()->role == 5): ?>
                            <a href="<?php echo e(route('invoices.export.pdf', $invoice)); ?>" class="btn btn-light btn-sm" target="_blank">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                            <a href="<?php echo e(route('invoices.export.word', $invoice)); ?>" class="btn btn-light btn-sm" target="_blank">
                                <i class="fas fa-file-word"></i> Word
                            </a>
                            <a href="<?php echo e(route('invoices.print', $invoice)); ?>" class="btn btn-light btn-sm" target="_blank">
                                <i class="fas fa-print"></i> Print
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('invoices.index')); ?>" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Invoice Header -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h4 class="text-primary">Niranjan Enterprises</h4>
                            <p class="mb-1">Help Desk Management System</p>
                            <p class="mb-1">Invoice Number: <strong><?php echo e($invoice->invoice_number); ?></strong></p>
                            <p class="mb-1">Invoice Date: <strong><?php echo e($invoice->invoice_date->format('d-m-Y')); ?></strong></p>
                            <p class="mb-1">Status: 
                                <span class="badge bg-<?php echo e($invoice->status == 'paid' ? 'success' : ($invoice->status == 'overdue' ? 'danger' : 'warning')); ?>">
                                    <?php echo e(ucfirst($invoice->status)); ?>

                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5 class="text-primary">Bill To:</h5>
                            <p class="mb-1"><strong><?php echo e($invoice->customer_name); ?></strong></p>
                            <p class="mb-1"><?php echo e($invoice->customer_email); ?></p>
                            <p class="mb-1"><?php echo e($invoice->customer_phone); ?></p>
                            <p class="mb-1"><?php echo e($invoice->customer_address); ?></p>
                        </div>
                    </div>
                    
                    <!-- Project Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary">Project Information</h6>
                            <p class="mb-1"><strong>Project Name:</strong> <?php echo e($invoice->project_name ?? 'N/A'); ?></p>
                            <p class="mb-1"><strong>Project Topic:</strong> <?php echo e($invoice->project_topic ?? 'N/A'); ?></p>
                            <p class="mb-1"><strong>Department:</strong> <?php echo e($invoice->department_name ?? 'N/A'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Project Timeline</h6>
                            <p class="mb-1"><strong>Start Date:</strong> <?php echo e($invoice->start_date ? $invoice->start_date->format('d-m-Y') : 'N/A'); ?></p>
                            <p class="mb-1"><strong>End Date:</strong> <?php echo e($invoice->end_date ? $invoice->end_date->format('d-m-Y') : 'N/A'); ?></p>
                            <p class="mb-1"><strong>Duration:</strong> 
                                <?php if($invoice->start_date && $invoice->end_date): ?>
                                    <?php echo e($invoice->start_date->diffInDays($invoice->end_date)); ?> days
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Project Full Details -->
                    <?php if($invoice->project_full_details): ?>
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary">Project Full Details</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0"><?php echo e(nl2br($invoice->project_full_details)); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Payment Details -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h6 class="text-primary">Payment Breakdown</h6>
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Description</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Advance Payment</td>
                                        <td class="text-end">₹<?php echo e(number_format($invoice->advance_payment, 2)); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Remaining Payment</td>
                                        <td class="text-end">₹<?php echo e(number_format($invoice->remaining_payment, 2)); ?></td>
                                    </tr>
                                    <?php if($invoice->gst > 0): ?>
                                    <tr>
                                        <td>GST (18%)</td>
                                        <td class="text-end">₹<?php echo e(number_format($invoice->gst, 2)); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr class="table-primary fw-bold">
                                        <td>Total Amount</td>
                                        <td class="text-end">₹<?php echo e(number_format($invoice->total_payment, 2)); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-primary">Payment Status</h6>
                            <div class="card bg-<?php echo e($invoice->status == 'paid' ? 'success' : ($invoice->status == 'overdue' ? 'danger' : 'warning')); ?> text-white">
                                <div class="card-body text-center">
                                    <h4 class="mb-2"><?php echo e(ucfirst($invoice->status)); ?></h4>
                                    <p class="mb-0">
                                        <?php if($invoice->status == 'paid'): ?>
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        <?php elseif($invoice->status == 'overdue'): ?>
                                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                                        <?php else: ?>
                                            <i class="fas fa-clock fa-2x"></i>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Installments Details -->
                    <?php if($invoice->installments && is_array($invoice->installments) && count($invoice->installments) > 0): ?>
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary">Installment Schedule</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Installment #</th>
                                            <th>Due Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Payment Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $invoice->installments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $installment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($index + 1); ?></td>
                                            <td><?php echo e($installment['due_date'] ?? 'N/A'); ?></td>
                                            <td>₹<?php echo e(number_format($installment['amount'] ?? 0, 2)); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e(($installment['status'] ?? 'pending') == 'paid' ? 'success' : 'warning'); ?>">
                                                    <?php echo e(ucfirst($installment['status'] ?? 'pending')); ?>

                                                </span>
                                            </td>
                                            <td><?php echo e($installment['payment_date'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Footer -->
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Note:</strong> This is a view-only invoice. To make changes, please contact the administrator.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/invoices/view_only.blade.php ENDPATH**/ ?>