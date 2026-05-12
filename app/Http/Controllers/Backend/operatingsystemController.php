<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\operating_system;
use Image;
use Illuminate\Support\Facades\Auth;
class operatingsystemController extends Controller
{
    public function operating_systemView(){
		$id = Auth::user()->id;
		$adminData = User::find($id);
    	$operating_system = operating_system::latest()->get();
    	return view('backend.operating_system.operating_system_view',compact('operating_system','adminData'));

    }


    public function operating_systemStore(Request $request){

    	$request->validate([
    		'operating_system_name_en' => 'required',

    	],[
    		'operating_system_name_en.required' => 'Input Operating System   Name',

    	]);



	operating_system::insert([
		'operating_system' => $request->operating_system_name_en,


    	]);

	    $notification = array(
			'message' => 'Operating System   Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 



    public function operating_systemEdit($id){
    	$operating_system = operating_system::findOrFail($id);
    	return view('backend.operating_system.operating_system_edit',compact('operating_system'));
    }


    public function operating_systemUpdate(Request $request){
    	
    	$operating_system_id = $request->id;
    	

	

    	$operating = operating_system::findOrFail($operating_system_id);
       
		$operating->operating_system = $request->input('operating_system');

		 $operating->save();

    

	    $notification = array(
			'message' => 'Operating System Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->route('all.operating_system')->with($notification);
 
    } // end method 



    public function operating_systemDelete($id){

    	$operating_system = operating_system::findOrFail($id);
    
    	

    	operating_system::findOrFail($id)->delete();

    	 $notification = array(
			'message' => 'Operating System  Deleted Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    } // end method 
}
