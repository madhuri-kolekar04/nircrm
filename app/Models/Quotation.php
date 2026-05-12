<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_number',
        'client_business_name',
        'client_email',
        'client_phone',
        'client_contact_name',
        'executive_summary',
        'total_cost',
        'gst_amount',
        'final_amount',
        'status',
        'approval_status',
        'approved_at',
        'approval_notes',
        'payment_status',
        'payment_updated_at',
        'invoice_status',
        'customer_panel',
        'valid_until',
        'terms_conditions',
        'created_by',
        'lead_id',
    ];

    protected $casts = [
        'total_cost' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'valid_until' => 'date',
        'approved_at' => 'datetime',
        'payment_updated_at' => 'datetime',
        'customer_panel' => 'boolean',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'quotation_service')
                    ->withPivot(['price', 'quantity', 'subtotal']);
    }

    /**
     * Get the emails sent for this quotation.
     */
    public function emails()
    {
        return $this->hasMany(QuotationEmail::class)->orderBy('sent_at', 'desc');
    }

    /**
     * Get the number of times this quotation has been sent.
     */
    public function getEmailCountAttribute()
    {
        return $this->emails()->count();
    }

    /**
     * Get the most recent email sent.
     */
    public function getLastEmailAttribute()
    {
        return $this->emails()->first();
    }

    /**
     * Check if quotation has been sent via email.
     */
    public function getHasBeenEmailedAttribute()
    {
        return $this->emails()->exists();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public static function getStatuses()
    {
        return [
            'draft' => 'Draft',
            'sent' => 'Sent',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ];
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'draft' => 'secondary',
            'sent' => 'primary',
            'approved' => 'success',
            'rejected' => 'danger',
        ];
        return $colors[$this->status] ?? 'secondary';
    }

    public function getFormattedTotalCostAttribute()
    {
        return '₹' . number_format($this->total_cost, 2);
    }

    public function getFormattedFinalAmountAttribute()
    {
        return '₹' . number_format($this->final_amount, 2);
    }

    public static function generateQuotationNumber()
    {
        $prefix = 'QTN-' . date('Y');
        $lastQuotation = self::where('quotation_number', 'like', $prefix . '%')
                            ->orderBy('quotation_number', 'desc')
                            ->first();
        
        if ($lastQuotation) {
            $lastNumber = intval(substr($lastQuotation->quotation_number, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public static function getApprovalStatuses()
    {
        return [
            'waiting' => 'Waiting',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ];
    }

    public function getApprovalStatusColorAttribute()
    {
        $colors = [
            'waiting' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
        ];
        return $colors[$this->approval_status] ?? 'secondary';
    }

    public function getApprovalStatusIconAttribute()
    {
        $icons = [
            'waiting' => 'clock',
            'approved' => 'check-circle',
            'rejected' => 'times-circle',
        ];
        return $icons[$this->approval_status] ?? 'question-circle';
    }

    public function approve($notes = null)
    {
        $this->update([
            'approval_status' => 'approved',
            'approved_at' => now(),
            'approval_notes' => $notes,
        ]);
    }

    public function reject($notes = null)
    {
        $this->update([
            'approval_status' => 'rejected',
            'approval_notes' => $notes,
        ]);
    }

    // Payment Status Methods
    public static function getPaymentStatuses()
    {
        return [
            'pending' => 'Pending',
            'partial' => 'Partial',
            'completed' => 'Completed',
            'overdue' => 'Overdue',
            'cancelled' => 'Cancelled',
        ];
    }

    public function getPaymentStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'partial' => 'info',
            'completed' => 'success',
            'overdue' => 'danger',
            'cancelled' => 'secondary',
        ];
        return $colors[$this->payment_status] ?? 'secondary';
    }

    public function getPaymentStatusIconAttribute()
    {
        $icons = [
            'pending' => 'clock',
            'partial' => 'hourglass-half',
            'completed' => 'check-circle',
            'overdue' => 'exclamation-triangle',
            'cancelled' => 'times-circle',
        ];
        return $icons[$this->payment_status] ?? 'question-circle';
    }

    /**
     * Check if customer has panel access
     */
    public function hasCustomerPanelAccess()
    {
        return $this->customer_panel;
    }

    /**
     * Get customer user associated with this quotation
     */
    public function getCustomerUser()
    {
        return \App\Models\User::where('email', $this->client_email)
                               ->where('role', 3) // Customer role
                               ->first();
    }

    /**
     * Get invoice status color attribute
     */
    public function getInvoiceStatusColorAttribute()
    {
        $colors = [
            'pending' => 'secondary',
            'waiting for approval' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
        ];
        return $colors[$this->invoice_status] ?? 'secondary';
    }

    /**
     * Get invoice status icon attribute
     */
    public function getInvoiceStatusIconAttribute()
    {
        $icons = [
            'pending' => 'clock',
            'waiting for approval' => 'hourglass-half',
            'approved' => 'check-circle',
            'rejected' => 'times-circle',
        ];
        return $icons[$this->invoice_status] ?? 'clock';
    }
}
