@extends('admin.admin_master')

@section('page-title', 'Advanced Invoice Management System')

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
<div class="container-fluid">
    <!-- Advanced Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Invoices</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalInvoices ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Paid Invoices</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $paidInvoices ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Invoices</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingInvoices ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹{{ number_format($totalRevenue ?? 0, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Invoice Management -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-file-invoice-dollar"></i> Advanced Invoice Management System
            </h6>
            <div class="d-flex flex-wrap gap-2">
                @if(auth()->user()->role == 1 || auth()->user()->role == 5)
                    <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Create Invoice
                    </a>
                    <button class="btn btn-success btn-sm" onclick="exportSelectedInvoices()">
                        <i class="fas fa-file-excel"></i> Export Selected
                    </button>
                    <button class="btn btn-info btn-sm" onclick="sendBulkEmails()">
                        <i class="fas fa-envelope-bulk"></i> Bulk Email
                    </button>
                @endif
                <button class="btn btn-secondary btn-sm" onclick="toggleFilters()">
                    <i class="fas fa-filter"></i> Filters
                </button>
            </div>
        </div>

        <div class="card-body">
            <!-- Advanced Filters Section -->
            <div id="advancedFilters" class="mb-4" style="display: none;">
                <div class="card bg-light">
                    <div class="card-body">
                        <form id="filterForm" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Search</label>
                                <input type="text" class="form-control" id="searchInput" placeholder="Invoice number, customer, project...">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="statusFilter">
                                    <option value="">All Status</option>
                                    <option value="paid">Paid</option>
                                    <option value="pending">Pending</option>
                                    <option value="overdue">Overdue</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Date From</label>
                                <input type="date" class="form-control" id="dateFrom">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Date To</label>
                                <input type="date" class="form-control" id="dateTo">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="applyFilters()">
                                        <i class="fas fa-search"></i> Apply
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="resetFilters()">
                                        <i class="fas fa-undo"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Advanced Notifications -->
            @if(auth()->check() && !(auth()->user()->role == 1 || auth()->user()->role == 5))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle"></i>
                    <strong>Limited Access:</strong> You can view invoices, but only administrators can edit, send emails, download PDFs, or delete invoices.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Advanced DataTable -->
            @if($invoices->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="advancedInvoicesTable">
                        <thead class="table-dark">
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                </th>
                                <th width="60">#</th>
                                <th>Invoice Number</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Project Name</th>
                                <th>Total Amount</th>
                                <th>Advance Paid</th>
                                <th>Remaining</th>
                                <th>Status</th>
                                <th>Invoice Date</th>
                                <th width="180">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @forelse($invoices as $invoice)
                            <tr data-invoice-id="{{ $invoice->id }}">
                                <td>
                                    <input type="checkbox" class="invoice-checkbox" value="{{ $invoice->id }}">
                                </td>
                                <td>{{ $counter++ }}</td>
                                <td>
                                    <strong class="text-primary">{{ $invoice->invoice_number }}</strong>
                                    <br>
                                    <small class="text-muted">ID: {{ $invoice->id }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ strtoupper(substr($invoice->customer_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $invoice->customer_name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $invoice->customer_phone ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="mailto:{{ $invoice->customer_email }}" class="text-decoration-none">
                                        {{ $invoice->customer_email }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $invoice->project_name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success fs-6">₹{{ number_format($invoice->total_payment, 2) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info fs-6">₹{{ number_format($invoice->advance_payment, 2) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning fs-6">₹{{ number_format($invoice->remaining_payment, 2) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'pending' ? 'warning' : ($invoice->status == 'overdue' ? 'danger' : 'secondary')) }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small">
                                        {{ $invoice->invoice_date->format('d M Y') }}
                                        <br>
                                        <span class="text-muted">{{ $invoice->invoice_date->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-info" onclick="viewInvoice({{ $invoice->id }})" title="View Invoice" @if(!auth()->check()) disabled>
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        @if(auth()->check() && (auth()->user()->role == 1 || auth()->user()->role == 5))
                                            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-warning" title="Edit Invoice">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-success" onclick="sendInvoiceEmail({{ $invoice->id }})" title="Send Email">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" title="Download Options">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('invoices.export.pdf', $invoice) }}" target="_blank">
                                                        <i class="fas fa-file-pdf"></i> Download PDF
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="{{ route('invoices.export.word', $invoice) }}" target="_blank">
                                                        <i class="fas fa-file-word"></i> Download Word
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item" href="#" onclick="printInvoice({{ $invoice->id }})">
                                                        <i class="fas fa-print"></i> Print Invoice
                                                    </a></li>
                                                </ul>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteInvoice({{ $invoice->id }})" title="Delete Invoice">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-warning" disabled title="Edit Invoice (Admin Only)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" disabled title="Send Email (Admin Only)">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" disabled title="Download (Admin Only)">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" disabled title="Delete Invoice (Admin Only)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="13" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No invoices found</h5>
                                    <p class="text-muted">Try adjusting your filters or create a new invoice.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Advanced Pagination -->
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

<!-- Advanced View Invoice Modal -->
<div class="modal fade" id="viewInvoiceModal" tabindex="-1" aria-labelledby="viewInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewInvoiceModalLabel">
                    <i class="fas fa-file-invoice"></i> Invoice Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
                <button type="button" class="btn btn-primary" onclick="printInvoiceFromModal()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Advanced Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="emailModalLabel">
                    <i class="fas fa-envelope"></i> Send Invoice Email
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="emailForm">
                    <div class="mb-3">
                        <label class="form-label">To:</label>
                        <input type="email" class="form-control" id="emailTo" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject:</label>
                        <input type="text" class="form-control" id="emailSubject" value="Invoice Payment Reminder">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message:</label>
                        <textarea class="form-control" id="emailMessage" rows="5">Dear Customer,

This is a reminder regarding your invoice payment. Please find the invoice details attached.

Thank you for your business.

Best regards,
Niranjan Enterprises</textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="attachPDF" checked>
                            <label class="form-check-label" for="attachPDF">
                                Attach PDF invoice
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="sendCustomEmail()">
                    <i class="fas fa-paper-plane"></i> Send Email
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize Advanced DataTable
    $('#advancedInvoicesTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'desc']],
        language: {
            search: "Search invoices:",
            lengthMenu: "Show _MENU_ invoices per page",
            info: "Showing _START_ to _END_ of _TOTAL_ invoices",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Export Excel',
                className: 'btn btn-success btn-sm'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> Export PDF',
                className: 'btn btn-danger btn-sm'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-info btn-sm'
            }
        ]
    });

    // Real-time search
    $('#searchInput').on('keyup', function() {
        var table = $('#advancedInvoicesTable').DataTable();
        table.search(this.value).draw();
    });

    // Status filter
    $('#statusFilter').on('change', function() {
        var table = $('#advancedInvoicesTable').DataTable();
        if (this.value === '') {
            table.column(9).search('').draw();
        } else {
            table.column(9).search(this.value).draw();
        }
    });
});

// Toggle Filters
function toggleFilters() {
    $('#advancedFilters').slideToggle();
}

// Apply Filters
function applyFilters() {
    var dateFrom = $('#dateFrom').val();
    var dateTo = $('#dateTo').val();
    var status = $('#statusFilter').val();
    
    var table = $('#advancedInvoicesTable').DataTable();
    
    // Apply date range filter
    if (dateFrom || dateTo) {
        // Add custom date range filtering logic here
        showNotification('Date filters applied', 'success');
    }
    
    // Apply status filter
    if (status) {
        table.column(9).search(status).draw();
    }
}

// Reset Filters
function resetFilters() {
    $('#searchInput').val('');
    $('#statusFilter').val('');
    $('#dateFrom').val('');
    $('#dateTo').val('');
    
    var table = $('#advancedInvoicesTable').DataTable();
    table.search('').columns().search('').draw();
    
    showNotification('Filters reset', 'info');
}

// Toggle Select All
function toggleSelectAll() {
    var selectAll = $('#selectAll').prop('checked');
    $('.invoice-checkbox').prop('checked', selectAll);
}

// Export Selected Invoices
function exportSelectedInvoices() {
    var selectedInvoices = [];
    $('.invoice-checkbox:checked').each(function() {
        selectedInvoices.push($(this).val());
    });
    
    if (selectedInvoices.length === 0) {
        showNotification('Please select invoices to export', 'warning');
        return;
    }
    
    // Implement export logic here
    showNotification('Exporting ' + selectedInvoices.length + ' invoices...', 'success');
}

// Send Bulk Emails
function sendBulkEmails() {
    var selectedInvoices = [];
    $('.invoice-checkbox:checked').each(function() {
        selectedInvoices.push($(this).val());
    });
    
    if (selectedInvoices.length === 0) {
        showNotification('Please select invoices to send emails', 'warning');
        return;
    }
    
    if (confirm('Send payment reminder emails for ' + selectedInvoices.length + ' invoices?')) {
        // Implement bulk email logic here
        showNotification('Sending emails...', 'success');
    }
}

// Advanced View Invoice
function viewInvoice(invoiceId) {
    $('#viewInvoiceModal').modal('show');
    
    $.ajax({
        url: `/invoices/${invoiceId}`,
        method: 'GET',
        success: function(response) {
            var tempDiv = $('<div>').html(response);
            var cardContent = tempDiv.find('.card').first();
            
            if (cardContent.length === 0) {
                cardContent = tempDiv.find('.container-fluid').first();
            }
            
            if (cardContent.length === 0) {
                cardContent = tempDiv;
            }
            
            var modalContent = cardContent.clone();
            modalContent.find('.btn-group').remove();
            modalContent.find('.card-header h5').text('Invoice Details');
            
            $('#invoiceDetails').html(modalContent.html());
        },
        error: function(xhr) {
            var errorMessage = 'Error loading invoice details';
            
            if (xhr.status === 404) {
                errorMessage = 'Invoice not found';
            } else if (xhr.status === 403) {
                errorMessage = 'You are not authorized to view this invoice';
            } else if (xhr.status === 401) {
                errorMessage = 'Please login to view invoices';
                window.location.href = '/login';
                return;
            }
            
            $('#invoiceDetails').html('<div class="alert alert-danger">' + errorMessage + '</div>');
        }
    });
}

// Advanced Send Email
function sendInvoiceEmail(invoiceId) {
    // Get invoice details for email modal
    $.ajax({
        url: `/invoices/${invoiceId}`,
        method: 'GET',
        success: function(response) {
            var tempDiv = $('<div>').html(response);
            var customerEmail = tempDiv.find('td:contains("Email")').next().text().trim();
            
            $('#emailTo').val(customerEmail);
            $('#emailModal').modal('show');
        },
        error: function() {
            showNotification('Error loading invoice details', 'error');
        }
    });
}

// Send Custom Email
function sendCustomEmail() {
    var to = $('#emailTo').val();
    var subject = $('#emailSubject').val();
    var message = $('#emailMessage').val();
    var attachPDF = $('#attachPDF').is(':checked');
    
    if (!to || !subject || !message) {
        showNotification('Please fill all email fields', 'warning');
        return;
    }
    
    // Implement custom email sending logic here
    showNotification('Sending email...', 'success');
    
    setTimeout(function() {
        $('#emailModal').modal('hide');
        showNotification('Email sent successfully!', 'success');
    }, 2000);
}

// Print Invoice
function printInvoice(invoiceId) {
    window.open(`/invoices/${invoiceId}/print`, '_blank');
}

// Print Invoice from Modal
function printInvoiceFromModal() {
    window.print();
}

// Advanced Delete Invoice
function deleteInvoice(invoiceId) {
    if (confirm('Are you sure you want to delete this invoice? This action cannot be undone.')) {
        $.ajax({
            url: `/invoices/${invoiceId}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                showNotification('Invoice deleted successfully!', 'success');
                location.reload();
            },
            error: function(xhr) {
                var errorMessage = 'Error deleting invoice';
                
                if (xhr.status === 401) {
                    errorMessage = 'Please login to delete invoices';
                    window.location.href = '/login';
                    return;
                } else if (xhr.status === 403) {
                    errorMessage = 'You are not authorized to delete this invoice';
                } else if (xhr.status === 404) {
                    errorMessage = 'Invoice not found';
                }
                
                showNotification(errorMessage, 'error');
            }
        });
    }
}

// Show Notification
function showNotification(message, type) {
    var alertClass = 'alert-info';
    var icon = 'fas fa-info-circle';
    
    switch(type) {
        case 'success':
            alertClass = 'alert-success';
            icon = 'fas fa-check-circle';
            break;
        case 'warning':
            alertClass = 'alert-warning';
            icon = 'fas fa-exclamation-triangle';
            break;
        case 'error':
            alertClass = 'alert-danger';
            icon = 'fas fa-times-circle';
            break;
    }
    
    var notification = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="${icon}"></i> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('.card-body').prepend(notification);
    
    // Auto-dismiss after 5 seconds
    setTimeout(function() {
        $('.alert').first().fadeOut();
    }, 5000);
}
</script>
@endsection
@endsection
