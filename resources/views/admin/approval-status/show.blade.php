@extends('admin.admin_master')

@section('page-title', 'Approval Request Details')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-info-circle"></i>
                        Approval Request #{{ $approval->id }}
                    </h4>
                    <a href="{{ route('approval-status.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    
                    <!-- Request Status Badge -->
                    <div class="mb-3">
                        <span class="badge bg-{{ $approval->status == 'approved' ? 'success' : ($approval->status == 'rejected' ? 'danger' : 'warning') }} fs-6">
                            <i class="fas fa-{{ $approval->status == 'approved' ? 'check' : ($approval->status == 'rejected' ? 'times' : 'clock') }}"></i>
                            {{ strtoupper($approval->status) }}
                        </span>
                    </div>

                    <div class="row">
                        <!-- Request Details -->
                        <div class="col-md-6">
                            <h5 class="mb-3">
                                <i class="fas fa-file-alt text-primary"></i>
                                Request Details
                            </h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="150">Request ID:</th>
                                    <td>#{{ $approval->id }}</td>
                                </tr>
                                <tr>
                                    <th>Action Type:</th>
                                    <td>
                                        <span class="badge bg-{{ $approval->action_type == 'delete' ? 'danger' : ($approval->action_type == 'update' ? 'warning' : 'primary') }}">
                                            {{ strtoupper($approval->action_type) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Target Type:</th>
                                    <td>{{ ucfirst($approval->target_type) }}</td>
                                </tr>
                                <tr>
                                    <th>Target:</th>
                                    <td>
                                        @if($approval->target)
                                            <strong>{{ $approval->target->name }}</strong><br>
                                            <small class="text-muted">{{ $approval->target->email }}</small>
                                        @else
                                            <strong>{{ $approval->target_data['name'] ?? 'N/A' }}</strong><br>
                                            <small class="text-muted">{{ $approval->target_data['email'] ?? 'N/A' }}</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Requested By:</th>
                                    <td>
                                        <strong>{{ $approval->requester->name }}</strong><br>
                                        <small class="text-muted">{{ $approval->requester->email }}</small><br>
                                        <small class="badge bg-info">{{ $approval->requester->position ?? 'User' }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $approval->created_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                                @if($approval->approved_at)
                                <tr>
                                    <th>Approved:</th>
                                    <td>{{ $approval->approved_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                                @endif
                                @if($approval->rejected_at)
                                <tr>
                                    <th>Rejected:</th>
                                    <td>{{ $approval->rejected_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>

                        <!-- Approval Progress -->
                        <div class="col-md-6">
                            <h5 class="mb-3">
                                <i class="fas fa-tasks text-success"></i>
                                Approval Progress
                            </h5>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Progress:</span>
                                    <strong>
                                        {{ count($approval->current_approvals ?? []) }} / {{ count($approval->required_approvals ?? []) }}
                                    </strong>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <?php
                                    $required = count($approval->required_approvals ?? []);
                                    $current = count($approval->current_approvals ?? []);
                                    $percentage = $required > 0 ? ($current / $required) * 100 : 0;
                                    ?>
                                    <div class="progress-bar bg-{{ $approval->status == 'approved' ? 'success' : ($approval->status == 'rejected' ? 'danger' : 'warning') }}" 
                                         role="progressbar" 
                                         style="width: {{ $percentage }}%"
                                         aria-valuenow="{{ $current }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="{{ $required }}">
                                        {{ round($percentage) }}%
                                    </div>
                                </div>
                            </div>

                            <h6>Required Approvers:</h6>
                            <div class="list-group mb-3">
                                @if(isset($approval->required_approvals) && count($approval->required_approvals) > 0)
                                    @foreach($approval->required_approvals as $approverId)
                                        @if(isset($approvers[$approverId]))
                                            <?php $approver = $approvers[$approverId]; ?>
                                            <?php $hasApproved = in_array($approverId, $approval->current_approvals ?? []); ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $approver->name }}</strong><br>
                                                    <small class="text-muted">{{ $approver->email }}</small><br>
                                                    <small class="badge bg-info">{{ $approver->position ?? 'User' }}</small>
                                                </div>
                                                <div>
                                                    @if($hasApproved)
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check"></i> Approved
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-clock"></i> Pending
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="list-group-item">
                                        <em class="text-muted">No approvers found</em>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Reason Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">
                                <i class="fas fa-comment text-info"></i>
                                Request Reason
                            </h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0">{{ $approval->reason }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rejection Reason (if rejected) -->
                    @if($approval->status == 'rejected' && $approval->rejection_reason)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">
                                <i class="fas fa-times-circle text-danger"></i>
                                Rejection Reason
                            </h5>
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <p class="mb-0">{{ $approval->rejection_reason }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Target Data (for reference) -->
                    @if($approval->target_data)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">
                                <i class="fas fa-database text-secondary"></i>
                                Target Data (Snapshot at time of request)
                            </h5>
                            <div class="card">
                                <div class="card-body">
                                    <pre class="mb-0">{{ json_encode($approval->target_data, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons (if pending and user can approve) -->
                    @if($approval->status == 'pending' && auth()->user() && $approval->canBeApprovedBy(auth()->user()))
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <h5 class="card-title text-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Action Required
                                    </h5>
                                    <p class="card-text">This approval request requires your action.</p>
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-success" 
                                                onclick="approveRequest({{ $approval->id }})">
                                            <i class="fas fa-check"></i> Approve Request
                                        </button>
                                        <button type="button" 
                                                class="btn btn-danger" 
                                                onclick="showRejectModal({{ $approval->id }})">
                                            <i class="fas fa-times"></i> Reject Request
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">
                    <i class="fas fa-times-circle"></i>
                    Reject Approval Request
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" action="{{ route('approval-status.reject', ':id') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="rejectId">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Rejection Reason *</label>
                        <textarea class="form-control" 
                                  name="rejection_reason" 
                                  id="rejection_reason" 
                                  rows="3" 
                                  required
                                  placeholder="Please provide a reason for rejection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Reject Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approveRequest(id) {
    if (confirm('Are you sure you want to approve this request?')) {
        fetch(`/approval-status/${id}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                toastr.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('An error occurred while approving the request.');
        });
    }
}

function showRejectModal(id) {
    document.getElementById('rejectId').value = id;
    const form = document.getElementById('rejectForm');
    form.action = form.action.replace(':id', id);
    
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}

// Handle reject form submission
document.getElementById('rejectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const id = formData.get('id');
    
    fetch(`/approval-status/${id}/reject`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastr.success(data.message);
            bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            toastr.error(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred while rejecting the request.');
    });
});
</script>
@endsection
