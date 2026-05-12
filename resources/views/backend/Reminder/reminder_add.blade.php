






@extends('admin.admin_master')
@section('admin')


<div class="container-full">
		<!-- Content Header (Page header) -->
		  

		<!-- Main content -->
		<section class="content">
 
		 <!-- Basic Forms -->
		  <div class="box" >
   <div class="box-header with-border">
     <h3 class="box-title">Add Customer</h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body" style="overflow:none;">
       <div >
    <!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 
<!--   ------------ Add reminder Page -------- -->


<div class="col-md-4">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<form method="post" action="{{ route('reminder.store') }}" >
@csrf




  <div class="form-group">
        <h5> ID <span class="text-danger">*</span></h5>
        <input type="text" id="reminder_id" name="reminder_id" class="form-control" readonly>
        @error('reminder_id') 
        <span class="text-danger">{{ $message }}</span>
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
            document.getElementById('reminder_id').value = randomNumber;
        }

        // Run the function when the page loads
        window.onload = generateUniqueNumber;
    </script>

     <div class="col-md-4">

<div class="form-group">
<h5>Project Name<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="reminder_name" class="form-control"  > 
@error('reminder_name') 
<span class="text-danger">{{ $message}}</span>
@enderror 

	 </div>

</div>

</div> <!-- end col md 4 -->
<div class="col-md-4">
    <div class="form-group">
        <h5>Group Name<span class="text-danger">*</span></h5>
        <div class="controls">
            <select name="system_type_id" class="form-control" required="">
                <option value="" selected disabled>Select Group</option>
                @php
                    // Assuming $system_type is an array of objects with 'system_type_name' property
                    $sortedGroups = $system_type->sortBy('system_type_name');
                @endphp
                @foreach($sortedGroups as $item)
                    <option value="{{ $item->system_type_name }}">{{ $item->system_type_name }}</option>
                @endforeach
            </select>
            @error('system_type_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
 <!-- end col md 4 -->


<div class="col-md-4" style="display:none">

<div class="form-group">
<h5>Last Name<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="reminder_last_name" class="form-control"  > 
@error('reminder_name') 
<span class="text-danger">{{ $message}}</span>
@enderror 

	 </div>

</div>

</div> <!-- end col md 4 -->




<div class="col-md-4">
    <div class="form-group">
        <h5>Categories<span class="text-danger">*</span></h5>
        <div class="controls">
            <select name="reminder_department" class="form-control" required="">
                <option value="" selected disabled>Select Group</option>
                @php
                    // Assuming $operating_system is an array of objects with 'operating_system' property
                    $sortedCategories = $operating_system->sortBy('operating_system');
                @endphp
                @foreach($sortedCategories as $item)
                    <option value="{{ $item->operating_system }}">{{ $item->operating_system }}</option>
                @endforeach
            </select>
            @error('reminder_department')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>




<div class="col-md-4">
    <div class="form-group">
        <h5>Work Type<span class="text-danger">*</span></h5>
        <div class="controls">
            <select name="location" class="form-control">
                <option value="">Select Department</option>
                <option value="Retailer">Retailer</option>
                <option value="One Time Assignment">One Time Assignment</option>
               
                <!-- Add more options as needed -->
            </select>
            @error('location') 
            <span class="text-danger">{{ $message }}</span>
            @enderror 
        </div>
    </div>
</div>
<!-- end col md 4 -->




<div class="col-md-4">

<div class="form-group">
<h5>Mobile No:<span class="text-danger"></span></h5>
<div class="controls">
<input type="text"  name="reminder_contact" class="form-control"   > 
@error('reminder_contact') 
<span class="text-danger">{{ $message}}</span>
@enderror 
</div>
</div>
				
	</div> <!-- end col md 4 -->



<!-- end col md 4 -->









 

     
</div> <!-- 2nd row end-->





<div class="text-xs-right">
<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Add New">					 
           </div>
       </form>


 </div>

   </div>


</section>
</div>
</div>
</div>
   @endsection








