@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-x-ray"></i> X-ray DICOM Viewer
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Upload Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-upload"></i> Upload DICOM File
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form id="dicomUploadForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="dicom_file" class="form-label">
                                                        <strong>Select DICOM File (.dcm)</strong>
                                                    </label>
                                                    <input type="file" 
                                                           class="form-control" 
                                                           id="dicom_file" 
                                                           name="dicom_file" 
                                                           accept=".dcm,.dicom"
                                                           required>
                                                    <small class="form-text text-muted">
                                                        Supported formats: .dcm, .dicom (Max: 50MB)
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>&nbsp;</label><br>
                                                    <button type="submit" class="btn btn-primary btn-lg" id="uploadBtn">
                                                        <i class="fas fa-cloud-upload-alt"></i> Upload DICOM
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <!-- Progress Bar -->
                                    <div id="uploadProgress" class="mt-3" style="display: none;">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                                 role="progressbar" 
                                                 style="width: 0%">
                                                0%
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Alert Messages -->
                                    <div id="uploadAlert" class="mt-3" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- File List Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-folder-open"></i> Uploaded DICOM Files
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if(count($dicomFiles) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th width="5%">#</th>
                                                        <th>File Name</th>
                                                        <th>Size</th>
                                                        <th>Uploaded Date</th>
                                                        <th width="25%">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($dicomFiles as $index => $file)
                                                        <tr>
                                                            <td><strong>{{ $index + 1 }}</strong></td>
                                                            <td>
                                                                <i class="fas fa-file-medical text-primary"></i>
                                                                {{ $file['filename'] }}
                                                            </td>
                                                            <td>{{ number_format($file['size'] / 1024 / 1024, 2) }} MB</td>
                                                            <td>{{ $file['uploaded_at'] }}</td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="{{ route('xray.view', $file['filename']) }}" 
                                                                       class="btn btn-sm btn-primary"
                                                                       title="View DICOM">
                                                                        <i class="fas fa-eye"></i> View
                                                                    </a>
                                                                    <a href="{{ route('xray.download', $file['filename']) }}" 
                                                                       class="btn btn-sm btn-success"
                                                                       title="Download DICOM"
                                                                       download>
                                                                        <i class="fas fa-download"></i> Download
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No DICOM files uploaded yet</h5>
                                            <p class="text-muted">
                                                Upload your first DICOM file using the form above to get started.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for File Upload -->
<script>
$(document).ready(function() {
    $('#dicomUploadForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var uploadBtn = $('#uploadBtn');
        var progressBar = $('#uploadProgress');
        var alert = $('#uploadAlert');
        
        // Show progress bar
        progressBar.show();
        alert.hide();
        
        // Disable button
        uploadBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
        
        $.ajax({
            url: '{{ route("xray.upload") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        progressBar.find('.progress-bar').css('width', percentComplete + '%').text(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                if (response.success) {
                    alert.html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> ${response.message}
                            <br>
                            <a href="${response.view_url}" class="btn btn-sm btn-primary mt-2">
                                <i class="fas fa-eye"></i> View File
                            </a>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `).show();
                    
                    // Reset form
                    $('#dicomUploadForm')[0].reset();
                    
                    // Reload page after 2 seconds to show new file
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    alert.html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `).show();
                }
            },
            error: function(xhr) {
                alert.html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> 
                        Error uploading file: ${xhr.statusText}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `).show();
            },
            complete: function() {
                // Reset button and progress
                uploadBtn.prop('disabled', false).html('<i class="fas fa-cloud-upload-alt"></i> Upload DICOM');
                progressBar.hide();
            }
        });
    });
});
</script>
@endsection
