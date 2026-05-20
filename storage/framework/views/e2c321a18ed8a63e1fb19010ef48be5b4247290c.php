<!-- Password Change Modal -->
<div class="modal fade" id="passwordChangeModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="passwordChangeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="passwordChangeModalLabel">
                    <i class="fas fa-lock me-2"></i>Change Your Password
                </h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    For your security, please change your password before continuing.
                </div>
                
                <form id="passwordChangeForm">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="password" required minlength="8" placeholder="Enter new password">
                            <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Password must be at least 8 characters long.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="password_confirmation" required placeholder="Confirm new password">
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">
                            Passwords do not match.
                        </div>
                    </div>
                    
                    <div id="passwordChangeError" class="alert alert-danger d-none"></div>
                    <div id="passwordChangeSuccess" class="alert alert-success d-none"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="passwordChangeForm" class="btn btn-primary" id="changePasswordBtn">
                    <i class="fas fa-save me-2"></i>Change Password
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.modal-backdrop {
    z-index: 1050 !important;
}

#passwordChangeModal {
    z-index: 1060 !important;
}

#passwordChangeModal .modal-dialog {
    max-width: 500px;
}

#passwordChangeModal .modal-header {
    border-bottom: 2px solid #ffc107;
}

#passwordChangeModal .form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

#passwordChangeModal .btn-primary {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #000;
}

#passwordChangeModal .btn-primary:hover {
    background-color: #e0a800;
    border-color: #d39e00;
    color: #000;
}

.password-strength {
    height: 5px;
    border-radius: 3px;
    margin-top: 5px;
    transition: all 0.3s ease;
}

.strength-weak { background-color: #dc3545; width: 33%; }
.strength-medium { background-color: #ffc107; width: 66%; }
.strength-strong { background-color: #28a745; width: 100%; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if password change is required
    fetch('/check-password-change-required')
        .then(response => response.json())
        .then(data => {
            if (data.password_change_required) {
                const modal = new bootstrap.Modal(document.getElementById('passwordChangeModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
                
                // Prevent closing the modal
                document.getElementById('passwordChangeModal').addEventListener('hide.bs.modal', function(e) {
                    e.preventDefault();
                });
            }
        })
        .catch(error => console.error('Error checking password change requirement:', error));
    
    // Toggle password visibility
    document.getElementById('toggleNewPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('new_password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
    
    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('confirm_password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
    
    // Check password match
    function checkPasswordMatch() {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const confirmInput = document.getElementById('confirm_password');
        
        if (confirmPassword && newPassword !== confirmPassword) {
            confirmInput.classList.add('is-invalid');
            return false;
        } else {
            confirmInput.classList.remove('is-invalid');
            return true;
        }
    }
    
    document.getElementById('confirm_password').addEventListener('input', checkPasswordMatch);
    document.getElementById('new_password').addEventListener('input', checkPasswordMatch);
    
    // Handle form submission
    document.getElementById('passwordChangeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!checkPasswordMatch()) {
            document.getElementById('passwordChangeError').textContent = 'Passwords do not match.';
            document.getElementById('passwordChangeError').classList.remove('d-none');
            return;
        }
        
        const formData = new FormData(this);
        const submitBtn = document.getElementById('changePasswordBtn');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Changing...';
        document.getElementById('passwordChangeError').classList.add('d-none');
        document.getElementById('passwordChangeSuccess').classList.add('d-none');
        
        fetch('/change-password', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                password: formData.get('password'),
                password_confirmation: formData.get('password_confirmation')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('passwordChangeSuccess').textContent = data.message;
                document.getElementById('passwordChangeSuccess').classList.remove('d-none');
                
                // Hide modal after success and reload page
                setTimeout(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('passwordChangeModal'));
                    modal.hide();
                    location.reload();
                }, 1500);
            } else {
                throw new Error(data.message || 'Password change failed');
            }
        })
        .catch(error => {
            document.getElementById('passwordChangeError').textContent = error.message || 'An error occurred while changing password.';
            document.getElementById('passwordChangeError').classList.remove('d-none');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
});
</script>
<?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/auth/change-password.blade.php ENDPATH**/ ?>