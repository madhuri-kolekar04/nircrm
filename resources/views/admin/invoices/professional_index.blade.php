@extends('admin.admin_master')

@section('page-title', 'Professional Invoice Management')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
:root {
    --primary-color: #4f46e5;
    --primary-dark: #4338ca;
    --secondary-color: #06b6d4;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --dark-color: #1f2937;
    --light-color: #f9fafb;
    --border-color: #e5e7eb;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    color: var(--dark-color);
}

.professional-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

/* Header Section */
.professional-header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-title {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-title h1 {
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin: 0;
}

.header-title .icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.header-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: var(--shadow-md);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.stat-card.primary::before { background: linear-gradient(90deg, var(--primary-color), var(--primary-dark)); }
.stat-card.success::before { background: linear-gradient(90deg, var(--success-color), #059669); }
.stat-card.warning::before { background: linear-gradient(90deg, var(--warning-color), #d97706); }
.stat-card.info::before { background: linear-gradient(90deg, var(--secondary-color), #0891b2); }

.stat-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-info h3 {
    font-size: 0.875rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark-color);
    line-height: 1;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stat-card.primary .stat-icon { background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); }
.stat-card.success .stat-icon { background: linear-gradient(135deg, var(--success-color), #059669); }
.stat-card.warning .stat-icon { background: linear-gradient(135deg, var(--warning-color), #d97706); }
.stat-card.info .stat-icon { background: linear-gradient(135deg, var(--secondary-color), #0891b2); }

/* Main Content */
.professional-main {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Search and Filter Section */
.search-filter-section {
    background: var(--light-color);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid var(--border-color);
}

.search-filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    align-items: end;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
}

.form-control {
    padding: 0.75rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.875rem;
    transition: var(--transition);
    background: white;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-success {
    background: linear-gradient(135deg, var(--success-color), #059669);
    color: white;
}

.btn-warning {
    background: linear-gradient(135deg, var(--warning-color), #d97706);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, var(--danger-color), #dc2626);
    color: white;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

/* Table Section */
.table-container {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.professional-table {
    width: 100%;
    border-collapse: collapse;
}

.professional-table thead {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
}

.professional-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.professional-table tbody tr {
    border-bottom: 1px solid var(--border-color);
    transition: var(--transition);
}

.professional-table tbody tr:hover {
    background: var(--light-color);
}

.professional-table td {
    padding: 1rem;
    font-size: 0.875rem;
}

.invoice-number {
    font-weight: 700;
    color: var(--primary-color);
}

.customer-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.customer-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

.customer-details {
    flex: 1;
}

.customer-name {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.25rem;
}

.customer-email {
    font-size: 0.75rem;
    color: #6b7280;
}

.amount-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.amount-badge.total {
    background: #dcfce7;
    color: #166534;
}

.amount-badge.advance {
    background: #dbeafe;
    color: #1e40af;
}

.amount-badge.remaining {
    background: #fef3c7;
    color: #92400e;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-badge.paid {
    background: #dcfce7;
    color: #166534;
}

.status-badge.pending {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.overdue {
    background: #fecaca;
    color: #991b1b;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
    font-size: 0.875rem;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.action-btn.view {
    background: #dbeafe;
    color: #1e40af;
}

.action-btn.edit {
    background: #fef3c7;
    color: #92400e;
}

.action-btn.email {
    background: #dcfce7;
    color: #166534;
}

.action-btn.download {
    background: #e0e7ff;
    color: #4338ca;
}

.action-btn.delete {
    background: #fecaca;
    color: #991b1b;
}

.action-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

/* Modal Styles */
.professional-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.professional-modal.show {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 20px;
    max-width: 800px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-lg);
}

.modal-header {
    padding: 2rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark-color);
}

.modal-close {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background: var(--light-color);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.modal-close:hover {
    background: var(--danger-color);
    color: white;
}

.modal-body {
    padding: 2rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .professional-container {
        padding: 1rem;
    }
    
    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .search-filter-grid {
        grid-template-columns: 1fr;
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .professional-table {
        min-width: 800px;
    }
}

/* Loading Animation */
.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Notification Toast */
.notification-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 1rem 1.5rem;
    background: white;
    border-radius: 8px;
    box-shadow: var(--shadow-lg);
    display: flex;
    align-items: center;
    gap: 1rem;
    z-index: 2000;
    transform: translateX(400px);
    transition: var(--transition);
}

.notification-toast.show {
    transform: translateX(0);
}

.notification-toast.success {
    border-left: 4px solid var(--success-color);
}

.notification-toast.error {
    border-left: 4px solid var(--danger-color);
}

.notification-toast.warning {
    border-left: 4px solid var(--warning-color);
}

.notification-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.75rem;
}

.notification-toast.success .notification-icon {
    background: var(--success-color);
}

.notification-toast.error .notification-icon {
    background: var(--danger-color);
}

.notification-toast.warning .notification-icon {
    background: var(--warning-color);
}
</style>
@endsection

@section('admin')
@if(!auth()->check())
    <div class="professional-container">
        <div class="professional-header">
            <div class="alert alert-warning">
                <h4><i class="fas fa-exclamation-triangle"></i> Authentication Required</h4>
                <p>Please <a href="{{ route('login') }}" class="alert-link">login to your account</a> to access the invoice management system.</p>
            </div>
        </div>
    </div>
@else
<div class="professional-container">
    <!-- Professional Header -->
    <div class="professional-header">
        <div class="header-content">
            <div class="header-title">
                <div class="icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <h1>Professional Invoice Management</h1>
            </div>
            <div class="header-actions">
                @if(auth()->user()->role == 1 || auth()->user()->role == 5)
                    <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Invoice
                    </a>
                    <button class="btn btn-success" onclick="exportSelected()">
                        <i class="fas fa-file-excel"></i> Export
                    </button>
                    <button class="btn btn-warning" onclick="bulkEmail()">
                        <i class="fas fa-envelope-bulk"></i> Bulk Email
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>Total Invoices</h3>
                    <div class="stat-value">{{ $totalInvoices ?? 0 }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
            </div>
        </div>

        <div class="stat-card success">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>Paid Invoices</h3>
                    <div class="stat-value">{{ $paidInvoices ?? 0 }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="stat-card warning">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>Pending Invoices</h3>
                    <div class="stat-value">{{ $pendingInvoices ?? 0 }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <div class="stat-card info">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>Total Revenue</h3>
                    <div class="stat-value">₹{{ number_format($totalRevenue ?? 0, 0) }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-rupee-sign"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="professional-main">
        <!-- Search and Filter Section -->
        <div class="search-filter-section">
            <div class="search-filter-grid">
                <div class="form-group">
                    <label>Search</label>
                    <input type="text" class="form-control" id="searchInput" placeholder="Invoice, customer, project...">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="paid">Paid</option>
                        <option value="pending">Pending</option>
                        <option value="overdue">Overdue</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date From</label>
                    <input type="date" class="form-control" id="dateFrom">
                </div>
                <div class="form-group">
                    <label>Date To</label>
                    <input type="date" class="form-control" id="dateTo">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" onclick="applyFilters()">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
                <div class="form-group">
                    <button class="btn btn-secondary" onclick="resetFilters()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        @if($invoices->count() > 0)
            <div class="table-container">
                <table class="professional-table" id="invoicesTable">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                            </th>
                            <th>Invoice #</th>
                            <th>Customer</th>
                            <th>Project</th>
                            <th>Total</th>
                            <th>Advance</th>
                            <th>Remaining</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $counter = 1; @endphp
                        @forelse($invoices as $invoice)
                        <tr data-invoice-id="{{ $invoice->id }}">
                            <td>
                                <input type="checkbox" class="invoice-checkbox" value="{{ $invoice->id }}">
                            </td>
                            <td>
                                <div class="invoice-number">{{ $invoice->invoice_number }}</div>
                                <small class="text-muted">ID: {{ $invoice->id }}</small>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-avatar">
                                        {{ strtoupper(substr($invoice->customer_name, 0, 1)) }}
                                    </div>
                                    <div class="customer-details">
                                        <div class="customer-name">{{ $invoice->customer_name }}</div>
                                        <div class="customer-email">{{ $invoice->customer_email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $invoice->project_name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="amount-badge total">₹{{ number_format($invoice->total_payment, 0) }}</span>
                            </td>
                            <td>
                                <span class="amount-badge advance">₹{{ number_format($invoice->advance_payment, 0) }}</span>
                            </td>
                            <td>
                                <span class="amount-badge remaining">₹{{ number_format($invoice->remaining_payment, 0) }}</span>
                            </td>
                            <td>
                                <span class="status-badge {{ $invoice->status }}">{{ $invoice->status }}</span>
                            </td>
                            <td>
                                <div>{{ $invoice->invoice_date->format('d M Y') }}</div>
                                <small class="text-muted">{{ $invoice->invoice_date->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn view" onclick="viewInvoice({{ $invoice->id }})" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    @if(auth()->check() && (auth()->user()->role == 1 || auth()->user()->role == 5))
                                        <a href="{{ route('invoices.edit', $invoice) }}" class="action-btn edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn email" onclick="sendEmail({{ $invoice->id }})" title="Send Email">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                        <div class="dropdown">
                                            <button class="action-btn download" data-bs-toggle="dropdown" title="Download">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('invoices.export.pdf', $invoice) }}">
                                                    <i class="fas fa-file-pdf"></i> PDF
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ route('invoices.export.word', $invoice) }}">
                                                    <i class="fas fa-file-word"></i> Word
                                                </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="printInvoice({{ $invoice->id }})">
                                                    <i class="fas fa-print"></i> Print
                                                </a></li>
                                            </ul>
                                        </div>
                                        <button class="action-btn delete" onclick="deleteInvoice({{ $invoice->id }})" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        <button class="action-btn edit" disabled title="Edit (Admin Only)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn email" disabled title="Email (Admin Only)">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                        <button class="action-btn download" disabled title="Download (Admin Only)">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        <button class="action-btn delete" disabled title="Delete (Admin Only)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No invoices found</h5>
                                <p class="text-muted">Try adjusting your filters or create a new invoice.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing {{ $invoices->firstItem() ?? 0 }} to {{ $invoices->lastItem() ?? 0 }} of {{ $invoices->total() }} entries
                </div>
                <div>
                    {{ $invoices->links() }}
                </div>
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

<!-- Professional Modal -->
<div class="professional-modal" id="viewModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Invoice Details</h2>
            <button class="modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="modalContent">
            <div class="text-center py-4">
                <div class="loading-spinner"></div>
                <p class="mt-2">Loading invoice details...</p>
            </div>
        </div>
    </div>
</div>

<!-- Notification Toast -->
<div class="notification-toast" id="notification">
    <div class="notification-icon">
        <i class="fas fa-check"></i>
    </div>
    <div class="notification-message">Success message</div>
</div>
@endif

@section('scripts')
<script>
// Professional JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeTable();
    setupSearchFilters();
});

function initializeTable() {
    // Add hover effects to table rows
    const tableRows = document.querySelectorAll('.professional-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
        });
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
}

function setupSearchFilters() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    
    searchInput.addEventListener('input', function() {
        filterTable();
    });
    
    statusFilter.addEventListener('change', function() {
        filterTable();
    });
}

function filterTable() {
    const searchValue = document.getElementById('searchInput').value.toLowerCase();
    const statusValue = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('.professional-table tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const status = row.querySelector('.status-badge')?.textContent.toLowerCase();
        
        const matchesSearch = text.includes(searchValue);
        const matchesStatus = !statusValue || status === statusValue;
        
        row.style.display = matchesSearch && matchesStatus ? '' : 'none';
    });
}

function applyFilters() {
    filterTable();
    showNotification('Filters applied successfully', 'success');
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    filterTable();
    showNotification('Filters reset', 'info');
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.invoice-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

function viewInvoice(invoiceId) {
    const modal = document.getElementById('viewModal');
    const modalContent = document.getElementById('modalContent');
    
    modal.classList.add('show');
    
    fetch(`/invoices/${invoiceId}`)
        .then(response => response.text())
        .then(html => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            
            const cardContent = tempDiv.querySelector('.card') || tempDiv.querySelector('.container-fluid') || tempDiv;
            modalContent.innerHTML = cardContent.innerHTML;
        })
        .catch(error => {
            modalContent.innerHTML = '<div class="alert alert-danger">Error loading invoice details</div>';
        });
}

function closeModal() {
    document.getElementById('viewModal').classList.remove('show');
}

function sendEmail(invoiceId) {
    if (confirm('Send payment reminder email for this invoice?')) {
        fetch(`/invoices/${invoiceId}/send-reminder`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Email sent successfully', 'success');
            } else {
                showNotification(data.error || 'Failed to send email', 'error');
            }
        })
        .catch(error => {
            showNotification('Error sending email', 'error');
        });
    }
}

function deleteInvoice(invoiceId) {
    if (confirm('Are you sure you want to delete this invoice? This action cannot be undone.')) {
        fetch(`/invoices/${invoiceId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Invoice deleted successfully', 'success');
                location.reload();
            } else {
                showNotification(data.error || 'Failed to delete invoice', 'error');
            }
        })
        .catch(error => {
            showNotification('Error deleting invoice', 'error');
        });
    }
}

function printInvoice(invoiceId) {
    window.open(`/invoices/${invoiceId}/print`, '_blank');
}

function exportSelected() {
    const selected = document.querySelectorAll('.invoice-checkbox:checked');
    if (selected.length === 0) {
        showNotification('Please select invoices to export', 'warning');
        return;
    }
    showNotification(`Exporting ${selected.length} invoices...`, 'success');
}

function bulkEmail() {
    const selected = document.querySelectorAll('.invoice-checkbox:checked');
    if (selected.length === 0) {
        showNotification('Please select invoices to send emails', 'warning');
        return;
    }
    if (confirm(`Send payment reminder emails for ${selected.length} invoices?`)) {
        showNotification(`Sending emails to ${selected.length} customers...`, 'success');
    }
}

function showNotification(message, type = 'success') {
    const notification = document.getElementById('notification');
    const icon = notification.querySelector('.notification-icon i');
    const messageEl = notification.querySelector('.notification-message');
    
    notification.className = `notification-toast ${type}`;
    messageEl.textContent = message;
    
    if (type === 'success') {
        icon.className = 'fas fa-check';
    } else if (type === 'error') {
        icon.className = 'fas fa-times';
    } else if (type === 'warning') {
        icon.className = 'fas fa-exclamation';
    }
    
    notification.classList.add('show');
    
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}
</script>
@endsection
@endsection
