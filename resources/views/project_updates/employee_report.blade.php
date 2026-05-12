@extends('admin.admin_master')

@section('page-title', 'Employee Project Updates Report')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar"></i> Employee Project Updates Report
                    </h5>
                    <div>
                        <small class="text-muted">
                            {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
                        </small>
                        <button onclick="window.print()" class="btn btn-sm btn-outline-primary ms-2">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <a href="{{ route('project-updates.index') }}" class="btn btn-sm btn-outline-secondary ms-1">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($employeeReports) > 0)
                        <!-- Summary Section -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Employees</h5>
                                        <h3>{{ count($employeeReports) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Updates</h5>
                                        <h3>{{ array_sum(array_column(array_column($employeeReports, 'total_updates'), 'total_updates')) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Project Updates</h5>
                                        <h3>{{ array_sum(array_column(array_column($employeeReports, 'project_updates'), 'project_updates')) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Invoice Updates</h5>
                                        <h3>{{ array_sum(array_column(array_column($employeeReports, 'invoice_updates'), 'invoice_updates')) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employee Details -->
                        @foreach($employeeReports as $employeeReport)
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h6 class="mb-0">
                                                <i class="fas fa-user"></i> {{ $employeeReport['employee']->name }}
                                                <small class="text-muted">({{ $employeeReport['employee']->department }})</small>
                                            </h6>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <span class="badge bg-primary me-2">{{ $employeeReport['total_updates'] }} Total</span>
                                            <span class="badge bg-info me-2">{{ $employeeReport['project_updates'] }} Projects</span>
                                            <span class="badge bg-warning">{{ $employeeReport['invoice_updates'] }} Invoices</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if(count($employeeReport['updates']) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Date & Time</th>
                                                        <th>Type</th>
                                                        <th>Reference</th>
                                                        <th>Update Details</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($employeeReport['updates'] as $update)
                                                        <tr>
                                                            <td>{{ $update->update_date->format('d-m-Y H:i') }}</td>
                                                            <td>
                                                                @if($update->product_id)
                                                                    <span class="badge bg-info">Project</span>
                                                                @elseif($update->invoice_id)
                                                                    <span class="badge bg-warning">Invoice</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($update->product_id && $update->product)
                                                                    {{ $update->product->product_name_en }}
                                                                @elseif($update->invoice_id && $update->invoice)
                                                                    {{ $update->invoice->invoice_number }} - {{ $update->invoice->project_name }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($update->request_text)
                                                                    <div class="text-muted">
                                                                        <small><strong>Request:</strong></small><br>
                                                                        {!! nl2br(e($update->request_text)) !!}
                                                                    </div>
                                                                @else
                                                                    @if($update->update_point_1)
                                                                        <div>• {{ $update->update_point_1 }}</div>
                                                                    @endif
                                                                    @if($update->update_point_2)
                                                                        <div>• {{ $update->update_point_2 }}</div>
                                                                    @endif
                                                                    @if($update->update_point_3)
                                                                        @if(json_decode($update->update_point_3))
                                                                            @foreach(json_decode($update->update_point_3) as $point)
                                                                                <div>• {{ $point }}</div>
                                                                            @endforeach
                                                                        @else
                                                                            <div>• {{ $update->update_point_3 }}</div>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted">No updates found for this employee in the selected period.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Updates Found</h5>
                            <p class="text-muted">No project updates found for the selected criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .no-print {
        display: none !important;
    }
    
    .card {
        border: 1px solid #ddd !important;
        page-break-inside: avoid;
    }
    
    .table {
        font-size: 12px;
    }
}
</style>
@endsection
