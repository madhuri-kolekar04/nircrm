@extends('admin.admin_master')

@section('page-title', 'Manual Leads - Calling App')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        Manual Leads Management
                    </h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('callingapp.add-leads') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>
                            Add New Lead
                        </a>
                        <button class="btn btn-secondary btn-sm" onclick="switchTab('google')">
                            <i class="fas fa-sync me-2"></i>
                            Back to Google Sheet
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(empty($pageData))
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5>No Manual Leads Found</h5>
                            <p class="text-muted">No manually added leads available. Click "Add New Lead" to create one.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Business Name</th>
                                        <th>Email</th>
                                        <th>WhatsApp</th>
                                        <th>Who Called?</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pageData as $index => $row)
                                        <tr>
                                            <td><strong>{{ ($page - 1) * $perPage + $index + 1 }}</strong></td>
                                            <td>
                                                <span class="badge bg-warning text-dark" title="Manually Added">
                                                    <i class="fas fa-star"></i> *
                                                </span>
                                            </td>
                                            <td>
                                                <strong>{{ $row['full_name'] ?? '-' }}</strong>
                                            </td>
                                            <td>{{ $row['business_name'] ?? '-' }}</td>
                                            <td>
                                                @if(!empty($row['email']))
                                                    <a href="mailto:{{ $row['email'] }}" class="email-link">
                                                        <i class="fas fa-envelope me-1"></i>
                                                        {{ $row['email'] }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $row['whatsapp'] ?? '-' }}</td>
                                            <td>{{ $row['who_called'] ?? '-' }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" onclick="editLead({{ $row['id'] ?? '' }})" title="Edit Lead">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    <!-- Pagination -->
                    @if($totalPages > 1)
                        <div class="d-flex justify-content-center mt-4">
                            <nav>
                                <ul class="pagination">
                                    @if($page > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                Previous
                                            </a>
                                        </li>
                                    @endif
                                    
                                    {{-- Current Page --}}
                                    @for($i = max(1, $page - 2); $i <= min($page + 2, $totalPages); $i++)
                                        <li class="page-item {{ $i == $page ? 'active' : '' }}">
                                            @if($i == $page)
                                                <span class="page-link">{{ $i }}</span>
                                            @else
                                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                            @endif
                                        </li>
                                    @endfor
                                    
                                    @if($page < $totalPages)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}" aria-label="Next">
                                                Next
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35em 0.65em;
        border-radius: 0.375rem;
    }

    .bg-warning {
        background-color: #ffc107 !important;
        color: #000 !important;
    }

    .text-dark {
        color: #000 !important;
    }

    .email-link {
        color: inherit;
        text-decoration: none;
    }

    .email-link:hover {
        text-decoration: underline;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .page-item {
        margin: 0 5px;
    }

    .page-link {
        padding: 8px 16px;
        text-decoration: none;
        color: #495057;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background-color: #e9ecef;
        color: #000;
    }

    .page-item.active .page-link {
        background-color: #667eea;
        color: #fff;
        border-color: #667eea;
    }
</style>

<script>
    function editLead(leadId) {
        // Redirect to edit lead - you can implement this later
        console.log('Edit lead:', leadId);
    }

    function switchTab(tabType) {
        // Remove active class from all tabs
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Add active class to selected tab
        if (tabType === 'google') {
            document.getElementById('google-tab').classList.add('active');
            // Show Google Sheet data
            window.location.href = '{{ route("callingapp.index") }}';
        } else if (tabType === 'manual') {
            document.getElementById('manual-tab').classList.add('active');
            // Show Manual Leads only
            window.location.href = '{{ route("callingapp.manual-leads") }}';
        }
    }
</script>
