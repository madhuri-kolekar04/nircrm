@extends('admin.admin_master')

@section('title')
    Page Customization - {{ $menuName ?? '' }}
@endsection

@section('admin')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">
                                <i class="fas fa-cog text-primary mr-2"></i>
                                Page Customization: {{ $menuName ?? '' }}
                            </h3>
                            <small class="text-muted">URL: {{ $menuUrl ?? '' }}</small>
                        </div>
                        <div>
                            <a href="{{ route('menu-controller.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Menu Controller
                            </a>
                            <button class="btn btn-success btn-sm ml-2" id="saveAllCustomizations">
                                <i class="fas fa-save"></i> Save All Changes
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Page Info -->
                        <div class="alert alert-info mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Menu Name:</strong> {{ $menuName ?? '' }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Menu URL:</strong> {{ $menuUrl ?? '' }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Role ID:</strong> {{ $roleId ?? 'All Roles' }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Employee ID:</strong> {{ $employeeId ?? 'All Employees' }}
                                </div>
                            </div>
                        </div>

                        <!-- Technical Analysis Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-robot mr-2"></i>
                                            AI Technical Analysis
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted mb-3">
                                            Click the button below to analyze the page and fetch all technical details 
                                            (tables, columns, buttons, forms, fields). You can then customize visibility for each element.
                                        </p>
                                        <button class="btn btn-primary" id="analyzePageBtn">
                                            <i class="fas fa-search-plus mr-2"></i>
                                            Analyze Page & Fetch Technical Details
                                        </button>
                                        
                                        <!-- Analysis Results -->
                                        <div id="analysisResults" class="mt-4" style="display: none;">
                                            <div class="accordion" id="technicalAccordion">
                                                <!-- Tables Section -->
                                                <div class="card">
                                                    <div class="card-header" id="headingTables">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTables">
                                                                <i class="fas fa-table mr-2"></i>
                                                                Tables (<span id="tableCount">0</span>)
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseTables" class="collapse show" data-parent="#technicalAccordion">
                                                        <div class="card-body">
                                                            <div id="tablesList"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Columns Section -->
                                                <div class="card">
                                                    <div class="card-header" id="headingColumns">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseColumns">
                                                                <i class="fas fa-columns mr-2"></i>
                                                                Columns (<span id="columnCount">0</span>)
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseColumns" class="collapse show" data-parent="#technicalAccordion">
                                                        <div class="card-body">
                                                            <div id="columnsList"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Buttons Section -->
                                                <div class="card">
                                                    <div class="card-header" id="headingButtons">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseButtons">
                                                                <i class="fas fa-mouse-pointer mr-2"></i>
                                                                Buttons (<span id="buttonCount">0</span>)
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseButtons" class="collapse show" data-parent="#technicalAccordion">
                                                        <div class="card-body">
                                                            <div id="buttonsList"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Forms Section -->
                                                <div class="card">
                                                    <div class="card-header" id="headingForms">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseForms">
                                                                <i class="fas fa-wpforms mr-2"></i>
                                                                Forms (<span id="formCount">0</span>)
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseForms" class="collapse show" data-parent="#technicalAccordion">
                                                        <div class="card-body">
                                                            <div id="formsList"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Input Fields Section -->
                                                <div class="card">
                                                    <div class="card-header" id="headingFields">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFields">
                                                                <i class="fas fa-keyboard mr-2"></i>
                                                                Input Fields (<span id="fieldCount">0</span>)
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseFields" class="collapse show" data-parent="#technicalAccordion">
                                                        <div class="card-body">
                                                            <div id="fieldsList"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Links Section -->
                                                <div class="card">
                                                    <div class="card-header" id="headingLinks">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseLinks">
                                                                <i class="fas fa-link mr-2"></i>
                                                                Links (<span id="linkCount">0</span>)
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseLinks" class="collapse show" data-parent="#technicalAccordion">
                                                        <div class="card-body">
                                                            <div id="linksList"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Images Section -->
                                                <div class="card">
                                                    <div class="card-header" id="headingImages">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseImages">
                                                                <i class="fas fa-image mr-2"></i>
                                                                Images (<span id="imageCount">0</span>)
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseImages" class="collapse show" data-parent="#technicalAccordion">
                                                        <div class="card-body">
                                                            <div id="imagesList"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Text/Labels Section -->
                                                <div class="card">
                                                    <div class="card-header" id="headingText">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseText">
                                                                <i class="fas fa-font mr-2"></i>
                                                                Text & Labels (<span id="textCount">0</span>)
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseText" class="collapse show" data-parent="#technicalAccordion">
                                                        <div class="card-body">
                                                            <div id="textList"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Divs/Containers Section -->
                                                <div class="card">
                                                    <div class="card-header" id="headingContainers">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseContainers">
                                                                <i class="fas fa-square mr-2"></i>
                                                                Containers & Divs (<span id="containerCount">0</span>)
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseContainers" class="collapse show" data-parent="#technicalAccordion">
                                                        <div class="card-body">
                                                            <div id="containersList"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cards/Sections Section -->
                                                <div class="card">
                                                    <div class="card-header" id="headingCards">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseCards">
                                                                <i class="fas fa-clone mr-2"></i>
                                                                Cards & Sections (<span id="cardCount">0</span>)
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseCards" class="collapse show" data-parent="#technicalAccordion">
                                                        <div class="card-body">
                                                            <div id="cardsList"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Navigation Elements Section -->
                                                <div class="card">
                                                    <div class="card-header" id="headingNavigation">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseNavigation">
                                                                <i class="fas fa-compass mr-2"></i>
                                                                Navigation (<span id="navigationCount">0</span>)
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapseNavigation" class="collapse show" data-parent="#technicalAccordion">
                                                        <div class="card-body">
                                                            <div id="navigationList"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Existing Customizations -->
                        @if($customizations->count() > 0)
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="mb-3">
                                        <i class="fas fa-list-check mr-2"></i>
                                        Existing Customizations
                                    </h4>
                                    
                                    @foreach($customizations as $type => $items)
                                        <div class="card mb-3">
                                            <div class="card-header bg-light">
                                                <h5 class="mb-0 text-capitalize">{{ $type }} Elements</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 50px;">#</th>
                                                                <th>Element Name</th>
                                                                <th>Identifier</th>
                                                                <th style="width: 100px;">Visible</th>
                                                                <th style="width: 100px;">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($items as $index => $item)
                                                                <tr data-customization-id="{{ $item->id }}">
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $item->element_name }}</td>
                                                                    <td><code>{{ $item->element_identifier ?: 'N/A' }}</code></td>
                                                                    <td class="text-center">
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox" 
                                                                                   class="custom-control-input visibility-toggle" 
                                                                                   id="visibility_{{ $item->id }}"
                                                                                   {{ $item->is_visible ? 'checked' : '' }}
                                                                                   data-id="{{ $item->id }}">
                                                                            <label class="custom-control-label" for="visibility_{{ $item->id }}">
                                                                                {{ $item->is_visible ? 'Show' : 'Hide' }}
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button class="btn btn-danger btn-sm delete-customization" 
                                                                                data-id="{{ $item->id }}">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle mr-2"></i>
                                No customizations found for this page. Click "Analyze Page" to fetch technical details and start customizing.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .customization-item {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    .customization-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .element-type-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .badge-table { background: #17a2b8; color: white; }
    .badge-column { background: #6c757d; color: white; }
    .badge-button { background: #28a745; color: white; }
    .badge-form { background: #ffc107; color: #333; }
    .badge-field { background: #dc3545; color: white; }
    .badge-link { background: #007bff; color: white; }
    .badge-image { background: #6f42c1; color: white; }
    .badge-text { background: #fd7e14; color: white; }
    .badge-container { background: #20c997; color: white; }
    .badge-card { background: #6c757d; color: white; }
    .badge-navigation { background: #343a40; color: white; }
    
    .visibility-toggle-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .technical-detail-card {
        border-left: 4px solid #007bff;
        background: white;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 0 8px 8px 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .element-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .element-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .element-metadata {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
</style>
@endpush

@push('scripts')
<script>
    const menuName = '{{ $menuName }}';
    const menuUrl = '{{ $menuUrl }}';
    const roleId = '{{ $roleId }}' === '' ? null : '{{ $roleId }}';
    const employeeId = '{{ $employeeId }}' === '' ? null : '{{ $employeeId }}';
    
    let analyzedElements = [];
    
    $(document).ready(function() {
        // Analyze page button
        $('#analyzePageBtn').on('click', function() {
            analyzePage();
        });
        
        // Save all customizations
        $('#saveAllCustomizations').on('click', function() {
            saveAllCustomizations();
        });
        
        // Delete customization
        $('.delete-customization').on('click', function() {
            const id = $(this).data('id');
            deleteCustomization(id);
        });
        
        // Visibility toggle
        $('.visibility-toggle').on('change', function() {
            const id = $(this).data('id');
            const isVisible = $(this).is(':checked');
            updateVisibility(id, isVisible);
        });
    });
    
    function analyzePage() {
        // Show loading
        $('#analyzePageBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Analyzing...');
        
        // Call real page analysis API
        $.ajax({
            url: '{{ route("page-customization.analyze") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                menu_name: menuName,
                menu_url: menuUrl
            },
            success: function(response) {
                if (response.success) {
                    displayAnalysisResults(response.data);
                    $('#analysisResults').show();
                } else {
                    alert('Error analyzing page: ' + response.message);
                }
            },
            error: function(xhr) {
                console.error('Analysis error:', xhr);
                alert('Error analyzing page: ' + (xhr.responseJSON?.message || 'Unknown error'));
            },
            complete: function() {
                $('#analyzePageBtn').prop('disabled', false).html('<i class="fas fa-search-plus mr-2"></i>Analyze Page & Fetch Technical Details');
            }
        });
    }
    
    function generateMockAnalysis() {
        // This is a mock function - in production, this would analyze the actual page
        return {
            tables: [
                { name: 'Leads Table', id: 'leads-table', columns: ['ID', 'Name', 'Email', 'Phone', 'Status', 'Priority', 'Actions'] },
                { name: 'Users Table', id: 'users-table', columns: ['ID', 'Name', 'Email', 'Role', 'Department', 'Status'] }
            ],
            columns: [
                { name: 'ID', table: 'leads-table', type: 'number' },
                { name: 'Name', table: 'leads-table', type: 'text' },
                { name: 'Email', table: 'leads-table', type: 'email' },
                { name: 'Phone', table: 'leads-table', type: 'text' },
                { name: 'Status', table: 'leads-table', type: 'dropdown' },
                { name: 'Priority', table: 'leads-table', type: 'dropdown' }
            ],
            buttons: [
                { name: 'Add Lead', id: 'add-lead-btn', type: 'primary', purpose: 'Create' },
                { name: 'Upload Excel', id: 'upload-btn', type: 'warning', purpose: 'Import' },
                { name: 'Download Template', id: 'download-btn', type: 'info', purpose: 'Export' },
                { name: 'Save Permissions', id: 'save-btn', type: 'success', purpose: 'Save' },
                { name: 'Edit', id: 'edit-btn', type: 'primary', purpose: 'Edit' },
                { name: 'Delete', id: 'delete-btn', type: 'danger', purpose: 'Delete' },
                { name: 'Submit', id: 'submit-btn', type: 'primary', purpose: 'Submit' },
                { name: 'Cancel', id: 'cancel-btn', type: 'secondary', purpose: 'Cancel' },
                { name: 'Search', id: 'search-btn', type: 'info', purpose: 'Search' },
                { name: 'Filter', id: 'filter-btn', type: 'warning', purpose: 'Filter' }
            ],
            forms: [
                { name: 'Lead Form', id: 'lead-form', fields: ['Name', 'Email', 'Phone', 'Company', 'Status'] },
                { name: 'Permission Form', id: 'permission-form', fields: ['Role', 'Menu', 'Visible'] },
                { name: 'Search Form', id: 'search-form', fields: ['Query', 'Date Range'] }
            ],
            fields: [
                { name: 'Select Role', id: 'role-select', type: 'dropdown', required: true },
                { name: 'Menu Name', id: 'menu-name', type: 'text', required: false },
                { name: 'Visible', id: 'visible-check', type: 'checkbox', required: false },
                { name: 'Email', id: 'email-field', type: 'email', required: true },
                { name: 'Phone', id: 'phone-field', type: 'tel', required: false },
                { name: 'Description', id: 'description-field', type: 'textarea', required: false },
                { name: 'Date', id: 'date-field', type: 'date', required: false }
            ],
            links: [
                { name: 'Dashboard', id: 'dashboard-link', href: '/admin/dashboard' },
                { name: 'View Details', id: 'view-details-link', href: '#' },
                { name: 'Edit Profile', id: 'edit-profile-link', href: '/admin/profile/edit' },
                { name: 'Logout', id: 'logout-link', href: '/admin/logout' },
                { name: 'Help', id: 'help-link', href: '/help' }
            ],
            images: [
                { name: 'Logo', id: 'main-logo', src: '/images/logo.png' },
                { name: 'User Avatar', id: 'user-avatar', src: '/images/avatar.jpg' },
                { name: 'Banner', id: 'page-banner', src: '/images/banner.jpg' },
                { name: 'Icon', id: 'settings-icon', src: '/images/settings.png' }
            ],
            text: [
                { name: 'Page Title', id: 'page-title', content: 'Page Title' },
                { name: 'Header Text', id: 'header-text', content: 'Welcome to Dashboard' },
                { name: 'Footer Text', id: 'footer-text', content: '© 2024 Company' },
                { name: 'Instructions', id: 'instructions', content: 'Please fill the form' },
                { name: 'Error Message', id: 'error-message', content: 'Error occurred' }
            ],
            containers: [
                { name: 'Main Container', id: 'main-container', class: 'container' },
                { name: 'Sidebar', id: 'sidebar', class: 'sidebar' },
                { name: 'Content Area', id: 'content-area', class: 'content' },
                { name: 'Header', id: 'page-header', class: 'header' },
                { name: 'Footer', id: 'page-footer', class: 'footer' }
            ],
            cards: [
                { name: 'Info Card', id: 'info-card', class: 'card-info' },
                { name: 'Stats Card', id: 'stats-card', class: 'card-stats' },
                { name: 'User Card', id: 'user-card', class: 'card-user' },
                { name: 'Settings Card', id: 'settings-card', class: 'card-settings' }
            ],
            navigation: [
                { name: 'Main Menu', id: 'main-menu', type: 'navbar' },
                { name: 'Breadcrumb', id: 'breadcrumb', type: 'breadcrumb' },
                { name: 'Pagination', id: 'pagination', type: 'pagination' },
                { name: 'Tab Navigation', id: 'tab-nav', type: 'tabs' },
                { name: 'Sidebar Menu', id: 'sidebar-menu', type: 'sidebar' }
            ]
        };
    }
    
    function displayAnalysisResults(analysis) {
        // Display Tables
        $('#tableCount').text(analysis.tables.length);
        let tablesHtml = '';
        analysis.tables.forEach((table, idx) => {
            const elementId = `table_${idx}`;
            tablesHtml += createElementCard('table', table.name, table.id, elementId, {
                'Columns': table.columns.length,
                'Column Names': table.columns.join(', ')
            });
            
            // Add to analyzed elements
            analyzedElements.push({
                type: 'table',
                name: table.name,
                identifier: table.id,
                visible: true,
                metadata: { columns: table.columns }
            });
        });
        $('#tablesList').html(tablesHtml);
        
        // Display Columns
        $('#columnCount').text(analysis.columns.length);
        let columnsHtml = '';
        analysis.columns.forEach((col, idx) => {
            const elementId = `column_${idx}`;
            columnsHtml += createElementCard('column', col.name, `${col.table}.${col.name}`, elementId, {
                'Table': col.table,
                'Type': col.type
            });
            
            analyzedElements.push({
                type: 'column',
                name: col.name,
                identifier: `${col.table}.${col.name}`,
                visible: true,
                metadata: { table: col.table, type: col.type }
            });
        });
        $('#columnsList').html(columnsHtml);
        
        // Display Buttons
        $('#buttonCount').text(analysis.buttons.length);
        let buttonsHtml = '';
        analysis.buttons.forEach((btn, idx) => {
            const elementId = `button_${idx}`;
            buttonsHtml += createElementCard('button', btn.name, btn.id, elementId, {
                'Type': btn.type,
                'Purpose': btn.purpose
            });
            
            analyzedElements.push({
                type: 'button',
                name: btn.name,
                identifier: btn.id,
                visible: true,
                metadata: { buttonType: btn.type, purpose: btn.purpose }
            });
        });
        $('#buttonsList').html(buttonsHtml);
        
        // Display Forms
        $('#formCount').text(analysis.forms.length);
        let formsHtml = '';
        analysis.forms.forEach((form, idx) => {
            const elementId = `form_${idx}`;
            formsHtml += createElementCard('form', form.name, form.id, elementId, {
                'Fields': form.fields.length,
                'Field Names': form.fields.join(', ')
            });
            
            analyzedElements.push({
                type: 'form',
                name: form.name,
                identifier: form.id,
                visible: true,
                metadata: { fields: form.fields }
            });
        });
        $('#formsList').html(formsHtml);
        
        // Display Fields
        $('#fieldCount').text(analysis.fields.length);
        let fieldsHtml = '';
        analysis.fields.forEach((field, idx) => {
            const elementId = `field_${idx}`;
            fieldsHtml += createElementCard('field', field.name, field.id, elementId, {
                'Type': field.type,
                'Required': field.required ? 'Yes' : 'No'
            });
            
            analyzedElements.push({
                type: 'field',
                name: field.name,
                identifier: field.id,
                visible: true,
                metadata: { fieldType: field.type, required: field.required }
            });
        });
        $('#fieldsList').html(fieldsHtml);
        
        // Display Links
        $('#linkCount').text(analysis.links.length);
        let linksHtml = '';
        analysis.links.forEach((link, idx) => {
            const elementId = `link_${idx}`;
            linksHtml += createElementCard('link', link.name, link.id, elementId, {
                'URL': link.href,
                'Type': 'Hyperlink'
            });
            
            analyzedElements.push({
                type: 'link',
                name: link.name,
                identifier: link.id,
                visible: true,
                metadata: { href: link.href }
            });
        });
        $('#linksList').html(linksHtml);
        
        // Display Images
        $('#imageCount').text(analysis.images.length);
        let imagesHtml = '';
        analysis.images.forEach((image, idx) => {
            const elementId = `image_${idx}`;
            imagesHtml += createElementCard('image', image.name, image.id, elementId, {
                'Source': image.src,
                'Type': 'Image'
            });
            
            analyzedElements.push({
                type: 'image',
                name: image.name,
                identifier: image.id,
                visible: true,
                metadata: { src: image.src }
            });
        });
        $('#imagesList').html(imagesHtml);
        
        // Display Text Elements
        $('#textCount').text(analysis.text.length);
        let textHtml = '';
        analysis.text.forEach((text, idx) => {
            const elementId = `text_${idx}`;
            textHtml += createElementCard('text', text.name, text.id, elementId, {
                'Content': text.content,
                'Type': 'Text'
            });
            
            analyzedElements.push({
                type: 'text',
                name: text.name,
                identifier: text.id,
                visible: true,
                metadata: { content: text.content }
            });
        });
        $('#textList').html(textHtml);
        
        // Display Containers
        $('#containerCount').text(analysis.containers.length);
        let containersHtml = '';
        analysis.containers.forEach((container, idx) => {
            const elementId = `container_${idx}`;
            containersHtml += createElementCard('container', container.name, container.id, elementId, {
                'Class': container.class,
                'Type': 'Container'
            });
            
            analyzedElements.push({
                type: 'container',
                name: container.name,
                identifier: container.id,
                visible: true,
                metadata: { class: container.class }
            });
        });
        $('#containersList').html(containersHtml);
        
        // Display Cards
        $('#cardCount').text(analysis.cards.length);
        let cardsHtml = '';
        analysis.cards.forEach((card, idx) => {
            const elementId = `card_${idx}`;
            cardsHtml += createElementCard('card', card.name, card.id, elementId, {
                'Class': card.class,
                'Type': 'Card'
            });
            
            analyzedElements.push({
                type: 'card',
                name: card.name,
                identifier: card.id,
                visible: true,
                metadata: { class: card.class }
            });
        });
        $('#cardsList').html(cardsHtml);
        
        // Display Navigation
        $('#navigationCount').text(analysis.navigation.length);
        let navigationHtml = '';
        analysis.navigation.forEach((nav, idx) => {
            const elementId = `navigation_${idx}`;
            navigationHtml += createElementCard('navigation', nav.name, nav.id, elementId, {
                'Type': nav.type,
                'Navigation': 'Yes'
            });
            
            analyzedElements.push({
                type: 'navigation',
                name: nav.name,
                identifier: nav.id,
                visible: true,
                metadata: { navType: nav.type }
            });
        });
        $('#navigationList').html(navigationHtml);
        
        // Bind visibility toggle events
        bindVisibilityToggles();
    }
    
        
    function createElementCard(type, name, identifier, elementId, metadata) {
        const badgeClass = `badge-${type}`;
        let metadataHtml = '';
        
        for (const [key, value] of Object.entries(metadata)) {
            metadataHtml += `<span class="badge badge-light mr-2">${key}: ${value}</span>`;
        }
        
        return `
            <div class="technical-detail-card" id="${elementId}">
                <div class="element-header">
                    <div class="element-info">
                        <span class="element-type-badge ${badgeClass}">${type}</span>
                        <strong>${name}</strong>
                    </div>
                    <div class="visibility-toggle-wrapper">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input element-visibility" 
                                   id="${elementId}_toggle" checked data-element-id="${elementId}" data-element-type="${type}">
                            <label class="custom-control-label" for="${elementId}_toggle">Show</label>
                        </div>
                    </div>
                </div>
                <div class="element-metadata">
                    <code>ID: ${identifier}</code><br>
                    ${metadataHtml}
                </div>
            </div>
        `;
    }
    
    function bindVisibilityToggles() {
        $('.element-visibility').on('change', function() {
            const elementId = $(this).data('element-id');
            const elementType = $(this).data('element-type');
            const isVisible = $(this).is(':checked');
            
            // Update the label
            $(this).siblings('label').text(isVisible ? 'Show' : 'Hide');
            
            // Update the element in analyzedElements array
            const element = analyzedElements.find(e => `element_${analyzedElements.indexOf(e)}` === elementId);
            if (element) {
                element.visible = isVisible;
            }
            
            // Get element name from the UI instead of analyzedElements
            const elementName = $(this).closest('.technical-detail-card').find('strong').text() || '';
            
            // Automatically save to database via AJAX
            $.ajax({
                url: '{{ route("page-customization.update-single") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    menu_name: menuName,
                    menu_url: menuUrl,
                    role_id: roleId,
                    employee_id: employeeId,
                    element_identifier: elementId,
                    element_type: elementType,
                    element_name: elementName,
                    is_visible: isVisible ? 1 : 0
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        const toast = $('<div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;">' +
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '<strong>Success!</strong> ' + response.message +
                        '</div>');
                        $('body').append(toast);
                        setTimeout(() => toast.fadeOut(() => toast.remove()), 3000);
                    }
                },
                error: function(xhr) {
                    // Show error message
                    const toast = $('<div class="alert alert-danger alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;">' +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<strong>Error!</strong> Failed to update visibility' +
                    '</div>');
                    $('body').append(toast);
                    setTimeout(() => toast.fadeOut(() => toast.remove()), 3000);
                    
                    console.error('Update error:', xhr);
                }
            });
        });
    }
    
    function saveAllCustomizations() {
        // Get all current checkbox states from the UI
        const allCheckboxes = $('.element-visibility');
        
        if (allCheckboxes.length === 0) {
            alert('No elements found to save. Please analyze the page first to fetch technical details.');
            return;
        }
        
        $('#saveAllCustomizations').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');
        
        // Build elements array from current UI state
        const currentElements = [];
        allCheckboxes.each(function() {
            const checkbox = $(this);
            const elementId = checkbox.data('element-id');
            const elementType = checkbox.data('element-type');
            const isVisible = checkbox.is(':checked');
            const elementName = checkbox.closest('.technical-detail-card').find('strong').text();
            
            currentElements.push({
                type: elementType,
                name: elementName,
                identifier: elementId,
                visible: isVisible
            });
        });
        
        const payload = {
            _token: '{{ csrf_token() }}',
            menu_name: menuName,
            menu_url: menuUrl,
            role_id: roleId,
            employee_id: employeeId,
            elements: currentElements
        };
        
        $.ajax({
            url: '{{ route("page-customization.store") }}',
            method: 'POST',
            data: payload,
            success: function(response) {
                if (response.success) {
                    alert('Customizations saved successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Error saving customizations: ' + (xhr.responseJSON?.message || 'Unknown error'));
            },
            complete: function() {
                $('#saveAllCustomizations').prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Save All Changes');
            }
        });
    }
    
    function updateVisibility(id, isVisible) {
        $.ajax({
            url: '{{ route("page-customization.batch-update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                items: [{
                    id: id,
                    is_visible: isVisible
                }]
            },
            success: function(response) {
                if (response.success) {
                    console.log('Visibility updated successfully');
                }
            },
            error: function(xhr) {
                console.error('Error updating visibility:', xhr);
            }
        });
    }
    
    function deleteCustomization(id) {
        if (!confirm('Are you sure you want to delete this customization?')) {
            return;
        }
        
        $.ajax({
            url: '{{ route("page-customization.destroy", "") }}/' + id,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $(`tr[data-customization-id="${id}"]`).fadeOut(function() {
                        $(this).remove();
                    });
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Error deleting customization: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    }
</script>
@endpush
