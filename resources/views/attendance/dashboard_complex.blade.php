@extends('admin.admin_master')

@section('page-title', 'Attendance Dashboard')

@section('admin')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-dark mb-2">
                        <i class="fas fa-clock text-primary me-2"></i>Attendance Dashboard
                    </h2>
                    <p class="text-muted mb-0">
                        Welcome back, <span class="fw-semibold">{{ Auth::user()->name }}</span>!
                        @if(Auth::user()->department)
                            @if(is_object(Auth::user()->department))
                                - {{ Auth::user()->department->name }} Department
                            @else
                                - {{ Auth::user()->department }} Department
                            @endif
                        @endif
                    </p>
                </div>
                <div class="d-flex gap-2">
                    @if(Auth::user()->role == 1 || Auth::user()->role == 5)
                        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#markAttendanceModal">
                            <i class="fas fa-user-check me-2"></i>Mark Attendance
                        </button>
                        <a href="{{ route('shifts.index') }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-cog me-2"></i>Manage Shifts
                        </a>
                        <button type="button" class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#userManagementModal">
                            <i class="fas fa-users-cog me-2"></i>Manage Users
                        </button>
                    @endif
                    <a href="{{ route('attendance.report') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-chart-bar me-2"></i>Reports
                    </a>
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
                            <h3 class="fw-bold mb-1">{{ $stats['total'] }}</h3>
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
                            <h3 class="fw-bold mb-1 text-success">{{ $stats['present'] }}</h3>
                            <p class="text-muted mb-0">Present Today</p>
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
                            <h3 class="fw-bold mb-1 text-danger">{{ $stats['absent'] }}</h3>
                            <p class="text-muted mb-0">Absent Today</p>
                        </div>
                        <div class="ms-3">
                            <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                                <i class="fas fa-user-times text-danger fs-4"></i>
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
                            <h3 class="fw-bold mb-1 text-warning">{{ $stats['onLeave'] }}</h3>
                            <p class="text-muted mb-0">On Leave</p>
                        </div>
                        <div class="ms-3">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="fas fa-calendar-times text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    @if(Auth::user()->role != 3)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-bolt text-warning me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-success btn-lg" id="checkInBtn">
                            <i class="fas fa-sign-in-alt me-2"></i>Check In
                        </button>
                        <button type="button" class="btn btn-danger btn-lg" id="checkOutBtn">
                            <i class="fas fa-sign-out-alt me-2"></i>Check Out
                        </button>
                        <button type="button" class="btn btn-info btn-lg" id="refreshBtn">
                            <i class="fas fa-sync-alt me-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Today's Attendance Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-calendar-day text-primary me-2"></i>
                            Today's Attendance - {{ Carbon\Carbon::today()->format('d M Y') }}
                        </h5>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control" id="searchInput" placeholder="Search employees...">
                            <select class="form-select" id="departmentFilter">
                                <option value="">All Departments</option>
                                @foreach($users->pluck('department')->unique()->filter() as $department)
                                    <option value="{{ $department }}">{{ $department }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="attendanceTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Shift</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Working Hours</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $userItem)
                                    <tr class="attendance-row" data-department="{{ $userItem->department->name ?? 'N/A' }}" data-name="{{ $userItem->name }} {{ $userItem->last_name ?? '' }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $userItem->name }} {{ $userItem->last_name ?? '' }}</div>
                                                    <small class="text-muted">{{ $userItem->role_name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $userItem->department->name ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            @if($userItem->shift)
                                                <div>
                                                    <span class="badge bg-info">{{ $userItem->shift->name }}</span>
                                                    <br><small class="text-muted">{{ $userItem->shift->start_time->format('H:i') }} - {{ $userItem->shift->end_time->format('H:i') }}</small>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary">Default Shift</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($todayAttendances->has($userItem->id))
                                                <div>
                                                    {{ $todayAttendances[$userItem->id]->check_in_time ? Carbon\Carbon::parse($todayAttendances[$userItem->id]->check_in_time)->format('H:i:s') : 'N/A' }}
                                                    @if($todayAttendances[$userItem->id]->is_late)
                                                        <span class="badge bg-warning text-dark ms-1">Late</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($todayAttendances->has($userItem->id))
                                                <div>
                                                    {{ $todayAttendances[$userItem->id]->check_out_time ? Carbon\Carbon::parse($todayAttendances[$userItem->id]->check_out_time)->format('H:i:s') : 'N/A' }}
                                                    @if($todayAttendances[$userItem->id]->is_early_checkout)
                                                        <span class="badge bg-warning text-dark ms-1">Early</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($todayAttendances->has($userItem->id))
                                                <span class="fw-semibold">{{ $todayAttendances[$userItem->id]->working_hours ?? 'N/A' }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($todayAttendances->has($userItem->id))
                                                <span class="badge bg-{{ $todayAttendances[$userItem->id]->status == 'present' ? 'success' : ($todayAttendances[$userItem->id]->status == 'absent' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $todayAttendances[$userItem->id]->status)) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Not Marked</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(in_array(Auth::user()->role, [1, 5]))
                                                <button class="btn btn-sm btn-outline-primary edit-attendance" 
                                                        data-user-id="{{ $userItem->id }}" 
                                                        data-date="{{ Carbon\Carbon::today()->format('Y-m-d') }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-clock text-primary me-2"></i>Attendance Check
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="attendanceContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Checking your attendance status...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitAttendance">
                    <i class="fas fa-check me-2"></i>Mark Attendance
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Mark Attendance Modal -->
@if(in_array(Auth::user()->role, [1, 5]))
<div class="modal fade" id="markAttendanceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-user-check text-primary me-2"></i>Mark Attendance
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="markAttendanceForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label fw-semibold">Employee</label>
                        <select name="user_id" class="form-select form-select-lg" required>
                            <option value="">Select Employee</option>
                            @foreach($users as $userItem)
                                <option value="{{ $userItem->id }}">{{ $userItem->name }} {{ $userItem->last_name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label fw-semibold">Date</label>
                        <input type="date" name="date" class="form-control form-control-lg" value="{{ Carbon\Carbon::today()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select form-select-lg" required>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="half_day">Half Day</option>
                            <option value="on_leave">On Leave</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label fw-semibold">Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Add any notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-check me-2"></i>Mark Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- User Management Modal -->
@if(in_array(Auth::user()->role, [1, 5]))
<div class="modal fade" id="userManagementModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-users-cog text-primary me-2"></i>User Management
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Current Shift</th>
                                <th>Assign New Shift</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $userItem)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $userItem->name }} {{ $userItem->last_name ?? '' }}</div>
                                                <small class="text-muted">{{ $userItem->role_name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $userItem->department->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        @if($userItem->shift)
                                            <span class="badge bg-info">{{ $userItem->shift->name }}</span>
                                            <br><small class="text-muted">{{ $userItem->shift->start_time->format('H:i') }} - {{ $userItem->shift->end_time->format('H:i') }}</small>
                                        @else
                                            <span class="badge bg-secondary">No Shift</span>
                                        @endif
                                    </td>
                                    <td>
                                        <select class="form-select user-shift-select" data-user-id="{{ $userItem->id }}">
                                            <option value="">No Shift</option>
                                            @foreach($shifts ?? [] as $shift)
                                                <option value="{{ $shift->id }}" {{ $userItem->shift_id == $shift->id ? 'selected' : '' }}>
                                                    {{ $shift->name }} ({{ $shift->start_time->format('H:i') }} - {{ $shift->end_time->format('H:i') }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $userItem->is_active ? 'success' : 'danger' }}">
                                            {{ $userItem->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm {{ $userItem->is_active ? 'btn-warning' : 'btn-success' }} toggle-user-status" 
                                                data-user-id="{{ $userItem->id }}" 
                                                data-status="{{ $userItem->is_active ? '0' : '1' }}">
                                            <i class="fas fa-{{ $userItem->is_active ? 'user-slash' : 'user-check' }} me-1"></i>
                                            {{ $userItem->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
.attendance-row {
    transition: background-color 0.2s ease-in-out;
}
.attendance-row:hover {
    background-color: #f8f9fa;
}
.btn {
    transition: all 0.2s ease-in-out;
}
.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.modal-content {
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
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

@push('scripts')
<script>
$(document).ready(function() {
    // Check attendance status on page load
    @if(Auth::user()->role != 3)
    checkAttendanceStatus();
    @endif

    // Search functionality
    $('#searchInput').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        $('.attendance-row').each(function() {
            var name = $(this).data('name').toLowerCase();
            var department = $(this).data('department').toLowerCase();
            if (name.includes(searchTerm) || department.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Department filter
    $('#departmentFilter').on('change', function() {
        var selectedDept = $(this).val();
        $('.attendance-row').each(function() {
            var department = $(this).data('department');
            if (selectedDept === '' || department === selectedDept) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Refresh button
    $('#refreshBtn').click(function() {
        location.reload();
    });

    function checkAttendanceStatus() {
        $.get('/attendance/check-status')
            .done(function(response) {
                if (response.show_attendance && !response.already_checked_in) {
                    showAttendanceModal(response);
                }
            })
            .fail(function() {
                console.log('Failed to check attendance status');
            });
    }

    function showAttendanceModal(data) {
        var alertClass = data.is_on_time ? 'success' : 'warning';
        var content = '<div class="text-center">' +
            '<div class="mb-4">' +
                '<div class="rounded-circle bg-primary bg-opacity-10 p-4 d-inline-block mb-3">' +
                    '<i class="fas fa-clock text-primary fs-1"></i>' +
                '</div>' +
            '</div>' +
            '<h5 class="fw-bold mb-3">Your Attendance Status</h5>' +
            '<div class="row mb-3">' +
                '<div class="col-md-6">' +
                    '<p class="mb-2"><strong>Shift:</strong> ' + data.shift_name + '</p>' +
                    '<p class="mb-2"><strong>Time:</strong> ' + data.shift_time + '</p>' +
                '</div>' +
                '<div class="col-md-6">' +
                    '<p class="mb-2"><strong>Status:</strong> <div class="alert alert-' + alertClass + '">' + data.status_message + '</div></p>' +
                    '<p class="mb-2"><strong>Current Time:</strong> ' + new Date().toLocaleTimeString() + '</p>' +
                '</div>' +
            '</div>' +
            '<div class="alert alert-info">' +
                '<i class="fas fa-info-circle me-2"></i>' +
                'Click "Mark Attendance" to record your check-in for today.' +
            '</div>' +
        '</div>';
        
        $('#attendanceContent').html(content);
        $('#attendanceModal').modal('show');
    }

    // Check In button
    $('#checkInBtn').click(function() {
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Checking In...');
        
        $.post('/attendance/check-in')
            .done(function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message);
                    btn.prop('disabled', false).html('<i class="fas fa-sign-in-alt me-2"></i>Check In');
                }
            })
            .fail(function() {
                alert('Failed to check in. Please try again.');
                btn.prop('disabled', false).html('<i class="fas fa-sign-in-alt me-2"></i>Check In');
            });
    });

    // Check Out button
    $('#checkOutBtn').click(function() {
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Checking Out...');
        
        $.post('/attendance/check-out')
            .done(function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message);
                    btn.prop('disabled', false).html('<i class="fas fa-sign-out-alt me-2"></i>Check Out');
                }
            })
            .fail(function() {
                alert('Failed to check out. Please try again.');
                btn.prop('disabled', false).html('<i class="fas fa-sign-out-alt me-2"></i>Check Out');
            });
    });

    // Submit Attendance from Modal
    $('#submitAttendance').click(function() {
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Marking...');
        
        $.post('/attendance/check-in')
            .done(function(response) {
                if (response.success) {
                    $('#attendanceModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                    btn.prop('disabled', false).html('<i class="fas fa-check me-2"></i>Mark Attendance');
                }
            })
            .fail(function() {
                alert('Failed to mark attendance. Please try again.');
                btn.prop('disabled', false).html('<i class="fas fa-check me-2"></i>Mark Attendance');
            });
    });

    // Mark Attendance Form
    $('#markAttendanceForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');
        
        $.post('/attendance/mark', formData)
            .done(function(response) {
                if (response.success) {
                    $('#markAttendanceModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                    btn.prop('disabled', false).html('<i class="fas fa-check me-2"></i>Mark Attendance');
                }
            })
            .fail(function() {
                alert('Failed to mark attendance. Please try again.');
                btn.prop('disabled', false).html('<i class="fas fa-check me-2"></i>Mark Attendance');
            });
    });

    // User shift assignment
    $('.user-shift-select').change(function() {
        var userId = $(this).data('user-id');
        var shiftId = $(this).val();
        var select = $(this);
        
        if (confirm('Are you sure you want to assign this shift?')) {
            select.prop('disabled', true);
            
            $.post('/shifts/assign', {
                user_id: userId,
                shift_id: shiftId,
                _token: $('meta[name="csrf-token"]').attr('content')
            })
            .done(function(response) {
                if (response.success) {
                    alert('Shift assigned successfully');
                } else {
                    alert(response.message);
                }
                select.prop('disabled', false);
            })
            .fail(function() {
                alert('Failed to assign shift. Please try again.');
                select.prop('disabled', false);
            });
        }
    });

    // Toggle user status
    $('.toggle-user-status').click(function() {
        var userId = $(this).data('user-id');
        var status = $(this).data('status');
        var button = $(this);
        
        if (confirm('Are you sure you want to ' + (status == '1' ? 'activate' : 'deactivate') + ' this user?')) {
            button.prop('disabled', true);
            
            $.post('/users/toggle-status', {
                user_id: userId,
                is_active: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            })
            .done(function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message);
                    button.prop('disabled', false);
                }
            })
            .fail(function() {
                alert('Failed to update user status. Please try again.');
                button.prop('disabled', false);
            });
        }
    });

    // Edit attendance
    $('.edit-attendance').click(function() {
        var userId = $(this).data('user-id');
        var date = $(this).data('date');
        
        // Open mark attendance modal with pre-filled data
        $('#markAttendanceModal').modal('show');
        $('#markAttendanceForm select[name="user_id"]').val(userId);
        $('#markAttendanceForm input[name="date"]').val(date);
    });
});
</script>
@endpush
