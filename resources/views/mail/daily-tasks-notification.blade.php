<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Tasks Summary - {{ $dateLabel }} by {{ $user->name }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 30px;
        }
        .summary {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        .summary h3 {
            margin: 0 0 10px 0;
            color: #667eea;
            font-size: 18px;
        }
        .summary p {
            margin: 5px 0;
            font-size: 14px;
        }
        .tasks-list {
            margin-top: 20px;
        }
        .task-item {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            transition: box-shadow 0.3s ease;
        }
        .task-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .task-number {
            background: #667eea;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .task-time {
            color: #6c757d;
            font-size: 12px;
            font-weight: 500;
        }
        .task-description {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #2c3e50;
        }
        .task-project {
            color: #495057;
            font-size: 14px;
            margin-bottom: 8px;
        }
        .task-project strong {
            color: #2c3e50;
        }
        .task-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        .status-in_progress {
            background: #cce5ff;
            color: #004085;
            border: 1px solid #99d6ff;
        }
        .status-completed {
            background: #d4edda;
            color: #155724;
            border: 1px solid #b8e6c1;
        }
        .status-stopped {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f1b0b7;
        }
        .status-on_hold {
            background: #e2e3e5;
            color: #383d41;
            border: 1px solid #ced4da;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 12px;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Daily Tasks Summary</h1>
            <p>{{ $dateLabel }} by {{ $user->name }} ({{ $user->email }})</p>
        </div>
        
        <div class="content">
            <div class="summary">
                <h3>📊 Summary</h3>
                <p><strong>Total Tasks:</strong> {{ $totalTasks }}</p>
                <p><strong>Date:</strong> {{ $dateLabel }}</p>
                <p><strong>Employee:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
            </div>
            
            <div class="tasks-list">
                <h3 style="color: #667eea; margin-bottom: 20px;">📝 Task Details</h3>
                
                @foreach($tasks as $task)
                    <div class="task-item">
                        <div class="task-header">
                            <span class="task-number">Task #{{ $task['task_number'] }}</span>
                            <span class="task-time">{{ \Carbon\Carbon::parse($task['task_date'])->format('h:i A') }}</span>
                        </div>
                        
                        <div class="task-description">
                            {{ $task['task_description'] }}
                        </div>
                        
                        <div class="task-project">
                            <strong>Project/Client:</strong> {{ $task['client_project_name'] }}
                        </div>
                        
                        <div class="task-status status-{{ $task['status'] }}">
                            {{ str_replace('_', ' ', ucfirst($task['status'])) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="footer">
            <p>This email was sent automatically from NIRCRM Task Management System</p>
            <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
