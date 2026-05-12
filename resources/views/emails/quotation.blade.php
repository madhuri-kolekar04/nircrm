<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Proposal - {{ $quotation->quotation_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #2c3e50;
            max-width: 650px;
            margin: 0 auto;
            padding: 0;
            background: #f8f9fa;
        }
        .email-container {
            background: white;
            margin: 20px auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .section {
            margin-bottom: 35px;
        }
        .section-title {
            color: #2c3e50;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #3498db;
        }
        .info-box {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: 600;
            color: #2c3e50;
            width: 140px;
            flex-shrink: 0;
        }
        .info-value {
            color: #495057;
            flex: 1;
        }
        .service-item {
            background: white;
            border: 1px solid #e9ecef;
            border-left: 4px solid #3498db;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            transition: box-shadow 0.3s ease;
        }
        .service-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .service-name {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        .service-description {
            color: #6c757d;
            margin-bottom: 12px;
        }
        .service-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }
        .price-tag {
            background: #e3f2fd;
            color: #1976d2;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
        }
        .timeline-tag {
            background: #fff3e0;
            color: #f57c00;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .pricing-summary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
        }
        .pricing-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .pricing-row.total {
            border-top: 2px solid #3498db;
            padding-top: 15px;
            margin-top: 15px;
        }
        .total-amount {
            font-size: 24px;
            font-weight: 700;
            color: #27ae60;
        }
        .cta-section {
            text-align: center;
            margin: 40px 0;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            margin: 10px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }
        .btn-success {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            color: white;
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
        }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .footer h4 {
            margin: 0 0 15px 0;
            color: #3498db;
        }
        .footer p {
            margin: 8px 0;
            font-size: 14px;
        }
        .footer .contact-info {
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .emoji {
            font-size: 20px;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>📋 Business Proposal</h1>
            <p>Professional Services for {!! $quotation->client_business_name !!}</p>
        </div>

        <div class="content">
            <!-- Quotation Details -->
            <div class="section">
                <h3 class="section-title">Proposal Details</h3>
                <div class="info-box">
                    <div class="info-row">
                        <span class="info-label">Proposal Number:</span>
                        <span class="info-value">{{ $quotation->quotation_number }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date:</span>
                        <span class="info-value">{{ $quotation->created_at->format('d F, Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Valid Until:</span>
                        <span class="info-value">{{ $quotation->valid_until ? $quotation->valid_until->format('d F, Y') : 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Client:</span>
                        <span class="info-value">{{ $quotation->client_business_name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Contact Person:</span>
                        <span class="info-value">{{ $quotation->client_contact_name }}</span>
                    </div>
                </div>
            </div>

            <!-- Proposed Services -->
            <div class="section">
                <h3 class="section-title">🚀 Proposed Services</h3>
                @foreach($quotation->services as $service)
                <div class="service-item">
                    <div class="service-name">{{ $service->name }}</div>
                    <div class="service-description">{{ $service->description }}</div>
                    <div class="service-meta">
                        <span class="price-tag">{{ number_format($service->pivot->subtotal, 2) }}</span>
                        @if($service->timeline_weeks)
                        <span class="timeline-tag">{{ $service->timeline_weeks }} weeks</span>
                        @endif
                        <span>Quantity: {{ $service->pivot->quantity }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Investment Summary -->
            <div class="section">
                <h3 class="section-title">💰 Investment Summary</h3>
                <div class="pricing-summary">
                    <div class="pricing-row">
                        <span>Subtotal:</span>
                        <span>{{ number_format($quotation->total_cost, 2) }}</span>
                    </div>
                    <div class="pricing-row">
                        <span>GST (18%):</span>
                        <span>{{ number_format($quotation->gst_amount, 2) }}</span>
                    </div>
                    <div class="pricing-row total">
                        <span>Total Investment:</span>
                        <span class="total-amount">{{ number_format($quotation->final_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Executive Summary -->
            @if($quotation->executive_summary)
            <div class="section">
                <h3 class="section-title">📝 Executive Summary</h3>
                <div class="info-box">
                    <p>{{ $quotation->executive_summary }}</p>
                </div>
            </div>
            @endif

            <!-- Call to Action -->
            <div class="cta-section">
                <a href="tel:+919220518202" class="btn btn-primary">
                    <span class="emoji">📞</span> Call Us Now
                </a>
                <a href="mailto:udyami.nircrm24@gmail.com" class="btn btn-success">
                    <span class="emoji">✅</span> Approve Proposal
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h4>Thank you for choosing NIRCRM!</h4>
            <div class="contact-info">
                <p><span class="emoji">📧</span> Email: udyami.nircrm24@gmail.com</p>
                <p><span class="emoji">📞</span> Phone: +91-9220518202</p>
                <p><span class="emoji">🌐</span> Website: www.nircrm.com</p>
            </div>
            <p>We at NIRCRM appreciate your interest and look forward to working with you.</p>
            <p><strong>Best regards,<br>{{ $quotation->creator->name }}<br>NIRCRM Team</strong></p>
        </div>
    </div>
</body>
</html>
