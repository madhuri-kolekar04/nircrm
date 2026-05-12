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
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        OTP has been sent to <strong>{{ $employeeData['email'] }}</strong>. 
                        Please check your email and enter the OTP below.
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Employee Details</h6>
                                    <p><strong>Name:</strong> {{ $employeeData['name'] }}</p>
                                    <p><strong>Email:</strong> {{ $employeeData['email'] }}</p>
                                    <p><strong>Phone:</strong> {{ $employeeData['phone'] }}</p>
                                    <p><strong>Department:</strong> {{ is_string($employeeData['department']) ? $employeeData['department'] : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('employees.verify-otp') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="otp" class="form-label">Enter OTP *</label>
                                    <input type="text" class="form-control @error('otp') is-invalid @enderror" 
                                           id="otp" name="otp" maxlength="6" pattern="[0-9]{6}" 
                                           placeholder="Enter 6-digit OTP" required autocomplete="off">
                                    @error('otp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">OTP will expire in 10 minutes.</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <div>
                                <form action="{{ route('employees.resend-otp') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-redo"></i> Resend OTP
                                    </button>
                                </form>
                            </div>
                            <div>
                                <a href="{{ route('employees.create') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Verify & Create Account
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
