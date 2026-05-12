@extends('customer.layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="customer-card">
                <div class="customer-card-header text-center">
                    <h1 class="mb-2">
                        <i class="fas fa-hand-wave me-3"></i>Welcome Back, {{ auth()->user()->name }}!
                    </h1>
                    <p class="lead mb-0">Here's your business overview at a glance</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="customer-stat-card">
                <div class="customer-stat-icon primary">
                    <i class="fas fa-building"></i>
                </div>
                <div class="customer-stat-value">{{ $totalStats['total_companies'] ?? 0 }}</div>
                <div class="customer-stat-label">Active Companies</div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="customer-stat-card">
                <div class="customer-stat-icon success">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <div class="customer-stat-value">{{ number_format($totalStats['total_amount'] ?? 0, 0) }}</div>
                <div class="customer-stat-label">Total Portfolio Value</div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-success" style="width: 85%"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="customer-stat-card">
                <div class="customer-stat-icon info">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="customer-stat-value">{{ $totalStats['completed_payments'] ?? 0 }}</div>
                <div class="customer-stat-label">Completed Projects</div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-info" style="width: {{ ($totalStats['total_quotations'] ?? 0) > 0 ? (($totalStats['completed_payments'] ?? 0) / ($totalStats['total_quotations'] ?? 1) * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="customer-stat-card">
                <div class="customer-stat-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="customer-stat-value">{{ $totalStats['pending_payments'] ?? 0 }}</div>
                <div class="customer-stat-label">Pending Projects</div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-warning" style="width: {{ ($totalStats['total_quotations'] ?? 0) > 0 ? (($totalStats['pending_payments'] ?? 0) / ($totalStats['total_quotations'] ?? 1) * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Companies Overview & Recent Activity -->
    <div class="row">
        <!-- Companies Grid -->
        <div class="col-lg-8 mb-4">
            <div class="customer-card">
                <div class="customer-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-building me-2"></i>Your Companies
                        </h5>
                        <a href="{{ route('customer.companies.index') }}" class="btn btn-sm btn-outline-primary">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="customer-card-body">
                    @if($companies && count($companies) > 0)
                        <div class="row">
                            @foreach(array_slice($companies, 0, 6) as $company)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="company-card h-100">
                                        <div class="company-card-header">
                                            <h6 class="mb-0">{{ $company['name'] }}</h6>
                                        </div>
                                        <div class="company-card-body">
                                            <div class="company-stats mb-3">
                                                <div class="company-stat">
                                                    <div class="company-stat-value">{{ count($company['quotations']) }}</div>
                                                    <div class="company-stat-label">Projects</div>
                                                </div>
                                                <div class="company-stat">
                                                    <div class="company-stat-value">{{ number_format($company['total_amount'], 0) }}</div>
                                                    <div class="company-stat-label">Value</div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-{{ ($company['completed_payments'] ?? 0) > 0 ? 'success' : 'warning' }}">
                                                    {{ ($company['completed_payments'] ?? 0) > 0 ? 'Active' : 'Pending' }}
                                                </span>
                                                <a href="{{ route('customer.companies.show', $company['name']) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="customer-avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                <i class="fas fa-building"></i>
                            </div>
                            <h5>No Companies Yet</h5>
                            <p class="text-muted">Your companies will appear here once they're set up by the administrator.</p>
                            <div class="mt-3">
                                <i class="fas fa-info-circle text-muted fa-2x mb-2"></i>
                                <p class="text-muted small">Contact your administrator to get started with your company profile.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4 mb-4">
            <div class="customer-card">
                <div class="customer-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Recent Activity
                    </h5>
                </div>
                <div class="customer-card-body">
                    @if($recentQuotations && $recentQuotations->isNotEmpty())
                        <div class="activity-timeline">
                            @foreach($recentQuotations as $quotation)
                                <div class="activity-item">
                                    <div class="activity-icon bg-{{ $quotation->approval_status_color ?? 'secondary' }}">
                                        <i class="fas fa-{{ ($quotation->approval_status ?? 'pending') == 'approved' ? 'check' : 'clock' }}"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-title">{{ $quotation->quotation_number ?? 'N/A' }}</div>
                                        <div class="activity-description">{{ $quotation->client_business_name ?? 'Unknown Company' }}</div>
                                        <div class="activity-time">{{ $quotation->created_at?->diffForHumans() ?? 'Unknown time' }}</div>
                                        <div class="activity-amount">{{ $quotation->formatted_final_amount ?? '₹0' }}</div>
                                        <div class="activity-actions mt-2">
                                            <a href="{{ route('customer.quotations.pdf', $quotation->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clock text-muted fa-2x mb-3"></i>
                            <p class="text-muted">No recent activity</p>
                            <p class="text-muted small">Your activity will appear here once you have active projects.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="customer-card">
                <div class="customer-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="customer-card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('customer.companies.index') }}" class="quick-action-card">
                                <div class="quick-action-icon bg-primary">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h6>View Companies</h6>
                                    <small>Manage your business entities</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="#" class="quick-action-card">
                                <div class="quick-action-icon bg-success">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h6>All Invoices</h6>
                                    <small>Download and manage invoices</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="#" class="quick-action-card">
                                <div class="quick-action-icon bg-info">
                                    <i class="fas fa-project-diagram"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h6>Projects</h6>
                                    <small>Track project progress</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="#" class="quick-action-card">
                                <div class="quick-action-icon bg-warning">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h6>Reports</h6>
                                    <small>View business analytics</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.activity-timeline {
    position: relative;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    position: relative;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
    margin-right: 1rem;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
}

.activity-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.activity-description {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.activity-time {
    color: var(--text-secondary);
    font-size: 0.75rem;
    margin-bottom: 0.25rem;
}

.activity-amount {
    font-weight: 600;
    color: var(--primary-color);
}

.activity-actions {
    display: flex;
    gap: 0.5rem;
}

.activity-actions .btn {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
}

.quick-action-card {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: var(--white);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s ease;
    height: 100%;
}

.quick-action-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    color: var(--primary-color);
}

.quick-action-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 1rem;
    flex-shrink: 0;
}

.quick-action-content h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
}

.quick-action-content small {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.progress {
    background-color: rgba(0, 0, 0, 0.1);
    border-radius: 3px;
}

.progress-bar {
    border-radius: 3px;
}

@media (max-width: 768px) {
    .quick-action-card {
        flex-direction: column;
        text-align: center;
    }
    
    .quick-action-icon {
        margin-right: 0;
        margin-bottom: 1rem;
    }
}
</style>
@endsection
