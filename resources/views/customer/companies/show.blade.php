@extends('customer.layouts.app')

@section('title', $companyName . ' - Company Details')

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
                            <li class="breadcrumb-item active">{{ $companyName }}</li>
                        </ol>
                    </nav>
                    <h2 class="mb-1">{{ $companyName }}</h2>
                    <p class="text-muted mb-0">Company overview and project details</p>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('customer.companies.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Companies
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="customer-stat-card">
                <div class="customer-stat-icon primary">
                    <i class="fas fa-file-contract"></i>
                </div>
                <div class="customer-stat-value">{{ $stats['total_quotations'] }}</div>
                <div class="customer-stat-label">Total Quotations</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="customer-stat-card">
                <div class="customer-stat-icon success">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <div class="customer-stat-value">{{ number_format($stats['total_amount'], 0) }}</div>
                <div class="customer-stat-label">Total Value</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="customer-stat-card">
                <div class="customer-stat-icon info">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="customer-stat-value">{{ $stats['completed_payments'] }}</div>
                <div class="customer-stat-label">Completed</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="customer-stat-card">
                <div class="customer-stat-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="customer-stat-value">{{ $stats['pending_payments'] }}</div>
                <div class="customer-stat-label">Pending</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="customer-card">
                <div class="customer-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="customer-card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('customer.companies.invoices', $companyName) }}" class="btn btn-outline-primary w-100 mb-2">
                                <i class="fas fa-file-invoice me-2"></i>View All Invoices
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('customer.companies.projects', $companyName) }}" class="btn btn-outline-info w-100 mb-2">
                                <i class="fas fa-project-diagram me-2"></i>View Projects
                            </a>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-success w-100 mb-2" onclick="downloadCompanyReport()">
                                <i class="fas fa-download me-2"></i>Download Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quotations Table -->
    <div class="row">
        <div class="col-12">
            <div class="customer-card">
                <div class="customer-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-file-contract me-2"></i>Quotations
                    </h5>
                </div>
                <div class="customer-card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="quotationsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Quotation #</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quotations as $quotation)
                                <tr>
                                    <td>
                                        <strong>{{ $quotation->quotation_number }}</strong>
                                    </td>
                                    <td>{{ $quotation->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $quotation->formatted_final_amount }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $quotation->approval_status_color }}">
                                            {{ ucfirst($quotation->approval_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $quotation->payment_status_color }}">
                                            {{ ucfirst($quotation->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-info" onclick="viewQuotation({{ $quotation->id }})" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($quotation->payment_status == 'completed')
                                                <button type="button" class="btn btn-sm btn-success" onclick="downloadInvoice({{ $quotation->id }})" title="Download Invoice">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            @endif
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

function downloadCompanyReport() {
    alert('Company report download feature coming soon!');
}

$(document).ready(function() {
    $('#quotationsTable').DataTable({
        "pageLength": 10,
        "order": [[ 1, "desc" ]], // Sort by date
        "responsive": true,
        "language": {
            "search": "Search quotations:",
            "lengthMenu": "Show _MENU_ entries per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ quotations"
        }
    });
});
</script>
@endsection
@endsection
