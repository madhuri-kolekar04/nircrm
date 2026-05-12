<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Approved - NIRCRM</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 600px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            text-align: center;
        }
        .header {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 40px 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
        }
        .content {
            padding: 40px 30px;
        }
        .success-icon {
            font-size: 64px;
            color: #27ae60;
            margin-bottom: 20px;
        }
        .invoice-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }
        .invoice-details h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #7f8c8d;
        }
        .detail-value {
            color: #2c3e50;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #7f8c8d;
        }
        .footer a {
            color: #3498db;
            text-decoration: none;
            margin: 0 10px;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Invoice Approved Successfully!</h1>
            <p>Thank you for your prompt approval</p>
        </div>

        <div class="content">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <h2>Invoice Approval Confirmed</h2>
            <p>{{ $message ?? 'Your invoice has been successfully approved and processed.' }}</p>
            
            @if($invoice ?? null)
            <div class="invoice-details">
                <h3>📋 Invoice Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Invoice Number:</span>
                    <span class="detail-value">{{ $invoice->invoice_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Client Name:</span>
                    <span class="detail-value">{{ $invoice->customer_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Amount:</span>
                    <span class="detail-value">₹{{ number_format($invoice->total_payment, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Approval Date:</span>
                    <span class="detail-value">{{ $tracking ? $tracking->responded_at->format('M d, Y h:i A') : now()->format('M d, Y h:i A') }}</span>
                </div>
            </div>
            @endif
            
            <p><strong>What happens next?</strong></p>
            <ul style="text-align: left; max-width: 400px; margin: 0 auto;">
                <li>Your invoice has been marked as approved</li>
                <li>Our team will process your payment</li>
                <li>You will receive a confirmation email shortly</li>
                <li>For any queries, please contact our support team</li>
            </ul>
        </div>

        <div class="footer">
            <p><strong>NIRCRM Professional Business Solutions</strong></p>
            <p>Thank you for your business!</p>
            <div>
                <a href="/">Visit Our Website</a>
                <a href="tel:9284161465">Call Support</a>
                <a href="mailto:support@nircrm.com">Email Support</a>
            </div>
            <p style="font-size: 12px; margin-top: 15px;">
                © 2026 NIRCRM. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
