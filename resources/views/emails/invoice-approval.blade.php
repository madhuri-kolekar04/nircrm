<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Approval Required</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .invoice-details {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            min-width: 120px;
        }
        .btn-approve {
            background: #28a745;
            color: white;
        }
        .btn-call {
            background: #007bff;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 12px;
        }
        .highlight {
            background: #e7f3ff;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📄 Invoice Approval Required</h1>
        <p>Action Required: Please Review and Approve</p>
    </div>

    <div class="content">
        <p>Dear {{ $lead->name }},</p>
        
        <p>We have generated an invoice for your business requirements. Please review the details below and take appropriate action.</p>

        <div class="invoice-details">
            <h3>📋 Invoice Details</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Invoice Number:</strong></td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $invoice->invoice_number }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Invoice Date:</strong></td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $invoice->invoice_date->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Total Amount:</strong></td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">${{ number_format($invoice->total_payment, 2) }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Project:</strong></td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $invoice->project_name }}</td>
                </tr>
            </table>
        </div>

        <div class="highlight">
            <h3>🎯 Next Steps</h3>
            <p>Please choose one of the following actions:</p>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/invoice/approve/' . $approvalToken) }}" class="btn btn-approve">
                ✅ Approve Invoice
            </a>
            
            <a href="tel:{{ $callNumber }}" class="btn btn-call">
                📞 Call Us: {{ $callNumber }}
            </a>
        </div>

        <div class="highlight">
            <h3>📞 Need Help?</h3>
            <p>If you have any questions or need clarification about the invoice, please don't hesitate to call us at <strong>{{ $callNumber }}</strong>.</p>
            <p>Our team is ready to assist you with any concerns you may have.</p>
        </div>

        <p><strong>Important Note:</strong> Upon approval, the invoice status will be updated in our system and you will receive a confirmation email with further payment instructions.</p>
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
    </div>
</body>
</html>
