@extends('admin.admin_master')
@section('admin')


  <!-- Content Wrapper. Contains page content -->
  
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		 

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			 


<!--   ------------ Add Action Page -------- -->


          <div class="col-12">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Edit Action </h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">


 <form method="post" action="{{ route('Action.update',$Action->id) }}" enctype="multipart/form-data">
	 	@csrf
	 <input type="hidden" name="Action_id" value="{{ $Action->id }}">	

	 <div class="form-group">
		<h5>Action Name  <span class="text-danger">*</span></h5>
		<div class="controls">
	 <input type="text"  name="Action" class="form-control" value="{{ $Action->action_name }}" > 
	 @error('Action') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	</div>
	</div>







					 

			 <div class="text-xs-right">
	<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update">					 
						</div>
					</form>




					  
					</div>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box --> 
			</div>

 


		  </div>
		  <!-- /.row -->
		</section>
		<!-- /.content -->
	  
	  </div>
  



@endsection