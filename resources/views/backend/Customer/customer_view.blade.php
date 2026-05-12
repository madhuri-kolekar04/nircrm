@extends('admin.admin_master')
@section('admin')

<style>
.table > tbody > tr > td{
	padding:0px 0px;
	font-size:20px;
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
    
    <script>
  document.addEventListener('DOMContentLoaded', function() {
    const employeeSelect = document.getElementById('employeeSelect');
    const employeeTable = document.getElementById('employeeTable');
    const rows = employeeTable.querySelectorAll('tbody tr');

    function filterRows() {
        const selectedEmployee = employeeSelect.value;

        rows.forEach(row => {
            if (selectedEmployee === "" || row.getAttribute('data-employee-name') === selectedEmployee) {
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

  <!-- Content Wrapper. Contains page content -->
  
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		 

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			<div class="col-12">

			 <div class="box">
				<div class="box-header with-border">
				      @if (auth()->user()->employeeID == "admin")
				  <h3 class="box-title">Employees Leave List <span class="badge badge-pill badge-danger"> {{ count($customer) }} </span></h3>
				  @endif
				  
				@if (auth()->user()->employeeID !== "admin")
    <h3 class="box-title"> Employees Leave List <span id="total-count" class="badge badge-pill badge-danger">:0</span></h3>
@endif

<script>
document.addEventListener("DOMContentLoaded", function() {
    updateTotalCount();

    // Function to update the total count
    function updateTotalCount() {
        const table = document.getElementById('employeeTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        // Count only the visible rows
        let visibleCount = 0;
        for (let row of rows) {
            if (row.style.display !== 'none') {
                visibleCount++;
            }
        }
        
        document.getElementById('total-count').textContent = ' ' + visibleCount;

        // Update status counts
        updateStatusCounts(rows);
    }

    // Function to update the counts for each status
    function updateStatusCounts(rows) {
        const statusCounts = {
            'All': 0
        };

        for (let row of rows) {
            if (row.style.display !== 'none') {
                const status = row.getAttribute('data-status');
                if (status) {
                    if (!statusCounts[status]) {
                        statusCounts[status] = 0;
                    }
                    statusCounts[status]++;
                }
                statusCounts['All']++;
            }
        }

        for (let status in statusCounts) {
            const countElement = document.getElementById('count-' + status);
            if (countElement) {
                countElement.textContent = statusCounts[status];
            }
        }
    }
});
</script>

				  <a href="{{ url('customer/add') }}" style="float :right"class="btn btn-info"  title="Add customer">
					 <span class="glyphicon glyphicon-plus"></span>
				</svg></a>

				<!-- <a href="{{ route('export-user') }}" style="float :right"class="btn btn-info" title="Download">Export</a> -->
				<div>
  <br><br>
<div class="form-group">
    <h5>Employee Name<span class="text-danger">*</span></h5>
    <div class="controls">
        @if (auth()->user()->employeeID == "admin")
            <select id="employeeSelect" name="customer_name" class="form-control" required>
                <option value="" selected disabled>Select Employee</option>
                @foreach($name as $item)
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

<div style="transform: scale(0.9); width: 110%; transform-origin: 0% 0% 0px;" class="box-body">
   @if (auth()->user()->employeeID == "admin")
     <div class="button-container">
        <button id="approvalButton" onclick="filterTable('Approval')" class="btn btn-success">Approval (0)</button>
        <button id="rejectedButton" onclick="filterTable('Rejected')" class="btn btn-danger">Rejected (0)</button>
    </div>
@endif

    <div class="table-responsive">
        <table id="employeeTable" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Leave Reason</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Days</th>
                    <th>Status</th>
                    <th>Admin Note</th>
                    @if (auth()->user()->employeeID == "admin")
                        <th>Controls</th>
                    @endif
                    
                      @if (auth()->user()->employeeID !== "admin")
                        <th>Controls</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($customer as $key => $item)
                    <tr data-employee-name="{{ $item->name }}">
                        <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td style="font-size:20px;">{{ $item->name }}</td>
                        <td>{{ $item->contact_number }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->comapny_name)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->location)->format('d/m/Y') }}</td>
                        <td>{{ $item->service }}</td>
                        <td class="status">{{ $item->profile_photo_path }}</td>
                        <td>{{ $item->reason }}</td>
                        @if (auth()->user()->employeeID == "admin")
                        <td>
                            
                            <a href="{{ route('customer.edit', $item->id) }}" class="btn btn-info" title="Edit Data">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="{{ route('customer.delete', $item->id) }}" class="btn btn-danger" title="Delete Data" id="delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                        @endif
                        
                          @if (auth()->user()->employeeID !== "admin")
                        <td>
                            
                            <a href="{{ route('customer.edit', $item->id) }}" class="btn btn-info" title="Edit Data">
                                <i class="fa fa-pencil"></i>
                            </a>
                           
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function updateButtonCounts() {
        var table, tr, td, i;
        var approvalCount = 0;
        var rejectedCount = 0;

        table = document.getElementById("employeeTable");
        tr = table.getElementsByTagName("tr");
        
        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByClassName("status")[0];
            if (td) {
                if (td.innerHTML.indexOf('Approval') > -1) {
                    approvalCount++;
                } else if (td.innerHTML.indexOf('Rejected') > -1) {
                    rejectedCount++;
                }
            }       
        }

        document.getElementById('approvalButton').innerHTML = `Approval (${approvalCount})`;
        document.getElementById('rejectedButton').innerHTML = `Rejected (${rejectedCount})`;
    }

    function filterTable(status) {
        var table, tr, td, i;
        table = document.getElementById("employeeTable");
        tr = table.getElementsByTagName("tr");
        
        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByClassName("status")[0];
            if (td) {
                if (td.innerHTML.indexOf(status) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateButtonCounts();
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
  



@endsection