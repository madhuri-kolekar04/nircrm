<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MenuPermission;
use App\Models\EmployeeMenuPermission;
use App\Models\Category;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    /**
     * Display a listing of the menu permissions.
     */
    public function index(): View
    {
        $roles = [
            1 => 'Admin',
            2 => 'Employee', 
            3 => 'Customer',
            4 => 'Manager',
            5 => 'Super Admin'
        ];

        // Get all available menus from the system
        $allMenus = [
            ['name' => 'Dashboard', 'url' => 'admin/dashboard', 'icon' => 'fas fa-gauge-high'],
            ['name' => 'Leads Generation', 'url' => 'leadsmanagement', 'icon' => 'fas fa-chart-line'],
            ['name' => 'Categories', 'url' => 'categories', 'icon' => 'fas fa-layer-group'],
            ['name' => 'Employees', 'url' => 'employees', 'icon' => 'fas fa-user-tie'],
            ['name' => 'Customers', 'url' => 'customers', 'icon' => 'fas fa-users'],
            ['name' => 'Quotations', 'url' => 'quotations', 'icon' => 'fas fa-file-contract'],
            ['name' => 'Invoices', 'url' => 'invoices', 'icon' => 'fas fa-file-invoice'],
            ['name' => 'Account', 'url' => 'accounts', 'icon' => 'fas fa-user-check'],
            ['name' => 'Project Updates', 'url' => 'project-updates', 'icon' => 'fas fa-project-diagram'],
            ['name' => 'Approval Status', 'url' => 'approval-status', 'icon' => 'fas fa-check-circle'],
            ['name' => 'Sales Department', 'url' => 'sales-department', 'icon' => 'fas fa-chart-line'],
            ['name' => 'EmpTasks', 'url' => 'niremptask', 'icon' => 'fas fa-tasks'],
            ['name' => 'Menu Controller', 'url' => 'menu-controller', 'icon' => 'fas fa-cogs'],
            ['name' => 'Employee Menu Controller', 'url' => 'employee-menu-controller', 'icon' => 'fas fa-users-cog'],
            ['name' => 'Attendance', 'url' => 'admin/attendance', 'icon' => 'fas fa-calendar-check'],
        ];

        return view('admin.menu-controller.index', compact('roles', 'allMenus'));
    }

    /**
     * Display employee-specific menu controller.
     */
    public function employeeIndex(): View
    {
        $roles = [
            2 => 'Employee', 
            3 => 'Customer',
            4 => 'Manager'
        ];

        // Get all available menus from system (employee view)
        $allMenus = [
            ['name' => 'Dashboard', 'url' => 'admin/dashboard', 'icon' => 'fas fa-gauge-high'],
            ['name' => 'Leads Generation', 'url' => 'leadsmanagement', 'icon' => 'fas fa-chart-line'],
            ['name' => 'Categories', 'url' => 'categories', 'icon' => 'fas fa-layer-group'],
            ['name' => 'Employees', 'url' => 'employees', 'icon' => 'fas fa-user-tie'],
            ['name' => 'Customers', 'url' => 'customers', 'icon' => 'fas fa-users'],
            ['name' => 'Quotations', 'url' => 'quotations', 'icon' => 'fas fa-file-contract'],
            ['name' => 'Invoices', 'url' => 'invoices', 'icon' => 'fas fa-file-invoice'],
            ['name' => 'Account', 'url' => 'accounts', 'icon' => 'fas fa-user-check'],
            ['name' => 'Project Updates', 'url' => 'project-updates', 'icon' => 'fas fa-project-diagram'],
            ['name' => 'Approval Status', 'url' => 'approval-status', 'icon' => 'fas fa-check-circle'],
            ['name' => 'Sales Department', 'url' => 'sales-department', 'icon' => 'fas fa-chart-line'],
            ['name' => 'EmpTasks', 'url' => 'niremptask', 'icon' => 'fas fa-tasks'],
        ];

        $categories = Category::all();
        $departments = Department::select('id', 'department')->get();

        return view('admin.menu-controller.employee-index', compact('roles', 'allMenus', 'categories', 'departments'));
    }

    /**
     * Get employees based on department and role
     */
    public function getEmployeesByDepartmentAndRole(Request $request): JsonResponse
    {
        $departmentId = $request->get('department_id');
        $roleName = $request->get('role_name');
        
        $query = User::query();
        
        if ($departmentId) {
            // Get department name from departments table
            $department = Department::find($departmentId);
            if ($department) {
                $query->where('department', 'like', '%' . $department->department . '%');
            }
        }
        
        if ($roleName) {
            // Map role names to role numbers as stored in database
            $roleMapping = [
                'Admin' => '1',
                'Employee' => '2',
                'Customer' => '3',
                'Manager' => '4',
                'Super Admin' => '5'
            ];
            
            $roleNumber = $roleMapping[$roleName] ?? $roleName;
            $query->where('role', $roleNumber);
        }
        
        $employees = $query->select('id', 'name', 'email', 'department', 'role')->get();
        
        return response()->json($employees);
    }

    /**
     * Get menu permissions for a specific role
     */
    public function getMenuPermissions(Request $request): JsonResponse
    {
        $roleId = $request->get('role_id');
        
        \Log::info('MenuController@getMenuPermissions: Request for role', ['role_id' => $roleId]);
        
        $menuPermissions = MenuPermission::forRole($roleId)->get();
        
        \Log::info('MenuController@getMenuPermissions: Retrieved permissions', [
            'role_id' => $roleId,
            'count' => $menuPermissions->count(),
            'permissions' => $menuPermissions->toArray()
        ]);
        
        return response()->json($menuPermissions);
    }

    /**
     * Update menu permissions for a role
     */
    public function updateMenuPermissions(Request $request): JsonResponse
    {
        try {
            $roleId = $request->get('role_id');
            $menus = $request->get('menus', []);

            // Log the incoming data
            \Log::info('MenuController@updateMenuPermissions: Incoming request', [
                'role_id' => $roleId,
                'menus' => $menus,
                'menus_count' => is_array($menus) ? count($menus) : 0
            ]);

            // Validate input
            if (!$roleId) {
                \Log::error('MenuController@updateMenuPermissions: Role ID is required');
                return response()->json(['success' => false, 'message' => 'Role ID is required']);
            }

            if (empty($menus)) {
                \Log::error('MenuController@updateMenuPermissions: Menu data is required');
                return response()->json(['success' => false, 'message' => 'Menu data is required']);
            }

            foreach ($menus as $menu) {
                if (!isset($menu['name'])) {
                    \Log::warning('MenuController@updateMenuPermissions: Skipping invalid menu entry', $menu);
                    continue; // Skip invalid menu entries
                }

                \Log::info('MenuController@updateMenuPermissions: Processing menu', [
                    'menu_name' => $menu['name'],
                    'visible' => $menu['visible'] ?? 'not_set',
                    'visible_cast' => filter_var($menu['visible'] ?? false, FILTER_VALIDATE_BOOLEAN)
                ]);

                MenuPermission::updateOrCreate(
                    [
                        'menu_name' => $menu['name'],
                        'role_id' => $roleId
                    ],
                    [
                        'menu_url' => $menu['url'] ?? '',
                        'menu_icon' => $menu['icon'] ?? '',
                        'menu_order' => $menu['order'] ?? 0,
                        'is_visible' => filter_var($menu['visible'] ?? false, FILTER_VALIDATE_BOOLEAN)
                    ]
                );

                \Log::info('MenuController@updateMenuPermissions: Saved menu permission', [
                    'menu_name' => $menu['name'],
                    'role_id' => $roleId,
                    'is_visible' => filter_var($menu['visible'] ?? false, FILTER_VALIDATE_BOOLEAN)
                ]);
            }

            \Log::info('MenuController@updateMenuPermissions: Transaction completed successfully');

            return response()->json(['success' => true, 'message' => 'Menu permissions updated successfully.']);
            
        } catch (\Exception $e) {
            \Log::error('MenuController@updateMenuPermissions: Exception occurred', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Error updating menu permissions: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get menu permissions for a specific employee
     */
    public function getEmployeeMenuPermissions(Request $request): JsonResponse
    {
        $employeeId = $request->get('employee_id');
        
        \Log::info('MenuController@getEmployeeMenuPermissions: Request for employee', ['employee_id' => $employeeId]);
        
        $menuPermissions = EmployeeMenuPermission::forEmployee($employeeId)->get();
        
        \Log::info('MenuController@getEmployeeMenuPermissions: Retrieved permissions', [
            'employee_id' => $employeeId,
            'count' => $menuPermissions->count(),
            'permissions' => $menuPermissions->toArray()
        ]);
        
        return response()->json($menuPermissions);
    }

    /**
     * Update menu permissions for an employee
     */
    public function updateEmployeeMenuPermissions(Request $request): JsonResponse
    {
        try {
            $employeeId = $request->get('employee_id');
            $menus = $request->get('menus', []);

            // Log the incoming data
            \Log::info('MenuController@updateEmployeeMenuPermissions: Incoming request', [
                'employee_id' => $employeeId,
                'menus' => $menus,
                'menus_count' => is_array($menus) ? count($menus) : 0
            ]);

            // Validate input
            if (!$employeeId) {
                \Log::error('MenuController@updateEmployeeMenuPermissions: Employee ID is required');
                return response()->json(['success' => false, 'message' => 'Employee ID is required']);
            }

            if (empty($menus)) {
                \Log::error('MenuController@updateEmployeeMenuPermissions: Menu data is required');
                return response()->json(['success' => false, 'message' => 'Menu data is required']);
            }

            foreach ($menus as $menu) {
                if (!isset($menu['name'])) {
                    \Log::warning('MenuController@updateEmployeeMenuPermissions: Skipping invalid menu entry', $menu);
                    continue; // Skip invalid menu entries
                }

                \Log::info('MenuController@updateEmployeeMenuPermissions: Processing menu', [
                    'menu_name' => $menu['name'],
                    'visible' => $menu['visible'] ?? 'not_set',
                    'visible_cast' => filter_var($menu['visible'] ?? false, FILTER_VALIDATE_BOOLEAN)
                ]);

                EmployeeMenuPermission::updateOrCreate(
                    [
                        'employee_id' => $employeeId,
                        'menu_name' => $menu['name']
                    ],
                    [
                        'menu_url' => $menu['url'] ?? '',
                        'menu_icon' => $menu['icon'] ?? '',
                        'menu_order' => $menu['order'] ?? 0,
                        'is_visible' => filter_var($menu['visible'] ?? false, FILTER_VALIDATE_BOOLEAN)
                    ]
                );

                \Log::info('MenuController@updateEmployeeMenuPermissions: Saved menu permission', [
                    'menu_name' => $menu['name'],
                    'employee_id' => $employeeId,
                    'is_visible' => filter_var($menu['visible'] ?? false, FILTER_VALIDATE_BOOLEAN)
                ]);
            }

            \Log::info('MenuController@updateEmployeeMenuPermissions: Transaction completed successfully');

            return response()->json(['success' => true, 'message' => 'Employee menu permissions updated successfully.']);
            
        } catch (\Exception $e) {
            \Log::error('MenuController@updateEmployeeMenuPermissions: Exception occurred', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Error updating employee menu permissions: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create(): View
    {
        $roles = [
            1 => 'Admin',
            2 => 'Employee', 
            3 => 'Customer',
            4 => 'Manager',
            5 => 'Super Admin'
        ];

        return view('admin.menu-controller.create', compact('roles'));
    }

    /**
     * Store a newly created menu item in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'menu_name' => 'required|string|max:255',
            'menu_url' => 'required|string|max:255',
            'menu_icon' => 'nullable|string|max:255',
            'menu_order' => 'nullable|integer|min:0',
            'role_id' => 'required|integer|in:1,2,3,4,5',
            'is_visible' => 'boolean',
        ]);

        MenuPermission::create($request->all());

        return redirect()->route('menu-controller.index')
            ->with('success', 'Menu item created successfully.');
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit($id): View
    {
        $menuPermission = MenuPermission::findOrFail($id);
        
        $roles = [
            1 => 'Admin',
            2 => 'Employee', 
            3 => 'Customer',
            4 => 'Manager',
            5 => 'Super Admin'
        ];

        return view('admin.menu-controller.edit', compact('menuPermission', 'roles'));
    }

    /**
     * Update the specified menu item in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $menuPermission = MenuPermission::findOrFail($id);

        $request->validate([
            'menu_name' => 'required|string|max:255',
            'menu_url' => 'required|string|max:255',
            'menu_icon' => 'nullable|string|max:255',
            'menu_order' => 'nullable|integer|min:0',
            'role_id' => 'required|integer|in:1,2,3,4,5',
            'is_visible' => 'boolean',
        ]);

        $menuPermission->update($request->all());

        return redirect()->route('menu-controller.index')
            ->with('success', 'Menu item updated successfully.');
    }

    /**
     * Remove the specified menu item from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $menuPermission = MenuPermission::findOrFail($id);
        $menuPermission->delete();

        return redirect()->route('menu-controller.index')
            ->with('success', 'Menu item deleted successfully.');
    }
}
