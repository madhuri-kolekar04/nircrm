@extends('admin.admin_master')
@section('admin')


<div class="container-full">
		<!-- Content Header (Page header) -->
		  

		<!-- Main content -->
		<section class="content">
 
		 <!-- Basic Forms -->
		  <div class="box" >
   <div class="box-header with-border">
     <h3 class="box-title">Edit customer</h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body" style="overflow:none;">
       <div >
    <!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 
<!--   ------------ Add customer Page -------- -->


<div class="col-md-4">


<form method="post" action="{{ route('customer.update',$customer->id) }}" >
@csrf




<div class="form-group">
<h5> ID <span class="text-danger">*</span></h5>
<input type="text"  name="customer_id" class="form-control" value="{{$customer->customerID}}"  readonly> 
@error('customer_id') 
<span class="text-danger">{{ $message}}</span>
@enderror 
	</div>
		   
	   </div> <!-- end col md 4 -->

     <div class="col-md-4">

<div class="form-group">
<h5>Employee Name<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="customer_name" class="form-control" value="{{ $customer->name }}" readonly > 
@error('customer_name') 
<span class="text-danger">{{ $message}}</span>
@enderror 

	 </div>

</div>



</div> <!-- end col md 4 -->

<div class="col-md-4" style="display:none">

<div class="form-group">
<h5>Last Name<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="customer_last_name" class="form-control"  > 
@error('customer_name') 
<span class="text-danger">{{ $message}}</span>
@enderror 

	 </div>

</div>

</div> <!-- end col md 4 -->




 <!-- end col md 4 -->


<div class="col-md-4">

    <div class="form-group">
        <h5>Start Date<span class="text-danger">*</span></h5>
        <div class="controls">
            <input type="date" name="comapny_name" id="comapny_name" class="form-control" value="{{ $customer->comapny_name }}" required>
            @error('start_date')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <h5>End Date<span class="text-danger">*</span></h5>
        <div class="controls">
            <input type="date" name="location" id="location" class="form-control" value="{{ $customer->location }}" required>
            @error('end_date')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <h5>Number of Days</h5>
        <div class="controls">
            <input type="text" id="service" name="service" value="{{ $customer->service }}" class="form-control" readonly>
        </div>
    </div>

</div>

<script>
    document.getElementById('comapny_name').addEventListener('change', function() {
        // Update minimum date of end_date input
        document.getElementById('location').min = this.value;
        calculateDays();
    });

    document.getElementById('location').addEventListener('change', calculateDays);

    function calculateDays() {
        var startDateInput = document.getElementById('comapny_name');
        var endDateInput = document.getElementById('location');
        var numDaysInput = document.getElementById('service');

        var startDate = new Date(startDateInput.value);
        var endDate = new Date(endDateInput.value);

        if (startDate.getTime() > endDate.getTime()) {
            // If End Date is before Start Date, reset End Date to Start Date
            endDateInput.value = startDateInput.value;
            endDate = startDate;
        }

        var diffTime = Math.abs(endDate - startDate + 1);
        var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        numDaysInput.value = diffDays;
    }
</script>






<div class="col-md-4">

<div class="form-group">
<h5>Leave Reasons<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="customer_contact" class="form-control" value="{{ $customer->contact_number }}"  > 
@error('customer_contact') 
<span class="text-danger">{{ $message}}</span>
@enderror 
</div>
</div>
				
	</div> <!-- end col md 4 -->


  
 <!-- end col md 4 -->




@if ((auth()->user()->employeeID == "admin"))


<div class="col-md-4">
    <div class="form-group">
        <h5>Leave Type <span class="text-danger">*</span></h5>
        <div class="controls">
            <select name="profile_photo_path" id="profile_photo_path" class="form-control" onchange="toggleReasonBox()">
                <option value="">Select Leave Type</option>
                <option value="Approval (Paid Leave)" {{ $customer->profile_photo_path == "Approval (Paid Leave)" ? 'selected' : '' }}>Approval (Paid Leave)</option>
                <option value="Approval (UnPaid Leave)" {{ $customer->profile_photo_path == "Approval (UnPaid Leave)" ? 'selected' : '' }}>Approval (UnPaid Leave)</option>
                <option value="Rejected" {{ $customer->profile_photo_path == "Rejected" ? 'selected' : '' }}>Rejected</option>
                <!-- Add more options as needed -->
            </select>
            @error('leave_type')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div> <!-- end col md 4 -->

<div class="col-md-4">

<div class="form-group">
<h5>Comments From Admin<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="reason" class="form-control" value="{{ $customer->reason }}"  > 
@error('reason') 
<span class="text-danger">{{ $message}}</span>
@enderror 
</div>
</div>
				
	</div>

@endif




<div class="text-xs-right">
	<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update">					 
						</div>
					</form>

 </div>

   </div>


</section>
</div>
</div>
</div>
   @endsection






