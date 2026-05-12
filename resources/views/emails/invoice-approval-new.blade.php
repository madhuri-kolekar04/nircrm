<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Approval Required - {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }
        .header .subtitle {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }
        .nircrm-logo {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 25px;
        }
        .invoice-details {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            border: 2px solid #e9ecef;
            position: relative;
        }
        .invoice-details::before {
            content: '📋';
            position: absolute;
            top: -15px;
            left: 30px;
            background: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 24px;
            border: 2px solid #e9ecef;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-number {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            background: linear-gradient(135deg, #3498db, #2980b9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .invoice-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .invoice-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
        }
        .invoice-item label {
            display: block;
            font-size: 12px;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .invoice-item value {
            display: block;
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
        }
        .amount-section {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            margin: 30px 0;
        }
        .amount-amount {
            font-size: 36px;
            font-weight: bold;
            margin: 10px 0;
        }
        .mail-id-section {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin: 20px 0;
        }
        .mail-id {
            font-size: 20px;
            font-weight: bold;
            font-family: 'Courier New', monospace;
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 8px;
            display: inline-block;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 40px 0;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        .btn-approve {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
        }
        .btn-call {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 12px;
            text-transform: uppercase;
        }
        .badge-warning {
            background: #ffc107;
            color: #856404;
        }
        .badge-success {
            background: #28a745;
            color: white;
        }
        .badge-danger {
            background: #dc3545;
            color: white;
        }
        .btn i {
            font-size: 20px;
        }
        .footer {
            background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer .company {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .footer .tagline {
            opacity: 0.8;
            font-style: italic;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .status-pending {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 10px;
            }
            .header {
                padding: 30px 20px;
            }
            .content {
                padding: 30px 20px;
            }
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            .btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="nircrm-logo">🚀 NIRCRM</div>
            <h1>Invoice Approval Required</h1>
            <div class="subtitle">Professional Business Solutions</div>
        </div>

        <div class="content">
            <div class="greeting">
                Dear <strong>{{ $quotation->client_contact_name ?? $quotation->client_name ?? 'Valued Customer' }},</strong>
            </div>
            
            <p>We have generated an invoice for your business requirements. Please review the complete details below and take appropriate action to proceed with your order.</p>

            <div class="invoice-details">
                <h3>📋 Invoice Details</h3>
                <table>
                    <tr>
                        <td><strong>Invoice Number:</strong></td>
                        <td>{{ $invoice->invoice_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Current Status:</strong></td>
                        <td><span class="badge badge-{{ $invoice->status == 'pending' ? 'warning' : ($invoice->status == 'approved' ? 'success' : 'danger') }}">
                            <i class="{{ $invoice->status == 'pending' ? 'fas fa-clock' : ($invoice->status == 'approved' ? 'fas fa-check-circle' : 'fas fa-times-circle') }}"></i>
                            {{ ucfirst($invoice->status) }}
                        </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Installment:</strong></td>
                        <td><span class="installment-badge">{{ $installmentLetter ?? 'N/A' }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Invoice Date:</strong></td>
                        <td>{{ $invoice->invoice_date ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Due Date:</strong></td>
                        <td>{{ $invoice->end_date ?? 'Not specified' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Client Name:</strong></td>
                        <td>{{ $invoice->customer_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $invoice->customer_email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone:</strong></td>
                        <td>{{ $invoice->customer_phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Department:</strong></td>
                        <td>{{ $invoice->department ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Amount:</strong></td>
                        <td><strong style="color: #28a745;">₹{{ number_format($invoice->total_payment ?? 0, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>GST (18%):</strong></td>
                        <td>₹{{ number_format($invoice->gst ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Amount:</strong></td>
                        <td><strong style="color: #007bff;">₹{{ number_format(($invoice->total_payment ?? 0) + ($invoice->gst ?? 0), 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Invoice Status:</strong></td>
                        <td><span class="badge badge-{{ $invoice->status == 'pending' ? 'warning' : ($invoice->status == 'approved' ? 'success' : 'danger') }}">
                            <i class="{{ $invoice->status == 'pending' ? 'fas fa-clock' : ($invoice->status == 'approved' ? 'fas fa-check-circle' : 'fas fa-times-circle') }}"></i>
                            {{ ucfirst($invoice->status) }}
                        </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                <h6 style="margin: 0 0 10px 0; color: #2c3e50;">Service Details</h6>
                <div style="display: grid; grid-template-columns: 1fr auto; gap: 15px; align-items: center;">
                    <div>
                        <strong>{{ $invoice->project_topic ?? 'Service/Project' }}</strong>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 18px; font-weight: bold; color: #27ae60;">₹{{ number_format($invoice->total_payment ?? 0, 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="amount-section">
                <div>Total Amount Due</div>
                <div class="amount-amount">₹{{ number_format($invoice->total_payment ?? 0, 2) }}</div>
                <div>Including GST: ₹{{ number_format($invoice->gst ?? 0, 2) }}</div>
            </div>

            <div class="mail-id-section">
                <div>📧 Mail ID</div>
                <div class="mail-id">{{ $invoice->mail_id ?? 'N/A' }}</div>
            </div>

            <div class="action-buttons">
                @if($invoice->status == 'pending')
                    <a href="{{ route('invoice.approve', $approvalToken) }}" class="btn btn-approve">
                        <i class="fas fa-clock"></i> Approve Invoice
                    </a>
                @elseif($invoice->status == 'approved')
                    <a href="#" class="btn btn-success" disabled>
                        <i class="fas fa-check-circle"></i> Invoice Already APPROVED - Status: {{ $invoice->status }}
                    </a>
                @else
                    <a href="{{ route('invoice.approve', $approvalToken) }}" class="btn btn-approve">
                        <i class="fas fa-exclamation-triangle"></i> Review Invoice - Status: {{ $invoice->status }}
                    </a>
                @endif
                <a href="tel:{{ $callNumber }}" class="btn btn-call">
                    <i class="fas fa-phone"></i> Call Support ({{ $callNumber }})
                </a>
            </div>

            <div style="text-align: center; margin: 30px 0; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <h4 style="color: #2c3e50; margin-bottom: 15px;">📌 Important Information</h4>
                <ul style="text-align: left; max-width: 400px; margin: 0 auto;">
                    <li>This is an automated approval request for your invoice</li>
                    <li>Click "Approve Invoice" to review and approve the invoice</li>
                    <li>For any queries, call our support team at {{ $callNumber }}</li>
                    <li>Your prompt payment helps us serve you better</li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <div class="company">NIRCRM Professional Business Solutions</div>
            <div class="tagline">Your Trusted Partner for Business Growth</div>
            <p>Thank you for your business!</p>
            <p>We appreciate your prompt payment and continued trust in our services.</p>
            <p style="font-size: 12px; opacity: 0.7; margin-top: 20px;">
                This is an automated message. Please do not reply to this email.<br>
                © 2026 NIRCRM. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
