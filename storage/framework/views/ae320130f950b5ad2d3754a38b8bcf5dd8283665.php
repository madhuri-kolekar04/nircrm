

<?php $__env->startSection('page-title', 'Edit Invoice'); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Invoice: <?php echo e($invoice->invoice_number); ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('invoices.update', $invoice)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <!-- Project Details Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-project-diagram"></i> Project Details
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="project_name" class="form-label">Project Name *</label>
                                    <input type="text" class="form-control" id="project_name" name="project_name" value="<?php echo e($invoice->project_name); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="project_topic" class="form-label">Project Topic *</label>
                                    <input type="text" class="form-control" id="project_topic" name="project_topic" value="<?php echo e($invoice->project_topic); ?>" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="project_full_details" class="form-label">Project Full Details *</label>
                                    <textarea class="form-control" id="project_full_details" name="project_full_details" rows="3" required><?php echo e($invoice->project_full_details); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date *</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo e($invoice->start_date->format('Y-m-d')); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date *</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo e($invoice->end_date->format('Y-m-d')); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="department_id" class="form-label">Department *</label>
                                    <select class="form-control" id="department_id" name="department_id" required style="color: black; font-weight: bold;">
                                        <option value="">Select Department</option>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e($invoice->department == $name ? 'selected' : ''); ?> style="color: black; font-weight: bold;"><?php echo e($name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Customer Details Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-user"></i> Customer Details
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Customer Name *</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo e($invoice->customer_name); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_email" class="form-label">Customer Email *</label>
                                    <input type="email" class="form-control" id="customer_email" name="customer_email" value="<?php echo e($invoice->customer_email); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_phone" class="form-label">Customer Phone *</label>
                                    <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="<?php echo e($invoice->customer_phone); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_address" class="form-label">Customer Address *</label>
                                    <textarea class="form-control" id="customer_address" name="customer_address" rows="2" required><?php echo e($invoice->customer_address); ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Details Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-rupee-sign"></i> Payment Details
                                </h6>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="advance_payment" class="form-label">Advance Payment *</label>
                                    <input type="number" class="form-control" id="advance_payment" name="advance_payment" step="0.01" min="0" value="<?php echo e($invoice->advance_payment); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="remaining_payment" class="form-label">Remaining Payment *</label>
                                    <input type="number" class="form-control" id="remaining_payment" name="remaining_payment" step="0.01" min="0" value="<?php echo e($invoice->remaining_payment); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="gst" class="form-label">GST *</label>
                                    <input type="number" class="form-control" id="gst" name="gst" step="0.01" min="0" value="<?php echo e($invoice->gst); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Total Payment</label>
                                    <div class="form-control bg-light" id="total_payment_display">₹<?php echo e(number_format($invoice->total_payment, 2)); ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Section -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="pending" <?php echo e($invoice->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                        <option value="paid" <?php echo e($invoice->status == 'paid' ? 'selected' : ''); ?>>Paid</option>
                                        <option value="overdue" <?php echo e($invoice->status == 'overdue' ? 'selected' : ''); ?>>Overdue</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Installment Schedule Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-calendar-alt"></i> Installment Schedule
                                </h6>
                            </div>
                            <div class="col-12">
                                <div id="installments-container">
                                    <?php
                                        $installments = json_decode($invoice->installments, true) ?? [];
                                        $installmentCount = count($installments);
                                    ?>
                                    <?php for($i = 0; $i < max(3, $installmentCount); $i++): ?>
                                    <div class="installment-row mb-3" data-index="<?php echo e($i); ?>">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Installment <?php echo e($i + 1); ?> Amount</label>
                                                <input type="number" step="0.01" class="form-control" name="installment_amounts[<?php echo e($i); ?>]" 
                                                       value="<?php echo e($installments[$i]['amount'] ?? ''); ?>" placeholder="0.00">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Due Date</label>
                                                <input type="date" class="form-control" name="installment_dates[<?php echo e($i); ?>]" 
                                                       value="<?php echo e($installments[$i]['date'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Notes</label>
                                                <input type="text" class="form-control" name="installment_notes[<?php echo e($i); ?>]" 
                                                       value="<?php echo e($installments[$i]['notes'] ?? ''); ?>" placeholder="Optional notes">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">&nbsp;</label><br>
                                                <?php if($i >= 3): ?>
                                                <button type="button" class="btn btn-danger btn-sm remove-installment" onclick="removeInstallment(this)">
                                                    <i class="fas fa-trash"></i> Remove
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                                
                                <button type="button" class="btn btn-success mb-3" id="add-installment">
                                    <i class="fas fa-plus-circle"></i> Add Installment
                                </button>
                                <button type="button" class="btn btn-info mb-3 ms-2" id="test-modal-btn">
                                    <i class="fas fa-bug"></i> Test Modal
                                </button>
                                <button type="button" class="btn btn-warning mb-3 ms-2" id="test-calculation-btn">
                                    <i class="fas fa-calculator"></i> Test Calculation
                                </button>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Invoice
                                </button>
                                <a href="<?php echo e(route('invoices.show', $invoice)); ?>" class="btn btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="<?php echo e(route('invoices.index')); ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Installment Modal -->
<div class="modal fade" id="installmentModal" tabindex="-1" aria-labelledby="installmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="installmentModalLabel">
                    <i class="fas fa-plus-circle"></i> Add New Installment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="installment-form">
                    <div class="mb-3">
                        <label for="modal-amount" class="form-label">
                            <i class="fas fa-rupee-sign"></i> Installment Amount *
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" id="modal-amount" step="0.01" min="0" required placeholder="0.00">
                        </div>
                        <small class="text-muted">Enter the installment amount</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="modal-date" class="form-label">
                            <i class="fas fa-calendar"></i> Due Date *
                        </label>
                        <input type="date" class="form-control" id="modal-date" required>
                        <small class="text-muted">Select the due date for this installment</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="modal-notes" class="form-label">
                            <i class="fas fa-sticky-note"></i> Notes
                        </label>
                        <textarea class="form-control" id="modal-notes" rows="3" placeholder="Optional notes about this installment..."></textarea>
                        <small class="text-muted">Add any additional information (optional)</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-success" id="save-installment">
                    <i class="fas fa-save"></i> Add Installment
                </button>
            </div>
        </div>
    </div>
</div>

<script>
console.log('=== INSTALLMENT SCRIPT LOADING ===');

// Function to update remaining payment calculation
function updateRemainingPayment() {
    console.log('🧮 Updating remaining payment...');
    
    // Get total payment from display (convert from ₹ format)
    var totalDisplay = document.getElementById('total_payment_display').textContent;
    var totalPayment = parseFloat(totalDisplay.replace('₹', '').replace(',', '')) || 0;
    
    var advancePayment = parseFloat(document.getElementById('advance_payment').value) || 0;
    var totalInstallments = 0;

    // Sum up all installment amounts
    var installmentInputs = document.querySelectorAll('input[name^="installment_amounts"]');
    installmentInputs.forEach(function(input) {
        totalInstallments += parseFloat(input.value) || 0;
    });

    var calculatedRemaining = totalPayment - advancePayment - totalInstallments;
    var remainingField = document.getElementById('remaining_payment');
    
    if (remainingField) {
        remainingField.value = calculatedRemaining.toFixed(2);
        console.log('✅ Remaining updated to:', calculatedRemaining.toFixed(2));
    }
    
    // Update total display
    var total = advancePayment + calculatedRemaining + parseFloat(document.getElementById('gst').value || 0);
    document.getElementById('total_payment_display').textContent = '₹' + total.toFixed(2);
}

// Function to show modal
function showInstallmentModal() {
    console.log('🔘 Showing modal...');
    
    try {
        var modalElement = document.getElementById('installmentModal');
        console.log('Modal element found:', !!modalElement);
        console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
        console.log('Bootstrap.Modal available:', typeof bootstrap !== 'undefined' && bootstrap.Modal);
        
        if (modalElement) {
            // Method 1: Try Bootstrap 5 Modal
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                try {
                    if (!window.installmentModal) {
                        window.installmentModal = new bootstrap.Modal(modalElement);
                        console.log('✅ Bootstrap Modal created successfully');
                    }
                    window.installmentModal.show();
                    console.log('✅ Modal shown using Bootstrap');
                    return;
                } catch (bootstrapError) {
                    console.error('❌ Bootstrap Modal error:', bootstrapError);
                }
            }
            
            // Method 2: Try jQuery Bootstrap (if jQuery is available)
            if (typeof $ !== 'undefined' && $.fn.modal) {
                try {
                    $(modalElement).modal('show');
                    console.log('✅ Modal shown using jQuery Bootstrap');
                    return;
                } catch (jqueryError) {
                    console.error('❌ jQuery Modal error:', jqueryError);
                }
            }
            
            // Method 3: Manual modal show (fallback)
            console.log('🔧 Using manual modal show as fallback');
            modalElement.style.display = 'block';
            modalElement.classList.add('show');
            modalElement.classList.remove('fade');
            document.body.classList.add('modal-open');
            
            // Add backdrop
            var existingBackdrop = document.getElementById('manual-backdrop');
            if (!existingBackdrop) {
                var backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop show';
                backdrop.id = 'manual-backdrop';
                document.body.appendChild(backdrop);
            }
            
            // Add close handlers
            var closeButtons = modalElement.querySelectorAll('[data-bs-dismiss="modal"]');
            closeButtons.forEach(function(btn) {
                btn.onclick = function() {
                    hideManualModal();
                };
            });
            
            // Close on backdrop click
            var backdrop = document.getElementById('manual-backdrop');
            if (backdrop) {
                backdrop.onclick = hideManualModal;
            }
            
            console.log('✅ Modal shown manually');
            
        } else {
            console.error('❌ Modal element not found');
            alert('Modal element not found!');
        }
    } catch (error) {
        console.error('❌ Error showing modal:', error);
        alert('Error showing modal: ' + error.message);
    }
}

// Function to hide manual modal
function hideManualModal() {
    var modalElement = document.getElementById('installmentModal');
    if (modalElement) {
        modalElement.style.display = 'none';
        modalElement.classList.remove('show');
        modalElement.classList.add('fade');
    }
    // Ensure modal-open class is removed from body to restore scrolling
    document.body.classList.remove('modal-open');
    
    var backdrop = document.getElementById('manual-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
}

// Function to save installment
function saveInstallment() {
    console.log('💾 Saving installment...');
    
    var amount = parseFloat(document.getElementById('modal-amount').value);
    var date = document.getElementById('modal-date').value;
    var notes = document.getElementById('modal-notes').value;
    
    if (!amount || amount <= 0) {
        alert('Please enter a valid amount');
        return;
    }
    
    if (!date) {
        alert('Please select a due date');
        return;
    }
    
    // Find the installments container
    var container = document.getElementById('installments-container');
    var rows = container.querySelectorAll('.installment-row');
    
    // Calculate next index
    var maxIndex = 0;
    rows.forEach(function(row) {
        var index = parseInt(row.getAttribute('data-index'));
        if (!isNaN(index) && index > maxIndex) {
            maxIndex = index;
        }
    });
    var nextIndex = maxIndex + 1;
    
    // Create new installment row
    var newRow = document.createElement('div');
    newRow.className = 'installment-row mb-3 border border-success rounded p-2';
    newRow.setAttribute('data-index', nextIndex);
    newRow.style.backgroundColor = '#f8fff9';
    
    newRow.innerHTML = `
        <div class="row">
            <div class="col-md-3">
                <label class="form-label"><strong>Installment ${nextIndex + 1} Amount</strong> <span class="text-success">(New)</span></label>
                <input type="number" step="0.01" class="form-control" name="installment_amounts[${nextIndex}]" value="${amount}" placeholder="0.00">
            </div>
            <div class="col-md-3">
                <label class="form-label">Due Date</label>
                <input type="date" class="form-control" name="installment_dates[${nextIndex}]" value="${date}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Notes</label>
                <input type="text" class="form-control" name="installment_notes[${nextIndex}]" value="${notes}" placeholder="Optional notes">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label><br>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeInstallment(this)">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
        </div>
    `;
    
    // Add the new row
    container.appendChild(newRow);
    
    // Hide modal - try multiple methods to ensure it closes
    try {
        // Method 1: Try Bootstrap modal
        if (window.installmentModal && typeof window.installmentModal.hide === 'function') {
            window.installmentModal.hide();
            console.log('✅ Modal closed using Bootstrap');
        } else {
            console.log('⚠️ Bootstrap modal not available, using manual method');
        }
    } catch (bootstrapError) {
        console.error('❌ Bootstrap modal error:', bootstrapError);
    }
    
    // Method 2: Always try manual cleanup as fallback
    try {
        hideManualModal();
        console.log('✅ Manual modal cleanup completed');
    } catch (manualError) {
        console.error('❌ Manual modal cleanup error:', manualError);
    }
    
    // Method 3: Force cleanup any remaining overlays
    try {
        // Remove any remaining backdrop
        var backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(function(backdrop) {
            backdrop.remove();
        });
        
        // Remove modal-open class from body
        document.body.classList.remove('modal-open');
        
        // Reset body styles to ensure scrolling works
        document.body.style.overflow = '';
        document.body.style.position = '';
        document.body.style.height = '';
        document.body.style.width = '';
        
        // Hide modal element forcefully
        var modalElement = document.getElementById('installmentModal');
        if (modalElement) {
            modalElement.style.display = 'none';
            modalElement.classList.remove('show');
        }
        
        console.log('✅ Force cleanup completed');
    } catch (forceError) {
        console.error('❌ Force cleanup error:', forceError);
    }
    
    // Re-add listeners and update calculation
    addEventListeners();
    updateRemainingPayment();
    
    console.log('✅ Installment saved successfully');
    alert('Installment added successfully!');
}

// Function to remove installment
function removeInstallment(button) {
    if (confirm('Are you sure you want to remove this installment?')) {
        var row = button.closest('.installment-row');
        row.remove();
        updateRemainingPayment();
        console.log('🗑️ Installment removed');
    }
}

// Function to add all event listeners
function addEventListeners() {
    console.log('📝 Adding event listeners...');
    
    // Add listeners to installment fields
    var installmentInputs = document.querySelectorAll('input[name^="installment_amounts"]');
    installmentInputs.forEach(function(input) {
        input.addEventListener('input', updateRemainingPayment);
    });
    
    // Add listeners to payment fields
    document.getElementById('advance_payment').addEventListener('input', updateRemainingPayment);
    document.getElementById('remaining_payment').addEventListener('input', updateRemainingPayment);
    document.getElementById('gst').addEventListener('input', updateRemainingPayment);
}

// Wait for DOM to be loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 DOM loaded - initializing...');
    
    // Add button listeners
    var addBtn = document.getElementById('add-installment');
    if (addBtn) {
        addBtn.addEventListener('click', showInstallmentModal);
        console.log('✅ Add Installment button listener added');
    }
    
    var testBtn = document.getElementById('test-modal-btn');
    if (testBtn) {
        testBtn.addEventListener('click', showInstallmentModal);
        console.log('✅ Test Modal button listener added');
    }
    
    var testCalcBtn = document.getElementById('test-calculation-btn');
    if (testCalcBtn) {
        testCalcBtn.addEventListener('click', function() {
            updateRemainingPayment();
            alert('Calculation updated! Check remaining payment field.');
        });
        console.log('✅ Test Calculation button listener added');
    }
    
    var saveBtn = document.getElementById('save-installment');
    if (saveBtn) {
        saveBtn.addEventListener('click', saveInstallment);
        console.log('✅ Save installment button listener added');
    }
    
    // Add field listeners
    addEventListeners();
    
    // Initial calculation
    updateRemainingPayment();
    
    console.log('✅ Initialization complete');
});

console.log('=== SCRIPT READY ===');
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/invoices/edit.blade.php ENDPATH**/ ?>