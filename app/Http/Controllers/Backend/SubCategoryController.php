<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\User;
use App\Models\SubSubCategory;
use App\Models\service_category;

use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    public function SubCategoryView(){
		$id = Auth::user()->id;
        $adminData = User::find($id);
    	$categories = Category::orderBy('category_name_en','ASC')->get();
    	$subcategory = SubCategory::latest()->get();
		$service_category = service_category::latest()->get();
    	return view('backend.category.subcategory_view',compact('subcategory','categories','adminData','service_category'));

    }


     public function SubCategoryStore(Request $request){

		// dd($request);
       $request->validate([
    		'service_category' => 'required',
    		'category_id' => 'required',
    		'subcategory_name_en' => 'required',
    	],[
    		'category_id.required' => 'Please select Any option',
    		'subcategory_name_en.required' => 'Input SubCategory  Name',
			'service_category.required' => 'Input Service Category  Name',
    	]);

    	 

	   SubCategory::insert([
		'service_category_id' => $request->service_category,

		'category_id' => $request->category_id,
		'subcategory_name_en' => $request->subcategory_name_en,
		'subcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subcategory_name_en)),

		 

    	]);

	    $notification = array(
			'message' => 'SubCategory Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 



     public function SubCategoryEdit($id){
    	$categories = Category::orderBy('category_name_en','ASC')->get();
    	$subcategory = SubCategory::findOrFail($id);
    	return view('backend.category.subcategory_edit',compact('subcategory','categories'));

    }


    public function SubCategoryUpdate(Request $request){

    	$subcat_id = $request->id;

    	 SubCategory::findOrFail($subcat_id)->update([
		'category_id' => $request->category_id,
		'subcategory_name_en' => $request->subcategory_name_en,
		'subcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subcategory_name_en)),
		 

    	]);

	    $notification = array(
			'message' => 'SubCategory Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->route('all.subcategory')->with($notification);

    }  // end method



    public function SubCategoryDelete($id){

    	SubCategory::findOrFail($id)->delete();

    	$notification = array(
			'message' => 'SubCategory Deleted Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    }


  /////////////// That for SUB->SUBCATEGORY ////////////////

 public function SubSubCategoryView(){

	$id = Auth::user()->id;
        $adminData = User::find($id);
 	$categories = Category::orderBy('category_name_en','ASC')->get();
    	$subsubcategory = SubSubCategory::latest()->get();
		$service_category = service_category::latest()->get();

    	return view('backend.category.sub_subcategory_view',compact('subsubcategory','categories','service_category','adminData'));

     }

 
     public function GetSubCategory($category_id){

     	$subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name_en','ASC')->get();
     	return json_encode($subcat);
     }
	 


       public function GetSubSubCategory($subcategory_id){

        $subsubcat = SubSubCategory::where('subcategory_id',$subcategory_id)->orderBy('subsubcategory_name_en','DESC')->get();
		
        return json_encode($subsubcat);
     }

	 public function GetCategory($service_category_id){

        $subcat1 = Category::where('service_category_id',$service_category_id)->orderBy('category_name_en','DESC')->get();
        return json_encode($subcat1);

     }



public function SubSubCategoryStore(Request $request){

       $request->validate([
    		'category_id' => 'required',
    		'subcategory_id' => 'required',
    		'service_category' => 'required',

    		'subsubcategory_name_en' => 'required',

    	],[
    		'category_id.required' => 'Please select Any option',
    		'subsubcategory_name_en.required' => 'Input SubSubCategory  Name',
			'subcategory_id.required' => 'Input Sub Category  Name',
    		'service_category.required' => 'Input Service Category  Name',
    	]);

    	 

	   SubSubCategory::insert([
		'service_category_id' => $request->service_category,
		'category_id' => $request->category_id,
		'subcategory_id' => $request->subcategory_id,
		'subsubcategory_name_en' => $request->subsubcategory_name_en,
		'subsubcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subsubcategory_name_en)),

		 

    	]);

	    $notification = array(
			'message' => 'Sub-SubCategory Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 



    public function SubSubCategoryEdit($id){
    	$categories = Category::orderBy('category_name_en','ASC')->get();
		$service_category = service_category::orderBy('service_category_name','ASC')->get();
    	$subcategories = SubCategory::orderBy('subcategory_name_en','ASC')->get();
    	$subsubcategories = SubSubCategory::findOrFail($id);
    	return view('backend.category.sub_subcategory_edit',compact('categories','service_category','subcategories','subsubcategories'));

    }



    public function SubSubCategoryUpdate(Request $request){

    	$subsubcat_id = $request->id;

    	SubSubCategory::findOrFail($subsubcat_id)->update([
		'category_id' => $request->category_id,
		'subcategory_id' => $request->subcategory_id,
		'subsubcategory_name_en' => $request->subsubcategory_name_en,
		'subsubcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subsubcategory_name_en)),

		 

    	]);

	    $notification = array(
			'message' => 'Sub-SubCategory Update Successfully',
			'alert-type' => 'info'
		);

		return redirect()->route('all.subsubcategory')->with($notification);

    } // end method 


    public function SubSubCategoryDelete($id){

    	SubSubCategory::findOrFail($id)->delete();
    	 $notification = array(
			'message' => 'Sub-SubCategory Deleted Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    }


}
 
