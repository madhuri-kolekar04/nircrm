@extends('admin.admin_master')
@section('admin')

<style>
.table > tbody > tr > td{
	padding:0px 0px;
	font-size:20px;
}
</style>

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
  <!-- Content Wrapper. Contains page content -->
  
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		 

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			<div class="col-12">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Customers List <span class="badge badge-pill badge-danger"> {{ count($reminder) }} </span></h3>
				  <a href="{{ url('reminder/add') }}" style="float :right"class="btn btn-info"  title="Add reminder">
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
							    <th>No.</th>
							
								<th>Customer_ID</th>
								
									<th>Project Name</th>
									<th>Group Name</th>
								<th>Contact No:</th>
							
								<th>Customers Details</th>
						
								<th>Controls</th>
								
								 
							</tr>
						</thead>
						<tbody>
	 @foreach($reminder as $key=> $item)
	 <tr>
	 @if($key <= 010)
	   		<td>{{'0'.$key+1}}</td>
		@else
			<td>{{$key+1}}</td>
		@endif
			<th style="font-size:20px;">{{$item->reminderID}}</th>
		<th style="font-size:20px;">{{$item->name}}</th>
		<th style="font-size:20px;">{{ $item->system_type_id }}</th>
		


	
		<td>{{ $item->contact_number }}</td>
		
		 <td>{{ $item->department }} </td>

		

		 
		<td>
		@if ((auth()->user()->role == 1) || (auth()->user()->role == 2) || (auth()->user()->role == 5))
 <a href="{{ route('reminder.edit',$item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i> </a>
 <a href="{{ route('reminder.delete',$item->id) }}" class="btn btn-danger" title="Delete Data" id="delete">
 	<i class="fa fa-trash"></i></a>
		</td>
				@endif			 
	 </tr>
	  @endforeach
						</tbody>
						 
					  </table>
					  
					  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                // Override the alert function to automatically dismiss the alert
                                window.alert = function(message) {
                                    console.log("Alert dismissed: " + message);
                                };

                                $(document).ready(function () {
                                    // Check if DataTable is already initialized and destroy if it is
                                    if ($.fn.DataTable.isDataTable('#example1')) {
                                        $('#example1').DataTable().destroy();
                                    }
                                    // Initialize DataTable
                                    $('#example1').DataTable({
                                        "paging": true,       // Enable pagination
                                        "pageLength": 99999,  // Set a high number to display all data on one page
                                        "lengthMenu": [[99999], ["All"]],  // Customize the length menu label
                                        "info": false         // Disable info text
                                    });
                                });
                            </script>
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