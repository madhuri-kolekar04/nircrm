@extends('admin.admin_master')

@section('page-title', 'Create Invoice')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Create Invoice</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf
                        
                        <!-- Project Details Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-project-diagram"></i> Project Details
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="project_name" class="form-label">Project Name *</label>
                                    <input type="text" class="form-control" id="project_name" name="project_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="project_topic" class="form-label">Project Topic *</label>
                                    <input type="text" class="form-control" id="project_topic" name="project_topic" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="project_full_details" class="form-label">Project Full Details *</label>
                                    <textarea class="form-control" id="project_full_details" name="project_full_details" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date *</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date *</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="department_id" class="form-label">Department *</label>
                                    <select class="form-control" id="department_id" name="department_id" required style="color: black; font-weight: bold;">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $id => $name)
                                            <option value="{{ $id }}" style="color: black; font-weight: bold;">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Customer Details Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-user"></i> Customer Details
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Customer Name *</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_email" class="form-label">Customer Email *</label>
                                    <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_phone" class="form-label">Customer Phone *</label>
                                    <input type="text" class="form-control" id="customer_phone" name="customer_phone" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_address" class="form-label">Customer Address *</label>
                                    <textarea class="form-control" id="customer_address" name="customer_address" rows="2" required></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Details Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-rupee-sign"></i> Payment Details
                                </h6>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="advance_payment" class="form-label">Advance Payment *</label>
                                    <input type="number" class="form-control border-primary" id="advance_payment" name="advance_payment" step="0.01" min="0" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="remaining_payment" class="form-label">Remaining Payment *</label>
                                    <input type="number" class="form-control border-primary" id="remaining_payment" name="remaining_payment" step="0.01" min="0" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="gst" class="form-label">GST *</label>
                                    <input type="number" class="form-control border-primary" id="gst" name="gst" step="0.01" min="0" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Total Payment</label>
                                    <input type="number" class="form-control border-success" id="total_payment" name="total_payment" step="0.01" min="0" placeholder="0.00" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Invoice
                                </button>
                                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
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
    // All fields are now manual - no automatic calculations
});
</script>
@endsection
