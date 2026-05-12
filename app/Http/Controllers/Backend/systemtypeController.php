<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\system_type;
use Image;
use Illuminate\Support\Facades\Auth;
class systemtypeController extends Controller
{
    public function system_typeView(){
		$id = Auth::user()->id;
		$adminData = User::find($id);
    	$system_type = system_type::latest()->get();
    	return view('backend.system_type.system_type_view',compact('system_type','adminData'));

    }


    public function system_typeStore(Request $request){

    	$request->validate([
    		'system_type_name_en' => 'required',

    	],[
    		'system_type_name_en.required' => 'Input System Type  Name',

    	]);



	system_type::insert([
		'system_type_name' => $request->system_type_name_en,


    	]);

	    $notification = array(
			'message' => 'System Type  Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 



    public function system_typeEdit($id){
    	$system_type = system_type::findOrFail($id);
    	return view('backend.system_type.system_type_edit',compact('system_type'));

    }


    public function system_typeUpdate(Request $request){
    	
    	$system_type_id = $request->id;
    	

	

    	system_type::findOrFail($system_type_id)->update([
		'system_type_name' => $request->system_type_name,

		 

    	]);

	    $notification = array(
			'message' => 'System Type Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->route('all.system_type')->with($notification);
 
    } // end method 



    public function system_typeDelete($id){

    	$system_type = system_type::findOrFail($id);
    
    	

    	system_type::findOrFail($id)->delete();

    	 $notification = array(
			'message' => 'System Type  Deleted Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    } // end method 

}
