<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #fff;
        }
        .invoice-header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .invoice-header h1 {
            color: #333;
            margin: 0;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-details, .customer-details {
            width: 48%;
        }
        .section-title {
            font-weight: bold;
            color: #667eea;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .details-table td:first-child {
            font-weight: bold;
            background: #f8f9fa;
            width: 30%;
        }
        .payment-summary {
            margin-top: 30px;
        }
        .payment-table {
            width: 100%;
            border-collapse: collapse;
        }
        .payment-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .payment-table td:first-child {
            font-weight: bold;
            background: #f8f9fa;
        }
        .total-row {
            background: #667eea !important;
            color: white;
            font-weight: bold;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-size: 12px;
        }
        .status-paid { background: #28a745; }
        .status-pending { background: #ffc107; color: #333; }
        .status-overdue { background: #dc3545; }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>NIRANJAN ENTERPRISES</h1>
        <p>Help Desk Management System</p>
        <h2>INVOICE</h2>
    </div>

    <div class="invoice-info">
        <div class="invoice-details">
            <div class="section-title">Invoice Details</div>
            <p><strong>Invoice Number:</strong> {{ $tempInvoice->invoice_number }}</p>
            <p><strong>Invoice Date:</strong> {{ is_object($tempInvoice->invoice_date) ? $tempInvoice->invoice_date->format('d-m-Y') : date('d-m-Y', strtotime($tempInvoice->invoice_date)) }}</p>
            <p><strong>Status:</strong> <span class="status-badge status-{{ $tempInvoice->status }}">{{ ucfirst($tempInvoice->status) }}</span></p>
        </div>
        <div class="customer-details">
            <div class="section-title">Customer Details</div>
            <p><strong>Name:</strong> {{ $tempInvoice->customer_name }}</p>
            <p><strong>Email:</strong> {{ $tempInvoice->customer_email }}</p>
            <p><strong>Phone:</strong> {{ $tempInvoice->customer_phone }}</p>
            <p><strong>Address:</strong> {{ $tempInvoice->customer_address }}</p>
        </div>
    </div>

    <div class="section-title">Project Details</div>
    <table class="details-table">
        <tr>
            <td>Project Name</td>
            <td>{{ $tempInvoice->project_name }}</td>
        </tr>
        <tr>
            <td>Project Topic</td>
            <td>{{ $tempInvoice->project_topic }}</td>
        </tr>
        <tr>
            <td>Project Details</td>
            <td>{{ $tempInvoice->project_full_details }}</td>
        </tr>
        <tr>
            <td>Start Date</td>
            <td>{{ is_object($tempInvoice->start_date) ? $tempInvoice->start_date->format('d-m-Y') : date('d-m-Y', strtotime($tempInvoice->start_date)) }}</td>
        </tr>
        <tr>
            <td>End Date</td>
            <td>{{ is_object($tempInvoice->end_date) ? $tempInvoice->end_date->format('d-m-Y') : date('d-m-Y', strtotime($tempInvoice->end_date)) }}</td>
        </tr>
        <tr>
            <td>Department</td>
            <td>{{ $tempInvoice->department }}</td>
        </tr>
    </table>

    <div class="payment-summary">
        <div class="section-title">Payment Details</div>
        <table class="payment-table">
            <tr>
                <td>Advance Payment</td>
                <td style="text-align: right;">₹{{ number_format($tempInvoice->advance_payment, 2) }}</td>
            </tr>
            <tr>
                <td>Remaining Payment</td>
                <td style="text-align: right;">₹{{ number_format($tempInvoice->remaining_payment, 2) }}</td>
            </tr>
            <tr>
                <td>GST</td>
                <td style="text-align: right;">₹{{ number_format($tempInvoice->gst, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Total Payment</td>
                <td style="text-align: right;">₹{{ number_format($tempInvoice->total_payment, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Thank you for your business! Please make payment within 30 days.</p>
        <p>This is a computer-generated invoice. No signature required.</p>
    </div>
</body>
</html>
