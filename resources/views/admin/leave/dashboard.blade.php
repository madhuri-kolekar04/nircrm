@extends('admin.admin_master')

@section('page-title', 'Leave Dashboard')

@section('content')
<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Leave Dashboard</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('leave.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-list"></i> All Leaves
                </a>
                <a href="{{ route('leave.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Request Leave
                </a>
                @if(auth()->user()->canApproveLeave())
                    <a href="{{ route('leave.calendar') }}" class="btn btn-outline-info">
                        <i class="fas fa-calendar"></i> Calendar
                    </a>
                @endif
            </div>
        </div>

        <!-- Leave Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                        <h4>{{ $leaveStats['total_leaves'] }}</h4>
                        <p class="mb-0">Total Requests</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-hourglass-half fa-2x mb-2"></i>
                        <h4>{{ $leaveStats['pending_leaves'] }}</h4>
                        <p class="mb-0">Pending</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h4>{{ $leaveStats['approved_leaves'] }}</h4>
                        <p class="mb-0">Approved</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-times-circle fa-2x mb-2"></i>
                        <h4>{{ $leaveStats['rejected_leaves'] }}</h4>
                        <p class="mb-0">Rejected</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Balance -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-balance-scale"></i> Leave Balance - {{ now()->year }}
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($leaveBalances)
                            <div class="row">
                                @foreach($leaveBalances as $balance)
                                    <div class="col-md-4 mb-3">
                                        <div class="card border-primary">
                                            <div class="card-body">
                                                <h6 class="card-title text-primary">{{ $balance['type']->name }}</h6>
                                                <div class="row text-center">
                                                    <div class="col-4">
                                                        <small class="text-muted">Allocated</small>
                                                        <h5 class="text-primary">{{ $balance['allocated'] }}</h5>
                                                    </div>
                                                    <div class="col-4">
                                                        <small class="text-muted">Used</small>
                                                        <h5 class="text-warning">{{ $balance['used'] }}</h5>
                                                    </div>
                                                    <div class="col-4">
                                                        <small class="text-muted">Remaining</small>
                                                        <h5 class="text-success">{{ $balance['remaining'] }}</h5>
                                                    </div>
                                                </div>
                                                <div class="progress mt-2" style="height: 8px;">
                                                    <?php
                                                    $percentage = $balance['allocated'] > 0 
                                                        ? ($balance['used'] / $balance['allocated']) * 100 
                                                        : 0;
                                                    $progressColor = $percentage >= 80 ? 'danger' : 
                                                                    ($percentage >= 60 ? 'warning' : 'success');
                                                    ?>
                                                    <div class="progress-bar bg-{{ $progressColor }}" 
                                                         style="width: {{ $percentage }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-balance-scale fa-3x text-muted mb-3"></i>
                                <h5>No leave types configured</h5>
                                <p class="text-muted">Contact your administrator to set up leave types.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Leave Requests -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-history"></i> Recent Leave Requests
                        </h5>
                        <a href="{{ route('leave.index') }}" class="btn btn-sm btn-outline-primary">
                            View All
                        </a>
                    </div>
                    <div class="card-body">
                        @if($recentLeaves->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Leave Type</th>
                                            <th>Duration</th>
                                            <th>Days</th>
                                            <th>Status</th>
                                            <th>Applied On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentLeaves as $leave)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-tag text-primary me-2"></i>
                                                        <div>
                                                            <div class="fw-bold">{{ $leave->leaveType->name }}</div>
                                                            <small class="text-muted">{{ $leave->reason }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $leave->start_date->format('M d') }} -
                                                    {{ $leave->end_date->format('M d, Y') }}
                                                    @if($leave->is_half_day)
                                                        <span class="badge bg-info ms-1">Half Day</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $leave->total_days }} day(s)</span>
                                                </td>
                                                <td>{!! $leave->status_badge !!}</td>
                                                <td>{{ $leave->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('leave.show', $leave) }}" class="btn btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if($leave->status === 'pending')
                                                            <button class="btn btn-outline-danger" onclick="cancelLeave({{ $leave->id }})">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5>No leave requests found</h5>
                                <p class="text-muted">You haven't applied for any leave yet.</p>
                                <a href="{{ route('leave.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Request Leave
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        @if(auth()->user()->canApproveLeave())
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-tasks"></i> Pending Approvals
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <p class="mb-3">You have pending leave requests to review.</p>
                                <a href="{{ route('leave.index', ['status' => 'pending']) }}" class="btn btn-warning">
                                    <i class="fas fa-hourglass-half"></i> Review Pending Requests
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function cancelLeave(leaveId) {
    Swal.fire({
        title: 'Cancel Leave Request?',
        text: "Are you sure you want to cancel this leave request?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/leave/${leaveId}/cancel`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Auto-refresh pending leaves every 30 seconds for managers
@if(auth()->user()->canApproveLeave())
setInterval(() => {
    // This would typically fetch updated data via AJAX
    // For now, we'll just show a subtle notification
    console.log('Checking for pending leave updates...');
}, 30000);
@endif
</script>
@endpush
