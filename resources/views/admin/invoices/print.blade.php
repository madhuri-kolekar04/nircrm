<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }} - Niranjan Enterprises</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
            padding: 20px;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
            background: #fff;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #007bff;
            font-size: 2.5em;
            margin-bottom: 5px;
        }
        
        .header h2 {
            color: #333;
            font-size: 1.8em;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
            font-size: 1.1em;
        }
        
        .invoice-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .invoice-details, .customer-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }
        
        .section-title {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
            font-size: 1.2em;
        }
        
        .detail-row {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }
        
        .detail-label {
            font-weight: bold;
            color: #555;
        }
        
        .detail-value {
            color: #333;
        }
        
        .project-section, .payment-section {
            margin-bottom: 30px;
        }
        
        .section-header {
            background: #007bff;
            color: white;
            padding: 10px 15px;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .info-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        
        .info-table td:first-child {
            background: #f8f9fa;
            font-weight: bold;
            width: 30%;
        }
        
        .payment-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .payment-table th, .payment-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        
        .payment-table th {
            background: #007bff;
            color: white;
        }
        
        .payment-table .total-row {
            background: #e3f2fd;
            font-weight: bold;
        }
        
        .text-right {
            text-align: right;
        }
        
        .installment-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .installment-table th, .installment-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        
        .installment-table th {
            background: #6c757d;
            color: white;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #007bff;
            text-align: center;
            color: #666;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: bold;
        }
        
        .status-paid {
            background: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-overdue {
            background: #f8d7da;
            color: #721c24;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .invoice-container {
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <h1>NIRANJAN ENTERPRISES</h1>
            <h2>TAX INVOICE</h2>
            <p>Help Desk Management System</p>
        </div>
        
        <div class="invoice-info">
            <div class="invoice-details">
                <div class="section-title">Invoice Information</div>
                <div class="detail-row">
                    <span class="detail-label">Invoice Number:</span>
                    <span class="detail-value">{{ $invoice->invoice_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Invoice Date:</span>
                    <span class="detail-value">{{ $invoice->invoice_date->format('d-m-Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">
                        <span class="status-badge status-{{ $invoice->status }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Department:</span>
                    <span class="detail-value">{{ $invoice->department }}</span>
                </div>
            </div>
            
            <div class="customer-details">
                <div class="section-title">Customer Information</div>
                <div class="detail-row">
                    <span class="detail-label">Customer Name:</span>
                    <span class="detail-value">{{ $invoice->customer_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $invoice->customer_email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $invoice->customer_phone ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Address:</span>
                    <span class="detail-value">{{ $invoice->customer_address ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        
        <div class="project-section">
            <div class="section-header">Project Details</div>
            <table class="info-table">
                <tr>
                    <td>Project Name</td>
                    <td>{{ $invoice->project_name }}</td>
                </tr>
                <tr>
                    <td>Project Topic</td>
                    <td>{{ $invoice->project_topic }}</td>
                </tr>
                <tr>
                    <td>Project Details</td>
                    <td>{{ $invoice->project_full_details }}</td>
                </tr>
                <tr>
                    <td>Start Date</td>
                    <td>{{ $invoice->start_date->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>End Date</td>
                    <td>{{ $invoice->end_date->format('d-m-Y') }}</td>
                </tr>
            </table>
        </div>
        
        <div class="payment-section">
            <div class="section-header">Payment Details</div>
            <table class="payment-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="text-right">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Advance Payment</td>
                        <td class="text-right">{{ number_format($invoice->advance_payment, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Remaining Payment</td>
                        <td class="text-right">{{ number_format($invoice->remaining_payment, 2) }}</td>
                    </tr>
                    <tr>
                        <td>GST (18%)</td>
                        <td class="text-right">{{ number_format($invoice->gst, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td><strong>Total Payment</strong></td>
                        <td class="text-right"><strong>₹{{ number_format($invoice->total_payment, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        @if($invoice->installments && count(json_decode($invoice->installments, true)) > 0)
        <div class="payment-section">
            <div class="section-header">Installment Schedule</div>
            <table class="installment-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $installments = json_decode($invoice->installments, true);
                    @endphp
                    @foreach($installments as $index => $installment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>₹{{ number_format($installment['amount'], 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($installment['date'])->format('d-m-Y') }}</td>
                        <td>{{ $installment['notes'] ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        
        <div class="footer">
            <p><strong>Thank you for your business!</strong></p>
            <p>Please make payment within 30 days from the invoice date.</p>
            <p>NIRANJAN ENTERPRISES | Help Desk Management System</p>
            <p>Generated on: {{ date('d-m-Y H:i:s') }}</p>
        </div>
    </div>
    
    <script>
        // Auto-print when page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
