@extends('admin.admin_master')
@section('admin')


<div class="container-full">
		<!-- Content Header (Page header) -->
		  

		<!-- Main content -->
		<section class="content">
 
		 <!-- Basic Forms -->
		  <div class="box" >
   <div class="box-header with-border">
     <h3 class="box-title">Edit Customer</h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body" style="overflow:none;">
       <div >
    <!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 
<!--   ------------ Add reminder Page -------- -->


<div class="col-md-4">


<form method="post" action="{{ route('reminder.update',$reminder->id) }}" >
@csrf




<div class="form-group">
<h5> ID <span class="text-danger">*</span></h5>
<input type="text"  name="reminder_id" class="form-control" value="{{$reminder->reminderID}}" > 
@error('reminder_id') 
<span class="text-danger">{{ $message}}</span>
@enderror 
	</div>
		   
	   </div> <!-- end col md 4 -->

     <div class="col-md-4">

<div class="form-group">
<h5>Company Name<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="reminder_name" class="form-control" value="{{ $reminder->name }}"  > 
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
                <option value="" disabled>Select Group</option>
                @php
                    $sortedSystemTypes = $system_type->sortBy('system_type_name');
                @endphp
                @foreach($sortedSystemTypes as $item)
                    <option value="{{ $item->system_type_name }}" {{ $item->id == $reminder->system_type_id ? 'selected' : '' }}>
                        {{ $item->system_type_name }}
                    </option>
                @endforeach
            </select>
            @error('system_type_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<!-- end col md 4 -->

 <!-- end col md 4 -->


<div class="col-md-4" style="display:none">

<div class="form-group">
<h5>Last Name<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="reminder_last_name" class="form-control"  value="{{ $reminder->last_name }}" > 
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
                <option value="" disabled>Select Group</option>
                @php
                    $sortedOperatingSystems = $operating_system->sortBy('operating_system');
                @endphp
                @foreach($sortedOperatingSystems as $item)
                    <option value="{{ $item->operating_system }}" {{ $item->operating_system == $reminder->reminder_department ? 'selected' : '' }}>
                        {{ $item->operating_system }}
                    </option>
                @endforeach
            </select>
            @error('reminder_department')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

 <!-- end col md 4 -->


     
 <!-- end col md 4 -->

<div class="col-md-4">
    <div class="form-group">
        <h5>Work Type<span class="text-danger">*</span></h5>
        <div class="controls">
            <select name="location" class="form-control">
                <option value="">Select Department</option>
                <option value="Retailer" {{ $reminder->location == 'Retailer' ? 'selected' : '' }}>Retailer</option>
                <option value="One Time Assignment" {{ $reminder->location == 'One Time Assignment' ? 'selected' : '' }}>One Time Assignment</option>
               
                <!-- Add more options as needed -->
            </select>
            @error('location') 
            <span class="text-danger">{{ $message }}</span>
            @enderror 
        </div>
    </div>
</div>



<div class="col-md-4">

<div class="form-group">
<h5>Mobile Number<span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="reminder_contact" class="form-control"  value="{{ $reminder->contact_number}}" > 
@error('reminder_contact') 
<span class="text-danger">{{ $message}}</span>
@enderror 
</div>
</div>
				
	</div> <!-- end col md 4 -->



</div> 
<!-- end col md 4 -->



 <!-- end col md 4 -->


 <!-- 2nd row end-->




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






