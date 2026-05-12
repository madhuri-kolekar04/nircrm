@extends('admin.admin_master')

@section('page-title', 'Create Leave Request')

@section('admin')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="page-title mb-1">Create Leave Request</h4>
                    <p class="text-muted mb-0">Submit a new leave request for approval</p>
                </div>
                <div>
                    <a href="{{ route('leave.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Back to Leave Management
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information & Approval Hierarchy -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-user me-2"></i>Your Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-user text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-semibold">{{ $user->name }} {{ $user->last_name ?? '' }}</h5>
                            <p class="text-muted mb-0">{{ $user->designation ?? 'Employee' }}</p>
                            <p class="text-muted mb-0">{{ $user->department->name ?? 'No Department' }}</p>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <div class="fw-bold text-primary">{{ $user->employee_id ?? 'N/A' }}</div>
                                <small class="text-muted">Employee ID</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-success">{{ \Carbon\Carbon::parse($user->joining_date ?? now())->diffInYears(now()) }} Years</div>
                            <small class="text-muted">Service Period</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-sitemap me-2"></i>Approval Hierarchy
                    </h6>
                </div>
                <div class="card-body">
                    <div class="approval-flow">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                <i class="fas fa-user text-success"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">You</div>
                                <small class="text-muted">{{ $user->name }} ({{ $user->role_name ?? 'Employee' }})</small>
                            </div>
                            <i class="fas fa-arrow-down text-muted"></i>
                        </div>
                        
                        @php
                            // Determine next approver based on user role
                            $nextApproverName = 'Not Assigned';
                            $nextApproverTitle = 'Manager';
                            
                            if ($user->role == 3) { // Employee
                                $manager = \App\Models\User::where('role', 4)->where('department_id', $user->department_id)->first();
                                if ($manager) {
                                    $nextApproverName = $manager->name;
                                    $nextApproverTitle = $manager->designation ?? 'Manager';
                                }
                            } elseif ($user->role == 4) { // Manager
                                $gm = \App\Models\User::where('role', 5)->first();
                                if ($gm) {
                                    $nextApproverName = $gm->name;
                                    $nextApproverTitle = $gm->designation ?? 'General Manager';
                                }
                            } elseif ($user->role == 5) { // General Manager
                                $admin = \App\Models\User::where('role', 1)->first();
                                if ($admin) {
                                    $nextApproverName = $admin->name;
                                    $nextApproverTitle = $admin->designation ?? 'Admin';
                                }
                            }
                        @endphp
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-3">
                                <i class="fas fa-user-tie text-warning"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $nextApproverName }}</div>
                                <small class="text-muted">{{ $nextApproverTitle }}</small>
                            </div>
                            @if($user->role != 1)
                                <i class="fas fa-arrow-down text-muted"></i>
                            @endif
                        </div>
                        
                        @if($user->role == 3 || $user->role == 4)
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-opacity-10 p-2 me-3">
                                <i class="fas fa-user-shield text-info"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">
                                    @if($user->role == 3)
                                        @php $gm = \App\Models\User::where('role', 5)->first(); @endphp
                                        {{ $gm->name ?? 'Not Assigned' }}
                                    @else
                                        @php $admin = \App\Models\User::where('role', 1)->first(); @endphp
                                        {{ $admin->name ?? 'Not Assigned' }}
                                    @endif
                                </div>
                                <small class="text-muted">
                                    @if($user->role == 3)
                                        General Manager
                                    @else
                                        Admin
                                    @endif
                                </small>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Approval Process:</strong> Your leave request will be sent to {{ $nextApproverName }} for approval.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Balance Cards -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Your Leave Balance</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($leaveTypes as $type)
                            @php
                                $balance = $leaveBalances[$type->id] ?? [
                                    'total_days' => $type->days_per_year,
                                    'used_days' => 0,
                                    'pending_days' => 0,
                                    'available_days' => $type->days_per_year,
                                    'remaining_after_pending' => $type->days_per_year,
                                    'usage_percentage' => 0
                                ];
                            @endphp
                            <div class="col-md-3 mb-3">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{ $type->name }}</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $balance['available_days'] }} days</div>
                                                <div class="text-xs text-gray-500">Available of {{ $balance['total_days'] }} total</div>
                                                
                                                <!-- Progress bar for usage -->
                                                @if($balance['total_days'] > 0)
                                                    @php
                                                        $progressColor = 'bg-success';
                                                        if ($balance['usage_percentage'] > 80) {
                                                            $progressColor = 'bg-danger';
                                                        } elseif ($balance['usage_percentage'] > 60) {
                                                            $progressColor = 'bg-warning';
                                                        }
                                                    @endphp
                                                    <div class="progress mt-2" style="height: 6px;">
                                                        <div class="progress-bar {{ $progressColor }}" role="progressbar" 
                                                             style="width: {{ $balance['usage_percentage'] }}%"
                                                             aria-valuenow="{{ $balance['usage_percentage'] }}" 
                                                             aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        Used: {{ $balance['used_days'] }} days
                                                        @if($balance['pending_days'] > 0)
                                                            <span class="text-warning">| Pending: {{ $balance['pending_days'] }} days</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Request Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Leave Request Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('leave.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="leave_type_id" class="form-label">Leave Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="leave_type_id" name="leave_type_id" required>
                                    <option value="">Select Leave Type</option>
                                    @foreach($leaveTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->days_per_year }} days/year)</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Leave Duration <span class="text-danger">*</span></label>
                                <div class="mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="leave_duration" id="full_day_leave" value="full_day" checked>
                                        <label class="form-check-label" for="full_day_leave">
                                            Full Day Leave
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="leave_duration" id="half_day_leave" value="half_day">
                                        <label class="form-check-label" for="half_day_leave">
                                            Half Day Leave
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="fullDateInputs">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>

                        <div class="row" id="halfDateInputs" style="display: none;">
                            <div class="col-md-6 mb-3">
                                <label for="half_day_date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="half_day_date" name="half_day_date" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="half_day_type" class="form-label">Half Day Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="half_day_type" name="half_day_type">
                                    <option value="first_half">First Half</option>
                                    <option value="second_half">Second Half</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="reason" name="reason" rows="4" required 
                                      placeholder="Please provide a detailed reason for your leave request..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="emergency_contact" class="form-label">Emergency Contact (Optional)</label>
                            <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" 
                                   placeholder="Phone number or email for emergency contact">
                        </div>

                        <div class="mb-3">
                            <label for="attachments" class="form-label">Attachments (Optional)</label>
                            <input type="file" class="form-control" id="attachments" name="attachments[]" multiple 
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="text-muted">Upload supporting documents (PDF, DOC, DOCX, JPG, PNG - Max 2MB each)</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('leave.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Submit Leave Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Important Notes</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-info-circle text-info"></i>
                            <strong>Advance Notice:</strong> Please submit leave requests at least 3 days in advance.
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-check text-success"></i>
                            <strong>Approval Process:</strong> Your request will be reviewed by your manager or department head.
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-clock text-warning"></i>
                            <strong>Processing Time:</strong> Leave requests are typically processed within 24-48 hours.
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-file-alt text-primary"></i>
                            <strong>Documentation:</strong> For medical leave, please attach relevant medical certificates.
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope text-secondary"></i>
                            <strong>Notifications:</strong> You will receive email notifications about the status of your request.
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Leave Policy</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>Annual Leave:</strong> {{ $leaveTypes->where('name', 'Annual Leave')->first()->days_per_year ?? 'N/A' }} days per year
                        </li>
                        <li class="mb-2">
                            <strong>Sick Leave:</strong> {{ $leaveTypes->where('name', 'Sick Leave')->first()->days_per_year ?? 'N/A' }} days per year
                        </li>
                        <li class="mb-2">
                            <strong>Personal Leave:</strong> {{ $leaveTypes->where('name', 'Personal Leave')->first()->days_per_year ?? 'N/A' }} days per year
                        </li>
                        <li class="mb-2">
                            <strong>Carry Forward:</strong> Unused leave can be carried forward subject to management approval.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    
    .progress-bar.bg-success {
        background-color: #28a745 !important;
    }
    
    .progress-bar.bg-warning {
        background-color: #ffc107 !important;
    }
    
    .progress-bar.bg-danger {
        background-color: #dc3545 !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Set minimum date to today
    var today = new Date().toISOString().split('T')[0];
    $('#start_date, #end_date, #half_day_date').attr('min', today);
    
    // Handle radio button toggle
    $('input[name="leave_duration"]').change(function() {
        var selectedValue = $('input[name="leave_duration"]:checked').val();
        
        if (selectedValue === 'full_day') {
            $('#fullDateInputs').show();
            $('#halfDateInputs').hide();
            $('#start_date, #end_date').attr('required', 'required');
            $('#half_day_date').removeAttr('required');
        } else if (selectedValue === 'half_day') {
            $('#fullDateInputs').hide();
            $('#halfDateInputs').show();
            $('#start_date, #end_date').removeAttr('required');
            $('#half_day_date').attr('required', 'required');
        }
    });
    
    // Initialize with full day selected
    $('#fullDateInputs').show();
    $('#halfDateInputs').hide();
    $('#start_date, #end_date').attr('required', 'required');
    $('#half_day_date').removeAttr('required');
    
    // Auto-calculate end date for half day
    $('#half_day_date').change(function() {
        $('#end_date').val($(this).val());
    });
    
    // Validate date range
    $('#start_date, #end_date').change(function() {
        var startDate = new Date($('#start_date').val());
        var endDate = new Date($('#end_date').val());
        
        if (startDate && endDate && startDate > endDate) {
            alert('End date must be after or equal to start date');
            $('#end_date').val($('#start_date').val());
        }
    });
    
    // Form validation
    $('form').submit(function(e) {
        var isValid = true;
        
        // Check if leave type is selected
        if (!$('#leave_type_id').val()) {
            alert('Please select a leave type');
            return false;
        }
        
        // Check if leave duration is selected
        var selectedDuration = $('input[name="leave_duration"]:checked').val();
        if (!selectedDuration) {
            alert('Please select either Full Day Leave or Half Day Leave');
            return false;
        }
        
        // Check if dates are selected based on radio button
        if (selectedDuration === 'full_day') {
            if (!$('#start_date').val() || !$('#end_date').val()) {
                alert('Please select both start and end dates for full day leave');
                return false;
            }
            
            // Validate date range for full-day leave
            var startDate = new Date($('#start_date').val());
            var endDate = new Date($('#end_date').val());
            
            if (startDate > endDate) {
                alert('End date must be after or equal to start date');
                return false;
            }
        }
        
        if (selectedDuration === 'half_day') {
            if (!$('#half_day_date').val()) {
                alert('Please select date for half day leave');
                return false;
            }
        }
        
        // Check reason length
        if ($('#reason').val().length < 10) {
            alert('Please provide a detailed reason (minimum 10 characters)');
            return false;
        }
        
        return true; // Allow submission if all validations pass
    });
});
</script>
@endpush
