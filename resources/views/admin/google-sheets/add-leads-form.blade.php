<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Lead - Calling App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .form-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .form-subtitle {
            font-size: 1rem;
            opacity: 0.9;
        }

        .form-body {
            padding: 40px;
        }

        .form-section {
            margin-bottom: 40px;
            padding: 25px;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            background: #f8f9fa;
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 1.1rem;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .required-star {
            color: var(--danger-color);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .back-link {
            color: white;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .back-link:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('callingapp.index') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Back to Calling App
                </a>
            </div>
            <h1 class="form-title">
                <i class="fas fa-user-plus me-2"></i>Add New Lead
            </h1>
            <p class="form-subtitle">Enter lead details to add to Leads Management system</p>
        </div>

        <div class="form-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('callingapp.store-lead') }}" method="POST">
                @csrf

                <!-- Basic Information -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="fas fa-user me-2"></i>Basic Information
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">
                                    Full Name <span class="required-star">*</span>
                                </label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                       id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="business_name" class="form-label">Business Name</label>
                                <input type="text" class="form-control @error('business_name') is-invalid @enderror" 
                                       id="business_name" name="business_name" value="{{ old('business_name') }}">
                                @error('business_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="whatsapp" class="form-label">WhatsApp</label>
                                <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" 
                                       id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}">
                                @error('whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="website_url" class="form-label">Website URL</label>
                                <input type="url" class="form-control @error('website_url') is-invalid @enderror" 
                                       id="website_url" name="website_url" value="{{ old('website_url') }}">
                                @error('website_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="business_type" class="form-label">Business Type</label>
                                <input type="text" class="form-control @error('business_type') is-invalid @enderror" 
                                       id="business_type" name="business_type" value="{{ old('business_type') }}">
                                @error('business_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lead Details -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="fas fa-chart-line me-2"></i>Lead Details
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="primary_goal" class="form-label">Primary Goal</label>
                                <input type="text" class="form-control @error('primary_goal') is-invalid @enderror" 
                                       id="primary_goal" name="primary_goal" value="{{ old('primary_goal') }}">
                                @error('primary_goal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="budget_range" class="form-label">Budget Range</label>
                                <input type="text" class="form-control @error('budget_range') is-invalid @enderror" 
                                       id="budget_range" name="budget_range" value="{{ old('budget_range') }}" 
                                       placeholder="e.g., 5000-10000">
                                @error('budget_range')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="score" class="form-label">Score</label>
                                <input type="text" class="form-control @error('score') is-invalid @enderror" 
                                       id="score" name="score" value="{{ old('score') }}">
                                @error('score')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tier" class="form-label">Tier</label>
                                <select class="form-select @error('tier') is-invalid @enderror" 
                                        id="tier" name="tier">
                                    <option value="">Select Tier</option>
                                    <option value="hot" {{ old('tier') == 'hot' ? 'selected' : '' }}>Hot</option>
                                    <option value="warm" {{ old('tier') == 'warm' ? 'selected' : '' }}>Warm</option>
                                    <option value="cold" {{ old('tier') == 'cold' ? 'selected' : '' }}>Cold</option>
                                    <option value="qualified" {{ old('tier') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                                    <option value="lost" {{ old('tier') == 'lost' ? 'selected' : '' }}>Lost</option>
                                </select>
                                @error('tier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="submitted_at" class="form-label">Submitted At</label>
                                <input type="date" class="form-control @error('submitted_at') is-invalid @enderror" 
                                       id="submitted_at" name="submitted_at" value="{{ old('submitted_at') }}">
                                @error('submitted_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="fas fa-file-alt me-2"></i>Additional Information
                    </h5>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="audit_report" class="form-label">Audit Report</label>
                                <textarea class="form-control @error('audit_report') is-invalid @enderror" 
                                          id="audit_report" name="audit_report" rows="4">{{ old('audit_report') }}</textarea>
                                @error('audit_report')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="audit_report_plain" class="form-label">Audit Report Plain</label>
                                <textarea class="form-control @error('audit_report_plain') is-invalid @enderror" 
                                          id="audit_report_plain" name="audit_report_plain" rows="4">{{ old('audit_report_plain') }}</textarea>
                                @error('audit_report_plain')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('callingapp.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Lead
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
