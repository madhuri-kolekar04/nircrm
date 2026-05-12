@extends('customer.layouts.app')

@section('title', $companyName . ' - Projects')

@section('content')
<div class="container-fluid">
    <!-- Company Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('customer.companies.index') }}">My Companies</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.companies.show', $companyName) }}">{{ $companyName }}</a></li>
                            <li class="breadcrumb-item active">Projects</li>
                        </ol>
                    </nav>
                    <h2 class="mb-1">{{ $companyName }} - Projects</h2>
                    <p class="text-muted mb-0">Track all your project progress and updates</p>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('customer.companies.show', $companyName) }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Company
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="customer-stat-card">
                <div class="customer-stat-icon primary">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <div class="customer-stat-value">{{ $quotations->count() }}</div>
                <div class="customer-stat-label">Total Projects</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="customer-stat-card">
                <div class="customer-stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="customer-stat-value">{{ $quotations->where('approval_status', 'approved')->count() }}</div>
                <div class="customer-stat-label">Approved</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="customer-stat-card">
                <div class="customer-stat-icon warning">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="customer-stat-value">{{ $quotations->where('payment_status', 'completed')->count() }}</div>
                <div class="customer-stat-label">Completed</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="customer-stat-card">
                <div class="customer-stat-icon info">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <div class="customer-stat-value">{{ number_format($quotations->sum('final_amount'), 0) }}</div>
                <div class="customer-stat-label">Total Value</div>
            </div>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="customer-card">
                <div class="customer-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-project-diagram me-2"></i>Project List
                    </h5>
                </div>
                <div class="customer-card-body">
                    <div class="row">
                        @foreach($quotations as $quotation)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="company-card">
                                    <div class="company-card-header">
                                        <h6 class="mb-0">
                                            {{ $quotation->quotation_number }}
                                        </h6>
                                    </div>
                                    <div class="company-card-body">
                                        <div class="project-info mb-3">
                                            <p class="text-muted mb-2">{{ Str::limit($quotation->executive_summary ?? 'No description available', 80) }}</p>
                                            
                                            <div class="company-stats mb-3">
                                                <div class="company-stat">
                                                    <div class="company-stat-value">
                                                        <span class="badge bg-{{ $quotation->approval_status_color }}">
                                                            {{ ucfirst($quotation->approval_status) }}
                                                        </span>
                                                    </div>
                                                    <div class="company-stat-label">Status</div>
                                                </div>
                                                <div class="company-stat">
                                                    <div class="company-stat-value">
                                                        <span class="badge bg-{{ $quotation->payment_status_color }}">
                                                            {{ ucfirst($quotation->payment_status) }}
                                                        </span>
                                                    </div>
                                                    <div class="company-stat-label">Payment</div>
                                                </div>
                                            </div>
                                            
                                            <div class="project-details">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Value:</span>
                                                    <strong>{{ $quotation->formatted_final_amount }}</strong>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Created:</span>
                                                    <span>{{ $quotation->created_at->format('M d, Y') }}</span>
                                                </div>
                                                @if($quotation->approved_at)
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-muted">Approved:</span>
                                                        <span>{{ $quotation->approved_at->format('M d, Y') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-sm btn-info" onclick="viewProject({{ $quotation->id }})">
                                                <i class="fas fa-eye me-2"></i>View Details
                                            </button>
                                            @if($quotation->payment_status == 'completed')
                                                <button type="button" class="btn btn-sm btn-success" onclick="downloadInvoice({{ $quotation->id }})">
                                                    <i class="fas fa-download me-2"></i>Download Invoice
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-primary" onclick="trackProgress({{ $quotation->id }})">
                                                <i class="fas fa-chart-line me-2"></i>Track Progress
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Timeline -->
    <div class="row">
        <div class="col-12">
            <div class="customer-card">
                <div class="customer-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Project Timeline
                    </h5>
                </div>
                <div class="customer-card-body">
                    <div class="timeline">
                        @foreach($quotations->sortBy('created_at') as $quotation)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-{{ $quotation->approval_status_color }}">
                                    <i class="fas fa-{{ $quotation->approval_status == 'approved' ? 'check' : 'clock' }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>{{ $quotation->quotation_number }}</h6>
                                    <p class="text-muted mb-1">{{ Str::limit($quotation->executive_summary ?? 'Project quotation', 100) }}</p>
                                    <small class="text-muted">
                                        Created: {{ $quotation->created_at->format('M d, Y') }}
                                        @if($quotation->approved_at)
                                            | Approved: {{ $quotation->approved_at->format('M d, Y') }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}
</style>

@section('scripts')
<script>
function viewProject(quotationId) {
    window.open('/quotations/' + quotationId, '_blank');
}

function downloadInvoice(quotationId) {
    window.open('/accounts/generate-invoice/' + quotationId, '_blank');
}

function trackProgress(quotationId) {
    alert('Project tracking feature coming soon!');
}
</script>
@endsection
@endsection
