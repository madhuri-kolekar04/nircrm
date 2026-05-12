<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation {{ $quotation->quotation_number }}</title>
    <style>
        @page {
            margin: 20mm;
            size: A4;
        }
        
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #2c3e50;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }
        
        .container {
            max-width: 100%;
            margin: 0 auto;
        }
        
        /* Header Styles */
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px 0;
            border-bottom: 3px solid #3498db;
        }
        
        .header h1 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .header h2 {
            color: #7f8c8d;
            font-size: 16px;
            font-weight: 400;
            margin: 0;
        }
        
        /* Grid Layout */
        .row {
            display: flex;
            margin: 0 -10px;
            margin-bottom: 20px;
        }
        
        .col-6 {
            width: 50%;
            padding: 0 10px;
        }
        
        .col-12 {
            width: 100%;
            padding: 0 10px;
        }
        
        /* Section Styles */
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            color: #2c3e50;
            font-size: 18px;
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
            margin-bottom: 8px;
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
        
        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .table th {
            background: #3498db;
            color: white;
            font-weight: 600;
            padding: 12px 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table td {
            border: 1px solid #e9ecef;
            padding: 12px 10px;
            vertical-align: top;
        }
        
        .table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .table tbody tr:hover {
            background: #e3f2fd;
        }
        
        /* Pricing Table */
        .pricing-table .table th:last-child,
        .pricing-table .table td:last-child {
            text-align: right;
            font-weight: 600;
        }
        
        .table-info td {
            background: #e3f2fd !important;
            font-weight: 600;
        }
        
        .table-success td {
            background: #e8f5e8 !important;
            font-weight: 700;
            color: #27ae60;
            font-size: 14px;
        }
        
        /* Service Details */
        .service-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .service-description {
            color: #6c757d;
            font-size: 11px;
            margin-bottom: 5px;
        }
        
        .service-meta {
            font-size: 10px;
            color: #868e96;
        }
        
        .quantity-badge {
            background: #3498db;
            color: white;
            padding: 2px 6px;
            border-radius: 12px;
            font-size: 10px;
            margin-left: 5px;
        }
        
        /* Terms Section */
        .terms-section {
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        
        /* Signature Section */
        .signature-section {
            margin-top: 40px;
        }
        
        .signature-box {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            min-height: 120px;
        }
        
        .signature-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .signature-line {
            border-bottom: 1px solid #dee2e6;
            height: 30px;
            margin-bottom: 5px;
        }
        
        .signature-label {
            font-size: 11px;
            color: #6c757d;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
        }
        
        .footer h4 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .footer p {
            margin: 5px 0;
            font-size: 11px;
        }
        
        /* Utility Classes */
        .text-end {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .mb-0 { margin-bottom: 0; }
        .mb-1 { margin-bottom: 8px; }
        .mb-2 { margin-bottom: 15px; }
        .mb-3 { margin-bottom: 20px; }
        .mb-4 { margin-bottom: 30px; }
        
        .mt-0 { margin-top: 0; }
        .mt-2 { margin-top: 15px; }
        .mt-3 { margin-top: 20px; }
        .mt-4 { margin-top: 30px; }
        
        .text-primary { color: #3498db; }
        .text-success { color: #27ae60; }
        .text-muted { color: #6c757d; }
        .text-dark { color: #2c3e50; }
        
        .font-weight-bold { font-weight: 700; }
        .font-weight-600 { font-weight: 600; }
        
        .border { border: 1px solid #dee2e6; }
        .rounded { border-radius: 8px; }
        
        /* Price Formatting */
        .price {
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }
        
        .total-price {
            font-size: 16px;
            color: #27ae60;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Business Proposal</h1>
            <h2>Website Design and Digital Marketing Services</h2>
        </div>

        <!-- Client and Quotation Information -->
        <div class="row">
            <div class="col-6">
                <div class="section">
                    <h3 class="section-title">Client Information</h3>
                    <div class="info-box">
                        <div class="info-row">
                            <span class="info-label">Business Name:</span>
                            <span class="info-value">{{ $quotation->client_business_name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Contact Person:</span>
                            <span class="info-value">{{ $quotation->client_contact_name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email Address:</span>
                            <span class="info-value">{{ $quotation->client_email }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Phone Number:</span>
                            <span class="info-value">{{ $quotation->client_phone }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="section">
                    <h3 class="section-title">Quotation Details</h3>
                    <div class="info-box">
                        <div class="info-row">
                            <span class="info-label">Quotation No:</span>
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
                            <span class="info-label">Status:</span>
                            <span class="info-value">{{ ucfirst($quotation->status) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Executive Summary -->
        @if($quotation->executive_summary)
        <div class="section">
            <h3 class="section-title">Executive Summary</h3>
            <div class="info-box">
                <p>{{ $quotation->executive_summary }}</p>
            </div>
        </div>
        @endif

        <!-- Services Overview -->
        <div class="section">
            <h3 class="section-title">Proposed Services</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th width="25%">Service Name</th>
                        <th width="35%">Description</th>
                        <th width="15%">Timeline</th>
                        <th width="10%">Price</th>
                        <th width="8%">Qty</th>
                        <th width="7%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotation->services as $service)
                    <tr>
                        <td>
                            <div class="service-name">
                                {{ $service->name }}
                                @if($service->pivot->quantity > 1)
                                <span class="quantity-badge">×{{ $service->pivot->quantity }}</span>
                                @endif
                            </div>
                            @if($service->is_optional)
                            <div class="service-meta">Optional Service</div>
                            @endif
                        </td>
                        <td>
                            <div class="service-description">{{ Str::limit($service->description, 200) }}</div>
                        </td>
                        <td>
                            @if($service->timeline_weeks)
                            <div>{{ $service->timeline_weeks }} weeks</div>
                            @else
                            <div>Ongoing</div>
                            @endif
                        </td>
                        <td class="price">{{ number_format($service->pivot->price, 2) }}</td>
                        <td class="text-center">{{ $service->pivot->quantity }}</td>
                        <td class="price">{{ number_format($service->pivot->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Investment Summary -->
        <div class="row">
            <div class="col-6">
                <div class="section">
                    <h3 class="section-title">Investment Summary</h3>
                    <table class="table pricing-table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Cost (excluding GST)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotation->services as $service)
                            <tr>
                                <td>{{ $service->name }}</td>
                                <td class="price">{{ number_format($service->pivot->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                            <tr class="table-info">
                                <td>Subtotal</td>
                                <td class="price">{{ number_format($quotation->total_cost, 2) }}</td>
                            </tr>
                            <tr>
                                <td>GST (18%)</td>
                                <td class="price">{{ number_format($quotation->gst_amount, 2) }}</td>
                            </tr>
                            <tr class="table-success">
                                <td>Total Investment</td>
                                <td class="price total-price">{{ number_format($quotation->final_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-6">
                <div class="section">
                    <h3 class="section-title">Project Timeline</h3>
                    <div class="info-box">
                        @foreach($quotation->services as $service)
                        @if($service->timeline_weeks)
                        <div class="info-row mb-2">
                            <span class="info-label">{{ $service->name }}:</span>
                            <span class="info-value">{{ $service->timeline_weeks }} weeks</span>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Terms and Conditions -->
        @if($quotation->terms_conditions)
        <div class="section">
            <h3 class="section-title">Terms and Conditions</h3>
            <div class="terms-section">
                {!! nl2br($quotation->terms_conditions) !!}
            </div>
        </div>
        @endif

        <!-- Agreement Section -->
        <div class="section signature-section">
            <h3 class="section-title">Agreement</h3>
            <p>By signing below, you agree to the terms and conditions outlined in this proposal.</p>
            <div class="row">
                <div class="col-6">
                    <div class="signature-box">
                        <div class="signature-title">Client Signature</div>
                        <div class="signature-line"></div>
                        <div class="signature-label">Name: _____________________</div>
                        <div class="signature-label">Date: _____________________</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="signature-box">
                        <div class="signature-title">Service Provider</div>
                        <div class="signature-line"></div>
                        <div class="signature-label">Name: {{ $quotation->creator->name }}</div>
                        <div class="signature-label">Date: _____________________</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h4>Thank you for your business!</h4>
            <p><strong>Contact Information:</strong></p>
            <p>📧 Email: udyami.nircrm24@gmail.com</p>
            <p>📞 Phone: +91-9220518202</p>
            <p>🌐 Website: www.nircrm.com</p>
            <p class="mt-3"><em>We look forward to working with you to achieve your business goals.</em></p>
            <p class="mt-2"><strong>Best regards,<br>{{ $quotation->creator->name }}<br>NIRCRM Team</strong></p>
        </div>
    </div>
</body>
</html>
