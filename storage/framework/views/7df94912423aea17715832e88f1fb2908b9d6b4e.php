<?php $__env->startSection('title'); ?>
    Menu Controller - Admin Panel
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Menu Controller</h3>
                        <div class="card-tools">
                            <button class="btn btn-warning btn-sm" id="setMenusBtn">
                                <i class="fas fa-cogs"></i> Set Menus
                            </button>
                            <a href="<?php echo e(route('menu-controller.create')); ?>" class="btn btn-primary btn-sm ml-2">
                                <i class="fas fa-plus"></i> Add Menu Item
                            </a>
                            <a href="<?php echo e(route('employee-menu-controller.index')); ?>" class="btn btn-info btn-sm ml-2">
                                <i class="fas fa-users-cog"></i> Employee Menu
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>

                        <!-- Set Menus Modal -->
                        <div class="modal fade" id="setMenusModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Set Menus - Role Configuration</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Role Selection -->
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label for="modalRoleSelect" class="form-label font-weight-bold">Select Role:</label>
                                                <select class="form-control" id="modalRoleSelect">
                                                    <option value="">Choose a role...</option>
                                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleId => $roleName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($roleId); ?>"><?php echo e($roleName); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">&nbsp;</label>
                                                <div>
                                                    <button class="btn btn-success btn-sm" id="modalSavePermissions" disabled>
                                                        <i class="fas fa-save"></i> Save Menu Order
                                                    </button>
                                                    <button class="btn btn-secondary btn-sm ml-2" id="resetOrder">
                                                        <i class="fas fa-undo"></i> Reset Order
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Menu List with Drag & Drop -->
                                        <div id="setMenusContainer" style="display: none;">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle"></i> Drag and drop menus to reorder. Use checkboxes to show/hide menus for this role.
                                            </div>
                                            
                                            <div id="sortableMenus" class="list-group">
                                                <!-- Menu items will be populated here -->
                                            </div>
                                        </div>

                                        <!-- Loading State -->
                                        <div id="modalLoadingState" class="text-center" style="display: none;">
                                            <i class="fas fa-spinner fa-spin fa-2x"></i>
                                            <p>Loading menu configuration...</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="modalSaveBtn" disabled>
                                            <i class="fas fa-save"></i> Save All Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Role Selection Dropdown -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="roleSelect" class="form-label">Select Role:</label>
                                <select class="form-control" id="roleSelect">
                                    <option value="">Choose a role...</option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleId => $roleName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($roleId); ?>"><?php echo e($roleName); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <!-- Menu Permissions Table -->
                        <div id="menuPermissionsContainer" style="display: none;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4>Menu Permissions for <span id="selectedRoleName"></span></h4>
                                <button class="btn btn-success btn-sm" id="savePermissions">
                                    <i class="fas fa-save"></i> Save Permissions
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="menuTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>Menu Name</th>
                                            <th>URL</th>
                                            <th>Icon</th>
                                            <th>Order</th>
                                            <th class="text-center">Visible</th>
                                        </tr>
                                    </thead>
                                    <tbody id="menuTableBody">
                                        <!-- Menu items will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Loading State -->
                        <div id="loadingState" class="text-center" style="display: none;">
                            <i class="fas fa-spinner fa-spin fa-2x"></i>
                            <p>Loading menu permissions...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #007bff;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .menu-icon-preview {
        font-size: 16px;
        margin-right: 8px;
    }

    /* Set Menus Modal Styles */
    .menu-item {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        margin-bottom: 8px;
        border-radius: 8px;
        padding: 15px;
        cursor: move;
        transition: all 0.3s ease;
    }

    .menu-item:hover {
        background: #e9ecef;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .menu-item.dragging {
        opacity: 0.5;
        transform: rotate(2deg);
    }

    .menu-item.ui-sortable-helper {
        background: #fff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .menu-handle {
        font-size: 18px;
        color: #6c757d;
        cursor: grab;
    }

    .menu-handle:active {
        cursor: grabbing;
    }

    .menu-order-badge {
        background: #007bff;
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: bold;
    }

    .visibility-toggle {
        margin-left: auto;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    const allMenus = <?php echo json_encode($allMenus, 15, 512) ?>;
    let currentRolePermissions = [];
    let modalRolePermissions = [];

    $(document).ready(function() {
        // Set Menus Button Handler
        $('#setMenusBtn').on('click', function() {
            $('#setMenusModal').modal('show');
        });

        // Modal Role Selection Handler
        $('#modalRoleSelect').on('change', function() {
            const roleId = $(this).val();
            if (roleId) {
                loadModalMenuPermissions(roleId);
                $('#setMenusContainer').show();
                $('#modalLoadingState').hide();
                $('#modalSavePermissions, #modalSaveBtn').prop('disabled', false);
            } else {
                $('#setMenusContainer').hide();
                $('#modalSavePermissions, #modalSaveBtn').prop('disabled', true);
            }
        });

        // Modal Save Permissions Handler
        $('#modalSavePermissions, #modalSaveBtn').on('click', function() {
            saveModalMenuPermissions();
        });

        // Reset Order Handler
        $('#resetOrder').on('click', function() {
            const roleId = $('#modalRoleSelect').val();
            if (roleId) {
                loadModalMenuPermissions(roleId);
            }
        });

        // Initialize Sortable
        $('#sortableMenus').sortable({
            handle: '.menu-handle',
            placeholder: 'menu-item-placeholder',
            start: function(e, ui) {
                ui.item.addClass('dragging');
            },
            stop: function(e, ui) {
                ui.item.removeClass('dragging');
                updateMenuOrderBadges();
            }
        });

        // Original role selection change handler
        $('#roleSelect').on('change', function() {
            const roleId = $(this).val();
            if (roleId) {
                loadMenuPermissions(roleId);
                $('#selectedRoleName').text($('#roleSelect option:selected').text());
                $('#menuPermissionsContainer').show();
            } else {
                $('#menuPermissionsContainer').hide();
            }
        });

        // Save permissions button handler
        $('#savePermissions').on('click', function() {
            saveMenuPermissions();
        });
    });

    function loadModalMenuPermissions(roleId) {
        $('#modalLoadingState').show();
        $('#sortableMenus').empty();

        console.log('Loading modal permissions for role:', roleId);

        $.get('<?php echo e(route("menu-controller.api.permissions")); ?>', { role_id: roleId })
            .done(function(data) {
                console.log('Raw data from server:', data);
                modalRolePermissions = data;
                populateModalMenuList();
                $('#modalLoadingState').hide();
            })
            .fail(function(xhr, status, error) {
                console.error('Error loading permissions:', xhr.responseText);
                alert('Error loading menu permissions: ' + error);
                $('#modalLoadingState').hide();
            });
    }

    function populateModalMenuList() {
        const container = $('#sortableMenus');
        container.empty();

        // Sort menus by current order
        const sortedMenus = [...allMenus].sort((a, b) => {
            const permissionA = modalRolePermissions.find(p => p.menu_name === a.name);
            const permissionB = modalRolePermissions.find(p => p.menu_name === b.name);
            const orderA = permissionA ? permissionA.menu_order : allMenus.indexOf(a);
            const orderB = permissionB ? permissionB.menu_order : allMenus.indexOf(b);
            return orderA - orderB;
        });

        sortedMenus.forEach(function(menu, index) {
            const existingPermission = modalRolePermissions.find(p => p.menu_name === menu.name);
            let isVisible = true;
            if (existingPermission) {
                isVisible = existingPermission.is_visible === 1 || existingPermission.is_visible === true;
            }
            const order = existingPermission ? existingPermission.menu_order : index;

            const menuItem = `
                <div class="menu-item" data-menu-name="${menu.name}" data-menu-url="${menu.url}" data-menu-icon="${menu.icon}">
                    <div class="d-flex align-items-center">
                        <div class="menu-handle mr-3">
                            <i class="fas fa-grip-vertical"></i>
                        </div>
                        <div class="menu-order-badge mr-3">
                            #${index + 1}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center">
                                <i class="${menu.icon} menu-icon-preview mr-2"></i>
                                <strong>${menu.name}</strong>
                                <small class="text-muted ml-2">${menu.url}</small>
                            </div>
                        </div>
                        <div class="visibility-toggle">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input menu-visibility-checkbox" 
                                       id="modal_${menu.name.replace(/\s+/g, '_')}" 
                                       data-menu-name="${menu.name}" 
                                       ${isVisible ? 'checked' : ''}>
                                <label class="custom-control-label" for="modal_${menu.name.replace(/\s+/g, '_')}">
                                    ${isVisible ? 'Visible' : 'Hidden'}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.append(menuItem);
        });

        // Add event listeners for visibility checkboxes
        $('.menu-visibility-checkbox').on('change', function() {
            const $checkbox = $(this);
            const $label = $checkbox.next('label');
            const isVisible = $checkbox.is(':checked');
            $label.text(isVisible ? 'Visible' : 'Hidden');
        });
    }

    function updateMenuOrderBadges() {
        $('#sortableMenus .menu-item').each(function(index) {
            $(this).find('.menu-order-badge').text('#' + (index + 1));
        });
    }

    function saveModalMenuPermissions() {
        const roleId = $('#modalRoleSelect').val();
        const menus = [];

        $('#sortableMenus .menu-item').each(function(index) {
            const $item = $(this);
            const menuName = $item.data('menu-name');
            const menuUrl = $item.data('menu-url');
            const menuIcon = $item.data('menu-icon');
            const isVisible = $item.find('.menu-visibility-checkbox').is(':checked');

            menus.push({
                name: menuName,
                url: menuUrl,
                icon: menuIcon,
                order: index,
                visible: isVisible
            });
        });

        console.log('Saving modal menu permissions:', { role_id: roleId, menus: menus });

        $('#modalSavePermissions, #modalSaveBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '<?php echo e(route("menu-controller.api.update")); ?>',
            method: 'POST',
            data: {
                role_id: roleId,
                menus: menus
            },
            dataType: 'json',
            success: function(response) {
                console.log('Server response:', response);
                if (response.success) {
                    alert('Menu configuration saved successfully!');
                    // Reload to show updated data
                    loadModalMenuPermissions(roleId);
                } else {
                    alert('Error saving menu configuration: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                alert('Error saving menu configuration: ' + (xhr.responseJSON?.message || error));
            },
            complete: function() {
                $('#modalSavePermissions').prop('disabled', false).html('<i class="fas fa-save"></i> Save Menu Order');
                $('#modalSaveBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Save All Changes');
            }
        });
    }

    function loadMenuPermissions(roleId) {
        $('#loadingState').show();
        $('#menuTableBody').empty();

        console.log('Loading permissions for role:', roleId);

        $.get('<?php echo e(route("menu-controller.api.permissions")); ?>', { role_id: roleId })
            .done(function(data) {
                console.log('Raw data from server:', data);
                currentRolePermissions = data;
                populateMenuTable();
                $('#loadingState').hide();
            })
            .fail(function(xhr, status, error) {
                console.error('Error loading permissions:', xhr.responseText);
                alert('Error loading menu permissions: ' + error);
                $('#loadingState').hide();
            });
    }

    function populateMenuTable() {
        const tbody = $('#menuTableBody');
        tbody.empty();
        const roleId = $('#roleSelect').val();

        console.log('Current role permissions from server:', currentRolePermissions);

        allMenus.forEach(function(menu, index) {
            const existingPermission = currentRolePermissions.find(p => p.menu_name === menu.name);
            console.log('Menu:', menu.name, 'Existing permission:', existingPermission);
            
            // Handle is_visible properly - it comes as integer from database (0 or 1)
            let isVisible = true; // Default to visible
            if (existingPermission) {
                // Convert integer to boolean for comparison
                isVisible = existingPermission.is_visible === 1 || existingPermission.is_visible === true;
            }
            const order = existingPermission ? existingPermission.menu_order : index;

            console.log('Final visibility for', menu.name, ':', isVisible);

            const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>
                        <i class="${menu.icon} menu-icon-preview"></i>
                        ${menu.name}
                        <input type="hidden" name="menus[${index}][name]" value="${menu.name}">
                        <input type="hidden" name="menus[${index}][url]" value="${menu.url}">
                        <input type="hidden" name="menus[${index}][icon]" value="${menu.icon}">
                    </td>
                    <td>${menu.url}</td>
                    <td><i class="${menu.icon}"></i></td>
                    <td>
                        <input type="number" class="form-control form-control-sm" 
                               name="menus[${index}][order]" value="${order}" min="0" style="width: 80px;">
                    </td>
                    <td class="text-center">
                        <select class="form-select form-select-sm menu-visibility" name="menus[${index}][visible]" data-menu-name="${menu.name}" data-menu-url="${menu.url}" style="width: 100px;">
                            <option value="1" ${isVisible ? 'selected' : ''}>Show</option>
                            <option value="0" ${!isVisible ? 'selected' : ''}>Hide</option>
                        </select>
                        ${isVisible ? `
                            <a href="<?php echo e(route('page-customization.index')); ?>?menu_name=${encodeURIComponent(menu.name)}&menu_url=${encodeURIComponent(menu.url)}&role_id=${roleId}" 
                               class="btn btn-sm btn-outline-primary ml-1 page-settings-btn" 
                               title="Customize Page Elements"
                               style="padding: 2px 6px; font-size: 11px;">
                                <i class="fas fa-cog"></i>
                            </a>
                        ` : ''}
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }

    function saveMenuPermissions() {
        const roleId = $('#roleSelect').val();
        const menus = [];

        $('input[name^="menus"], select[name^="menus"]').each(function() {
            const element = $(this);
            const name = element.attr('name');
            let value;
            
            if (element.is('select')) {
                value = element.val();
            } else if (element.is(':checkbox')) {
                value = element.is(':checked');
            } else {
                value = element.val();
            }
            
            const match = name.match(/menus\[(\d+)\]\[(.+)\]/);
            if (match) {
                const index = parseInt(match[1]);
                const field = match[2];
                
                if (!menus[index]) {
                    menus[index] = {};
                }
                
                if (field === 'visible') {
                    menus[index][field] = value === '1' || value === 1 || value === true;
                } else {
                    menus[index][field] = value;
                }
            }
        });

        const validMenus = menus.filter(menu => menu && menu.name);

        $('#savePermissions').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '<?php echo e(route("menu-controller.api.update")); ?>',
            method: 'POST',
            data: {
                role_id: roleId,
                menus: validMenus
            },
            dataType: 'json',
            success: function(response) {
                console.log('Server response:', response);
                if (response.success) {
                    alert('Menu permissions saved successfully!');
                    loadMenuPermissions(roleId);
                } else {
                    alert('Error saving menu permissions: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                alert('Error saving menu permissions: ' + (xhr.responseJSON?.message || error));
            },
            complete: function() {
                $('#savePermissions').prop('disabled', false).html('<i class="fas fa-save"></i> Save Permissions');
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/menu-controller/index.blade.php ENDPATH**/ ?>