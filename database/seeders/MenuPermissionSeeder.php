<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuPermission;

class MenuPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define all available menus
        $menus = [
            ['name' => 'Dashboard', 'url' => 'admin/dashboard', 'icon' => 'fas fa-gauge-high', 'order' => 1],
            ['name' => 'Leads Generation', 'url' => 'leads', 'icon' => 'fas fa-chart-line', 'order' => 2],
            ['name' => 'Categories', 'url' => 'categories', 'icon' => 'fas fa-layer-group', 'order' => 3],
            ['name' => 'Employees', 'url' => 'employees', 'icon' => 'fas fa-user-tie', 'order' => 4],
            ['name' => 'Customers', 'url' => 'customers', 'icon' => 'fas fa-users', 'order' => 5],
            ['name' => 'Invoices', 'url' => 'invoices', 'icon' => 'fas fa-file-invoice', 'order' => 6],
            ['name' => 'Account', 'url' => 'accounts', 'icon' => 'fas fa-user-check', 'order' => 7],
            ['name' => 'Project Updates', 'url' => 'project-updates', 'icon' => 'fas fa-project-diagram', 'order' => 8],
            ['name' => 'Approval Status', 'url' => 'approval-status', 'icon' => 'fas fa-check-circle', 'order' => 9],
            ['name' => 'Sales Department', 'url' => 'sales-department', 'icon' => 'fas fa-chart-line', 'order' => 10],
            ['name' => 'EmpTasks', 'url' => 'admin/dashboard', 'icon' => 'fas fa-tasks', 'order' => 11],
            ['name' => 'Menu Controller', 'url' => 'menu-controller', 'icon' => 'fas fa-cogs', 'order' => 12],
        ];

        // Define role permissions
        $rolePermissions = [
            // Admin (Role 1) - All menus visible
            1 => ['Dashboard', 'Leads Generation', 'Categories', 'Employees', 'Customers', 'Invoices', 'Account', 'Project Updates', 'Approval Status', 'Sales Department', 'EmpTasks', 'Menu Controller'],
            
            // Employee (Role 2) - Limited menus
            2 => ['Dashboard', 'Project Updates', 'Approval Status'],
            
            // Customer (Role 3) - Customer specific menus
            3 => ['Dashboard', 'Invoices', 'Project Updates'],
            
            // Manager (Role 4) - Manager menus
            4 => ['Dashboard', 'Project Updates', 'Approval Status'],
            
            // Super Admin (Role 5) - All menus visible
            5 => ['Dashboard', 'Leads Generation', 'Categories', 'Employees', 'Customers', 'Invoices', 'Account', 'Project Updates', 'Approval Status', 'Sales Department', 'EmpTasks', 'Menu Controller'],
        ];

        // Create menu permissions for each role
        foreach ($rolePermissions as $roleId => $visibleMenus) {
            foreach ($menus as $menu) {
                MenuPermission::updateOrCreate(
                    [
                        'menu_name' => $menu['name'],
                        'role_id' => $roleId
                    ],
                    [
                        'menu_url' => $menu['url'],
                        'menu_icon' => $menu['icon'],
                        'menu_order' => $menu['order'],
                        'is_visible' => in_array($menu['name'], $visibleMenus)
                    ]
                );
            }
        }
    }
}
