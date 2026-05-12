@extends('admin.admin_master')

@section('page-title', 'Attendance Dashboard')

@section('content')
<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Attendance Dashboard</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('attendance.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-list"></i> View All
                </a>
                @if(auth()->user()->canApproveLeave())
                    <a href="{{ route('attendance.reports') }}" class="btn btn-outline-success">
                        <i class="fas fa-chart-bar"></i> Reports
                    </a>
                @endif
            </div>
        </div>

        <!-- Today's Status Card -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-day"></i> Today's Attendance
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($todayAttendance)
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="p-3">
                                        <i class="fas fa-sign-in-alt fa-2x text-success"></i>
                                        <h6 class="mt-2">Check In</h6>
                                        <p class="h4 text-primary">{{ $todayAttendance->check_in_time }}</p>
                                        @if($todayAttendance->is_late)
                                            <span class="badge bg-warning">Late</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3">
                                        <i class="fas fa-sign-out-alt fa-2x text-danger"></i>
                                        <h6 class="mt-2">Check Out</h6>
                                        <p class="h4 text-primary">
                                            {{ $todayAttendance->check_out_time ?? '---' }}
                                        </p>
                                        @if($todayAttendance->is_early_checkout)
                                            <span class="badge bg-warning">Early</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($todayAttendance->working_hours)
                                <div class="text-center mt-3">
                                    <span class="badge bg-info">Working Hours: {{ $todayAttendance->working_hours }}h</span>
                                    @if($todayAttendance->overtime_hours > 0)
                                        <span class="badge bg-warning">Overtime: {{ $todayAttendance->overtime_hours }}h</span>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                                <h5>No attendance record for today</h5>
                                <p class="text-muted">Check in to start your day</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-mouse-pointer"></i> Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if(!$todayAttendance || !$todayAttendance->check_in_time)
                                <button onclick="checkIn()" class="btn btn-success btn-lg" id="checkInBtn">
                                    <i class="fas fa-sign-in-alt"></i> Check In
                                </button>
                            @elseif($todayAttendance->check_in_time && !$todayAttendance->check_out_time)
                                <button onclick="checkOut()" class="btn btn-danger btn-lg" id="checkOutBtn">
                                    <i class="fas fa-sign-out-alt"></i> Check Out
                                </button>
                            @else
                                <button class="btn btn-secondary btn-lg" disabled>
                                    <i class="fas fa-check"></i> Completed for Today
                                </button>
                            @endif
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Current Time: {{ now()->format('h:i A') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-check fa-2x mb-2"></i>
                        <h4>{{ $monthStats->total_days ?? 0 }}</h4>
                        <p class="mb-0">Total Days</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-user-check fa-2x mb-2"></i>
                        <h4>{{ $monthStats->present_days ?? 0 }}</h4>
                        <p class="mb-0">Present Days</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-user-times fa-2x mb-2"></i>
                        <h4>{{ $monthStats->absent_days ?? 0 }}</h4>
                        <p class="mb-0">Absent Days</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-plane fa-2x mb-2"></i>
                        <h4>{{ $monthStats->leave_days ?? 0 }}</h4>
                        <p class="mb-0">Leave Days</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- This Week's Attendance -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-week"></i> This Week's Attendance
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($weekAttendances->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Day</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Working Hours</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($weekAttendances as $attendance)
                                            <tr>
                                                <td>{{ $attendance->date->format('M d, Y') }}</td>
                                                <td>{{ $attendance->date->format('l') }}</td>
                                                <td>{{ $attendance->check_in_time ?? '---' }}</td>
                                                <td>{{ $attendance->check_out_time ?? '---' }}</td>
                                                <td>{{ $attendance->working_hours ? $attendance->working_hours . 'h' : '---' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $attendance->status_color }}">
                                                        {{ ucfirst($attendance->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5>No attendance records for this week</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Attendance -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-history"></i> Recent Attendance
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($recentAttendances->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Working Hours</th>
                                            <th>Status</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentAttendances as $attendance)
                                            <tr>
                                                <td>{{ $attendance->date->format('M d, Y') }}</td>
                                                <td>{{ $attendance->check_in_time ?? '---' }}</td>
                                                <td>{{ $attendance->check_out_time ?? '---' }}</td>
                                                <td>{{ $attendance->working_hours ? $attendance->working_hours . 'h' : '---' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $attendance->status_color }}">
                                                        {{ ucfirst($attendance->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $attendance->notes ?? '---' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <h5>No recent attendance records</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function checkIn() {
    const btn = document.getElementById('checkInBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Checking in...';
    
    fetch('{{ route("attendance.check-in") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            location: 'Office'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Something went wrong. Please try again.'
        });
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Check In';
    });
}

function checkOut() {
    const btn = document.getElementById('checkOutBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Checking out...';
    
    fetch('{{ route("attendance.check-out") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Something went wrong. Please try again.'
        });
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-sign-out-alt"></i> Check Out';
    });
}

// Update current time every minute
setInterval(() => {
    const timeElement = document.querySelector('.text-muted .fa-info-circle').parentElement;
    if (timeElement) {
        const now = new Date();
        timeElement.innerHTML = '<i class="fas fa-info-circle"></i> Current Time: ' + 
            now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    }
}, 60000);
</script>
@endpush
