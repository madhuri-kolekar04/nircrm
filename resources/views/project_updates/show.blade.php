@extends('admin.admin_master')

@section('page-title', 'Project Details - ' . $project->product_name_en)

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Project Details</h5>
                    <a href="{{ route('project-updates.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Projects
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <!-- Project Details Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Project Information</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Project Name:</strong> {{ $project->product_name_en }}</p>
                                            <p><strong>Project Topic:</strong> {{ $project->long_descp_en ?? 'N/A' }}</p>
                                            <p><strong>Project Details:</strong> {{ $project->short_descp_en ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($project->created_at)->format('d-m-Y') }}</p>
                                            <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($project->updated_at)->format('d-m-Y') }}</p>
                                            <p><strong>Department:</strong> {{ $project->category->category_name_en ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Today's Update Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0">Today's Update</h6>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUpdateModal">
                                        <i class="fas fa-plus"></i> Add Update
                                    </button>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">Click "Add Update" to add today's project updates. Updates will be sent via email to the customer and admin.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Previous Updates Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Previous Updates</h6>
                                </div>
                                <div class="card-body">
                                    @php
                                        // Ensure $updates is always a collection
                                        if (!isset($updates)) {
                                            $updates = collect([]);
                                        }
                                    @endphp
                                    @forelse($updates as $update)
                                        <div class="update-item mb-4 p-3 border rounded">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <strong>Updated by:</strong> {{ $update->user->name }}
                                                    <span class="text-muted">(
                                                        @if(isset($update->user->department) && is_object($update->user->department))
                                                            {{ $update->user->department->name ?? 'N/A' }}
                                                        @elseif(isset($update->user->department) && is_string($update->user->department))
                                                            @php
                                                                $deptData = json_decode($update->user->department);
                                                                if ($deptData && isset($deptData->name)) {
                                                                    echo $deptData->name;
                                                                } elseif ($deptData && isset($deptData->department)) {
                                                                    echo $deptData->department;
                                                                } else {
                                                                    echo $update->user->department;
                                                                }
                                                            @endphp
                                                        @else
                                                            {{ $update->user->department ?? 'N/A' }}
                                                        @endif
                                                    )</span>
                                                </div>
                                                <div>
                                                    <small class="text-muted">
                                                        {{ $update->update_date->format('M d, Y H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="update-points">
                                                @php
                                                    // Check if update_point_3 contains JSON (multiple points)
                                                    $updatePoint3 = $update->update_point_3;
                                                    $isJson = false;
                                                    $allPoints = [];
                                                    
                                                    if (!empty($updatePoint3)) {
                                                        // Try to decode as JSON
                                                        $decoded = json_decode($updatePoint3, true);
                                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                                            $isJson = true;
                                                            $allPoints = $decoded;
                                                        }
                                                    }
                                                    
                                                    if ($isJson) {
                                                        // Display all points from JSON
                                                        foreach ($allPoints as $index => $point) {
                                                            if (!empty(trim($point))) {
                                                                echo '<div class="mb-2"><strong>' . ($index + 1) . '.</strong> ' . e($point) . '</div>';
                                                            }
                                                        }
                                                    } else {
                                                        // Display individual points (backward compatibility)
                                                        if (!empty($update->update_point_1)) {
                                                            echo '<div class="mb-2"><strong>1.</strong> ' . e($update->update_point_1) . '</div>';
                                                        }
                                                        if (!empty($update->update_point_2)) {
                                                            echo '<div class="mb-2"><strong>2.</strong> ' . e($update->update_point_2) . '</div>';
                                                        }
                                                        if (!empty($update->update_point_3)) {
                                                            echo '<div class="mb-2"><strong>3.</strong> ' . e($update->update_point_3) . '</div>';
                                                        }
                                                    }
                                                @endphp
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted py-4">
                                            <i class="fas fa-history fa-3x mb-3 d-block"></i>
                                            No updates yet. Be the first to add an update!
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Update Modal -->
<div class="modal fade" id="addUpdateModal" tabindex="-1" aria-labelledby="addUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUpdateModalLabel">Add Today's Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('project-updates.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $project->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="update_point_1" class="form-label">Update Point 1 *</label>
                        <textarea class="form-control @error('update_point_1') is-invalid @enderror" 
                                  id="update_point_1" name="update_point_1" rows="3" required>{{ old('update_point_1') }}</textarea>
                        @error('update_point_1')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="update_point_2" class="form-label">Update Point 2</label>
                        <textarea class="form-control @error('update_point_2') is-invalid @enderror" 
                                  id="update_point_2" name="update_point_2" rows="3">{{ old('update_point_2') }}</textarea>
                        @error('update_point_2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="update_point_3" class="form-label">Update Point 3</label>
                        <textarea class="form-control @error('update_point_3') is-invalid @enderror" 
                                  id="update_point_3" name="update_point_3" rows="3">{{ old('update_point_3') }}</textarea>
                        @error('update_point_3')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Submit Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
