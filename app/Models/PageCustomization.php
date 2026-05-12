<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageCustomization extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_name',
        'menu_url',
        'role_id',
        'employee_id',
        'element_type',
        'element_name',
        'element_identifier',
        'is_visible',
        'element_metadata',
        'notes'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'element_metadata' => 'array'
    ];

    /**
     * Get customizations for a specific menu and role
     */
    public static function getForMenuAndRole($menuName, $roleId)
    {
        return self::where('menu_name', $menuName)
            ->where('role_id', $roleId)
            ->get();
    }

    /**
     * Get customizations for a specific menu and employee
     */
    public static function getForMenuAndEmployee($menuName, $employeeId)
    {
        return self::where('menu_name', $menuName)
            ->where('employee_id', $employeeId)
            ->get();
    }

    /**
     * Check if an element is visible
     */
    public static function isElementVisible($menuName, $elementIdentifier, $roleId = null, $employeeId = null)
    {
        $query = self::where('menu_name', $menuName)
            ->where('element_identifier', $elementIdentifier);

        if ($roleId) {
            $query->where('role_id', $roleId);
        }

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        $customization = $query->first();

        return $customization ? $customization->is_visible : true; // Default to visible if no customization
    }

    /**
     * Get all hidden elements for a menu
     */
    public static function getHiddenElements($menuName, $roleId = null, $employeeId = null)
    {
        $query = self::where('menu_name', $menuName)
            ->where('is_visible', false);

        if ($roleId) {
            $query->where('role_id', $roleId);
        }

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        return $query->pluck('element_identifier')->toArray();
    }

    /**
     * Get all visible elements for a menu
     */
    public static function getVisibleElements($menuName, $roleId = null, $employeeId = null)
    {
        $query = self::where('menu_name', $menuName)
            ->where('is_visible', true);

        if ($roleId) {
            $query->where('role_id', $roleId);
        }

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        return $query->pluck('element_identifier')->toArray();
    }

    /**
     * Scope for element type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('element_type', $type);
    }

    /**
     * Scope for visible elements
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope for hidden elements
     */
    public function scopeHidden($query)
    {
        return $query->where('is_visible', false);
    }
}
