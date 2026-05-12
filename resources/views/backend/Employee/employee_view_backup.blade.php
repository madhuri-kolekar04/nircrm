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
				  <h3 class="box-title">Employee List <span class="badge badge-pill badge-danger"> {{ count($Employee) }} </span></h3>
				  <a href="{{ url('Employee/add') }}" style="float :right"class="btn btn-info"  title="Add Employee">
					 <span class="glyphicon glyphicon-plus"></span>
				</svg></a>

<div style="transform: scale(0.9); width: 110%; transform-origin: 0% 0% 0px;" class="box-body">
   @if (auth()->user()->employeeID == "admin")
     <div class="button-container">
        <button id="approvalButton" onclick="filterTable('Approval')" class="btn btn-success">Approval (0)</button>
        <button id="rejectedButton" onclick="filterTable('Rejected')" class="btn btn-danger">Rejected (0)</button>
    </div>
@endif
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
								<th>Designation</th>
								<th>Profile Pics</th>
								<th>Contact Number</th>
								<th>Email</th>
								<th>Department</th>
								<th>Online/Offline</th>
								<th>Controls</th>
								 
							</tr>
						</thead>
						<tbody>
	 @foreach($Employee as $key=> $item)
	 <tr>
	 @if($key <= 010)
	   		<td>{{'0'.$key+1}}</td>
	@else
			<td>{{$key+1}}</td>
	@endif
		<th style="font-size:20px;">{{$item->name}}</th>
		<th style="font-size:20px;">{{$item->employeeID}}</th>
		<th style="font-size:20px;">{{$item->designation}}</th>


		<td> <img class="rounded-circle" src="{{ (!empty($item->profile_photo_path))?url('upload/admin_images/'.$item->profile_photo_path):url('upload/no_image.jpg')  }}" alt="User Avatar" style="hight:70px; width:70px; ">  </td>
		<td>{{ $item->contact_number }}</td>
		 <td>{{ $item->email }} </td>
		 <td>{{ $item['departmentgetname']['department'] }} </td>
 <td style="font-size:20px;">
                @if($item->is_logged_in)
                    Online
                @else
                    Offline
                @endif
            </td>
		

		 
		<td>
 <a href="{{ route('Employee.edit',$item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i> </a>
 <a href="{{ route('Employee.delete',$item->id) }}" class="btn btn-danger" title="Delete Data" id="delete">
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



         
		</div>
		<!-- /.row -->
		</section>
		<!-- /.content -->
	  </div>
@stop
