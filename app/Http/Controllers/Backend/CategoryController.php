<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department; // Changed from Category to Department
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ServiceCategory;


class CategoryController extends Controller
{
    public function CategoryView(){
		$id = Auth::user()->id;
		$adminData = User::find($id);
    	$category = Department::latest()->get();
		$service_category = ServiceCategory::latest()->get();
    	return view('backend.category.category_view',compact('category','adminData','service_category'));
    }

    public function CategoryStore(Request $request){

       $request->validate([
    		'category_name_en' => 'required',
    		
    	],[
    		'category_name_en.required' => 'Input Department Name',
    	
    	]);

    	 

	Department::insert([
		'department' => $request->category_name_en, // Use department field from departments table
    	]);

	    $notification = array(
			'message' => 'Department Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 


    public function CategoryEdit($id){
    	$category = Department::findOrFail($id); // Changed from Category to Department
    	return view('backend.category.category_edit',compact('category'));

    }


    public function CategoryUpdate(Request $request ,$id){

    	// Update departments table instead of categories
      Department::findOrFail($id)->update([
		'department' => $request->category_name_en, // Use department field
    	]);

	    $notification = array(
			'message' => 'Department Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->route('all.category')->with($notification);

    } // end method


    public function CategoryDelete($id){

    	Department::findOrFail($id)->delete(); // Changed from Category to Department

    	$notification = array(
			'message' => 'Department Deleted Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    } // end method 


}
 