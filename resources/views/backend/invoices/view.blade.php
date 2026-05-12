@extends('admin.admin_master')

@section('page-title', 'Invoice Details - ' . ($invoice->invoice_number ?? 'Unknown'))

@section('title', 'Invoice Details - ' . ($invoice->invoice_number ?? 'Unknown'))

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-header bg-gradient-info text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-invoice"></i> Invoice Details
                        </h5>
                    </div>
                        <div>
                            @if($quotation)
                                <a href="{{ route('invoices.management', $quotation->id) }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to Invoice Management
                                </a>
                            @else
                                <a href="{{ route('accounts.index') }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to Accounts
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Invoice Header -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6><i class="fas fa-building"></i> Company Details</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5>NIRCRM</h5>
                                    <p class="mb-1">Professional Business Solutions</p>
                                    <p class="mb-1">Email: {{ config('mail.from.address') }}</p>
                                    <p class="mb-1">Phone: 9284161465</p>
                                    <p class="mb-0">GST: {{ $invoice->gst_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-user"></i> Client Details</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5>{{ $invoice->customer_name }}</h5>
                                    <p class="mb-1">{{ $invoice->customer_address }}</p>
                                    <p class="mb-1">Email: {{ $invoice->customer_email }}</p>
                                    <p class="mb-1">Phone: {{ $invoice->customer_phone }}</p>
                                    <p class="mb-0">PAN: {{ $invoice->company_pan ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6><i class="fas fa-info-circle"></i> Invoice Information</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="20%">Invoice Number</th>
                                            <th width="20%">Invoice Date</th>
                                            <th width="20%">Due Date</th>
                                            <th width="20%">Payment Status</th>
                                            <th width="20%">Department</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>{{ $invoice->invoice_number }}</strong></td>
                                            <td>{{ $invoice->invoice_date }}</td>
                                            <td>{{ $invoice->end_date ?? 'Not specified' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $invoice->status == 'completed' ? 'success' : ($invoice->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($invoice->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $invoice->department }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Installment Information -->
                    @if($invoice->installment_number)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6><i class="fas fa-layer-group"></i> Installment Information</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="25%">Installment Number</th>
                                            <th width="25%">Installment Letter</th>
                                            <th width="25%">Mail ID</th>
                                            <th width="25%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $invoice->installment_number ?? 'N/A' }}</td>
                                            <td>{{ $invoice->installment_letter ?? 'N/A' }}</td>
                                            <td><code>{{ $invoice->mail_id ?? 'N/A' }}</code></td>
                                            <td>
                                                <span class="badge bg-{{ $invoice->status == 'approved' ? 'success' : ($invoice->status == 'pending' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($invoice->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Services/Items -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6><i class="fas fa-list"></i> Invoice Items</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="45%">Description</th>
                                            <th width="15%" class="text-center">Quantity</th>
                                            <th width="15%" class="text-right">Unit Price</th>
                                            <th width="20%" class="text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $invoice->project_topic ?? 'Service/Project' }}</td>
                                            <td class="text-center">1</td>
                                            <td class="text-right">₹{{ number_format($invoice->total_payment ?? 0, 2) }}</td>
                                            <td class="text-right">₹{{ number_format($invoice->total_payment ?? 0, 2) }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="table-secondary">
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>Subtotal:</strong></td>
                                            <td class="text-right">₹{{ number_format($invoice->total_payment ?? 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>GST (18%):</strong></td>
                                            <td class="text-right">₹{{ number_format($invoice->gst ?? 0, 2) }}</td>
                                        </tr>
                                        <tr class="table-dark">
                                            <td colspan="4" class="text-right"><strong>Total Amount:</strong></td>
                                            <td class="text-right"><strong>₹{{ number_format(($invoice->total_payment ?? 0) + ($invoice->gst ?? 0), 2) }}</strong></td>
                                        </tr>
                                        @if($invoice->advance_payment > 0)
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>Advance Payment:</strong></td>
                                            <td class="text-right text-success">-₹{{ number_format($invoice->advance_payment, 2) }}</td>
                                        </tr>
                                        <tr class="table-info">
                                            <td colspan="4" class="text-right"><strong>Remaining Amount:</strong></td>
                                            <td class="text-right"><strong>₹{{ number_format(($invoice->total_payment ?? 0) + ($invoice->gst ?? 0) - ($invoice->advance_payment ?? 0), 2) }}</strong></td>
                                        </tr>
                                        @endif
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6><i class="fas fa-credit-card"></i> Payment Details</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-1"><strong>Bank Account:</strong> {{ $invoice->bank_account_number ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>IFSC Code:</strong> {{ $invoice->ifsc_code ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Mobile Bank:</strong> {{ $invoice->mobile_bank_number ?? 'N/A' }}</p>
                                    <p class="mb-0"><strong>Advance Payment:</strong> ₹{{ number_format($invoice->advance_payment, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-receipt"></i> GST Details</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-1"><strong>GST Number:</strong> {{ $invoice->gst_number ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Place of Supply:</strong> {{ $invoice->place_of_supply ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>HSN/SAC Code:</strong> {{ $invoice->hsn_code ?? 'N/A' }}</p>
                                    <p class="mb-0"><strong>GST Rate:</strong> 18%</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Notes -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6><i class="fas fa-file-contract"></i> Payment Terms</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p>{{ $invoice->payment_terms ?? 'Payment to be made within 15 days from invoice date.' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-sticky-note"></i> Notes</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p>{{ $invoice->notes ?? 'Thank you for your business!' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row">
                        <div class="col-12 text-center">
                            <button onclick="window.print()" class="btn btn-primary btn-lg me-2">
                                <i class="fas fa-print"></i> Print Invoice
                            </button>
                            <button onclick="downloadPDF()" class="btn btn-success btn-lg me-2">
                                <i class="fas fa-download"></i> Download PDF
                            </button>
                            <a href="mailto:{{ $invoice->customer_email }}?subject=Invoice {{ $invoice->invoice_number }}&body=Please find attached your invoice {{ $invoice->invoice_number }}" class="btn btn-info btn-lg">
                                <i class="fas fa-envelope"></i> Email Invoice
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
@media print {
    .btn, .card-header .btn {
        display: none !important;
    }
    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
    }
}
</style>

@push('scripts')
<script>
function downloadPDF() {
    // Placeholder for PDF generation
    alert('PDF generation will be implemented soon. For now, please use the Print function.');
}

$(document).ready(function() {
    // Add any interactive features here
});
</script>
@endpush
