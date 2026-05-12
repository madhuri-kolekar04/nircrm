<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerCompanyController extends Controller
{
    /**
     * Display customer home page (white page)
     */
    public function home()
    {
        // Only allow customer users
        if (Auth::user()->role != 3) {
            abort(403, 'Unauthorized action.');
        }

        return view('customer.home');
    }

    /**
     * Display customer dashboard
     */
    public function dashboard()
    {
        // Only allow customer users
        if (Auth::user()->role != 3) {
            abort(403, 'Unauthorized action.');
        }

        $customerEmail = Auth::user()->email;
        
        // Get all quotations for this customer email
        $quotations = Quotation::where('client_email', $customerEmail)
            ->where('customer_panel', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // Group quotations by company name
        $companies = [];
        foreach ($quotations as $quotation) {
            $companyName = $quotation->client_business_name;
            
            if (!isset($companies[$companyName])) {
                $companies[$companyName] = [
                    'name' => $companyName,
                    'quotations' => [],
                    'total_amount' => 0,
                    'completed_payments' => 0,
                    'pending_payments' => 0,
                    'approved_quotations' => 0,
                ];
            }
            
            $companies[$companyName]['quotations'][] = $quotation;
            $companies[$companyName]['total_amount'] += $quotation->final_amount;
            
            if ($quotation->payment_status === 'completed') {
                $companies[$companyName]['completed_payments']++;
            } else {
                $companies[$companyName]['pending_payments']++;
            }
            
            if ($quotation->approval_status === 'approved') {
                $companies[$companyName]['approved_quotations']++;
            }
        }

        // Calculate overall statistics
        $totalStats = [
            'total_companies' => count($companies),
            'total_quotations' => $quotations->count(),
            'total_amount' => $quotations->sum('final_amount'),
            'completed_payments' => $quotations->where('payment_status', 'completed')->count(),
            'pending_payments' => $quotations->where('payment_status', '!=', 'completed')->count(),
            'approved_quotations' => $quotations->where('approval_status', 'approved')->count(),
        ];

        // Get recent activities
        $recentQuotations = $quotations->take(5);

        return view('customer.dashboard', compact('companies', 'totalStats', 'recentQuotations'));
    }

    /**
     * Display attractive customer dashboard
     */
    public function myCustomerDashboard()
    {
        // Only allow customer users
        if (Auth::user()->role != 3) {
            abort(403, 'Unauthorized action.');
        }

        $customerEmail = Auth::user()->email;
        
        // Get all quotations for this customer email
        $quotations = Quotation::where('client_email', $customerEmail)
            ->where('customer_panel', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // Group quotations by company name
        $companies = [];
        foreach ($quotations as $quotation) {
            $companyName = $quotation->client_business_name;
            
            if (!isset($companies[$companyName])) {
                $companies[$companyName] = [
                    'name' => $companyName,
                    'quotations' => [],
                    'total_amount' => 0,
                    'completed_payments' => 0,
                    'pending_payments' => 0,
                    'approved_quotations' => 0,
                ];
            }
            
            $companies[$companyName]['quotations'][] = $quotation;
            $companies[$companyName]['total_amount'] += $quotation->final_amount;
            
            if ($quotation->payment_status === 'completed') {
                $companies[$companyName]['completed_payments']++;
            } else {
                $companies[$companyName]['pending_payments']++;
            }
            
            if ($quotation->approval_status === 'approved') {
                $companies[$companyName]['approved_quotations']++;
            }
        }

        // Calculate overall statistics
        $totalStats = [
            'total_companies' => count($companies),
            'total_quotations' => $quotations->count(),
            'total_amount' => $quotations->sum('final_amount'),
            'completed_payments' => $quotations->where('payment_status', 'completed')->count(),
            'pending_payments' => $quotations->where('payment_status', '!=', 'completed')->count(),
            'approved_quotations' => $quotations->where('approval_status', 'approved')->count(),
        ];

        // Get recent activities
        $recentQuotations = $quotations->take(5);

        return view('customer.mycusdashboard', compact('companies', 'totalStats', 'recentQuotations'));
    }

    /**
     * Display customer's companies list
     */
    public function index()
    {
        // Only allow customer users
        if (Auth::user()->role != 3) {
            abort(403, 'Unauthorized action.');
        }

        $customerEmail = Auth::user()->email;
        
        // Get all quotations for this customer email
        $quotations = Quotation::where('client_email', $customerEmail)
            ->where('customer_panel', true)
            ->get()
            ->unique('client_business_name');

        // Group quotations by company name
        $companies = [];
        foreach ($quotations as $quotation) {
            $companyName = $quotation->client_business_name;
            
            if (!isset($companies[$companyName])) {
                $companies[$companyName] = [
                    'name' => $companyName,
                    'quotations' => [],
                    'total_amount' => 0,
                    'completed_payments' => 0,
                    'pending_payments' => 0,
                ];
            }
            
            $companies[$companyName]['quotations'][] = $quotation;
            $companies[$companyName]['total_amount'] += $quotation->final_amount;
            
            if ($quotation->payment_status === 'completed') {
                $companies[$companyName]['completed_payments']++;
            } else {
                $companies[$companyName]['pending_payments']++;
            }
        }

        return view('customer.companies.index', compact('companies'));
    }

    /**
     * Show company details
     */
    public function show($companyName)
    {
        // Only allow customer users
        if (Auth::user()->role != 3) {
            abort(403, 'Unauthorized action.');
        }

        $customerEmail = Auth::user()->email;
        
        // Get all quotations for this company and customer
        $quotations = Quotation::where('client_email', $customerEmail)
            ->where('client_business_name', $companyName)
            ->where('customer_panel', true)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($quotations->isEmpty()) {
            abort(404, 'Company not found or access denied.');
        }

        // Calculate company statistics
        $stats = [
            'total_quotations' => $quotations->count(),
            'total_amount' => $quotations->sum('final_amount'),
            'completed_payments' => $quotations->where('payment_status', 'completed')->count(),
            'pending_payments' => $quotations->where('payment_status', '!=', 'completed')->count(),
            'approved_quotations' => $quotations->where('approval_status', 'approved')->count(),
        ];

        return view('customer.companies.show', compact('companyName', 'quotations', 'stats'));
    }

    /**
     * Show company invoices
     */
    public function invoices($companyName)
    {
        // Only allow customer users
        if (Auth::user()->role != 3) {
            abort(403, 'Unauthorized action.');
        }

        $customerEmail = Auth::user()->email;
        
        // Get all quotations for this company and customer
        $quotations = Quotation::where('client_email', $customerEmail)
            ->where('client_business_name', $companyName)
            ->where('customer_panel', true)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($quotations->isEmpty()) {
            abort(404, 'Company not found or access denied.');
        }

        return view('customer.companies.invoices', compact('companyName', 'quotations'));
    }

    /**
     * Show company projects/updates
     */
    public function projects($companyName)
    {
        // Only allow customer users
        if (Auth::user()->role != 3) {
            abort(403, 'Unauthorized action.');
        }

        $customerEmail = Auth::user()->email;
        
        // Get all quotations for this company and customer
        $quotations = Quotation::where('client_email', $customerEmail)
            ->where('client_business_name', $companyName)
            ->where('customer_panel', true)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($quotations->isEmpty()) {
            abort(404, 'Company not found or access denied.');
        }

        return view('customer.companies.projects', compact('companyName', 'quotations'));
    }

    /**
     * Download quotation PDF for customer
     */
    public function downloadQuotationPDF($quotationId)
    {
        // Debug: Check user role
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated.');
        }
        
        // Debug: Check if user is customer
        if ($user->role != 3) {
            abort(403, 'User role is not customer. Role: ' . $user->role);
        }

        $customerEmail = $user->email;
        
        // Debug: Check if quotation exists
        $quotation = Quotation::where('id', $quotationId)
            ->where('client_email', $customerEmail)
            ->where('customer_panel', true)
            ->first();

        if (!$quotation) {
            // Debug: Show what we found
            $allQuotations = Quotation::where('id', $quotationId)->first();
            if (!$allQuotations) {
                abort(404, 'Quotation not found with ID: ' . $quotationId);
            }
            
            abort(403, 'Access denied. Quotation exists but customer access not enabled. Customer email: ' . $customerEmail . ', Quotation client email: ' . $allQuotations->client_email . ', Customer panel: ' . ($allQuotations->customer_panel ? 'true' : 'false'));
        }

        // Generate PDF directly for customer
        try {
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.quotations.pdf', compact('quotation'));
            
            return $pdf->download('Quotation_' . $quotation->quotation_number . '.pdf');
        } catch (\Exception $e) {
            // If PDF generation fails, show error
            return back()->with('error', 'Unable to generate PDF. Please contact support.');
        }
    }
}
