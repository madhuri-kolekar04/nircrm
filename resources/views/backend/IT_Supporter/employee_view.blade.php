@extends('admin.admin_master')
@section('admin')
  
<style>
.table > tbody > tr > td {
	padding:0px 0px !important;
	font-size:17px ;

}
.actioncenter{
	display:flex;
	justify-content:center;
	align-item:center
}

</style>
<style>
    .status-online {
    color: green;
    font-weight: bold;
}

.status-offline {
    color: red;
    font-weight: bold;
}

</style>
<style>
.button-container {
    display: flex;
    justify-content: center;
    align-items: center;
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
				  <h3 class="box-title">Employees List <span  class="badge badge-pill badge-danger"> {{ count($Employee) }} </span></h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  @if (auth()->user()->employeeID == "admin" || auth()->user()->role == 5)
				  <h3 class="box-title">Online <span class="badge badge-pill badge-success">{{ $Employee->where('is_logged_in', true)->count() }}</span></h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             <h3 class="box-title">Offline <span class="badge badge-pill badge-danger">{{ $Employee->where('is_logged_in', false)->count() }}</span></h3>
             @endif
				   @if (( auth()->user()->role == 1) || (auth()->user()->role == 5))
				  <a href="{{ url('ITEmployee/add') }}" style="float :right"class="btn btn-info"  title="Add Technician">
					 <span class="glyphicon glyphicon-plus"></span>
					 @endif
				</svg></a>
				<!-- <a href="{{ route('export-user') }}" style="float :right"class="btn btn-info" title="Download">Export</a> -->
								</div>

								
				<!-- /.box-header -->
				<div style="transform: scale(0.9);width: 110%; transform-origin: 0% 0% 0px;" class="box-body">

					<div class="table-responsive">
					<!-- Count of Online Employees -->

<div style="transform: scale(0.9); width: 110%; transform-origin: 0% 0% 0px;" class="box-body">
    @if (auth()->user()->employeeID == "admin" || auth()->user()->role == 5)
        <div class="button-container">
            <button id="approvalButton" onclick="filterTable('Online')" class="btn btn-success">Online (0)</button>
            <button id="rejectedButton" onclick="filterTable('Offline')" class="btn btn-danger">Offline (0)</button>
        </div>
    @endif

<!-- Table -->
<table id="example1" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
    <thead>
        <tr> 
            <th>ID</th>
            <th>Employee Name</th>
             @if (auth()->user()->employeeID == "admin" || auth()->user()->role == 5)
           
            @endif
            <th>Profile Pics</th>
             @if (auth()->user()->employeeID == "admin" || auth()->user()->role == 5)
            <th>Contact Number</th>
            @endif
            <th>Email</th>
            <th>Department</th>
            @if (auth()->user()->employeeID == "admin" || auth()->user()->role == 5)
                <th>Online/Offline</th>
                 <th>Today Login Time</th>
                 <th>Last Time Login</th>
                <th>Controls</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($Employee as $key => $item)
        <tr>
            @if($key < 10)
                <td>{{ '0' . ($key + 1) }}</td>
            @else
                <td>{{ $key + 1 }}</td>
            @endif

            <td style="font-weight:900;">
                <span class="badge badge-pill">{{ $item->name }}</span>
            </td>
           
            <td>
                <img class="rounded-circle" src="{{ !empty($item->profile_photo_path) ? url('upload/admin_images/' . $item->profile_photo_path) : url('upload/no_image.jpg') }}" alt="User Avatar" style="height:70px; width:70px; padding:0;">
            </td>
             @if (auth()->user()->employeeID == "admin" || auth()->user()->role == 5)
            <td>{{ $item->contact_number }}</td>
            @endif
            <td>{{ $item->email }}</td>
            <td>{{ $item['Groupname']['Group'] ?? '' }}</td>
            @if (auth()->user()->employeeID == "admin" || auth()->user()->role == 5)
                <td class="status" style="font-size:20px; font-weight:bold; color: {{ $item->is_logged_in ? 'green' : 'red' }};">
                        {{ $item->is_logged_in ? 'Online' : 'Offline' }}
                    </td>
                   <td class="updated_at" data-employee-id="{{ $item->id }}" data-timestamp="{{ $item->updated_at }}">
                {{ $item->updated_at }}
            </td>
            
             <td class="last_at" data-employee-id="{{ $item->id }}" data-timestamp="{{ $item->last_at }}">
                {{ $item->updated_at }}
            </td>
                <td>
                     
                    <div style="width:170px" class="actioncenter">
                        <a href="{{ route('ITEmployee.edit', $item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i></a>
                        <a href="{{ route('ITEmployee.delete', $item->id) }}" class="btn btn-danger" title="Delete Data" id="delete"><i class="fa fa-trash"></i></a>
                    </div>
                </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
			<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updatedAtElements = document.querySelectorAll('td.last_at');
        const currentTimestamp = new Date().getTime();

        updatedAtElements.forEach((element, index) => {
            const employeeId = element.getAttribute('data-employee-id');
            const localStorageKey = employee_${employeeId}_updated_at;

            // Check if there's a stored timestamp in localStorage
            const storedTimestamp = localStorage.getItem(localStorageKey);

            if (storedTimestamp) {
                const storedTimestampTime = new Date(storedTimestamp).getTime();
                const timeDifference = currentTimestamp - storedTimestampTime;

                // 24 hours in milliseconds
                const twentyFourHours = 24 * 60 * 60 * 1000;

                if (timeDifference < twentyFourHours) {
                    // Use the cached timestamp if it's within 24 hours
                    element.textContent = storedTimestamp;
                    return;
                }
            }

            // Update the timestamp and store it in localStorage
            const newTimestamp = element.getAttribute('data-timestamp');
            localStorage.setItem(localStorageKey, newTimestamp);
            element.textContent = newTimestamp;
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updatedAtElements = document.querySelectorAll('td.updated_at');
        
        updatedAtElements.forEach((element) => {
            const employeeId = element.getAttribute('data-employee-id');
            const localStorageKey = `employee_${employeeId}_updated_at`;
            const localStorageDateKey = `employee_${employeeId}_date`;

            // Check if there's a stored timestamp in localStorage
            const storedTimestamp = localStorage.getItem(localStorageKey);
            const storedDate = localStorage.getItem(localStorageDateKey);

            // Function to extract date from timestamp (format: YYYY-MM-DD)
            const extractDate = (timestamp) => timestamp.split(' ')[0];

            // Fetch the current timestamp (assuming the element has the new timestamp in data-timestamp attribute)
            const newTimestamp = element.getAttribute('data-timestamp');
            const newDate = extractDate(newTimestamp);

            // Check if the stored date is different from the new date
            if (storedDate !== newDate) {
                // If the date has changed, update localStorage with the new timestamp and date
                localStorage.setItem(localStorageKey, newTimestamp);
                localStorage.setItem(localStorageDateKey, newDate);
                element.textContent = newTimestamp;
            } else {
                // If the date hasn't changed, use the cached timestamp
                element.textContent = storedTimestamp;
            }
        });
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
  
  
<script>
    function updateButtonCounts() {
        var table, tr, td, i;
        var onlineCount = 0;
        var offlineCount = 0;

        table = document.getElementById("example1");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) { // Start from 1 to skip header
            td = tr[i].getElementsByClassName("status")[0];
            if (td) {
                if (td.innerHTML.indexOf('Online') > -1) {
                    onlineCount++;
                } else if (td.innerHTML.indexOf('Offline') > -1) {
                    offlineCount++;
                }
            }
        }

        document.getElementById('approvalButton').innerHTML = `Online (${onlineCount})`;
        document.getElementById('rejectedButton').innerHTML = `Offline (${offlineCount})`;
    }

    function filterTable(status) {
        var table, tr, td, i;
        table = document.getElementById("example1");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByClassName("status")[0];
            if (td) {
                if (td.innerHTML.indexOf(status) > -1) {
                    tr[i].style.display = ""; // Show row
                } else {
                    tr[i].style.display = "none"; // Hide row
                }
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateButtonCounts();
    });
</script>
<script type="text/javascript">
    var element = document.getElementsByClassName("dt-button");

    setInterval(function() {
        window.location.reload();
    }, 50000); // 30000 milliseconds is 30 seconds
</script>



@endsection