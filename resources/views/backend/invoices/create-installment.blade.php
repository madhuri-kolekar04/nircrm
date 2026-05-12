@extends('admin.admin_master')

@section('page-title', 'Create Installment Invoice - ' . ($invoiceNumber ?? 'Unknown'))

@section('title', 'Create Installment Invoice - ' . ($invoiceNumber ?? 'Unknown'))

@push('styles')
<style>
.content-area {
    padding-right: 50px !important;
    padding-left: 50px !important;
    overflow-x: hidden;
}

.container-fluid {
    padding-right: -50px;
    padding-left: -25px;
}

.card {
    margin-right: 10px;
    margin-left: 10px;
}

.table-responsive {
    overflow-x: auto;
    max-width: 100%;
}

/* Fix for scrollbar visibility */
::-webkit-scrollbar {
    width: 12px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 6px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
@endpush

@section('admin')
<!-- Main Content Area -->
<div class="content-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-gradient-success text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-file-invoice-dollar"></i> Create Installment Invoice
                                </h5>
                                <p class="mb-0 mt-1">Quotation: {{ $quotation->quotation_number }} | Client: {{ $quotation->client_contact_name }}</p>
                            </div>
                            <div>
                                <a href="{{ route('invoices.management', $quotation->id) }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to Invoice Management
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Error Messages -->
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Success Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Quotation Summary -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6><i class="fas fa-building"></i> Quotation Details</h6>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5>{{ $quotation->quotation_number }}</h5>
                                        <p class="mb-1"><strong>Client Business:</strong> {{ $quotation->client_business_name }}</p>
                                        <p class="mb-1"><strong>Contact Person:</strong> {{ $quotation->client_contact_name }}</p>
                                        <p class="mb-1"><strong>Email:</strong> {{ $quotation->client_email }}</p>
                                        <p class="mb-0"><strong>Phone:</strong> {{ $quotation->client_phone }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-rupee-sign"></i> Financial Details</h6>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5>Installment {{ $installmentLetter }}</h5>
                                        <p class="mb-1"><strong>Invoice Number:</strong> {{ $invoiceNumber }}</p>
                                        <p class="mb-1"><strong>Total Amount:</strong> ₹{{ number_format($quotation->final_amount, 2) }}</p>
                                        <p class="mb-1"><strong>GST (18%):</strong> ₹{{ number_format($quotation->gst_amount, 2) }}</p>
                                        <p class="mb-0"><strong>Status:</strong> {{ $quotation->status }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Create Installment Form -->
                        <form action="{{ route('invoices.save-installment', [$quotation->id, $installmentLetter]) }}" method="POST" id="installment-form">
                            @csrf
                            
                            <!-- Invoice Information -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-info-circle"></i> Invoice Information</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <tr>
                                                <td><strong>Invoice Number:</strong></td>
                                                <td>{{ $invoiceNumber }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Invoice Date:</strong></td>
                                                <td>
                                                    <input type="date" class="form-control form-control-sm" name="invoice_date" 
                                                           value="{{ now()->format('Y-m-d') }}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Installment Letter:</strong></td>
                                                <td><span class="badge bg-primary">{{ $installmentLetter }}</span></td>
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
                                                           value="{{ $quotation->client_contact_name }}" required>
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
                                                           value="{{ $quotation->client_email }}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Phone:</strong></td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="client_phone" 
                                                           value="{{ $quotation->client_phone }}" required>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Breakdown Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6><i class="fas fa-calculator"></i> Payment Breakdown</h6>
                                    <div class="card bg-gradient-light">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="advance_payment" class="form-label">Advance Payment</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">₹</span>
                                                            <input type="number" class="form-control" id="advance_payment" name="advance_payment" 
                                                                   value="{{ $lastInvoice ? $lastInvoice->advance_payment : 0 }}" 
                                                                   step="0.01" min="0" onchange="calculateRemainingPayment()">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="remaining_payment" class="form-label">Remaining Payment</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">₹</span>
                                                            <input type="number" class="form-control bg-white" id="remaining_payment" name="remaining_payment" 
                                                                   value="{{ ($quotation->final_amount - ($lastInvoice ? $lastInvoice->advance_payment : 0)) }}" 
                                                                   step="0.01" min="0" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="gst_amount" class="form-label">GST (18%)</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">₹</span>
                                                            <input type="number" class="form-control bg-white" id="gst_amount" name="gst_amount" 
                                                                   value="{{ $quotation->gst_amount }}" 
                                                                   step="0.01" min="0" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="total_amount_display" class="form-label">Total Amount</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">₹</span>
                                                            <input type="number" class="form-control bg-white border-success" id="total_amount_display" name="total_amount_display" 
                                                                   value="{{ $quotation->final_amount }}" 
                                                                   step="0.01" min="0" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Existing Installments Section -->
                            @if($existingInvoices && $existingInvoices->count() > 0)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6><i class="fas fa-history"></i> Existing Installments</h6>
                                    <div class="card bg-gradient-light">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th width="15%">Invoice Number</th>
                                                            <th width="15%">Installment</th>
                                                            <th width="15%">Date</th>
                                                            <th width="15%">Amount</th>
                                                            <th width="10%">Status</th>
                                                            <th width="15%">Due Date</th>
                                                            <th width="15%">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($existingInvoices as $invoice)
                                                            @php
                                                                // Get all installments for this invoice
                                                                $allInstallments = [];
                                                                
                                                                if ($invoice->installments) {
                                                                    try {
                                                                        if (is_string($invoice->installments)) {
                                                                            $decoded = json_decode($invoice->installments, true);
                                                                            if (json_last_error() === JSON_ERROR_NONE) {
                                                                                if (isset($decoded[0]) && is_array($decoded[0])) {
                                                                                    // Array of installments
                                                                                    $allInstallments = $decoded;
                                                                                } elseif (isset($decoded['amount'])) {
                                                                                    // Single installment object
                                                                                    $allInstallments = [$decoded];
                                                                                }
                                                                            }
                                                                        } elseif (is_array($invoice->installments)) {
                                                                            if (isset($invoice->installments[0]) && is_array($invoice->installments[0])) {
                                                                                // Array of installments
                                                                                $allInstallments = $invoice->installments;
                                                                            } elseif (isset($invoice->installments['amount'])) {
                                                                                // Single installment object
                                                                                $allInstallments = [$invoice->installments];
                                                                            }
                                                                        }
                                                                    } catch (Exception $e) {
                                                                        $allInstallments = [];
                                                                    }
                                                                }
                                                                
                                                                // If no installments found, create a default one
                                                                if (empty($allInstallments)) {
                                                                    $allInstallments = [[
                                                                        'amount' => $invoice->total_payment,
                                                                        'installment_number' => 1,
                                                                        'due_date' => $invoice->end_date,
                                                                        'status' => $invoice->status
                                                                    ]];
                                                                }
                                                            @endphp
                                                            
                                                            @foreach($allInstallments as $index => $installment)
                                                            <tr>
                                                                <td><strong>{{ $invoice->invoice_number }}</strong></td>
                                                                <td>
                                                                    @php
                                                                        // Get installment letter/number
                                                                        $installmentLabel = 'Installment ' . ($installment['installment_number'] ?? ($index + 1));
                                                                        
                                                                        // Try to get letter from invoice number
                                                                        if ($invoice->invoice_number && preg_match('/-([A-Z])$/', $invoice->invoice_number, $matches)) {
                                                                            $installmentLabel = $matches[1];
                                                                        } elseif (isset($installment['installment_letter'])) {
                                                                            $installmentLabel = $installment['installment_letter'];
                                                                        }
                                                                    @endphp
                                                                    
                                                                    <div>
                                                                        <span class="badge bg-primary">{{ $installmentLabel }}</span>
                                                                        <div class="text-success fw-bold mt-1">₹{{ number_format($installment['amount'] ?? 0, 2) }}</div>
                                                                    </div>
                                                                </td>
                                                                <td>{{ $invoice->invoice_date }}</td>
                                                                <td class="text-right fw-bold">₹{{ number_format($installment['amount'] ?? 0, 2) }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ ($installment['status'] ?? $invoice->status) == 'completed' ? 'success' : (($installment['status'] ?? $invoice->status) == 'pending' ? 'warning' : 'danger') }}">
                                                                        {{ ucfirst($installment['status'] ?? $invoice->status) }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $installment['due_date'] ?? $invoice->end_date ?? 'Not set' }}</td>
                                                                <td>
                                                                    <a href="{{ route('invoices.view', $invoice->id) }}" class="btn btn-sm btn-outline-info" target="_blank">
                                                                        <i class="fas fa-eye"></i> View
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        @endforeach
                                                    </tbody>
                                                                                                    </table>
                                            </div>
                                            
                                            <!-- Installment Summary -->
                                            <div class="alert alert-info mt-3">
                                                <h6><i class="fas fa-info-circle"></i> Installment Summary</h6>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <strong>Total Installments:</strong> {{ $existingInvoices->count() }}
                                                    </div>
                                                    <div class="col-md-3">
                                                        <strong>Total Quotation Amount:</strong> ₹{{ number_format($quotation->final_amount, 2) }}
                                                    </div>
                                                    <div class="col-md-3">
                                                        <strong>Already Paid:</strong> ₹{{ number_format($existingInvoices->where('status', 'completed')->sum('total_payment'), 2) }}
                                                    </div>
                                                    <div class="col-md-3">
                                                        <strong>Remaining Balance:</strong> ₹{{ number_format($quotation->final_amount - $existingInvoices->where('status', 'completed')->sum('total_payment'), 2) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Installment Schedule Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6><i class="fas fa-calendar-check"></i> Create New Installment</h6>
                                    <div class="card bg-gradient-light">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="installment_number" class="form-label">Installment Number</label>
                                                        <input type="text" class="form-control" id="installment_number" name="installment_number" 
                                                               value="Installment {{ $installmentLetter }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="installment_amount" class="form-label">Installment Amount</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">₹</span>
                                                            <input type="number" class="form-control" id="installment_amount" name="total_amount" 
                                                                   value="{{ ($quotation->final_amount - ($lastInvoice ? $lastInvoice->advance_payment : 0)) }}" 
                                                                   step="0.01" min="0" required>
                                                        </div>
                                                        <small class="text-muted">Amount for this installment</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="installment_due_date" class="form-label">Due Date</label>
                                                        <input type="date" class="form-control" id="installment_due_date" name="installment_due_date" 
                                                               value="{{ now()->addDays(15)->format('Y-m-d') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="payment_status" class="form-label">Payment Status</label>
                                                        <select class="form-select" id="payment_status" name="payment_status">
                                                            <option value="pending">Pending</option>
                                                            <option value="partial">Partial</option>
                                                            <option value="completed">Completed</option>
                                                            <option value="overdue">Overdue</option>
                                                            <option value="cancelled">Cancelled</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            @if($existingInvoices && $existingInvoices->count() > 0)
                                            <div class="alert alert-info mt-3">
                                                <h6><i class="fas fa-info-circle"></i> Installment Summary</h6>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <strong>Total Quotation Amount:</strong> ₹{{ number_format($quotation->final_amount, 2) }}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Already Paid:</strong> ₹{{ number_format($existingInvoices->where('status', 'completed')->sum('total_payment'), 2) }}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Remaining Balance:</strong> ₹{{ number_format($quotation->final_amount - $existingInvoices->where('status', 'completed')->sum('total_payment'), 2) }}
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
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
                                                       value="{{ $lastInvoice->bank_account_number ?? '' }}" 
                                                       placeholder="Enter Bank Account Number" maxlength="20">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ifsc_code" class="form-label">IFSC Code</label>
                                                <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" 
                                                       value="{{ $lastInvoice->ifsc_code ?? '' }}" 
                                                       placeholder="Enter IFSC Code" maxlength="11">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="mobile_bank_number" class="form-label">Mobile Bank Number</label>
                                                <input type="text" class="form-control" id="mobile_bank_number" name="mobile_bank_number" 
                                                       value="{{ $lastInvoice->mobile_bank_number ?? '' }}" 
                                                       placeholder="Enter Mobile Number" maxlength="10">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="company_pan" class="form-label">Company PAN</label>
                                                <input type="text" class="form-control" id="company_pan" name="company_pan" 
                                                       value="{{ $lastInvoice->company_pan ?? '' }}" 
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
                                                <label for="gst_number" class="form-label">GST Number</label>
                                                <input type="text" class="form-control" id="gst_number" name="gst_number" 
                                                       value="{{ $lastInvoice->gst_number ?? '' }}" 
                                                       placeholder="Enter GST Number" maxlength="20">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="place_of_supply" class="form-label">Place of Supply</label>
                                                <input type="text" class="form-control" id="place_of_supply" name="place_of_supply" 
                                                       value="{{ $lastInvoice->place_of_supply ?? 'Maharashtra' }}" maxlength="100">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="hsn_code" class="form-label">HSN/SAC Code</label>
                                                <input type="text" class="form-control" id="hsn_code" name="hsn_code" 
                                                       value="{{ $lastInvoice->hsn_code ?? '998314' }}" placeholder="Enter HSN/SAC Code" maxlength="20">
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

                            <!-- Payment Terms -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6><i class="fas fa-credit-card"></i> Payment Terms</h6>
                                    <div class="form-group">
                                        <label for="payment_terms" class="form-label">Payment Terms & Conditions</label>
                                        <textarea class="form-control" id="payment_terms" name="payment_terms" rows="3" 
                                                  placeholder="Enter payment terms and conditions...">{{ $lastInvoice->payment_terms ?? 'Payment to be made within 15 days from invoice date. Late payment charges @ 18% per annum will be applicable.' }}</textarea>
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
                                                  placeholder="Enter any additional notes...">{{ $lastInvoice->notes ?? 'Thank you for your business! We appreciate your trust in our services. This is installment ' . $installmentLetter . ' for quotation ' . $quotation->quotation_number . '.' }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success btn-lg me-2" name="save_only" value="1">
                                        <i class="fas fa-save"></i> Save Installment {{ $installmentLetter }} Invoice
                                    </button>
                                    <a href="{{ route('invoices.management', $quotation->id) }}" class="btn btn-secondary btn-lg">
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
</div>

<!-- Bank Details Data (for JavaScript) -->
<script>
const lastInvoiceDetails = {!! json_encode($lastInvoice ? [
    'bank_account_number' => $lastInvoice->bank_account_number,
    'ifsc_code' => $lastInvoice->ifsc_code,
    'mobile_bank_number' => $lastInvoice->mobile_bank_number,
    'company_pan' => $lastInvoice->company_pan,
    'gst_number' => $lastInvoice->gst_number,
    'place_of_supply' => $lastInvoice->place_of_supply,
    'hsn_code' => $lastInvoice->hsn_code,
    'payment_terms' => $lastInvoice->payment_terms,
    'notes' => $lastInvoice->notes
] : null) !!};
</script>

@push('scripts')
<script>
$(document).ready(function() {
    // Set minimum date to today
    $('#invoice_date, #installment_due_date').attr('min', new Date().toISOString().split('T')[0]);

    // Form validation
    $('#installment-form').on('submit', function(e) {
        var amount = parseFloat($('#total_amount').val()) || 0;
        if (amount <= 0) {
            e.preventDefault();
            alert('Installment amount must be greater than 0');
            $('#total_amount').focus();
        }
    });

    // Payment calculation functions
    window.calculateRemainingPayment = function() {
        var totalAmount = parseFloat('{{ $quotation->final_amount }}') || 0;
        var advancePayment = parseFloat($('#advance_payment').val()) || 0;
        var remainingPayment = totalAmount - advancePayment;
        
        $('#remaining_payment').val(remainingPayment.toFixed(2));
        $('#installment_amount').val(remainingPayment.toFixed(2));
        
        // Update installment schedule
        updateInstallmentSchedule();
        
        console.log('Payment calculated:', {
            total: totalAmount,
            advance: advancePayment,
            remaining: remainingPayment
        });
    };

    // Installment schedule management
    window.updateInstallmentSchedule = function() {
        var numberOfInstallments = parseInt($('#number_of_installments').val()) || 1;
        var installmentAmount = parseFloat($('#installment_amount').val()) || 0;
        var amountPerInstallment = installmentAmount / numberOfInstallments;
        
        var scheduleBody = $('#installment_schedule_body');
        scheduleBody.empty();
        
        var baseDate = new Date();
        
        for (var i = 0; i < numberOfInstallments; i++) {
            var dueDate = new Date(baseDate);
            dueDate.setMonth(dueDate.getMonth() + (i + 1));
            
            var row = `
                <tr>
                    <td>Installment ${i + 1}</td>
                    <td>
                        <input type="date" class="form-control form-control-sm" name="installment_due_dates[]" 
                               value="${dueDate.toISOString().split('T')[0]}">
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" name="installment_amounts[]" 
                                   value="${amountPerInstallment.toFixed(2)}" step="0.01" min="0">
                        </div>
                    </td>
                    <td>
                        <select class="form-select form-select-sm" name="installment_statuses[]">
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="overdue">Overdue</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" name="installment_notes[]" 
                               placeholder="Optional notes">
                    </td>
                </tr>
            `;
            scheduleBody.append(row);
        }
        
        console.log('Installment schedule updated:', {
            numberOfInstallments: numberOfInstallments,
            amountPerInstallment: amountPerInstallment
        });
    };

    // Auto-calculate when installment amount changes
    $('#installment_amount').on('input', function() {
        updateInstallmentSchedule();
    });
    
    // Initialize on page load
    calculateRemainingPayment();

    // Copy bank details from last invoice
    function copyLastBankDetails() {
        if (lastInvoiceDetails) {
            $('#bank_account_number').val(lastInvoiceDetails.bank_account_number || '');
            $('#ifsc_code').val(lastInvoiceDetails.ifsc_code || '');
            $('#mobile_bank_number').val(lastInvoiceDetails.mobile_bank_number || '');
            $('#company_pan').val(lastInvoiceDetails.company_pan || '');
            $('#gst_number').val(lastInvoiceDetails.gst_number || '');
            $('#place_of_supply').val(lastInvoiceDetails.place_of_supply || '');
            $('#hsn_code').val(lastInvoiceDetails.hsn_code || '');
            $('#payment_terms').val(lastInvoiceDetails.payment_terms || '');
            $('#notes').val(lastInvoiceDetails.notes || '');
            
            alert('Bank details copied from last invoice');
        }
    }

    // Add copy button functionality
    @if($lastInvoice)
    $('#copy-last-bank').on('click', copyLastBankDetails);
    @endif
});
</script>
@endpush
