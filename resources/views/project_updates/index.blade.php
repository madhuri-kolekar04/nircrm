@extends('admin.admin_master')

@section('page-title', 'Project Updates Dashboard')

@section('admin')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="card-title mb-2">
                                <i class="fas fa-project-diagram"></i> Project Updates Dashboard
                            </h3>
                            <p class="card-text mb-0">
                                Comprehensive view of project updates and invoice management
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('employee-report.index') }}" class="btn btn-light me-2">
                                <i class="fas fa-chart-bar"></i> Employee Report
                            </a>
                            <a href="{{ route('project-updates.dashboard') }}" class="btn btn-warning">
                                <i class="fas fa-sync"></i> Refresh Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Dashboard Section -->
    @if(isset($projectData))
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-gradient-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line"></i> Project-wise Update Dashboard
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Summary Cards -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title">Total Projects</h6>
                                                <h3 class="mb-0">{{ $projectData->count() }}</h3>
                                            </div>
                                            <div class="fa-2x">
                                                <i class="fas fa-folder-open"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title">Active Projects</h6>
                                                <h3 class="mb-0">{{ $projectData->where('status', 'active')->count() }}</h3>
                                            </div>
                                            <div class="fa-2x">
                                                <i class="fas fa-play-circle"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title">Total Updates</h6>
                                                <h3 class="mb-0">{{ $projectData->sum('total_updates') }}</h3>
                                            </div>
                                            <div class="fa-2x">
                                                <i class="fas fa-edit"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title">Avg Completion</h6>
                                                <h3 class="mb-0">{{ round($projectData->avg('completion_percentage')) }}%</h3>
                                            </div>
                                            <div class="fa-2x">
                                                <i class="fas fa-percentage"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Project Cards -->
                        <div class="row">
                            @foreach($projectData as $data)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0 text-truncate" style="max-width: 200px;">
                                                    {{ $data['project']->product_name_en }}
                                                </h6>
                                                <div>
                                                    <span class="badge bg-{{ $data['status'] == 'active' ? 'success' : ($data['status'] == 'moderate' ? 'warning' : 'secondary') }}">
                                                        {{ ucfirst($data['status']) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <!-- Project Info -->
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <small class="text-muted">Category</small>
                                                    <div>{{ $data['project']->category->category_name_en ?? 'N/A' }}</div>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Customer</small>
                                                    <div>{{ $data['project']->customer->name ?? 'N/A' }}</div>
                                                </div>
                                            </div>

                                            <!-- Progress Bar -->
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <small class="text-muted">Completion</small>
                                                    <small class="text-muted">{{ $data['completion_percentage'] }}%</small>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-{{ $data['completion_percentage'] >= 70 ? 'success' : ($data['completion_percentage'] >= 40 ? 'warning' : 'danger') }}" 
                                                         role="progressbar" 
                                                         style="width: {{ $data['completion_percentage'] }}%">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Stats -->
                                            <div class="row mb-3">
                                                <div class="col-4 text-center">
                                                    <small class="text-muted">Updates</small>
                                                    <div class="fw-bold">{{ $data['total_updates'] }}</div>
                                                </div>
                                                <div class="col-4 text-center">
                                                    <small class="text-muted">Frequency</small>
                                                    <div>
                                                        <span class="badge bg-{{ $data['update_frequency'] == 'high' ? 'success' : ($data['update_frequency'] == 'medium' ? 'warning' : 'secondary') }} text-white">
                                                            {{ ucfirst($data['update_frequency']) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-center">
                                                    <small class="text-muted">Team</small>
                                                    <div class="fw-bold">{{ $data['employees_involved']->count() }}</div>
                                                </div>
                                            </div>

                                            <!-- Last Update -->
                                            @if($data['last_update'])
                                                <div class="mb-3">
                                                    <small class="text-muted">Last Update</small>
                                                    <div>{{ $data['last_update']->format('M d, Y H:i') }}</div>
                                                </div>
                                            @endif

                                            <!-- Employees Involved -->
                                            @if($data['employees_involved']->count() > 0)
                                                <div class="mb-3">
                                                    <small class="text-muted">Team Members</small>
                                                    <div>
                                                        @foreach($data['employees_involved']->take(3) as $employee)
                                                            <span class="badge bg-light text-dark me-1">{{ $employee }}</span>
                                                        @endforeach
                                                        @if($data['employees_involved']->count() > 3)
                                                            <span class="badge bg-secondary">+{{ $data['employees_involved']->count() - 3 }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Action Buttons -->
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('project-updates.show', $data['project']->id) }}" 
                                                   class="btn btn-sm btn-primary flex-fill">
                                                    <i class="fas fa-eye"></i> View Details
                                                </a>
                                                @if($data['recent_updates']->count() > 0)
                                                    <button type="button" 
                                                            class="btn btn-sm btn-info flex-fill" 
                                                            data-bs-toggle="collapse" 
                                                            data-bs-target="#recentUpdates{{ $data['project']->id }}">
                                                        <i class="fas fa-history"></i> Recent
                                                    </button>
                                                @endif
                                            </div>

                                            <!-- Recent Updates Collapse -->
                                            @if($data['recent_updates']->count() > 0)
                                                <div class="collapse mt-3" id="recentUpdates{{ $data['project']->id }}">
                                                    <div class="card card-body bg-light">
                                                        <h6 class="card-title">Recent Updates</h6>
                                                        @foreach($data['recent_updates'] as $update)
                                                            <div class="mb-2 pb-2 border-bottom">
                                                                <div class="d-flex justify-content-between">
                                                                    <small class="text-muted">{{ $update->update_date->format('d-m-Y H:i') }}</small>
                                                                    <small class="text-muted">{{ $update->user->name }}</small>
                                                                </div>
                                                                @if($update->update_point_1)
                                                                    <small>{{ \Illuminate\Support\Str::limit($update->update_point_1, 80) }}</small>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Existing Invoice Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Project Updates - Invoices</h5>
                    @if(!isset($projectData))
                        <a href="{{ route('project-updates.dashboard') }}" class="btn btn-success">
                            <i class="fas fa-chart-line"></i> View Project Dashboard
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Customer Name</th>
                                    <th>Project Name</th>
                                    <th>Department</th>
                                    <th>Total Payment</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td><strong>{{ $invoice->invoice_number }}</strong></td>
                                        <td>{{ $invoice->customer_name }}</td>
                                        <td>{{ $invoice->project_name }}</td>
                                        <td>
                                            @if(isset($invoice->department) && is_object($invoice->department))
                                                {{ $invoice->department->name ?? 'N/A' }}
                                            @elseif(isset($invoice->department) && is_string($invoice->department))
                                                @php
                                                    $deptData = json_decode($invoice->department);
                                                    if ($deptData && isset($deptData->name)) {
                                                        echo $deptData->name;
                                                    } elseif ($deptData && isset($deptData->department)) {
                                                        echo $deptData->department;
                                                    } else {
                                                        echo $invoice->department;
                                                    }
                                                @endphp
                                            @else
                                                {{ $invoice->department ?? 'N/A' }}
                                            @endif
                                        </td>
                                        <td>{{ $invoice->formatted_total_payment }}</td>
                                        <td>
                                            <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'overdue' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $invoice->invoice_date->format('d-m-Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('project-updates.show', $invoice->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <a href="{{ route('project-updates.show', $invoice->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Update
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No invoices found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.progress {
    background-color: #e9ecef;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.badge {
    font-size: 0.75em;
}

@media print {
    .btn, .no-print {
        display: none !important;
    }
    
    .card {
        border: 1px solid #ddd !important;
        page-break-inside: avoid;
    }
}
</style>
@endsection
