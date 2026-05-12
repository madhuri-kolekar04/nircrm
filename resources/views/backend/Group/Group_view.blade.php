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
				  <h3 class="box-title">Tier List <span class="badge badge-pill badge-danger"> {{ count($Group) }} </span></h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
					  <table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Id</th>
								<th>Tier </th>
								
								<th>Controls</th>
								 
							</tr>
						</thead>
						<tbody>
	@forEach($Group as $key=>$item)
	 <tr>
	 @if($key <= 010)
	   		<td>{{'0'.$key+1}}</td>
		@else
			<td>{{$key+1}}</td>
		@endif
		</td>
		

		
		<td>{{ $item->Group }}</td>
		

		

		
		<td>
 <a href="{{ route('Group.edit',$item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i> </a>
 <a href="{{ route('Group.delete',$item->id) }}" class="btn btn-danger" title="Delete Data" id="delete">
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
	 <h3 class="box-title">Add Tier </h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
	   <div class="table-responsive">


<form method="post" action="{{ route('Group.store') }}" >
@csrf
		  

<div class="form-group">
<h5> Tier    <span class="text-danger">*</span></h5>
<div class="controls">
<input type="text"  name="Group" class="form-control" > 
@error('Group') 
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