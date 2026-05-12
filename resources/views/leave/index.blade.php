@extends('admin.admin_master')

@section('page-title', 'Leave Management')

@section('admin')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="page-title mb-1">Leave Management</h4>
                    <p class="text-muted mb-0">Manage leave requests and approvals</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('leave.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Leave Request
                    </a>
                    <a href="{{ route('leave.calendar-leaves') }}" class="btn btn-outline-info">
                        <i class="fas fa-calendar-alt"></i> Calendar Leaves
                    </a>
                    <a href="{{ route('leave.leave-bucket') }}" class="btn btn-outline-success">
                        <i class="fas fa-bucket"></i> Leave Bucket
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-tabs" id="leaveTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                        All Leaves
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                        Pending
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">
                        Approved
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab">
                        Rejected
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Leave Requests Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Leave Requests</h6>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="leaveTabContent">
                        <!-- All Leaves Tab -->
                        <div class="tab-pane fade show active" id="all" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Employee</th>
                                            <th>Leave Type</th>
                                            <th>Duration</th>
                                            <th>Reason</th>
                                            <th>Status</th>
                                            <th>Applied On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($leaves as $leave)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                                             style="width: 35px; height: 35px; font-size: 14px;">
                                                            {{ $leave->user ? strtoupper(substr($leave->user->name, 0, 1)) : 'U' }}
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $leave->user ? $leave->user->name : 'Unknown User' }}</div>
                                                            <small class="text-muted">
                                                                @if($leave->user && $leave->user->department)
                                                                    @if(is_object($leave->user->department))
                                                                        {{ $leave->user->department->name }}
                                                                    @else
                                                                        {{ $leave->user->department }}
                                                                    @endif
                                                                @else
                                                                    No Department
                                                                @endif
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $leave->leaveType->name }}</span>
                                                </td>
                                                <td>
                                                    @if($leave->is_half_day)
                                                        <span class="badge bg-warning">Half Day ({{ $leave->half_day_type }})</span>
                                                    @else
                                                        {{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M Y') }}
                                                        <br><small class="text-muted">{{ $leave->total_days }} days</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>{{ Str::limit($leave->reason, 50) }}</div>
                                                </td>
                                                <td>
                                                    {!! $leave->status_badge !!}
                                                </td>
                                                <td>
                                                    <small>{{ $leave->created_at->format('d M Y') }}</small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('leave.show', $leave) }}" class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if($leave->status === 'pending' && $leave->canBeApprovedBy(Auth::user()))
                                                            <button type="button" class="btn btn-success btn-sm approve-leave" data-leave-id="{{ $leave->id }}">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm reject-leave" data-leave-id="{{ $leave->id }}">
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
                            {{ $leaves->links() }}
                        </div>

                        <!-- Pending Tab -->
                        <div class="tab-pane fade" id="pending" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered">
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
                                        @foreach($leaves->where('status', 'pending') as $leave)
                                            <tr>
                                                <td>
                                                    <div class="fw-bold">{{ $leave->user ? $leave->user->name : 'Unknown User' }}</div>
                                                    <small class="text-muted">{{ $leave->user && $leave->user->department ? ($leave->user->department->name ?? 'No Department') : 'No Department' }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $leave->leaveType->name }}</span>
                                                </td>
                                                <td>
                                                    @if($leave->is_half_day)
                                                        <span class="badge bg-warning">Half Day</span>
                                                    @else
                                                        {{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M Y') }}
                                                        <br><small class="text-muted">{{ $leave->total_days }} days</small>
                                                    @endif
                                                </td>
                                                <td>{{ Str::limit($leave->reason, 50) }}</td>
                                                <td>{{ $leave->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('leave.show', $leave) }}" class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if($leave->canBeApprovedBy(Auth::user()))
                                                            <button type="button" class="btn btn-success btn-sm approve-leave" data-leave-id="{{ $leave->id }}">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm reject-leave" data-leave-id="{{ $leave->id }}">
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
                        </div>

                        <!-- Approved Tab -->
                        <div class="tab-pane fade" id="approved" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Employee</th>
                                            <th>Leave Type</th>
                                            <th>Duration</th>
                                            <th>Approved By</th>
                                            <th>Approved On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($leaves->where('status', 'approved') as $leave)
                                            <tr>
                                                <td>
                                                    <div class="fw-bold">{{ $leave->user ? $leave->user->name : 'Unknown User' }}</div>
                                                    <small class="text-muted">{{ $leave->user && $leave->user->department ? ($leave->user->department->name ?? 'No Department') : 'No Department' }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $leave->leaveType->name }}</span>
                                                </td>
                                                <td>
                                                    @if($leave->is_half_day)
                                                        <span class="badge bg-warning">Half Day</span>
                                                    @else
                                                        {{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M Y') }}
                                                        <br><small class="text-muted">{{ $leave->total_days }} days</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($leave->approver)
                                                        {{ $leave->approver->name }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($leave->approval_date)
                                                        {{ $leave->approval_date->format('d M Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('leave.show', $leave) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Rejected Tab -->
                        <div class="tab-pane fade" id="rejected" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Employee</th>
                                            <th>Leave Type</th>
                                            <th>Duration</th>
                                            <th>Rejected By</th>
                                            <th>Rejection Reason</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($leaves->where('status', 'rejected') as $leave)
                                            <tr>
                                                <td>
                                                    <div class="fw-bold">{{ $leave->user ? $leave->user->name : 'Unknown User' }}</div>
                                                    <small class="text-muted">{{ $leave->user && $leave->user->department ? ($leave->user->department->name ?? 'No Department') : 'No Department' }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $leave->leaveType->name }}</span>
                                                </td>
                                                <td>
                                                    @if($leave->is_half_day)
                                                        <span class="badge bg-warning">Half Day</span>
                                                    @else
                                                        {{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M Y') }}
                                                        <br><small class="text-muted">{{ $leave->total_days }} days</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($leave->approver)
                                                        {{ $leave->approver->name }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <small>{{ $leave->rejection_reason ?? '-' }}</small>
                                                </td>
                                                <td>
                                                    <a href="{{ route('leave.show', $leave) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
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
    </div>
</div>

<!-- Leave Action Modal -->
<div class="modal fade" id="leaveActionModal" tabindex="-1" aria-labelledby="leaveActionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leaveActionModalLabel">Leave Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="leaveActionForm">
                <div class="modal-body">
                    <input type="hidden" id="leaveActionId" name="leave_id">
                    <input type="hidden" id="leaveActionType" name="action_type">
                    
                    <div class="mb-3" id="approvalNotesDiv" style="display: none;">
                        <label for="approvalNotes" class="form-label">Approval Notes</label>
                        <textarea class="form-control" id="approvalNotes" name="approval_notes" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3" id="rejectionReasonDiv" style="display: none;">
                        <label for="rejectionReason" class="form-label">Rejection Reason</label>
                        <textarea class="form-control" id="rejectionReason" name="rejection_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="leaveActionSubmitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    // Leave approval/rejection
    $('.approve-leave').click(function() {
        var leaveId = $(this).data('leave-id');
        $('#leaveActionId').val(leaveId);
        $('#leaveActionType').val('approve');
        $('#approvalNotesDiv').show();
        $('#rejectionReasonDiv').hide();
        $('#rejectionReason').removeAttr('required');
        $('#leaveActionSubmitBtn').removeClass('btn-danger').addClass('btn-success').text('Approve');
        $('#leaveActionModalLabel').text('Approve Leave');
        $('#leaveActionModal').modal('show');
    });
    
    $('.reject-leave').click(function() {
        var leaveId = $(this).data('leave-id');
        $('#leaveActionId').val(leaveId);
        $('#leaveActionType').val('reject');
        $('#approvalNotesDiv').hide();
        $('#rejectionReasonDiv').show();
        $('#rejectionReason').attr('required', 'required');
        $('#leaveActionSubmitBtn').removeClass('btn-success').addClass('btn-danger').text('Reject');
        $('#leaveActionModalLabel').text('Reject Leave');
        $('#leaveActionModal').modal('show');
    });
    
    // Leave action form submission
    $('#leaveActionForm').submit(function(e) {
        e.preventDefault();
        
        var leaveId = $('#leaveActionId').val();
        var actionType = $('#leaveActionType').val();
        var url = actionType === 'approve' ? 
            '{{ route("leave.approve", ":id") }}'.replace(':id', leaveId) : 
            '{{ route("leave.reject", ":id") }}'.replace(':id', leaveId);
        
        $.ajax({
            url: url,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    $('#leaveActionModal').modal('hide');
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
