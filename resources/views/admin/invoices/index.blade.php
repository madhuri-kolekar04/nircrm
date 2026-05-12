@extends('admin.admin_master')

@section('page-title', 'Invoice Management - Saved Invoices')

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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-file-invoice-dollar"></i> Invoice Management - Saved Invoices
                    </h3>
                    @if(auth()->user()->role == 1 || auth()->user()->role == 5)
                        <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Invoice
                        </a>
                    @endif
                </div>
                <div class="card-body">
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

                    @if($invoices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="invoicesTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice Number</th>
                                        <th>Customer Name</th>
                                        <th>Email</th>
                                        <th>Project Name</th>
                                        <th>Total Amount</th>
                                        <th>Advance Paid</th>
                                        <th>Remaining</th>
                                        <th>Status</th>
                                        <th>Invoice Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1; @endphp
                                    @forelse($invoices as $invoice)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>
                                            <strong class="text-primary">{{ $invoice->invoice_number }}</strong>
                                        </td>
                                        <td>{{ $invoice->customer_name }}</td>
                                        <td>{{ $invoice->customer_email }}</td>
                                        <td>{{ $invoice->project_name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-success">₹{{ number_format($invoice->total_payment, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">₹{{ number_format($invoice->advance_payment, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">₹{{ number_format($invoice->remaining_payment, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $invoice->invoice_date->format('d M Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-info" onclick="viewInvoice({{ $invoice->id }})" title="View Invoice" @if(!auth()->check()) disabled style="opacity: 0.5;">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                
                                                @if(auth()->check() && (auth()->user()->role == 1 || auth()->user()->role == 5))
                                                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-warning" title="Edit Invoice">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-success" onclick="sendInvoiceEmail({{ $invoice->id }})" title="Send Email">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                    <a href="{{ route('invoices.export.pdf', $invoice) }}" class="btn btn-sm btn-primary" title="Download PDF" target="_blank">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteInvoice({{ $invoice->id }})" title="Delete Invoice">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-warning" disabled title="Edit Invoice (Admin Only)" style="opacity: 0.5;">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success" disabled title="Send Email (Admin Only)" style="opacity: 0.5;">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-primary" disabled title="Download PDF (Admin Only)" style="opacity: 0.5;">
                                                        <i class="fas fa-download"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" disabled title="Delete Invoice (Admin Only)" style="opacity: 0.5;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No invoices found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            {{ $invoices->links() }}
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

<!-- View Invoice Modal -->
<div class="modal fade" id="viewInvoiceModal" tabindex="-1" aria-labelledby="viewInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewInvoiceModalLabel">Invoice Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="invoiceDetails">
                <!-- Invoice details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif

@section('scripts')
<script>
$(document).ready(function() {
    $('#invoicesTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'desc']]
    });
});

function viewInvoice(invoiceId) {
    $.ajax({
        url: `/invoices/${invoiceId}`,
        method: 'GET',
        beforeSend: function(xhr) {
            // Add any necessary headers
        },
        success: function(response) {
            // Extract only the card content from the response
            var tempDiv = $('<div>').html(response);
            var cardContent = tempDiv.find('.card').first();
            
            if (cardContent.length === 0) {
                // Fallback: try to find the main content area
                cardContent = tempDiv.find('.container-fluid').first();
            }
            
            if (cardContent.length === 0) {
                // Last fallback: use the entire response
                cardContent = tempDiv;
            }
            
            // Clean up the content for modal display
            var modalContent = cardContent.clone();
            
            // Remove header actions that don't make sense in modal
            modalContent.find('.btn-group .btn-danger, .btn-group .btn-success, .btn-group .btn-secondary').remove();
            
            // Adjust the header for modal
            modalContent.find('.card-header h5').text('Invoice Details - ' + invoiceId);
            
            $('#invoiceDetails').html(modalContent.html());
            $('#viewInvoiceModal').modal('show');
        },
        error: function(xhr) {
            var errorMessage = 'Error loading invoice details';
            
            if (xhr.status === 404) {
                errorMessage = 'Invoice not found';
            } else if (xhr.status === 403) {
                errorMessage = 'You are not authorized to view this invoice';
            } else if (xhr.status === 401) {
                errorMessage = 'Please login to view invoices';
                // Redirect to login if not authenticated
                if (xhr.responseText.includes('login') || xhr.responseText.includes('unauthorized')) {
                    window.location.href = '/login';
                    return;
                }
            } else if (xhr.status === 500) {
                errorMessage = 'Server error occurred while loading invoice';
            }
            
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            alert(errorMessage);
        }
    });
}

function sendInvoiceEmail(invoiceId) {
    if (confirm('Are you sure you want to send this invoice via email?')) {
        $.ajax({
            url: `/invoices/${invoiceId}/send-reminder`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    alert(response.success);
                    location.reload();
                } else {
                    alert('Unexpected response from server');
                }
            },
            error: function(xhr) {
                var errorMessage = 'Error sending invoice email';
                
                if (xhr.status === 401) {
                    errorMessage = 'Please login to send emails';
                    // Redirect to login if not authenticated
                    if (xhr.responseText.includes('login') || xhr.responseText.includes('unauthorized')) {
                        window.location.href = '/login';
                        return;
                    }
                } else if (xhr.status === 403) {
                    errorMessage = 'You are not authorized to send emails for this invoice';
                } else if (xhr.status === 404) {
                    errorMessage = 'Invoice not found';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error occurred while sending email';
                }
                
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                } else if (xhr.responseText) {
                    try {
                        var errorData = JSON.parse(xhr.responseText);
                        if (errorData.error) errorMessage = errorData.error;
                    } catch (e) {
                        // Use default error message
                    }
                }
                
                alert(errorMessage);
            }
        });
    }
}

function deleteInvoice(invoiceId) {
    if (confirm('Are you sure you want to delete this invoice? This action cannot be undone.')) {
        $.ajax({
            url: `/invoices/${invoiceId}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert('Invoice deleted successfully!');
                location.reload();
            },
            error: function(xhr) {
                var errorMessage = 'Error deleting invoice';
                
                if (xhr.status === 401) {
                    errorMessage = 'Please login to delete invoices';
                    // Redirect to login if not authenticated
                    if (xhr.responseText.includes('login') || xhr.responseText.includes('unauthorized')) {
                        window.location.href = '/login';
                        return;
                    }
                } else if (xhr.status === 403) {
                    errorMessage = 'You are not authorized to delete this invoice';
                } else if (xhr.status === 404) {
                    errorMessage = 'Invoice not found';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error occurred while deleting invoice';
                }
                
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                alert(errorMessage);
            }
        });
    }
}
</script>
@endsection
@endsection
