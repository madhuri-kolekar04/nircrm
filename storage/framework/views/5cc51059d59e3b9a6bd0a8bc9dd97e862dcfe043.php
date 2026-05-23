<?php $__env->startSection('page-title', 'Shift Management'); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-clock"></i> Shift Management
                        <a href="<?php echo e(route('shifts.create')); ?>" class="btn btn-sm btn-success float-right">
                            <i class="fas fa-plus"></i> Add New Shift
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Shift Creation Settings Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-cog"></i> Quick Shift Creation</h5>
                                </div>
                                <div class="card-body">
                                    <form id="quickShiftForm" class="row g-3">
                                        <?php echo csrf_field(); ?>
                                        <div class="col-md-3">
                                            <label for="shift_name" class="form-label">Shift Name</label>
                                            <input type="text" class="form-control" id="shift_name" name="name" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="start_time" class="form-label">Start Time</label>
                                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="end_time" class="form-label">End Time</label>
                                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="grace_period" class="form-label">Grace Period (min)</label>
                                            <input type="number" class="form-control" id="grace_period" name="grace_period_minutes" value="15" min="0" max="60" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="shift_description" class="form-label">Description</label>
                                            <input type="text" class="form-control" id="shift_description" name="description" placeholder="Optional description">
                                        </div>
                                        <div class="col-md-1">
                                            <label class="form-label">&nbsp;</label>
                                            <div>
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-save"></i> Create
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Shifts Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Shift Name</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Grace Period</th>
                                    <th>Duration</th>
                                    <th>Assigned Users</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($shift->name); ?></strong>
                                            <?php if($shift->description): ?>
                                                <br><small class="text-muted"><?php echo e($shift->description); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($shift->start_time->format('H:i')); ?></td>
                                        <td><?php echo e($shift->end_time->format('H:i')); ?></td>
                                        <td><?php echo e($shift->grace_period_minutes); ?> minutes</td>
                                        <td><?php echo e($shift->getShiftDurationHours()); ?> hours</td>
                                        <td>
                                            <span class="badge badge-info"><?php echo e($shift->users->count()); ?></span>
                                            <?php if($shift->users->count() > 0): ?>
                                                <br><small class="text-muted">Click to view users</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?php echo e($shift->is_active ? 'success' : 'danger'); ?>">
                                                <?php echo e($shift->is_active ? 'Active' : 'Inactive'); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('shifts.edit', $shift)); ?>" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <?php if($shift->users->count() == 0): ?>
                                                    <form action="<?php echo e(route('shifts.destroy', $shift)); ?>" method="POST" style="display: inline;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this shift?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- User Assignment Section -->
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-users"></i> User Shift Assignment</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Position</th>
                                            <th>Current Shift</th>
                                            <th>Assign Shift</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userTableBody">
                                        <?php
                                            $users = \App\Models\User::where('role', '!=', 3)
                                                ->where('is_active', true)
                                                ->with(['department', 'shift'])
                                                ->get();
                                        ?>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr data-user-id="<?php echo e($user->id); ?>">
                                                <td><?php echo e($user->employee_id ?? 'N/A'); ?></td>
                                                <td>
                                                    <strong><?php echo e($user->name); ?> <?php echo e($user->last_name ?? ''); ?></strong>
                                                    <br><small class="text-muted"><?php echo e($user->email); ?></small>
                                                </td>
                                                <td><?php echo e($user->department->name ?? 'N/A'); ?></td>
                                                <td><?php echo e($user->position ?? 'N/A'); ?></td>
                                                <td>
                                                    <?php if($user->shift): ?>
                                                        <span class="badge badge-primary"><?php echo e($user->shift->name); ?></span>
                                                        <br><small class="text-muted">
                                                            <?php echo e($user->shift->start_time->format('H:i')); ?> - <?php echo e($user->shift->end_time->format('H:i')); ?>

                                                        </small>
                                                    <?php else: ?>
                                                        <span class="badge badge-secondary">No Shift</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <select class="form-control form-control-sm shift-select" data-user-id="<?php echo e($user->id); ?>" onchange="updateHiddenInput(<?php echo e($user->id); ?>, this.value)">
                                                        <option value="">Select Shift</option>
                                                        <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($shift->id); ?>" <?php echo e($user->shift_id == $shift->id ? 'selected' : ''); ?>>
                                                                <?php echo e($shift->name); ?> (<?php echo e($shift->start_time->format('H:i')); ?> - <?php echo e($shift->end_time->format('H:i')); ?>)
                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <form action="<?php echo e(route('shifts.assign')); ?>" method="POST" style="display: inline;">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                                                        <input type="hidden" name="shift_id" id="shift-hidden-<?php echo e($user->id); ?>" value="<?php echo e($user->shift_id ?? ''); ?>">
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return validateShift(<?php echo e($user->id); ?>)">
                                                            <i class="fas fa-check"></i> Assign
                                                        </button>
                                                    </form>
                                                    <form action="<?php echo e(route('shifts.assign')); ?>" method="POST" style="display: inline;">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                                                        <input type="hidden" name="shift_id" id="shift-hidden-<?php echo e($user->id); ?>-2" value="<?php echo e($user->shift_id ?? ''); ?>">
                                                        <button type="submit" class="btn btn-sm btn-primary ms-1" onclick="return validateShift(<?php echo e($user->id); ?>)">
                                                            <i class="fas fa-user-plus"></i> Appoint
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Quick shift creation
    $('#quickShiftForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?php echo e(route("shifts.store")); ?>',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error creating shift: ' + xhr.responseJSON.message || 'Unknown error');
            }
        });
    });
});

// Function to update hidden inputs when dropdown changes
function updateHiddenInput(userId, shiftId) {
    console.log('Updating hidden input for user ' + userId + ' to shift ' + shiftId);
    $('#shift-hidden-' + userId).val(shiftId);
    $('#shift-hidden-' + userId + '-2').val(shiftId);
}

// Validation function for shift assignment
function validateShift(userId) {
    var shiftId = $('#shift-hidden-' + userId).val();
    
    console.log('Validating shift for user ' + userId + ': ' + shiftId);
    
    if (!shiftId) {
        alert('Please select a shift first!');
        return false;
    }
    
    return true;
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/shifts/index.blade.php ENDPATH**/ ?>