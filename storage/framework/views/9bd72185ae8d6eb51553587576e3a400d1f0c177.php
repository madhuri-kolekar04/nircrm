<?php $__env->startSection('admin'); ?>
<?php $__env->startPush('styles'); ?>
<style>
/* Reset and base styles for profile page */
.profile-container * {
    box-sizing: border-box;
}

.profile-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
    width: 100%;
    background: transparent;
}

.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2.5rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
}

.profile-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="50" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="30" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

.profile-content {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 2rem;
    align-items: start;
}

.profile-sidebar {
    position: sticky;
    top: 2rem;
}

.profile-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
}

.profile-avatar-section {
    text-align: center;
    padding: 2.5rem 2rem;
    background: linear-gradient(135deg, #f8f9ff 0%, #e8ecff 100%);
}

.profile-avatar {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    border: 5px solid white;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    object-fit: cover;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.profile-avatar:hover {
    transform: scale(1.05);
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.profile-role {
    display: inline-block;
    padding: 0.5rem 1.25rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 1rem;
}

.role-admin {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
}

.role-employee {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
}

.role-manager {
    background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);
    color: white;
}

.role-customer {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    color: white;
}

.profile-status {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.875rem;
    background: #10b981;
    color: white;
}

.info-section {
    margin-bottom: 2rem;
}

.info-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.25rem 2rem;
    font-size: 1.125rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.info-header.personal {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.info-header.professional {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
}

.info-header.statistics {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.info-body {
    padding: 0;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 0;
}

.info-item {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    transition: all 0.2s ease;
}

.info-item:hover {
    background: #f9fafb;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.info-value {
    font-size: 1rem;
    color: #1f2937;
    font-weight: 500;
    word-break: break-word;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1px;
    background: #f3f4f6;
}

.stat-item {
    background: white;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.2s ease;
}

.stat-item:hover {
    background: #f9fafb;
}

.stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.75rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.edit-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.edit-btn:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

@media (max-width: 1024px) {
    .profile-content {
        grid-template-columns: 1fr;
    }
    
    .profile-sidebar {
        position: static;
        max-width: 400px;
        margin: 0 auto;
    }
}

@media (max-width: 768px) {
    .profile-container {
        padding: 1rem;
    }
    
    .profile-header {
        padding: 1.5rem;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
<?php $__env->stopPush(); ?>

<div class="profile-container">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0" style="font-weight: 700; font-size: 2.5rem; position: relative; z-index: 1;">
                    <i class="fas fa-user-circle mr-3"></i>
                    User Profile
                </h1>
                <p class="mb-0 mt-2" style="opacity: 0.9; font-size: 1.1rem; position: relative; z-index: 1;">
                    View and manage your account information
                </p>
            </div>
            <div class="col-md-4 text-right">
                <a href="<?php echo e(route('admin.profile.edit')); ?>" class="edit-btn">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="profile-content">
        <!-- Left Sidebar -->
        <div class="profile-sidebar">
            <div class="profile-card">
                <div class="profile-avatar-section">
                    <img src="<?php echo e((!empty($adminData->profile_photo_path)) ? url('upload/admin_images/'.$adminData->profile_photo_path) : url('upload/no_image.jpg')); ?>" 
                         alt="Profile Avatar" 
                         class="profile-avatar">
                    
                    <h3 class="profile-name"><?php echo e($adminData->name ?? 'Unknown User'); ?></h3>
                    
                    <?php
                        $roleClass = 'role-customer';
                        $roleText = 'Customer';
                        if (isset($adminData->role)) {
                            if ($adminData->role == 1 || $adminData->role == 5) {
                                $roleClass = 'role-admin';
                                $roleText = 'Administrator';
                            } elseif ($adminData->role == 2) {
                                $roleClass = 'role-employee';
                                $roleText = 'Employee';
                            } elseif ($adminData->role == 3) {
                                $roleClass = 'role-customer';
                                $roleText = 'Customer';
                            } elseif ($adminData->role == 4) {
                                $roleClass = 'role-manager';
                                $roleText = 'Manager';
                            }
                        }
                    ?>
                    
                    <div class="profile-role <?php echo e($roleClass); ?>">
                        <?php echo e($roleText); ?>

                    </div>
                    
                    <div class="profile-status">
                        <i class="fas fa-check-circle"></i>
                        Active
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content -->
        <div class="profile-main">
            <!-- Personal Information -->
            <div class="info-section">
                <div class="profile-card">
                    <div class="info-header personal">
                        <i class="fas fa-user"></i>
                        Personal Information
                    </div>
                    <div class="info-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Full Name</div>
                                <div class="info-value"><?php echo e($adminData->name ?? 'N/A'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Email Address</div>
                                <div class="info-value"><?php echo e($adminData->email ?? 'N/A'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Contact Number</div>
                                <div class="info-value"><?php echo e($adminData->contact_number ?? 'N/A'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Address</div>
                                <div class="info-value"><?php echo e($adminData->address ?? 'N/A'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="info-section">
                <div class="profile-card">
                    <div class="info-header professional">
                        <i class="fas fa-briefcase"></i>
                        Professional Information
                    </div>
                    <div class="info-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Employee ID</div>
                                <div class="info-value"><?php echo e($adminData->employeeID ?? 'N/A'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Position</div>
                                <div class="info-value"><?php echo e($adminData->position ?? 'N/A'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Department</div>
                                <div class="info-value">
                                    <?php if(isset($adminData->Groupname) && isset($adminData->Groupname->Group)): ?>
                                        <?php echo e($adminData->Groupname->Group); ?>

                                    <?php elseif(isset($adminData->department) && is_object($adminData->department)): ?>
                                        <?php echo e($adminData->department->name ?? 'N/A'); ?>

                                    <?php elseif(isset($adminData->department) && is_string($adminData->department)): ?>
                                        <?php
                                            $deptData = json_decode($adminData->department);
                                            if ($deptData && isset($deptData->name)) {
                                                echo $deptData->name;
                                            } elseif ($deptData && isset($deptData->department)) {
                                                echo $deptData->department;
                                            } else {
                                                echo $adminData->department;
                                            }
                                        ?>
                                    <?php else: ?>
                                        <?php echo e($adminData->department ?? 'N/A'); ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Role</div>
                                <div class="info-value">
                                    <span class="badge bg-primary"><?php echo e($roleText); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="info-section">
                <div class="profile-card">
                    <div class="info-header statistics">
                        <i class="fas fa-chart-bar"></i>
                        Account Statistics
                    </div>
                    <div class="info-body">
                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-value">
                                    <?php if($adminData->created_at): ?>
                                        <?php echo e(\Carbon\Carbon::parse($adminData->created_at)->format('M j, Y')); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </div>
                                <div class="stat-label">Member Since</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">
                                    <?php if($adminData->email_verified_at): ?>
                                        <i class="fas fa-check-circle text-success"></i> Verified
                                    <?php else: ?>
                                        <i class="fas fa-times-circle text-warning"></i> Not Verified
                                    <?php endif; ?>
                                </div>
                                <div class="stat-label">Email Status</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">
                                    <?php if($adminData->last_login_at): ?>
                                        <?php echo e(\Carbon\Carbon::parse($adminData->last_login_at)->diffForHumans()); ?>

                                    <?php else: ?>
                                        Never
                                    <?php endif; ?>
                                </div>
                                <div class="stat-label">Last Login</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">
                                    <i class="fas fa-circle text-success"></i> <?php echo e($adminData->status ?? 'Active'); ?>

                                </div>
                                <div class="stat-label">Account Status</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/admin_profile_view.blade.php ENDPATH**/ ?>