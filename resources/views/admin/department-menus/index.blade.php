@extends('admin.admin_master')

@section('page-title', 'Department Menu Management')

@section('content')
<div class="content-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h2 class="mb-1">Department Menu Management</h2>
                                <p class="text-muted mb-0">Manage which menus are visible to each department</p>
                            </div>
                            <a href="{{ route('department-menus.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Assign New Menu
                            </a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Department</th>
                                        <th>Assigned Menus</th>
                                        <th>Menu Count</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($departments as $department)
                                        <tr>
                                            <td>
                                                <strong>{{ $department->department_name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $department->department_code ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                @if($department->departmentMenus && $department->departmentMenus->count() > 0)
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach($department->departmentMenus->take(5) as $menu)
                                                            <span class="badge bg-light text-dark">
                                                                <i class="{{ $menu->menu_icon }} me-1"></i>
                                                                {{ $menu->menu_title }}
                                                            </span>
                                                        @endforeach
                                                        @if($department->departmentMenus->count() > 5)
                                                            <span class="badge bg-secondary">
                                                                +{{ $department->departmentMenus->count() - 5 }} more
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">No menus assigned</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    {{ $department->departmentMenus ? $department->departmentMenus->count() : 0 }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('department-menus.edit', $department->id) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="Edit Menu Assignment">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('department-menus.create') }}?department={{ $department->id }}" 
                                                       class="btn btn-sm btn-outline-success" 
                                                       title="Quick Assign">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                                <h5>No departments found</h5>
                                                <p class="text-muted">Please create departments first to manage their menu assignments.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <i class="fas fa-building fa-2x text-primary mb-2"></i>
                                            <h4>{{ $departments->count() }}</h4>
                                            <p class="text-muted mb-0">Total Departments</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <i class="fas fa-utensils fa-2x text-success mb-2"></i>
                                            <h4>{{ $departments->sum(function($dept) { return $dept->departmentMenus ? $dept->departmentMenus->count() : 0; }) }}</h4>
                                            <p class="text-muted mb-0">Total Menu Assignments</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <i class="fas fa-check-circle fa-2x text-info mb-2"></i>
                                            <h4>{{ $departments->filter(function($dept) { return $dept->departmentMenus && $dept->departmentMenus->count() > 0; })->count() }}</h4>
                                            <p class="text-muted mb-0">Departments with Menus</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                                            <h4>{{ $departments->filter(function($dept) { return !$dept->departmentMenus || $dept->departmentMenus->count() == 0; })->count() }}</h4>
                                            <p class="text-muted mb-0">Departments without Menus</p>
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
@endsection
