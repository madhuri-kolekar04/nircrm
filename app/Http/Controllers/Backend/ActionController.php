<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Action;
use App\Models\User;
class ActionController extends Controller
{
    public function ActionView(){
        $id = Auth::user()->id;
       $adminData = User::find($id);
       $Action = Action::latest()->get();
       $Employee = User::where('role' , '0')->get();
      
       return view('backend.Action.Action_view',compact('Action' ,'Employee','adminData'));

   }


   


public function ActionStore(Request $request){

   $request->validate([
       'Action' => 'required',

   ],[
       'Action.required' => 'Input Action  Name',
          ]);



Action::insert([
   'action_name' => $request->Action,

   ]);

   $notification = array(
       'message' => 'Action Inserted Successfully',
       'alert-type' => 'success'
   );

   return redirect()->back()->with($notification);

} // end method 



public function ActionEdit($id){
   $Action = Action::findOrFail($id);
   return view('backend.Action.Action_edit',compact('Action'));

}


public function ActionUpdate(Request $request){
   
   $Action_id = $request->Action_id;
   Action::findOrFail($Action_id)->update([
   'action_name' => $request->Action,


   ]);

   $notification = array(
       'message' => 'Action Updated Successfully',
       'alert-type' => 'info'
   );

   return redirect()->route('all.Action')->with($notification);


} // end method 



public function ActionDelete($id){

   $Action = Action::findOrFail($id)->delete();


    $notification = array(
       'message' => 'Action Deleted Successfully',
       'alert-type' => 'info'
   );

   return redirect()->back()->with($notification);

} // end method 



}
