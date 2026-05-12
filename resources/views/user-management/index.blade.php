@extends('admin.admin_master')

@section('page-title', 'User Management')

@section('admin')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-dark mb-2">
                        <i class="fas fa-users-cog text-primary me-2"></i>User Management
                    </h2>
                    <p class="text-muted mb-0">
                        Manage users, assign shifts, and control access permissions
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('attendance.dashboard') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <button type="button" class="btn btn-success btn-lg" onclick="showBulkAssignModal()">
                        <i class="fas fa-users-gear me-2"></i>Bulk Assign Shifts
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="fw-bold mb-1">{{ $users->count() }}</h3>
                            <p class="text-muted mb-0">Total Users</p>
                        </div>
                        <div class="ms-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-users text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="fw-bold mb-1 text-success">{{ $users->where('is_active', true)->count() }}</h3>
                            <p class="text-muted mb-0">Active Users</p>
                        </div>
                        <div class="ms-3">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="fas fa-user-check text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="fw-bold mb-1 text-warning">{{ $users->where('is_active', false)->count() }}</h3>
                            <p class="text-muted mb-0">Inactive Users</p>
                        </div>
                        <div class="ms-3">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="fas fa-user-times text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="fw-bold mb-1 text-info">{{ $shifts->count() }}</h3>
                            <p class="text-muted mb-0">Available Shifts</p>
                        </div>
                        <div class="ms-3">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="fas fa-clock text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 text-primary fw-bold">
                            <i class="fas fa-list me-2"></i>Users List
                        </h6>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control" id="searchUsers" placeholder="Search users..." style="width: 250px;">
                            <select class="form-select" id="filterDepartment" style="width: 200px;">
                                <option value="">All Departments</option>
                                @foreach($users->pluck('department')->filter() as $dept)
                                    <option value="{{ $dept }}">{{ $dept }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="usersTable">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Department</th>
                                    <th>Position</th>
                                    <th>Current Shift</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($users->count() > 0)
                                    @foreach($users as $user)
                                        <tr class="user-row" data-name="{{ $user->name }}" data-department="{{ $user->department }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3" 
                                                         style="width: 40px; height: 40px; font-size: 16px; font-weight: bold;">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                                        <small class="text-muted">{{ $user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($user->department)
                                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-1">
                                                        {{ $user->department }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $user->position ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                @if($user->shift)
                                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-1">
                                                        {{ $user->shift->name }}
                                                        <small>({{ $user->shift->start_time->format('H:i') }} - {{ $user->shift->end_time->format('H:i') }})</small>
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1">No Shift</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-primary" onclick="editUser({{ $user->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-{{ $user->is_active ? 'warning' : 'success' }}" 
                                                            onclick="toggleUserStatus({{ $user->id }}, {{ $user->is_active ? 'false' : 'true' }})">
                                                        <i class="fas fa-{{ $user->is_active ? 'user-slash' : 'user-check' }}"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-info" onclick="assignShift({{ $user->id }})">
                                                        <i class="fas fa-clock"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-users-slash fa-3x mb-3"></i>
                                                <h5>No users found</h5>
                                                <p>There are no users to manage at the moment.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Assign Shift Modal -->
<div class="modal fade" id="bulkAssignModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-users-gear me-2"></i>Bulk Assign Shifts
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="bulkAssignForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Select Users</label>
                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                @foreach($users as $user)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="user_ids[]" value="{{ $user->id }}" id="user_{{ $user->id }}">
                                        <label class="form-check-label" for="user_{{ $user->id }}">
                                            {{ $user->name }} - {{ $user->email }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Select Shift</label>
                            <select class="form-select" name="shift_id" required>
                                <option value="">Choose Shift</option>
                                @foreach($shifts as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->name }} ({{ $shift->start_time->format('H:i') }} - {{ $shift->end_time->format('H:i') }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitBulkAssign()">Assign Shifts</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showBulkAssignModal() {
    var modal = new bootstrap.Modal(document.getElementById('bulkAssignModal'));
    modal.show();
}

function submitBulkAssign() {
    var form = document.getElementById('bulkAssignForm');
    var formData = new FormData(form);
    
    fetch('/users/bulk-assign-shift', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Shifts assigned successfully!');
            location.reload();
        } else {
            alert(data.message || 'Failed to assign shifts');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to assign shifts. Please try again.');
    });
}

function toggleUserStatus(userId, newStatus) {
    if (!confirm('Are you sure you want to ' + (newStatus ? 'activate' : 'deactivate') + ' this user?')) {
        return;
    }
    
    fetch('/users/toggle-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            user_id: userId,
            is_active: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('User status updated successfully!');
            location.reload();
        } else {
            alert(data.message || 'Failed to update user status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update user status. Please try again.');
    });
}

function editUser(userId) {
    // Implement edit user functionality
    alert('Edit user functionality coming soon!');
}

function assignShift(userId) {
    // Implement individual shift assignment
    alert('Individual shift assignment coming soon!');
}

// Search functionality
document.getElementById('searchUsers').addEventListener('input', function() {
    var searchTerm = this.value.toLowerCase();
    var rows = document.querySelectorAll('.user-row');
    
    rows.forEach(function(row) {
        var name = row.getAttribute('data-name').toLowerCase();
        row.style.display = name.includes(searchTerm) ? '' : 'none';
    });
});

// Department filter
document.getElementById('filterDepartment').addEventListener('change', function() {
    var filterValue = this.value;
    var rows = document.querySelectorAll('.user-row');
    
    rows.forEach(function(row) {
        var department = row.getAttribute('data-department');
        row.style.display = !filterValue || department === filterValue ? '' : 'none';
    });
});
</script>
@endpush

@push('styles')
<style>
.card {
    transition: transform 0.2s ease-in-out;
}
.card:hover {
    transform: translateY(-2px);
}
.badge {
    font-size: 0.75rem;
}
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}
.user-row {
    transition: background-color 0.2s ease-in-out;
}
.user-row:hover {
    background-color: #f8f9fa;
}
.btn {
    transition: all 0.2s ease-in-out;
}
.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.rounded-circle {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endpush
