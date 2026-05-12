@extends('admin.admin_master')
@section('admin')


<div class="container-full">
		<!-- Content Header (Page header) -->
		  

		<!-- Main content -->
		<section class="content">
 
		 <!-- Basic Forms -->
		  <div class="box" >
   <div class="box-header with-border">
     <h3 class="box-title">Edit Employee</h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body" style="overflow:none;">
       <div >
    <!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 
<!--   ------------ Add Employee Page -------- -->


<div class="col-md-4">


<form method="post" action="{{ route('Employee.update',$Employee->id) }}" >
@csrf




<div class="form-group">
<h5> ID <span class="text-danger">*</span></h5>
<input type="text"  name="Employee_id" class="form-control" value="{{$Employee->employeeID}}" > 
@error('Employee_id') 
<span class="text-danger">{{ $message}}</span>
@enderror 
	</div>
		   
	   </div> <!-- end col md 4 -->

     <div class="col-md-4">

<div class="form-group">
<h5>Name<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="Employee_name" class="form-control" value="{{ $Employee->name }}"  > 
@error('Employee_name') 
<span class="text-danger">{{ $message}}</span>
@enderror 

	 </div>

</div>



</div> <!-- end col md 4 -->

<div class="col-md-4" style="display:none">

<div class="form-group">
<h5>Last Name<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="Employee_last_name" class="form-control"  value="{{ $Employee->last_name }}" > 
@error('Employee_name') 
<span class="text-danger">{{ $message}}</span>
@enderror 

	 </div>

</div>

</div> <!-- end col md 4 -->



<div class="col-md-4">

<div class="form-group">
<h5>Designation<span class="text-danger">*</span></h5>
<div class="controls">
<select name="designation" class="form-control" required="" >
	   <option value="" selected="" disabled="">Select Department</option>
	   @foreach($Group as $item)
<option value="{{ $item->id }}" {{ $item->id ==  $item->Group ? 'selected' : '' }}>{{$item->Group  }}</option>	
	   @endforeach
   </select>
@error('Employee_designation') 
<span class="text-danger">{{ $message}}</span>
@enderror 

	 </div>

</div>

</div><!-- end col md 4 -->




<div class="col-md-4">

<div class="form-group">
<h5>Contact<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="Employee_contact" class="form-control"  value="{{ $Employee->contact_number}}" > 
@error('Employee_contact') 
<span class="text-danger">{{ $message}}</span>
@enderror 
</div>
</div>
				
	</div> <!-- end col md 4 -->


  <div class="col-md-4">
<div class="form-group">
<h5>  Email / User ID  <span class="text-danger">*</span></h5>
<div class="controls"> 
<input type="email"  name="Employee_email" class="form-control"  value="{{ $Employee->email}}"> 
@error('Employee_email') 
<span class="text-danger">{{ $message}}</span>
@enderror 
</div>
</div> 

</div> 
<!-- end col md 4 -->


<div class="col-md-4">

 <div class="form-group">
<h5> Password <span class="text-danger">*</span></h5>
<div class="controls">
<input type="password"  name="Employee_password" class="form-control" class="form-control" placeholder="Enter your new password" > 
@error('Employee_password') 
<span class="text-danger">{{ $message}}</span>
@enderror 
</div>

	</div> 
</div>
 <!-- end col md 4 -->


<div class="col-md-4">

<div class="form-group">
<h5>Department<span class="text-danger">*</span></h5>
<div class="controls">
<select name="Employee_department" class="form-control" required="" >
<option value="" selected="" disabled="">Select Department</option>
@foreach($Department as $item)
<option value="{{ $item->id }}" {{ $item->id ==  $item->department ? 'selected' : '' }}>{{$item->department  }}</option>	
@endforeach
</select>
@error('Employee_department') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
</div>
		   
	   </div> <!-- end col md 4 -->


     
</div> <!-- 2nd row end-->




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






