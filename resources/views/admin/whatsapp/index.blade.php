@extends('layouts.app-whatsapp')

@section('title', 'WhatsApp Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="page-title">WhatsApp Management</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">WhatsApp</li>
            </ol>
        </div>
        <div>
            <button type="button" class="btn btn-primary" id="checkStatusBtn">
                <i class="fas fa-check-circle"></i> Check Status
            </button>
            <button type="button" class="btn btn-info ms-2" id="templatesBtn">
                <i class="fas fa-file-alt"></i> Templates
            </button>
        </div>
    </div>

    <!-- Status Alert -->
    <div id="statusAlert" class="alert alert-info d-none" role="alert">
        <h5 class="alert-heading">WhatsApp API Status</h5>
        <p id="statusMessage">Checking status...</p>
    </div>

    <!-- WhatsApp Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $leads->total() }}</h4>
                            <p class="card-text">Total Leads</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $leads->whereNotNull('phone')->count() }}</h4>
                            <p class="card-text">With Phone Numbers</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-phone fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">0</h4>
                            <p class="card-text">Messages Sent</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-paper-plane fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">4</h4>
                            <p class="card-text">Templates</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Lead List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Leads with Phone Numbers</h5>
                </div>
                <div class="card-body">
                    <!-- Search and Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="searchLead" placeholder="Search leads...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="hot">Hot</option>
                                <option value="warm">Warm</option>
                                <option value="cold">Cold</option>
                                <option value="qualified">Qualified</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success w-100" id="bulkMessageBtn">
                                <i class="fas fa-bullhorn"></i> Bulk Message
                            </button>
                        </div>
                    </div>

                    <!-- Leads Table -->
                    <div class="table-responsive">
                        <table class="table table-hover" id="leadsTable">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leads as $lead)
                                    <tr data-lead-id="{{ $lead->id }}">
                                        <td>
                                            <input type="checkbox" class="lead-checkbox form-check-input" 
                                                   value="{{ $lead->id }}" 
                                                   {{ $lead->phone ? '' : 'disabled' }}>
                                        </td>
                                        <td>
                                            <strong>{{ $lead->name }}</strong>
                                            @if($lead->company_name)
                                                <br><small class="text-muted">{{ $lead->company_name }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($lead->phone)
                                                <span class="badge bg-success">{{ $lead->phone }}</span>
                                            @else
                                                <span class="badge bg-secondary">No Phone</span>
                                            @endif
                                        </td>
                                        <td>{{ $lead->email ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $lead->getStatusColor() }}">
                                                {{ ucfirst($lead->lead_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $lead->getPriorityColor() }}">
                                                {{ ucfirst($lead->priority) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" 
                                                    class="btn btn-sm btn-primary sendMessageBtn" 
                                                    data-lead-id="{{ $lead->id }}"
                                                    data-lead-name="{{ $lead->name }}"
                                                    data-lead-phone="{{ $lead->phone }}"
                                                    {{ !$lead->phone ? 'disabled' : '' }}>
                                                <i class="fas fa-paper-plane"></i> Send
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No leads found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $leads->firstItem() }} to {{ $leads->lastItem() }} of {{ $leads->total() }} entries
                        </div>
                        <div>
                            {{ $leads->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Composer -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Message Composer</h5>
                </div>
                <div class="card-body">
                    <form id="messageForm">
                        <input type="hidden" id="leadId" name="lead_id">
                        
                        <div class="mb-3">
                            <label for="recipientInfo" class="form-label">Recipient</label>
                            <input type="text" class="form-control" id="recipientInfo" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="messageType" class="form-label">Message Type</label>
                            <select class="form-control" id="messageType" name="message_type">
                                <option value="text">Text Message</option>
                                <option value="image">Image Message</option>
                                <option value="document">Document Message</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="templateSelect" class="form-label">Use Template</label>
                            <select class="form-control" id="templateSelect">
                                <option value="">Select Template</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="6" 
                                      placeholder="Type your message here..." maxlength="1000" required></textarea>
                            <div class="form-text">
                                <span id="charCount">0</span>/1000 characters
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success" id="sendBtn">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                            <button type="button" class="btn btn-secondary" id="clearBtn">
                                <i class="fas fa-eraser"></i> Clear
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary" id="followUpBtn">
                            <i class="fas fa-clock"></i> Follow Up
                        </button>
                        <button type="button" class="btn btn-outline-success" id="quotationBtn">
                            <i class="fas fa-file-invoice"></i> Quotation Sent
                        </button>
                        <button type="button" class="btn btn-outline-warning" id="reminderBtn">
                            <i class="fas fa-bell"></i> Appointment Reminder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Message Modal -->
<div class="modal fade" id="bulkMessageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Bulk Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Selected leads: <span id="selectedCount">0</span>
                </div>
                <form id="bulkMessageForm">
                    <div class="mb-3">
                        <label for="bulkMessage" class="form-label">Message</label>
                        <textarea class="form-control" id="bulkMessage" name="message" rows="6" 
                                  placeholder="Type your bulk message here..." maxlength="1000" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="sendBulkBtn">
                    <i class="fas fa-paper-plane"></i> Send Bulk Message
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Templates Modal -->
<div class="modal fade" id="templatesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Message Templates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="templatesList">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.lead-checkbox:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
    cursor: pointer;
}
.badge {
    font-size: 0.75em;
}
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let selectedLeads = [];
    
    // Handle pre-filled data from URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const leadId = urlParams.get('lead_id');
    const leadName = urlParams.get('lead_name');
    const leadPhone = urlParams.get('lead_phone');
    
    if (leadId && leadName && leadPhone) {
        $('#leadId').val(leadId);
        $('#recipientInfo').val(`${leadName} (${leadPhone})`);
        
        // Scroll to message composer
        $('html, body').animate({
            scrollTop: $('#messageForm').offset().top - 100
        }, 500);
        
        // Highlight the message composer
        $('#messageForm').closest('.card').addClass('border-primary');
        setTimeout(function() {
            $('#messageForm').closest('.card').removeClass('border-primary');
        }, 3000);
    }

    // Check WhatsApp Status
    $('#checkStatusBtn').click(function() {
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Checking...');
        
        $.get('/whatsapp/status')
            .done(function(response) {
                const alert = $('#statusAlert');
                const message = $('#statusMessage');
                
                if (response.success) {
                    alert.removeClass('alert-danger').addClass('alert-success');
                    message.text(response.message + ' - Phone: ' + (response.phone_number_info?.display_phone_number || 'N/A'));
                } else {
                    alert.removeClass('alert-success').addClass('alert-danger');
                    message.text(response.message);
                }
                
                alert.removeClass('d-none');
            })
            .fail(function() {
                $('#statusAlert').removeClass('alert-success').addClass('alert-danger')
                    .removeClass('d-none').find('#statusMessage').text('Failed to check status');
            })
            .always(function() {
                btn.prop('disabled', false).html('<i class="fas fa-check-circle"></i> Check Status');
            });
    });

    // Load Templates
    $('#templatesBtn').click(function() {
        $('#templatesModal').modal('show');
        
        $.get('/whatsapp/templates')
            .done(function(response) {
                if (response.success) {
                    let html = '<div class="row">';
                    response.templates.forEach(function(template, index) {
                        html += `
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">${template.name}</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="small">${template.message}</p>
                                        <div class="text-muted">
                                            <small>Variables: ${template.variables.join(', ')}</small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary mt-2 use-template-btn" 
                                                data-template="${template.message}">
                                            Use Template
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    $('#templatesList').html(html);
                    
                    // Update template select dropdown
                    let options = '<option value="">Select Template</option>';
                    response.templates.forEach(function(template) {
                        options += `<option value="${template.message}">${template.name}</option>`;
                    });
                    $('#templateSelect').html(options);
                }
            });
    });

    // Use Template
    $(document).on('click', '.use-template-btn', function() {
        const template = $(this).data('template');
        $('#message').val(template);
        $('#templatesModal').modal('hide');
        updateCharCount();
    });

    // Template Select Change
    $('#templateSelect').change(function() {
        const template = $(this).val();
        if (template) {
            $('#message').val(template);
            updateCharCount();
        }
    });

    // Send Message Button
    $('.sendMessageBtn').click(function() {
        const leadId = $(this).data('lead-id');
        const leadName = $(this).data('lead-name');
        const leadPhone = $(this).data('lead-phone');
        
        $('#leadId').val(leadId);
        $('#recipientInfo').val(`${leadName} (${leadPhone})`);
        $('#messageForm')[0].reset();
        $('#recipientInfo').val(`${leadName} (${leadPhone})`);
        
        // Scroll to message composer
        $('html, body').animate({
            scrollTop: $('#messageForm').offset().top - 100
        }, 500);
    });

    // Message Form Submit
    $('#messageForm').submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const btn = $('#sendBtn');
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
        
        $.ajax({
            url: '/whatsapp/send',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(function(response) {
            if (response.success) {
                alert('Message sent successfully!');
                $('#messageForm')[0].reset();
                updateCharCount();
            } else {
                alert('Failed to send message: ' + response.message);
            }
        })
        .fail(function(xhr) {
            const error = xhr.responseJSON?.message || 'Failed to send message';
            alert('Error: ' + error);
        })
        .always(function() {
            btn.prop('disabled', false).html('<i class="fas fa-paper-plane"></i> Send Message');
        });
    });

    // Character Counter
    $('#message').on('input', updateCharCount);
    
    function updateCharCount() {
        const length = $('#message').val().length;
        $('#charCount').text(length);
    }

    // Clear Button
    $('#clearBtn').click(function() {
        $('#messageForm')[0].reset();
        updateCharCount();
    });

    // Select All Checkbox
    $('#selectAll').change(function() {
        const checked = $(this).prop('checked');
        $('.lead-checkbox:not(:disabled)').prop('checked', checked);
        updateSelectedLeads();
    });

    // Individual Checkbox Change
    $('.lead-checkbox').change(function() {
        updateSelectedLeads();
    });

    function updateSelectedLeads() {
        selectedLeads = [];
        $('.lead-checkbox:checked').each(function() {
            selectedLeads.push($(this).val());
        });
        $('#selectedCount').text(selectedLeads.length);
    }

    // Bulk Message Button
    $('#bulkMessageBtn').click(function() {
        if (selectedLeads.length === 0) {
            alert('Please select at least one lead');
            return;
        }
        $('#bulkMessageModal').modal('show');
    });

    // Send Bulk Message
    $('#sendBulkBtn').click(function() {
        const message = $('#bulkMessage').val().trim();
        
        if (!message) {
            alert('Please enter a message');
            return;
        }
        
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
        
        $.ajax({
            url: '/whatsapp/bulk-send',
            method: 'POST',
            data: {
                lead_ids: selectedLeads,
                message: message,
                message_type: 'text',
                _token: $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(function(response) {
            if (response.success) {
                alert(response.message);
                $('#bulkMessageModal').modal('hide');
                $('#bulkMessage').val('');
                $('.lead-checkbox').prop('checked', false);
                updateSelectedLeads();
            } else {
                alert('Failed to send bulk message');
            }
        })
        .fail(function(xhr) {
            const error = xhr.responseJSON?.message || 'Failed to send bulk message';
            alert('Error: ' + error);
        })
        .always(function() {
            btn.prop('disabled', false).html('<i class="fas fa-paper-plane"></i> Send Bulk Message');
        });
    });

    // Quick Action Buttons
    $('#followUpBtn').click(function() {
        const message = 'Hello {name}, this is a follow-up regarding your inquiry. We would love to discuss how we can help you. Please let us know a convenient time to connect.';
        $('#message').val(message);
        updateCharCount();
    });

    $('#quotationBtn').click(function() {
        const message = 'Dear {name}, we have sent you the quotation. Please review it and let us know if you have any questions. Looking forward to your response.';
        $('#message').val(message);
        updateCharCount();
    });

    $('#reminderBtn').click(function() {
        const message = 'Hi {name}, this is a reminder about your appointment. We look forward to meeting you.';
        $('#message').val(message);
        updateCharCount();
    });

    // Search Functionality
    $('#searchLead').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('#leadsTable tbody tr').each(function() {
            const row = $(this);
            const text = row.text().toLowerCase();
            row.toggle(text.includes(searchTerm));
        });
    });

    // Status Filter
    $('#statusFilter').change(function() {
        const status = $(this).val();
        $('#leadsTable tbody tr').each(function() {
            const row = $(this);
            if (status === '') {
                row.show();
            } else {
                const statusBadge = row.find('td:nth-child(5) .badge').text().toLowerCase();
                row.toggle(statusBadge === status.toLowerCase());
            }
        });
    });
});
</script>
@endpush
