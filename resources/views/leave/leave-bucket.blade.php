@extends('admin.admin_master')

@section('page-title', 'Leave Bucket')

@section('admin')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-3 mb-md-0">
                    <h4 class="page-title mb-1">
                        <i class="fas fa-bucket text-primary me-2"></i>
                        Leave Bucket
                    </h4>
                    <p class="text-muted mb-0">Monthly leave summaries and analytics with demo data</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#analyticsModal">
                        <i class="fas fa-chart-line me-2"></i>Analytics
                    </button>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filtersModal">
                        <i class="fas fa-filter me-2"></i>Filters
                    </button>
                    <a href="{{ route('leave.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>New Leave Request
                    </a>
                    <a href="{{ route('leave.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Month Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-outline-primary" id="prevMonth">
                            <i class="fas fa-chevron-left me-2"></i>{{ \Carbon\Carbon::createFromDate($year, $month, 1)->subMonth()->format('F Y') }}
                        </button>
                        <h5 class="mb-0 fw-bold text-primary">
                            {{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}
                        </h5>
                        <button type="button" class="btn btn-outline-primary" id="nextMonth">
                            {{ \Carbon\Carbon::createFromDate($year, $month, 1)->addMonth()->format('F Y') }}<i class="fas fa-chevron-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold">{{ $bucketData['total_employees'] }}</div>
                    <div class="small">Total Employees</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-success text-white">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold">{{ $bucketData['total_leaves_this_month'] }}</div>
                    <div class="small">Total Leaves This Month</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-warning text-white">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold">{{ $bucketData['pending_approval'] }}</div>
                    <div class="small">Pending Approval</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-info text-white">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold">{{ $bucketData['average_leave_duration'] }}</div>
                    <div class="small">Avg Duration (Days)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Type Breakdown -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-pie me-2"></i>
                        Leave Type Breakdown
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="leaveTypeChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-list me-2"></i>
                        Leave Summary
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($leaveTypeBreakdown as $type => $data)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle me-2" style="width: 12px; height: 12px; background: {{ $data['color'] }};"></div>
                                <span>{{ $type }}</span>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">{{ $data['count'] }}</div>
                                <small class="text-muted">{{ $data['percentage'] }}%</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Department Wise Statistics -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-building me-2"></i>
                        Department Wise Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($bucketData['department_wise'] as $department => $data)
                            <div class="col-md-2 col-sm-4 col-6 mb-3">
                                <div class="text-center p-3 border rounded">
                                    <h6 class="fw-bold text-primary">{{ $department }}</h6>
                                    <div class="mb-2">
                                        <span class="badge bg-primary">{{ $data['total'] }} Total</span>
                                    </div>
                                    <div class="d-flex justify-content-between small">
                                        <span class="text-success">{{ $data['approved'] }} Approved</span>
                                        <span class="text-warning">{{ $data['pending'] }} Pending</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Statistics -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Monthly Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                                <span>Working Days</span>
                                <span class="fw-bold">{{ $monthlyStats['working_days'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                                <span>Weekends</span>
                                <span class="fw-bold">{{ $monthlyStats['weekends'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                                <span>Holidays</span>
                                <span class="fw-bold">{{ $monthlyStats['holidays'] }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                                <span>Total Leave Days</span>
                                <span class="fw-bold text-danger">{{ $monthlyStats['total_leave_days'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                                <span>Productivity Impact</span>
                                <span class="fw-bold text-warning">{{ $monthlyStats['productivity_impact'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                                <span>Attendance Rate</span>
                                <span class="fw-bold text-success">{{ $monthlyStats['attendance_rate'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-chart-line me-2"></i>
                        <strong>Leave Trend:</strong> {{ $monthlyStats['leave_trend'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-info-circle me-2"></i>
                        Quick Insights
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary">Peak Leave Days</h6>
                        <div class="d-flex gap-2">
                            @foreach($bucketData['peak_leave_days'] as $day)
                                <span class="badge bg-warning text-dark">{{ $day }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-success">Approval Rate</h6>
                        <div class="progress">
                            <?php $approvalRate = round(($bucketData['approved_leaves'] / $bucketData['total_leaves_this_month']) * 100); ?>
                            <div class="progress-bar bg-success" style="width: {{ $approvalRate }}%">
                                {{ $approvalRate }}%
                            </div>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-info">Leave Balance Status</h6>
                        <div class="small text-muted">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            Most employees have sufficient leave balance
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Trends Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-line me-2"></i>
                        Leave Trends (Last 6 Months)
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="trendsChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters Modal -->
<div class="modal fade" id="filtersModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-filter me-2"></i>Filter Leave Bucket
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="departmentFilter" class="form-label">Department</label>
                            <select class="form-select" id="departmentFilter" name="department_id">
                                <option value="">All Departments</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="monthFilter" class="form-label">Month</label>
                            <select class="form-select" id="monthFilter" name="month">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromDate(null, $m, 1)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="yearFilter" class="form-label">Year</label>
                            <select class="form-select" id="yearFilter" name="year">
                                @for($y = date('Y'); $y >= date('Y') - 2; $y--)
                                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="statusFilter" class="form-label">Status</label>
                            <select class="form-select" id="statusFilter" name="status">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-outline-danger" id="resetFilters">Reset</button>
                <button type="button" class="btn btn-primary" id="applyFilters">Apply Filters</button>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Modal -->
<div class="modal fade" id="analyticsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-chart-line me-2"></i>Advanced Analytics
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Leave Distribution by Day</h6>
                        <canvas id="dayDistributionChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <h6>Leave Duration Analysis</h6>
                        <canvas id="durationChart"></canvas>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <h6>Key Performance Indicators</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Metric</th>
                                        <th>Current Month</th>
                                        <th>Previous Month</th>
                                        <th>Change</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total Leave Days</td>
                                        <td>{{ $monthlyStats['total_leave_days'] }}</td>
                                        <td>98</td>
                                        <td><span class="text-success">+14.3%</span></td>
                                    </tr>
                                    <tr>
                                        <td>Average Duration</td>
                                        <td>{{ $bucketData['average_leave_duration'] }} days</td>
                                        <td>2.2 days</td>
                                        <td><span class="text-warning">+13.6%</span></td>
                                    </tr>
                                    <tr>
                                        <td>Approval Rate</td>
                                        <td>82.2%</td>
                                        <td>85.1%</td>
                                        <td><span class="text-danger">-2.9%</span></td>
                                    </tr>
                                    <tr>
                                        <td>Productivity Impact</td>
                                        <td>{{ $monthlyStats['productivity_impact'] }}</td>
                                        <td>4.5%</td>
                                        <td><span class="text-warning">+0.6%</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css" rel="stylesheet">
<style>
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.progress {
    height: 8px;
}

.badge {
    font-size: 0.75rem;
}

.text-primary {
    color: #007bff !important;
}

.text-success {
    color: #28a745 !important;
}

.text-warning {
    color: #ffc107 !important;
}

.text-danger {
    color: #dc3545 !important;
}

.text-info {
    color: #17a2b8 !important;
}

@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    
    .fs-2 {
        font-size: 1.5rem !important;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    setupEventListeners();
});

function initializeCharts() {
    // Leave Type Breakdown Chart
    const leaveTypeCtx = document.getElementById('leaveTypeChart').getContext('2d');
    new Chart(leaveTypeCtx, {
        type: 'doughnut',
        data: {
            labels: @json(array_keys($leaveTypeBreakdown)),
            datasets: [{
                data: @json(array_column($leaveTypeBreakdown, 'count')),
                backgroundColor: @json(array_column($leaveTypeBreakdown, 'color')),
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Trends Chart
    const trendsCtx = document.getElementById('trendsChart').getContext('2d');
    new Chart(trendsCtx, {
        type: 'line',
        data: {
            labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Total Leaves',
                data: [38, 42, 35, 48, 41, 45],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4
            }, {
                label: 'Approved Leaves',
                data: [32, 38, 30, 41, 35, 37],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Day Distribution Chart (for analytics modal)
    const dayDistCtx = document.getElementById('dayDistributionChart');
    if (dayDistCtx) {
        new Chart(dayDistCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                datasets: [{
                    label: 'Leaves by Day',
                    data: [12, 8, 6, 9, 10],
                    backgroundColor: '#007bff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Duration Chart (for analytics modal)
    const durationCtx = document.getElementById('durationChart');
    if (durationCtx) {
        new Chart(durationCtx.getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['1 Day', '2 Days', '3 Days', '4+ Days'],
                datasets: [{
                    data: [15, 18, 8, 4],
                    backgroundColor: ['#28a745', '#ffc107', '#fd7e14', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
}

function setupEventListeners() {
    document.getElementById('prevMonth').addEventListener('click', () => {
        const currentMonth = {{ $month }};
        const currentYear = {{ $year }};
        let newMonth = currentMonth - 1;
        let newYear = currentYear;
        
        if (newMonth < 1) {
            newMonth = 12;
            newYear--;
        }
        
        window.location.href = `/leave/leave-bucket?month=${newMonth}&year=${newYear}`;
    });
    
    document.getElementById('nextMonth').addEventListener('click', () => {
        const currentMonth = {{ $month }};
        const currentYear = {{ $year }};
        let newMonth = currentMonth + 1;
        let newYear = currentYear;
        
        if (newMonth > 12) {
            newMonth = 1;
            newYear++;
        }
        
        window.location.href = `/leave/leave-bucket?month=${newMonth}&year=${newYear}`;
    });
    
    document.getElementById('applyFilters').addEventListener('click', applyFilters);
    document.getElementById('resetFilters').addEventListener('click', resetFilters);
}

function applyFilters() {
    const month = document.getElementById('monthFilter').value;
    const year = document.getElementById('yearFilter').value;
    const department = document.getElementById('departmentFilter').value;
    const status = document.getElementById('statusFilter').value;
    
    let url = `/leave/leave-bucket?month=${month}&year=${year}`;
    if (department) url += `&department_id=${department}`;
    if (status) url += `&status=${status}`;
    
    window.location.href = url;
}

function resetFilters() {
    window.location.href = '/leave/leave-bucket';
}
</script>
@endpush
