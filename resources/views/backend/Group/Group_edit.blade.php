@extends('admin.admin_master')
@section('admin')


  <!-- Content Wrapper. Contains page content -->
  
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		 

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			 


<!--   ------------ Add Group Page -------- -->


          <div class="col-12">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Edit Tier </h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">


 <form method="post" action="{{ route('Group.update',$Group->id) }}" enctype="multipart/form-data">
	 	@csrf
	 <input type="hidden" name="Group_id" value="{{ $Group->id }}">	

	 <div class="form-group">
		<h5>Tier Name  <span class="text-danger">*</span></h5>
		<div class="controls">
	 <input type="text"  name="Group" class="form-control" value="{{ $Group->Group }}" > 
	 @error('Group') 
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