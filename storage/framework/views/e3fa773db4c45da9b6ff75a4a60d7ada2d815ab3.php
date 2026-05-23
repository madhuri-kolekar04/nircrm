

<?php $__env->startSection('page-title', 'Invoice Details'); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Invoice Details</h5>
                    <div class="btn-group">
                        <a href="<?php echo e(route('invoices.export.pdf', $invoice)); ?>" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                        <a href="<?php echo e(route('invoices.export.word', $invoice)); ?>" class="btn btn-success">
                            <i class="fas fa-file-word"></i> Export Word
                        </a>
                        <a href="<?php echo e(route('invoices.edit', $invoice)); ?>" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?php echo e(route('invoices.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
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
                        <div class="col-12">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-project-diagram"></i> Project Details
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td width="20%"><strong>Project Name:</strong></td>
                                        <td><?php echo e($invoice->project_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Project Topic:</strong></td>
                                        <td><?php echo e($invoice->project_topic); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Project Details:</strong></td>
                                        <td><?php echo e($invoice->project_full_details); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Start Date:</strong></td>
                                        <td><?php echo e($invoice->start_date->format('d-m-Y')); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>End Date:</strong></td>
                                        <td><?php echo e($invoice->end_date->format('d-m-Y')); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Department:</strong></td>
                                        <td><?php echo e($invoice->department); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                       <?php if((auth()->user()->position === 'Admin')|| (auth()->user()->role == 3)): ?>
                    <!-- Payment Details -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-rupee-sign"></i> Payment Details
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td width="20%"><strong>Advance Payment:</strong></td>
                                        <td class="text-end"><?php echo e($invoice->formatted_advance_payment); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Remaining Payment:</strong></td>
                                        <td class="text-end"><?php echo e($invoice->formatted_remaining_payment); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>GST:</strong></td>
                                        <td class="text-end"><?php echo e($invoice->formatted_gst); ?></td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td><strong>Total Payment:</strong></td>
                                        <td class="text-end"><strong><?php echo e($invoice->formatted_total_payment); ?></strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Installment Schedule -->
                    <?php if($invoice->installments && count($invoice->installments) > 0): ?>
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-calendar-alt"></i> Installment Schedule
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="25%">Amount</th>
                                            <th width="25%">Due Date</th>
                                            <th width="45%">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $invoice->installments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $installment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><strong><?php echo e($index + 1); ?></strong></td>
                                            <td>₹<?php echo e(number_format($installment['amount'], 2)); ?></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($installment['date'])->format('d-m-Y')); ?></td>
                                            <td><?php echo e($installment['notes'] ?: '-'); ?></td>
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
                                <i class="fas fa-info-circle"></i> 
                                Thank you for your business! Please make payment within 30 days.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/invoices/show.blade.php ENDPATH**/ ?>