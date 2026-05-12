<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'pricing_type',
        'timeline_weeks',
        'key_features',
        'is_optional',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_optional' => 'boolean',
        'status' => 'boolean',
        'key_features' => 'array',
    ];

    public function quotations()
    {
        return $this->belongsToMany(Quotation::class, 'quotation_service')
                    ->withPivot(['price', 'quantity', 'subtotal']);
    }

    public static function getPricingTypes()
    {
        return [
            'one_time' => 'One Time',
            'per_year' => 'Per Year',
            'per_month' => 'Per Month',
            'per_page' => 'Per Page',
        ];
    }

    public function getFormattedPriceAttribute()
    {
        return '₹' . number_format($this->price, 2);
    }

    public function getFormattedPricingTypeAttribute()
    {
        $types = self::getPricingTypes();
        return $types[$this->pricing_type] ?? $this->pricing_type;
    }
}
