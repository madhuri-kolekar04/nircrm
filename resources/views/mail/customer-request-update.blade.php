<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Update Request</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 650px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid #e9ecef;
        }
        .header {
            background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);
            color: white;
            padding: 35px 30px;
            text-align: center;
            position: relative;
        }
        .header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="50" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="30" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 600;
            position: relative;
            z-index: 1;
        }
        .header .subtitle {
            margin-top: 12px;
            opacity: 0.95;
            font-size: 18px;
            font-weight: 300;
            position: relative;
            z-index: 1;
        }
        .priority-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            margin-top: 15px;
            backdrop-filter: blur(10px);
        }
        .content {
            padding: 35px 30px;
        }
        .customer-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        .customer-info::before {
            content: "👤";
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 60px;
            opacity: 0.1;
        }
        .customer-info h3 {
            margin: 0 0 20px 0;
            font-size: 22px;
            font-weight: 600;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }
        .info-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 12px 15px;
            border-radius: 8px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .info-label {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            color: white;
            font-size: 16px;
            font-weight: 500;
        }
        .request-section {
            margin-top: 30px;
        }
        .request-section h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .request-item {
            background: #f8f9fa;
            border-left: 4px solid #ff6b6b;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            position: relative;
            transition: all 0.3s ease;
        }
        .request-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.1);
        }
        .request-item::before {
            content: "📝";
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 24px;
            opacity: 0.3;
        }
        .request-content {
            color: #495057;
            font-size: 16px;
            line-height: 1.6;
            margin-right: 40px;
        }
        .action-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 10px;
            margin-top: 30px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 14px 28px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            margin: 0 5px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }
        .btn-secondary:hover {
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        }
        .meta-info {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-top: 25px;
        }
        .meta-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f1f3f4;
        }
        .meta-item:last-child {
            border-bottom: none;
        }
        .meta-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 14px;
        }
        .meta-value {
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 25px;
            text-align: center;
            border-top: 2px solid #e9ecef;
            color: #6c757d;
        }
        .company-name {
            font-weight: 700;
            color: #333;
            font-size: 18px;
            margin: 10px 0;
        }
        .footer-links {
            margin-top: 15px;
        }
        .footer-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }
        .footer-links a:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .container {
                margin: 10px;
                border-radius: 8px;
            }
            .content {
                padding: 25px 20px;
            }
            .header {
                padding: 25px 20px;
            }
            .header h1 {
                font-size: 26px;
            }
            .btn {
                display: block;
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚨 Customer Update Request</h1>
            <div class="subtitle">New request requires your attention</div>
            <div class="priority-badge">🔥 High Priority</div>
        </div>
        
        <div class="content">
            <div class="customer-info">
                <h3>Customer Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Customer Name</span>
                        <span class="info-value">{{ $user->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email Address</span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Project Name</span>
                        <span class="info-value">{{ $invoice->project_name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Department</span>
                        <span class="info-value">{{ $invoice->department }}</span>
                    </div>
                </div>
            </div>

            <div class="request-section">
                <h3>📋 Update Request Details</h3>
                
                @php
                    $requestPoints = [];
                    if (!empty($update->request_text)) {
                        // Split by new lines and clean up
                        $lines = explode("\n", trim($update->request_text));
                        foreach ($lines as $line) {
                            $line = trim($line);
                            if (!empty($line)) {
                                $requestPoints[] = $line;
                            }
                        }
                    }
                    
                    // Also check update_point_1, update_point_2, update_point_3 for backward compatibility
                    if (!empty($update->update_point_1)) $requestPoints[] = $update->update_point_1;
                    if (!empty($update->update_point_2)) $requestPoints[] = $update->update_point_2;
                    if (!empty($update->update_point_3)) {
                        $decoded = json_decode($update->update_point_3);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            $requestPoints = array_merge($requestPoints, $decoded);
                        } else {
                            $requestPoints[] = $update->update_point_3;
                        }
                    }
                @endphp
                
                @foreach($requestPoints as $index => $point)
                    <div class="request-item">
                        <div class="request-content">{{ $point }}</div>
                    </div>
                @endforeach
            </div>

            <div class="meta-info">
                <div class="meta-item">
                    <span class="meta-label">Invoice Number</span>
                    <span class="meta-value">{{ $invoice->invoice_number }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Request Date</span>
                    <span class="meta-value">{{ $update->update_date->format('M d, Y H:i A') }}</span>
                </div>
                @if($invoice->project_topic)
                <div class="meta-item">
                    <span class="meta-label">Project Topic</span>
                    <span class="meta-value">{{ $invoice->project_topic }}</span>
                </div>
                @endif
                @if($invoice->start_date)
                <div class="meta-item">
                    <span class="meta-label">Project Start Date</span>
                    <span class="meta-value">{{ $invoice->start_date->format('M d, Y') }}</span>
                </div>
                @endif
                @if($invoice->end_date)
                <div class="meta-item">
                    <span class="meta-label">Project End Date</span>
                    <span class="meta-value">{{ $invoice->end_date->format('M d, Y') }}</span>
                </div>
                @endif
            </div>

            <div class="action-section">
                <h3 style="margin-bottom: 20px; color: #333;">🎯 Take Action</h3>
                <p style="margin-bottom: 20px; color: #6c757d;">Please review this customer request and provide appropriate updates.</p>
                <a href="{{ url('/project-updates/' . $invoice->id) }}" class="btn">
                    View Project Details
                </a>
                <a href="{{ url('/project-updates/' . $invoice->id . '#requestUpdatesColumn') }}" class="btn btn-secondary">
                    Respond to Request
                </a>
            </div>
        </div>

        <div class="footer">
            <p>This is an automated notification from the project management system.</p>
            <div class="company-name">Niranjan Enterprises</div>
            <div class="footer-links">
                <a href="{{ url('/') }}">Dashboard</a>
                <a href="{{ url('/project-updates') }}">Project Updates</a>
                <a href="mailto:support@niranjanenterprises.com">Support</a>
            </div>
            <p style="margin-top: 15px; font-size: 12px;">© {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>
</body>
</html>
