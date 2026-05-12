@extends('layouts.app')

@section('title', 'Payment Installment Plan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-credit-card"></i> Payment Installment Plan
                        <small class="text-muted">for Quotation #{{ $quotation->id }}</small>
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Quotation Summary -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h5><i class="fas fa-info-circle"></i> Quotation Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Project:</strong> {{ $quotation->project_title ?? 'N/A' }}<br>
                                        <strong>Client:</strong> {{ $quotation->client_contact_name ?? 'N/A' }}<br>
                                        <strong>Email:</strong> {{ $quotation->client_email ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Total Amount:</strong> ₹{{ number_format($quotation->final_amount, 2) }}<br>
                                        <strong>GST Amount:</strong> ₹{{ number_format($quotation->gst_amount ?? 0, 2) }}<br>
                                        <strong>Final Amount:</strong> ₹{{ number_format($quotation->final_amount, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Plan Form -->
                    <form id="payment-plan-form" method="POST" action="{{ route('accounts.confirm-payment-plan', $quotation->id) }}">
                        @csrf
                        
                        <!-- Payment Summary -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5><i class="fas fa-calculator"></i> Payment Summary</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Total Amount</label>
                                                <input type="number" class="form-control bg-white" id="total_amount" name="total_amount" 
                                                       value="{{ $quotation->final_amount }}" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Advance Payment</label>
                                                <input type="number" class="form-control" id="advance_payment" name="advance_payment" 
                                                       placeholder="0.00" min="0" step="0.01" value="0" onchange="updateRemaining()">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Remaining Amount</label>
                                                <input type="number" class="form-control bg-white" id="remaining_amount" name="remaining_amount" 
                                                       value="{{ $quotation->final_amount }}" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Advance Payment Date</label>
                                                <input type="date" class="form-control" id="advance_payment_date" name="advance_payment_date" 
                                                       value="{{ now()->format('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Installment Controls -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <h5><i class="fas fa-calendar-alt"></i> Installment Schedule</h5>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Payment Schedule</label>
                                                <div class="btn-group w-100" role="group">
                                                    <button type="button" class="btn btn-outline-primary" onclick="addInstallment()">
                                                        <i class="fas fa-plus"></i> Add Installment
                                                    </button>
                                                    <button type="button" class="btn btn-outline-info" onclick="calculateSummary()">
                                                        <i class="fas fa-calculator"></i> Calculate Summary
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-success w-100" onclick="testSystem()">
                                                    <i class="fas fa-check"></i> Test System
                                                </button>
                                            </div>
                                        </div>
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

                        <!-- Client Information (Hidden fields for form submission) -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5><i class="fas fa-user"></i> Client Information</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Client Name *</label>
                                                <input type="text" class="form-control" name="client_name" 
                                                       value="{{ $quotation->client_contact_name ?? '' }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Client Email *</label>
                                                <input type="email" class="form-control" name="client_email" 
                                                       value="{{ $quotation->client_email ?? '' }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Client Phone *</label>
                                                <input type="text" class="form-control" name="client_phone" 
                                                       value="{{ $quotation->client_phone ?? '' }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Client Business</label>
                                                <input type="text" class="form-control" name="client_business" 
                                                       value="{{ $quotation->client_business_name ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Invoice Date *</label>
                                                <input type="date" class="form-control" name="invoice_date" 
                                                       value="{{ now()->format('Y-m-d') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Payment Status</label>
                                                <select class="form-control" name="payment_status">
                                                    <option value="pending">Pending</option>
                                                    <option value="partial">Partial</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg me-2" id="confirm-btn">
                                    <i class="fas fa-check"></i> Confirm Payment Plan
                                </button>
                                <button type="button" class="btn btn-secondary btn-lg me-2" onclick="window.close()">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Installment Modal -->
<div class="modal fade" id="installmentModal" tabindex="-1" aria-labelledby="installmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="installmentModalLabel">
                    <i class="fas fa-plus-circle"></i> Add Installment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="installment-form">
                    <div class="mb-3">
                        <label for="modal-amount" class="form-label">Amount *</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" id="modal-amount" 
                                   placeholder="0.00" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="modal-date" class="form-label">Due Date *</label>
                        <input type="date" class="form-control" id="modal-date" required>
                    </div>
                    <div class="mb-3">
                        <label for="modal-notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="modal-notes" rows="2" 
                                  placeholder="Optional notes for this installment"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitInstallment()">
                    <i class="fas fa-save"></i> Add Installment
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Debug: Check if script is loading
console.log('Modal installment payment plan script loaded successfully');

let installmentCounter = 0;
let installmentModal;

// Initialize modal when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing payment plan modal system');
    
    // Initialize Bootstrap modal
    const modalElement = document.getElementById('installmentModal');
    if (modalElement) {
        installmentModal = new bootstrap.Modal(modalElement);
        console.log('Payment plan modal initialized successfully');
    }
    
    // Set default date in modal
    updateModalDefaultDate();
    
    // Initialize remaining amount
    updateRemaining();
});

// Update remaining amount
function updateRemaining() {
    console.log('Updating remaining amount');
    try {
        const total = parseFloat(document.getElementById('total_amount').value) || 0;
        const advance = parseFloat(document.getElementById('advance_payment').value) || 0;
        const remaining = total - advance;
        
        document.getElementById('remaining_amount').value = remaining.toFixed(2);
        validateInstallments();
    } catch (error) {
        console.error('Error in updateRemaining:', error);
    }
}

// Open modal to add installment
function addInstallment() {
    console.log('Opening payment plan installment modal');
    try {
        // Clear previous values
        document.getElementById('modal-amount').value = '';
        document.getElementById('modal-notes').value = '';
        
        // Set default date
        updateModalDefaultDate();
        
        // Open modal
        if (installmentModal) {
            installmentModal.show();
        } else {
            // Fallback if Bootstrap modal not available
            $('#installmentModal').modal('show');
        }
        
        // Focus on amount field
        setTimeout(() => {
            document.getElementById('modal-amount').focus();
        }, 500);
        
    } catch (error) {
        console.error('Error opening payment plan modal:', error);
        alert('Error opening installment modal: ' + error.message);
    }
}

// Update modal default date
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

// Submit installment from modal
function submitInstallment() {
    console.log('Submitting installment from payment plan modal');
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
        
        // Close modal
        if (installmentModal) {
            installmentModal.hide();
        } else {
            $('#installmentModal').modal('hide');
        }
        
        // Validate
        validateInstallments();
        
    } catch (error) {
        console.error('Error submitting payment plan installment:', error);
        alert('Error submitting installment: ' + error.message);
    }
}

// Add installment to the schedule display
function addInstallmentToSchedule(amount, date, notes) {
    console.log('Adding installment to payment plan schedule:', { amount, date, notes });
    
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
    console.log('Payment plan installment added to schedule successfully');
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
        
        const remaining = parseFloat(document.getElementById('remaining_amount').value) || 0;
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
        console.log('Payment plan summary displayed');
    } catch (error) {
        console.error('Error in calculateSummary:', error);
        alert('Error calculating summary: ' + error.message);
    }
}

// Validate installments
function validateInstallments() {
    try {
        const remaining = parseFloat(document.getElementById('remaining_amount').value) || 0;
        const amountInputs = document.querySelectorAll('input[name="installment_amounts[]"]');
        const validationDiv = document.getElementById('installment-validation');
        
        if (amountInputs.length === 0) {
            validationDiv.style.display = 'none';
            return true;
        }
        
        let totalInstallmentAmount = 0;
        amountInputs.forEach(input => {
            totalInstallmentAmount += parseFloat(input.value) || 0;
        });
        
        const difference = Math.abs(totalInstallmentAmount - remaining);
        
        if (difference > 0.01) {
            validationDiv.className = 'alert alert-warning';
            validationDiv.innerHTML = `
                <i class="fas fa-exclamation-triangle"></i> 
                <strong>Attention:</strong> Installment amounts (₹${totalInstallmentAmount.toFixed(2)}) 
                ${totalInstallmentAmount > remaining ? 'exceed' : 'are less than'} the remaining amount (₹${remaining.toFixed(2)}). 
                Difference: ₹${difference.toFixed(2)}
                <br><small>Adjust installment amounts to match the remaining amount exactly.</small>
            `;
            validationDiv.style.display = 'block';
            return false;
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
        return false;
    }
}

// Test system
function testSystem() {
    console.log('Testing modal payment plan installment system');
    
    const total = document.getElementById('total_amount');
    const advance = document.getElementById('advance_payment');
    const remaining = document.getElementById('remaining_amount');
    
    if (!total || !advance || !remaining) {
        alert('❌ Some elements are missing');
        return;
    }
    
    const totalVal = parseFloat(total.value) || 0;
    const advanceVal = parseFloat(advance.value) || 0;
    const remainingVal = totalVal - advanceVal;
    const installmentCount = document.querySelectorAll('.installment-row').length;
    
    alert(`✅ Modal Payment Plan Installment System Test:\n\n` +
          `Total Amount: ₹${totalVal.toFixed(2)}\n` +
          `Advance Payment: ₹${advanceVal.toFixed(2)}\n` +
          `Remaining Amount: ₹${remainingVal.toFixed(2)}\n` +
          `Current Installments: ${installmentCount}\n\n` +
          `✅ Modal payment plan system is working!`);
}

// Form submission
document.getElementById('payment-plan-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate installments before submission
    if (!validateInstallments()) {
        alert('Please fix installment validation errors before submitting.');
        return;
    }
    
    const formData = new FormData(this);
    const submitBtn = document.getElementById('confirm-btn');
    
    // Disable button and show loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`✅ ${data.message}\n\nInvoice Number: ${data.invoice_number}\nInvoice ID: ${data.invoice_id}`);
            
            // Close window after successful submission
            setTimeout(() => {
                window.close();
                // If window doesn't close, redirect to parent
                if (!window.closed) {
                    window.opener.location.href = '/invoices';
                }
            }, 2000);
        } else {
            alert(`❌ Error: ${data.message}`);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ An error occurred while processing the payment plan.');
    })
    .finally(() => {
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-check"></i> Confirm Payment Plan';
    });
});
</script>
@endsection
