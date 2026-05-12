<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'url',
        'ip_address',
        'user_agent',
        'session_id',
        'method',
        'controller',
        'function',
        'parameters',
        'duration',
        'status_code',
        'type',
        'level',
        'read_at',
    ];

    protected $casts = [
        'parameters' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that performed the activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an activity for the current user.
     */
    public static function logActivity($action, $description = null, $type = 'general', $level = 'info', $additionalData = [])
    {
        if (!Auth::check()) {
            return null;
        }

        $user = Auth::user();
        $request = request();

        $data = array_merge([
            'user_id' => $user->id,
            'action' => $action,
            'description' => $description ?: self::generateDescription($action),
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'session_id' => $request->session()->getId(),
            'method' => $request->method(),
            'type' => $type,
            'level' => $level,
        ], $additionalData);

        return self::create($data);
    }

    /**
     * Generate a description based on the action.
     */
    private static function generateDescription($action)
    {
        $descriptions = [
            'login' => 'You successfully logged into the system',
            'logout' => 'You logged out of the system',
            'profile_view' => 'You viewed your profile information',
            'profile_update' => 'You updated your profile details',
            'password_change' => 'You changed your password',
            'dashboard_view' => 'You opened the main dashboard',
            'logs_view' => 'You opened the activity logs page',
            'ticket_create' => 'You created a new support ticket',
            'ticket_update' => 'You updated a support ticket',
            'ticket_view' => 'You viewed a support ticket',
            'ticket_delete' => 'You deleted a support ticket',
            'customer_create' => 'You added a new customer to the system',
            'customer_update' => 'You updated customer information',
            'customer_view' => 'You viewed customer details',
            'customer_delete' => 'You removed a customer from the system',
            'employee_create' => 'You added a new employee to the team',
            'employee_update' => 'You updated employee information',
            'employee_view' => 'You viewed employee details',
            'employee_delete' => 'You removed an employee from the system',
            'department_view' => 'You viewed the department list',
            'department_create' => 'You created a new department',
            'department_update' => 'You updated department information',
            'department_delete' => 'You deleted a department',
            'file_upload' => 'You uploaded a file to the system',
            'file_download' => 'You downloaded a file',
            'file_delete' => 'You deleted a file',
            'export_data' => 'You exported data from the system',
            'import_data' => 'You imported data into the system',
            'search' => 'You searched for information',
            'filter' => 'You applied filters to view specific results',
            'page_view' => 'You visited a page',
            'click' => 'You clicked on a button or link',
            'form_submit' => 'You submitted a form',
            'ajax_request' => 'The system processed your request',
            'api_call' => 'You made a request to the system',
        ];

        return $descriptions[$action] ?? "You performed an action: " . ucfirst(str_replace('_', ' ', $action));
    }

    /**
     * Get activities for a specific user.
     */
    public static function getUserActivities($userId = null, $limit = 50)
    {
        $query = self::with('user')
            ->orderBy('created_at', 'desc');

        if ($userId) {
            $query->where('user_id', $userId);
        } elseif (Auth::check()) {
            $query->where('user_id', Auth::id());
        }

        return $query->limit($limit)->get();
    }

    /**
     * Get recent activities for the current user.
     */
    public static function getRecentActivities($limit = 20)
    {
        return self::getUserActivities(null, $limit);
    }

    /**
     * Get formatted activity data for display.
     */
    public function getFormattedData()
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'level' => $this->level,
            'action' => $this->action,
            'title' => $this->getActionTitle(),
            'message' => $this->description,
            'details' => $this->getUserFriendlyDetails(),
            'timestamp' => $this->created_at->format('Y-m-d H:i:s'),
            'user_name' => $this->user->name,
            'user_role' => $this->getUserRoleName(),
            'icon' => $this->getActivityIcon(),
            'color' => $this->getActivityColor(),
            'url' => $this->url,
            'ip_address' => $this->ip_address,
            'duration' => $this->duration,
        ];
    }

    /**
     * Get a user-friendly action title.
     */
    private function getActionTitle()
    {
        $titles = [
            'login' => 'Login',
            'logout' => 'Logout',
            'profile_view' => 'Viewed Profile',
            'profile_update' => 'Updated Profile',
            'password_change' => 'Changed Password',
            'dashboard_view' => 'Dashboard',
            'logs_view' => 'Activity Logs',
            'ticket_create' => 'Created Ticket',
            'ticket_update' => 'Updated Ticket',
            'ticket_view' => 'Viewed Ticket',
            'ticket_delete' => 'Deleted Ticket',
            'customer_create' => 'Added Customer',
            'customer_update' => 'Updated Customer',
            'customer_view' => 'Viewed Customer',
            'customer_delete' => 'Removed Customer',
            'employee_create' => 'Added Employee',
            'employee_update' => 'Updated Employee',
            'employee_view' => 'Viewed Employee',
            'employee_delete' => 'Removed Employee',
            'department_view' => 'Viewed Departments',
            'department_create' => 'Created Department',
            'department_update' => 'Updated Department',
            'department_delete' => 'Deleted Department',
            'file_upload' => 'Uploaded File',
            'file_download' => 'Downloaded File',
            'file_delete' => 'Deleted File',
            'export_data' => 'Exported Data',
            'import_data' => 'Imported Data',
            'search' => 'Searched',
            'filter' => 'Filtered Results',
            'page_view' => 'Page Visit',
            'click' => 'Clicked',
            'form_submit' => 'Submitted Form',
            'ajax_request' => 'System Request',
            'api_call' => 'System Action',
        ];

        return $titles[$this->action] ?? ucfirst(str_replace('_', ' ', $this->action));
    }

    /**
     * Get user-friendly details for the activity.
     */
    private function getUserFriendlyDetails()
    {
        $details = [];
        
        // Add duration in a friendly format
        if ($this->duration) {
            $details[] = $this->getFriendlyDuration($this->duration);
        }
        
        // Add status in a friendly format
        if ($this->status_code) {
            $details[] = $this->getFriendlyStatus($this->status_code);
        }
        
        // Add method in a friendly format
        if ($this->method) {
            $details[] = $this->getFriendlyMethod($this->method);
        }
        
        // Add controller/function in a simplified format
        if ($this->controller) {
            $details[] = "System module: " . $this->getSimplifiedController($this->controller);
            if ($this->function) {
                $details[] = "Action: " . $this->getSimplifiedFunction($this->function);
            }
        }
        
        // Add IP address in a friendly format
        if ($this->ip_address) {
            $details[] = "From: " . $this->ip_address;
        }
        
        // Add any parameters in a simplified format
        if ($this->parameters && !empty($this->parameters)) {
            $details[] = "Details: " . $this->getSimplifiedParameters($this->parameters);
        }
        
        return implode(' | ', $details);
    }

    /**
     * Get user-friendly duration format.
     */
    private function getFriendlyDuration($duration)
    {
        if ($duration < 100) {
            return "Very fast response (under 0.1 seconds)";
        } elseif ($duration < 500) {
            return "Quick response (" . round($duration) . " milliseconds)";
        } elseif ($duration < 1000) {
            return "Normal response (" . round($duration) . " milliseconds)";
        } elseif ($duration < 2000) {
            return "Slow response (" . round($duration/1000, 2) . " seconds)";
        } else {
            return "Very slow response (" . round($duration/1000, 2) . " seconds)";
        }
    }

    /**
     * Get user-friendly status format.
     */
    private function getFriendlyStatus($statusCode)
    {
        $statusMap = [
            200 => 'Success',
            201 => 'Created successfully',
            202 => 'Accepted',
            204 => 'No content',
            400 => 'Request error',
            401 => 'Not authorized',
            403 => 'Access denied',
            404 => 'Not found',
            422 => 'Invalid data',
            500 => 'System error',
            503 => 'System unavailable',
        ];

        return $statusMap[$statusCode] ?? "Status: {$statusCode}";
    }

    /**
     * Get user-friendly method format.
     */
    private function getFriendlyMethod($method)
    {
        $methodMap = [
            'GET' => 'Viewing information',
            'POST' => 'Submitting data',
            'PUT' => 'Updating information',
            'PATCH' => 'Modifying data',
            'DELETE' => 'Removing data',
        ];

        return $methodMap[$method] ?? "Request type: {$method}";
    }

    /**
     * Get simplified controller name.
     */
    private function getSimplifiedController($controller)
    {
        $controllerMap = [
            'LogsController' => 'Activity Logs',
            'DashboardController' => 'Dashboard',
            'ProfileController' => 'User Profile',
            'EmployeeController' => 'Employee Management',
            'CustomerController' => 'Customer Management',
            'TicketController' => 'Ticket System',
            'CategoryController' => 'Categories',
            'DepartmentController' => 'Departments',
            'InvoiceController' => 'Invoices',
            'NotificationController' => 'Notifications',
            'AuthController' => 'Authentication',
        ];

        return $controllerMap[$controller] ?? str_replace('Controller', '', $controller);
    }

    /**
     * Get simplified function name.
     */
    private function getSimplifiedFunction($function)
    {
        $functionMap = [
            'index' => 'Listing',
            'create' => 'Creation',
            'store' => 'Saving',
            'show' => 'Details',
            'edit' => 'Editing',
            'update' => 'Updating',
            'destroy' => 'Deleting',
            'login' => 'Login',
            'logout' => 'Logout',
        ];

        return $functionMap[$function] ?? ucfirst($function);
    }

    /**
     * Get simplified parameters.
     */
    private function getSimplifiedParameters($parameters)
    {
        if (empty($parameters)) {
            return 'No additional details';
        }

        $paramCount = count($parameters);
        if ($paramCount === 1) {
            $key = key($parameters);
            $value = $parameters[$key];
            return "With {$key}: " . $this->truncateValue($value);
        } elseif ($paramCount <= 3) {
            $paramStrings = [];
            foreach ($parameters as $key => $value) {
                $paramStrings[] = "{$key}: " . $this->truncateValue($value);
            }
            return 'With ' . implode(', ', $paramStrings);
        } else {
            return "With {$paramCount} items of information";
        }
    }

    /**
     * Truncate long values for display.
     */
    private function truncateValue($value)
    {
        if (is_string($value) && strlen($value) > 50) {
            return substr($value, 0, 47) . '...';
        }
        return (string) $value;
    }

    /**
     * Get the user role name.
     */
    private function getUserRoleName()
    {
        if (!$this->user) {
            return 'Unknown';
        }

        switch ($this->user->role) {
            case 1:
                return 'Admin';
            case 2:
                return 'Employee';
            case 3:
                return 'Customer';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get the activity icon based on type and action.
     */
    private function getActivityIcon()
    {
        $iconMap = [
            'login' => 'fa-sign-in-alt',
            'logout' => 'fa-sign-out-alt',
            'profile' => 'fa-user',
            'dashboard' => 'fa-tachometer-alt',
            'logs' => 'fa-history',
            'ticket' => 'fa-ticket-alt',
            'customer' => 'fa-users',
            'employee' => 'fa-user-tie',
            'department' => 'fa-building',
            'file' => 'fa-file',
            'search' => 'fa-search',
            'export' => 'fa-download',
            'import' => 'fa-upload',
            'click' => 'fa-mouse-pointer',
            'form' => 'fa-edit',
            'api' => 'fa-code',
        ];

        foreach ($iconMap as $key => $icon) {
            if (strpos($this->action, $key) !== false) {
                return $icon;
            }
        }

        return 'fa-circle';
    }

    /**
     * Get the activity color based on level and type.
     */
    private function getActivityColor()
    {
        $colorMap = [
            'error' => 'danger',
            'warning' => 'warning',
            'success' => 'success',
            'info' => 'info',
            'debug' => 'secondary',
        ];

        if (isset($colorMap[$this->level])) {
            return $colorMap[$this->level];
        }

        // Default colors based on action type
        if (strpos($this->action, 'delete') !== false) {
            return 'danger';
        } elseif (strpos($this->action, 'create') !== false || strpos($this->action, 'add') !== false) {
            return 'success';
        } elseif (strpos($this->action, 'update') !== false || strpos($this->action, 'edit') !== false) {
            return 'warning';
        } elseif (strpos($this->action, 'view') !== false) {
            return 'info';
        }

        return 'primary';
    }
}
