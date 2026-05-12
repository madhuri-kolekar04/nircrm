@extends('admin.admin_master')

@section('page-title', 'Add Lead')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Add New Lead</h5>
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

                    <!-- Toast Notification Container -->
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
                        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="me-auto" id="toastTitle">Notification</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body" id="toastMessage">
                                Message here
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('leads.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-12">
                                <h6 class="mb-3">Basic Information</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                           id="company_name" name="company_name" value="{{ old('company_name') }}">
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                           id="website" name="website" value="{{ old('website') }}">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="industry" class="form-label">Industry</label>
                                    <input type="text" class="form-control @error('industry') is-invalid @enderror" 
                                           id="industry" name="industry" value="{{ old('industry') }}">
                                    @error('industry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <!-- Address Information -->
                            <div class="col-12">
                                <h6 class="mb-3">Address Information</h6>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" name="address" rows="2">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city') }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                           id="state" name="state" value="{{ old('state') }}">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                           id="country" name="country" value="{{ old('country') }}">
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="pincode" class="form-label">Pincode</label>
                                    <input type="text" class="form-control @error('pincode') is-invalid @enderror" 
                                           id="pincode" name="pincode" value="{{ old('pincode') }}">
                                    @error('pincode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <!-- Lead Details -->
                            <div class="col-12">
                                <h6 class="mb-3">Lead Details</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="lead_status" class="form-label">Lead Status *</label>
                                    <div class="input-group">
                                        <select class="form-select @error('lead_status') is-invalid @enderror" 
                                                id="lead_status" name="lead_status" required>
                                            <option value="">Select Status</option>
                                            @foreach($leadStatuses as $key => $status)
                                                <option value="{{ $key }}" {{ old('lead_status') == $key ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                            <option value="add_new_status">+ Add New Status</option>
                                        </select>
                                    </div>
                                    <div class="mt-2" id="new_status_div" style="display: none;">
                                        <input type="text" class="form-control @error('new_lead_status') is-invalid @enderror" 
                                               id="new_lead_status" name="new_lead_status" 
                                               placeholder="Enter new status name" maxlength="100">
                                        @error('new_lead_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @error('lead_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="source" class="form-label">Source *</label>
                                    <select class="form-select @error('source') is-invalid @enderror" 
                                            id="source" name="source" required>
                                        <option value="">Select Source</option>
                                        @foreach($sources as $key => $source)
                                            <option value="{{ $key }}" {{ old('source') == $key ? 'selected' : '' }}>
                                                {{ $source }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4" id="custom_source_div" style="display: none;">
                                <div class="mb-3">
                                    <label for="custom_source" class="form-label">Enter the source</label>
                                    <input type="text" class="form-control @error('custom_source') is-invalid @enderror" 
                                           id="custom_source" name="custom_source" value="{{ old('custom_source') }}" 
                                           placeholder="Please specify the source">
                                    @error('custom_source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Priority *</label>
                                    <div class="input-group">
                                        <select class="form-select @error('priority') is-invalid @enderror" 
                                                id="priority" name="priority" required>
                                            <option value="">Select Priority</option>
                                            @foreach($priorities as $key => $priority)
                                                <option value="{{ $key }}" {{ old('priority') == $key ? 'selected' : '' }}>
                                                    {{ $priority }}
                                                </option>
                                            @endforeach
                                            <option value="add_new_priority">+ Add New Priority</option>
                                        </select>
                                    </div>
                                    <div class="mt-2" id="new_priority_div" style="display: none;">
                                        <input type="text" class="form-control @error('new_priority') is-invalid @enderror" 
                                               id="new_priority" name="new_priority" 
                                               placeholder="Enter new priority name" maxlength="100">
                                        @error('new_priority')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="budget" class="form-label">Budget</label>
                                    <input type="number" step="0.01" class="form-control @error('budget') is-invalid @enderror" 
                                           id="budget" name="budget" value="{{ old('budget') }}">
                                    @error('budget')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="follow_up_date" class="form-label">Follow Up Date</label>
                                    <input type="date" class="form-control @error('follow_up_date') is-invalid @enderror" 
                                           id="follow_up_date" name="follow_up_date" value="{{ old('follow_up_date') }}">
                                    @error('follow_up_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="department_id" class="form-label">Department</label>
                                    <select class="form-select @error('department_id') is-invalid @enderror" 
                                            id="department_id" name="department_id">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->department }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="assigned_to" class="form-label">Assigned To</label>
                                    <select class="form-select @error('assigned_to') is-invalid @enderror" 
                                            id="assigned_to" name="assigned_to">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->position ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <!-- Additional Information -->
                            <div class="col-12">
                                <h6 class="mb-3">Additional Information</h6>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('leads.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Lead
                            </button>
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
    const leadStatusSelect = document.getElementById('lead_status');
    const newStatusDiv = document.getElementById('new_status_div');
    const newStatusInput = document.getElementById('new_lead_status');
    const prioritySelect = document.getElementById('priority');
    const newPriorityDiv = document.getElementById('new_priority_div');
    const newPriorityInput = document.getElementById('new_priority');
    
    // Handle lead status dropdown change
    if (leadStatusSelect && newStatusDiv) {
        leadStatusSelect.addEventListener('change', function() {
            const selectedStatus = this.value;
            
            if (selectedStatus === 'add_new_status') {
                newStatusDiv.style.display = 'block';
                newStatusInput.required = true;
                leadStatusSelect.required = false;
            } else {
                newStatusDiv.style.display = 'none';
                newStatusInput.required = false;
                newStatusInput.value = '';
                leadStatusSelect.required = true;
            }
        });
        
        // Check initial state on page load
        if (leadStatusSelect.value === 'add_new_status') {
            newStatusDiv.style.display = 'block';
            newStatusInput.required = true;
            leadStatusSelect.required = false;
        }
    }
    
    // Handle priority dropdown change
    if (prioritySelect && newPriorityDiv) {
        prioritySelect.addEventListener('change', function() {
            const selectedPriority = this.value;
            
            if (selectedPriority === 'add_new_priority') {
                newPriorityDiv.style.display = 'block';
                newPriorityInput.required = true;
                prioritySelect.required = false;
            } else {
                newPriorityDiv.style.display = 'none';
                newPriorityInput.required = false;
                newPriorityInput.value = '';
                prioritySelect.required = true;
            }
        });
        
        // Check initial state on page load
        if (prioritySelect.value === 'add_new_priority') {
            newPriorityDiv.style.display = 'block';
            newPriorityInput.required = true;
            prioritySelect.required = false;
        }
    }
    
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
        if (sourceSelect.value === 'other') {
            customSourceDiv.style.display = 'block';
            customSourceInput.required = true;
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
    
    // Form submission handler with toast notification
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading toast
            showToast('Processing...', 'info');
            
            // Submit form via fetch
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Network response was not ok');
            })
            .then(html => {
                // Check if response contains success message
                if (html.includes('alert-success') || html.includes('Lead created successfully')) {
                    showToast('Lead created successfully!', 'success');
                    // Redirect after delay
                    setTimeout(() => {
                        window.location.href = '/leadsmanagement';
                    }, 2000);
                } else if (html.includes('alert-danger') || html.includes('error')) {
                    showToast('Error creating lead. Please check the form.', 'error');
                } else {
                    showToast('Unknown response. Please check the results.', 'warning');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error submitting form. Please try again.', 'error');
            });
        });
    }
    
    // Toast notification function
    function showToast(message, type = 'info') {
        const toastEl = document.getElementById('liveToast');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');
        
        // Set message and title
        toastMessage.textContent = message;
        
        // Set title and color based on type
        switch(type) {
            case 'success':
                toastTitle.textContent = 'Success';
                toastEl.classList.remove('bg-danger', 'bg-warning', 'bg-info');
                toastEl.classList.add('bg-success', 'text-white');
                break;
            case 'error':
                toastTitle.textContent = 'Error';
                toastEl.classList.remove('bg-success', 'bg-warning', 'bg-info');
                toastEl.classList.add('bg-danger', 'text-white');
                break;
            case 'warning':
                toastTitle.textContent = 'Warning';
                toastEl.classList.remove('bg-success', 'bg-danger', 'bg-info');
                toastEl.classList.add('bg-warning', 'text-white');
                break;
            default:
                toastTitle.textContent = 'Info';
                toastEl.classList.remove('bg-success', 'bg-danger', 'bg-warning');
                toastEl.classList.add('bg-info', 'text-white');
        }
        
        // Show toast
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
    
    // Show success/error messages from session as toast
    @if(session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif
    
    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif
});
</script>
@endsection
