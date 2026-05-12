<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectCompletionStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'invoice_id',
        'user_id',
        'status_items',
        'progress_data',
        'current_percentage',
        'exact_percentage',
        'total_percentage',
    ];

    protected $casts = [
        'status_items' => 'array',
        'progress_data' => 'array',
        'current_percentage' => 'decimal:2',
        'exact_percentage' => 'decimal:2',
        'total_percentage' => 'decimal:2',
    ];

    /**
     * Get the project that owns the completion status.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'project_id');
    }

    /**
     * Get the invoice that owns the completion status.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the user that created the completion status.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the status items as formatted array with percentages.
     */
    public function getFormattedStatusItemsAttribute()
    {
        $items = $this->status_items;
        $count = count($items);
        
        if ($count === 0) {
            return [];
        }

        $percentagePerItem = round(100 / $count, 2);
        
        return array_map(function($item, $index) use ($percentagePerItem) {
            return [
                'text' => $item,
                'percentage' => $percentagePerItem,
                'color' => $this->getColorByPercentage($percentagePerItem),
                'order' => $index + 1
            ];
        }, $items, array_keys($items));
    }

    /**
     * Get color based on percentage.
     */
    private function getColorByPercentage($percentage): string
    {
        if ($percentage >= 75) {
            return '#28a745'; // Green
        } elseif ($percentage >= 50) {
            return '#ffc107'; // Yellow
        } elseif ($percentage >= 25) {
            return '#fd7e14'; // Orange
        } else {
            return '#dc3545'; // Red
        }
    }

    /**
     * Calculate remaining percentage.
     */
    public function getRemainingPercentageAttribute(): float
    {
        return 100 - $this->total_percentage;
    }

    /**
     * Scope for project-specific statuses.
     */
    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    /**
     * Scope for invoice-specific statuses.
     */
    public function scopeForInvoice($query, $invoiceId)
    {
        return $query->where('invoice_id', $invoiceId);
    }

    /**
     * Get the latest status for a project or invoice.
     */
    public static function getLatestStatus($projectId = null, $invoiceId = null)
    {
        $query = static::query();
        
        if ($projectId) {
            $query->forProject($projectId);
        }
        
        if ($invoiceId) {
            $query->forInvoice($invoiceId);
        }
        
        return $query->latest()->first();
    }
}
