<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class ITEmployeeController extends Controller
{


    public function EmployeeView(){
		$id = Auth::user()->id;
        $adminData = User::find($id);
    	$Employee = User::latest()->whereIn('role' , [2, 6, 7, 8])->get();
	
		$Group = Group::latest()->get();
    	return view('backend.IT_Supporter.employee_view',compact('Employee' ,'Group','adminData'));
    }


    public function EmployeeAdd(){
		$Department = Department::latest()->get();
    }

    public function EmployeeStore(Request $request)
    {
        // Set role based on position
        $role = ($request->Employee_position == 'general_manager') ? 5 : (($request->Employee_position == 'Manager') ? 4 : 2);

        User::insert([
            'name' => $request->Employee_name,
            'employeeID' => $request->Employee_id,
            'contact_number' => $request->Employee_contact,
            'email' => $request->Employee_email,
            'password' => Hash::make($request->Employee_password),
            'department' => $request->Employee_department,
            'group' => $request->Group,
            'role' => $role,
            'position' => $request->Employee_position,
        ]);

    return redirect()->back()->with($notification);
} // end method


    public function EmployeeEdit($id){
	
		$adminData = User::find($id);
    	$Employee = User::findOrFail($id);
		$Group = Group::latest()->get();
		$Department = Department::latest()->get();
    	return view('backend.IT_Supporter.employee_edit',compact('Employee' ,'Group','Department','adminData'));

    }


    public function EmployeeUpdate(Request $request ,$id){
// dd($request);

        User::findOrFail($id)->update([
			'name' => $request->Employee_name,
			'employeeID' => $request->Employee_id,
			'contact_number' => $request->Employee_contact,
			'email' => $request->Employee_email,
			'password' => Hash::make($request->Employee_password),
			'department' => $request->Employee_department,
			'group' => $request->Group,
		    'role' => 2
	

    	]);

	    $notification = array(
			'message' => 'IT Supporter Details Updated Successfully',
			'alert-type' => 'success'
		);

		return redirect()->route('all.Employee')->with($notification);
		


    } // end method
    
    
    
    
    
    
    
    


    public function EmployeeDelete($id){

    	User::findOrFail($id)->delete();

    	$notification = array(
			'message' => 'IT Supporter Details Deleted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 


}
 

