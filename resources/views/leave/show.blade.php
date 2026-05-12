@extends('admin.admin_master')

@section('page-title', 'Leave Details')

@section('admin')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="page-title mb-1">Leave Details</h4>
                    <p class="text-muted mb-0">View detailed information about this leave request</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('leave.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Back to Leave Management
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Details Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i>Leave Request Information</h6>
                    <div>
                        {!! $leave->status_badge !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Employee Name</label>
                            <div class="fw-bold">{{ $leave->user->name }}</div>
                            <small class="text-muted">{{ $leave->user->getRoleNameAttribute() }}</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Department</label>
                            <div class="fw-bold">
                                @if($leave->user->department)
                                    @if(is_object($leave->user->department))
                                        {{ $leave->user->department->name }}
                                    @else
                                        {{ $leave->user->department }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Leave Type</label>
                            <div class="fw-bold">{{ $leave->leaveType->name }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Duration</label>
                            <div class="fw-bold">
                                @if($leave->is_half_day)
                                    <span class="badge bg-warning">Half Day ({{ $leave->half_day_type }})</span>
                                @else
                                    {{ $leave->start_date->format('d M Y') }} - {{ $leave->end_date->format('d M Y') }}
                                    <br><small class="text-muted">{{ $leave->total_days }} working days</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Applied On</label>
                            <div class="fw-bold">{{ $leave->created_at->format('d M Y h:i A') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Employee ID</label>
                            <div class="fw-bold">{{ $leave->user->employeeID ?? 'N/A' }}</div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label text-muted">Reason for Leave</label>
                            <div class="p-3 bg-light rounded">{{ $leave->reason }}</div>
                        </div>
                    </div>
                    
                    @if($leave->attachments && !empty($leave->attachments))
                        <div class="row mt-3">
                            <div class="col-12">
                                <label class="form-label text-muted">Attachments</label>
                                <div class="row">
                                    @foreach($leave->attachments as $attachment)
                                        <div class="col-md-4 mb-2">
                                            <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                                                <i class="fas fa-paperclip me-2"></i>
                                                {{ basename($attachment) }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Approval Status Card -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-tasks me-2"></i>Approval Status</h6>
                </div>
                <div class="card-body">
                    @if($leave->status === 'pending')
                        <div class="text-center">
                            <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                            <h6>Pending Approval</h6>
                            <p class="text-muted">Your leave request is waiting for approval from your manager.</p>
                            <div class="mt-3">
                                <small class="text-muted">Expected response time: 24-48 hours</small>
                            </div>
                        </div>
                    @elseif($leave->status === 'approved')
                        <div class="text-center">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h6>Approved</h6>
                            <p class="text-muted">Your leave request has been approved.</p>
                            @if($leave->approver)
                                <div class="mt-3">
                                    <small class="text-muted">Approved by: {{ $leave->approver->name }}</small><br>
                                    <small class="text-muted">On: {{ $leave->approval_date->format('d M Y h:i A') }}</small>
                                </div>
                            @endif
                            @if($leave->approval_notes)
                                <div class="mt-3 p-2 bg-light rounded">
                                    <small><strong>Notes:</strong> {{ $leave->approval_notes }}</small>
                                </div>
                            @endif
                        </div>
                    @elseif($leave->status === 'rejected')
                        <div class="text-center">
                            <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                            <h6>Rejected</h6>
                            <p class="text-muted">Your leave request has been rejected.</p>
                            @if($leave->approver)
                                <div class="mt-3">
                                    <small class="text-muted">Rejected by: {{ $leave->approver->name }}</small><br>
                                    <small class="text-muted">On: {{ $leave->approval_date->format('d M Y h:i A') }}</small>
                                </div>
                            @endif
                            @if($leave->rejection_reason)
                                <div class="mt-3 p-2 bg-light rounded">
                                    <small><strong>Reason:</strong> {{ $leave->rejection_reason }}</small>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center">
                            <i class="fas fa-ban fa-3x text-secondary mb-3"></i>
                            <h6>{{ ucfirst($leave->status) }}</h6>
                            <p class="text-muted">Leave status: {{ $leave->status }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Actions Card -->
            @if($leave->status === 'pending' && $leave->user_id === Auth::user()->id)
                <div class="card mt-3">
                    <div class="card-header bg-warning text-white">
                        <h6 class="mb-0"><i class="fas fa-edit me-2"></i>Actions</h6>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-warning btn-sm w-100 mb-2" data-bs-toggle="modal" data-bs-target="#cancelLeaveModal">
                            <i class="fas fa-times me-2"></i>Cancel Leave Request
                        </button>
                        <small class="text-muted">You can cancel your leave request while it's pending approval.</small>
                    </div>
                </div>
            @endif
            
            @if($leave->canBeApprovedBy(Auth::user()) && $leave->status === 'pending')
                <div class="card mt-3">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-gavel me-2"></i>Approval Actions</h6>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success btn-sm w-100 mb-2" data-bs-toggle="modal" data-bs-target="#approveLeaveModal">
                            <i class="fas fa-check me-2"></i>Approve Leave
                        </button>
                        <button type="button" class="btn btn-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#rejectLeaveModal">
                            <i class="fas fa-times me-2"></i>Reject Leave
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Cancel Leave Modal -->
@if($leave->status === 'pending' && $leave->user_id === Auth::user()->id)
<div class="modal fade" id="cancelLeaveModal" tabindex="-1" aria-labelledby="cancelLeaveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="cancelLeaveModalLabel">Cancel Leave Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="cancelLeaveForm">
                <div class="modal-body">
                    <input type="hidden" name="leave_id" value="{{ $leave->id }}">
                    <p>Are you sure you want to cancel this leave request?</p>
                    <div class="mb-3">
                        <label for="cancelReason" class="form-label">Reason for Cancellation (Optional)</label>
                        <textarea class="form-control" id="cancelReason" name="reason" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep It</button>
                    <button type="submit" class="btn btn-warning">Yes, Cancel Leave</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Approve Leave Modal -->
@if($leave->canBeApprovedBy(Auth::user()) && $leave->status === 'pending')
<div class="modal fade" id="approveLeaveModal" tabindex="-1" aria-labelledby="approveLeaveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="approveLeaveModalLabel">Approve Leave Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('leave.approve', $leave) }}">
                @csrf
                <div class="modal-body">
                    <p>Approve this leave request for <strong>{{ $leave->user->name }}</strong>?</p>
                    <div class="mb-3">
                        <label for="approvalNotes" class="form-label">Approval Notes (Optional)</label>
                        <textarea class="form-control" id="approvalNotes" name="approval_notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve Leave</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Reject Leave Modal -->
@if($leave->canBeApprovedBy(Auth::user()) && $leave->status === 'pending')
<div class="modal fade" id="rejectLeaveModal" tabindex="-1" aria-labelledby="rejectLeaveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectLeaveModalLabel">Reject Leave Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('leave.reject', $leave) }}">
                @csrf
                <div class="modal-body">
                    <p>Reject this leave request for <strong>{{ $leave->user->name }}</strong>?</p>
                    <div class="mb-3">
                        <label for="rejectionReason" class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejectionReason" name="rejection_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Leave</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
// Set up CSRF token for all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    // Cancel leave form submission
    $('#cancelLeaveForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '/leave/' + {{ $leave->id }} + '/cancel',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    $('#cancelLeaveModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                var message = 'Something went wrong';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if(xhr.responseJSON && xhr.responseJSON.error) {
                    message = xhr.responseJSON.error;
                }
                alert('Error: ' + message);
            }
        });
    });
});
</script>
@endpush
