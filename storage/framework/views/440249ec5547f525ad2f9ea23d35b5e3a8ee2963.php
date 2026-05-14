<?php $__env->startSection('admin'); ?>
<?php $__env->startPush('styles'); ?>
<style>
/* Reset and base styles for profile edit page */
.profile-edit-container * {
    box-sizing: border-box;
}

.profile-edit-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    width: 100%;
    background: transparent;
}

.profile-edit-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2.5rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
}

.profile-edit-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="50" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="30" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

.profile-edit-content {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 2rem;
    align-items: start;
}

.profile-edit-sidebar {
    position: sticky;
    top: 2rem;
}

.profile-edit-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.profile-edit-card:hover {
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

.form-section {
    margin-bottom: 2rem;
}

.form-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.25rem 2rem;
    font-size: 1.125rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-header.personal {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.form-header.security {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.form-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-label .required {
    color: #ef4444;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-control:hover {
    border-color: #d1d5db;
}

.password-input-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 5px;
    transition: all 0.2s ease;
}

.password-toggle:hover {
    background: #f3f4f6;
    color: #374151;
}

.file-upload-wrapper {
    position: relative;
    overflow: hidden;
    display: inline-block;
    width: 100%;
}

.file-upload-input {
    position: absolute;
    left: -9999px;
}

.file-upload-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 2rem;
    border: 2px dashed #d1d5db;
    border-radius: 10px;
    background: #f9fafb;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.file-upload-label:hover {
    border-color: #667eea;
    background: #f8f9ff;
}

.file-upload-label.has-file {
    border-color: #10b981;
    background: #f0fdf4;
}

.image-preview {
    margin-top: 1rem;
    text-align: center;
}

.image-preview img {
    max-width: 150px;
    max-height: 150px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 0.875rem 2.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.btn-cancel {
    background: #6b7280;
    color: white;
    border: none;
    padding: 0.875rem 2.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-left: 1rem;
}

.btn-cancel:hover {
    background: #4b5563;
    transform: translateY(-2px);
}

.form-actions {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
}

@media (max-width: 1024px) {
    .profile-edit-content {
        grid-template-columns: 1fr;
    }
    
    .profile-edit-sidebar {
        position: static;
        max-width: 400px;
        margin: 0 auto;
    }
}

@media (max-width: 768px) {
    .profile-edit-container {
        padding: 1rem;
    }
    
    .profile-edit-header {
        padding: 1.5rem;
    }
    
    .form-body {
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-cancel {
        margin-left: 0;
    }
}
</style>
<?php $__env->stopPush(); ?>

<div class="profile-edit-container">
    <!-- Profile Edit Header -->
    <div class="profile-edit-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0" style="font-weight: 700; font-size: 2.5rem; position: relative; z-index: 1;">
                    <i class="fas fa-user-edit mr-3"></i>
                    Edit Profile
                </h1>
                <p class="mb-0 mt-2" style="opacity: 0.9; font-size: 1.1rem; position: relative; z-index: 1;">
                    Update your personal information and account settings
                </p>
            </div>
            <div class="col-md-4 text-right">
                <a href="<?php echo e(route('admin.profile')); ?>" class="btn-cancel" style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);">
                    <i class="fas fa-arrow-left"></i>
                    Back to Profile
                </a>
            </div>
        </div>
    </div>

    <!-- Profile Edit Content -->
    <div class="profile-edit-content">
        <!-- Left Sidebar -->
        <div class="profile-edit-sidebar">
            <div class="profile-edit-card">
                <div class="profile-avatar-section">
                    <img src="<?php echo e((!empty($editData->profile_photo_path)) ? url('upload/admin_images/'.$editData->profile_photo_path) : url('upload/no_image.jpg')); ?>" 
                         alt="Profile Avatar" 
                         class="profile-avatar" id="currentAvatar">
                    
                    <h3 class="profile-name"><?php echo e($editData->name ?? 'Unknown User'); ?></h3>
                    
                    <?php
                        $roleClass = 'role-customer';
                        $roleText = 'Customer';
                        if (isset($editData->role)) {
                            if ($editData->role == 1 || $editData->role == 5) {
                                $roleClass = 'role-admin';
                                $roleText = 'Administrator';
                            } elseif ($editData->role == 2) {
                                $roleClass = 'role-employee';
                                $roleText = 'Employee';
                            } elseif ($editData->role == 3) {
                                $roleClass = 'role-customer';
                                $roleText = 'Customer';
                            } elseif ($editData->role == 4) {
                                $roleClass = 'role-manager';
                                $roleText = 'Manager';
                            }
                        }
                    ?>
                    
                    <div class="profile-role <?php echo e($roleClass); ?>">
                        <?php echo e($roleText); ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content - Form -->
        <div class="profile-edit-main">
            <form method="post" action="<?php echo e(route('admin.profile.store')); ?>" enctype="multipart/form-data" id="profileEditForm">
                <?php echo csrf_field(); ?>
                
                <!-- Personal Information Section -->
                <div class="form-section">
                    <div class="profile-edit-card">
                        <div class="form-header personal">
                            <i class="fas fa-user"></i>
                            Personal Information
                        </div>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">
                                            User Name <span class="required">*</span>
                                        </label>
                                        <input type="text" name="name" class="form-control" id="name" value="<?php echo e($editData->name); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            Email Address <span class="required">*</span>
                                        </label>
                                        <input type="email" name="email" class="form-control" id="email" value="<?php echo e($editData->email); ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_number" class="form-label">
                                            Contact Number <span class="required">*</span>
                                        </label>
                                        <input type="tel" name="contact_number" class="form-control" id="contact_number" value="<?php echo e($editData->contact_number); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="profile_photo_path" class="form-label">
                                            Profile Image
                                        </label>
                                        <div class="file-upload-wrapper">
                                            <input type="file" name="profile_photo_path" class="file-upload-input" id="profile_photo_path" accept="image/*">
                                            <label for="profile_photo_path" class="file-upload-label" id="fileLabel">
                                                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #6b7280;"></i>
                                                <div>
                                                    <div style="font-weight: 600; color: #374151;">Click to upload or drag and drop</div>
                                                    <div style="font-size: 0.875rem; color: #6b7280;">PNG, JPG, GIF up to 10MB</div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="image-preview" id="imagePreview">
                                            <img src="<?php echo e((!empty($editData->profile_photo_path)) ? url('upload/admin_images/'.$editData->profile_photo_path) : url('upload/no_image.jpg')); ?>" alt="Current Profile Image" id="previewImg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if(auth()->user()->employeeID == "admin"): ?>
                <!-- Security Section -->
                <div class="form-section">
                    <div class="profile-edit-card">
                        <div class="form-header security">
                            <i class="fas fa-lock"></i>
                            Security Settings
                        </div>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="form-label">
                                            New Password
                                        </label>
                                        <div class="password-input-wrapper">
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter new password (leave blank to keep current)">
                                            <button type="button" class="password-toggle" id="togglePassword">
                                                <i class="fas fa-eye" id="eyeIcon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">
                                            Confirm New Password
                                        </label>
                                        <div class="password-input-wrapper">
                                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm new password">
                                            <button type="button" class="password-toggle" id="togglePasswordConfirm">
                                                <i class="fas fa-eye" id="eyeIconConfirm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 1rem; margin-top: 1rem;">
                                <div style="display: flex; align-items: center; gap: 0.5rem; color: #92400e; font-weight: 600;">
                                    <i class="fas fa-info-circle"></i>
                                    Security Note
                                </div>
                                <div style="color: #78350f; font-size: 0.875rem; margin-top: 0.5rem;">
                                    Leave password fields blank if you don't want to change your current password.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Form Actions -->
                <div class="profile-edit-card">
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i>
                            Update Profile
                        </button>
                        <a href="<?php echo e(route('admin.profile')); ?>" class="btn-cancel">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload preview
    const fileInput = document.getElementById('profile_photo_path');
    const fileLabel = document.getElementById('fileLabel');
    const previewImg = document.getElementById('previewImg');
    const currentAvatar = document.getElementById('currentAvatar');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                currentAvatar.src = e.target.result;
                fileLabel.classList.add('has-file');
                fileLabel.innerHTML = `
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: #10b981;"></i>
                    <div>
                        <div style="font-weight: 600; color: #374151;">${file.name}</div>
                        <div style="font-size: 0.875rem; color: #6b7280;">Click to change file</div>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }
    });

    // Password toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function() {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });

    // Confirm password toggle
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordConfirmField = document.getElementById('password_confirmation');
    const eyeIconConfirm = document.getElementById('eyeIconConfirm');

    if (togglePasswordConfirm) {
        togglePasswordConfirm.addEventListener('click', function() {
            if (passwordConfirmField.type === 'password') {
                passwordConfirmField.type = 'text';
                eyeIconConfirm.classList.remove('fa-eye');
                eyeIconConfirm.classList.add('fa-eye-slash');
            } else {
                passwordConfirmField.type = 'password';
                eyeIconConfirm.classList.remove('fa-eye-slash');
                eyeIconConfirm.classList.add('fa-eye');
            }
        });
    }

    // Form validation
    const form = document.getElementById('profileEditForm');
    form.addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;

        if (password && password !== passwordConfirm) {
            e.preventDefault();
            alert('Passwords do not match. Please try again.');
            return false;
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/admin_profile_edit.blade.php ENDPATH**/ ?>