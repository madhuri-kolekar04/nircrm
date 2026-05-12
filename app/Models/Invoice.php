<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_name',
        'project_topic',
        'project_full_details',
        'start_date',
        'end_date',
        'department',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'advance_payment',
        'remaining_payment',
        'gst',
        'total_payment',
        'invoice_number',
        'invoice_date',
        'status',
        'mail_approval_status',
        'installments',
        'deleted_at',
        'bank_account_number',
        'ifsc_code',
        'mobile_bank_number',
        'company_pan',
        'gst_number',
        'place_of_supply',
        'hsn_code',
        'payment_terms',
        'privacy_policy',
        'notes',
        'approval_token',
        'approved_at',
        'lead_id',
        'mail_id',
        'mail_sent_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'invoice_date' => 'date',
        'approved_at' => 'datetime',
        'advance_payment' => 'decimal:2',
        'remaining_payment' => 'decimal:2',
        'gst' => 'decimal:2',
        'total_payment' => 'decimal:2',
        'installments' => 'array',
    ];

    /**
     * Generate unique invoice number
     */
    public static function generateInvoiceNumber()
    {
        $prefix = 'INV-';
        $year = date('Y');
        $month = date('m');
        $pattern = $prefix . $year . $month . '%';
        
        // Get the last invoice for this month
        $lastInvoice = self::where('invoice_number', 'like', $pattern)
                            ->orderBy('invoice_number', 'desc')
                            ->first();
        
        if ($lastInvoice) {
            // Extract the last 4 digits and increment
            $lastNumber = intval(substr($lastInvoice->invoice_number, -4));
            $newNumber = $lastNumber + 1;
        } else {
            // No invoices for this month, start with 1
            $newNumber = 1;
        }
        
        $invoiceNumber = $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        
        // Double-check for uniqueness (prevent race conditions)
        $attempts = 0;
        while (self::where('invoice_number', $invoiceNumber)->exists() && $attempts < 10) {
            $newNumber++;
            $invoiceNumber = $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            $attempts++;
        }
        
        return $invoiceNumber;
    }

    /**
     * Calculate total payment with GST
     */
    public function calculateTotalPayment()
    {
        $subtotal = $this->advance_payment + $this->remaining_payment;
        $total = $subtotal + $this->gst;
        return $total;
    }

    /**
     * Format currency
     */
    public function formatCurrency($amount)
    {
        return '₹' . number_format($amount, 2);
    }

    /**
     * Get formatted total payment
     */
    public function getFormattedTotalPaymentAttribute()
    {
        return $this->formatCurrency($this->total_payment);
    }

    /**
     * Get formatted advance payment
     */
    public function getFormattedAdvancePaymentAttribute()
    {
        return $this->formatCurrency($this->advance_payment);
    }

    /**
     * Get formatted remaining payment
     */
    public function getFormattedRemainingPaymentAttribute()
    {
        return $this->formatCurrency($this->remaining_payment);
    }

    /**
     * Get formatted GST
     */
    public function getFormattedGstAttribute()
    {
        return $this->formatCurrency($this->gst);
    }

    /**
     * Relationship with Lead
     */
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    /**
     * Find invoice by approval token
     */
    public static function findByApprovalToken($token)
    {
        return self::where('approval_token', $token)->first();
    }
}
