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
                    
                    <!-- Quick Access Cards -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <a href="{{ route('approval-status.leave.index') }}" class="text-decoration-none">
                                <div class="card bg-gradient-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title">
                                                    <i class="fas fa-calendar-alt me-2"></i>
                                                    Leave Approvals
                                                </h5>
                                                <p class="card-text mb-0">Manage leave requests and approvals</p>
                                            </div>
                                            <div class="ms-3">
                                                <i class="fas fa-arrow-right fs-3"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('leave.index') }}" class="text-decoration-none">
                                <div class="card bg-gradient-success text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title">
                                                    <i class="fas fa-calendar me-2"></i>
                                                    All Leaves
                                                </h5>
                                                <p class="card-text mb-0">View complete leave history</p>
                                            </div>
                                            <div class="ms-3">
                                                <i class="fas fa-arrow-right fs-3"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Pending for Me</h5>
                                    <h2>{{ $pendingApprovals->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">My Pending Requests</h5>
                                    <h2>{{ $myRequests->where('status', 'pending')->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">My Approved</h5>
                                    <h2>{{ $myRequests->where('status', 'approved')->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h5 class="card-title">My Rejected</h5>
                                    <h2>{{ $myRequests->where('status', 'rejected')->count() }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Approvals for Current User -->
                    @if($pendingApprovals->count() > 0)
                    <div class="mb-4">
                        <h5 class="mb-3">
                            <i class="fas fa-clock text-warning"></i>
                            Pending Approvals for Your Action
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="pendingApprovalsTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Request ID</th>
                                        <th>Action</th>
                                        <th>Target</th>
                                        <th>Requested By</th>
                                        <th>Reason</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingApprovals as $approval)
                                    <tr>
                                        <td>#{{ $approval->id }}</td>
                                        <td>
                                            <span class="badge bg-{{ $approval->action_type == 'delete' ? 'danger' : ($approval->action_type == 'update' ? 'warning' : 'primary') }}">
                                                {{ strtoupper($approval->action_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($approval->target)
                                                {{ $approval->target->name }}
                                                <small class="text-muted d-block">{{ $approval->target_type }}</small>
                                            @else
                                                {{ $approval->target_data['name'] ?? 'N/A' }}
                                                <small class="text-muted d-block">{{ $approval->target_type }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $approval->requester->name }}
                                            <small class="text-muted d-block">{{ $approval->requester->email }}</small>
                                        </td>
                                        <td>{{ Str::limit($approval->reason, 50) }}</td>
                                        <td>{{ $approval->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" 
                                                        class="btn btn-sm btn-success" 
                                                        onclick="approveRequest({{ $approval->id }})"
                                                        title="Approve">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger" 
                                                        onclick="showRejectModal({{ $approval->id }})"
                                                        title="Reject">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                                <a href="{{ route('approval-status.show', $approval->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="View Details">
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
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        No pending approvals require your action.
                    </div>
                    @endif

                    <!-- My Approval Requests -->
                    <div class="mt-4">
                        <h5 class="mb-3">
                            <i class="fas fa-history text-primary"></i>
                            My Approval Requests
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="myRequestsTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Request ID</th>
                                        <th>Action</th>
                                        <th>Target</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myRequests as $request)
                                    <tr>
                                        <td>#{{ $request->id }}</td>
                                        <td>
                                            <span class="badge bg-{{ $request->action_type == 'delete' ? 'danger' : ($request->action_type == 'update' ? 'warning' : 'primary') }}">
                                                {{ strtoupper($request->action_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($request->target)
                                                {{ $request->target->name }}
                                                <small class="text-muted d-block">{{ $request->target_type }}</small>
                                            @else
                                                {{ $request->target_data['name'] ?? 'N/A' }}
                                                <small class="text-muted d-block">{{ $request->target_type }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $request->status == 'approved' ? 'success' : ($request->status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ strtoupper($request->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <?php
                                                $required = count($request->required_approvals ?? []);
                                                $current = count($request->current_approvals ?? []);
                                                $percentage = $required > 0 ? ($current / $required) * 100 : 0;
                                                ?>
                                                <div class="progress-bar bg-success" 
                                                     role="progressbar" 
                                                     style="width: {{ $percentage }}%"
                                                     aria-valuenow="{{ $current }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="{{ $required }}">
                                                    {{ $current }}/{{ $required }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $request->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('approval-status.show', $request->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="View Details">
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
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTables
    $('#pendingApprovalsTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']]
    });

    $('#myRequestsTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']]
    });
});

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
                location.reload();
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
            location.reload();
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
