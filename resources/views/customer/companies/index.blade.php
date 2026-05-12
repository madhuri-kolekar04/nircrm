@extends('customer.layouts.app')

@section('title', 'My Companies')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">My Companies</h2>
                    <p class="text-muted mb-0">Manage and view all your company projects and invoices</p>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary fs-6">{{ count($companies) }} Companies</span>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($companies))
        <!-- Stats Overview -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="customer-stat-card">
                    <div class="customer-stat-icon primary">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="customer-stat-value">{{ count($companies) }}</div>
                    <div class="customer-stat-label">Total Companies</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="customer-stat-card">
                    <div class="customer-stat-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="customer-stat-value">{{ collect($companies)->sum('completed_payments') }}</div>
                    <div class="customer-stat-label">Completed Projects</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="customer-stat-card">
                    <div class="customer-stat-icon warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="customer-stat-value">{{ collect($companies)->sum('pending_payments') }}</div>
                    <div class="customer-stat-label">Pending Projects</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="customer-stat-card">
                    <div class="customer-stat-icon info">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <div class="customer-stat-value">{{ number_format(collect($companies)->sum('total_amount'), 0) }}</div>
                    <div class="customer-stat-label">Total Value</div>
                </div>
            </div>
        </div>

        <!-- Companies Grid -->
        <div class="row">
            @foreach($companies as $company)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="company-card">
                        <div class="company-card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-building me-2"></i>
                                {{ $company['name'] }}
                            </h5>
                        </div>
                        <div class="company-card-body">
                            <div class="company-stats">
                                <div class="company-stat">
                                    <div class="company-stat-value">{{ count($company['quotations']) }}</div>
                                    <div class="company-stat-label">Projects</div>
                                </div>
                                <div class="company-stat">
                                    <div class="company-stat-value">{{ $company['completed_payments'] }}</div>
                                    <div class="company-stat-label">Completed</div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Total Value:</span>
                                    <strong class="text-primary">{{ $company['total_amount'] }}</strong>
                                </div>
                                @if($company['pending_payments'] > 0)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Pending:</span>
                                        <span class="badge bg-warning">{{ $company['pending_payments'] }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('customer.companies.show', $company['name']) }}" class="btn btn-primary">
                                    <i class="fas fa-eye me-2"></i>View Details
                                </a>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('customer.companies.invoices', $company['name']) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-file-invoice"></i> Invoices
                                    </a>
                                    <a href="{{ route('customer.companies.projects', $company['name']) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-project-diagram"></i> Projects
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="customer-avatar mx-auto mb-4" style="width: 100px; height: 100px; font-size: 2.5rem;">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="mb-3">No Companies Found</h3>
                    <p class="text-muted mb-4">You don't have any companies associated with your account yet.</p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Please contact our support team if you believe this is an error or to get your company account set up.
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
