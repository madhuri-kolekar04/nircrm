@extends('admin.admin_master')

@section('page-title', 'Calendar Leaves')

@section('admin')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-3 mb-md-0">
                    <h4 class="page-title mb-1">
                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                        Calendar Leaves
                    </h4>
                    <p class="text-muted mb-0">Complete calendar view with company holidays and all leaves</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#holidaysModal">
                        <i class="fas fa-gift me-2"></i>View Holidays
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

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold">{{ $leaves->count() }}</div>
                    <div class="small">Total Leaves</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-success text-white">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold">{{ $leaves->where('status', 'approved')->count() }}</div>
                    <div class="small">Approved</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-warning text-white">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold">{{ $leaves->where('status', 'pending')->count() }}</div>
                    <div class="small">Pending</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-danger text-white">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold">{{ $leaves->where('status', 'rejected')->count() }}</div>
                    <div class="small">Rejected</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-info text-white">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold">{{ count($holidays) }}</div>
                    <div class="small">Holidays</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-secondary text-white">
                <div class="card-body text-center">
                    <div class="fs-2 fw-bold">{{ $leaves->sum('total_days') }}</div>
                    <div class="small">Total Days</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Container -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-calendar me-2"></i>
                        Calendar View - {{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}
                    </h5>
                    <div class="d-flex gap-2 align-items-center">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-light btn-sm" id="prevMonth">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button type="button" class="btn btn-light btn-sm" id="todayBtn">
                                Today
                            </button>
                            <button type="button" class="btn btn-light btn-sm" id="nextMonth">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="calendar"></div>
                    <div class="calendar-legend">
                        <div class="legend-item">
                            <div class="legend-color" style="background: #28a745;"></div>
                            <span>Approved Leave</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #ffc107;"></div>
                            <span>Pending Leave</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #dc3545;"></div>
                            <span>Rejected Leave</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #6c757d;"></div>
                            <span>Cancelled Leave</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #ff6b6b;"></div>
                            <span>National Holiday</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #4ecdc4;"></div>
                            <span>Company Holiday</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #45b7d1;"></div>
                            <span>Regional Holiday</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Holidays -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-gift me-2"></i>
                        Upcoming Holidays
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($holidays as $holiday)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="d-flex align-items-center p-3 border rounded">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                            <i class="fas fa-calendar-day text-warning fs-4"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold">{{ $holiday['name'] }}</h6>
                                        <p class="mb-0 text-muted small">{{ \Carbon\Carbon::parse($holiday['date'])->format('d M Y') }}</p>
                                        <span class="badge bg-{{ $holiday['type'] == 'national' ? 'danger' : ($holiday['type'] == 'company' ? 'info' : 'primary') }} bg-opacity-10 text-{{ $holiday['type'] == 'national' ? 'danger' : ($holiday['type'] == 'company' ? 'info' : 'primary') }}">
                                            {{ ucfirst($holiday['type']) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
                    <i class="fas fa-filter me-2"></i>Filter Leaves
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
                            <label for="leaveTypeFilter" class="form-label">Leave Type</label>
                            <select class="form-select" id="leaveTypeFilter" name="leave_type_id">
                                <option value="">All Leave Types</option>
                                @foreach($leaveTypes as $leaveType)
                                    <option value="{{ $leaveType->id }}">{{ $leaveType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="userFilter" class="form-label">Employee</label>
                            <select class="form-select" id="userFilter" name="user_id">
                                <option value="">All Employees</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} {{ $user->last_name ?? '' }}</option>
                                @endforeach
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
                                <option value="on_hold">On Hold</option>
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

<!-- Holidays Modal -->
<div class="modal fade" id="holidaysModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-gift me-2"></i>Company Holidays {{ $year }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Holiday Name</th>
                                <th>Type</th>
                                <th>Days Until</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($holidays as $holiday)
                                @php
                                    $daysUntil = \Carbon\Carbon::parse($holiday['date'])->diffInDays(\Carbon\Carbon::today(), false);
                                @endphp
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($holiday['date'])->format('d M Y') }}</td>
                                    <td>{{ $holiday['name'] }}</td>
                                    <td>
                                        <span class="badge bg-{{ $holiday['type'] == 'national' ? 'danger' : ($holiday['type'] == 'company' ? 'info' : 'primary') }}">
                                            {{ ucfirst($holiday['type']) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($daysUntil > 0)
                                            <span class="text-success">{{ $daysUntil }} days</span>
                                        @elseif($daysUntil == 0)
                                            <span class="text-warning fw-bold">Today</span>
                                        @else
                                            <span class="text-muted">Passed</span>
                                        @endif
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

<!-- Leave Details Modal -->
<div class="modal fade" id="leaveDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2"></i>Leave Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="leaveDetailsContent">
                <!-- Leave details will be loaded here -->
            </div>
            <div class="modal-footer" id="leaveDetailsActions">
                <!-- Action buttons will be loaded here -->
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<style>
#calendar {
    height: 600px;
}

.fc-event {
    cursor: pointer;
    border-radius: 4px !important;
    border: none !important;
    padding: 2px 4px !important;
    font-size: 11px !important;
    margin: 1px 0 !important;
}

.fc-daygrid-day.fc-day-today {
    background-color: #e3f2fd !important;
}

.fc-toolbar-title {
    font-size: 1.2rem !important;
    font-weight: 600 !important;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.calendar-legend {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    margin-top: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 4px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.875rem;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 3px;
}

.holiday-event {
    background: linear-gradient(45deg, #ff6b6b, #ff8e8e) !important;
    border: 2px solid #ff5252 !important;
}

.company-holiday-event {
    background: linear-gradient(45deg, #4ecdc4, #6ee7df) !important;
    border: 2px solid #3db8af !important;
}

.regional-holiday-event {
    background: linear-gradient(45deg, #45b7d1, #6fc5da) !important;
    border: 2px solid #3498a8 !important;
}

@media (max-width: 768px) {
    #calendar {
        height: 400px;
    }
    
    .fc-toolbar-title {
        font-size: 1rem !important;
    }
    
    .btn-group .btn {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
let calendar;
let currentFilters = {
    department_id: '',
    leave_type_id: '',
    user_id: '',
    status: ''
};

document.addEventListener('DOMContentLoaded', function() {
    initializeCalendar();
    loadCalendarData();
    setupEventListeners();
});

function initializeCalendar() {
    const calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: false,
        height: 'auto',
        eventClick: handleEventClick,
        datesSet: function(info) {
            updateCalendarHeader(info.view.currentStart);
        }
    });
    calendar.render();
}

function loadCalendarData() {
    const currentData = calendar.view.currentStart;
    const month = currentData.getMonth() + 1;
    const year = currentData.getFullYear();
    
    // Load leaves
    const params = new URLSearchParams({
        month: month,
        year: year,
        ...currentFilters
    });
    
    fetch(`/leave/calendar-leaves-data?${params}`)
        .then(response => response.json())
        .then(data => {
            calendar.removeAllEvents();
            
            // Add leave events
            calendar.addEventSource(data.leaves);
            
            // Add holiday events
            data.holidays.forEach(holiday => {
                calendar.addEvent({
                    title: holiday.name,
                    start: holiday.date,
                    backgroundColor: getHolidayColor(holiday.type),
                    borderColor: getHolidayBorderColor(holiday.type),
                    textColor: '#fff',
                    extendedProps: {
                        type: 'holiday',
                        holiday_type: holiday.type,
                        description: holiday.name
                    }
                });
            });
        })
        .catch(error => {
            console.error('Error loading calendar data:', error);
        });
}

function handleEventClick(info) {
    const event = info.event;
    const props = event.extendedProps;
    
    if (props.type === 'holiday') {
        showHolidayDetails(props);
    } else {
        showLeaveDetails(props);
    }
}

function showHolidayDetails(holidayData) {
    const modal = new bootstrap.Modal(document.getElementById('leaveDetailsModal'));
    const content = document.getElementById('leaveDetailsContent');
    const actions = document.getElementById('leaveDetailsActions');
    
    content.innerHTML = `
        <div class="row">
            <div class="col-12">
                <h6>Holiday Information</h6>
                <p><strong>Name:</strong> ${holidayData.description}</p>
                <p><strong>Type:</strong> <span class="badge bg-${getHolidayBadgeColor(holidayData.holiday_type)}">${holidayData.holiday_type}</span></p>
                <p><strong>Date:</strong> ${info.event.start.toLocaleDateString()}</p>
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    This is a company holiday. No leave requests can be submitted for this date.
                </div>
            </div>
        </div>
    `;
    
    actions.innerHTML = `
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    `;
    
    modal.show();
}

function showLeaveDetails(leaveData) {
    const modal = new bootstrap.Modal(document.getElementById('leaveDetailsModal'));
    const content = document.getElementById('leaveDetailsContent');
    const actions = document.getElementById('leaveDetailsActions');
    
    content.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <h6>Employee Information</h6>
                <p><strong>Name:</strong> ${leaveData.employee}</p>
                <p><strong>Department:</strong> ${leaveData.department}</p>
            </div>
            <div class="col-md-6">
                <h6>Leave Information</h6>
                <p><strong>Type:</strong> ${leaveData.leave_type}</p>
                <p><strong>Status:</strong> <span class="badge bg-${getStatusColor(leaveData.status)}">${leaveData.status}</span></p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h6>Leave Details</h6>
                <p><strong>Duration:</strong> ${leaveData.total_days} day(s) ${leaveData.is_half_day ? '(' + leaveData.half_day_type + ')' : ''}</p>
                <p><strong>Reason:</strong> ${leaveData.reason}</p>
                ${leaveData.approver ? `<p><strong>Approved by:</strong> ${leaveData.approver}</p>` : ''}
            </div>
        </div>
    `;
    
    actions.innerHTML = '';
    if (leaveData.can_approve) {
        actions.innerHTML += `
            <button type="button" class="btn btn-success" onclick="approveLeave(${leaveData.id})">
                <i class="fas fa-check me-2"></i>Approve
            </button>
            <button type="button" class="btn btn-danger" onclick="rejectLeave(${leaveData.id})">
                <i class="fas fa-times me-2"></i>Reject
            </button>
        `;
    }
    
    if (leaveData.can_cancel) {
        actions.innerHTML += `
            <button type="button" class="btn btn-warning" onclick="cancelLeave(${leaveData.id})">
                <i class="fas fa-ban me-2"></i>Cancel
            </button>
        `;
    }
    
    modal.show();
}

function getHolidayColor(type) {
    const colors = {
        'national': '#ff6b6b',
        'company': '#4ecdc4',
        'regional': '#45b7d1'
    };
    return colors[type] || '#6c757d';
}

function getHolidayBorderColor(type) {
    const colors = {
        'national': '#ff5252',
        'company': '#3db8af',
        'regional': '#3498a8'
    };
    return colors[type] || '#545b62';
}

function getHolidayBadgeColor(type) {
    const colors = {
        'national': 'danger',
        'company': 'info',
        'regional': 'primary'
    };
    return colors[type] || 'secondary';
}

function getStatusColor(status) {
    const colors = {
        'approved': 'success',
        'pending': 'warning',
        'rejected': 'danger',
        'cancelled': 'secondary',
        'on_hold': 'info'
    };
    return colors[status] || 'primary';
}

function setupEventListeners() {
    document.getElementById('prevMonth').addEventListener('click', () => {
        calendar.prev();
        loadCalendarData();
    });
    
    document.getElementById('nextMonth').addEventListener('click', () => {
        calendar.next();
        loadCalendarData();
    });
    
    document.getElementById('todayBtn').addEventListener('click', () => {
        calendar.today();
        loadCalendarData();
    });
    
    document.getElementById('applyFilters').addEventListener('click', applyFilters);
    document.getElementById('resetFilters').addEventListener('click', resetFilters);
}

function applyFilters() {
    currentFilters = {
        department_id: document.getElementById('departmentFilter').value,
        leave_type_id: document.getElementById('leaveTypeFilter').value,
        user_id: document.getElementById('userFilter').value,
        status: document.getElementById('statusFilter').value
    };
    
    loadCalendarData();
    bootstrap.Modal.getInstance(document.getElementById('filtersModal')).hide();
}

function resetFilters() {
    document.getElementById('filterForm').reset();
    currentFilters = {
        department_id: '',
        leave_type_id: '',
        user_id: '',
        status: ''
    };
    loadCalendarData();
}

function updateCalendarHeader(date) {
    const header = document.querySelector('.card-header h5');
    header.innerHTML = `
        <i class="fas fa-calendar me-2"></i>
        Calendar View - ${new Date(date).toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}
    `;
}

function approveLeave(leaveId) {
    if (confirm('Are you sure you want to approve this leave?')) {
        fetch(`/leave/${leaveId}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('leaveDetailsModal')).hide();
                loadCalendarData();
                location.reload();
            }
        });
    }
}

function rejectLeave(leaveId) {
    const reason = prompt('Please enter rejection reason:');
    if (reason) {
        fetch(`/leave/${leaveId}/reject`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ rejection_reason: reason })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('leaveDetailsModal')).hide();
                loadCalendarData();
                location.reload();
            }
        });
    }
}

function cancelLeave(leaveId) {
    if (confirm('Are you sure you want to cancel this leave?')) {
        fetch(`/leave/${leaveId}/cancel`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('leaveDetailsModal')).hide();
                loadCalendarData();
                location.reload();
            }
        });
    }
}
</script>
@endpush
