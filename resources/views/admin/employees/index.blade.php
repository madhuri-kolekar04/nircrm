@extends('admin.admin_master')

@section('page-title', 'Employees')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Employees</h5>
                    <a href="{{ route('employees.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Employee
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Department</th>
                                    <th>Position</th>
                                    @if(auth()->user()->role == 1)
                                    <th>Role</th>
                                    @endif
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $employee)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->contact_number }}</td>
                                        <td>
                                            @if($employee->department)
                                                @if(is_object($employee->department))
                                                    {{ $employee->department->department ?? $employee->department->department_name ?? $employee->department->name ?? 'N/A' }}
                                                @else
                                                    {{ $employee->department }}
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ isset($employee->position) ? $employee->position : 'N/A' }}</td>
                                        @if(auth()->user()->role == 1)
                                        <td>
                                            @switch($employee->role)
                                                @case(1)
                                                    <span class="badge bg-danger">Admin</span>
                                                    @break
                                                @case(2)
                                                    <span class="badge bg-primary">Employee</span>
                                                    @break
                                                @case(3)
                                                    <span class="badge bg-info">Customer</span>
                                                    @break
                                                @case(4)
                                                    <span class="badge bg-warning">Manager</span>
                                                    @break
                                                @case(5)
                                                    <span class="badge bg-success">CEO/General Manager</span>
                                                    @break
                                                @case(6)
                                                    <span class="badge bg-secondary">Marketing</span>
                                                    @break
                                                @case(7)
                                                    <span class="badge bg-secondary">Sales</span>
                                                    @break
                                                @case(8)
                                                    <span class="badge bg-secondary">Account</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark">Unknown ({{ $employee->role }})</span>
                                            @endswitch
                                        </td>
                                        @endif
                                        <td>
                                            @if($employee->email_varified_at)
                                                <span class="badge bg-success">Verified</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this employee?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ auth()->user()->role == 1 ? 9 : 8 }}" class="text-center">No employees found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
