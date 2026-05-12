@extends('admin.admin_master')

@section('page-title', 'Lead Details')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Lead Details - {{ $lead->name }}</h5>
                    <div>
                        <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('leads.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Leads
                        </a>
                    </div>
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

                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-12">
                            <h6 class="mb-3 border-bottom pb-2">Basic Information</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Name</label>
                                <p class="form-control-plaintext">{{ $lead->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Email</label>
                                <p class="form-control-plaintext">{{ $lead->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Phone</label>
                                <p class="form-control-plaintext">{{ $lead->phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Company Name</label>
                                <p class="form-control-plaintext">{{ $lead->company_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Website</label>
                                <p class="form-control-plaintext">
                                    @if($lead->website)
                                        <a href="{{ $lead->website }}" target="_blank">{{ $lead->website }}</a>
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Industry</label>
                                <p class="form-control-plaintext">{{ $lead->industry ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="col-12 mt-4">
                            <h6 class="mb-3 border-bottom pb-2">Address Information</h6>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label text-muted">Address</label>
                                <p class="form-control-plaintext">{{ $lead->address ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted">City</label>
                                <p class="form-control-plaintext">{{ $lead->city ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted">State</label>
                                <p class="form-control-plaintext">{{ $lead->state ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted">Country</label>
                                <p class="form-control-plaintext">{{ $lead->country ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted">Pincode</label>
                                <p class="form-control-plaintext">{{ $lead->pincode ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Lead Details -->
                        <div class="col-12 mt-4">
                            <h6 class="mb-3 border-bottom pb-2">Lead Details</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Lead Status</label>
                                <p class="form-control-plaintext">
                                    @if($lead->lead_status)
                                        <span class="badge bg-{{ 
                                            $lead->lead_status == 'hot' ? 'danger' : 
                                            ($lead->lead_status == 'cold' ? 'info' : 
                                            ($lead->lead_status == 'warm' ? 'warning' : 
                                            ($lead->lead_status == 'qualified' ? 'success' : 'secondary'))) 
                                        }}">
                                            {{ ucfirst($lead->lead_status) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Source</label>
                                <p class="form-control-plaintext">{{ $lead->source ? ucfirst(str_replace('_', ' ', $lead->source)) : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Priority</label>
                                <p class="form-control-plaintext">
                                    @if($lead->priority)
                                        <span class="badge bg-{{ 
                                            $lead->priority == 'high' ? 'danger' : 
                                            ($lead->priority == 'medium' ? 'warning' : 'success') 
                                        }}">
                                            {{ ucfirst($lead->priority) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Budget</label>
                                <p class="form-control-plaintext">
                                    @if($lead->budget)
                                        Rs {{ number_format($lead->budget, 2) }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Expected Close Date</label>
                                <p class="form-control-plaintext">{{ $lead->expected_close_date ? \Carbon\Carbon::parse($lead->expected_close_date)->format('M d, Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Created Date</label>
                                <p class="form-control-plaintext">{{ $lead->created_at ? \Carbon\Carbon::parse($lead->created_at)->format('M d, Y H:i A') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label text-muted">Description</label>
                                <p class="form-control-plaintext">{{ $lead->description ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label text-muted">Notes</label>
                                <p class="form-control-plaintext">{{ $lead->notes ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Assignment Information -->
                        <div class="col-12 mt-4">
                            <h6 class="mb-3 border-bottom pb-2">Assignment Information</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Assigned To</label>
                                <p class="form-control-plaintext">
                                    @if($lead->assignedUser)
                                        {{ $lead->assignedUser->name }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Created By</label>
                                <p class="form-control-plaintext">
                                    @if($lead->creator)
                                        {{ $lead->creator->name }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Department</label>
                                <p class="form-control-plaintext">
                                    @if($department)
                                        @if(is_object($department))
                                            {{ $department->department }}
                                        @else
                                            {{ $department }}
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-12 mt-4">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('leads.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Leads
                                </a>
                                <div>
                                    <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Edit Lead
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
