<?php

namespace App\Helpers;

use App\Models\PageCustomization;

class PageCustomizationHelper
{
    /**
     * Check if an element is visible for the current user
     * 
     * @param string $elementIdentifier The element ID, class, or selector
     * @param string|null $menuName Optional menu name (auto-detected if null)
     * @return bool
     */
    public static function isVisible(string $elementIdentifier, ?string $menuName = null): bool
    {
        $user = auth()->user();
        
        if (!$user) {
            return true; // Default to visible for guests
        }
        
        if (!$menuName) {
            $menuName = self::detectCurrentMenu();
        }
        
        if (!$menuName) {
            return true;
        }
        
        return PageCustomization::isElementVisible(
            $menuName,
            $elementIdentifier,
            $user->role,
            $user->id
        );
    }
    
    /**
     * Check if an element is hidden
     * 
     * @param string $elementIdentifier The element ID, class, or selector
     * @param string|null $menuName Optional menu name
     * @return bool
     */
    public static function isHidden(string $elementIdentifier, ?string $menuName = null): bool
    {
        return !self::isVisible($elementIdentifier, $menuName);
    }
    
    /**
     * Get all hidden elements for current page
     * 
     * @param string|null $menuName Optional menu name
     * @return array
     */
    public static function getHiddenElements(?string $menuName = null): array
    {
        $user = auth()->user();
        
        if (!$user) {
            return [];
        }
        
        if (!$menuName) {
            $menuName = self::detectCurrentMenu();
        }
        
        if (!$menuName) {
            return [];
        }
        
        return PageCustomization::getHiddenElements(
            $menuName,
            $user->role,
            $user->id
        );
    }
    
    /**
     * Get all customizations for current page
     * 
     * @param string|null $menuName Optional menu name
     * @return \Illuminate\Support\Collection
     */
    public static function getCustomizations(?string $menuName = null)
    {
        $user = auth()->user();
        
        if (!$user) {
            return collect([]);
        }
        
        if (!$menuName) {
            $menuName = self::detectCurrentMenu();
        }
        
        if (!$menuName) {
            return collect([]);
        }
        
        return PageCustomization::where('menu_name', $menuName)
            ->where(function($query) use ($user) {
                $query->where('role_id', $user->role)
                      ->orWhere('employee_id', $user->id);
            })
            ->get();
    }
    
    /**
     * Get customizations grouped by element type
     * 
     * @param string|null $menuName Optional menu name
     * @return array
     */
    public static function getCustomizationsByType(?string $menuName = null): array
    {
        return self::getCustomizations($menuName)
            ->groupBy('element_type')
            ->toArray();
    }
    
    /**
     * Detect current menu name from route or URL
     * 
     * @return string|null
     */
    public static function detectCurrentMenu(): ?string
    {
        $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
        $path = parse_url(url()->current(), PHP_URL_PATH);
        
        $routeToMenuMap = [
            'leads.index' => 'Leads Generation',
            'leads.create' => 'Leads Generation',
            'employees.index' => 'Employees',
            'employees.create' => 'Employees',
            'customers.index' => 'Customers',
            'customers.create' => 'Customers',
            'invoices.index' => 'Invoices',
            'accounts.index' => 'Account',
            'all.category' => 'Categories',
            'menu-controller.index' => 'Menu Controller',
            'employee-menu-controller.index' => 'Employee Menu Controller',
            'approval-status.index' => 'Approval Status',
            'sales.department' => 'Sales Department',
            'chat.index' => 'Chat',
        ];
        
        if (isset($routeToMenuMap[$routeName])) {
            return $routeToMenuMap[$routeName];
        }
        
        $pathToMenuMap = [
            '/leadsmanagement' => 'Leads Generation',
            '/employees' => 'Employees',
            '/customers' => 'Customers',
            '/invoices' => 'Invoices',
            '/accounts' => 'Account',
            '/categories' => 'Categories',
            '/menu-controller' => 'Menu Controller',
            '/employee-menu-controller' => 'Employee Menu Controller',
            '/approval-status' => 'Approval Status',
            '/sales-department' => 'Sales Department',
            '/chat' => 'Chat',
            '/admin/dashboard' => 'Dashboard',
        ];
        
        foreach ($pathToMenuMap as $pathPattern => $menuName) {
            if (strpos($path, $pathPattern) !== false) {
                return $menuName;
            }
        }
        
        return null;
    }
    
    /**
     * Check if a column is visible in a table
     * 
     * @param string $tableId The table ID or selector
     * @param string $columnName The column name
     * @return bool
     */
    public static function isColumnVisible(string $tableId, string $columnName): bool
    {
        $elementIdentifier = "{$tableId}.{$columnName}";
        return self::isVisible($elementIdentifier);
    }
    
    /**
     * Check if a button is visible
     * 
     * @param string $buttonId The button ID or selector
     * @return bool
     */
    public static function isButtonVisible(string $buttonId): bool
    {
        return self::isVisible($buttonId);
    }
    
    /**
     * Check if a form field is visible
     * 
     * @param string $formId The form ID
     * @param string $fieldName The field name
     * @return bool
     */
    public static function isFieldVisible(string $formId, string $fieldName): bool
    {
        $elementIdentifier = "{$formId}.{$fieldName}";
        return self::isVisible($elementIdentifier);
    }
}
