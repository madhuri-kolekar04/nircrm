<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DepartmentMenu;
use App\Models\Department;

class DepartmentMenuController extends Controller
{
    public function index()
    {
        $departments = Department::with('departmentMenus')->get();
        return view('admin.department-menus.index', compact('departments'));
    }

    public function create()
    {
        $departments = Department::all();
        $availableMenus = $this->getAvailableMenus();
        return view('admin.department-menus.create', compact('departments', 'availableMenus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'menus' => 'required|array',
            'menus.*.menu_key' => 'required|string',
            'menus.*.menu_title' => 'required|string',
            'menus.*.menu_icon' => 'required|string',
            'menus.*.menu_route' => 'required|string',
            'menus.*.sort_order' => 'nullable|integer|min:0'
        ]);

        // Clear existing menus for this department
        DepartmentMenu::where('department_id', $request->department_id)->delete();

        // Insert new menus
        foreach ($request->menus as $index => $menu) {
            DepartmentMenu::create([
                'department_id' => $request->department_id,
                'menu_key' => $menu['menu_key'],
                'menu_title' => $menu['menu_title'],
                'menu_icon' => $menu['menu_icon'],
                'menu_route' => $menu['menu_route'],
                'sort_order' => $menu['sort_order'] ?? $index,
                'is_active' => true
            ]);
        }

        return redirect()->route('department-menus.index')
            ->with('success', 'Menu assignments updated successfully!');
    }

    public function edit($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $availableMenus = $this->getAvailableMenus();
        $assignedMenus = DepartmentMenu::where('department_id', $departmentId)
            ->active()
            ->ordered()
            ->get()
            ->keyBy('menu_key');

        return view('admin.department-menus.edit', compact('department', 'availableMenus', 'assignedMenus'));
    }

    public function update(Request $request, $departmentId)
    {
        $department = Department::findOrFail($departmentId);
        
        $request->validate([
            'menus' => 'required|array',
            'menus.*.menu_key' => 'required|string',
            'menus.*.menu_title' => 'required|string',
            'menus.*.menu_icon' => 'required|string',
            'menus.*.menu_route' => 'required|string',
            'menus.*.sort_order' => 'nullable|integer|min:0'
        ]);

        // Clear existing menus for this department
        DepartmentMenu::where('department_id', $departmentId)->delete();

        // Insert new menus
        foreach ($request->menus as $index => $menu) {
            if (isset($menu['assigned']) && $menu['assigned']) {
                DepartmentMenu::create([
                    'department_id' => $departmentId,
                    'menu_key' => $menu['menu_key'],
                    'menu_title' => $menu['menu_title'],
                    'menu_icon' => $menu['menu_icon'],
                    'menu_route' => $menu['menu_route'],
                    'sort_order' => $menu['sort_order'] ?? $index,
                    'is_active' => true
                ]);
            }
        }

        return redirect()->route('department-menus.index')
            ->with('success', 'Menu assignments updated successfully!');
    }

    private function getAvailableMenus()
    {
        return [
            'dashboard' => [
                'menu_key' => 'dashboard',
                'menu_title' => 'Dashboard',
                'menu_icon' => 'fas fa-gauge-high',
                'menu_route' => 'admin.dashboard'
            ],
            'leads' => [
                'menu_key' => 'leads',
                'menu_title' => 'Leads Generation',
                'menu_icon' => 'fas fa-chart-line',
                'menu_route' => 'leads.index'
            ],
            'categories' => [
                'menu_key' => 'categories',
                'menu_title' => 'Categories',
                'menu_icon' => 'fas fa-layer-group',
                'menu_route' => 'all.category'
            ],
            'employees' => [
                'menu_key' => 'employees',
                'menu_title' => 'Employees',
                'menu_icon' => 'fas fa-user-tie',
                'menu_route' => 'employees.index'
            ],
            'customers' => [
                'menu_key' => 'customers',
                'menu_title' => 'Customers',
                'menu_icon' => 'fas fa-users',
                'menu_route' => 'customers.index'
            ],
            'invoices' => [
                'menu_key' => 'invoices',
                'menu_title' => 'Invoices',
                'menu_icon' => 'fas fa-file-invoice',
                'menu_route' => 'invoices.index'
            ],
            'accounts' => [
                'menu_key' => 'accounts',
                'menu_title' => 'Account',
                'menu_icon' => 'fas fa-user-check',
                'menu_route' => 'accounts.index'
            ],
            'project-updates' => [
                'menu_key' => 'project-updates',
                'menu_title' => 'Project Updates',
                'menu_icon' => 'fas fa-project-diagram',
                'menu_route' => 'project-updates.index'
            ],
            'approval-status' => [
                'menu_key' => 'approval-status',
                'menu_title' => 'Approval Status',
                'menu_icon' => 'fas fa-check-circle',
                'menu_route' => 'approval-status.index'
            ],
            'sales-department' => [
                'menu_key' => 'sales-department',
                'menu_title' => 'Sales Department',
                'menu_icon' => 'fas fa-chart-line',
                'menu_route' => 'sales.department'
            ],
            'emptasks' => [
                'menu_key' => 'emptasks',
                'menu_title' => 'EmpTasks',
                'menu_icon' => 'fas fa-tasks',
                'menu_route' => 'employee.dashboard'
            ],
            'my-menu' => [
                'menu_key' => 'my-menu',
                'menu_title' => 'My Menu',
                'menu_icon' => 'fas fa-utensils',
                'menu_route' => 'my-menu'
            ]
        ];
    }
}
