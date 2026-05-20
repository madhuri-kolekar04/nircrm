<?php $__env->startSection('title'); ?>
    Employee Menu Controller - Admin Panel
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Employee Menu Controller</h3>
                        <div class="card-tools">
                            <a href="<?php echo e(route('menu-controller.index')); ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Admin Menu
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

                        <!-- Employee Selection Dropdowns -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="departmentSelect" class="form-label">Department:</label>
                                <select class="form-control" id="departmentSelect">
                                    <option value="">Select Department...</option>
                                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($department->id); ?>"><?php echo e($department->department); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="roleSelect" class="form-label">Select Role:</label>
                                <select class="form-control" id="roleSelect">
                                    <option value="">Select Role...</option>
                                    <option value="Employee">Employee</option>
                                    <option value="Manager">Manager</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="employeeSelect" class="form-label">Employee List:</label>
                                <select class="form-control" id="employeeSelect">
                                    <option value="">Select Employee...</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <button class="btn btn-primary btn-block" id="loadEmployeeBtn">
                                    <i class="fas fa-search"></i> Load
                                </button>
                            </div>
                        </div>

                        
                        <!-- Menu Permissions Table -->
                        <div id="menuPermissionsContainer" style="display: none;">
                            <form id="employeeMenuPermissionsForm">
                                <?php echo csrf_field(); ?>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4>Menu Permissions for <span id="selectedEmployeeName"></span></h4>
                                    <button class="btn btn-success btn-sm" id="savePermissions" type="button">
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
                            </form>
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
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const allMenus = <?php echo json_encode($allMenus, 15, 512) ?>;
    let currentEmployeePermissions = [];
    let selectedEmployeeId = null;

    // Set up CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
        }
    });

    $(document).ready(function() {
        // Employee selection dropdown handlers
        $('#departmentSelect, #roleSelect').on('change', function() {
            loadEmployees();
        });

        $('#loadEmployeeBtn').on('click', function() {
            const employeeId = $('#employeeSelect').val();
            const employeeName = $('#employeeSelect option:selected').text();
            
            if (employeeId) {
                selectedEmployeeId = employeeId;
                const nameOnly = employeeName.split(' (')[0]; // Remove email from display
                $('#selectedEmployeeName').text(nameOnly);
                loadEmployeeMenuPermissions(employeeId);
                $('#menuPermissionsContainer').show();
            } else {
                alert('Please select an employee first');
                $('#menuPermissionsContainer').hide();
            }
        });

        // Save permissions button handler
        $('#savePermissions').on('click', function() {
            saveEmployeeMenuPermissions();
        });
    });

    function loadEmployees() {
        const departmentId = $('#departmentSelect').val();
        const roleName = $('#roleSelect').val();
        
        if (!departmentId && !roleName) {
            $('#employeeSelect').html('<option value="">Select Employee...</option>');
            return;
        }

        $('#employeeSelect').html('<option value="">Loading...</option>');

        $.get('<?php echo e(route("employee-menu-controller.api.employees")); ?>', { 
            department_id: departmentId, 
            role_name: roleName 
        })
        .done(function(data) {
            let options = '<option value="">Select Employee...</option>';
            data.forEach(function(employee) {
                options += `<option value="${employee.id}">${employee.name} (${employee.email})</option>`;
            });
            $('#employeeSelect').html(options);
        })
        .fail(function(xhr, status, error) {
            console.error('Error loading employees:', xhr.responseText);
            $('#employeeSelect').html('<option value="">Error loading employees</option>');
        });
    }

    function loadEmployeeMenuPermissions(employeeId) {
        $('#loadingState').show();
        $('#menuTableBody').empty();

        console.log('Loading permissions for employee:', employeeId);

        // Fetch existing employee menu permissions from database
        $.get('<?php echo e(route("employee-menu-controller.api.permissions")); ?>', { 
            employee_id: employeeId 
        })
        .done(function(data) {
            console.log('Retrieved employee permissions:', data);
            console.log('Data length:', data.length);
            currentEmployeePermissions = data;
            
            // If no individual employee permissions, fetch role-based permissions
            if (data.length === 0) {
                console.log('No individual employee permissions found, fetching role-based permissions...');
                // Get the employee's role from the dropdown
                const employeeRole = $('#roleSelect').val();
                console.log('Selected role from dropdown:', employeeRole);
                
                if (employeeRole) {
                    // Map role name to role ID
                    const roleMap = {
                        'Employee': 2,
                        'Manager': 4,
                        'Admin': 1,
                        'Super Admin': 5,
                        'Customer': 3
                    };
                    const roleId = roleMap[employeeRole];
                    console.log('Mapped role ID:', roleId);
                    
                    if (roleId) {
                        // Fetch role-based menu permissions
                        console.log('Fetching role-based permissions for role ID:', roleId);
                        $.get('<?php echo e(route("menu-controller.api.permissions")); ?>', { 
                            role_id: roleId 
                        })
                        .done(function(roleData) {
                            console.log('Retrieved role-based permissions:', roleData);
                            console.log('Role data length:', roleData.length);
                            // Convert role permissions to employee permission format
                            currentEmployeePermissions = roleData.map(function(menu) {
                                console.log('Processing role menu:', menu.menu_name, 'Visible:', menu.is_visible);
                                return {
                                    menu_name: menu.menu_name,
                                    menu_url: menu.menu_url,
                                    menu_icon: menu.menu_icon,
                                    menu_order: menu.menu_order,
                                    is_visible: menu.is_visible
                                };
                            });
                            console.log('Final currentEmployeePermissions:', currentEmployeePermissions);
                            populateEmployeeMenuTable();
                            $('#loadingState').hide();
                        })
                        .fail(function(xhr, status, error) {
                            console.error('Error loading role permissions:', xhr.responseText);
                            currentEmployeePermissions = [];
                            populateEmployeeMenuTable();
                            $('#loadingState').hide();
                        });
                        return; // Exit early, we'll populate after role permissions load
                    }
                }
            }
            
            console.log('Using individual employee permissions');
            populateEmployeeMenuTable();
            $('#loadingState').hide();
        })
        .fail(function(xhr, status, error) {
            console.error('Error loading employee permissions:', xhr.responseText);
            // If no permissions exist, start with empty array
            currentEmployeePermissions = [];
            populateEmployeeMenuTable();
            $('#loadingState').hide();
        });
    }

    function populateEmployeeMenuTable() {
        const tbody = $('#menuTableBody');
        tbody.empty();

        console.log('=== POPULATE EMPLOYEE MENU TABLE ===');
        console.log('Current employee permissions:', currentEmployeePermissions);
        console.log('All available menus:', allMenus);

        allMenus.forEach(function(menu, index) {
            const existingPermission = currentEmployeePermissions.find(p => p.menu_name === menu.name);
            
            console.log(`Processing menu: ${menu.name}`);
            console.log(`Found permission:`, existingPermission);
            
            // Use the actual permission status if it exists, otherwise default to visible
            let isVisible = true; // Default fallback
            if (existingPermission) {
                isVisible = existingPermission.is_visible === 1 || existingPermission.is_visible === true;
                console.log(`Setting visibility for ${menu.name}: ${isVisible ? 'SHOW' : 'HIDE'} (from permission)`);
            } else {
                console.log(`Setting visibility for ${menu.name}: ${isVisible ? 'SHOW' : 'HIDE'} (default)`);
            }
            
            const order = existingPermission ? existingPermission.menu_order : index;

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
                    <select class="form-select form-select-sm employee-menu-toggle" name="menus[${index}][visible]" style="width: 100px;" data-employee-id="${selectedEmployeeId}" data-menu-name="${menu.name}">
                        <option value="1" ${isVisible ? 'selected' : ''}>Show</option>
                        <option value="0" ${!isVisible ? 'selected' : ''}>Hide</option>
                    </select>
                </td>
                </tr>
            `;
            tbody.append(row);
        });

        console.log('=== END POPULATE ===');

        // Add event listener for immediate saving on dropdown change
        $('.employee-menu-toggle').off('change').on('change', function() {
            const employeeId = $(this).data('employee-id');
            const menuName = $(this).data('menu-name');
            const isVisible = $(this).val() === '1';
            
            console.log(`Menu "${menuName}" for employee ${employeeId} set to: ${isVisible ? 'Show' : 'Hide'}`);
            
            // Immediately save the change
            saveSingleMenuPermission(employeeId, menuName, isVisible);
        });
    }

    function saveSingleMenuPermission(employeeId, menuName, isVisible) {
        console.log(`Saving menu permission: Employee ${employeeId}, Menu "${menuName}", Visible: ${isVisible}`);
        
        // Find the menu data from allMenus
        const menuData = allMenus.find(m => m.name === menuName);
        if (!menuData) {
            console.error('Menu not found:', menuName);
            return;
        }

        // Prepare the data for API
        const permissionData = {
            employee_id: employeeId,
            menus: [{
                name: menuName,
                url: menuData.url,
                icon: menuData.icon,
                order: 0,
                visible: isVisible
            }],
            _token: $('input[name="_token"]').val()
        };

        // Save via API
        $.post('<?php echo e(route("employee-menu-controller.api.update")); ?>', permissionData)
        .done(function(response) {
            console.log('Menu permission saved successfully:', response);
            // Show success message
            const action = isVisible ? 'shown' : 'hidden';
            console.log(`Menu "${menuName}" has been ${action} for this employee.`);
            
            // Update current permissions array
            const existingIndex = currentEmployeePermissions.findIndex(p => p.menu_name === menuName);
            if (existingIndex >= 0) {
                currentEmployeePermissions[existingIndex].is_visible = isVisible;
            } else {
                currentEmployeePermissions.push({
                    menu_name: menuName,
                    menu_url: menuData.url,
                    menu_icon: menuData.icon,
                    menu_order: 0,
                    is_visible: isVisible
                });
            }
        })
        .fail(function(xhr, status, error) {
            console.error('Error saving menu permission:', xhr.responseText);
            alert('Error saving menu permission: ' + (xhr.responseJSON?.message || error));
        });
    }

    function saveEmployeeMenuPermissions() {
        if (!selectedEmployeeId) {
            alert('No employee selected');
            return;
        }

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

        console.log('Saving menu permissions for employee:', selectedEmployeeId);
        console.log('Menus to save:', validMenus);

        $('#savePermissions').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        // Save via API
        const permissionData = {
            employee_id: selectedEmployeeId,
            menus: validMenus,
            _token: $('input[name="_token"]').val()
        };

        $.post('<?php echo e(route("employee-menu-controller.api.update")); ?>', permissionData)
        .done(function(response) {
            console.log('Menu permissions saved successfully:', response);
            $('#savePermissions').prop('disabled', false).html('<i class="fas fa-save"></i> Save Permissions');
            alert('Menu permissions saved successfully for employee!');
            
            // Refresh the permissions to show updated state
            loadEmployeeMenuPermissions(selectedEmployeeId);
        })
        .fail(function(xhr, status, error) {
            console.error('Error saving menu permissions:', xhr.responseText);
            $('#savePermissions').prop('disabled', false).html('<i class="fas fa-save"></i> Save Permissions');
            alert('Error saving menu permissions: ' + (xhr.responseJSON?.message || error));
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/menu-controller/employee-index.blade.php ENDPATH**/ ?>