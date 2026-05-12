@extends('admin.admin_master')
@section('admin')


  <!-- Content Wrapper. Contains page content -->
  
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		 

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			<div class="col-8">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Ticket Status List <span class="badge badge-pill badge-danger"> {{ count($Ticket_status) }} </span></h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
					  <table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Id</th>
								<th>Ticket Status </th>
								<th>Controls</th>
								 
							</tr>
						</thead>
						<tbody>

	 @foreach($Ticket_status as $key=> $item)
	 <tr>
	 @if($key <= 010)
	   		<td>{{'0'.$key+1}}</td>
		@else
			<td>{{$key+1}}</td>
		@endif
		
		<td>{{ $item->Ticket_status }}</td>
		

		

		
		<td>
 <a href="{{ route('Ticket_status.edit',$item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i> </a>
 <a href="{{ route('Ticket_status.delete',$item->id) }}" class="btn btn-danger" title="Delete Data" id="delete">
 	<i class="fa fa-trash"></i></a>
		</td>
							 
	 </tr>
	  @endforeach
						</tbody>
						 
					  </table>
					</div>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->

			          
			</div>
			<!-- /.col -->


			
<!--   ------------ Add Ticket_status Page -------- -->


<div class="col-4">

<div class="box">
   <div class="box-header with-border">
	 <h3 class="box-title">Add Ticket Status </h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
	   <div class="table-responsive">


<form method="post" action="{{ route('Ticket_status.store') }}" >
@csrf
		  

<div class="form-group">
<h5>Add Ticket Status    <span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="Ticket_status" class="form-control" > 
@error('Ticket_status') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
</div>





		

<div class="text-xs-right">
<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Add New">					 
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