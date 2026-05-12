<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Exports\userexport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Brand;
use App\Models\Group;
use App\Models\Reminder;
use App\Models\Department;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use App\Models\MultiImg;
use App\Models\Ticket_status;
use Carbon\Carbon;
use App\Models\SystemType;
use App\Models\ServiceCategory;
use App\Models\OperatingSystem;
use App\Models\Action;













use Image;
use Excel;
use Illuminate\Support\Facades\Auth;
class TicketController extends Controller
{

	public function exportUser(){
		return Excel::download(new userexport, 'users.xlsx');
		
	}
	public function importUser(Request $request){

		
		Excel::import(new UsersImport, request()->file('your_file.csv'));
		
	}
    
	public function AddProduct(){
		$categories = Category::latest()->get();
		$brands = Brand::latest()->get();
		$Department = Department::latest()->get();
		$Group = Group::latest()->get();
		$stage = Ticket_status::latest()->get();
		$Employee = User::latest()->get();
		$shares  = Product::latest()->get();
			$reminder = Reminder::latest()->get();
		$system_type =  SystemType::latest()->get();
		
		$service_category =  ServiceCategory::latest()->get();
		$operating_system =  OperatingSystem::latest()->get();
		$Action = Action::latest()->get();
		return view('backend.product.product_add',compact('categories','operating_system','service_category','system_type','shares','brands','Department','Group','stage','reminder' ));

	}


	public function PreviewProduct($id){
		$prv = Auth::user()->id;
        $adminData = User::find($prv);
		$multiImgs = MultiImg::where('product_id',$id)->get();
		$categories = Category::latest()->get();
		$Group = Group::latest()->get();
		$reminder = reminder::latest()->get();
		$brands = Brand::latest()->get();
		$subcategory = SubCategory::latest()->get();
		$subsubcategory = SubSubCategory::latest()->get();
		$Department = Department::latest()->get();
		$product = Product::findOrFail($id);
		$stage = Ticket_status::latest()->get();
		$username = User::latest()->get();
		$Action = Action::latest()->get();
		$system_type =  SystemType::latest()->get();
		$service_category =  ServiceCategory::latest()->get();
		$operating_system =  OperatingSystem::latest()->get();

		return view('backend.product.product_preview',compact('adminData','operating_system','service_category','system_type','Action','categories','username','brands','subcategory','stage','subsubcategory','product','multiImgs','Department','Group','reminder'));
	
	}

	public function AddProductuser(){
		$categories = Category::latest()->get();
		$brands = Brand::latest()->get();
		$Department = Department::latest()->get();
		$Group = Group::latest()->get();
		$reminder = reminder::latest()->get();
		$stage = Ticket_status::latest()->get();
	   $system_type =  system_type::latest()->get();
	   $service_category =  service_category::latest()->get();
	   $operating_system =  operating_system::latest()->get();
	   $Action = Action::latest()->get();
		$shares  = Product::latest()->get();
		
		$id = Auth::user()->id;
		$userdepartment = Auth::user()->department;
		$adminData = User::find($id);
		$selectdepartment = Department::find($userdepartment);

		return view('backend.product.product_adduser',compact('categories','Action','operating_system','service_category','system_type','selectdepartment','adminData','shares','brands','Department','Group','stage','reminder' ));

	}
	public function userassignupdate(Request $request) {
    // Validate the request
    $request->validate([
        'assign' => 'required|array',
        'assign.*' => 'exists:users,id',
        'tiergroup' => 'required|string',
    ]);

    // Find the product by ID
    $id = $request->input('ticketid');
    $product = Product::find($id);

    // Store array of user IDs as JSON (commented out since Assign column doesn't exist)
    // $product->Assign = json_encode($request->input('assign'));
    $product->Group = $request->input('tiergroup');

    // Save the product
    $product->save();

    // Prepare notification
    $notification = array(
        'message' => 'Ticket Updated Without Image Successfully',
        'alert-type' => 'success'
    );

    // Redirect with notification
    return redirect()->route('manage-product')->with($notification);
}


public function updateStatus(Request $request)
{
    $item = Item::find($request->item_id);
    if ($item) {
        $item->status = $request->status;
        if ($item->save()) {
            return response()->json(['success' => true]);
        }
    }
    return response()->json(['success' => false], 500);
}


public function StoreProduct(Request $request){

    $productData = [
        'brand_id' => $request->brand_id,
        'category_id' => $request->category_id,
        'due_info' => $request->due_info,
        'subcategory_id' => $request->subcategory_id,
        'subsubcategory_id' => $request->subsubcategory_id,
        'system_type_id' => $request->system_type_id,
        'service_category_id' => $request->service_category_id,
        'operating_system_id' => $request->operating_system_id,
        'product_name_en' => $request->product_name_en,
        'long_descp_en' => $request->long_descp_en,
        'history' => $request->history,
          'customerlist' => $request->customerlist,
           'system_type_id' => $request->system_type_id,
        'Department_id' => $request->Department_id ?? null,
        // 'Assign' => json_encode($request->assign), // Commented out since Assign column doesn't exist
        'Group' => $request->Group_IT,
        'status' => $request->status ?? 1,
        
        
        'created_at' => Carbon::now(),
    ];

    if ($request->file('product_thambnail')) {
        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $image->move('upload/products/thambnail/', $name_gen);
        $save_url = 'upload/products/thambnail/' . $name_gen;
        $productData['product_thambnail'] = $save_url;
    }

    $product_id = Product::insertGetId($productData);

    // Multiple Image Upload
    if ($request->hasFile('multi_img')) {
        foreach ($request->file('multi_img') as $img) {
            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            $img->move('upload/products/multi-image/', $make_name);
            $uploadPath = 'upload/products/multi-image/' . $make_name;

            MultiImg::insert([
                'product_id' => $product_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),
            ]);
        }
    }

    $notification = [
        'message' => 'Product Inserted Successfully',
        'alert-type' => 'success',
    ];

    return redirect()->route('manage-product')->with($notification);
}


public function StoreProductuser(Request $request){

    $productData = [
        'brand_id' => $request->brand_id,
        'category_id' => $request->category_id,
        'due_info' => $request->due_info,
        'subcategory_id' => $request->subcategory_id,
        'subsubcategory_id' => $request->subsubcategory_id,
        'system_type_id' => $request->system_type_id,
        'service_category_id' => $request->service_category_id,
        'operating_system_id' => $request->operating_system_id,
        'product_name_en' => $request->product_name_en,
        'long_descp_en' => $request->long_descp_en,
        'history' => $request->history,
       'customerlist' => $request->customerlist,
       'system_type_id' => $request->system_type_id,
        'Department_id' => $request->department_id ?? null,
        'status' => $request->status ?? 1,
        'created_at' => Carbon::now(),
    ];

    if ($request->file('product_thambnail')) {
        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $image->move('upload/products/thambnail/', $name_gen);
        $save_url = 'upload/products/thambnail/' . $name_gen;
        $productData['product_thambnail'] = $save_url;
    }

    $product_id = Product::insertGetId($productData);

    // Multiple Image Upload
    if ($request->hasFile('multi_img')) {
        foreach ($request->file('multi_img') as $img) {
            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            $img->move('upload/products/multi-image/', $make_name);
            $uploadPath = 'upload/products/multi-image/' . $make_name;

            MultiImg::insert([
                'product_id' => $product_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),
            ]);
        }
    }

    $notification = [
        'message' => 'Product Inserted Successfully',
        'alert-type' => 'success',
    ];

    return redirect()->route('manage-product')->with($notification);
}


	public function ManageProduct(){

	
$name =  User::latest()->whereIn('role' , [2, 6, 7, 8])->get();

		$Department = Department::latest()->get();
		$products = Product::latest()->orderBy('id', 'ASC')->get();
		
		$id = Auth::user()->id;
		$userData = Product::where('product_name_en' ,$id )->get();
		$adminData = User::find($id);
		return view('backend.product.product_view',compact('products' ,'Department','userData','adminData','name'));
		return view('dashboard',compact('products' ));
	}
	public function MyManageProduct(){

	
		$id = Auth::user()->id;


		$Department = Department::latest()->get();
		$products = Product::where('status', '>=', 0)->get(); // Get all products instead of filtering by non-existent Assign column
		$userData = User::find($id);
		return view('backend.product.Myproduct_view',compact('products' ,'Department','userData'));
	}


	public function EditProduct($id){

		$multiImgs = MultiImg::where('product_id',$id)->get();
		$categories = Category::latest()->get();
		$Group = Group::latest()->get();
		$brands = Brand::latest()->get();
		  
		  	$customer = reminder::latest()->get();
		$subcategory = SubCategory::latest()->get();
		$subsubcategory = SubSubCategory::latest()->get();
		$Department = Department::latest()->get();
		$products = Product::findOrFail($id);
		$stage = Ticket_status::latest()->get();
			$changeLog = Product::latest()->get();
			$history = Product::latest()->get();
		$username = User::latest()->get();
		$system_type =  SystemType::latest()->get();
		$service_category =  ServiceCategory::latest()->get();
		$operating_system =  OperatingSystem::latest()->get();
		$Action = Action::latest()->get();

		
		
		return view('backend.product.product_edit',compact('categories','Action','operating_system','service_category','system_type','username','brands','subcategory','stage','subsubcategory','products','multiImgs','Department','Group','changeLog','customer'));

	}
	
		public function ProductDataUpdate(Request $request){

// dd($request);
	$brand = $request->input('brand_id');
	$productId = $request->input('product_id');
	  $product = Product::find($productId);
	  $product->customer = $request->input('category_id');
	  $product->brand_id = $brand;
	  $product->category_id = $request->input('category_id');
	  $product->subcategory_id = $request->input('subcategory_id');
	  $product->subsubcategory_id = $request->input('subsubcategory_id');
	  $product->system_type_id = $request->input('system_type_id');
	  $product->service_category_id = $request->input('service_category_id');
	  $product->operating_system_id= $request->input('operating_system_id');
	  $product->product_name_en = $request->input('product_name_en');
	  $product->due_info = $request->input('due_info');
	  $product->changeLog = $request->input('changeLog');
	    $product->history = $request->input('history');
	    $product->customerlist = $request->input('customerlist');
	    $product->system_type_id = $request->input('system_type_id');
	  $product->long_descp_en = $request->input('long_descp_en');
	  $product->history = $request->input('history');
	  $product->Summary = $request->input('summary');
	  $product->Department_id = $request->input('Department_id');
	  // $product->Assign = $request->input('assign'); // Commented out since Assign column doesn't exist
	  $product->Group = $request->input('Group_IT');
	  $product->status = $request->input('status');
	  
	 
	//   dd($product);
      $product->save();
	  

          $notification = array(
			'message' => 'Ticket Updated Without Image Successfully',
			'alert-type' => 'success'
		);

		return redirect()->route('manage-product')->with($notification);


	} // end method 

	
		public function EditProductemp($id){

		$multiImgs = MultiImg::where('product_id',$id)->get();
		$categories = Category::latest()->get();
		$Group = Group::latest()->get();
		$brands = Brand::latest()->get();
		
		$subcategory = SubCategory::latest()->get();
		$subsubcategory = SubSubCategory::latest()->get();
		$Department = Department::latest()->get();
		$products = Product::findOrFail($id);
			$changeLog = Product::latest()->get();
			
			
			$history = Product::latest()->get();
		$stage = Ticket_status::latest()->get();
		$username = User::latest()->get();
		$system_type =  SystemType::latest()->get();
		$service_category =  ServiceCategory::latest()->get();
		$operating_system =  OperatingSystem::latest()->get();
		$Action = Action::latest()->get();

		
		
		return view('backend.product.product_edit_emp',compact('categories','Action','operating_system','service_category','system_type','username','brands','subcategory','stage','subsubcategory','products','multiImgs','Department','Group'));

	}



	public function ProductDataUpdateemp(Request $request){

// dd($request);
	$brand = $request->input('brand_id');
	$productId = $request->input('product_id');
	  $product = Product::find($productId);

	
	  $product->Group = $request->input('Group_IT');
	  $product->status = $request->input('status');
	   $product->changeLog = $request->input('changeLog');
	    $product->history = $request->input('history');
	
	//   dd($product);
      $product->save();
	  

          $notification = array(
			'message' => 'Ticket Updated Without Image Successfully',
			'alert-type' => 'success'
		);

		return redirect()->route('manage-product')->with($notification);


	} // end method 
	


/// Multiple Image Update
	public function MultiImageUpdate(Request $request){
		$imgs = $request->multi_img;

		foreach ($imgs as $id => $img) {
	    $imgDel = MultiImg::findOrFail($id);
	    unlink($imgDel->photo_name);
	     
    	$make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
    	Image::make($img)->resize(917,1000)->save('upload/products/multi-image/'.$make_name);
    	$uploadPath = 'upload/products/multi-image/'.$make_name;

    	MultiImg::where('id',$id)->update([
    		'photo_name' => $uploadPath,
    		'updated_at' => Carbon::now(),

    	]);

	 } // end foreach

       $notification = array(
			'message' => 'Ticket Image Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

	} // end mehtod 


 /// Product Main Thambnail Update /// 
 public function ThambnailImageUpdate(Request $request){
 	$pro_id = $request->id;
 	$oldImage = $request->old_img;
 	unlink($oldImage);

    $image = $request->file('product_thambnail');
    	$name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    	Image::make($image)->resize(917,1000)->save('upload/products/thambnail/'.$name_gen);
    	$save_url = 'upload/products/thambnail/'.$name_gen;

    	Product::findOrFail($pro_id)->update([
    		'product_thambnail' => $save_url,
    		'updated_at' => Carbon::now(),

    	]);

         $notification = array(
			'message' => 'Ticket Image Thambnail Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

     } // end method


 //// Multi Image Delete ////
     public function MultiImageDelete($id){
     	$oldimg = MultiImg::findOrFail($id);
     	unlink($oldimg->photo_name);
     	MultiImg::findOrFail($id)->delete();

     	$notification = array(
			'message' => 'Ticket Image Deleted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

     } // end method 



     public function ProductInactive($id){
     	Product::findOrFail($id)->update(['status' => 0]);
     	$notification = array(
			'message' => 'Ticket Inactive',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);
     }


  public function ProductActive($id){
  	Product::findOrFail($id)->update(['status' => 1]);
     	$notification = array(
			'message' => 'Ticket Active',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);
     	
     }



     public function ProductDelete($id){
     	$product = Product::findOrFail($id);
		if($product->product_thambnail !== null){
			unlink($product->product_thambnail);

		}
     	Product::findOrFail($id)->delete();

     	$images = MultiImg::where('product_id',$id)->get();
     	foreach ($images as $img) {
     		unlink($img->photo_name);
     		MultiImg::where('product_id',$id)->delete();
     	}

     	$notification = array(
			'message' => 'Ticket Deleted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

     }// end method 






  
  public function GetTicketUserName($Department_id){

	$userlist =User::where('department',$Department_id)->orderBy('name','DESC')->get();
	
	return json_encode($userlist);
 }

 public function GetTicketAssign($Group_ID){

	$userlistassign =User::where('group',$Group_ID)->orderBy('name','DESC')->get();
	
	return json_encode($userlistassign);
 }
 


 public function nextteirgroupchange($id){




	// $getticketgroup = Product::find($id)->Group;
	// $getgroupname = Group::find($getticketgroup)->get();

//   $getticketdata = Product::find($id);
  $ticketassgingroup = Product::where('id' , $id)->get(['id']);
 
  $getticketdata = Group::latest()->get();

	return response()->json([
 		// 'status' => 200,
		'group' => $getticketdata, 
		'ticket' => $ticketassgingroup, 
	]);
 }

 //  $ticketassgingroup = Product::where('id' , $ticketid)->Group;
//  $getticketdata =Group::where('Group',$ticketassgingroup)->get();
 
//  return response($getticketdata);
}
 
