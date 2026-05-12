@extends('admin.admin_master')

@section('page-title')
    Google Sheets Management
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .table-responsive {
            max-height: 70vh;
            overflow-y: auto;
        }
        .sticky-top {
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0.5rem;
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-top: none;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endpush

@section('admin')
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">
                        <i class="fas fa-table text-success me-2"></i>
                        Google Sheets Management
                    </h4>
                    <p class="mb-0">
                        Manage and sync data from your Google Sheets
                        @if($lastSync)
                            <span class="badge bg-info ms-2">
                                Last sync: {{ $lastSync->diffForHumans() }}
                            </span>
                        @endif
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <button onclick="syncGoogleSheets()" class="btn btn-success" id="syncBtn">
                        <i class="fas fa-sync me-2"></i>Sync Google Sheets
                    </button>
                    <a href="{{ route('google-sheets.export') }}" class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>Export to Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid py-4">
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
                        <table class="table table-striped table-hover table-bordered mb-0">
                            <thead class="table-dark sticky-top">
                                <tr>
                                    <th class="text-center" style="width: 60px;">#</th>
                                    @foreach($headers as $header)
                                        <th>
                                            <small>{{ $header }}</small>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pageData as $index => $row)
                                    <tr>
                                        <td class="text-center fw-bold">
                                            {{ $totalRows - (($currentPage - 1) * $perPage) - $index }}
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
                                                    } elseif (strlen($value) > 50) {
                                                        $displayValue = substr(e($value), 0, 50) . '...';
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
                
                <!-- Pagination -->
                @if($totalPages > 1)
                    <div class="card-footer">
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
            </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    function syncGoogleSheets() {
        const syncBtn = document.getElementById('syncBtn');
        const originalText = syncBtn.innerHTML;
        
        // Show loading state
        syncBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Syncing...';
        syncBtn.disabled = true;
        
        fetch('{{ route(\'google-sheets-management.sync\') }}', {
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
                alert.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + data.message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
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
                alert.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + data.message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                document.body.appendChild(alert);
            }
        })
        .catch(error => {
            console.error('Sync error:', error);
            const alert = document.createElement('div');
            alert.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
            alert.style.zIndex = '9999';
            alert.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>An error occurred while syncing Google Sheets. Please check console for more information.<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            document.body.appendChild(alert);
        })
        .finally(() => {
            // Restore button state
            syncBtn.innerHTML = originalText;
            syncBtn.disabled = false;
        });
    }
    </script>
@endsection
