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

        <!-- Debug Info -->
        <div class="alert alert-info">
            <h5>Debug Information</h5>
            <p><strong>User:</strong> {{ auth()->user()->name }} (ID: {{ auth()->user()->id }})</p>
            <p><strong>Role:</strong> {{ auth()->user()->role }}</p>
            <p><strong>Today's Date:</strong> {{ now()->format('Y-m-d') }}</p>
            <p><strong>Today's Attendance:</strong> {{ $todayAttendance ? 'Found' : 'Not Found' }}</p>
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
    </div>
</div>
@endsection

@push('scripts')
<script>
function checkIn() {
    alert('Check In functionality would be implemented here');
}

function checkOut() {
    alert('Check Out functionality would be implemented here');
}
</script>
@endpush
