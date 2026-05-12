<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Task Notification - NIRCRM</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f0f1ff 0%, #e0e7ff 100%);
            color: #1f2937;
            line-height: 1.6;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .email-header {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            color: #ffffff;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .email-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .email-header-content {
            position: relative;
            z-index: 1;
        }

        .logo {
            width: 180px;
            height: auto;
            margin: 0 auto 1rem;
            border-radius: 8px;
        }

        .email-title {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .email-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 400;
        }

        .email-body {
            padding: 2rem;
        }

        .task-alert {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .alert-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .alert-content h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 0.25rem;
        }

        .alert-content p {
            color: #78350f;
            margin: 0;
            font-size: 0.875rem;
        }

        .task-details {
            background: #f9fafb;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #e5e7eb;
        }

        .task-details h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-row {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #6b7280;
            min-width: 140px;
            font-size: 0.875rem;
        }

        .detail-value {
            color: #1f2937;
            font-weight: 500;
            flex: 1;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .status-in_progress {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .status-completed {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .status-stopped {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .status-on_hold {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
        }

        .employee-info {
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #c7d2fe;
        }

        .employee-info h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #3730a3;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .employee-details {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .employee-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .employee-text h4 {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .employee-text p {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0;
        }

        
        .email-footer {
            background: #f9fafb;
            padding: 2rem;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer-text {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #4f46e5;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .timestamp {
            background: #f3f4f6;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.75rem;
            color: #6b7280;
            text-align: center;
            margin-top: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .email-container {
                border-radius: 12px;
            }

            .email-header,
            .email-body {
                padding: 1.5rem;
            }

            .email-title {
                font-size: 1.5rem;
            }

            .detail-row {
                flex-direction: column;
                gap: 0.25rem;
            }

            .detail-label {
                min-width: auto;
            }

            .employee-details {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Email Header -->
        <div class="email-header">
            <div class="email-header-content">
                <img src="https://niranjanenterprises.com/wp-content/uploads/2026/01/Digital-solutions-180x55.webp" alt="Niranjan Enterprises Logo" class="logo">
                <h1 class="email-title">New Task Created</h1>
                <p class="email-subtitle">A new task has been added to the system</p>
            </div>
        </div>

        <!-- Email Body -->
        <div class="email-body">
            <!-- Task Alert -->
            <div class="task-alert">
                <div class="alert-icon">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <div class="alert-content">
                    <h3>New Task Alert</h3>
                    <p>{{ $user->name }} has just created a new task in the NIRCRM system</p>
                </div>
            </div>

            <!-- Employee Information -->
            <div class="employee-info">
                <h3>
                    <i class="bi bi-person-circle"></i>
                    Employee Information
                </h3>
                <div class="employee-details">
                    <div class="employee-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="employee-text">
                        <h4>{{ $user->name }}</h4>
                        <p>{{ $user->email }}</p>
                        @if($user->position)
                        <p>{{ $user->position }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Task Details -->
            <div class="task-details">
                <h3>
                    <i class="bi bi-clipboard-data"></i>
                    Task Details
                </h3>
                
                <div class="detail-row">
                    <div class="detail-label">Task Number:</div>
                    <div class="detail-value">#{{ $task->task_number }}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Date & Time:</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($task->task_date)->format('l, F j, Y - g:i A') }}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Client/Project:</div>
                    <div class="detail-value">{{ $task->client_project_name }}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Status:</div>
                    <div class="detail-value">
                        <span class="status-badge status-{{ $task->status }}">
                            <i class="bi bi-circle-fill"></i>
                            {{ str_replace('_', ' ', ucfirst($task->status)) }}
                        </span>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Description:</div>
                    <div class="detail-value">{{ $task->task_description }}</div>
                </div>
            </div>

            
            <!-- Timestamp -->
            <div class="timestamp">
                <i class="bi bi-clock"></i>
                Task created on {{ now()->format('l, F j, Y - g:i A') }}
            </div>
        </div>

        <!-- Email Footer -->
        <div class="email-footer">
            <p class="footer-text">
                This is an automated notification from NIRCRM Task Management System
            </p>
            <div class="footer-links">
                <a href="{{ config('app.url') }}">NIRCRM Portal</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Support</a>
            </div>
            <p class="footer-text" style="margin-top: 1rem; font-size: 0.75rem;">
                © {{ now()->year }} NIRCRM. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
