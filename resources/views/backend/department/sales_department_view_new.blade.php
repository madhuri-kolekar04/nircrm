@extends('admin.admin_master')

@section('page-title', 'Sales Department - Qualified Leads')
@section('admin')
<style>
.lead-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border-left: 4px solid #667eea;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #667eea;
}

.stat-label {
    color: #6c757d;
    font-size: 0.9rem;
    margin-top: 5px;
}

.table-modern {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.table-modern thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.table-modern th {
    border: none;
    padding: 15px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table-modern td {
    padding: 15px;
    vertical-align: middle;
    border-color: #f8f9fa;
}

.badge-status {
    padding: 8px 12px;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.85rem;
}

.btn-action {
    padding: 8px 12px;
    margin: 0 2px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.email-sent {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

.refresh-btn {
    transition: all 0.3s ease;
}

.refresh-btn:hover {
    transform: rotate(180deg);
}

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loading-content {
    background: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
}

.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<div class="container-fluid">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="spinner"></div>
            <h5>Processing...</h5>
            <p class="text-muted">Please wait while we process your request</p>
        </div>
    </div>

    <!-- Header Card -->
    <div class="lead-card">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="mb-0">
                    <i class="fas fa-chart-line me-3"></i>
                    Sales Department
                </h2>
                <p class="mb-0 mt-2 opacity-75">Manage qualified leads and invoice approvals</p>
            </div>
            <div class="col-md-6 text-md-end">
                <button class="btn btn-light btn-lg me-2" onclick="refreshAllData()">
                    <i class="fas fa-sync-alt refresh-btn"></i> Refresh All
                </button>
                <a href="{{ route('quotations.index') }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-file-invoice"></i> Quotations
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number" id="totalLeads">{{ $qualifiedLeads->count() }}</div>
            <div class="stat-label">Total Qualified Leads</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="waitingApproval">0</div>
            <div class="stat-label">Waiting Approval</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="approvedCount">0</div>
            <div class="stat-label">Approved</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="totalValue">$0</div>
            <div class="stat-label">Total Value</div>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div id="alertContainer"></div>

    <!-- Main Table -->
    <div class="table-modern">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="leadsTable">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Lead Details</th>
                        <th>Contact</th>
                        <th>Budget & Priority</th>
                        <th>Assignment</th>
                        <th>Created</th>
                        <th>Invoice Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($qualifiedLeads) && $qualifiedLeads->count() > 0)
                        @foreach($qualifiedLeads as $index => $lead)
                        <tr id="lead-row-{{ $lead->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                        {{ strtoupper(substr($lead->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold">{{ $lead->name }}</h6>
                                        <small class="text-muted">{{ $lead->company_name ?? 'No Company' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="contact-info">
                                    <div class="mb-2">
                                        <i class="fas fa-envelope text-muted me-2"></i>
                                        <small>{{ $lead->email }}</small>
                                    </div>
                                    <div>
                                        <i class="fas fa-phone text-muted me-2"></i>
                                        <small>{{ $lead->phone }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="budget-priority">
                                    <div class="mb-2">
                                        <span class="badge bg-success">${{ number_format($lead->budget ?? 0, 0) }}</span>
                                    </div>
                                    <div>
                                        <span class="badge bg-{{ $lead->getPriorityColor() ?? 'secondary' }}">
                                            {{ ucfirst($lead->priority ?? 'Medium') }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="assigned-user">
                                    @if($lead->assignedUser)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                {{ strtoupper(substr($lead->assignedUser->name, 0, 1)) }}
                                            </div>
                                            <small>{{ $lead->assignedUser->name }}</small>
                                        </div>
                                    @else
                                        <small class="text-muted">Unassigned</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <small>{{ $lead->created_at->format('M d, Y') }}</small>
                            </td>
                            <td>
                                <div class="invoice-status">
                                    <span class="badge badge-status bg-{{ $lead->getInvoiceStatusColor() }}" id="invoice-status-{{ $lead->id }}">
                                        {{ ucfirst(str_replace('_', ' ', $lead->invoice_status ?? 'waiting_for_approval')) }}
                                    </span>
                                    @if($lead->invoice_number)
                                        <br><small class="text-muted">{{ $lead->invoice_number }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-info btn-action" onclick="viewLead({{ $lead->id }})" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning btn-action" onclick="editLead({{ $lead->id }})" title="Edit Lead">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    @if(!$lead->invoice_number)
                                        <a href="{{ route('sales.department.create-invoice', $lead->id) }}" class="btn btn-sm btn-success btn-action" title="Create Invoice">
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                    @endif
                                    
                                    @if($lead->invoice_number && in_array($lead->invoice_status ?? 'waiting_for_approval', ['waiting_for_approval', 'waiting for approval']))
                                        <button class="btn btn-sm btn-primary btn-action" id="mail-btn-{{ $lead->id }}" onclick="sendApprovalEmail({{ $lead->id }}, '{{ $lead->email }}', '{{ $lead->invoice_number }}')" title="Send Approval Email">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                    @endif
                                    
                                    <button class="btn btn-sm btn-danger btn-action" onclick="deleteLead({{ $lead->id }})" title="Delete Lead">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-users text-muted fa-3x mb-3"></i>
                                <h5 class="text-muted">No Qualified Leads Found</h5>
                                <p class="text-muted">There are currently no leads with "Qualified" status.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Global variables
let refreshInterval;

// Initialize page
$(document).ready(function() {
    console.log('🚀 Sales Department page loaded');
    
    // Set up CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Refresh CSRF token periodically (every 30 minutes)
    setInterval(function() {
        refreshCsrfToken();
    }, 30 * 60 * 1000);
    
    // Initialize statistics
    updateStatistics();
    
    // Start real-time updates
    startRealTimeUpdates();
    
    // Initialize DataTable
    $('#leadsTable').DataTable({
        pageLength: 25,
        order: [[0, 'desc']],
        responsive: true,
        language: {
            emptyTable: "No qualified leads available",
            search: "Search leads:",
            lengthMenu: "Show _MENU_ leads per page"
        }
    });
    
    // Automatically refresh all data on page load (after all functions are defined)
    console.log('🚀 Setting up automatic refresh in 1 second...');
    
    // Multiple approaches to ensure refresh happens
    setTimeout(() => {
        console.log('⏰ Time elapsed - calling refreshAllData()');
        
        // Method 1: Call function directly
        try {
            refreshAllData();
            console.log('✅ Method 1 (direct function call) successful');
        } catch (e) {
            console.error('❌ Method 1 failed:', e);
        }
        
        // Method 2: Simulate button click
        setTimeout(() => {
            try {
                $('button[onclick*="refreshAllData()"]').click();
                console.log('✅ Method 2 (button click) successful');
            } catch (e) {
                console.error('❌ Method 2 failed:', e);
            }
        }, 500);
        
        // Method 3: Vanilla JavaScript approach
        setTimeout(() => {
            try {
                const refreshBtn = document.querySelector('button[onclick*="refreshAllData()"]');
                if (refreshBtn) {
                    refreshBtn.click();
                    console.log('✅ Method 3 (vanilla JS click) successful');
                } else {
                    console.error('❌ Method 3: Button not found');
                }
            } catch (e) {
                console.error('❌ Method 3 failed:', e);
            }
        }, 1000);
        
    }, 1000);
});

// Refresh CSRF token
function refreshCsrfToken() {
    $.get('/refresh-csrf').done(function(data) {
        $('meta[name="csrf-token"]').attr('content', data.token);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': data.token
            }
        });
        console.log('🔄 CSRF token refreshed');
    }).fail(function() {
        console.warn('⚠️ Failed to refresh CSRF token');
    });
}

// Update statistics
function updateStatistics() {
    let totalLeads = 0;
    let waitingApproval = 0;
    let approvedCount = 0;
    let totalValue = 0;
    
    $('#leadsTable tbody tr').each(function() {
        const row = $(this);
        const status = row.find('.badge-status').text().toLowerCase();
        const budgetText = row.find('.bg-success').text();
        
        totalLeads++;
        
        if (status.includes('waiting')) {
            waitingApproval++;
        } else if (status.includes('approved')) {
            approvedCount++;
        }
        
        // Extract budget value
        const budget = parseFloat(budgetText.replace(/[^0-9.]/g, '')) || 0;
        totalValue += budget;
    });
    
    // Update display with animation
    animateNumber('totalLeads', totalLeads);
    animateNumber('waitingApproval', waitingApproval);
    animateNumber('approvedCount', approvedCount);
    $('#totalValue').text('$' + numberFormat(totalValue));
}

// Animate number changes
function animateNumber(elementId, targetValue) {
    const element = document.getElementById(elementId);
    const currentValue = parseInt(element.textContent) || 0;
    const increment = (targetValue - currentValue) / 20;
    let current = currentValue;
    
    const timer = setInterval(() => {
        current += increment;
        if ((increment > 0 && current >= targetValue) || (increment < 0 && current <= targetValue)) {
            element.textContent = targetValue;
            clearInterval(timer);
        } else {
            element.textContent = Math.round(current);
        }
    }, 50);
}

// Format numbers
function numberFormat(num) {
    return num.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Real-time updates
function startRealTimeUpdates() {
    // Check for updates every 15 seconds
    refreshInterval = setInterval(() => {
        updateInvoiceStatuses();
    }, 15000);
    
    // Initial check
    updateInvoiceStatuses();
}

// Update invoice statuses
function updateInvoiceStatuses() {
    $.ajax({
        url: '/api/sales-department/invoice-statuses',
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        },
        success: function(data) {
            if (data.statuses) {
                let updated = false;
                Object.keys(data.statuses).forEach(leadId => {
                    const statusInfo = data.statuses[leadId];
                    const statusElement = $(`#invoice-status-${leadId}`);
                    
                    if (statusElement.length > 0) {
                        const currentStatus = statusElement.text().toLowerCase();
                        const newStatus = statusInfo.status.toLowerCase();
                        
                        if (currentStatus !== newStatus) {
                            // Update status
                            statusElement.removeClass('bg-success bg-danger bg-warning bg-info bg-secondary');
                            statusInfo.color = statusInfo.color || 'success';
                            statusElement.addClass(`bg-${statusInfo.color}`);
                            statusElement.text(statusInfo.status);
                            
                            // Update mail button visibility
                            const mailBtn = $(`#mail-btn-${leadId}`);
                            if (newStatus.includes('approved')) {
                                mailBtn.fadeOut();
                            } else if (newStatus.includes('waiting')) {
                                mailBtn.fadeIn();
                            }
                            
                            updated = true;
                        }
                    }
                });
                
                if (updated) {
                    updateStatistics();
                    showAlert('Statuses updated successfully!', 'success');
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Failed to update statuses:', error);
            console.error('XHR Status:', xhr.status);
            console.error('Response Text:', xhr.responseText);
            
            // Show specific error messages for debugging
            if (xhr.status === 401) {
                console.error('Authentication failed - user not logged in');
            } else if (xhr.status === 403) {
                console.error('Access forbidden - insufficient permissions');
            } else if (xhr.status === 404) {
                console.error('API endpoint not found');
            } else if (xhr.status === 500) {
                console.error('Server error - check Laravel logs');
            } else if (xhr.status === 0) {
                console.error('Network error - check connection');
            }
            
            // Don't show error to user for background updates to avoid spam
        }
    });
}

// Send approval email - Enhanced Version
function sendApprovalEmail(leadId, email, invoiceNumber) {
    if (!confirm(`Send invoice approval email to ${email} for invoice ${invoiceNumber}?`)) {
        return;
    }
    
    showLoading();
    
    const mailBtn = $(`#mail-btn-${leadId}`);
    const originalHtml = mailBtn.html();
    
    // Update button state
    mailBtn.html('<i class="fas fa-spinner fa-spin"></i>');
    mailBtn.prop('disabled', true);
    
    $.ajax({
        url: `/sales-department/${leadId}/send-approval-email`,
        method: 'POST',
        data: {
            lead_id: leadId,
            email: email,
            invoice_number: invoiceNumber,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            hideLoading();
            
            if (response.success) {
                // Show enhanced success message
                let successMessage = `✅ Email sent successfully to ${email}!`;
                
                if (response.data) {
                    successMessage += `\n📧 Invoice: ${response.data.invoice_number}`;
                    successMessage += `\n📅 Sent: ${response.data.sent_at}`;
                    successMessage += `\n⏰ Expires: ${response.data.expires_at}`;
                }
                
                showAlert(successMessage, 'success');
                
                // Add email sent animation
                mailBtn.addClass('email-sent');
                mailBtn.html('<i class="fas fa-check"></i>');
                
                // Show additional info
                setTimeout(() => {
                    showAlert('📋 The client can now approve or reject the invoice via email. Status will update automatically.', 'info');
                }, 2000);
                
                // Check for status updates after 3 seconds
                setTimeout(() => {
                    updateInvoiceStatuses();
                }, 3000);
                
            } else {
                showAlert(`❌ Email failed: ${response.message}`, 'danger');
                // Restore button on failure
                mailBtn.html(originalHtml);
                mailBtn.prop('disabled', false);
            }
        },
        error: function(xhr, status, error) {
            hideLoading();
            
            let errorMessage = 'Network error occurred';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 419) {
                errorMessage = 'CSRF token expired. Refreshing token and retrying...';
                // Refresh CSRF token and retry once
                refreshCsrfToken();
                setTimeout(() => {
                    sendApprovalEmail(leadId, email, invoiceNumber);
                }, 1000);
                return; // Don't restore button yet, we're retrying
            } else if (xhr.status === 403) {
                errorMessage = 'Permission denied. You may not have rights to send emails.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            }
            
            showAlert(`❌ ${errorMessage}`, 'danger');
            
            // Restore button on error
            mailBtn.html(originalHtml);
            mailBtn.prop('disabled', false);
            
            console.error('Email sending failed:', {
                status: xhr.status,
                error: error,
                response: xhr.responseText
            });
        },
        complete: function() {
            // Reset button after delay (only if not showing check mark)
            setTimeout(() => {
                if (mailBtn.html().includes('fa-spinner')) {
                    mailBtn.html(originalHtml);
                    mailBtn.prop('disabled', false);
                }
                mailBtn.removeClass('email-sent');
            }, 5000);
        }
    });
}

// View lead details
function viewLead(leadId) {
    showLoading();
    // Implementation for viewing lead details
    window.location.href = `/leadsmanagement/${leadId}/edit`;
}

// Edit lead
function editLead(leadId) {
    showLoading();
    window.location.href = `/leadsmanagement/${leadId}/edit`;
}

// Delete lead
function deleteLead(leadId) {
    if (!confirm('Are you sure you want to delete this lead?')) {
        return;
    }
    
    showLoading();
    
    $.ajax({
        url: `/leadsmanagement/${leadId}`,
        method: 'DELETE',
        headers: {
            'Accept': 'application/json'
        },
        success: function(response) {
            hideLoading();
            $(`#lead-row-${leadId}`).fadeOut(() => {
                $(this).remove();
                updateStatistics();
            });
            showAlert('Lead deleted successfully!', 'success');
        },
        error: function(xhr, status, error) {
            hideLoading();
            showAlert(`Delete failed: ${error}`, 'danger');
        }
    });
}

// Refresh all data
function refreshAllData() {
    console.log('🔄 refreshAllData function called!');
    showLoading();
    updateInvoiceStatuses();
    updateStatistics();
    
    setTimeout(() => {
        hideLoading();
        showAlert('Data refreshed successfully!', 'info');
    }, 1000);
}

// Show loading overlay
function showLoading() {
    $('#loadingOverlay').show();
}

// Hide loading overlay
function hideLoading() {
    $('#loadingOverlay').hide();
}

// Show alert message
function showAlert(message, type) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-triangle' : 'info-circle'}"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const container = $('#alertContainer');
    container.html(alertHtml);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        container.find('.alert').fadeOut();
    }, 5000);
}

// Cleanup on page unload
$(window).on('beforeunload', function() {
    if (refreshInterval) {
        clearInterval(refreshInterval);
    }
});
</script>

<!-- Simple Auto Refresh Script -->
<script>
// Guaranteed automatic refresh - this will run after everything else
window.addEventListener('load', function() {
    console.log('🔄 Page fully loaded - setting up guaranteed auto refresh');
    setTimeout(function() {
        console.log('⚡ GUARANTEED AUTO REFRESH TRIGGERED');
        // Try to find and click the refresh button
        var buttons = document.querySelectorAll('button');
        for (var i = 0; i < buttons.length; i++) {
            if (buttons[i].innerHTML.includes('Refresh All')) {
                console.log('🎯 Found Refresh All button - clicking it');
                buttons[i].click();
                break;
            }
        }
    }, 2000);
});
</script>
@endsection
