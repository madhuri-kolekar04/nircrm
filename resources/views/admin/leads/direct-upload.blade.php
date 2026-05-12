@extends('admin.admin_master')

@section('page-title', 'Direct Excel Upload - Leads')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-excel"></i> Direct Excel Upload with Preview
                    </h5>
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

                    <!-- Upload Section -->
                    <div id="uploadSection">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-excel fa-3x text-success mb-3"></i>
                                        <h5 class="card-title">Upload Excel File</h5>
                                        <p class="card-text">Upload your Excel file to preview and edit leads before importing</p>
                                        <input type="file" id="excelFile" class="form-control" accept=".xlsx,.xls,.csv">
                                        <button type="button" id="uploadBtn" class="btn btn-primary mt-3" disabled>
                                            <i class="fas fa-upload"></i> Process Excel
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-info">
                                    <div class="card-body">
                                        <h6 class="card-title"><i class="fas fa-info-circle"></i> Instructions</h6>
                                        <ul class="small mb-0">
                                            <li>Upload an Excel file with lead data</li>
                                            <li>Preview the data with editable dropdowns</li>
                                            <li>Modify values before importing</li>
                                            <li>Click "Import All Leads" to save</li>
                                            <li><a href="{{ route('leads.template') }}" target="_blank">Download Template</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loadingSection" class="text-center" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Processing...</span>
                        </div>
                        <p class="mt-2">Processing Excel file...</p>
                    </div>

                    <!-- Preview Section -->
                    <div id="previewSection" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6><i class="fas fa-eye"></i> Lead Preview (<span id="leadCount">0</span> leads)</h6>
                            <div>
                                <button type="button" id="backToUpload" class="btn btn-secondary btn-sm me-2">
                                    <i class="fas fa-arrow-left"></i> Back to Upload
                                </button>
                                <button type="button" id="importAllBtn" class="btn btn-success">
                                    <i class="fas fa-save"></i> Import All Leads
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Name *</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Company</th>
                                        <th>Website</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Pincode</th>
                                        <th>Industry</th>
                                        <th>Status *</th>
                                        <th>Source *</th>
                                        <th>Description</th>
                                        <th>Budget</th>
                                        <th>Follow Up Date</th>
                                        <th>Notes</th>
                                        <th>Priority *</th>
                                        <th>Department</th>
                                        <th>Work Status</th>
                                        <th>Work Type</th>
                                        <th>Current Service</th>
                                        <th>Date of Completion</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="leadsTableBody">
                                    <!-- Leads will be populated here -->
                                </tbody>
                            </table>
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
document.addEventListener('DOMContentLoaded', function() {
    let leadsData = [];
    
    // File input change handler
    document.getElementById('excelFile').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || '';
        document.getElementById('uploadBtn').disabled = !e.target.files[0];
    });
    
    // Upload button click handler
    document.getElementById('uploadBtn').addEventListener('click', function() {
        const fileInput = document.getElementById('excelFile');
        const file = fileInput.files[0];
        
        if (!file) {
            alert('Please select a file first');
            return;
        }
        
        // Show loading
        document.getElementById('uploadSection').style.display = 'none';
        document.getElementById('loadingSection').style.display = 'block';
        
        // Create FormData
        const formData = new FormData();
        formData.append('excel_file', file);
        
        // Send AJAX request
        fetch('{{ route("leads.process.excel") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                leadsData = data.leads;
                displayLeads(leadsData);
                
                // Show preview section
                document.getElementById('loadingSection').style.display = 'none';
                document.getElementById('previewSection').style.display = 'block';
            } else {
                alert('Error: ' + data.message);
                // Back to upload
                document.getElementById('loadingSection').style.display = 'none';
                document.getElementById('uploadSection').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error processing file');
            document.getElementById('loadingSection').style.display = 'none';
            document.getElementById('uploadSection').style.display = 'block';
        });
    });
    
    // Back to upload button
    document.getElementById('backToUpload').addEventListener('click', function() {
        document.getElementById('previewSection').style.display = 'none';
        document.getElementById('uploadSection').style.display = 'block';
        document.getElementById('excelFile').value = '';
        document.getElementById('uploadBtn').disabled = true;
    });
    
    // Import all button
    document.getElementById('importAllBtn').addEventListener('click', function() {
        if (confirm('Are you sure you want to import all ' + leadsData.length + ' leads?')) {
            importAllLeads();
        }
    });
    
    function displayLeads(leads) {
        const tbody = document.getElementById('leadsTableBody');
        tbody.innerHTML = '';
        
        document.getElementById('leadCount').textContent = leads.length;
        
        leads.forEach((lead, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.name || ''}" data-field="name" data-index="${index}">
                </td>
                <td>
                    <input type="email" class="form-control form-control-sm" value="${lead.email || ''}" data-field="email" data-index="${index}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.phone || ''}" data-field="phone" data-index="${index}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.company_name || ''}" data-field="company_name" data-index="${index}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.website || ''}" data-field="website" data-index="${index}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.address || ''}" data-field="address" data-index="${index}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.city || ''}" data-field="city" data-index="${index}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.state || ''}" data-field="state" data-index="${index}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.country || ''}" data-field="country" data-index="${index}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.pincode || ''}" data-field="pincode" data-index="${index}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.industry || ''}" data-field="industry" data-index="${index}">
                </td>
                <td>
                    <select class="form-select form-select-sm" data-field="lead_status" data-index="${index}">
                        @foreach($leadStatuses as $value => $label)
                            <option value="{{ $value }}" ${lead.lead_status === '{{ $value }}' ? 'selected' : ''}>{{ $label }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-select form-select-sm" data-field="source" data-index="${index}">
                        @foreach($sources as $value => $label)
                            <option value="{{ $value }}" ${lead.source === '{{ $value }}' ? 'selected' : ''}>{{ $label }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.description || ''}" data-field="description" data-index="${index}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm" value="${lead.budget || ''}" data-field="budget" data-index="${index}">
                </td>
                <td>
                    <input type="date" class="form-control form-control-sm" value="${lead.follow_up_date || ''}" data-field="follow_up_date" data-index="${index}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.notes || ''}" data-field="notes" data-index="${index}">
                </td>
                <td>
                    <select class="form-select form-select-sm" data-field="priority" data-index="${index}">
                        @foreach($priorities as $value => $label)
                            <option value="{{ $value }}" ${lead.priority === '{{ $value }}' ? 'selected' : ''}>{{ $label }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-select form-select-sm" data-field="department" data-index="${index}">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->department }}" ${lead.department === '{{ $department->department }}' ? 'selected' : ''}>{{ $department->department }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.work_status || ''}" data-field="work_status" data-index="${index}" placeholder="Work Status">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.work_type || ''}" data-field="work_type" data-index="${index}" placeholder="Work Type">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="${lead.current_service || ''}" data-field="current_service" data-index="${index}" placeholder="Current Service">
                </td>
                <td>
                    <input type="date" class="form-control form-control-sm" value="${lead.date_of_completion || ''}" data-field="date_of_completion" data-index="${index}">
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeLead(${index})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        // Add change event listeners to all inputs
        document.querySelectorAll('#leadsTableBody input, #leadsTableBody select').forEach(element => {
            element.addEventListener('change', function() {
                const index = parseInt(this.dataset.index);
                const field = this.dataset.field;
                leadsData[index][field] = this.value;
            });
        });
    }
    
    function removeLead(index) {
        if (confirm('Remove this lead from import?')) {
            leadsData.splice(index, 1);
            displayLeads(leadsData);
        }
    }
    
    function importAllLeads() {
        const importBtn = document.getElementById('importAllBtn');
        importBtn.disabled = true;
        importBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Importing...';
        
        fetch('{{ route("leads.save.direct.upload") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify({
                leads: leadsData
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = '{{ route("leads.index") }}';
            } else {
                alert('Error: ' + data.message);
                importBtn.disabled = false;
                importBtn.innerHTML = '<i class="fas fa-save"></i> Import All Leads';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error importing leads');
            importBtn.disabled = false;
            importBtn.innerHTML = '<i class="fas fa-save"></i> Import All Leads';
        });
    }
});
</script>
@endpush
