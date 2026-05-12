






@extends('admin.admin_master')
@section('admin')


<div class="container-full">
		<!-- Content Header (Page header) -->
		  

		<!-- Main content -->
		<section class="content">
 
		 <!-- Basic Forms -->
		  <div class="box" >
   <div class="box-header with-border">
     <h3 class="box-title">Leave Application</h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body" style="overflow:none;">
       <div >
    <!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 
<!--   ------------ Add customer Page -------- -->


<div class="col-md-4">


<form method="post" action="{{ route('customer.store') }}" >
@csrf




<div class="form-group">
<h5> ID <span class="text-danger">*</span></h5>
<input type="text"  name="customer_id" id="customer_id" class="form-control" readonly > 
@error('customer_id') 
<span class="text-danger">{{ $message}}</span>
@enderror 
	</div>
		   
	   </div> <!-- end col md 4 -->
	   
	   
	   
	     
	     <script>
        // Array to store generated numbers
        const generatedNumbers = [];

        function generateUniqueNumber() {
            let randomNumber;

            // Keep generating numbers until a unique one is found
            do {
                randomNumber = Math.floor(100 + Math.random() * 900);
            } while (generatedNumbers.includes(randomNumber));

            // Store the generated number
            generatedNumbers.push(randomNumber);

            // Set the value of the input field
            document.getElementById('customer_id').value = randomNumber;
        }

        // Run the function when the page loads
        window.onload = generateUniqueNumber;
    </script>

     <div class="col-md-4">

<div class="form-group">
    <h5>Employee Name<span class="text-danger">*</span></h5>
    <div class="controls">
        @if (auth()->user()->employeeID == "admin")
            <select name="customer_name" class="form-control" required>
                <option value="" selected disabled>Select Department</option>
                @foreach($name as $item)
                    <option value="{{ $item->name }}">{{ $item->name }}</option>  
                @endforeach
            </select>
        @else
            <select name="customer_name" class="form-control" required>
                <option value="{{ auth()->user()->name }}" selected>{{ auth()->user()->name }}</option>
            </select>
        @endif
        @error('customer_name') 
            <span class="text-danger">{{ $message }}</span>
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
            <input type="date" id="comapny_name" name="comapny_name" class="form-control" required>
            @error('comapny_name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <h5>End Date<span class="text-danger">*</span></h5>
        <div class="controls">
            <input type="date" id="location" name="location" class="form-control" required>
            @error('location')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <h5>Number of Days</h5>
        <div class="controls">
            <input type="text" id="service" name="service" class="form-control" readonly>
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
<input type="text"  name="customer_contact" class="form-control"   > 
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
                <option value="Approval (Paid Leave)">Approval (Paid Leave)</option>
                <option value="Approval (UnPaid Leave)">Approval (UnPaid Leave)</option>
                <option value="Rejected">Rejected</option>
                <!-- Add more options as needed -->
            </select>
            @error('leave_type')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
 <!-- end col md 4 -->
</div>
<div class="col-md-4">
<div class="form-group">
<h5>Comments From Admin<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="reason" id="reason" class="form-control"   > 
@error('reason') 
<span class="text-danger">{{ $message}}</span>
@enderror 
</div>
</div>
				
	</div>
@endif

</div>
     
</div> <!-- 2nd row end-->

</div> 



<div class="text-xs-right">
<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Add Leave">					 
           </div>
       </form>


 </div>

   </div>


</section>
</div>
</div>
</div>
   @endsection








