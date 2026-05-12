@extends('admin.admin_master')

@section('page-title', 'Request Leave')

@section('content')
<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Request Leave</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('leave.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="{{ route('leave.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-list"></i> All Leaves
                </a>
            </div>
        </div>

        <!-- Leave Request Form -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-plus"></i> New Leave Request
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('leave.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="leave_type_id" class="form-label">Leave Type *</label>
                                        <select name="leave_type_id" id="leave_type_id" class="form-select" required>
                                            <option value="">Select Leave Type</option>
                                            @foreach($leaveTypes as $type)
                                                <option value="{{ $type->id }}" 
                                                        data-max-days="{{ $type->max_days_per_year ?? 0 }}"
                                                        data-requires-approval="{{ $type->requires_approval ? 'true' : 'false' }}">
                                                    {{ $type->name }}
                                                    @if($type->max_days_per_year)
                                                        (Max: {{ $type->max_days_per_year }} days/year)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="duration_type" class="form-label">Duration Type</label>
                                        <select name="duration_type" id="duration_type" class="form-select">
                                            <option value="full_day">Full Day</option>
                                            <option value="half_day">Half Day</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="dateFields">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date *</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" 
                                               required min="{{ now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date *</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" 
                                               required min="{{ now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="halfDayFields" style="display: none;">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="leave_date" class="form-label">Leave Date *</label>
                                        <input type="date" name="leave_date" id="leave_date" class="form-control" 
                                               min="{{ now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="half_day_type" class="form-label">Half Day Type *</label>
                                        <select name="half_day_type" id="half_day_type" class="form-select">
                                            <option value="first_half">First Half</option>
                                            <option value="second_half">Second Half</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason *</label>
                                <textarea name="reason" id="reason" class="form-control" rows="4" 
                                          placeholder="Please provide a reason for your leave request..." required></textarea>
                                <small class="text-muted">Minimum 10 characters</small>
                            </div>

                            <div class="mb-3">
                                <label for="emergency_contact" class="form-label">Emergency Contact (Optional)</label>
                                <input type="text" name="emergency_contact" id="emergency_contact" class="form-control" 
                                       placeholder="Phone number or email for emergency contact">
                            </div>

                            <div class="mb-3">
                                <label for="attachments" class="form-label">Attachments (Optional)</label>
                                <input type="file" name="attachments[]" id="attachments" class="form-control" 
                                       multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <small class="text-muted">
                                    Supported formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max 2MB each)
                                </small>
                            </div>

                            <div class="alert alert-info" id="leaveBalanceInfo" style="display: none;">
                                <i class="fas fa-info-circle"></i>
                                <span id="balanceText"></span>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Submit Request
                                </button>
                                <a href="{{ route('leave.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Leave Balance Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-balance-scale"></i> Your Leave Balance
                        </h6>
                    </div>
                    <div class="card-body">
                        <div id="leaveBalanceDisplay">
                            <div class="text-center text-muted">
                                <i class="fas fa-spinner fa-spin"></i>
                                <p class="mb-0 mt-2">Loading leave balance...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leave Policy Card -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-book"></i> Leave Policy
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Submit requests at least 2 days in advance
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Attach medical documents for sick leave (3+ days)
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Half-day requests must be submitted before 10 AM
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Emergency leave will require immediate notification
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-info text-info me-2"></i>
                                All leave requests are subject to manager approval
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadLeaveBalance();
    
    // Handle duration type change
    document.getElementById('duration_type').addEventListener('change', function() {
        const isHalfDay = this.value === 'half_day';
        document.getElementById('dateFields').style.display = isHalfDay ? 'none' : 'block';
        document.getElementById('halfDayFields').style.display = isHalfDay ? 'block' : 'none';
        
        if (isHalfDay) {
            // Clear full day dates
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
        } else {
            // Clear half day fields
            document.getElementById('leave_date').value = '';
        }
    });
    
    // Handle leave type change
    document.getElementById('leave_type_id').addEventListener('change', function() {
        updateLeaveBalanceInfo();
    });
    
    // Handle date changes
    document.getElementById('start_date').addEventListener('change', function() {
        updateEndDateMin();
        calculateDays();
    });
    
    document.getElementById('end_date').addEventListener('change', calculateDays);
    document.getElementById('leave_date').addEventListener('change', calculateDays);
    
    // Set default end date minimum
    updateEndDateMin();
});

function loadLeaveBalance() {
    fetch('/api/leave-balance')
        .then(response => response.json())
        .then(data => {
            displayLeaveBalance(data);
        })
        .catch(error => {
            console.error('Error loading leave balance:', error);
            document.getElementById('leaveBalanceDisplay').innerHTML = 
                '<div class="text-center text-muted"><p class="mb-0">Unable to load leave balance</p></div>';
        });
}

function displayLeaveBalance(balances) {
    let html = '';
    
    if (balances && balances.length > 0) {
        balances.forEach(balance => {
            const percentage = balance.allocated > 0 
                ? Math.round((balance.used / balance.allocated) * 100) 
                : 0;
            const progressColor = percentage >= 80 ? 'danger' : 
                               (percentage >= 60 ? 'warning' : 'success');
            
            html += `
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="fw-bold">${balance.type.name}</small>
                        <small class="text-muted">${balance.used}/${balance.allocated}</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-${progressColor}" style="width: ${percentage}%"></div>
                    </div>
                </div>
            `;
        });
    } else {
        html = '<div class="text-center text-muted"><p class="mb-0">No leave balance available</p></div>';
    }
    
    document.getElementById('leaveBalanceDisplay').innerHTML = html;
}

function updateEndDateMin() {
    const startDate = document.getElementById('start_date').value;
    const endDateInput = document.getElementById('end_date');
    
    if (startDate) {
        endDateInput.min = startDate;
        if (endDateInput.value && endDateInput.value < startDate) {
            endDateInput.value = startDate;
        }
    }
}

function calculateDays() {
    const durationType = document.getElementById('duration_type').value;
    let days = 0;
    
    if (durationType === 'full_day') {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        
        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            days = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
        }
    } else {
        days = 0.5;
    }
    
    updateLeaveBalanceInfo(days);
}

function updateLeaveBalanceInfo(days = null) {
    const leaveTypeSelect = document.getElementById('leave_type_id');
    const selectedOption = leaveTypeSelect.options[leaveTypeSelect.selectedIndex];
    const maxDays = selectedOption ? parseInt(selectedOption.dataset.maxDays) || 0 : 0;
    const requiresApproval = selectedOption ? selectedOption.dataset.requiresApproval === 'true' : true;
    
    const infoDiv = document.getElementById('leaveBalanceInfo');
    const balanceText = document.getElementById('balanceText');
    
    if (maxDays > 0) {
        let message = `Maximum ${maxDays} days allowed per year for this leave type.`;
        
        if (days !== null) {
            message += ` You are requesting ${days} day(s).`;
            
            if (days > maxDays) {
                message = `⚠️ ${message} This exceeds your annual limit!`;
                infoDiv.className = 'alert alert-warning';
            } else {
                infoDiv.className = 'alert alert-info';
            }
        }
        
        balanceText.textContent = message;
        infoDiv.style.display = 'block';
    } else {
        infoDiv.style.display = 'none';
    }
}

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const durationType = document.getElementById('duration_type').value;
    const reason = document.getElementById('reason').value;
    
    // Validate reason length
    if (reason.length < 10) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Reason must be at least 10 characters long.'
        });
        return;
    }
    
    // Validate dates based on duration type
    if (durationType === 'full_day') {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        
        if (!startDate || !endDate) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please select both start and end dates.'
            });
            return;
        }
        
        if (new Date(endDate) < new Date(startDate)) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'End date cannot be before start date.'
            });
            return;
        }
    } else {
        const leaveDate = document.getElementById('leave_date').value;
        const halfDayType = document.getElementById('half_day_type').value;
        
        if (!leaveDate) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please select a leave date for half-day request.'
            });
            return;
        }
    }
});
</script>
@endpush
