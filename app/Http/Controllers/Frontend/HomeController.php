<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Department;


class HomeController extends Controller
{
    public function index(){
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $role = Auth::user()->role;
        $position = Auth::user()->position;

        if($role == 1 ){
            $adminData = Auth::user();
            return view('admin.index',compact('adminData'  ));
    
        }elseif($role == 4 || $position == 'Manager'){
            $managerData = Auth::user();
            return redirect()->route('employees.index');
      
        }elseif($role == 2){
            $adminData = Auth::user();
            return redirect()->route('manage-product');
      
        }elseif($role == 3){
            $customerData = Auth::user();
            return redirect()->route('invoices.index');
      
        }else{
            return redirect()->route('login');
        }
}
}
