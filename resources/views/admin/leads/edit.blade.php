@extends('admin.admin_master')

@section('page-title', 'Edit Lead')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Lead - {{ $lead->name }}</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('leads.update', $lead->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-12">
                                <h6 class="mb-3">Basic Information</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $lead->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $lead->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $lead->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                           id="company_name" name="company_name" value="{{ old('company_name', $lead->company_name) }}">
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                           id="website" name="website" value="{{ old('website', $lead->website) }}">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="industry" class="form-label">Industry</label>
                                    <input type="text" class="form-control @error('industry') is-invalid @enderror" 
                                           id="industry" name="industry" value="{{ old('industry', $lead->industry) }}">
                                    @error('industry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="col-12 mt-4">
                                <h6 class="mb-3">Address Information</h6>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" name="address" rows="2">{{ old('address', $lead->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city', $lead->city) }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                           id="state" name="state" value="{{ old('state', $lead->state) }}">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                           id="country" name="country" value="{{ old('country', $lead->country) }}">
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="pincode" class="form-label">Pincode</label>
                                    <input type="text" class="form-control @error('pincode') is-invalid @enderror" 
                                           id="pincode" name="pincode" value="{{ old('pincode', $lead->pincode) }}">
                                    @error('pincode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Lead Details -->
                            <div class="col-12 mt-4">
                                <h6 class="mb-3">Lead Details</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lead_status" class="form-label">Lead Status *</label>
                                    <select class="form-select @error('lead_status') is-invalid @enderror" 
                                            id="lead_status" name="lead_status" required>
                                        <option value="">Select Status</option>
                                        @foreach($leadStatuses as $value => $label)
                                            <option value="{{ $value }}" {{ old('lead_status', $lead->lead_status) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('lead_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @php
                                $isCustomSource = !array_key_exists($lead->source, \App\Models\Lead::getSources());
                            @endphp
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="source" class="form-label">Source *</label>
                                    <select class="form-select @error('source') is-invalid @enderror" 
                                            id="source" name="source" required>
                                        <option value="">Select Source</option>
                                        @foreach($sources as $value => $label)
                                            <option value="{{ $value }}" {{ old('source', $lead->source) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                        @if($isCustomSource)
                                            <option value="other" selected>Other</option>
                                        @endif
                                    </select>
                                    @error('source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6" id="custom_source_div" style="display: {{ $isCustomSource ? 'block' : 'none' }};">
                                <div class="mb-3">
                                    <label for="custom_source" class="form-label">Enter the source</label>
                                    <input type="text" class="form-control @error('custom_source') is-invalid @enderror" 
                                           id="custom_source" name="custom_source" value="{{ old('custom_source', $isCustomSource ? $lead->source : '') }}" 
                                           placeholder="Please specify the source">
                                    @error('custom_source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select class="form-select @error('priority') is-invalid @enderror" 
                                            id="priority" name="priority">
                                        <option value="">Select Priority</option>
                                        @foreach($priorities as $value => $label)
                                            <option value="{{ $value }}" {{ old('priority', $lead->priority) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="budget" class="form-label">Budget</label>
                                    <input type="number" class="form-control @error('budget') is-invalid @enderror" 
                                           id="budget" name="budget" value="{{ old('budget', $lead->budget) }}" step="0.01">
                                    @error('budget')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expected_close_date" class="form-label">Expected Close Date</label>
                                    <input type="date" class="form-control @error('expected_close_date') is-invalid @enderror" 
                                           id="expected_close_date" name="expected_close_date" value="{{ old('expected_close_date', $lead->expected_close_date) }}">
                                    @error('expected_close_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description', $lead->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="2">{{ old('notes', $lead->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Assignment -->
                            <div class="col-12 mt-4">
                                <h6 class="mb-3">Assignment</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="assigned_to" class="form-label">Assigned To</label>
                                    <select class="form-select @error('assigned_to') is-invalid @enderror" 
                                            id="assigned_to" name="assigned_to">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('assigned_to', $lead->assigned_to) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <select class="form-select @error('department') is-invalid @enderror" 
                                            id="department" name="department">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            @php
                                                $leadDepartment = is_string($lead->department) ? json_decode($lead->department, true) : $lead->department;
                                                $leadDepartmentValue = is_array($leadDepartment) ? $leadDepartment[0] : $leadDepartment;
                                            @endphp
                                            <option value="{{ $department->department }}" {{ old('department', $leadDepartmentValue) == $department->department ? 'selected' : '' }}>
                                                {{ $department->department }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('leads.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to Leads
                                    </a>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Lead
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const departmentSelect = document.getElementById('department');
    const assignedToSelect = document.getElementById('assigned_to');
    const sourceSelect = document.getElementById('source');
    const customSourceDiv = document.getElementById('custom_source_div');
    const customSourceInput = document.getElementById('custom_source');
    
    // Handle source dropdown change
    if (sourceSelect && customSourceDiv) {
        sourceSelect.addEventListener('change', function() {
            const selectedSource = this.value;
            
            if (selectedSource === 'other') {
                customSourceDiv.style.display = 'block';
                customSourceInput.required = true;
            } else {
                customSourceDiv.style.display = 'none';
                customSourceInput.required = false;
                customSourceInput.value = '';
            }
        });
        
        // Check initial state on page load
        const currentSource = '{{ $lead->source }}';
        const availableSources = @json(array_keys(\App\Models\Lead::getSources()));
        const isCustomSource = !availableSources.includes(currentSource);
        
        if (isCustomSource || sourceSelect.value === 'other') {
            customSourceDiv.style.display = 'block';
            customSourceInput.required = true;
            if (!customSourceInput.value && isCustomSource) {
                customSourceInput.value = currentSource;
            }
        }
    }
    
    if (departmentSelect && assignedToSelect) {
        departmentSelect.addEventListener('change', function() {
            const selectedDepartment = this.value;
            
            if (selectedDepartment) {
                // Fetch users for the selected department
                fetch(`/product/Ticket/ajax/${selectedDepartment}`)
                    .then(response => response.json())
                    .then(users => {
                        // Clear current options
                        assignedToSelect.innerHTML = '<option value="">Select User</option>';
                        
                        // Add new options
                        if (users && users.length > 0) {
                            users.forEach(user => {
                                const option = document.createElement('option');
                                option.value = user.id;
                                option.textContent = `${user.name} (${user.position || 'N/A'})`;
                                assignedToSelect.appendChild(option);
                            });
                        } else {
                            const option = document.createElement('option');
                            option.value = "";
                            option.textContent = "No users found in this department";
                            option.disabled = true;
                            assignedToSelect.appendChild(option);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching users:', error);
                        assignedToSelect.innerHTML = '<option value="">Select User</option>';
                    });
            } else {
                // Reset to default when no department is selected
                assignedToSelect.innerHTML = '<option value="">Select User</option>';
            }
        });
    }
});
</script>
@endsection
