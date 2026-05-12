<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeMenuPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'menu_name',
        'menu_url',
        'menu_icon',
        'menu_order',
        'is_visible'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'menu_order' => 'integer',
        'employee_id' => 'integer'
    ];

    /**
     * Scope to get visible menus for a specific employee
     */
    public function scopeVisibleForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId)->where('is_visible', true)->orderBy('menu_order');
    }

    /**
     * Scope to get all menus for a specific employee
     */
    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId)->orderBy('menu_order');
    }

    /**
     * Get the employee that owns the menu permission
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
