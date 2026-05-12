
@extends('admin.admin_master')
@section('admin')


<div class="container-full">
		<!-- Content Header (Page header) -->
		  

		<!-- Main content -->
		<section class="content">
 
		 <!-- Basic Forms -->
		  <div class="box" >
   <div class="box-header with-border">
     <h3 class="box-title">Add Employee </h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body" style="overflow:none;">
       <div >
        
    <!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 
<!--   ------------ Add Employee Page -------- -->

<div class="col-md-4">

<form method="post" action="{{ route('ITEmployee.store') }}" >
@csrf

<div class="form-group">
<h5> ID <span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="Employee_id" id="Employee_id" class="form-control"  readonly> 
@error('Employee_id') 
<span class="text-danger">{{ $message}}</span>
@enderror
</div>

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
            document.getElementById('Employee_id').value = randomNumber;
        }

        // Run the function when the page loads
        window.onload = generateUniqueNumber;
    </script>


     <div class="col-md-4">


     <div class="form-group">
     <h5> Name <span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="Employee_name" class="form-control" > 
@error('Employee_name') 
<span class="text-danger">{{ $message}}</span>
@enderror 
</div>
</div>

		   
	   </div> <!-- end col md 4 -->






     <div class="col-md-4">



     <div class="form-group">
     <h5>Contact  <span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="Employee_contact" class="form-control" > 
@error('Employee_contact') 
<span class="text-danger">{{ $message}}</span>
@enderror
</div>
</div>

		   
	   </div> <!-- end col md 4 -->






     <div class="col-md-4">

     <div class="form-group">
     <h5>Email  <span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="Employee_email" class="form-control" > 
@error('Employee_email') 
<span class="text-danger">{{ $message}}</span>
@enderror 
</div>
</div>


		   
	   </div> <!-- end col md 4 -->




     <div class="col-md-4">

     <div class="form-group">
     <h5>Password <span class="text-danger">*</span></h5>
<div class="controls">
<input type="password"  name="Employee_password" class="form-control" > 
@error('Employee_password') 
<span class="text-danger">{{ $message}}</span>
@enderror 
</div>
</div>


  
</div> <!-- end col md 4 -->


<div class="col-md-4">
<div class="form-group">
<h5>Select Manager  <span class="text-danger">*</span></h5>
<div class="controls">
<select name="Employee_department" class="form-control" required="" >


<option value="" selected="" disabled="">Select Manager</option>
@foreach($Department as $item)
<option value="{{ $item->id }}">{{ $item->department }}</option>	
@endforeach	

</select>
@error('Employee_department') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
</div>


		   
	   </div> <!-- end col md 4 -->





     <div class="col-md-4">
     <h5>Department <span class="text-danger">*</span></h5>
<div class="controls">
<select name="Group" class="form-control" required="" >
<option value="" selected="" disabled="">Select Department</option>
@foreach($Group as $item)
<option value="{{ $item->id }}">{{ $item->Group }}</option>	
@endforeach
</select>
@error('Group') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
</div>

  
</div> <!-- end col md 4 -->


<div class="col-md-4">
<div class="form-group">
<h5>Position <span class="text-danger">*</span></h5>
<div class="controls">
<select name="Employee_position" class="form-control" required="" >
<option value="" selected="" disabled="">Select Position</option>
<option value="CEO">CEO</option>
<option value="Manager">Manager</option>
<option value="Employee">Employee</option>
</select>
@error('Employee_position') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
</div>

</div> <!-- end col md 4 -->



     
</div> <!-- 2nd row end-->



<div class="text-xs-right">
	<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Add">					 
</div>

</form>
 </div>

   </div>


</section>
</div>
</div>
</div>
   @endsection





















