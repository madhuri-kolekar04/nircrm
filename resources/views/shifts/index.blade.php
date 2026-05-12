@extends('admin.admin_master')

@section('page-title', 'Shift Management')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-clock"></i> Shift Management
                        <a href="{{ route('shifts.create') }}" class="btn btn-sm btn-success float-right">
                            <i class="fas fa-plus"></i> Add New Shift
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Shift Creation Settings Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-cog"></i> Quick Shift Creation</h5>
                                </div>
                                <div class="card-body">
                                    <form id="quickShiftForm" class="row g-3">
                                        @csrf
                                        <div class="col-md-3">
                                            <label for="shift_name" class="form-label">Shift Name</label>
                                            <input type="text" class="form-control" id="shift_name" name="name" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="start_time" class="form-label">Start Time</label>
                                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="end_time" class="form-label">End Time</label>
                                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="grace_period" class="form-label">Grace Period (min)</label>
                                            <input type="number" class="form-control" id="grace_period" name="grace_period_minutes" value="15" min="0" max="60" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="shift_description" class="form-label">Description</label>
                                            <input type="text" class="form-control" id="shift_description" name="description" placeholder="Optional description">
                                        </div>
                                        <div class="col-md-1">
                                            <label class="form-label">&nbsp;</label>
                                            <div>
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-save"></i> Create
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Shifts Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Shift Name</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Grace Period</th>
                                    <th>Duration</th>
                                    <th>Assigned Users</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shifts as $shift)
                                    <tr>
                                        <td>
                                            <strong>{{ $shift->name }}</strong>
                                            @if($shift->description)
                                                <br><small class="text-muted">{{ $shift->description }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $shift->start_time->format('H:i') }}</td>
                                        <td>{{ $shift->end_time->format('H:i') }}</td>
                                        <td>{{ $shift->grace_period_minutes }} minutes</td>
                                        <td>{{ $shift->getShiftDurationHours() }} hours</td>
                                        <td>
                                            <span class="badge badge-info">{{ $shift->users->count() }}</span>
                                            @if($shift->users->count() > 0)
                                                <br><small class="text-muted">Click to view users</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $shift->is_active ? 'success' : 'danger' }}">
                                                {{ $shift->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('shifts.edit', $shift) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($shift->users->count() == 0)
                                                    <form action="{{ route('shifts.destroy', $shift) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this shift?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- User Assignment Section -->
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-users"></i> User Shift Assignment</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Position</th>
                                            <th>Current Shift</th>
                                            <th>Assign Shift</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userTableBody">
                                        @php
                                            $users = \App\Models\User::where('role', '!=', 3)
                                                ->where('is_active', true)
                                                ->with(['department', 'shift'])
                                                ->get();
                                        @endphp
                                        @foreach($users as $user)
                                            <tr data-user-id="{{ $user->id }}">
                                                <td>{{ $user->employee_id ?? 'N/A' }}</td>
                                                <td>
                                                    <strong>{{ $user->name }} {{ $user->last_name ?? '' }}</strong>
                                                    <br><small class="text-muted">{{ $user->email }}</small>
                                                </td>
                                                <td>{{ $user->department->name ?? 'N/A' }}</td>
                                                <td>{{ $user->position ?? 'N/A' }}</td>
                                                <td>
                                                    @if($user->shift)
                                                        <span class="badge badge-primary">{{ $user->shift->name }}</span>
                                                        <br><small class="text-muted">
                                                            {{ $user->shift->start_time->format('H:i') }} - {{ $user->shift->end_time->format('H:i') }}
                                                        </small>
                                                    @else
                                                        <span class="badge badge-secondary">No Shift</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <select class="form-control form-control-sm shift-select" data-user-id="{{ $user->id }}" onchange="updateHiddenInput({{ $user->id }}, this.value)">
                                                        <option value="">Select Shift</option>
                                                        @foreach($shifts as $shift)
                                                            <option value="{{ $shift->id }}" {{ $user->shift_id == $shift->id ? 'selected' : '' }}>
                                                                {{ $shift->name }} ({{ $shift->start_time->format('H:i') }} - {{ $shift->end_time->format('H:i') }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <form action="{{ route('shifts.assign') }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                        <input type="hidden" name="shift_id" id="shift-hidden-{{ $user->id }}" value="{{ $user->shift_id ?? '' }}">
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return validateShift({{ $user->id }})">
                                                            <i class="fas fa-check"></i> Assign
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('shifts.assign') }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                        <input type="hidden" name="shift_id" id="shift-hidden-{{ $user->id }}-2" value="{{ $user->shift_id ?? '' }}">
                                                        <button type="submit" class="btn btn-sm btn-primary ms-1" onclick="return validateShift({{ $user->id }})">
                                                            <i class="fas fa-user-plus"></i> Appoint
                                                        </button>
                                                    </form>
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
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Quick shift creation
    $('#quickShiftForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("shifts.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error creating shift: ' + xhr.responseJSON.message || 'Unknown error');
            }
        });
    });
});

// Function to update hidden inputs when dropdown changes
function updateHiddenInput(userId, shiftId) {
    console.log('Updating hidden input for user ' + userId + ' to shift ' + shiftId);
    $('#shift-hidden-' + userId).val(shiftId);
    $('#shift-hidden-' + userId + '-2').val(shiftId);
}

// Validation function for shift assignment
function validateShift(userId) {
    var shiftId = $('#shift-hidden-' + userId).val();
    
    console.log('Validating shift for user ' + userId + ': ' + shiftId);
    
    if (!shiftId) {
        alert('Please select a shift first!');
        return false;
    }
    
    return true;
}
</script>
@endsection
