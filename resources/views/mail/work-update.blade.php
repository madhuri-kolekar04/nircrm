<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Update Notification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
            font-weight: 300;
        }
        .header .subtitle {
            margin-top: 10px;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 30px;
        }
        .project-info {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 4px;
        }
        .project-info h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 20px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 15px;
        }
        .info-item {
            margin: 5px 0;
        }
        .info-label {
            font-weight: 600;
            color: #555;
            display: inline-block;
            min-width: 100px;
        }
        .info-value {
            color: #333;
        }
        .updates-section {
            margin-top: 25px;
        }
        .updates-section h3 {
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .update-item {
            background-color: #fff;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            position: relative;
        }
        .update-item:before {
            content: "✓";
            background-color: #28a745;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            margin-right: 10px;
            position: absolute;
            left: -12px;
            top: 15px;
        }
        .update-content {
            margin-left: 20px;
        }
        .meta-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin-top: 25px;
            font-size: 14px;
            color: #6c757d;
        }
        .meta-item {
            margin: 5px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }
        .company-name {
            font-weight: 600;
            color: #333;
            margin-top: 10px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: 500;
        }
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .container {
                margin: 10px;
            }
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Work Update Notification</h1>
            <div class="subtitle">Important progress update on your project</div>
        </div>
        
        <div class="content">
            <div class="project-info">
                <h3>{{ $invoice->project_name }}</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Invoice:</span>
                        <span class="info-value">{{ $invoice->invoice_number }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Department:</span>
                        <span class="info-value">{{ $invoice->department }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Start Date:</span>
                        <span class="info-value">{{ $invoice->start_date ? $invoice->start_date->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">End Date:</span>
                        <span class="info-value">{{ $invoice->end_date ? $invoice->end_date->format('M d, Y') : 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="updates-section">
                <h3>🚀 Latest Work Updates</h3>
                
                @php
                    $updatePoints = [];
                    if (!empty($update->update_point_1)) $updatePoints[] = $update->update_point_1;
                    if (!empty($update->update_point_2)) $updatePoints[] = $update->update_point_2;
                    
                    // Check if update_point_3 contains JSON (multiple points)
                    if (!empty($update->update_point_3)) {
                        $decoded = json_decode($update->update_point_3);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            $updatePoints = array_merge($updatePoints, $decoded);
                        } else {
                            $updatePoints[] = $update->update_point_3;
                        }
                    }
            @endphp
                
                @foreach($updatePoints as $index => $point)
                    <div class="update-item">
                        <div class="update-content">{{ $point }}</div>
                    </div>
                @endforeach
            </div>

            <div class="meta-info">
                <div class="meta-item">
                    <strong>Updated by:</strong> {{ $user->name }} 
                    @if($user->role == 1 || $user->role == 5) (Admin)
                    @elseif($user->role == 2) (Employee)
                    @elseif($user->role == 3) (Customer)
                    @endif
                </div>
                <div class="meta-item">
                    <strong>Date:</strong> {{ $update->update_date->format('M d, Y H:i A') }}
                </div>
                @if($invoice->project_topic)
                <div class="meta-item">
                    <strong>Topic:</strong> {{ $invoice->project_topic }}
                </div>
                @endif
            </div>
            
            @if(!empty($update->attachment))
                <div class="updates-section">
                    <h3>📎 Attachment</h3>
                    <div class="update-item">
                        <div class="update-content">
                            <strong>{{ basename($update->attachment) }}</strong>
                            <br>
                            <small class="text-muted">File is available for download in the project portal</small>
                            <br><br>
                            <a href="{{ route('attachments.public.download', basename($update->attachment)) }}" 
                           style="background-color: #28a745; 
                                  color: white; 
                                  padding: 12px 24px; 
                                  text-decoration: none; 
                                  border-radius: 6px; 
                                  display: inline-block; 
                                  font-weight: 600; 
                                  font-size: 14px;
                                  border: 1px solid #28a745;
                                  font-family: Arial, sans-serif;">
                                📎 Download Attachment
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <a href="{{ url('/project-updates/' . $invoice->id) }}" class="btn">
                View Full Project Details
            </a>
        </div>

        <div class="footer">
            <p>This is an automated notification from the project management system.</p>
            <div class="company-name">Niranjan Enterprises</div>
            <p>© {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>
</body>
</html>
