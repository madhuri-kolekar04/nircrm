@extends('admin.admin_master')

@section('page-title', 'Create Invoice')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-invoice"></i> Create Invoice - {{ $quotation->quotation_number }}
                    </h5>
                    <div>
                        <button type="submit" form="invoice-form" class="btn btn-primary me-2" name="save_only" value="1">
                            <i class="fas fa-save"></i> Save Invoice Details
                        </button>
                        <a href="{{ route('accounts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Accounts
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('accounts.simple-save-invoice', $quotation->id) }}" method="POST" id="invoice-form">
                        @csrf
                        
                        <!-- Invoice Header Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6><i class="fas fa-info-circle"></i> Invoice Details</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <tr>
                                            <td><strong>Invoice Number:</strong></td>
                                            <td>{{ $invoiceNumber }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Date:</strong></td>
                                            <td>
                                                <input type="date" class="form-control form-control-sm" name="invoice_date" 
                                                       value="{{ now()->format('Y-m-d') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Quotation Ref:</strong></td>
                                            <td>{{ $quotation->quotation_number }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Status:</strong></td>
                                            <td>
                                                <select class="form-select form-select-sm" name="payment_status">
                                                    <option value="pending" {{ $quotation->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="partial" {{ $quotation->payment_status == 'partial' ? 'selected' : '' }}>Partial</option>
                                                    <option value="completed" {{ $quotation->payment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="overdue" {{ $quotation->payment_status == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                                    <option value="cancelled" {{ $quotation->payment_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-user"></i> Client Information</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="client_name" 
                                                       value="{{ $quotation->client_contact_name }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Business:</strong></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="client_business" 
                                                       value="{{ $quotation->client_business_name }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>
                                                <input type="email" class="form-control form-control-sm" name="client_email" 
                                                       value="{{ $quotation->client_email }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="client_phone" 
                                                       value="{{ $quotation->client_phone }}">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Details of Niranjan Enterprises -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6><i class="fas fa-university"></i> Bank Details of Niranjan Enterprises</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bank_name" class="form-label">Bank Name</label>
                                            <input type="text" class="form-control" id="bank_name" name="bank_name" 
                                                   value="Bank of Maharashtra" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bank_account_number" class="form-label">Bank Account Number</label>
                                            <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" 
                                                   value="60187263458" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="ifsc_code" class="form-label">Branch & IFSC</label>
                                            <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" 
                                                   value="MAHB0000114" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bank_gst_number" class="form-label">GST Number</label>
                                            <input type="text" class="form-control" id="bank_gst_number" name="bank_gst_number" 
                                                   placeholder="Enter GST Number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Client GST Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6><i class="fas fa-receipt"></i> Client GST Information</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="gst_number" class="form-label">GST Registration Number</label>
                                            <input type="text" class="form-control" id="gst_number" name="gst_number" 
                                                   placeholder="Enter GST Number" maxlength="20">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="place_of_supply" class="form-label">Place of Supply *</label>
                                            <input type="text" class="form-control" id="place_of_supply" name="place_of_supply" 
                                                   value="Maharashtra" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="hsn_code" class="form-label">HSN/SAC Code</label>
                                            <input type="text" class="form-control" id="hsn_code" name="hsn_code" 
                                                   value="998314" placeholder="Enter HSN/SAC Code" maxlength="20">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">GST Rate</label>
                                            <input type="text" class="form-control" value="18%" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Installment -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6><i class="fas fa-credit-card"></i> Payment Details</h6>
                                
                                <!-- Simple Payment Summary -->
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Hidden total amount for calculations -->
                                            <input type="hidden" id="total_amount" name="total_amount" 
                                                   value="{{ $quotation->final_amount }}">
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Advance Payment</label>
                                                <input type="number" class="form-control" id="advance_payment" name="advance_payment" 
                                                       placeholder="0.00" min="0" step="0.01" value="0" onchange="updatePaymentDetails()">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Remaining Payment</label>
                                                <input type="number" class="form-control bg-white" id="remaining_payment" name="remaining_payment" 
                                                       value="{{ $quotation->final_amount }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">GST</label>
                                                <input type="number" class="form-control bg-white" id="gst_amount" name="gst_amount" 
                                                       value="{{ $quotation->gst_amount }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Total Payment</label>
                                                <input type="number" class="form-control border-success" id="total_payment" name="total_payment" 
                                                       value="{{ $quotation->final_amount + $quotation->gst_amount }}" onchange="updatePaymentDetails()">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Advance Payment Date</label>
                                                <input type="date" class="form-control" id="advance_payment_date" name="advance_payment_date" 
                                                       value="{{ now()->format('Y-m-d') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Payment Schedule</label>
                                                <div class="btn-group w-100 mb-3" role="group">
                                                    <button type="button" class="btn btn-outline-primary" onclick="addInstallment()">
                                                        <i class="fas fa-plus"></i> Add Installment
                                                    </button>
                                                    <button type="button" class="btn btn-outline-info" onclick="calculateSummary()">
                                                        <i class="fas fa-calculator"></i> Calculate Summary
                                                    </button>
                                                    <button type="button" class="btn btn-outline-warning" onclick="testModal()">
                                                        <i class="fas fa-bug"></i> Test Modal
                                                    </button>
                                                    <button type="button" class="btn btn-outline-success" onclick="autoFixInstallments()">
                                                        <i class="fas fa-magic"></i> Auto-Fix Amounts
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Installments Container -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-list"></i> Installment Schedule
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="installments-container">
                                            <div class="text-center text-muted py-4" id="empty-installments">
                                                <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                                <p>Click "Add Installment" to create payment schedule entries</p>
                                                <small class="text-muted">You can add multiple installments with custom amounts and due dates</small>
                                            </div>
                                        </div>
                                        
                                        <!-- Installment Summary -->
                                        <div class="row mt-3" id="installment-summary" style="display: none;">
                                            <div class="col-12">
                                                <div class="alert alert-info">
                                                    <h6><i class="fas fa-info-circle"></i> Installment Summary</h6>
                                                    <div id="summary-content"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Validation Feedback -->
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div id="installment-validation" class="alert" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Services Table -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6><i class="fas fa-list"></i> Services & Charges</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="50%">Service Description</th>
                                                <th width="15%" class="text-center">Quantity</th>
                                                <th width="15%" class="text-right">Unit Price</th>
                                                <th width="15%" class="text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $counter = 1; @endphp
                                            @if($quotation->services->count() > 0)
                                                @foreach($quotation->services as $service)
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>{{ $service->name }}</td>
                                                    <td class="text-center">{{ $service->pivot->quantity }}</td>
                                                    <td class="text-right">₹{{ number_format($service->pivot->price, 2) }}</td>
                                                    <td class="text-right">
                                                        <input type="number" 
                                                               class="form-control form-control-sm text-end service-amount" 
                                                               name="service_amounts[{{ $service->id }}]" 
                                                               value="{{ number_format($service->pivot->subtotal, 2, '.', '') }}" 
                                                               min="0" 
                                                               step="0.01"
                                                               data-service-id="{{ $service->id }}"
                                                               data-quantity="{{ $service->pivot->quantity }}"
                                                               data-unit-price="{{ $service->pivot->price }}"
                                                               onchange="updateServiceAmount(this)">
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        {{ $quotation->executive_summary ?? 'Professional Services as per quotation' }}
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <tfoot class="table-secondary">
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Subtotal:</strong></td>
                                                <td class="text-right">
                                                    <input type="number" 
                                                           class="form-control form-control-sm text-end" 
                                                           id="manual_subtotal" 
                                                           name="manual_subtotal" 
                                                           value="{{ number_format($quotation->total_cost, 2, '.', '') }}" 
                                                           min="0" 
                                                           step="0.01"
                                                           onchange="updateManualTotals('subtotal')">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>GST (18%):</strong></td>
                                                <td class="text-right">
                                                    <input type="number" 
                                                           class="form-control form-control-sm text-end" 
                                                           id="manual_gst" 
                                                           name="manual_gst" 
                                                           value="{{ number_format($quotation->gst_amount, 2, '.', '') }}" 
                                                           min="0" 
                                                           step="0.01"
                                                           onchange="updateManualTotals('gst')">
                                                </td>
                                            </tr>
                                            <!-- Installments Section -->
                                            <tbody id="installments-tbody">
                                                <tr>
                                                    <td colspan="4" class="text-right">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <strong>Installment 1:</strong>
                                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeInstallmentField(this)">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="number" 
                                                               class="form-control form-control-sm text-end installment-amount" 
                                                               name="installment_amounts[]" 
                                                               placeholder="0.00" 
                                                               min="0" 
                                                               step="0.01"
                                                               onchange="updateInstallmentTotals()">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addInstallmentField()">
                                                        <i class="fas fa-plus"></i> Add Installment
                                                    </button>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr class="table-dark">
                                                <td colspan="4" class="text-right"><strong>Total Amount:</strong></td>
                                                <td class="text-right">
                                                    <input type="number" 
                                                           class="form-control form-control-sm text-end fw-bold" 
                                                           id="manual_total" 
                                                           name="manual_total" 
                                                           value="{{ number_format($quotation->final_amount, 2, '.', '') }}" 
                                                           min="0" 
                                                           step="0.01"
                                                           onchange="updateManualTotals('total')">
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Terms -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6><i class="fas fa-credit-card"></i> Payment Terms</h6>
                                <div class="form-group">
                                    <label for="payment_terms" class="form-label">Payment Terms & Conditions</label>
                                    <textarea class="form-control" id="payment_terms" name="payment_terms" rows="3" 
                                              placeholder="Enter payment terms and conditions...">Payment to be made within 15 days from invoice date. Late payment charges @ 18% per annum will be applicable.</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Privacy Policy -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6><i class="fas fa-shield-alt"></i> Privacy Policy</h6>
                                <div class="form-group">
                                    <label for="privacy_policy" class="form-label">Privacy Policy Statement</label>
                                    <textarea class="form-control" id="privacy_policy" name="privacy_policy" rows="4" 
                                              placeholder="Enter privacy policy...">We respect your privacy and are committed to protecting your personal data. This invoice and all related information are confidential and intended solely for the use of the addressee. Any unauthorized use or disclosure is prohibited. All business transactions are subject to our terms of service and privacy policy available at our website.</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6><i class="fas fa-sticky-note"></i> Additional Notes</h6>
                                <div class="form-group">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" 
                                              placeholder="Enter any additional notes...">Thank you for your business! We appreciate your trust in our services.</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Installments Container -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-list"></i> Installment Schedule
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="installments-container">
                                    <div class="text-center text-muted py-4" id="empty-installments">
                                        <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                        <p>Click "Add Installment" to create payment schedule entries</p>
                                        <small class="text-muted">You can add multiple installments with custom amounts and due dates</small>
                                    </div>
                                </div>
                                
                                <!-- Installment Summary -->
                                <div class="row mt-3" id="installment-summary" style="display: none;">
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <h6><i class="fas fa-info-circle"></i> Installment Summary</h6>
                                            <div id="summary-content"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Validation Feedback -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div id="installment-validation" class="alert" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" form="invoice-form" class="btn btn-primary btn-lg me-2" name="save_only" value="1">
                                    <i class="fas fa-save"></i> Save Invoice Details
                                </button>
                                <button type="submit" form="invoice-form" class="btn btn-success btn-lg me-2">
                                    <i class="fas fa-download"></i> Generate & Download Invoice PDF
                                </button>
                                <button type="submit" form="invoice-form" class="btn btn-warning btn-lg me-2" name="save_without_pdf" value="1">
                                    <i class="fas fa-file-alt"></i> Save Without PDF (Fallback)
                                </button>
                                <a href="{{ route('accounts.index') }}" class="btn btn-secondary btn-lg">
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

<!-- Installment Modal - Simple Version -->
<div id="installmentModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: white; padding: 20px; border-radius: 8px; max-width: 500px; width: 90%; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
            <h5 style="margin: 0;">
                <i class="fas fa-plus-circle"></i> Add Installment
            </h5>
            <button type="button" onclick="closeModal()" style="background: none; border: none; font-size: 24px; cursor: pointer;">×</button>
        </div>
        
        <form id="installment-form">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Amount *</label>
                <div style="display: flex; align-items: center;">
                    <span style="background: #e9ecef; padding: 8px; border: 1px solid #ced4da; border-radius: 4px 0 0 4px;">₹</span>
                    <input type="number" id="modal-amount" 
                           placeholder="0.00" min="0" step="0.01" required
                           style="flex: 1; padding: 8px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0;">
                </div>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Due Date *</label>
                <input type="date" id="modal-date" required
                       style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Notes</label>
                <textarea id="modal-notes" rows="2" placeholder="Optional notes for this installment"
                          style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; resize: vertical;"></textarea>
            </div>
        </form>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
            <button type="button" onclick="closeModal()" 
                    style="padding: 8px 16px; border: 1px solid #6c757d; background: #6c757d; color: white; border-radius: 4px; cursor: pointer;">
                Cancel
            </button>
            <button type="button" onclick="submitInstallment()" 
                    style="padding: 8px 16px; border: 1px solid #007bff; background: #007bff; color: white; border-radius: 4px; cursor: pointer;">
                <i class="fas fa-save"></i> Add Installment
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Debug: Check if script is loading
console.log('Invoice script loaded successfully');

// Initialize installment counter
let installmentCounter = 1;

// Test functions on page load
window.addEventListener('load', function() {
    console.log('Page fully loaded');
    console.log('Testing installment functions...');
    
    // Test add function
    if (typeof addInstallmentField === 'function') {
        console.log('✅ addInstallmentField function is available');
    } else {
        console.error('❌ addInstallmentField function is NOT available');
    }
    
    // Test remove function
    if (typeof removeInstallmentField === 'function') {
        console.log('✅ removeInstallmentField function is available');
    } else {
        console.error('❌ removeInstallmentField function is NOT available');
    }
    
    // Test update function
    if (typeof updateInstallmentTotals === 'function') {
        console.log('✅ updateInstallmentTotals function is available');
    } else {
        console.error('❌ updateInstallmentTotals function is NOT available');
    }
});

// Installment management functions
function addInstallmentField() {
    console.log('addInstallmentField called');
    installmentCounter++;
    const installmentsTbody = document.getElementById('installments-tbody');
    
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td colspan="4" class="text-right">
            <div class="d-flex justify-content-between align-items-center">
                <strong>Installment ${installmentCounter}:</strong>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeInstallmentField(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </td>
        <td class="text-right">
            <input type="number" 
                   class="form-control form-control-sm text-end installment-amount" 
                   name="installment_amounts[]" 
                   placeholder="0.00" 
                   min="0" 
                   step="0.01"
                   onchange="updateInstallmentTotals()">
            </td>
    `;
    
    installmentsTbody.appendChild(newRow);
    
    console.log('Added installment field:', installmentCounter);
}

function removeInstallmentField(button) {
    console.log('removeInstallmentField called');
    const row = button.closest('tr');
    row.remove();
    
    // Renumber remaining installments
    const installmentRows = document.querySelectorAll('#installments-tbody tr');
    installmentRows.forEach((row, index) => {
        const labelCell = row.querySelector('td:first-child strong');
        if (labelCell) {
            labelCell.textContent = `Installment ${index + 1}:`;
        }
    });
    
    installmentCounter = installmentRows.length;
    updateInstallmentTotals();
    
    console.log('Removed installment field');
}

function updateInstallmentTotals() {
    console.log('updateInstallmentTotals called');
    const installmentInputs = document.querySelectorAll('.installment-amount');
    let totalInstallments = 0;
    
    installmentInputs.forEach(input => {
        const amount = parseFloat(input.value) || 0;
        totalInstallments += amount;
    });
    
    console.log('Installment totals updated:', {
        totalInstallments: totalInstallments,
        installmentCount: installmentInputs.length
    });
    
    // Optionally validate that installments don't exceed total amount
    const totalAmount = parseFloat(document.getElementById('manual_total').value) || 0;
    if (totalInstallments > totalAmount) {
        alert('Total installments cannot exceed the total amount!');
        // Reset the last changed input
        event.target.value = '';
        return;
    }
}

// Simple modal functions - no Bootstrap dependency
function openModal() {
    console.log('Opening simple modal');
    document.getElementById('installmentModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Clear previous values
    document.getElementById('modal-amount').value = '';
    document.getElementById('modal-notes').value = '';
    
    // Set default date
    updateModalDefaultDate();
    
    // Focus on amount field
    setTimeout(() => {
        document.getElementById('modal-amount').focus();
    }, 100);
}

function closeModal() {
    console.log('Closing simple modal');
    document.getElementById('installmentModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function updateModalDefaultDate() {
    installmentCounter++;
    const nextMonth = new Date();
    nextMonth.setMonth(nextMonth.getMonth() + installmentCounter);
    const defaultDate = nextMonth.toISOString().split('T')[0];
    
    const dateInput = document.getElementById('modal-date');
    if (dateInput) {
        dateInput.value = defaultDate;
    }
}

// Open modal to add installment
function addInstallment() {
    console.log('Add Installment button clicked');
    openModal();
}

// Test modal functionality
function testModal() {
    console.log('Test Modal button clicked');
    alert('Simple Modal Test:\n\n✅ Script loaded\n✅ Modal element found\n✅ Functions defined\n\nClick "Add Installment" to test the modal!');
}

// Auto-fix installment amounts to match remaining amount
function autoFixInstallments() {
    console.log('Auto-fixing installment amounts');
    
    const amountInputs = document.querySelectorAll('input[name="installment_amounts[]"]');
    const remaining = parseFloat(document.getElementById('remaining_payment').value) || 0;
    
    if (amountInputs.length === 0) {
        alert('Please add at least one installment first.');
        return;
    }
    
    const amountPerInstallment = remaining / amountInputs.length;
    
    amountInputs.forEach((input, index) => {
        input.value = amountPerInstallment.toFixed(2);
    });
    
    // Re-validate
    validateInstallments();
    
    alert(`✅ Auto-Fix Applied!\n\nAdjusted ${amountInputs.length} installment(s) to:\n₹${amountPerInstallment.toFixed(2)} each\n\nTotal: ₹${remaining.toFixed(2)}`);
}

// Update service amount and recalculate totals
function updateServiceAmount(input) {
    const serviceId = input.dataset.serviceId;
    const newAmount = parseFloat(input.value) || 0;
    const quantity = parseFloat(input.dataset.quantity) || 1;
    const unitPrice = parseFloat(input.dataset.unitPrice) || 0;
    
    console.log('Service amount updated:', {
        serviceId: serviceId,
        newAmount: newAmount,
        quantity: quantity,
        unitPrice: unitPrice
    });
    
    // Update the display with proper formatting
    input.value = newAmount.toFixed(2);
    
    // Recalculate totals
    recalculateServiceTotals();
}

// Recalculate service totals and update payment details
function recalculateServiceTotals() {
    const serviceAmountInputs = document.querySelectorAll('.service-amount');
    let subtotal = 0;
    
    serviceAmountInputs.forEach(input => {
        const amount = parseFloat(input.value) || 0;
        subtotal += amount;
    });
    
    // Update subtotal in the table footer input
    const subtotalElement = document.getElementById('manual_subtotal');
    if (subtotalElement) {
        subtotalElement.value = subtotal.toFixed(2);
    }
    
    // Calculate GST (18%)
    const gstAmount = subtotal * 0.18;
    const gstElement = document.getElementById('manual_gst');
    if (gstElement) {
        gstElement.value = gstAmount.toFixed(2);
    }
    
    // Calculate total amount
    const totalAmount = subtotal + gstAmount;
    const totalElement = document.getElementById('manual_total');
    if (totalElement) {
        totalElement.value = totalAmount.toFixed(2);
    }
    
    // Update payment details fields
    const totalAmountField = document.getElementById('total_amount');
    const gstAmountField = document.getElementById('gst_amount');
    const totalPaymentField = document.getElementById('total_payment');
    const remainingPaymentField = document.getElementById('remaining_payment');
    
    if (totalAmountField) totalAmountField.value = totalAmount.toFixed(2);
    if (gstAmountField) gstAmountField.value = gstAmount.toFixed(2);
    if (totalPaymentField) totalPaymentField.value = totalAmount.toFixed(2);
    if (remainingPaymentField) remainingPaymentField.value = totalAmount.toFixed(2);
    
    console.log('Service totals recalculated:', {
        subtotal: subtotal,
        gst: gstAmount,
        total: totalAmount
    });
}

// Handle manual editing of totals
function updateManualTotals(field) {
    const subtotal = parseFloat(document.getElementById('manual_subtotal').value) || 0;
    const gst = parseFloat(document.getElementById('manual_gst').value) || 0;
    const total = parseFloat(document.getElementById('manual_total').value) || 0;
    
    console.log('Manual total update:', {
        field: field,
        subtotal: subtotal,
        gst: gst,
        total: total
    });
    
    switch(field) {
        case 'subtotal':
            // When subtotal is manually edited, recalculate GST and total
            const calculatedGst = subtotal * 0.18;
            const calculatedTotal = subtotal + calculatedGst;
            document.getElementById('manual_gst').value = calculatedGst.toFixed(2);
            document.getElementById('manual_total').value = calculatedTotal.toFixed(2);
            break;
            
        case 'gst':
            // When GST is manually edited, recalculate total
            const newTotal = subtotal + gst;
            document.getElementById('manual_total').value = newTotal.toFixed(2);
            break;
            
        case 'total':
            // When total is manually edited, keep subtotal and GST as is
            // Optionally validate that total >= subtotal
            if (total < subtotal) {
                alert('Total amount cannot be less than subtotal!');
                document.getElementById('manual_total').value = (subtotal + gst).toFixed(2);
                return;
            }
            break;
    }
    
    // Update payment details fields with the final values
    const finalSubtotal = parseFloat(document.getElementById('manual_subtotal').value) || 0;
    const finalGst = parseFloat(document.getElementById('manual_gst').value) || 0;
    const finalTotal = parseFloat(document.getElementById('manual_total').value) || 0;
    
    const totalAmountField = document.getElementById('total_amount');
    const gstAmountField = document.getElementById('gst_amount');
    const totalPaymentField = document.getElementById('total_payment');
    const remainingPaymentField = document.getElementById('remaining_payment');
    
    if (totalAmountField) totalAmountField.value = finalTotal.toFixed(2);
    if (gstAmountField) gstAmountField.value = finalGst.toFixed(2);
    if (totalPaymentField) totalPaymentField.value = finalTotal.toFixed(2);
    if (remainingPaymentField) remainingPaymentField.value = finalTotal.toFixed(2);
    
    console.log('Payment details updated with manual totals:', {
        finalSubtotal: finalSubtotal,
        finalGst: finalGst,
        finalTotal: finalTotal
    });
}



// Submit installment from modal
function submitInstallment() {
    console.log('Submitting installment from modal');
    try {
        // Get values from modal
        const amount = parseFloat(document.getElementById('modal-amount').value) || 0;
        const date = document.getElementById('modal-date').value;
        const notes = document.getElementById('modal-notes').value;
        
        // Validate
        if (amount <= 0) {
            alert('Please enter a valid amount greater than 0');
            return;
        }
        
        if (!date) {
            alert('Please select a due date');
            return;
        }
        
        // Add installment to schedule
        addInstallmentToSchedule(amount, date, notes);
        
    } catch (error) {
        console.error('Error adding installment:', error);
        alert('Error adding installment: ' + error.message);
    } finally {
        // Always close the modal, even if there's an error
        closeModal();
        
        // Validate after modal is closed (with error handling)
        try {
            validateInstallments();
        } catch (validationError) {
            console.error('Error in validation:', validationError);
            // Don't show alert for validation errors to avoid annoying the user
        }
    }
}

// Add installment to the schedule display
function addInstallmentToSchedule(amount, date, notes) {
    console.log('Adding installment to schedule:', { amount, date, notes });
    
    const container = document.getElementById('installments-container');
    const emptyState = document.getElementById('empty-installments');
    
    if (!container) {
        alert('Error: Installments container not found');
        return;
    }
    
    // Hide empty state
    if (emptyState) {
        emptyState.style.display = 'none';
    }
    
    // Create installment row
    const installmentRow = document.createElement('div');
    installmentRow.className = 'row mb-3 p-3 border rounded installment-row';
    installmentRow.id = `installment-row-${installmentCounter}`;
    
    // Format date for display
    const formattedDate = new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
    
    installmentRow.innerHTML = `
        <div class="col-md-2">
            <label class="form-label fw-bold">Installment ${installmentCounter}</label>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeInstallment(${installmentCounter})" title="Remove">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="col-md-3">
            <label class="form-label">Amount</label>
            <div class="form-control-plaintext">
                <strong>₹${amount.toFixed(2)}</strong>
            </div>
            <input type="hidden" name="installment_amounts[]" value="${amount}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Due Date</label>
            <div class="form-control-plaintext">
                <strong>${formattedDate}</strong>
            </div>
            <input type="hidden" name="installment_dates[]" value="${date}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Notes</label>
            <div class="form-control-plaintext">
                ${notes || '<span class="text-muted">No notes</span>'}
            </div>
            <input type="hidden" name="installment_notes[]" value="${notes}">
        </div>
        <input type="hidden" name="installment_numbers[]" value="${installmentCounter}">
    `;
    
    container.appendChild(installmentRow);
    console.log('Installment added to schedule successfully');
}

// Remove installment row
function removeInstallment(id) {
    console.log('removeInstallment called with id:', id);
    try {
        const row = document.getElementById(`installment-row-${id}`);
        if (row) {
            row.remove();
            validateInstallments();
            
            // Check if no installments left
            const remainingRows = document.querySelectorAll('.installment-row');
            if (remainingRows.length === 0) {
                const emptyState = document.getElementById('empty-installments');
                if (emptyState) {
                    emptyState.style.display = 'block';
                }
            }
        }
    } catch (error) {
        console.error('Error in removeInstallment:', error);
    }
}

// Calculate and show summary
function calculateSummary() {
    console.log('calculateSummary called');
    try {
        const amountInputs = document.querySelectorAll('input[name="installment_amounts[]"]');
        const summaryDiv = document.getElementById('installment-summary');
        const summaryContent = document.getElementById('summary-content');
        
        console.log('Amount inputs found:', amountInputs.length);
        
        if (amountInputs.length === 0) {
            alert('Please add at least one installment first');
            return;
        }
        
        let totalInstallmentAmount = 0;
        amountInputs.forEach(input => {
            totalInstallmentAmount += parseFloat(input.value) || 0;
        });
        
        const remaining = parseFloat(document.getElementById('remaining_payment').value) || 0;
        const difference = totalInstallmentAmount - remaining;
        
        console.log('Total installment amount:', totalInstallmentAmount);
        console.log('Remaining amount:', remaining);
        console.log('Difference:', difference);
        
        summaryContent.innerHTML = `
            <div class="row">
                <div class="col-md-3">
                    <strong>Total Installments:</strong> ${amountInputs.length}
                </div>
                <div class="col-md-3">
                    <strong>Total Amount:</strong> ₹${totalInstallmentAmount.toFixed(2)}
                </div>
                <div class="col-md-3">
                    <strong>Remaining Required:</strong> ₹${remaining.toFixed(2)}
                </div>
                <div class="col-md-3">
                    <strong>Difference:</strong> 
                    <span class="${Math.abs(difference) < 0.01 ? 'text-success' : 'text-warning'}">
                        ₹${Math.abs(difference).toFixed(2)}
                    </span>
                </div>
            </div>
        `;
        
        summaryDiv.style.display = 'block';
        console.log('Summary displayed');
    } catch (error) {
        console.error('Error in calculateSummary:', error);
        alert('Error calculating summary: ' + error.message);
    }
}

// Validate installments
function validateInstallments() {
    try {
        const remaining = parseFloat(document.getElementById('remaining_payment').value) || 0;
        const amountInputs = document.querySelectorAll('input[name="installment_amounts[]"]');
        const validationDiv = document.getElementById('installment-validation');
        
        // Check if validation div exists
        if (!validationDiv) {
            console.warn('installment-validation div not found');
            return true;
        }
        
        if (amountInputs.length === 0) {
            validationDiv.style.display = 'none';
            return true;
        }
        
        let totalInstallmentAmount = 0;
        amountInputs.forEach(input => {
            totalInstallmentAmount += parseFloat(input.value) || 0;
        });
        
        const difference = Math.abs(totalInstallmentAmount - remaining);
        
        // More flexible validation - allow small differences
        if (difference > 0.01) {
            validationDiv.className = 'alert alert-warning';
            validationDiv.innerHTML = `
                <i class="fas fa-exclamation-triangle"></i> 
                <strong>Amount Mismatch:</strong> Installment amounts (₹${totalInstallmentAmount.toFixed(2)}) 
                ${totalInstallmentAmount > remaining ? 'exceed' : 'are less than'} the remaining amount (₹${remaining.toFixed(2)}). 
                Difference: ₹${difference.toFixed(2)}
                <br><small>You can still submit the invoice, but consider adjusting the amounts for accuracy.</small>
            `;
            validationDiv.style.display = 'block';
            return false; // Return false to indicate warning, but don't block
        } else {
            validationDiv.className = 'alert alert-success';
            validationDiv.innerHTML = `
                <i class="fas fa-check-circle"></i> 
                <strong>Perfect!</strong> Installment amounts match the remaining amount exactly.
            `;
            validationDiv.style.display = 'block';
            return true;
        }
    } catch (error) {
        console.error('Error in validateInstallments:', error);
        // Don't re-throw the error to prevent screen from getting stuck
        return false;
    }
}

// Update payment details
function updatePaymentDetails() {
    console.log('Updating payment details');
    try {
        // All fields are now manual - no automatic calculations
        validateInstallments();
    } catch (error) {
        console.error('Error in updatePaymentDetails:', error);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Simple modal system loaded');
    updatePaymentDetails();
    
    // Add form submission validation
    const invoiceForm = document.getElementById('invoice-form');
    if (invoiceForm) {
        invoiceForm.addEventListener('submit', function(e) {
            console.log('=== FORM SUBMISSION DEBUG ===');
            
            // Debug: Log all installment data before submission
            const amountInputs = document.querySelectorAll('input[name="installment_amounts[]"]');
            const dateInputs = document.querySelectorAll('input[name="installment_dates[]"]');
            const notesInputs = document.querySelectorAll('input[name="installment_notes[]"]');
            const numberInputs = document.querySelectorAll('input[name="installment_numbers[]"]');
            
            console.log('Installment data found:');
            console.log('Amount inputs:', amountInputs.length);
            console.log('Date inputs:', dateInputs.length);
            console.log('Notes inputs:', notesInputs.length);
            console.log('Number inputs:', numberInputs.length);
            
            // Log actual values
            amountInputs.forEach((input, index) => {
                console.log(`Installment ${index + 1}:`, {
                    amount: input.value,
                    date: dateInputs[index]?.value,
                    notes: notesInputs[index]?.value,
                    number: numberInputs[index]?.value
                });
            });
            
            const installmentCount = document.querySelectorAll('.installment-row').length;
            console.log('Installment rows found:', installmentCount);
            
            if (installmentCount > 0) {
                const isValid = validateInstallments();
                
                // Allow submission but show warning if validation fails
                if (!isValid) {
                    const remaining = parseFloat(document.getElementById('remaining_payment').value) || 0;
                    let totalInstallmentAmount = 0;
                    amountInputs.forEach(input => {
                        totalInstallmentAmount += parseFloat(input.value) || 0;
                    });
                    
                    const difference = Math.abs(totalInstallmentAmount - remaining);
                    
                    // Show confirmation dialog instead of blocking
                    const confirmMessage = `Installment amounts (₹${totalInstallmentAmount.toFixed(2)}) don't exactly match the remaining amount (₹${remaining.toFixed(2)}).\n\nDifference: ₹${difference.toFixed(2)}\n\nDo you want to proceed anyway?`;
                    
                    if (!confirm(confirmMessage)) {
                        e.preventDefault();
                        return false;
                    }
                }
                
                console.log('✅ Installments will be submitted with the form');
            } else {
                console.log('ℹ️ No installments to submit');
            }
        });
    }
});
</script>
@endpush
