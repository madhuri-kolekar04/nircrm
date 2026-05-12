@extends('admin.admin_master')

@section('page-title', 'Invoice Details - View Only')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-eye me-2"></i>Invoice Details (View Only)
                    </h5>
                    <div class="btn-group">
                        @if(auth()->user()->role == 1 || auth()->user()->role == 5)
                            <a href="{{ route('invoices.export.pdf', $invoice) }}" class="btn btn-light btn-sm" target="_blank">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                            <a href="{{ route('invoices.export.word', $invoice) }}" class="btn btn-light btn-sm" target="_blank">
                                <i class="fas fa-file-word"></i> Word
                            </a>
                            <a href="{{ route('invoices.print', $invoice) }}" class="btn btn-light btn-sm" target="_blank">
                                <i class="fas fa-print"></i> Print
                            </a>
                        @endif
                        <a href="{{ route('invoices.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Invoice Header -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h4 class="text-primary">Niranjan Enterprises</h4>
                            <p class="mb-1">Help Desk Management System</p>
                            <p class="mb-1">Invoice Number: <strong>{{ $invoice->invoice_number }}</strong></p>
                            <p class="mb-1">Invoice Date: <strong>{{ $invoice->invoice_date->format('d-m-Y') }}</strong></p>
                            <p class="mb-1">Status: 
                                <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'overdue' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5 class="text-primary">Bill To:</h5>
                            <p class="mb-1"><strong>{{ $invoice->customer_name }}</strong></p>
                            <p class="mb-1">{{ $invoice->customer_email }}</p>
                            <p class="mb-1">{{ $invoice->customer_phone }}</p>
                            <p class="mb-1">{{ $invoice->customer_address }}</p>
                        </div>
                    </div>
                    
                    <!-- Project Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary">Project Information</h6>
                            <p class="mb-1"><strong>Project Name:</strong> {{ $invoice->project_name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Project Topic:</strong> {{ $invoice->project_topic ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Department:</strong> {{ $invoice->department_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Project Timeline</h6>
                            <p class="mb-1"><strong>Start Date:</strong> {{ $invoice->start_date ? $invoice->start_date->format('d-m-Y') : 'N/A' }}</p>
                            <p class="mb-1"><strong>End Date:</strong> {{ $invoice->end_date ? $invoice->end_date->format('d-m-Y') : 'N/A' }}</p>
                            <p class="mb-1"><strong>Duration:</strong> 
                                @if($invoice->start_date && $invoice->end_date)
                                    {{ $invoice->start_date->diffInDays($invoice->end_date) }} days
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <!-- Project Full Details -->
                    @if($invoice->project_full_details)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary">Project Full Details</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0">{{ nl2br($invoice->project_full_details) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Payment Details -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h6 class="text-primary">Payment Breakdown</h6>
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Description</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Advance Payment</td>
                                        <td class="text-end">₹{{ number_format($invoice->advance_payment, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Remaining Payment</td>
                                        <td class="text-end">₹{{ number_format($invoice->remaining_payment, 2) }}</td>
                                    </tr>
                                    @if($invoice->gst > 0)
                                    <tr>
                                        <td>GST (18%)</td>
                                        <td class="text-end">₹{{ number_format($invoice->gst, 2) }}</td>
                                    </tr>
                                    @endif
                                    <tr class="table-primary fw-bold">
                                        <td>Total Amount</td>
                                        <td class="text-end">₹{{ number_format($invoice->total_payment, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-primary">Payment Status</h6>
                            <div class="card bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'overdue' ? 'danger' : 'warning') }} text-white">
                                <div class="card-body text-center">
                                    <h4 class="mb-2">{{ ucfirst($invoice->status) }}</h4>
                                    <p class="mb-0">
                                        @if($invoice->status == 'paid')
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        @elseif($invoice->status == 'overdue')
                                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                                        @else
                                            <i class="fas fa-clock fa-2x"></i>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Installments Details -->
                    @if($invoice->installments && is_array($invoice->installments) && count($invoice->installments) > 0)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary">Installment Schedule</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Installment #</th>
                                            <th>Due Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Payment Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice->installments as $index => $installment)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $installment['due_date'] ?? 'N/A' }}</td>
                                            <td>₹{{ number_format($installment['amount'] ?? 0, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ ($installment['status'] ?? 'pending') == 'paid' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($installment['status'] ?? 'pending') }}
                                                </span>
                                            </td>
                                            <td>{{ $installment['payment_date'] ?? 'N/A' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Footer -->
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Note:</strong> This is a view-only invoice. To make changes, please contact the administrator.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
