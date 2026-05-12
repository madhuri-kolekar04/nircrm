<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\service_category;
use Image;
use Illuminate\Support\Facades\Auth;

class servicecategoryController extends Controller
{
    public function service_categoryView(){
		$id = Auth::user()->id;
		$adminData = User::find($id);
    	$service_category = service_category::latest()->get();
    	return view('backend.service_category.service_category_view',compact('service_category','adminData'));

    }


    public function service_categoryStore(Request $request){

    	$request->validate([
    		'service_category_name_en' => 'required',

    	],[
    		'service_category_name_en.required' => 'Input Service Category  Name',

    	]);



	service_category::insert([
		'service_category_name' => $request->service_category_name_en,


    	]);

	    $notification = array(
			'message' => 'Service Category  Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 



    public function service_categoryEdit($id){
    	$service_category = service_category::findOrFail($id);
    	return view('backend.service_category.service_category_edit',compact('service_category'));

    }


    public function service_categoryUpdate(Request $request){
    	
    	$service_category_id = $request->id;
    	

	

    	service_category::findOrFail($service_category_id)->update([
		'service_category_name' => $request->service_category_name_en,

		 

    	]);

	    $notification = array(
			'message' => 'Service Category Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->route('all.service_category')->with($notification);
 
    } // end method 



    public function service_categoryDelete($id){

    	$service_category = service_category::findOrFail($id);
    
    	

    	service_category::findOrFail($id)->delete();

    	 $notification = array(
			'message' => 'Service Category  Deleted Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    } // end method 
}

