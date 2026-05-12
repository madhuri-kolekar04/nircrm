<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Calling App - Google Sheets Data</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 10px;
        }

        .app-container {
            max-width: 100%;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .app-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .app-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            padding: 10px 15px;
            border-radius: 8px;
        }

        .app-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .sync-button {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .sync-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .sync-button.syncing {
            background: rgba(255, 255, 255, 0.1);
            cursor: not-allowed;
        }

        .header-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .employee-button {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .employee-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .stats-bar {
            background: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .stat-item strong {
            color: #495057;
        }

        .search-section {
            padding: 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .search-input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #e9ecef;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .table-container {
            overflow-x: auto;
            background: white;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .data-table th {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 15px 10px;
            text-align: left;
            font-weight: 600;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .data-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        .data-table tr:hover {
            background: #f8f9fa;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
            font-size: 0.9rem;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .action-btn.view {
            background: var(--info-color);
        }

        .action-btn.call {
            background: var(--success-color);
        }

        .action-btn.meeting {
            background: var(--warning-color);
        }

        .action-btn.history {
            background: var(--info-color);
        }

        .action-btn.recording {
            background: #dc3545;
            cursor: default;
            pointer-events: none;
        }

        .pagination-container {
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pagination-btn {
            padding: 8px 15px;
            border: 1px solid #e9ecef;
            background: white;
            color: #495057;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .pagination-btn:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .pagination-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .no-data i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .toast {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 15px 20px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 300px;
            animation: slideIn 0.3s ease;
        }

        .toast.success {
            border-left: 4px solid var(--success-color);
        }

        .toast.error {
            border-left: 4px solid var(--danger-color);
        }

        .toast.info {
            border-left: 4px solid var(--info-color);
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            body {
                padding: 5px;
            }

            .app-title {
                font-size: 1.5rem;
            }

            .app-subtitle {
                font-size: 0.9rem;
            }

            .sync-button {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .stats-bar {
                padding: 10px 15px;
            }

            .stat-item {
                font-size: 0.8rem;
            }

            .search-section {
                padding: 15px;
            }

            .data-table {
                font-size: 0.8rem;
            }

            .data-table th,
            .data-table td {
                padding: 10px 8px;
            }

            .action-btn {
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }

            .pagination-container {
                padding: 15px;
            }

            .pagination-btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }

            /* Header elements mobile responsive */
            .app-header {
                position: relative;
            }

            .app-header > div[style*="position: absolute"] {
                position: relative !important;
                top: auto !important;
                right: auto !important;
                justify-content: center !important;
                margin-bottom: 15px;
                flex-wrap: wrap;
                gap: 10px !important;
            }

            .app-header > div[style*="position: absolute"] > div {
                flex: 1;
                min-width: fit-content;
                text-align: center;
            }

            .auto-sync-indicator {
                padding: 6px 12px !important;
                font-size: 0.75rem !important;
            }
        }

        @media (max-width: 480px) {
            .app-title {
                font-size: 1.3rem;
            }

            .data-table {
                font-size: 0.7rem;
            }

            .data-table th,
            .data-table td {
                padding: 8px 6px;
            }

            .action-btn {
                width: 28px;
                height: 28px;
                font-size: 0.7rem;
            }

            .toast {
                min-width: 250px;
                right: 10px;
                left: 10px;
            }

            /* Header elements for smaller mobile screens */
            .app-header > div[style*="position: absolute"] {
                gap: 8px !important;
            }

            .app-header > div[style*="position: absolute"] > div {
                font-size: 0.75rem !important;
                padding: 6px 10px !important;
            }

            .auto-sync-indicator {
                padding: 4px 8px !important;
                font-size: 0.7rem !important;
            }
        }

        /* Email and WhatsApp links */
        .email-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .email-link:hover {
            text-decoration: underline;
        }

        .whatsapp-link {
            color: var(--success-color);
            text-decoration: none;
            font-weight: 500;
        }

        .whatsapp-link:hover {
            text-decoration: underline;
        }

        .website-link {
            color: var(--info-color);
            text-decoration: none;
            font-weight: 500;
        }

        .website-link:hover {
            text-decoration: underline;
        }

        .who-called-info {
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
            color: var(--success-color);
        }

        .who-called-name {
            font-size: 0.9rem;
        }

        .not-called-yet {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #6c757d;
            font-size: 0.85rem;
            font-style: italic;
        }

        .best-calling-time {
            padding: 4px 0;
        }

        .confidence-badge {
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .source-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
            background: #6c757d;
        }

        /* Bootstrap badge overrides for source indicators */
        .badge {
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            padding: 0.35em 0.65em !important;
            border-radius: 0.375rem !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
            color: #000 !important;
        }

        .bg-info {
            background-color: #17a2b8 !important;
            color: #fff !important;
        }

        .confidence-high {
            background: rgba(40, 167, 69, 0.1) !important;
            color: #28a745 !important;
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .confidence-medium {
            background: rgba(255, 193, 7, 0.1) !important;
            color: #ffc107 !important;
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .confidence-low {
            background: rgba(108, 117, 125, 0.1) !important;
            color: #6c757d !important;
            border: 1px solid rgba(108, 117, 125, 0.2);
        }

        .no-time-data {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 8px 12px;
            background: rgba(108, 117, 125, 0.05);
            border-radius: 6px;
            font-size: 0.8rem;
        }

        .auto-sync-indicator {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .auto-sync-indicator.active {
            background: rgba(40, 167, 69, 0.3);
        }

        .pulse {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #28a745;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
            }
        }

        /* Tab Navigation Styles */
        .tab-navigation {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .tab-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #e9ecef;
            color: #495057;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tab-btn:hover {
            background: #dee2e6;
            transform: translateY(-2px);
        }

        .tab-btn.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .tab-btn.active:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        /* Custom Modal Styles */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .custom-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .custom-modal {
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transform: scale(0.7);
            transition: all 0.3s ease;
            text-align: center;
            position: relative;
        }

        .custom-modal-overlay.active .custom-modal {
            transform: scale(1);
        }

        .modal-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            animation: modalIconPulse 2s infinite;
        }

        .modal-icon i {
            color: white;
            font-size: 24px;
        }

        @keyframes modalIconPulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 15px rgba(220, 53, 69, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .modal-message {
            font-size: 1rem;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .modal-btn {
            padding: 12px 30px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            min-width: 100px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modal-btn-confirm {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .modal-btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        }

        .modal-btn-cancel {
            background: #f8f9fa;
            color: #6c757d;
            border: 2px solid #e9ecef;
        }

        .modal-btn-cancel:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        /* Mobile Responsive Modal */
        @media (max-width: 768px) {
            .custom-modal {
                padding: 25px;
                width: 85%;
                max-width: 350px;
            }

            .modal-title {
                font-size: 1.3rem;
            }

            .modal-message {
                font-size: 0.9rem;
            }

            .modal-btn {
                padding: 10px 25px;
                font-size: 0.9rem;
                min-width: 90px;
            }

            .modal-icon {
                width: 50px;
                height: 50px;
            }

            .modal-icon i {
                font-size: 20px;
            }
        }

        @media (max-width: 480px) {
            .custom-modal {
                padding: 20px;
                width: 90%;
                max-width: 300px;
            }

            .modal-title {
                font-size: 1.2rem;
            }

            .modal-message {
                font-size: 0.85rem;
                margin-bottom: 25px;
            }

            .modal-buttons {
                gap: 10px;
            }

            .modal-btn {
                padding: 8px 20px;
                font-size: 0.85rem;
                min-width: 80px;
            }

            .modal-icon {
                width: 45px;
                height: 45px;
                margin-bottom: 15px;
            }

            .modal-icon i {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Header -->
        <div class="app-header">
            <!-- User Info and Auto-sync -->
            <div style="position: absolute; top: 20px; right: 20px; display: flex; gap: 15px; align-items: center;">
                <!-- User Info -->
                <div style="background: rgba(255, 255, 255, 0.2); padding: 8px 15px; border-radius: 20px; font-size: 0.85rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-user-circle"></i>
                    <span>({{ Auth::user()->role_name }})</span>
                </div>
                
                <!-- Auto-sync enabled -->
                <div class="auto-sync-indicator" id="autoSyncIndicator">
                    <span class="pulse"></span>
                    <span>(40s)</span>
                </div>
                
                <!-- Logout Button -->
                <button type="button" onclick="showLogoutModal()" style="background: rgba(220, 53, 69, 0.2); border: 1px solid rgba(220, 53, 69, 0.5); color: white; padding: 8px 15px; border-radius: 20px; font-size: 0.85rem; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
            <h1 class="app-title">
                <i class="fas fa-phone-alt me-2"></i>
                Calling App
            </h1>
            <p class="app-subtitle">Google Sheets Data - Auto-Sync Lead Management (40s)</p>
            <div class="header-buttons">
                <a href="/followup" class="employee-button" id="todayButton" onclick="loadTodayFollowupCount()">
                    <i class="fas fa-calendar-day"></i>
                    <span>Today: <strong id="todayCount">0</strong></span>
                </a>
                <button class="employee-button" onclick="showEmployeeModal()">
                    <i class="fas fa-user-plus"></i>
                    <span>Add Employee</span>
                </button>
                <a href="/callingappleads" class="employee-button" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-user-plus"></i>
                    <span>Add Leads</span>
                </a>
                <button class="sync-button" id="syncBtn" onclick="syncGoogleSheets()">
                    <i class="fas fa-sync-alt"></i>
                    <span>Sync Google Sheets</span>
                </button>
            </div>
        </div>

        <!-- Stats Bar -->
        <div class="stats-bar">
            <div class="stat-item">
                <i class="fas fa-users"></i>
                <span>Total Leads: <strong>{{ $totalRows }}</strong></span>
            </div>
            <div class="stat-item">
                <i class="fas fa-file-alt"></i>
                <span>Page: <strong>{{ $page }} / {{ $totalPages }}</strong></span>
            </div>
            <div class="stat-item">
                <i class="fas fa-list"></i>
                <span>Showing: <strong>{{ min($perPage, count($pageData)) }}</strong> per page</span>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            @php
                $isManualLeadsTab = request()->routeIs('callingapp.manual-leads');
                $searchRoute = $isManualLeadsTab ? 'callingapp.manual-leads' : 'callingapp.index';
            @endphp
            <form method="GET" action="{{ route($searchRoute) }}">
                <input type="text" 
                       name="search" 
                       class="search-input" 
                       placeholder="🔍 Search leads by name, business, email..." 
                       value="{{ $search }}">
            </form>
        </div>

        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <button class="tab-btn {{ request()->routeIs('callingapp.manual-leads') ? '' : 'active' }}" onclick="switchTab('google')" id="google-tab">
                <i class="fas fa-sync"></i>
                Google Sheet
            </button>
            <button class="tab-btn {{ request()->routeIs('callingapp.manual-leads') ? 'active' : '' }}" onclick="switchTab('manual')" id="manual-tab">
                <i class="fas fa-user-plus"></i>
                Manual Leads
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 20px 0;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 20px 0;">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @include('admin.google-sheets.calling-app-table')
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Custom Logout Modal -->
    <div class="custom-modal-overlay" id="logoutModal">
        <div class="custom-modal">
            <div class="modal-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h3 class="modal-title">Logout Confirmation</h3>
            <p class="modal-message">Are you sure you want to logout? You will need to login again to access the system.</p>
            <div class="modal-buttons">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="hideLogoutModal()">Cancel</button>
                <form method="POST" action="{{ route('callingapp.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="modal-btn modal-btn-confirm">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Hash function for stable lead-based time assignment
    function hashCode(str) {
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
            const char = str.charCodeAt(i);
            hash = ((hash << 5) - hash) + char;
            hash = hash & hash; // Convert to 32bit integer
        }
        return hash;
    }

    // Auto-sync enabled - 40 second interval
    let autoSyncInterval;
    let isAutoSyncEnabled = true;

    function loadTodayFollowupCount() {
        fetch('{{ route('callingapp.today-followup-count') }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('todayCount').textContent = data.today_count;
                }
            })
            .catch(error => {
                console.error('Error loading today follow-up count:', error);
            });
    }

    function startAutoSync() {
        if (isAutoSyncEnabled) {
            autoSyncInterval = setInterval(() => {
                // Only auto-sync when Google Sheet tab is active
                const googleTab = document.getElementById('google-tab');
                if (googleTab && googleTab.classList.contains('active') && !document.getElementById('syncBtn').classList.contains('syncing')) {
                    console.log('Starting auto-sync (40 second interval) - Google Sheet tab active');
                    syncGoogleSheets(true); // true = auto-sync
                }
            }, 40000); // 40 seconds as requested
            
            document.getElementById('autoSyncIndicator').classList.add('active');
        }
    }

    function stopAutoSync() {
        clearInterval(autoSyncInterval);
        document.getElementById('autoSyncIndicator').classList.remove('active');
    }

    function clearLoadingStates() {
        // Clear any stuck loading states
        const syncBtn = document.getElementById('syncBtn');
        if (syncBtn && syncBtn.classList.contains('syncing')) {
            syncBtn.innerHTML = '<i class="fas fa-sync"></i><span>Sync</span>';
            syncBtn.classList.remove('syncing');
            syncBtn.disabled = false;
            console.log('Cleared stuck sync button loading state');
        }
        
        // Clear any loading spinners
        document.querySelectorAll('.fa-spinner.fa-spin').forEach(spinner => {
            spinner.classList.remove('fa-spin');
            console.log('Cleared spinner animation');
        });
    }

    // Add keyboard shortcut to clear loading states (Ctrl + Shift + L)
    document.addEventListener('keydown', function(event) {
        if (event.ctrlKey && event.shiftKey && event.key === 'L') {
            event.preventDefault();
            clearLoadingStates();
            showToast('Loading states cleared', 'success');
        }
    });

    function syncGoogleSheets(isAutoSync = false) {
        const syncBtn = document.getElementById('syncBtn');
        
        // Check if button exists and is not already syncing
        if (!syncBtn || syncBtn.classList.contains('syncing')) {
            console.log('Sync already in progress or button not found');
            return;
        }
        
        // Check if Google Sheet tab is active for auto-sync
        if (isAutoSync) {
            const googleTab = document.getElementById('google-tab');
            if (!googleTab || !googleTab.classList.contains('active')) {
                console.log('Auto-sync skipped - Google Sheet tab is not active');
                return;
            }
        }
        
        const originalText = syncBtn.innerHTML;
        
        // Show loading state
        syncBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Syncing...</span>';
        syncBtn.classList.add('syncing');
        syncBtn.disabled = true;
        
        // Get current page and search parameters
        const urlParams = new URLSearchParams(window.location.search);
        const currentPage = urlParams.get('page') || 1;
        const searchValue = document.querySelector('.search-input')?.value || urlParams.get('search') || '';
        
        // Add timeout to prevent infinite loading
        const timeoutId = setTimeout(() => {
            console.error('Sync request timed out');
            showToast('Sync request timed out. Please try again.', 'error');
            // Restore button state
            syncBtn.innerHTML = originalText;
            syncBtn.classList.remove('syncing');
            syncBtn.disabled = false;
        }, 15000); // 15 second timeout

        fetch('{{ route('callingapp.sync') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                page: currentPage,
                search: searchValue,
                auto_sync: isAutoSync
            })
        })
        .then(response => {
            clearTimeout(timeoutId); // Clear timeout on successful response
            return response.json();
        })
        .then(data => {
            if (data.success) {
                if (!isAutoSync) {
                    showToast(data.message, 'success');
                }
                
                // Update table without page refresh - only if Google Sheet tab is active
                if (data.table_data) {
                    const googleTab = document.getElementById('google-tab');
                    if (googleTab && googleTab.classList.contains('active')) {
                        updateTableData(data.table_data);
                        updateStatistics(data);
                    } else {
                        console.log('Auto-sync completed but Google Sheet tab is not active - no table update');
                    }
                } else {
                    // Fallback: refresh the page if table_data is missing
                    console.warn('No table_data received, refreshing page');
                    if (!isAutoSync) {
                        window.location.reload();
                    }
                }
                
                // Update today's follow-up count after sync
                loadTodayFollowupCount();
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            clearTimeout(timeoutId); // Clear timeout on error
            console.error('Sync error:', error);
            showToast('An error occurred while syncing Google Sheets.', 'error');
        })
        .finally(() => {
            clearTimeout(timeoutId); // Ensure timeout is cleared
            // Restore button state
            syncBtn.innerHTML = originalText;
            syncBtn.classList.remove('syncing');
            syncBtn.disabled = false;
        });
    }
        
        
    function updateTableData(tableData) {
        try {
            // Update table body
            const tableBody = document.querySelector('.data-table tbody');
            if (!tableBody) return;
            
            // Clear existing rows
            tableBody.innerHTML = '';
            
            // Add new rows
            tableData.pageData.forEach((row, index) => {
                const tr = document.createElement('tr');
                
                // Serial number
                const td1 = document.createElement('td');
                td1.innerHTML = `<strong>${(tableData.page - 1) * tableData.perPage + index + 1}</strong>`;
                tr.appendChild(td1);
                
                // Full Name
                const td2 = document.createElement('td');
                td2.innerHTML = `<strong>${row.full_name || '-'}</strong>`;
                tr.appendChild(td2);
                
                // Business Name
                const td3 = document.createElement('td');
                td3.textContent = row.business_name || '-';
                tr.appendChild(td3);
                
                // Email
                const td4 = document.createElement('td');
                if (row.email) {
                    td4.innerHTML = `<a href="mailto:${row.email}" class="email-link"><i class="fas fa-envelope me-1"></i>${row.email}</a>`;
                } else {
                    td4.textContent = '-';
                }
                tr.appendChild(td4);
                
                // WhatsApp
                const td5 = document.createElement('td');
                if (row.whatsapp) {
                    const cleanPhone = row.whatsapp.replace(/[^0-9+]/g, '');
                    td5.innerHTML = `<a href="https://wa.me/${cleanPhone}" target="_blank" class="whatsapp-link"><i class="fab fa-whatsapp me-1"></i>${row.whatsapp}</a>`;
                } else {
                    td5.textContent = '-';
                }
                tr.appendChild(td5);
                
                // Who Called
                const td6 = document.createElement('td');
                if (row.who_called && row.who_called !== 'Not called yet') {
                    td6.innerHTML = `<div class="who-called-info"><i class="fas fa-user-check me-1"></i><span class="who-called-name">${row.who_called}</span></div>`;
                } else {
                    td6.innerHTML = `<span class="not-called-yet"><i class="fas fa-phone-slash me-1"></i>Not called yet</span>`;
                }
                tr.appendChild(td6);
                
                // Best Calling Time
                const td7 = document.createElement('td');
                if (row.best_calling_time && row.best_calling_time.time_range) {
                    // Use colors from backend calculation
                    const backendColor = row.best_calling_time.color || '#6c757d';
                    const confidence = (row.best_calling_time.confidence || 'low').toLowerCase();
                    
                    // Generate colors based on backend color for consistency
                    let bgColor, textColor, iconColor, badgeBg, badgeText;
                    
                    if (confidence === 'high') {
                        bgColor = '#e3f2fd';
                        textColor = '#1976d2';
                        iconColor = '#2196f3';
                        badgeBg = '#2196f3';
                        badgeText = '#ffffff';
                    } else if (confidence === 'medium') {
                        bgColor = '#fff3e0';
                        textColor = '#f57c00';
                        iconColor = '#ff9800';
                        badgeBg = '#ff9800';
                        badgeText = '#ffffff';
                    } else {
                        // Use green theme for low confidence (permanent)
                        bgColor = '#e8f5e8';
                        textColor = '#2e7d32';
                        iconColor = '#4caf50';
                        badgeBg = '#4caf50';
                        badgeText = '#ffffff';
                    }
                    
                    td7.innerHTML = `
                        <div class="best-calling-time" style="display: flex; flex-direction: column; gap: 6px; padding: 8px 12px; background: ${bgColor}; border-radius: 8px; border-left: 4px solid ${iconColor};">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-clock" style="color: ${iconColor}; font-size: 1rem;"></i>
                                <span style="font-weight: 700; color: ${textColor}; font-size: 0.9rem;">
                                    ${row.best_calling_time.time_range}
                                </span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span class="confidence-badge" 
                                      style="font-size: 0.65rem; padding: 3px 8px; border-radius: 12px; background: ${badgeBg}; color: ${badgeText}; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                    ${row.best_calling_time.confidence || 'Low'}
                                </span>
                                <span style="font-size: 0.7rem; color: ${textColor}; opacity: 0.8;">
                                    <i class="fas fa-phone-alt" style="font-size: 0.6rem;"></i>
                                    ${row.best_calling_time.interaction_count || 0} calls
                                </span>
                            </div>
                        </div>
                    `;
                } else {
                    // Fallback: Generate a stable time recommendation based on lead data
                    const leadHash = hashCode((row.full_name || '') + (row.email || ''));
                    const timeRanges = [
                        {range: '9:00 AM - 11:00 AM', peak: '10:00 AM'},   // Morning start
                        {range: '10:00 AM - 12:00 PM', peak: '11:00 AM'}, // Late morning
                        {range: '2:00 PM - 4:00 PM', peak: '3:00 PM'},     // Afternoon
                        {range: '5:00 PM - 7:00 PM', peak: '6:00 PM'}      // Evening end
                    ];
                    const index = Math.abs(leadHash) % timeRanges.length;
                    const fallbackTime = timeRanges[index];
                    
                    // Use green color for Low confidence fallback
                    const greenColor = '#4caf50';
                    
                    td7.innerHTML = `
                        <div class="best-calling-time" style="display: flex; flex-direction: column; gap: 6px; padding: 8px 12px; background: #e8f5e8; border-radius: 8px; border-left: 4px solid ${greenColor};">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-clock" style="color: ${greenColor}; font-size: 1rem;"></i>
                                <span style="font-weight: 700; color: #2e7d32; font-size: 0.9rem;">
                                    ${fallbackTime.range}
                                </span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span class="confidence-badge" 
                                      style="font-size: 0.65rem; padding: 3px 8px; border-radius: 12px; background: ${greenColor}; color: #ffffff; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Low
                                </span>
                                <span style="font-size: 0.7rem; color: #2e7d32; opacity: 0.8;">
                                    <i class="fas fa-phone-alt" style="font-size: 0.6rem;"></i>
                                    0 calls
                                </span>
                            </div>
                        </div>
                    `;
                }
                tr.appendChild(td7);
                
                // Actions
                const td8 = document.createElement('td');
                td8.innerHTML = `
                    <div class="action-buttons">
                        <button class="action-btn view" onclick="openLeadDetails(${index})" title="View Details">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="action-btn history" onclick="viewLeadCallHistory('${row.full_name || ''}', '${row.email || ''}', '${row.business_name || ''}', '${row.whatsapp || ''}')" title="View Call History">
                            <i class="fas fa-history"></i>
                        </button>
                        <button class="action-btn call" onclick="makePhoneCall('${row.whatsapp || ''}')" title="Call">
                            <i class="fas fa-phone"></i>
                        </button>
                        <button class="action-btn meeting" onclick="openMeetingModal('${row.full_name || ''}', '${row.email || ''}', '${row.whatsapp || ''}', '${row.business_name || ''}', '${row.who_called || ''}')" title="Schedule Meeting">
                            <i class="fas fa-calendar"></i>
                        </button>
                    </div>
                `;
                tr.appendChild(td8);
                
                tableBody.appendChild(tr);
            });
            
            // Update pagination
            updatePagination(tableData);
            
            // Update search value
            const searchInput = document.querySelector('.search-input');
            if (searchInput && tableData.search) {
                searchInput.value = tableData.search;
            }
            
        } catch (error) {
            console.error('Error updating table:', error);
            showToast('Error updating table data', 'error');
        }
    }

    function updatePagination(tableData) {
        const paginationDiv = document.querySelector('.pagination');
        if (!paginationDiv) return;
        
        paginationDiv.innerHTML = '';
        
        // Previous button
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${tableData.page <= 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="#" onclick="changePage(${tableData.page - 1})" tabindex="-1">Previous</a>`;
        paginationDiv.appendChild(prevLi);
        
        // Page numbers
        const startPage = Math.max(1, tableData.page - 2);
        const endPage = Math.min(tableData.totalPages, tableData.page + 2);
        
        for (let i = startPage; i <= endPage; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === tableData.page ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#" onclick="changePage(${i})">${i}</a>`;
            paginationDiv.appendChild(li);
        }
        
        // Next button
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${tableData.page >= tableData.totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="#" onclick="changePage(${tableData.page + 1})">Next</a>`;
        paginationDiv.appendChild(nextLi);
        
        // Update page info
        const pageInfo = document.querySelector('.page-info');
        if (pageInfo) {
            pageInfo.innerHTML = `Page: <strong>${tableData.page} / ${tableData.totalPages}</strong>`;
        }
    }

    function changePage(page) {
        // Update URL without refresh
        const url = new URL(window.location);
        url.searchParams.set('page', page);
        window.history.pushState({}, '', url);
        
        // Trigger sync with new page
        syncGoogleSheets(true);
    }

    function updateStatistics(data) {
        // Update statistics if they exist
        const statsElements = document.querySelectorAll('.stat-item span');
        if (statsElements.length >= 3) {
            // Safely access nested properties and provide fallbacks
            const tableData = data.table_data || {};
            const totalRows = tableData.totalRows ?? data.totalRows ?? 0;
            const page = tableData.page ?? data.page ?? 1;
            const totalPages = tableData.totalPages ?? data.totalPages ?? 1;
            const perPage = tableData.perPage ?? data.perPage ?? 50;
            const pageDataLength = tableData.pageData?.length ?? 0;
            
            statsElements[0].innerHTML = `<strong>${totalRows}</strong>`;
            statsElements[1].innerHTML = `<strong>${page} / ${totalPages}</strong>`;
            statsElements[2].innerHTML = `<strong>${Math.min(perPage, pageDataLength)}</strong>`;
        }
    }

    function openLeadDetails(index) {
        // Determine source from active tab
        const source = document.getElementById('manual-tab').classList.contains('active') ? 'manual' : 'google';
        // Navigate to lead details in same tab with source information
        window.location.href = `/callingapp/lead-details/${index}?source=${source}`;
    }

    function viewLeadCallHistory(fullName, email, businessName, whatsapp) {
        // Navigate to call history for specific lead with filters in same tab
        const params = new URLSearchParams({
            lead_name: fullName || '',
            lead_email: email || '',
            lead_business: businessName || '',
            lead_whatsapp: whatsapp || '',
            source: document.getElementById('manual-tab').classList.contains('active') ? 'manual' : 'google'
        });
        window.location.href = `/callhistory?${params.toString()}`;
    }

    function makePhoneCall(phone) {
        if (!phone) {
            showToast('No phone number available', 'error');
            return;
        }
        
        // Clean phone number
        const cleanPhone = phone.replace(/[^0-9+]/g, '');
        
        // Try to open phone app on mobile, WhatsApp as fallback
        if (/Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            // Mobile - try to open phone dialer
            window.location.href = `tel:${cleanPhone}`;
            showToast('Opening phone dialer...', 'success');
        } else {
            // Desktop - open WhatsApp
            window.open(`https://wa.me/${cleanPhone}`, '_blank');
            showToast('Opening WhatsApp...', 'success');
        }
    }

    function viewRecordings(fullName, whatsapp) {
        console.log('Viewing recordings for:', {fullName, whatsapp});
        
        // Open the all recordings page with filters
        const params = new URLSearchParams();
        if (fullName) params.set('customer_name', fullName);
        if (whatsapp) params.set('customer_phone', whatsapp);
        
        const url = params.toString() ? `/allrecordingcall?${params.toString()}` : '/allrecordingcall';
        window.open(url, '_blank');
        showToast('Opening recordings...', 'success');
    }

    function openMeetingModal(fullName, email, whatsapp, businessName, whoCalled) {
        console.log('Opening meeting modal with data:', {fullName, email, whatsapp, businessName, whoCalled});
        
        // Clear form first
        clearMeetingForm();
        
        // Set lead information
        document.getElementById('leadFullName').value = fullName || '';
        document.getElementById('leadBusinessName').value = businessName || '';
        document.getElementById('leadEmail').value = email || '';
        document.getElementById('leadWhatsapp').value = whatsapp || '';
        document.getElementById('leadWebsiteUrl').value = 'https://example.com'; // Set default value to pass validation
        
        // Store who called for pre-selection
        window.currentWhoCalled = whoCalled;
        
        // Load employees and pre-select who called
        loadEmployees(whoCalled);
        
        // Fetch existing meeting details for this lead (pass all fields for accurate matching)
        fetchMeetingDetails(fullName, businessName, email, whatsapp);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('meetingModal'));
        modal.show();
    }

    function fetchMeetingDetails(fullName, businessName, email, whatsapp) {
        if (!email) return;
        
        // Create query parameters for all lead fields
        const params = new URLSearchParams({
            full_name: fullName || '',
            business_name: businessName || '',
            email: email || '',
            whatsapp: whatsapp || ''
        });
        
        fetch(`/callingapp/call-details-by-lead?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.meeting_details && data.meeting_details.length > 0) {
                    // Get most recent meeting detail
                    const latestDetail = data.meeting_details[0];
                    populateMeetingForm(latestDetail);
                } else {
                    // Clear form if no existing data
                    clearMeetingForm();
                }
            })
            .catch(error => {
                console.error('Error fetching meeting details:', error);
                // Clear form on error
                clearMeetingForm();
            });
    }

    function populateMeetingForm(meetingDetail) {
        try {
            // Set employee selection
            const employeeSelect = document.getElementById('calledByEmployee');
            if (employeeSelect && meetingDetail.called_by_employee_name) {
                // Find and select the employee
                for (let i = 0; i < employeeSelect.options.length; i++) {
                    if (employeeSelect.options[i].text === meetingDetail.called_by_employee_name) {
                        employeeSelect.selectedIndex = i;
                        break;
                    }
                }
            }
            
            // Set rating
            if (meetingDetail.rating) {
                document.getElementById('rating').value = meetingDetail.rating;
                updateStarRating(meetingDetail.rating);
            }
            
            // Set meeting conclusion
            if (meetingDetail.meeting_conclusion) {
                document.getElementById('meetingConclusion').value = meetingDetail.meeting_conclusion;
            }
            
            // Set next call date
            if (meetingDetail.next_call_date) {
                const nextCallDate = new Date(meetingDetail.next_call_date);
                const formattedDate = nextCallDate.toISOString().slice(0, 16); // Format for datetime-local
                document.getElementById('nextCallDate').value = formattedDate;
            }
            
            // Set additional notes
            if (meetingDetail.additional_notes) {
                document.getElementById('additionalNotes').value = meetingDetail.additional_notes;
            }
            
            // Show notification that data was loaded
            showToast('Previous meeting details loaded', 'info', 2000);
            
        } catch (error) {
            console.error('Error populating meeting form:', error);
            showToast('Error loading previous data', 'error');
        }
    }

    function updateStarRating(rating) {
        const stars = document.querySelectorAll('.star-rating i');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('active');
                star.style.color = '#ffc107';
            } else {
                star.classList.remove('active');
                star.style.color = '#e9ecef';
            }
        });
    }

    function showEmployeeModal() {
        const modal = new bootstrap.Modal(document.getElementById('employeeModal'));
        modal.show();
        
        // Load existing employees when modal opens
        loadExistingEmployees();
    }

    function loadExistingEmployees() {
        console.log('=== LOADING EXISTING EMPLOYEES ===');
        
        fetch('/callingapp/employees')
            .then(response => response.json())
            .then(data => {
                console.log('Employees data:', data);
                
                if (data.success && data.employees.length > 0) {
                    displayExistingEmployees(data.employees);
                } else {
                    displayNoEmployeesMessage();
                }
            })
            .catch(error => {
                console.error('Error loading employees:', error);
                displayNoEmployeesMessage();
            });
    }

    function displayExistingEmployees(employees) {
        const container = document.getElementById('existingEmployeesList');
        
        let html = '';
        employees.forEach(employee => {
            // Note: Using 'active' field instead of 'status' based on database schema
            const isActive = employee.active === 1; // Active is 1, Inactive is 0
            const statusBadge = isActive ? 
                '<span class="status-badge status-active">Active</span>' : 
                '<span class="status-badge status-inactive">Inactive</span>';
            
            html += `
                <div class="employee-item">
                    <div class="employee-info">
                        <div class="employee-name">${employee.name}</div>
                        <div class="employee-email">${employee.email}</div>
                    </div>
                    <div class="employee-status">
                        ${statusBadge}
                    </div>
                </div>
            `;
        });
        
        container.innerHTML = html;
    }

    function displayNoEmployeesMessage() {
        const container = document.getElementById('existingEmployeesList');
        container.innerHTML = `
            <div class="no-employees">
                <i class="fas fa-users"></i>
                <h6>No Employees Found</h6>
                <p>No employees have been added yet. Add your first employee below.</p>
            </div>
        `;
    }

    function loadEmployees(preSelectName = null) {
        console.log('=== LOADING EMPLOYEES ===');
        console.log('Pre-select name:', preSelectName);
        
        const select = document.getElementById('calledByEmployee');
        if (!select) {
            console.error('Employee select element not found!');
            return;
        }
        
        // Show loading state
        select.innerHTML = '<option value="">Loading employees...</option>';
        select.disabled = true;
        
        const startTime = performance.now();
        
        // Add cache-busting timestamp
        const timestamp = new Date().getTime();
        fetch(`/callingapp/employees?t=${timestamp}`, {
            method: 'GET',
            headers: {
                'Cache-Control': 'no-cache',
                'Pragma': 'no-cache'
            }
        })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                const endTime = performance.now();
                console.log('Fetch took:', (endTime - startTime).toFixed(2), 'ms');
                console.log('Received data:', data);
                
                // Re-enable select
                select.disabled = false;
                
                if (data.success) {
                    console.log('Employees count:', data.employees ? data.employees.length : 0);
                    
                    select.innerHTML = '<option value="">Select Employee...</option>';
                    
                    if (data.employees && data.employees.length > 0) {
                        data.employees.forEach((employee, index) => {
                            console.log(`Adding employee ${index + 1}:`, employee);
                            
                            const option = document.createElement('option');
                            option.value = `${employee.name}|${employee.email}`;
                            option.textContent = `${employee.name} (${employee.email})`;
                            
                            // Pre-select if this employee matches who called
                            if (preSelectName && employee.name === preSelectName) {
                                option.selected = true;
                                console.log('Pre-selecting employee:', employee.name);
                            }
                            
                            select.appendChild(option);
                        });
                        
                        console.log('Total options added:', select.options.length - 1); // -1 for the default option
                        
                        // If someone was pre-selected, show a notification
                        if (preSelectName && preSelectName !== 'Not called yet') {
                            showToast(`Pre-selected: ${preSelectName} (last caller)`, 'info', 2000);
                        }
                    } else {
                        console.warn('No employees found in response');
                        select.innerHTML = '<option value="">No employees available</option>';
                        showToast('No employees available', 'warning');
                    }
                } else {
                    console.error('Server returned error:', data.message);
                    select.innerHTML = '<option value="">Error loading employees</option>';
                    showToast(data.message || 'Failed to load employees', 'error');
                }
            })
            .catch(error => {
                console.error('=== FETCH ERROR ===');
                console.error('Error type:', error.name);
                console.error('Error message:', error.message);
                console.error('Full error:', error);
                
                // Show error state in select
                select.innerHTML = '<option value="">Failed to load</option>';
                select.disabled = false;
                
                showToast('Failed to load employees', 'error');
                
                // Retry once after a delay
                setTimeout(() => {
                    console.log('Retrying employee load...');
                    loadEmployees(preSelectName);
                }, 3000);
            });
    }

    function addEmployee() {
        const form = document.getElementById('employeeForm');
        const formData = new FormData(form);
        
        fetch('/callingapp/add-employee', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: formData.get('name'),
                email: formData.get('email')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                form.reset();
                
                // Refresh the existing employees list
                loadExistingEmployees();
                
                // Reload employees if meeting modal is open
                if (document.getElementById('meetingModal').classList.contains('show')) {
                    loadEmployees();
                }
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error adding employee:', error);
            showToast('Failed to add employee', 'error');
        });
    }

    function saveCallDetails() {
        console.log('=== SAVE CALL DETAILS START ===');
        
        const form = document.getElementById('meetingForm');
        if (!form) {
            console.error('Meeting form not found!');
            showToast('Meeting form not found!', 'error');
            return;
        }
        
        const formData = new FormData(form);
        console.log('Form data entries:', Array.from(formData.entries()));
        
        // Get selected employee info
        const employeeSelect = document.getElementById('calledByEmployee');
        if (!employeeSelect) {
            console.error('Employee select not found!');
            showToast('Employee select not found!', 'error');
            return;
        }
        
        const selectedEmployee = employeeSelect.value;
        console.log('Selected employee:', selectedEmployee);
        
        if (!selectedEmployee) {
            console.error('No employee selected');
            showToast('Please select an employee', 'error');
            return;
        }
        
        // Get rating value
        const ratingValue = document.getElementById('rating').value;
        console.log('Rating value:', ratingValue);
        
        if (!ratingValue || ratingValue === '0') {
            console.error('No rating selected');
            showToast('Please select a rating', 'error');
            return;
        }
        
        // Get form values with fallbacks
        const leadFullName = document.getElementById('leadFullName').value || '';
        const leadBusinessName = document.getElementById('leadBusinessName').value || '';
        const leadEmail = document.getElementById('leadEmail').value || '';
        const leadWhatsapp = document.getElementById('leadWhatsapp').value || '';
        const leadWebsiteUrl = document.getElementById('leadWebsiteUrl').value || '';
        const meetingConclusion = document.getElementById('meetingConclusion').value || '';
        const nextCallDate = document.getElementById('nextCallDate').value || '';
        const additionalNotes = document.getElementById('additionalNotes').value || '';
        
        console.log('Form values:', {
            leadFullName, leadBusinessName, leadEmail, leadWhatsapp, 
            leadWebsiteUrl, meetingConclusion, nextCallDate, additionalNotes
        });
        
        // Validate required fields
        if (!leadFullName.trim()) {
            console.error('Lead full name is empty');
            showToast('Lead full name is required', 'error');
            return;
        }
        
        if (!leadBusinessName.trim()) {
            console.error('Lead business name is empty');
            showToast('Lead business name is required', 'error');
            return;
        }
        
        if (!leadEmail.trim()) {
            console.error('Lead email is empty');
            showToast('Lead email is required', 'error');
            return;
        }
        
        if (!leadWhatsapp.trim()) {
            console.error('Lead WhatsApp is empty');
            showToast('Lead WhatsApp is required', 'error');
            return;
        }
        
        if (!leadWebsiteUrl.trim()) {
            console.error('Lead website URL is empty');
            showToast('Lead website URL is required', 'error');
            return;
        }
        
        if (!meetingConclusion.trim()) {
            console.error('Meeting conclusion is empty');
            showToast('Meeting conclusion is required', 'error');
            return;
        }
        
        const [employeeName, employeeEmail] = selectedEmployee.split('|');
        
        const callData = {
            lead_full_name: leadFullName.trim(),
            lead_business_name: leadBusinessName.trim(),
            lead_email: leadEmail.trim(),
            lead_whatsapp: leadWhatsapp.trim(),
            lead_website_url: leadWebsiteUrl.trim(),
            called_by_employee_name: employeeName.trim(),
            called_by_employee_email: employeeEmail.trim(),
            rating: parseInt(ratingValue),
            meeting_conclusion: meetingConclusion.trim(),
            next_call_date: nextCallDate ? nextCallDate : null,
            additional_notes: additionalNotes ? additionalNotes.trim() : null
        };
        
        console.log('=== SENDING DATA ===');
        console.log('Data to save:', callData);
        console.log('JSON string:', JSON.stringify(callData, null, 2));
        
        // Show loading state
        showToast('Saving...', 'info');
        
        fetch('/callingapp/save-call-details', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(callData)
        })
        .then(response => {
            console.log('=== RESPONSE RECEIVED ===');
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            console.log('Response ok:', response.ok);
            
            if (!response.ok) {
                console.error('Response not OK:', response.status, response.statusText);
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('=== RESPONSE DATA ===');
            console.log('Response data:', data);
            console.log('Success status:', data.success);
            console.log('Message:', data.message);
            
            if (data.success) {
                console.log('Save successful - showing success message');
                
                // Show appropriate message based on action
                if (data.action === 'updated') {
                    showToast('Meeting details updated successfully!', 'success');
                } else {
                    showToast('Meeting details saved successfully!', 'success');
                }
                
                resetCompleteForm();
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('meetingModal'));
                if (modal) {
                    modal.hide();
                } else {
                    console.error('Could not find modal instance');
                }
                
                // Refresh the table data to show updated "Who Called?" information
                // syncGoogleSheets(true);
                
                // Redirect to callingapp page for full refresh
                console.log('Redirecting to /callingapp for full page refresh...');
                window.location.href = '/callingapp';
            } else {
                console.error('Save failed - showing error message');
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('=== FETCH ERROR ===');
            console.error('Error type:', error.name);
            console.error('Error message:', error.message);
            console.error('Full error:', error);
            showToast('Failed to save call details', 'error');
        });
    }

    function clearBrowserCache() {
        console.log('=== CLEARING BROWSER CACHE ===');
        
        // Clear localStorage
        localStorage.clear();
        console.log('localStorage cleared');
        
        // Clear sessionStorage
        sessionStorage.clear();
        console.log('sessionStorage cleared');
        
        // Show message
        alert('Browser cache cleared! Try saving again.');
        showToast('Browser cache cleared', 'info');
    }

    function testDatabaseConnection() {
        console.log('=== TESTING DATABASE CONNECTION ===');
        
        // Show loading message
        showToast('Testing database connection...', 'info');
        
        fetch('/callingapp/test-connection', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Test response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Database test result:', data);
            if (data.success) {
                showToast('✅ ' + data.message + ' (Records: ' + data.meeting_call_details_count + ')', 'success', 5000);
            } else {
                showToast('❌ ' + data.message, 'error', 5000);
            }
        })
        .catch(error => {
            console.error('Database test error:', error);
            showToast('❌ Network error: ' + error.message, 'error', 5000);
        });
    }

    function openCallHistoryPage() {
        console.log('=== OPENING CALL HISTORY PAGE ===');
        
        // Navigate to Call History page in same tab with source info
        const source = document.getElementById('manual-tab').classList.contains('active') ? 'manual' : 'google';
        window.location.href = `/callhistory?source=${source}`;
        
        console.log('✅ Call History page opened in same tab');
    }

    
    function testSaveFunction() {
        console.log('=== TEST SAVE FUNCTION ===');
        alert('Save button is working! Check console for details.');
        
        // Test if saveCallDetails function exists
        if (typeof saveCallDetails === 'function') {
            console.log('✅ saveCallDetails function exists');
            alert('saveCallDetails function exists and is callable');
        } else {
            console.error('❌ saveCallDetails function does not exist');
            alert('ERROR: saveCallDetails function not found');
        }
    }

    function testDatabaseConnection() {
        console.log('=== TESTING DATABASE CONNECTION ===');
        
        // Show loading message
        showToast('Testing database connection...', 'info');
        
        fetch('/callingapp/test-connection', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Test response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Database test result:', data);
            if (data.success) {
                showToast('✅ ' + data.message + ' (Records: ' + data.meeting_call_details_count + ')', 'success', 5000);
            } else {
                showToast('❌ ' + data.message, 'error', 5000);
            }
        })
        .catch(error => {
            console.error('Database test error:', error);
            showToast('❌ Network error: ' + error.message, 'error', 5000);
        });
    }

    function clearMeetingForm() {
        console.log('Clearing meeting form fields...');
        
        // Reset rating
        document.getElementById('rating').value = '0';
        updateStarRating(0);
        
        // Reset employee dropdown
        const employeeSelect = document.getElementById('calledByEmployee');
        if (employeeSelect) {
            employeeSelect.selectedIndex = 0;
        }
        
        // Reset text areas
        const meetingConclusion = document.getElementById('meetingConclusion');
        if (meetingConclusion) {
            meetingConclusion.value = '';
        }
        
        const nextCallDate = document.getElementById('nextCallDate');
        if (nextCallDate) {
            nextCallDate.value = '';
        }
        
        const additionalNotes = document.getElementById('additionalNotes');
        if (additionalNotes) {
            additionalNotes.value = '';
        }
        
        console.log('Form fields cleared successfully');
    }

    function resetCompleteForm() {
        console.log('Resetting complete form...');
        
        // Reset form using HTML5 reset
        const form = document.getElementById('meetingForm');
        if (form) {
            form.reset();
        }
        
        // Reset hidden fields
        document.getElementById('leadFullName').value = '';
        document.getElementById('leadBusinessName').value = '';
        document.getElementById('leadEmail').value = '';
        document.getElementById('leadWhatsapp').value = '';
        document.getElementById('leadWebsiteUrl').value = '';
        
        // Reset form fields
        clearMeetingForm();
        
        console.log('Complete form reset successfully');
    }

    // Star rating functionality
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-rating i');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.dataset.rating);
                document.getElementById('rating').value = rating;
                
                // Update star display
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
            
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.dataset.rating);
                
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#e9ecef';
                    }
                });
            });
        });
        
        document.querySelector('.star-rating').addEventListener('mouseleave', function() {
            const currentRating = parseInt(document.getElementById('rating').value);
            
            stars.forEach((s, index) => {
                if (index < currentRating) {
                    s.style.color = '#ffc107';
                } else {
                    s.style.color = '#e9ecef';
                }
            });
        });
    });

    function showToast(message, type = 'info', duration = 3000) {
        console.log('=== SHOWING TOAST ===');
        console.log('Message:', message);
        console.log('Type:', type);
        console.log('Duration:', duration);
        
        const toastContainer = document.getElementById('toastContainer');
        
        if (!toastContainer) {
            console.error('Toast container not found! Using alert instead.');
            alert('[' + type.toUpperCase() + '] ' + message);
            return;
        }
        
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        const icon = type === 'success' ? 'fa-check-circle' : 
                    type === 'error' ? 'fa-exclamation-circle' : 
                    'fa-info-circle';
        
        toast.innerHTML = `
            <i class="fas ${icon}"></i>
            <span>${message}</span>
        `;
        
        toastContainer.appendChild(toast);
        console.log('Toast added to container:', toast);
        
        // Auto remove after duration
        setTimeout(() => {
            console.log('Removing toast after timeout');
            toast.style.animation = 'slideIn 0.3s ease reverse';
            setTimeout(() => {
                toast.remove();
                console.log('Toast removed');
            }, 300);
        }, duration);
    }

    // Auto-sync is disabled - only manual sync available
    // CSRF token is already in the meta tag from Blade template

    // Auto-sync is disabled - no visibility change handling needed

    // Custom Modal Functions
    function showLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function hideLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.remove('active');
        document.body.style.overflow = ''; // Restore background scrolling
    }

    // Close modal when clicking on overlay background
    document.getElementById('logoutModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideLogoutModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('logoutModal');
            if (modal.classList.contains('active')) {
                hideLogoutModal();
            }
        }
    });
    </script>

    <!-- Employee Modal -->
    <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeModalLabel">
                        <i class="fas fa-user-plus me-2"></i>
                        Add New Employee
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add New Employee Form -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-user-plus me-2"></i>
                            Add New Employee
                        </h6>
                        <form id="employeeForm">
                            <div class="mb-3">
                                <label for="employeeName" class="form-label">Employee Name</label>
                                <input type="text" class="form-control" id="employeeName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="employeeEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="employeeEmail" name="email" required>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Existing Employees Section -->
                    <div class="border-top pt-3">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-users me-2"></i>
                            Existing Employees
                        </h6>
                        <div id="existingEmployeesList" class="employee-list">
                            <div class="text-center">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">Loading employees...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="addEmployee()">Add Employee</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Meeting Modal -->
    <div class="modal fade" id="meetingModal" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="meetingModalLabel">
                        <i class="fas fa-calendar me-2"></i>
                        Schedule Meeting & Call Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="meetingForm">
                        <!-- Lead Information (hidden) -->
                        <input type="hidden" id="leadFullName" name="lead_full_name">
                        <input type="hidden" id="leadBusinessName" name="lead_business_name">
                        <input type="hidden" id="leadEmail" name="lead_email">
                        <input type="hidden" id="leadWhatsapp" name="lead_whatsapp">
                        <input type="hidden" id="leadWebsiteUrl" name="lead_website_url">
                        
                        <!-- Employee Selection -->
                        <div class="mb-3">
                            <label for="calledByEmployee" class="form-label">1. Who is called? <span class="text-danger">*</span></label>
                            <select class="form-select" id="calledByEmployee" name="called_by_employee" required>
                                <option value="">Select Employee...</option>
                            </select>
                        </div>

                        <!-- Rating -->
                        <div class="mb-3">
                            <label class="form-label">2. Rating of Call <span class="text-danger">*</span></label>
                            <div class="star-rating" id="starRating">
                                <i class="fas fa-star" data-rating="1"></i>
                                <i class="fas fa-star" data-rating="2"></i>
                                <i class="fas fa-star" data-rating="3"></i>
                                <i class="fas fa-star" data-rating="4"></i>
                                <i class="fas fa-star" data-rating="5"></i>
                            </div>
                            <input type="hidden" id="rating" name="rating" value="0" required>
                        </div>

                        <!-- Meeting Conclusion -->
                        <div class="mb-3">
                            <label for="meetingConclusion" class="form-label">3. Meeting Conclusion <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="meetingConclusion" name="meeting_conclusion" rows="6" 
                                placeholder="Enter conclusion points (e.g.,&#10;1. Customer interested in product&#10;2. Follow-up required next week&#10;3. Budget confirmed)" required></textarea>
                            <small class="form-text text-muted">Enter points one per line (e.g., 1. Point one, 2. Point two)</small>
                        </div>

                        <!-- Next Call Date -->
                        <div class="mb-3">
                            <label for="nextCallDate" class="form-label">4. Next Call Date & Time (Optional)</label>
                            <input type="datetime-local" class="form-control" id="nextCallDate" name="next_call_date">
                        </div>

                        <!-- Additional Notes -->
                        <div class="mb-3">
                            <label for="additionalNotes" class="form-label">5. Additional Notes</label>
                            <textarea class="form-control" id="additionalNotes" name="additional_notes" rows="3" 
                                placeholder="Any additional information..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" onclick="openCallHistoryPage()">
                        <i class="fas fa-history me-2"></i>
                        Call History
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="clearMeetingForm()">Clear</button>
                    <button type="button" class="btn btn-primary" onclick="saveCallDetails()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Star Rating CSS -->
    <style>
        .star-rating {
            display: flex;
            gap: 10px;
            font-size: 2rem;
        }
        
        .star-rating i {
            cursor: pointer;
            color: #e9ecef;
            transition: color 0.3s ease;
        }
        
        .star-rating i:hover,
        .star-rating i.active {
            color: #ffc107;
        }
        
        .star-rating i.active {
            transform: scale(1.1);
        }

        /* Employee List Styles */
        .employee-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .employee-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #e9ecef;
            transition: background-color 0.2s ease;
        }

        .employee-item:last-child {
            border-bottom: none;
        }

        .employee-item:hover {
            background-color: #e9ecef;
        }

        .employee-info {
            flex: 1;
        }

        .employee-name {
            font-weight: 600;
            color: #495057;
            margin-bottom: 4px;
        }

        .employee-email {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .employee-status {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }

        .no-employees {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .no-employees i {
            font-size: 3rem;
            margin-bottom: 16px;
            opacity: 0.5;
        }
    </style>

    <script>
    // Initialize the page - auto-sync enabled
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded - auto-sync enabled (40 second interval)');
        
        // Start auto-sync after 5 seconds to allow page to fully load
        setTimeout(() => {
            if (isAutoSyncEnabled) {
                startAutoSync();
                console.log('Auto-sync started - 40 second interval');
            }
        }, 5000);
        
        // Set max date for date inputs to today (immediate, no network request)
        const dateInputs = document.querySelectorAll('input[type="date"]');
        const today = new Date().toISOString().split('T')[0];
        dateInputs.forEach(input => {
            input.max = today;
        });
        
        // Add pagination click handlers to preserve tab state
        const paginationLinks = document.querySelectorAll('.pagination-btn:not([style*="background: var(--success-color)"])');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                if (href && !href.includes('recordings.all')) {
                    // Extract page and search parameters from URL
                    const url = new URL(href, window.location.origin);
                    const page = url.searchParams.get('page') || 1;
                    const search = url.searchParams.get('search') || '';
                    
                    // Check which tab is currently active
                    const isManualTabActive = document.getElementById('manual-tab').classList.contains('active');
                    
                    if (isManualTabActive) {
                        // Load manual leads data with pagination
                        loadManualLeadsDataWithPagination(page, search);
                    } else {
                        // Load Google Sheets data with pagination
                        loadGoogleSheetsDataWithPagination(page, search);
                    }
                }
            });
        });

        // Add search form AJAX handler
        const searchForm = document.querySelector('.search-section form');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchInput = this.querySelector('input[name="search"]');
                const search = searchInput ? searchInput.value : '';
                
                // Check which tab is currently active
                const isManualTabActive = document.getElementById('manual-tab').classList.contains('active');
                
                if (isManualTabActive) {
                    // Load manual leads data with search
                    loadManualLeadsDataWithPagination(1, search);
                } else {
                    // Load Google Sheets data with search
                    loadGoogleSheetsDataWithPagination(1, search);
                }
            });
        }
    });

    function showAddLeadsModal() {
        // Load current page leads for selection
        loadLeadsForSelection();
        const modal = new bootstrap.Modal(document.getElementById('addLeadsModal'));
        modal.show();
    }

    function loadLeadsForSelection() {
        // Get current page data from the table
        const tableRows = document.querySelectorAll('#leadsTable tbody tr');
        const leadsList = document.getElementById('leadsSelectionList');
        leadsList.innerHTML = '';

        tableRows.forEach((row, index) => {
            const cells = row.querySelectorAll('td');
            if (cells.length >= 4) {
                const fullName = cells[0].textContent.trim();
                const businessName = cells[1].textContent.trim();
                const email = cells[2].textContent.trim();
                const whatsapp = cells[3].textContent.trim();

                if (fullName && fullName !== 'No leads found') {
                    const leadItem = document.createElement('div');
                    leadItem.className = 'lead-selection-item';
                    leadItem.innerHTML = `
                        <div class="lead-info">
                            <strong>${fullName}</strong><br>
                            <small>${businessName} | ${email} | ${whatsapp}</small>
                        </div>
                        <button class="btn btn-success btn-sm" onclick="transferLeadToLeadsManagement(${index})">
                            <i class="fas fa-arrow-right"></i> Transfer
                        </button>
                    `;
                    leadsList.appendChild(leadItem);
                }
            }
        });

        if (leadsList.children.length === 0) {
            leadsList.innerHTML = '<p class="text-muted">No leads available for transfer</p>';
        }
    }

    function transferLeadToLeadsManagement(leadIndex) {
        // Redirect to leads management with the lead index
        window.location.href = `/callingappleads?lead_index=${leadIndex}`;
    }

    function switchTab(tabType) {
        // Remove active class from all tabs
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Add active class to selected tab
        if (tabType === 'google') {
            document.getElementById('google-tab').classList.add('active');
            // Load Google Sheet data via AJAX
            loadGoogleSheetsData();
        } else if (tabType === 'manual') {
            document.getElementById('manual-tab').classList.add('active');
            // Load Manual Leads data via AJAX
            loadManualLeadsData();
        }
    }

    function loadGoogleSheetsData() {
        // Show loading state
        const tableContainer = document.querySelector('.table-container');
        tableContainer.innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading Google Sheets data...</div>';
        
        // Get current page and search parameters
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page') || 1;
        const search = urlParams.get('search') || '';
        
        // Fetch Google Sheets data
        fetch(`{{ route('callingapp.index') }}?page=${page}&search=${search}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Extract the table content from the response
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTableContainer = doc.querySelector('.table-container');
            const statsBar = doc.querySelector('.stats-bar');
            const paginationContainer = doc.querySelector('.pagination-container');
            
            if (newTableContainer) {
                tableContainer.innerHTML = newTableContainer.innerHTML;
                // Update stats bar if available
                if (statsBar) {
                    document.querySelector('.stats-bar').innerHTML = statsBar.innerHTML;
                }
                // Update pagination section
                const currentPaginationContainer = document.querySelector('.pagination-container');
                if (currentPaginationContainer && paginationContainer) {
                    currentPaginationContainer.innerHTML = paginationContainer.innerHTML;
                }
                // Re-attach pagination event listeners
                attachPaginationListeners();
            } else {
                tableContainer.innerHTML = '<div class="text-center p-4 text-danger">Error loading data</div>';
            }
        })
        .catch(error => {
            console.error('Error loading Google Sheets data:', error);
            tableContainer.innerHTML = '<div class="text-center p-4 text-danger">Error loading data</div>';
        });
    }

    function loadGoogleSheetsDataWithPagination(page, search) {
        // Show loading state
        const tableContainer = document.querySelector('.table-container');
        tableContainer.innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading Google Sheets data...</div>';
        
        // Update URL without page reload
        const newUrl = `{{ route('callingapp.index') }}?page=${page}&search=${search}`;
        window.history.pushState({tab: 'google'}, '', newUrl);
        
        // Fetch Google Sheets data
        fetch(`{{ route('callingapp.index') }}?page=${page}&search=${search}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Extract the table content from the response
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTableContainer = doc.querySelector('.table-container');
            const statsBar = doc.querySelector('.stats-bar');
            const paginationContainer = doc.querySelector('.pagination-container');
            
            if (newTableContainer) {
                tableContainer.innerHTML = newTableContainer.innerHTML;
                // Update stats bar if available
                if (statsBar) {
                    document.querySelector('.stats-bar').innerHTML = statsBar.innerHTML;
                }
                // Update pagination section
                const currentPaginationContainer = document.querySelector('.pagination-container');
                if (currentPaginationContainer && paginationContainer) {
                    currentPaginationContainer.innerHTML = paginationContainer.innerHTML;
                }
                // Re-attach pagination event listeners
                attachPaginationListeners();
            } else {
                tableContainer.innerHTML = '<div class="text-center p-4 text-danger">Error loading data</div>';
            }
        })
        .catch(error => {
            console.error('Error loading Google Sheets data:', error);
            tableContainer.innerHTML = '<div class="text-center p-4 text-danger">Error loading data</div>';
        });
    }

    function attachPaginationListeners() {
        // Add pagination click handlers to preserve tab state
        const paginationLinks = document.querySelectorAll('.pagination-btn:not([style*="background: var(--success-color)"])');
        paginationLinks.forEach(link => {
            // Remove existing listeners to prevent duplicates
            link.replaceWith(link.cloneNode(true));
        });
        
        // Re-attach event listeners
        const newPaginationLinks = document.querySelectorAll('.pagination-btn:not([style*="background: var(--success-color)"])');
        newPaginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                if (href && !href.includes('recordings.all')) {
                    // Extract page and search parameters from URL
                    const url = new URL(href, window.location.origin);
                    const page = url.searchParams.get('page') || 1;
                    const search = url.searchParams.get('search') || '';
                    
                    // Check which tab is currently active
                    const isManualTabActive = document.getElementById('manual-tab').classList.contains('active');
                    
                    if (isManualTabActive) {
                        // Load manual leads data with pagination
                        loadManualLeadsDataWithPagination(page, search);
                    } else {
                        // Load Google Sheets data with pagination
                        loadGoogleSheetsDataWithPagination(page, search);
                    }
                }
            });
        });
    }

    function loadManualLeadsData() {
        // Show loading state
        const tableContainer = document.querySelector('.table-container');
        tableContainer.innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading manual leads...</div>';
        
        // Get current page and search parameters
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page') || 1;
        const search = urlParams.get('search') || '';
        
        // Fetch manual leads data
        fetch(`{{ route('callingapp.manual-leads') }}?page=${page}&search=${search}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Extract the table content from the response
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTableContainer = doc.querySelector('.table-container');
            const statsBar = doc.querySelector('.stats-bar');
            const paginationContainer = doc.querySelector('.pagination-container');
            
            if (newTableContainer) {
                tableContainer.innerHTML = newTableContainer.innerHTML;
                // Update stats bar if available
                if (statsBar) {
                    document.querySelector('.stats-bar').innerHTML = statsBar.innerHTML;
                }
                // Update pagination section
                const currentPaginationContainer = document.querySelector('.pagination-container');
                if (currentPaginationContainer && paginationContainer) {
                    currentPaginationContainer.innerHTML = paginationContainer.innerHTML;
                }
                // Re-attach pagination event listeners
                attachPaginationListeners();
            } else {
                tableContainer.innerHTML = '<div class="text-center p-4 text-danger">Error loading data</div>';
            }
        })
        .catch(error => {
            console.error('Error loading manual leads data:', error);
            tableContainer.innerHTML = '<div class="text-center p-4 text-danger">Error loading data</div>';
        });
    }

    function loadManualLeadsDataWithPagination(page, search) {
        // Show loading state
        const tableContainer = document.querySelector('.table-container');
        tableContainer.innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading manual leads...</div>';
        
        // Update URL without page reload
        const newUrl = `{{ route('callingapp.manual-leads') }}?page=${page}&search=${search}`;
        window.history.pushState({tab: 'manual'}, '', newUrl);
        
        // Fetch manual leads data
        fetch(`{{ route('callingapp.manual-leads') }}?page=${page}&search=${search}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Extract the table content from the response
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTableContainer = doc.querySelector('.table-container');
            const statsBar = doc.querySelector('.stats-bar');
            const paginationContainer = doc.querySelector('.pagination-container');
            
            if (newTableContainer) {
                tableContainer.innerHTML = newTableContainer.innerHTML;
                // Update stats bar if available
                if (statsBar) {
                    document.querySelector('.stats-bar').innerHTML = statsBar.innerHTML;
                }
                // Update pagination section
                const currentPaginationContainer = document.querySelector('.pagination-container');
                if (currentPaginationContainer && paginationContainer) {
                    currentPaginationContainer.innerHTML = paginationContainer.innerHTML;
                }
                // Re-attach pagination event listeners
                attachPaginationListeners();
            } else {
                tableContainer.innerHTML = '<div class="text-center p-4 text-danger">Error loading data</div>';
            }
        })
        .catch(error => {
            console.error('Error loading manual leads data:', error);
            tableContainer.innerHTML = '<div class="text-center p-4 text-danger">Error loading data</div>';
        });
    }

    // Initialize with Google tab active - moved to main initialization
    // Tab switching is handled by the main DOMContentLoaded listener above
    </script>

    <!-- Add Leads Modal -->
    <div class="modal fade" id="addLeadsModal" tabindex="-1" aria-labelledby="addLeadsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLeadsModalLabel">
                        <i class="fas fa-user-plus me-2"></i>
                        Transfer Lead to Leads Management
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Select a lead from the current page to transfer it to the Leads Management system. The lead data will be automatically populated in the form.
                    </div>
                    <div id="leadsSelectionList" style="max-height: 400px; overflow-y: auto;">
                        <!-- Leads will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .lead-selection-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .lead-selection-item:hover {
            background-color: #f8f9fa;
            border-color: #007bff;
            box-shadow: 0 2px 4px rgba(0,123,255,0.1);
        }
        
        .lead-info {
            flex: 1;
        }
        
        .lead-info small {
            color: #6c757d;
        }
    </style>
</body>
</html>
