@extends('admin.admin_master')

@section('title')
    Page Customization
@endsection

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs"></i>
                        Page Customization System
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Selection Controls -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="menu_select" class="form-label">Select Menu</label>
                            <select id="menu_select" class="form-control">
                                <option value="">Choose Menu...</option>
                                @foreach($menus as $menu)
                                    <option value="{{ $menu['url'] }}" data-name="{{ $menu['name'] }}">
                                        {{ $menu['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="role_select" class="form-label">Select Role</label>
                            <select id="role_select" class="form-control">
                                <option value="">All Roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="user_select" class="form-label">Select User</label>
                            <select id="user_select" class="form-control" disabled>
                                <option value="">All Users</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <button id="analyze_page" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Analyze Page
                            </button>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div id="loading_state" class="text-center" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2">Analyzing page elements...</p>
                    </div>

                    <!-- Elements Configuration -->
                    <div id="elements_container" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5><i class="fas fa-list"></i> Page Elements</h5>
                            </div>
                            <div class="col-md-6 text-right">
                                <button id="save_all" class="btn btn-success">
                                    <i class="fas fa-save"></i>
                                    Save All Customizations
                                </button>
                                <button id="reset_all" class="btn btn-warning">
                                    <i class="fas fa-undo"></i>
                                    Reset All
                                </button>
                            </div>
                        </div>

                        <!-- Elements Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="elements_table">
                                <thead>
                                    <tr>
                                        <th width="5%">Show/Hide</th>
                                        <th width="25%">Element Name</th>
                                        <th width="15%">Type</th>
                                        <th width="15%">Category</th>
                                        <th width="40%">Description</th>
                                    </tr>
                                </thead>
                                <tbody id="elements_tbody">
                                    <!-- Elements will be loaded here -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Statistics -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Customization Statistics</h6>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Total Elements:</strong> <span id="total_elements">0</span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Visible:</strong> <span id="visible_elements">0</span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Hidden:</strong> <span id="hidden_elements">0</span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Scope:</strong> <span id="customization_scope">Global</span>
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
</div>

<!-- Success/Error Messages -->
<div id="success_message" class="alert alert-success" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
    <i class="fas fa-check-circle"></i>
    <span id="success_text">Customizations saved successfully!</span>
</div>

<div id="error_message" class="alert alert-danger" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
    <i class="fas fa-exclamation-circle"></i>
    <span id="error_text">Error occurred!</span>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let currentElements = [];
    let currentCustomizations = {};

    // Menu change handler
    $('#menu_select').change(function() {
        const menuUrl = $(this).val();
        const menuName = $(this).find('option:selected').data('name');
        
        if (menuUrl) {
            analyzePage(menuName, menuUrl);
        }
    });

    // Role change handler
    $('#role_select').change(function() {
        const roleId = $(this).val();
        loadUsersForRole(roleId);
    });

    // Analyze page button
    $('#analyze_page').click(function() {
        const menuUrl = $('#menu_select').val();
        const menuName = $('#menu_select').find('option:selected').data('name');
        
        if (!menuUrl) {
            showError('Please select a menu first');
            return;
        }
        
        analyzePage(menuName, menuUrl);
    });

    // Save all customizations
    $('#save_all').click(function() {
        saveAllCustomizations();
    });

    // Reset all customizations
    $('#reset_all').click(function() {
        if (confirm('Are you sure you want to reset all customizations for this selection?')) {
            resetAllCustomizations();
        }
    });

    function analyzePage(menuName, menuUrl) {
        showLoading();
        
        $.get('/page-customization/analyze', {
            menu_name: menuName,
            menu_url: menuUrl
        }, function(response) {
            hideLoading();
            
            if (response.error) {
                showError(response.error);
                return;
            }
            
            currentElements = response.elements || [];
            displayElements(currentElements);
            loadExistingCustomizations(menuName);
        }).fail(function() {
            hideLoading();
            showError('Error analyzing page. Please try again.');
        });
    }

    function loadUsersForRole(roleId) {
        const userSelect = $('#user_select');
        
        if (!roleId) {
            userSelect.html('<option value="">All Users</option>');
            userSelect.prop('disabled', true);
            return;
        }
        
        userSelect.prop('disabled', false);
        userSelect.html('<option value="">All Users</option>');
        
        $.get('/page-customization/users-for-role', {
            role_id: roleId
        }, function(response) {
            const users = response.users || [];
            users.forEach(function(user) {
                userSelect.append(`<option value="${user.id}">${user.name}</option>`);
            });
        }).fail(function() {
            showError('Error loading users for role.');
        });
    }

    function loadExistingCustomizations(menuName) {
        const roleId = $('#role_select').val();
        const userId = $('#user_select').val();
        
        $.get('/page-customization/get-customizations', {
            menu_name: menuName,
            role_id: roleId || '',
            employee_id: userId || ''
        }, function(response) {
            currentCustomizations = {};
            const customizations = response.customizations || [];
            
            customizations.forEach(function(customization) {
                currentCustomizations[customization.element_identifier] = customization.is_visible;
            });
            
            updateElementStates();
            updateStatistics();
        }).fail(function() {
            showError('Error loading existing customizations.');
        });
    }

    function displayElements(elements) {
        const tbody = $('#elements_tbody');
        tbody.empty();
        
        if (elements.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        <i class="fas fa-info-circle"></i>
                        No customizable elements found for this page.
                    </td>
                </tr>
            `);
            return;
        }
        
        elements.forEach(function(element) {
            const row = `
                <tr>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input element-checkbox" 
                                   type="checkbox" 
                                   id="${element.id}" 
                                   data-element-id="${element.id}"
                                   ${element.default_visible ? 'checked' : ''}>
                            <label class="form-check-label" for="${element.id}">
                                <span class="form-check-switch"></span>
                            </label>
                        </div>
                    </td>
                    <td>
                        <strong>${element.name}</strong>
                        <br>
                        <small class="text-muted">${element.description}</small>
                    </td>
                    <td>
                        <span class="badge badge-${element.type === 'section' ? 'primary' : element.type === 'button' ? 'success' : element.type === 'table' ? 'info' : 'secondary'}">
                            ${element.type}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-light">${element.category}</span>
                    </td>
                    <td>
                        <small class="text-muted">${element.description}</small>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });

        // Add change handlers to checkboxes
        $('.element-checkbox').change(function() {
            const elementId = $(this).data('element-id');
            const isVisible = $(this).is(':checked');
            currentCustomizations[elementId] = isVisible;
            updateStatistics();
        });
    }

    function updateElementStates() {
        $('.element-checkbox').each(function() {
            const elementId = $(this).data('element-id');
            const isVisible = currentCustomizations[elementId] !== undefined ? currentCustomizations[elementId] : true;
            $(this).prop('checked', isVisible);
        });
    }

    function updateStatistics() {
        const total = currentElements.length;
        let visible = 0;
        let hidden = 0;
        
        $('.element-checkbox').each(function() {
            if ($(this).is(':checked')) {
                visible++;
            } else {
                hidden++;
            }
        });
        
        $('#total_elements').text(total);
        $('#visible_elements').text(visible);
        $('#hidden_elements').text(hidden);
        
        // Update scope
        const roleId = $('#role_select').val();
        const userId = $('#user_select').val();
        let scope = 'Global';
        
        if (userId) {
            scope = 'User Specific';
        } else if (roleId) {
            scope = 'Role Specific';
        }
        
        $('#customization_scope').text(scope);
    }

    function saveAllCustomizations() {
        const menuName = $('#menu_select').find('option:selected').data('name');
        const roleId = $('#role_select').val();
        const userId = $('#user_select').val();
        
        if (!menuName) {
            showError('Please select a menu first');
            return;
        }
        
        $.post('/page-customization/store', {
            menu_name: menuName,
            role_id: roleId || '',
            employee_id: userId || '',
            elements: currentCustomizations
        }, function(response) {
            if (response.success) {
                showSuccess(response.message);
            } else {
                showError(response.message);
            }
        }).fail(function() {
            showError('Error saving customizations. Please try again.');
        });
    }

    function resetAllCustomizations() {
        const menuName = $('#menu_select').find('option:selected').data('name');
        const roleId = $('#role_select').val();
        const userId = $('#user_select').val();
        
        $.ajax({
            url: '/page-customization/reset',
            type: 'DELETE',
            data: {
                menu_name: menuName,
                role_id: roleId || '',
                employee_id: userId || ''
            },
            success: function(response) {
                if (response.success) {
                    showSuccess(response.message);
                    // Reset checkboxes to default
                    $('.element-checkbox').each(function() {
                        const elementId = $(this).data('element-id');
                        const element = currentElements.find(el => el.id === elementId);
                        if (element) {
                            $(this).prop('checked', element.default_visible);
                            currentCustomizations[elementId] = element.default_visible;
                        }
                    });
                    updateStatistics();
                } else {
                    showError(response.message);
                }
            },
            error: function() {
                showError('Error resetting customizations. Please try again.');
            }
        });
    }

    function showLoading() {
        $('#loading_state').show();
        $('#elements_container').hide();
    }

    function hideLoading() {
        $('#loading_state').hide();
        $('#elements_container').show();
    }

    function showSuccess(message) {
        $('#success_text').text(message);
        $('#success_message').fadeIn().delay(3000).fadeOut();
    }

    function showError(message) {
        $('#error_text').text(message);
        $('#error_message').fadeIn().delay(3000).fadeOut();
    }
});
</script>
@endpush
