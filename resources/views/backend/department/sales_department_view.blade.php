@extends('admin.admin_master')

@section('admin')
@section('page-title', 'Sales Department - Qualified Leads')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-chart-line text-primary"></i>
                        Qualified Leads
                    </h4>
                    <div>
                        <button class="btn btn-outline-success btn-sm me-2" onclick="updateInvoiceStatuses()" title="Refresh Invoice Statuses">
                            <i class="fas fa-sync-alt"></i> Refresh Status
                        </button>
                        <a href="{{ route('quotations.index') }}" class="btn btn-primary">
                            <i class="fas fa-file-invoice"></i>
                        Quotation Management
                    </a>
                </div>
                <div class="card-body">
                    <!-- Success Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <!-- Email Sent Messages -->
                    @if(session('email_sent'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-envelope"></i> {{ session('email_sent') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <!-- Error Messages -->
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(isset($qualifiedLeads) && $qualifiedLeads->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="qualifiedLeadsTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Budget</th>
                                        <th>Priority</th>
                                        <th>Assigned To</th>
                                        <th>Created Date</th>
                                        <th>Invoice Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1; @endphp
                                    @foreach($qualifiedLeads as $lead)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>
                                            <strong>{{ $lead->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $lead->city ?? 'N/A' }}, {{ $lead->state ?? 'N/A' }}</small>
                                        </td>
                                        <td>{{ $lead->company_name ?? 'N/A' }}</td>
                                        <td>{{ $lead->email }}</td>
                                        <td>{{ $lead->phone }}</td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $lead->budget ? '$'.number_format($lead->budget, 2) : 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $lead->getPriorityColor() }}">
                                                {{ ucfirst($lead->priority) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($lead->assignedUser)
                                                <span class="badge bg-primary">{{ $lead->assignedUser->name }}</span>
                                            @else
                                                <span class="badge bg-secondary">Unassigned</span>
                                            @endif
                                        </td>
                                        <td>{{ $lead->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $lead->getInvoiceStatusColor() }}" id="invoice-status-{{ $lead->id }}">
                                                {{ ucfirst(str_replace('_', ' ', $lead->invoice_status ?? 'waiting_for_approval')) }}
                                            </span>
                                            @if($lead->invoice_number)
                                                <br><small class="text-muted">{{ $lead->invoice_number }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-info" onclick="viewLead({{ $lead->id }})" title="View Lead">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning" onclick="editLead({{ $lead->id }})" title="Edit Lead">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @if(!$lead->invoice_number)
                                                <a href="{{ route('sales.department.create-invoice', $lead->id) }}" class="btn btn-sm btn-success" title="Create Invoice">
                                                    <i class="fas fa-file-invoice"></i> Create Invoice
                                                </a>
                                                @endif
                                                @if($lead->invoice_number && ($lead->invoice_status == 'waiting_for_approval' || $lead->invoice_status == 'waiting_for_approval'))
                                                <button class="btn btn-sm btn-primary" onclick="sendApprovalEmail({{ $lead->id }}, '{{ $lead->email }}', '{{ $lead->invoice_number }}')" title="Send Approval Email">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                                @endif
                                                <button class="btn btn-sm btn-danger" onclick="softDeleteLead({{ $lead->id }})" title="Soft Delete Lead">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-lead text-muted fa-3x mb-3"></i>
                            <h5 class="text-muted">No Qualified Leads Found</h5>
                            <p class="text-muted">There are currently no leads with "Qualified" status.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function createQuotation() {
    // Placeholder for quotation creation functionality
    alert('Quotation creation functionality will be implemented here.');
}

function viewLead(leadId) {
    // Redirect to lead view page
    window.location.href = '/leadsmanagement/' + leadId;
}

function editLead(leadId) {
    // Redirect to lead edit page
    window.location.href = '/leadsmanagement/' + leadId + '/edit';
}

function softDeleteLead(leadId) {
    if(confirm('Are you sure you want to soft delete this lead? This can be restored later.')) {
        // Implement soft delete logic here
        console.log('Soft deleting lead ID: ' + leadId);
        // You can make an AJAX call to soft delete the lead
        fetch('/leadsmanagement/' + leadId + '/soft-delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Lead soft deleted successfully!');
                location.reload();
            } else {
                alert('Error deleting lead: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting lead');
        });
    }
}

function amountFinalization(leadId) {
    // Placeholder for amount finalization functionality
    if(confirm('Are you sure you want to proceed with amount finalization for this lead?')) {
        // Implement amount finalization logic here
        console.log('Amount finalization for lead ID: ' + leadId);
    }
}

function createInvoiceFromLead(leadId) {
    // Redirect to create invoice page with lead data
    window.location.href = '/sales-department/' + leadId + '/create-invoice';
}

function approveLead(leadId) {
    // Placeholder for approval functionality
    if(confirm('Are you sure you want to approve this lead?')) {
        // Implement approval logic here
        console.log('Approving lead ID: ' + leadId);
    }
}

function sendApprovalEmail(leadId, email, invoiceNumber) {
    if(confirm('Are you sure you want to send approval email to ' + email + ' for invoice ' + invoiceNumber + '?')) {
        // Show loading state
        const button = event.target;
        const originalHtml = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        
        // Get CSRF token with fallback
        let csrfToken = '';
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag) {
            csrfToken = metaTag.getAttribute('content');
        } else {
            // Fallback: try to get from hidden input
            const csrfInput = document.querySelector('input[name="_token"]');
            if (csrfInput) {
                csrfToken = csrfInput.value;
            }
        }
        
        console.log('CSRF Token:', csrfToken ? 'Found' : 'Not found');
        console.log('Lead ID:', leadId);
        console.log('Email:', email);
        
        if (!csrfToken) {
            alert('CSRF token not found. Please refresh the page and try again.');
            button.disabled = false;
            button.innerHTML = originalHtml;
            return;
        }
        
        fetch('/sales-department/' + leadId + '/send-approval-email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                lead_id: leadId,
                email: email,
                invoice_number: invoiceNumber
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Show detailed success message
                const successDiv = document.createElement('div');
                successDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
                successDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 400px; max-width: 600px;';
                successDiv.innerHTML = `
                    <div class="d-flex align-items-start">
                        <i class="fas fa-check-circle fa-2x me-3 mt-1"></i>
                        <div class="flex-grow-1">
                            <h6 class="mb-2">📧 Email Processed Successfully!</h6>
                            <p class="mb-2"><strong>To:</strong> ${email}</p>
                            <p class="mb-2"><strong>Invoice:</strong> ${invoiceNumber}</p>
                            <p class="mb-0 text-muted small">${data.message}</p>
                            <hr class="my-2">
                            <small class="text-muted">
                                <strong>Note:</strong> If the email doesn't arrive, check Laravel logs for SMTP configuration issues.
                                The system may have logged the email for debugging if SMTP failed.
                            </small>
                        </div>
                        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>
                    </div>
                `;
                document.body.appendChild(successDiv);
                
                // Immediately check for status updates (in case approval happens quickly)
                setTimeout(() => {
                    updateInvoiceStatuses();
                }, 2000);
                
                // Auto-remove after 8 seconds
                setTimeout(() => {
                    if(successDiv.parentNode) {
                        successDiv.remove();
                    }
                }, 8000);
            } else {
                // Show detailed error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                errorDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 400px; max-width: 600px;';
                errorDiv.innerHTML = `
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-triangle fa-2x me-3 mt-1"></i>
                        <div class="flex-grow-1">
                            <h6 class="mb-2">❌ Email Sending Failed</h6>
                            <p class="mb-2"><strong>To:</strong> ${email}</p>
                            <p class="mb-2"><strong>Invoice:</strong> ${invoiceNumber}</p>
                            <p class="mb-0"><strong>Error:</strong> ${data.message}</p>
                            <hr class="my-2">
                            <small class="text-muted">
                                <strong>Troubleshooting:</strong><br>
                                1. Check mail configuration in .env file<br>
                                2. Verify SMTP credentials are correct<br>
                                3. Check Laravel logs: storage/logs/laravel.log<br>
                                4. Test with: <a href="/test_email.html" target="_blank">/test_email.html</a>
                            </small>
                        </div>
                        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>
                    </div>
                `;
                document.body.appendChild(errorDiv);
                
                // Auto-remove after 10 seconds
                setTimeout(() => {
                    if(errorDiv.parentNode) {
                        errorDiv.remove();
                    }
                }, 10000);
            }
            // Reset button state
            button.disabled = false;
            button.innerHTML = originalHtml;
        })
        .catch(error => {
            console.error('Network Error Details:', error);
            console.error('Error Status:', error.status);
            console.error('Error Message:', error.message);
            
            // Try alternative method with form data
            console.log('Trying alternative method...');
            
            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('lead_id', leadId);
            formData.append('email', email);
            formData.append('invoice_number', invoiceNumber);
            
            fetch('/sales-department/' + leadId + '/send-approval-email', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Alternative method success:', data);
                if(data.success) {
                    // Show success message
                    const successDiv = document.createElement('div');
                    successDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
                    successDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 400px; max-width: 600px;';
                    successDiv.innerHTML = `
                        <div class="d-flex align-items-start">
                            <i class="fas fa-check-circle fa-2x me-3 mt-1"></i>
                            <div class="flex-grow-1">
                                <h6 class="mb-2">📧 Email Sent Successfully!</h6>
                                <p class="mb-2"><strong>To:</strong> ${email}</p>
                                <p class="mb-2"><strong>Invoice:</strong> ${invoiceNumber}</p>
                                <p class="mb-0 text-muted small">${data.message}</p>
                            </div>
                            <button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                    document.body.appendChild(successDiv);
                    setTimeout(() => {
                        if(successDiv.parentNode) {
                            successDiv.remove();
                        }
                    }, 8000);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(formError => {
                console.error('Form method also failed:', formError);
                
                // Show detailed network error message
                const networkDiv = document.createElement('div');
                networkDiv.className = 'alert alert-warning alert-dismissible fade show position-fixed';
                networkDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 400px; max-width: 600px;';
                networkDiv.innerHTML = `
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-triangle fa-2x me-3 mt-1"></i>
                        <div class="flex-grow-1">
                            <h6 class="mb-2">⚠️ Network Error - Debug Info</h6>
                            <p class="mb-2"><strong>Original Error:</strong> ${error.message}</p>
                            <p class="mb-2"><strong>Status:</strong> ${error.status || 'Unknown'}</p>
                            <p class="mb-2"><strong>URL:</strong> /sales-department/${leadId}/send-approval-email</p>
                            <hr class="my-2">
                            <p class="mb-2"><strong>Troubleshooting Steps:</strong></p>
                            <ol class="mb-0 small">
                                <li>Check browser console (F12) for more details</li>
                                <li>Verify the route exists: php artisan route:list</li>
                                <li>Check Laravel logs: storage/logs/laravel.log</li>
                                <li>Try refreshing the page</li>
                                <li>Test with: <a href="/test_email.html" target="_blank">/test_email.html</a></li>
                            </ol>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-outline-primary" onclick="testDirectLink('${leadId}')">Test Direct Link</button>
                                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="location.reload()">Refresh Page</button>
                            </div>
                        </div>
                        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>
                    </div>
                `;
                document.body.appendChild(networkDiv);
                
                setTimeout(() => {
                    if(networkDiv.parentNode) {
                        networkDiv.remove();
                    }
                }, 15000);
            })
            .finally(() => {
                // Reset button state
                button.disabled = false;
                button.innerHTML = originalHtml;
            });
        });
    }
}

function testDirectLink(leadId) {
    console.log('Testing direct link for lead:', leadId);
    
    // Open the route in a new tab to test if it exists
    const testWindow = window.open('/sales-department/' + leadId + '/send-approval-email', '_blank', 'width=600,height=400');
    
    setTimeout(() => {
        if (testWindow && !testWindow.closed) {
            console.log('Route appears to be accessible');
            testWindow.close();
        } else {
            console.log('Route might not exist or returned an error');
        }
    }, 3000);
}

 // Automatically refresh all data on page load
    setTimeout(() => {
        refreshAllData();
    }, 1000);
    
// Initialize DataTable for better table functionality
$(document).ready(function() {
    console.log('Sales department page loaded');
    
    $('#qualifiedLeadsTable').DataTable({
        "pageLength": 25,
        "order": [[ 0, "desc" ]],
        "responsive": true,
        "language": {
            "emptyTable": "No qualified leads available"
        }
    });
    
    console.log('DataTable initialized successfully.');
    
    // Start real-time status updates
    startRealTimeUpdates();
});

// Real-time status update functionality
function startRealTimeUpdates() {
    // Check for status updates every 10 seconds (faster for testing)
    setInterval(function() {
        updateInvoiceStatuses();
    }, 10000);
    
    // Initial status check
    updateInvoiceStatuses();
}

function updateInvoiceStatuses() {
    $.ajax({
        url: '/api/sales-department/invoice-statuses',
        method: 'GET',
        success: function(data) {
            if(data.statuses) {
                Object.keys(data.statuses).forEach(function(leadId) {
                    var statusInfo = data.statuses[leadId];
                    var statusElement = $('#invoice-status-' + leadId);
                    
                    if(statusElement.length > 0) {
                        // Update status text and color
                        statusElement.removeClass('bg-success bg-danger bg-warning bg-info bg-secondary');
                        statusElement.addClass('bg-' + statusInfo.color);
                        statusElement.text(statusInfo.status);
                        
                        // Add animation for status change
                        statusElement.addClass('animate__animated animate__flash');
                        setTimeout(function() {
                            statusElement.removeClass('animate__animated animate__flash');
                        }, 1000);
                        
                        // Show notification if status changed to approved
                        if(statusInfo.status === 'Approved') {
                            showApprovalNotification(leadId, statusInfo.invoiceNumber);
                        }
                    }
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Failed to update invoice statuses:', error);
        }
    });
}

function showApprovalNotification(leadId, invoiceNumber) {
    // Create notification element
    var notification = $('<div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
        '<strong>✅ Invoice Approved!</strong><br>' +
        'Invoice ' + invoiceNumber + ' has been approved by the client.' +
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
        '</div>');
    
    $('body').append(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(function() {
        notification.fadeOut(function() {
            notification.remove();
        });
    }, 5000);
    
    // Play notification sound if available
    if(typeof playNotificationSound === 'function') {
        playNotificationSound();
    }
}

// Show success popup on page load if success message exists
$(document).ready(function() {
    // Check for success messages and show popup
    @if(session('success'))
    showSuccessPopup('{{ session('success') }}');
    @endif
    
    @if(session('email_sent'))
    showEmailPopup('{{ session('email_sent') }}');
    @endif
    
    @if(session('error'))
    showErrorPopup('{{ session('error') }}');
    @endif
});

function showSuccessPopup(message) {
    var notification = $('<div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 350px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">' +
        '<div class="d-flex align-items-center">' +
        '<i class="fas fa-check-circle fa-2x me-3"></i>' +
        '<div>' +
        '<strong>✅ Success!</strong><br>' +
        '<span>' + message + '</span>' +
        '</div>' +
        '<button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>' +
        '</div>' +
        '</div>');
    
    $('body').append(notification);
    
    // Auto-remove after 6 seconds
    setTimeout(function() {
        notification.fadeOut(function() {
            notification.remove();
        });
    }, 6000);
}

function showEmailPopup(message) {
    var notification = $('<div class="alert alert-info alert-dismissible fade show position-fixed" style="top: 80px; right: 20px; z-index: 9999; min-width: 350px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">' +
        '<div class="d-flex align-items-center">' +
        '<i class="fas fa-envelope fa-2x me-3"></i>' +
        '<div>' +
        '<strong>📧 Email Sent!</strong><br>' +
        '<span>' + message + '</span>' +
        '</div>' +
        '<button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>' +
        '</div>' +
        '</div>');
    
    $('body').append(notification);
    
    // Auto-remove after 6 seconds
    setTimeout(function() {
        notification.fadeOut(function() {
            notification.remove();
        });
    }, 6000);
}

function showErrorPopup(message) {
    var notification = $('<div class="alert alert-danger alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 350px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">' +
        '<div class="d-flex align-items-center">' +
        '<i class="fas fa-exclamation-circle fa-2x me-3"></i>' +
        '<div>' +
        '<strong>❌ Error!</strong><br>' +
        '<span>' + message + '</span>' +
        '</div>' +
        '<button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>' +
        '</div>' +
        '</div>');
    
    $('body').append(notification);
    
    // Auto-remove after 8 seconds
    setTimeout(function() {
        notification.fadeOut(function() {
            notification.remove();
        });
    }, 8000);
}
</script>
@endsection
