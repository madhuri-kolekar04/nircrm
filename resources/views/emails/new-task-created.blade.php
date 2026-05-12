<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Task Created</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        .header {
            background: linear-gradient(135deg, #6a0dad 0%, #8b4fc9 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header img {
            max-width: 180px;
            height: auto;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
            line-height: 1.6;
        }
        .alert-box {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            padding: 20px;
            border-left: 5px solid #ffc107;
            margin-bottom: 30px;
            border-radius: 8px;
            font-size: 16px;
            box-shadow: 0 2px 10px rgba(255, 193, 7, 0.2);
        }
        .alert-box strong {
            display: block;
            font-size: 18px;
            margin-bottom: 8px;
        }
        .section-title {
            font-size: 20px;
            color: #6a0dad;
            margin-top: 30px;
            margin-bottom: 15px;
            border-bottom: 2px solid #6a0dad;
            padding-bottom: 8px;
            font-weight: 600;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }
        .info-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        .info-card h4 {
            margin: 0 0 15px 0;
            color: #495057;
            font-size: 16px;
            font-weight: 600;
        }
        .info-item {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }
        .info-label {
            font-weight: 500;
            color: #6c757d;
            font-size: 14px;
        }
        .info-value {
            color: #212529;
            font-weight: 400;
            font-size: 14px;
        }
        .task-details {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 25px;
        }
        .task-details table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        .task-details th {
            background-color: #6a0dad;
            color: #ffffff;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }
        .task-details td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            font-size: 14px;
        }
        .task-details tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .task-details tr:last-child td {
            border-bottom: none;
        }
        .priority-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .priority-high {
            background-color: #dc3545;
            color: #ffffff;
        }
        .priority-medium {
            background-color: #ffc107;
            color: #212529;
        }
        .priority-low {
            background-color: #28a745;
            color: #ffffff;
        }
        .footer {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #6c757d;
            text-align: center;
            padding: 25px;
            font-size: 14px;
            border-top: 1px solid #dee2e6;
        }
        .footer .company-name {
            font-weight: 600;
            color: #6a0dad;
            font-size: 16px;
            margin-bottom: 8px;
        }
        .footer .contact-info {
            margin-top: 10px;
            font-size: 13px;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }
            .info-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            .header {
                padding: 25px 15px;
            }
            .content {
                padding: 20px;
            }
            .task-details th,
            .task-details td {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="https://niranjanenterprises.com/wp-content/uploads/2026/01/Digital-solutions-180x55.webp" alt="Niranjan Enterprises Logo">
            <h1>New Task Created</h1>
            <p>A new task has been successfully added to the system</p>
        </div>
        
        <div class="content">
            <div class="alert-box">
                <strong>New Task Alert!</strong>
                A new task has been assigned to you in the system. Please review the details below and take appropriate action.
            </div>

            <h2 class="section-title">Employee Information</h2>
            <div class="info-grid">
                <div class="info-card">
                    <h4>Assigned To</h4>
                    <div class="info-item">
                        <span class="info-label">Name:</span>
                        <span class="info-value">{{ $employee_name ?? 'Employee Name' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $employee_email ?? 'employee@company.com' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Department:</span>
                        <span class="info-value">{{ $department ?? 'Department Name' }}</span>
                    </div>
                </div>
                <div class="info-card">
                    <h4>Assigned By</h4>
                    <div class="info-item">
                        <span class="info-label">Name:</span>
                        <span class="info-value">{{ $assigned_by_name ?? 'Manager Name' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $assigned_by_email ?? 'manager@company.com' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date:</span>
                        <span class="info-value">{{ $created_date ?? date('Y-m-d') }}</span>
                    </div>
                </div>
            </div>

            <h2 class="section-title">Task Details</h2>
            <div class="task-details">
                <table>
                    <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>{{ $task_id ?? 'TSK-001' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Task Title</strong></td>
                            <td>{{ $task_title ?? 'Sample Task Title' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Description</strong></td>
                            <td>{{ $task_description ?? 'Task description will appear here...' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Priority</strong></td>
                            <td>
                                <span class="priority-badge priority-{{ $priority ?? 'medium' }}">
                                    {{ $priority ?? 'Medium' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Due Date</strong></td>
                            <td>{{ $due_date ?? '2025-12-31' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>{{ $status ?? 'Pending' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Category</strong></td>
                            <td>{{ $category ?? 'General' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2 class="section-title">Additional Information</h2>
            <div class="info-card">
                <p><strong>Notes:</strong> {{ $notes ?? 'Please review this task carefully and update the status once completed. If you have any questions, contact your department manager.' }}</p>
                <p><strong>Expected Completion Time:</strong> {{ $expected_time ?? '2-3 business days' }}</p>
            </div>
        </div>
        
        <div class="footer">
            <div class="company-name">Niranjan Enterprises</div>
            <p>Digital Solutions & Business Management</p>
            <div class="contact-info">
                <p>This is an automated notification. Please do not reply to this email.</p>
                <p>For support, contact: support@niranjanenterprises.com</p>
                <p>&copy; {{ date('Y') }} Niranjan Enterprises. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
