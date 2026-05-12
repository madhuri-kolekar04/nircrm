






@extends('admin.admin_master')
@section('admin')


<div class="container-full">
		<!-- Content Header (Page header) -->
		  

		<!-- Main content -->
		<section class="content">
 
		 <!-- Basic Forms -->
		  <div class="box" >
   <div class="box-header with-border">
     <h3 class="box-title">Add sales</h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body" style="overflow:none;">
       <div >
    <!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 
<!--   ------------ Add sales Page -------- -->


<div class="col-md-4">


<form method="post" action="{{ route('sales.store') }}" >
@csrf




<div class="form-group">
<h5> ID <span class="text-danger">*</span></h5>
<input type="text"  name="sales_id" class="form-control"  > 
@error('sales_id') 
<span class="text-danger">{{ $message}}</span>
@enderror 
	</div>
		   
	   </div> <!-- end col md 4 -->

     <div class="col-md-4">

<div class="form-group">
<h5>Name<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="sales_name" class="form-control"  > 
@error('sales_name') 
<span class="text-danger">{{ $message}}</span>
@enderror 

	 </div>

</div>

</div> <!-- end col md 4 -->


<div class="col-md-4" style="display:none">

<div class="form-group">
<h5>Last Name<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="sales_last_name" class="form-control"  > 
@error('sales_name') 
<span class="text-danger">{{ $message}}</span>
@enderror 

	 </div>

</div>

</div> <!-- end col md 4 -->




<div class="col-md-4">



</div> <!-- end col md 4 -->




<div class="col-md-4">

<div class="form-group">
<h5>Contact<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="sales_contact" class="form-control"   > 
@error('sales_contact') 
<span class="text-danger">{{ $message}}</span>
@enderror 
</div>
</div>
				
	</div> <!-- end col md 4 -->


  <div class="col-md-4">
<div class="form-group">
<h5>  Email / User ID  <span class="text-danger">*</span></h5>
<div class="controls"> 
<input type="email"  name="sales_email" class="form-control"  > 
@error('sales_email') 
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
<input type="password"  name="sales_password" class="form-control" class="form-control" placeholder="Enter your new password" > 
@error('sales_password') 
<span class="text-danger">{{ $message}}</span>
@enderror 
</div>

	</div> 
</div>
 <!-- end col md 4 -->







 <div class="col-md-4">

<div class="form-group">
<h5> References By <span class="text-danger">*</span></h5>
<div class="controls">
   <select name="sales_department" class="form-control" required="" >
	   <option value="" selected="" disabled="">Select Department</option>
	   @foreach($Department as $item)
<option value="{{ $item->id }}">{{ $item->department }}</option>	
	   @endforeach
   </select>
   @error('sales_department') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
	</div>
		   
	   </div> <!-- end col md 4 -->


     
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








