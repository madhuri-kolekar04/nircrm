<?php $__env->startSection('page-title', 'Due Date Management'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
.urgency-overdue { background-color: #f8d7da; color: #721c24; }
.urgency-today { background-color: #f8d7da; color: #721c24; }
.urgency-urgent { background-color: #fff3cd; color: #856404; }
.urgency-soon { background-color: #d1ecf1; color: #0c5460; }
.urgency-normal { background-color: #d4edda; color: #155724; }

.btn .fas {
    display: inline-block !important;
    font-style: normal !important;
    font-variant: normal !important;
    text-rendering: auto !important;
    line-height: 1 !important;
    font-family: "Font Awesome 6 Free" !important;
    font-weight: 900 !important;
}

.btn .fa-envelope:before {
    content: "\f0e0" !important;
}

.btn .fa-calendar:before {
    content: "\f073" !important;
}

.btn .fa-users:before {
    content: "\f0c0" !important;
}

.stats-card {
    border-radius: 10px;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: transform 0.2s;
}

.stats-card:hover {
    transform: translateY(-2px);
}

.bulk-actions {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#dueDateTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[3, 'asc']], // Sort by due date
        language: {
            search: "Search leads...",
            lengthMenu: "Show _MENU_ leads per page"
        }
    });

    // Handle individual checkbox selection
    $('.lead-checkbox').change(function() {
        updateBulkActions();
    });

    // Handle select all checkbox
    $('#selectAll').change(function() {
        $('.lead-checkbox').prop('checked', $(this).prop('checked'));
        updateBulkActions();
    });

    // Update bulk actions visibility
    function updateBulkActions() {
        const checkedCount = $('.lead-checkbox:checked').length;
        if (checkedCount > 0) {
            $('.bulk-actions').show();
            $('#selectedCount').text(checkedCount);
        } else {
            $('.bulk-actions').hide();
        }
    }

    // Send individual reminder
    $('.send-reminder-btn').click(function() {
        const leadId = $(this).data('lead-id');
        const leadName = $(this).data('lead-name');
        
        // Get lead details for modal
        const leadRow = $(this).closest('tr');
        const leadEmail = leadRow.find('td:eq(2)').text().trim();
        const dueDate = leadRow.find('td:eq(3)').text().trim();
        const urgency = leadRow.find('td:eq(5)').text().trim();
        
        // Populate modal with lead details
        $('#modalLeadName').text(leadName);
        $('#modalLeadEmail').text(leadEmail);
        $('#modalDueDate').text(dueDate);
        $('#modalUrgency').text(urgency);
        
        // Store lead ID for form submission
        $('#customEmailForm').data('lead-id', leadId);
        
        // Clear previous message
        $('#customMessage').val('');
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('customEmailModal'));
        modal.show();
    });

    // Send bulk reminders
    $('#sendBulkReminders').click(function() {
        const selectedLeads = [];
        $('.lead-checkbox:checked').each(function() {
            selectedLeads.push($(this).val());
        });

        if (selectedLeads.length === 0) {
            alert('Please select at least one lead.');
            return;
        }

        if (confirm(`Are you sure you want to send due date reminders to ${selectedLeads.length} selected leads?`)) {
            sendBulkReminders(selectedLeads);
        }
    });

    // Send individual reminder
    function sendReminder(leadId) {
        const btn = $(`.send-reminder-btn[data-lead-id="${leadId}"]`);
        const originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i> Sending...').prop('disabled', true);

        $.ajax({
            url: `/duedate/send-reminder/${leadId}`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Failed to send reminder';
                showAlert('error', message);
            },
            complete: function() {
                btn.html(originalText).prop('disabled', false);
            }
        });
    }

    // Send bulk reminders
    function sendBulkReminders(leadIds) {
        const btn = $('#sendBulkReminders');
        const originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i> Sending...').prop('disabled', true);

        $.ajax({
            url: '/duedate/send-bulk-reminders',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                lead_ids: leadIds
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Uncheck all checkboxes
                    $('.lead-checkbox').prop('checked', false);
                    $('#selectAll').prop('checked', false);
                    updateBulkActions();
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Failed to send bulk reminders';
                showAlert('error', message);
            },
            complete: function() {
                btn.html(originalText).prop('disabled', false);
            }
        });
    }

    // Handle custom email form submission
    $('#customEmailForm').submit(function(e) {
        e.preventDefault();
        const leadId = $(this).data('lead-id');
        const customMessage = $('#customMessage').val();
        
        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('customEmailModal')).hide();
        
        // Send reminder with custom message
        sendCustomReminder(leadId, customMessage);
    });

    // Handle "Send Without Message" button
    $('#sendWithoutMessage').click(function() {
        const leadId = $('#customEmailForm').data('lead-id');
        
        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('customEmailModal')).hide();
        
        // Send reminder without custom message
        sendReminder(leadId);
    });

    // Send reminder with custom message
    function sendCustomReminder(leadId, customMessage) {
        const btn = $('.send-reminder-btn[data-lead-id="' + leadId + '"]');
        const originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i> Sending...').prop('disabled', true);

        $.ajax({
            url: `/duedate/send-reminder/${leadId}`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                custom_message: customMessage
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Failed to send reminder';
                showAlert('error', message);
            },
            complete: function() {
                btn.html(originalText).prop('disabled', false);
            }
        });
    }

    // Show alert message
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('.alert-container').html(alertHtml);
        
        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card stats-card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-calendar-alt fa-2x text-danger mb-2"></i>
                    <h5 class="card-title">Overdue</h5>
                    <h3 class="text-danger"><?php echo e($leads->getCollection()->where('urgency_status.status', 'overdue')->count()); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                    <h5 class="card-title">Due Today</h5>
                    <h3 class="text-warning"><?php echo e($leads->getCollection()->where('urgency_status.status', 'today')->count()); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-clock fa-2x text-info mb-2"></i>
                    <h5 class="card-title">This Week</h5>
                    <h3 class="text-info"><?php echo e($leads->getCollection()->where('urgency_status.status', 'urgent')->count()); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-calendar-week fa-2x text-primary mb-2"></i>
                    <h5 class="card-title">This Month</h5>
                    <h3 class="text-primary"><?php echo e($leads->getCollection()->where('urgency_status.status', 'soon')->count()); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h5 class="card-title">On Track</h5>
                    <h3 class="text-success"><?php echo e($leads->getCollection()->where('urgency_status.status', 'normal')->count()); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-users fa-2x text-secondary mb-2"></i>
                    <h5 class="card-title">Total</h5>
                    <h3 class="text-secondary"><?php echo e($leads->total()); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-filter me-2"></i>Filters
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('duedate.index')); ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="<?php echo e(request('search')); ?>" placeholder="Search by name, email, phone...">
                    </div>
                    <div class="col-md-2">
                        <label for="urgency" class="form-label">Urgency</label>
                        <select class="form-select" id="urgency" name="urgency">
                            <option value="">All</option>
                            <option value="overdue" <?php echo e(request('urgency') == 'overdue' ? 'selected' : ''); ?>>Overdue</option>
                            <option value="today" <?php echo e(request('urgency') == 'today' ? 'selected' : ''); ?>>Due Today</option>
                            <option value="this_week" <?php echo e(request('urgency') == 'this_week' ? 'selected' : ''); ?>>This Week</option>
                            <option value="this_month" <?php echo e(request('urgency') == 'this_month' ? 'selected' : ''); ?>>This Month</option>
                            <option value="next_month" <?php echo e(request('urgency') == 'next_month' ? 'selected' : ''); ?>>Next Month</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="due_date_from" class="form-label">From Date</label>
                        <input type="date" class="form-control" id="due_date_from" name="due_date_from" 
                               value="<?php echo e(request('due_date_from')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="due_date_to" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="due_date_to" name="due_date_to" 
                               value="<?php echo e(request('due_date_to')); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="<?php echo e(route('duedate.index')); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Due Date Table -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Due Date Management
                </h5>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-info"><?php echo e($leads->total()); ?> leads with due dates</span>
                    <a href="<?php echo e(route('leads.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Leads
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Alert Container -->
            <div class="alert-container"></div>

            <!-- Bulk Actions -->
            <div class="bulk-actions" style="display: none;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Selected: <span id="selectedCount">0</span> leads</strong>
                    </div>
                    <div>
                        <button type="button" class="btn btn-warning" id="sendBulkReminders">
                            <i class="fas fa-envelope"></i> Send Bulk Reminders
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearSelection()">
                            <i class="fas fa-times"></i> Clear Selection
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table id="dueDateTable" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="40">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th>Lead</th>
                            <th>Contact</th>
                            <th>Due Date</th>
                            <th>Days Left</th>
                            <th>Urgency</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input lead-checkbox" 
                                           value="<?php echo e($lead->id); ?>" data-lead-name="<?php echo e($lead->name); ?>">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <strong><?php echo e($lead->name); ?></strong>
                                            <?php if($lead->company_name): ?>
                                                <br><small class="text-muted"><?php echo e($lead->company_name); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if($lead->email): ?>
                                        <div><i class="fas fa-envelope text-muted"></i> <?php echo e($lead->email); ?></div>
                                    <?php endif; ?>
                                    <?php if($lead->phone): ?>
                                        <div><i class="fas fa-phone text-muted"></i> <?php echo e($lead->phone); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo e($lead->due_date->format('M d, Y')); ?></strong>
                                    <br><small class="text-muted"><?php echo e($lead->due_date->format('l')); ?></small>
                                </td>
                                <td>
                                    <span class="badge urgency-<?php echo e($lead->urgency_status['status']); ?>">
                                        <?php echo e($lead->urgency_status['days_text']); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($lead->urgency_status['color']); ?>">
                                        <?php echo e($lead->urgency_status['label']); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: <?php echo e(App\Models\Lead::getStatusColorForValue($lead->lead_status)); ?>20; color: <?php echo e(App\Models\Lead::getStatusColorForValue($lead->lead_status)); ?>;">
                                        <?php echo e(App\Models\Lead::getLeadStatuses()[$lead->lead_status] ?? $lead->lead_status); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: <?php echo e(App\Models\Lead::getPriorityColorForValue($lead->priority)); ?>20; color: <?php echo e(App\Models\Lead::getPriorityColorForValue($lead->priority)); ?>;">
                                        <?php echo e(App\Models\Lead::getPriorities()[$lead->priority] ?? $lead->priority); ?>

                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-warning send-reminder-btn" 
                                                data-lead-id="<?php echo e($lead->id); ?>" data-lead-name="<?php echo e($lead->name); ?>"
                                                title="Send Reminder">
                                            <i class="fas fa-envelope"></i> Mail
                                        </button>
                                        <a href="<?php echo e(route('leads.edit.new', $lead->id)); ?>" class="btn btn-sm btn-info" title="Edit Lead">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <div class="text-muted">No leads with due dates found</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                <?php echo e($leads->links()); ?>

            </div>
        </div>
    </div>
</div>

<!-- Custom Email Modal -->
<div class="modal fade" id="customEmailModal" tabindex="-1" aria-labelledby="customEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="customEmailModalLabel">
                    <i class="fas fa-envelope me-2"></i>Send Custom Due Date Reminder
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="customEmailForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Lead Name:</label>
                            <p class="form-control-plaintext" id="modalLeadName">-</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Due Date:</label>
                            <p class="form-control-plaintext" id="modalDueDate">-</p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Lead Email:</label>
                            <p class="form-control-plaintext" id="modalLeadEmail">-</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Urgency:</label>
                            <p class="form-control-plaintext" id="modalUrgency">-</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="customMessage" class="form-label fw-bold">
                            <i class="fas fa-message me-2"></i>Custom Message (Optional)
                        </label>
                        <textarea class="form-control" id="customMessage" name="custom_message" rows="8" 
                                  placeholder="Enter your custom message here. This will be highlighted in the email sent to the lead and general managers..."></textarea>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> 
                            Add a personalized message that will be prominently displayed in the "Due Date Details" section of the email.
                        </small>
                    </div>

                    <div class="alert alert-info">
                        <h6><i class="fas fa-users me-2"></i>Email Recipients:</h6>
                        <ul class="mb-0">
                            <li><strong>Lead:</strong> Will receive the email with your custom message</li>
                            <li><strong>General Managers:</strong> Will receive a copy with your custom message</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="sendWithoutMessage">
                        <i class="fas fa-paper-plane"></i> Send Without Message
                    </button>
                    <button type="submit" class="btn btn-warning" id="sendCustomMessage">
                        <i class="fas fa-envelope"></i> Send Custom Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function clearSelection() {
    $('.lead-checkbox').prop('checked', false);
    $('#selectAll').prop('checked', false);
    updateBulkActions();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/leads/duedate.blade.php ENDPATH**/ ?>