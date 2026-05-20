

<?php $__env->startSection('page-title', 'Verify OTP'); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Verify OTP</h5>
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
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        OTP has been sent to <strong><?php echo e($employeeData['email']); ?></strong>. 
                        Please check your email and enter the OTP below.
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Employee Details</h6>
                                    <p><strong>Name:</strong> <?php echo e($employeeData['name']); ?></p>
                                    <p><strong>Email:</strong> <?php echo e($employeeData['email']); ?></p>
                                    <p><strong>Phone:</strong> <?php echo e($employeeData['phone']); ?></p>
                                    <p><strong>Department:</strong> <?php echo e(is_string($employeeData['department']) ? $employeeData['department'] : 'N/A'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form action="<?php echo e(route('employees.verify-otp')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="otp" class="form-label">Enter OTP *</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="otp" name="otp" maxlength="6" pattern="[0-9]{6}" 
                                           placeholder="Enter 6-digit OTP" required autocomplete="off">
                                    <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="text-muted">OTP will expire in 10 minutes.</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <div>
                                <form action="<?php echo e(route('employees.resend-otp')); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-redo"></i> Resend OTP
                                    </button>
                                </form>
                            </div>
                            <div>
                                <a href="<?php echo e(route('employees.create')); ?>" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Verify & Create Account
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/employees/verify.blade.php ENDPATH**/ ?>