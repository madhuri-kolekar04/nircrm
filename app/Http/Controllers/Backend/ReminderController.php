<?php

namespace App\Http\Controllers\Backend;




use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\Reminder;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;



use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Brand;
use App\Models\Group;


use App\Models\Product;

use App\Models\MultiImg;
use App\Models\Ticket_status;
use Carbon\Carbon;
use App\Models\SystemType;
use App\Models\ServiceCategory;
use App\Models\OperatingSystem;

use Illuminate\Support\Facades\Hash;
class ReminderController extends Controller
{


    public function reminderView(){
		$id = Auth::user()->id;
		$adminData = Reminder::find($id);
		$Department = Department::latest()->get();
			$system_type =  SystemType::latest()->get();
				$system_type_id =  Product::latest()->get();
				
					$operating_system =  OperatingSystem::latest()->get();
				
    	$reminder = Reminder::latest()->where('role' , 3)->get();
    	return view('backend.Reminder.reminder_view',compact('reminder','Department','adminData','system_type','system_type_id','operating_system'));
    }


    public function reminderAdd(){
		$Department = Department::latest()->get();
			$system_type =  SystemType::latest()->get();
			$system_type_id = Product::latest()->get();
			
				$operating_system =  OperatingSystem::latest()->get();
			
        return view('backend.Reminder.reminder_add' , compact('Department','system_type','system_type_id','operating_system'));


    }
    
  public function generateId()
{
    do {
        $id = mt_rand(100, 999);
        $exists = DB::table('reminders')->where('reminderID', $id)->exists();
    } while ($exists);

    return response()->json(['success' => true, 'id' => $id]);
}
    public function reminderStore(Request $request){

       $request->validate([
    		'reminder_name' => 'required',
    	
			'reminder_id' =>'required',
		
		
		
		
    	],[
    		'reminder_name.required' => 'Input reminder  Name',
    

			'reminder_id.required' => 'Input reminder ID ',
			'designation' =>'Input designation ID',
			
			
			'reminder_password.required' => 'Input reminder  Password',
			'reminder_department.required' => 'Input reminder  Department',
    	]);

    	 

        Reminder::insert([
		'name' => $request->reminder_name,
		// 'last_name' => $request->reminder_last_name,
		// 'designation' =>  $request->input('designation'),
		'reminderID' => $request->reminder_id,
		'system_type_id' => $request->system_type_id,
			'location' => $request->location,
		'contact_number' => $request->reminder_contact,
		'email' => $request->reminder_email,
		'password' => Hash::make($request->reminder_password),
		'department' => $request->reminder_department,
		'role' => 3,

    	]);

	    $notification = array(
			'message' => 'reminder Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);
    } // end method 

    public function reminderEdit($id)
    {
        $reminder = Reminder::findOrFail($id);
        $Department = Department::latest()->get();
        $system_type = SystemType::latest()->get();
        $system_type_id = Product::latest()->get();
        $operating_system = OperatingSystem::latest()->get();
        return view('backend.Reminder.reminder_edit', compact('reminder', 'Department', 'system_type', 'system_type_id', 'operating_system'));
    }

    public function reminderUpdate(Request $request, $id)
    {
        Reminder::findOrFail($id)->update([
            'name' => $request->reminder_name,
            'reminderID' => $request->reminder_id,
            'location' => $request->location,
            'reminder_department' => $request->reminder_department,
            'system_type_id' => $request->system_type_id,
            'contact_number' => $request->reminder_contact,
            'email' => $request->reminder_email,
            'password' => Hash::make($request->reminder_password),
            'department' => $request->reminder_department,
        ]);

        $notification = array(
            'message' => 'reminder Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.reminder')->with($notification);
    } // end method


    public function reminderDelete($id){

    	Reminder::findOrFail($id)->delete();

    	$notification = array(
			'message' => 'reminder Deleted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 





	 
}
 

