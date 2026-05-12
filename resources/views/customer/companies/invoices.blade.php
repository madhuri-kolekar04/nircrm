@extends('customer.layouts.app')

@section('title', $companyName . ' - Invoices')

@section('content')
<div class="invoices-container">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1>{{ $companyName }}</h1>
                <p>All invoices for this project</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('customer.companies.show', $companyName) }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left me-2"></i>Back to Project
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $quotations->count() }}</h3>
                <p>Total Invoices</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3>₹{{ number_format($quotations->where('payment_status', 'completed')->sum('final_amount'), 0) }}</h3>
                <p>Paid Amount</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3>₹{{ number_format($quotations->where('payment_status', '!=', 'completed')->sum('final_amount'), 0) }}</h3>
                <p>Pending Amount</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-check"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $quotations->where('payment_status', 'completed')->count() }}</h3>
                <p>Completed</p>
            </div>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="invoices-table-container">
        <div class="table-header">
            <h2>Invoice List</h2>
            <button class="btn btn-primary" onclick="downloadAllInvoices()">
                <i class="fas fa-download me-2"></i>Download All
            </button>
        </div>
        
        <div class="table-wrapper">
            <table class="invoices-table">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Quotation #</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotations as $quotation)
                        <tr>
                            <td>
                                <span class="invoice-number">INV-{{ date('Y') }}-{{ str_pad($quotation->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>{{ $quotation->quotation_number }}</td>
                            <td>{{ $quotation->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="amount">₹{{ $quotation->formatted_final_amount }}</span>
                            </td>
                            <td>
                                @if($quotation->payment_status == 'completed')
                                    <span class="status paid">
                                        <i class="fas fa-check-circle me-1"></i>Paid
                                    </span>
                                @else
                                    <span class="status pending">
                                        <i class="fas fa-clock me-1"></i>Pending
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($quotation->payment_updated_at)
                                    {{ $quotation->payment_updated_at->format('M d, Y') }}
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon btn-info" onclick="viewQuotation({{ $quotation->id }})" title="View Quotation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($quotation->payment_status == 'completed')
                                        <button class="btn-icon btn-success" onclick="downloadInvoice({{ $quotation->id }})" title="Download Invoice">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    @endif
                                    <button class="btn-icon btn-primary" onclick="emailInvoice({{ $quotation->id }})" title="Email Invoice">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.invoices-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

/* Page Header */
.page-header {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-info h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.header-info p {
    color: #718096;
    margin: 0;
}

.btn-outline {
    background: transparent;
    border: 2px solid #667eea;
    color: #667eea;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-outline:hover {
    background: #667eea;
    color: white;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.stat-icon.blue { background: linear-gradient(135deg, #667eea, #764ba2); }
.stat-icon.green { background: linear-gradient(135deg, #11998e, #38ef7d); }
.stat-icon.orange { background: linear-gradient(135deg, #f093fb, #f5576c); }
.stat-icon.purple { background: linear-gradient(135deg, #4facfe, #00f2fe); }

.stat-content h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
}

.stat-content p {
    margin: 0.25rem 0 0 0;
    color: #718096;
    font-size: 0.9rem;
}

/* Table Container */
.invoices-table-container {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.table-header h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

/* Table Styles */
.table-wrapper {
    overflow-x: auto;
}

.invoices-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
}

.invoices-table th {
    background: #f8f9fa;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #2d3748;
    border-bottom: 2px solid #e9ecef;
}

.invoices-table td {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.invoices-table tr:hover {
    background: #f8f9fa;
}

.invoice-number {
    font-weight: 600;
    color: #667eea;
}

.amount {
    font-weight: 600;
    color: #11998e;
}

.status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status.paid {
    background: #d4edda;
    color: #155724;
}

.status.pending {
    background: #fff3cd;
    color: #856404;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-icon.btn-info {
    background: #17a2b8;
    color: white;
}

.btn-icon.btn-success {
    background: #28a745;
    color: white;
}

.btn-icon.btn-primary {
    background: #667eea;
    color: white;
}

.btn-icon:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

/* Responsive Design */
@media (max-width: 768px) {
    .invoices-container {
        padding: 1rem;
    }
    
    .header-content {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .table-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .invoices-table {
        font-size: 0.8rem;
    }
    
    .invoices-table th,
    .invoices-table td {
        padding: 0.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>

@section('scripts')
<script>
function viewQuotation(quotationId) {
    window.open('/quotations/' + quotationId, '_blank');
}

function downloadInvoice(quotationId) {
    window.open('/accounts/generate-invoice/' + quotationId, '_blank');
}

function emailInvoice(quotationId) {
    if (confirm('Do you want to receive this invoice via email?')) {
        alert('Invoice will be sent to your registered email address.');
    }
}

function downloadAllInvoices() {
    alert('Bulk download feature coming soon!');
}
</script>
@endsection
