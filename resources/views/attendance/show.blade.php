@extends('admin.admin_master')

@section('page-title', 'Attendance Details')

@section('admin')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="page-title mb-1">Attendance Details</h4>
                    <p class="text-muted mb-0">Detailed view of attendance record</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('attendance.dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                    <a href="{{ route('attendance.report') }}" class="btn btn-outline-info">
                        <i class="fas fa-chart-bar"></i> View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Details Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-user-clock me-2"></i>Attendance Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Employee Name</label>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px; font-size: 18px;">
                                    {{ strtoupper(substr($attendance->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold fs-5">{{ $attendance->user->name }}</div>
                                    <small class="text-muted">{{ $attendance->user->getRoleNameAttribute() }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Department</label>
                            <div class="fw-bold">
                                @if($attendance->user->department)
                                    @if(is_object($attendance->user->department))
                                        <span class="badge bg-info fs-6">{{ $attendance->user->department->name }}</span>
                                    @else
                                        <span class="badge bg-info fs-6">{{ $attendance->user->department }}</span>
                                    @endif
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Date</label>
                            <div class="fw-bold fs-5">{{ $attendance->date->format('d F Y') }}</div>
                            <small class="text-muted">{{ $attendance->date->format('l') }}</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Employee ID</label>
                            <div class="fw-bold">{{ $attendance->user->employeeID ?? 'N/A' }}</div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="attendance-stat-card">
                                <div class="stat-icon bg-success">
                                    <i class="fas fa-sign-in-alt"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Check In</div>
                                    <div class="stat-value">
                                        @if($attendance->check_in_time)
                                            {{ $attendance->check_in_time->format('h:i A') }}
                                            @if($attendance->is_late)
                                                <span class="badge bg-warning ms-2">Late</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Not Marked</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="attendance-stat-card">
                                <div class="stat-icon bg-warning">
                                    <i class="fas fa-sign-out-alt"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Check Out</div>
                                    <div class="stat-value">
                                        @if($attendance->check_out_time)
                                            {{ $attendance->check_out_time->format('h:i A') }}
                                            @if($attendance->is_early_checkout)
                                                <span class="badge bg-warning ms-2">Early</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Not Marked</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="attendance-stat-card">
                                <div class="stat-icon bg-info">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Working Hours</div>
                                    <div class="stat-value">
                                        @if($attendance->working_hours)
                                            {{ number_format($attendance->working_hours, 2) }}h
                                        @else
                                            <span class="text-muted">0h</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="attendance-stat-card">
                                <div class="stat-icon bg-primary">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Overtime</div>
                                    <div class="stat-value">
                                        @if($attendance->overtime_hours > 0)
                                            <span class="text-success">+{{ number_format($attendance->overtime_hours, 2) }}h</span>
                                        @else
                                            <span class="text-muted">0h</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($attendance->notes)
                        <div class="row mt-4">
                            <div class="col-12">
                                <label class="form-label text-muted">Notes</label>
                                <div class="p-3 bg-light rounded">{{ $attendance->notes }}</div>
                            </div>
                        </div>
                    @endif
                    
                    @if($attendance->location)
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted">Location</label>
                                <div class="fw-bold">
                                    <i class="fas fa-map-marker-alt me-2"></i>{{ $attendance->location }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">IP Address</label>
                                <div class="fw-bold">
                                    <i class="fas fa-network-wired me-2"></i>{{ $attendance->ip_address ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card">
                <div class="card-header bg-gradient text-white" id="statusHeader">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Attendance Status</h6>
                </div>
                <div class="card-body text-center">
                    <div class="status-icon mb-3" id="statusIcon">
                        <i class="fas fa-user-check fa-3x"></i>
                    </div>
                    <h4 class="mb-2" id="statusText">{{ ucfirst($attendance->status) }}</h4>
                    <p class="text-muted" id="statusDescription">
                        @switch($attendance->status)
                            @case('present')
                                Employee was present and worked today
                                @break
                            @case('absent')
                                Employee was absent today
                                @break
                            @case('half_day')
                                Employee worked half day today
                                @break
                            @case('on_leave')
                                Employee was on approved leave
                                @break
                            @case('holiday')
                                Today was a company holiday
                                @break
                            @case('weekend')
                                Today was a weekend
                                @break
                            @default
                                Attendance status not specified
                        @endswitch
                    </p>
                </div>
            </div>
            
            <!-- Quick Actions -->
            @if(Auth::user()->role == 1 || Auth::user()->role == 5)
                <div class="card mt-3">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0"><i class="fas fa-tools me-2"></i>Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary btn-sm w-100 mb-2" data-bs-toggle="modal" data-bs-target="#editAttendanceModal">
                            <i class="fas fa-edit me-2"></i>Edit Attendance
                        </button>
                        <button type="button" class="btn btn-info btn-sm w-100 mb-2" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Print Record
                        </button>
                        <a href="{{ route('attendance.report') }}?user_id={{ $attendance->user_id }}&start_date={{ $attendance->date->format('Y-m-d') }}&end_date={{ $attendance->date->format('Y-m-d') }}" class="btn btn-outline-success btn-sm w-100">
                            <i class="fas fa-chart-bar me-2"></i>View Report
                        </a>
                    </div>
                </div>
            @endif
            
            <!-- Employee Summary -->
            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Employee Summary</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="summary-stat">
                                <div class="summary-number">{{ \App\Models\Attendance::where('user_id', $attendance->user_id)->whereMonth('date', $attendance->date->month)->count() }}</div>
                                <div class="summary-label">Days</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="summary-stat">
                                <div class="summary-number text-success">{{ \App\Models\Attendance::where('user_id', $attendance->user_id)->whereMonth('date', $attendance->date->month)->where('status', 'present')->count() }}</div>
                                <div class="summary-label">Present</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="summary-stat">
                                <div class="summary-number text-danger">{{ \App\Models\Attendance::where('user_id', $attendance->user_id)->whereMonth('date', $attendance->date->month)->where('status', 'absent')->count() }}</div>
                                <div class="summary-label">Absent</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Attendance Modal -->
@if(Auth::user()->role == 1 || Auth::user()->role == 5)
<div class="modal fade" id="editAttendanceModal" tabindex="-1" aria-labelledby="editAttendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editAttendanceModalLabel">Edit Attendance</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('attendance.mark') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{ $attendance->user_id }}">
                    <input type="hidden" name="date" value="{{ $attendance->date->format('Y-m-d') }}">
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="present" {{ $attendance->status === 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ $attendance->status === 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="half_day" {{ $attendance->status === 'half_day' ? 'selected' : '' }}>Half Day</option>
                            <option value="on_leave" {{ $attendance->status === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                            <option value="holiday" {{ $attendance->status === 'holiday' ? 'selected' : '' }}>Holiday</option>
                            <option value="weekend" {{ $attendance->status === 'weekend' ? 'selected' : '' }}>Weekend</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="check_in_time" class="form-label">Check In Time</label>
                            <input type="time" class="form-control" id="check_in_time" name="check_in_time" 
                                   value="{{ $attendance->check_in_time ? $attendance->check_in_time->format('H:i') : '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="check_out_time" class="form-label">Check Out Time</label>
                            <input type="time" class="form-control" id="check_out_time" name="check_out_time" 
                                   value="{{ $attendance->check_out_time ? $attendance->check_out_time->format('H:i') : '' }}">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ $attendance->notes ?? '' }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" value="{{ $attendance->location ?? '' }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<style>
.attendance-stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e3e6f0;
    transition: all 0.3s ease;
}

.attendance-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    margin: 0 auto 1rem;
}

.stat-content {
    text-align: center;
}

.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 1.1rem;
    font-weight: bold;
    color: #2c3e50;
}

.status-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin: 0 auto;
    font-size: 2.5rem;
}

.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.summary-stat {
    padding: 0.5rem;
}

.summary-number {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 0.25rem;
}

.summary-label {
    font-size: 0.75rem;
    color: #6c757d;
    text-transform: uppercase;
}

@media print {
    .no-print {
        display: none !important;
    }
}
</style>

<script>
// Set status colors based on attendance status
$(document).ready(function() {
    var status = '{{ $attendance->status }}';
    var statusHeader = $('#statusHeader');
    var statusIcon = $('#statusIcon');
    
    switch(status) {
        case 'present':
            statusHeader.removeClass().addClass('bg-success text-white');
            statusIcon.html('<i class="fas fa-user-check fa-3x"></i>').removeClass().addClass('bg-success');
            break;
        case 'absent':
            statusHeader.removeClass().addClass('bg-danger text-white');
            statusIcon.html('<i class="fas fa-user-times fa-3x"></i>').removeClass().addClass('bg-danger');
            break;
        case 'half_day':
            statusHeader.removeClass().addClass('bg-warning text-white');
            statusIcon.html('<i class="fas fa-clock fa-3x"></i>').removeClass().addClass('bg-warning');
            break;
        case 'on_leave':
            statusHeader.removeClass().addClass('bg-info text-white');
            statusIcon.html('<i class="fas fa-calendar-times fa-3x"></i>').removeClass().addClass('bg-info');
            break;
        case 'holiday':
            statusHeader.removeClass().addClass('bg-primary text-white');
            statusIcon.html('<i class="fas fa-umbrella-beach fa-3x"></i>').removeClass().addClass('bg-primary');
            break;
        case 'weekend':
            statusHeader.removeClass().addClass('bg-secondary text-white');
            statusIcon.html('<i class="fas fa-home fa-3x"></i>').removeClass().addClass('bg-secondary');
            break;
    }
});
</script>
@endpush
