@extends('admin.admin_master')

@section('page-title', 'Attendance Reports')

@section('content')
<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Attendance Reports</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('attendance.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-list"></i> Records
                </a>
                <button onclick="exportReport()" class="btn btn-success">
                    <i class="fas fa-download"></i> Export CSV
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-filter"></i> Report Filters
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('attendance.reports') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="date_from" class="form-label">From Date</label>
                            <input type="date" name="date_from" id="date_from" class="form-control" 
                                   value="{{ $startDate }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="date_to" class="form-label">To Date</label>
                            <input type="date" name="date_to" id="date_to" class="form-control" 
                                   value="{{ $endDate }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="user_id" class="form-label">Employee</label>
                            <select name="user_id" id="user_id" class="form-select">
                                <option value="">All Employees</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="department_id" class="form-label">Department</label>
                            <select name="department_id" id="department_id" class="form-select">
                                <option value="">All Departments</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Generate Report
                            </button>
                            <a href="{{ route('attendance.reports') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h4>{{ $summary->count() }}</h4>
                        <p class="mb-0">Employees</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-user-check fa-2x mb-2"></i>
                        <h4>{{ $summary->sum('present_days') }}</h4>
                        <p class="mb-0">Present Days</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-user-times fa-2x mb-2"></i>
                        <h4>{{ $summary->sum('absent_days') }}</h4>
                        <p class="mb-0">Absent Days</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-plane fa-2x mb-2"></i>
                        <h4>{{ $summary->sum('leave_days') }}</h4>
                        <p class="mb-0">Leave Days</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h4>{{ $summary->sum('total_hours') }}</h4>
                        <p class="mb-0">Total Hours</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-secondary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-business-time fa-2x mb-2"></i>
                        <h4>{{ $summary->sum('total_overtime') }}</h4>
                        <p class="mb-0">Overtime</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Report Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-table"></i> Detailed Report
                </h5>
                <div>
                    <span class="text-muted">Period: {{ $startDate }} to {{ $endDate }}</span>
                </div>
            </div>
            <div class="card-body">
                @if($summary->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="attendanceReportTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Employee</th>
                                    <th>Employee ID</th>
                                    <th>Department</th>
                                    <th>Total Days</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Leave</th>
                                    <th>Half Day</th>
                                    <th>Working Hours</th>
                                    <th>Overtime</th>
                                    <th>Late Count</th>
                                    <th>Early Count</th>
                                    <th>Attendance %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($summary as $employeeSummary)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 12px;">
                                                    {{ substr($employeeSummary['user']->full_name, 0, 1) }}
                                                </div>
                                                <div class="fw-bold">{{ $employeeSummary['user']->full_name }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $employeeSummary['user']->employee_id ?? 'N/A' }}</td>
                                        <td>{{ $employeeSummary['user']->department->name ?? 'N/A' }}</td>
                                        <td>{{ $employeeSummary['total_days'] }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $employeeSummary['present_days'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">{{ $employeeSummary['absent_days'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $employeeSummary['leave_days'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{ $employeeSummary['half_days'] }}</span>
                                        </td>
                                        <td>{{ number_format($employeeSummary['total_hours'], 2) }}h</td>
                                        <td>{{ number_format($employeeSummary['total_overtime'], 2) }}h</td>
                                        <td>
                                            @if($employeeSummary['late_count'] > 0)
                                                <span class="badge bg-warning">{{ $employeeSummary['late_count'] }}</span>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($employeeSummary['early_checkout_count'] > 0)
                                                <span class="badge bg-warning">{{ $employeeSummary['early_checkout_count'] }}</span>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif
                                        </td>
                                        <td>
                                            <?php
                                            $attendancePercentage = $employeeSummary['total_days'] > 0 
                                                ? round(($employeeSummary['present_days'] / $employeeSummary['total_days']) * 100, 2)
                                                : 0;
                                            $badgeColor = $attendancePercentage >= 90 ? 'success' : 
                                                          ($attendancePercentage >= 75 ? 'warning' : 'danger');
                                            ?>
                                            <span class="badge bg-{{ $badgeColor }}">{{ $attendancePercentage }}%</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                        <h5>No data found for the selected period</h5>
                        <p class="text-muted">Try adjusting your filters or select a different date range.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportReport() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route('attendance.export') }}';
    
    // Add CSRF token
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    form.appendChild(csrfToken);
    
    // Add filters
    const dateFrom = document.createElement('input');
    dateFrom.type = 'hidden';
    dateFrom.name = 'date_from';
    dateFrom.value = document.getElementById('date_from').value;
    form.appendChild(dateFrom);
    
    const dateTo = document.createElement('input');
    dateTo.type = 'hidden';
    dateTo.name = 'date_to';
    dateTo.value = document.getElementById('date_to').value;
    form.appendChild(dateTo);
    
    const userId = document.createElement('input');
    userId.type = 'hidden';
    userId.name = 'user_id';
    userId.value = document.getElementById('user_id').value;
    form.appendChild(userId);
    
    const departmentId = document.createElement('input');
    departmentId.type = 'hidden';
    departmentId.name = 'department_id';
    departmentId.value = document.getElementById('department_id').value;
    form.appendChild(departmentId);
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

// Initialize DataTable for better table functionality
document.addEventListener('DOMContentLoaded', function() {
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#attendanceReportTable').DataTable({
            pageLength: 25,
            order: [[12, 'desc']], // Sort by attendance percentage descending
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
    }
});
</script>
@endpush
