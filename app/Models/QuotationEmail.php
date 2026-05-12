<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'sent_by',
        'recipient_email',
        'recipient_name',
        'subject',
        'message',
        'has_attachment',
        'attachment_path',
        'status',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'has_attachment' => 'boolean',
        'sent_at' => 'datetime',
    ];

    /**
     * Get the quotation that owns the email.
     */
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    /**
     * Get the user who sent the email.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    /**
     * Get formatted sent date.
     */
    public function getFormattedSentAtAttribute()
    {
        return $this->sent_at->format('d M Y, h:i A');
    }

    /**
     * Get status color class.
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'sent' => 'success',
            'failed' => 'danger',
            'pending' => 'warning',
            default => 'secondary',
        };
    }

    /**
     * Get status icon.
     */
    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'sent' => 'fa-check-circle',
            'failed' => 'fa-exclamation-triangle',
            'pending' => 'fa-clock',
            default => 'fa-question-circle',
        };
    }
}
