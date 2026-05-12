<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use PDF;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function index()
    {
        // Get statistics for dashboard
        $totalInvoices = Invoice::count();
        $paidInvoices = Invoice::where('status', 'paid')->count();
        $pendingInvoices = Invoice::where('status', 'pending')->count();
        $totalRevenue = Invoice::where('status', 'paid')->sum('total_payment');
        
        // For customer role (role 3), show only their invoices
        if (auth()->user()->role == 3) {
            $invoices = Invoice::where('customer_email', auth()->user()->email)
                              ->latest()
                              ->paginate(10);
        } else {
            // For other roles, show all invoices
            $invoices = Invoice::latest()->paginate(10);
        }
        
        return view('admin.invoices.working_index', compact('invoices', 'totalInvoices', 'paidInvoices', 'pendingInvoices', 'totalRevenue'));
    }

    public function create()
    {
        // Get departments from departments table (using 'department' field)
        $departments = \App\Models\Department::pluck('department', 'id');
        
        return view('admin.invoices.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'project_name' => 'required|string|max:255',
            'project_topic' => 'required|string|max:255',
            'project_full_details' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'department_id' => 'required|exists:departments,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'advance_payment' => 'required|numeric|min:0',
            'remaining_payment' => 'required|numeric|min:0',
            'gst' => 'required|numeric|min:0',
            'total_payment' => 'required|numeric|min:0',
            'installment_amounts' => 'array',
            'installment_amounts.*' => 'nullable|numeric|min:0',
            'installment_dates' => 'array',
            'installment_dates.*' => 'nullable|date',
            'installment_notes' => 'array',
            'installment_notes.*' => 'nullable|string|max:255',
        ]);

        // Debug: Log validation results
        \Log::info('Validation passed successfully');

        $data = $request->all();
        
        // Process installment data
        $installments = [];
        if ($request->has('installment_amounts')) {
            foreach ($request->installment_amounts as $index => $amount) {
                if ($amount && $amount > 0) {
                    $installments[] = [
                        'amount' => $amount,
                        'date' => $request->installment_dates[$index] ?? null,
                        'notes' => $request->installment_notes[$index] ?? ''
                    ];
                }
            }
        }
        $data['installments'] = json_encode($installments);
        
        $data['invoice_number'] = Invoice::generateInvoiceNumber();
        $data['invoice_date'] = now()->format('Y-m-d');
        
        // Get department name from department_id
        $department = \App\Models\Department::find($request->department_id);
        $data['department'] = $department ? $department->department : '';
        
        // Use manual GST and total payment values from form
        // No automatic calculations - use user input directly

        // Debug: Log the data being saved
        \Log::info('Invoice data being saved:', $data);

        Invoice::create($data);

        // Send email notifications (optional - won't break if fails)
        $emailSent = true;
        try {
            $this->sendInvoiceEmails($data);
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
            $emailSent = false;
        }

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice created successfully.' . ($emailSent ? ' and emails sent.' : ' (Email notification failed)'));
    }

    public function show(Invoice $invoice)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            abort(401, 'Unauthorized access. Please login.');
        }

        // Allow all authenticated users to access any invoice
        
        // Allow all roles to view any invoice
        // Decode installments JSON for display
        $invoice->installments = json_decode($invoice->installments, true);
        
        // Get department name
        $department = \App\Models\Department::find($invoice->department_id);
        $invoice->department_name = $department ? $department->department : 'N/A';
        
        return view('admin.invoices.show', compact('invoice'));
    }

    public function viewOnly(Invoice $invoice)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            abort(401, 'Unauthorized access. Please login.');
        }

        // Allow all authenticated users to access any invoice
        
        // Allow all roles to view any invoice
        // Decode installments JSON for display
        $invoice->installments = json_decode($invoice->installments, true);
        
        // Get department name
        $department = \App\Models\Department::find($invoice->department_id);
        $invoice->department_name = $department ? $department->department : 'N/A';
        
        return view('admin.invoices.view_only', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            abort(401, 'Unauthorized access. Please login.');
        }

        // Allow all authenticated users to access any invoice
        
        // Allow all roles to edit any invoice
        // Get departments from departments table (using 'department' field)
        $departments = \App\Models\Department::pluck('department', 'id');
        
        return view('admin.invoices.edit', compact('invoice', 'departments'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            abort(401, 'Unauthorized access. Please login.');
        }

        // Allow all authenticated users to access any invoice
        
        // Allow all roles to update any invoice
        
        $request->validate([
            'project_name' => 'required|string|max:255',
            'project_topic' => 'required|string|max:255',
            'project_full_details' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'department_id' => 'required|exists:departments,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'advance_payment' => 'required|numeric|min:0',
            'remaining_payment' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,overdue',
            'installment_amounts' => 'array',
            'installment_amounts.*' => 'nullable|numeric|min:0',
            'installment_dates' => 'array',
            'installment_dates.*' => 'nullable|date',
            'installment_notes' => 'array',
            'installment_notes.*' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        
        // Process installment data
        $installments = [];
        if ($request->has('installment_amounts')) {
            foreach ($request->installment_amounts as $index => $amount) {
                if ($amount && $amount > 0) {
                    $installments[] = [
                        'amount' => $amount,
                        'date' => $request->installment_dates[$index] ?? null,
                        'notes' => $request->installment_notes[$index] ?? ''
                    ];
                }
            }
        }
        $data['installments'] = json_encode($installments);
        
        // Get department name from department_id
        $department = \App\Models\Department::find($request->department_id);
        $data['department'] = $department ? $department->department : '';
        
        // Calculate total payment with fixed 18% GST
        $subtotal = $request->advance_payment + $request->remaining_payment;
        $gst = $subtotal * 0.18; // Fixed 18% GST
        $data['gst'] = $gst;
        $data['total_payment'] = $subtotal + $gst;

        $invoice->update($data);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Unauthorized access. Please login.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to delete invoices.');
        }

        // Allow all authenticated users to access any invoice
        
        // Allow all roles to delete any invoice
        
        try {
            $invoice->delete();

            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json(['success' => 'Invoice deleted successfully!']);
            }

            return redirect()->route('invoices.index')
                ->with('success', 'Invoice deleted successfully.');
                
        } catch (\Exception $e) {
            \Log::error('Invoice deletion failed: ' . $e->getMessage());
            
            // Return JSON error for AJAX requests
            if (request()->ajax()) {
                return response()->json(['error' => 'Failed to delete invoice: ' . $e->getMessage()], 500);
            }
            
            return redirect()->route('invoices.index')
                ->with('error', 'Failed to delete invoice. Please try again.');
        }
    }

    public function printInvoice(Invoice $invoice)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to print invoices.');
        }

        // Allow all authenticated users to access any invoice
        
        // Allow all roles to print any invoice
        
        return view('admin.invoices.print', compact('invoice'));
    }

    public function exportPDF(Invoice $invoice)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Unauthorized access. Please login.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to download invoices.');
        }

        // Allow all authenticated users to access any invoice
        
        // Allow all roles to export any invoice
        
        try {
            // Debug: Log the invoice data
            \Log::info('Generating PDF for invoice: ' . $invoice->invoice_number);
            
            // Create comprehensive HTML content for PDF
            $html = '<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; line-height: 1.6; }
        .header { text-align: center; border-bottom: 3px solid #007bff; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #007bff; margin-bottom: 10px; }
        .header h2 { color: #333; margin: 0; }
        .section { margin: 25px 0; }
        .section-title { background-color: #007bff; color: white; padding: 10px; font-weight: bold; margin-bottom: 15px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .info-item { padding: 10px; background-color: #f8f9fa; border-left: 4px solid #007bff; }
        .label { font-weight: bold; color: #007bff; }
        .value { margin-left: 5px; }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table th, .table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .table th { background-color: #007bff; color: white; }
        .table .total-row { background-color: #e3f2fd; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 2px solid #007bff; text-align: center; color: #666; }
        .installment-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .installment-table th, .installment-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .installment-table th { background-color: #6c757d; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>NIRANJAN ENTERPRISES</h1>
        <h2>TAX INVOICE</h2>
        <p>Help Desk Management System</p>
    </div>
    
    <div class="section">
        <div class="section-title">Invoice Information</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Invoice Number:</span>
                <span class="value">' . $invoice->invoice_number . '</span>
            </div>
            <div class="info-item">
                <span class="label">Invoice Date:</span>
                <span class="value">' . $invoice->invoice_date->format('d-m-Y') . '</span>
            </div>
            <div class="info-item">
                <span class="label">Status:</span>
                <span class="value">' . ucfirst($invoice->status) . '</span>
            </div>
            <div class="info-item">
                <span class="label">Department:</span>
                <span class="value">' . $invoice->department . '</span>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">Customer Information</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Customer Name:</span>
                <span class="value">' . $invoice->customer_name . '</span>
            </div>
            <div class="info-item">
                <span class="label">Email:</span>
                <span class="value">' . $invoice->customer_email . '</span>
            </div>
            <div class="info-item">
                <span class="label">Phone:</span>
                <span class="value">' . $invoice->customer_phone . '</span>
            </div>
            <div class="info-item">
                <span class="label">Address:</span>
                <span class="value">' . $invoice->customer_address . '</span>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">Project Details</div>
        <table class="table">
            <tr>
                <td width="20%"><strong>Project Name:</strong></td>
                <td>' . $invoice->project_name . '</td>
            </tr>
            <tr>
                <td><strong>Project Topic:</strong></td>
                <td>' . $invoice->project_topic . '</td>
            </tr>
            <tr>
                <td><strong>Project Details:</strong></td>
                <td>' . $invoice->project_full_details . '</td>
            </tr>
            <tr>
                <td><strong>Start Date:</strong></td>
                <td>' . $invoice->start_date->format('d-m-Y') . '</td>
            </tr>
            <tr>
                <td><strong>End Date:</strong></td>
                <td>' . $invoice->end_date->format('d-m-Y') . '</td>
            </tr>
        </table>
    </div>
    
    <div class="section">
        <div class="section-title">Payment Details</div>
        <table class="table">
            <tr>
                <th>Description</th>
                <th class="text-right">Amount (₹)</th>
            </tr>
            <tr>
                <td>Advance Payment</td>
                <td class="text-right">' . number_format($invoice->advance_payment, 2) . '</td>
            </tr>
            <tr>
                <td>Remaining Payment</td>
                <td class="text-right">' . number_format($invoice->remaining_payment, 2) . '</td>
            </tr>
            <tr>
                <td>GST (18%)</td>
                <td class="text-right">' . number_format($invoice->gst, 2) . '</td>
            </tr>
            <tr class="total-row">
                <td><strong>Total Payment</strong></td>
                <td class="text-right"><strong>₹' . number_format($invoice->total_payment, 2) . '</strong></td>
            </tr>
        </table>
    </div>';
            
            // Add installment details if available
            $installments = json_decode($invoice->installments, true);
            if ($installments && count($installments) > 0) {
                $html .= '
    <div class="section">
        <div class="section-title">Installment Schedule</div>
        <table class="installment-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>';
                
                foreach ($installments as $index => $installment) {
                    $dueDate = isset($installment['date']) ? \Carbon\Carbon::parse($installment['date'])->format('d-m-Y') : 'N/A';
                    $notes = isset($installment['notes']) ? $installment['notes'] : '-';
                    $html .= '
                <tr>
                    <td>' . ($index + 1) . '</td>
                    <td>₹' . number_format($installment['amount'], 2) . '</td>
                    <td>' . $dueDate . '</td>
                    <td>' . $notes . '</td>
                </tr>';
                }
                
                $html .= '
            </tbody>
        </table>
    </div>';
            }
            
            $html .= '
    
    <div class="footer">
        <p><strong>Thank you for your business!</strong></p>
        <p>Please make payment within 30 days from invoice date.</p>
        <p>NIRANJAN ENTERPRISES | Help Desk Management System</p>
        <p>Generated on: ' . date('d-m-Y H:i:s') . '</p>
    </div>
</body>
</html>';
            
            // Use DomPDF to generate PDF
            $pdf = new \Dompdf\Dompdf();
            $pdf->loadHtml($html);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            
            $filename = 'Invoice_' . $invoice->invoice_number . '.pdf';
            
            // Force download with proper headers
            return response($pdf->output())
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Content-Length', strlen($pdf->output()));
                
        } catch (\Exception $e) {
            \Log::error('PDF export failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            if (request()->ajax()) {
                return response()->json(['error' => 'Failed to generate PDF: ' . $e->getMessage()], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to generate PDF. Error: ' . $e->getMessage());
        }
    }

    /**
     * Simple PDF Download - Always Works
     */
    public function simplePdfDownload(Invoice $invoice)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to download invoices.');
        }

        // Allow all authenticated users to access any invoice
        
        // Allow all roles to download any invoice
        
        try {
            // Simple HTML for PDF - minimal styling for reliability
            $html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice ' . $invoice->invoice_number . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.4; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #333; }
        .info { margin-bottom: 20px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .label { font-weight: bold; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .total { font-weight: bold; background-color: #f9f9f9; }
        .footer { margin-top: 30px; text-align: center; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <h2>' . $invoice->invoice_number . '</h2>
    </div>
    
    <div class="info">
        <div class="info-row">
            <span class="label">Date:</span>
            <span>' . $invoice->invoice_date->format('d M Y') . '</span>
        </div>
        <div class="info-row">
            <span class="label">Customer:</span>
            <span>' . $invoice->customer_name . '</span>
        </div>
        <div class="info-row">
            <span class="label">Email:</span>
            <span>' . $invoice->customer_email . '</span>
        </div>
    </div>
    
    <div class="info">
        <div class="info-row">
            <span class="label">Project:</span>
            <span>' . ($invoice->project_name ?? 'N/A') . '</span>
        </div>
        <div class="info-row">
            <span class="label">Status:</span>
            <span>' . ucfirst($invoice->status) . '</span>
        </div>
    </div>
    
    <table class="table">
        <tr>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>Advance Payment</td>
            <td>₹' . number_format($invoice->advance_payment, 2) . '</td>
        </tr>
        <tr>
            <td>Remaining Payment</td>
            <td>₹' . number_format($invoice->remaining_payment, 2) . '</td>
        </tr>
        <tr>
            <td>GST (18%)</td>
            <td>₹' . number_format($invoice->gst, 2) . '</td>
        </tr>
        <tr class="total">
            <td><strong>Total</strong></td>
            <td><strong>₹' . number_format($invoice->total_payment, 2) . '</strong></td>
        </tr>
    </table>
    
    <div class="footer">
        <p>Thank you for your business!</p>
        <p>Niranjan Enterprises | Help Desk Management System</p>
    </div>
</body>
</html>';
            
            // Generate PDF using DomPDF
            $pdf = new \Dompdf\Dompdf();
            $pdf->loadHtml($html);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            
            $filename = 'Invoice_' . $invoice->invoice_number . '.pdf';
            
            // Return PDF download
            return response($pdf->output())
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Content-Length', strlen($pdf->output()));
                
        } catch (\Exception $e) {
            \Log::error('Simple PDF download failed: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Failed to download PDF. Please try again.');
        }
    }

    /**
     * Simple Print - Always Works
     */
    public function simplePrint(Invoice $invoice)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to print invoices.');
        }

        // Allow all authenticated users to access any invoice
        
        // Allow all roles to print any invoice
        
        // Simple HTML for print - minimal styling for reliability
        $html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice ' . $invoice->invoice_number . ' - Print</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.4; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #333; }
        .info { margin-bottom: 20px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .label { font-weight: bold; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .total { font-weight: bold; background-color: #f9f9f9; }
        .footer { margin-top: 30px; text-align: center; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <h2>' . $invoice->invoice_number . '</h2>
    </div>
    
    <div class="info">
        <div class="info-row">
            <span class="label">Date:</span>
            <span>' . $invoice->invoice_date->format('d M Y') . '</span>
        </div>
        <div class="info-row">
            <span class="label">Customer:</span>
            <span>' . $invoice->customer_name . '</span>
        </div>
        <div class="info-row">
            <span class="label">Email:</span>
            <span>' . $invoice->customer_email . '</span>
        </div>
    </div>
    
    <div class="info">
        <div class="info-row">
            <span class="label">Project:</span>
            <span>' . ($invoice->project_name ?? 'N/A') . '</span>
        </div>
        <div class="info-row">
            <span class="label">Status:</span>
            <span>' . ucfirst($invoice->status) . '</span>
        </div>
    </div>
    
    <table class="table">
        <tr>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>Advance Payment</td>
            <td>₹' . number_format($invoice->advance_payment, 2) . '</td>
        </tr>
        <tr>
            <td>Remaining Payment</td>
            <td>₹' . number_format($invoice->remaining_payment, 2) . '</td>
        </tr>
        <tr>
            <td>GST (18%)</td>
            <td>₹' . number_format($invoice->gst, 2) . '</td>
        </tr>
        <tr class="total">
            <td><strong>Total</strong></td>
            <td><strong>₹' . number_format($invoice->total_payment, 2) . '</strong></td>
        </tr>
    </table>
    
    <div class="footer">
        <p>Thank you for your business!</p>
        <p>Niranjan Enterprises | Help Desk Management System</p>
    </div>
</body>
</html>';
        
        return view('admin.invoices.print', compact('invoice', 'html'));
    }

    public function exportWord(Invoice $invoice)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            abort(401, 'Unauthorized access. Please login.');
        }

        // Allow all authenticated users to access any invoice
        
        // Allow all roles to export any invoice
        
        $phpWord = new PhpWord();
        
        // Add a section to the document
        $section = $phpWord->addSection();
        
        // Add title
        $section->addText('INVOICE', ['bold' => true, 'size' => 16], ['align' => 'center']);
        $section->addText('Invoice Number: ' . $invoice->invoice_number);
        $section->addText('Invoice Date: ' . $invoice->invoice_date->format('d-m-Y'));
        $section->addText('Status: ' . ucfirst($invoice->status));
        $section->addTextBreak(2);
        
        // Project Details
        $section->addText('PROJECT DETAILS', ['bold' => true, 'size' => 14]);
        $section->addText('Project Name: ' . $invoice->project_name);
        $section->addText('Project Topic: ' . $invoice->project_topic);
        $section->addText('Project Details: ' . $invoice->project_full_details);
        $section->addText('Start Date: ' . $invoice->start_date->format('d-m-Y'));
        $section->addText('End Date: ' . $invoice->end_date->format('d-m-Y'));
        $section->addText('Department: ' . $invoice->department);
        $section->addTextBreak(2);
        
        // Customer Details
        $section->addText('CUSTOMER DETAILS', ['bold' => true, 'size' => 14]);
        $section->addText('Customer Name: ' . $invoice->customer_name);
        $section->addText('Email: ' . $invoice->customer_email);
        $section->addText('Phone: ' . $invoice->customer_phone);
        $section->addText('Address: ' . $invoice->customer_address);
        $section->addTextBreak(2);
        
        // Payment Details
        $section->addText('PAYMENT DETAILS', ['bold' => true, 'size' => 14]);
        $section->addText('Advance Payment: ₹' . number_format($invoice->advance_payment, 2));
        $section->addText('Remaining Payment: ₹' . number_format($invoice->remaining_payment, 2));
        $section->addText('GST: ₹' . number_format($invoice->gst, 2));
        $section->addText('Total Payment: ₹' . number_format($invoice->total_payment, 2));
        
        // Save the file
        $filename = 'Invoice_' . $invoice->invoice_number . '.docx';
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $objWriter->save('php://output');
        exit;
    }

    /**
     * Send invoice emails to customer and admin
     */
    private function sendInvoiceEmails($invoiceData)
    {
        try {
            // Debug: Log the invoice data
            \Log::info('Attempting to send emails for invoice: ' . $invoiceData['invoice_number']);
            \Log::info('Customer email: ' . $invoiceData['customer_email']);
            
            // Create a temporary invoice object for PDF generation
            $tempInvoice = new Invoice();
            $tempInvoice->invoice_number = $invoiceData['invoice_number'];
            $tempInvoice->invoice_date = \Carbon\Carbon::parse($invoiceData['invoice_date']);
            $tempInvoice->start_date = \Carbon\Carbon::parse($invoiceData['start_date']);
            $tempInvoice->end_date = \Carbon\Carbon::parse($invoiceData['end_date']);
            $tempInvoice->status = $invoiceData['status'] ?? 'pending';
            $tempInvoice->customer_name = $invoiceData['customer_name'];
            $tempInvoice->customer_email = $invoiceData['customer_email'];
            $tempInvoice->customer_phone = $invoiceData['customer_phone'];
            $tempInvoice->customer_address = $invoiceData['customer_address'];
            $tempInvoice->project_name = $invoiceData['project_name'];
            $tempInvoice->project_topic = $invoiceData['project_topic'];
            $tempInvoice->project_full_details = $invoiceData['project_full_details'];
            $tempInvoice->department = $invoiceData['department'];
            $tempInvoice->advance_payment = $invoiceData['advance_payment'];
            $tempInvoice->remaining_payment = $invoiceData['remaining_payment'];
            $tempInvoice->gst = $invoiceData['gst'];
            $tempInvoice->total_payment = $invoiceData['total_payment'];
            
            // Send email to customer with PDF attachment
            $pdf = PDF::loadView('admin.invoices.pdf', compact('tempInvoice'));
            $pdfContent = $pdf->output();
            
            \Log::info('PDF generated successfully');
            
            Mail::html($this->getEmailContent($invoiceData, 'customer'), function($message) use ($invoiceData, $pdfContent) {
                $message->to($invoiceData['customer_email'])
                        ->subject('Invoice ' . $invoiceData['invoice_number'] . ' - Niranjan Enterprises')
                        ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), config('mail.from.name', 'Niranjan Enterprises'))
                        ->attachData($pdfContent, 'Invoice_' . $invoiceData['invoice_number'] . '.pdf', [
                            'mime' => 'application/pdf',
                            'as' => 'Invoice_' . $invoiceData['invoice_number'] . '.pdf'
                        ]);
            });

            \Log::info('Customer email sent successfully');

            // Send notification email to admin
            Mail::html($this->getEmailContent($invoiceData, 'admin'), function($message) use ($invoiceData) {
                $message->to('shubhamdixitcorpo@gmail.com')
                        ->subject('📄 New Invoice Created: ' . $invoiceData['invoice_number'])
                        ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), config('mail.from.name', 'Niranjan Enterprises'));
            });

            \Log::info('Admin notification email sent successfully');

        } catch (\Exception $e) {
            // Log detailed error for debugging
            \Log::error('Email sending failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Re-throw the exception so we can handle it in the calling method
            throw $e;
        }
    }

    /**
     * Generate email content
     */
    private function getEmailContent($invoiceData, $recipientType)
    {
        $content = "";
        
        if ($recipientType === 'customer') {
            $content = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice from Niranjan Enterprises</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 15px;
        }
        .title {
            color: #007bff;
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }
        .subtitle {
            color: #666;
            font-size: 16px;
            margin: 5px 0 0 0;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        .info-item {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .info-label {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 3px;
        }
        .info-value {
            color: #333;
        }
        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .payment-table th,
        .payment-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .payment-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .payment-table .total-row {
            background-color: #e3f2fd;
            font-weight: bold;
            font-size: 16px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #007bff;
            text-align: center;
            color: #666;
        }
        .company-info {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        .highlight {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp" alt="Niranjan Enterprises" class="logo">
            <h1 class="title">Invoice Generated</h1>
            <p class="subtitle">Thank you for choosing Niranjan Enterprises!</p>
        </div>

        <div class="section">
            <div class="section-title">📋 Invoice Details</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Invoice Number</div>
                    <div class="info-value">' . $invoiceData['invoice_number'] . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Invoice Date</div>
                    <div class="info-value">' . date('d-m-Y', strtotime($invoiceData['invoice_date'])) . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value"><span style="background-color: #ffc107; color: #000; padding: 3px 8px; border-radius: 3px; font-size: 12px;">' . ucfirst($invoiceData['status'] ?? 'Pending') . '</span></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Department</div>
                    <div class="info-value">' . $invoiceData['department'] . '</div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">👤 Customer Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Name</div>
                    <div class="info-value">' . $invoiceData['customer_name'] . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">' . $invoiceData['customer_email'] . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Phone</div>
                    <div class="info-value">' . $invoiceData['customer_phone'] . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Address</div>
                    <div class="info-value">' . $invoiceData['customer_address'] . '</div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">🚀 Project Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Project Name</div>
                    <div class="info-value">' . $invoiceData['project_name'] . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Project Topic</div>
                    <div class="info-value">' . $invoiceData['project_topic'] . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Start Date</div>
                    <div class="info-value">' . date('d-m-Y', strtotime($invoiceData['start_date'])) . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">End Date</div>
                    <div class="info-value">' . date('d-m-Y', strtotime($invoiceData['end_date'])) . '</div>
                </div>
            </div>
            <div class="info-item" style="margin-top: 15px;">
                <div class="info-label">Project Details</div>
                <div class="info-value">' . $invoiceData['project_full_details'] . '</div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">💰 Payment Information</div>
            <table class="payment-table">
                <tr>
                    <th>Description</th>
                    <th style="text-align: right;">Amount (₹)</th>
                </tr>
                <tr>
                    <td>Advance Payment</td>
                    <td style="text-align: right;">' . number_format($invoiceData['advance_payment'], 2) . '</td>
                </tr>
                <tr>
                    <td>Remaining Payment</td>
                    <td style="text-align: right;">' . number_format($invoiceData['remaining_payment'], 2) . '</td>
                </tr>
                <tr>
                    <td>GST</td>
                    <td style="text-align: right;">' . number_format($invoiceData['gst'], 2) . '</td>
                </tr>
                <tr class="total-row">
                    <td>Total Payment</td>
                    <td style="text-align: right;">' . number_format($invoiceData['total_payment'], 2) . '</td>
                </tr>
            </table>
        </div>

        <div class="highlight">
            <strong>📌 Important Information:</strong><br>
            • Please make the payment within 30 days from the invoice date<br>
            • Late payments may attract additional charges as per our terms<br>
            • Your invoice PDF is attached to this email for your records<br>
            • For any queries, please contact our support team
        </div>

        <div class="footer">
            <p><strong>Thank you for your business!</strong></p>
            <p>We appreciate your trust in Niranjan Enterprises</p>
            
            <div class="company-info">
                <strong>🏢 NIRANJAN ENTERPRISES</strong><br>
                Help Desk Management System<br>
                📞 Phone: [Your Phone Number]<br>
                📧 Email: [Your Email]<br>
                🌐 Website: https://niranjanenterprises.com<br>
                📍 Address: [Your Address]
            </div>
        </div>
    </div>
</body>
</html>';
        } else {
            $content = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Invoice Notification</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #28a745;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 15px;
        }
        .title {
            color: #28a745;
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }
        .subtitle {
            color: #666;
            font-size: 16px;
            margin: 5px 0 0 0;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        .info-item {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
        .info-label {
            font-weight: bold;
            color: #28a745;
            margin-bottom: 3px;
        }
        .info-value {
            color: #333;
        }
        .alert {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #28a745;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp" alt="Niranjan Enterprises" class="logo">
            <h1 class="title">📄 New Invoice Created</h1>
            <p class="subtitle">Automated Notification System</p>
        </div>

        <div class="alert">
            <strong>🔔 New Invoice Alert:</strong> A new invoice has been generated and sent to the customer.
        </div>

        <div class="section">
            <div class="section-title">📋 Invoice Details</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Invoice Number</div>
                    <div class="info-value">' . $invoiceData['invoice_number'] . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Invoice Date</div>
                    <div class="info-value">' . date('d-m-Y', strtotime($invoiceData['invoice_date'])) . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value"><span style="background-color: #ffc107; color: #000; padding: 3px 8px; border-radius: 3px; font-size: 12px;">' . ucfirst($invoiceData['status'] ?? 'Pending') . '</span></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Total Amount</div>
                    <div class="info-value"><strong>₹' . number_format($invoiceData['total_payment'], 2) . '</strong></div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">👤 Customer Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Name</div>
                    <div class="info-value">' . $invoiceData['customer_name'] . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">' . $invoiceData['customer_email'] . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Phone</div>
                    <div class="info-value">' . $invoiceData['customer_phone'] . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Department</div>
                    <div class="info-value">' . $invoiceData['department'] . '</div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">🚀 Project Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Project Name</div>
                    <div class="info-value">' . $invoiceData['project_name'] . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Project Topic</div>
                    <div class="info-value">' . $invoiceData['project_topic'] . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Start Date</div>
                    <div class="info-value">' . date('d-m-Y', strtotime($invoiceData['start_date'])) . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">End Date</div>
                    <div class="info-value">' . date('d-m-Y', strtotime($invoiceData['end_date'])) . '</div>
                </div>
            </div>
        </div>

        <div class="alert">
            <strong>⚠️ Action Required:</strong><br>
            • Review the invoice details for accuracy<br>
            • Follow up with the customer for payment confirmation<br>
            • Update the invoice status when payment is received<br>
            • Monitor payment timeline (30 days due)
        </div>

        <div class="footer">
            <p>This is an automated notification from the Invoice Management System</p>
            <p>Generated on: ' . date('d-m-Y H:i:s') . '</p>
            <p>🏢 NIRANJAN ENTERPRISES | Help Desk Management System</p>
        </div>
    </div>
</body>
</html>';
        }
        
        return $content;
    }

    /**
     * Send payment reminder email
     */
    public function sendPaymentReminder(Invoice $invoice)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Unauthorized access. Please login.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to send reminders.');
        }

        // Admin and CEO can send reminders for all invoices
        if (auth()->user()->role == 1 || auth()->user()->role == 5) {
            // Full access
        } 
        // Allow all authenticated users to access any invoice
        
        try {
            $reminderContent = $this->getPaymentReminderContent($invoice);
            
            Mail::html($reminderContent, function($message) use ($invoice) {
                $message->to($invoice->customer_email)
                        ->subject('🔔 Payment Reminder: Invoice ' . $invoice->invoice_number)
                        ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), config('mail.from.name', 'Niranjan Enterprises'));
            });

            // Send notification to admin
            Mail::html($reminderContent, function($message) use ($invoice) {
                $message->to('shubhamdixitcorpo@gmail.com')
                        ->subject('🔔 Payment Reminder Sent: ' . $invoice->invoice_number)
                        ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), config('mail.from.name', 'Niranjan Enterprises'));
            });

            // Return JSON response for AJAX requests
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => 'Payment reminder sent successfully!']);
            }

            return back()->with('success', 'Payment reminder sent successfully.');

        } catch (\Exception $e) {
            \Log::error('Payment reminder email failed: ' . $e->getMessage());
            \Log::error('Error details: ' . $e->getTraceAsString());
            
            // Return JSON error for AJAX requests
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Failed to send payment reminder: ' . $e->getMessage()], 500);
            }
            
            return back()->with('error', 'Failed to send payment reminder. Please try again.');
        }
    }

    /**
     * Generate payment reminder content
     */
    private function getPaymentReminderContent($invoice)
    {
        $content = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Reminder - Niranjan Enterprises</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #ffc107;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 15px;
        }
        .title {
            color: #ffc107;
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }
        .subtitle {
            color: #666;
            font-size: 16px;
            margin: 5px 0 0 0;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background-color: #ffc107;
            color: #000;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        .info-item {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #ffc107;
        }
        .info-label {
            font-weight: bold;
            color: #ffc107;
            margin-bottom: 3px;
        }
        .info-value {
            color: #333;
        }
        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .payment-table th,
        .payment-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .payment-table th {
            background-color: #ffc107;
            color: #000;
            font-weight: bold;
        }
        .payment-table .total-row {
            background-color: #fff3cd;
            font-weight: bold;
            font-size: 16px;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .payment-methods {
            background-color: #e3f2fd;
            border: 1px solid #bbdefb;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #ffc107;
            text-align: center;
            color: #666;
        }
        .company-info {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        .alert {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp" alt="Niranjan Enterprises" class="logo">
            <h1 class="title">🔔 Payment Reminder</h1>
            <p class="subtitle">Friendly Payment Reminder</p>
        </div>

        <div class="alert">
            <strong>Dear ' . $invoice->customer_name . ',</strong><br>
            This is a friendly reminder regarding your outstanding invoice. Please find the details below.
        </div>

        <div class="section">
            <div class="section-title">📋 Invoice Details</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Invoice Number</div>
                    <div class="info-value">' . $invoice->invoice_number . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Invoice Date</div>
                    <div class="info-value">' . $invoice->invoice_date->format('d-m-Y') . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Due Date</div>
                    <div class="info-value">' . $invoice->invoice_date->addDays(30)->format('d-m-Y') . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value"><span style="background-color: #ffc107; color: #000; padding: 3px 8px; border-radius: 3px; font-size: 12px;">' . ucfirst($invoice->status) . '</span></div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">💰 Payment Information</div>
            <table class="payment-table">
                <tr>
                    <th>Description</th>
                    <th style="text-align: right;">Amount (₹)</th>
                </tr>
                <tr>
                    <td>Total Amount Due</td>
                    <td style="text-align: right;">' . number_format($invoice->total_payment, 2) . '</td>
                </tr>
                <tr>
                    <td>Remaining Payment</td>
                    <td style="text-align: right;">' . number_format($invoice->remaining_payment, 2) . '</td>
                </tr>
                <tr class="total-row">
                    <td><strong>Amount Due Now</strong></td>
                    <td style="text-align: right;"><strong>₹' . number_format($invoice->remaining_payment, 2) . '</strong></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">📝 Payment Methods</div>
            <div class="payment-methods">
                <strong>You can make payment through any of the following methods:</strong><br><br>
                🏦 <strong>Bank Transfer:</strong><br>
                Account Name: Niranjan Enterprises<br>
                Account Number: [Your Account Number]<br>
                Bank Name: [Your Bank Name]<br>
                IFSC Code: [Your IFSC Code]<br><br>
                
                📱 <strong>UPI Payment:</strong><br>
                UPI ID: [Your UPI ID]<br>
                PhonePay: [Your PhonePay Number]<br>
                Google Pay: [Your Google Pay Number]<br><br>
                
                📋 <strong>Cheque Payment:</strong><br>
                Payable to: Niranjan Enterprises<br>
                Mention Invoice Number: ' . $invoice->invoice_number . '<br><br>
                
                💵 <strong>Cash Payment:</strong><br>
                Visit our office during business hours<br>
                Address: [Your Office Address]
            </div>
        </div>

        <div class="warning">
            <strong>⚠️ Important Notes:</strong><br>
            • Please complete the payment as soon as possible to avoid late fees<br>
            • Late payments may attract additional charges as per our terms<br>
            • If you have already made the payment, please disregard this reminder<br>
            • For any payment-related queries, please contact our accounts department<br>
            • Please mention your invoice number (' . $invoice->invoice_number . ') in all payment communications
        </div>

        <div class="footer">
            <p><strong>Thank you for your prompt attention to this matter!</strong></p>
            <p>We appreciate your business and look forward to serving you again.</p>
            
            <div class="company-info">
                <strong>🏢 NIRANJAN ENTERPRISES</strong><br>
                Help Desk Management System<br>
                📞 Phone: [Your Phone Number]<br>
                📧 Email: [Your Email]<br>
                🌐 Website: https://niranjanenterprises.com<br>
                📍 Address: [Your Address]
            </div>
        </div>
    </div>
</body>
</html>';
        
        return $content;
    }
}
