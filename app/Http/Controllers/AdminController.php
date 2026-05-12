<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Models\User;
use App\Models\EmployeeTask;

class AdminController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        return view('employee.login');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:Employee,Admin',
        ]);

        try {
            // Set role based on position
            $roleValue = $request->role === 'Admin' ? 1 : 2;
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'position' => $request->role,
                'role' => $roleValue,
            ]);

            // Auto login after registration
            Auth::login($user);

            // Set remember cookie if requested
            if ($request->remember) {
                $rememberToken = \Str::random(60);
                cookie()->queue('employee_remember', $rememberToken, 43200); // 30 days
            }

            return redirect()->route($request->role === 'Admin' ? 'admin.dashboard' : 'employee.dashboard')
                ->with('success', 'Account created successfully!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['registration' => 'Registration failed. Please try again.']);
        }
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        // Check if user is admin
        if (Auth::user()->role !== 1) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Access denied. Admin privileges required.');
        }

        // Get all employees
        $employees = User::where('role', 2)->get();
        
        // Get all tasks with employee relationships
        $allTasks = EmployeeTask::with('user')->orderBy('created_at', 'desc')->get();
        
        // Statistics
        $totalTasks = $allTasks->count();
        $completedTasks = $allTasks->where('status', 'completed')->count();
        $pendingTasks = $allTasks->where('status', 'pending')->count();
        $inProgressTasks = $allTasks->where('status', 'in_progress')->count();
        
        // Tasks by employee
        $tasksByEmployee = [];
        foreach ($employees as $employee) {
            $employeeTasks = $allTasks->where('user_id', $employee->id);
            $tasksByEmployee[] = [
                'employee' => $employee,
                'tasks' => $employeeTasks,
                'task_count' => $employeeTasks->count(),
                'completed_count' => $employeeTasks->where('status', 'completed')->count(),
                'pending_count' => $employeeTasks->where('status', 'pending')->count(),
            ];
        }

        return view('admin.dashboard', compact(
            'employees',
            'allTasks',
            'tasksByEmployee',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'inProgressTasks'
        ));
    }

    /**
     * Get filtered tasks for admin
     */
    public function getFilteredTasks(Request $request)
    {
        if (Auth::user()->role !== 1) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $query = EmployeeTask::with('user');

        // Filter by employee
        if ($request->employee_id) {
            $query->where('user_id', $request->employee_id);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->date_from) {
            $query->whereDate('task_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('task_date', '<=', $request->date_to);
        }

        // Filter by date range (single date)
        if ($request->date) {
            $query->whereDate('task_date', $request->date);
        }

        $tasks = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'tasks' => $tasks,
            'total' => $tasks->count()
        ]);
    }

    /**
     * Delete any task (admin only)
     */
    public function deleteTask($id)
    {
        if (Auth::user()->role !== 1) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $task = EmployeeTask::findOrFail($id);
        
        try {
            $task->delete();
            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get task details for editing (admin only)
     */
    public function editTask($id)
    {
        if (Auth::user()->role !== 1) {
            return response()->json(['success' => false, 'error' => 'Access denied'], 403);
        }

        try {
            $task = EmployeeTask::with('user')->findOrFail($id);
            
            // Format the date for datetime-local input (YYYY-MM-DDTHH:MM format)
            $task->task_date = $task->task_date->format('Y-m-d\TH:i');
            
            return response()->json([
                'success' => true,
                'task' => $task
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Task not found: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update any task (admin only)
     */
    public function updateTask(Request $request, $id)
    {
        if (Auth::user()->role !== 1) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $request->validate([
            'task_date' => 'required|date',
            'task_description' => 'required|string',
            'client_project_name' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed,stopped,on_hold'
        ]);

        $task = EmployeeTask::findOrFail($id);
        
        try {
            $task->update([
                'task_date' => $request->task_date,
                'task_description' => $request->task_description,
                'client_project_name' => $request->client_project_name,
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
