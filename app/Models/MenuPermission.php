<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_name',
        'menu_url',
        'menu_icon',
        'menu_order',
        'role_id',
        'is_visible'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'menu_order' => 'integer',
        'role_id' => 'integer'
    ];

    /**
     * Get role name by role ID
     */
    public function getRoleNameAttribute()
    {
        $roles = [
            1 => 'Admin',
            2 => 'Employee',
            3 => 'Customer',
            4 => 'Manager',
            5 => 'Super Admin'
        ];
        
        // Handle null or invalid role values
        $roleId = $this->role_id;
        if ($roleId === null || !is_numeric($roleId)) {
            return 'Unknown';
        }
        
        return $roles[$roleId] ?? 'Unknown';
    }

    /**
     * Scope to get visible menus for a specific role
     */
    public function scopeVisibleForRole($query, $roleId)
    {
        return $query->where('role_id', $roleId)->where('is_visible', true)->orderBy('menu_order');
    }

    /**
     * Scope to get all menus for a specific role
     */
    public function scopeForRole($query, $roleId)
    {
        return $query->where('role_id', $roleId)->orderBy('menu_order');
    }
}
