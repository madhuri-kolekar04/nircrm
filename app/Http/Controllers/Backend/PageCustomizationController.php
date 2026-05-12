<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PageCustomization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PageCustomizationController extends Controller
{
    /**
     * Display page customization interface
     */
    public function index(Request $request): View
    {
        $menuName = $request->get('menu_name', '');
        $menuUrl = $request->get('menu_url', '');
        $roleId = $request->get('role_id', '');
        $employeeId = $request->get('employee_id', '');
        
        $menus = $this->getAllMenus();
        $roles = $this->getAllRoles();
        
        // Get existing customizations if menu name is provided
        $customizations = collect();
        if ($menuName) {
            $query = PageCustomization::where('menu_name', $menuName);
            
            if ($roleId && $roleId !== '') {
                $query->where('role_id', $roleId);
            }
            
            if ($employeeId && $employeeId !== '') {
                $query->where('employee_id', $employeeId);
            }
            
            $customizations = $query->get()->groupBy('element_type');
        }
        
        return view('admin.page-customization.index', compact(
            'menus', 
            'roles', 
            'menuName', 
            'menuUrl', 
            'roleId', 
            'employeeId',
            'customizations'
        ));
    }

    /**
     * Get all available menus
     */
    private function getAllMenus(): array
    {
        return [
            ['name' => 'Dashboard', 'url' => 'admin/dashboard', 'icon' => 'fas fa-gauge-high'],
            ['name' => 'Leads Generation', 'url' => 'leads', 'icon' => 'fas fa-chart-line'],
            ['name' => 'Categories', 'url' => 'categories', 'icon' => 'fas fa-layer-group'],
            ['name' => 'Employees', 'url' => 'employees', 'icon' => 'fas fa-user-tie'],
            ['name' => 'Customers', 'url' => 'customers', 'icon' => 'fas fa-users'],
            ['name' => 'Quotations', 'url' => 'quotations', 'icon' => 'fas fa-file-invoice'],
            ['name' => 'Invoices', 'url' => 'invoices', 'icon' => 'fas fa-file-invoice'],
            ['name' => 'Account', 'url' => 'accounts', 'icon' => 'fas fa-user-check'],
            ['name' => 'Project Updates', 'url' => 'project-updates', 'icon' => 'fas fa-project-diagram'],
            ['name' => 'Approval Status', 'url' => 'approval-status', 'icon' => 'fas fa-check-circle'],
            ['name' => 'Sales Department', 'url' => 'sales-department', 'icon' => 'fas fa-chart-line'],
            ['name' => 'Menu Controller', 'url' => 'menu-controller', 'icon' => 'fas fa-cogs'],
        ];
    }

    /**
     * Get all roles
     */
    private function getAllRoles(): array
    {
        return [
            ['id' => 1, 'name' => 'Admin'],
            ['id' => 2, 'name' => 'Employee'],
            ['id' => 3, 'name' => 'Customer'],
            ['id' => 4, 'name' => 'Manager'],
            ['id' => 5, 'name' => 'Super Admin'],
        ];
    }

    /**
     * Get users for selected role
     */
    public function getUsersForRole(Request $request): \Illuminate\Http\JsonResponse
    {
        $roleId = $request->get('role_id');
        
        if (!$roleId) {
            return response()->json(['users' => []]);
        }

        $users = User::where('role', $roleId)
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return response()->json(['users' => $users]);
    }

    /**
     * Analyze page and get all customizable elements
     */
    public function analyzePage(Request $request): \Illuminate\Http\JsonResponse
    {
        $menuName = $request->get('menu_name');
        $menuUrl = $request->get('menu_url');

        if (!$menuName || !$menuUrl) {
            return response()->json([
                'success' => false,
                'message' => 'Menu name and URL required'
            ], 400);
        }

        // Get page elements based on menu type
        $elements = $this->getPageElements($menuName, $menuUrl);
        
        // Transform elements to match expected JavaScript structure
        $structuredElements = [
            'tables' => [],
            'columns' => [],
            'buttons' => [],
            'forms' => [],
            'fields' => [],
            'links' => [],
            'images' => [],
            'text' => [],
            'containers' => [],
            'cards' => [],
            'navigation' => []
        ];
        
        foreach ($elements as $element) {
            switch ($element['type']) {
                case 'table':
                    $structuredElements['tables'][] = [
                        'name' => $element['name'],
                        'id' => $element['id'],
                        'columns' => ['ID', 'Name', 'Email', 'Actions'] // Default columns
                    ];
                    break;
                case 'column':
                    $structuredElements['columns'][] = [
                        'name' => $element['name'],
                        'table' => 'main-table',
                        'type' => 'text'
                    ];
                    break;
                case 'button':
                    $structuredElements['buttons'][] = [
                        'name' => $element['name'],
                        'id' => $element['id'],
                        'type' => 'primary',
                        'purpose' => $element['category'] ?? 'Action'
                    ];
                    break;
                case 'input':
                case 'field':
                    $structuredElements['fields'][] = [
                        'name' => $element['name'],
                        'id' => $element['id'],
                        'type' => 'text',
                        'required' => false
                    ];
                    break;
                default:
                    // Add to appropriate category or skip
                    break;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Page analyzed successfully',
            'data' => $structuredElements
        ]);
    }

    /**
     * Get customizable elements for a page
     */
    private function getPageElements(string $menuName, string $menuUrl): array
    {
        $elements = [];

        switch ($menuUrl) {
            case 'admin/dashboard':
                $elements = $this->getDashboardElements();
                break;
            case 'employees':
                $elements = $this->getEmployeesElements();
                break;
            case 'customers':
                $elements = $this->getCustomersElements();
                break;
            case 'leads':
                $elements = $this->getLeadsElements();
                break;
            case 'categories':
                $elements = $this->getCategoriesElements();
                break;
            case 'quotations':
                $elements = $this->getQuotationsElements();
                break;
            case 'invoices':
                $elements = $this->getInvoicesElements();
                break;
            case 'accounts':
                $elements = $this->getAccountsElements();
                break;
            case 'project-updates':
                $elements = $this->getProjectUpdatesElements();
                break;
            case 'approval-status':
                $elements = $this->getApprovalStatusElements();
                break;
            case 'sales-department':
                $elements = $this->getSalesDepartmentElements();
                break;
            case 'menu-controller':
                $elements = $this->getMenuControllerElements();
                break;
            default:
                $elements = $this->getGenericElements($menuName, $menuUrl);
                break;
        }

        return $elements;
    }

    /**
     * Get dashboard elements
     */
    private function getDashboardElements(): array
    {
        return [
            [
                'id' => 'dashboard_stats_cards',
                'name' => 'Statistics Cards',
                'type' => 'section',
                'category' => 'content',
                'default_visible' => true,
                'description' => 'Dashboard statistics cards section'
            ],
            [
                'id' => 'dashboard_charts',
                'name' => 'Charts Section',
                'type' => 'section',
                'category' => 'content',
                'default_visible' => true,
                'description' => 'Dashboard charts and graphs'
            ],
            [
                'id' => 'dashboard_recent_activities',
                'name' => 'Recent Activities',
                'type' => 'section',
                'category' => 'content',
                'default_visible' => true,
                'description' => 'Recent activities list'
            ],
            [
                'id' => 'dashboard_quick_actions',
                'name' => 'Quick Actions',
                'type' => 'section',
                'category' => 'content',
                'default_visible' => true,
                'description' => 'Quick action buttons'
            ]
        ];
    }

    /**
     * Get employees page elements
     */
    private function getEmployeesElements(): array
    {
        return [
            [
                'id' => 'employees_add_button',
                'name' => 'Add Employee Button',
                'type' => 'button',
                'category' => 'actions',
                'default_visible' => true,
                'description' => 'Add new employee button'
            ],
            [
                'id' => 'employees_search_field',
                'name' => 'Search Field',
                'type' => 'input',
                'category' => 'filters',
                'default_visible' => true,
                'description' => 'Employee search input field'
            ],
            [
                'id' => 'employees_table',
                'name' => 'Employees Table',
                'type' => 'table',
                'category' => 'content',
                'default_visible' => true,
                'description' => 'Main employees data table'
            ],
            [
                'id' => 'employees_edit_button',
                'name' => 'Edit Button',
                'type' => 'button',
                'category' => 'table_actions',
                'default_visible' => true,
                'description' => 'Edit employee action button'
            ],
            [
                'id' => 'employees_delete_button',
                'name' => 'Delete Button',
                'type' => 'button',
                'category' => 'table_actions',
                'default_visible' => true,
                'description' => 'Delete employee action button'
            ],
            [
                'id' => 'employees_name_column',
                'name' => 'Name Column',
                'type' => 'column',
                'category' => 'table_columns',
                'default_visible' => true,
                'description' => 'Employee name table column'
            ],
            [
                'id' => 'employees_email_column',
                'name' => 'Email Column',
                'type' => 'column',
                'category' => 'table_columns',
                'default_visible' => true,
                'description' => 'Employee email table column'
            ],
            [
                'id' => 'employees_role_column',
                'name' => 'Role Column',
                'type' => 'column',
                'category' => 'table_columns',
                'default_visible' => true,
                'description' => 'Employee role table column'
            ],
            [
                'id' => 'employees_department_column',
                'name' => 'Department Column',
                'type' => 'column',
                'category' => 'table_columns',
                'default_visible' => true,
                'description' => 'Employee department table column'
            ]
        ];
    }

    /**
     * Get customers page elements
     */
    private function getCustomersElements(): array
    {
        return [
            [
                'id' => 'customers_add_button',
                'name' => 'Add Customer Button',
                'type' => 'button',
                'category' => 'actions',
                'default_visible' => true,
                'description' => 'Add new customer button'
            ],
            [
                'id' => 'customers_search_field',
                'name' => 'Search Field',
                'type' => 'input',
                'category' => 'filters',
                'default_visible' => true,
                'description' => 'Customer search input field'
            ],
            [
                'id' => 'customers_table',
                'name' => 'Customers Table',
                'type' => 'table',
                'category' => 'content',
                'default_visible' => true,
                'description' => 'Main customers data table'
            ],
            [
                'id' => 'customers_name_column',
                'name' => 'Name Column',
                'type' => 'column',
                'category' => 'table_columns',
                'default_visible' => true,
                'description' => 'Customer name table column'
            ],
            [
                'id' => 'customers_email_column',
                'name' => 'Email Column',
                'type' => 'column',
                'category' => 'table_columns',
                'default_visible' => true,
                'description' => 'Customer email table column'
            ],
            [
                'id' => 'customers_phone_column',
                'name' => 'Phone Column',
                'type' => 'column',
                'category' => 'table_columns',
                'default_visible' => true,
                'description' => 'Customer phone table column'
            ]
        ];
    }

    /**
     * Get generic elements for unknown pages
     */
    private function getGenericElements(string $menuName, string $menuUrl): array
    {
        return [
            [
                'id' => $menuUrl . '_add_button',
                'name' => 'Add Button',
                'type' => 'button',
                'category' => 'actions',
                'default_visible' => true,
                'description' => 'Add new item button'
            ],
            [
                'id' => $menuUrl . '_search_field',
                'name' => 'Search Field',
                'type' => 'input',
                'category' => 'filters',
                'default_visible' => true,
                'description' => 'Search input field'
            ],
            [
                'id' => $menuUrl . '_table',
                'name' => 'Data Table',
                'type' => 'table',
                'category' => 'content',
                'default_visible' => true,
                'description' => 'Main data table'
            ],
            [
                'id' => $menuUrl . '_edit_button',
                'name' => 'Edit Button',
                'type' => 'button',
                'category' => 'table_actions',
                'default_visible' => true,
                'description' => 'Edit action button'
            ],
            [
                'id' => $menuUrl . '_delete_button',
                'name' => 'Delete Button',
                'type' => 'button',
                'category' => 'table_actions',
                'default_visible' => true,
                'description' => 'Delete action button'
            ]
        ];
    }

    /**
     * Get existing customizations
     */
    public function getCustomizations(Request $request): \Illuminate\Http\JsonResponse
    {
        $menuName = $request->get('menu_name');
        $roleId = $request->get('role_id');
        $employeeId = $request->get('employee_id');

        $query = PageCustomization::where('menu_name', $menuName);

        if ($roleId && $roleId !== '') {
            $query->where('role_id', $roleId);
        }

        if ($employeeId && $employeeId !== '') {
            $query->where('employee_id', $employeeId);
        }

        $customizations = $query->get();

        return response()->json(['customizations' => $customizations]);
    }

    /**
     * Update single element visibility
     */
    public function updateSingle(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $menuName = $request->get('menu_name');
            $menuUrl = $request->get('menu_url');
            $roleId = $request->get('role_id');
            $employeeId = $request->get('employee_id');
            $elementIdentifier = $request->get('element_identifier');
            $elementType = $request->get('element_type');
            $elementName = $request->get('element_name');
            $isVisible = $request->get('is_visible');

            // Find existing customization or create new one
            $customization = PageCustomization::where('menu_name', $menuName)
                ->where('element_identifier', $elementIdentifier);

            if ($roleId && $roleId !== '') {
                $customization->where('role_id', $roleId);
            }

            if ($employeeId && $employeeId !== '') {
                $customization->where('employee_id', $employeeId);
            }

            $customization = $customization->first();

            if ($customization) {
                // Update existing record
                $customization->update([
                    'is_visible' => $isVisible ? 1 : 0,
                    'updated_at' => now()
                ]);
            } else {
                // Create new record
                PageCustomization::create([
                    'menu_name' => $menuName,
                    'menu_url' => $menuUrl,
                    'element_identifier' => $elementIdentifier,
                    'element_name' => $elementName ?? '',
                    'role_id' => $roleId ?: null,
                    'employee_id' => $employeeId ?: null,
                    'is_visible' => $isVisible ? 1 : 0,
                    'element_type' => $elementType ?? 'field',
                    'element_category' => 'general',
                    'created_by' => auth()->id(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Element visibility updated successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating single element: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating element: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Batch update visibility for multiple elements
     */
    public function batchUpdate(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $items = $request->get('items', []);
            
            foreach ($items as $item) {
                $customization = PageCustomization::find($item['id']);
                if ($customization) {
                    $customization->is_visible = $item['is_visible'];
                    $customization->save();
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Visibility updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in batch update: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating visibility: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a specific customization
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            $customization = PageCustomization::find($id);
            
            if (!$customization) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customization not found'
                ], 404);
            }
            
            $customization->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Customization deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting customization: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting customization: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save customizations
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $menuName = $request->get('menu_name');
            $menuUrl = $request->get('menu_url');
            $roleId = $request->get('role_id');
            $employeeId = $request->get('employee_id');
            $elements = $request->get('elements', []);

            // Delete existing customizations for this combination
            $query = PageCustomization::where('menu_name', $menuName);
            
            if ($roleId && $roleId !== '') {
                $query->where('role_id', $roleId);
            }
            
            if ($employeeId && $employeeId !== '') {
                $query->where('employee_id', $employeeId);
            }
            
            $query->delete();

            // Save new customizations
            foreach ($elements as $element) {
                // Handle both array of objects and key-value pair formats
                if (is_array($element) && isset($element['identifier'])) {
                    // New format: array of objects from analyzedElements
                    PageCustomization::create([
                        'menu_name' => $menuName,
                        'menu_url' => $menuUrl,
                        'element_identifier' => $element['identifier'],
                        'element_name' => $element['name'] ?? '',
                        'role_id' => $roleId ?: null,
                        'employee_id' => $employeeId ?: null,
                        'is_visible' => $element['visible'] ? 1 : 0,
                        'element_type' => $element['type'] ?? 'field',
                        'element_category' => $element['category'] ?? 'general',
                        'created_by' => auth()->id(),
                    ]);
                } else {
                    // Legacy format: key-value pair
                    $elementId = is_string($element) ? $element : '';
                    $isVisible = is_bool($element) ? $element : true;
                    
                    if ($elementId) {
                        PageCustomization::create([
                            'menu_name' => $menuName,
                            'menu_url' => $menuUrl,
                            'element_identifier' => $elementId,
                            'role_id' => $roleId ?: null,
                            'employee_id' => $employeeId ?: null,
                            'is_visible' => $isVisible ? 1 : 0,
                            'element_type' => 'field',
                            'element_category' => 'general',
                            'created_by' => auth()->id(),
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Customizations saved successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error saving customizations: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error saving customizations: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset customizations
     */
    public function reset(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $menuName = $request->get('menu_name');
            $roleId = $request->get('role_id');
            $employeeId = $request->get('employee_id');

            // Delete existing customizations for this combination
            $query = PageCustomization::where('menu_name', $menuName);
            
            if ($roleId && $roleId !== '') {
                $query->where('role_id', $roleId);
            }
            
            if ($employeeId && $employeeId !== '') {
                $query->where('employee_id', $employeeId);
            }
            
            $query->delete();

            return response()->json([
                'success' => true,
                'message' => 'Customizations reset successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error resetting customizations: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error resetting customizations: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Apply customizations to frontend
     */
    public function applyCustomizations(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['hiddenElements' => []]);
        }

        $currentPath = $request->get('current_path', '');
        $menuName = $this->detectMenuFromPath($currentPath);

        // Get hidden elements with priority: User > Role > Global
        $hiddenElements = [];
        
        // User-specific customizations (highest priority)
        $userCustomizations = PageCustomization::where('menu_name', $menuName)
            ->where('employee_id', $user->id)
            ->where('is_visible', 0)
            ->pluck('element_identifier')
            ->toArray();
        
        // Role-specific customizations (medium priority)
        $roleCustomizations = PageCustomization::where('menu_name', $menuName)
            ->where('role_id', $user->role)
            ->whereNull('employee_id')
            ->where('is_visible', 0)
            ->pluck('element_identifier')
            ->toArray();
        
        // Global customizations (lowest priority)
        $globalCustomizations = PageCustomization::where('menu_name', $menuName)
            ->whereNull('role_id')
            ->whereNull('employee_id')
            ->where('is_visible', 0)
            ->pluck('element_identifier')
            ->toArray();

        $hiddenElements = array_merge($userCustomizations, $roleCustomizations, $globalCustomizations);
        $hiddenElements = array_unique($hiddenElements);

        return response()->json([
            'hiddenElements' => $hiddenElements,
            'menuName' => $menuName,
            'userRole' => $user->role,
            'userId' => $user->id
        ]);
    }

    /**
     * Detect menu name from URL path
     */
    private function detectMenuFromPath($path): string
    {
        $pathToMenu = [
            'admin/dashboard' => 'Dashboard',
            'leads' => 'Leads Generation',
            'categories' => 'Categories',
            'employees' => 'Employees',
            'customers' => 'Customers',
            'quotations' => 'Quotations',
            'invoices' => 'Invoices',
            'accounts' => 'Account',
            'project-updates' => 'Project Updates',
            'approval-status' => 'Approval Status',
            'sales-department' => 'Sales Department',
            'menu-controller' => 'Menu Controller',
        ];

        foreach ($pathToMenu as $pattern => $menuName) {
            if (strpos($path, $pattern) !== false) {
                return $menuName;
            }
        }
        
        return 'Unknown';
    }

    // Additional element methods for other pages...
    private function getLeadsElements(): array
    {
        return $this->getGenericElements('Leads Generation', 'leads');
    }

    private function getCategoriesElements(): array
    {
        return $this->getGenericElements('Categories', 'categories');
    }

    private function getQuotationsElements(): array
    {
        return $this->getGenericElements('Quotations', 'quotations');
    }

    private function getInvoicesElements(): array
    {
        return $this->getGenericElements('Invoices', 'invoices');
    }

    private function getAccountsElements(): array
    {
        return $this->getGenericElements('Account', 'accounts');
    }

    private function getProjectUpdatesElements(): array
    {
        return $this->getGenericElements('Project Updates', 'project-updates');
    }

    private function getApprovalStatusElements(): array
    {
        return $this->getGenericElements('Approval Status', 'approval-status');
    }

    private function getSalesDepartmentElements(): array
    {
        return $this->getGenericElements('Sales Department', 'sales-department');
    }

    private function getMenuControllerElements(): array
    {
        return $this->getGenericElements('Menu Controller', 'menu-controller');
    }
}
