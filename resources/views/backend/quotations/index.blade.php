@extends('admin.admin_master')

@section('admin')
@section('page-title', 'Quotations Management')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-file-invoice text-success"></i>
                        Quotations Management
                    </h4>
                    <div>
                        <a href="{{ route('services.index') }}" class="btn btn-info me-2">
                            <i class="fas fa-tags"></i>
                            Services & Prices
                        </a>
                        <a href="{{ route('quotations.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i>
                            Create Quotation
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($quotations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="quotationsTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Quotation Number</th>
                                        <th>Client Name</th>
                                        <th>Business Name</th>
                                        <th>Email</th>
                                        <th>Final Amount</th>
                                        <th>Status</th>
                                        <th>Quotation Approval</th>
                                        <th>Created Date</th>
                                        <th>Valid Until</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1; @endphp
                                    @foreach($quotations as $quotation)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>
                                            <strong>{{ $quotation->quotation_number }}</strong>
                                        </td>
                                        <td>{{ $quotation->client_contact_name }}</td>
                                        <td>{{ $quotation->client_business_name }}</td>
                                        <td>{{ $quotation->client_email }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $quotation->formatted_final_amount }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $quotation->status_color }}">
                                                {{ ucfirst($quotation->status) }}
                                            </span>
                                            @if($quotation->email_count > 0)
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-sm btn-info py-0" 
                                                        title="View Email History ({{ $quotation->email_count }} sends)"
                                                        onclick="showEmailHistory({{ $quotation->id }})">
                                                    Send {{ $quotation->email_count }}
                                                </button>
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $quotation->approval_status_color }} me-1">
                                                <i class="fas fa-{{ $quotation->approval_status_icon }}"></i>
                                                {{ ucfirst($quotation->approval_status) }}
                                            </span>
                                            @if($quotation->approved_at)
                                            <div class="small text-muted mt-1">
                                                {{ $quotation->approved_at->format('M d, Y h:i A') }}
                                            </div>
                                            @endif
                                        </td>
                                        <td>{{ $quotation->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($quotation->valid_until)
                                                <span class="{{ $quotation->valid_until->isPast() ? 'text-danger' : 'text-success' }}">
                                                    {{ $quotation->valid_until->format('M d, Y') }}
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('quotations.show', $quotation->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="View Quotation">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('quotations.edit', $quotation->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Edit Quotation">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('quotations.pdf', $quotation->id) }}" 
                                                   class="btn btn-sm btn-danger" 
                                                   title="Download PDF"
                                                   target="_blank">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                <form action="{{ route('quotations.send', $quotation->id) }}" 
                                                      method="POST" 
                                                      style="display: inline-block;"
                                                      onsubmit="return confirm('Send this quotation to {{ $quotation->client_email }}?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Send Email">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('quotations.destroy', $quotation->id) }}" 
                                                      method="POST" 
                                                      style="display: inline-block;"
                                                      onsubmit="return confirm('Are you sure you want to delete this quotation?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete Quotation">
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
                            <i class="fas fa-file-invoice text-muted fa-3x mb-3"></i>
                            <h5 class="text-muted">No Quotations Found</h5>
                            <p class="text-muted">Start by creating your first quotation.</p>
                            <a href="{{ route('quotations.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Create First Quotation
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email History Modal -->
<div class="modal fade" id="emailHistoryModal" tabindex="-1" aria-labelledby="emailHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailHistoryModalLabel">
                    <i class="fas fa-envelope"></i>
                    Email History
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="emailHistoryContent">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading email history...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function showEmailHistory(quotationId) {
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('emailHistoryModal'));
    modal.show();
    
    // Load email history via AJAX
    fetch(`/quotations/${quotationId}/email-history`)
        .then(response => response.json())
        .then(data => {
            let html = '';
            
            if (data.emails && data.emails.length > 0) {
                html += `
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th width="200">Sent By</th>
                                    <th width="200">Recipient</th>
                                    <th>Subject</th>
                                    <th width="120">Status</th>
                                    <th width="150">Sent At</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                
                data.emails.forEach((email, index) => {
                    html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle me-2 text-muted"></i>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold text-truncate">${email.sender_name}</div>
                                        <small class="text-muted text-truncate d-block">${email.sender_email}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-bold text-truncate">${email.recipient_name}</div>
                                    <small class="text-muted text-truncate d-block">${email.recipient_email}</small>
                                </div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;" title="${email.subject}">
                                    ${email.subject}
                                </div>
                                ${email.has_attachment ? '<span class="badge bg-success ms-2"><i class="fas fa-paperclip"></i> PDF</span>' : ''}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-${email.status_color} me-2">
                                        <i class="fas ${email.status_icon}"></i>
                                        ${email.status.charAt(0).toUpperCase() + email.status.slice(1)}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-nowrap">${email.formatted_sent_at}</span>
                                    <small class="text-muted">${email.time_ago}</small>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                
                html += `
                            </tbody>
                        </table>
                    </div>
                `;
            } else {
                html = `
                    <div class="text-center py-4">
                        <i class="fas fa-envelope-open-text text-muted fa-3x mb-3"></i>
                        <h5 class="text-muted">No Email History</h5>
                        <p class="text-muted">This quotation hasn't been sent via email yet.</p>
                    </div>
                `;
            }
            
            document.getElementById('emailHistoryContent').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading email history:', error);
            document.getElementById('emailHistoryContent').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Error loading email history. Please try again.
                </div>
            `;
        });
}
</script>

<script>
$(document).ready(function() {
    $('#quotationsTable').DataTable({
        "pageLength": 25,
        "order": [[ 0, "desc" ]],
        "responsive": true,
        "language": {
            "emptyTable": "No quotations available"
        }
    });
});
</script>
@endsection
