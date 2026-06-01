<?php $__env->startSection('title'); ?>
    Create Menu Item - Admin Panel
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card">
                
                <div class="card-header">
                    <h3 class="card-title">Create Menu Item</h3>

                    <div class="card-tools">
                        <a href="<?php echo e(route('menu-controller.index')); ?>" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <form action="<?php echo e(route('menu-controller.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="card-body">

                        
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        
                        <div class="row">

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_name">
                                        Menu Name <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           class="form-control"
                                           id="menu_name"
                                           name="menu_name"
                                           value="<?php echo e(old('menu_name')); ?>"
                                           placeholder="Enter menu name"
                                           required>
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_url">
                                        Menu URL <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           class="form-control"
                                           id="menu_url"
                                           name="menu_url"
                                           value="<?php echo e(old('menu_url')); ?>"
                                           placeholder="e.g. attendance/dashboard"
                                           required>
                                </div>
                            </div>

                        </div>

                        
                        <div class="row">

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_icon">Menu Icon</label>

                                    <input type="text"
                                           class="form-control"
                                           id="menu_icon"
                                           name="menu_icon"
                                           value="<?php echo e(old('menu_icon')); ?>"
                                           placeholder="e.g. fas fa-home">

                                    <small class="text-muted">
                                        Enter Font Awesome icon class
                                    </small>
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_order">Menu Order</label>

                                    <input type="number"
                                           class="form-control"
                                           id="menu_order"
                                           name="menu_order"
                                           value="<?php echo e(old('menu_order', 0)); ?>"
                                           min="0">

                                    <small class="text-muted">
                                        Lower numbers appear first
                                    </small>
                                </div>
                            </div>

                        </div>

                        
                        <div class="row">

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role_id">
                                        Role <span class="text-danger">*</span>
                                    </label>

                                    <select class="form-control"
                                            id="role_id"
                                            name="role_id"
                                            required>

                                        <option value="">Select Role</option>

                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>"
                                                <?php echo e(old('role_id') == $id ? 'selected' : ''); ?>>
                                                <?php echo e($role); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_visible">Status</label>

                                    <select class="form-control"
                                            id="is_visible"
                                            name="is_visible">

                                        <option value="1"
                                            <?php echo e(old('is_visible', 1) == 1 ? 'selected' : ''); ?>>
                                            Active
                                        </option>

                                        <option value="0"
                                            <?php echo e(old('is_visible') == 0 ? 'selected' : ''); ?>>
                                            Inactive
                                        </option>

                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>

                    
                    <div class="card-footer">

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Menu Item
                        </button>

                        <a href="<?php echo e(route('menu-controller.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/menu-controller/create.blade.php ENDPATH**/ ?>