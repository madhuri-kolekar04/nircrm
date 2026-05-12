<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Approval Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }
        .header {
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2c3e50;
            font-size: 32px;
            margin-bottom: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 18px;
            margin: 20px 0;
        }
        .status-approved {
            background: #28a745;
            color: white;
        }
        .status-pending {
            background: #ffc107;
            color: #856404;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            margin: 20px 10px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        .invoice-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: left;
        }
        .invoice-details h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }
        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .invoice-details td:first-child {
            font-weight: bold;
            width: 40%;
        }
        .footer {
            margin-top: 30px;
            padding: 20px;
            background: #e9ecef;
            border-radius: 10px;
            color: #6c757d;
        }
        .success-icon {
            font-size: 60px;
            color: #28a745;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">✅</div>
            <h1>Invoice Approval Status</h1>
            <p>Invoice has been successfully processed</p>
        </div>

        <div class="status-badge status-approved">
            <i class="fas fa-check-circle"></i> Approved
        </div>

        <div class="invoice-details">
            <h3>📋 Invoice Information</h3>
            <table>
                <tr>
                    <td><strong>Invoice Number:</strong></td>
                    <td>{{ $invoice->invoice_number ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Current Status:</strong></td>
                    <td><span class="status-badge status-approved">Approved</span></td>
                </tr>
                <tr>
                    <td><strong>Client Name:</strong></td>
                    <td>{{ $invoice->customer_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Amount:</strong></td>
                    <td><strong style="color: #28a745;">₹{{ number_format($invoice->total_payment ?? 0, 2) }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="action-buttons">
            <a href="{{ route('invoices.management', ['quotationId' => $quotation?->id ?? $lead?->id ?? 'all']) }}" class="btn btn-success">
                <i class="fas fa-check-circle"></i> View Management Page
            </a>
            <a href="tel:{{ $callNumber ?? '+919876543210' }}" class="btn btn-primary">
                <i class="fas fa-phone"></i> Call Support
            </a>
        </div>

        <div class="footer">
            <p><strong>Thank you for your business!</strong></p>
            <p>Your invoice has been approved successfully. You can view the updated status in the management dashboard.</p>
        </div>
    </div>
</body>
</html>
