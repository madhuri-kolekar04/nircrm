

<?php $__env->startSection('page-title', 'Employees'); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Employees</h5>
                    <a href="<?php echo e(route('employees.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Employee
                    </a>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Department</th>
                                    <th>Position</th>
                                    <?php if(auth()->user()->role == 1): ?>
                                    <th>Role</th>
                                    <?php endif; ?>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($employee->name); ?></td>
                                        <td><?php echo e($employee->email); ?></td>
                                        <td><?php echo e($employee->contact_number); ?></td>
                                        <td>
                                            <?php if($employee->department): ?>
                                                <?php if(is_object($employee->department)): ?>
                                                    <?php echo e($employee->department->department ?? $employee->department->department_name ?? $employee->department->name ?? 'N/A'); ?>

                                                <?php else: ?>
                                                    <?php echo e($employee->department); ?>

                                                <?php endif; ?>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(isset($employee->position) ? $employee->position : 'N/A'); ?></td>
                                        <?php if(auth()->user()->role == 1): ?>
                                        <td>
                                            <?php switch($employee->role):
                                                case (1): ?>
                                                    <span class="badge bg-danger">Admin</span>
                                                    <?php break; ?>
                                                <?php case (2): ?>
                                                    <span class="badge bg-primary">Employee</span>
                                                    <?php break; ?>
                                                <?php case (3): ?>
                                                    <span class="badge bg-info">Customer</span>
                                                    <?php break; ?>
                                                <?php case (4): ?>
                                                    <span class="badge bg-warning">Manager</span>
                                                    <?php break; ?>
                                                <?php case (5): ?>
                                                    <span class="badge bg-success">CEO/General Manager</span>
                                                    <?php break; ?>
                                                <?php case (6): ?>
                                                    <span class="badge bg-secondary">Marketing</span>
                                                    <?php break; ?>
                                                <?php case (7): ?>
                                                    <span class="badge bg-secondary">Sales</span>
                                                    <?php break; ?>
                                                <?php case (8): ?>
                                                    <span class="badge bg-secondary">Account</span>
                                                    <?php break; ?>
                                                <?php default: ?>
                                                    <span class="badge bg-light text-dark">Unknown (<?php echo e($employee->role); ?>)</span>
                                            <?php endswitch; ?>
                                        </td>
                                        <?php endif; ?>
                                        <td>
                                            <?php if($employee->email_varified_at): ?>
                                                <span class="badge bg-success">Verified</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('employees.edit', $employee)); ?>" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="<?php echo e(route('employees.destroy', $employee)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this employee?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="<?php echo e(auth()->user()->role == 1 ? 9 : 8); ?>" class="text-center">No employees found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <?php echo e($employees->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/employees/index.blade.php ENDPATH**/ ?>