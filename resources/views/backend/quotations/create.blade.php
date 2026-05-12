@extends('admin.admin_master')

@section('admin')
@section('page-title', 'Create Quotation')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-file-invoice text-success"></i>
                        Create Professional Quotation
                    </h4>
                </div>
                <div class="card-body">
                    <form id="quotationForm" action="{{ route('quotations.store') }}" method="POST">
                        @csrf
                        @if($lead)
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                        @endif
                        
                        <!-- Client Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-user-tie"></i> Client Information
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_business_name" class="form-label">Business Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('client_business_name') is-invalid @enderror" 
                                           id="client_business_name" name="client_business_name" 
                                           value="{{ old('client_business_name', $lead->company ?? '') }}" required>
                                    @error('client_business_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_contact_name" class="form-label">Contact Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('client_contact_name') is-invalid @enderror" 
                                           id="client_contact_name" name="client_contact_name" 
                                           value="{{ old('client_contact_name', $lead->name ?? '') }}" required>
                                    @error('client_contact_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('client_email') is-invalid @enderror" 
                                           id="client_email" name="client_email" 
                                           value="{{ old('client_email', $lead->email ?? '') }}" required>
                                    @error('client_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('client_phone') is-invalid @enderror" 
                                           id="client_phone" name="client_phone" 
                                           value="{{ old('client_phone', $lead->phone ?? '') }}" required>
                                    @error('client_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Executive Summary -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-file-alt"></i> Executive Summary
                                </h5>
                                <div class="mb-3">
                                    <label for="executive_summary" class="form-label">Executive Summary</label>
                                    <textarea class="form-control @error('executive_summary') is-invalid @enderror" 
                                              id="executive_summary" name="executive_summary" rows="4" 
                                              placeholder="Provide a brief summary of the proposal...">{{ old('executive_summary') }}</textarea>
                                    @error('executive_summary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Services Selection -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-cogs"></i> Services Selection
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="servicesTable">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="50">Select</th>
                                                <th>Service Name</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Type</th>
                                                <th>Timeline</th>
                                                <th width="100">Quantity</th>
                                                <th width="120">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($services as $service)
                                            <tr class="service-row" data-service-id="{{ $service->id }}" data-price="{{ $service->price }}">
                                                <td>
                                                    <input type="checkbox" class="form-check-input service-checkbox" 
                                                           name="services[{{ $service->id }}][selected]" 
                                                           value="{{ $service->id }}"
                                                           onchange="toggleServiceRow({{ $service->id }})">
                                                </td>
                                                <td>
                                                    <strong>{{ $service->name }}</strong>
                                                    @if($service->is_optional)
                                                        <span class="badge bg-info ms-2">Optional</span>
                                                    @endif
                                                </td>
                                                <td>{{ Str::limit($service->description, 80) }}</td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-text">₹</span>
                                                        <input type="number" class="form-control form-control-sm price-input" 
                                                               name="services[{{ $service->id }}][price]" 
                                                               value="{{ $service->price }}" 
                                                               min="0" step="0.01" 
                                                               onchange="calculateSubtotal({{ $service->id }})"
                                                               disabled>
                                                    </div>
                                                </td>
                                                <td>{{ $service->formatted_pricing_type }}</td>
                                                <td>
                                                    @if($service->timeline_weeks)
                                                        {{ $service->timeline_weeks }} weeks
                                                    @else
                                                        Ongoing
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm quantity-input" 
                                                           name="services[{{ $service->id }}][quantity]" 
                                                           value="1" min="1" 
                                                           onchange="calculateSubtotal({{ $service->id }})"
                                                           disabled>
                                                </td>
                                                <td class="subtotal-cell">₹0.00</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Summary -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-calculator"></i> Pricing Summary
                                </h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-6"><strong>Total Cost:</strong></div>
                                            <div class="col-6 text-end" id="totalCost">₹0.00</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6"><strong>GST (18%):</strong></div>
                                            <div class="col-6 text-end" id="gstAmount">₹0.00</div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-6"><h5>Final Amount:</h5></div>
                                            <div class="col-6 text-end"><h5 id="finalAmount">₹0.00</h5></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-cog"></i> Additional Options
                                </h5>
                                <div class="mb-3">
                                    <label for="valid_until" class="form-label">Valid Until</label>
                                    <input type="date" class="form-control" id="valid_until" name="valid_until">
                                </div>
                                <div class="mb-3">
                                    <label for="terms_conditions" class="form-label">Terms & Conditions</label>
                                    <textarea class="form-control" id="terms_conditions" name="terms_conditions" rows="4" 
                                              placeholder="Enter terms and conditions...">{{ old('terms_conditions') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('sales.department') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Back to Sales Department
                            </a>
                            <div>
                                <button type="button" class="btn btn-info me-2" onclick="previewQuotation()">
                                    <i class="fas fa-eye"></i>
                                    Preview
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i>
                                    Create Quotation
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedServices = {};

function toggleServiceRow(serviceId) {
    const checkbox = event.target;
    const row = checkbox.closest('tr');
    const quantityInput = row.querySelector('.quantity-input');
    const priceInput = row.querySelector('.price-input');
    
    if (checkbox.checked) {
        quantityInput.disabled = false;
        priceInput.disabled = false;
        calculateSubtotal(serviceId);
    } else {
        quantityInput.disabled = true;
        priceInput.disabled = true;
        row.querySelector('.subtotal-cell').textContent = '₹0.00';
        delete selectedServices[serviceId];
    }
    calculateTotal();
}

function calculateSubtotal(serviceId) {
    const row = document.querySelector(`tr[data-service-id="${serviceId}"]`);
    const price = parseFloat(row.querySelector('.price-input').value) || 0;
    const quantity = parseInt(row.querySelector('.quantity-input').value) || 1;
    const subtotal = price * quantity;
    
    row.querySelector('.subtotal-cell').textContent = '₹' + subtotal.toFixed(2);
    selectedServices[serviceId] = { price, quantity, subtotal };
    calculateTotal();
}

function calculateTotal() {
    let totalCost = 0;
    Object.values(selectedServices).forEach(service => {
        totalCost += service.subtotal;
    });
    
    const gstAmount = totalCost * 0.18;
    const finalAmount = totalCost + gstAmount;
    
    document.getElementById('totalCost').textContent = '₹' + totalCost.toFixed(2);
    document.getElementById('gstAmount').textContent = '₹' + gstAmount.toFixed(2);
    document.getElementById('finalAmount').textContent = '₹' + finalAmount.toFixed(2);
}

function previewQuotation() {
    // This will open a preview of the quotation
    alert('Preview functionality will be implemented next!');
}

// Set default valid date to 30 days from now
document.addEventListener('DOMContentLoaded', function() {
    const validUntil = new Date();
    validUntil.setDate(validUntil.getDate() + 30);
    document.getElementById('valid_until').value = validUntil.toISOString().split('T')[0];
});
</script>
@endsection
