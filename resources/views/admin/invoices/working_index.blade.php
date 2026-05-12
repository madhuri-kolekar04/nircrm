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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Statistics Cards - Admin Only -->
    @if(auth()->user()->role == 1)
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
    @endif

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
                            <div class="text-muted">
                                User: {{ auth()->user()->email }} (Role: {{ auth()->user()->role }})
                                @if(auth()->user()->role == 1 || auth()->user()->role == 5)
                                    <span class="badge bg-success">Admin Access</span>
                                @else
                                    <span class="badge bg-warning">Limited Access</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
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
                                        <th width="60">#</th>
                                        <th>Invoice Number</th>
                                        <th>Customer</th>
                                        <th>Project</th>
                                        <th>Total Amount</th>
                                        <th>Advance Paid</th>
                                        <th>Remaining</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th width="250">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1; @endphp
                                    @forelse($invoices as $invoice)
                                    <tr data-invoice-id="{{ $invoice->id }}">
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
                                                <!-- View Button - Always available for authenticated users -->
                                                <a href="{{ route('invoices.view', $invoice) }}" class="btn btn-sm btn-outline-primary" title="View Invoice">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                @if(auth()->check() && (auth()->user()->role == 1 || auth()->user()->role == 5))
                                                    <!-- Edit Button - Admin only -->
                                                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-outline-warning" title="Edit Invoice">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    
                                                    <!-- Email Button - Admin only -->
                                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="sendInvoiceEmail({{ $invoice->id }})" title="Send Email">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                    
                                                    <!-- Download Button - Admin only -->
                                                    <a href="{{ route('invoices.export.pdf', $invoice) }}" class="btn btn-sm btn-outline-info" title="Download PDF" target="_blank">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    
                                                    <!-- Delete Button - Admin only -->
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteInvoice({{ $invoice->id }})" title="Delete Invoice">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @else
                                                    <!-- Disabled buttons for non-admin users -->
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
                                        <td colspan="10" class="text-center py-5">
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
@endif

@push('scripts')
<script>
console.log('Invoice page JavaScript loaded successfully!');

document.addEventListener('DOMContentLoaded', function() {
    initializeDataTable();
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

// Send Email Function
function sendInvoiceEmail(invoiceId) {
    console.log('Sending email for invoice:', invoiceId);
    
    if (confirm('Send payment reminder email for this invoice?')) {
        // Show loading state
        showNotification('Sending email...', 'info');
        
        fetch(`/invoices/${invoiceId}/send-reminder`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => {
            console.log('Email response status:', response.status);
            console.log('Response headers:', response.headers);
            
            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            console.log('Content type:', contentType);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            } else {
                // If not JSON, try to get text and see what we got
                return response.text().then(text => {
                    console.log('Non-JSON response:', text);
                    throw new Error('Server returned HTML instead of JSON. Check server logs.');
                });
            }
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

// Delete Invoice Function (Soft Delete)
function deleteInvoice(invoiceId) {
    console.log('Deleting invoice:', invoiceId);
    
    if (confirm('Are you sure you want to delete this invoice? This action cannot be undone.')) {
        // Show loading state
        showNotification('Deleting invoice...', 'info');
        
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
                // Remove the row from table
                const row = document.querySelector(`tr[data-invoice-id="${invoiceId}"]`);
                if (row) {
                    row.remove();
                }
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

// Print Invoice Function
function printInvoice(invoiceId) {
    console.log('Printing invoice:', invoiceId);
    
    // Try direct window.open first
    const printUrl = `/invoices/${invoiceId}/print`;
    console.log('Opening print URL:', printUrl);
    
    // Open in new tab
    const printWindow = window.open(printUrl, '_blank');
    
    // Wait for page to load, then trigger print
    setTimeout(() => {
        if (printWindow && !printWindow.closed) {
            printWindow.print();
        }
    }, 1000);
}

// Show Notification Function
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
    }, 5000);
}

// Verify functions are loaded
console.log('Functions available:');
console.log('sendInvoiceEmail:', typeof sendInvoiceEmail);
console.log('deleteInvoice:', typeof deleteInvoice);
console.log('printInvoice:', typeof printInvoice);
</script>
@endpush
@endsection
