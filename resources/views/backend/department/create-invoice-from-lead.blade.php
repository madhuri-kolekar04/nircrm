@extends('admin.admin_master')

@section('page-title', 'Create Invoice from Lead')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-invoice"></i> Create Invoice - {{ $lead->name }}
                    </h5>
                    <div>
                        <button type="submit" form="invoice-form" class="btn btn-primary me-2" name="save_only" value="1" onclick="showLoading(this)">
                            <i class="fas fa-save"></i> Save Invoice Details
                        </button>
                        <a href="{{ route('sales.department') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Sales Department
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

                    <!-- Lead Information Display -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Lead Information</h6>
                                <div class="row">
                                    <div class="col-md-3"><strong>Name:</strong> {{ $lead->name }}</div>
                                    <div class="col-md-3"><strong>Email:</strong> {{ $lead->email }}</div>
                                    <div class="col-md-3"><strong>Phone:</strong> {{ $lead->phone }}</div>
                                    <div class="col-md-3"><strong>Company:</strong> {{ $lead->company_name ?? 'N/A' }}</div>
                                </div>
                                @if($lead->budget)
                                <div class="row mt-2">
                                    <div class="col-md-3"><strong>Budget:</strong> ${{ number_format($lead->budget, 2) }}</div>
                                    <div class="col-md-3"><strong>Priority:</strong> {{ ucfirst($lead->priority) }}</div>
                                    <div class="col-md-6"><strong>Address:</strong> {{ $lead->address ?? 'N/A' }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('sales.department.save-invoice', $lead->id) }}" method="POST" id="invoice-form">
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
                                            <td><strong>Lead Ref:</strong></td>
                                            <td>{{ $lead->name }} (ID: {{ $lead->id }})</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Status:</strong></td>
                                            <td>
                                                <select class="form-select form-select-sm" name="payment_status">
                                                    <option value="pending">Pending</option>
                                                    <option value="partial">Partial</option>
                                                    <option value="completed">Completed</option>
                                                    <option value="overdue">Overdue</option>
                                                    <option value="cancelled">Cancelled</option>
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
                                                       value="{{ $lead->name }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Business:</strong></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="client_business" 
                                                       value="{{ $lead->company_name ?? '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>
                                                <input type="email" class="form-control form-control-sm" name="client_email" 
                                                       value="{{ $lead->email }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="client_phone" 
                                                       value="{{ $lead->phone }}">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Banking Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6><i class="fas fa-university"></i> Banking Information</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bank_account_number" class="form-label">Bank Account Number</label>
                                            <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" 
                                                   placeholder="Enter Bank Account Number" maxlength="20">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="ifsc_code" class="form-label">IFSC Code</label>
                                            <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" 
                                                   placeholder="Enter IFSC Code" maxlength="11">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="mobile_bank_number" class="form-label">Mobile Bank Linked Number</label>
                                            <input type="text" class="form-control" id="mobile_bank_number" name="mobile_bank_number" 
                                                   placeholder="Enter Mobile Number" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="company_pan" class="form-label">Company PAN (Optional)</label>
                                            <input type="text" class="form-control" id="company_pan" name="company_pan" 
                                                   placeholder="Enter Company PAN" maxlength="10">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- GST Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6><i class="fas fa-receipt"></i> GST Information</h6>
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
                                            <label for="place_of_supply" class="form-label">Place of Supply</label>
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
                                <h6><i class="fas fa-credit-card"></i> Payment Installment Plan</h6>
                                
                                <!-- Quotation Information -->
                                @if($latestQuotation)
                                <div class="alert alert-success mb-3">
                                    <h6><i class="fas fa-check-circle"></i> Latest Approved Quotation Found</h6>
                                    <div class="row">
                                        <div class="col-md-4"><strong>Quotation Number:</strong> {{ $latestQuotation->quotation_number }}</div>
                                        <div class="col-md-4"><strong>Final Amount:</strong> ${{ number_format($latestQuotation->final_amount, 2) }}</div>
                                        <div class="col-md-4"><strong>Approved Date:</strong> {{ $latestQuotation->approved_at ? $latestQuotation->approved_at->format('M d, Y') : 'N/A' }}</div>
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Simple Payment Summary -->
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Total Amount</label>
                                                <input type="number" class="form-control bg-white" id="total_amount" name="total_amount" 
                                                       value="{{ $totalAmount }}" step="0.01" min="0" onchange="updateGSTAndRemaining()">
                                                <small class="text-muted">Fetched from quotation final amount or lead budget</small>
                                                <input type="hidden" name="total_amount_backup" value="{{ $totalAmount }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Advance Payment</label>
                                                <input type="number" class="form-control" id="advance_payment" name="advance_payment" 
                                                       placeholder="0.00" min="0" step="0.01" value="0" onchange="updateRemaining()">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Remaining Amount</label>
                                                <input type="number" class="form-control bg-white" id="remaining_amount" name="remaining_amount" 
                                                       value="{{ $totalAmount }}" readonly>
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
                                @if($latestQuotation)
                                <div class="alert alert-info mb-3">
                                    <strong>Services from Quotation:</strong> {{ $latestQuotation->quotation_number }}
                                </div>
                                @endif
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
                                            @php $counter = 1;
                                             @endphp
                                            @if($latestQuotation && $latestQuotation->services->count() > 0)
                                                @foreach($latestQuotation->services as $service)
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>{{ $service->name }}</td>
                                                    <td class="text-center">{{ $service->pivot->quantity }}</td>
                                                    <td class="text-right">${{ number_format($service->pivot->price, 2) }}</td>
                                                    <td class="text-right">${{ number_format($service->pivot->subtotal, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>{{ $lead->description ?? 'Professional Services as per lead requirements' }}</td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-right">${{ number_format($totalAmount, 2) }}</td>
                                                    <td class="text-right">${{ number_format($totalAmount, 2) }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <tfoot class="table-secondary">
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Subtotal:</strong></td>
                                                <td class="text-right" id="subtotal-amount">₹{{ number_format((float)$subtotalAmount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>GST (18%):</strong></td>
                                                <td class="text-right" id="gst-amount"> ₹{{ number_format((float)$gstAmount, 2) }}</td>
                                            </tr>
                                            <tr class="table-dark">
                                                <td colspan="4" class="text-right"><strong>Total Amount:</strong></td>
                                                <td class="text-right" id="total-amount-display"><strong>₹{{ number_format((float)$totalAmount, 2) }}</strong></td>
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

                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" form="invoice-form" class="btn btn-primary btn-lg me-2" name="save_only" value="1" onclick="showLoading(this)">
                                    <i class="fas fa-save"></i> Save Invoice Details
                                </button>
                                <button type="submit" form="invoice-form" class="btn btn-success btn-lg me-2" onclick="showLoading(this)">
                                    <i class="fas fa-download"></i> Generate & Download Invoice PDF
                                </button>
                                <button type="submit" form="invoice-form" class="btn btn-warning btn-lg me-2" name="save_without_pdf" value="1" onclick="showLoading(this)">
                                    <i class="fas fa-file-alt"></i> Save Without PDF (Fallback)
                                </button>
                                <a href="{{ route('sales.department') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                        
                        <!-- Loading Indicator -->
                        <div id="loading-indicator" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center;">
                            <div style="background: white; padding: 30px; border-radius: 8px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
                                <div class="spinner-border text-primary mb-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <h5 id="loading-text">Creating Invoice...</h5>
                                <p class="text-muted mb-0">Please wait while we process your invoice and send approval email.</p>
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
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Amount</label>
                <div style="display: flex; align-items: center;">
                    <span style="background: #e9ecef; padding: 8px; border: 1px solid #ced4da; border-radius: 4px 0 0 4px;">₹</span>
                    <input type="number" id="modal-amount" 
                           placeholder="0.00" min="0" step="0.01"
                           style="flex: 1; padding: 8px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0;">
                </div>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Due Date</label>
                <input type="date" id="modal-date"
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

@push('scripts')
<script>
// Debug: Check if script is loading
console.log('Lead invoice modal script loaded successfully');

let installmentCounter = 0;
let installments = [];

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
    const remaining = parseFloat(document.getElementById('remaining_amount').value) || 0;
    
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
        console.error('Error submitting installment:', error);
        alert('Error adding installment. Please try again.');
    }
}

// Add installment to schedule
function addInstallmentToSchedule(amount, date, notes) {
    const installmentId = Date.now();
    installments.push({
        id: installmentId,
        amount: amount,
        date: date,
        notes: notes
    });
    
    // Create installment row
    const installmentRow = document.createElement('div');
    installmentRow.className = 'row mb-2 align-items-center';
    installmentRow.id = `installment-${installmentId}`;
    
    installmentRow.innerHTML = `
        <div class="col-md-4">
            <input type="number" name="installment_amounts[]" value="${amount.toFixed(2)}" 
                   class="form-control" readonly>
        </div>
        <div class="col-md-4">
            <input type="date" name="installment_dates[]" value="${date}" 
                   class="form-control" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" name="installment_notes[]" value="${notes}" 
                   class="form-control" readonly>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeInstallment(${installmentId})">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    
    // Add to container
    const container = document.getElementById('installments-container');
    if (document.getElementById('empty-installments')) {
        document.getElementById('empty-installments').style.display = 'none';
    }
    
    container.appendChild(installmentRow);
    
    // Close modal
    closeModal();
    
    // Validate and update summary
    validateInstallments();
    calculateSummary();
    
    console.log('Installment added successfully:', { amount, date, notes });
}

// Remove installment
function removeInstallment(installmentId) {
    if (confirm('Are you sure you want to remove this installment?')) {
        // Remove from array
        installments = installments.filter(i => i.id !== installmentId);
        
        // Remove from DOM
        const element = document.getElementById(`installment-${installmentId}`);
        if (element) {
            element.remove();
        }
        
        // Show empty message if no installments
        if (installments.length === 0) {
            document.getElementById('empty-installments').style.display = 'block';
        }
        
        // Recalculate
        validateInstallments();
        calculateSummary();
    }
}

// Update remaining amount when advance payment changes
function updateRemaining() {
    const total = parseFloat(document.getElementById('total_amount').value) || 0;
    const advance = parseFloat(document.getElementById('advance_payment').value) || 0;
    const remaining = Math.max(0, total - advance);
    
    document.getElementById('remaining_amount').value = remaining.toFixed(2);
    
    // Re-validate installments
    validateInstallments();
}

// Update GST and remaining when total amount changes
// function updateGSTAndRemaining() {
//     const total = parseFloat(document.getElementById('total_amount').value) || 0;
//     const advance = parseFloat(document.getElementById('advance_payment').value) || 0;
//     const remaining = Math.max(0, total - advance);
    
//     // Update remaining amount
//     document.getElementById('remaining_amount').value = remaining.toFixed(2);
    
//     // Update GST calculations in services table
//     const gstAmount = total * 0.18;
//     const totalWithGST = total * 1.18;
    
//     // Update services table if elements exist
//     const subtotalElement = document.getElementById('subtotal-amount');
//     const gstElement = document.getElementById('gst-amount');
//     const totalDisplayElement = document.getElementById('total-amount-display');
    
//     if (subtotalElement) subtotalElement.textContent = '$' + total.toFixed(2);
//     if (gstElement) gstElement.textContent = '$' + gstAmount.toFixed(2);
//     if (totalDisplayElement) totalDisplayElement.innerHTML = '<strong>$' + totalWithGST.toFixed(2) + '</strong>';
    
//     // Re-validate installments
//     validateInstallments();
// }


function updateGSTAndRemaining() {
    const total = parseFloat(document.getElementById('total_amount').value) || 0;
    const advance = parseFloat(document.getElementById('advance_payment').value) || 0;
    const remaining = Math.max(0, total - advance);

    document.getElementById('remaining_amount').value = remaining.toFixed(2);


    validateInstallments();
}

// Validate installments
function validateInstallments() {
    const total = parseFloat(document.getElementById('total_amount').value) || 0;
    const advance = parseFloat(document.getElementById('advance_payment').value) || 0;
    const remaining = total - advance;
    
    const validationDiv = document.getElementById('installment-validation');
    const summaryDiv = document.getElementById('installment-summary');
    
    if (installments.length === 0) {
        validationDiv.style.display = 'none';
        summaryDiv.style.display = 'none';
        return;
    }
    
    const installmentTotal = installments.reduce((sum, i) => sum + i.amount, 0);
    const difference = Math.abs(installmentTotal - remaining);
    const tolerance = 0.01; // Small tolerance for floating point math
    
    if (difference <= tolerance) {
        validationDiv.className = 'alert alert-success';
        validationDiv.innerHTML = '<i class="fas fa-check-circle"></i> Installments match remaining amount perfectly!';
        validationDiv.style.display = 'block';
    } else {
        validationDiv.className = 'alert alert-warning';
        validationDiv.innerHTML = `<i class="fas fa-exclamation-triangle"></i> Installment total (₹${installmentTotal.toFixed(2)}) doesn't match remaining amount (₹${remaining.toFixed(2)}). Difference: ₹${difference.toFixed(2)}`;
        validationDiv.style.display = 'block';
    }
}

// Calculate summary
function calculateSummary() {
    const total = parseFloat(document.getElementById('total_amount').value) || 0;
    const advance = parseFloat(document.getElementById('advance_payment').value) || 0;
    const remaining = total - advance;
    
    const summaryDiv = document.getElementById('installment-summary');
    const summaryContent = document.getElementById('summary-content');
    
    if (installments.length === 0) {
        summaryDiv.style.display = 'none';
        return;
    }
    
    const installmentTotal = installments.reduce((sum, i) => sum + i.amount, 0);
    
    summaryContent.innerHTML = `
        <div class="row">
            <div class="col-md-6"><strong>Total Amount:</strong></div>
            <div class="col-md-6">₹${total.toFixed(2)}</div>
        </div>
        <div class="row">
            <div class="col-md-6"><strong>Advance Payment:</strong></div>
            <div class="col-md-6">₹${advance.toFixed(2)}</div>
        </div>
        <div class="row">
            <div class="col-md-6"><strong>Remaining Amount:</strong></div>
            <div class="col-md-6">₹${remaining.toFixed(2)}</div>
        </div>
        <div class="row">
            <div class="col-md-6"><strong>Number of Installments:</strong></div>
            <div class="col-md-6">${installments.length}</div>
        </div>
        <div class="row">
            <div class="col-md-6"><strong>Installment Total:</strong></div>
            <div class="col-md-6">₹${installmentTotal.toFixed(2)}</div>
        </div>
    `;
    
    summaryDiv.style.display = 'block';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Lead invoice form loaded');
    
    // Always update calculations on page load, even if total amount is 0
    updateGSTAndRemaining();
});

// Show loading indicator when form is submitted
function showLoading(button) {
    console.log('🚀 showLoading called for button:', button.name);
    console.log('📋 Form data before submission:');
    
    const form = document.getElementById('invoice-form');
    const formData = new FormData(form);
    
    // Log all form data
    for (let [key, value] of formData.entries()) {
        console.log(`   ${key}: ${value}`);
    }
    
    const loadingIndicator = document.getElementById('loading-indicator');
    const loadingText = document.getElementById('loading-text');
    
    // Update loading text based on button clicked
    if (button.name === 'save_only') {
        loadingText.textContent = 'Saving Invoice Details...';
    } else if (button.name === 'save_without_pdf') {
        loadingText.textContent = 'Saving Invoice (No PDF)...';
    } else {
        loadingText.textContent = 'Generating Invoice & PDF...';
    }
    
    // Show loading indicator
    loadingIndicator.style.display = 'flex';
    
    // Disable all buttons
    const buttons = form.querySelectorAll('button[type="submit"]');
    buttons.forEach(btn => {
        btn.disabled = true;
        btn.style.opacity = '0.6';
    });
    
    // Submit the form after a short delay to ensure loading shows
    setTimeout(() => {
        console.log('📤 Submitting form to:', form.action);
        console.log('📤 Form method:', form.method);
        form.submit();
    }, 500);
    
    return false; // Prevent default submission to allow our delay
}
</script>
@endpush
@endsection
