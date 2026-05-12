@extends('admin.admin_master')

@section('page-title', 'Leave Calendar')

@section('admin')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="page-title mb-1">
                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                        Leave Calendar
                    </h4>
                    <p class="text-muted mb-0">Interactive calendar view of all leaves</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('leave.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Leave Management
                    </a>
                    <a href="{{ route('leave.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>New Leave Request
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="fs-2 fw-bold">{{ $leaves->where('status', 'approved')->count() }}</div>
                                <div class="small">Approved This Month</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="fs-2 fw-bold">{{ $leaves->where('status', 'pending')->count() }}</div>
                                <div class="small">Pending Approval</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="fs-2 fw-bold">{{ $leaves->sum('total_days') }}</div>
                                <div class="small">Total Days This Month</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="fs-2 fw-bold">{{ $leaves->unique('user_id')->count() }}</div>
                                <div class="small">Employees on Leave</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar View -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-calendar me-2"></i>
                        Calendar View - {{ date('F Y') }}
                    </h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-light btn-sm" onclick="previousMonth()">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-light btn-sm" onclick="currentMonth()">
                            Today
                        </button>
                        <button type="button" class="btn btn-light btn-sm" onclick="nextMonth()">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered calendar-table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Sun</th>
                                    <th class="text-center">Mon</th>
                                    <th class="text-center">Tue</th>
                                    <th class="text-center">Wed</th>
                                    <th class="text-center">Thu</th>
                                    <th class="text-center">Fri</th>
                                    <th class="text-center">Sat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $currentMonth = date('n');
                                    $currentYear = date('Y');
                                    $daysInMonth = date('t');
                                    $firstDayOfWeek = date('w', strtotime(date('Y-m-01')));
                                    
                                    $dayCounter = 1;
                                    for ($week = 0; $week < 6; $week++) {
                                        echo '<tr>';
                                        for ($weekDay = 0; $weekDay < 7; $weekDay++) {
                                            if ($week == 0 && $weekDay < $firstDayOfWeek) {
                                                echo '<td class="calendar-empty">&nbsp;</td>';
                                            } elseif ($dayCounter > $daysInMonth) {
                                                echo '<td class="calendar-empty">&nbsp;</td>';
                                            } else {
                                                $dateString = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $dayCounter);
                                                $dayLeaves = $leaves->filter(function($leave) use ($dateString) {
                                                    $startDate = \Carbon\Carbon::parse($leave->start_date)->format('Y-m-d');
                                                    $endDate = \Carbon\Carbon::parse($leave->end_date)->format('Y-m-d');
                                                    return $dateString >= $startDate && $dateString <= $endDate;
                                                });
                                                
                                                $isToday = ($dateString == date('Y-m-d'));
                                                $cellClass = $isToday ? 'calendar-today' : '';
                                                
                                                echo '<td class="calendar-day ' . $cellClass . '">';
                                                echo '<div class="calendar-day-number">' . $dayCounter . '</div>';
                                                
                                                if ($dayLeaves->count() > 0) {
                                                    echo '<div class="calendar-leaves">';
                                                    foreach ($dayLeaves as $leave) {
                                                        $statusColor = $leave->status == 'approved' ? 'success' : ($leave->status == 'pending' ? 'warning' : 'danger');
                                                        echo '<div class="calendar-leave-item bg-' . $statusColor . '" title="' . $leave->user->name . ' - ' . $leave->leave_type->name . '">';
                                                        echo '<i class="fas fa-user"></i> ' . substr($leave->user->name, 0, 8);
                                                        echo '</div>';
                                                    }
                                                    echo '</div>';
                                                }
                                                
                                                echo '</td>';
                                                $dayCounter++;
                                            }
                                        }
                                        echo '</tr>';
                                        if ($dayCounter > $daysInMonth) {
                                            break;
                                        }
                                    }
                                @endphp
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave List -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-list me-2"></i>
                        Leave Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee</th>
                                    <th>Leave Type</th>
                                    <th>Duration</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($leaves->count() > 0)
                                    @foreach($leaves as $leave)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                                <div>{{ $leave->user->name }} {{ $leave->user->last_name ?? '' }}</div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-info">{{ $leave->leave_type->name }}</span></td>
                                        <td>{{ $leave->total_days }} day(s)</td>
                                        <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $leave->status == 'approved' ? 'success' : ($leave->status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($leave->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-calendar-times fs-1 mb-2"></i>
                                            <p>No leaves found for this period</p>
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
</div>

@endsection

@push('styles')
<style>
.calendar-table {
    font-size: 14px;
}

.calendar-day {
    width: 14.28%;
    height: 80px;
    vertical-align: top;
    border: 1px solid #dee2e6;
    position: relative;
    padding: 5px;
}

.calendar-empty {
    background: #f8f9fa;
}

.calendar-today {
    background: #e3f2fd !important;
}

.calendar-day-number {
    font-weight: bold;
    margin-bottom: 5px;
    color: #495057;
}

.calendar-leaves {
    position: absolute;
    top: 25px;
    left: 5px;
    right: 5px;
    z-index: 10;
}

.calendar-leave-item {
    font-size: 10px;
    padding: 2px 4px;
    margin: 1px 0;
    border-radius: 3px;
    cursor: pointer;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.calendar-leave-item.bg-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.calendar-leave-item.bg-warning {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.calendar-leave-item.bg-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.badge {
    font-size: 0.75rem;
}

@media (max-width: 768px) {
    .calendar-day {
        height: 60px;
        font-size: 12px;
    }
    
    .calendar-leave-item {
        font-size: 9px;
        padding: 1px 2px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function previousMonth() {
    const currentUrl = new URL(window.location.href);
    const currentMonth = parseInt(currentUrl.searchParams.get('month') || new Date().getMonth() + 1);
    const currentYear = parseInt(currentUrl.searchParams.get('year') || new Date().getFullYear());
    
    let newMonth = currentMonth - 1;
    let newYear = currentYear;
    
    if (newMonth < 1) {
        newMonth = 12;
        newYear--;
    }
    
    window.location.href = `/leave/calendar?month=${newMonth}&year=${newYear}`;
}

function currentMonth() {
    window.location.href = '/leave/calendar';
}

function nextMonth() {
    const currentUrl = new URL(window.location.href);
    const currentMonth = parseInt(currentUrl.searchParams.get('month') || new Date().getMonth() + 1);
    const currentYear = parseInt(currentUrl.searchParams.get('year') || new Date().getFullYear());
    
    let newMonth = currentMonth + 1;
    let newYear = currentYear;
    
    if (newMonth > 12) {
        newMonth = 1;
        newYear++;
    }
    
    window.location.href = `/leave/calendar?month=${newMonth}&year=${newYear}`;
}
</script>
@endpush
