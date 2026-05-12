@extends('admin.admin_master')
@section('admin')


  <!-- Content Wrapper. Contains page content -->
  
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		 

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			 


<!--   ------------ Add Ticket_status Page -------- -->


          <div class="col-12">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Edit Ticket Status </h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">


 <form method="post" action="{{ route('Ticket_status.update',$Ticket_status->id) }}" enctype="multipart/form-data">
	 	@csrf
	 <input type="hidden" name="Ticket_status_id" value="{{ $Ticket_status->id }}">	

	 <div class="form-group">
		<h5>Ticket status Name  <span class="text-danger">*</span></h5>
		<div class="controls">
	 <input type="text"  name="Ticket_status" class="form-control" value="{{ $Ticket_status->Ticket_status }}" > 
	 @error('Ticket_status') 
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