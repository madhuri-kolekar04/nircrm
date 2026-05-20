<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(auth()->check())
        <meta name="user-role" content="{{ auth()->user()->role }}">
    @endif
    <link rel="icon" href="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp">
    <title>Niranjan Enterprises - Help Desk</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --dark-bg: #1f2937;
            --sidebar-bg: #111827;
            --card-bg: #ffffff;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f3f4f6; /* Changed from gradient to solid color */
            min-height: 100vh;
            color: var(--text-primary);
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
            background: #ffffff; /* Ensure solid white background */
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: white;
            border-right: 1px solid #e5e7eb;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1001; /* Higher than header */
            transition: all 0.3s ease;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        }

        .sidebar.collapsed {
            width: 80px;
        }
        
        /* Fully hidden sidebar */
        .sidebar.hidden {
            width: 0;
            min-width: 0;
            padding: 0;
            overflow: hidden;
            border: none;
            opacity: 0;
            transform: translateX(-100%);
        }
        
        /* When sidebar is fully hidden, main content takes full width */
        .sidebar.hidden ~ .main-content {
            margin-left: 0;
            width: 100%;
        }
        
        /* Hover functionality - sidebar expands on hover */
        .sidebar.collapsed:hover {
            width: 280px;
        }
        
        .sidebar.collapsed:hover .sidebar-title {
            display: block;
        }
        
        .sidebar.collapsed:hover .menu-item span {
            display: inline;
        }
        
        .sidebar.collapsed:hover .menu-item {
            text-align: left;
            padding: 0.875rem 1.5rem;
        }
        
        .sidebar.collapsed:hover .menu-item i {
            margin-right: 12px;
            font-size: 1.1rem;
        }
        
        .sidebar.collapsed:hover .dropdown-arrow {
            display: inline;
        }
        
        .sidebar.collapsed:hover .user-role-badge {
            display: block;
        }
        
        /* Hide elements when collapsed */
        .sidebar.collapsed .sidebar-title {
            display: none;
        }
        
        .sidebar.collapsed .menu-item span {
            display: none;
        }
        
        .sidebar.collapsed .menu-item {
            text-align: center;
            padding: 0.875rem;
        }
        
        .sidebar.collapsed .menu-item i {
            margin-right: 0;
            font-size: 1.2rem;
        }
        
        .sidebar.collapsed .dropdown-arrow {
            display: none;
        }
        
        .sidebar.collapsed .user-role-badge {
            display: none;
        }
        
        /* Dropdown menu hover behavior */
        .sidebar.collapsed .dropdown-menu {
            position: absolute;
            left: 80px;
            top: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateX(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            min-width: 200px;
            padding: 0.5rem 0;
        }
        
        .sidebar.collapsed:hover .dropdown-menu {
            position: static;
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
            box-shadow: none;
            border: none;
            background: transparent;
        }
        
        /* Active dropdown styles */
        .sidebar .dropdown.show .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
            display: block !important;
        }
        
        .sidebar .dropdown-menu {
            position: static;
            background: #f8f9fa;
            border: none;
            border-radius: 0;
            box-shadow: none;
            max-height: 400px;
            overflow: hidden;
            opacity: 1;
            visibility: visible;
            transform: none;
            transition: none;
            display: none;
        }
        
        .sidebar .dropdown.show .dropdown-menu {
            display: block !important;
        }
        
        .sidebar .dropdown-menu .menu-item {
            padding: 0.75rem 1rem;
            margin-left: 1rem;
            font-size: 0.9rem;
            text-align: left;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
        }
        
        .sidebar .dropdown-menu .menu-item:hover {
            background: rgba(102, 126, 234, 0.1);
            border-left-color: #667eea;
        }
        
        .sidebar .dropdown-menu .menu-item.active {
            background: rgba(102, 126, 234, 0.15);
            border-left-color: #667eea;
            color: #667eea;
        }
        
        .sidebar .dropdown-menu .dropdown-header {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: rgba(0, 0, 0, 0.02);
            margin: 0.5rem 0;
        }
        
        .sidebar .dropdown-menu .dropdown-divider {
            margin: 0.5rem 0;
            border-color: #e5e7eb;
        }

        .sidebar-header {
            padding: 1.5rem;
            background: var(--primary-gradient);
            color: white;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            padding: 10px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .sidebar-logo:hover {
            transform: scale(1.05);
        }

        .sidebar-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .sidebar.collapsed .sidebar-logo {
            width: 40px;
            height: 40px;
            margin: 0 auto 0.5rem;
        }

        .sidebar.collapsed .sidebar-title {
            display: none;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: block;
            padding: 0.875rem 1.5rem;
            color: #374151;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            position: relative;
            overflow: hidden;
            background: transparent;
            border-radius: 8px;
            margin-bottom: 0.25rem;
            font-weight: 400;
        }

        .menu-item:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%);
            color: #667eea;
            border-left-color: #667eea;
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
        }

        .menu-item.active {
            background: var(--primary-gradient);
            color: white;
            border-left-color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .menu-item i {
            width: 20px;
            margin-right: 12px;
            font-size: 1.1rem;
            text-align: center;
            color: #6b7280;
            transition: all 0.3s ease;
        }
        
        .menu-item:hover i {
            transform: scale(1.1);
            color: #667eea;
        }
        
        .menu-item.active i {
            color: white;
            transform: scale(1.1);
        }
        
        /* Dropdown Menu Styles */
        .dropdown-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: #f9fafb;
            border-radius: 8px;
            margin: 0.25rem 0;
            border: 1px solid #e5e7eb;
            display: block;
            opacity: 0;
            transform: translateY(-10px);
        }
        
        .dropdown-menu.open {
            max-height: 400px;
            opacity: 1;
            transform: translateY(0);
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .menu-header {
            cursor: pointer;
            position: relative;
            user-select: none;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(102, 126, 234, 0.02) 100%);
            border-radius: 8px;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
            padding-right: 3rem !important; /* Make space for arrow */
        }
        
        .menu-header:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%);
            transform: translateX(2px);
        }
        
        .menu-header::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
            color: #6b7280;
            font-size: 0.8rem;
            pointer-events: none; /* Ensure arrow doesn't interfere with click */
        }
        
        .menu-header.open::after {
            transform: translateY(-50%) rotate(180deg);
            color: #667eea;
        }
        
        .menu-header:hover::after {
            color: #667eea;
        }
        
        /* Make the entire menu header area clickable */
        .menu-header i,
        .menu-header span {
            pointer-events: none; /* Let the parent handle clicks */
        }
        
        .dropdown-menu .menu-item {
            transition: all 0.2s ease;
            border-left: 2px solid transparent;
        }
        
        .dropdown-menu .menu-item:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%);
            border-left-color: #667eea;
            transform: translateX(4px);
        }

        /* Dropdown Arrow Styles */
        .dropdown-arrow {
            transition: transform 0.3s ease;
            margin-left: auto;
            font-size: 0.8rem;
            opacity: 0.7;
        }

        .menu-header.open .dropdown-arrow {
            transform: rotate(180deg);
            opacity: 1;
        }

        .menu-header {
            cursor: pointer;
            position: relative;
        }

        .menu-header:hover .dropdown-arrow {
            opacity: 1;
            color: #667eea;
        }

        /* User Role Badge Styles */
        .user-role-badge {
            text-align: center;
            margin-top: 0.5rem;
        }

        .user-role-badge .badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .badge-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border: none;
        }

        .badge-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            border: none;
        }

        .badge-info {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
            border: none;
        }

        .sidebar.collapsed .menu-item span {
            display: none;
        }
        
        /* Additional collapsed state styles are handled above */
        
        /* Menu Header Styling */
        .menu-item[style*="padding-left: 2rem"] {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%);
            border-left: 3px solid #667eea;
            font-weight: 500;
            position: relative;
        }
        
        .menu-item[style*="padding-left: 2rem"]::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--primary-gradient);
        }
        
        .menu-item[style*="padding-left: 2rem"]:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(102, 126, 234, 0.1) 100%);
            transform: translateX(8px);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px; /* Default expanded sidebar */
            transition: all 0.3s ease;
            position: relative;
            background: #f3f4f6;
        }

        .main-content.expanded {
            margin-left: 280px;
            width: calc(100% - 280px);
        }
        
        /* When sidebar is collapsed (80px), adjust main content */
        .sidebar.collapsed ~ .main-content {
            margin-left: 80px;
            width: calc(100% - 80px);
        }
        
        /* When sidebar is fully hidden, main content takes full width */
        .sidebar.hidden ~ .main-content,
        .sidebar.hidden ~ .main-content.expanded {
            margin-left: 0;
            width: 100%;
        }
        
        /* Ensure content area fills available space */
        .content-area {
            padding: 1rem;
            flex: 1;
            width: 100%;
            box-sizing: border-box;
            overflow-y: auto;
            background: #f3f4f6;
        }
        
        /* Split View Layout */
        .split-view-container {
            display: flex;
            height: calc(100vh - 60px); /* Adjust based on header height only */
            overflow: hidden; /* Hide main scrollbar */
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease; /* Smooth transitions */
        }

        .left-panel-30 {
            flex: 0 0 30%;
            max-width: 30%;
            overflow-y: auto;
            border-right: 1px solid #e5e7eb;
            background: #f8f9fa; /* Light background for left panel */
            box-sizing: border-box;
            position: relative; /* For positioning */
        }

        .right-panel-70 {
            flex: 1; /* Always take remaining space */
            padding: 1rem;
            overflow-y: auto; /* Enable vertical scrolling for right panel */
            position: relative; /* For slider positioning */
            min-height: 100%; /* Ensure minimum height is 100% of container */
            overflow-x: hidden; /* Prevent horizontal scroll */
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); /* Gradient background */
        }

        /* Enhanced panel styling */
        .panel-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .panel-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .panel-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        /* When split view is not active, right panel should take full space */
        .split-view-container:not(.split-active) .right-panel-70 {
            flex: 1;
            width: 100%;
            margin-left: 0;
            height: 100%;
            padding: 1rem;
        }

        /* When no menu is selected, show content in left panel */
        .split-view-container:not(.split-active) .left-panel-30 {
            flex: 0 0 30%;
            max-width: 30%;
            overflow-y: auto;
            border-right: 1px solid #e5e7eb;
            background: #f8f9fa; /* Light background for left panel */
            box-sizing: border-box;
            position: relative; /* For positioning */
        }

        .split-view-container:not(.split-active) .content-area {
            display: none; /* Hide main content area when not in split view */
        }

        .split-view-container:not(.split-active) .left-panel-30 .content-area {
            display: block; /* Show content area in left panel */
            padding: 1rem;
        }

        .split-view-container.split-active .right-panel-70 {
            flex: 0 0 70%;
            width: 70%;
        }

        /* Ensure sidebar remains visible when split view is active */
        .split-view-container ~ .sidebar {
            display: block !important; /* Force sidebar to remain visible */
            transform: none !important; /* Remove any transform effects */
        }

        .split-view-container ~ .main-content {
            margin-left: 80px !important; /* Ensure proper spacing from sidebar */
            width: calc(100% - 80px) !important; /* Full width when in split view */
        }

        /* Responsive adjustments for smaller screens */
        @media (max-width: 992px) {
            .split-view-container {
                flex-direction: column; /* Stack panels vertically */
                height: auto; /* Adjust height automatically */
                overflow-x: auto; /* Enable horizontal scroll for container */
            }

            .left-panel-30,
            .right-panel-70 {
                flex: 0 0 100%; /* Both panels take full width */
                max-width: 100%;
                border-right: none; /* Remove right border when stacked */
            }

            .left-panel-30 {
                border-bottom: 1px solid #e5e7eb; /* Add a bottom border to left panel */
            }

            .right-panel-70 {
                min-height: 300px; /* Minimum height for right panel */
                max-height: 60vh; /* Maximum height for right panel */
                overflow-y: auto; /* Enable vertical scrolling */
                position: relative; /* For slider positioning */
            }

            /* Dynamic width adjustment classes */
            .right-panel-70.dynamic-width {
                width: auto; /* Let content determine width */
                max-width: 100%;
                min-width: 200px; /* Minimum usable width */
            }

            /* Content overflow slider */
            .content-slider {
                position: absolute;
                bottom: 10px;
                right: 10px;
                background: rgba(0, 0, 0, 0.8);
                color: white;
                padding: 8px 12px;
                border-radius: 20px;
                cursor: pointer;
                display: none; /* Hidden by default */
                z-index: 10;
                transition: all 0.3s ease;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            .content-slider:hover {
                background: rgba(0, 0, 0, 0.9);
                transform: translateY(-2px);
            }

            .content-slider.visible {
                display: block;
            }
        }

        .right-panel-70.active {
            display: block; /* Show right panel when active on small screens */
        }

        /* Right Panel Content Styling */
        .right-panel-placeholder {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }

        .right-panel-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .right-panel-placeholder p {
            font-size: 1rem;
            margin: 0;
        }

        .detail-section {
            padding: 1.5rem;
        }

        .detail-section h4 {
            color: #374151;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-section h4 i {
            color: #667eea;
            font-size: 1rem;
        }

        .detail-grid {
            display: grid;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .detail-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .detail-value {
            color: #374151;
            font-size: 1rem;
        }

        .action-section {
            padding: 1.5rem;
        }

        .action-section h4 {
            color: #374151;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-section h4 i {
            color: #667eea;
            font-size: 1rem;
        }

        .action-form {
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 1rem;
        }

        .form-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .delete-warning {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .delete-warning p {
            color: #dc3545;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .item-preview {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 1rem;
        }

        /* Top Header */
        .top-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
            margin-left: 0;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-right {
            /* Notifications */
        }

        .menu-toggle {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .menu-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-right: 1rem;
        }

        /* Notification Styles */
        .notifications-menu {
            position: relative;
        }

        .notification-toggle {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f8f9fa;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .notification-toggle:hover {
            background: #e9ecef;
            color: #FFA500; /* Darker golden for hover */
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 18px;
        }

        .notification-toggle i {
            font-size: 16px;
            color: #FFD700; /* Golden color */
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 320px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            display: none; /* Always start hidden */
        }

        .dropdown-header {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .clear-all {
            color: #dc3545;
            text-decoration: none;
            font-size: 14px;
        }

        .clear-all:hover {
            text-decoration: underline;
        }

        .notification-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .notification-item {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f3f4;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
        }

        .notification-item.unread {
            background-color: #e3f2fd;
            border-left: 3px solid #2196f3;
        }

        .notification-content {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .notification-icon {
            flex-shrink: 0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .notification-icon.client-request {
            background: #fff3cd;
            color: #856404;
        }

        .notification-icon.work-update {
            background: #d4edda;
            color: #155724;
        }

        .notification-details {
            flex: 1;
            min-width: 0;
        }

        .notification-title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 4px;
            color: #333;
        }

        .notification-message {
            font-size: 13px;
            color: #666;
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .notification-time {
            font-size: 12px;
            color: #999;
        }

        .no-notifications {
            padding: 2rem;
            text-align: center;
            color: #666;
        }

        .no-notifications i {
            font-size: 24px;
            margin-bottom: 8px;
            display: block;
            opacity: 0.5;
        }

        .dropdown-footer {
            padding: 0.75rem 1rem;
            border-top: 1px solid #dee2e6;
            text-align: center;
        }

        .dropdown-footer a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .dropdown-footer a:hover {
            text-decoration: underline;
        }

        .notification-indicator {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #007bff;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(0, 123, 255, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 123, 255, 0); }
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .user-menu:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #667eea;
            border: 2px solid #667eea;
            margin-right: 12px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            margin-right: 8px;
        }

        .user-name {
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            line-height: 1.2;
        }

        .user-role {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.2;
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Card Styles */
        .dashboard-card {
            background: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-card {
            background: var(--primary-gradient);
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            transition: all 0.3s ease;
        }

        .stat-card:hover::before {
            top: -100%;
            right: -100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .table {
            margin: 0;
        }

        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
            color: var(--text-primary);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        /* Button Styles */
        .btn-action {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            margin: 0.125rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-primary-custom {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-success-custom {
            background: var(--success-color);
            color: white;
        }

        .btn-warning-custom {
            background: var(--warning-color);
            color: white;
        }

        .btn-danger-custom {
            background: var(--danger-color);
            color: white;
        }

        /* Badge Styles */
        .badge-status {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%; /* Full width on mobile */
            }

            .content-area {
                padding: 1rem;
            }

            .top-header {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.2rem;
            }

            .header-right {
                gap: 0.5rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .table-container {
                overflow-x: auto;
            }

            .btn-action {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .stat-card {
                padding: 1rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .dashboard-card {
                padding: 1rem;
            }

            .user-menu span {
                display: none;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* User Dropdown Styles */
        .user-dropdown-menu {
            animation: dropdownSlide 0.3s ease-out;
            overflow: hidden;
            z-index: 9999 !important;
        }

        @keyframes dropdownSlide {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }

        .dropdown-item:first-child {
            border-radius: 12px 12px 0 0;
        }

        .dropdown-item:last-child {
            border-radius: 0 0 12px 12px;
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%);
            color: #667eea;
            transform: translateX(4px);
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 12px;
            font-size: 14px;
            text-align: center;
        }

        .dropdown-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 4px 0;
        }

        .logout-item:hover {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            color: #ef4444;
        }

        /* Sidebar Logout Menu Item Styles */
        .logout-menu-item {
            color: #dc3545 !important;
            border-left-color: #dc3544 !important;
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%) !important;
            margin-top: 1rem;
            border-top: 1px solid #e5e7eb;
            padding-top: 1rem;
        }

        .logout-menu-item:hover {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.2) 0%, rgba(220, 53, 69, 0.1) 100%) !important;
            color: #b02a37 !important;
            border-left-color: #b02a37 !important;
            transform: translateX(5px);
        }

        .logout-menu-item i {
            color: #dc3544 !important;
        }

        .logout-menu-item:hover i {
            color: #b02a37 !important;
            transform: scale(1.1);
        }

        /* Ensure user menu is clickable */
        .user-menu {
            cursor: pointer !important;
            transition: all 0.2s ease;
            position: relative;
        }

        .user-menu:hover {
            background: rgba(102, 126, 234, 0.05) !important;
            border-radius: 8px;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
        }

        .user-menu:hover .user-avatar {
            background: #5a67d8 !important;
            transform: scale(1.05);
        }

        .user-menu:hover .user-name {
            color: #667eea !important;
        }

        .user-menu:hover .user-role {
            color: #7c3aed !important;
        }

        .user-menu:hover .fa-chevron-down {
            color: #667eea !important;
            transform: rotate(180deg);
        }

        /* Ensure all child elements have pointer cursor */
        .user-menu * {
            cursor: pointer !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-gradient);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #667eea;
        }
    </style>
    
    @stack('styles')
</head>

<body>
    <div class="main-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <img src="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp" alt="Niranjan Enterprises Logo">
                </div>
                <div class="sidebar-title">
                    <h5 class="mb-0">Help Desk</h5>
                    <small>Niranjan Enterprises</small>
                    <div class="user-role-badge mt-2">
                        @php
                            $departmentName = 'USER';
                            if(auth()->check()) {
                                switch(auth()->user()->role) {
                                    case 1:
                                        $departmentName = 'Admin';
                                        break;
                                    case 2:
                                        $departmentName = 'Employee';
                                        break;
                                    case 3:
                                        $departmentName = 'Customer';
                                        break;
                                    case 4:
                                        $departmentName = 'Manager';
                                        break;
                                    case 5:
                                        $departmentName = 'General Manager';
                                        break;
                                    default:
                                        $departmentName = 'USER';
                                }
                            }
                        @endphp
                        <span class="badge badge-primary">{{ $departmentName }}</span>
                    </div>
                </div>
            </div>
            <nav class="sidebar-menu">
                @include('admin.body.sidebar')
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Top Header -->
            <header class="top-header">
                <div class="header-left">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="header-right">
                    <!-- Notifications -->
                    <div class="notifications-menu" style="position: relative;">
                        <div id="notification-bell" style="cursor: pointer; padding: 8px; border-radius: 50%; background: #f8f9fa; display: inline-block;" onclick="document.getElementById('notification-dropdown').style.display=document.getElementById('notification-dropdown').style.display=='block'?'none':'block';">
                            <i class="fa fa-bell" style="color: #FFD700; font-size: 16px;"></i>
                            <span id="notification-count" class="notification-badge" style="display: none;">0</span>
                        </div>
                        <div id="notification-dropdown" class="dropdown-menu" style="display: none; position: absolute; top: 50px; right: 0; background: white; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 300px; z-index: 9999;">
                            <div style="padding: 15px; border-bottom: 1px solid #eee;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <h4 style="margin: 0; font-size: 16px;">Notifications</h4>
                                    <a href="#" onclick="document.getElementById('notification-dropdown').style.display='none'; document.getElementById('notification-count').style.display='none'; return false;" style="color: #dc3545; text-decoration: none; font-size: 14px;">Clear All</a>
                                </div>
                            </div>
                            <div>
                                <ul id="notification-list" style="list-style: none; margin: 0; padding: 0;">
                                    <li style="padding: 20px; text-align: center; color: #666;">
                                        <i class="fa fa-bell-slash" style="font-size: 24px; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                                        <span>No new notifications</span>
                                    </li>
                                </ul>
                            </div>
                            <div style="padding: 12px 15px; border-top: 1px solid #eee; text-align: center;">
                                <a href="{{ route('project-updates.index') }}" style="color: #007bff; text-decoration: none; font-size: 14px;">View all</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Attainance Logo -->
                    <div style="margin: 0 10px;">

                    
                        <!-- <a href="{{ route('attendance.dashboard') }}" class="attainance-logo" title="Attainance System" style="display: flex; align-items: center; justify-content: center; width: 45px; height: 45px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 12px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3); position: relative; overflow: hidden;"> 
                        <i class="fas fa-calendar-check" style="font-size: 20px; animation: pulse 2s infinite;"></i>

                         </a> -->

                         @if(Auth::user()->role == 1)

                       <a href="{{ route('attendance.dashboard') }}" class="attainance-logo" title="Attainance System" style="display: flex; align-items: center; justify-content: center; width: 45px; height: 45px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 12px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3); position: relative; overflow: hidden;">
                        <i class="fas fa-calendar-check"></i></a>

                        @elseif(Auth::user()->role == 2)

                         <a href="#" data-bs-toggle="modal"  data-bs-target="#attendancePopupModal" class="attainance-logo" title="Attainance System" style="display: flex; align-items: center; justify-content: center; width: 45px; height: 45px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 12px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3); position: relative; overflow: hidden;">
                             <i class="fas fa-user-check"></i></a>

@endif


                          
                            <style>
                                .attainance-logo:hover {
                                    transform: translateY(-2px) scale(1.05);
                                    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
                                    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
                                }
                                .attainance-logo::before {
                                    content: '';
                                    position: absolute;
                                    top: 0;
                                    left: -100%;
                                    width: 100%;
                                    height: 100%;
                                    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                                    transition: left 0.5s;
                                }
                                .attainance-logo:hover::before {
                                    left: 100%;
                                }
                                @keyframes pulse {
                                    0% { transform: scale(1); opacity: 1; }
                                    50% { transform: scale(1.1); opacity: 0.8; }
                                    100% { transform: scale(1); opacity: 1; }
                                }
                                .attainance-logo::after {
                                    content: '';
                                    position: absolute;
                                    top: 50%;
                                    left: 50%;
                                    transform: translate(-50%, -50%);
                                    width: 30px;
                                    height: 30px;
                                    border: 2px solid rgba(255,255,255,0.3);
                                    border-radius: 50%;
                                    animation: ripple 2s infinite;
                                }
                                @keyframes ripple {
                                    0% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
                                    100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
                                }
                            </style>
                        
                    </div>
                    
                                        
                    <!-- User Dropdown Menu -->
                    <div class="user-dropdown" style="position: relative;">
                        <div class="user-menu" onclick="toggleUserDropdown()" style="cursor: pointer !important; display: flex; align-items: center; padding: 8px 12px; border-radius: 8px; background: #f8f9fa; transition: all 0.2s ease;">
                            <div class="user-avatar" style="width: 35px; height: 35px; background: #667eea; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 12px; cursor: pointer !important;">
                                {{ auth()->user() ? substr(auth()->user()->name, 0, 1) : 'U' }}
                            </div>
                            <div class="user-info" style="display: flex; flex-direction: column; margin-right: 8px; cursor: pointer !important;">
                                <span class="user-name" style="font-weight: 600; color: #374151; font-size: 14px; cursor: pointer !important;">{{ auth()->user() ? auth()->user()->name : 'Guest User' }}</span>
                                <span class="user-role" style="font-size: 12px; color: #6b7280; cursor: pointer !important;">
                                    @php
                                        $departmentName = 'USER';
                                        if(auth()->check()) {
                                            switch(auth()->user()->role) {
                                                case 1:
                                                    $departmentName = 'Admin';
                                                    break;
                                                case 2:
                                                    $departmentName = 'Employee';
                                                    break;
                                                case 3:
                                                    $departmentName = 'Customer';
                                                    break;
                                                case 4:
                                                    $departmentName = 'Manager';
                                                    break;
                                                case 5:
                                                    $departmentName = 'General Manager';
                                                    break;
                                                default:
                                                    $departmentName = 'USER';
                                            }
                                        }
                                    @endphp
                                    {{ $departmentName }}
                                </span>
                            </div>
                            <i class="fas fa-chevron-down" style="color: #6b7280; margin-left: 5px; cursor: pointer !important;"></i>
                        </div>
                        
                        <div id="userDropdownMenu" class="user-dropdown-menu" style="display: none; position: absolute; top: 100%; right: 0; background: white; border: 2px solid #667eea; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); min-width: 250px; min-height: 150px; z-index: 9999; margin-top: 8px; overflow: visible;">
                            <!-- Profile Section -->
                            <div style="padding: 15px; border-bottom: 1px solid #f3f4f6; background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(102, 126, 234, 0.02) 100%);">
                                <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                    <div style="width: 40px; height: 40px; background: #667eea; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 12px;">
                                        {{ auth()->user() ? substr(auth()->user()->name, 0, 1) : 'U' }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #374151; font-size: 14px;">{{ auth()->user() ? auth()->user()->name : 'Guest User' }}</div>
                                        <div style="font-size: 12px; color: #6b7280;">
                                            @php
                                                $departmentName = 'USER';
                                                if(auth()->check()) {
                                                    switch(auth()->user()->role) {
                                                        case 1:
                                                            $departmentName = 'Admin';
                                                            break;
                                                        case 2:
                                                            $departmentName = 'Employee';
                                                            break;
                                                        case 3:
                                                            $departmentName = 'Customer';
                                                            break;
                                                        case 4:
                                                            $departmentName = 'Manager';
                                                            break;
                                                        case 5:
                                                            $departmentName = 'General Manager';
                                                            break;
                                                        default:
                                                            $departmentName = 'USER';
                                                    }
                                                }
                                            @endphp
                                            {{ $departmentName }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Menu Items -->
                            <div style="padding: 8px 0;">
                                <a href="{{ route('admin.profile') }}" onclick="handleDropdownClick(event)" class="dropdown-item" style="display: flex; align-items: center; padding: 12px 16px; color: #374151; text-decoration: none;" onmouseover="this.style.background='linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%)'; this.style.color='#667eea';" onmouseout="this.style.background='transparent'; this.style.color='#374151';">
                                    <i class="fas fa-user-circle" style="width: 20px; margin-right: 12px; font-size: 14px;"></i>
                                    <span>View Profile</span>
                                </a>
                                
                                <a href="{{ route('admin.profile.edit') }}" onclick="handleDropdownClick(event)" class="dropdown-item" style="display: flex; align-items: center; padding: 12px 16px; color: #374151; text-decoration: none;" onmouseover="this.style.background='linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%)'; this.style.color='#667eea';" onmouseout="this.style.background='transparent'; this.style.color='#374151';">
                                    <i class="fas fa-user-edit" style="width: 20px; margin-right: 12px; font-size: 14px;"></i>
                                    <span>Edit Profile</span>
                                </a>
                                
                                <a href="{{ route('admin.change.password') }}" onclick="handleDropdownClick(event)" class="dropdown-item" style="display: flex; align-items: center; padding: 12px 16px; color: #374151; text-decoration: none;" onmouseover="this.style.background='linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%)'; this.style.color='#667eea';" onmouseout="this.style.background='transparent'; this.style.color='#374151';">
                                    <i class="fas fa-key" style="width: 20px; margin-right: 12px; font-size: 14px;"></i>
                                    <span>Change Password</span>
                                </a>
                                
                                <div style="height: 1px; background: #e5e7eb; margin: 8px 16px;"></div>
                                
                                <a href="{{ route('logs') }}" onclick="handleDropdownClick(event)" class="dropdown-item" style="display: flex; align-items: center; padding: 12px 16px; color: #374151; text-decoration: none;" onmouseover="this.style.background='linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%)'; this.style.color='#667eea';" onmouseout="this.style.background='transparent'; this.style.color='#374151';">
                                    <i class="fas fa-history" style="width: 20px; margin-right: 12px; font-size: 14px;"></i>
                                    <span>Activity Logs</span>
                                </a>
                                
                                </div>
                        </div>
                    </div>
                    
                    </div>
            </header>

            <!-- Content Area -->
            <main class="content-area">
                @yield('admin')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Sidebar Toggle and Hover Functionality
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        // Initialize sidebar in collapsed state (not fully hidden)
        sidebar.classList.add('collapsed');

        menuToggle.addEventListener('click', function() {
            // Toggle between: expanded (280px) -> collapsed (80px) -> hidden (0px) -> expanded
            if (sidebar.classList.contains('hidden')) {
                // Hidden -> Expanded
                sidebar.classList.remove('hidden');
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
            } else if (sidebar.classList.contains('collapsed')) {
                // Collapsed -> Hidden
                sidebar.classList.add('hidden');
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
            } else {
                // Expanded -> Collapsed
                sidebar.classList.add('collapsed');
                sidebar.classList.remove('hidden');
                mainContent.classList.add('expanded');
            }
        });

        // Initialize Bootstrap dropdowns
        $(document).ready(function() {
            // Initialize all dropdowns
            $('.dropdown-toggle').dropdown();
            
            // Handle sidebar dropdowns specifically
            $('.sidebar .dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                const $dropdown = $(this).closest('.dropdown');
                const $menu = $dropdown.find('.dropdown-menu');
                
                // Close other dropdowns
                $('.sidebar .dropdown').not($dropdown).removeClass('show');
                $('.sidebar .dropdown-menu').not($menu).removeClass('show');
                
                // Toggle current dropdown
                $dropdown.toggleClass('show');
                $menu.toggleClass('show');
            });
            
            // Close dropdowns when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.sidebar .dropdown').length) {
                    $('.sidebar .dropdown').removeClass('show');
                    $('.sidebar .dropdown-menu').removeClass('show');
                }
            });
        });

        // Mobile Sidebar Toggle
        if (window.innerWidth <= 768) {
            sidebar.classList.add('hidden');
        }

        // Mobile Menu Handling
        menuToggle.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('active');
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // User Dropdown Toggle
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdownMenu');
            const isVisible = dropdown.style.display === 'block';
            
            // Toggle dropdown visibility
            dropdown.style.display = isVisible ? 'none' : 'block';
            
            // Close dropdown when clicking outside
            if (!isVisible) {
                setTimeout(() => {
                    document.addEventListener('click', closeUserDropdown);
                }, 100);
            }
        }

        // Add hover functionality to user dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const userDropdown = document.querySelector('.user-dropdown');
            const dropdownMenu = document.getElementById('userDropdownMenu');
            
            if (userDropdown && dropdownMenu) {
                // Show dropdown on mouseover
                userDropdown.addEventListener('mouseover', function() {
                    dropdownMenu.style.display = 'block';
                });
                
                // Hide dropdown on mouseout
                userDropdown.addEventListener('mouseout', function(e) {
                    // Check if mouse is leaving the dropdown area
                    if (!userDropdown.contains(e.relatedTarget)) {
                        dropdownMenu.style.display = 'none';
                    }
                });
                
                // Also handle mouseout from dropdown menu itself
                dropdownMenu.addEventListener('mouseout', function(e) {
                    if (!userDropdown.contains(e.relatedTarget)) {
                        dropdownMenu.style.display = 'none';
                    }
                });
            }
        });

        // Handle dropdown link clicks
        function handleDropdownClick(e) {
            // Prevent the dropdown from closing when clicking on links
            e.stopPropagation();
            
            // Allow the link to navigate normally
            return true;
        }

        function closeUserDropdown(e) {
            const dropdown = document.getElementById('userDropdownMenu');
            const userMenu = document.querySelector('.user-menu');
            
            // Don't close if clicking on a link inside the dropdown
            const clickedElement = e.target.closest('a, button, [onclick]');
            if (clickedElement && dropdown.contains(clickedElement)) {
                return;
            }
            
            if (!userMenu.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
                document.removeEventListener('click', closeUserDropdown);
            }
        }

        // Test function to verify dropdown is working
        function testDropdown() {
            const dropdown = document.getElementById('userDropdownMenu');
            const userMenu = document.querySelector('.user-menu');
            
            console.log('Dropdown element:', dropdown);
            console.log('User menu element:', userMenu);
            console.log('Dropdown display:', dropdown ? dropdown.style.display : 'not found');
            console.log('Dropdown children:', dropdown ? dropdown.children.length : 'no children');
            
            // Manually show dropdown for testing
            if (dropdown) {
                dropdown.style.display = 'block';
                dropdown.style.visibility = 'visible';
                dropdown.style.opacity = '1';
                
                // Log each dropdown item
                const items = dropdown.querySelectorAll('a');
                console.log('Dropdown items found:', items.length);
                items.forEach((item, index) => {
                    console.log(`Item ${index}:`, item.textContent.trim());
                });
                
                setTimeout(() => {
                    dropdown.style.display = 'none';
                }, 5000); // Hide after 5 seconds
            }
        }

        // Profile Modal
        function openProfileModal() {
            // Close dropdown first
            document.getElementById('userDropdownMenu').style.display = 'none';
            
            // Create and show profile modal
            const modalHtml = `
                <div class="profile-modal-backdrop" id="profileModal" onclick="closeProfileModal(event)">
                    <div class="profile-modal-content" onclick="event.stopPropagation()">
                        <div class="profile-modal-header">
                            <h3><i class="fas fa-user-circle"></i> My Profile</h3>
                            <button class="close-btn" onclick="closeProfileModal()">&times;</button>
                        </div>
                        <div class="profile-modal-body">
                            <div class="profile-avatar">
                                <div class="avatar-circle">
                                    U
                                </div>
                            </div>
                            <div class="profile-info">
                                <div class="info-group">
                                    <label><i class="fas fa-user"></i> Name</label>
                                    <p>User</p>
                                </div>
                                <div class="info-group">
                                    <label><i class="fas fa-envelope"></i> Email</label>
                                    <p>user@example.com</p>
                                </div>
                                <div class="info-group">
                                    <label><i class="fas fa-user-tag"></i> Role</label>
                                    <p>
                                        <span class="role-badge admin">User</span>
                                    </p>
                                </div>
                                <div class="info-group">
                                    <label><i class="fas fa-calendar"></i> Member Since</label>
                                    <p>N/A</p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Add modal to body
            const modalContainer = document.createElement('div');
            modalContainer.innerHTML = modalHtml;
            document.body.appendChild(modalContainer.firstElementChild);
            
            // Add modal styles
            if (!document.getElementById('profileModalStyles')) {
                const modalStyles = document.createElement('style');
                modalStyles.id = 'profileModalStyles';
                modalStyles.innerHTML = `
                    .profile-modal-backdrop {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0, 0, 0, 0.5);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        z-index: 10000;
                        animation: fadeIn 0.3s ease;
                    }
                    
                    .profile-modal-content {
                        background: white;
                        border-radius: 16px;
                        width: 90%;
                        max-width: 500px;
                        max-height: 90vh;
                        overflow-y: auto;
                        animation: slideUp 0.3s ease;
                        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
                    }
                    
                    .profile-modal-header {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        padding: 1.5rem;
                        border-radius: 16px 16px 0 0;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }
                    
                    .profile-modal-header h3 {
                        margin: 0;
                        font-size: 1.5rem;
                        font-weight: 600;
                    }
                    
                    .close-btn {
                        background: rgba(255, 255, 255, 0.2);
                        border: none;
                        color: white;
                        font-size: 1.5rem;
                        width: 32px;
                        height: 32px;
                        border-radius: 50%;
                        cursor: pointer;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        transition: all 0.2s ease;
                    }
                    
                    .close-btn:hover {
                        background: rgba(255, 255, 255, 0.3);
                        transform: scale(1.1);
                    }
                    
                    .profile-modal-body {
                        padding: 2rem;
                    }
                    
                    .profile-avatar {
                        text-align: center;
                        margin-bottom: 2rem;
                    }
                    
                    .avatar-circle {
                        width: 80px;
                        height: 80px;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 2rem;
                        font-weight: bold;
                        margin: 0 auto;
                        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
                    }
                    
                    .profile-info .info-group {
                        margin-bottom: 1.5rem;
                    }
                    
                    .profile-info label {
                        display: block;
                        font-weight: 600;
                        color: #6b7280;
                        margin-bottom: 0.5rem;
                        font-size: 0.875rem;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    }
                    
                    .profile-info p {
                        margin: 0;
                        color: #374151;
                        font-size: 1rem;
                        padding: 0.5rem 0;
                    }
                    
                    .role-badge {
                        padding: 0.25rem 0.75rem;
                        border-radius: 12px;
                        font-size: 0.875rem;
                        font-weight: 600;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    }
                    
                    .role-badge.admin {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                    }
                    
                    .role-badge.employee {
                        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                        color: white;
                    }
                    
                    .role-badge.customer {
                        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
                        color: white;
                    }
                    
                    @keyframes fadeIn {
                        from { opacity: 0; }
                        to { opacity: 1; }
                    }
                    
                    @keyframes slideUp {
                        from { 
                            opacity: 0;
                            transform: translateY(20px);
                        }
                        to { 
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }
                `;
                document.head.appendChild(modalStyles);
            }
        }

        function closeProfileModal(event) {
            if (!event || event.target.classList.contains('profile-modal-backdrop') || event.target.classList.contains('close-btn')) {
                const modal = document.getElementById('profileModal');
                if (modal) {
                    modal.remove();
                }
            }
        }

        // Activity Tracking System
        let activityTracker = {
            isEnabled: false, // Disabled to prevent JavaScript errors
            lastActivity: Date.now(),
            debounceTimer: null,
            
            init: function() {
                this.trackPageView();
                this.trackClicks();
                this.trackFormSubmissions();
                this.trackAjaxRequests();
                this.trackScrollActivity();
                this.trackKeyboardActivity();
                this.startSessionTracking();
            },
            
            // Track page views
            trackPageView: function() {
                const path = window.location.pathname;
                const action = this.getActionFromPath(path);
                const description = this.getDescriptionFromPath(path);
                
                this.logActivity(action, description, 'page_view', 'info', {
                    path: path,
                    title: document.title,
                    referrer: document.referrer
                });
            },
            
            // Track clicks on interactive elements
            trackClicks: function() {
                document.addEventListener('click', (e) => {
                    const element = e.target.closest('a, button, input[type="button"], input[type="submit"], [onclick]');
                    if (!element) return;
                    
                    const action = this.getClickAction(element);
                    const description = this.getClickDescription(element);
                    
                    this.logActivity(action, description, 'click', 'info', {
                        element: element.tagName.toLowerCase(),
                        text: element.textContent?.trim().substring(0, 50) || '',
                        class: element.className,
                        id: element.id
                    });
                });
            },
            
            // Track form submissions
            trackFormSubmissions: function() {
                document.addEventListener('submit', (e) => {
                    const form = e.target;
                    const action = this.getFormAction(form);
                    const description = this.getFormDescription(form);
                    
                    this.logActivity(action, description, 'form_submit', 'info', {
                        form_action: form.action,
                        form_method: form.method,
                        form_id: form.id,
                        form_class: form.className
                    });
                });
            },
            
            // Track AJAX requests
            trackAjaxRequests: function() {
                const originalFetch = window.fetch;
                const originalXHR = window.XMLHttpRequest;
                
                // Track fetch requests
                window.fetch = function(...args) {
                    const url = args[0];
                    const options = args[1] || {};
                    
                    activityTracker.logActivity('ajax_request', `Fetch request to ${url}`, 'ajax_request', 'debug', {
                        url: url,
                        method: options.method || 'GET'
                    });
                    
                    return originalFetch.apply(this, args);
                };
                
                // Track XMLHttpRequest
                const XHROpen = originalXHR.prototype.open;
                originalXHR.prototype.open = function(method, url) {
                    activityTracker.logActivity('ajax_request', `XHR request to ${url}`, 'ajax_request', 'debug', {
                        url: url,
                        method: method
                    });
                    
                    return XHROpen.apply(this, arguments);
                };
            },
            
            // Track scroll activity
            trackScrollActivity: function() {
                let scrollTimeout;
                document.addEventListener('scroll', () => {
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(() => {
                        const scrollPercentage = Math.round(
                            (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100
                        );
                        
                        if (scrollPercentage > 0 && scrollPercentage % 25 === 0) {
                            this.logActivity('scroll', `Scrolled to ${scrollPercentage}% of page`, 'scroll', 'debug', {
                                scroll_percentage: scrollPercentage,
                                scroll_y: window.scrollY
                            });
                        }
                    }, 1000);
                });
            },
            
            // Track keyboard activity
            trackKeyboardActivity: function() {
                let keyPressCount = 0;
                document.addEventListener('keydown', () => {
                    keyPressCount++;
                    
                    if (keyPressCount % 50 === 0) {
                        this.logActivity('keyboard_activity', `User typed ${keyPressCount} keystrokes`, 'keyboard', 'debug', {
                            keystroke_count: keyPressCount
                        });
                    }
                });
            },
            
            // Track session duration
            startSessionTracking: function() {
                setInterval(() => {
                    const duration = Date.now() - this.lastActivity;
                    const minutes = Math.floor(duration / 60000);
                    
                    if (minutes >= 5) {
                        this.logActivity('session_activity', `User active for ${minutes} minutes`, 'session', 'info', {
                            session_duration: minutes,
                            activity_count: this.getActivityCount()
                        });
                        this.lastActivity = Date.now();
                    }
                }, 60000); // Check every minute
            },
            
            // Log activity to server
            logActivity: function(action, description, type, level, additionalData = {}) {
                if (!this.isEnabled) return;
                
                // Debounce rapid activities
                clearTimeout(this.debounceTimer);
                this.debounceTimer = setTimeout(() => {
                    fetch('{{ route("logs.activity") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            action: action,
                            description: description,
                            type: type,
                            level: level,
                            additional_data: additionalData
                        })
                    }).catch(error => {
                        // Silently fail to avoid disrupting user experience
                        console.warn('Activity logging failed:', error);
                    });
                }, 500);
            },
            
            // Helper methods to generate actions and descriptions
            getActionFromPath: function(path) {
                const pathMap = {
                    '/admin/dashboard': 'dashboard_view',
                    '/logs': 'logs_view',
                    '/admin/profile': 'profile_view',
                    '/admin/change/password': 'password_change_view',
                    '/employees': 'employee_view',
                    '/customers': 'customer_view',
                    '/category': 'category_view',
                    '/product': 'ticket_view',
                    '/tickets': 'ticket_view'
                };
                
                return pathMap[path] || 'page_view';
            },
            
            getDescriptionFromPath: function(path) {
                const descMap = {
                    '/admin/dashboard': 'You opened the main dashboard',
                    '/logs': 'You opened the activity logs page',
                    '/admin/profile': 'You viewed your profile information',
                    '/admin/change/password': 'You went to the password change page',
                    '/employees': 'You viewed the employee list',
                    '/customers': 'You viewed the customer list',
                    '/category': 'You viewed the category management',
                    '/product': 'You viewed the ticket management',
                    '/tickets': 'You viewed the ticket management'
                };
                
                return descMap[path] || `You visited ${path}`;
            },
            
            getClickAction: function(element) {
                const tagName = element.tagName.toLowerCase();
                const id = element.id;
                const className = element.className;
                
                if (tagName === 'a') {
                    return 'link_click';
                } else if (tagName === 'button' || element.type === 'submit') {
                    return 'button_click';
                } else if (id) {
                    return `click_${id}`;
                } else if (className) {
                    return `click_${className.split(' ')[0]}`;
                }
                
                return 'element_click';
            },
            
            getClickDescription: function(element) {
                const text = element.textContent?.trim() || '';
                const tagName = element.tagName.toLowerCase();
                
                if (tagName === 'a') {
                    return `You clicked on: ${text.substring(0, 50) || element.href}`;
                } else if (tagName === 'button') {
                    return `You clicked the button: ${text.substring(0, 50)}`;
                } else {
                    return `You clicked on the ${tagName}: ${text.substring(0, 50)}`;
                }
            },
            
            getFormAction: function(form) {
                const action = form.action || '';
                const id = form.id || '';
                
                if (id) {
                    return `form_submit_${id}`;
                } else if (action) {
                    return `form_submit_${action.split('/').pop()}`;
                }
                
                return 'form_submit';
            },
            
            getFormDescription: function(form) {
                const action = form.action || '';
                const id = form.id || '';
                const buttonText = form.querySelector('button[type="submit"]')?.textContent?.trim() || '';
                
                if (buttonText) {
                    return `You submitted the form: ${buttonText}`;
                } else if (id) {
                    return `You submitted the form with ID: ${id}`;
                } else {
                    return 'You submitted the form';
                }
            },
            
            getActivityCount: function() {
                // This would be tracked in a real implementation
                return 0;
            }
        };

        // Initialize activity tracking when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            activityTracker.init();
        });

        // Initialize DataTables
        $(document).ready(function() {
            $('.datatable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'desc']],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        });

        // Toastr Configuration
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Show Messages
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type','info') }}";
            var message = "{{ Session::get('message') }}";
            
            switch(type){
                case 'success':
                    toastr.success(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                default:
                    toastr.info(message);
            }
        @endif

        // Initialize Select2
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        });
        
        // Enhanced dropdown functionality - works on all pages
        function initDropdowns() {
            console.log('Initializing dropdowns...');
            
            $('.menu-header').off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const $header = $(this);
                const $dropdown = $header.next('.dropdown-menu');
                
                console.log('Menu header clicked:', $header.text().trim());
                console.log('Dropdown found:', $dropdown.length > 0 ? 'Yes' : 'No');
                
                if ($dropdown.length === 0) {
                    console.error('Dropdown not found for header:', $header);
                    return;
                }
                
                // Check if sidebar is collapsed
                const isCollapsed = $('.sidebar').hasClass('collapsed');
                
                if (isCollapsed) {
                    // In collapsed state, show dropdown as floating menu
                    $('.dropdown-menu').not($dropdown).removeClass('open');
                    
                    if ($dropdown.hasClass('open')) {
                        $dropdown.removeClass('open');
                    } else {
                        $dropdown.addClass('open');
                    }
                } else {
                    // In expanded state, use normal dropdown behavior
                    $('.dropdown-menu').not($dropdown).each(function() {
                        const $otherDropdown = $(this);
                        const $otherHeader = $otherDropdown.prev('.menu-header');
                        
                        $otherDropdown.removeClass('open');
                        $otherHeader.removeClass('open');
                    });
                    
                    // Toggle current dropdown with animation
                    if ($dropdown.hasClass('open')) {
                        $dropdown.removeClass('open');
                        $header.removeClass('open');
                    } else {
                        $dropdown.addClass('open');
                        $header.addClass('open');
                    }
                }
                
                console.log('Classes after toggle:', $dropdown.attr('class'), $header.attr('class'));
            });
            
            // Prevent dropdown items from closing the dropdown
            $('.dropdown-menu .menu-item').off('click').on('click', function(e) {
                e.stopPropagation();
                
                const isCollapsed = $('.sidebar').hasClass('collapsed');
                
                if (!isCollapsed) {
                    // Allow navigation but close dropdown after a short delay
                    const $dropdown = $(this).closest('.dropdown-menu');
                    const $header = $dropdown.prev('.menu-header');
                    
                    setTimeout(() => {
                        $dropdown.removeClass('open');
                        $header.removeClass('open');
                    }, 300);
                }
            });
            
            // Close dropdowns when clicking outside
            $(document).off('click.dropdown').on('click.dropdown', function(e) {
                if (!$(e.target).closest('.menu-header, .dropdown-menu').length) {
                    $('.dropdown-menu').removeClass('open');
                    $('.menu-header').removeClass('open');
                }
            });
            
            // Add keyboard support
            $('.menu-header').off('keydown').on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).click();
                }
            });
        }
        
        // Initialize dropdowns immediately and on document ready
        $(document).ready(function() {
            initDropdowns();
        });
        
        // Re-initialize dropdowns after any AJAX or dynamic content loads
        $(document).ajaxComplete(function() {
            setTimeout(initDropdowns, 100);
        });

        // Simple notification system - NO COMPLEX JAVASCRIPT
        let notificationPollingInterval;
        let lastNotificationCheck = Math.floor(Date.now() / 1000) - 1800;

        // Initialize notification system (disabled - NotificationController not implemented)
        $(document).ready(function() {
            console.log('Notification system disabled - NotificationController not implemented');
        });

        // Notification functions disabled
        function startNotificationPolling() {
            // Disabled
        }

        function loadNotifications() {
            // Disabled
        }

        function updateNotificationUI(data) {
            // Disabled
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notification-dropdown');
            const bell = document.getElementById('notification-bell');
            if (dropdown && bell && !bell.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });

        // Clean up
        window.addEventListener('beforeunload', function() {
            // Notification polling disabled
        });

        // Simple toggle function as backup
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const header = dropdown.previousElementSibling;
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(d => {
                if (d.id !== dropdownId) {
                    d.classList.remove('open');
                    d.previousElementSibling.classList.remove('open');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('open');
            header.classList.toggle('open');
        }

        function getElementIcon(elementType) {
            const icons = {
                'table': '📊',
                'form': '📝',
                'button': '🔘',
                'input': '⌨️',
                'card': '🃏',
                'navigation': '🧭'
            };
            return icons[elementType] || '📄';
        }

        function testAPIConnection() {
            console.log('Testing API connection...');
            
            fetch('/test-post', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    test: 'data',
                    timestamp: new Date().toISOString()
                })
            })
            .then(response => {
                console.log('Test response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Test response data:', data);
                showNotification('API connection test successful!', 'success');
            })
            .catch(error => {
                console.error('Test API error:', error);
                showNotification('API connection test failed: ' + error.message, 'error');
            });
        }

        
        function showNotification(message, type) {
            // Create a simple notification
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 12px 20px;
                border-radius: 6px;
                color: white;
                font-size: 14px;
                z-index: 10000;
                opacity: 0;
                transition: opacity 0.3s ease;
            `;
            
            switch(type) {
                case 'success':
                    notification.style.background = '#28a745';
                    break;
                case 'error':
                    notification.style.background = '#dc3545';
                    break;
                case 'info':
                    notification.style.background = '#17a2b8';
                    break;
                default:
                    notification.style.background = '#6c757d';
            }
            
            notification.textContent = message;
            document.body.appendChild(notification);
            
            // Fade in
            setTimeout(() => notification.style.opacity = '1', 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        function closeAIHelperModal() {
            console.log('closeAIHelperModal called');
            const backdrop = document.getElementById('aiHelperModalBackdrop');
            if (backdrop) {
                backdrop.remove();
            }
        }

        function getPageTechnicalInfo() {
            // Get all tables with full column details
            const tables = Array.from(document.querySelectorAll('table')).map((table, idx) => {
                const headers = Array.from(table.querySelectorAll('th')).map(th => {
                    const text = th.textContent.trim();
                    // Try to get data attribute if available
                    const dataColumn = th.getAttribute('data-column');
                    return {
                        name: text,
                        dataColumn: dataColumn || text
                    };
                }).filter(h => h.name.length > 0);
                
                // Get table caption or aria-label
                const caption = table.querySelector('caption');
                const ariaLabel = table.getAttribute('aria-label');
                const tableName = table.id || (caption ? caption.textContent.trim() : null) || ariaLabel || `Table ${idx + 1}`;
                
                return {
                    name: tableName,
                    id: table.id || `table-${idx}`,
                    class: table.className || '',
                    columns: headers,
                    rowCount: table.querySelectorAll('tbody tr').length
                };
            });

            // If no real tables found, add some test elements for demonstration
            if (tables.length === 0) {
                tables.push({
                    name: 'Employee Table',
                    id: 'employee-table',
                    class: 'table table-striped',
                    columns: [
                        { name: 'ID', dataColumn: 'id' },
                        { name: 'Name', dataColumn: 'name' },
                        { name: 'Email', dataColumn: 'email' },
                        { name: 'Department', dataColumn: 'department' }
                    ],
                    rowCount: 5
                });
            }

            // Get all forms with detailed field information
            const forms = Array.from(document.querySelectorAll('form')).map((form, idx) => {
                const inputs = Array.from(form.querySelectorAll('input, select, textarea'));
                const fieldDetails = inputs.map((input, fieldIdx) => {
                    const fieldInfo = {
                        index: fieldIdx + 1,
                        tag: input.tagName.toLowerCase(),
                        type: input.type || input.tagName.toLowerCase(),
                        name: input.name || '',
                        id: input.id || '',
                        placeholder: input.placeholder || '',
                        required: input.required,
                        class: input.className || ''
                    };
                    // Create a display label
                    if (input.name) return `${input.name} (${input.type || input.tagName})`;
                    if (input.id) return `${input.id} (${input.type || input.tagName})`;
                    if (input.placeholder) return `${input.placeholder} (${input.type || input.tagName})`;
                    return `Field ${fieldIdx + 1} (${input.type || input.tagName})`;
                });
                
                const formName = form.id || form.name || form.getAttribute('aria-label') || `Form ${idx + 1}`;
                
                return {
                    name: formName,
                    id: form.id || '',
                    action: form.action || '',
                    method: form.method || 'GET',
                    fields: fieldDetails,
                    fieldCount: inputs.length
                };
            });

            // If no real forms found, add test form
            if (forms.length === 0) {
                forms.push({
                    name: 'User Registration Form',
                    id: 'registration-form',
                    action: '/register',
                    method: 'POST',
                    fields: ['name (text)', 'email (email)', 'password (password)', 'confirm_password (password)'],
                    fieldCount: 4
                });
            }

            // Get all input fields with full details
            const allInputs = Array.from(document.querySelectorAll('input, select, textarea'));
            const inputDetails = allInputs.map((input, idx) => {
                const label = document.querySelector(`label[for="${input.id}"]`);
                const labelText = label ? label.textContent.trim() : '';
                
                return {
                    index: idx + 1,
                    display: input.name || input.id || input.placeholder || labelText || `Input ${idx + 1}`,
                    name: input.name || '',
                    id: input.id || '',
                    type: input.type || input.tagName.toLowerCase(),
                    placeholder: input.placeholder || '',
                    label: labelText,
                    required: input.required ? 'Yes' : 'No',
                    class: input.className || ''
                };
            });

            // If no real inputs found, add test inputs
            if (inputDetails.length === 0) {
                inputDetails.push(
                    { index: 1, display: 'username', name: 'username', id: 'username', type: 'text', placeholder: 'Enter username', label: 'Username', required: 'Yes', class: 'form-control' },
                    { index: 2, display: 'email', name: 'email', id: 'email', type: 'email', placeholder: 'Enter email', label: 'Email', required: 'Yes', class: 'form-control' },
                    { index: 3, display: 'password', name: 'password', id: 'password', type: 'password', placeholder: 'Enter password', label: 'Password', required: 'Yes', class: 'form-control' }
                );
            }

            // Get all buttons with details
            const buttons = Array.from(document.querySelectorAll('button, input[type="button"], input[type="submit"], .btn')).map((btn, idx) => {
                const text = btn.textContent.trim() || btn.value || `Button ${idx + 1}`;
                const btnId = btn.id || `button-${idx}`;
                
                // Determine button purpose
                let purpose = 'Action';
                const textLower = text.toLowerCase();
                if (textLower.includes('save') || textLower.includes('submit')) purpose = 'Save/Submit';
                else if (textLower.includes('delete') || textLower.includes('remove')) purpose = 'Delete';
                else if (textLower.includes('edit') || textLower.includes('update')) purpose = 'Edit';
                else if (textLower.includes('create') || textLower.includes('add') || textLower.includes('new')) purpose = 'Create';
                else if (textLower.includes('cancel')) purpose = 'Cancel';
                else if (textLower.includes('view') || textLower.includes('show')) purpose = 'View';
                
                return {
                    text: text,
                    id: btn.id || '',
                    class: btn.className || '',
                    type: btn.type || 'button',
                    purpose: purpose,
                    icon: btn.querySelector('i') ? btn.querySelector('i').className : ''
                };
            });

            // If no real buttons found, add test buttons
            if (buttons.length === 0) {
                buttons.push(
                    { text: 'Save Changes', id: 'save-btn', class: 'btn btn-primary', type: 'submit', purpose: 'Save/Submit', icon: 'fas fa-save' },
                    { text: 'Delete Item', id: 'delete-btn', class: 'btn btn-danger', type: 'button', purpose: 'Delete', icon: 'fas fa-trash' },
                    { text: 'Edit Profile', id: 'edit-btn', class: 'btn btn-warning', type: 'button', purpose: 'Edit', icon: 'fas fa-edit' }
                );
            }

            return {
                url: window.location.pathname + window.location.search,
                title: document.title || 'Unknown Page',
                tables: tables,
                forms: forms,
                inputs: inputDetails,
                buttons: buttons
            };
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAIHelperModal();
            }
        });
    </script>
    
    @stack('scripts')
    
    <!-- Page Customization Script -->
    @if(auth()->check())
        <script src="{{ asset('js/page-customization.js') }}"></script>
        <script src="{{ asset('js/role-visibility.js') }}"></script>
    @endif
    
    <!-- Include Password Change Modal for customers -->
    @if(auth()->check() && auth()->user()->role == 3)
        @include('auth.change-password')
    @endif
    
    @if(auth()->check() && auth()->user()->role != 3)
        @include('partials.attendance-popup')
    @endif
    
    <!-- Off-Time Login Modal -->
    @if(auth()->check() && session('show_off_time_modal'))
        <div class="modal fade" id="offTimeLoginModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Off-Time Login Alert
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="text-warning" style="font-size: 48px;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h4 class="text-dark mt-3">You are logging in outside your scheduled shift time</h4>
                        </div>
                        
                        <div class="alert alert-warning border-warning">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Your Shift Time:</strong><br>
                                    <span class="text-dark">
                                        @if(auth()->user()->shift)
                                            {{ auth()->user()->shift->start_time->format('H:i') }} - {{ auth()->user()->shift->end_time->format('H:i') }}
                                        @else
                                            No shift assigned
                                        @endif
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Current Login Time:</strong><br>
                                    <span class="text-dark">{{ now()->format('H:i:s') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-muted text-center">
                            <small>
                                <i class="fas fa-info-circle me-1"></i>
                                This login has been recorded and will be reported to your senior management.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-warning btn-lg" data-bs-dismiss="modal" onclick="clearOffTimeModal()">
                            <i class="fas fa-check me-2"></i>I Understand
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var offTimeModal = new bootstrap.Modal(document.getElementById('offTimeLoginModal'));
            offTimeModal.show();
            
            // Send notification to seniors
            sendOffTimeNotification();
        });
        
        function sendOffTimeNotification() {
            fetch('/off-time-login-notify', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    user_id: {{ auth()->user()->id }},
                    login_time: '{{ now()->format('H:i:s') }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Off-time notification sent:', data);
            })
            .catch(error => {
                console.error('Error sending off-time notification:', error);
            });
        }
        
        function clearOffTimeModal() {
            // Clear session data
            fetch('/clear-off-time-modal', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        }
        </script>
    @endif
    
    <!-- Logout Form (Hidden) -->
    <form action="{{ route('logout') }}" method="POST" id="logoutForm" style="display: none;">
        @csrf
    </form>
</body>
</html>
