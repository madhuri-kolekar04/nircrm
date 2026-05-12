@extends('customer.layouts.app')

@section('title', $companyName . ' - Invoices')

@section('content')
<div class="container-fluid">
    <!-- Company Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('customer.companies.index') }}">My Companies</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.companies.show', $companyName) }}">{{ $companyName }}</a></li>
                            <li class="breadcrumb-item active">Invoices</li>
                        </ol>
                    </nav>
                    <h2 class="mb-1">{{ $companyName }} - Invoices</h2>
                    <p class="text-muted mb-0">View and download all your invoices</p>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('customer.companies.show', $companyName) }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Company
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="customer-stat-card">
                <div class="customer-stat-icon primary">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="customer-stat-value">{{ $quotations->count() }}</div>
                <div class="customer-stat-label">Total Invoices</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="customer-stat-card">
                <div class="customer-stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="customer-stat-value">{{ number_format($quotations->where('payment_status', 'completed')->sum('final_amount'), 0) }}</div>
                <div class="customer-stat-label">Paid Amount</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="customer-stat-card">
                <div class="customer-stat-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="customer-stat-value">{{ number_format($quotations->where('payment_status', '!=', 'completed')->sum('final_amount'), 0) }}</div>
                <div class="customer-stat-label">Pending Amount</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="customer-stat-card">
                <div class="customer-stat-icon info">
                    <i class="fas fa-check"></i>
                </div>
                <div class="customer-stat-value">{{ $quotations->where('payment_status', 'completed')->count() }}</div>
                <div class="customer-stat-label">Completed</div>
            </div>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="row">
        <div class="col-12">
            <div class="customer-card">
                <div class="customer-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-file-invoice me-2"></i>Invoice List
                        </h5>
                        <button class="btn btn-success btn-sm" onclick="downloadAllInvoices()">
                            <i class="fas fa-download me-2"></i>Download All
                        </button>
                    </div>
                </div>
                <div class="customer-card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="invoicesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Quotation #</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quotations as $quotation)
                                <tr>
                                    <td>
                                        <strong>INV-{{ date('Y') }}-{{ str_pad($quotation->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                    </td>
                                    <td>{{ $quotation->quotation_number }}</td>
                                    <td>{{ $quotation->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $quotation->formatted_final_amount }}</span>
                                    </td>
                                    <td>
                                        @if($quotation->payment_status == 'completed')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Paid
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($quotation->payment_updated_at)
                                            {{ $quotation->payment_updated_at->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-info" onclick="viewQuotation({{ $quotation->id }})" title="View Quotation">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($quotation->payment_status == 'completed')
                                                <button type="button" class="btn btn-sm btn-success" onclick="downloadInvoice({{ $quotation->id }})" title="Download Invoice">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-primary" onclick="emailInvoice({{ $quotation->id }})" title="Email Invoice">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function viewQuotation(quotationId) {
    window.open('/quotations/' + quotationId, '_blank');
}

function downloadInvoice(quotationId) {
    window.open('/accounts/generate-invoice/' + quotationId, '_blank');
}

function emailInvoice(quotationId) {
    if (confirm('Do you want to receive this invoice via email?')) {
        alert('Invoice will be sent to your registered email address.');
    }
}

function downloadAllInvoices() {
    alert('Bulk download feature coming soon!');
}

$(document).ready(function() {
    $('#invoicesTable').DataTable({
        "pageLength": 25,
        "order": [[ 2, "desc" ]], // Sort by date
        "responsive": true,
        "language": {
            "search": "Search invoices:",
            "lengthMenu": "Show _MENU_ entries per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ invoices"
        }
    });
});
</script>
@endsection
@endsection
