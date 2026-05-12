@extends('admin.admin_master')

@section('page-title', 'Attendance Dashboard')

@section('admin')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="page-title mb-1">Attendance Dashboard</h4>
                    <p class="text-muted mb-0">
                        Welcome back, {{ Auth::user()->name }}! 
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#markAttendanceModal">
                            <i class="fas fa-user-check"></i> Mark Attendance
                        </button>
                        <a href="{{ route('shifts.index') }}" class="btn btn-warning">
                            <i class="fas fa-cog"></i> Manage Shifts
                        </a>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#userManagementModal">
                            <i class="fas fa-users-cog"></i> Manage Users
                        </button>
                    @endif
                    <a href="{{ route('attendance.report') }}" class="btn btn-outline-primary">
                        <i class="fas fa-chart-bar"></i> Reports
                    </a>
                    <a href="{{ route('leave.calendar') }}" class="btn btn-outline-info">
                        <i class="fas fa-calendar-alt"></i> Leave Calendar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total'] }}</div>
                <div class="stat-label">
                    <i class="fas fa-users me-2"></i>Total Users
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-number text-success">{{ $stats['present'] }}</div>
                <div class="stat-label">
                    <i class="fas fa-user-check me-2"></i>Present
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-number text-danger">{{ $stats['absent'] }}</div>
                <div class="stat-label">
                    <i class="fas fa-user-times me-2"></i>Absent
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-number text-warning">{{ $stats['onLeave'] }}</div>
                <div class="stat-label">
                    <i class="fas fa-calendar-times me-2"></i>On Leave
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    @if(Auth::user()->role != 3)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success" id="checkInBtn">
                            <i class="fas fa-sign-in-alt"></i> Check In
                        </button>
                        <button type="button" class="btn btn-danger" id="checkOutBtn">
                            <i class="fas fa-sign-out-alt"></i> Check Out
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
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Today's Attendance - {{ Carbon\Carbon::today()->format('d M Y') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
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
                                    <tr>
                                        <td>
                                            {{ $userItem->name }} {{ $userItem->last_name ?? '' }}
                                            <br><small class="text-muted">{{ $userItem->role_name }}</small>
                                        </td>
                                        <td>{{ $userItem->department->name ?? 'N/A' }}</td>
                                        <td>
                                            @if($userItem->shift)
                                                {{ $userItem->shift->name }}
                                                <br><small class="text-muted">{{ $userItem->shift->start_time->format('H:i') }} - {{ $userItem->shift->end_time->format('H:i') }}</small>
                                            @else
                                                Default Shift
                                            @endif
                                        </td>
                                        <td>
                                            @if($todayAttendances->has($userItem->id))
                                                {{ $todayAttendances[$userItem->id]->check_in_time ? Carbon\Carbon::parse($todayAttendances[$userItem->id]->check_in_time)->format('H:i:s') : 'N/A' }}
                                                @if($todayAttendances[$userItem->id]->is_late)
                                                    <span class="badge bg-warning text-dark">Late</span>
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($todayAttendances->has($userItem->id))
                                                {{ $todayAttendances[$userItem->id]->check_out_time ? Carbon\Carbon::parse($todayAttendances[$userItem->id]->check_out_time)->format('H:i:s') : 'N/A' }}
                                                @if($todayAttendances[$userItem->id]->is_early_checkout)
                                                    <span class="badge bg-warning text-dark">Early</span>
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($todayAttendances->has($userItem->id))
                                                {{ $todayAttendances[$userItem->id]->working_hours ?? 'N/A' }}
                                            @else
                                                -
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
                                                <button class="btn btn-sm btn-info edit-attendance" 
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Check</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="attendanceContent">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitAttendance">Mark Attendance</button>
            </div>
        </div>
    </div>
</div>

<!-- Mark Attendance Modal -->
@if(in_array(Auth::user()->role, [1, 5]))
<div class="modal fade" id="markAttendanceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mark Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="markAttendanceForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Employee</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Select Employee</option>
                            @foreach($users as $userItem)
                                <option value="{{ $userItem->id }}">{{ $userItem->name }} {{ $userItem->last_name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ Carbon\Carbon::today()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="half_day">Half Day</option>
                            <option value="on_leave">On Leave</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Mark Attendance</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- User Management Modal -->
@if(in_array(Auth::user()->role, [1, 5]))
<div class="modal fade" id="userManagementModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Management</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Shift</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $userItem)
                                <tr>
                                    <td>{{ $userItem->name }} {{ $userItem->last_name ?? '' }}</td>
                                    <td>{{ $userItem->department->name ?? 'N/A' }}</td>
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
.stat-card {
    background: var(--primary-gradient);
    color: white;
    padding: 1.5rem;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}
.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
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

    function checkAttendanceStatus() {
        $.get('/attendance/check-status')
            .done(function(response) {
                if (response.show_attendance && !response.already_checked_in) {
                    showAttendanceModal(response);
                }
            });
    }

    function showAttendanceModal(data) {
        var content = `
            <div class="text-center">
                <h5>Your Attendance Status</h5>
                <p><strong>Shift:</strong> ${data.shift_name}</p>
                <p><strong>Time:</strong> ${data.shift_time}</p>
                <p><strong>Status:</strong> <span class="badge bg-${data.is_on_time ? 'success' : 'warning'}">${data.status_message}</span></p>
                <p>Click "Mark Attendance" to record your check-in.</p>
            </div>
        `;
        
        $('#attendanceContent').html(content);
        $('#attendanceModal').modal('show');
    }

    // Check In button
    $('#checkInBtn').click(function() {
        $.post('/attendance/check-in')
            .done(function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message);
                }
            });
    });

    // Check Out button
    $('#checkOutBtn').click(function() {
        $.post('/attendance/check-out')
            .done(function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message);
                }
            });
    });

    // Submit Attendance from Modal
    $('#submitAttendance').click(function() {
        $.post('/attendance/check-in')
            .done(function(response) {
                if (response.success) {
                    $('#attendanceModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                }
            });
    });

    // Mark Attendance Form
    $('#markAttendanceForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        
        $.post('/attendance/mark', formData)
            .done(function(response) {
                if (response.success) {
                    $('#markAttendanceModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                }
            });
    });

    // User shift assignment
    $('.user-shift-select').change(function() {
        var userId = $(this).data('user-id');
        var shiftId = $(this).val();
        
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
        });
    });

    // Toggle user status
    $('.toggle-user-status').click(function() {
        var userId = $(this).data('user-id');
        var status = $(this).data('status');
        var button = $(this);
        
        if (confirm('Are you sure you want to ' + (status == '1' ? 'activate' : 'deactivate') + ' this user?')) {
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
                }
            });
        }
    });
});
</script>
@endpush
