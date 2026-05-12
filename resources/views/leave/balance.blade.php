@extends('admin.admin_master')

@section('page-title', 'Leave Balance')

@section('admin')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="page-title mb-1">
                        <i class="fas fa-chart-pie text-primary me-2"></i>
                        Leave Balance & Analytics
                    </h4>
                    <p class="text-muted mb-0">Track your leave balance and view statistics</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('leave.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Leave Management
                    </a>
                    <a href="{{ route('leave.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>New Leave Request
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- User Profile Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-white bg-opacity-20 p-4 me-4">
                                    <i class="fas fa-user text-white fs-3"></i>
                                </div>
                                <div>
                                    <h3 class="mb-1">{{ $user->name }} {{ $user->last_name ?? '' }}</h3>
                                    <p class="mb-1">{{ $user->designation ?? 'Employee' }} • {{ $user->department->name ?? 'No Department' }}</p>
                                    <p class="mb-0">Employee ID: {{ $user->employee_id ?? 'N/A' }} • Service: {{ \Carbon\Carbon::parse($user->joining_date ?? $user->created_at)->diffInYears(\Carbon\Carbon::now()) }} Years</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-10 rounded p-3 mb-2">
                                        <div class="fs-4 fw-bold">{{ $statistics['total_leaves'] ?? 0 }}</div>
                                        <div class="small">Total Requests</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-10 rounded p-3 mb-2">
                                        <div class="fs-4 fw-bold">{{ $statistics['total_days_taken_this_year'] ?? 0 }}</div>
                                        <div class="small">Days Taken</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Balance Overview -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-wallet me-2"></i>
                        Leave Balance Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(isset($leaveBalances) && count($leaveBalances) > 0)
                            @foreach($leaveBalances as $leaveTypeId => $balance)
                                @php
                                    $leaveType = \App\Models\LeaveType::find($leaveTypeId);
                                    $percentage = $balance['total_days'] > 0 ? round(($balance['used_days'] / $balance['total_days']) * 100, 1) : 0;
                                    $statusColor = $percentage >= 80 ? 'danger' : ($percentage >= 60 ? 'warning' : 'success');
                                @endphp
                                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 fw-semibold">{{ $leaveType->name ?? 'Leave Type' }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="text-center mb-3">
                                                <div class="fs-3 fw-bold text-{{ $statusColor }}">{{ $balance['available_days'] ?? 0 }}</div>
                                                <div class="small text-muted">Available Days</div>
                                            </div>
                                            
                                            <div class="row text-center small mb-3">
                                                <div class="col-4">
                                                    <div class="fw-bold text-primary">{{ $balance['total_days'] ?? 0 }}</div>
                                                    <div class="text-muted">Total</div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="fw-bold text-warning">{{ $balance['used_days'] ?? 0 }}</div>
                                                    <div class="text-muted">Used</div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="fw-bold text-info">{{ $balance['pending_days'] ?? 0 }}</div>
                                                    <div class="text-muted">Pending</div>
                                                </div>
                                            </div>
                                            
                                            <div class="progress mb-2" style="height: 8px;">
                                                <div class="progress-bar bg-{{ $statusColor }}" style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <div class="text-center">
                                                <small class="text-muted">{{ $percentage }}% used</small>
                                                <span class="badge bg-{{ $statusColor }}">
                                                    @if($percentage >= 80)
                                                        Critical
                                                    @elseif($percentage >= 60)
                                                        Moderate
                                                    @else
                                                        Healthy
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No leave balance data available. Please contact HR for more information.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-bar me-2"></i>
                        Leave Statistics (This Year)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center">
                                <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-block mb-2">
                                    <i class="fas fa-check-circle text-success fs-3"></i>
                                </div>
                                <div class="fs-4 fw-bold text-success">{{ $statistics['approved_this_year'] ?? 0 }}</div>
                                <div class="text-muted">Approved</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center">
                                <div class="rounded-circle bg-warning bg-opacity-10 p-3 d-inline-block mb-2">
                                    <i class="fas fa-clock text-warning fs-3"></i>
                                </div>
                                <div class="fs-4 fw-bold text-warning">{{ $statistics['pending_this_year'] ?? 0 }}</div>
                                <div class="text-muted">Pending</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center">
                                <div class="rounded-circle bg-danger bg-opacity-10 p-3 d-inline-block mb-2">
                                    <i class="fas fa-times-circle text-danger fs-3"></i>
                                </div>
                                <div class="fs-4 fw-bold text-danger">{{ $statistics['rejected_this_year'] ?? 0 }}</div>
                                <div class="text-muted">Rejected</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center">
                                <div class="rounded-circle bg-info bg-opacity-10 p-3 d-inline-block mb-2">
                                    <i class="fas fa-chart-line text-info fs-3"></i>
                                </div>
                                <div class="fs-4 fw-bold text-info">{{ round($statistics['average_leave_duration'] ?? 0, 1) }}</div>
                                <div class="text-muted">Avg Duration</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Upcoming Leaves
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($upcomingLeaves) && $upcomingLeaves->count() > 0)
                        @foreach($upcomingLeaves as $leave)
                        <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                <i class="fas fa-calendar text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $leave->leaveType->name ?? 'Leave' }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</small>
                                <div class="small">{{ $leave->total_days }} day(s)</div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-calendar-times fs-1 mb-2"></i>
                            <p>No upcoming leaves</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Department Summary (for managers/admins) -->
    @if(isset($departmentSummary) && $departmentSummary && $departmentSummary->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-users me-2"></i>
                        Department Leave Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Leave Type</th>
                                    <th>Total Requests</th>
                                    <th>Approved</th>
                                    <th>Pending</th>
                                    <th>Rejected</th>
                                    <th>Total Days Taken</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departmentSummary as $summary)
                                <tr>
                                    <td><strong>{{ $summary->leave_type }}</strong></td>
                                    <td>{{ $summary->total_requests }}</td>
                                    <td><span class="badge bg-success">{{ $summary->approved }}</span></td>
                                    <td><span class="badge bg-warning">{{ $summary->pending }}</span></td>
                                    <td><span class="badge bg-danger">{{ $summary->rejected }}</span></td>
                                    <td>{{ $summary->total_days_taken }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
.progress {
    background-color: #e9ecef;
    border-radius: 4px;
}
.progress-bar {
    background-color: #007bff;
    height: 100%;
    border-radius: 4px;
    transition: width 0.3s ease;
}
</style>
@endpush
