@extends('admin.admin_master')

@section('page-title', 'Approval Status')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-check-circle"></i>
                        Approval Status Management
                    </h4>
                </div>
                <div class="card-body">
                    
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Pending for Me</h5>
                                    <h2>{{ $pendingApprovals->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">My Pending</h5>
                                    <h2>{{ $myRequests->where('status', 'pending')->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">My Approved</h5>
                                    <h2>{{ $myRequests->where('status', 'approved')->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h5 class="card-title">My Rejected</h5>
                                    <h2>{{ $myRequests->where('status', 'rejected')->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-teal text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Leave Pending</h5>
                                    <h2>{{ $pendingLeaves->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-purple text-white">
                                <div class="card-body">
                                    <h5 class="card-title">My Leave Req</h5>
                                    <h2>{{ $myLeaveRequests->where('status', 'pending')->count() }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs mb-4" id="approvalTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                                <i class="fas fa-tasks"></i> General Approvals
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="leave-tab" data-bs-toggle="tab" data-bs-target="#leave" type="button" role="tab">
                                <i class="fas fa-plane"></i> Leave Management
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="approvalTabsContent">
                        <!-- General Approvals Tab -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <!-- Existing approval content here -->
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                General approval system content remains the same.
                            </div>
                        </div>

                        <!-- Leave Management Tab -->
                        <div class="tab-pane fade" id="leave" role="tabpanel">
                            <!-- Pending Leave Approvals -->
                            @if($pendingLeaves->count() > 0)
                            <div class="mb-4">
                                <h5 class="mb-3">
                                    <i class="fas fa-clock text-warning"></i>
                                    Pending Leave Approvals
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Employee</th>
                                                <th>Leave Type</th>
                                                <th>Duration</th>
                                                <th>Days</th>
                                                <th>Reason</th>
                                                <th>Applied</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingLeaves as $leave)
                                            <tr>
                                                <td>{{ $leave->user->full_name }}</td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $leave->leaveType->name }}</span>
                                                </td>
                                                <td>
                                                    {{ $leave->start_date->format('M d') }} -
                                                    {{ $leave->end_date->format('M d, Y') }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $leave->total_days }} day(s)</span>
                                                </td>
                                                <td>{{ Str::limit($leave->reason, 50) }}</td>
                                                <td>{{ $leave->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('leave.show', $leave) }}" class="btn btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <button class="btn btn-success" onclick="approveLeave({{ $leave->id }})">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button class="btn btn-danger" onclick="rejectLeave({{ $leave->id }})">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                No pending leave requests require your action.
                            </div>
                            @endif

                            <!-- Quick Actions -->
                            <div class="mt-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-rocket"></i> Quick Actions
                                        </h6>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('leave.create') }}" class="btn btn-success">
                                                <i class="fas fa-plus"></i> Request Leave
                                            </a>
                                            <a href="{{ route('leave.dashboard') }}" class="btn btn-primary">
                                                <i class="fas fa-tachometer-alt"></i> Leave Dashboard
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function approveLeave(leaveId) {
    if (confirm('Are you sure you want to approve this leave request?')) {
        fetch(`/leave/${leaveId}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ approval_notes: '' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Leave request approved successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function rejectLeave(leaveId) {
    const reason = prompt('Please provide rejection reason:');
    if (reason) {
        fetch(`/leave/${leaveId}/reject`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ rejection_reason: reason })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Leave request rejected successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}
</script>
@endsection
