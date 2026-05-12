<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\sales;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
class SalesController extends Controller
{


    public function salesView(){
		$id = Auth::user()->id;
		$adminData = User::find($id);
		$Department = Department::latest()->get();
    	$sales = User::latest()->where('role' , 4)->get();
    	return view('backend.sales.sales_view',compact('sales','Department','adminData'));
    }


    public function salesAdd(){
		$Department = Department::latest()->get();
        return view('backend.sales.sales_add' , compact('Department'));


    }
    public function salesStore(Request $request){

       $request->validate([
    		'sales_name' => 'required',
    	
			'sales_id' =>'required',
			'sales_email' =>'required',
			'designation' =>'required',
			'sales_password' =>'required',
			'sales_department' =>'required',
		
    	],[
    		'sales_name.required' => 'Input sales  Name',
    

			'sales_id.required' => 'Input sales ID ',
			'designation' =>'Input designation ID',
			'sales_email.required' => 'Input sales  Email',
			'sales_password.required' => 'Input sales  Password',
			'sales_department.required' => 'Input sales  Department',
    	]);

    	 

        User::insert([
		'name' => $request->sales_name,
		// 'last_name' => $request->sales_last_name,
		// 'designation' =>  $request->input('designation'),
		'employeeID' => $request->sales_id,
		'contact_number' => $request->sales_contact,
		'email' => $request->sales_email,
		'password' => Hash::make($request->sales_password),
		'department' => $request->sales_department,
		'role' => 4,

    	]);

	    $notification = array(
			'message' => 'sales Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 


    public function salesEdit($id){
    	$sales = User::findOrFail($id);
		// $Department = Sale::latest()->get();
		$Department = Department::latest()->get();
    	return view('backend.sales.sales_edit',compact('sales','Department'));

    }


    public function salesUpdate(Request $request ,$id){
// dd($request);
    	 

        User::findOrFail($id)->update([
			'name' => $request->sales_name,
		//    'last_name' => $request->sales_last_name,
			// 'designation' => $request->input('designation'),
			'salesID' => $request->sales_id,
			'contact_number' => $request->sales_contact,
			'email' => $request->sales_email,
			'password' => Hash::make($request->sales_password),
			'department' => $request->sales_department,
	

    	]);

	    $notification = array(
			'message' => 'sales Updated Successfully',
			'alert-type' => 'success'
		);

		return redirect()->route('all.sales')->with($notification);


    } // end method


    public function salesDelete($id){

    	User::findOrFail($id)->delete();

    	$notification = array(
			'message' => 'sales Deleted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 





	 
}
 

