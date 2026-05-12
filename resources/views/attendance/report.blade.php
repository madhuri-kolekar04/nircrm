@extends('admin.admin_master')

@section('title', 'Attendance Reports - NIRCRM')

@section('admin')
<div class="container-fluid">
    <!-- Enhanced Page Header with NIRCRM Branding -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white shadow-lg">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-white bg-opacity-25 p-3 me-3">
                                    <i class="fas fa-chart-line fa-2x"></i>
                                </div>
                                <div>
                                    <h1 class="h3 mb-1 text-white">Attendance Reports</h1>
                                    <p class="mb-0 text-white-50">Comprehensive attendance analytics and reporting system</p>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-3">
                                    <div class="border-end border-white-50">
                                        <h4 class="mb-0 text-white">{{ $attendances->count() }}</h4>
                                        <small class="text-white-50">Total Records</small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="border-end border-white-50">
                                        <h4 class="mb-0 text-white">{{ $attendances->where('status', 'present')->count() }}</h4>
                                        <small class="text-white-50">Present</small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="border-end border-white-50">
                                        <h4 class="mb-0 text-white">{{ $attendances->where('status', 'absent')->count() }}</h4>
                                        <small class="text-white-50">Absent</small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <h4 class="mb-0 text-white">{{ number_format($attendances->sum('working_hours'), 1) }}h</h4>
                                    <small class="text-white-50">Total Hours</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('attendance.dashboard') }}" class="btn btn-outline-light">
                                    <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                                </a>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" id="downloadPDF">
                                        <i class="fas fa-file-pdf me-2"></i> PDF
                                    </button>
                                    <button type="button" class="btn btn-info" id="downloadExcel">
                                        <i class="fas fa-file-excel me-2"></i> Excel
                                    </button>
                                    <button type="button" class="btn btn-warning" id="printReport">
                                        <i class="fas fa-print me-2"></i> Print
                                    </button>
                                    <button type="button" class="btn btn-primary" id="emailReport">
                                        <i class="fas fa-envelope me-2"></i> Email
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Filters Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 text-primary fw-bold">
                            <i class="fas fa-filter me-2"></i>Report Filters
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="toggleFilters">
                            <i class="fas fa-chevron-up"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" id="filtersBody">
                    <form id="reportFilterForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1"></i> Start Date
                                </label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                       value="{{ $startDate->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1"></i> End Date
                                </label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                       value="{{ $endDate->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-building me-1"></i> Department
                                </label>
                                <select class="form-select" id="department_filter" name="department_id">
                                    <option value="">All Departments</option>
                                    @foreach(\App\Models\Department::all() as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-info-circle me-1"></i> Status
                                </label>
                                <select class="form-select" id="status_filter" name="status">
                                    <option value="">All Status</option>
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="half_day">Half Day</option>
                                    <option value="on_leave">On Leave</option>
                                    <option value="holiday">Holiday</option>
                                    <option value="weekend">Weekend</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i> Apply Filters
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="resetFilters">
                                        <i class="fas fa-undo me-2"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Summary Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-gradient-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Present Days</h6>
                            <h3 class="text-white mb-0">{{ $attendances->where('status', 'present')->count() }}</h3>
                            <small class="text-white-50">
                                {{ $attendances->count() > 0 ? round(($attendances->where('status', 'present')->count() / $attendances->count()) * 100, 1) : 0 }}% attendance rate
                            </small>
                        </div>
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-user-check fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-gradient-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Absent Days</h6>
                            <h3 class="text-white mb-0">{{ $attendances->where('status', 'absent')->count() }}</h3>
                            <small class="text-white-50">
                                {{ $attendances->count() > 0 ? round(($attendances->where('status', 'absent')->count() / $attendances->count()) * 100, 1) : 0 }}% absence rate
                            </small>
                        </div>
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-user-times fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-gradient-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Total Hours</h6>
                            <h3 class="text-white mb-0">{{ number_format($attendances->sum('working_hours'), 1) }}h</h3>
                            <small class="text-white-50">
                                Avg: {{ $attendances->count() > 0 ? number_format($attendances->sum('working_hours') / $attendances->count(), 1) : 0 }}h/day
                            </small>
                        </div>
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-clock fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-gradient-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Overtime</h6>
                            <h3 class="text-white mb-0">{{ number_format($attendances->sum('overtime_hours'), 1) }}h</h3>
                            <small class="text-white-50">
                                {{ $userSummaries->where('overtimeHours', '>', 0)->count() }} users with OT
                            </small>
                        </div>
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-hourglass-half fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Employee Summary Table -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 text-primary fw-bold">
                            <i class="fas fa-users me-2"></i>Employee Summary
                        </h6>
                        <span class="badge bg-primary">{{ $userSummaries->count() }} Employees</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="userSummaryTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th class="text-center">Total Days</th>
                                    <th class="text-center">Present</th>
                                    <th class="text-center">Absent</th>
                                    <th class="text-center">Leave</th>
                                    <th class="text-center">Half Day</th>
                                    <th class="text-center">Total Hours</th>
                                    <th class="text-center">Overtime</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($userSummaries->count() > 0)
                                    @foreach($userSummaries as $summary)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3" 
                                                         style="width: 40px; height: 40px; font-size: 16px; font-weight: bold;">
                                                        {{ strtoupper(substr($summary['user']->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $summary['user']->name }}</div>
                                                        <small class="text-muted">{{ $summary['user']->getRoleNameAttribute() }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($summary['user']->department)
                                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-1">
                                                        @if(is_object($summary['user']->department))
                                                            {{ $summary['user']->department->name }}
                                                        @else
                                                            {{ $summary['user']->department }}
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1">N/A</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary">{{ $summary['totalDays'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success">{{ $summary['present'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-danger">{{ $summary['absent'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $summary['onLeave'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning">{{ $summary['halfDay'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ number_format($summary['totalHours'], 1) }}h</strong>
                                        </td>
                                        <td class="text-center">
                                            @if($summary['overtimeHours'] > 0)
                                                <span class="text-success fw-bold">+{{ number_format($summary['overtimeHours'], 1) }}h</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-primary view-details" 
                                                        data-user-id="{{ $summary['user']->id }}" data-user-name="{{ $summary['user']->name }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-success export-user" 
                                                        data-user-id="{{ $summary['user']->id }}" data-user-name="{{ $summary['user']->name }}">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <h5>No attendance data found</h5>
                                                <p>There are no attendance records for the selected date range and filters.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Detailed Attendance Records -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 text-primary fw-bold">
                            <i class="fas fa-list-alt me-2"></i>Detailed Attendance Records
                        </h6>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary" id="toggleDetails">
                                <i class="fas fa-eye me-1"></i> Toggle Details
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="showAllRecords">
                                <i class="fas fa-expand me-1"></i> Show All
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="detailedAttendanceTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Working Hours</th>
                                    <th>Overtime</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($attendances->count() > 0)
                                    @foreach($attendances as $attendance)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $attendance->date->format('d M Y') }}</div>
                                                <small class="text-muted">{{ $attendance->date->format('l') }}</small>
                                            </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-2" 
                                                     style="width: 30px; height: 30px; font-size: 12px; font-weight: bold;">
                                                    {{ strtoupper(substr($attendance->user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $attendance->user->name }}</div>
                                                    <small class="text-muted">{{ $attendance->user->getRoleNameAttribute() }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($attendance->user->department)
                                                <span class="badge bg-info bg-opacity-10 text-info px-2 py-1">
                                                    @if(is_object($attendance->user->department))
                                                        {{ $attendance->user->department->name }}
                                                    @else
                                                        {{ $attendance->user->department }}
                                                    @endif
                                                </span>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->check_in_time)
                                                <div class="text-success">
                                                    {{ $attendance->check_in_time->format('H:i') }}
                                                    @if($attendance->is_late)
                                                        <i class="fas fa-exclamation-triangle text-warning ms-1" title="Late"></i>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->check_out_time)
                                                <div class="text-warning">
                                                    {{ $attendance->check_out_time->format('H:i') }}
                                                    @if($attendance->is_early_checkout)
                                                        <i class="fas fa-exclamation-triangle text-warning ms-1" title="Early Checkout"></i>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <strong>
                                                @if($attendance->working_hours)
                                                    {{ number_format($attendance->working_hours, 1) }}h
                                                @else
                                                    -
                                                @endif
                                            </strong>
                                        </td>
                                        <td class="text-center">
                                            @if($attendance->overtime_hours > 0)
                                                <span class="text-success fw-bold">+{{ number_format($attendance->overtime_hours, 1) }}h</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'present' => 'success',
                                                    'absent' => 'danger', 
                                                    'half_day' => 'warning',
                                                    'on_leave' => 'info',
                                                    'holiday' => 'secondary',
                                                    'weekend' => 'dark'
                                                ];
                                                $color = $statusColors[$attendance->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}">{{ ucfirst(str_replace('_', ' ', $attendance->status)) }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $attendance->notes ?? '-' }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <h5>No detailed records found</h5>
                                                <p>There are no attendance records for the selected date range and filters.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Report Modal -->
    <div class="modal fade" id="emailReportModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-envelope me-2"></i>Share Attendance Report
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="emailReportForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-envelope me-1"></i> Recipient Email
                                </label>
                                <input type="email" class="form-control" id="recipient_email" name="recipient_email" 
                                       placeholder="Enter email address" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-tag me-1"></i> Subject
                                </label>
                                <input type="text" class="form-control" id="email_subject" name="email_subject" 
                                       value="NIRCRM Attendance Report - {{ $startDate->format('d M Y') }} to {{ $endDate->format('d M Y') }}" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-comment me-1"></i> Message
                                </label>
                                <textarea class="form-control" id="email_message" name="email_message" rows="4" 
                                          placeholder="Add a custom message (optional)">Please find attached the attendance report for the period {{ $startDate->format('d M Y') }} to {{ $endDate->format('d M Y') }}.</textarea>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="include_summary" name="include_summary" checked>
                                    <label class="form-check-label" for="include_summary">
                                        Include summary statistics
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="include_detailed" name="include_detailed" checked>
                                    <label class="form-check-label" for="include_detailed">
                                        Include detailed records
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="sendEmailReport">
                        <i class="fas fa-paper-plane me-2"></i> Send Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mb-0">Generating report, please wait...</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
    }
    .bg-gradient-danger {
        background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%) !important;
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%) !important;
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f2994a 0%, #f2c94c 100%) !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
    }
    .badge {
        font-weight: 500;
    }
    .card {
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .btn {
        transition: all 0.2s ease-in-out;
    }
    .btn:hover {
        transform: translateY(-1px);
    }
    @media print {
        .no-print {
            display: none !important;
        }
        .card {
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
$(document).ready(function() {
    // Report filter form submission
    $('#reportFilterForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        window.location.href = '{{ route("attendance.report") }}?' + formData;
    });
    
    // Reset filters
    $('#resetFilters').click(function() {
        $('#reportFilterForm')[0].reset();
        window.location.href = '{{ route("attendance.report") }}';
    });
    
    // Toggle filters
    $('#toggleFilters').click(function() {
        $('#filtersBody').slideToggle();
        $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
    });
    
    // Download PDF
    $('#downloadPDF').click(function() {
        $('#loadingModal').modal('show');
        
        setTimeout(function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            // Add NIRCRM branding
            doc.setFontSize(20);
            doc.setTextColor(102, 126, 234);
            doc.text('NIRCRM Attendance Report', 14, 20);
            
            doc.setFontSize(12);
            doc.setTextColor(100);
            doc.text('Period: {{ $startDate->format("d M Y") }} - {{ $endDate->format("d M Y") }}', 14, 30);
            doc.text('Generated on: ' + new Date().toLocaleDateString(), 14, 37);
            
            // Add summary statistics
            doc.setFontSize(14);
            doc.setTextColor(50);
            doc.text('Summary Statistics', 14, 50);
            
            doc.setFontSize(10);
            doc.text('Total Records: {{ $attendances->count() }}', 14, 60);
            doc.text('Present: {{ $attendances->where("status", "present")->count() }}', 14, 67);
            doc.text('Absent: {{ $attendances->where("status", "absent")->count() }}', 14, 74);
            doc.text('Total Hours: {{ number_format($attendances->sum("working_hours"), 2) }}h', 14, 81);
            
            // Add detailed table
            let tableData = [];
            $('#detailedAttendanceTable tbody tr').each(function() {
                let row = [];
                $(this).find('td').each(function() {
                    row.push($(this).text().trim());
                });
                tableData.push(row);
            });
            
            doc.autoTable({
                head: [['Date', 'Employee', 'Department', 'Check In', 'Check Out', 'Hours', 'Overtime', 'Status', 'Notes']],
                body: tableData,
                startY: 90,
                theme: 'grid',
                styles: { fontSize: 8 },
                headStyles: { fillColor: [102, 126, 234] }
            });
            
            doc.save('attendance_report_{{ $startDate->format("Y-m-d") }}_to_{{ $endDate->format("Y-m-d") }}.pdf');
            $('#loadingModal').modal('hide');
        }, 1000);
    });
    
    // Download Excel
    $('#downloadExcel').click(function() {
        $('#loadingModal').modal('show');
        
        setTimeout(function() {
            // Create workbook with multiple sheets
            var wb = XLSX.utils.book_new();
            
            // Summary sheet
            var summaryData = [
                ['NIRCRM Attendance Report Summary'],
                ['Period', '{{ $startDate->format("d M Y") }} - {{ $endDate->format("d M Y") }}'],
                ['Generated', new Date().toLocaleDateString()],
                [],
                ['Total Records', '{{ $attendances->count() }}'],
                ['Present', '{{ $attendances->where("status", "present")->count() }}'],
                ['Absent', '{{ $attendances->where("status", "absent")->count() }}'],
                ['Total Hours', '{{ number_format($attendances->sum("working_hours"), 2) }}h'],
                ['Overtime Hours', '{{ number_format($attendances->sum("overtime_hours"), 2) }}h']
            ];
            
            var summaryWs = XLSX.utils.aoa_to_sheet(summaryData);
            XLSX.utils.book_append_sheet(wb, summaryWs, "Summary");
            
            // Employee summary sheet
            var employeeData = [];
            $('#userSummaryTable thead tr th').each(function() {
                employeeData.push([$(this).text().trim()]);
            });
            
            $('#userSummaryTable tbody tr').each(function() {
                var row = [];
                $(this).find('td').each(function() {
                    row.push($(this).text().trim());
                });
                employeeData.push(row);
            });
            
            var employeeWs = XLSX.utils.aoa_to_sheet(employeeData);
            XLSX.utils.book_append_sheet(wb, employeeWs, "Employee Summary");
            
            // Detailed records sheet
            var detailData = [];
            $('#detailedAttendanceTable thead tr th').each(function() {
                detailData.push([$(this).text().trim()]);
            });
            
            $('#detailedAttendanceTable tbody tr').each(function() {
                var row = [];
                $(this).find('td').each(function() {
                    row.push($(this).text().trim());
                });
                detailData.push(row);
            });
            
            var detailWs = XLSX.utils.aoa_to_sheet(detailData);
            XLSX.utils.book_append_sheet(wb, detailWs, "Detailed Records");
            
            var filename = 'NIRCRM_attendance_report_{{ $startDate->format("Y-m-d") }}_to_{{ $endDate->format("Y-m-d") }}.xlsx';
            XLSX.writeFile(wb, filename);
            
            $('#loadingModal').modal('hide');
        }, 1000);
    });
    
    // Export individual user data
    $('.export-user').click(function() {
        var userName = $(this).data('user-name');
        var userId = $(this).data('user-id');
        
        $('#loadingModal').modal('show');
        
        setTimeout(function() {
            // Filter table data for this user
            var rows = $('#detailedAttendanceTable tbody tr').filter(function() {
                return $(this).find('td:eq(1)').text().includes(userName);
            });
            
            if (rows.length === 0) {
                alert('No data found for this user');
                $('#loadingModal').modal('hide');
                return;
            }
            
            // Create a temporary table with user data
            var tempTable = $('<table></table>');
            tempTable.append($('#detailedAttendanceTable thead').clone());
            rows.clone().appendTo(tempTable);
            
            var ws = XLSX.utils.table_to_sheet(tempTable[0]);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, userName + " Attendance");
            
            var filename = 'NIRCRM_' + userName.replace(/\s+/g, '_') + '_attendance_{{ $startDate->format("Y-m-d") }}_to_{{ $endDate->format("Y-m-d") }}.xlsx';
            XLSX.writeFile(wb, filename);
            
            $('#loadingModal').modal('hide');
        }, 500);
    });
    
    // Email report functionality
    $('#emailReport').click(function() {
        $('#emailReportModal').modal('show');
    });
    
    // Send email report
    $('#sendEmailReport').click(function() {
        var recipientEmail = $('#recipient_email').val();
        var subject = $('#email_subject').val();
        var message = $('#email_message').val();
        var includeSummary = $('#include_summary').is(':checked');
        var includeDetailed = $('#include_detailed').is(':checked');
        
        // Validate email
        if (!recipientEmail) {
            alert('Please enter recipient email address');
            return;
        }
        
        $('#loadingModal').modal('show');
        $('#emailReportModal').modal('hide');
        
        // Generate email content
        var emailContent = '<h2>NIRCRM Attendance Report</h2>';
        emailContent += '<p><strong>Period:</strong> {{ $startDate->format("d M Y") }} - {{ $endDate->format("d M Y") }}</p>';
        emailContent += '<p><strong>Generated:</strong> ' + new Date().toLocaleDateString() + '</p>';
        
        if (includeSummary) {
            emailContent += '<h3>Summary Statistics</h3>';
            emailContent += '<ul>';
            emailContent += '<li>Total Records: {{ $attendances->count() }}</li>';
            emailContent += '<li>Present: {{ $attendances->where("status", "present")->count() }}</li>';
            emailContent += '<li>Absent: {{ $attendances->where("status", "absent")->count() }}</li>';
            emailContent += '<li>Total Hours: {{ number_format($attendances->sum("working_hours"), 2) }}h</li>';
            emailContent += '</ul>';
        }
        
        if (includeDetailed) {
            emailContent += '<h3>Detailed Records</h3>';
            emailContent += '<table border="1" style="border-collapse: collapse; width: 100%;">';
            emailContent += '<thead><tr><th>Date</th><th>Employee</th><th>Department</th><th>Check In</th><th>Check Out</th><th>Hours</th><th>Status</th></tr></thead>';
            emailContent += '<tbody>';
            
            $('#detailedAttendanceTable tbody tr').each(function() {
                var cells = $(this).find('td');
                emailContent += '<tr>';
                cells.each(function(index) {
                    emailContent += '<td>' + $(this).text() + '</td>';
                });
                emailContent += '</tr>';
            });
            
            emailContent += '</tbody></table>';
        }
        
        if (message) {
            emailContent += '<p><strong>Message:</strong> ' + message + '</p>';
        }
        
        emailContent += '<hr><p><small>This is an automated report from NIRCRM Attendance System.</small></p>';
        
        // Send email via AJAX
        $.ajax({
            url: '{{ route("attendance.send.email") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                recipient_email: recipientEmail,
                subject: subject,
                message: message,
                include_summary: includeSummary ? 1 : 0,
                include_detailed: includeDetailed ? 1 : 0,
                email_content: emailContent
            },
            success: function(response) {
                $('#loadingModal').modal('hide');
                if (response.success) {
                    alert('Report sent successfully to ' + recipientEmail);
                } else {
                    alert('Failed to send report: ' + response.message);
                }
            },
            error: function() {
                $('#loadingModal').modal('hide');
                alert('Failed to send report. Please try again.');
            }
        });
    });
    
    // Toggle detailed view
    $('#toggleDetails').click(function() {
        $('#detailedAttendanceTable').toggle();
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });
    
    // Print report
    $('#printReport').click(function() {
        window.print();
    });
    
    // View user details
    $('.view-details').click(function() {
        var userName = $(this).data('user-name');
        
        // Filter the table to show this user's records
        $('#detailedAttendanceTable tbody tr').each(function() {
            if ($(this).find('td:eq(1)').text().includes(userName)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        
        // Scroll to detailed table
        $('#detailedAttendanceTable')[0].scrollIntoView({ behavior: 'smooth' });
        
        // Show all button if not exists
        if (!$('#showAllBtn').length) {
            $('<button type="button" class="btn btn-sm btn-outline-secondary ms-2" id="showAllBtn"><i class="fas fa-expand me-1"></i> Show All</button>')
                .insertAfter('#toggleDetails');
        }
    });
    
    // Show all records
    $(document).on('click', '#showAllBtn, #showAllRecords', function() {
        $('#detailedAttendanceTable tbody tr').show();
        $('#showAllBtn').remove();
    });
});
</script>
@endpush
