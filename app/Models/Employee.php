<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * Get active employees
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
