@extends('admin.admin_master')

@section('page-title', 'Upload Leads - Excel')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Upload Leads via Excel</h5>
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

                    <!-- Download Template Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Important Instructions</h6>
                                <ul class="mb-0">
                                    <li>Download the Excel template below to see the required field format</li>
                                    <li>Fill in your lead data following the template structure</li>
                                    <li>Required fields are marked with * in the template</li>
                                    <li>Supported formats: .xlsx, .xls, .csv (Max file size: 10MB)</li>
                                    <li>Lead Status options: hot, cold, warm, qualified, lost</li>
                                    <li>Source options: website, referral, social_media, email, phone, advertisement, other</li>
                                    <li>Priority options: low, medium, high</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Download Template -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-excel fa-3x text-success mb-3"></i>
                                    <h5 class="card-title">Download Excel Template</h5>
                                    <p class="card-text">Get the pre-formatted Excel template with all required fields</p>
                                    <a href="{{ route('leads.template') }}" class="btn btn-success">
                                        <i class="fas fa-download"></i> Download Template
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-upload fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">Upload Filled Excel</h5>
                                    <p class="card-text">Upload your completed Excel file with lead data</p>
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('excelFile').click()">
                                        <i class="fas fa-file-upload"></i> Choose File
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Form -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Upload Excel File</h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('leads.upload.excel') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <label for="excelFile" class="form-label">Select Excel File *</label>
                                                    <input type="file" class="form-control @error('excel_file') is-invalid @enderror" 
                                                           id="excelFile" name="excel_file" 
                                                           accept=".xlsx,.xls,.csv" required style="display: none;">
                                                    <div class="form-control" onclick="document.getElementById('excelFile').click()" style="cursor: pointer;">
                                                        <span id="fileName">Choose Excel file (.xlsx, .xls, .csv)</span>
                                                    </div>
                                                    @error('excel_file')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                    <small class="text-muted">Maximum file size: 10MB</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">&nbsp;</label><br>
                                                    <button type="submit" class="btn btn-primary w-100" id="uploadBtn" disabled>
                                                        <i class="fas fa-upload"></i> Upload Leads
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Excel Field Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Field Name</th>
                                                    <th>Required</th>
                                                    <th>Description</th>
                                                    <th>Valid Options</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Name</strong></td>
                                                    <td><span class="badge bg-danger">Yes</span></td>
                                                    <td>Full name of the lead contact</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Email</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>Email address of the lead</td>
                                                    <td>Valid email format</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Phone</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>Phone number of the lead</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Company Name</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>Name of the company</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Website</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>Company website URL</td>
                                                    <td>Valid URL format</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Address</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>Complete address</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>City</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>City name</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>State</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>State/Province name</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Country</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>Country name</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Pincode</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>Postal/ZIP code</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Industry</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>Industry type</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Lead Status</strong></td>
                                                    <td><span class="badge bg-danger">Yes</span></td>
                                                    <td>Current status of the lead</td>
                                                    <td>hot, cold, warm, qualified, lost</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Source</strong></td>
                                                    <td><span class="badge bg-danger">Yes</span></td>
                                                    <td>How the lead was generated</td>
                                                    <td>website, referral, social_media, email, phone, advertisement, other</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Description</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>Additional details about the lead</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Budget</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>Estimated budget amount</td>
                                                    <td>Numeric value</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Follow Up Date</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>Date for next follow-up</td>
                                                    <td>YYYY-MM-DD format</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Notes</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>Additional notes</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Priority</strong></td>
                                                    <td><span class="badge bg-danger">Yes</span></td>
                                                    <td>Priority level of the lead</td>
                                                    <td>low, medium, high</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Department</strong></td>
                                                    <td><span class="badge bg-secondary">No</span></td>
                                                    <td>Department to assign the lead</td>
                                                    <td>-</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('excelFile').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Choose Excel file (.xlsx, .xls, .csv)';
    document.getElementById('fileName').textContent = fileName;
    document.getElementById('uploadBtn').disabled = !e.target.files[0];
});
</script>
@endpush
