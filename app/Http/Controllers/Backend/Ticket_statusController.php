<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket_status;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class Ticket_statusController extends Controller
{
 public function Ticket_statusView(){

        $id = Auth::user()->id;
        $adminData = User::find($id);
    	$Ticket_status = Ticket_status::latest()->get();
    	
       
    	return view('backend.Ticket_Status.Ticket_status_view',compact('Ticket_status','adminData' ));

    }


    


public function Ticket_statusStore(Request $request){

    $request->validate([
        'Ticket_status' => 'required',

    ],[
        'Ticket_status.required' => 'Input Ticket Status  Name',
           ]);



Ticket_status::insert([
    'Ticket_status' => $request->Ticket_status,

    ]);

    $notification = array(
        'message' => 'Ticket Status Inserted Successfully',
        'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);

} // end method 



public function Ticket_statusEdit($id){
    $Ticket_status = Ticket_status::findOrFail($id);
    return view('backend.Ticket_Status.Ticket_status_edit',compact('Ticket_status'));

}


public function Ticket_statusUpdate(Request $request){
    
	$Ticket_status_id = $request->Ticket_status_id;
    Ticket_status::findOrFail($Ticket_status_id)->update([
    'Ticket_status' => $request->Ticket_status,


    ]);

    $notification = array(
        'message' => 'Ticket Status Updated Successfully',
        'alert-type' => 'info'
    );

    return redirect()->route('all.Ticket_status')->with($notification);


} // end method 



public function Ticket_statusDelete($id){

    $Ticket_status = Ticket_status::findOrFail($id)->delete();


     $notification = array(
        'message' => 'Ticket Status Deleted Successfully',
        'alert-type' => 'info'
    );

    return redirect()->back()->with($notification);

} // end method 




}