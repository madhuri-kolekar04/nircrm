@extends('customer.layouts.app')

@section('title', $companyName . ' - Projects')

@section('content')
<div class="projects-container">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1>{{ $companyName }}</h1>
                <p>Track all your project progress and updates</p>
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
                <i class="fas fa-project-diagram"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $quotations->count() }}</h3>
                <p>Total Projects</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $quotations->where('approval_status', 'approved')->count() }}</h3>
                <p>Approved</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $quotations->where('payment_status', 'completed')->count() }}</h3>
                <p>Completed</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-rupee-sign"></i>
            </div>
            <div class="stat-content">
                <h3>₹{{ number_format($quotations->sum('final_amount'), 0) }}</h3>
                <p>Total Value</p>
            </div>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="projects-section">
        <div class="section-header">
            <h2>Project List</h2>
            <p>All projects for {{ $companyName }}</p>
        </div>
        
        <div class="projects-grid">
            @foreach($quotations as $quotation)
                <div class="project-card">
                    <div class="project-header">
                        <h3>{{ $quotation->quotation_number }}</h3>
                        <span class="project-status {{ $quotation->approval_status }}">
                            {{ ucfirst($quotation->approval_status) }}
                        </span>
                    </div>
                    
                    <div class="project-body">
                        <p class="project-description">
                            {{ Str::limit($quotation->executive_summary ?? 'No description available', 120) }}
                        </p>
                        
                        <div class="project-stats">
                            <div class="project-stat">
                                <span class="label">Status</span>
                                <span class="value status-badge {{ $quotation->approval_status_color }}">
                                    {{ ucfirst($quotation->approval_status) }}
                                </span>
                            </div>
                            <div class="project-stat">
                                <span class="label">Payment</span>
                                <span class="value status-badge {{ $quotation->payment_status_color }}">
                                    {{ ucfirst($quotation->payment_status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="project-details">
                            <div class="detail-row">
                                <span class="detail-label">Value:</span>
                                <span class="detail-value">{{ $quotation->formatted_final_amount }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Created:</span>
                                <span class="detail-value">{{ $quotation->created_at->format('M d, Y') }}</span>
                            </div>
                            @if($quotation->approved_at)
                                <div class="detail-row">
                                    <span class="detail-label">Approved:</span>
                                    <span class="detail-value">{{ $quotation->approved_at->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="project-actions">
                        <button class="btn btn-info" onclick="viewProject({{ $quotation->id }})">
                            <i class="fas fa-eye me-2"></i>View Details
                        </button>
                        @if($quotation->payment_status == 'completed')
                            <button class="btn btn-success" onclick="downloadInvoice({{ $quotation->id }})">
                                <i class="fas fa-download me-2"></i>Download Invoice
                            </button>
                        @endif
                        <button class="btn btn-primary" onclick="trackProgress({{ $quotation->id }})">
                            <i class="fas fa-chart-line me-2"></i>Track Progress
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Timeline Section -->
    <div class="timeline-section">
        <div class="section-header">
            <h2>Project Timeline</h2>
            <p>Chronological view of all project activities</p>
        </div>
        
        <div class="timeline">
            @foreach($quotations->sortBy('created_at') as $quotation)
                <div class="timeline-item">
                    <div class="timeline-marker {{ $quotation->approval_status_color }}">
                        <i class="fas fa-{{ $quotation->approval_status == 'approved' ? 'check' : 'clock' }}"></i>
                    </div>
                    <div class="timeline-content">
                        <h4>{{ $quotation->quotation_number }}</h4>
                        <p>{{ Str::limit($quotation->executive_summary ?? 'Project quotation', 100) }}</p>
                        <div class="timeline-meta">
                            <span class="date">
                                <i class="fas fa-calendar me-1"></i>
                                Created: {{ $quotation->created_at->format('M d, Y') }}
                            </span>
                            @if($quotation->approved_at)
                                <span class="date">
                                    <i class="fas fa-check me-1"></i>
                                    Approved: {{ $quotation->approved_at->format('M d, Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.projects-container {
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

/* Section Headers */
.section-header {
    text-align: center;
    margin-bottom: 2rem;
}

.section-header h2 {
    font-size: 1.8rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.section-header p {
    color: #718096;
    margin: 0;
}

/* Projects Section */
.projects-section {
    margin-bottom: 3rem;
}

.projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.project-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.project-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.project-header h3 {
    font-size: 1.3rem;
    font-weight: 600;
    margin: 0;
}

.project-status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.project-status.approved {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.project-status.pending {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.project-body {
    padding: 2rem;
}

.project-description {
    color: #718096;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.project-stats {
    display: flex;
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.project-stat {
    flex: 1;
}

.project-stat .label {
    display: block;
    font-size: 0.8rem;
    color: #718096;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-badge.success {
    background: #d4edda;
    color: #155724;
}

.status-badge.warning {
    background: #fff3cd;
    color: #856404;
}

.status-badge.info {
    background: #d1ecf1;
    color: #0c5460;
}

.project-details {
    margin-bottom: 1.5rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.detail-label {
    color: #718096;
    font-size: 0.9rem;
}

.detail-value {
    font-weight: 600;
    color: #2d3748;
}

.project-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.btn {
    padding: 0.75rem 1rem;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    font-size: 0.9rem;
}

.btn.btn-info {
    background: #17a2b8;
    color: white;
}

.btn.btn-success {
    background: #28a745;
    color: white;
}

.btn.btn-primary {
    background: #667eea;
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

/* Timeline Section */
.timeline-section {
    margin-bottom: 3rem;
}

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
    margin-bottom: 2rem;
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

.timeline-marker.success {
    background: #28a745;
}

.timeline-marker.warning {
    background: #ffc107;
}

.timeline-content {
    background: white;
    padding: 1.5rem;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border-left: 4px solid #667eea;
}

.timeline-content h4 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.timeline-content p {
    color: #718096;
    margin-bottom: 1rem;
}

.timeline-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.timeline-meta .date {
    font-size: 0.8rem;
    color: #718096;
}

/* Responsive Design */
@media (max-width: 768px) {
    .projects-container {
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
    
    .projects-grid {
        grid-template-columns: 1fr;
    }
    
    .project-actions {
        flex-direction: column;
    }
    
    .timeline-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
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
