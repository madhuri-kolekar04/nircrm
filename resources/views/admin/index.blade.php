@extends('admin.admin_master')
@section('admin')
@section('page-title', 'Dashboard')

@php
$numberofticket = App\Models\Product::get()->count();
$numberofticketpending = App\Models\product::where('status',2)->count();
$numberofemployeeID = App\Models\User::where('role', 2)->count();
$numberofclients = App\Models\User::where('role', 3)->count();
$inprogress = App\Models\product::where('status', 1)->count();
$resolved= App\Models\product::where('status', 3)->count();

// Reaction notification statistics
$reactionStats = [
    'total' => \App\Models\LeadReaction::count(),
    'scheduled' => \App\Models\LeadReaction::where('notification_sent', false)
        ->where('next_follow_up', '>=', now()->format('Y-m-d'))
        ->count(),
    'sent_today' => \App\Models\LeadReaction::where('notification_sent', true)
        ->whereDate('notification_sent_at', today())
        ->count(),
    'overdue' => \App\Models\LeadReaction::where('notification_sent', false)
        ->where('next_follow_up', '<', now()->format('Y-m-d'))
        ->count(),
];

// Get all projects/tickets for the table
$projects = App\Models\Product::with(['category', 'user'])->orderBy('created_at', 'desc')->take(10)->get();
@endphp

<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-number">{{ $numberofclients }}</div>
            <div class="stat-label">
                <i class="fas fa-users me-2"></i>Total Clients
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-number">{{ $numberofemployeeID }}</div>
            <div class="stat-label">
                <i class="fas fa-user-tie me-2"></i>Total Employees
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-number">{{ $resolved }}</div>
            <div class="stat-label">
                <i class="fas fa-check-circle me-2"></i>Completed Work
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-number">{{ $numberofticketpending + $inprogress }}</div>
            <div class="stat-label">
                <i class="fas fa-clock me-2"></i>Pending Work
            </div>
        </div>
    </div>
</div>

<!-- Reaction Notification Widget -->
<div class="row mt-4">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bell me-2"></i>Reaction Notifications
                </h5>
                <div>
                    <a href="{{ route('reactions-system.index') }}" class="btn-action btn-primary-custom">
                        <i class="fas fa-cog me-2"></i>Manage Reactions
                    </a>
                    <a href="{{ route('leads.index') }}" class="btn-action btn-success-custom ms-2">
                        <i class="fas fa-users me-2"></i>View Leads
                    </a>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="reaction-stat-item">
                        <div class="reaction-stat-icon bg-primary">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="reaction-stat-content">
                            <div class="reaction-stat-number">{{ $reactionStats['total'] }}</div>
                            <div class="reaction-stat-label">Total Reactions</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="reaction-stat-item">
                        <div class="reaction-stat-icon bg-info">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="reaction-stat-content">
                            <div class="reaction-stat-number">{{ $reactionStats['scheduled'] }}</div>
                            <div class="reaction-stat-label">Scheduled</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="reaction-stat-item">
                        <div class="reaction-stat-icon bg-success">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="reaction-stat-content">
                            <div class="reaction-stat-number">{{ $reactionStats['sent_today'] }}</div>
                            <div class="reaction-stat-label">Sent Today</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="reaction-stat-item">
                        <div class="reaction-stat-icon bg-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="reaction-stat-content">
                            <div class="reaction-stat-number">{{ $reactionStats['overdue'] }}</div>
                            <div class="reaction-stat-label">Overdue</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Automated notifications run every minute. Last check: {{ now()->format('H:i') }}
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Employee Projects Table -->
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Employee Project List</h5>
                <div>
                    <a href="{{ route('manage-product') }}" class="btn-action btn-primary-custom">
                        <i class="fas fa-list me-2"></i>View All
                    </a>
                </div>
            </div>
            
            <div class="table-container">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>Project ID</th>
                            <th>Project Name</th>
                            <th>Assigned Employee</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td><strong>#{{ $project->id }}</strong></td>
                                <td>{{ Str::limit($project->product_name, 30) }}</td>
                                <td>
                                    @if($project->user)
                                        {{ $project->user->name }}
                                    @else
                                        <span class="text-muted">Unassigned</span>
                                    @endif
                                </td>
                                <td>
                                    @if($project->category)
                                        {{ $project->category->category_name }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($project->status == 0)
                                        <span class="badge-status bg-warning">Pending</span>
                                    @elseif($project->status == 1)
                                        <span class="badge-status bg-info">In Progress</span>
                                    @elseif($project->status == 2)
                                        <span class="badge-status bg-success">Completed</span>
                                    @elseif($project->status == 3)
                                        <span class="badge-status bg-primary">Resolved</span>
                                    @else
                                        <span class="badge-status bg-secondary">Unknown</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($project->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('product.preview', $project->id) }}" 
                                           class="btn-action btn-primary-custom" 
                                           title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('product.edit', $project->id) }}" 
                                           class="btn-action btn-warning-custom" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn-action btn-danger-custom" 
                                                title="Delete"
                                                onclick="confirmDelete({{ $project->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    No projects found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this project? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(projectId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/product/delete/${projectId}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>

<style>
.reaction-stat-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-radius: 10px;
    background: #f8f9fa;
    border-left: 4px solid #007bff;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.reaction-stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.reaction-stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 1rem;
    font-size: 1.2rem;
}

.reaction-stat-content {
    flex-grow: 1;
}

.reaction-stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2c3e50;
    line-height: 1;
}

.reaction-stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.reaction-stat-icon.bg-primary { background: linear-gradient(135deg, #007bff, #0056b3); }
.reaction-stat-icon.bg-info { background: linear-gradient(135deg, #17a2b8, #0c5460); }
.reaction-stat-icon.bg-success { background: linear-gradient(135deg, #28a745, #155724); }
.reaction-stat-icon.bg-warning { background: linear-gradient(135deg, #ffc107, #d39e00); }
</style>

@endsection