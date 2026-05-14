

<?php $__env->startSection('page-title', 'Project Updates'); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Project Updates - Invoices (<?php echo e(Auth::user()->departmentgetname->department ?? 'No Department'); ?>)</h5>
                    <?php if(auth()->user()->role == 1): ?>
                    <a href="<?php echo e(route('employee-report.index')); ?>" class="btn btn-success">
                        <i class="fas fa-chart-bar"></i> Employee Report
                    </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Customer Name</th>
                                    <th>Project Name</th>
                                    <th>Department</th>
                                    <th>Total Payment</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><strong><?php echo e($invoice->invoice_number); ?></strong></td>
                                        <td><?php echo e($invoice->customer_name); ?></td>
                                        <td><?php echo e($invoice->project_name); ?></td>
                                        <td><?php echo e($invoice->department); ?></td>
                                        <td><?php echo e($invoice->formatted_total_payment); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo e($invoice->status == 'paid' ? 'success' : ($invoice->status == 'overdue' ? 'danger' : 'warning')); ?>">
                                                <?php echo e(ucfirst($invoice->status)); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($invoice->invoice_date->format('d-m-Y')); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('project-updates.show', $invoice->id)); ?>" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <a href="<?php echo e(route('project-updates.show', $invoice->id)); ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Update
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No invoices found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u314035009/domains/talktonitesh.com/public_html/nircrm/resources/views/project_updates/customer_invoices.blade.php ENDPATH**/ ?>