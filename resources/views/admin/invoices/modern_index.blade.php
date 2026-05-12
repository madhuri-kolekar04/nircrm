@extends('admin.admin_master')

@section('page-title', 'Professional Invoice Management')

@section('admin')
@if(!auth()->check())
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning">
                <h4><i class="fas fa-exclamation-triangle"></i> Authentication Required</h4>
                <p>Please <a href="{{ route('login') }}" class="alert-link">login to your account</a> to access the invoice management system.</p>
            </div>
        </div>
    </div>
</div>
@else
<!-- Professional Invoice Management System -->
<div class="container-fluid">
    <!-- JavaScript Test -->
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>JavaScript Test:</strong> 
        <button onclick="alert('JavaScript is working!')" class="btn btn-sm btn-primary">Test JS</button>
        <button onclick="console.log('Console test successful!')" class="btn btn-sm btn-info">Test Console</button>
        @if(auth()->check())
            <span class="badge bg-success">Logged in as: {{ auth()->user()->email }} (Role: {{ auth()->user()->role }})</span>
            @if(auth()->user()->role == 1 || auth()->user()->role == 5)
                <span class="badge bg-primary">ADMIN ACCESS</span>
            @else
                <span class="badge bg-warning">Limited Access</span>
            @endif
        @else
            <span class="badge bg-danger">NOT LOGGED IN</span>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-white bg-opacity-20 p-3 me-3">
                                    <i class="fas fa-file-invoice-dollar fa-2x"></i>
                                </div>
                                <div>
                                    <h1 class="mb-1 fw-bold">Professional Invoice Management</h1>
                                    <p class="mb-0 opacity-75">Manage your invoices with advanced features</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            @if(auth()->user()->role == 1 || auth()->user()->role == 5)
                                <a href="{{ route('invoices.create') }}" class="btn btn-light btn-lg me-2">
                                    <i class="fas fa-plus me-2"></i>Create Invoice
                                </a>
                                <button class="btn btn-warning btn-lg me-2" onclick="exportSelected()">
                                    <i class="fas fa-file-excel me-2"></i>Export
                                </button>
                                <button class="btn btn-success btn-lg" onclick="bulkEmail()">
                                    <i class="fas fa-envelope-bulk me-2"></i>Bulk Email
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-file-invoice fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-2">Total Invoices</h6>
                            <h3 class="mb-0 fw-bold">{{ $totalInvoices ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-2">Paid Invoices</h6>
                            <h3 class="mb-0 fw-bold">{{ $paidInvoices ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-2">Pending Invoices</h6>
                            <h3 class="mb-0 fw-bold">{{ $pendingInvoices ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                            <i class="fas fa-rupee-sign fa-2x text-info"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-2">Total Revenue</h6>
                            <h3 class="mb-0 fw-bold">₹{{ number_format($totalRevenue ?? 0, 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-0 pt-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0 fw-bold text-dark">Invoice List</h5>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <button class="btn btn-outline-primary btn-sm me-2" onclick="toggleFilters()">
                                <i class="fas fa-filter me-1"></i> Filters
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" onclick="resetFilters()">
                                <i class="fas fa-redo me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Advanced Filters -->
                    <div id="filterSection" class="mb-4" style="display: none;">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Search</label>
                                        <input type="text" class="form-control" id="searchInput" placeholder="Invoice, customer, project...">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Status</label>
                                        <select class="form-select" id="statusFilter">
                                            <option value="">All Status</option>
                                            <option value="paid">Paid</option>
                                            <option value="pending">Pending</option>
                                            <option value="overdue">Overdue</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Date From</label>
                                        <input type="date" class="form-control" id="dateFrom">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Date To</label>
                                        <input type="date" class="form-control" id="dateTo">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">&nbsp;</label>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-primary" onclick="applyFilters()">
                                                <i class="fas fa-search"></i> Apply
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Invoice Table -->
                    @if($invoices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="invoicesTable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="40">
                                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll()" class="form-check-input">
                                        </th>
                                        <th width="60">#</th>
                                        <th>Invoice Number</th>
                                        <th>Customer</th>
                                        <th>Project</th>
                                        <th>Total Amount</th>
                                        <th>Advance Paid</th>
                                        <th>Remaining</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th width="200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1; @endphp
                                    @forelse($invoices as $invoice)
                                    <tr data-invoice-id="{{ $invoice->id }}">
                                        <td>
                                            <input type="checkbox" class="form-check-input invoice-checkbox" value="{{ $invoice->id }}">
                                        </td>
                                        <td>{{ $counter++ }}</td>
                                        <td>
                                            <div class="fw-bold text-primary">{{ $invoice->invoice_number }}</div>
                                            <small class="text-muted">ID: {{ $invoice->id }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 12px; font-weight: 600;">
                                                    {{ strtoupper(substr($invoice->customer_name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $invoice->customer_name }}</div>
                                                    <small class="text-muted">{{ $invoice->customer_email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $invoice->project_name ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">₹{{ number_format($invoice->total_payment, 0) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">₹{{ number_format($invoice->advance_payment, 0) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">₹{{ number_format($invoice->remaining_payment, 0) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>{{ $invoice->invoice_date->format('d M Y') }}</div>
                                            <small class="text-muted">{{ $invoice->invoice_date->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="console.log('View button clicked!'); viewInvoice({{ $invoice->id }})" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                
                                                @if(auth()->check() && (auth()->user()->role == 1 || auth()->user()->role == 5))
                                                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="console.log('Email button clicked!'); sendInvoiceEmail({{ $invoice->id }})" title="Send Email">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="{{ route('invoices.export.pdf', $invoice) }}" target="_blank">
                                                                <i class="fas fa-file-pdf"></i> PDF
                                                            </a></li>
                                                            <li><a class="dropdown-item" href="{{ route('invoices.export.word', $invoice) }}" target="_blank">
                                                                <i class="fas fa-file-word"></i> Word
                                                            </a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="console.log('Print button clicked!'); printInvoice({{ $invoice->id }})">
                                                                <i class="fas fa-print"></i> Print
                                                            </a></li>
                                                        </ul>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="console.log('Delete button clicked!'); deleteInvoice({{ $invoice->id }})" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Edit (Admin Only)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Email (Admin Only)">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Download (Admin Only)">
                                                        <i class="fas fa-download"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Delete (Admin Only)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No invoices found</h5>
                                            <p class="text-muted">Try adjusting your filters or create a new invoice.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Showing {{ $invoices->firstItem() ?? 0 }} to {{ $invoices->lastItem() ?? 0 }} of {{ $invoices->total() }} entries
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $invoices->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-invoice-dollar fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">No Invoices Found</h4>
                            <p class="text-muted">There are no saved invoices in the system yet.</p>
                            @if(auth()->user()->role == 1 || auth()->user()->role == 5)
                                <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create First Invoice
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Professional Modal -->
<div class="modal fade" id="viewInvoiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-file-invoice me-2"></i>Invoice Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="invoiceDetails">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading invoice details...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printInvoiceFromModal()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
console.log('Invoice page JavaScript loaded successfully!');

document.addEventListener('DOMContentLoaded', function() {
    initializeDataTable();
    setupSearchFilters();
});

function initializeDataTable() {
    // Initialize DataTable if available
    if ($.fn.DataTable) {
        $('#invoicesTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']],
            language: {
                search: "Search invoices:",
                lengthMenu: "Show _MENU_ invoices per page",
                info: "Showing _START_ to _END_ of _TOTAL_ invoices"
            }
        });
    }
}

function setupSearchFilters() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterTable();
        });
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            filterTable();
        });
    }
}

function toggleFilters() {
    const filterSection = document.getElementById('filterSection');
    if (filterSection) {
        filterSection.style.display = filterSection.style.display === 'none' ? 'block' : 'none';
    }
}

function filterTable() {
    const searchValue = document.getElementById('searchInput').value.toLowerCase();
    const statusValue = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('#invoicesTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const status = row.querySelector('.badge')?.textContent.toLowerCase();
        
        const matchesSearch = !searchValue || text.includes(searchValue);
        const matchesStatus = !statusValue || status === statusValue;
        
        row.style.display = matchesSearch && matchesStatus ? '' : 'none';
    });
}

function applyFilters() {
    filterTable();
    showNotification('Filters applied successfully', 'success');
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    filterTable();
    showNotification('Filters reset', 'info');
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.invoice-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

function viewInvoice(invoiceId) {
    console.log('Viewing invoice:', invoiceId);
    const modal = new bootstrap.Modal(document.getElementById('viewInvoiceModal'));
    const modalContent = document.getElementById('invoiceDetails');
    
    modal.show();
    
    fetch(`/invoices/${invoiceId}`)
        .then(response => {
            console.log('View response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            console.log('View HTML received');
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            
            const cardContent = tempDiv.querySelector('.card') || tempDiv.querySelector('.container-fluid') || tempDiv;
            modalContent.innerHTML = cardContent.innerHTML;
        })
        .catch(error => {
            console.error('View error:', error);
            modalContent.innerHTML = '<div class="alert alert-danger">Error loading invoice details: ' + error.message + '</div>';
        });
}

function sendInvoiceEmail(invoiceId) {
    console.log('Sending email for invoice:', invoiceId);
    if (confirm('Send payment reminder email for this invoice?')) {
        fetch(`/invoices/${invoiceId}/send-reminder`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => {
            console.log('Email response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Email response data:', data);
            if (data.success) {
                showNotification(data.success, 'success');
            } else {
                showNotification(data.error || 'Failed to send email', 'error');
            }
        })
        .catch(error => {
            console.error('Email error:', error);
            showNotification('Error sending email: ' + error.message, 'error');
        });
    }
}

function deleteInvoice(invoiceId) {
    console.log('Deleting invoice:', invoiceId);
    if (confirm('Are you sure you want to delete this invoice? This action cannot be undone.')) {
        fetch(`/invoices/${invoiceId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            console.log('Delete response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Delete response data:', data);
            if (data.success) {
                showNotification('Invoice deleted successfully', 'success');
                location.reload();
            } else {
                showNotification(data.error || 'Failed to delete invoice', 'error');
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            showNotification('Error deleting invoice: ' + error.message, 'error');
        });
    }
}

function printInvoice(invoiceId) {
    console.log('Printing invoice:', invoiceId);
    const printUrl = `/invoices/${invoiceId}/print`;
    console.log('Opening print URL:', printUrl);
    window.open(printUrl, '_blank');
}

function printInvoiceFromModal() {
    window.print();
}

function exportSelected() {
    const selected = document.querySelectorAll('.invoice-checkbox:checked');
    if (selected.length === 0) {
        showNotification('Please select invoices to export', 'warning');
        return;
    }
    showNotification(`Exporting ${selected.length} invoices...`, 'success');
}

function bulkEmail() {
    const selected = document.querySelectorAll('.invoice-checkbox:checked');
    if (selected.length === 0) {
        showNotification('Please select invoices to send emails', 'warning');
        return;
    }
    if (confirm(`Send payment reminder emails for ${selected.length} invoices?`)) {
        showNotification(`Sending emails to ${selected.length} customers...`, 'success');
    }
}

function showNotification(message, type = 'success') {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'error' ? 'alert-danger' : 
                      type === 'warning' ? 'alert-warning' : 'alert-info';
    
    const notification = document.createElement('div');
    notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
});

// Verify functions are loaded
console.log('Functions available:');
console.log('viewInvoice:', typeof viewInvoice);
console.log('sendInvoiceEmail:', typeof sendInvoiceEmail);
console.log('deleteInvoice:', typeof deleteInvoice);
console.log('printInvoice:', typeof printInvoice);
</script>
@endpush
@endsection
