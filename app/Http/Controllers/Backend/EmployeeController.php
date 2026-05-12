<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\ApprovalStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    // New employee management methods
    public function index()
    {
        // Get all employees - no role restrictions
        $employees = User::latest()->paginate(10);
        
        return view('admin.employees.index', compact('employees'));
    }
    
    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'department' => 'required|exists:departments,id',
            'position' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'employeeID' => 'nullable|string|max:50',
        ]);

        try {
            // Generate 6-digit OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $otpExpiresAt = now()->addMinutes(15); // OTP expires in 15 minutes

            // Create user with OTP
            $department = Department::find($request->department);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'department_id' => $request->department,
                'department' => $department ? $department->department ?? $department->name : null,
                'position' => $request->position,
                'contact_number' => $request->contact_number,
                'employeeID' => $request->employeeID,
                'role' => 2, // Default to Employee role
                'otp' => $otp,
                'otp_expires_at' => $otpExpiresAt,
                'is_verified' => false,
            ]);

            // Send OTP email
            try {
                Mail::raw("Your OTP for employee verification is: {$otp}\n\nThis OTP will expire in 15 minutes.", function($message) use ($request) {
                    $message->to($request->email)
                           ->subject('Employee Verification OTP - Niranjan Enterprises');
                });
            } catch (\Exception $mailException) {
                \Log::error('Failed to send OTP email: ' . $mailException->getMessage());
                // Continue with user creation even if email fails
            }

            // Store user email in session for verification page
            session(['employee_email_for_verification' => $request->email]);

            return redirect()->route('employees.verify')
                ->with('success', 'Employee created successfully. Please check your email for OTP verification.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating employee: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        // Use Department model to get actual departments
        $departments = Department::all();
        
        return view('admin.employees.create', compact('departments'));
    }
    
    /**
     * Show the form for editing the specified employee.
     */
    public function edit($id)
    {
        $employee = User::findOrFail($id);
        $departments = Department::all();
        
        return view('admin.employees.edit', compact('employee', 'departments'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'department' => 'required|exists:departments,id',
            'position' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'employeeID' => 'nullable|string|max:50',
        ]);

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'department_id' => $request->department,
                'position' => $request->position,
                'contact_number' => $request->contact_number,
                'employeeID' => $request->employeeID,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $employee->update($updateData);

            return redirect()->route('employees.index')
                ->with('success', 'Employee updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating employee: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy($id)
    {
        try {
            $employee = User::findOrFail($id);
            $employee->delete();

            return redirect()->route('employees.index')
                ->with('success', 'Employee deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->route('employees.index')
                ->with('error', 'Error deleting employee: ' . $e->getMessage());
        }
    }

    /**
     * Show employee verification page.
     */
    public function verify()
    {
        $email = session('employee_email_for_verification');
        $employeeData = [];
        
        if ($email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                // Get department name properly - handle both accessor and direct field
                $departmentName = 'N/A';
                if ($user->department_id) {
                    $dept = $user->department()->first();
                    $departmentName = $dept ? ($dept->department ?? $dept->name ?? 'N/A') : 'N/A';
                } elseif (isset($user->attributes['department'])) {
                    $departmentName = $user->attributes['department'];
                }
                
                $employeeData = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->contact_number,
                    'department' => $departmentName
                ];
            }
        }
        
        return view('admin.employees.verify', compact('employeeData'));
    }

    /**
     * Verify employee OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|digits:6',
        ]);

        try {
            $email = session('employee_email_for_verification');
            
            if (!$email) {
                return redirect()->route('employees.index')
                    ->with('error', 'Verification session expired. Please try again.');
            }

            $user = User::where('email', $email)
                        ->where('otp', $request->otp)
                        ->where('otp_expires_at', '>', now())
                        ->first();

            if (!$user) {
                return redirect()->back()
                    ->with('error', 'Invalid or expired OTP. Please try again.')
                    ->withInput();
            }

            // Mark user as verified and clear OTP
            $user->update([
                'is_verified' => true,
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            // Clear session
            session()->forget('employee_email_for_verification');

            return redirect()->route('employees.index')
                ->with('success', 'Employee verified and activated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error verifying OTP: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Resend OTP to employee.
     */
    public function resendOtp(Request $request)
    {
        try {
            $email = session('employee_email_for_verification');
            
            if (!$email) {
                return redirect()->route('employees.index')
                    ->with('error', 'No email found for OTP resend. Please try again.');
            }

            $user = User::where('email', $email)->first();
            
            if (!$user) {
                return redirect()->back()
                    ->with('error', 'Employee not found.');
            }

            // Generate new OTP
            $newOtp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $otpExpiresAt = now()->addMinutes(15);

            // Update user with new OTP
            $user->update([
                'otp' => $newOtp,
                'otp_expires_at' => $otpExpiresAt,
            ]);

            // Send new OTP email
            try {
                Mail::raw("Your new OTP for employee verification is: {$newOtp}\n\nThis OTP will expire in 15 minutes.", function($message) use ($email) {
                    $message->to($email)
                           ->subject('New OTP - Niranjan Enterprises');
                });

                return redirect()->back()
                    ->with('success', 'New OTP sent successfully to your email.');

            } catch (\Exception $mailException) {
                \Log::error('Failed to resend OTP email: ' . $mailException->getMessage());
                return redirect()->back()
                    ->with('error', 'Failed to send OTP email. Please try again later.');
            }

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error resending OTP: ' . $e->getMessage());
        }
    }

    /**
     * Get required approvals based on corporate hierarchy
     */
    private function getRequiredApprovals($requester, $target)
    {
        $approvals = [];

        // Get requester's role/position
        $requesterRole = $requester->role;
        $requesterPosition = $requester->position;

        // Define hierarchy: Admin > General Manager > Manager > Employee
        if (in_array($requesterRole, [1, 5])) {
            // Admin actions need General Manager and Manager approval
            $generalManagers = User::where('role', 1)
                ->where('position', 'General Manager')
                ->pluck('id')
                ->toArray();
            
            $managers = User::where('position', 'Manager')
                ->pluck('id')
                ->toArray();
            
            $approvals = array_merge($generalManagers, $managers);
        } elseif ($requesterPosition === 'General Manager') {
            // General Manager actions need Manager approval
            $managers = User::where('position', 'Manager')
                ->pluck('id')
                ->toArray();
            
            $approvals = $managers;
        } elseif ($requesterPosition === 'Manager') {
            // Manager actions need Admin approval
            $admins = User::whereIn('role', [1, 5])
                ->pluck('id')
                ->toArray();
            
            $approvals = $admins;
        } elseif ($requesterRole == 2) {
            // Employee actions need Manager and Admin approval
            $managers = User::where('position', 'Manager')
                ->pluck('id')
                ->toArray();
            
            $admins = User::whereIn('role', [1, 5])
                ->pluck('id')
                ->toArray();
            
            $approvals = array_merge($managers, $admins);
        }

        return array_unique($approvals);
    }

    // Existing methods from original controller
    public function EmployeeView(){
		$id = Auth::user()->id;
		$adminData = User::find($id);
		$Department = Department::latest()->get();
    	$Employee = User::latest()->where('role' , 3)->get();
    	return view('backend.Employee.employee_view',compact('Employee','Department','adminData'));
    }

    public function EmployeeAdd(){
		$Department = Department::latest()->get();
        return view('backend.Employee.employee_add' , compact('Department'));

    }
    public function EmployeeStore(Request $request){

       $request->validate([
    		'Employee_name' => 'required',
    	
			'Employee_id' =>'required',
			'Employee_email' =>'required',
			'designation' =>'required',
			'Employee_password' =>'required',
			'Employee_department' =>'required',
		
    	],[
    		'Employee_name.required' => 'Input Employee  Name',

			'Employee_id.required' => 'Input Employee ID ',
			'designation' =>'Input designation ID',
			'Employee_email.required' => 'Input Employee  Email',
			'Employee_password.required' => 'Input Employee  Password',
			'Employee_department.required' => 'Input Employee  Department',
    	]);

        // Get department name from ID
        $departmentName = Department::find($request->Employee_department)->department ?? $request->Employee_department;

        User::insert([
		'name' => $request->Employee_name,
		'last_name' => $request->Employee_last_name,
		'designation' =>  $request->input('designation'),
		'employeeID' => $request->Employee_id,
		'contact_number' => $request->Employee_contact,
		'email' => $request->Employee_email,
		'password' => Hash::make($request->Employee_password),
		'department' => $departmentName,
		'Group' => $request->Group,
		'role' => 3,

    	]);

	    $notification = array(
			'message' => 'Employee Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 

    public function EmployeeEdit($id){
    	$Employee = User::findOrFail($id);
		$Department = Department::latest()->get();
    	return view('backend.Employee.Employee_edit',compact('Employee','Department'));

    }

    public function EmployeeUpdate(Request $request ,$id){
// dd($request);

        // Get department name from ID
        $departmentName = Department::find($request->Employee_department)->department ?? $request->Employee_department;

        User::findOrFail($id)->update([
			'name' => $request->Employee_name,
		   'last_name' => $request->Employee_last_name,
			'designation' => $request->input('designation'),
			'employeeID' => $request->Employee_id,
			'contact_number' => $request->Employee_contact,
			'email' => $request->Employee_email,
			'password' => Hash::make($request->Employee_password),
			'department' => $departmentName,
	'group' => $request->Group,

    	]);

	    $notification = array(
			'message' => 'Employee Updated Successfully',
			'alert-type' => 'success'
		);

	return redirect()->route('all.ITEmployee')->with($notification);

    } // end method

    public function EmployeeDelete($id){

    	User::findOrFail($id)->delete();

    	$notification = array(
			'message' => 'Employee Deleted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 

}

