@extends('admin.admin_master')

@section('admin')
@section('page-title', 'Edit Quotation: ' . $quotation->quotation_number)

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-edit text-warning"></i>
                        Edit Quotation: {{ $quotation->quotation_number }}
                    </h4>
                    <a href="{{ route('quotations.show', $quotation->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i>
                        View Quotation
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Validation Error!</strong> Please fix the following errors:
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('quotations.update', $quotation->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Client Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-user"></i>
                                    Client Information
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="client_business_name" class="form-label">Business Name *</label>
                                    <input type="text" class="form-control" id="client_business_name" 
                                           name="client_business_name" value="{{ old('client_business_name', $quotation->client_business_name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="client_contact_name" class="form-label">Contact Person *</label>
                                    <input type="text" class="form-control" id="client_contact_name" 
                                           name="client_contact_name" value="{{ old('client_contact_name', $quotation->client_contact_name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="client_email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="client_email" 
                                           name="client_email" value="{{ old('client_email', $quotation->client_email) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="client_phone" class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control" id="client_phone" 
                                           name="client_phone" value="{{ old('client_phone', $quotation->client_phone) }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Executive Summary -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-file-alt"></i>
                                    Executive Summary
                                </h5>
                                <div class="form-group">
                                    <label for="executive_summary" class="form-label">Executive Summary</label>
                                    <textarea class="form-control" id="executive_summary" name="executive_summary" rows="4">{{ old('executive_summary', $quotation->executive_summary) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Services Selection -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-cogs"></i>
                                    Services Selection
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="5%">Select</th>
                                                <th width="25%">Service Name</th>
                                                <th width="30%">Description</th>
                                                <th width="15%">Price</th>
                                                <th width="10%">Timeline</th>
                                                <th width="10%">Quantity</th>
                                                <th width="5%">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($services as $service)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" name="services[{{ $service->id }}][selected]" 
                                                           value="1" class="service-checkbox"
                                                           onchange="calculateTotals()"
                                                           @if($quotation->services->contains($service->id)) checked @endif>
                                                </td>
                                                <td>
                                                    <strong>{{ $service->name }}</strong>
                                                    @if($service->is_optional)
                                                    <span class="badge bg-info ms-2">Optional</span>
                                                    @endif
                                                </td>
                                                <td>{{ Str::limit($service->description, 100) }}</td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-text">₹</span>
                                                        <input type="number" class="form-control form-control-sm price-input" 
                                                               name="services[{{ $service->id }}][price]" 
                                                               value="{{ $quotation->services->contains($service->id) ? $quotation->services->find($service->id)->pivot->price : $service->price }}" 
                                                               min="0" step="0.01" 
                                                               onchange="calculateTotals()"
                                                               oninput="calculateTotals()"
                                                               onkeyup="calculateTotals()">
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($service->timeline_weeks)
                                                        {{ $service->timeline_weeks }} weeks
                                                    @else
                                                        Ongoing
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="number" name="services[{{ $service->id }}][quantity]" 
                                                           class="form-control form-control-sm quantity-input" 
                                                           value="{{ $quotation->services->contains($service->id) ? $quotation->services->find($service->id)->pivot->quantity : 1 }}" 
                                                           min="1" data-price="{{ $service->price }}"
                                                           onchange="calculateTotals()"
                                                           oninput="calculateTotals()"
                                                           onkeyup="calculateTotals()">
                                                </td>
                                                <td class="subtotal">{{ $quotation->services->contains($service->id) ? number_format($quotation->services->find($service->id)->pivot->subtotal, 2) : '0.00' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Summary -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-calculator"></i>
                                    Pricing Summary
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Total Cost (excluding GST)</th>
                                            <td class="text-end" id="total_cost">{{ number_format($quotation->total_cost, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>GST (18%)</th>
                                            <td class="text-end" id="gst_amount">{{ number_format($quotation->gst_amount, 2) }}</td>
                                        </tr>
                                        <tr class="table-success">
                                            <th>Final Amount</th>
                                            <td class="text-end" id="final_amount">{{ number_format($quotation->final_amount, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-calendar"></i>
                                    Additional Options
                                </h5>
                                <div class="form-group mb-3">
                                    <label for="valid_until" class="form-label">Valid Until</label>
                                    <input type="date" class="form-control" id="valid_until" 
                                           name="valid_until" value="{{ old('valid_until', $quotation->valid_until ? $quotation->valid_until->format('Y-m-d') : '') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="draft" {{ $quotation->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="sent" {{ $quotation->status === 'sent' ? 'selected' : '' }}>Sent</option>
                                        <option value="approved" {{ $quotation->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $quotation->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-file-contract"></i>
                                    Terms and Conditions
                                </h5>
                                <div class="form-group">
                                    <label for="terms_conditions" class="form-label">Terms and Conditions</label>
                                    <textarea class="form-control" id="terms_conditions" name="terms_conditions" rows="4">{{ old('terms_conditions', $quotation->terms_conditions) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('quotations.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i>
                                        Back to Quotations
                                    </a>
                                    <div>
                                        <button type="reset" class="btn btn-warning me-2">
                                            <i class="fas fa-undo"></i>
                                            Reset
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i>
                                            Save Changes
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
// Global function to calculate totals
function calculateTotals() {
    console.log('Calculating totals...');
    let totalCost = 0;
    
    // Get all service rows
    const serviceRows = document.querySelectorAll('tbody tr');
    
    serviceRows.forEach(function(row) {
        const checkbox = row.querySelector('.service-checkbox');
        const quantityInput = row.querySelector('.quantity-input');
        const priceInput = row.querySelector('.price-input');
        const subtotalCell = row.querySelector('.subtotal');
        
        if (checkbox && quantityInput && priceInput && subtotalCell) {
            if (checkbox.checked) {
                const price = parseFloat(priceInput.value) || 0;
                const quantity = parseInt(quantityInput.value) || 1;
                const subtotal = price * quantity;
                
                subtotalCell.textContent = '₹' + subtotal.toFixed(2);
                totalCost += subtotal;
                
                console.log('Row updated - Price:', price, 'Quantity:', quantity, 'Subtotal:', subtotal);
            } else {
                subtotalCell.textContent = '₹0.00';
            }
        }
    });
    
    const gstAmount = totalCost * 0.18;
    const finalAmount = totalCost + gstAmount;
    
    // Update pricing summary
    const totalCostElement = document.getElementById('total_cost');
    const gstAmountElement = document.getElementById('gst_amount');
    const finalAmountElement = document.getElementById('final_amount');
    
    if (totalCostElement) totalCostElement.textContent = '₹' + totalCost.toFixed(2);
    if (gstAmountElement) gstAmountElement.textContent = '₹' + gstAmount.toFixed(2);
    if (finalAmountElement) finalAmountElement.textContent = '₹' + finalAmount.toFixed(2);
    
    console.log('Final totals - Total:', totalCost, 'GST:', gstAmount, 'Final:', finalAmount);
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, setting up event listeners...');
    
    // Add event listeners to all checkboxes
    const checkboxes = document.querySelectorAll('.service-checkbox');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            console.log('Checkbox changed');
            calculateTotals();
        });
    });
    
    // Add event listeners to all quantity inputs
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(function(input) {
        // Add multiple event types to catch all changes
        input.addEventListener('input', function() {
            console.log('Quantity input changed to:', this.value);
            calculateTotals();
        });
        
        input.addEventListener('change', function() {
            console.log('Quantity changed to:', this.value);
            calculateTotals();
        });
        
        input.addEventListener('keyup', function() {
            console.log('Quantity keyup:', this.value);
            calculateTotals();
        });
    });
    
    // Initial calculation
    console.log('Performing initial calculation');
    calculateTotals();
});

// Also try jQuery approach as backup
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        console.log('jQuery also loaded, adding jQuery listeners...');
        
        $('.service-checkbox').on('change', function() {
            console.log('jQuery checkbox changed');
            calculateTotals();
        });
        
        $('.quantity-input').on('input change keyup', function() {
            console.log('jQuery quantity changed to:', $(this).val());
            calculateTotals();
        });
        
        // Initial calculation
        calculateTotals();
    });
}
</script>
@endsection
