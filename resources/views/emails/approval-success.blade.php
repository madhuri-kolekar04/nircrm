<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Approved - {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
        }
        .success-icon {
            font-size: 80px;
            margin: 20px 0;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .invoice-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .invoice-number {
            font-size: 24px;
            font-weight: bold;
            color: #27ae60;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            margin: 20px 10px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        .footer {
            background: #34495e;
            color: white;
            padding: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">✅</div>
            <h1>Invoice Approved Successfully!</h1>
        </div>

        <div class="content">
            <p>Thank you for approving the invoice. Your approval has been processed successfully.</p>
            
            <div class="invoice-details">
                <h3>Invoice Details</h3>
                <div class="invoice-number">{{ $invoice->invoice_number }}</div>
                <p>Amount: ₹{{ number_format($invoice->total_payment, 2) }}</p>
                <p>Client: {{ $invoice->customer_name }}</p>
            </div>

            <div>
                <a href="tel:{{ $callNumber }}" class="btn">
                    📞 Call Support: {{ $callNumber }}
                </a>
            </div>

            <p style="margin-top: 30px; color: #666;">
                This page can now be closed. You will receive a confirmation email shortly.
            </p>
        </div>

        <div class="footer">
            <p>© 2026 NIRCRM Professional Business Solutions</p>
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
