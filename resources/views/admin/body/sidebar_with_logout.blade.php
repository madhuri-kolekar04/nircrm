@php
$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();
@endphp

@auth
    <!-- Admin Menu -->
    @if ((auth()->user()->role == 1) || (auth()->user()->role == 5))
        @if(false) <!-- Dashboard to History Menu Hidden -->
        <a href="{{ url('admin/dashboard') }}" class="menu-item {{ ($route == 'dashboard')? 'active':'' }}">
            <i class="fas fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>
        
        <!-- Project Menu Dropdown -->
        <div class="menu-item menu-header" onclick="toggleDropdown('project-dropdown')">
            <i class="fas fa-ticket"></i>
            <span>Project Menu</span>
            <i class="fas fa-chevron-down dropdown-arrow"></i>
        </div>
        
        <div class="dropdown-menu" id="project-dropdown">
            <a href="{{ route('add-product') }}" class="menu-item {{ ($route == 'add-product')? 'active':'' }}" style="font-size: 0.9rem; padding: 0.75rem 1.5rem; margin-left: 1rem;">
                <i class="fas fa-plus" style="width: 16px; margin-right: 8px;"></i>
                <span>Create Project</span>
            </a>
            <a href="{{ route('manage-product') }}" class="menu-item {{ ($route == 'manage-product')? 'active':'' }}" style="font-size: 0.9rem; padding: 0.75rem 1.5rem; margin-left: 1rem;">
                <i class="fas fa-list" style="width: 16px; margin-right: 8px;"></i>
                <span>Manage Projects</span>
            </a>
        </div>
        
        <!-- Customer Menu Dropdown -->
        <div class="menu-item menu-header" onclick="toggleDropdown('customer-dropdown')">
            <i class="fas fa-users"></i>
            <span>Customer Menu</span>
            <i class="fas fa-chevron-down dropdown-arrow"></i>
        </div>
        
        <div class="dropdown-menu" id="customer-dropdown">
            <a href="{{ route('all.reminder') }}" class="menu-item {{ ($route == 'all.reminder')? 'active':'' }}" style="font-size: 0.9rem; padding: 0.75rem 1.5rem; margin-left: 1rem;">
                <i class="fas fa-user-plus" style="width: 16px; margin-right: 8px;"></i>
                <span>Add Customer</span>
            </a>
            <a href="{{ route('all.customer') }}" class="menu-item {{ ($route == 'all.customer')? 'active':'' }}" style="font-size: 0.9rem; padding: 0.75rem 1.5rem; margin-left: 1rem;">
                <i class="fas fa-users" style="width: 16px; margin-right: 8px;"></i>
                <span>Manage Customers</span>
            </a>
            <a href="{{ route('invoices.index') }}" class="menu-item {{ ($prefix == '/invoices')?'active':'' }}" style="font-size: 0.9rem; padding: 0.75rem 1.5rem; margin-left: 1rem;">
                <i class="fas fa-file-invoice" style="width: 16px; margin-right: 8px;"></i>
                <span>My Invoices</span>
            </a>
        </div>
        
        <!-- Employee Menu Dropdown -->
        <div class="menu-item menu-header" onclick="toggleDropdown('employee-dropdown')">
            <i class="fas fa-user-tie"></i>
            <span>Employee Menu</span>
            <i class="fas fa-chevron-down dropdown-arrow"></i>
        </div>
        
        <div class="dropdown-menu" id="employee-dropdown">
            <a href="{{ route('all.ITEmployee') }}" class="menu-item {{ ($route == 'all.ITEmployee')? 'active':'' }}" style="font-size: 0.9rem; padding: 0.75rem 1.5rem; margin-left: 1rem;">
                <i class="fas fa-user-plus" style="width: 16px; margin-right: 8px;"></i>
                <span>Add Employee</span>
            </a>
            <a href="{{ route('all.ITEmployee') }}" class="menu-item {{ ($route == 'all.ITEmployee')? 'active':'' }}" style="font-size: 0.9rem; padding: 0.75rem 1.5rem; margin-left: 1rem;">
                <i class="fas fa-users" style="width: 16px; margin-right: 8px;"></i>
                <span>Manage Employees</span>
            </a>
        </div>
        
        <!-- Department Menu Dropdown -->
        <div class="menu-item menu-header" onclick="toggleDropdown('department-dropdown')">
            <i class="fas fa-building"></i>
            <span>Department Menu</span>
            <i class="fas fa-chevron-down dropdown-arrow"></i>
        </div>
        
        <div class="dropdown-menu" id="department-dropdown">
            <a href="{{ route('all.Department') }}" class="menu-item {{ ($route == 'all.Department')? 'active':'' }}" style="font-size: 0.9rem; padding: 0.75rem 1.5rem; margin-left: 1rem;">
                <i class="fas fa-plus" style="width: 16px; margin-right: 8px;"></i>
                <span>Add Department</span>
            </a>
            <a href="{{ route('all.category') }}#" class="menu-item {{ ($prefix == '/category')?'active':'' }}" style="font-size: 0.9rem; padding: 0.75rem 1.5rem; margin-left: 1rem;">
                <i class="fas fa-list" style="width: 16px; margin-right: 8px;"></i>
                <span>Manage Departments</span>
            </a>
        </div>
        
        <!-- History Menu Dropdown -->
        <div class="menu-item menu-header" onclick="toggleDropdown('history-dropdown')">
            <i class="fas fa-history"></i>
            <span>History Menu</span>
            <i class="fas fa-chevron-down dropdown-arrow"></i>
        </div>
        
        <div class="dropdown-menu" id="history-dropdown">
            <a href="{{ route('manage-product') }}" class="menu-item {{ ($route == 'manage-product')? 'active':'' }}" style="font-size: 0.9rem; padding: 0.75rem 1.5rem; margin-left: 1rem;">
                <i class="fas fa-clock" style="width: 16px; margin-right: 8px;"></i>
                <span>Project History</span>
            </a>
            <a href="#" class="menu-item" style="font-size: 0.9rem; padding: 0.75rem 1.5rem; margin-left: 1rem;">
                <i class="fas fa-user-clock" style="width: 16px; margin-right: 8px;"></i>
                <span>Employee History</span>
            </a>
            <a href="#" class="menu-item" style="font-size: 0.9rem; padding: 0.75rem 1.5rem; margin-left: 1rem;">
                <i class="fas fa-chart-line" style="width: 16px; margin-right: 8px;"></i>
                <span>Activity History</span>
            </a>
        </div>
        
        <!-- Additional Admin Options -->
        <a href="{{ route('all.category') }}" class="menu-item {{ ($prefix == '/category')?'active':'' }}">
            <i class="fas fa-layer-group"></i>
            <span>Categories</span>
        </a>
        
        <a href="{{ route('employees.index') }}" class="menu-item {{ ($prefix == '/employees')?'active':'' }}">
            <i class="fas fa-user-tie"></i>
            <span>Employees</span>
        </a>
        
        <a href="{{ route('customers.index') }}" class="menu-item {{ ($prefix == '/customers')?'active':'' }}">
            <i class="fas fa-users"></i>
            <span>Customers</span>
        </a>
        
        <a href="{{ route('invoices.index') }}" class="menu-item {{ ($prefix == '/invoices')?'active':'' }}">
            <i class="fas fa-file-invoice"></i>
            <span>Invoices</span>
        </a>
        
        <a href="{{ route('project-updates.index') }}" class="menu-item {{ ($prefix == '/project-updates')?'active':'' }}">
            <i class="fas fa-project-diagram"></i>
            <span>Project Updates</span>
        </a>
        
        <!-- Logout Menu Item -->
        <a href="#" onclick="document.getElementById('logoutForm').submit(); return false;" class="menu-item logout-menu-item" style="color: #dc3545 !important; border-left-color: #dc3544 !important; background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%) !important; margin-top: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1rem;">
            <i class="fas fa-sign-out-alt" style="color: #dc3544 !important;"></i>
            <span>Logout</span>
        </a>
    @endif

    <!-- Employee Menu -->
    @if ((auth()->user()->role == 2))
        @if(false) <!-- Dashboard and My Projects Menu Hidden -->
        <a href="{{ route('manage-product') }}" class="menu-item {{ ($route == 'manage-product')? 'active':'' }}">
            <i class="fas fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('manage-product') }}" class="menu-item {{ ($route == 'manage-product')? 'active':'' }}">
            <i class="fas fa-ticket"></i>
            <span>My Projects</span>
        </a>
        @endif
        
        <a href="{{ route('invoices.index') }}" class="menu-item {{ ($prefix == '/invoices')?'active':'' }}">
            <i class="fas fa-file-invoice"></i>
            <span>My Invoices</span>
        </a>
        
        @if ((auth()->user()->employeeID == "admin"))
            <a href="{{ route('add-product') }}" class="menu-item {{ ($route == 'add-product')? 'active':'' }}">
                <i class="fas fa-plus"></i>
                <span>Create Project</span>
            </a>
        @endif
        
        <a href="{{ route('project-updates.index') }}" class="menu-item {{ ($prefix == '/project-updates')?'active':'' }}">
            <i class="fas fa-project-diagram"></i>
            <span>Project Updates</span>
        </a>
        
        <!-- Logout Menu Item -->
        <a href="#" onclick="document.getElementById('logoutForm').submit(); return false;" class="menu-item logout-menu-item" style="color: #dc3545 !important; border-left-color: #dc3544 !important; background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%) !important; margin-top: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1rem;">
            <i class="fas fa-sign-out-alt" style="color: #dc3544 !important;"></i>
            <span>Logout</span>
        </a>
    @endif

    <!-- Manager Menu (for users with position 'Manager') -->
    @if ((auth()->user()->position == 'Manager'))
        <a href="{{ route('employees.index') }}" class="menu-item {{ ($prefix == '/employees')?'active':'' }}">
            <i class="fas fa-user-tie"></i>
            <span>Employee</span>
        </a>
        
        <a href="{{ route('invoices.index') }}" class="menu-item {{ ($prefix == '/invoices')?'active':'' }}">
            <i class="fas fa-file-invoice"></i>
            <span>Invoices</span>
        </a>
        
        <a href="{{ route('project-updates.index') }}" class="menu-item {{ ($prefix == '/project-updates')?'active':'' }}">
            <i class="fas fa-project-diagram"></i>
            <span>Project Updates</span>
        </a>
        
        <!-- Logout Menu Item -->
        <a href="#" onclick="document.getElementById('logoutForm').submit(); return false;" class="menu-item logout-menu-item" style="color: #dc3545 !important; border-left-color: #dc3544 !important; background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%) !important; margin-top: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1rem;">
            <i class="fas fa-sign-out-alt" style="color: #dc3544 !important;"></i>
            <span>Logout</span>
        </a>
    @endif

    <!-- Customer Menu -->
    @if ((auth()->user()->role == 3))
        @if(false) <!-- Dashboard to My Projects Menu Hidden -->
        <a href="{{ route('manage-product') }}" class="menu-item {{ ($route == 'manage-product')? 'active':'' }}">
            <i class="fas fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('add-productuser') }}" class="menu-item {{ ($route == 'add-productuser')? 'active':'' }}">
            <i class="fas fa-plus"></i>
            <span>Add Project</span>
        </a>
        
        <a href="{{ route('my-manage-product') }}" class="menu-item {{ ($route == 'my-manage-product')? 'active':'' }}">
            <i class="fas fa-list"></i>
            <span>My Projects</span>
        </a>
        @endif
        
        <a href="{{ route('invoices.index') }}" class="menu-item {{ ($prefix == '/invoices')?'active':'' }}">
            <i class="fas fa-file-invoice"></i>
            <span>My Invoices</span>
        </a>
        
        <a href="{{ route('project-updates.index') }}" class="menu-item {{ ($prefix == '/project-updates')?'active':'' }}">
            <i class="fas fa-project-diagram"></i>
            <span>Project Updates</span>
        </a>
        
        <!-- Logout Menu Item -->
        <a href="#" onclick="document.getElementById('logoutForm').submit(); return false;" class="menu-item logout-menu-item" style="color: #dc3545 !important; border-left-color: #dc3544 !important; background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%) !important; margin-top: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1rem;">
            <i class="fas fa-sign-out-alt" style="color: #dc3544 !important;"></i>
            <span>Logout</span>
        </a>
    @endif
@endauth
