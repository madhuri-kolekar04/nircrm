<?php $__env->startSection('page-title', 'Edit Attendance'); ?>

<?php $__env->startSection('admin'); ?>
<div class="edit-container">
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4 animate-slide-up">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-white mb-2">
                        <i class="fas fa-edit me-2"></i>Edit Attendance Record
                    </h2>
                    <p class="text-white-50 mb-0">Update attendance details for <?php echo e($attendance->user->name); ?></p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('attendance.show', $attendance->id)); ?>" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i> Back to Details
                    </a>
                    <a href="<?php echo e(route('attendance.dashboard')); ?>" class="btn btn-outline-light">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card edit-card animate-slide-up">
                <div class="card-header card-header-gradient text-white">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-user-clock me-2"></i>Attendance Information
                    </h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('attendance.mark')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="user_id" value="<?php echo e($attendance->user_id); ?>">
                        <input type="hidden" name="date" value="<?php echo e($attendance->date->format('Y-m-d')); ?>">
                        
                        <!-- Employee Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert employee-info-card">
                                    <div class="d-flex align-items-center">
                                        <div class="employee-avatar me-3">
                                            <?php echo e(strtoupper(substr($attendance->user->name, 0, 1))); ?>

                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1 fw-bold"><?php echo e($attendance->user->name); ?></h5>
                                            <p class="mb-0 opacity-90"><?php echo e($attendance->user->getRoleNameAttribute()); ?></p>
                                            <?php if($attendance->user->department): ?>
                                                <p class="mb-0 opacity-75"><i class="fas fa-building me-1"></i><?php echo e($attendance->user->department->name); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-end">
                                            <div class="badge bg-white text-dark status-badge">
                                                <i class="fas fa-calendar me-1"></i><?php echo e($attendance->date->format('d M Y')); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Attendance Status Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="section-title">Attendance Status</h5>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Attendance Status <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="present" <?php echo e($attendance->status === 'present' ? 'selected' : ''); ?>>🟢 Present</option>
                                    <option value="absent" <?php echo e($attendance->status === 'absent' ? 'selected' : ''); ?>>🔴 Absent</option>
                                    <option value="half_day" <?php echo e($attendance->status === 'half_day' ? 'selected' : ''); ?>>🟡 Half Day</option>
                                    <option value="on_leave" <?php echo e($attendance->status === 'on_leave' ? 'selected' : ''); ?>>🔵 On Leave</option>
                                    <option value="holiday" <?php echo e($attendance->status === 'holiday' ? 'selected' : ''); ?>>🟣 Holiday</option>
                                    <option value="weekend" <?php echo e($attendance->status === 'weekend' ? 'selected' : ''); ?>>⚫ Weekend</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">Date</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" class="form-control form-control-lg" id="date" name="date" 
                                           value="<?php echo e($attendance->date->format('Y-m-d')); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Time Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="section-title">Time Information</h5>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="check_in_time" class="form-label">Check In Time</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-sign-in-alt"></i></span>
                                    <input type="time" class="form-control" id="check_in_time" name="check_in_time" 
                                           value="<?php echo e($attendance->check_in_time ? $attendance->check_in_time->format('H:i') : ''); ?>">
                                </div>
                                <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Standard check-in: 9:00 AM</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="check_out_time" class="form-label">Check Out Time</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-sign-out-alt"></i></span>
                                    <input type="time" class="form-control" id="check_out_time" name="check_out_time" 
                                           value="<?php echo e($attendance->check_out_time ? $attendance->check_out_time->format('H:i') : ''); ?>">
                                </div>
                                <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Standard check-out: 6:00 PM</small>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="section-title">Additional Details</h5>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Location</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" class="form-control" id="location" name="location" 
                                           value="<?php echo e($attendance->location ?? 'Office'); ?>" placeholder="Enter location">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="working_hours" class="form-label">Working Hours (Auto-calculated)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    <input type="number" step="0.1" class="form-control" id="working_hours" name="working_hours" 
                                           value="<?php echo e($attendance->working_hours ?? ''); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Notes Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="section-title">Notes & Remarks</h5>
                                <div class="floating-label">
                                    <textarea class="form-control" id="notes" name="notes" rows="4" 
                                              placeholder=" "><?php echo e($attendance->notes ?? ''); ?></textarea>
                                    <label for="notes" class="form-label">Add any notes or remarks about this attendance record...</label>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="section-title">Quick Actions</h5>
                                <div class="card quick-action-card">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-outline-success w-100" onclick="setFullDay()">
                                                    <i class="fas fa-calendar-day me-2"></i> Full Day
                                                </button>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-outline-warning w-100" onclick="setHalfDay()">
                                                    <i class="fas fa-clock me-2"></i> Half Day
                                                </button>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-outline-info w-100" onclick="setStandardTime()">
                                                    <i class="fas fa-business-time me-2"></i> Standard Hours
                                                </button>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-outline-secondary w-100" onclick="clearForm()">
                                                    <i class="fas fa-eraser me-2"></i> Clear
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <button type="button" class="btn btn-outline-secondary btn-lg" onclick="window.history.back()">
                                            <i class="fas fa-times me-2"></i> Cancel
                                        </button>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save me-2"></i> Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.edit-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.edit-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.edit-card:hover {
    transform: translateY(-5px);
}

.card-header-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 1.5rem;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e3e6f0;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.input-group-text {
    border-radius: 10px 0 0 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 10px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
}

.btn-outline-primary {
    border: 2px solid #667eea;
    color: #667eea;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
}

.quick-action-card {
    border-radius: 15px;
    border: none;
    background: #f8f9fc;
    transition: all 0.3s ease;
}

.quick-action-card:hover {
    background: #e3e6f0;
    transform: translateY(-2px);
}

.employee-info-card {
    border-radius: 15px;
    border: none;
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.employee-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: bold;
    color: white;
}

.status-badge {
    border-radius: 20px;
    padding: 0.5rem 1rem;
    font-weight: 600;
}

.form-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.floating-label {
    position: relative;
}

.floating-label .form-control {
    padding-top: 1.5rem;
}

.floating-label .form-label {
    position: absolute;
    top: 0.75rem;
    left: 1rem;
    transition: all 0.3s ease;
    pointer-events: none;
}

.floating-label .form-control:focus + .form-label,
.floating-label .form-control:not(:placeholder-shown) + .form-label {
    top: 0.25rem;
    font-size: 0.75rem;
    color: #667eea;
}

@keyframes slideInUp {
    from {
        transform: translateY(30px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.animate-slide-up {
    animation: slideInUp 0.6s ease-out;
}

.section-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 1.5rem;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Auto-calculate working hours when times change
    $('#check_in_time, #check_out_time').change(function() {
        calculateWorkingHours();
    });
    
    // Update status color when changed
    $('#status').change(function() {
        updateStatusColor();
    });
    
    // Initialize status color
    updateStatusColor();
});

function calculateWorkingHours() {
    var checkIn = $('#check_in_time').val();
    var checkOut = $('#check_out_time').val();
    
    if (checkIn && checkOut) {
        var startTime = new Date('2000-01-01 ' + checkIn);
        var endTime = new Date('2000-01-01 ' + checkOut);
        
        if (endTime > startTime) {
            var diffMs = endTime - startTime;
            var diffHours = diffMs / (1000 * 60 * 60);
            $('#working_hours').val(diffHours.toFixed(2));
        } else {
            $('#working_hours').val('');
        }
    } else {
        $('#working_hours').val('');
    }
}

function updateStatusColor() {
    var status = $('#status').val();
    var select = $('#status');
    
    select.removeClass('bg-success bg-danger bg-warning bg-info bg-primary bg-secondary');
    
    switch(status) {
        case 'present':
            select.addClass('bg-success text-white');
            break;
        case 'absent':
            select.addClass('bg-danger text-white');
            break;
        case 'half_day':
            select.addClass('bg-warning text-white');
            break;
        case 'on_leave':
            select.addClass('bg-info text-white');
            break;
        case 'holiday':
            select.addClass('bg-primary text-white');
            break;
        case 'weekend':
            select.addClass('bg-secondary text-white');
            break;
    }
}

function setFullDay() {
    $('#status').val('present').trigger('change');
    $('#check_in_time').val('09:00');
    $('#check_out_time').val('18:00');
    calculateWorkingHours();
}

function setHalfDay() {
    $('#status').val('half_day').trigger('change');
    $('#check_in_time').val('09:00');
    $('#check_out_time').val('13:00');
    calculateWorkingHours();
}

function setStandardTime() {
    $('#check_in_time').val('09:00');
    $('#check_out_time').val('18:00');
    calculateWorkingHours();
}

function clearForm() {
    $('#status').val('').trigger('change');
    $('#check_in_time').val('');
    $('#check_out_time').val('');
    $('#working_hours').val('');
    $('#notes').val('');
    $('#location').val('Office');
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/attendance/edit.blade.php ENDPATH**/ ?>