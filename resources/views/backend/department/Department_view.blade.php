@extends('admin.admin_master')
@section('admin')

  <!-- Content Wrapper. Contains page content -->
  
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		 

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			<div class="col-12">
			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Department Management <span class="badge badge-pill badge-danger"> {{ count($Department) }} </span></h3>
				  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
				    <i class="fa fa-plus"></i> Add Department
				  </button>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
					  <table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Id</th>
								<th>Department </th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($Department as $key=> $item)
							 <tr>
								@if($key <= 010)
									<td>{{'0'.$key+1}}</td>
								@else
									<td>{{$key+1}}</td>
								@endif
								
								<td>{{ $item->department }}</td>
								
								<td>
									<a href="{{ route('Department.edit',$item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i> </a>
									<a href="{{ route('Department.delete',$item->id) }}" class="btn btn-danger" title="Delete Data" id="delete">
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

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDepartmentModalLabel">Add New Department</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="{{ route('Department.store') }}">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="Department">Department Name <span class="text-danger">*</span></label>
            <input type="text" name="Department" class="form-control" id="Department" placeholder="Enter department name" required>
            @error('Department') 
              <span class="text-danger">{{ $message }}</span>
            @enderror 
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
/* Debug: Ensure modal is visible when shown */
.modal.show {
    display: block !important;
}

/* Debug: Add border to modal for visibility */
.modal-content {
    border: 2px solid red !important;
}

/* Debug: Ensure modal backdrop is visible */
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.5) !important;
}
</style>
@endpush

@push('scripts')
<script>
// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Department page loaded, initializing modal...');
    
    // Check if Bootstrap is available
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap is not loaded!');
        return;
    }
    
    // Get modal element
    const modalElement = document.getElementById('addDepartmentModal');
    if (!modalElement) {
        console.error('Modal element not found!');
        return;
    }
    
    // Initialize modal
    const modal = new bootstrap.Modal(modalElement);
    console.log('Modal initialized successfully');
    
    // Add click event listener to the button
    const addDeptBtn = document.querySelector('[data-bs-target="#addDepartmentModal"]');
    if (addDeptBtn) {
        addDeptBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Add Department button clicked');
            modal.show();
        });
        console.log('Button event listener attached');
    } else {
        console.error('Add Department button not found!');
    }
});

// Alternative: Use jQuery as backup
$(document).ready(function() {
    console.log('jQuery ready, setting up modal backup...');
    
    $('#addDepartmentModal').on('show.bs.modal', function (e) {
        console.log('Modal is about to be shown');
    });
    
    // Manual trigger as backup
    $('[data-bs-target="#addDepartmentModal"]').on('click', function(e) {
        e.preventDefault();
        console.log('jQuery button click handler triggered');
        $('#addDepartmentModal').modal('show');
    });
});
</script>
@endpush
