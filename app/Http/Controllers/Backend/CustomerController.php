<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Reminder;
use App\Models\OperatingSystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
class CustomerController extends Controller
{
    public function customerView()
    {
        $id = Auth::user()->id;
        $adminData = Customer::find($id);
        $Department = Department::latest()->get();
        $customer = Customer::latest()->where('role', 3)->get();
        $name = User::latest()->whereIn('role', [2, 6, 7, 8])->get();
        return view('backend.Customer.customer_view', compact('customer', 'Department', 'adminData', 'customer', 'name'));
    }

    public function customerAdd()
    {
        $Department = Department::latest()->get();
        $name = User::latest()->whereIn('role', [2, 6, 7, 8])->get();
        return view('backend.Customer.customer_add', compact('Department', 'name'));
    }

    public function customerStore(Request $request)
    {
        $request->validate([
            'customer_name' => '',
        ], [
            'customer_name.required' => 'Input customer  Name',
        ]);

        Customer::insert([
            'name' => $request->customer_name,
            'customerID' => $request->customer_id,
            'contact_number' => $request->customer_contact,
            'profile_photo_path' => $request->profile_photo_path,
            'reason' => $request->reason,
            'service' => $request->service,
            'comapny_name' => $request->comapny_name,
            'location' => $request->location,
            'department' => $request->customer_department,
            'role' => 3,
        ]);

        $notification = array(
            'message' => 'Customer Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function customerEdit($id)
    {
        $customer = Customer::findOrFail($id);
        $Department = Department::latest()->get();
        $reason = Customer::latest()->get();
        $name = User::latest()->whereIn('role', [2, 6, 7, 8])->get();
        $operating_system = OperatingSystem::latest()->get();
        return view('backend.Customer.customer_edit', compact('customer', 'Department', 'operating_system', 'name', 'reason'));
    }

    public function customerUpdate(Request $request, $id)
    {
        Customer::findOrFail($id)->update([
            'name' => $request->customer_name,
            'customerID' => $request->customer_id,
            'contact_number' => $request->customer_contact,
            'profile_photo_path' => $request->profile_photo_path,
            'reason' => $request->reason,
            'service' => $request->service,
            'comapny_name' => $request->comapny_name,
            'location' => $request->location,
        ]);

        $notification = array(
            'message' => 'Customer Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.customer')->with($notification);
    }

    public function customerDelete($id)
    {
        Customer::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    // New customer management methods
    public function index()
    {
        $customers = User::where('role', 3)->latest()->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        \Log::info('Customer store method called');
        \Log::info('Request data: ' . json_encode($request->all()));
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'pan_number' => 'required|string|max:20',
            'aadhar_number' => 'required|string|max:20',
            'location' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        \Log::info('Validation passed');

        try {
            $customer = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'contact_number' => $request->phone,
                'comapny_name' => $request->company_name,
                'pan_number' => $request->pan_number,
                'aadhar_number' => $request->aadhar_number,
                'location' => $request->location,
                'designation' => $request->designation,
                'department' => 'Customer', // Default department for customers
                'password' => Hash::make($request->password),
                'role' => 3,
                'email_varified_at' => now(), // Using the correct field name from User model
            ]);

            \Log::info('Customer created successfully with ID: ' . $customer->id);
            return redirect()->route('customers.index')->with('success', 'Customer account created successfully!');
        } catch (\Exception $e) {
            \Log::error('Customer creation failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Failed to create customer account. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function verify()
    {
        $customerData = session('customer_data');

        if (!$customerData) {
            return redirect()->route('customers.create')->with('error', 'Session expired. Please try again.');
        }

        return view('admin.customers.verify', compact('customerData'));
    }

    public function verifyOtp(Request $request)
    {
        $customerData = session('customer_data');

        if (!$customerData) {
            return redirect()->route('customers.create')->with('error', 'Session expired. Please try again.');
        }

        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if ($request->otp != $customerData['otp']) {
            return back()->with('error', 'Invalid OTP. Please try again.');
        }

        if (Carbon::now()->gt($customerData['otp_expires_at'])) {
            session()->forget('customer_data');
            return redirect()->route('customers.create')->with('error', 'OTP expired. Please try again.');
        }

        try {
            $customer = User::create([
                'name' => $customerData['name'],
                'email' => $customerData['email'],
                'contact_number' => $customerData['phone'],
                'comapny_name' => $customerData['company_name'],
                'pan_number' => $customerData['pan_number'],
                'aadhar_number' => $customerData['aadhar_number'],
                'department' => 'Customer', // Default department for customers
                'password' => $customerData['password'],
                'role' => $customerData['role'],
            ]);

            session()->forget('customer_data');

            return redirect()->route('customers.index')->with('success', 'Customer account created successfully!');
        } catch (\Exception $e) {
            \Log::error('Customer creation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to create customer account. Please try again.');
        }
    }

    public function resendOtp(Request $request)
    {
        $customerData = session('customer_data');

        if (!$customerData) {
            return redirect()->route('customers.create')->with('error', 'Session expired. Please try again.');
        }

        $newOtp = rand(100000, 999999);

        $customerData['otp'] = $newOtp;
        $customerData['otp_expires_at'] = Carbon::now()->addMinutes(10);
        session(['customer_data' => $customerData]);

        try {
            Mail::raw("Your new OTP for customer account creation is: {$newOtp}\n\nThis OTP will expire in 10 minutes.\n\nThank you,\nNiranjan Enterprises", function ($message) use ($customerData) {
                $message->to($customerData['email'])
                    ->subject('🔐 New OTP - Customer Account Verification - Niranjan Enterprises')
                    ->from(config('mail.from.address', 'noreply@niranjanenterprises.com'), config('mail.from.name', 'Niranjan Enterprises'));
            });

            return back()->with('success', 'New OTP has been sent to your email address.');
        } catch (\Exception $e) {
            \Log::error('OTP resend failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to resend OTP. Please try again.');
        }
    }

    public function edit(User $customer)
    {
        if ($customer->role != 3) {
            abort(404, 'Customer not found');
        }

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        if ($customer->role != 3) {
            abort(404, 'Customer not found');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'pan_number' => 'required|string|max:20',
            'aadhar_number' => 'required|string|max:20',
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->phone,
            'comapny_name' => $request->company_name,
            'pan_number' => $request->pan_number,
            'aadhar_number' => $request->aadhar_number,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }

    public function destroy(User $customer)
    {
        if ($customer->role != 3) {
            abort(404, 'Customer not found');
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
    }
}
