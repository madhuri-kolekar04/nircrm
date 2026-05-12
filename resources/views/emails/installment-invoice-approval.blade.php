<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installment {{ $installmentLetter }} Invoice Approval Required</title>
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
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
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
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .invoice-details td:first-child {
            font-weight: bold;
            width: 40%;
        }
        .installment-badge {
            background: #ff6b6b;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin: 10px 0;
        }
        .action-buttons {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-approve {
            background: #28a745;
            color: white;
        }
        .btn-approve:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        .btn-call {
            background: #007bff;
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
        .btn-call:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background: #e9ecef;
            border-radius: 8px;
            color: #666;
        }
        .highlight {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📄 Installment {{ $installmentLetter }} Invoice Approval Required</h1>
        <p>Action Required: Please Review and Approve Installment Payment</p>
    </div>

    <div class="content">
        <p>Dear {{ $quotation->client_contact_name }},</p>
        
        <p>We have generated <strong>Installment {{ $installmentLetter }}</strong> invoice for your business requirements. This is part of the payment schedule for your quotation. Please review the details below and take appropriate action.</p>

        <div class="installment-badge">
            <i class="fas fa-file-invoice"></i> Installment {{ $installmentLetter }} Invoice
        </div>

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
                    <td><span class="installment-badge">{{ $installmentLetter }}</span></td>
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

        <div class="highlight">
            <h4>📌 Important Information</h4>
            <ul>
                <li>This is <strong>Installment {{ $installmentLetter }}</strong> of your payment schedule</li>
                <li>Please review all details carefully before approval</li>
                <li>Payment terms and conditions are mentioned in the invoice</li>
            </ul>
        </div>

        <div class="action-buttons">
            @if($invoice->status == 'pending')
                <a href="{{ route('invoice.approve', $approvalToken) }}" class="btn btn-approve">
                    <i class="fas fa-clock"></i> Approve Installment {{ $installmentLetter }}
                </a>
            @elseif($invoice->status == 'approved')
                <a href="#" class="btn btn-success" disabled>
                    <i class="fas fa-check-circle"></i> Invoice Already APPLIED - Status: {{ $invoice->status }}
                </a>
            @else
                <a href="{{ route('invoice.approve', $approvalToken) }}" class="btn btn-approve">
                    <i class="fas fa-exclamation-triangle"></i> Review Installment {{ $installmentLetter }} - Status: {{ $invoice->status }}
                </a>
            @endif
            <a href="tel:{{ $callNumber }}" class="btn btn-call">
                <i class="fas fa-phone"></i> Call Support ({{ $callNumber }})
            </a>
        </div>

        <div class="footer">
            <p><strong>Thank you for your business!</strong></p>
            <p>We appreciate your prompt payment and continued trust in our services.</p>
            <p><small>This is an automated message. Please do not reply to this email.</small></p>
            <p><small>NIRCRM | Professional Business Solutions</small></p>
        </div>
    </div>
</body>
</html>
