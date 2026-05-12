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
            </div>
            <div class="stat-content">
                <h3>{{ $totalStats['completed_payments'] ?? 0 }}</h3>
                <p>Completed</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalStats['pending_payments'] ?? 0 }}</h3>
                <p>Pending</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-rupee-sign"></i>
            </div>
            <div class="stat-content">
                <h3>₹{{ number_format($totalStats['total_amount'] ?? 0, 0) }}</h3>
                <p>Total Value</p>
            </div>
        </div>
    </div>

    <!-- Projects Section -->
    <div class="projects-section">
        <div class="section-header">
            <h2>Your Projects</h2>
            <p>Select a project to view details</p>
        </div>
        
        @if($companies && count($companies) > 0)
            <div class="projects-grid">
                @foreach($companies as $company)
                    <div class="project-card" onclick="selectProject('{{ $company['name'] }}', '{{ $company['name'] }}')">
                        <div class="project-header">
                            <h3>{{ $company['name'] }}</h3>
                            <span class="project-status {{ ($company['completed_payments'] ?? 0) > 0 ? 'active' : 'pending' }}">
                                {{ ($company['completed_payments'] ?? 0) > 0 ? 'Active' : 'Pending' }}
                            </span>
                        </div>
                        
                        <div class="project-stats">
                            <div class="project-stat">
                                <span class="stat-number">{{ count($company['quotations']) }}</span>
                                <span class="stat-label">Projects</span>
                            </div>
                            <div class="project-stat">
                                <span class="stat-number">₹{{ number_format($company['total_amount'], 0) }}</span>
                                <span class="stat-label">Value</span>
                            </div>
                        </div>
                        
                        <div class="project-action">
                            <span>View Details</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3>No Projects Yet</h3>
                <p>Your projects will appear here once they're set up</p>
            </div>
        @endif
    </div>
<style>
/* Project Boxes */
        .project-box {
            background: var(--white);
            border: 2px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .project-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
        }

        .project-box-header {
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            color: var(--white);
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .project-box-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }

        .project-box-body {
            padding: 1.5rem;
        }

        .project-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .project-stat {
            text-align: center;
            padding: 1rem;
            background: var(--light-bg);
            border-radius: 12px;
        }

        .project-stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .project-stat-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

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

.quick-action-card.disabled-action {
    opacity: 0.6;
    cursor: not-allowed;
    pointer-events: none;
}

.quick-action-card.disabled-action:hover {
    transform: none;
    box-shadow: none;
    color: var(--text-primary);
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
