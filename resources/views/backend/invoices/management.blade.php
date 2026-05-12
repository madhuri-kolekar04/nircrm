@extends('admin.admin_master')

@section('page-title', 'Invoice Management')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="fas fa-tasks"></i> Invoice Management
                            </h5>
                            <p class="mb-0 mt-1">Quotation: {{ $quotation->quotation_number }} | Client: {{ $quotation->client_contact_name }}</p>
                        </div>
                        <div>
                            <a href="{{ route('accounts.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Accounts
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('email_sent'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-envelope"></i> {{ session('email_sent') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Quotation Summary -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h6 class="text-muted">Quotation Number</h6>
                                                <h5 class="text-primary">{{ $quotation->quotation_number }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h6 class="text-muted">Client Name</h6>
                                                <h5>{{ $quotation->client_contact_name }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h6 class="text-muted">Total Amount</h6>
                                                <h5 class="text-success">₹{{ number_format($quotation->final_amount, 2) }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h6 class="text-muted">Invoice Status</h6>
                                                <h5>
                                                    <span class="badge bg-{{ $quotation->getInvoiceStatusColorAttribute() }}">
                                                        <i class="{{ $quotation->getInvoiceStatusIconAttribute() }}"></i>
                                                        {{ $quotation->invoice_status }}
                                                    </span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-dark">
                                        <i class="fas fa-plus-circle text-primary"></i> Quick Actions - Create New Installment Invoice
                                    </h6>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInstallmentModal">
                                        <i class="fas fa-plus"></i> Add Custom Installment
                                    </button>
                                </div>
                                <div class="card-body bg-light">
                                    <div class="row g-3" id="installmentButtons">
                                        <!-- Standard installment buttons with clean design -->
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                            <a href="{{ route('invoices.create-installment', [$quotation->id, 'A']) }}" 
                                               class="btn btn-outline-primary btn-sm w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none installment-btn">
                                                <i class="fas fa-file-invoice mb-2 fa-lg"></i>
                                                <span class="fw-semibold">Invoice A</span>
                                                <small class="text-muted">First Installment</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                            <a href="{{ route('invoices.create-installment', [$quotation->id, 'B']) }}" 
                                               class="btn btn-outline-info btn-sm w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none installment-btn">
                                                <i class="fas fa-file-invoice mb-2 fa-lg"></i>
                                                <span class="fw-semibold">Invoice B</span>
                                                <small class="text-muted">Second Installment</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                            <a href="{{ route('invoices.create-installment', [$quotation->id, 'C']) }}" 
                                               class="btn btn-outline-warning btn-sm w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none installment-btn">
                                                <i class="fas fa-file-invoice mb-2 fa-lg"></i>
                                                <span class="fw-semibold">Invoice C</span>
                                                <small class="text-muted">Third Installment</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                            <a href="{{ route('invoices.create-installment', [$quotation->id, 'D']) }}" 
                                               class="btn btn-outline-danger btn-sm w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none installment-btn">
                                                <i class="fas fa-file-invoice mb-2 fa-lg"></i>
                                                <span class="fw-semibold">Invoice D</span>
                                                <small class="text-muted">Fourth Installment</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                            <a href="{{ route('invoices.create-installment', [$quotation->id, 'E']) }}" 
                                               class="btn btn-outline-secondary btn-sm w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none installment-btn">
                                                <i class="fas fa-file-invoice mb-2 fa-lg"></i>
                                                <span class="fw-semibold">Invoice E</span>
                                                <small class="text-muted">Fifth Installment</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                            <a href="{{ route('invoices.create-installment', [$quotation->id, 'F']) }}" 
                                               class="btn btn-outline-dark btn-sm w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none installment-btn">
                                                <i class="fas fa-file-invoice mb-2 fa-lg"></i>
                                                <span class="fw-semibold">Invoice F</span>
                                                <small class="text-muted">Sixth Installment</small>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="alert alert-info mt-3 mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Quick Guide:</strong> Click on any installment letter to create an invoice, or use "Add Custom Installment" for personalized installment names.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoices Table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-list"></i> All Invoices for {{ $quotation->quotation_number }}
                                        <span class="badge bg-primary float-end">{{ $invoices->count() }} Invoice(s)</span>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @if($invoices->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" id="invoicesTable">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th width="5%">#</th>
                                                        <th width="15%">Invoice Number</th>
                                                        <th width="20%">Client Details</th>
                                                        <th width="15%">Amount</th>
                                                        <th width="10%">Status</th>
                                                        <th width="10%">Mail Approval Status</th>
                                                        <th width="10%">Date</th>
                                                        <th width="10%">Email Sent</th>
                                                        <th width="10%">Mail ID</th>
                                                        <th width="10%">Approval</th>
                                                        <th width="10%">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $counter = 1; @endphp
                                                    @foreach($invoices as $invoice)
                                                        <tr class="invoice-row" data-invoice-id="{{ $invoice->id }}">
                                                            <td>{{ $counter++ }}</td>
                                                            <td>
                                                                <strong>{{ $invoice->invoice_number }}</strong>
                                                                <br>
                                                                <small class="text-muted">{{ $invoice->department }}</small>
                                                            </td>
                                                            <td>
                                                                <strong>{{ $invoice->customer_name }}</strong>
                                                                <br>
                                                                <small class="text-muted">{{ $invoice->customer_email }}</small>
                                                                <br>
                                                                <small class="text-muted">{{ $invoice->customer_phone }}</small>
                                                                <br>
                                                                <small class="text-info"><strong>Mail ID: {{ $invoice->mail_id ?? 'N/A' }}</strong></small>
                                                            </td>
                                                            <td>
                                                                <strong class="text-success">₹{{ number_format($invoice->total_payment, 2) }}</strong>
                                                                <br>
                                                                <small class="text-muted">GST: ₹{{ number_format($invoice->gst, 2) }}</small>
                                                            </td>
                                                            <td class="regular-status">
                                                                <span class="badge bg-{{ $invoice->status == 'completed' ? 'success' : ($invoice->status == 'pending' ? 'warning' : 'danger') }}">
                                                                    {{ ucfirst($invoice->status) }}
                                                                </span>
                                                            </td>
                                                            <td class="mail-approval-status">
                                                                @if($invoice->mail_approval_status == 'approved')
                                                                    <span class="badge bg-success">
                                                                        <i class="fas fa-check-circle"></i> Mail Approved
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-warning">
                                                                        <i class="fas fa-clock"></i> Mail Pending
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $invoice->invoice_date }}
                                                                <br>
                                                                <small class="text-muted">{{ $invoice->created_at->format('M d, Y') }}</small>
                                                            </td>
                                                            <td>
                                                                @if($invoice->created_at->diffInHours() < 24)
                                                                    <span class="badge bg-success">
                                                                        <i class="fas fa-check"></i> Sent
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-secondary">
                                                                        <i class="fas fa-clock"></i> {{ $invoice->created_at->diffForHumans() }}
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <code class="text-info">{{ $invoice->mail_id ?? 'N/A' }}</code>
                                                            </td>
                                                            <td class="approval-section">
                                                                @if($invoice->status == 'pending')
                                                                    <button type="button" class="btn btn-sm btn-success" onclick="sendApprovalEmail({{ $invoice->id }}, '{{ $invoice->customer_email }}', '{{ $invoice->invoice_number }}', '{{ $invoice->mail_id ?? 'N/A' }}')">
                                                                        <i class="fas fa-envelope"></i> Send Approval
                                                                    </button>
                                                                @elseif($invoice->status == 'approved')
                                                                    <span class="badge bg-success">
                                                                        <i class="fas fa-check-circle"></i> Approved
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-secondary">
                                                                        <i class="fas fa-clock"></i> {{ $invoice->status }}
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="{{ route('invoices.view', $invoice->id) }}" class="btn btn-sm btn-primary" title="View Invoice">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <form action="{{ route('invoices.delete', $invoice->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this invoice?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete Invoice">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                                            <h4 class="text-muted">No Invoices Found</h4>
                                            <p class="text-muted">Click on any installment letter above to create the first invoice for this quotation.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Installment Modal -->
<div class="modal fade" id="addInstallmentModal" tabindex="-1" aria-labelledby="addInstallmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInstallmentModalLabel">
                    <i class="fas fa-plus-circle"></i> Add New Installment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addInstallmentForm">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="installmentName" class="form-label">Installment Name</label>
                        <input type="text" class="form-control" id="installmentName" name="installmentName" 
                               placeholder="Enter installment name (e.g., G, H, Advance, Final, etc.)" 
                               maxlength="20" required>
                        <small class="form-text text-muted">Enter a name for the new installment (letters, numbers, or words)</small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="installmentColor" class="form-label">Button Color</label>
                        <select class="form-select" id="installmentColor" name="installmentColor">
                            <option value="primary">Primary (Blue)</option>
                            <option value="success">Success (Green)</option>
                            <option value="info">Info (Light Blue)</option>
                            <option value="warning">Warning (Yellow)</option>
                            <option value="danger">Danger (Red)</option>
                            <option value="secondary">Secondary (Gray)</option>
                            <option value="dark">Dark (Black)</option>
                            <option value="light">Light (White)</option>
                        </select>
                        <small class="form-text text-muted">Choose a color for the installment button</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="addCustomInstallment()">
                    <i class="fas fa-plus"></i> Add Installment
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Store custom installments
let customInstallments = [];

$(document).ready(function() {
    // Load saved custom installments from localStorage
    loadCustomInstallments();
    
    // Initialize DataTables for invoices table
    $('#invoicesTable').DataTable({
        "pageLength": 25,
        "order": [[ 5, "desc" ]], // Sort by date
        "responsive": true,
        "language": {
            "search": "Search invoices:",
            "lengthMenu": "Show _MENU_ invoices per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ invoices",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });

    // Auto-refresh invoice statuses every 30 seconds
    setInterval(function() {
        updateInvoiceStatuses();
    }, 30000);

    function updateInvoiceStatuses() {
        $.get('{{ route("invoices.api.statuses") }}', {
            quotation_ids: [{{ $quotation->id }}]
        }, function(data) {
            // Update status badges in the table
            data.invoices.forEach(function(invoice) {
                $('tbody tr').each(function() {
                    var row = $(this);
                    var invoiceNumber = row.find('td:nth-child(2) strong').text();
                    
                    if (invoiceNumber === invoice.invoice_number) {
                        // Update status badge
                        var statusBadge = row.find('td:nth-child(5) .badge');
                        statusBadge.removeClass('bg-success bg-warning bg-danger')
                                   .addClass('bg-' + (invoice.status === 'completed' ? 'success' : (invoice.status === 'pending' ? 'warning' : 'danger')))
                                   .text(invoice.status.charAt(0).toUpperCase() + invoice.status.slice(1));
                        
                        // Add animation
                        statusBadge.addClass('animate__animated animate__pulse');
                        setTimeout(function() {
                            statusBadge.removeClass('animate__animated animate__pulse');
                        }, 1000);
                    }
                });
            });
        });
    }

    // Add hover effects to installment buttons
    $('.installment-btn').hover(
        function() {
            $(this).addClass('shadow-sm').removeClass('shadow-none');
        },
        function() {
            $(this).removeClass('shadow-sm').addClass('shadow-none');
        }
    );
});

// Load custom installments from localStorage
function loadCustomInstallments() {
    const saved = localStorage.getItem('customInstallments_' + {{ $quotation->id }});
    if (saved) {
        customInstallments = JSON.parse(saved);
        customInstallments.forEach(installment => {
            addInstallmentButton(installment.name, installment.color);
        });
    }
}

// Save custom installments to localStorage
function saveCustomInstallments() {
    localStorage.setItem('customInstallments_' + {{ $quotation->id }}, JSON.stringify(customInstallments));
}

// Add custom installment function
function addCustomInstallment() {
    const name = $('#installmentName').val().trim();
    const color = $('#installmentColor').val();
    
    if (!name) {
        alert('Please enter an installment name');
        return;
    }
    
    // Check if installment already exists
    if (customInstallments.find(inst => inst.name.toLowerCase() === name.toLowerCase())) {
        alert('Installment "' + name + '" already exists');
        return;
    }
    
    // Add to custom installments array
    customInstallments.push({ name: name, color: color });
    saveCustomInstallments();
    
    // Add button to UI
    addInstallmentButton(name, color);
    
    // Close modal and reset form
    $('#addInstallmentModal').modal('hide');
    $('#addInstallmentForm')[0].reset();
    
    // Show success message
    showNotification('Installment "' + name + '" added successfully!', 'success');
}

// Add installment button to UI
function addInstallmentButton(name, color) {
    const baseUrl = "/invoices/create-installment/{{ $quotation->id }}/";
    const encodedName = encodeURIComponent(name);
    const url = baseUrl + encodedName;
    
    const buttonHtml = `
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 custom-installment" data-installment="${name}">
            <a href="${url}" 
               class="btn btn-outline-${color} btn-sm w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none installment-btn animate__animated animate__fadeIn">
                <i class="fas fa-file-invoice mb-2 fa-lg"></i>
                <span class="fw-semibold">Invoice ${name}</span>
                <small class="text-muted">Custom Installment</small>
            </a>
            <button type="button" class="btn btn-sm btn-outline-danger w-100 mt-1" 
                    onclick="removeCustomInstallment('${name}')" title="Remove Installment">
                <i class="fas fa-trash"></i> Remove
            </button>
        </div>
    `;
    
    $('#installmentButtons').append(buttonHtml);
    
    // Re-attach hover effects
    $('.installment-btn').hover(
        function() {
            $(this).addClass('shadow-sm').removeClass('shadow-none');
        },
        function() {
            $(this).removeClass('shadow-sm').addClass('shadow-none');
        }
    );
}

// Remove custom installment
function removeCustomInstallment(name) {
    if (confirm('Are you sure you want to remove installment "' + name + '"?')) {
        // Remove from array
        customInstallments = customInstallments.filter(inst => inst.name !== name);
        saveCustomInstallments();
        
        // Remove from UI
        $(`[data-installment="${name}"]`).remove();
        
        // Show success message
        showNotification('Installment "' + name + '" removed successfully!', 'warning');
    }
}

// Show notification
function showNotification(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'warning' ? 'alert-warning' : 'alert-info';
    
    const notification = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999;" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('body').append(notification);
    
    // Auto-remove after 3 seconds
    setTimeout(() => {
        $('.alert').fadeOut();
    }, 3000);
}

// Send approval email function
function sendApprovalEmail(invoiceId, customerEmail, invoiceNumber, mailId) {
    console.log('=== sendApprovalEmail called ===');
    console.log('invoiceId:', invoiceId);
    console.log('customerEmail:', customerEmail);
    console.log('invoiceNumber:', invoiceNumber);
    console.log('mailId:', mailId);
    
    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded!');
        alert('Error: jQuery is not loaded. Please refresh the page.');
        return;
    }
    
    // Check CSRF token
    const csrfToken = '{{ csrf_token() }}';
    console.log('CSRF Token:', csrfToken);
    
    if (confirm(`Send approval email for invoice ${invoiceNumber} (Mail ID: ${mailId}) to ${customerEmail}?`)) {
        console.log('User confirmed, preparing AJAX request...');
        
        const requestData = {
            invoice_id: invoiceId,
            customer_email: customerEmail,
            invoice_number: invoiceNumber,
            mail_id: mailId,
            _token: csrfToken
        };
        
        console.log('Request data:', requestData);
        console.log('Request URL:', '/invoices/send-approval-email');
        
        $.ajax({
            url: '/invoices/send-approval-email',
            method: 'POST',
            data: requestData,
            dataType: 'json',
            beforeSend: function(xhr) {
                console.log('Sending request...');
                console.log('Request headers:', xhr);
            },
            success: function(response) {
                console.log('=== SUCCESS ===');
                console.log('Response:', response);
                showNotification(response.message, 'success');
                // Refresh table to show updated mail ID and status
                refreshInvoiceTable();
            },
            error: function(xhr, status, error) {
                console.log('=== ERROR ===');
                console.log('XHR:', xhr);
                console.log('Status:', status);
                console.log('Error:', error);
                console.log('Response text:', xhr.responseText);
                console.log('Response JSON:', xhr.responseJSON);
                
                let errorMsg = 'Unknown error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    errorMsg = xhr.responseText;
                }
                
                showNotification('Failed to send approval email: ' + errorMsg, 'warning');
            },
            complete: function(xhr) {
                console.log('Request completed');
                console.log('Final status:', xhr.status);
            }
        });
    } else {
        console.log('User cancelled the action');
    }
}

// Real-time status update function
function updateMailApprovalStatus(invoiceId) {
    console.log('Updating mail approval status for invoice:', invoiceId);
    
    $.ajax({
        url: '/invoices/check-approval-status/' + invoiceId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('Status check response:', response);
            
            if (response.mail_approval_status === 'approved') {
                // Update the mail approval status badge
                const statusCell = $('#invoice-' + invoiceId + ' .mail-approval-status');
                statusCell.html(`
                    <span class="badge bg-success">
                        <i class="fas fa-check-circle"></i> Mail Approved
                    </span>
                `);
                
                // Update the approval button section
                const approvalCell = $('#invoice-' + invoiceId + ' .approval-section');
                approvalCell.html(`
                    <span class="badge bg-success">
                        <i class="fas fa-check-circle"></i> Approved
                    </span>
                `);
                
                // Update the regular status badge
                const regularStatusCell = $('#invoice-' + invoiceId + ' .regular-status');
                regularStatusCell.html(`
                    <span class="badge bg-success">
                        Approved
                    </span>
                `);
                
                showNotification('Invoice status updated successfully!', 'success');
            }
        },
        error: function(xhr, status, error) {
            console.log('Error checking status:', error);
        }
    });
}

// Auto-check approval status every 5 seconds
setInterval(function() {
    $('.invoice-row').each(function() {
        const invoiceId = $(this).data('invoice-id');
        if (invoiceId) {
            updateMailApprovalStatus(invoiceId);
        }
    });
}, 5000);

// Refresh invoice table function
function refreshInvoiceTable() {
    console.log('Refreshing invoice table...');
    
    // Show loading state
    showNotification('Refreshing invoice data...', 'info');
    
    // Reload the page to show updated status
    setTimeout(function() {
        window.location.reload();
    }, 2000);
}

</script>

<style>
.installment-btn {
    transition: all 0.3s ease;
    border-radius: 8px !important;
    min-height: 100px;
    background: white !important;
    border: 2px solid !important;
}

.installment-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

.installment-btn .fas {
    transition: transform 0.3s ease;
}

.installment-btn:hover .fas {
    transform: scale(1.1);
}

.installment-btn span {
    transition: color 0.3s ease;
}

.installment-btn:hover span {
    color: #0d6efd !important;
}

.card.border-0.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.card-header.bg-white {
    background-color: #fff !important;
    border-bottom: 1px solid #dee2e6 !important;
}

.alert-info {
    border-left: 4px solid #0d6efd;
    background-color: #f8f9fa;
    border-color: #b8daff;
}
</style>
@endpush
