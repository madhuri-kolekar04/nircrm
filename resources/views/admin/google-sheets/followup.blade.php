<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Follow-up Management - NIRCRM</title>
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
            cursor: pointer;
            user-select: none;
            transition: all 0.3s ease;
            padding: 10px 15px;
            border-radius: 8px;
        }

        .app-title:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .app-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .today-indicator {
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
            text-decoration: none;
            margin-bottom: 15px;
        }

        .today-indicator:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: white;
            text-decoration: none;
        }

        .date-filter-section {
            padding: 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .date-filter-container {
            display: flex;
            gap: 15px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .date-input {
            padding: 10px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            min-width: 200px;
        }

        .date-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .filter-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .filter-btn:hover {
            background: var(--secondary-color);
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

        .time-badge {
            background: var(--info-color);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .rating-stars {
            color: var(--warning-color);
        }

        .rating-stars .empty {
            color: #e9ecef;
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

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Mobile scroll indicators */
        .table-container::before,
        .table-container::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 20px;
            pointer-events: none;
            z-index: 5;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .table-container::before {
            left: 0;
            background: linear-gradient(to right, rgba(255,255,255,1), rgba(255,255,255,0));
        }

        .table-container::after {
            right: 0;
            background: linear-gradient(to left, rgba(255,255,255,1), rgba(255,255,255,0));
        }

        .table-container.can-scroll-right::after {
            opacity: 1;
        }

        .table-container.scrolled-left::before {
            opacity: 1;
        }

        /* Touch feedback for mobile */
        @media (max-width: 768px) {
            .btn, .action-btn, .filter-btn {
                transition: transform 0.1s ease, box-shadow 0.1s ease;
            }

            .btn:active, .action-btn:active, .filter-btn:active {
                transform: scale(0.95);
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }
        }

        /* Better mobile focus states */
        @media (hover: none) and (pointer: coarse) {
            .btn:hover, .action-btn:hover, .filter-btn:hover {
                transform: none;
                box-shadow: none;
            }

            .btn:focus, .action-btn:focus, .filter-btn:focus {
                outline: 2px solid var(--primary-color);
                outline-offset: 2px;
            }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            body {
                padding: 0;
            }

            .app-container {
                border-radius: 0;
                margin: 0;
                min-height: 100vh;
            }

            .app-header {
                padding: 15px;
                position: relative;
            }

            .back-button {
                position: absolute;
                top: 10px;
                left: 10px;
                padding: 8px 12px;
                font-size: 0.8rem;
            }

            .back-button .back-text {
                display: none;
            }

            .back-button .back-icon {
                display: inline;
            }

            .app-title {
                font-size: 1.4rem;
                margin: 15px 0 8px 0;
                padding: 8px 12px;
            }

            .app-subtitle {
                font-size: 0.85rem;
                margin-bottom: 15px;
            }

            .today-indicator {
                padding: 8px 20px;
                font-size: 0.9rem;
                margin-bottom: 10px;
            }

            .date-filter-section {
                padding: 15px;
            }

            .date-filter-container {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .date-input {
                min-width: auto;
                width: 100%;
                padding: 12px;
                font-size: 1rem;
            }

            .filter-btn {
                width: 100%;
                justify-content: center;
                padding: 12px;
                font-size: 1rem;
            }

            .stats-bar {
                padding: 10px 15px;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .stat-item {
                font-size: 0.85rem;
                width: 100%;
            }

            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            /* Mobile table styles */
            .data-table {
                font-size: 0.85rem;
                min-width: 600px;
            }

            .data-table th,
            .data-table td {
                padding: 12px 8px;
            }

            .data-table th {
                font-size: 0.8rem;
                white-space: nowrap;
            }

            .lead-info {
                min-width: 150px;
            }

            .contact-info {
                min-width: 140px;
            }

            .action-buttons {
                min-width: 120px;
                justify-content: flex-start;
            }

            .action-btn {
                width: 32px;
                height: 32px;
                font-size: 0.85rem;
                margin-right: 4px;
            }

            .time-badge {
                font-size: 0.75rem;
                padding: 3px 8px;
                white-space: nowrap;
            }

            .toast {
                min-width: 280px;
                right: 10px;
                left: 10px;
                font-size: 0.9rem;
            }

            /* Mobile modal improvements */
            .modal-dialog {
                margin: 10px;
                max-width: calc(100% - 20px);
            }

            .modal-body {
                padding: 15px;
            }

            .modal-header {
                padding: 15px;
            }

            .modal-footer {
                padding: 15px;
                flex-direction: column;
                gap: 10px;
            }

            .modal-footer .btn {
                width: 100%;
            }

            /* Form improvements for mobile */
            .form-control {
                font-size: 16px; /* Prevents zoom on iOS */
            }

            .star-rating {
                font-size: 1.2rem;
                gap: 8px;
            }

            /* Better touch targets */
            .btn, .action-btn {
                min-height: 44px; /* iOS touch target recommendation */
            }

            .action-btn {
                min-height: 32px;
            }
        }

        @media (max-width: 480px) {
            .app-header {
                padding: 10px;
            }

            .back-button {
                top: 8px;
                left: 8px;
                padding: 6px 10px;
                font-size: 0.75rem;
            }

            .back-button .back-text {
                display: none;
            }

            .back-button .back-icon {
                display: inline;
            }

            .app-title {
                font-size: 1.2rem;
                margin: 12px 0 6px 0;
                padding: 6px 10px;
            }

            .app-subtitle {
                font-size: 0.8rem;
                margin-bottom: 12px;
            }

            .today-indicator {
                padding: 6px 15px;
                font-size: 0.85rem;
            }

            .date-filter-section {
                padding: 10px;
            }

            .date-filter-container {
                gap: 8px;
            }

            .date-input {
                padding: 10px;
                font-size: 0.9rem;
            }

            .filter-btn {
                padding: 10px;
                font-size: 0.9rem;
            }

            .stats-bar {
                padding: 8px 10px;
            }

            .stat-item {
                font-size: 0.8rem;
            }

            .data-table {
                font-size: 0.8rem;
                min-width: 550px;
            }

            .data-table th,
            .data-table td {
                padding: 10px 6px;
            }

            .data-table th {
                font-size: 0.75rem;
            }

            .lead-name {
                font-size: 0.85rem;
            }

            .lead-business {
                font-size: 0.75rem;
            }

            .contact-info {
                font-size: 0.75rem;
            }

            .email-link, .whatsapp-link {
                font-size: 0.75rem;
                word-break: break-all;
            }

            .time-badge {
                font-size: 0.7rem;
                padding: 2px 6px;
            }

            .action-btn {
                width: 28px;
                height: 28px;
                font-size: 0.75rem;
            }

            .toast {
                min-width: 260px;
                font-size: 0.85rem;
                padding: 12px 15px;
            }

            .modal-dialog {
                margin: 5px;
                max-width: calc(100% - 10px);
            }

            .modal-body,
            .modal-header,
            .modal-footer {
                padding: 10px;
            }

            .star-rating {
                font-size: 1rem;
                gap: 6px;
            }

            /* Better small screen handling */
            .table-container {
                margin: 0 -10px;
                padding: 0 10px;
            }
        }

        /* Extra small screens */
        @media (max-width: 360px) {
            .app-title {
                font-size: 1.1rem;
            }

            .data-table {
                min-width: 500px;
            }

            .data-table th,
            .data-table td {
                padding: 8px 4px;
            }

            .action-btn {
                width: 26px;
                height: 26px;
                font-size: 0.7rem;
            }
        }

        /* Landscape mode for mobile */
        @media (max-width: 768px) and (orientation: landscape) {
            .app-header {
                padding: 8px 15px;
            }

            .app-title {
                font-size: 1.3rem;
                margin: 8px 0 4px 0;
            }

            .app-subtitle {
                font-size: 0.8rem;
                margin-bottom: 8px;
            }

            .date-filter-section {
                padding: 10px 15px;
            }

            .date-filter-container {
                flex-direction: row;
                flex-wrap: wrap;
                gap: 8px;
            }

            .date-input {
                flex: 1;
                min-width: 150px;
            }

            .filter-btn {
                flex: 0 0 auto;
                width: auto;
                padding: 8px 15px;
            }
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: white;
            text-decoration: none;
        }

        .back-button .back-text {
            display: inline;
        }

        .back-button .back-icon {
            display: inline;
        }

        .lead-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .lead-name {
            font-weight: 600;
            color: var(--primary-color);
        }

        .lead-business {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-size: 0.85rem;
        }

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

        /* Star Rating Styles */
        .star-rating {
            display: flex;
            gap: 10px;
            font-size: 1.5rem;
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
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Header -->
        <div class="app-header">
            <h1 class="app-title" onclick="refreshPage()">
                <i class="fas fa-calendar-check me-2"></i>
                Follow-up Management
            </h1>
            <p class="app-subtitle">Manage your scheduled follow-ups and callbacks</p>
            
            <div class="header-buttons">
                <a href="/callingapp" class="today-indicator">
                    <i class="fas fa-calendar-day"></i>
                    <span>Today: <strong>{{ $todayCount }}</strong></span>
                </a>
            </div>
        </div>

        <!-- Date Filter Section -->
        <div class="date-filter-section">
            <div class="date-filter-container">
                <label for="dateFilter" class="form-label mb-0">Select Date:</label>
                <input type="date" 
                       id="dateFilter" 
                       class="date-input" 
                       value="{{ $selectedDate }}">
                <button class="filter-btn" onclick="filterByDate()">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                </button>
                <button class="filter-btn" onclick="goToToday()" style="background: var(--success-color);">
                    <i class="fas fa-calendar-day"></i>
                    <span>Today</span>
                </button>
            </div>
        </div>

        <!-- Stats Bar -->
        <div class="stats-bar">
            <div class="stat-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Selected Date: <strong>{{ \Carbon\Carbon::parse($selectedDate)->format('M d, Y') }}</strong></span>
            </div>
            <div class="stat-item">
                <i class="fas fa-list"></i>
                <span>Total Follow-ups: <strong>{{ $followupEntries->count() }}</strong></span>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            @if(isset($error))
                <div class="no-data">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h3>{{ $error }}</h3>
                    <p>Please try again or contact support.</p>
                </div>
            @elseif($followupEntries->isEmpty())
                <div class="no-data">
                    <i class="fas fa-calendar-times"></i>
                    <h3>No follow-ups scheduled</h3>
                    <p>No follow-ups found for {{ \Carbon\Carbon::parse($selectedDate)->format('M d, Y') }}.</p>
                </div>
            @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Lead Information</th>
                            <th>Contact Details</th>
                            <th>Call Time</th>
                            <th>Who Called?</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($followupEntries as $entry)
                            <tr>
                                <td>
                                    <div class="lead-info">
                                        <div class="lead-name">{{ $entry->lead_full_name }}</div>
                                        <div class="lead-business">{{ $entry->lead_business_name }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="contact-info">
                                        @if(!empty($entry->lead_email))
                                            <a href="mailto:{{ $entry->lead_email }}" class="email-link">
                                                <i class="fas fa-envelope me-1"></i>
                                                {{ $entry->lead_email }}
                                            </a>
                                        @endif
                                        @if(!empty($entry->lead_whatsapp))
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9+]/', '', $entry->lead_whatsapp) }}" 
                                               target="_blank" 
                                               class="whatsapp-link">
                                                <i class="fab fa-whatsapp me-1"></i>
                                                {{ $entry->lead_whatsapp }}
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if(!empty($entry->next_call_date))
                                        <span class="time-badge">
                                            {{ \Carbon\Carbon::parse($entry->next_call_date)->format('h:i A') }}
                                        </span>
                                    @else
                                        <span class="text-muted">No time set</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-user me-1 text-muted"></i>
                                        <span>{{ $entry->called_by_employee_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn call" 
                                                onclick="makePhoneCall('{{ $entry->lead_whatsapp }}')"
                                                title="Call">
                                            <i class="fas fa-phone"></i>
                                        </button>
                                        <button class="action-btn meeting" 
                                                onclick="openCallModal('{{ $entry->lead_full_name }}', '{{ $entry->lead_business_name }}', '{{ $entry->lead_email }}', '{{ $entry->lead_whatsapp }}', '{{ $entry->lead_website_url ?? '' }}', '{{ $entry->called_by_employee_name }}', '{{ $entry->called_by_employee_email }}')"
                                                title="Schedule Meeting">
                                            <i class="fas fa-calendar"></i>
                                        </button>
                                        <button class="action-btn view" 
                                                onclick="viewFullDetails({{ $entry->id }})"
                                                title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDetailsModalLabel">
                        <i class="fas fa-eye me-2"></i>
                        Follow-up Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="viewDetailsContent">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading details...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="openCallModalFromView()">
                        <i class="fas fa-phone me-2"></i>
                        Schedule Call
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Meeting & Call Details Modal -->
    <div class="modal fade" id="meetingModal" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="meetingModalLabel">
                        <i class="fas fa-calendar-plus me-2"></i>
                        Schedule Meeting & Call Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="meetingForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="leadFullName" class="form-label">Lead Full Name *</label>
                                    <input type="text" class="form-control" id="leadFullName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="leadBusinessName" class="form-label">Business Name *</label>
                                    <input type="text" class="form-control" id="leadBusinessName" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="leadEmail" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="leadEmail" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="leadWhatsapp" class="form-label">WhatsApp *</label>
                                    <input type="text" class="form-control" id="leadWhatsapp" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="leadWebsiteUrl" class="form-label">Website URL *</label>
                                    <input type="url" class="form-control" id="leadWebsiteUrl" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="calledByEmployeeName" class="form-label">Who Called? *</label>
                                    <select class="form-control" id="calledByEmployeeName" required>
                                        <option value="">Select Employee</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating *</label>
                                    <div class="star-rating" id="starRating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star" data-rating="{{ $i }}"></i>
                                        @endfor
                                    </div>
                                    <input type="hidden" id="rating" name="rating" value="5" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nextCallDate" class="form-label">Next Call Date & Time (Optional)</label>
                                    <input type="datetime-local" class="form-control" id="nextCallDate">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="meetingConclusion" class="form-label">Meeting Conclusion *</label>
                            <textarea class="form-control" id="meetingConclusion" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="additionalNotes" class="form-label">Additional Notes</label>
                            <textarea class="form-control" id="additionalNotes" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="clearMeetingForm()">Clear</button>
                    <button type="button" class="btn btn-primary" onclick="saveCallDetails()">
                        <i class="fas fa-save me-2"></i>
                        Save Details
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    function showToast(message, type = 'info') {
        const toastContainer = document.getElementById('toastContainer');
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
        
        setTimeout(() => {
            toast.style.animation = 'slideIn 0.3s ease reverse';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    function refreshPage() {
        window.location.reload();
    }

    function filterByDate() {
        const selectedDate = document.getElementById('dateFilter').value;
        if (!selectedDate) {
            showToast('Please select a date', 'error');
            return;
        }
        
        // Update URL without page refresh
        const url = new URL(window.location);
        url.searchParams.set('date', selectedDate);
        window.history.pushState({}, '', url);
        
        // Load data for selected date
        loadFollowupEntries(selectedDate);
    }

    function goToToday() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('dateFilter').value = today;
        
        // Update URL without page refresh
        const url = new URL(window.location);
        url.searchParams.set('date', today);
        window.history.pushState({}, '', url);
        
        // Load today's data
        loadFollowupEntries(today);
    }

    function loadFollowupEntries(date) {
        showToast('Loading follow-up entries...', 'info');
        
        fetch(`/followup/entries?date=${date}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateTable(data.followup_entries);
                    updateStats(data.selected_date, data.count);
                    showToast(`Loaded ${data.count} follow-up entries`, 'success');
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error loading follow-up entries:', error);
                showToast('Failed to load follow-up entries', 'error');
            });
    }

    function updateTable(entries) {
        const tableBody = document.querySelector('.data-table tbody');
        const noDataDiv = document.querySelector('.no-data');
        
        if (entries.length === 0) {
            // Show no data message
            if (tableBody) {
                tableBody.innerHTML = '';
            }
            if (noDataDiv) {
                noDataDiv.style.display = 'block';
            }
            return;
        }
        
        // Hide no data message
        if (noDataDiv) {
            noDataDiv.style.display = 'none';
        }
        
        // Update table
        if (tableBody) {
            tableBody.innerHTML = '';
            
            entries.forEach(entry => {
                const tr = document.createElement('tr');
                
                const callDate = new Date(entry.next_call_date);
                const callTime = callDate.toLocaleTimeString('en-US', { 
                    hour: '2-digit', 
                    minute: '2-digit',
                    hour12: true 
                });
                
                tr.innerHTML = `
                    <td>
                        <div class="lead-info">
                            <div class="lead-name">${entry.lead_full_name}</div>
                            <div class="lead-business">${entry.lead_business_name}</div>
                        </div>
                    </td>
                    <td>
                        <div class="contact-info">
                            ${entry.lead_email ? `
                                <a href="mailto:${entry.lead_email}" class="email-link">
                                    <i class="fas fa-envelope me-1"></i>
                                    ${entry.lead_email}
                                </a>
                            ` : ''}
                            ${entry.lead_whatsapp ? `
                                <a href="https://wa.me/${entry.lead_whatsapp.replace(/[^0-9+]/g, '')}" target="_blank" class="whatsapp-link">
                                    <i class="fab fa-whatsapp me-1"></i>
                                    ${entry.lead_whatsapp}
                                </a>
                            ` : ''}
                        </div>
                    </td>
                    <td>
                        <span class="time-badge">${callTime}</span>
                    </td>
                    <td>
                        <div>
                            <i class="fas fa-user me-1 text-muted"></i>
                            <span>${entry.called_by_employee_name}</span>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn call" 
                                    onclick="makePhoneCall('${entry.lead_whatsapp}')"
                                    title="Call">
                                <i class="fas fa-phone"></i>
                            </button>
                            <button class="action-btn meeting" 
                                    onclick="openCallModal('${entry.lead_full_name}', '${entry.lead_business_name}', '${entry.lead_email}', '${entry.lead_whatsapp}', '${entry.lead_website_url || ''}', '${entry.called_by_employee_name}', '${entry.called_by_employee_email}')"
                                    title="Schedule Meeting">
                                <i class="fas fa-calendar"></i>
                            </button>
                            <button class="action-btn view" 
                                    onclick="viewFullDetails(${entry.id})"
                                    title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                `;
                
                tableBody.appendChild(tr);
            });
        }
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

    function viewFullDetails(entryId) {
        // Show loading state
        const modal = new bootstrap.Modal(document.getElementById('viewDetailsModal'));
        const contentDiv = document.getElementById('viewDetailsContent');
        
        contentDiv.innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading details...</p>
            </div>
        `;
        
        modal.show();
        
        // Fetch full details
        fetch(`/callingapp/meeting-call-detail/${entryId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayFullDetails(data.meeting_call_detail);
                } else {
                    contentDiv.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Failed to load details: ${data.message}
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error fetching details:', error);
                contentDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Failed to load details. Please try again.
                    </div>
                `;
            });
    }

    function displayFullDetails(details) {
        const contentDiv = document.getElementById('viewDetailsContent');
        
        const callDate = details.next_call_date ? new Date(details.next_call_date) : null;
        const callDateTime = callDate ? callDate.toLocaleString() : 'Not set';
        
        contentDiv.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary">Lead Information</h6>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Full Name:</strong></td>
                            <td>${details.lead_full_name}</td>
                        </tr>
                        <tr>
                            <td><strong>Business Name:</strong></td>
                            <td>${details.lead_business_name}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>
                                ${details.lead_email ? 
                                    `<a href="mailto:${details.lead_email}">${details.lead_email}</a>` : 
                                    'Not provided'
                                }
                            </td>
                        </tr>
                        <tr>
                            <td><strong>WhatsApp:</strong></td>
                            <td>
                                ${details.lead_whatsapp ? 
                                    `<a href="https://wa.me/${details.lead_whatsapp.replace(/[^0-9+]/g, '')}" target="_blank">${details.lead_whatsapp}</a>` : 
                                    'Not provided'
                                }
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Website:</strong></td>
                            <td>
                                ${details.lead_website_url ? 
                                    `<a href="${details.lead_website_url}" target="_blank">${details.lead_website_url}</a>` : 
                                    'Not provided'
                                }
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary">Call Information</h6>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Who Called:</strong></td>
                            <td>${details.called_by_employee_name}</td>
                        </tr>
                        <tr>
                            <td><strong>Employee Email:</strong></td>
                            <td>${details.called_by_employee_email}</td>
                        </tr>
                        <tr>
                            <td><strong>Rating:</strong></td>
                            <td>
                                <div class="rating-stars">
                                    ${generateRatingStars(details.rating)}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Next Call Date:</strong></td>
                            <td>${callDateTime}</td>
                        </tr>
                        <tr>
                            <td><strong>Created At:</strong></td>
                            <td>${new Date(details.created_at).toLocaleString()}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <h6 class="text-primary">Meeting Conclusion</h6>
                    <div class="border rounded p-3 bg-light">
                        ${details.meeting_conclusion || '<em class="text-muted">No conclusion provided</em>'}
                    </div>
                </div>
            </div>
            ${details.additional_notes ? `
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="text-primary">Additional Notes</h6>
                        <div class="border rounded p-3 bg-light">
                            ${details.additional_notes}
                        </div>
                    </div>
                </div>
            ` : ''}
        `;
        
        // Store current details for potential use in call modal
        window.currentViewDetails = details;
    }

    function openCallModalFromView() {
        if (window.currentViewDetails) {
            const details = window.currentViewDetails;
            openCallModal(
                details.lead_full_name,
                details.lead_business_name,
                details.lead_email,
                details.lead_whatsapp,
                details.lead_website_url,
                details.called_by_employee_name,
                details.called_by_employee_email
            );
            
            // Close view modal
            const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewDetailsModal'));
            viewModal.hide();
        }
    }

    function openCallModal(fullName, businessName, email, whatsapp, websiteUrl, whoCalled, whoCalledEmail) {
        // Clear form first
        clearMeetingForm();
        
        // Set lead information
        document.getElementById('leadFullName').value = fullName || '';
        document.getElementById('leadBusinessName').value = businessName || '';
        document.getElementById('leadEmail').value = email || '';
        document.getElementById('leadWhatsapp').value = whatsapp || '';
        document.getElementById('leadWebsiteUrl').value = websiteUrl || 'https://example.com';
        
        // Load employees and pre-select who called
        loadEmployees(whoCalled);
        
        // Fetch existing meeting details for this lead
        fetchMeetingDetails(fullName, businessName, email, whatsapp);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('meetingModal'));
        modal.show();
    }

    function fetchMeetingDetails(fullName, businessName, email, whatsapp) {
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
                }
            })
            .catch(error => {
                console.error('Error fetching meeting details:', error);
            });
    }

    function populateMeetingForm(details) {
        // Set rating
        if (details.rating) {
            setRating(details.rating);
        }
        
        // Set next call date
        if (details.next_call_date) {
            const callDate = new Date(details.next_call_date);
            // Format for datetime-local input (YYYY-MM-DDTHH:mm)
            const formattedDate = callDate.toISOString().slice(0, 16);
            document.getElementById('nextCallDate').value = formattedDate;
        }
        
        // Set meeting conclusion
        if (details.meeting_conclusion) {
            document.getElementById('meetingConclusion').value = details.meeting_conclusion;
        }
        
        // Set additional notes
        if (details.additional_notes) {
            document.getElementById('additionalNotes').value = details.additional_notes;
        }
    }

    function setRating(rating) {
        document.getElementById('rating').value = rating;
        
        // Update star display
        const stars = document.querySelectorAll('#starRating i');
        stars.forEach(star => {
            star.classList.remove('active');
            if (parseInt(star.dataset.rating) <= rating) {
                star.classList.add('active');
            }
        });
    }

    function loadEmployees(preSelectName = '') {
        fetch('/callingapp/employees')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById('calledByEmployeeName');
                    select.innerHTML = '<option value="">Select Employee</option>';
                    
                    data.employees.forEach(employee => {
                        const option = document.createElement('option');
                        option.value = employee.name;
                        option.textContent = employee.name;
                        // Store email in dataset for later use
                        option.dataset.email = employee.email;
                        if (employee.name === preSelectName) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading employees:', error);
            });
    }

    function clearMeetingForm() {
        document.getElementById('meetingForm').reset();
        
        // Reset rating to default (5 stars)
        setRating(5);
        
        // Clear other fields that might not be reset by form.reset()
        document.getElementById('nextCallDate').value = '';
        document.getElementById('meetingConclusion').value = '';
        document.getElementById('additionalNotes').value = '';
    }

    function saveCallDetails() {
        // Get form values
        const leadFullName = document.getElementById('leadFullName').value;
        const leadBusinessName = document.getElementById('leadBusinessName').value;
        const leadEmail = document.getElementById('leadEmail').value;
        const leadWhatsapp = document.getElementById('leadWhatsapp').value;
        const leadWebsiteUrl = document.getElementById('leadWebsiteUrl').value;
        
        // Get selected employee
        const selectedEmployee = document.getElementById('calledByEmployeeName');
        const employeeName = selectedEmployee.value;
        const employeeEmail = selectedEmployee.options[selectedEmployee.selectedIndex]?.dataset.email || '';
        
        // Get other values
        const rating = document.getElementById('rating').value;
        const meetingConclusion = document.getElementById('meetingConclusion').value;
        const nextCallDate = document.getElementById('nextCallDate').value;
        const additionalNotes = document.getElementById('additionalNotes').value;
        
        // Validate required fields
        if (!leadFullName || !leadBusinessName || !leadEmail || !leadWhatsapp || !leadWebsiteUrl || !employeeName || !employeeEmail || !rating || !meetingConclusion) {
            showToast('Please fill in all required fields', 'error');
            return;
        }
        
        // Validate rating
        if (rating < 1 || rating > 5) {
            showToast('Rating must be between 1 and 5', 'error');
            return;
        }
        
        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(leadEmail) || !emailRegex.test(employeeEmail)) {
            showToast('Please enter valid email addresses', 'error');
            return;
        }
        
        const data = {
            lead_full_name: leadFullName,
            lead_business_name: leadBusinessName,
            lead_email: leadEmail,
            lead_whatsapp: leadWhatsapp,
            lead_website_url: leadWebsiteUrl,
            called_by_employee_name: employeeName,
            called_by_employee_email: employeeEmail,
            rating: parseInt(rating),
            meeting_conclusion: meetingConclusion,
            next_call_date: nextCallDate || null,
            additional_notes: additionalNotes || ''
        };
        
        console.log('Saving data:', data);
        
        fetch('/callingapp/save-call-details', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(result => {
            console.log('Response data:', result);
            if (result.success) {
                showToast('Call details saved successfully!', 'success');
                const modal = bootstrap.Modal.getInstance(document.getElementById('meetingModal'));
                modal.hide();
                
                // Refresh the table
                const selectedDate = document.getElementById('dateFilter').value;
                loadFollowupEntries(selectedDate);
            } else {
                showToast('Failed to save: ' + result.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error saving details:', error);
            showToast('Failed to save details: ' + error.message, 'error');
        });
    }

    // Star rating functionality
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#starRating i');
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.dataset.rating);
                document.getElementById('rating').value = rating;
                
                stars.forEach(s => s.classList.remove('active'));
                stars.forEach(s => {
                    if (parseInt(s.dataset.rating) <= rating) {
                        s.classList.add('active');
                    }
                });
            });
        });
    });

    function generateRatingStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += '<i class="fas fa-star"></i>';
            } else {
                stars += '<i class="fas fa-star empty"></i>';
            }
        }
        return stars;
    }

    function updateStats(selectedDate, count) {
        const statsElements = document.querySelectorAll('.stat-item span');
        if (statsElements.length >= 2) {
            const date = new Date(selectedDate);
            const formattedDate = date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
            
            statsElements[0].innerHTML = `<strong>${formattedDate}</strong>`;
            statsElements[1].innerHTML = `<strong>${count}</strong>`;
        }
    }

    // Load data on page load based on URL parameters
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const dateParam = urlParams.get('date');
        
        if (dateParam && dateParam !== '{{ $selectedDate }}') {
            loadFollowupEntries(dateParam);
        }
        
        // Mobile-specific enhancements
        initMobileEnhancements();
    });

    // Mobile enhancements function
    function initMobileEnhancements() {
        // Detect mobile device
        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        
        if (isMobile) {
            // Add touch feedback for buttons
            const buttons = document.querySelectorAll('.btn, .action-btn, .filter-btn');
            buttons.forEach(button => {
                button.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.95)';
                });
                
                button.addEventListener('touchend', function() {
                    this.style.transform = 'scale(1)';
                });
            });
            
            // Improve table scrolling on mobile
            const tableContainer = document.querySelector('.table-container');
            if (tableContainer) {
                let isScrolling = false;
                
                tableContainer.addEventListener('scroll', function() {
                    if (!isScrolling) {
                        isScrolling = true;
                        tableContainer.style.scrollBehavior = 'smooth';
                        
                        // Add scroll indicators
                        if (this.scrollLeft > 0) {
                            this.classList.add('scrolled-left');
                        } else {
                            this.classList.remove('scrolled-left');
                        }
                        
                        if (this.scrollLeft < this.scrollWidth - this.clientWidth) {
                            this.classList.add('can-scroll-right');
                        } else {
                            this.classList.remove('can-scroll-right');
                        }
                        
                        setTimeout(() => {
                            isScrolling = false;
                        }, 100);
                    }
                });
            }
            
            // Handle mobile viewport height changes
            const handleViewportChange = () => {
                const vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', `${vh}px`);
            };
            
            handleViewportChange();
            window.addEventListener('resize', handleViewportChange);
            window.addEventListener('orientationchange', handleViewportChange);
            
            // Add swipe gestures for mobile (optional enhancement)
            addSwipeGestures();
        }
    }

    // Add swipe gestures for mobile navigation
    function addSwipeGestures() {
        let touchStartX = 0;
        let touchEndX = 0;
        
        document.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, false);
        
        document.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, false);
        
        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left - could trigger next action
                    console.log('Swipe left detected');
                } else {
                    // Swipe right - could trigger back action
                    console.log('Swipe right detected');
                    // Optionally go back
                    // window.history.back();
                }
            }
        }
    }

    // Enhanced mobile modal handling
    function openMobileModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            const bsModal = new bootstrap.Modal(modal);
            
            // Adjust modal for mobile
            if (window.innerWidth <= 768) {
                modal.querySelector('.modal-dialog').classList.add('modal-fullscreen-md-down');
            }
            
            bsModal.show();
        }
    }

    // Mobile-optimized toast notifications
    function showMobileToast(message, type = 'info') {
        const toastContainer = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        // Add mobile-specific styling
        if (window.innerWidth <= 768) {
            toast.style.cssText = `
                position: fixed;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                right: auto;
                top: auto;
                min-width: 280px;
                max-width: 90%;
                z-index: 9999;
            `;
        }
        
        const icon = type === 'success' ? 'fa-check-circle' : 
                    type === 'error' ? 'fa-exclamation-circle' : 
                    'fa-info-circle';
        
        toast.innerHTML = `
            <i class="fas ${icon}"></i>
            <span>${message}</span>
        `;
        
        toastContainer.appendChild(toast);
        
        // Auto-remove with animation
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    // Override showToast for mobile
    const originalShowToast = window.showToast;
    window.showToast = function(message, type = 'info') {
        if (window.innerWidth <= 768) {
            showMobileToast(message, type);
        } else {
            originalShowToast(message, type);
        }
    };

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(event) {
        const urlParams = new URLSearchParams(window.location.search);
        const dateParam = urlParams.get('date');
        
        if (dateParam) {
            document.getElementById('dateFilter').value = dateParam;
            loadFollowupEntries(dateParam);
        }
    });
    </script>
</body>
</html>
