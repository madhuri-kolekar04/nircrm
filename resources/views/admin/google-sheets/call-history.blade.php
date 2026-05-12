<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call History - NIRCRM</title>
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
            --light-bg: #f8f9fa;
            --white: #ffffff;
            --gray: #6c757d;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 10px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .history-container {
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            min-height: calc(100vh - 20px);
        }

        .history-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
            margin: 0;
            text-align: center;
        }

        .history-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .back-button {
            position: absolute;
            top: 30px;
            right: 30px;
            background: var(--white);
            color: var(--primary-color);
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            min-height: 44px;
            touch-action: manipulation;
        }

        .back-button .back-text {
            display: inline;
        }

        .back-button .back-icon {
            display: inline;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            background: var(--secondary-color);
            color: white;
        }

        .filters-section {
            background: var(--white);
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .filter-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .filter-item select,
        .filter-item input {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            min-height: 44px;
            touch-action: manipulation;
        }

        .filter-item select:focus,
        .filter-item input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-item label {
            font-weight: 600;
            color: var(--gray);
            margin-bottom: 5px;
        }


        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .stat-card {
            background: var(--white);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .history-grid {
            display: grid;
            gap: 20px;
            margin-top: 20px;
        }

        .history-item {
            background: var(--white);
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid var(--primary-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .history-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .employee-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .employee-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .employee-details {
            flex: 1;
        }

        .employee-email {
            font-size: 0.85rem;
            color: #ffffff;
            margin-top: 3px;
            font-weight: 500;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .conclusion-content {
            white-space: pre-line;
            line-height: 1.5;
        }

        .employee-name {
            font-weight: 700;
            font-size: 1.2rem;
            color: #dc3545;
            margin-bottom: 5px;
        }

        .lead-info {
            background: var(--light-bg);
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .lead-info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .lead-label {
            font-weight: 600;
            color: var(--gray);
            min-width: 120px;
        }

        .lead-value {
            color: var(--primary-color);
            word-break: break-all;
        }

        .call-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            background: rgba(255, 193, 7, 0.1);
            border-radius: 20px;
            margin-bottom: 15px;
        }

        .rating-stars {
            color: #ffc107;
            font-size: 1.2rem;
        }

        .rating-stars .empty {
            color: #ddd;
            opacity: 0.3;
        }

        .rating-text {
            font-weight: 600;
            color: var(--warning-color);
            font-size: 0.9rem;
        }

        .call-content {
            background: var(--light-bg);
            padding: 15px;
            border-radius: 8px;
            border-left: 3px solid var(--info-color);
        }

        .next-call-section {
            background: var(--light-bg);
            padding: 15px;
            border-radius: 8px;
            border-left: 3px solid var(--success-color);
        }

        .next-call-content {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: var(--success-color);
        }

        .additional-notes {
            background: var(--light-bg);
            padding: 15px;
            border-radius: 8px;
            border-left: 3px solid var(--warning-color);
            margin-top: 15px;
            font-style: italic;
        }

        .no-history {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray);
        }

        .no-history i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: var(--gray);
        }

        .no-history h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        /* Enhanced Mobile Responsive */
        @media (max-width: 768px) {
            body {
                padding: 0;
            }

            .history-container {
                margin: 0;
                border-radius: 0;
                min-height: 100vh;
            }

            .history-header {
                padding: 15px;
                position: relative;
                min-height: auto;
            }

            .history-header h1 {
                font-size: 1.5rem;
                flex-direction: column;
                gap: 8px;
                text-align: center;
                margin-bottom: 50px;
            }

            .back-button {
                position: absolute;
                top: 10px;
                right: 10px;
                padding: 8px 16px;
                font-size: 0.8rem;
                min-height: 40px;
            }

            .back-button .back-text {
                display: none;
            }

            .back-button .back-icon {
                display: inline;
            }

            .filters-section {
                padding: 15px;
                margin: 0;
                border-radius: 0;
            }

            .filter-group {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .filter-item {
                margin-bottom: 0;
            }

            .filter-item label {
                font-size: 0.9rem;
                margin-bottom: 6px;
            }

            .filter-item select,
            .filter-item input {
                padding: 12px;
                font-size: 16px; /* Prevents zoom on iOS */
                min-height: 48px;
            }

            .stats-section {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                padding: 0 15px;
            }

            .stat-card {
                padding: 15px;
                border-radius: 8px;
            }

            .stat-number {
                font-size: 1.8rem;
            }

            .stat-label {
                font-size: 0.8rem;
            }

            .history-grid {
                grid-template-columns: 1fr;
                gap: 12px;
                padding: 0 15px 15px;
            }

            .history-item {
                padding: 15px;
                border-radius: 8px;
            }

            .history-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                margin-bottom: 12px;
                padding-bottom: 12px;
            }

            .employee-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                width: 100%;
            }

            .employee-avatar {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }

            .employee-name {
                font-size: 1rem;
                line-height: 1.2;
            }

            .call-date-time {
                font-size: 0.85rem;
                margin-top: 4px;
            }

            .employee-email {
                font-size: 0.8rem;
                word-break: break-all;
            }

            .call-rating {
                padding: 8px 12px;
                font-size: 0.85rem;
                align-self: flex-start;
            }

            .rating-stars {
                font-size: 1rem;
            }

            .lead-info {
                padding: 12px;
                margin-bottom: 12px;
            }

            .lead-info-item {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 8px;
                gap: 4px;
            }

            .lead-label {
                min-width: auto;
                font-size: 0.8rem;
            }

            .lead-value {
                font-size: 0.9rem;
                word-break: break-all;
            }

            .call-content,
            .next-call-section,
            .additional-notes {
                padding: 12px;
                margin-bottom: 12px;
            }

            .section-header {
                font-size: 0.9rem;
                margin-bottom: 8px;
            }

            .conclusion-content,
            .notes-content {
                font-size: 0.9rem;
                line-height: 1.4;
            }

            .no-history {
                padding: 40px 20px;
            }

            .no-history h3 {
                font-size: 1.3rem;
            }

            .no-history p {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .history-header {
                padding: 12px;
            }

            .history-header h1 {
                font-size: 1.3rem;
                margin-bottom: 45px;
            }

            .back-button {
                top: 8px;
                right: 8px;
                padding: 6px 12px;
                font-size: 0.75rem;
                min-height: 36px;
            }

            .back-button .back-text {
                display: none;
            }

            .back-button .back-icon {
                display: inline;
            }

            .filters-section {
                padding: 12px;
            }

            .filter-group {
                gap: 10px;
            }

            .filter-item label {
                font-size: 0.85rem;
            }

            .filter-item select,
            .filter-item input {
                padding: 10px;
                font-size: 16px;
                min-height: 44px;
            }

            .stats-section {
                grid-template-columns: 1fr;
                gap: 10px;
                padding: 0 12px;
            }

            .stat-card {
                padding: 12px;
            }

            .stat-number {
                font-size: 1.6rem;
            }

            .stat-label {
                font-size: 0.75rem;
            }

            .history-grid {
                gap: 10px;
                padding: 0 12px 12px;
            }

            .history-item {
                padding: 12px;
            }

            .employee-info {
                gap: 8px;
            }

            .employee-avatar {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .employee-name {
                font-size: 0.9rem;
            }

            .call-date-time {
                font-size: 0.8rem;
            }

            .employee-email {
                font-size: 0.75rem;
            }

            .call-rating {
                padding: 6px 10px;
                font-size: 0.8rem;
            }

            .rating-stars {
                font-size: 0.9rem;
            }

            .lead-info {
                padding: 10px;
            }

            .lead-info-item {
                margin-bottom: 6px;
            }

            .lead-label {
                font-size: 0.75rem;
            }

            .lead-value {
                font-size: 0.85rem;
            }

            .call-content,
            .next-call-section,
            .additional-notes {
                padding: 10px;
            }

            .section-header {
                font-size: 0.85rem;
            }

            .conclusion-content,
            .notes-content {
                font-size: 0.85rem;
            }

            .no-history {
                padding: 30px 15px;
            }

            .no-history i {
                font-size: 3rem;
            }

            .no-history h3 {
                font-size: 1.2rem;
            }

            .no-history p {
                font-size: 0.85rem;
            }
        }

        /* Extra small screens */
        @media (max-width: 360px) {
            .history-header h1 {
                font-size: 1.2rem;
            }

            .back-button {
                padding: 5px 10px;
                font-size: 0.7rem;
                min-height: 32px;
            }

            .back-button .back-text {
                display: none;
            }

            .back-button .back-icon {
                display: inline;
            }

            .stat-number {
                font-size: 1.4rem;
            }

            .employee-avatar {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }

            .employee-name {
                font-size: 0.85rem;
            }

            .lead-value {
                font-size: 0.8rem;
            }
        }

        /* Touch feedback for mobile */
        @media (hover: none) and (pointer: coarse) {
            .back-button:hover,
            .history-item:hover {
                transform: none;
                box-shadow: none;
            }

            .back-button:active {
                transform: scale(0.95);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            }

            .history-item:active {
                transform: scale(0.98);
            }

            .filter-item select:active,
            .filter-item input:active {
                transform: scale(0.98);
            }
        }

        /* Landscape mode for mobile */
        @media (max-width: 768px) and (orientation: landscape) {
            .history-header {
                padding: 10px 15px;
            }

            .history-header h1 {
                font-size: 1.4rem;
                margin-bottom: 40px;
            }

            .back-button {
                top: 8px;
                right: 15px;
                padding: 6px 12px;
                font-size: 0.8rem;
            }

            .back-button .back-text {
                display: none;
            }

            .back-button .back-icon {
                display: inline;
            }

            .stats-section {
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
            }

            .stat-card {
                padding: 10px;
            }

            .stat-number {
                font-size: 1.4rem;
            }

            .stat-label {
                font-size: 0.7rem;
            }
        }

        /* Accessibility improvements */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .history-item {
                border-width: 2px;
            }

            .back-button,
            .filter-item select,
            .filter-item input {
                border-width: 2px;
            }
        }
    </style>
</head>
<body>
    <div class="history-container">
        <!-- Header -->
        <div class="history-header">
            <h1>
                <i class="fas fa-history"></i>
                Call History Management
            </h1>
            <a href="{{ request()->get('source') === 'manual' ? route('callingapp.manual-leads') : route('callingapp.index') }}" class="back-button">
                <span class="back-text">Back to Calling App</span>
                <i class="fas fa-arrow-right back-icon"></i>
            </a>
        </div>

        @if($allCallHistory->isEmpty())
            <!-- No History State -->
            <div class="no-history">
                <i class="fas fa-phone-slash"></i>
                <h3>No Call History Found</h3>
                <p>There are no call history records in the system yet.</p>
                <p>Start making calls to see the history appear here.</p>
            </div>
        @else
            <!-- Filters Section -->
            <div class="filters-section">
                <h3>
                    <i class="fas fa-filter"></i>
                    Filter & Search
                </h3>
                
                <div class="filter-group">
                    <div class="filter-item">
                        <label for="employeeFilter">Filter by Employee</label>
                        <select id="employeeFilter" class="form-select" onchange="filterHistory()">
                            <option value="">All Employees</option>
                            @foreach($allCallHistory->unique('called_by_employee_email')->pluck('called_by_employee_name') as $employee)
                                <option value="{{ $employee }}">{{ $employee }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="filter-item">
                        <label for="dateFilter">Filter by Date</label>
                        <input type="date" id="dateFilter" class="form-control" onchange="filterHistory()">
                    </div>
                    
                    <div class="filter-item">
                        <label for="searchFilter">Search by Lead Name or Email</label>
                        <input type="text" id="searchFilter" class="form-control" placeholder="Search..." onkeyup="filterHistory()">
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="stats-section">
                <div class="stat-card">
                    <div class="stat-number">{{ $allCallHistory->unique('called_by_employee_email')->count() }}</div>
                    <div class="stat-label">Unique Employees</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">{{ $allCallHistory->where('rating', '>=', 4)->count() }}</div>
                    <div class="stat-label">High Rated (4-5)</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">{{ $allCallHistory->where('rating', 3)->count() }}</div>
                    <div class="stat-label">Medium Rated (3)</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">{{ $allCallHistory->where('rating', '<=', 3)->count() }}</div>
                    <div class="stat-label">Low Rated (1-2)</div>
                </div>
            </div>

            <!-- History Grid -->
            <div class="history-grid">
                @foreach($allCallHistory as $call)
                    <div class="history-item">
                        <!-- Header -->
                        <div class="history-header">
                            <div class="employee-info">
                                <div class="employee-avatar">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="employee-details">
                                    <div class="employee-name">{{ $call->called_by_employee_name ?? 'Unknown' }}</div>
                                    <div class="call-date-time">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($call->created_at)->format('M d, Y H:i') }}
                                    </div>
                                    <div class="employee-email">
                                        <i class="fas fa-envelope"></i>
                                        {{ $call->called_by_employee_email ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="call-rating">
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $call->rating ? '' : 'empty' }}"></i>
                                    @endfor
                                </div>
                                <div class="rating-text">{{ $call->rating }}/5</div>
                            </div>
                        </div>
                        
                        <!-- Lead Information -->
                        <div class="lead-info">
                            @if($call->lead_email)
                                <div class="lead-info-item">
                                    <div class="lead-label">Lead Email:</div>
                                    <div class="lead-value">{{ $call->lead_email }}</div>
                                </div>
                            @endif
                            
                            @if($call->lead_full_name)
                                <div class="lead-info-item">
                                    <div class="lead-label">Lead Name:</div>
                                    <div class="lead-value">{{ $call->lead_full_name }}</div>
                                </div>
                            @endif
                            
                            @if($call->lead_business_name)
                                <div class="lead-info-item">
                                    <div class="lead-label">Business:</div>
                                    <div class="lead-value">{{ $call->lead_business_name }}</div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Call Content -->
                        <div class="call-content">
                            <div class="section-header">
                                <i class="fas fa-clipboard-check"></i>
                                <span>Meeting Conclusion</span>
                            </div>
                            <div class="conclusion-content">
                                {!! nl2br(e($call->meeting_conclusion)) !!}
                            </div>
                        </div>
                        
                        @if($call->next_call_date)
                            <div class="next-call-section">
                                <div class="section-header">
                                    <i class="fas fa-clock"></i>
                                    <span>Next Call Scheduled</span>
                                </div>
                                <div class="next-call-content">
                                    <i class="fas fa-bell"></i>
                                    {{ \Carbon\Carbon::parse($call->next_call_date)->format('M d, Y H:i') }}
                                </div>
                            </div>
                        @endif
                        
                        @if($call->additional_notes)
                            <div class="additional-notes">
                                <div class="section-header">
                                    <i class="fas fa-sticky-note"></i>
                                    <span>Additional Notes</span>
                                </div>
                                <div class="notes-content">{{ $call->additional_notes }}</div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enhanced filter functionality with mobile optimizations
        function filterHistory() {
            const employeeFilter = document.getElementById('employeeFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;
            const searchFilter = document.getElementById('searchFilter').value.toLowerCase();
            
            const historyItems = document.querySelectorAll('.history-item');
            let visibleCount = 0;
            
            historyItems.forEach(item => {
                const employeeName = item.querySelector('.employee-name')?.textContent.trim() || '';
                const employeeEmail = item.querySelector('.employee-email')?.textContent.trim() || '';
                const callDate = item.querySelector('.call-date-time')?.textContent || '';
                const leadEmail = item.querySelector('.lead-value')?.textContent || '';
                const leadName = item.querySelector('.lead-value')?.textContent || '';
                
                let showItem = true;
                
                // Employee filter
                if (employeeFilter && employeeName !== employeeFilter) {
                    showItem = false;
                }
                
                // Date filter - enhanced to handle different date formats
                if (dateFilter) {
                    const itemDate = new Date(callDate).toISOString().split('T')[0];
                    const filterDate = new Date(dateFilter).toISOString().split('T')[0];
                    if (itemDate !== filterDate) {
                        showItem = false;
                    }
                }
                
                // Search filter
                if (searchFilter && 
                    !leadEmail.toLowerCase().includes(searchFilter) && 
                    !leadName.toLowerCase().includes(searchFilter) &&
                    !employeeName.toLowerCase().includes(searchFilter) &&
                    !employeeEmail.toLowerCase().includes(searchFilter)) {
                    showItem = false;
                }
                
                // Smooth transitions for mobile
                if (showItem) {
                    if (item.style.display === 'none') {
                        item.style.display = 'block';
                        item.style.opacity = '0';
                        setTimeout(() => {
                            item.style.opacity = '1';
                        }, 10);
                    }
                    visibleCount++;
                } else {
                    item.style.opacity = '0';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 200);
                }
            });
            
            // Show no results message if needed
            showNoResultsMessage(visibleCount === 0);
        }
        
        // Show no results message
        function showNoResultsMessage(show) {
            let noResultsMsg = document.getElementById('noResultsMessage');
            
            if (show && !noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'noResultsMessage';
                noResultsMsg.className = 'no-history';
                noResultsMsg.innerHTML = `
                    <i class="fas fa-search"></i>
                    <h3>No Results Found</h3>
                    <p>Try adjusting your filters or search terms.</p>
                `;
                
                const historyGrid = document.querySelector('.history-grid');
                if (historyGrid) {
                    historyGrid.appendChild(noResultsMsg);
                }
            } else if (!show && noResultsMsg) {
                noResultsMsg.remove();
            }
        }
        
        // Mobile-optimized auto-refresh with user activity detection
        let refreshInterval;
        let lastActivity = Date.now();
        
        function startAutoRefresh() {
            refreshInterval = setInterval(() => {
                const timeSinceActivity = Date.now() - lastActivity;
                
                // Only refresh if user has been inactive for more than 30 seconds
                if (timeSinceActivity > 30000) {
                    location.reload();
                } else {
                    // Check again in 30 seconds
                    setTimeout(startAutoRefresh, 30000);
                }
            }, 30000);
        }
        
        // Track user activity
        ['mousedown', 'touchstart', 'keydown', 'scroll'].forEach(event => {
            document.addEventListener(event, () => {
                lastActivity = Date.now();
            }, { passive: true });
        });
        
        // Mobile-friendly clear filters button
        function clearFilters() {
            document.getElementById('employeeFilter').value = '';
            document.getElementById('dateFilter').value = '';
            document.getElementById('searchFilter').value = '';
            filterHistory();
        }
        
        // Add clear filters button if it doesn't exist
        document.addEventListener('DOMContentLoaded', function() {
            const filtersSection = document.querySelector('.filters-section');
            if (filtersSection && !document.getElementById('clearFiltersBtn')) {
                const clearBtn = document.createElement('button');
                clearBtn.id = 'clearFiltersBtn';
                clearBtn.className = 'btn btn-outline-secondary btn-sm mt-2';
                clearBtn.innerHTML = '<i class="fas fa-times me-1"></i>Clear Filters';
                clearBtn.onclick = clearFilters;
                clearBtn.style.cssText = 'min-height: 40px; touch-action: manipulation;';
                
                const filterGroup = filtersSection.querySelector('.filter-group');
                if (filterGroup) {
                    filterGroup.appendChild(clearBtn);
                }
            }
            
            // Start auto-refresh
            startAutoRefresh();
            
            // Add smooth scrolling for better mobile experience
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            // Initialize filters
            filterHistory();
        });
        
        // Handle visibility change to pause/resume auto-refresh
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                clearInterval(refreshInterval);
            } else {
                startAutoRefresh();
            }
        });
        
        // Add pull-to-refresh functionality for mobile
        let touchStartY = 0;
        let touchEndY = 0;
        
        document.addEventListener('touchstart', function(e) {
            touchStartY = e.changedTouches[0].screenY;
        }, { passive: true });
        
        document.addEventListener('touchend', function(e) {
            touchEndY = e.changedTouches[0].screenY;
            handleSwipe();
        }, { passive: true });
        
        function handleSwipe() {
            const swipeDistance = touchStartY - touchEndY;
            const isPullDown = swipeDistance < -50 && window.scrollY === 0;
            
            if (isPullDown) {
                // Show refresh indicator
                showRefreshIndicator();
                
                // Refresh after a short delay
                setTimeout(() => {
                    location.reload();
                }, 500);
            }
        }
        
        function showRefreshIndicator() {
            const indicator = document.createElement('div');
            indicator.id = 'refreshIndicator';
            indicator.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i> Refreshing...';
            indicator.style.cssText = `
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: var(--primary-color);
                color: white;
                padding: 10px 20px;
                border-radius: 25px;
                z-index: 9999;
                font-size: 0.9rem;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            `;
            
            document.body.appendChild(indicator);
            
            // Remove indicator after 2 seconds
            setTimeout(() => {
                const existingIndicator = document.getElementById('refreshIndicator');
                if (existingIndicator) {
                    existingIndicator.remove();
                }
            }, 2000);
        }
    </script>
</body>
</html>
