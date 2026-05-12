<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Customer Portal') - Niranjan Enterprises</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --light-bg: #f8fafc;
            --white: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--light-bg);
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Customer Header */
        .customer-header {
            background: var(--white);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .customer-navbar {
            padding: 1rem 0;
        }

        .customer-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-primary);
        }

        .customer-brand img {
            height: 40px;
            margin-right: 12px;
        }

        .customer-brand h4 {
            margin: 0;
            font-weight: 700;
            color: var(--primary-color);
        }

        .customer-brand small {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        /* Customer Sidebar */
        .customer-sidebar {
            position: fixed;
            top: 73px;
            left: 0;
            width: 280px;
            height: calc(100vh - 73px);
            background: var(--white);
            border-right: 1px solid var(--border-color);
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 999;
        }

        .customer-sidebar.collapsed {
            transform: translateX(-100%);
        }

        .customer-sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .customer-user-info {
            text-align: center;
        }

        .customer-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: var(--white);
            font-size: 1.5rem;
            font-weight: 600;
        }

        .customer-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .customer-email {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        /* Customer Menu */
        .customer-menu {
            padding: 1rem 0;
        }

        .customer-menu-item {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: var(--text-primary);
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            margin: 0.25rem 0;
        }

        .customer-menu-item:hover {
            background: rgba(37, 99, 235, 0.05);
            border-left-color: var(--primary-color);
            color: var(--primary-color);
        }

        .customer-menu-item.active {
            background: rgba(37, 99, 235, 0.1);
            border-left-color: var(--primary-color);
            color: var(--primary-color);
            font-weight: 500;
        }

        .customer-menu-item i {
            width: 20px;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* Customer Dropdown */
        .customer-dropdown {
            position: relative;
        }

        .customer-dropdown-menu {
            display: none;
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            margin-left: 1rem;
        }

        .customer-dropdown.show .customer-dropdown-menu {
            display: block;
        }

        .customer-dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .customer-dropdown-item:hover {
            background: var(--light-bg);
            color: var(--primary-color);
        }

        .customer-dropdown-item i {
            width: 16px;
            margin-right: 8px;
            font-size: 0.9rem;
        }

        .customer-dropdown-header {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: var(--light-bg);
        }

        /* Main Content */
        .customer-main {
            margin-left: 280px;
            min-height: calc(100vh - 73px);
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }

        .customer-main.expanded {
            margin-left: 0;
        }

        /* Customer Cards */
        .customer-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .customer-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .customer-card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            color: var(--white);
            border-radius: 12px 12px 0 0;
        }

        .customer-card-body {
            padding: 1.5rem;
        }

        /* Stats Cards */
        .customer-stat-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.2s ease;
        }

        .customer-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .customer-stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: var(--white);
        }

        .customer-stat-icon.primary {
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
        }

        .customer-stat-icon.success {
            background: linear-gradient(135deg, var(--success-color), #059669);
        }

        .customer-stat-icon.warning {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
        }

        .customer-stat-icon.info {
            background: linear-gradient(135deg, var(--info-color), #2563eb);
        }

        .customer-stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .customer-stat-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Mobile Menu Toggle */
        .customer-menu-toggle {
            display: none;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .customer-sidebar {
                transform: translateX(-100%);
            }
            
            .customer-sidebar.active {
                transform: translateX(0);
            }
            
            .customer-main {
                margin-left: 0;
                padding: 1rem;
            }
            
            .customer-menu-toggle {
                display: block;
            }
        }

        /* Company Cards */
        .company-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .company-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .company-card-header {
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            color: var(--white);
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .company-card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }

        .company-card-body {
            padding: 1.5rem;
        }

        .company-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .company-stat {
            text-align: center;
            padding: 1rem;
            background: var(--light-bg);
            border-radius: 12px;
        }

        .company-stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .company-stat-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body>
    <!-- Customer Header -->
    <header class="customer-header">
        <div class="container-fluid">
            <nav class="customer-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="customer-menu-toggle me-3" id="mobileMenuToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        <a href="{{ route('invoices.index') }}" class="customer-brand">
                            <img src="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp" alt="Niranjan Enterprises">
                            <div>
                                <h4>Customer Portal</h4>
                                <small>Niranjan Enterprises</small>
                            </div>
                        </a>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>{{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Customer Sidebar -->
    <aside class="customer-sidebar" id="customerSidebar">
        <div class="customer-sidebar-header">
            <div class="customer-user-info">
                <div class="customer-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="customer-name">{{ auth()->user()->name }}</div>
                <div class="customer-email">{{ auth()->user()->email }}</div>
            </div>
        </div>
        
        <nav class="customer-menu">
            <!-- My Companies Dropdown -->
            <div class="customer-dropdown" id="companiesDropdown">
                <a href="#" class="customer-menu-item dropdown-toggle" onclick="toggleDropdown('companiesDropdown')">
                    <i class="fas fa-building"></i>
                    <span>My Companies</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="customer-dropdown-menu">
                    <a href="{{ route('customer.companies.index') }}" class="customer-dropdown-item">
                        <i class="fas fa-list"></i>
                        <span>All Companies</span>
                    </a>
                    @php
                        $customerEmail = auth()->user()->email;
                        $customerCompanies = \App\Models\Quotation::where('client_email', $customerEmail)
                            ->where('customer_panel', true)
                            ->get()
                            ->unique('client_business_name')
                            ->take(5);
                    @endphp
                    @if($customerCompanies->isNotEmpty())
                        <div class="customer-dropdown-header">Quick Access</div>
                        @foreach($customerCompanies as $company)
                            <a href="{{ route('customer.companies.show', $company->client_business_name) }}" class="customer-dropdown-item">
                                <i class="fas fa-building-user"></i>
                                <span>{{ $company->client_business_name }}</span>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Other Menu Items -->
            <a href="{{ route('customer.companies.index') }}" class="customer-menu-item {{ request()->routeIs('customer.companies.*') ? 'active' : '' }}">
                <i class="fas fa-dashboard"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="#" class="customer-menu-item">
                <i class="fas fa-file-invoice"></i>
                <span>Invoices</span>
            </a>
            
            <a href="#" class="customer-menu-item">
                <i class="fas fa-project-diagram"></i>
                <span>Projects</span>
            </a>
            
            <a href="#" class="customer-menu-item">
                <i class="fas fa-chart-line"></i>
                <span>Reports</span>
            </a>
            
            <a href="#" class="customer-menu-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="customer-main" id="customerMain">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    
    <script>
        // Mobile Menu Toggle
        document.getElementById('mobileMenuToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('customerSidebar');
            const main = document.getElementById('customerMain');
            
            sidebar.classList.toggle('active');
            main.classList.toggle('expanded');
        });

        // Dropdown Toggle
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const allDropdowns = document.querySelectorAll('.customer-dropdown');
            
            // Close other dropdowns
            allDropdowns.forEach(d => {
                if (d.id !== dropdownId) {
                    d.classList.remove('show');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('show');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.customer-dropdown')) {
                document.querySelectorAll('.customer-dropdown').forEach(d => {
                    d.classList.remove('show');
                });
            }
        });

        // Initialize tooltips and dropdowns
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            // Handle dropdown clicks with jQuery
            $('.customer-dropdown .dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                const dropdownId = $(this).closest('.customer-dropdown').attr('id');
                toggleDropdown(dropdownId);
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>
