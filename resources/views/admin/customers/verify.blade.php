@extends('admin.admin_master')

@section('page-title', 'Verify OTP')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Verify OTP</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Customer Details</h6>
                                    <p><strong>Name:</strong> {{ $customerData['name'] }}</p>
                                    <p><strong>Email:</strong> {{ $customerData['email'] }}</p>
                                    <p><strong>Phone:</strong> {{ $customerData['phone'] }}</p>
                                    <p><strong>Company:</strong> {{ $customerData['company_name'] ?? 'N/A' }}</p>
                                    <p><strong>PAN Number:</strong> {{ $customerData['pan_number'] }}</p>
                                    <p><strong>Aadhar Number:</strong> {{ $customerData['aadhar_number'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('customers.verify-otp') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="otp" class="form-label">Enter OTP *</label>
                                    <input type="text" class="form-control @error('otp') is-invalid @enderror" 
                                           id="otp" name="otp" maxlength="6" required placeholder="Enter 6-digit OTP">
                                    @error('otp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">OTP has been sent to {{ $customerData['email'] }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Verify and Create Account
                                </button>
                                <a href="{{ route('customers.resend-otp') }}" class="btn btn-secondary" onclick="event.preventDefault(); document.getElementById('resendForm').submit();">
                                    <i class="fas fa-redo"></i> Resend OTP
                                </a>
                                <a href="{{ route('customers.create') }}" class="btn btn-danger">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Hidden form for resending OTP -->
                    <form id="resendForm" action="{{ route('customers.resend-otp') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
