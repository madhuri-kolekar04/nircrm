<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_full_name',
        'lead_business_name',
        'lead_email',
        'lead_whatsapp',
        'lead_website_url',
        'called_by_employee_name',
        'called_by_employee_email',
        'rating',
        'meeting_conclusion',
        'next_call_date',
        'additional_notes'
    ];

    protected $casts = [
        'next_call_date' => 'datetime',
        'rating' => 'integer'
    ];
}
