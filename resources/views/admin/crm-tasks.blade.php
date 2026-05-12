@extends('admin.admin_master')

@section('title', 'NIRCRM Tasks - Admin Panel')

@section('page-title', 'NIRCRM Tasks')

@section('admin')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-0">
                        <i class="fas fa-tasks text-primary me-2"></i>
                        NIRCRM Employee Tasks
                    </h2>
                    <p class="text-muted mb-0">Manage and monitor all employee tasks</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="refreshTasks()">
                        <i class="fas fa-sync-alt me-1"></i>Refresh
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm" onclick="exportTasks()">
                        <i class="fas fa-download me-1"></i>Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-list text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Total Tasks</h6>
                            <h3 class="mb-0">{{ $totalTasks }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Completed</h6>
                            <h3 class="mb-0 text-success">{{ $completedTasks }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-clock text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">In Progress</h6>
                            <h3 class="mb-0 text-warning">{{ $inProgressTasks }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-hourglass-half text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Pending</h6>
                            <h3 class="mb-0 text-info">{{ $pendingTasks }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>
                    All Employee Tasks
                </h5>
                <div class="d-flex gap-2 flex-wrap">
                    <!-- Filter by Status -->
                    <select class="form-select form-select-sm" id="statusFilter" onchange="filterTasks()" style="width: 150px;">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="stopped">Stopped</option>
                        <option value="on_hold">On Hold</option>
                    </select>
                    
                    <!-- Filter by Employee -->
                    <select class="form-select form-select-sm" id="employeeFilter" onchange="filterTasks()" style="width: 180px;">
                        <option value="">All Employees</option>
                        @foreach($tasks->pluck('user.name', 'user.id')->unique() as $userId => $userName)
                            <option value="{{ $userId }}">{{ $userName }}</option>
                        @endforeach
                    </select>
                    
                    <!-- Date Range Filter -->
                    <input type="date" class="form-control form-control-sm" id="dateFromFilter" placeholder="From Date" onchange="filterTasks()" style="width: 140px;">
                    <input type="date" class="form-control form-control-sm" id="dateToFilter" placeholder="To Date" onchange="filterTasks()" style="width: 140px;">
                    
                    <!-- Search -->
                    <div class="input-group" style="width: 250px;">
                        <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Search tasks..." onkeyup="searchTasks()">
                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="clearSearch()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <!-- Clear Filters -->
                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="clearAllFilters()">
                        <i class="fas fa-filter-circle-xmark me-1"></i>Clear Filters
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tasksTable">
                    <thead class="table-light">
                        <tr>
                            <th>Task #</th>
                            <th>Employee</th>
                            <th>Client/Project</th>
                            <th>Task Description</th>
                            <th>Task Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tasks->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0">No tasks found</p>
                                        <small>Employee tasks will appear here once created</small>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach($tasks as $task)
                            <tr data-status="{{ $task->status }}" data-employee="{{ $task->user->name ?? 'N/A' }}" data-employee-id="{{ $task->user_id ?? '' }}" data-date="{{ $task->task_date ? $task->task_date->format('Y-m-d') : '' }}">
                                <td>
                                    <span class="badge bg-light text-dark">#{{ $task->task_number }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2" style="width: 32px; height: 32px;">
                                            <i class="fas fa-user text-primary" style="font-size: 12px;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $task->user->name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $task->user->email ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-briefcase text-muted me-2"></i>
                                        <div>
                                            <div class="fw-medium">{{ Str::limit($task->client_project_name ?? 'N/A', 25) }}</div>
                                            @if(strlen($task->client_project_name ?? '') > 25)
                                                <small class="text-muted">{{ Str::limit($task->client_project_name, 40) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="task-description" style="max-width: 250px;">
                                        {{ Str::limit($task->task_description ?? 'N/A', 60) }}
                                        @if(strlen($task->task_description ?? '') > 60)
                                            <span class="text-muted">...</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-alt text-muted me-2"></i>
                                        <div>
                                            <div>{{ \Carbon\Carbon::parse($task->task_date)->format('d-m-Y|h:i A') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @switch($task->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock me-1"></i>Pending
                                            </span>
                                        @break
                                        @case('in_progress')
                                            <span class="badge bg-info text-white">
                                                <i class="fas fa-spinner me-1"></i>In Progress
                                            </span>
                                        @break
                                        @case('completed')
                                            <span class="badge bg-success text-white">
                                                <i class="fas fa-check-circle me-1"></i>Completed
                                            </span>
                                        @break
                                        @case('stopped')
                                            <span class="badge bg-danger text-white">
                                                <i class="fas fa-stop-circle me-1"></i>Stopped
                                            </span>
                                        @break
                                        @case('on_hold')
                                            <span class="badge bg-secondary text-white">
                                                <i class="fas fa-pause-circle me-1"></i>On Hold
                                            </span>
                                        @break
                                        @default
                                            <span class="badge bg-secondary text-white">
                                                <i class="fas fa-question me-1"></i>{{ $task->status }}
                                            </span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="viewTask({{ $task->id }})" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-success btn-sm" onclick="editTask({{ $task->id }})" title="Edit Task">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteTask({{ $task->id }})" title="Delete Task">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Task Details Modal -->
<div class="modal fade" id="taskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-tasks me-2"></i>
                    Task Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="taskDetails">
                    <!-- Task details will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.task-description {
    line-height: 1.4;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: var(--text-primary);
    background: #f8f9fa;
}

.table td {
    vertical-align: middle;
    border-color: #e5e7eb;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.form-select-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.form-control-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

/* Enhanced table styling */
.table-hover tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05);
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: all 0.2s ease;
}

/* Status badge animations */
.badge {
    transition: all 0.2s ease;
}

.badge:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Filter controls styling */
.form-select:focus, .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Enhanced modal styling */
.modal-content {
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-radius: 15px;
}

.modal-header {
    border-bottom: 1px solid #e5e7eb;
    border-radius: 15px 15px 0 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

/* Statistics card hover effects */
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .d-flex.flex-wrap {
        flex-direction: column;
        gap: 0.5rem !important;
    }
    
    .form-select-sm, .form-control-sm {
        width: 100% !important;
    }
}

/* Edit Modal Styling */
#editTaskModal .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
}

#editTaskModal .modal-header .btn-close {
    filter: brightness(0) invert(1);
}

#editTaskModal .form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

#editTaskModal .form-control:focus,
#editTaskModal .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

#editTaskModal .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

#editTaskModal .btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}
</style>
@endpush

@push('scripts')
<script>
function refreshTasks() {
    window.location.reload();
}

function exportTasks() {
    // Export functionality can be implemented here
    alert('Export functionality will be implemented soon!');
}

function filterTasks() {
    const status = document.getElementById('statusFilter').value;
    const employeeId = document.getElementById('employeeFilter').value;
    const dateFrom = document.getElementById('dateFromFilter').value;
    const dateTo = document.getElementById('dateToFilter').value;
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    
    const rows = document.querySelectorAll('#tasksTable tbody tr');
    
    rows.forEach(row => {
        let showRow = true;
        
        // Filter by status
        if (status && row.dataset.status !== status) {
            showRow = false;
        }
        
        // Filter by employee
        if (employeeId && row.dataset.employeeId !== employeeId) {
            showRow = false;
        }
        
        // Filter by date range
        if (dateFrom && row.dataset.date < dateFrom) {
            showRow = false;
        }
        if (dateTo && row.dataset.date > dateTo) {
            showRow = false;
        }
        
        // Filter by search term
        if (searchTerm) {
            const employee = row.dataset.employee.toLowerCase();
            const text = row.textContent.toLowerCase();
            if (!employee.includes(searchTerm) && !text.includes(searchTerm)) {
                showRow = false;
            }
        }
        
        row.style.display = showRow ? '' : 'none';
    });
    
    updateVisibleCount();
}

function searchTasks() {
    filterTasks(); // Use the main filter function
}

function clearSearch() {
    document.getElementById('searchInput').value = '';
    filterTasks();
}

function clearAllFilters() {
    document.getElementById('statusFilter').value = '';
    document.getElementById('employeeFilter').value = '';
    document.getElementById('dateFromFilter').value = '';
    document.getElementById('dateToFilter').value = '';
    document.getElementById('searchInput').value = '';
    filterTasks();
}

function updateVisibleCount() {
    const visibleRows = document.querySelectorAll('#tasksTable tbody tr[style=""], #tasksTable tbody tr:not([style])').length;
    const totalRows = document.querySelectorAll('#tasksTable tbody tr').length;
    
    // Update count display if needed
    console.log(`Showing ${visibleRows} of ${totalRows} tasks`);
}

function formatDateTimeForInput(dateTimeString) {
    if (!dateTimeString) return '';
    
    // If it's already in the correct format (YYYY-MM-DDTHH:MM), return as is
    if (dateTimeString.includes('T') && dateTimeString.length >= 16) {
        return dateTimeString.substring(0, 16);
    }
    
    // Try to parse the date and format it
    try {
        const date = new Date(dateTimeString);
        if (isNaN(date.getTime())) {
            console.error('Invalid date:', dateTimeString);
            return '';
        }
        
        // Format as YYYY-MM-DDTHH:MM
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        
        return `${year}-${month}-${day}T${hours}:${minutes}`;
    } catch (error) {
        console.error('Error formatting date:', error);
        return '';
    }
}

function getStatusBadge(status) {
    const badges = {
        'pending': '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Pending</span>',
        'in_progress': '<span class="badge bg-info text-white"><i class="fas fa-spinner me-1"></i>In Progress</span>',
        'completed': '<span class="badge bg-success text-white"><i class="fas fa-check-circle me-1"></i>Completed</span>',
        'stopped': '<span class="badge bg-danger text-white"><i class="fas fa-stop-circle me-1"></i>Stopped</span>',
        'on_hold': '<span class="badge bg-secondary text-white"><i class="fas fa-pause-circle me-1"></i>On Hold</span>'
    };
    
    return badges[status] || '<span class="badge bg-secondary text-white"><i class="fas fa-question me-1"></i>' + status + '</span>';
}

function formatTaskDateTime(taskDate) {
    const date = new Date(taskDate);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const hours = date.getHours();
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const ampm = hours >= 12 ? 'PM' : 'AM';
    const formattedHours = hours % 12 || 12;
    
    return `${day}-${month}-${year}|${formattedHours}:${minutes} ${ampm}`;
}

function viewTask(taskId) {
    // Load task details into modal
    fetch(`/admin/crm-tasks/${taskId}/details`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('taskDetails').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <strong>Task #:</strong> <span class="badge bg-primary">#${data.task_number}</span><br><br>
                        <strong>Employee:</strong><br>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2" style="width: 32px; height: 32px;">
                                <i class="fas fa-user text-primary" style="font-size: 12px;"></i>
                            </div>
                            <div>
                                <div class="fw-medium">${data.user.name || 'N/A'}</div>
                                <small class="text-muted">${data.user.email || 'N/A'}</small>
                            </div>
                        </div>
                        
                        <strong>Client/Project:</strong><br>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-briefcase text-muted me-2"></i>
                            <span>${data.client_project_name || 'N/A'}</span>
                        </div>
                        
                        <strong>Date & Time:</strong><br>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-calendar-alt text-muted me-2"></i>
                            <span>${formatTaskDateTime(data.task_date)}</span>
                        </div>
                        
                        <strong>Status:</strong><br>
                        <div class="mb-3">
                            ${getStatusBadge(data.status)}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <strong>Task Description:</strong><br>
                        <div class="alert alert-light">
                            <p class="mb-0">${data.task_description || 'No description provided'}</p>
                        </div>
                    </div>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('taskModal')).show();
        })
        .catch(error => {
            console.error('Error loading task details:', error);
            alert('Error loading task details');
        });
}

function editTask(taskId) {
    // Load task data and open edit modal
    fetch(`/admin/task/${taskId}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                openEditModal(data.task);
            } else {
                alert('Error loading task for editing: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error loading task for editing:', error);
            alert('Error loading task for editing');
        });
}

function openEditModal(task) {
    const modalHtml = `
        <div class="modal fade" id="editTaskModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-edit me-2"></i>
                            Edit Task #${task.task_number}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editTaskForm">
                            <input type="hidden" name="task_id" value="${task.id}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Task Date & Time</label>
                                        <input type="datetime-local" class="form-control" name="task_date" value="${formatDateTimeForInput(task.task_date)}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Client/Project Name</label>
                                        <input type="text" class="form-control" name="client_project_name" value="${task.client_project_name}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="status" required>
                                            <option value="pending" ${task.status === 'pending' ? 'selected' : ''}>Pending</option>
                                            <option value="in_progress" ${task.status === 'in_progress' ? 'selected' : ''}>In Progress</option>
                                            <option value="completed" ${task.status === 'completed' ? 'selected' : ''}>Completed</option>
                                            <option value="stopped" ${task.status === 'stopped' ? 'selected' : ''}>Stopped</option>
                                            <option value="on_hold" ${task.status === 'on_hold' ? 'selected' : ''}>On Hold</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Employee</label>
                                        <input type="text" class="form-control" value="${task.user ? task.user.name : 'N/A'}" readonly>
                                        <small class="text-muted">Task assigned to: ${task.user ? task.user.email : 'N/A'}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Task Description</label>
                                        <textarea class="form-control" name="task_description" rows="4" required>${task.task_description}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveTaskChanges()">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if present
    const existingModal = document.getElementById('editTaskModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add new modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editTaskModal'));
    modal.show();
    
    // Clean up modal after hidden
    document.getElementById('editTaskModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

function saveTaskChanges() {
    const form = document.getElementById('editTaskForm');
    const formData = new FormData(form);
    const taskId = formData.get('task_id');
    
    fetch(`/admin/task/${taskId}/update`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            task_date: formData.get('task_date'),
            client_project_name: formData.get('client_project_name'),
            task_description: formData.get('task_description'),
            status: formData.get('status')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Task updated successfully!');
            bootstrap.Modal.getInstance(document.getElementById('editTaskModal')).hide();
            location.reload(); // Refresh to show updated data
        } else {
            alert('Error updating task: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error updating task:', error);
        alert('Error updating task');
    });
}

function deleteTask(taskId) {
    if (confirm('Are you sure you want to delete this task?')) {
        fetch(`/admin/crm-tasks/${taskId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Task deleted successfully!');
                refreshTasks();
            } else {
                alert('Error deleting task: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error deleting task:', error);
            alert('Error deleting task');
        });
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
