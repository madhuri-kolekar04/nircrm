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
        
        /* Audit Report Column Styles */
        .audit-report-cell {
            max-width: 200px;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }
        .audit-report-cell:hover {
            background-color: #f0f4ff;
            transform: scale(1.02);
        }
        .audit-report-truncated {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #667eea;
            font-weight: 500;
        }
        .audit-report-truncated:hover {
            color: #5a6fd8;
        }
        .audit-report-indicator {
            position: absolute;
            top: 2px;
            right: 2px;
            background: #667eea;
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            cursor: pointer;
        }
        
        /* Modal Styles */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px 12px 0 0;
            border: none;
        }
        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
        }
        .audit-report-content {
            white-space: pre-wrap;
            word-wrap: break-word;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 15px;
            line-height: 1.7;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #dee2e6;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-height: 60vh;
            overflow-y: auto;
        }
        
        .audit-report-formatted {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .audit-report-formatted h1 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #3498db;
            text-align: center;
        }
        
        .audit-report-formatted h2 {
            color: #34495e;
            font-size: 22px;
            font-weight: 600;
            margin: 25px 0 15px 0;
            padding-left: 15px;
            border-left: 4px solid #3498db;
            background: rgba(52, 152, 219, 0.1);
            padding: 10px 15px;
            border-radius: 0 8px 8px 0;
        }
        
        .audit-report-formatted h3 {
            color: #2c3e50;
            font-size: 18px;
            font-weight: 600;
            margin: 20px 0 10px 0;
            color: #2980b9;
        }
        
        .audit-report-formatted p {
            margin-bottom: 15px;
            text-align: justify;
            color: #34495e;
        }
        
        .audit-report-formatted ul {
            margin: 15px 0;
            padding-left: 0;
            list-style: none;
        }
        
        .audit-report-formatted li {
            margin-bottom: 12px;
            padding: 12px 15px 12px 35px;
            background: white;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            position: relative;
        }
        
        .audit-report-formatted li:before {
            content: "▶";
            position: absolute;
            left: 12px;
            top: 12px;
            color: #3498db;
            font-size: 12px;
        }
        
        .audit-report-formatted strong {
            color: #2c3e50;
            font-weight: 700;
            background: linear-gradient(135deg, #3498db, #2980b9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .audit-report-formatted br {
            margin-bottom: 10px;
        }
        
        /* Mobile Responsive Audit Report */
        @media (max-width: 768px) {
            .audit-report-content {
                padding: 20px;
                font-size: 14px;
                line-height: 1.6;
                max-height: 70vh;
            }
            
            .audit-report-formatted h1 {
                font-size: 24px;
                margin-bottom: 15px;
            }
            
            .audit-report-formatted h2 {
                font-size: 20px;
                margin: 20px 0 12px 0;
                padding: 8px 12px;
            }
            
            .audit-report-formatted h3 {
                font-size: 16px;
                margin: 15px 0 8px 0;
            }
            
            .audit-report-formatted li {
                padding: 10px 12px 10px 30px;
                margin-bottom: 10px;
            }
            
            .audit-report-formatted li:before {
                left: 10px;
                top: 10px;
            }
        }
        
        @media (max-width: 480px) {
            .audit-report-content {
                padding: 15px;
                font-size: 13px;
                line-height: 1.5;
            }
            
            .audit-report-formatted h1 {
                font-size: 20px;
            }
            
            .audit-report-formatted h2 {
                font-size: 18px;
            }
            
            .audit-report-formatted li {
                padding: 8px 10px 8px 25px;
            }
            
            .audit-report-formatted li:before {
                left: 8px;
                top: 8px;
            }
        }
        
        /* Responsive table */
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .table {
            margin-bottom: 0;
        }
        
        /* General improvements */
        .btn {
            border-radius: 6px;
            font-weight: 500;
        }
    </style>
@endsection

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
                                            <small>{{ Illuminate\Support\Str::title(str_replace('_', ' ', $header)) }}</small>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pageData as $index => $row)
                                    <tr>
                                        <td class="text-center fw-bold">
                                            {{ ($currentPage - 1) * $perPage + $index + 1 }}
                                        </td>
                                        @foreach($headers as $header)
                                            <td>
                                                @php
                                                    $value = $row[$header] ?? '';
                                                    
                                                    // Special handling for audit report columns
                                                    if ($header === 'audit_report' || $header === 'audit_report_plain') {
                                                        if (!empty($value)) {
                                                            $displayValue = substr(strip_tags($value), 0, 50);
                                                            if (strlen($value) > 50) {
                                                                $displayValue .= '...';
                                                            }
                                                            $isAuditReport = true;
                                                        } else {
                                                            $displayValue = '<span class="text-muted">-</span>';
                                                            $isAuditReport = false;
                                                        }
                                                    } else {
                                                        $displayValue = !empty($value) ? e($value) : '<span class="text-muted">-</span>';
                                                        $isAuditReport = false;
                                                    }
                                                    
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
                                                    } elseif (!$isAuditReport && strlen($value) > 50) {
                                                        $displayValue = substr(e($value), 0, 50) . '...';
                                                    }
                                                @endphp
                                                
                                                @if($isAuditReport && !empty($value))
                                                    <div class="audit-report-cell" 
                                                         data-report-type="{{ e($header) }}" 
                                                         data-customer-name="{{ e($row['full_name'] ?? 'Unknown') }}" 
                                                         data-business-name="{{ e($row['business_name'] ?? 'Unknown') }}" 
                                                         data-report-content="{{ e(str_replace('"', '&quot;', $value)) }}"
                                                         onclick="showAuditReportModal(this)">
                                                        <span class="audit-report-truncated">{{ $displayValue }}</span>
                                                        <span class="audit-report-indicator">
                                                            <i class="fas fa-expand"></i>
                                                        </span>
                                                    </div>
                                                @else
                                                    {!! $displayValue !!}
                                                @endif
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
    
    <!-- Audit Report Modal -->
    <div class="modal fade" id="auditReportModal" tabindex="-1" aria-labelledby="auditReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="auditReportModalLabel">
                        <i class="fas fa-file-alt me-2"></i>
                        <span id="modalTitle">Audit Report</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i>
                            <strong>Name:</strong> <span id="modalCustomerName"></span><br>
                            <i class="fas fa-building me-1"></i>
                            <strong>Business:</strong> <span id="modalBusinessName"></span><br>
                            <i class="fas fa-tag me-1"></i>
                            <strong>Type:</strong> <span id="modalReportType"></span>
                        </small>
                    </div>
                    <div class="audit-report-content" id="modalContent">
                        <!-- Content will be inserted here -->
                    </div>
                    <div class="mt-3">
                        <button onclick="copyAuditReportContent()" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-copy me-1"></i>Copy Content
                        </button>
                        <button onclick="downloadAuditReport()" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-download me-1"></i>Download
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    function syncGoogleSheets() {
        const syncBtn = document.getElementById('syncBtn');
        const originalText = syncBtn.innerHTML;
        
        // Show loading state
        syncBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Syncing...';
        syncBtn.disabled = true;
        
        fetch("{{ route('google-sheets-management.sync') }}", {
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
    
    // Audit Report Modal Functions
    let currentAuditContent = '';
    let currentReportType = '';
    
    function showAuditReportModal(element) {
        // Get data from element attributes
        const reportType = element.getAttribute('data-report-type');
        const customerName = element.getAttribute('data-customer-name');
        const businessName = element.getAttribute('data-business-name');
        const content = element.getAttribute('data-report-content');
        
        // Decode HTML entities
        const decodedContent = content.replace(/&quot;/g, '"').replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>');
        
        currentAuditContent = decodedContent;
        currentReportType = reportType;
        
        console.log('Modal data:', { reportType, customerName, businessName, contentLength: decodedContent.length });
        
        // Set modal header info
        document.getElementById('modalTitle').textContent = reportType.replace('_', ' ').toUpperCase();
        document.getElementById('modalCustomerName').textContent = customerName;
        document.getElementById('modalBusinessName').textContent = businessName;
        document.getElementById('modalReportType').textContent = reportType.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
        
        // Set modal content
        const contentDiv = document.getElementById('modalContent');
        
        if (reportType === 'audit_report') {
            // Formatted report with HTML/markdown
            contentDiv.innerHTML = formatAuditReport(decodedContent);
            contentDiv.className = 'audit-report-content audit-report-formatted';
        } else {
            // Plain text report
            contentDiv.textContent = decodedContent;
            contentDiv.className = 'audit-report-content';
        }
        
        console.log('Modal content set, showing modal...');
        
        // Show modal
        try {
            const modal = new bootstrap.Modal(document.getElementById('auditReportModal'));
            modal.show();
            console.log('Modal should be visible now');
        } catch (error) {
            console.error('Error showing modal:', error);
            alert('Error showing modal: ' + error.message);
        }
    }
    
    function formatAuditReport(content) {
        // Clean up the content first
        let formatted = content.trim();
        
        // Convert markdown-like content to HTML with better formatting
        formatted = formatted
            // Headers (with better spacing)
            .replace(/^# (.*$)/gim, '<h1>$1</h1>')
            .replace(/^## (.*$)/gim, '<h2>$1</h2>')
            .replace(/^### (.*$)/gim, '<h3>$1</h3>')
            // Bold text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            // Italic text
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            // Numbered lists
            .replace(/^\d+\. (.*$)/gim, '<li>$1</li>')
            // Bullet points
            .replace(/^- (.*$)/gim, '<li>$1</li>')
            // Convert consecutive list items to proper lists
            .replace(/(<li>.*<\/li>)(\s*<li>.*<\/li>)+/g, function(match) {
                return '<ul>' + match + '</ul>';
            })
            // Convert numbered lists
            .replace(/(<li>\d+\. .*<\/li>)/g, '<ol>$1</ol>')
            // Handle multiple line breaks (convert to paragraphs)
            .replace(/\n{3,}/g, '\n\n')
            // Convert double line breaks to paragraphs
            .replace(/\n\n/g, '</p><p>')
            // Convert single line breaks to <br>
            .replace(/\n/g, '<br>');
        
        // Clean up any list formatting issues
        formatted = formatted.replace(/<\/p><ul>/g, '<ul>').replace(/<\/ul><p>/g, '</ul>');
        formatted = formatted.replace(/<\/p><ol>/g, '<ol>').replace(/<\/ol><p>/g, '</ol>');
        
        // Remove empty paragraphs
        formatted = formatted.replace(/<p><\/p>/g, '');
        formatted = formatted.replace(/<p><br><\/p>/g, '');
        
        // Wrap in paragraphs if not already wrapped and not starting with header or list
        if (!formatted.startsWith('<h1>') && !formatted.startsWith('<h2>') && !formatted.startsWith('<h3>') && 
            !formatted.startsWith('<ul>') && !formatted.startsWith('<ol>') && !formatted.startsWith('<p>')) {
            formatted = '<p>' + formatted + '</p>';
        }
        
        // Add proper spacing around headers
        formatted = formatted.replace(/<\/h1>/g, '</h1><br>')
                           .replace(/<\/h2>/g, '</h2><br>')
                           .replace(/<\/h3>/g, '</h3><br>');
        
        // Clean up any double breaks
        formatted = formatted.replace(/<br><br>/g, '<br>');
        
        return formatted;
    }
    
    function copyAuditReportContent() {
        const textArea = document.createElement('textarea');
        textArea.value = currentAuditContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        
        // Show success message
        showToast('Content copied to clipboard!', 'success');
    }
    
    function downloadAuditReport() {
        const customerName = document.getElementById('modalCustomerName').textContent;
        const businessName = document.getElementById('modalBusinessName').textContent;
        const filename = `${customerName}_${businessName}_${currentReportType}.txt`.replace(/[^a-z0-9_\-]/gi, '_');
        
        const blob = new Blob([currentAuditContent], { type: 'text/plain' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        // Show success message
        showToast('Report downloaded successfully!', 'success');
    }
    
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show position-fixed bottom-0 end-0 m-3`;
        toast.style.zIndex = '9999';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
    </script>
@endsection
