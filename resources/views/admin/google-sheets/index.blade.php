@extends('admin.admin_master')

@section('page-title', 'Google Sheets Management')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<style>
.gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.gradient-success {
    background: linear-gradient(135deg, #13B497 0%, #59D4A8 100%);
}
.gradient-info {
    background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
}
.gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.table th {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-top: none !important;
}

.table td {
    vertical-align: middle;
    font-size: 0.9rem;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.btn .fas {
    display: inline-block !important;
    font-style: normal !important;
    font-variant: normal !important;
    text-rendering: auto !important;
    line-height: 1 !important;
    font-family: "Font Awesome 6 Free" !important;
    font-weight: 900 !important;
}

.sticky-top {
    top: 0;
    z-index: 10;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.8rem;
    }
    
    .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
}
</style>
@endpush

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-table text-success me-2"></i>
                            Google Sheets Management
                            @if($lastSync)
                                <small class="badge bg-info ms-2">
                                    Last sync: {{ $lastSync->diffForHumans() }}
                                </small>
                            @endif
                        </h5>
                        <div class="d-flex align-items-center gap-3">
                            <button onclick="syncGoogleSheets()" class="btn btn-success" id="syncBtn">
                                <i class="fas fa-sync me-2"></i>Sync Google Sheets
                            </button>
                            <a href="{{ route('google-sheets.export') }}" class="btn btn-primary">
                                <i class="fas fa-download me-2"></i>Export to Excel
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(isset($error))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-gradient-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title mb-0">Total Rows</h6>
                                            <h3 class="mb-0">{{ number_format($totalRows) }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-database fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title mb-0">Columns</h6>
                                            <h3 class="mb-0">{{ count($headers) }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-columns fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title mb-0">Current Page</h6>
                                            <h3 class="mb-0">{{ $currentPage }} / {{ $totalPages }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-file-alt fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title mb-0">Per Page</h6>
                                            <h3 class="mb-0">{{ $perPage }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-list fa-2x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filters -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" action="{{ route('google-sheets-management.index') }}" class="row g-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Search in Google Sheets data...">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" name="per_page">
                                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 rows</option>
                                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 rows</option>
                                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 rows</option>
                                        <option value="200" {{ $perPage == 200 ? 'selected' : '' }}>200 rows</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-filter me-2"></i>Apply Filters
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

    <!-- Data Table -->
                    @if(empty($pageData))
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-table fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No data found</h5>
                                <p class="text-muted">Click "Sync Google Sheets" to fetch data from your spreadsheet.</p>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-header bg-gradient-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-table me-2"></i>
                                    Google Sheets Data
                                    <small class="opacity-75 ms-2">
                                        Showing {{ count($pageData) }} of {{ number_format($totalRows) }} rows
                                    </small>
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                                    <table class="table table-striped table-hover table-bordered mb-0" id="googleSheetsTable">
                                        <thead class="table-dark sticky-top">
                                            <tr>
                                                <th class="text-center" style="width: 60px;">#</th>
                                                @foreach($headers as $header)
                                                    <th>
                                                        {{ Str::title(str_replace('_', ' ', $header)) }}
                                                        <small class="d-block text-muted fw-normal">
                                                            {{ $header }}
                                                        </small>
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pageData as $index => $row)
                                                <tr>
                                                    <td class="text-center fw-bold">
                                                        {{ (($currentPage - 1) * $perPage) + $index + 1 }}
                                                    </td>
                                                    @foreach($headers as $header)
                                                        <td>
                                                            @php
                                                                $value = $row[$header] ?? '';
                                                                $displayValue = !empty($value) ? e($value) : '<span class="text-muted">-</span>';
                                                                
                                                                // Special formatting for certain columns
                                                                if ($header === 'email' && !empty($value) && filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                                                    $displayValue = '<a href="mailto:' . e($value) . '" class="text-primary text-decoration-none">' . e($value) . '</a>';
                                                                } elseif ($header === 'website_url' && !empty($value)) {
                                                                    $url = !preg_match('/^https?:\/\//', $value) ? 'https://' . $value : $value;
                                                                    $displayValue = '<a href="' . e($url) . '" target="_blank" class="text-primary text-decoration-none">' . e($value) . '</a>';
                                                                } elseif ($header === 'whatsapp' && !empty($value)) {
                                                                    $phone = preg_replace('/[^0-9+]/', '', $value);
                                                                    $displayValue = '<a href="https://wa.me/' . e($phone) . '" target="_blank" class="text-success text-decoration-none">' . e($value) . '</a>';
                                                                } elseif ($header === 'submitted_at' && !empty($value)) {
                                                                    try {
                                                                        $date = new DateTime($value);
                                                                        $displayValue = $date->format('M d, Y H:i');
                                                                    } catch (Exception $e) {
                                                                        $displayValue = e($value);
                                                                    }
                                                                } elseif (strlen($value) > 100) {
                                                                    $displayValue = substr(e($value), 0, 100) . '...';
                                                                }
                                                            @endphp
                                                            {!! $displayValue !!}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if($totalPages > 1)
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted">
                                    Showing {{ (($currentPage - 1) * $perPage) + 1 }} to 
                                    {{ min($currentPage * $perPage, $totalRows) }} of {{ number_format($totalRows) }} entries
                                </div>
                                <nav>
                                    <ul class="pagination mb-0">
                                        <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ route('google-sheets-management.index', ['page' => max(1, $currentPage - 1), 'search' => $search, 'per_page' => $perPage]) }}">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                        
                                        @for($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++)
                                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                                <a class="page-link" href="{{ route('google-sheets-management.index', ['page' => $i, 'search' => $search, 'per_page' => $perPage]) }}">
                                                    {{ $i }}
                                                </a>
                                            </li>
                                        @endfor
                                        
                                        <li class="page-item {{ $currentPage >= $totalPages ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ route('google-sheets-management.index', ['page' => min($totalPages, $currentPage + 1), 'search' => $search, 'per_page' => $perPage]) }}">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function syncGoogleSheets() {
    const syncBtn = document.getElementById('syncBtn');
    const originalText = syncBtn.innerHTML;
    
    // Show loading state
    syncBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Syncing...';
    syncBtn.disabled = true;
    
    fetch('{{ route("google-sheets-management.sync") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
            alert.style.zIndex = '9999';
            alert.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alert);
            
            // Auto remove alert after 5 seconds
            setTimeout(() => {
                alert.remove();
            }, 5000);
            
            // Refresh page after 3 seconds
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        } else {
            // Show error message
            const alert = document.createElement('div');
            alert.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
            alert.style.zIndex = '9999';
            alert.innerHTML = `
                <i class="fas fa-exclamation-triangle me-2"></i>
                ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alert);
        }
    })
    .catch(error => {
        console.error('Sync error:', error);
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
        alert.style.zIndex = '9999';
        alert.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>
            An error occurred while syncing Google Sheets
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alert);
    })
    .finally(() => {
        // Restore button state
        syncBtn.innerHTML = originalText;
        syncBtn.disabled = false;
    });
}

// Auto-refresh every 30 seconds
setInterval(() => {
    const lastSyncElement = document.querySelector('.badge.bg-info');
    if (lastSyncElement) {
        fetch('{{ route("google-sheets-management.index") }}')
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newLastSync = doc.querySelector('.badge.bg-info');
                if (newLastSync) {
                    lastSyncElement.textContent = newLastSync.textContent;
                }
            })
            .catch(error => console.log('Auto-refresh failed:', error));
    }
}, 30000);
</script>
@endpush
