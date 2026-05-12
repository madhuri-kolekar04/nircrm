<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class GroupController extends Controller
{
 public function GroupView(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
    	$Group = Group::latest()->get();
    	$Employee = User::where('role' , '0')->get();
       
    	return view('backend.Group.Group_view',compact('Group' ,'Employee','adminData'));

    }


    


public function GroupStore(Request $request){

    $request->validate([
        'Group' => 'required',

    ],[
        'Group.required' => 'Input Group  Name',
           ]);



Group::insert([
    'Group' => $request->Group,

    ]);

    $notification = array(
        'message' => 'Group Inserted Successfully',
        'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);

} // end method 



public function GroupEdit($id){
    $Group = Group::findOrFail($id);
    return view('backend.Group.Group_edit',compact('Group'));

}


public function GroupUpdate(Request $request){
    
	$Group_id = $request->Group_id;
    Group::findOrFail($Group_id)->update([
    'Group' => $request->Group,


    ]);

    $notification = array(
        'message' => 'Group Updated Successfully',
        'alert-type' => 'info'
    );

    return redirect()->route('all.Group')->with($notification);


} // end method 



public function GroupDelete($id){

    $Group = Group::findOrFail($id)->delete();


     $notification = array(
        'message' => 'Group Deleted Successfully',
        'alert-type' => 'info'
    );

    return redirect()->back()->with($notification);

} // end method 




}