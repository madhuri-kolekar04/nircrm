@extends('admin.admin_master')

@section('page-title', 'Leave Approval Status')

@section('admin')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="page-title mb-1">
                        <i class="fas fa-clipboard-check text-primary me-2"></i>
                        Leave Approval Status
                    </h4>
                    <p class="text-muted mb-0">Manage leave requests and approvals</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('leave.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-calendar-alt me-2"></i>All Leaves
                    </a>
                    <a href="{{ route('leave.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>New Leave Request
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
                            <h3 class="fw-bold mb-1 text-warning">{{ $stats['pending_for_me'] }}</h3>
                            <p class="text-muted mb-0">Pending for Me</p>
                        </div>
                        <div class="ms-3">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="fas fa-hourglass-half text-warning fs-4"></i>
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
                            <h3 class="fw-bold mb-1 text-info">{{ $stats['my_pending'] }}</h3>
                            <p class="text-muted mb-0">My Pending Requests</p>
                        </div>
                        <div class="ms-3">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="fas fa-paper-plane text-info fs-4"></i>
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
                            <h3 class="fw-bold mb-1 text-success">{{ $stats['my_approved'] }}</h3>
                            <p class="text-muted mb-0">My Approved</p>
                        </div>
                        <div class="ms-3">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="fas fa-check-circle text-success fs-4"></i>
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
                            <h3 class="fw-bold mb-1 text-danger">{{ $stats['my_rejected'] }}</h3>
                            <p class="text-muted mb-0">My Rejected</p>
                        </div>
                        <div class="ms-3">
                            <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                                <i class="fas fa-times-circle text-danger fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Approvals for Me -->
    @if($pendingApprovals->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Pending Approvals for You ({{ $pendingApprovals->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee</th>
                                    <th>Leave Type</th>
                                    <th>Duration</th>
                                    <th>Reason</th>
                                    <th>Applied On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingApprovals as $leave)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $leave->user->name }} {{ $leave->user->last_name ?? '' }}</div>
                                                <small class="text-muted">{{ $leave->user->designation ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $leave->leaveType->name }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $leave->total_days }} day(s)</strong>
                                            <br><small class="text-muted">{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-truncate" style="max-width: 200px;" title="{{ $leave->reason }}">
                                            {{ Str::limit($leave->reason, 50) }}
                                        </p>
                                    </td>
                                    <td>
                                        <small>{{ \Carbon\Carbon::parse($leave->created_at)->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-success" onclick="approveLeave({{ $leave->id }})">
                                                <i class="fas fa-check me-1"></i>Approve
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="rejectLeave({{ $leave->id }})">
                                                <i class="fas fa-times me-1"></i>Reject
                                            </button>
                                            <a href="{{ route('approval-status.leave.show', $leave->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
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
    @endif

    <!-- My Leave Requests -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-calendar-alt me-2"></i>
                        My Leave Requests ({{ $myRequests->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Leave Type</th>
                                    <th>Duration</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Current Approver</th>
                                    <th>Applied On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myRequests as $leave)
                                <tr>
                                    <td>
                                        <span class="badge bg-info">{{ $leave->leaveType->name }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $leave->total_days }} day(s)</strong>
                                            <br><small class="text-muted">{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-truncate" style="max-width: 200px;" title="{{ $leave->reason }}">
                                            {{ Str::limit($leave->reason, 50) }}
                                        </p>
                                    </td>
                                    <td>
                                        {!! $leave->status_badge !!}
                                    </td>
                                    <td>
                                        @if($leave->status == 'pending')
                                            @php
                                                $nextApprover = $leave->getNextApprover();
                                            @endphp
                                            @if($nextApprover)
                                                <span class="text-muted">{{ $nextApprover->name }}</span>
                                            @else
                                                <span class="text-muted">No approver assigned</span>
                                            @endif
                                        @elseif($leave->approver)
                                            <span class="text-muted">{{ $leave->approver->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ \Carbon\Carbon::parse($leave->created_at)->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('approval-status.leave.show', $leave->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($leave->status == 'pending')
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="cancelLeave({{ $leave->id }})">
                                                    <i class="fas fa-times me-1"></i>Cancel
                                                </button>
                                            @endif
                                        </div>
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

<!-- Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Leave Approval</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="approvalForm" method="POST">
                @csrf
                <input type="hidden" id="leaveId" name="leave_id">
                <input type="hidden" id="approvalAction" name="action">
                <div class="modal-body">
                    <div id="approvalMessage"></div>
                    <div class="mb-3">
                        <label for="comments" class="form-label">Comments</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3" placeholder="Add your comments..."></textarea>
                    </div>
                    <div class="mb-3" id="rejectionReasonDiv" style="display: none;">
                        <label for="rejection_reason" class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required placeholder="Please provide a reason for rejection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approveLeave(leaveId) {
    document.getElementById('leaveId').value = leaveId;
    document.getElementById('approvalAction').value = 'approve';
    document.getElementById('approvalMessage').innerHTML = '<p class="text-success">Are you sure you want to approve this leave request?</p>';
    document.getElementById('rejectionReasonDiv').style.display = 'none';
    document.getElementById('rejection_reason').required = false;
    document.getElementById('submitBtn').className = 'btn btn-success';
    document.getElementById('submitBtn').innerHTML = '<i class="fas fa-check me-2"></i>Approve';
    
    var modal = new bootstrap.Modal(document.getElementById('approvalModal'));
    modal.show();
}

function rejectLeave(leaveId) {
    document.getElementById('leaveId').value = leaveId;
    document.getElementById('approvalAction').value = 'reject';
    document.getElementById('approvalMessage').innerHTML = '<p class="text-danger">Are you sure you want to reject this leave request?</p>';
    document.getElementById('rejectionReasonDiv').style.display = 'block';
    document.getElementById('rejection_reason').required = true;
    document.getElementById('submitBtn').className = 'btn btn-danger';
    document.getElementById('submitBtn').innerHTML = '<i class="fas fa-times me-2"></i>Reject';
    
    var modal = new bootstrap.Modal(document.getElementById('approvalModal'));
    modal.show();
}

function cancelLeave(leaveId) {
    if (confirm('Are you sure you want to cancel this leave request?')) {
        fetch(`/leave/${leaveId}/cancel`, {
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
                alert(data.message || 'Failed to cancel leave request');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to cancel leave request');
        });
    }
}

document.getElementById('approvalForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const leaveId = document.getElementById('leaveId').value;
    const action = document.getElementById('approvalAction').value;
    const comments = document.getElementById('comments').value;
    const rejectionReason = document.getElementById('rejection_reason').value;
    
    const formData = new FormData();
    formData.append('leave_id', leaveId);
    if (action === 'approve') {
        formData.append('comments', comments);
        url = `/approval-status/leave/${leaveId}/approve`;
    } else {
        formData.append('rejection_reason', rejectionReason);
        url = `/approval-status/leave/${leaveId}/reject`;
    }
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Failed to process approval');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to process approval');
    });
});
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
.btn-group .btn {
    margin: 0 2px;
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
