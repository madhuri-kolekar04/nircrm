@extends('admin.admin_master')

@section('page-title', 'Project Completion Status')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        Project Completion Status
                        @if(isset($project))
                            - {{ $project->product_name_en }}
                        @elseif(isset($invoice))
                            - {{ $invoice->project_name }}
                        @endif
                    </h5>
                    <a href="{{ route('project-updates.show', isset($project) ? $project->id : $invoice->id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
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
                    
                    <!-- Existing Completion Status Display -->
                    @if($completionStatus)
                        <div class="mb-4">
                            <h6 class="mb-3">Current Completion Status</h6>
                            <div class="progress mb-3" style="height: 30px;">
                                @foreach($completionStatus->formatted_status_items as $item)
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: {{ $item['percentage'] }}%; background-color: {{ $item['color'] }};"
                                         title="{{ $item['text'] }}: {{ $item['percentage'] }}%">
                                        {{ $item['percentage'] }}%
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="row">
                                @foreach($completionStatus->formatted_status_items as $item)
                                    <div class="col-md-6 col-lg-4 mb-2">
                                        <div class="card border-left" style="border-left-color: {{ $item['color'] }} !important; border-left-width: 4px !important;">
                                            <div class="card-body py-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">{{ $item['order'] }}.</small>
                                                    <span class="badge" style="background-color: {{ $item['color'] }};">{{ $item['percentage'] }}%</span>
                                                </div>
                                                <div class="mt-1">{{ $item['text'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-3">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCompletionStatusModal">
                                    <i class="fas fa-edit"></i> Edit Completion Status
                                </button>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Create Completion Status Button -->
                    @if(!$completionStatus)
                        <div class="text-center py-4">
                            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#createCompletionStatusModal">
                                <i class="fas fa-plus-circle"></i> Create Project Completion Status
                            </button>
                            <p class="text-muted mt-2">Define completion stages of your project with percentage breakdown</p>
                        </div>
                    @else
                        <!-- Interactive Progress Bar Only -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <p class="text-muted">Click on the progress bar sections to mark them as completed (green) or incomplete (gray).</p>
                                </div>
                                
                                <!-- Interactive Progress Bar -->
                                <div class="progress-container mb-4" style="position: relative;">
                                    <!-- Mouse Position Indicator -->
                                    <div class="mouse-indicator" id="mouseIndicator" style="display: none; position: absolute; top: -30px; transform: translateX(-50%); z-index: 1000;">
                                        <div class="mouse-percentage-badge">
                                            <span id="mousePercentage">0%</span>
                                        </div>
                                        <div class="mouse-indicator-line"></div>
                                    </div>
                                    
                                    <div class="progress" style="height: 40px; cursor: pointer;" id="interactiveProgressBar">
                                        @foreach($completionStatus->formatted_status_items as $index => $item)
                                            @php
                                                $progressData = json_decode($completionStatus->progress_data ?? '[]', true) ?? [];
                                                $isCompleted = false;
                                                $isPartial = false;
                                                $completionPercentage = 0;
                                                
                                                if (is_array($progressData) && isset($progressData[$index])) {
                                                    $isCompleted = isset($progressData[$index]['completed']) && ($progressData[$index]['completed'] === 'true' || $progressData[$index]['completed'] === true || $progressData[$index]['completed'] === 1);
                                                    $isPartial = isset($progressData[$index]['partial']) && ($progressData[$index]['partial'] === 'true' || $progressData[$index]['partial'] === true || $progressData[$index]['partial'] === 1);
                                                    $completionPercentage = $progressData[$index]['completion_percentage'] ?? 0;
                                                }
                                            @endphp
                                            <div class="progress-segment" 
                                                 data-index="{{ $index }}" 
                                                 data-completed="{{ $isCompleted ? 'true' : ($isPartial ? 'partial' : 'false') }}"
                                                 @if($isCompleted)
                                                     style="width: {{ $item['percentage'] }}%; background-color: #28a745; border-right: 1px solid #fff;"
                                                     title="{{ $item['text'] }}: {{ $item['percentage'] }}%">
                                                     <span class="segment-text" style="color: #ffffff;">{{ $item['text'] }}</span>
                                                 @elseif($isPartial)
                                                     style="width: {{ $item['percentage'] }}%; background: linear-gradient(to right, #28a745 0%, #28a745 {{ $completionPercentage }}%, #e9ecef {{ $completionPercentage }}%, #e9ecef 100%); border-right: 1px solid #fff;"
                                                     title="{{ $item['text'] }}: {{ $item['percentage'] }}%">
                                                     <span class="segment-text" style="color: {{ $completionPercentage > 50 ? '#ffffff' : '#6c757d' }};">{{ $item['text'] }}</span>
                                                 @else
                                                     style="width: {{ $item['percentage'] }}%; background-color: #e9ecef; border-right: 1px solid #fff;"
                                                     title="{{ $item['text'] }}: {{ $item['percentage'] }}%">
                                                     <span class="segment-text" style="color: #6c757d;">{{ $item['text'] }}</span>
                                                 @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Progress Info -->
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <small class="text-muted">Completed: <span id="completedCount" class="fw-bold text-success">
                                                @php
                                                    $completedSegments = 0;
                                                    $progressData = json_decode($completionStatus->progress_data ?? '[]', true) ?? [];
                                                    if (is_array($progressData)) {
                                                        foreach($progressData as $data) {
                                                            if (isset($data['completed']) && ($data['completed'] === 'true' || $data['completed'] === true || $data['completed'] === 1)) {
                                                                $completedSegments++;
                                                            }
                                                        }
                                                    }
                                                    echo $completedSegments;
                                                @endphp
                                            </span> / {{ count($completionStatus->formatted_status_items) }}</small>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <small class="text-muted">Mouse Position: <span id="mousePositionText" class="fw-bold text-primary">-</span></small>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <small class="text-muted">Progress: <span id="progressText" class="fw-bold">{{ $completionStatus->exact_percentage ?? 0 }}%</span></small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <button type="button" class="btn btn-success" id="saveProgressBtn">
                                        <i class="fas fa-check"></i> Okay
                                    </button>
                                    <button type="button" class="btn btn-secondary ms-2" id="resetProgressBtn">
                                        <i class="fas fa-undo"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Completion Status Modal -->
@if(!$completionStatus)
<div class="modal fade" id="createCompletionStatusModal" tabindex="-1" aria-labelledby="createCompletionStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCompletionStatusModalLabel">Create Project Completion Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('project-updates.completion-status.store', isset($project) ? $project->id : $invoice->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Project Completion Stages</label>
                        <p class="text-muted small">Add stages that represent your project completion. Each stage will automatically calculate its percentage.</p>
                        
                        <div id="statusItemsContainer">
                            <div class="status-item-row mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <input type="text" name="status_items[]" class="form-control" placeholder="Enter completion stage..." required>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2 percentage-display">25%</span>
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-item" style="display: none;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="status-item-row mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <input type="text" name="status_items[]" class="form-control" placeholder="Enter completion stage..." required>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2 percentage-display">25%</span>
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-item" style="display: none;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="status-item-row mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <input type="text" name="status_items[]" class="form-control" placeholder="Enter completion stage..." required>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2 percentage-display">25%</span>
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-item" style="display: none;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="status-item-row mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <input type="text" name="status_items[]" class="form-control" placeholder="Enter completion stage..." required>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2 percentage-display">25%</span>
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" id="addStatusItem" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-plus"></i> Add More Stages
                        </button>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Note:</strong> Percentages are automatically calculated and distributed equally among all stages. Total will always be 100%.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Completion Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Edit Completion Status Modal -->
@if($completionStatus)
<div class="modal fade" id="editCompletionStatusModal" tabindex="-1" aria-labelledby="editCompletionStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCompletionStatusModalLabel">Edit Project Completion Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('project-updates.completion-status.update', $completionStatus->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Project Completion Stages</label>
                        <p class="text-muted small">Edit stages that represent your project completion. Each stage will automatically calculate its percentage.</p>
                        
                        <div id="editStatusItemsContainer">
                            @foreach($completionStatus->status_items as $index => $item)
                                <div class="status-item-row mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <input type="text" name="status_items[]" class="form-control" value="{{ $item }}" placeholder="Enter completion stage..." required>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary me-2 percentage-display">{{ $completionStatus->formatted_status_items[$index]['percentage'] }}%</span>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-item" @if(count($completionStatus->status_items) <= 1) style="display: none;" @endif>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <button type="button" id="addEditStatusItem" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-plus"></i> Add More Stages
                        </button>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Note:</strong> Percentages are automatically calculated and distributed equally among all stages. Total will always be 100%.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Completion Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<style>
.border-left {
    border-left: 4px solid !important;
}

.progress-bar {
    font-size: 12px;
    line-height: 30px;
    text-align: center;
    color: white;
}

.status-item-row {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.percentage-display {
    min-width: 50px;
    text-align: center;
}

.progress-container {
    position: relative;
}

.progress-segment {
    position: relative;
    display: inline-block;
    height: 40px;
    line-height: 40px;
    text-align: center;
    color: #6c757d;
    font-weight: 500;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    border-right: 1px solid #fff;
}

.progress-segment:hover {
    opacity: 0.8;
    transform: translateY(-2px);
}

.segment-text {
    position: relative;
    z-index: 2;
    text-shadow: none;
    font-weight: 600;
    font-size: 12px;
}

.progress-segment[data-completed="true"] {
    background-color: #28a745 !important;
    color: #ffffff !important;
}

.progress-segment[data-completed="true"]:hover {
    background-color: #218838 !important;
}

/* Mouse Position Indicator Styles */
.mouse-indicator {
    pointer-events: none;
    transition: opacity 0.2s ease;
}

.mouse-percentage-badge {
    background-color: #007bff;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    white-space: nowrap;
}

.mouse-indicator-line {
    width: 2px;
    height: 20px;
    background-color: #007bff;
    margin: 0 auto;
    position: relative;
}

.mouse-indicator-line::before {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 4px solid #007bff;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to update percentages
    function updatePercentages(container) {
        const items = container.querySelectorAll('.status-item-row');
        const count = items.length;
        const percentage = count > 0 ? Math.round(100 / count) : 0;
        
        items.forEach(item => {
            const badge = item.querySelector('.percentage-display');
            if (badge) {
                badge.textContent = percentage + '%';
            }
        });
        
        // Show/hide remove buttons
        items.forEach(item => {
            const removeBtn = item.querySelector('.remove-item');
            if (removeBtn) {
                removeBtn.style.display = count > 1 ? 'inline-block' : 'none';
            }
        });
    }
    
    // Add new status item
    document.getElementById('addStatusItem')?.addEventListener('click', function() {
        const container = document.getElementById('statusItemsContainer');
        const newItem = document.createElement('div');
        newItem.className = 'status-item-row mb-3';
        newItem.innerHTML = `
            <div class="row align-items-center">
                <div class="col-md-8">
                    <input type="text" name="status_items[]" class="form-control" placeholder="Enter completion stage..." required>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary me-2 percentage-display">25%</span>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        updatePercentages(container);
        
        // Add remove event listener
        newItem.querySelector('.remove-item').addEventListener('click', function() {
            newItem.remove();
            updatePercentages(container);
        });
    });
    
    // Add new edit status item
    document.getElementById('addEditStatusItem')?.addEventListener('click', function() {
        const container = document.getElementById('editStatusItemsContainer');
        const newItem = document.createElement('div');
        newItem.className = 'status-item-row mb-3';
        newItem.innerHTML = `
            <div class="row align-items-center">
                <div class="col-md-8">
                    <input type="text" name="status_items[]" class="form-control" placeholder="Enter completion stage..." required>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary me-2 percentage-display">25%</span>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        updatePercentages(container);
        
        // Add remove event listener
        newItem.querySelector('.remove-item').addEventListener('click', function() {
            newItem.remove();
            updatePercentages(container);
        });
    });
    
    // Remove item handlers
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('.status-item-row');
            const container = row.parentElement;
            row.remove();
            updatePercentages(container);
        });
    });
    
    // Initialize percentages on page load
    const createContainer = document.getElementById('statusItemsContainer');
    const editContainer = document.getElementById('editStatusItemsContainer');
    
    if (createContainer) updatePercentages(createContainer);
    if (editContainer) updatePercentages(editContainer);
    
    // Interactive Progress Bar Functionality
    const progressBar = document.getElementById('interactiveProgressBar');
    const completionPercentage = document.getElementById('completionPercentage');
    const completedCount = document.getElementById('completedCount');
    const progressText = document.getElementById('progressText');
    const saveProgressBtn = document.getElementById('saveProgressBtn');
    const resetProgressBtn = document.getElementById('resetProgressBtn');
    
    if (progressBar) {
        const segments = progressBar.querySelectorAll('.progress-segment');
        const mouseIndicator = document.getElementById('mouseIndicator');
        const mousePercentage = document.getElementById('mousePercentage');
        const mousePositionText = document.getElementById('mousePositionText');
        let completedSegments = 0;
        
        // Add mouse move event to show position indicator
        progressBar.addEventListener('mousemove', function(event) {
            const rect = progressBar.getBoundingClientRect();
            const mouseX = event.clientX - rect.left;
            const progressBarWidth = rect.width;
            const mousePercentageValue = Math.round((mouseX / progressBarWidth) * 100);
            
            // Show and position the indicator
            mouseIndicator.style.display = 'block';
            mouseIndicator.style.left = mouseX + 'px';
            mousePercentage.textContent = mousePercentageValue + '%';
            mousePositionText.textContent = mousePercentageValue + '%';
        });
        
        // Hide indicator when mouse leaves
        progressBar.addEventListener('mouseleave', function() {
            mouseIndicator.style.display = 'none';
            mousePositionText.textContent = '-';
        });
        
        // Add click event to progress bar as continuous slider with auto-save
        progressBar.addEventListener('click', function(event) {
            const rect = progressBar.getBoundingClientRect();
            const clickX = event.clientX - rect.left;
            const progressBarWidth = rect.width;
            const clickPercentage = (clickX / progressBarWidth) * 100;
            
            // Fill exactly up to mouse position
            let newCompletedSegments = 0;
            let accumulatedWidth = 0;
            
            segments.forEach((segment, index) => {
                const segmentWidth = (parseFloat(segment.style.width) / 100) * progressBarWidth;
                const segmentStart = accumulatedWidth;
                const segmentEnd = accumulatedWidth + segmentWidth;
                
                if (segmentEnd <= clickX) {
                    // This segment is completed (green)
                    segment.style.background = 'linear-gradient(to right, #28a745 0%, #28a745 100%)';
                    segment.style.color = '#ffffff';
                    segment.dataset.completed = 'true';
                    newCompletedSegments++;
                } else if (segmentStart < clickX && clickX < segmentEnd) {
                    // Partial segment - fill up to click position
                    const fillPercentage = ((clickX - segmentStart) / segmentWidth) * 100;
                    segment.style.background = `linear-gradient(to right, #28a745 0%, #28a745 ${fillPercentage}%, #e9ecef ${fillPercentage}%, #e9ecef 100%)`;
                    segment.style.color = fillPercentage > 50 ? '#ffffff' : '#6c757d';
                    segment.dataset.completed = 'partial';
                } else {
                    // Segment is incomplete (gray)
                    segment.style.background = '#e9ecef';
                    segment.style.color = '#6c757d';
                    segment.dataset.completed = 'false';
                }
                
                accumulatedWidth += segmentWidth;
            });
            
            // Update display with actual percentage
            const displayPercentage = Math.round(clickPercentage);
            if (completionPercentage) {
                completionPercentage.textContent = displayPercentage + '%';
            }
            if (progressText) {
                progressText.textContent = displayPercentage + '%';
            }
            if (completedCount) {
                completedCount.textContent = newCompletedSegments + ' / ' + segments.length;
            }
            
            // Auto-save progress to database
            autoSaveProgress(displayPercentage);
        });
        
        // Auto-save progress function
        function autoSaveProgress(exactPercentage) {
            console.log('Auto-saving progress with percentage:', exactPercentage);
            
            // Create form data to submit
            const formData = new FormData();
            formData.append('exact_percentage', exactPercentage);
            formData.append('total_percentage', exactPercentage);
            
            // Submit via fetch API
            const fetchUrl = '{{ route("project-updates.progress.update", isset($project) ? $project->id : $invoice->id) }}';
            console.log('Auto-save URL:', fetchUrl);
            console.log('Form data:');
            formData.forEach((value, key) => {
                console.log(key + ':', value);
            });
            
            fetch(fetchUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: new URLSearchParams(formData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                return response.json();
            })
            .then(data => {
                console.log('Auto-save successful:', data);
                console.log('Data type:', typeof data);
                console.log('Data keys:', Object.keys(data));
                
                if (data.success) {
                    // Show success message briefly
                    const successMsg = document.createElement('div');
                    successMsg.textContent = 'Progress saved!';
                    successMsg.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #28a745; color: white; padding: 10px 20px; border-radius: 5px; z-index: 9999; font-weight: bold;';
                    document.body.appendChild(successMsg);
                    
                    // Remove message after 2 seconds
                    setTimeout(() => {
                        if (document.body.contains(successMsg)) {
                            document.body.removeChild(successMsg);
                        }
                    }, 2000);
                } else {
                    console.log('Save failed - data:', data);
                }
            })
            .catch(error => {
                console.error('Auto-save error:', error);
                console.error('Error details:', error.message);
                console.error('Error stack:', error.stack);
                
                // Show detailed error message
                const errorMsg = document.createElement('div');
                errorMsg.innerHTML = `
                    <div style="font-weight: bold;">Error saving progress!</div>
                    <div style="font-size: 12px; margin-top: 5px;">Check console for details</div>
                `;
                errorMsg.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #dc3545; color: white; padding: 10px 20px; border-radius: 5px; z-index: 9999; font-weight: bold; max-width: 300px;';
                document.body.appendChild(errorMsg);
                
                // Remove message after 5 seconds
                setTimeout(() => {
                    if (document.body.contains(errorMsg)) {
                        document.body.removeChild(errorMsg);
                    }
                }, 5000);
            });
        }
        
        // Update progress display
        function updateProgressDisplay() {
            const totalSegments = segments.length;
            const percentage = totalSegments > 0 ? Math.round((completedSegments / totalSegments) * 100) : 0;
            
            if (completionPercentage) {
                completionPercentage.textContent = percentage + '%';
            }
            if (completedCount) {
                completedCount.textContent = completedSegments + ' / ' + totalSegments;
            }
            if (progressText) {
                progressText.textContent = percentage + '%';
            }
        }
        
        // Save progress button
        if (saveProgressBtn) {
            saveProgressBtn.addEventListener('click', function() {
                alert('Okay button clicked! Processing...');
                
                // Calculate exact percentage from current visual state
                const progressBarRect = progressBar.getBoundingClientRect();
                let greenWidth = 0;
                
                segments.forEach((segment, index) => {
                    const segmentWidth = parseFloat(segment.style.width);
                    if (segment.dataset.completed === 'true') {
                        greenWidth += segmentWidth;
                    } else if (segment.dataset.completed === 'partial') {
                        // For partial segments, estimate based on current visual state
                        const currentBg = segment.style.background;
                        if (currentBg.includes('linear-gradient')) {
                            // Extract fill percentage from gradient
                            const match = currentBg.match(/#28a745\s+(\d+)%/);
                            if (match) {
                                const fillPercent = parseInt(match[1]);
                                greenWidth += (segmentWidth * fillPercent / 100);
                            }
                        }
                    }
                });
                
                const exactPercentage = Math.round(greenWidth);
                
                console.log('Saving progress with exact percentage:', exactPercentage);
                console.log('Green width calculated:', greenWidth);
                console.log('Form action:', form.action);
                
                // Create form data to submit
                const formData = new FormData();
                formData.append('exact_percentage', exactPercentage);
                formData.append('total_percentage', exactPercentage);
                
                // Submit via fetch or form submission
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/project-updates/{{ isset($project) ? $project->id : $invoice->id }}/update-progress';
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                console.log('CSRF Token:', csrfToken ? 'Found' : 'Not found');
                console.log('Form action:', form.action);
                console.log('Exact percentage:', exactPercentage);
                
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);
                } else {
                    console.error('CSRF token not found');
                    alert('Security token not found. Please refresh the page.');
                    return;
                }
                
                formData.forEach((value, key) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                
                console.log('Form created and appended to body');
                console.log('Form data being submitted:');
                formData.forEach((value, key) => {
                    console.log(key + ':', value);
                });
                
                // Add error handling
                try {
                    console.log('Submitting form...');
                    form.submit();
                } catch (error) {
                    console.error('Form submission error:', error);
                    alert('Error submitting form: ' + error.message);
                }
            });
        }
        
        // Reset progress button
        if (resetProgressBtn) {
            resetProgressBtn.addEventListener('click', function() {
                segments.forEach(segment => {
                    segment.dataset.completed = 'false';
                    segment.style.backgroundColor = '#e9ecef';
                    segment.style.color = '#6c757d';
                });
                completedSegments = 0;
                updateProgressDisplay();
            });
        }
        
        // Initialize display
        updateProgressDisplay();
    }
});
</script>
@endsection
