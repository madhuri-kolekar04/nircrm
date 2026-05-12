<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Approval Request - NIRCRM</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f7fa;
        }
        .container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
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
        .invoice-details {
            background: #f8f9fc;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
        }
        .invoice-details h3 {
            margin: 0 0 20px 0;
            color: #495057;
            font-size: 20px;
            display: flex;
            align-items: center;
        }
        .invoice-details h3::before {
            content: "📋";
            margin-right: 10px;
            font-size: 24px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #6c757d;
            flex: 1;
        }
        .detail-value {
            font-weight: 500;
            color: #495057;
            flex: 2;
            text-align: right;
        }
        .amount {
            color: #28a745;
            font-weight: 700;
            font-size: 18px;
        }
        .action-section {
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            border-radius: 8px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
        }
        .action-section h3 {
            margin: 0 0 20px 0;
            color: #495057;
            font-size: 20px;
        }
        .btn {
            display: inline-block;
            padding: 14px 28px;
            margin: 10px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            min-width: 140px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn-approve {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }
        .btn-reject {
            background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }
        .btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        }
        .btn-call {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }
        .btn-call:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        }
        .footer {
            background: #f8f9fc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
            color: #6c757d;
            font-size: 14px;
        }
        .footer .company {
            font-weight: 600;
            color: #495057;
        }
        .highlight-box {
            background: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 20px 25px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }
        .highlight-box h3 {
            margin: 0 0 15px 0;
            color: #0056b3;
            font-size: 18px;
        }
        .approval-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .approval-info p {
            margin: 0;
            color: #856404;
            font-size: 14px;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 8px;
            }
            .header, .content, .footer {
                padding: 25px 20px;
            }
            .btn {
                display: block;
                width: 100%;
                margin: 10px 0;
            }
            .detail-row {
                flex-direction: column;
                gap: 5px;
            }
            .detail-value {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📄 Invoice Approval Request</h1>
            <p>Action Required: Please Review and Approve</p>
        </div>

        <div class="content">
            <p>Dear <strong>{{ $lead->name }}</strong>,</p>
            
            <p>We have prepared an invoice for your business requirements. Please review the details below and take appropriate action to proceed with the project.</p>

            <div class="invoice-details">
                <h3>Invoice Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Invoice Number:</span>
                    <span class="detail-value">{{ $invoice->invoice_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Invoice Date:</span>
                    <span class="detail-value">{{ $invoice->invoice_date->format('M d, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value amount">${{ number_format($invoice->total_payment, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Project/Service:</span>
                    <span class="detail-value">{{ $invoice->project_name }}</span>
                </div>
                @if($invoice->department)
                <div class="detail-row">
                    <span class="detail-label">Department:</span>
                    <span class="detail-value">{{ $invoice->department }}</span>
                </div>
                @endif
            </div>

            <div class="approval-info">
                <p><strong>📧 Email Sent:</strong> This approval request was sent on {{ now()->format('M d, Y \a\t h:i A') }}. Please respond at your earliest convenience.</p>
            </div>

            <div class="action-section">
                <h3>🎯 Choose Your Action</h3>
                <p>Please select one of the following options:</p>
                
                <div style="margin: 25px 0;">
                    <a href="{{ url('/invoice/approve/' . $approvalToken) }}" class="btn btn-approve">
                        ✅ Approve Invoice
                    </a>
                    
                    <a href="{{ url('/invoice/reject/' . $approvalToken) }}" class="btn btn-reject">
                        ❌ Reject Invoice
                    </a>
                    
                    <a href="tel:{{ $callNumber }}" class="btn btn-call">
                        📞 Call Us: {{ $callNumber }}
                    </a>
                </div>
            </div>

            <div class="highlight-box">
                <h3>📞 Need Assistance?</h3>
                <p>If you have any questions or need clarification about the invoice details, please don't hesitate to contact us:</p>
                <ul style="text-align: left; margin: 15px 0;">
                    <li><strong>Phone:</strong> {{ $callNumber }}</li>
                    <li><strong>Email:</strong> {{ config('mail.from.address') }}</li>
                    <li><strong>Working Hours:</strong> Monday to Saturday, 9:00 AM - 6:00 PM</li>
                </ul>
                <p>Our dedicated team is ready to assist you with any concerns you may have.</p>
            </div>

            <div style="background: #f8f9fc; padding: 20px; border-radius: 8px; margin: 25px 0;">
                <h4 style="margin: 0 0 15px 0; color: #495057;">📋 What Happens Next?</h4>
                <ol style="margin: 0; padding-left: 20px; color: #6c757d;">
                    <li style="margin-bottom: 10px;">Upon approval, the invoice status will be updated to "Approved" in our system</li>
                    <li style="margin-bottom: 10px;">You will receive a confirmation email with payment instructions</li>
                    <li style="margin-bottom: 10px;">Our team will begin processing your order/service immediately</li>
                    <li>You can track the progress through your customer portal</li>
                </ol>
            </div>

            <p><strong>Important Note:</strong> This approval link is valid for 7 days. After that, you may need to contact us for a new approval request.</p>
        </div>

        <div class="footer">
            <p class="company">{{ config('mail.from.name', 'NIRCRM') }}</p>
            <p>Professional Business Solutions</p>
            <p>&copy; {{ date('Y') }} {{ config('mail.from.name', 'NIRCRM') }}. All rights reserved.</p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
