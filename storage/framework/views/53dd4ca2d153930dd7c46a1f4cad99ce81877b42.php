<?php $__env->startSection('title', 'Account Management'); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-user-check"></i> Account Management - Approved Quotations
                    </h3>
                    <a href="<?php echo e(route('invoices.index')); ?>" class="btn btn-primary">
                        <i class="fas fa-file-invoice-dollar"></i> Invoice Management
                    </a>
                </div>
                <div class="card-body">
                    <!-- Success Messages -->
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Email Sent Messages -->
                    <?php if(session('email_sent')): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-envelope"></i> <?php echo e(session('email_sent')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Error Messages -->
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($quotations->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="accountsTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Quotation Number</th>
                                        <th>Client Name</th>
                                        <th>Business Name</th>
                                        <th>Email</th>
                                        <th>Final Amount</th>
                                        <th>Invoice Status</th>
                                        <th>Approval Status</th>
                                        <th>Payment Status</th>
                                        <th>Customer Panel</th>
                                        <th>Accountant Actions</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $quotations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quotation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <strong><?php echo e($quotation->quotation_number); ?></strong>
                                        </td>
                                        <td><?php echo e($quotation->client_contact_name); ?></td>
                                        <td><?php echo e($quotation->client_business_name); ?></td>
                                        <td><?php echo e($quotation->client_email); ?></td>
                                        <td>
                                            <span class="badge bg-success"><?php echo e($quotation->formatted_final_amount); ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo e($quotation->invoice_status_color); ?> me-1" id="invoice-status-<?php echo e($quotation->id); ?>">
                                                <i class="fas fa-<?php echo e($quotation->invoice_status_icon); ?>"></i>
                                                <?php echo e(ucfirst($quotation->invoice_status ?: 'pending')); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo e($quotation->approval_status_color); ?> me-1">
                                                <i class="fas fa-<?php echo e($quotation->approval_status_icon); ?>"></i>
                                                <?php echo e(ucfirst($quotation->approval_status)); ?>

                                            </span>
                                            <?php if($quotation->approved_at): ?>
                                            <div class="small text-muted mt-1">
                                                <?php echo e($quotation->approved_at->format('M d, Y h:i A')); ?>

                                            </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <form action="<?php echo e(route('accounts.update-payment', $quotation->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <select name="payment_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    <?php $__currentLoopData = \App\Models\Quotation::getPaymentStatuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($key); ?>" <?php echo e($quotation->payment_status == $key ? 'selected' : ''); ?>>
                                                            <?php echo e($value); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </form>
                                            <?php if($quotation->payment_updated_at): ?>
                                            <div class="small text-muted mt-1">
                                                <?php echo e($quotation->payment_updated_at->format('M d, Y h:i A')); ?>

                                            </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input customer-panel-toggle" 
                                                       type="checkbox" 
                                                       id="customerPanel<?php echo e($quotation->id); ?>"
                                                       data-quotation-id="<?php echo e($quotation->id); ?>"
                                                       <?php echo e($quotation->customer_panel ? 'checked' : ''); ?>>
                                                <label class="form-check-label" for="customerPanel<?php echo e($quotation->id); ?>">
                                                    <?php echo e($quotation->customer_panel ? 'Enabled' : 'Disabled'); ?>

                                                </label>
                                            </div>
                                            <?php if($quotation->customer_panel): ?>
                                                <div class="small text-success mt-1">
                                                    <i class="fas fa-check-circle"></i> Customer can login
                                                </div>
                                            <?php else: ?>
                                                <div class="small text-muted mt-1">
                                                    <i class="fas fa-times-circle"></i> Customer cannot login
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('accounts.create-invoice', $quotation->id)); ?>" class="btn btn-sm btn-success" title="Generate GST Invoice">
                                                    <i class="fas fa-file-invoice"></i> Create Invoice
                                                </a>
                                                <a href="<?php echo e(route('invoices.management', $quotation->id)); ?>" class="btn btn-sm btn-info" title="Invoice Management">
                                                    <i class="fas fa-tasks"></i> Invoice Management
                                                </a>
                                                <a href="<?php echo e(route('quotations.edit', $quotation->id)); ?>" class="btn btn-sm btn-primary" title="Edit Quotation">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('quotations.show', $quotation->id)); ?>" class="btn btn-sm btn-info" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('quotations.pdf', $quotation->id)); ?>" class="btn btn-sm btn-secondary" title="Download PDF">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <?php if($quotation->lead_id): ?>
                                                <button class="btn btn-sm btn-warning" onclick="moveQuotationToLead(<?php echo e($quotation->id); ?>, <?php echo e($quotation->lead_id); ?>)" title="Move back to Leads Qualified">
                                                    <i class="fas fa-arrow-down"></i>
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                Showing <?php echo e($quotations->firstItem()); ?> to <?php echo e($quotations->lastItem()); ?> of <?php echo e($quotations->total()); ?> entries
                            </div>
                            <?php echo e($quotations->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-user-check text-muted fa-3x mb-3"></i>
                            <h5 class="text-muted">No Approved Quotations Found</h5>
                            <p class="text-muted">There are no approved quotations to manage at this time.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Section for Qualified Leads -->
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-users"></i> Leads Qualified
                    </h3>
                </div>
                <div class="card-body">
                    <?php if($qualifiedLeads->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="qualifiedLeadsTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Budget</th>
                                        <th>Priority</th>
                                        <th>Assigned To</th>
                                        <th>Created Date</th>
                                        <th>Customer Panel</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $qualifiedLeads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <strong><?php echo e($lead->name); ?></strong>
                                        </td>
                                        <td><?php echo e($lead->company_name ?? 'N/A'); ?></td>
                                        <td><?php echo e($lead->email ?? 'N/A'); ?></td>
                                        <td><?php echo e($lead->phone ?? 'N/A'); ?></td>
                                        <td>
                                            <?php if($lead->budget): ?>
                                                <span class="badge bg-info"><?php echo e(number_format($lead->budget, 2)); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo e($lead->priority === 'high' ? 'danger' : ($lead->priority === 'medium' ? 'warning' : 'secondary')); ?>">
                                                <?php echo e(ucfirst($lead->priority)); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if($lead->assignedUser): ?>
                                                <span class="badge bg-primary"><?php echo e($lead->assignedUser->name); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Unassigned</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($lead->created_at->format('M d, Y')); ?></td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input customer-panel-toggle" 
                                                       type="checkbox" 
                                                       id="leadCustomerPanel<?php echo e($lead->id); ?>"
                                                       data-lead-id="<?php echo e($lead->id); ?>"
                                                       <?php echo e($lead->customer_panel ? 'checked' : ''); ?>>
                                                <label class="form-check-label" for="leadCustomerPanel<?php echo e($lead->id); ?>">
                                                    <?php echo e($lead->customer_panel ? 'Enabled' : 'Disabled'); ?>

                                                </label>
                                            </div>
                                            <?php if($lead->customer_panel): ?>
                                                <div class="small text-success mt-1">
                                                    <i class="fas fa-check-circle"></i> Customer can login
                                                </div>
                                            <?php else: ?>
                                                <div class="small text-muted mt-1">
                                                    <i class="fas fa-times-circle"></i> Customer cannot login
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-info" onclick="viewLead(<?php echo e($lead->id); ?>)" title="View Lead">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning" onclick="editLead(<?php echo e($lead->id); ?>)" title="Edit Lead">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <?php if(!checkLeadInQuotations($lead->id)): ?>
                                                <button class="btn btn-sm btn-success" onclick="moveLeadToQuotation(<?php echo e($lead->id); ?>)" title="Move to Account Management">
                                                    <i class="fas fa-arrow-up"></i>
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users text-muted fa-3x mb-3"></i>
                            <h5 class="text-muted">No Qualified Leads Found</h5>
                            <p class="text-muted">There are no qualified leads to manage at this time.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Customer Panel Toggle functionality for Leads
$(document).ready(function() {
    console.log('Accounts page loaded. Initializing DataTables...');
    
    // Initialize DataTables first
    $('#accountsTable').DataTable({
        "pageLength": 25,
        "order": [[ 0, "asc" ]], // Sort by serial number column (index 0) in ascending order
        "responsive": true,
        "columnDefs": [{
            "targets": 0, // The first column (index 0) for serial numbers
            "render": function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        }],
        "language": {
            "search": "Search quotations:",
            "lengthMenu": "Show _MENU_ entries per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ quotations",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        },
        "initComplete": function() {
            console.log('Quotations DataTable initialized');
            // Now bind toggle events after DataTable is ready
            bindToggleEvents();
        }
    });
    
    $('#qualifiedLeadsTable').DataTable({
        "pageLength": 25,
        "responsive": true,
        "columnDefs": [{
            "targets": 0, // The first column (index 0) for serial numbers
            "render": function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        }],
        "language": {
            "search": "Search leads:",
            "lengthMenu": "Show _MENU_ entries per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ leads",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        },
        "initComplete": function() {
            console.log('Leads DataTable initialized');
            // Bind toggle events again for leads table
            bindToggleEvents();
        }
    });
    
    // Function to bind toggle events
    function bindToggleEvents() {
        console.log('Binding toggle events...');
        
        // Test: Check if toggle elements exist
        const $toggles = $('.customer-panel-toggle');
        console.log('Found toggle elements:', $toggles.length);
        
        // Handle customer panel toggle for quotations
        $toggles.off('change').on('change', function() {
            console.log('Toggle change detected!');
            
            const $toggle = $(this);
            const quotationId = $toggle.data('quotation-id');
            const leadId = $toggle.data('lead-id');
            
            console.log('Toggle data:', { quotationId, leadId });
            
            if (quotationId) {
                console.log('Handling quotation toggle for ID:', quotationId);
                // Handle quotation toggle (existing functionality)
                handleQuotationToggle($toggle, quotationId);
            } else if (leadId) {
                console.log('Handling lead toggle for ID:', leadId);
                // Handle lead toggle (new functionality)
                handleLeadToggle($toggle, leadId);
            } else {
                console.log('No ID found on toggle element');
            }
        });
    }
    
    // Handle quotation toggle (existing functionality)
    function handleQuotationToggle($toggle, quotationId) {
        console.log('handleQuotationToggle called with ID:', quotationId);
        
        const isEnabled = $toggle.is(':checked');
        const $label = $toggle.siblings('label');
        const $statusDiv = $toggle.closest('td').find('.small');
        
        console.log('Toggle state:', { isEnabled, hasLabel: !!$label.length, hasStatusDiv: !!$statusDiv.length });
        
        // Show loading state
        $toggle.prop('disabled', true);
        $label.text('Updating...');
        
        console.log('Sending AJAX request to:', `/accounts/${quotationId}/toggle-customer-panel`);
        
        // Send AJAX request to toggle customer panel
        $.ajax({
            url: `/accounts/${quotationId}/toggle-customer-panel`,
            method: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                customer_panel: isEnabled ? 1 : 0
            },
            beforeSend: function() {
                console.log('AJAX request sending...');
            },
            success: function(response) {
                console.log('AJAX Success:', response);
                
                // Update UI
                $label.text(isEnabled ? 'Enabled' : 'Disabled');
                
                if (isEnabled) {
                    $statusDiv.removeClass('text-muted').addClass('text-success')
                        .html('<i class="fas fa-check-circle"></i> Customer can login');
                } else {
                    $statusDiv.removeClass('text-success').addClass('text-muted')
                        .html('<i class="fas fa-times-circle"></i> Customer cannot login');
                }
                
                // Show success message
                showAlert(response.message, 'success');
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', { status, error, responseText: xhr.responseText, statusCode: xhr.status });
                
                // Revert toggle state
                $toggle.prop('checked', !isEnabled);
                $label.text(isEnabled ? 'Enabled' : 'Disabled');
                
                // Show specific error message
                let errorMessage = 'Error updating customer panel access. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 403) {
                    errorMessage = 'You are not authorized to perform this action.';
                } else if (xhr.status === 422) {
                    errorMessage = 'Invalid request. Please refresh the page and try again.';
                } else if (xhr.status >= 500) {
                    errorMessage = 'Server error. Please contact support if the problem persists.';
                }
                
                showAlert(errorMessage, 'danger');
            },
            complete: function() {
                $toggle.prop('disabled', false);
            }
        });
    }
    
    // Handle lead toggle (new functionality) - Use same logic as quotations
    function handleLeadToggle($toggle, leadId) {
        const isEnabled = $toggle.is(':checked');
        const $label = $toggle.siblings('label');
        const $statusDiv = $toggle.closest('td').find('.small');
        
        // Show loading state
        $toggle.prop('disabled', true);
        $label.text('Updating...');
        
        // Send AJAX request to AccountController for leads (same as quotations)
        $.ajax({
            url: `/accounts/lead/${leadId}/toggle-customer-panel`,
            method: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                customer_panel: isEnabled ? 1 : 0
            },
            success: function(response) {
                // Update UI - Same as quotations
                $label.text(isEnabled ? 'Enabled' : 'Disabled');
                
                if (isEnabled) {
                    $statusDiv.removeClass('text-muted').addClass('text-success')
                        .html('<i class="fas fa-check-circle"></i> Customer can login');
                } else {
                    $statusDiv.removeClass('text-success').addClass('text-muted')
                        .html('<i class="fas fa-times-circle"></i> Customer cannot login');
                }
                
                // Show success message - Same as quotations
                showAlert(response.message, 'success');
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error for lead:', { status, error, responseText: xhr.responseText, statusCode: xhr.status });
                
                // Revert toggle state - Same as quotations
                $toggle.prop('checked', !isEnabled);
                $label.text(isEnabled ? 'Enabled' : 'Disabled');
                
                // Show specific error message - Same as quotations
                let errorMessage = 'Error updating customer panel access. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 403) {
                    errorMessage = 'You are not authorized to perform this action.';
                } else if (xhr.status === 422) {
                    errorMessage = 'Invalid request. Please refresh the page and try again.';
                } else if (xhr.status >= 500) {
                    errorMessage = 'Server error. Please contact support if the problem persists.';
                }
                
                showAlert(errorMessage, 'danger');
            },
            complete: function() {
                $toggle.prop('disabled', false);
            }
        });
    }
    
    // Update invoice statuses in real-time
    function updateInvoiceStatuses() {
        $.ajax({
            url: '/api/invoice-statuses',
            method: 'GET',
            success: function(response) {
                response.forEach(function(statusInfo) {
                    const statusElement = $('#invoice-status-' + statusInfo.quotationId);
                    if (statusElement.length > 0) {
                        const currentStatus = statusElement.find('span').text().trim();
                        const newStatus = statusInfo.invoiceStatus;
                        
                        if (currentStatus !== newStatus) {
                            // Update status display
                            const statusColor = getStatusColor(newStatus);
                            const statusIcon = getStatusIcon(newStatus);
                            
                            statusElement.find('span')
                                .removeClass()
                                .addClass(`badge bg-${statusColor} me-1`)
                                .html(`<i class="fas fa-${statusIcon}"></i> ${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}`);
                            
                            // Add animation
                            statusElement.addClass('animate__animated animate__flash');
                            setTimeout(function() {
                                statusElement.removeClass('animate__animated animate__flash');
                            }, 1000);
                            
                            // Show notification if status changed to approved
                            if(newStatus === 'approved') {
                                showApprovalNotification(statusInfo.quotationId, statusInfo.invoiceNumber);
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Failed to update invoice statuses:', error);
            }
        });
    }
    
    // Get status color based on status
    function getStatusColor(status) {
        const colors = {
            'pending': 'secondary',
            'waiting for approval': 'warning',
            'approved': 'success',
            'rejected': 'danger'
        };
        return colors[status.toLowerCase()] || 'secondary';
    }
    
    // Get status icon based on status
    function getStatusIcon(status) {
        const icons = {
            'pending': 'clock',
            'waiting for approval': 'hourglass-half',
            'approved': 'check-circle',
            'rejected': 'times-circle'
        };
        return icons[status.toLowerCase()] || 'clock';
    }
    
    // Show approval notification
    function showApprovalNotification(quotationId, invoiceNumber) {
        // Create notification element
        var notification = $('<div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
            '<strong>✅ Invoice Approved!</strong><br>' +
            'Invoice ' + invoiceNumber + ' has been approved by the client.' +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
            '</div>');
        
        $('body').append(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(function() {
            notification.fadeOut(function() {
                notification.remove();
            });
        }, 5000);
        
        // Play notification sound if available
        if(typeof playNotificationSound === 'function') {
            playNotificationSound();
        }
    }
    
    // Show success popup on page load if success message exists
    $(document).ready(function() {
        // Check for success messages and show popup
        <?php if(session('success')): ?>
        showSuccessPopup('<?php echo e(session('success')); ?>');
        <?php endif; ?>
        
        <?php if(session('email_sent')): ?>
        showEmailPopup('<?php echo e(session('email_sent')); ?>');
        <?php endif; ?>
        
        <?php if(session('error')): ?>
        showErrorPopup('<?php echo e(session('error')); ?>');
        <?php endif; ?>
        
        // Start real-time updates
        setInterval(updateInvoiceStatuses, 10000); // Update every 10 seconds
    });
    
    function showSuccessPopup(message) {
        var notification = $('<div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 350px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">' +
            '<div class="d-flex align-items-center">' +
            '<i class="fas fa-check-circle fa-2x me-3"></i>' +
            '<div>' +
            '<strong>✅ Success!</strong><br>' +
            '<span>' + message + '</span>' +
            '</div>' +
            '<button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>' +
            '</div>' +
            '</div>');
        
        $('body').append(notification);
        
        // Auto-remove after 6 seconds
        setTimeout(function() {
            notification.fadeOut(function() {
                notification.remove();
            });
        }, 6000);
    }
    
    function showEmailPopup(message) {
        var notification = $('<div class="alert alert-info alert-dismissible fade show position-fixed" style="top: 80px; right: 20px; z-index: 9999; min-width: 350px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">' +
            '<div class="d-flex align-items-center">' +
            '<i class="fas fa-envelope fa-2x me-3"></i>' +
            '<div>' +
            '<strong>📧 Email Sent!</strong><br>' +
            '<span>' + message + '</span>' +
            '</div>' +
            '<button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>' +
            '</div>' +
            '</div>');
        
        $('body').append(notification);
        
        // Auto-remove after 6 seconds
        setTimeout(function() {
            notification.fadeOut(function() {
                notification.remove();
            });
        }, 6000);
    }
    
    function showErrorPopup(message) {
        var notification = $('<div class="alert alert-danger alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 350px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">' +
            '<div class="d-flex align-items-center">' +
            '<i class="fas fa-exclamation-circle fa-2x me-3"></i>' +
            '<div>' +
            '<strong>❌ Error!</strong><br>' +
            '<span>' + message + '</span>' +
            '</div>' +
            '<button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>' +
            '</div>' +
            '</div>');
        
        $('body').append(notification);
        
        // Auto-remove after 8 seconds
        setTimeout(function() {
            notification.fadeOut(function() {
                notification.remove();
            });
        }, 8000);
    }
    
    // Generic alert function for AJAX responses
    function showAlert(message, type) {
        if (type === 'success') {
            showSuccessPopup(message);
        } else if (type === 'danger' || type === 'error') {
            showErrorPopup(message);
        } else if (type === 'info') {
            showEmailPopup(message);
        } else {
            // Default to success popup
            showSuccessPopup(message);
        }
    }
    
    // Make sure global functions are available for Leads Qualified table
    window.viewLead = function(leadId) {
        console.log('View lead clicked:', leadId);
        window.open('<?php echo e(route("leads.show", ":id")); ?>'.replace(':id', leadId), '_blank');
    };
    
    window.editLead = function(leadId) {
        console.log('Edit lead clicked:', leadId);
        window.open('<?php echo e(route("leads.edit.new", ":id")); ?>'.replace(':id', leadId), '_blank');
    };
    
    window.moveLeadToQuotation = function(leadId) {
        console.log('Move lead to quotation clicked:', leadId);
        
        if (!confirm('Are you sure you want to move this lead to Account Management? This will create a quotation from the lead.')) {
            return;
        }
        
        $.ajax({
            url: `/accounts/move-lead-to-quotation/${leadId}`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                // Show loading state
                $(`button[onclick="moveLeadToQuotation(${leadId})"]`).prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                console.log('Lead moved successfully:', response);
                
                // Show success message
                showAlert(response.message, 'success');
                
                // Remove the lead row from the table
                $(`button[onclick="moveLeadToQuotation(${leadId})"]`).closest('tr').fadeOut(500, function() {
                    $(this).remove();
                });
                
                // Optionally refresh the page after a delay to show updated data
                setTimeout(function() {
                    location.reload();
                }, 2000);
            },
            error: function(xhr, status, error) {
                console.error('Error moving lead:', { status, error, responseText: xhr.responseText });
                
                // Restore button state
                $(`button[onclick="moveLeadToQuotation(${leadId})"]`).prop('disabled', false)
                    .html('<i class="fas fa-arrow-up"></i>');
                
                // Show error message
                let errorMessage = 'Error moving lead to Account Management. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 403) {
                    errorMessage = 'You are not authorized to perform this action.';
                } else if (xhr.status === 422) {
                    errorMessage = 'Invalid request. Please refresh the page and try again.';
                } else if (xhr.status >= 500) {
                    errorMessage = 'Server error. Please contact support if the problem persists.';
                }
                
                showAlert(errorMessage, 'danger');
            }
        });
    };
    
    window.moveQuotationToLead = function(quotationId, leadId) {
        console.log('Move quotation to lead clicked:', quotationId, leadId);
        
        if (!confirm('Are you sure you want to move this quotation back to Leads Qualified? This will remove the quotation and restore the lead.')) {
            return;
        }
        
        $.ajax({
            url: `/accounts/move-quotation-to-lead/${quotationId}/${leadId}`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                // Show loading state
                $(`button[onclick="moveQuotationToLead(${quotationId}, ${leadId})"]`).prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                console.log('Quotation moved back successfully:', response);
                
                // Show success message
                showAlert(response.message, 'success');
                
                // Remove the quotation row from the table
                $(`button[onclick="moveQuotationToLead(${quotationId}, ${leadId})"]`).closest('tr').fadeOut(500, function() {
                    $(this).remove();
                });
                
                // Optionally refresh the page after a delay to show updated data
                setTimeout(function() {
                    location.reload();
                }, 2000);
            },
            error: function(xhr, status, error) {
                console.error('Error moving quotation back:', { status, error, responseText: xhr.responseText });
                
                // Restore button state
                $(`button[onclick="moveQuotationToLead(${quotationId}, ${leadId})"]`).prop('disabled', false)
                    .html('<i class="fas fa-arrow-down"></i>');
                
                // Show error message
                let errorMessage = 'Error moving quotation back to Leads Qualified. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 403) {
                    errorMessage = 'You are not authorized to perform this action.';
                } else if (xhr.status === 422) {
                    errorMessage = 'Invalid request. Please refresh the page and try again.';
                } else if (xhr.status >= 500) {
                    errorMessage = 'Server error. Please contact support if the problem persists.';
                }
                
                showAlert(errorMessage, 'danger');
            }
        });
    };
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/backend/accounts/index.blade.php ENDPATH**/ ?>