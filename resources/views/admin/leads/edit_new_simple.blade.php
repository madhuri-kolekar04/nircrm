@extends('admin.admin_master')

@section('page-title', 'Edit Lead')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>Edit Lead
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('leads.update.new', $lead->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="mb-3 text-primary">Basic Information</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $lead->name) }}">
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
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
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
                        </div>

                        <!-- Lead Details -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="mb-3 text-primary">Lead Details</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="lead_status" class="form-label">Lead Status</label>
                                    <select class="form-select @error('lead_status') is-invalid @enderror" 
                                            id="lead_status" name="lead_status">
                                        <option value="">Select Status</option>
                                        @foreach(App\Models\Lead::getLeadStatuses() as $value => $label)
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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select class="form-select @error('priority') is-invalid @enderror" 
                                            id="priority" name="priority">
                                        <option value="">Select Priority</option>
                                        @foreach(App\Models\Lead::getPriorities() as $value => $label)
                                            <option value="{{ $value }}" {{ old('priority', $lead->priority ?? 'medium') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="source" class="form-label">Source</label>
                                    <select class="form-select @error('source') is-invalid @enderror" 
                                            id="source" name="source">
                                        <option value="">Select Source</option>
                                        @foreach(App\Models\Lead::getSources() as $value => $label)
                                            <option value="{{ $value }}" {{ old('source', $lead->source) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2" id="custom_source_div" style="display: none;">
                                        <input type="text" class="form-control @error('custom_source') is-invalid @enderror" 
                                               id="custom_source" name="custom_source" 
                                               value="{{ old('custom_source') }}" placeholder="Enter custom source" maxlength="255">
                                        @error('custom_source')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="mb-3 text-primary">Address Information</h6>
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
                        </div>

                        <!-- Additional Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="mb-3 text-primary">Additional Information</h6>
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
                                    <label for="follow_up_date" class="form-label">Follow Up Date</label>
                                    <input type="date" class="form-control @error('follow_up_date') is-invalid @enderror" 
                                           id="follow_up_date" name="follow_up_date" value="{{ old('follow_up_date', $lead->follow_up_date ? $lead->follow_up_date->format('Y-m-d') : '') }}">
                                    @error('follow_up_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="budget" class="form-label">Budget</label>
                                    <input type="number" class="form-control @error('budget') is-invalid @enderror" 
                                           id="budget" name="budget" value="{{ old('budget', $lead->budget) }}" step="0.01" min="0">
                                    @error('budget')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="department_id" class="form-label">Department</label>
                                    <select class="form-select @error('department_id') is-invalid @enderror" 
                                            id="department_id" name="department_id">
                                        <option value="">Select Department</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('department_id', $lead->department_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->department }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
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
                                              id="notes" name="notes" rows="3">{{ old('notes', $lead->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Work Details -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="mb-3 text-primary">Work Details</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="work_status" class="form-label">Work Status</label>
                                    <select class="form-select @error('work_status') is-invalid @enderror" 
                                            id="work_status" name="work_status">
                                        <option value="">Select Status</option>
                                        <option value="Active" {{ old('work_status', $lead->work_status) == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="NO" {{ old('work_status', $lead->work_status) == 'NO' ? 'selected' : '' }}>NO</option>
                                    </select>
                                    @error('work_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="work_type" class="form-label">Work Type</label>
                                    <input type="text" class="form-control @error('work_type') is-invalid @enderror" 
                                           id="work_type" name="work_type" value="{{ old('work_type', $lead->work_type) }}" placeholder="Enter work type">
                                    @error('work_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="current_service" class="form-label">Current Service</label>
                                    <input type="text" class="form-control @error('current_service') is-invalid @enderror" 
                                           id="current_service" name="current_service" value="{{ old('current_service', $lead->current_service) }}" placeholder="Enter current service">
                                    @error('current_service')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_of_completion" class="form-label">Date of Completion</label>
                                    <input type="date" class="form-control @error('date_of_completion') is-invalid @enderror" 
                                           id="date_of_completion" name="date_of_completion" value="{{ old('date_of_completion', $lead->date_of_completion ? $lead->date_of_completion->format('Y-m-d') : '') }}">
                                    @error('date_of_completion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="due_date" class="form-label">Due Date</label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                           id="due_date" name="due_date" value="{{ old('due_date', $lead->due_date ? $lead->due_date->format('Y-m-d') : '') }}">
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('leads.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Lead
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 9999;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 9999;">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sourceSelect = document.getElementById('source');
    const customSourceDiv = document.getElementById('custom_source_div');
    const customSourceInput = document.getElementById('custom_source');
    
    // Check if current source is a custom value (not in predefined options)
    const predefinedSources = @json(App\Models\Lead::getSources());
    const currentSource = '{{ $lead->source }}';
    let isCustomSource = true;
    
    // Check if current source matches any predefined option
    for (const [value, label] of Object.entries(predefinedSources)) {
        if (value === currentSource) {
            isCustomSource = false;
            break;
        }
    }
    
    // If current source is custom, set it to "other" and populate custom field
    if (isCustomSource && currentSource) {
        sourceSelect.value = 'other';
        customSourceInput.value = currentSource;
        customSourceDiv.style.display = 'block';
    }
    
    // Handle source dropdown change
    if (sourceSelect && customSourceDiv) {
        sourceSelect.addEventListener('change', function() {
            const selectedSource = this.value;
            
            if (selectedSource === 'other') {
                customSourceDiv.style.display = 'block';
            } else {
                customSourceDiv.style.display = 'none';
                customSourceInput.value = '';
            }
        });
        
        // Check initial state on page load
        if (sourceSelect.value === 'other') {
            customSourceDiv.style.display = 'block';
        }
    }
    
    console.log('Edit lead form loaded with custom source functionality');
});
</script>
@endpush
