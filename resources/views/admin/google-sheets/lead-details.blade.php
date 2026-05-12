<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Details - Calling App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    @php
        function formatAuditReportContent($content) {
            // Clean up the content first
            $formatted = trim($content);
            
            // Convert HTML entities back to characters
            $formatted = html_entity_decode($formatted, ENT_QUOTES, 'UTF-8');
            
            // Check if content already contains HTML tags (like the sample you showed)
            if (strpos($formatted, '<h2') !== false || strpos($formatted, '<h1') !== false) {
                // Content is already HTML formatted, just clean it up and return
                // Remove inline styles and replace with our CSS classes
                $formatted = preg_replace('/<h2[^>]*>/', '<h2>', $formatted);
                $formatted = preg_replace('/<h1[^>]*>/', '<h1>', $formatted);
                $formatted = preg_replace('/<h3[^>]*>/', '<h3>', $formatted);
                $formatted = preg_replace('/<ul[^>]*>/', '<ul>', $formatted);
                $formatted = preg_replace('/<li[^>]*>/', '<li>', $formatted);
                $formatted = preg_replace('/<p[^>]*>/', '<p>', $formatted);
                $formatted = preg_replace('/<strong[^>]*>/', '<strong>', $formatted);
                
                return $formatted;
            }
            
            // Convert markdown-like content to HTML with better formatting
            $formatted = preg_replace('/^# (.*$)/m', '<h1>$1</h1>', $formatted);
            $formatted = preg_replace('/^## (.*$)/m', '<h2>$1</h2>', $formatted);
            $formatted = preg_replace('/^### (.*$)/m', '<h3>$1</h3>', $formatted);
            
            // Bold text
            $formatted = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $formatted);
            
            // Italic text
            $formatted = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $formatted);
            
            // Numbered lists
            $formatted = preg_replace('/^\d+\. (.*$)/m', '<li>$1</li>', $formatted);
            
            // Bullet points
            $formatted = preg_replace('/^- (.*$)/m', '<li>$1</li>', $formatted);
            
            // Convert consecutive list items to proper lists
            $formatted = preg_replace('/(<li>.*<\/li>)(\s*<li>.*<\/li>)+/', '<ul>$0</ul>', $formatted);
            
            // Handle multiple line breaks (convert to paragraphs)
            $formatted = preg_replace('/\n{3,}/', "\n\n", $formatted);
            
            // Convert double line breaks to paragraphs
            $formatted = preg_replace('/\n\n/', '</p><p>', $formatted);
            
            // Convert single line breaks to <br>
            $formatted = preg_replace('/\n/', '<br>', $formatted);
            
            // Clean up any list formatting issues
            $formatted = str_replace('</p><ul>', '<ul>', $formatted);
            $formatted = str_replace('</ul><p>', '</ul>', $formatted);
            $formatted = str_replace('</p><ol>', '<ol>', $formatted);
            $formatted = str_replace('</ol><p>', '</ol>', $formatted);
            
            // Remove empty paragraphs
            $formatted = str_replace('<p></p>', '', $formatted);
            $formatted = str_replace('<p><br></p>', '', $formatted);
            
            // Wrap in paragraphs if not already wrapped and not starting with header or list
            if (!preg_match('/^<(h[1-6]|ul|ol|p)/', $formatted)) {
                $formatted = '<p>' . $formatted . '</p>';
            }
            
            // Add proper spacing around headers
            $formatted = preg_replace('/<\/h1>/', '</h1><br>', $formatted);
            $formatted = preg_replace('/<\/h2>/', '</h2><br>', $formatted);
            $formatted = preg_replace('/<\/h3>/', '</h3><br>', $formatted);
            
            // Clean up any double breaks
            $formatted = str_replace('<br><br>', '<br>', $formatted);
            
            return $formatted;
        }
    @endphp
    
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 10px;
        }

        .details-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .details-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .details-title {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: white;
        }

        .details-content {
            padding: 30px;
        }

        .lead-info-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .info-value {
            color: #495057;
            font-size: 1rem;
            word-break: break-word;
        }

        .info-value a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .info-value a:hover {
            text-decoration: underline;
        }

        .call-history-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
        }

        .call-history-item {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid var(--primary-color);
        }

        .call-history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .call-employee {
            font-weight: 600;
            color: var(--primary-color);
        }

        .call-date {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .call-rating {
            display: flex;
            gap: 5px;
            margin-bottom: 10px;
        }

        .star {
            color: #ffc107;
            font-size: 1.2rem;
        }

        .star.empty {
            color: #e9ecef;
        }

        .call-conclusion {
            margin-bottom: 10px;
        }

        /* Enhanced Call History Styles */
        .call-history-container {
            max-width: 100%;
        }

        .call-history-item {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .call-history-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .call-history-item.even {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .call-history-item.odd {
            background: linear-gradient(135deg, #ffffff 0%, #e9ecef 100%);
        }

        .call-employee-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .employee-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .employee-details {
            flex: 1;
        }

        .employee-name {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .call-date-time {
            color: #6c757d;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .call-rating {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: rgba(255, 193, 7, 0.1);
            border-radius: 20px;
            margin-bottom: 15px;
        }

        .rating-text {
            font-weight: 600;
            color: var(--warning-color);
            font-size: 0.9rem;
        }

        .call-history-body {
            display: grid;
            gap: 20px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 12px;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .call-conclusion-section,
        .next-call-section,
        .additional-notes-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 3px solid var(--info-color);
        }

        .next-call-section {
            border-left-color: var(--success-color);
        }

        .additional-notes-section {
            border-left-color: var(--warning-color);
        }

        .conclusion-content {
            line-height: 1.6;
        }

        .conclusion-point {
            background: white;
            padding: 8px 12px;
            margin-bottom: 8px;
            border-radius: 6px;
            border-left: 3px solid var(--primary-color);
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .conclusion-point:hover {
            background: var(--primary-color);
            color: white;
            transform: translateX(5px);
        }

        .next-call-content {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: var(--success-color);
        }

        .notes-content {
            background: white;
            padding: 12px;
            border-radius: 6px;
            border-left: 3px solid var(--warning-color);
            line-height: 1.5;
            font-style: italic;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .call-history-section {
                padding: 15px;
            }

            .call-history-item {
                padding: 15px;
                margin-bottom: 15px;
            }

            .call-employee-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .employee-avatar {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .employee-name {
                font-size: 1rem;
            }

            .call-rating {
                padding: 6px 12px;
                font-size: 0.85rem;
            }

            .call-history-body {
                gap: 15px;
            }

            .section-header {
                font-size: 0.85rem;
            }

            .call-conclusion-section,
            .next-call-section,
            .additional-notes-section {
                padding: 12px;
            }

            .conclusion-point {
                padding: 6px 10px;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 480px) {
            .call-history-section {
                padding: 10px;
            }

            .call-history-item {
                padding: 12px;
                margin-bottom: 12px;
            }

            .employee-avatar {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }

            .employee-name {
                font-size: 0.95rem;
            }

            .call-date-time {
                font-size: 0.8rem;
            }

            .call-rating {
                padding: 5px 10px;
                font-size: 0.8rem;
            }

            .call-history-body {
                gap: 12px;
            }

            .section-header {
                font-size: 0.8rem;
                gap: 6px;
            }

            .call-conclusion-section,
            .next-call-section,
            .additional-notes-section {
                padding: 10px;
            }

            .conclusion-point {
                padding: 5px 8px;
                font-size: 0.8rem;
                margin-bottom: 6px;
            }
        }

        .conclusion-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .conclusion-points {
            margin-left: 20px;
        }

        .conclusion-point {
            margin-bottom: 5px;
        }

        .next-call-info {
            background: #e7f3ff;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
        }

        .no-calls {
            text-align: center;
            color: #6c757d;
            padding: 40px;
        }

        /* Audit Report Styling */
        .audit-report-content {
            white-space: pre-wrap;
            word-wrap: break-word;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 15px;
            line-height: 1.7;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #dee2e6;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-height: 60vh;
            overflow-y: auto;
            margin: 10px 0;
        }
        
        .audit-report-formatted h1 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #3498db;
            text-align: center;
        }
        
        .audit-report-formatted h2 {
            color: #34495e;
            font-size: 22px;
            font-weight: 600;
            margin: 25px 0 15px 0;
            padding-left: 15px;
            border-left: 4px solid #3498db;
            background: rgba(52, 152, 219, 0.1);
            padding: 10px 15px;
            border-radius: 0 8px 8px 0;
        }
        
        .audit-report-formatted h3 {
            color: #2c3e50;
            font-size: 18px;
            font-weight: 600;
            margin: 20px 0 10px 0;
            color: #2980b9;
        }
        
        .audit-report-formatted p {
            margin-bottom: 15px;
            text-align: justify;
            color: #34495e;
        }
        
        .audit-report-formatted ul {
            margin: 15px 0;
            padding-left: 0;
            list-style: none;
        }
        
        .audit-report-formatted li {
            margin-bottom: 12px;
            padding: 12px 15px 12px 35px;
            background: white;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            position: relative;
        }
        
        .audit-report-formatted li:before {
            content: "▶";
            position: absolute;
            left: 12px;
            top: 12px;
            color: #3498db;
            font-size: 12px;
        }
        
        .audit-report-formatted strong {
            color: #2c3e50;
            font-weight: 700;
            background: linear-gradient(135deg, #3498db, #2980b9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .details-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .details-title {
                font-size: 1.5rem;
            }

            .details-content {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .call-history-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="details-container">
        <!-- Header -->
        <div class="details-header">
            <h1 class="details-title">
                <i class="fas fa-user me-2"></i>
                Lead Details
            </h1>
            <a href="{{ request()->get('source') === 'manual' ? route('callingapp.manual-leads') : route('callingapp.index') }}" class="back-btn">
                <i class="fas fa-arrow-left me-2"></i>
                Back to Calling App
            </a>
        </div>

        <!-- Content -->
        <div class="details-content">
            @if(isset($lead))
                <!-- Lead Information -->
                <div class="lead-info-section">
                    <h2 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Lead Information
                    </h2>
                    <div class="info-grid">
                        @foreach($lead as $key => $value)
                            @if(!empty($value))
                                <div class="info-item">
                                    <div class="info-label">
                                        {{ ucwords(str_replace('_', ' ', $key)) }}
                                    </div>
                                    <div class="info-value">
                                        @if($key === 'email')
                                            <a href="mailto:{{ $value }}">{{ $value }}</a>
                                        @elseif($key === 'whatsapp')
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9+]/', '', $value) }}" target="_blank">{{ $value }}</a>
                                        @elseif($key === 'website_url')
                                            <a href="{{ !preg_match('/^https?:\/\//', $value) ? 'https://' . $value : $value }}" target="_blank">{{ $value }}</a>
                                        @elseif($key === 'audit_report' || $key === 'audit_report_plain')
                                            <div class="audit-report-content audit-report-formatted">
                                                {!! formatAuditReportContent($value) !!}
                                            </div>
                                        @else
                                            {{ $value }}
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Call History -->
                <div class="call-history-section">
                    <h2 class="section-title">
                        <i class="fas fa-phone-alt"></i>
                        Schedule Meeting & Call Details History
                    </h2>
                    <div id="callHistory" class="call-history-container">
                        @if(isset($leadCallHistory) && $leadCallHistory->count() > 0)
                            @foreach($leadCallHistory as $index => $call)
                                <div class="call-history-item {{ $index % 2 === 0 ? 'even' : 'odd' }}">
                                    <div class="call-history-header">
                                        <div class="call-employee-info">
                                            <div class="employee-avatar">
                                                <i class="fas fa-user-circle"></i>
                                            </div>
                                            <div class="employee-details">
                                                <div class="employee-name">{{ $call->called_by_employee_name }}</div>
                                                <div class="call-date-time">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    {{ \Carbon\Carbon::parse($call->created_at)->format('M d, Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="call-rating">
                                            @php
                                                $stars = '';
                                                for($i = 1; $i <= 5; $i++) {
                                                    $stars .= '<i class="fas fa-star star ' . ($i <= $call->rating ? '' : 'empty') . '"></i>';
                                                }
                                            @endphp
                                            {!! $stars !!}
                                            <span class="rating-text">{{ $call->rating }}/5</span>
                                        </div>
                                    </div>
                                    
                                    <div class="call-history-body">
                                        <div class="call-conclusion-section">
                                            <div class="section-header">
                                                <i class="fas fa-clipboard-check"></i>
                                                <span>Meeting Conclusion</span>
                                            </div>
                                            <div class="conclusion-content">
                                                @php
                                                    $points = explode("\n", $call->meeting_conclusion);
                                                    foreach($points as $index => $point) {
                                                        $cleanPoint = trim($point);
                                                        if(!empty($cleanPoint)) {
                                                            echo '<div class="conclusion-point">' . ($index + 1) . '. ' . $cleanPoint . '</div>';
                                                        }
                                                    }
                                                @endphp
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
                                            <div class="additional-notes-section">
                                                <div class="section-header">
                                                    <i class="fas fa-sticky-note"></i>
                                                    <span>Additional Notes</span>
                                                </div>
                                                <div class="notes-content">
                                                    {{ $call->additional_notes }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-calls">
                                <i class="fas fa-phone-slash fa-3x mb-3"></i>
                                <h4>No Call History</h4>
                                <p>No calls have been recorded for this lead yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="no-calls">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <h4>Lead Not Found</h4>
                    <p>The requested lead could not be found.</p>
                    <a href="{{ request()->get('source') === 'manual' ? route('callingapp.manual-leads') : route('callingapp.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Calling App
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
