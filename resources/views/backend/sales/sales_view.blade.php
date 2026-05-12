@extends('admin.admin_master')
@section('admin')

<style>
.table > tbody > tr > td{
	padding:0px 0px;
	font-size:20px;
}
</style>

  <!-- Content Wrapper. Contains page content -->
  
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		 

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			<div class="col-12">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Agents List <span class="badge badge-pill badge-danger"> {{ count($sales) }} </span></h3>
				  <a href="{{ url('sales/add') }}" style="float :right"class="btn btn-info"  title="Add sales">
					 <span class="glyphicon glyphicon-plus"></span>
				</svg></a>

				<!-- <a href="{{ route('export-user') }}" style="float :right"class="btn btn-info" title="Download">Export</a> -->

				</div>
				<!-- /.box-header -->
				<div  style="transform: scale(0.9);width: 110%; transform-origin: 0% 0% 0px;"  class="box-body">
					<div class="table-responsive">
					  <table id="example1"  class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
						<thead>
							<tr>
							    <th>ID</th>
								<th>Name</th>
								<th>Emp_ID</th>
								
								<th>Profile Pics</th>
								<th>Contact Number</th>
								<th>Email</th>
								<th>References By</th>
								<th>Controls</th>
								 
							</tr>
						</thead>
						<tbody>
	 @foreach($sales as $key=> $item)
	 <tr>
	 @if($key <= 010)
	   		<td>{{'0'.$key+1}}</td>
		@else
			<td>{{$key+1}}</td>
		@endif
		<th style="font-size:20px;">{{$item->name}}</th>
		<th style="font-size:20px;">{{$item->salesID}}</th>
		


		<td> <img class="rounded-circle" src="{{ (!empty($item->profile_photo_path))?url('upload/admin_images/'.$item->profile_photo_path):url('upload/no_image.jpg')  }}" alt="User Avatar" style="hight:70px; width:70px; ">  </td>
		<td>{{ $item->contact_number }}</td>
		 <td>{{ $item->email }} </td>
	

		

		 
		<td>
		@if (auth()->user()->role == 1 )
 <a href="{{ route('sales.edit',$item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i> </a>
 <a href="{{ route('sales.delete',$item->id) }}" class="btn btn-danger" title="Delete Data" id="delete">
 	<i class="fa fa-trash"></i></a>
		</td>
				@endif			 
	 </tr>
	  @endforeach
						</tbody>z
						 
					  </table>
					</div>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->

			          
			</div>
			<!-- /.col -->




         
 


		  </div>
		  <!-- /.row -->
		</section>
		<!-- /.content -->
	  
	  </div>
  



@endsection