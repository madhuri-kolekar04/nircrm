<?php $__env->startSection('page-title', 'Employee Performance Report'); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="card-title mb-2">
                                <i class="fas fa-chart-line"></i> Employee Performance Report
                            </h3>
                            <p class="card-text mb-0">
                                Comprehensive analysis of employee project updates and performance metrics
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="<?php echo e(route('project-updates.index')); ?>" class="btn btn-light">
                                <i class="fas fa-arrow-left"></i> Back to Project Updates
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter"></i> Report Filters
                    </h5>
                </div>
                <div class="card-body">
                    <form id="reportFilterForm" method="POST" action="<?php echo e(route('employee-report.generate')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="time_filter" class="form-label">Time Period</label>
                                    <select class="form-select" id="time_filter" name="time_filter" onchange="updateDateFields()">
                                        <option value="custom">Custom Range</option>
                                        <option value="today">Today</option>
                                        <option value="week">This Week</option>
                                        <option value="month">This Month</option>
                                        <option value="quarter">This Quarter</option>
                                        <option value="year">This Year</option>
                                        <option value="all">All Time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="employee_id" class="form-label">Employee</label>
                                    <select class="form-select" id="employee_id" name="employee_id">
                                        <option value="">All Employees</option>
                                        <?php $__currentLoopData = $employees ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->name); ?> (<?php echo e(is_object($employee->department) ? ($employee->department->department ?? $employee->department->name ?? 'N/A') : $employee->department); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <select class="form-select" id="department" name="department">
                                        <option value="">All Departments</option>
                                        <?php $__currentLoopData = $departments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($department); ?>"><?php echo e($department); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo e($startDate->format('Y-m-d')); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo e($endDate->format('Y-m-d')); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label d-block">&nbsp;</label>
                                    <div class="btn-group w-100">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Generate
                                        </button>
                                        <button type="button" class="btn btn-success" onclick="exportReport()">
                                            <i class="fas fa-download"></i> Export
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

    <!-- Performance Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?php echo e(count($employeePerformanceData ?? [])); ?></h4>
                            <p class="card-text">Total Employees</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?php echo e(collect($performancePercentages ?? [])->avg('overall_score') ?? 0); ?>%</h4>
                            <p class="card-text">Avg Performance</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?php echo e(collect($performancePercentages ?? [])->where('grade', 'A+')->count()); ?></h4>
                            <p class="card-text">Top Performers</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-trophy fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?php echo e(collect($performancePercentages ?? [])->where('overall_score', '<', 50)->count()); ?></h4>
                            <p class="card-text">Need Improvement</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Performance Table -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar"></i> Employee Performance Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Completion %</th>
                                    <th>Efficiency %</th>
                                    <th>Response %</th>
                                    <th>Overall %</th>
                                    <th>Grade</th>
                                    <th>Total Tasks</th>
                                    <th>Completed</th>
                                    <th>Work Updates</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($employeePerformanceData) && count($employeePerformanceData) > 0): ?>
                                    <?php $__currentLoopData = $employeePerformanceData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employeeId => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $performance = $performancePercentages[$employeeId] ?? [];
                                            $gradeColor = [
                                                'A+' => 'success',
                                                'A' => 'success', 
                                                'B' => 'info',
                                                'C' => 'warning',
                                                'D' => 'danger',
                                                'F' => 'danger'
                                            ][$performance['grade'] ?? 'F'] ?? 'secondary';
                                        ?>
                                        <tr>
                                            <td>
                                              <strong><?php echo e($data['employee']->name ?? 'Employee Not Found'); ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary"><?php echo e($data['employee']->department ?? 'Employee Not Found'); ?></span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress me-2" style="width: 60px; height: 8px;">
                                                        <div class="progress-bar bg-info" style="width: <?php echo e($performance['completion_percentage'] ?? 0); ?>%"></div>
                                                    </div>
                                                    <small><?php echo e($performance['completion_percentage'] ?? 0); ?>%</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress me-2" style="width: 60px; height: 8px;">
                                                        <div class="progress-bar bg-success" style="width: <?php echo e($performance['efficiency_score'] ?? 0); ?>%"></div>
                                                    </div>
                                                    <small><?php echo e($performance['efficiency_score'] ?? 0); ?>%</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress me-2" style="width: 60px; height: 8px;">
                                                        <div class="progress-bar bg-warning" style="width: <?php echo e($performance['response_score'] ?? 0); ?>%"></div>
                                                    </div>
                                                    <small><?php echo e($performance['response_score'] ?? 0); ?>%</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress me-2" style="width: 60px; height: 8px;">
                                                        <div class="progress-bar bg-primary" style="width: <?php echo e($performance['overall_score'] ?? 0); ?>%"></div>
                                                    </div>
                                                    <small class="fw-bold"><?php echo e($performance['overall_score'] ?? 0); ?>%</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo e($gradeColor); ?> fs-6"><?php echo e($performance['grade'] ?? 'F'); ?></span>
                                            </td>
                                            <td><?php echo e($data['total_assigned_tasks'] + $data['total_work_updates']); ?></td>
                                            <td><?php echo e($data['completed_tasks']); ?></td>
                                            <td><?php echo e($data['total_work_updates']); ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-primary" onclick="viewEmployeeDetails(<?php echo e($employeeId); ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-success" onclick="exportEmployeeReport(<?php echo e($employeeId); ?>)">
                                                        <i class="fas fa-download"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="11" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                            No performance data available for the selected criteria.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Report via Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="emailForm" method="POST" action="<?php echo e(route('employee-report.email')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" id="email_start_date" name="start_date">
                    <input type="hidden" id="email_end_date" name="end_date">
                    <input type="hidden" id="email_employee_id" name="employee_id">
                    <input type="hidden" id="email_department" name="department">
                    
                    <div class="mb-3">
                        <label for="email_recipients" class="form-label">Email Recipients</label>
                        <textarea class="form-control" id="email_recipients" name="email_recipients" rows="3" 
                                  placeholder="Enter email addresses separated by commas" required></textarea>
                        <small class="text-muted">Multiple email addresses should be separated by commas</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-envelope"></i> Send Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function sendEmailReport() {
    // Copy form data to email modal
    document.getElementById('email_start_date').value = document.getElementById('start_date').value;
    document.getElementById('email_end_date').value = document.getElementById('end_date').value;
    document.getElementById('email_employee_id').value = document.getElementById('employee_id').value;
    document.getElementById('email_department').value = document.getElementById('department').value;
    
    // Show modal
    new bootstrap.Modal(document.getElementById('emailModal')).show();
}

function updateDateFields() {
    const timeFilter = document.getElementById('time_filter').value;
    const startDateField = document.getElementById('start_date');
    const endDateField = document.getElementById('end_date');
    const today = new Date();
    
    let startDate = new Date();
    let endDate = new Date();
    
    switch(timeFilter) {
        case 'today':
            startDate = today;
            endDate = today;
            break;
        case 'week':
            startDate = new Date(today.setDate(today.getDate() - today.getDay()));
            endDate = new Date(today.setDate(today.getDate() - today.getDay() + 6));
            break;
        case 'month':
            startDate = new Date(today.getFullYear(), today.getMonth(), 1);
            endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            break;
        case 'quarter':
            const quarter = Math.floor(today.getMonth() / 3);
            startDate = new Date(today.getFullYear(), quarter * 3, 1);
            endDate = new Date(today.getFullYear(), quarter * 3 + 3, 0);
            break;
        case 'year':
            startDate = new Date(today.getFullYear(), 0, 1);
            endDate = new Date(today.getFullYear(), 11, 31);
            break;
        case 'all':
            // Set to a very early date
            startDate = new Date(2020, 0, 1);
            endDate = today;
            break;
        default:
            return; // Keep custom dates
    }
    
    startDateField.value = formatDate(startDate);
    endDateField.value = formatDate(endDate);
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function viewEmployeeDetails(employeeId) {
    // Get current filter values
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const employeeIdField = document.getElementById('employee_id').value;
    const department = document.getElementById('department').value;
    
    // Build URL with parameters
    let url = `<?php echo e(route('employee-report.generate')); ?>?start_date=${startDate}&end_date=${endDate}`;
    
    // Add employee filter if not already set
    if (employeeIdField) {
        url += `&employee_id=${employeeId}`;
    } else {
        url += `&employee_id=${employeeId}`;
    }
    
    // Add department filter if set
    if (department) {
        url += `&department=${department}`;
    }
    
    // Open in new tab
    window.open(url, '_blank');
}

function exportReport() {
    // Export current report
    const form = document.getElementById('reportFilterForm');
    const formData = new FormData(form);
    
    // Create export URL
    const params = new URLSearchParams(formData);
    const exportUrl = `<?php echo e(route('employee-report.export')); ?>?${params.toString()}`;
    
    // Download file
    window.open(exportUrl, '_blank');
}

function exportEmployeeReport(employeeId) {
    // Export specific employee report
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const exportUrl = `<?php echo e(route('employee-report.export')); ?>?employee_id=${employeeId}&start_date=${startDate}&end_date=${endDate}`;
    
    window.open(exportUrl, '_blank');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set default time filter to "month"
    document.getElementById('time_filter').value = 'month';
    updateDateFields();
});

// Handle email form submission
document.getElementById('emailForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Report sent successfully!');
            bootstrap.Modal.getInstance(document.getElementById('emailModal')).hide();
        } else {
            alert('Failed to send report: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while sending the report.');
    });
});
</script>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}
.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.table th {
    border-top: none;
    font-weight: 600;
    background-color: #f8f9fa;
}

@media print {
    .btn, .no-print {
        display: none !important;
    }
    
    .card {
        border: 1px solid #ddd !important;
        page-break-inside: avoid;
    }
    
    .table {
        font-size: 12px;
    }
}
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/project_updates/employee_performance_report.blade.php ENDPATH**/ ?>