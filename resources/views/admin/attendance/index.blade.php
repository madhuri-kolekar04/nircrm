@extends('admin.admin_master')

@section('page-title', 'Attendance Records')

@section('content')
<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Attendance Records</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('attendance.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                @if(auth()->user()->canApproveLeave())
                    <a href="{{ route('attendance.reports') }}" class="btn btn-outline-success">
                        <i class="fas fa-chart-bar"></i> Reports
                    </a>
                @endif
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-filter"></i> Filters
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('attendance.index') }}">
                    <div class="row">
                        @if(auth()->user()->canApproveLeave())
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
                        @endif
                        <div class="col-md-3">
                            <label for="date_from" class="form-label">From Date</label>
                            <input type="date" name="date_from" id="date_from" class="form-control" 
                                   value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="date_to" class="form-label">To Date</label>
                            <input type="date" name="date_to" id="date_to" class="form-control" 
                                   value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                                <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                                <option value="half_day" {{ request('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
                                <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                <option value="holiday" {{ request('status') == 'holiday' ? 'selected' : '' }}>Holiday</option>
                                <option value="weekend" {{ request('status') == 'weekend' ? 'selected' : '' }}>Weekend</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Apply Filters
                            </button>
                            <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list"></i> Attendance Records
                </h5>
                <div>
                    <span class="badge bg-info">Total: {{ $attendances->total() }}</span>
                </div>
            </div>
            <div class="card-body">
                @if($attendances->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    @if(auth()->user()->canApproveLeave())
                                        <th>Employee</th>
                                    @endif
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Working Hours</th>
                                    <th>Overtime</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                    <tr>
                                        @if(auth()->user()->canApproveLeave())
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 12px;">
                                                        {{ substr($attendance->user->full_name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $attendance->user->full_name }}</div>
                                                        <small class="text-muted">{{ $attendance->user->employee_id ?? 'N/A' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                        <td>{{ $attendance->date->format('M d, Y') }}</td>
                                        <td>{{ $attendance->date->format('l') }}</td>
                                        <td>
                                            {{ $attendance->check_in_time ?? '---' }}
                                            @if($attendance->is_late)
                                                <span class="badge bg-warning ms-1">Late</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $attendance->check_out_time ?? '---' }}
                                            @if($attendance->is_early_checkout)
                                                <span class="badge bg-warning ms-1">Early</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $attendance->working_hours ? $attendance->working_hours . 'h' : '---' }}
                                        </td>
                                        <td>
                                            {{ $attendance->overtime_hours ? $attendance->overtime_hours . 'h' : '---' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $attendance->status_color }}">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $attendance->notes ?? '---' }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" onclick="viewDetails({{ $attendance->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if(auth()->user()->canApproveLeave())
                                                    <button class="btn btn-outline-secondary" onclick="editAttendance({{ $attendance->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Showing {{ $attendances->firstItem() }} to {{ $attendances->lastItem() }} of {{ $attendances->total() }} entries
                        </div>
                        {{ $attendances->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5>No attendance records found</h5>
                        <p class="text-muted">Try adjusting your filters or check back later.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Attendance Details Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="attendanceDetails">
                <!-- Details will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function viewDetails(attendanceId) {
    // For now, just show a simple alert. In a real app, you'd fetch details via AJAX
    Swal.fire({
        icon: 'info',
        title: 'Attendance Details',
        text: 'Detailed view functionality would be implemented here.',
        confirmButtonText: 'OK'
    });
}

function editAttendance(attendanceId) {
    // For now, just show a simple alert. In a real app, you'd open an edit modal
    Swal.fire({
        icon: 'info',
        title: 'Edit Attendance',
        text: 'Edit functionality would be implemented here.',
        confirmButtonText: 'OK'
    });
}

// Initialize date range picker
document.addEventListener('DOMContentLoaded', function() {
    // Set default date range to current month
    const dateFrom = document.getElementById('date_from');
    const dateTo = document.getElementById('date_to');
    
    if (!dateFrom.value && !dateTo.value) {
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        
        dateFrom.value = firstDay.toISOString().split('T')[0];
        dateTo.value = today.toISOString().split('T')[0];
    }
});

// Auto-submit form on filter change (optional)
document.querySelectorAll('#user_id, #status').forEach(element => {
    element.addEventListener('change', function() {
        this.form.submit();
    });
});
</script>
@endpush
