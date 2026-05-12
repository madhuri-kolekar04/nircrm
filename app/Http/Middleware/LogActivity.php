<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use Carbon\Carbon;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $startTime = microtime(true);
        $response = $next($request);
        $endTime = microtime(true);

        $duration = round(($endTime - $startTime) * 1000); // Convert to milliseconds

        // Log the activity
        $this->logRequestActivity($request, $response, $duration);

        return $response;
    }

    /**
     * Log the request activity.
     */
    private function logRequestActivity(Request $request, $response, $duration)
    {
        $user = Auth::user();
        $route = $request->route();
        
        if (!$route) {
            return;
        }

        $routeName = $route->getName();
        $action = $this->getActionFromRoute($routeName, $request);
        $description = $this->getDescriptionFromRoute($routeName, $request);
        $type = $this->getTypeFromRoute($routeName);
        $level = $this->getLevelFromResponse($response);

        // Skip logging for certain routes to avoid noise
        if ($this->shouldSkipLogging($routeName, $request)) {
            return;
        }

        $additionalData = [
            'controller' => $this->getControllerName($route),
            'function' => $this->getFunctionName($route),
            'parameters' => $this->getRouteParameters($route),
            'duration' => $duration,
            'status_code' => $response->getStatusCode(),
        ];

        ActivityLog::logActivity($action, $description, $type, $level, $additionalData);
    }

    /**
     * Get action from route name.
     */
    private function getActionFromRoute($routeName, Request $request)
    {
        $actionMap = [
            'dashboard' => 'dashboard_view',
            'logs' => 'logs_view',
            'admin.profile' => 'profile_view',
            'admin.change.password' => 'password_change_view',
            'employees.index' => 'employee_view',
            'employees.create' => 'employee_create',
            'employees.store' => 'employee_create',
            'employees.edit' => 'employee_edit',
            'employees.update' => 'employee_update',
            'employees.destroy' => 'employee_delete',
            'customers.index' => 'customer_view',
            'customers.create' => 'customer_create',
            'customers.store' => 'customer_create',
            'customers.edit' => 'customer_edit',
            'customers.update' => 'customer_update',
            'customers.destroy' => 'customer_delete',
            'all.category' => 'category_view',
            'category.store' => 'category_create',
            'category.edit' => 'category_edit',
            'category.update' => 'category_update',
            'category.delete' => 'category_delete',
            'all.subcategory' => 'subcategory_view',
            'subcategory.store' => 'subcategory_create',
            'subcategory.edit' => 'subcategory_edit',
            'subcategory.update' => 'subcategory_update',
            'subcategory.delete' => 'subcategory_delete',
            'add-product' => 'ticket_create',
            'product-store' => 'ticket_create',
            'product-storeuser' => 'ticket_create',
            'manage-product' => 'ticket_view',
            'my-manage-product' => 'ticket_view',
            'product.edit' => 'ticket_edit',
            'product.update' => 'ticket_update',
            'product.editemp' => 'ticket_edit',
            'product.updateemp' => 'ticket_update',
            'product.delete' => 'ticket_delete',
            'project-updates.index' => 'notification_view',
            'project-updates.show' => 'notification_view',
            'project-updates.store' => 'notification_create',
            'invoices.index' => 'invoice_view',
            'invoices.create' => 'invoice_create',
            'invoices.store' => 'invoice_create',
            'invoices.edit' => 'invoice_edit',
            'invoices.update' => 'invoice_update',
            'invoices.destroy' => 'invoice_delete',
            'login' => 'login',
            'logout' => 'logout',
            'profile.edit' => 'profile_view',
            'profile.update' => 'profile_update',
        ];

        // Check if it's a POST/PUT/DELETE request
        $method = $request->method();
        if ($method === 'POST') {
            if (strpos($routeName, 'store') !== false) {
                return str_replace('store', 'create', $actionMap[$routeName] ?? 'create');
            }
        } elseif ($method === 'PUT' || $method === 'PATCH') {
            if (strpos($routeName, 'update') !== false) {
                return str_replace('update', 'edit', $actionMap[$routeName] ?? 'update');
            }
        } elseif ($method === 'DELETE') {
            if (strpos($routeName, 'delete') !== false || strpos($routeName, 'destroy') !== false) {
                return str_replace(['delete', 'destroy'], 'delete', $actionMap[$routeName] ?? 'delete');
            }
        }

        return $actionMap[$routeName] ?? 'page_view';
    }

    /**
     * Get description from route name.
     */
    private function getDescriptionFromRoute($routeName, Request $request)
    {
        $method = $request->method();
        
        $descMap = [
            'dashboard' => 'You opened the main dashboard',
            'logs' => 'You opened the activity logs page',
            'admin.profile' => 'You viewed your profile information',
            'admin.change.password' => 'You went to the password change page',
            'employees.index' => 'You viewed the employee list',
            'employees.create' => 'You opened the employee creation page',
            'employees.store' => 'You successfully added a new employee',
            'employees.edit' => 'You edited employee details',
            'employees.update' => 'You successfully updated employee information',
            'employees.destroy' => 'You successfully removed an employee',
            'customers.index' => 'You viewed the customer list',
            'customers.create' => 'You opened the customer creation page',
            'customers.store' => 'You successfully added a new customer',
            'customers.edit' => 'You edited customer details',
            'customers.update' => 'You successfully updated customer information',
            'customers.destroy' => 'You successfully removed a customer',
            'all.category' => 'You viewed the category list',
            'category.store' => 'You successfully created a new category',
            'category.edit' => 'You edited category details',
            'category.update' => 'You successfully updated category information',
            'category.delete' => 'You successfully deleted a category',
            'all.subcategory' => 'You viewed the subcategory list',
            'subcategory.store' => 'You successfully created a new subcategory',
            'subcategory.edit' => 'You edited subcategory details',
            'subcategory.update' => 'You successfully updated subcategory information',
            'subcategory.delete' => 'You successfully deleted a subcategory',
            'add-product' => 'You opened the ticket creation page',
            'product-store' => 'You successfully created a new support ticket',
            'product-storeuser' => 'You successfully created a new support ticket',
            'manage-product' => 'You viewed the ticket list',
            'my-manage-product' => 'You viewed your assigned tickets',
            'product.edit' => 'You edited ticket details',
            'product.update' => 'You successfully updated ticket information',
            'product.editemp' => 'You edited ticket details',
            'product.updateemp' => 'You successfully updated ticket information',
            'product.delete' => 'You successfully deleted a ticket',
            'project-updates.index' => 'You viewed your notifications',
            'project-updates.show' => 'You viewed notification details',
            'project-updates.store' => 'You created a new notification',
            'invoices.index' => 'You viewed the invoice list',
            'invoices.create' => 'You opened the invoice creation page',
            'invoices.store' => 'You successfully created a new invoice',
            'invoices.edit' => 'You edited invoice details',
            'invoices.update' => 'You successfully updated invoice information',
            'invoices.destroy' => 'You successfully deleted an invoice',
            'login' => 'You successfully logged into the system',
            'logout' => 'You logged out of the system',
            'profile.edit' => 'You viewed your profile information',
            'profile.update' => 'You successfully updated your profile information',
        ];

        // Adjust description based on HTTP method
        if ($method === 'POST') {
            if (isset($descMap[$routeName]) && strpos($descMap[$routeName], 'opened') !== false) {
                return str_replace('opened', 'added', $descMap[$routeName]);
            } elseif (isset($descMap[$routeName]) && strpos($descMap[$routeName], 'viewed') !== false) {
                return str_replace('viewed', 'created', $descMap[$routeName]);
            }
        } elseif ($method === 'PUT' || $method === 'PATCH') {
            if (isset($descMap[$routeName]) && strpos($descMap[$routeName], 'opened') !== false) {
                return str_replace('opened', 'updated', $descMap[$routeName]);
            } elseif (isset($descMap[$routeName]) && strpos($descMap[$routeName], 'viewed') !== false) {
                return str_replace('viewed', 'updated', $descMap[$routeName]);
            }
        } elseif ($method === 'DELETE') {
            if (isset($descMap[$routeName])) {
                return str_replace(['opened', 'viewed', 'added', 'updated', 'created', 'successfully'], '', $descMap[$routeName]);
            }
        }

        return $descMap[$routeName] ?? "You accessed the {$routeName} page";
    }

    /**
     * Get type from route name.
     */
    private function getTypeFromRoute($routeName)
    {
        $typeMap = [
            'dashboard' => 'navigation',
            'logs' => 'navigation',
            'admin.profile' => 'navigation',
            'admin.change.password' => 'navigation',
            'employees' => 'employee',
            'customers' => 'customer',
            'category' => 'category',
            'subcategory' => 'category',
            'product' => 'ticket',
            'project-updates' => 'notification',
            'invoices' => 'invoice',
            'login' => 'auth',
            'logout' => 'auth',
            'profile' => 'profile',
        ];

        foreach ($typeMap as $key => $type) {
            if (strpos($routeName, $key) !== false) {
                return $type;
            }
        }

        return 'general';
    }

    /**
     * Get level from response status code.
     */
    private function getLevelFromResponse($response)
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 500) {
            return 'error';
        } elseif ($statusCode >= 400) {
            return 'warning';
        } elseif ($statusCode >= 300) {
            return 'info';
        } else {
            return 'success';
        }
    }

    /**
     * Check if we should skip logging for this route.
     */
    private function shouldSkipLogging($routeName, Request $request)
    {
        $skipRoutes = [
            'logs.api',
            'logs.activity',
            'logs.stats',
            'logs.realtime',
            'notifications.index',
            'notifications.read',
            'notifications.read-all',
        ];

        // Skip AJAX routes that generate too much noise
        if (in_array($routeName, $skipRoutes)) {
            return true;
        }

        // Skip asset requests
        if ($request->is('assets/*') || $request->is('css/*') || $request->is('js/*')) {
            return true;
        }

        // Skip if it's an AJAX request to certain endpoints
        if ($request->ajax() && $request->is(['api/*', 'ajax/*'])) {
            return true;
        }

        return false;
    }

    /**
     * Get controller name from route.
     */
    private function getControllerName($route)
    {
        $action = $route->getActionName();
        if ($action) {
            $parts = explode('@', $action);
            return class_basename($parts[0]);
        }
        return null;
    }

    /**
     * Get function name from route.
     */
    private function getFunctionName($route)
    {
        $action = $route->getActionName();
        if ($action) {
            $parts = explode('@', $action);
            return $parts[1] ?? null;
        }
        return null;
    }

    /**
     * Get route parameters.
     */
    private function getRouteParameters($route)
    {
        return $route->parameters();
    }
}
