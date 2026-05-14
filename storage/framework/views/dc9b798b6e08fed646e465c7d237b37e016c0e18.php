<?php $__env->startSection('page-title', 'Leads Generation'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<style>
.btn .fas {
    display: inline-block !important;
    font-style: normal !important;
    font-variant: normal !important;
    text-rendering: auto !important;
    line-height: 1 !important;
    font-family: "Font Awesome 6 Free" !important;
    font-weight: 900 !important;
}

.btn .fa-edit:before {
    content: "\f044" !important;
}

/* Pulsing animation for due date badge */
@keyframes pulse-badge {
    0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
    }
    50% {
        transform: scale(1.1);
        box-shadow: 0 0 0 5px rgba(220, 53, 69, 0);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
    }
}

.due-date-badge-pulse {
    animation: pulse-badge 2s infinite;
}

.btn .fa-trash:before {
    content: "\f2ed" !important;
}

.btn .fa-envelope:before {
    content: "\f0e0" !important;
}

.btn .fa-face-smile:before {
    content: "\f118" !important;
}

/* Empty fields count badge styling */
.empty-fields-badge {
    background-color: #dc3545 !important;
    color: white !important;
    font-size: 0.6rem !important;
    padding: 2px 5px !important;
    border-radius: 10px !important;
    font-weight: 600 !important;
    min-width: 18px !important;
    text-align: center !important;
    line-height: 1 !important;
    box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3) !important;
}

/* Hover effect for edit button with empty fields */
.btn-success:hover .empty-fields-badge {
    background-color: #c82333 !important;
    transform: scale(1.1) !important;
    transition: all 0.2s ease !important;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Leads Management</h5>
                        <div class="d-flex align-items-center gap-3">
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#reactionModal" title="Reaction Management">
                                <i class="fas fa-face-smile"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#leadsSettingsModal" title="Leads Settings">
                                <i class="fas fa-cog"></i>
                            </button>
                            <a href="<?php echo e(route('duedate.index')); ?>" class="btn btn-outline-warning position-relative" 
                                   <?php if($todayDueDateCount > 0): ?> 
                                       title="<?php echo e($todayDueDateCount); ?> lead(s) due today - Click to manage due dates" 
                                       data-bs-toggle="tooltip" 
                                   <?php else: ?> 
                                       title="Due Date Management" 
                                   <?php endif; ?>>
                                <i class="fas fa-calendar-alt"></i>
                                <?php if($todayDueDateCount > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger due-date-badge-pulse">
                                        <?php echo e($todayDueDateCount); ?>

                                        <span class="visually-hidden">today's due dates</span>
                                    </span>
                                <?php endif; ?>
                            </a>
                            <form method="GET" action="<?php echo e(route('leads.index')); ?>" class="d-flex align-items-center">
                                <div class="input-group" style="width: 300px;">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Search by Name, Email, Phone, Company..." 
                                           value="<?php echo e(request('search')); ?>"
                                           id="searchInput">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <?php if(request('search')): ?>
                                    <a href="<?php echo e(request()->fullUrlWithQuery(['search' => null])); ?>" 
                                       class="btn btn-outline-secondary ms-2" 
                                       title="Clear Search">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Add Buttons and Filters -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Extra Columns Toggle -->
                        <div class="d-flex align-items-center gap-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="extraColumnsToggle" onchange="toggleExtraColumns()">
                                <label class="form-check-label" for="extraColumnsToggle">
                                    <strong>Extra Columns</strong>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLeadModal">
                                <i class="fas fa-plus"></i> Add Lead
                            </button>
                            <a href="<?php echo e(route('leads.direct.upload')); ?>" class="btn btn-warning">
                                <i class="fas fa-magic"></i> Upload Excel
                            </a>
                            <a href="<?php echo e(route('leads.template')); ?>" class="btn btn-info">
                                <i class="fas fa-download"></i> Download Template
                            </a>
                        </div>
                        
                        <!-- Active Filters Display -->
                        <?php if(request('filter_type') || request('priority') || request('source')): ?>
                            <div class="d-flex align-items-center gap-2">
                                <?php if(request('filter_type') == 'status' && request('filter_value')): ?>
                                    <span class="badge bg-primary" style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;">
                                        <?php echo e(App\Models\Lead::getLeadStatuses()[request('filter_value')] ?? request('filter_value')); ?>

                                    </span>
                                <?php endif; ?>
                                <?php if(request('priority')): ?>
                                    <span class="badge bg-warning" style="background: linear-gradient(135deg, #fd7e14 0%, #e8590c 100%) !important;">
                                        <?php echo e(App\Models\Lead::getPriorities()[request('priority')] ?? request('priority')); ?>

                                    </span>
                                <?php endif; ?>
                                <?php if(request('source')): ?>
                                    <span class="badge bg-success" style="background: linear-gradient(135deg, #198754 0%, #157347 100%) !important;">
                                        <?php echo e(App\Models\Lead::getSources()[request('source')] ?? request('source')); ?>

                                    </span>
                                <?php endif; ?>
                                <?php if(request('work_status')): ?>
                                    <span class="badge bg-purple" style="background: linear-gradient(135deg, #6f42c1 0%, #5a2d91 100%) !important;">
                                        Work Status: <?php echo e(request('work_status')); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Filter Dropdowns Only -->
                        <div class="d-flex align-items-center gap-2">
                            <!-- Status Filter Dropdown -->
                            <form method="GET" action="<?php echo e(route('leads.index')); ?>" style="display: inline;">
                                <select name="filter_value" class="form-select form-select-sm filter-dropdown" onchange="this.form.submit()" style="min-width: 120px; background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); color: white; border: none; font-weight: 600; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    <option value="">All Statuses</option>
                                    <?php $__currentLoopData = App\Models\Lead::getLeadStatuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>" 
                                                <?php echo e(request('filter_value') == $value && request('filter_type') == 'status' ? 'selected' : ''); ?>

                                                style="background-color: <?php echo e(App\Models\Lead::getStatusColorForValue($value)); ?>20; color: <?php echo e(App\Models\Lead::getStatusColorForValue($value)); ?>;">
                                            <?php echo e($label); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <input type="hidden" name="filter_type" value="status">
                                <?php if(request('search')): ?>
                                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                                <?php endif; ?>
                                <?php if(request('priority')): ?>
                                    <input type="hidden" name="priority" value="<?php echo e(request('priority')); ?>">
                                <?php endif; ?>
                                <?php if(request('source')): ?>
                                    <input type="hidden" name="source" value="<?php echo e(request('source')); ?>">
                                <?php endif; ?>
                            </form>
                            
                            <!-- Priority Filter Dropdown -->
                            <form method="GET" action="<?php echo e(route('leads.index')); ?>" style="display: inline;">
                                <select name="priority" class="form-select form-select-sm filter-dropdown" onchange="this.form.submit()" style="min-width: 100px; background: linear-gradient(135deg, #fd7e14 0%, #e8590c 100%); color: white; border: none; font-weight: 600; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    <option value="">All Priorities</option>
                                    <?php $__currentLoopData = App\Models\Lead::getPriorities(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>" 
                                                <?php echo e(request('priority') == $value ? 'selected' : ''); ?>

                                                style="background-color: <?php echo e(App\Models\Lead::getPriorityColorForValue($value)); ?>20; color: <?php echo e(App\Models\Lead::getPriorityColorForValue($value)); ?>;">
                                            <?php echo e($label); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if(request('search')): ?>
                                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                                <?php endif; ?>
                                <?php if(request('filter_type') && request('filter_value')): ?>
                                    <input type="hidden" name="filter_type" value="<?php echo e(request('filter_type')); ?>">
                                    <input type="hidden" name="filter_value" value="<?php echo e(request('filter_value')); ?>">
                                <?php endif; ?>
                                <?php if(request('source')): ?>
                                    <input type="hidden" name="source" value="<?php echo e(request('source')); ?>">
                                <?php endif; ?>
                            </form>
                            
                            <!-- Source Filter Dropdown -->
                            <form method="GET" action="<?php echo e(route('leads.index')); ?>" style="display: inline;">
                                <select name="source" class="form-select form-select-sm filter-dropdown" onchange="this.form.submit()" style="min-width: 120px; background: linear-gradient(135deg, #198754 0%, #157347 100%); color: white; border: none; font-weight: 600; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    <option value="">All Sources</option>
                                    <?php $__currentLoopData = App\Models\Lead::getSources(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>" 
                                                <?php echo e(request('source') == $value ? 'selected' : ''); ?>>
                                            <?php echo e($label); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if(request('search')): ?>
                                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                                <?php endif; ?>
                                <?php if(request('filter_type') && request('filter_value')): ?>
                                    <input type="hidden" name="filter_type" value="<?php echo e(request('filter_type')); ?>">
                                    <input type="hidden" name="filter_value" value="<?php echo e(request('filter_value')); ?>">
                                <?php endif; ?>
                                <?php if(request('priority')): ?>
                                    <input type="hidden" name="priority" value="<?php echo e(request('priority')); ?>">
                                <?php endif; ?>
                            </form>
                            
                            <!-- Work Status Filter Dropdown -->
                            <form method="GET" action="<?php echo e(route('leads.index')); ?>" style="display: inline;">
                                <select name="work_status" class="form-select form-select-sm filter-dropdown" onchange="this.form.submit()" style="min-width: 120px; background: linear-gradient(135deg, #6f42c1 0%, #5a2d91 100%); color: white; border: none; font-weight: 600; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    <option value="">All Work Status</option>
                                    <option value="Active" <?php echo e(request('work_status') == 'Active' ? 'selected' : ''); ?>>Active</option>
                                    <option value="NO" <?php echo e(request('work_status') == 'NO' ? 'selected' : ''); ?>>NO</option>
                                </select>
                                <?php if(request('search')): ?>
                                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                                <?php endif; ?>
                                <?php if(request('filter_type') && request('filter_value')): ?>
                                    <input type="hidden" name="filter_type" value="<?php echo e(request('filter_type')); ?>">
                                    <input type="hidden" name="filter_value" value="<?php echo e(request('filter_value')); ?>">
                                <?php endif; ?>
                                <?php if(request('priority')): ?>
                                    <input type="hidden" name="priority" value="<?php echo e(request('priority')); ?>">
                                <?php endif; ?>
                                <?php if(request('source')): ?>
                                    <input type="hidden" name="source" value="<?php echo e(request('source')); ?>">
                                <?php endif; ?>
                            </form>
                            
                            <!-- Clear Filters Button -->
                            <a href="<?php echo e(route('leads.index')); ?>" class="btn btn-outline-danger btn-sm" style="border-radius: 0.5rem; font-weight: 600; transition: all 0.3s ease;">
                                <i class="fas fa-times-circle"></i> Clear
                            </a>
                        </div>
                    </div>

                    <!-- Leads Table -->
                    <div class="table-responsive">
                        <table id="leadsTable" class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Source</th>
                                    <th>Description</th>
                                    <th>Assigned To</th>
                                    <th class="extra-column" style="display: none;">Work Status</th>
                                    <th class="extra-column" style="display: none;">Work Type</th>
                                    <th class="extra-column" style="display: none;">Current Service</th>
                                    <th class="extra-column" style="display: none;">Date of Completion</th>
                                    <th class="extra-column" style="display: none;">Due Date</th>
                                    <th>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Actions</span>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-warning me-1" onclick="testBulkEmail()" title="Test Bulk Email" style="display: none;">
                                                    <i class="fas fa-bug"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-primary" onclick="openBulkEmailModal()" title="Send Bulk Email">
                                                    <i class="fas fa-envelope"></i> Bulk Email
                                                </button>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e(($leads->currentPage() - 1) * $leads->perPage() + $index + 1); ?></td>
                                        <td><?php echo e($lead->name); ?></td>
                                        <td><?php echo e($lead->email ?? '-'); ?></td>
                                        <td><?php echo e($lead->phone ?? '-'); ?></td>
                                        <td><?php echo e($lead->company_name ?? '-'); ?></td>
                                        <td>
                                            <select class="form-select form-select-sm status-select" 
                                                    data-lead-id="<?php echo e($lead->id); ?>" 
                                                    data-field="lead_status"
                                                    style="min-width: 100px; background-color: <?php echo e(App\Models\Lead::getStatusColorForValue($lead->lead_status)); ?>20; color: <?php echo e(App\Models\Lead::getStatusColorForValue($lead->lead_status)); ?>; font-weight: 600;">
                                                <?php $__currentLoopData = App\Models\Lead::getLeadStatuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($value); ?>" 
                                                            <?php echo e($lead->lead_status == $value ? 'selected' : ''); ?>

                                                            style="background-color: <?php echo e(App\Models\Lead::getStatusColorForValue($value)); ?>20; color: <?php echo e(App\Models\Lead::getStatusColorForValue($value)); ?>;">
                                                        <?php echo e($label); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm priority-select" 
                                                    data-lead-id="<?php echo e($lead->id); ?>" 
                                                    data-field="priority"
                                                    style="min-width: 80px; background-color: <?php echo e(App\Models\Lead::getPriorityColorForValue($lead->priority)); ?>20; color: <?php echo e(App\Models\Lead::getPriorityColorForValue($lead->priority)); ?>; font-weight: 600;">
                                                <?php $__currentLoopData = App\Models\Lead::getPriorities(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($value); ?>" 
                                                            <?php echo e($lead->priority == $value ? 'selected' : ''); ?>

                                                            style="background-color: <?php echo e(App\Models\Lead::getPriorityColorForValue($value)); ?>20; color: <?php echo e(App\Models\Lead::getPriorityColorForValue($value)); ?>;">
                                                        <?php echo e($label); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm source-select" 
                                                    data-lead-id="<?php echo e($lead->id); ?>" 
                                                    data-field="source"
                                                    style="min-width: 120px;">
                                                <?php $__currentLoopData = App\Models\Lead::getSources(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($value); ?>" 
                                                            <?php echo e($lead->source == $value ? 'selected' : ''); ?>>
                                                        <?php echo e($label); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(!array_key_exists($lead->source, App\Models\Lead::getSources())): ?>
                                                    <option value="<?php echo e($lead->source); ?>" selected>
                                                        <?php echo e($lead->source); ?>

                                                    </option>
                                                <?php endif; ?>
                                            </select>
                                            <?php if($lead->source === 'google_sheets'): ?>
                                                <span class="badge bg-success ms-1" style="font-size: 0.7rem;">Google Sheets</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo e($lead->description ?? $lead->notes ?? 'N/A'); ?>">
                                                <?php echo e(\Illuminate\Support\Str::limit($lead->description ?? $lead->notes ?? 'N/A', 50)); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <div style="width: 28px; height: 28px; border-radius: 50%; background: #00a884; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 600;">
                                                    <?php echo e($lead->assigned_to && $lead->assignedUser ? strtoupper(substr($lead->assignedUser->name, 0, 1)) : 'U'); ?>

                                                </div>
                                                <span><?php echo e($lead->assignedUser->name ?? 'Unassigned'); ?></span>
                                            </div>
                                        </td>
                                        <td class="extra-column" style="display: none;">
                                            <span class="badge <?php echo e($lead->work_status == 'Active' ? 'bg-success' : ($lead->work_status == 'NO' ? 'bg-danger' : 'bg-secondary')); ?>">
                                                <?php echo e($lead->work_status ?? 'N/A'); ?>

                                            </span>
                                        </td>
                                        <td class="extra-column" style="display: none;">
                                            <?php echo e($lead->work_type ?? '-'); ?>

                                        </td>
                                        <td class="extra-column" style="display: none;">
                                            <?php echo e($lead->current_service ?? '-'); ?>

                                        </td>
                                        <td class="extra-column" style="display: none;">
                                            <?php echo e($lead->date_of_completion ? $lead->date_of_completion->format('Y-m-d') : '-'); ?>

                                        </td>
                                        <td class="extra-column" style="display: none;">
                                            <?php echo e($lead->due_date ? $lead->due_date->format('Y-m-d') : '-'); ?>

                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 8px;">
                                                <button type="button" class="btn btn-sm btn-info" onclick="viewLead(<?php echo e($lead->id); ?>)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-secondary" onclick="createQuotation(<?php echo e($lead->id); ?>)" title="Create Quotation">
                                                    <i class="fas fa-file-invoice"></i>
                                                </button>
                                                                                                <button type="button" class="btn btn-sm btn-warning" onclick="manageLead(<?php echo e($lead->id); ?>)" title="Reaction">
                                                    <i class="fas fa-face-smile"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-success position-relative" onclick="editLead(<?php echo e($lead->id); ?>)" title="Edit Lead (<?php echo e($lead->empty_fields_count); ?> empty fields)">
                                                    <i class="fas fa-edit"></i>
                                                    <?php if($lead->empty_fields_count > 0): ?>
                                                        <span class="position-absolute top-0 start-100 translate-middle empty-fields-badge">
                                                            <?php echo e($lead->empty_fields_count); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteLead(<?php echo e($lead->id); ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="15" class="text-center py-4">
                                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                            <div class="text-muted">No leads found</div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        <?php echo e($leads->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Lead Modal -->
<div class="modal fade" id="addLeadModal" tabindex="-1" aria-labelledby="addLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLeadModalLabel">Choose Add Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                                <h5 class="card-title">Add Lead</h5>
                                <p class="card-text">Add a single lead manually by filling out the form with all fields</p>
                                <a href="<?php echo e(route('leads.create.new')); ?>" class="btn btn-primary">Add Lead</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <i class="fas fa-file-excel fa-3x text-success mb-3"></i>
                                <h5 class="card-title">Upload Excel</h5>
                                <p class="card-text">Upload multiple leads at once using an Excel file</p>
                                <a href="<?php echo e(route('leads.direct.upload')); ?>" class="btn btn-success">Upload Excel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">
                    <i class="fas fa-envelope"></i> <span id="emailModalTitle">Send Email</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeEmailModal()"></button>
            </div>
            <form id="emailForm" method="POST" action="<?php echo e(route('leads.send.email')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="emailTo" class="form-label fw-semibold">
                            <i class="fas fa-user"></i> To:
                        </label>
                        <textarea class="form-control" id="emailTo" name="email_to" rows="3" required placeholder="Enter email addresses (comma separated)"></textarea>
                        <small class="text-muted">Email will be sent to these addresses. For bulk email, addresses will be separated automatically.</small>
                        <div id="emailCount" class="mt-2 text-info"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="emailSubject" class="form-label fw-semibold">
                            <i class="fas fa-heading"></i> Subject:
                        </label>
                        <input type="text" class="form-control" id="emailSubject" name="subject" placeholder="Enter email subject" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="emailMessage" class="form-label fw-semibold">
                            <i class="fas fa-align-left"></i> Message:
                        </label>
                        <textarea class="form-control" id="emailMessage" name="message" rows="8" placeholder="Enter your full message here..." required></textarea>
                    </div>
                    
                    <div class="mb-3" id="leadNameSection">
                        <label for="leadName" class="form-label fw-semibold">
                            <i class="fas fa-user-tag"></i> Lead Name:
                        </label>
                        <input type="text" class="form-control" id="leadName" name="lead_name" readonly>
                        <small class="text-muted">For personalization in email (single email mode)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeEmailModal()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="sendEmailBtn">
                        <i class="fas fa-paper-plane"></i> Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Leads Settings Modal -->
<div class="modal fade" id="leadsSettingsModal" tabindex="-1" aria-labelledby="leadsSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leadsSettingsModalLabel">
                    <i class="fas fa-cog"></i> Leads Settings
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-filter"></i> Display Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="itemsPerPage" class="form-label">Items Per Page</label>
                                    <select class="form-select" id="itemsPerPage">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="showInactive" checked>
                                        <label class="form-check-label" for="showInactive">
                                            Show inactive leads
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="enableAutoRefresh">
                                        <label class="form-check-label" for="enableAutoRefresh">
                                            Enable auto refresh (5 minutes)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-bell"></i> Notification Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                        <label class="form-check-label" for="emailNotifications">
                                            Email notifications for new leads
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="statusChangeNotifications" checked>
                                        <label class="form-check-label" for="statusChangeNotifications">
                                            Status change notifications
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="assignmentNotifications">
                                        <label class="form-check-label" for="assignmentNotifications">
                                            Assignment notifications
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-palette"></i> Appearance Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="tableStyle" class="form-label">Table Style</label>
                                            <select class="form-select" id="tableStyle">
                                                <option value="striped">Striped</option>
                                                <option value="bordered">Bordered</option>
                                                <option value="hover">Hover</option>
                                                <option value="condensed">Condensed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="colorScheme" class="form-label">Color Scheme</label>
                                            <select class="form-select" id="colorScheme">
                                                <option value="default">Default</option>
                                                <option value="dark">Dark</option>
                                                <option value="blue">Blue</option>
                                                <option value="green">Green</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="compactMode">
                                                <label class="form-check-label" for="compactMode">
                                                    Compact mode
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-tags"></i> Status Management</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="newStatus" class="form-label">Add New Status</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="newStatus" placeholder="Enter status name">
                                        <button type="button" class="btn btn-primary" onclick="addNewStatus()">
                                            <i class="fas fa-plus"></i> Add
                                        </button>
                                    </div>
                                </div>
                                <div class="status-list" id="statusList">
                                    <h6 class="text-muted mb-2">Existing Statuses:</h6>
                                    <div id="statusItems">
                                        <!-- Status items will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Priority Management</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="newPriority" class="form-label">Add New Priority</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="newPriority" placeholder="Enter priority name">
                                        <button type="button" class="btn btn-primary" onclick="addNewPriority()">
                                            <i class="fas fa-plus"></i> Add
                                        </button>
                                    </div>
                                </div>
                                <div class="priority-list" id="priorityList">
                                    <h6 class="text-muted mb-2">Existing Priorities:</h6>
                                    <div id="priorityItems">
                                        <!-- Priority items will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="saveLeadsSettings()">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.status-select, .priority-select {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    font-weight: 500;
}

.status-select:focus, .priority-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.status-select option, .priority-select option {
    font-weight: 500;
    padding: 8px 12px;
}

.status-select option:checked, .priority-select option:checked {
    font-weight: 600;
}

/* Search Bar Styling */
#searchInput {
    border-radius: 0.5rem 0 0 0.5rem;
    border-right: none;
    transition: all 0.3s ease;
}

#searchInput:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

#searchInput + .btn {
    border-radius: 0 0.5rem 0.5rem 0;
    transition: all 0.3s ease;
}

#searchInput + .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
}

/* Search Highlighting */
mark {
    background-color: #fff3cd;
    color: #856404;
    padding: 2px 4px;
    border-radius: 3px;
    font-weight: 600;
}

/* Status Filter Dropdown Styling */
.filter-dropdown {
    transition: all 0.3s ease;
    border-radius: 0.5rem !important;
}

.filter-dropdown:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15) !important;
}

.filter-dropdown:focus {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(102, 126, 234, 0.4) !important;
    outline: none !important;
}

.filter-dropdown option {
    background: white !important;
    color: #333 !important;
    font-weight: 500 !important;
    padding: 10px !important;
}

.filter-dropdown option:hover {
    background: #f8f9fa !important;
}

/* Clear Filters Button Styling */
.btn-outline-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(220, 53, 69, 0.3) !important;
}

/* Filter label styling */
.form-label.text-primary {
    color: #0d6efd !important;
    font-size: 0.9rem;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.form-label.text-warning {
    color: #fd7e14 !important;
    font-size: 0.9rem;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.form-label.text-success {
    color: #198754 !important;
    font-size: 0.9rem;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

/* Search input group styling */
.input-group {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 0.5rem;
    overflow: hidden;
}

.input-group:focus-within {
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
}

/* Settings Button Styling */
.btn-outline-secondary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
}

/* Color Schemes */
.color-scheme-dark {
    background-color: #1a1a1a !important;
    color: #ffffff !important;
}

.color-scheme-dark .card {
    background-color: #2d2d2d !important;
    border-color: #404040 !important;
}

.color-scheme-dark .card-header {
    background-color: #404040 !important;
    border-color: #555 !important;
    color: #ffffff !important;
}

.color-scheme-blue {
    background-color: #e3f2fd !important;
}

.color-scheme-blue .card {
    background-color: #bbdefb !important;
    border-color: #90caf9 !important;
}

.color-scheme-blue .card-header {
    background-color: #90caf9 !important;
    border-color: #64b5f6 !important;
}

.color-scheme-green {
    background-color: #e8f5e8 !important;
}

.color-scheme-green .card {
    background-color: #c8e6c9 !important;
    border-color: #a5d6a7 !important;
}

.color-scheme-green .card-header {
    background-color: #a5d6a7 !important;
    border-color: #81c784 !important;
}

/* Compact Mode */
.compact-mode .card-body {
    padding: 1rem !important;
}

.compact-mode .table {
    font-size: 0.875rem;
}

.compact-mode .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.compact-mode .modal-body {
    padding: 1rem;
}

.compact-mode .form-control,
.compact-mode .form-select {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

/* Status and Priority Management Styles */
.status-item, .priority-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 12px;
    margin-bottom: 5px;
    background-color: #f8f9fa;
    border-radius: 6px;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
}

.status-item:hover, .priority-item:hover {
    background-color: #e9ecef;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.status-item.protected {
    background-color: #fff3cd;
    border-color: #ffeaa7;
}

.status-item .status-name, .priority-item .priority-name {
    font-weight: 500;
    color: #495057;
}

.status-item.protected .status-name {
    color: #856404;
    font-weight: 600;
}

.status-actions, .priority-actions {
    display: flex;
    gap: 5px;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    border-radius: 0.25rem;
}

.edit-input {
    padding: 4px 8px;
    border: 1px solid #007bff;
    border-radius: 4px;
    font-size: 0.875rem;
    width: 150px;
}

.status-list, .priority-list {
    max-height: 200px;
    overflow-y: auto;
}

.status-list::-webkit-scrollbar, .priority-list::-webkit-scrollbar {
    width: 6px;
}

.status-list::-webkit-scrollbar-track, .priority-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.status-list::-webkit-scrollbar-thumb, .priority-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.status-list::-webkit-scrollbar-thumb:hover, .priority-list::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Test modal availability
    console.log('DOM loaded, checking modal...');
    console.log('Email modal element:', $('#emailModal').length > 0 ? 'Found' : 'Not found');
    console.log('Bootstrap available:', typeof bootstrap !== 'undefined' ? 'Yes' : 'No');
    console.log('jQuery available:', typeof $ !== 'undefined' ? 'Yes' : 'No');
    
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Search functionality with debouncing
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    
    if (searchInput) {
        // Real-time search with debouncing (wait 500ms after typing stops)
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            const searchTerm = e.target.value.trim();
            
            searchTimeout = setTimeout(function() {
                if (searchTerm.length >= 2 || searchTerm.length === 0) {
                    performSearch(searchTerm);
                }
            }, 500);
        });
        
        // Handle Enter key for immediate search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimeout);
                performSearch(e.target.value.trim());
            }
        });
        
        // Handle Escape key to clear search
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                e.preventDefault();
                clearSearch();
            }
        });
    }
    
    function performSearch(searchTerm) {
        const currentUrl = new URL(window.location);
        
        if (searchTerm) {
            currentUrl.searchParams.set('search', searchTerm);
        } else {
            currentUrl.searchParams.delete('search');
        }
        
        // Preserve other filter parameters
        const preserveParams = ['filter_type', 'filter_value', 'priority', 'source'];
        preserveParams.forEach(param => {
            if (currentUrl.searchParams.has(param) && currentUrl.searchParams.get(param)) {
                // Keep existing parameters
            }
        });
        
        window.location.href = currentUrl.toString();
    }
    
    function clearSearch() {
        const currentUrl = new URL(window.location);
        currentUrl.searchParams.delete('search');
        window.location.href = currentUrl.toString();
    }
    
    // Highlight search results
    function highlightSearchResults(searchTerm) {
        if (!searchTerm) return;
        
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        const tableCells = document.querySelectorAll('#leadsTable tbody td:nth-child(2), #leadsTable tbody td:nth-child(3), #leadsTable tbody td:nth-child(4), #leadsTable tbody td:nth-child(5)');
        
        tableCells.forEach(cell => {
            const originalText = cell.textContent;
            if (originalText.toLowerCase().includes(searchTerm.toLowerCase())) {
                cell.innerHTML = originalText.replace(regex, '<mark>$1</mark>');
            }
        });
    }
    
    // Highlight results on page load
    const urlParams = new URLSearchParams(window.location.search);
    const searchParam = urlParams.get('search');
    if (searchParam) {
        setTimeout(() => highlightSearchResults(searchParam), 100);
    }
    
    // Test modal availability
    window.testEmailModal = function() {
        console.log('Test button clicked');
        openEmailModal('test@example.com', 'Test User');
    };
    
    // Test the modal directly
    window.testEmailModal = function() {
        console.log('Test button clicked');
        openEmailModal('test@example.com', 'Test User');
    };
    
    // Handle email button clicks using event delegation
    $(document).on('click', '.email-btn', function(e) {
        e.preventDefault();
        var email = $(this).data('email');
        var name = $(this).data('name');
        console.log('Email button clicked:', email, name);
        openEmailModal(email, name);
    });
    
    // Make sure global functions are available
    window.viewLead = function(leadId) {
        console.log('View lead clicked:', leadId);
        window.open('<?php echo e(route("leads.show", ":id")); ?>'.replace(':id', leadId), '_blank');
    };
    
    window.editLead = function(leadId) {
        console.log('Edit lead clicked:', leadId);
        window.open('<?php echo e(route("leads.edit.new", ":id")); ?>'.replace(':id', leadId), '_blank');
    };
    
    window.deleteLead = function(leadId) {
        console.log('Delete lead clicked:', leadId);
        if (confirm('Are you sure you want to delete this lead?')) {
            $.ajax({
                url: '/leadsmanagement/' + leadId,
                method: 'DELETE',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('Lead deleted successfully!', 'success');
                        // Reload the page after a short delay
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        showNotification(response.message || 'Error deleting lead', 'error');
                    }
                },
                error: function() {
                    showNotification('Error deleting lead', 'error');
                }
            });
        }
    };
    
    window.manageLead = function(leadId) {
        console.log('Reaction button clicked:', leadId);
        // Open the reaction page for this specific lead
        window.open('/leadsmanagement/' + leadId + '/reaction', '_blank');
    };
    
    window.createQuotation = function(leadId) {
        console.log('Create quotation clicked:', leadId);
        // Redirect to quotation creation page with lead data
        window.location.href = '/quotations/create?lead_id=' + leadId;
    };
    
    // Test function for debugging
    window.testBulkEmail = function() {
        console.log('Test bulk email function called');
        alert('Test function is working! Trying to open bulk email modal...');
        openBulkEmailModal();
    };
    
    // Ensure bulk email function is globally accessible
    window.openBulkEmailModal = function() {
        console.log('openBulkEmailModal function called');
        
        // Collect all email addresses from table
        var emails = [];
        $('#leadsTable tbody tr').each(function() {
            var email = $(this).find('td:nth-child(3)').text().trim();
            if (email && email !== '-' && email !== '') {
                emails.push(email);
            }
        });
        
        console.log('Found emails:', emails);
        
        if (emails.length === 0) {
            showNotification('No email addresses found in current table', 'warning');
            return;
        }
        
        // Bulk email mode
        $('#emailModalTitle').text('Send Bulk Email (' + emails.length + ' recipients)');
        $('#emailTo').val(emails.join(', '));
        $('#leadName').val('');
        $('#leadNameSection').hide();
        $('#emailCount').text('Total recipients: ' + emails.length);
        
        // Make email field editable for bulk email
        $('#emailTo').prop('readonly', false);
        
        showEmailModal();
    };
    
    // Handle status change
    document.querySelectorAll('.status-select').forEach(function(select) {
        select.addEventListener('change', function() {
            updateLeadField(this.dataset.leadId, 'lead_status', this.value, this);
        });
    });

    // Handle priority change
    document.querySelectorAll('.priority-select').forEach(function(select) {
        select.addEventListener('change', function() {
            updateLeadField(this.dataset.leadId, 'priority', this.value, this);
        });
    });

    // Handle source change
    document.querySelectorAll('.source-select').forEach(function(select) {
        select.addEventListener('change', function() {
            updateLeadField(this.dataset.leadId, 'source', this.value, this);
        });
    });

    function updateLeadField(leadId, field, value, element) {
        console.log('Updating lead field:', leadId, field, value);
        $.ajax({
            url: '/leadsmanagement/' + leadId + '/update-field',
            method: 'PATCH',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                field: field,
                value: value
            },
            success: function(response) {
                console.log('Update response:', response);
                if (response.success) {
                    showNotification('Lead updated successfully!', 'success');
                    
                    // Update the dropdown color based on new value
                    if (field === 'lead_status') {
                        var newColor = getStatusColor(value);
                        $(element).css('background-color', newColor + '20');
                        $(element).css('color', newColor);
                    } else if (field === 'priority') {
                        var newColor = getPriorityColor(value);
                        $(element).css('background-color', newColor + '20');
                        $(element).css('color', newColor);
                    }
                } else {
                    showNotification(response.message || 'Error updating lead', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('Update error:', xhr, status, error);
                showNotification('Error updating lead: ' + (xhr.responseJSON?.message || error), 'error');
            }
        });
    }

    function getStatusColor(value) {
        var colors = {
            'hot': '#dc3545',
            'cold': '#0dcaf0',
            'warm': '#ffc107',
            'qualified': '#198754',
            'lost': '#6c757d'
        };
        return colors[value] || '#6c757d';
    }

    function getPriorityColor(value) {
        var colors = {
            'high': '#dc3545',
            'medium': '#ffc107',
            'low': '#0dcaf0'
        };
        return colors[value] || '#6c757d';
    }

    function showNotification(message, type) {
        var notification = $('<div>')
            .addClass('alert alert-' + type + ' alert-dismissible fade show position-fixed')
            .css({
                'top': '20px',
                'right': '20px',
                'z-index': '9999',
                'min-width': '300px'
            })
            .html(message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>');
        
        $('body').append(notification);
        
        setTimeout(function() {
            if (notification.parent().length) {
                notification.remove();
            }
        }, 3000);
    }

    // Email Modal Functions
    function openEmailModal(email, name) {
        console.log('Opening email modal for:', email, name);
        
        // Single email mode
        $('#emailModalTitle').text('Send Email');
        $('#emailTo').val(email);
        $('#leadName').val(name);
        $('#leadNameSection').show();
        $('#emailCount').text('');
        
        // Make email field readonly for single email
        $('#emailTo').prop('readonly', true);
        
        showEmailModal();
    }
    
    function showEmailModal() {
        console.log('showEmailModal function called');
        // Reset form fields except email field
        $('#emailSubject').val('');
        $('#emailMessage').val('');
        
        try {
            // Method 1: Bootstrap 5
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                console.log('Using Bootstrap 5 method');
                var modal = new bootstrap.Modal(document.getElementById('emailModal'));
                modal.show();
                return;
            }
            
            // Method 2: jQuery + Bootstrap 4
            if (typeof $ !== 'undefined' && $('#emailModal').modal) {
                console.log('Using jQuery Bootstrap method');
                $('#emailModal').modal('show');
                return;
            }
            
            // Method 3: Manual show
            console.log('Using manual show method');
            $('#emailModal').removeClass('fade').addClass('show').css('display', 'block');
            $('body').addClass('modal-open');
            
        } catch (error) {
            console.error('Error opening email modal:', error);
            alert('Error opening email modal: ' + error.message);
        }
    }
    
    function closeEmailModal() {
        console.log('Closing email modal');
        try {
            // Method 1: Bootstrap 5
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var modal = bootstrap.Modal.getInstance(document.getElementById('emailModal'));
                if (modal) {
                    modal.hide();
                }
                return;
            }
            
            // Method 2: jQuery + Bootstrap 4
            if (typeof $ !== 'undefined' && $('#emailModal').modal) {
                $('#emailModal').modal('hide');
                return;
            }
            
            // Method 3: Manual hide
            $('#emailModal').removeClass('show').addClass('fade').css('display', 'none');
            $('body').removeClass('modal-open');
            
        } catch (error) {
            console.error('Error closing email modal:', error);
        }
    }

    // Handle email form submission
    $('#emailForm').on('submit', function(e) {
        e.preventDefault();
        
        var submitBtn = $('#sendEmailBtn');
        var originalText = submitBtn.html();
        
        // Show loading state
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Sending...').prop('disabled', true);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showNotification('Email sent successfully!', 'success');
                    // Use Bootstrap 5 modal API to hide
                    var modal = bootstrap.Modal.getInstance(document.getElementById('emailModal'));
                    if (modal) {
                        modal.hide();
                    }
                    // Reset form
                    $('#emailForm')[0].reset();
                } else {
                    showNotification(response.message || 'Error sending email', 'error');
                }
            },
            error: function(xhr) {
                var errorMessage = 'Error sending email';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showNotification(errorMessage, 'error');
            },
            complete: function() {
                // Restore button state
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Status and Priority Management Functions
    window.loadStatusesAndPriorities = function() {
        // Common headers for fetch requests
        const headers = {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };

        // Load statuses from API
        fetch('<?php echo e(route("staprio.statuses")); ?>', {
            method: 'GET',
            headers: headers
        })
            .then(response => response.json())
            .then(statuses => {
                renderStatuses(statuses);
            })
            .catch(error => {
                console.error('Error loading statuses:', error);
                showNotification('Error loading statuses', 'error');
            });

        // Load priorities from API
        fetch('<?php echo e(route("staprio.priorities")); ?>', {
            method: 'GET',
            headers: headers
        })
            .then(response => response.json())
            .then(priorities => {
                renderPriorities(priorities);
            })
            .catch(error => {
                console.error('Error loading priorities:', error);
                showNotification('Error loading priorities', 'error');
            });
    };

    window.renderStatuses = function(statuses) {
        const statusItems = document.getElementById('statusItems');
        if (!statusItems) {
            console.warn('statusItems element not found');
            return;
        }
        statusItems.innerHTML = '';
        
        statuses.forEach((status) => {
            const statusItem = document.createElement('div');
            statusItem.className = `status-item ${status.is_protected ? 'protected' : ''}`;
            statusItem.innerHTML = `
                <span class="status-name">${status.name}</span>
                <div class="status-actions">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="editStatus(${status.id})" ${status.is_protected ? 'disabled' : ''}>
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteStatus(${status.id})" ${status.is_protected ? 'disabled' : ''}>
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            statusItems.appendChild(statusItem);
        });
    };

    window.renderPriorities = function(priorities) {
        const priorityItems = document.getElementById('priorityItems');
        if (!priorityItems) {
            console.warn('priorityItems element not found');
            return;
        }
        priorityItems.innerHTML = '';
        
        priorities.forEach((priority) => {
            const priorityItem = document.createElement('div');
            priorityItem.className = 'priority-item';
            priorityItem.innerHTML = `
                <span class="priority-name">${priority.name}</span>
                <div class="priority-actions">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="editPriority(${priority.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletePriority(${priority.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            priorityItems.appendChild(priorityItem);
        });
    };

    window.addNewStatus = function() {
        const input = document.getElementById('newStatus');
        const statusName = input.value.trim();
        
        if (!statusName) {
            showNotification('Please enter a status name', 'error');
            return;
        }
        
        fetch('<?php echo e(route("staprio.store")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                name: statusName,
                type: 'status'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                input.value = '';
                loadStatusesAndPriorities();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error adding status:', error);
            showNotification('Error adding status', 'error');
        });
    };

    window.addNewPriority = function() {
        const input = document.getElementById('newPriority');
        const priorityName = input.value.trim();
        
        if (!priorityName) {
            showNotification('Please enter a priority name', 'error');
            return;
        }
        
        fetch('<?php echo e(route("staprio.store")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                name: priorityName,
                type: 'priority'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                input.value = '';
                loadStatusesAndPriorities();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error adding priority:', error);
            showNotification('Error adding priority', 'error');
        });
    };

    window.editStatus = function(id) {
        const headers = {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };

        fetch('<?php echo e(route("staprio.statuses")); ?>', {
            method: 'GET',
            headers: headers
        })
            .then(response => response.json())
            .then(statuses => {
                const status = statuses.find(s => s.id === id);
                if (status && status.is_protected) {
                    showNotification('This status is protected and cannot be edited', 'error');
                    return;
                }
                
                const statusItems = document.getElementById('statusItems');
                const statusItem = Array.from(statusItems.children).find(item => 
                    item.querySelector(`button[onclick*="editStatus(${id})"]`)
                );
                
                if (statusItem) {
                    statusItem.innerHTML = `
                        <input type="text" class="edit-input" id="editStatusInput${id}" value="${status.name}" onkeypress="if(event.key==='Enter') saveStatusEdit(${id})">
                        <div class="status-actions">
                            <button type="button" class="btn btn-sm btn-success" onclick="saveStatusEdit(${id})">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="loadStatusesAndPriorities()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    
                    document.getElementById(`editStatusInput${id}`).focus();
                }
            })
            .catch(error => {
                console.error('Error loading status:', error);
                showNotification('Error loading status', 'error');
            });
    };

    window.saveStatusEdit = function(id) {
        const input = document.getElementById(`editStatusInput${id}`);
        const newName = input.value.trim();
        
        if (!newName) {
            showNotification('Status name cannot be empty', 'error');
            return;
        }
        
        fetch(`<?php echo e(route("staprio.update", ":id")); ?>`.replace(':id', id), {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                name: newName
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                loadStatusesAndPriorities();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error updating status:', error);
            showNotification('Error updating status', 'error');
        });
    };

    window.deleteStatus = function(id) {
        if (confirm('Are you sure you want to delete this status?')) {
            fetch(`<?php echo e(route("staprio.destroy", ":id")); ?>`.replace(':id', id), {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    loadStatusesAndPriorities();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error deleting status:', error);
                showNotification('Error deleting status', 'error');
            });
        }
    };

    window.editPriority = function(id) {
        const headers = {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };

        fetch('<?php echo e(route("staprio.priorities")); ?>', {
            method: 'GET',
            headers: headers
        })
            .then(response => response.json())
            .then(priorities => {
                const priority = priorities.find(p => p.id === id);
                
                const priorityItems = document.getElementById('priorityItems');
                const priorityItem = Array.from(priorityItems.children).find(item => 
                    item.querySelector(`button[onclick*="editPriority(${id})"]`)
                );
                
                if (priorityItem) {
                    priorityItem.innerHTML = `
                        <input type="text" class="edit-input" id="editPriorityInput${id}" value="${priority.name}" onkeypress="if(event.key==='Enter') savePriorityEdit(${id})">
                        <div class="priority-actions">
                            <button type="button" class="btn btn-sm btn-success" onclick="savePriorityEdit(${id})">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="loadStatusesAndPriorities()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    
                    document.getElementById(`editPriorityInput${id}`).focus();
                }
            })
            .catch(error => {
                console.error('Error loading priority:', error);
                showNotification('Error loading priority', 'error');
            });
    };

    window.savePriorityEdit = function(id) {
        const input = document.getElementById(`editPriorityInput${id}`);
        const newName = input.value.trim();
        
        if (!newName) {
            showNotification('Priority name cannot be empty', 'error');
            return;
        }
        
        fetch(`<?php echo e(route("staprio.update", ":id")); ?>`.replace(':id', id), {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                name: newName
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                loadStatusesAndPriorities();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error updating priority:', error);
            showNotification('Error updating priority', 'error');
        });
    };

    window.deletePriority = function(id) {
        if (confirm('Are you sure you want to delete this priority?')) {
            fetch(`<?php echo e(route("staprio.destroy", ":id")); ?>`.replace(':id', id), {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    loadStatusesAndPriorities();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error deleting priority:', error);
                showNotification('Error deleting priority', 'error');
            });
        }
    };

    // Save Leads Settings
    window.saveLeadsSettings = function() {
        // Get all settings values
        const settings = {
            itemsPerPage: document.getElementById('itemsPerPage').value,
            showInactive: document.getElementById('showInactive').checked,
            enableAutoRefresh: document.getElementById('enableAutoRefresh').checked,
            emailNotifications: document.getElementById('emailNotifications').checked,
            statusChangeNotifications: document.getElementById('statusChangeNotifications').checked,
            assignmentNotifications: document.getElementById('assignmentNotifications').checked,
            tableStyle: document.getElementById('tableStyle').value,
            colorScheme: document.getElementById('colorScheme').value,
            compactMode: document.getElementById('compactMode').checked
        };

        // Save to localStorage
        localStorage.setItem('leadsSettings', JSON.stringify(settings));

        // Show success notification
        showNotification('Settings saved successfully!', 'success');

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('leadsSettingsModal'));
        if (modal) {
            modal.hide();
        }

        // Apply settings immediately
        applyLeadsSettings(settings);
    };

    // Apply Leads Settings
    window.applyLeadsSettings = function(settings) {
        // Apply table style
        const table = document.getElementById('leadsTable');
        if (table) {
            // Remove existing table classes
            table.className = 'table';
            
            // Add new table classes based on settings
            if (settings.tableStyle === 'striped') table.classList.add('table-striped');
            if (settings.tableStyle === 'bordered') table.classList.add('table-bordered');
            if (settings.tableStyle === 'hover') table.classList.add('table-hover');
            if (settings.tableStyle === 'condensed') table.classList.add('table-sm');
        }

        // Apply compact mode
        if (settings.compactMode) {
            document.body.classList.add('compact-mode');
        } else {
            document.body.classList.remove('compact-mode');
        }

        // Apply color scheme
        document.body.className = document.body.className.replace(/color-scheme-\w+/g, '');
        document.body.classList.add('color-scheme-' + settings.colorScheme);

        console.log('Settings applied:', settings);
    };

    // Load settings on page load
    document.addEventListener('DOMContentLoaded', function() {
        const savedSettings = localStorage.getItem('leadsSettings');
        if (savedSettings) {
            const settings = JSON.parse(savedSettings);
            
            // Update form controls
            document.getElementById('itemsPerPage').value = settings.itemsPerPage || '10';
            document.getElementById('showInactive').checked = settings.showInactive !== false;
            document.getElementById('enableAutoRefresh').checked = settings.enableAutoRefresh || false;
            document.getElementById('emailNotifications').checked = settings.emailNotifications !== false;
            document.getElementById('statusChangeNotifications').checked = settings.statusChangeNotifications !== false;
            document.getElementById('assignmentNotifications').checked = settings.assignmentNotifications || false;
            document.getElementById('tableStyle').value = settings.tableStyle || 'striped';
            document.getElementById('colorScheme').value = settings.colorScheme || 'default';
            document.getElementById('compactMode').checked = settings.compactMode || false;

            // Apply settings
            applyLeadsSettings(settings);
        }

        // Load statuses and priorities when settings modal is opened
        const settingsModal = document.getElementById('leadsSettingsModal');
        if (settingsModal) {
            settingsModal.addEventListener('show.bs.modal', function() {
                loadStatusesAndPriorities();
            });
        }

        // Load statuses and priorities on page load to show them by default
        document.addEventListener('DOMContentLoaded', function() {
            loadStatusesAndPriorities();
        });
    });
});
</script>

<!-- Reaction Management Modal -->
<div class="modal fade" id="reactionModal" tabindex="-1" aria-labelledby="reactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reactionModalLabel">
                    <i class="fas fa-face-smile"></i> Reaction Management
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-chart-line"></i> Reaction Overview</h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <div class="reaction-stat-card">
                                            <div class="reaction-emoji">😊</div>
                                            <h5 class="text-success"><?php echo e(App\Models\LeadReaction::where('reaction_type', 'positive')->count()); ?></h5>
                                            <small class="text-muted">Positive</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="reaction-stat-card">
                                            <div class="reaction-emoji">😐</div>
                                            <h5 class="text-warning"><?php echo e(App\Models\LeadReaction::where('reaction_type', 'neutral')->count()); ?></h5>
                                            <small class="text-muted">Neutral</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="reaction-stat-card">
                                            <div class="reaction-emoji">😔</div>
                                            <h5 class="text-danger"><?php echo e(App\Models\LeadReaction::where('reaction_type', 'negative')->count()); ?></h5>
                                            <small class="text-muted">Negative</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="reaction-stat-card">
                                            <div class="reaction-emoji">📊</div>
                                            <h5 class="text-primary"><?php echo e(App\Models\LeadReaction::count()); ?></h5>
                                            <small class="text-muted">Total</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-clock"></i> Recent Reactions</h6>
                            </div>
                            <div class="card-body">
                                <?php
                                    $recentReactions = App\Models\LeadReaction::with(['lead', 'user'])
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();
                                ?>
                                <?php if($recentReactions->count() > 0): ?>
                                    <?php $__currentLoopData = $recentReactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="d-flex align-items-center mb-2 p-2 border rounded">
                                            <div class="reaction-emoji me-3">
                                                <?php echo e($reaction->getReactionEmoji()); ?>

                                            </div>
                                            <div class="flex-grow-1">
                                                <strong><?php echo e($reaction->lead->name ?? 'Unknown Lead'); ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                    <?php echo e($reaction->user->name ?? 'Unknown User'); ?> - 
                                                    <?php echo e($reaction->created_at->diffForHumans()); ?>

                                                </small>
                                            </div>
                                            <div>
                                                <span class="badge bg-info"><?php echo e($reaction->reaction_type); ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-face-smile fa-3x mb-3"></i>
                                        <p>No reactions recorded yet. Start adding reactions to leads!</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
                <a href="<?php echo e(route('reactions-system.index')); ?>" class="btn btn-primary">
                    <i class="fas fa-cog"></i> Manage Reactions
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.reaction-stat-card {
    padding: 1rem;
    border-radius: 10px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    transition: transform 0.3s ease;
}

.reaction-stat-card:hover {
    transform: translateY(-3px);
}

.reaction-stat-card .reaction-emoji {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}

.reaction-stat-card h5 {
    margin-bottom: 0.25rem;
    font-weight: bold;
}

.reaction-stat-card small {
    font-weight: 600;
}
</style>

<script>

// Function to toggle extra columns visibility
function toggleExtraColumns() {
    const toggle = document.getElementById('extraColumnsToggle');
    const extraColumns = document.querySelectorAll('.extra-column');
    
    extraColumns.forEach(column => {
        if (toggle.checked) {
            column.style.display = 'table-cell';
        } else {
            column.style.display = 'none';
        }
    });
    
    // Save preference to localStorage
    localStorage.setItem('extraColumnsVisible', toggle.checked);
}


// Load preference from localStorage on page load
document.addEventListener('DOMContentLoaded', function() {
    const extraColumnsVisible = localStorage.getItem('extraColumnsVisible') === 'true';
    const toggle = document.getElementById('extraColumnsToggle');
    
    if (toggle) {
        toggle.checked = extraColumnsVisible;
        toggleExtraColumns();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/leads/index.blade.php ENDPATH**/ ?>