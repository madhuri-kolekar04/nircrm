<?php

use App\Models\MenuPermission;
use App\Models\EmployeeMenuPermission;

/**
 * Get visible menus for the current user's role
 */
function getVisibleMenusForCurrentUser()
{
    try {
        // Get the authenticated user
        $user = auth()->user();
        
        if (!$user) {
            return [];
        }
        
        // First, check if this user has individual employee menu permissions
        $employeeMenus = EmployeeMenuPermission::where('employee_id', $user->id)
                                              ->where('is_visible', true)
                                              ->orderBy('menu_order')
                                              ->get();
        
        // If employee has specific menu permissions, use those
        if (!$employeeMenus->isEmpty()) {
            return $employeeMenus->map(function($menu) {
                return [
                    'name' => $menu->menu_name,
                    'url' => $menu->menu_url,
                    'icon' => $menu->menu_icon
                ];
            })->toArray();
        }
        
        // If no individual permissions, fall back to role-based permissions
        // Handle both numeric and string role formats
        if (is_numeric($user->role)) {
            $roleId = (int)$user->role;
        } else {
            // Map role names to role IDs
            $roleMap = [
                'Admin' => 1,
                'Employee' => 2,
                'Customer' => 3,
                'Manager' => 4,
                'Super Admin' => 5
            ];
            $roleId = $roleMap[$user->role] ?? 2; // Default to Employee if not found
        }
        
        // Get visible menus for this role from database
        $visibleMenus = MenuPermission::where('role_id', $roleId)
                                      ->where('is_visible', true)
                                      ->orderBy('menu_order')
                                      ->get();
        
        // If we have menu permissions in database, use them
        if ($visibleMenus->count() > 0) {
            \Log::info('Using database menu permissions for role ' . $roleId . ': ' . $visibleMenus->count() . ' menus found');
            
            return $visibleMenus->map(function($menu) {
                return [
                    'name' => $menu->menu_name,
                    'url' => $menu->menu_url,
                    'icon' => $menu->menu_icon
                ];
            })->toArray();
        }
        
        // If no permissions found in database, use default menus
        \Log::info('No menu permissions found for role ' . $roleId . ' - using default menus');
        
        $defaultMenus = [
            ['name' => 'Dashboard', 'url' => 'admin/dashboard', 'icon' => 'fas fa-gauge-high'],
            ['name' => 'Leads Generation', 'url' => 'leadsmanagement', 'icon' => 'fas fa-chart-line'],
            ['name' => 'Reactions System', 'url' => 'reactions-system', 'icon' => 'fas fa-comments'],
            ['name' => 'Categories', 'url' => 'categories', 'icon' => 'fas fa-layer-group'],
            ['name' => 'Employees', 'url' => 'employees', 'icon' => 'fas fa-user-tie'],
            ['name' => 'Customers', 'url' => 'customers', 'icon' => 'fas fa-users'],
            ['name' => 'Quotations', 'url' => 'quotations', 'icon' => 'fas fa-file-contract'],
            ['name' => 'Invoices', 'url' => 'invoices', 'icon' => 'fas fa-file-invoice'],
            ['name' => 'Create Installment Invoice', 'url' => 'invoices/create-installment', 'icon' => 'fas fa-plus-circle'],
            ['name' => 'Account', 'url' => 'accounts', 'icon' => 'fas fa-user-check'],
            ['name' => 'Project Updates', 'url' => 'project-updates', 'icon' => 'fas fa-project-diagram'],
            ['name' => 'Approval Status', 'url' => 'approval-status', 'icon' => 'fas fa-check-circle'],
            ['name' => 'Sales Department', 'url' => 'sales-department', 'icon' => 'fas fa-chart-line'],
            ['name' => 'EmpTasks', 'url' => 'admin/dashboard', 'icon' => 'fas fa-tasks'],
            ['name' => 'Menu Controller', 'url' => 'menu-controller', 'icon' => 'fas fa-cogs'],
            ['name' => 'Activity Logs', 'url' => 'logs', 'icon' => 'fas fa-history'],
            ['name' => 'Okay', 'url' => 'okay', 'icon' => 'fas fa-check'],
             ['name' => 'Attendance', 'url' => 'attendance/dashboard', 'icon' => 'fas fa-user-check']

        ];
        
        // For non-admin roles, hide sensitive menus by default
        $adminRoles = [1, 'Admin', 5, 'Super Admin'];
        if (!in_array($user->role, $adminRoles)) {
            $defaultMenus = array_filter($defaultMenus, function($menu) {
                // Hide sensitive menus for non-admin users
                $restrictedMenus = ['Employees', 'Menu Controller', 'Activity Logs'];
                return !in_array($menu['name'], $restrictedMenus);
            });
        }
        
        \Log::info('Final default menus for user ' . $user->name . ': ' . json_encode(array_values($defaultMenus)));
        return array_values($defaultMenus);
        
    } catch (\Exception $e) {
        // Log error and return empty array
        \Log::error('Error in getVisibleMenusForCurrentUser: ' . $e->getMessage());
        return [];
    }
}

/**
 * Get role ID from role name
 */
function getRoleIdFromName($roleName)
{
    $roleMap = [
        'Admin' => 1,
        'Employee' => 2,
        'Customer' => 3,
        'Manager' => 4,
        'Super Admin' => 5
    ];
    
    return $roleMap[$roleName] ?? 2;
}

/**
 * Get activity type color for badges
 */
function getActivityTypeColor($type)
{
    $colors = [
        'login' => 'success',
        'logout' => 'info',
        'create' => 'primary',
        'update' => 'warning',
        'delete' => 'danger',
        'view' => 'secondary',
        'export' => 'info',
        'error' => 'danger',
        'general' => 'secondary',
        'navigation' => 'info',
        'user_action' => 'primary'
    ];
    return $colors[$type] ?? 'secondary';
}

/**
 * Get activity icon based on action
 */
function getActivityIcon($action)
{
    $iconMap = [
        'login' => 'sign-in-alt',
        'logout' => 'sign-out-alt',
        'profile_view' => 'user',
        'dashboard_view' => 'tachometer-alt',
        'logs_view' => 'history',
        'create' => 'plus',
        'update' => 'edit',
        'delete' => 'trash',
        'view' => 'eye',
        'export' => 'download',
        'import' => 'upload',
        'search' => 'search',
        'filter' => 'filter',
        'click' => 'mouse-pointer',
        'form_submit' => 'paper-plane',
        'ajax_request' => 'exchange-alt',
        'api_call' => 'code'
    ];
    
    foreach ($iconMap as $key => $icon) {
        if (strpos($action, $key) !== false) {
            return $icon;
        }
    }
    
    return 'circle';
}

/**
 * Check if a lead already has a quotation in Account Management
 */
function checkLeadInQuotations($leadId)
{
    try {
        return \App\Models\Quotation::where('lead_id', $leadId)->exists();
    } catch (\Exception $e) {
        \Log::error('Error in checkLeadInQuotations: ' . $e->getMessage());
        return false;
    }
}
