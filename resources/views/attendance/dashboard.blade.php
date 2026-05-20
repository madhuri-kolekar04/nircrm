@include('partials.attendance-popup')
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
                    @if(Auth::user()->role == 1 || Auth::user()->role == 5 )
                    <button type="button" class="btn btn-primary btn-lg" onclick="showAttendancePopup()">
                            <i class="fas fa-user-check me-2"></i>Mark Attendance
                        </button>
                       
                        <a href="{{ route('shifts.index') }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-cog me-2"></i>Manage Shifts
                        </a>
                        <button type="button" class="btn btn-info btn-lg" onclick="showUserManagement()">
                            <i class="fas fa-users-cog me-2"></i>Manage Users
                        </button>
                    @endif
                    
                    <a href="{{ route('attendance.report') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-chart-bar me-2"></i>Reports
                    </a>
                    <a href="{{ route('leave.index') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-calendar-alt me-2"></i>Leaves
                    </a>
                </div> 


                <!-- <div class="d-flex gap-2">
                     @if(Auth::user()->role == 1 || Auth::user()->role == 5 )
                    <button type="button" class="btn btn-primary btn-lg" onclick="showAttendancePopup()">
                            <i class="fas fa-user-check me-2"></i>Mark Attendance
                        </button>
                       
                        <a href="{{ route('shifts.index') }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-cog me-2"></i>Manage Shifts
                        </a>
                        <button type="button" class="btn btn-info btn-lg" onclick="showUserManagement()">
                            <i class="fas fa-users-cog me-2"></i>Manage Users
                        </button>
                        

                    @elseif(Auth::user()->role == 2)
                        <button type="button" class="btn btn-primary btn-lg"   data-bs-toggle="modal" data-bs-target="#attendancePopupModal">
                                <i class="fas fa-user-check me-2"></i>Mark Attendance</button>
                        
                    @endif

                         <a href="{{ route('attendance.report') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-chart-bar me-2"></i>Reports
                       </a>
                        <a href="{{ route('leave.index') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-calendar-alt me-2"></i>Leaves
                        </a>
                </div> -->
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
                        <button type="button" class="btn btn-success btn-lg" onclick="quickCheckIn()">
                            <i class="fas fa-sign-in-alt me-2"></i>Check In
                        </button>
                        <button type="button" class="btn btn-danger btn-lg" onclick="quickCheckOut()">
                            <i class="fas fa-sign-out-alt me-2"></i>Check Out
                        </button>
                        <button type="button" class="btn btn-info btn-lg" onclick="location.reload()">
                            <i class="fas fa-sync-alt me-2"></i>Refresh
                        </button>
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
                            <input type="text" class="form-control" id="searchInput" placeholder="Search employees..." onkeyup="filterTable()">
                            <select class="form-select" id="departmentFilter" onchange="filterTable()">
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
                                                <button class="btn btn-sm btn-outline-primary" onclick="editAttendance({{ $userItem->id }}, '{{ Carbon\Carbon::today()->format('Y-m-d') }}')">
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

<!-- Simple Attendance Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 bg-primary text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-clock me-2"></i>Mark Your Attendance
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="attendanceContent">
                    <div class="text-center py-4">
                        <div class="mb-4">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-4 d-inline-block mb-3">
                                <i class="fas fa-clock text-primary fs-1"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-3">Welcome!</h5>
                        <p class="text-muted mb-4">Please mark your attendance for today</p>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Shift:</strong> <span id="modalShiftName">Loading...</span></p>
                                <p class="mb-2"><strong>Time:</strong> <span id="modalShiftTime">Loading...</span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Status:</strong> <span id="modalStatus" class="badge bg-success">On Time</span></p>
                                <p class="mb-2"><strong>Current Time:</strong> <span id="modalCurrentTime">Loading...</span></p>
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Click "Mark Attendance" to record your check-in for today.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-lg" onclick="submitAttendance()">
                    <i class="fas fa-check me-2"></i>Mark Attendance
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Simple JavaScript -->
<script>
function showAttendancePopup() {
    // Load attendance status
    fetch('/attendance/check-status')
        .then(response => response.json())
        .then(data => {
            if (data.show_attendance && !data.already_checked_in) {
                // Update modal content
                document.getElementById('modalShiftName').textContent = data.shift_name || 'Default Shift';
                document.getElementById('modalShiftTime').textContent = data.shift_time || '11:00 - 18:00';
                document.getElementById('modalCurrentTime').textContent = new Date().toLocaleTimeString();
                
                // Update status badge
                var statusElement = document.getElementById('modalStatus');
                statusElement.textContent = data.status_message;
                statusElement.className = 'badge bg-' + (data.is_on_time ? 'success' : 'warning');
                
                // Show modal
                var modal = new bootstrap.Modal(document.getElementById('attendanceModal'));
                modal.show();
            }
            
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load attendance status');
        });
}

function quickCheckIn() {
    var btn = event.target;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Checking In...';
    
    fetch('/attendance/check-in', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Failed to check in');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Check In';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to check in. Please try again.');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Check In';
    });
}

function quickCheckOut() {
    var btn = event.target;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Checking Out...';
    
    fetch('/attendance/check-out', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Failed to check out');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sign-out-alt me-2"></i>Check Out';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to check out. Please try again.');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-sign-out-alt me-2"></i>Check Out';
    });
}

function submitAttendance() {
    var btn = event.target;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Marking...';
    
    fetch('/attendance/check-in', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: 'location=Office'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            var modal = bootstrap.Modal.getInstance(document.getElementById('attendanceModal'));
            modal.hide();
            setTimeout(() => location.reload(), 500);
        } else {
            alert(data.message || 'Failed to mark attendance');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check me-2"></i>Mark Attendance';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to mark attendance: ' + error.message + '. Please check browser console for details.');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-check me-2"></i>Mark Attendance';
    });
}

function filterTable() {
    var searchInput = document.getElementById('searchInput').value.toLowerCase();
    var departmentFilter = document.getElementById('departmentFilter').value;
    var rows = document.querySelectorAll('.attendance-row');
    
    rows.forEach(function(row) {
        var name = row.getAttribute('data-name').toLowerCase();
        var department = row.getAttribute('data-department');
        var showRow = true;
        
        if (searchInput && !name.includes(searchInput)) {
            showRow = false;
        }
        
        if (departmentFilter && department !== departmentFilter) {
            showRow = false;
        }
        
        row.style.display = showRow ? '' : 'none';
    });
}

function showUserManagement() {
    // Redirect to user management or show user management modal
    window.location.href = '/users/with-shifts';
}

function editAttendance(userId, date) {
    // Find the attendance record for the given user and date
    fetch(`/attendance/data?date=${date}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const attendance = data.data.find(a => a.user_id == userId);
                if (attendance) {
                    // Navigate to the edit page
                    window.location.href = `/attendance/edit/${attendance.id}`;
                } else {
                    // Create new attendance record if it doesn't exist
                    fetch('/attendance/mark', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            user_id: userId,
                            date: date,
                            status: 'present'
                        })
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            window.location.href = `/attendance/edit/${result.data.id}`;
                        } else {
                            alert('Failed to create attendance record: ' + result.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to create attendance record');
                    });
                }
            } else {
                alert('Failed to load attendance data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load attendance data');
        });
}

// Auto-show popup on page load
// document.addEventListener('DOMContentLoaded', function() {
//     @if(Auth::user()->role != 3)
//     setTimeout(showAttendancePopup, 2000);
//     @endif
// });
</script>
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
