@extends('admin.admin_master')

@section('admin')
@section('page-title', 'Quotation: {{ $quotation->quotation_number }}')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-file-invoice text-success"></i>
                        Quotation: {{ $quotation->quotation_number }}
                    </h4>
                    <div>
                        <span class="badge bg-{{ $quotation->status_color }} fs-6">
                            {{ ucfirst($quotation->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Professional Quotation Template -->
                    <div class="quotation-template border rounded p-4 bg-white">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <h2 class="text-primary">PROPOSAL</h2>
                            <h4 class="text-secondary">Website Design and SEO Services</h4>
                            <hr>
                        </div>

                        <!-- Client Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="text-primary">Client Information</h5>
                                <p><strong>Business Name:</strong> {{ $quotation->client_business_name }}</p>
                                <p><strong>Email Address:</strong> {{ $quotation->client_email }}</p>
                                <p><strong>Phone Number:</strong> {{ $quotation->client_phone }}</p>
                                <p><strong>Contact Name:</strong> {{ $quotation->client_contact_name }}</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <h5 class="text-primary">Quotation Details</h5>
                                <p><strong>Quotation Number:</strong> {{ $quotation->quotation_number }}</p>
                                <p><strong>Date:</strong> {{ $quotation->created_at->format('d M Y') }}</p>
                                <p><strong>Valid Until:</strong> {{ $quotation->valid_until ? $quotation->valid_until->format('d M Y') : 'N/A' }}</p>
                                <p><strong>Status:</strong> <span class="badge bg-{{ $quotation->status_color }}">{{ ucfirst($quotation->status) }}</span></p>
                            </div>
                        </div>

                        <!-- Executive Summary -->
                        @if($quotation->executive_summary)
                        <div class="mb-4">
                            <h5 class="text-primary">Executive Summary</h5>
                            <p>{{ $quotation->executive_summary }}</p>
                        </div>
                        @endif

                        <!-- Services Overview -->
                        <div class="mb-4">
                            <h5 class="text-primary">Services Overview</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Service</th>
                                            <th>Description</th>
                                            <th>Timeline</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($quotation->services as $service)
                                        <tr>
                                            <td>
                                                <strong>{{ $service->name }}</strong>
                                                @if($service->pivot->quantity > 1)
                                                    <span class="badge bg-info ms-2">x{{ $service->pivot->quantity }}</span>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($service->description, 150) }}</td>
                                            <td>
                                                @if($service->timeline_weeks)
                                                    {{ $service->timeline_weeks }} weeks
                                                @else
                                                    Ongoing
                                                @endif
                                            </td>
                                            <td><strong>₹{{ number_format($service->pivot->price, 2) }}</strong></td>
                                            <td>{{ $service->pivot->quantity }}</td>
                                            <td><strong>₹{{ number_format($service->pivot->subtotal, 2) }}</strong></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Total Investment -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="text-primary">Total Investment</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Service</th>
                                            <th>Cost (excluding GST)</th>
                                        </tr>
                                        @foreach($quotation->services as $service)
                                        <tr>
                                            <td>{{ $service->name }}</td>
                                            <td>₹{{ number_format($service->pivot->subtotal, 2) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="table-info">
                                            <td><strong>Total Cost</strong></td>
                                            <td><strong>{{ $quotation->formatted_total_cost }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>GST (18%)</td>
                                            <td>₹{{ number_format($quotation->gst_amount, 2) }}</td>
                                        </tr>
                                        <tr class="table-success">
                                            <td><strong>Final Amount</strong></td>
                                            <td><strong>{{ $quotation->formatted_final_amount }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-primary">Timeline and Milestones</h5>
                                <div class="timeline-info">
                                    @foreach($quotation->services as $service)
                                    @if($service->timeline_weeks)
                                    <div class="mb-2">
                                        <strong>{{ $service->name }}:</strong> {{ $service->timeline_weeks }} weeks
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        @if($quotation->terms_conditions)
                        <div class="mb-4">
                            <h5 class="text-primary">Terms and Conditions</h5>
                            <div class="terms-conditions">
                                {{ nl2br($quotation->terms_conditions) }}
                            </div>
                        </div>
                        @endif

                        <!-- Agreement Section -->
                        <div class="mb-4">
                            <h5 class="text-primary">Agreement</h5>
                            <p>By signing below, you agree to the terms and conditions outlined in this proposal.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="border p-3 mb-3">
                                        <p><strong>Client Signature:</strong> _____________________</p>
                                        <p><strong>Date:</strong> _____________________</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-3 mb-3">
                                        <p><strong>Authorized Representative</strong></p>
                                        <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                                        <p><strong>Signature:</strong> _____________________</p>
                                        <p><strong>Date:</strong> _____________________</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="text-center mt-4">
                            <h5 class="text-primary">Contact Information</h5>
                            <p>
                                <strong>Email:</strong> {{ config('app.contact_email', 'udyami.brandwhiz24@gmail.com') }}<br>
                                <strong>Phone:</strong> {{ config('app.contact_phone', '+91-9220518202') }}
                            </p>
                            <p class="text-muted">
                                Thank you for the opportunity to present this proposal. We are excited about the possibility of working together.
                            </p>
                            <p class="text-muted">
                                <strong>Best regards,</strong><br>
                                {{ Auth::user()->name }}<br>
                                {{ config('app.contact_phone', '9220518202') }}<br>
                                {{ config('app.company_name', 'NIRCRM') }}
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        @if(auth()->user()->role == 3)
                            <!-- Customer: Simple Back Button -->
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                        @else
                            <!-- Admin: Back to Quotations -->
                            <a href="{{ route('quotations.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Back to Quotations
                            </a>
                        @endif
                        
                        <div>
                            @if(auth()->user()->role == 3)
                                <!-- Customer: Download PDF using customer route -->
                                <a href="{{ route('customer.quotations.pdf', $quotation->id) }}" class="btn btn-danger me-2">
                                    <i class="fas fa-file-pdf"></i>
                                    Download PDF
                                </a>
                            @else
                                <!-- Admin: Download PDF using admin route -->
                                <a href="{{ route('quotations.pdf', $quotation->id) }}" class="btn btn-danger me-2" target="_blank">
                                    <i class="fas fa-file-pdf"></i>
                                    Download PDF
                                </a>
                                @if(in_array($quotation->status, ['draft', 'sent']))
                                <form action="{{ route('quotations.send', $quotation->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Send this quotation to client?')">
                                        <i class="fas fa-envelope"></i>
                                        Send Email
                                    </button>
                                </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
