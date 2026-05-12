@php
$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();
$userRole = auth()->user()->role ?? 'not_logged_in';
$userName = auth()->user()->name ?? 'not_logged_in';
@endphp

@auth
    <!-- Admin Menu -->
    @if ((auth()->user()->role == 1) || (auth()->user()->role == 5))
        @if(true) <!-- Dashboard to History Menu Hidden -->
        <a href="{{ url('admin/dashboard') }}" class="menu-item {{ ($route == 'dashboard')? 'active':'' }}">
            <i class="fas fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>
        
        <!-- Leads Generation Menu -->
        <a href="{{ route('leads.index') }}" class="menu-item {{ ($route == 'leads.index' || strpos($route, 'leads.') === 0)? 'active':'' }}">
            <i class="fas fa-chart-line"></i>
            <span>Leads Generation</span>
        </a>
        @endif
        
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
        
        <a href="{{ route('approval-status.index') }}" class="menu-item {{ ($prefix == '/approval-status')?'active':'' }}">
            <i class="fas fa-check-circle"></i>
            <span>Approval Status</span>
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
        
        <!-- Leads Generation Menu -->
        <a href="{{ route('leads.index') }}" class="menu-item {{ ($route == 'leads.index' || strpos($route, 'leads.') === 0)? 'active':'' }}">
            <i class="fas fa-chart-line"></i>
            <span>Leads Generation</span>
        </a>
        
        <a href="{{ route('project-updates.index') }}" class="menu-item {{ ($prefix == '/project-updates')?'active':'' }}">
            <i class="fas fa-project-diagram"></i>
            <span>Project Updates</span>
        </a>
        
        <a href="{{ route('approval-status.index') }}" class="menu-item {{ ($prefix == '/approval-status')?'active':'' }}">
            <i class="fas fa-check-circle"></i>
            <span>Approval Status</span>
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
        
        <!-- Leads Generation Menu -->
        <a href="{{ route('leads.index') }}" class="menu-item {{ ($route == 'leads.index' || strpos($route, 'leads.') === 0)? 'active':'' }}">
            <i class="fas fa-chart-line"></i>
            <span>Leads Generation</span>
        </a>
        
        <a href="{{ route('invoices.index') }}" class="menu-item {{ ($prefix == '/invoices')?'active':'' }}">
            <i class="fas fa-file-invoice"></i>
            <span>Invoices</span>
        </a>
        
        <a href="{{ route('project-updates.index') }}" class="menu-item {{ ($prefix == '/project-updates')?'active':'' }}">
            <i class="fas fa-project-diagram"></i>
            <span>Project Updates</span>
        </a>
        
        <a href="{{ route('approval-status.index') }}" class="menu-item {{ ($prefix == '/approval-status')?'active':'' }}">
            <i class="fas fa-check-circle"></i>
            <span>Approval Status</span>
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
        
        <!-- Leads Generation Menu -->
        <a href="{{ route('leads.index') }}" class="menu-item {{ ($route == 'leads.index' || strpos($route, 'leads.') === 0)? 'active':'' }}">
            <i class="fas fa-chart-line"></i>
            <span>Leads Generation</span>
        </a>
        
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
