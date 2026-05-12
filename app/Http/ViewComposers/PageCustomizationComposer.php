<?php

namespace App\Http\ViewComposers;

use App\Models\PageCustomization;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class PageCustomizationComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Get current user info
        $user = auth()->user();
        
        if (!$user) {
            $view->with('pageCustomizations', []);
            $view->with('hiddenElements', []);
            $view->with('currentMenuName', '');
            return;
        }
        
        // Detect current menu name from route or URL
        $currentMenuName = $this->detectCurrentMenu();
        
        // Get user's role and employee ID
        $roleId = $user->role ?? null;
        $employeeId = $user->id;
        
        // Get customizations for this user/role and menu
        $hiddenElements = [];
        
        // First check role-based customizations
        if ($roleId) {
            $roleCustomizations = PageCustomization::where('menu_name', $currentMenuName)
                ->where('role_id', $roleId)
                ->where('is_visible', 0)
                ->pluck('element_identifier')
                ->toArray();
            $hiddenElements = array_merge($hiddenElements, $roleCustomizations);
            
            // If entire table is hidden, hide all table elements
            if (in_array('employees-table', $hiddenElements)) {
                $hiddenElements = array_merge($hiddenElements, [
                    'employees-table.ID',
                    'employees-table.Name', 
                    'employees-table.Emp_ID',
                    'employees-table.Designation',
                    'employees-table.Profile_Pics',
                    'employees-table.Contact_Number',
                    'employees-table.Email',
                    'employees-table.Department',
                    'employees-table.Online_Offline',
                    'employees-table.Controls',
                    'add-employee-btn',
                    'edit-link',
                    'delete-link'
                ]);
            }
        }
        
        // Then check employee-specific customizations (these override role settings)
        $employeeCustomizations = PageCustomization::where('menu_name', $currentMenuName)
            ->where('employee_id', $employeeId)
            ->where('is_visible', 0)
            ->pluck('element_identifier')
            ->toArray();
        $hiddenElements = array_merge($hiddenElements, $employeeCustomizations);
        
        // Get all customizations for reference
        $allCustomizations = PageCustomization::where('menu_name', $currentMenuName)
            ->when($roleId, function($query) use ($roleId) {
                return $query->where('role_id', $roleId);
            })
            ->when($employeeId, function($query) use ($employeeId) {
                return $query->where('employee_id', $employeeId);
            })
            ->get();
        
        $view->with('pageCustomizations', $allCustomizations);
        $view->with('hiddenElements', $hiddenElements);
        $view->with('currentMenuName', $currentMenuName);
    }
    
    /**
     * Detect current menu name from route or URL
     */
    private function detectCurrentMenu(): string
    {
        $currentRoute = Route::currentRouteName();
        $currentPath = request()->path();
        
        // Map routes to menu names
        $routeToMenu = [
            'employees.index' => 'Employees',
            'employees.create' => 'Employees',
            'employees.edit' => 'Employees',
            'employees.store' => 'Employees',
            'employees.update' => 'Employees',
            'employees.destroy' => 'Employees',
            'Employee.index' => 'Employees',
            'Employee.create' => 'Employees',
            'Employee.edit' => 'Employees',
            'Employee.store' => 'Employees',
            'Employee.update' => 'Employees',
            'Employee.delete' => 'Employees',
            'leads.index' => 'Leads',
            'leads.create' => 'Leads',
            'leads.edit' => 'Leads',
            'customers.index' => 'Customers',
            'customers.create' => 'Customers',
            'customers.edit' => 'Customers',
            'menu-controller.index' => 'Menu Controller',
            'employee-menu-controller.index' => 'Employee Menu Controller',
        ];
        
        // Check if route name matches
        if (isset($routeToMenu[$currentRoute])) {
            return $routeToMenu[$currentRoute];
        }
        
        // Check URL path for common patterns
        if (strpos($currentPath, 'employees') !== false || strpos($currentPath, 'Employee') !== false) {
            return 'Employees';
        }
        if (strpos($currentPath, 'leads') !== false) {
            return 'Leads';
        }
        if (strpos($currentPath, 'customers') !== false) {
            return 'Customers';
        }
        if (strpos($currentPath, 'menu-controller') !== false) {
            return 'Menu Controller';
        }
        if (strpos($currentPath, 'employee-menu-controller') !== false) {
            return 'Employee Menu Controller';
        }
        
        // Default fallback
        return 'Unknown';
    }
}
