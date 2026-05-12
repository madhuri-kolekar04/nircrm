<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Niranjan CRM') }}</title>
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .whatsapp-container {
            display: flex;
            height: 100vh;
            background: #f0f2f5;
        }
        
        .sidebar {
            width: 280px;
            background: #111b21;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 16px;
            background: #202c33;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
        }
        
        .menu-item {
            padding: 12px 20px;
            color: #e9edef;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        
        .menu-item:hover {
            background: #2a3942;
        }
        
        .menu-item.active {
            background: #2a3942;
            border-left: 3px solid #00a884;
        }
        
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #efeae2;
        }
        
        .main-header {
            background: white;
            padding: 16px 24px;
            border-bottom: 1px solid #e9edef;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .content-area {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
        }
        
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e9edef;
            font-weight: 600;
            color: #111b21;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 4px solid #00a884;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #111b21;
        }
        
        .stat-label {
            color: #667781;
            font-size: 0.875rem;
            margin-top: 4px;
        }
        
        .mobile-menu-toggle {
            display: none;
            background: #00a884;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -280px;
                z-index: 1000;
                height: 100vh;
            }
            
            .sidebar.open {
                left: 0;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .lead-item {
            background: white;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s;
        }
        
        .lead-item:hover {
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .user-dropdown {
            position: relative;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            min-width: 200px;
            z-index: 1000;
            display: none;
            margin-top: 8px;
        }
        
        .dropdown-menu.show {
            display: block;
        }
        
        .dropdown-item {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: background 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            color: #111b21;
            text-decoration: none;
        }
        
        .dropdown-item:hover {
            background: #f8f9fa;
        }
        
        .dropdown-item i {
            width: 16px;
            color: #667781;
        }
        
        .dropdown-divider {
            height: 1px;
            background: #e9edef;
            margin: 4px 0;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: white;
            border-radius: 8px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #e9edef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .form-group {
            margin-bottom: 16px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #111b21;
        }
        
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e9edef;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background: #00a884;
            color: white;
        }
        
        .btn-primary:hover {
            background: #008966;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #545b62;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
    </style>
</head>

<body>
    <div class="whatsapp-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-cube" style="font-size: 1.5rem;"></i>
                    <span style="font-weight: 600;">Niranjan CRM</span>
                </div>
                <button onclick="toggleSidebar()" style="background: none; border: none; color: white; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="sidebar-menu">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">>
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
                
                <!-- Departments -->
                @if(auth()->user()->role == 1 || auth()->user()->role == 5)
                <a href="{{ route('all.Department') }}" class="menu-item {{ request()->routeIs('all.Department') ? 'active' : '' }}">>
                    <i class="fas fa-building"></i>
                    <span>Departments</span>
                </a>
                @endif
                
                <!-- Users -->
                @if(in_array(auth()->user()->role, [1, 4, 5]) || in_array(auth()->user()->position, ['CEO', 'Admin', 'Manager']))
                <a href="{{ route('employees.index') }}" class="menu-item {{ request()->routeIs('employees.*') ? 'active' : '' }}">>
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
                @endif
                
                <!-- Leads -->
                <a href="{{ route('leads.index') }}" class="menu-item {{ request()->routeIs('leads.*') ? 'active' : '' }}">
                    <i class="fas fa-user-plus"></i>
                    <span>Leads</span>
                </a>
                
                <!-- Clients -->
                <a href="{{ route('customers.index') }}" class="menu-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                    <i class="fas fa-handshake"></i>
                    <span>Clients</span>
                </a>
                
                <!-- Tasks -->
                <a href="{{ route('all.Employee') }}" class="menu-item {{ request()->routeIs('all.Employee') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i>
                    <span>Tasks</span>
                </a>
                
                <!-- Reports -->
                @if(in_array(auth()->user()->role, [1, 4, 5]) || in_array(auth()->user()->position, ['CEO', 'Admin', 'Manager']))
                <a href="{{ route('project-updates.index') }}" class="menu-item {{ request()->routeIs('project-updates.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
                @endif
                
                <!-- Chat/Messages -->
                <a href="{{ route('leads.index') }}" class="menu-item {{ request()->routeIs('leads.*') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i>
                    <span>Messages</span>
                </a>
                
                <!-- Settings -->
                <a href="{{ route('profile.edit') }}" class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
                
                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" style="margin-top: auto;">
                    @csrf
                    <button type="submit" class="menu-item" style="color: #ff6b6b;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="main-header">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button class="mobile-menu-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 style="margin: 0; color: #111b21; font-size: 1.25rem; font-weight: 600;">
                        {{ isset($pageTitle) ? $pageTitle : 'Dashboard' }}
                    </h1>
                </div>
                
                <div style="display: flex; align-items: center; gap: 16px;">
                    <!-- Notifications -->
                    <div style="position: relative;">
                        <i class="fas fa-bell" style="color: #667781; cursor: pointer; font-size: 1.1rem;"></i>
                        <span style="position: absolute; top: -8px; right: -8px; background: #ff6b6b; color: white; border-radius: 50%; width: 16px; height: 16px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center;">3</span>
                    </div>
                    
                    <!-- Attendance Button -->
                    <a href="{{ route('attendance.dashboard') }}" class="btn btn-primary" style="background: #00a884; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-weight: 500; transition: all 0.2s;">
                        <i class="fas fa-clock"></i> ATTENDANCE
                    </a>
                    
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer; font-weight: 500; transition: all 0.2s; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                    
                    <!-- User Profile Dropdown -->
                    <div class="user-dropdown">
                        <div onclick="toggleUserDropdown()" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #00a884; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 500; color: #111b21;">{{ auth()->user()->name }}</div>
                                <div style="font-size: 0.75rem; color: #667781;">{{ ucfirst(auth()->user()->role) }}</div>
                            </div>
                            <i class="fas fa-chevron-down" style="color: #667781; font-size: 0.75rem;"></i>
                        </div>
                        
                        <div class="dropdown-menu" id="userDropdown">
                            <a href="#" onclick="openViewProfileModal()" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                View Profile
                            </a>
                            <a href="#" onclick="openEditProfileModal()" class="dropdown-item">
                                <i class="fas fa-edit"></i>
                                Edit Profile
                            </a>
                            <a href="#" onclick="openChangePasswordModal()" class="dropdown-item">
                                <i class="fas fa-lock"></i>
                                Change Password
                            </a>
                            <div class="dropdown-divider"></div>
                            @if(in_array(auth()->user()->role, [1, 4, 5]) || in_array(auth()->user()->position, ['CEO', 'Admin', 'Manager']))
                            <a href="{{ route('logs') }}" class="dropdown-item">
                                <i class="fas fa-history"></i>
                                Activity Logs
                            </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="dropdown-item" style="color: #ff6b6b;">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </div>
    
    <!-- View Profile Modal -->
    <div id="viewProfileModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="margin: 0; color: #111b21;">View Profile</h3>
                <button onclick="closeModal('viewProfileModal')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #667781;">&times;</button>
            </div>
            <div class="modal-body">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #00a884; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 2rem; margin: 0 auto;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" value="{{ ucfirst(auth()->user()->role) }}" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Position</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->position ?? 'N/A' }}" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Department</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->department->name ?? 'N/A' }}" readonly>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="margin: 0; color: #111b21;">Edit Profile</h3>
                <button onclick="closeModal('editProfileModal')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #667781;">&times;</button>
            </div>
            <form method="POST" action="{{ route('profile.update') }}" class="modal-body">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="tel" name="phone" class="form-control" value="{{ auth()->user()->phone ?? '' }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="3">{{ auth()->user()->address ?? '' }}</textarea>
                </div>
                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                    <button type="button" onclick="closeModal('editProfileModal')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Change Password Modal -->
    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="margin: 0; color: #111b21;">Change Password</h3>
                <button onclick="closeModal('changePasswordModal')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #667781;">&times;</button>
            </div>
            <form method="POST" action="{{ route('password.change') }}" class="modal-body">
                @csrf
                <div class="form-group">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" required minlength="8">
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required minlength="8">
                </div>
                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                    <button type="button" onclick="closeModal('changePasswordModal')" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }
        
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }
        
        function openViewProfileModal() {
            document.getElementById('viewProfileModal').classList.add('show');
            toggleUserDropdown();
        }
        
        function openEditProfileModal() {
            document.getElementById('editProfileModal').classList.add('show');
            toggleUserDropdown();
        }
        
        function openChangePasswordModal() {
            document.getElementById('changePasswordModal').classList.add('show');
            toggleUserDropdown();
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target) && 
                sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
            
            // Close dropdown when clicking outside
            const dropdown = document.getElementById('userDropdown');
            const dropdownToggle = document.querySelector('.user-dropdown > div:first-child');
            
            if (!dropdown.contains(event.target) && 
                !dropdownToggle.contains(event.target) && 
                dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });
        
        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('show');
            }
        });
    </script>
</body>
</html>
