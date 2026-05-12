<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Staprio;
use App\Models\Quotation;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'website',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'industry',
        'lead_status',
        'source',
        'description',
        'budget',
        'assigned_to',
        'follow_up_date',
        'customer_panel',
        'invoice_status',
        'invoice_number',
        'invoice_created_at',
        'notes',
        'priority',
        'department',
        'department_id',
        'created_by',
        'business_type',
        'primary_goal',
        'score',
        'tier',
        'submitted_at',
        'audit_report',
        'audit_report_plain',
        'work_status',
        'work_type',
        'current_service',
        'date_of_completion',
        'due_date',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
        'budget' => 'decimal:2',
        'customer_panel' => 'boolean',
        'invoice_created_at' => 'datetime',
        'date_of_completion' => 'date',
        'due_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::retrieved(function ($lead) {
            if (is_null($lead->priority)) {
                $lead->priority = 'medium';
            }
        });
    }

    /**
     * Get the user who created the lead.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the assigned user for the lead.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get department for lead.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get quotations for this lead.
     */
    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class, 'lead_id');
    }

    /**
     * Get the latest approved quotation for this lead.
     */
    public function latestApprovedQuotation()
    {
        return $this->quotations()
                    ->where('approval_status', 'approved')
                    ->latest()
                    ->first();
    }

    /**
     * Get lead status options from database.
     */
    public static function getLeadStatuses(): array
    {
        return Staprio::getActiveStatuses();
    }

    /**
     * Get lead source options.
     */
    public static function getSources(): array
    {
        return [
            'website' => 'Website',
            'referral' => 'Referral',
            'social_media' => 'Social Media',
            'email' => 'Email',
            'phone' => 'Phone',
            'advertisement' => 'Advertisement',
            'other' => 'Other',
        ];
    }

    /**
     * Get priority options from database.
     */
    public static function getPriorities(): array
    {
        return Staprio::getActivePriorities();
    }

    /**
     * Get status color for UI.
     */
    public function getStatusColor(): string
    {
        return match($this->lead_status) {
            'hot' => 'danger',
            'cold' => 'info',
            'warm' => 'warning',
            'qualified' => 'success',
            'lost' => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * Get status color for specific value from database.
     */
    public static function getStatusColorForValue($value): string
    {
        // Handle null values
        if ($value === null) {
            return '#6c757d'; // Default gray color for null values
        }
        
        return Staprio::getStatusColorForValue($value);
    }

    /**
     * Get priority color for UI.
     */
    public function getPriorityColor(): string
    {
        return match($this->priority) {
            'high' => 'danger',
            'medium' => 'warning',
            'low' => 'info',
            default => 'secondary',
        };
    }

    /**
     * Get priority color for specific value from database.
     */
    public static function getPriorityColorForValue(?string $value): string
    {
        // Handle null values by providing a default
        $value = $value ?? 'medium';
        return Staprio::getPriorityColorForValue($value);
    }

    /**
     * Get the invoice status color for badge styling
     */
    public function getInvoiceStatusColor(): string
    {
        return match($this->invoice_status) {
            'approved' => 'success',
            'Mail Approved' => 'primary',
            'rejected' => 'danger',
            'waiting_for_approval' => 'warning',
            'waiting for approval' => 'warning',
            'draft' => 'info',
            default => 'secondary',
        };
    }

    /**
     * Count empty fields for the lead edit form
     */
    public function getEmptyFieldsCount(): int
    {
        $emptyCount = 0;
        
        // List of all fields to check (matching the edit form)
        $fields = [
            'name', 'email', 'phone', 'company_name', 'website', 'industry',
            'lead_status', 'priority', 'source', 'address', 'city', 'state', 
            'country', 'pincode', 'assigned_to', 'follow_up_date', 'budget', 
            'department_id', 'description', 'notes', 'work_status', 'work_type', 
            'current_service', 'date_of_completion', 'due_date'
        ];
        
        foreach ($fields as $field) {
            $value = $this->$field;
            
            // Check for empty values
            if ($value === null || $value === '' || $value === '0') {
                $emptyCount++;
            }
        }
        
        return $emptyCount;
    }
}
