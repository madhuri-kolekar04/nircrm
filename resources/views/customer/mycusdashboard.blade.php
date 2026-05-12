@extends('customer.layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Animated Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="welcome-text">
                        <h1 class="welcome-title">
                            <span class="wave-emoji">👋</span>
                            Welcome back, {{ auth()->user()->name }}!
                        </h1>
                        <p class="welcome-subtitle">Your business dashboard is ready to explore</p>
                        <div class="welcome-stats">
                            <div class="welcome-stat">
                                <span class="stat-number">{{ $totalStats['total_companies'] ?? 0 }}</span>
                                <span class="stat-label">Companies</span>
                            </div>
                            <div class="welcome-stat">
                                <span class="stat-number">{{ $totalStats['total_quotations'] ?? 0 }}</span>
                                <span class="stat-label">Projects</span>
                            </div>
                            <div class="welcome-stat">
                                <span class="stat-number">₹{{ number_format($totalStats['total_amount'] ?? 0, 0) }}</span>
                                <span class="stat-label">Total Value</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="welcome-decoration">
                    <div class="floating-shape shape-1"></div>
                    <div class="floating-shape shape-2"></div>
                    <div class="floating-shape shape-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card stat-card-primary">
                <div class="stat-card-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-card-content">
                    <div class="stat-card-number">{{ $totalStats['total_companies'] ?? 0 }}</div>
                    <div class="stat-card-label">Active Companies</div>
                    <div class="stat-card-progress">
                        <div class="progress">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
                <div class="stat-card-decoration">
                    <i class="fas fa-building decoration-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card stat-card-success">
                <div class="stat-card-icon">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <div class="stat-card-content">
                    <div class="stat-card-number">₹{{ number_format($totalStats['total_amount'] ?? 0, 0) }}</div>
                    <div class="stat-card-label">Portfolio Value</div>
                    <div class="stat-card-progress">
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: 85%"></div>
                        </div>
                    </div>
                </div>
                <div class="stat-card-decoration">
                    <i class="fas fa-chart-line decoration-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card stat-card-info">
                <div class="stat-card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-card-content">
                    <div class="stat-card-number">{{ $totalStats['completed_payments'] ?? 0 }}</div>
                    <div class="stat-card-label">Completed</div>
                    <div class="stat-card-progress">
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width: {{ ($totalStats['total_quotations'] ?? 0) > 0 ? (($totalStats['completed_payments'] ?? 0) / ($totalStats['total_quotations'] ?? 1) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="stat-card-decoration">
                    <i class="fas fa-trophy decoration-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card stat-card-warning">
                <div class="stat-card-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-card-content">
                    <div class="stat-card-number">{{ $totalStats['pending_payments'] ?? 0 }}</div>
                    <div class="stat-card-label">In Progress</div>
                    <div class="stat-card-progress">
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: {{ ($totalStats['total_quotations'] ?? 0) > 0 ? (($totalStats['pending_payments'] ?? 0) / ($totalStats['total_quotations'] ?? 1) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="stat-card-decoration">
                    <i class="fas fa-hourglass-half decoration-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Companies Grid & Activity Timeline -->
    <div class="row mb-4">
        <!-- Companies Grid -->
        <div class="col-lg-8 mb-4">
            <div class="content-card">
                <div class="content-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-building me-2"></i>Your Companies
                        </h5>
                        <a href="{{ route('customer.companies.index') }}" class="btn btn-primary btn-sm">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="content-card-body">
                    @if($companies && count($companies) > 0)
                        <div class="companies-grid">
                            @foreach(array_slice($companies, 0, 6) as $company)
                                <div class="company-card-modern">
                                    <div class="company-card-header-modern">
                                        <div class="company-icon">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <div class="company-status">
                                            <span class="status-badge status-{{ ($company['completed_payments'] ?? 0) > 0 ? 'active' : 'pending' }}">
                                                {{ ($company['completed_payments'] ?? 0) > 0 ? 'Active' : 'Pending' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="company-card-body-modern">
                                        <h6 class="company-name">{{ $company['name'] }}</h6>
                                        <div class="company-stats-modern">
                                            <div class="company-stat-modern">
                                                <span class="stat-value">{{ count($company['quotations']) }}</span>
                                                <span class="stat-text">Projects</span>
                                            </div>
                                            <div class="company-stat-modern">
                                                <span class="stat-value">₹{{ number_format($company['total_amount'], 0) }}</span>
                                                <span class="stat-text">Value</span>
                                            </div>
                                        </div>
                                        <div class="company-actions">
                                            <a href="{{ route('customer.companies.show', $company['name']) }}" class="btn btn-outline-primary btn-sm">
                                                View Details <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <h5>No Companies Yet</h5>
                            <p>Your companies will appear here once they're set up by the administrator.</p>
                            <div class="empty-state-actions">
                                <button class="btn btn-primary" disabled>
                                    <i class="fas fa-plus me-2"></i>Coming Soon
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="col-lg-4 mb-4">
            <div class="content-card">
                <div class="content-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Recent Activity
                    </h5>
                </div>
                <div class="content-card-body">
                    @if($recentQuotations && $recentQuotations->isNotEmpty())
                        <div class="activity-timeline-modern">
                            @foreach($recentQuotations as $quotation)
                                <div class="activity-item-modern">
                                    <div class="activity-dot activity-{{ ($quotation->approval_status ?? 'pending') == 'approved' ? 'success' : 'pending' }}"></div>
                                    <div class="activity-content-modern">
                                        <div class="activity-header">
                                            <span class="activity-title">{{ $quotation->quotation_number ?? 'N/A' }}</span>
                                            <span class="activity-time">{{ $quotation->created_at?->diffForHumans() ?? 'Unknown time' }}</span>
                                        </div>
                                        <div class="activity-description">{{ $quotation->client_business_name ?? 'Unknown Company' }}</div>
                                        <div class="activity-amount">₹{{ number_format($quotation->final_amount ?? 0, 0) }}</div>
                                        <div class="activity-actions">
                                            <a href="{{ route('customer.quotations.pdf', $quotation->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h5>No Recent Activity</h5>
                            <p>Your activity will appear here once you have active projects.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Grid -->
    <div class="row">
        <div class="col-12">
            <div class="content-card">
                <div class="content-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="content-card-body">
                    <div class="quick-actions-grid">
                        <a href="{{ route('customer.companies.index') }}" class="quick-action-modern">
                            <div class="quick-action-icon quick-action-primary">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="quick-action-content">
                                <h6>View Companies</h6>
                                <small>Manage your business entities</small>
                            </div>
                            <div class="quick-action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        <a href="#" class="quick-action-modern">
                            <div class="quick-action-icon quick-action-success">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div class="quick-action-content">
                                <h6>All Invoices</h6>
                                <small>Download and manage invoices</small>
                            </div>
                            <div class="quick-action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        <a href="#" class="quick-action-modern">
                            <div class="quick-action-icon quick-action-info">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div class="quick-action-content">
                                <h6>Projects</h6>
                                <small>Track project progress</small>
                            </div>
                            <div class="quick-action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        <a href="#" class="quick-action-modern">
                            <div class="quick-action-icon quick-action-warning">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="quick-action-content">
                                <h6>Reports</h6>
                                <small>View business analytics</small>
                            </div>
                            <div class="quick-action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Welcome Header Styles */
.welcome-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.welcome-content {
    display: flex;
    align-items: center;
    position: relative;
    z-index: 2;
}

.welcome-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    margin-right: 2rem;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.welcome-text {
    flex: 1;
}

.welcome-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    animation: fadeInUp 0.6s ease-out;
}

.wave-emoji {
    display: inline-block;
    animation: wave 2s infinite;
}

@keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(20deg); }
    75% { transform: rotate(-10deg); }
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.8s ease-out;
}

.welcome-stats {
    display: flex;
    gap: 2rem;
    animation: fadeInUp 1s ease-out;
}

.welcome-stat {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.8;
    margin-top: 0.25rem;
}

.welcome-decoration {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.floating-shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 6s ease-in-out infinite;
}

.shape-1 {
    width: 60px;
    height: 60px;
    top: 20%;
    right: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 40px;
    height: 40px;
    top: 60%;
    right: 20%;
    animation-delay: 2s;
}

.shape-3 {
    width: 30px;
    height: 30px;
    top: 40%;
    right: 5%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Enhanced Stat Cards */
.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.stat-card-primary {
    border-left: 4px solid #667eea;
}

.stat-card-success {
    border-left: 4px solid #10b981;
}

.stat-card-info {
    border-left: 4px solid #3b82f6;
}

.stat-card-warning {
    border-left: 4px solid #f59e0b;
}

.stat-card-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-bottom: 1rem;
}

.stat-card-primary .stat-card-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.stat-card-success .stat-card-icon {
    background: linear-gradient(135deg, #10b981, #059669);
}

.stat-card-info .stat-card-icon {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.stat-card-warning .stat-card-icon {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.stat-card-content {
    position: relative;
    z-index: 2;
}

.stat-card-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.stat-card-label {
    color: #64748b;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 1rem;
}

.stat-card-progress {
    margin-top: 1rem;
}

.stat-card-progress .progress {
    height: 6px;
    background-color: #f1f5f9;
    border-radius: 3px;
}

.stat-card-decoration {
    position: absolute;
    top: 1rem;
    right: 1rem;
    opacity: 0.1;
    font-size: 3rem;
    color: #64748b;
}

/* Content Cards */
.content-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.content-card-header {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.content-card-body {
    padding: 1.5rem;
}

/* Companies Grid */
.companies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.company-card-modern {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.company-card-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border-color: #cbd5e1;
}

.company-card-header-modern {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.company-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-active {
    background: #dcfce7;
    color: #166534;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.company-name {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 1rem;
}

.company-stats-modern {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.company-stat-modern {
    text-align: center;
    flex: 1;
}

.stat-value {
    display: block;
    font-weight: 700;
    color: #1e293b;
    font-size: 1.1rem;
}

.stat-text {
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Activity Timeline */
.activity-timeline-modern {
    position: relative;
}

.activity-item-modern {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    position: relative;
}

.activity-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 1rem;
    margin-top: 0.25rem;
    flex-shrink: 0;
    position: relative;
}

.activity-dot::before {
    content: '';
    position: absolute;
    top: -8px;
    left: -8px;
    right: -8px;
    bottom: -8px;
    border-radius: 50%;
    background: currentColor;
    opacity: 0.2;
}

.activity-success {
    background: #10b981;
    color: #10b981;
}

.activity-pending {
    background: #f59e0b;
    color: #f59e0b;
}

.activity-content-modern {
    flex: 1;
    background: #f8fafc;
    border-radius: 8px;
    padding: 1rem;
    border: 1px solid #e2e8f0;
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.activity-title {
    font-weight: 600;
    color: #1e293b;
}

.activity-time {
    font-size: 0.75rem;
    color: #64748b;
}

.activity-description {
    color: #64748b;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.activity-amount {
    font-weight: 600;
    color: #667eea;
    margin-bottom: 0.5rem;
}

/* Quick Actions */
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.quick-action-modern {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    text-decoration: none;
    color: #1e293b;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.quick-action-modern:hover {
    background: white;
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
    color: #667eea;
}

.quick-action-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 1rem;
    flex-shrink: 0;
}

.quick-action-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.quick-action-success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.quick-action-info {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.quick-action-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.quick-action-content {
    flex: 1;
}

.quick-action-content h6 {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.quick-action-content small {
    color: #64748b;
    font-size: 0.875rem;
}

.quick-action-arrow {
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease;
}

.quick-action-modern:hover .quick-action-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Empty States */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: #64748b;
}

.empty-state h5 {
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #64748b;
    margin-bottom: 1.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-content {
        flex-direction: column;
        text-align: center;
    }
    
    .welcome-avatar {
        margin-right: 0;
        margin-bottom: 1rem;
    }
    
    .welcome-stats {
        justify-content: center;
        gap: 1rem;
    }
    
    .companies-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
