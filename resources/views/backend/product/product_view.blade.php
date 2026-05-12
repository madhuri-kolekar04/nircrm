
@extends('admin.admin_master')

@section('admin')

<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 



 
    <style>
        .button-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .button-container button {
            flex: 1 1 auto;
            min-width: 120px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        @media (max-width: 768px) {
            .table thead {
                display: none;
            }

            .table, .table tbody, .table tr, .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
            }

            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 45%;
                padding-right: 10px;
                text-align: left;
                white-space: nowrap;
            }
        }
    </style>
  
<style>
.table > tbody > tr > td{
	padding:5px 5px;
	font-size:17px;
	text-align:right;
	
}
/* span{
	font-size:17px  !important;
} */
.dt-button{
	display:none;
}

.badge{

	min-width: 100px !important;

}
.disabled a{
	color:black !important;
}
</style>



<!-- ------------------------------model code------------------------------------ -->
<div class="modal fade"  id="modal-default" style="display: none;" aria-hidden="true">
	  <div class="modal-dialog" role="document" >
		<div class="modal-content" style="background-color:#fff ;border-radius:10px">
		  <div class="modal-header"style="background-color:#000;border-radius:10px 10px 0 	0px">
			<h4 class="modal-title" style="color:white">Forword work to next group</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span></button>
		  </div>
		  <form method="post" action="{{ route('userassignupdate') }}" enctype="multipart/form-data" >
		 	@csrf
		  <div class="modal-body">
		     	<!--------------------------------form data start-----------------  -->


          <div class="row">

				 <div class="col-md-6">
		
				 <div class="form-group">
				 <h5>Tier  <span class="text-danger">*</span></h5>
				<div class="controls">
				<select   id="userId" name="tiergroup" class="form-control" required="" >
			
		        </select>
				<input  style="opacity:0;"  type="text" name="ticketid" value="" id="ticketid">


				
				</div>
				</div>

						

				</div> <!-- end col md 6 -->





         <div class="col-md-6">

						<div class="form-group">
			<h5>IT Technision Name <span class="text-danger">*</span></h5>
			<div class="controls">
				<select name="assign" class="form-control" required="" >
				
					
				</select>
			 
			</div>
				</div>
						
					</div> <!-- end col md 4 -->
			
					</div>



            <!-- --------------------------------form data ends-------------------- -->

		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-rounded btn-primary float-right">Submit</button>
		  </div>
		  </form>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
  </div>

		  <!-- ------------------------------------model closed--------------------------------- -->



  <!-- Content Wrapper. Contains page content -->
  
	  <div class="container-full">
		<!-- Content Header (Page header) -->
	
		@if ((auth()->user()->role == 2) || (auth()->user()->role == 1) || (auth()->user()->role == 4) || (auth()->user()->role == 5))
		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			<div class="col-12">

			 <div class="box">
				<div class="box-header with-border">
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
			

			@if ((auth()->user()->employeeID == "admin"))

				
				
				<a href="{{ route('add-product') }}" style="float :right"class="btn btn-info" title="Add Ticket"><i class="fa-solid fa-plus"></i></a>

			    
				
				
@endif
  @if ( (auth()->user()->role == 1) || (auth()->user()->role == 4)  )
				<h3 class="box-title">Leads <span class="badge badge-pill badge-danger"> {{ count($products) }} </span></h3>
				@endif
				
			  @if ( (auth()->user()->role == 2)  )
				<h3 class="box-title" > Total Leads: <span  id="total-count" class="badge badge-pill badge-danger" >:0 </span></h3>
				@endif
				
				</div>
				<!-- /.box-header -->
				<div style="transform: scale(0.9);width: 110%; transform-origin: 0% 0% 0px;" class="box-body">
					<div class="table-responsive">
				
					<!-- <button class="btn btn-primary" name="hidebtn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapseExample" onclick="(function() { document.getElementById('collapse1').classList.remove('show'); })();">Dounload</button> -->
					
		<div class="form-group">
    <h5>Employee Name<span class="text-danger">*</span></h5>
    <div class="controls">
        @if (auth()->user()->employeeID == "admin")
            <select id="employeeSelect" name="customer_name" class="form-control" required>
                <option value="" selected>Select Employee</option>
                @foreach($name->sortBy('name') as $item) <!-- Sort the collection here -->
                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                @endforeach
            </select>
        @else
            <select id="employeeSelect" name="customer_name" class="form-control" required>
                <option value="{{ auth()->user()->name }}" selected>{{ auth()->user()->name }}</option>
            </select>
        @endif
        @error('customer_name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>


					
    @if(auth()->user()->role == 1 || auth()->user()->role == 4)
<div class="mb-3">
    <a href="{{ route('add-product') }}" class="btn btn-success btn-lg">
        <i class="fa fa-plus"></i> ADD
    </a>
</div>
@endif

    <div class="button-container">
    <button class="btn btn-warning btn-filter" onclick="filterTable('Started')">Started (<span id="count-Started">0</span>)</button>
    <button class="btn btn-secondary btn-filter" onclick="filterTable('In Process')">In Process (<span id="count-InProcess">0</span>)</button>
    <button class="btn btn-success btn-filter" onclick="filterTable('Completed')">Completed (<span id="count-Completed">0</span>)</button>
    <button class="btn btn-primary btn-filter" onclick="filterTable('On Hold')">On Hold (<span id="count-OnHold">0</span>)</button>
    <button class="btn btn-danger btn-filter" onclick="filterTable('Not Started')">Not Started (<span id="count-NotStarted">0</span>)</button>
      <button class="btn btn-info btn-filter" onclick="filterTable('Sent For Approval')">Sent For Approval (<span id="count-SentForApproval">0</span>)</button>
    <button class="btn btn-info btn-filter" onclick="filterTable('Changes')">Changes (<span id="count-Changes">0</span>)</button>
    <button class="btn btn-light btn-filter" onclick="filterTable('All')">Show All</button>
</div>




        <div class="table-responsive">
          <table id="example3" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
    <thead>
        <tr>
            <th>ID</th>
            <th>Group Name</th>
            <th>Project Name</th>
            <th>Category Name</th>
            <th>Sub Work</th>
            <th>Sub Sub Work</th>
            <th>Work Details</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Due Info</th>
            <th>Assigned To</th>
            <th>Time</th>
            <th>Priority</th>
            <th>Status</th>
            <th>-</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @foreach($products->sortByDesc('created_at') as $item)
            <?php
                $assignedUserIds = json_decode($item->Assign, true);
                $assignedUsers = collect([]);
                if (!is_null($assignedUserIds) && is_array($assignedUserIds)) {
                    $assignedUsers = \App\Models\User::whereIn('id', $assignedUserIds)->get();
                }
                $isAssignedToLoggedInUser = $assignedUsers->contains('name', auth()->user()->name);
            ?>

            @if (auth()->user()->employeeID == 'admin' || $isAssignedToLoggedInUser)
                <tr id="ticket-{{ $item->id }}" data-status="{{ $item->status }}">
                    <td data-label="ID.Dept"><span class="badge">{{ $item->id }}</span></td>
                    <td data-label="Group" style="font-size:15px;"><span class="badge">{{ $item->system_type_id }}</span></td>
                    <td data-label="Project Name"><span class="badge">{{ $item->customerlist }}</span></td>
                    <td data-label="Work Details"><span class="badge">{{ $item['servicecategory']['service_category_name'] }}</span></td>
              <td data-label="Sub Work"><span class="badge">{{ $item['category']['category_name_en'] }}</span></td>
                    <td data-label="Sub Sub Work">
                        @if (isset($item['subcategory']))
                            <span class="badge">{{ $item['subcategory']['subcategory_name_en'] }}</span>
                        @else
                            <span class="badge">-</span>
                        @endif
                    </td>
                    <td data-label="Work Details">
                        <span class="badge">
                            {{ Illuminate\Support\Str::limit(strip_tags($item['long_descp_en']), 25, '.....') }}
                        </span>
                    </td>
                    <td data-label="Start Date"><span class="badge">{{ \Carbon\Carbon::parse($item->Department_id)->format('d/m/Y') }}</span></td>
                    <td data-label="End Date" class="end-date"><span class="badge">{{ \Carbon\Carbon::parse($item->product_name_en)->format('d/m/Y') }}</span></td>
                    <td data-label="Due Info" class="due-info"><span class="badge">{{ $item['due_info'] }}</span></td>
                    <td data-label="Assigned To" class="status">
                        @if($assignedUsers->count() > 0)
                            @foreach($assignedUsers as $user)
                                <span class="badge badge-primary">{{ $user->name }}</span>
                            @endforeach
                        @else
                            <span class="badge badge-danger">Not Assigned</span>
                        @endif
                    </td>
                    <td data-label="Time"><span class="badge">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($item->created_at))->diffForHumans() }}</span></td>
                    <td data-label="Priority" class="priority">
                        @if(str_contains(strtolower($item['due_info']), 'overdue'))
                            <span class="badge badge-danger">High</span>
                        @else
                            @if($item->brand_id == 1)
                                <span class="badge badge-danger">High</span>
                            @elseif($item->brand_id == 2)
                                <span class="badge" style="background-color:#F5EA5A">Low</span>
                            @elseif($item->brand_id == 3)
                                <span class="badge" style="background-color:#F2921D">Medium</span>
                            @endif
                        @endif
                    </td>
                    <td data-label="Status">
                        @if($item->status == 1)
                            <span class="badge badge-pill" style="background-color:#F99417">Started</span>
                        @elseif($item->status == 2)
                            <span class="badge badge-pill" style="background-color:#BDCDD6">In Process</span>
                        @elseif($item->status == 3)
                            <span class="badge badge-pill badge-success">Completed</span>
                        @elseif($item->status == 4)
                            <span class="badge badge-pill" style="background-color:#00FFD1">On Hold</span>
                        @elseif($item->status == 5)
                            <span class="badge badge-pill" style="background-color:#F99417">Not Started</span>
                        @elseif($item->status == 6)
                            <span class="badge badge-pill" style="background-color:#F99417">Sent For Approval</span>
                         @elseif($item->status == 8)
                            <span class="badge badge-pill" style="background-color:#007BFF">Changes</span>
                     
                        @else
                            <span class="badge badge-pill" style="background-color:#FFD4B2">No status</span>
                        @endif
                    </td>
                    <td data-label="-">
                        <div style="width:250px">
                            <a href="{{ route('product.preview', $item->id) }}" class="btn btn-info" title="Preview Product"><i class="fa fa-eye"></i></a>
                            @if(auth()->user()->employeeID == 'admin')
                                <a href="{{ route('product.edit', $item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i></a>
                            @endif
                            @if(auth()->user()->employeeID !== 'admin')
                                <a href="{{ route('product.editemp', $item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i></a>
                            @endif
                            @if(auth()->user()->employeeID == 'admin')
                                <a href="{{ route('product.delete', $item->id) }}" class="btn btn-danger" title="Delete Data" id="delete"><i class="fa fa-trash"></i></a>
                            @endif
                        </div>
                    </td>
                </tr>
                <?php $i++; ?>
            @endif
        @endforeach
    </tbody>
</table>

            
            
         <script>
document.addEventListener('DOMContentLoaded', function() {
    const employeeSelect = document.getElementById('employeeSelect');
    const employeeTable = document.getElementById('example3');
    const rows = employeeTable.querySelectorAll('tbody tr');

    function filterRows() {
        const selectedEmployee = employeeSelect.value;

        rows.forEach(row => {
            const assignedToCells = row.querySelectorAll('.status .badge');
            let employeeFound = false;

            assignedToCells.forEach(cell => {
                if (cell.textContent === selectedEmployee) {
                    employeeFound = true;
                }
            });

            if (selectedEmployee === "" || employeeFound) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Filter rows initially if the user is not an admin
    @if (auth()->user()->employeeID != "admin")
        filterRows();
    @endif

    employeeSelect.addEventListener('change', filterRows);
});
</script>

 	 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                // Override the alert function to automatically dismiss the alert
                                window.alert = function(message) {
                                    console.log("Alert dismissed: " + message);
                                };

                                $(document).ready(function () {
                                    // Check if DataTable is already initialized and destroy if it is
                                    if ($.fn.DataTable.isDataTable('#example1')) {
                                        $('#example3').DataTable().destroy();
                                    }
                                    // Initialize DataTable
                                    $('#example3').DataTable({
                                        
                                        
        dom: 'Bfrtip',
       
   

                                        "paging": true,       // Enable pagination
                                        "pageLength": 99999,  // Set a high number to display all data on one page
                                        "lengthMenu": [[99999], ["All"]],  // Customize the length menu label
                                        "info": false         // Disable info text
                                    });
                                });
                            </script>

<script>
$(document).ready(function() {
    // Find all <td> elements with class "priority" containing "High"
    $('#example3 .priority').each(function() {
        if ($(this).text().trim() === 'High') {
            $(this).html('<span class="badge badge-danger">High</span>');
        }
    });
});
</script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('#example3 tbody tr');

            function calculateDueInfo(endDateStr) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                const [day, month, year] = endDateStr.split('/');
                const endDate = new Date(year, month - 1, day);
                endDate.setHours(0, 0, 0, 0);

                const timeDiff = endDate.getTime() - today.getTime();
                const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if (dayDiff < 0) {
                    return `Overdue by ${Math.abs(dayDiff)} days`;
                } else if (dayDiff === 0) {
                    return `Due today`;
                } else {
                    return `${dayDiff} days remaining`;
                }
            }

            rows.forEach(row => {
                const endDateElem = row.querySelector(' .end-date .badge');
                const dueInfoBadge = row.querySelector('.due-info .badge');
                const priorityBadge = row.querySelector('.priority .badge');

                if (endDateElem && dueInfoBadge) {
                    const dueInfo = calculateDueInfo(endDateElem.textContent);
                    dueInfoBadge.textContent = dueInfo;

                    if (dueInfo.startsWith('Overdue')) {
                        priorityBadge.classList.remove('badge-success', 'badge-warning', 'badge-info');
                        priorityBadge.classList.add('badge-danger');
                        priorityBadge.textContent = 'High';
                    } else {
                        const brandId = row.getAttribute('data-brand-id');
                        if (brandId == 1) {
                            priorityBadge.classList.remove('badge-success', 'badge-warning', 'badge-danger');
                            priorityBadge.classList.add('badge-danger');
                            priorityBadge.textContent = 'High';
                        } else if (brandId == 2) {
                            priorityBadge.classList.remove('badge-success', 'badge-warning', 'badge-danger');
                            priorityBadge.classList.add('badge-warning');
                            priorityBadge.textContent = 'Low';
                        } else if (brandId == 3)  {
                            priorityBadge.classList.remove('badge-success', 'badge-warning', 'badge-danger');
                            priorityBadge.classList.add('badge-info');
                            priorityBadge.textContent = 'Medium';
                        }
                    }
                }
            });
        });
    </script>



<script>
document.addEventListener("DOMContentLoaded", function() {
    updateStatusCounts();
});

function updateStatusCounts() {
    const statusCounts = {
        'Started': 0,
        'In Process': 0,
        'Completed': 0,
        'On Hold': 0,
        'Not Started': 0,
        'Sent For Approval': 0,
        'Changes': 0,
    };

    // Get all rows in the table body
    const rows = document.querySelectorAll("#example3 tbody tr");

    // Iterate through the rows and count each status
    rows.forEach(row => {
        const statusCell = row.querySelector("td:nth-child(14) span");
        if (statusCell) {
            const status = statusCell.textContent.trim();
            switch (status) {
                case 'Started':
                    statusCounts.Started++;
                    break;
                case 'In Process':
                    statusCounts['In Process']++;
                    break;
                case 'Completed':
                    statusCounts.Completed++;
                    break;
                case 'On Hold':
                    statusCounts['On Hold']++;
                    break;
                case 'Not Started':
                    statusCounts['Not Started']++;
                    break;
                    case 'Changes':
                    statusCounts['Changes']++;
                    break;
                      case 'Sent For Approval':
                    statusCounts['Sent For Approval']++;
                    break;
                default:
                    break;
            }
        }
    });

    // Update the button counts
    document.getElementById("count-Started").textContent = statusCounts.Started;
    document.getElementById("count-InProcess").textContent = statusCounts['In Process'];
    document.getElementById("count-Completed").textContent = statusCounts.Completed;
    document.getElementById("count-OnHold").textContent = statusCounts['On Hold'];
    document.getElementById("count-NotStarted").textContent = statusCounts['Not Started'];
    document.getElementById("count-SentForApproval").textContent = statusCounts['Sent For Approval'];
     document.getElementById("count-Changes").textContent = statusCounts['Changes'];
}

function filterTable(status) {
    const rows = document.querySelectorAll("#example3 tbody tr");
    rows.forEach(row => {
        const statusCell = row.querySelector("td:nth-child(14) span");
        if (statusCell) {
            if (status === 'All' || statusCell.textContent.trim() === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}
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
		@else
		@endif


			
		@if ((auth()->user()->role == 3) )
		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			<div class="col-12">

			 <div class="box">
				<div class="box-header with-border">
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
				<a href="{{ route('add-productuser') }}" style="float :right"class="btn btn-info" title="Add Ticket"><i class="fa-solid fa-plus"></i></a>
				  <h3 class="box-title">Ticket List 
				  @if ( (auth()->user()->role == 1) || (auth()->user()->role == 5)  )  )
				  <span class="badge badge-pill badge-danger"> {{ count($products) }} </span>
				@endif
					  @if ( (auth()->user()->role == 2))  )
				  <span class="badge badge-pill badge-danger"> {{ count($products) }} </span>
				@endif
				</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
				
					<table id="example1" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
						<thead>
							<tr>
							<!-- <th>Ticket ID </th> -->
								<!-- <th>Image </th> -->
								<th>Name</th>
							
								
								<th>Emp_ID</th>
								<th>Executive Name</th>
								
								<th>Project Name</th>
								<th>Main Notes</th>
								<th>Sub_Notes</th>
							
								<th>Assigned</th>
								<th>Time</th>
								<th>Priority</th>
								<th>Status </th>
							
								
								
								 
							</tr>
						</thead>
					
						<tbody>
	 @foreach($userData as  $key=>$item)
	 <tr>
		
	 @if($key <= 010)
	   		<td>{{'0'.$key+1}}</td>
		@else
			<td>{{$key+1}}</td>
		@endif
		<!-- <td> <img src="{{ (!empty($item->product_thambnail))? asset($item->product_thambnail):url('upload/no_image.jpg') }}" style="width: 60px; height: 50px;">  </td> -->
		<td><span class="badge badge-pill " style="font-size:17px">{{ $item['usergetname']['name'] }} </span></td>
       
        <td><span class="badge badge-pill " style="font-size:17px">{{ $item['usergetname']['employeeID'] }}<Span></td>
        <td ><span class="badge badge-pill " style="font-size:17px"> {{ $item['departmentfuc']['department'] }}</span></td>
        <td><span class="badge badge-pill " style="font-size:17px">  {{ $item['servicecategory']['service_category_name'] }} <Span> </td> 
		<td> <span class="badge badge-pill " style="font-size:17px">{{ $item['category']['category_name_en'] }}  </span></td>
		<td> <span class="badge badge-pill " style="font-size:17px">{{ $item['subcategory']['subcategory_name_en'] }} </span></td>
		<?php
    // Decode the JSON string
    $assignedUserIds = json_decode($item->Assign, true);

    // Initialize $assignedUsers as an empty collection
    $assignedUsers = collect([]);

    // Retrieve users only if $assignedUserIds is not null and is an array
    if (!is_null($assignedUserIds) && is_array($assignedUserIds)) {
        $assignedUsers = \App\Models\User::whereIn('id', $assignedUserIds)->get();
    }
?>

<td>
    @if($assignedUsers->count() > 0)
        @foreach($assignedUsers as $user)
            <span class="badge badge-primary">{{ $user->name }}</span>
        @endforeach
    @else
        <span class="badge badge-danger">Not Assigned</span>
    @endif
</td>


			<td id="timer">
		 <span class="badge badge-pill " style="font-size:17px"> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($item->created_at))->diffForHumans() }}</span>
		 </td>
		
	
		 <td>
		@if( $item->brand_id == 1)
		 	<span class="badge badge-pill badge-danger"> High </span>
		 	@elseif($item->brand_id == 2)
			 <span class="badge badge-pill "style="background-color:#F5EA5A"> Low </span>
			 @else
			 <span class="badge badge-pill " style="background-color:#F2921D"> Medium </span>
		@endif
		</td>
		 <td>
		
				 @if($item->status == 1)
						<span class="badge badge-pill " style="background-color:#5BC0F8"> Started </span>	
						@elseif($item->status == 2)
						<span class="badge badge-pill" style="background-color:#BDCDD6"> In Process </span>
						@elseif($item->status == 4)
						<span class="badge badge-pill badge-danger"> Completed </span>
						@elseif($item->status == 3)
						<span class="badge badge-pill" style="background-color:#00FFD1"> OnHold </span>
						@elseif($item->status == 5)
						<span class="badge badge-pill" style="background-color:#F99417"> Not Started </span>
					
							@else
						<span class="badge badge-pill "style="background-color:#FFD4B2"> No status </span>
				@endif
		
		 </td>

		

		

		
<!-- @if($item->status == 1)
 <a href="{{ route('product.inactive',$item->id) }}"  style="padding:5px 10px; margin:5px 5px" class="btn btn-danger" title="Inactive Now"><i class="fa fa-arrow-down"></i> </a>
	 @else
 <a href="{{ route('product.active',$item->id) }}" style="padding:5px 10px; margin:5px 5px" class="btn btn-success" title="Active Now"><i class="fa fa-arrow-up"></i> </a>
	 @endif -->




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
		@else
		@endif
	  
	  </div>
  
	 
<script type="text/javascript">
    var element = document.getElementsByClassName("dt-button");
    
    setInterval(function() {
        window.location.reload();
    }, 270000); // 90000 milliseconds is 1 minute and 30 seconds
</script>




<!-- 
<script>
var count = 3600;
var counter = setInterval(function timerDown() {
    count = count - 1;
    if (count === -1) {
        clearInterval(counter);
        return;
    }

    var seconds = count % 60,
        minutes = Math.floor(count / 60),
        hours = Math.floor(minutes / 60);
    minutes %= 60;
    hours %= 60;
  
  if ( minutes < 10) {
    
    minutes = '0' + minutes;
  }
  
  if ( hours < 10 ) {
    
    hours = '0' + hours;
  }
  
  if ( seconds < 10 ) {
    
    seconds = '0' + seconds;
  }  

    document.getElementById("countdown").innerHTML = hours + ":" + minutes + ":" + seconds; 
} , 1000); -->
<!-- 
</script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script> -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

 
<script >

$(document).on('click' , '#excelate',function() {
// alert('hi');
     var ticket_id = $(this).val();
	//  $('').model('show');
	 $.ajax({
		type:'GET',
		url:'/excalate/assign/'+ticket_id,
		
		success: function($getticketdata){
		
			var d =$('select[name="tiergroup"]').empty();
			$('select[name="tiergroup"]').append('<option value=""> Select Tier</option>');
			  $.each($getticketdata.group, function(key, value){
				// console.log(value[0])
				  $('select[name="tiergroup"]').append('<option value="'+ value.id +'">' + value.Group + '</option>');
			  });
			  $('#ticketid').val($getticketdata.ticket[0].id);

		},
	 });

 });


 $('select[name="tiergroup"]').on('change', function(){

var Group_ID = $(this).val();

if(Group_ID) {
	$.ajax({
		url: "{{  url('/product/Ticket_IT_Supporter/ajax') }}/"+Group_ID,
		type:"GET",
		dataType:"json",
		success:function(data) {
			
		   var d =$('select[name="assign"]').empty();

			  $.each(data, function(key, value){
			 
				  $('select[name="assign"]').append('<option value="'+ value.id +'">' + value.name + '</option>');
			  });
		},
	});
} else {
	alert('danger');
}
});

</script>


<script>
		
	// 	$('#example3').DataTable( {
	// 	dom: 'Bfrtip',
	// 	buttons: [
	// 		'copy', 'csv', 'excel', 'pdf', 'print'
	// 	],

	// } );
	
	// $('#example1').DataTable( {
	// 	dom: 'Bfrtip',
	// 	buttons: [
	// 		'copy', 'csv', 'excel', 'pdf', 'print'
	// 	],

	// } );
	
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        updateTotalCount();

        // Function to update the total count
        function updateTotalCount() {
            const table = document.getElementById('example3');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            const totalCount = rows.length;
            document.getElementById('total-count').textContent = ' ' + totalCount;

            // Update status counts
            updateStatusCounts(rows);
        }

        // Function to update the counts for each status
        function updateStatusCounts(rows) {
            const statusCounts = {
                'Assigned': 0,
                'Resolved': 0,
                'Open': 0,
                'OnHold': 0,
                'InProgress': 0,
                'Closed': 0,
                'Cancelled': 0,
                'All': rows.length
            };

            for (let row of rows) {
                const status = row.getAttribute('data-status');
                if (status) {
                    statusCounts[status]++;
                }
            }

            for (let status in statusCounts) {
                document.getElementById('count-' + status).textContent = statusCounts[status];
            }
        }
    });
</script>





@endsection




