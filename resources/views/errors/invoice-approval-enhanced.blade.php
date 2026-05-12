<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Approval - NIRCRM</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
        }
        .header {
            padding: 40px 30px;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
        }
        .header.success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        .header.error {
            background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
            color: white;
        }
        .header.rejected {
            background: linear-gradient(135deg, #fd7e14 0%, #e67e22 100%);
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
        }
        .icon {
            font-size: 64px;
            margin-bottom: 20px;
            display: block;
        }
        .success .icon {
            color: #28a745;
        }
        .error .icon {
            color: #dc3545;
        }
        .rejected .icon {
            color: #fd7e14;
        }
        .message {
            font-size: 18px;
            margin-bottom: 30px;
            color: #495057;
        }
        .details {
            background: #f8f9fc;
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #6c757d;
        }
        .detail-value {
            font-weight: 500;
            color: #495057;
        }
        .actions {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 0 10px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .footer {
            background: #f8f9fc;
            padding: 25px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
            color: #6c757d;
            font-size: 14px;
        }
        .company {
            font-weight: 600;
            color: #495057;
        }
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            .container {
                margin: 0;
                border-radius: 0;
            }
            .header, .content, .footer {
                padding: 25px 20px;
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
        <div class="header {{ $status }}">
            @if($status == 'success')
                <h1>✅ Invoice Approved</h1>
                <p>Thank you for your approval!</p>
            @elseif($status == 'rejected')
                <h1>❌ Invoice Rejected</h1>
                <p>We have received your rejection</p>
            @else
                <h1>⚠️ Approval Error</h1>
                <p>Unable to process your request</p>
            @endif
        </div>

        <div class="content">
            @if($status == 'success')
                <span class="icon">🎉</span>
                <p class="message">{{ $message }}</p>
                
                @if(isset($invoice) && isset($lead))
                    <div class="details">
                        <h4 style="margin: 0 0 20px 0; color: #495057;">Invoice Details</h4>
                        <div class="detail-row">
                            <span class="detail-label">Invoice Number:</span>
                            <span class="detail-value">{{ $invoice->invoice_number }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Lead Name:</span>
                            <span class="detail-value">{{ $lead->name }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Total Amount:</span>
                            <span class="detail-value">${{ number_format($invoice->total_payment, 2) }}</span>
                        </div>
                        @if(isset($tracking))
                            <div class="detail-row">
                                <span class="detail-label">Approved At:</span>
                                <span class="detail-value">{{ $tracking->responded_at->format('M d, Y h:i A') }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div style="background: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; padding: 20px; margin: 25px 0;">
                        <h4 style="margin: 0 0 15px 0; color: #155724;">What Happens Next?</h4>
                        <ul style="margin: 0; padding-left: 20px; color: #155724;">
                            <li>Our team will begin processing your order immediately</li>
                            <li>You will receive a confirmation email with payment instructions</li>
                            <li>Your project/service will be activated according to the agreed timeline</li>
                            <li>You can track progress through your customer portal</li>
                        </ul>
                    </div>
                @endif

            @elseif($status == 'rejected')
                <span class="icon">📋</span>
                <p class="message">{{ $message }}</p>
                
                @if(isset($invoice) && isset($lead))
                    <div class="details">
                        <h4 style="margin: 0 0 20px 0; color: #495057;">Rejection Details</h4>
                        <div class="detail-row">
                            <span class="detail-label">Invoice Number:</span>
                            <span class="detail-value">{{ $invoice->invoice_number }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Lead Name:</span>
                            <span class="detail-value">{{ $lead->name }}</span>
                        </div>
                        @if(isset($tracking))
                            <div class="detail-row">
                                <span class="detail-label">Rejected At:</span>
                                <span class="detail-value">{{ $tracking->responded_at->format('M d, Y h:i A') }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 20px; margin: 25px 0;">
                        <h4 style="margin: 0 0 15px 0; color: #856404;">Need to Discuss?</h4>
                        <p style="margin: 0 0 15px 0; color: #856404;">We understand you may have concerns about the invoice. Our team is ready to help:</p>
                        <ul style="margin: 0; padding-left: 20px; color: #856404;">
                            <li>Call us at <strong>9284161465</strong> for immediate assistance</li>
                            <li>Reply to this email with your questions</li>
                            <li>Schedule a meeting to discuss your requirements</li>
                        </ul>
                    </div>
                @endif

            @else
                <span class="icon">⚠️</span>
                <p class="message">{{ $message }}</p>
                
                @if(isset($expired) && $expired)
                    <div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 20px; margin: 25px 0;">
                        <h4 style="margin: 0 0 15px 0; color: #721c24;">Link Expired</h4>
                        <p style="margin: 0; color: #721c24;">This approval link has expired (7-day limit). Please contact our support team for a new approval request.</p>
                    </div>
                @endif
                
                <div style="background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 8px; padding: 20px; margin: 25px 0;">
                    <h4 style="margin: 0 0 15px 0; color: #0c5460;">Need Help?</h4>
                    <p style="margin: 0; color: #0c5460;">If you're experiencing issues with the approval process, please reach out to our support team:</p>
                    <ul style="margin: 10px 0 0 0; padding-left: 20px; color: #0c5460;">
                        <li><strong>Phone:</strong> 9284161465</li>
                        <li><strong>Email:</strong> {{ config('mail.from.address') }}</li>
                        <li><strong>Hours:</strong> Monday to Saturday, 9:00 AM - 6:00 PM</li>
                    </ul>
                </div>
            @endif

            <div class="actions">
                <a href="https://nircrm.com" class="btn btn-primary">Visit Our Website</a>
                <a href="mailto:{{ config('mail.from.address') }}" class="btn btn-secondary">Contact Support</a>
            </div>
        </div>

        <div class="footer">
            <p class="company">{{ config('mail.from.name', 'NIRCRM') }}</p>
            <p>Professional Business Solutions</p>
            <p>&copy; {{ date('Y') }} {{ config('mail.from.name', 'NIRCRM') }}. All rights reserved.</p>
            <p>This is an automated response. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
