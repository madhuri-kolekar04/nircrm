@extends('admin.admin_master')

@section('page-title', 'Leave Details')

@section('admin')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="page-title mb-1">
                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                        Leave Request Details
                    </h4>
                    <p class="text-muted mb-0">View and manage leave request information</p>
                </div>
                <div>
                    <a href="{{ route('approval-status.leave.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Approvals
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Details Card -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-info-circle me-2"></i>
                        Leave Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Employee</label>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $leave->user->name }} {{ $leave->user->last_name ?? '' }}</div>
                                    <small class="text-muted">{{ $leave->user->designation ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Department</label>
                            <div class="fw-semibold">{{ $leave->user->department->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Leave Type</label>
                            <div>
                                <span class="badge bg-info">{{ $leave->leaveType->name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Status</label>
                            <div>{!! $leave->status_badge !!}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Start Date</label>
                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">End Date</label>
                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Total Days</label>
                            <div class="fw-semibold">{{ $leave->total_days }} day(s)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Applied On</label>
                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($leave->created_at)->format('d M Y H:i') }}</div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted">Reason</label>
                            <div class="p-3 bg-light rounded">{{ $leave->reason }}</div>
                        </div>
                        @if($leave->emergency_contact)
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Emergency Contact</label>
                            <div class="fw-semibold">{{ $leave->emergency_contact }}</div>
                        </div>
                        @endif
                        @if($leave->is_half_day)
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Half Day Type</label>
                            <div class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $leave->half_day_type)) }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Approval Status Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-clipboard-check me-2"></i>
                        Approval Status
                    </h5>
                </div>
                <div class="card-body">
                    @if($leave->approvals->count() > 0)
                        @foreach($leave->approvals as $approval)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                            <div>
                                <div class="fw-semibold">{{ $approval->approver->name }}</div>
                                <small class="text-muted">{{ ucfirst($approval->approval_level) }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $approval->status == 'approved' ? 'success' : ($approval->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($approval->status) }}
                                </span>
                                @if($approval->approved_at)
                                    <br><small class="text-muted">{{ \Carbon\Carbon::parse($approval->approved_at)->format('d M Y') }}</small>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-hourglass-half fs-1 mb-2"></i>
                            <p>No approvals yet</p>
                        </div>
                    @endif

                    @if($leave->status == 'pending')
                        @php
                            $nextApprover = $leave->getNextApprover();
                        @endphp
                        @if($nextApprover)
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Next Approver:</strong> {{ $nextApprover->name }}
                        </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Actions Card -->
            @if($leave->canBeApprovedBy($user))
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-tasks me-2"></i>
                        Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" onclick="approveLeave({{ $leave->id }})">
                            <i class="fas fa-check me-2"></i>Approve Leave
                        </button>
                        <button type="button" class="btn btn-danger" onclick="rejectLeave({{ $leave->id }})">
                            <i class="fas fa-times me-2"></i>Reject Leave
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Comments History -->
    @if($leave->approvals->where('comments')->count() > 0 || $leave->approval_notes || $leave->rejection_reason)
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-comments me-2"></i>
                        Comments & Notes
                    </h5>
                </div>
                <div class="card-body">
                    @if($leave->approvals->where('comments')->count() > 0)
                        @foreach($leave->approvals->where('comments') as $approval)
                        <div class="mb-3 p-3 bg-light rounded">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="fw-semibold">{{ $approval->approver->name }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($approval->updated_at)->format('d M Y H:i') }}</small>
                            </div>
                            <div class="text-muted">{{ $approval->comments }}</div>
                        </div>
                        @endforeach
                    @endif

                    @if($leave->approval_notes)
                    <div class="mb-3 p-3 bg-success bg-opacity-10 rounded">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="fw-semibold">Approval Notes</div>
                            @if($leave->approver)
                                <small class="text-muted">{{ $leave->approver->name }} - {{ \Carbon\Carbon::parse($leave->approval_date)->format('d M Y H:i') }}</small>
                            @endif
                        </div>
                        <div>{{ $leave->approval_notes }}</div>
                    </div>
                    @endif

                    @if($leave->rejection_reason)
                    <div class="mb-3 p-3 bg-danger bg-opacity-10 rounded">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="fw-semibold">Rejection Reason</div>
                            @if($leave->approver)
                                <small class="text-muted">{{ $leave->approver->name }} - {{ \Carbon\Carbon::parse($leave->approval_date)->format('d M Y H:i') }}</small>
                            @endif
                        </div>
                        <div>{{ $leave->rejection_reason }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
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
.rounded-circle {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.bg-light {
    border-left: 4px solid #007bff;
}
</style>
@endpush
