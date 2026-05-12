@extends('admin.admin_master')
@section('admin')

<style>
/* Modern Department Management Styles */
.department-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.department-header h3 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 600;
}

.department-header .badge {
    background: rgba(255,255,255,0.2);
    color: white;
    font-size: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 25px;
}

.department-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.department-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.department-card .box-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    border: none;
    padding: 1.5rem;
}

.department-card .box-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin: 0;
}

.department-table {
    border-radius: 10px;
    overflow: hidden;
}

.department-table thead {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.department-table thead th {
    border: none;
    padding: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.department-table tbody tr {
    transition: all 0.3s ease;
}

.department-table tbody tr:hover {
    background: #f8f9fa;
    transform: scale(1.02);
}

.department-table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border: none;
}

.btn-action {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.9rem;
    margin: 0 0.25rem;
    transition: all 0.3s ease;
    border: none;
}

.btn-edit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-edit:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    color: white;
    transform: translateY(-2px);
}

.btn-delete {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.btn-delete:hover {
    background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
    color: white;
    transform: translateY(-2px);
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-group label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 10px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.table-responsive {
    border-radius: 10px;
    overflow: hidden;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .department-header {
        padding: 1.5rem;
    }
    
    .department-card {
        margin-bottom: 1.5rem;
    }
}
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="container-full">
    <!-- Content Header (Page header) -->
    <div class="department-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3 class="box-title">
                    <i class="fas fa-building mr-3"></i>
                    Department Management
                </h3>
            </div>
            <div class="col-md-6 text-md-right">
                <span class="badge">
                    <i class="fas fa-layer-group mr-2"></i>
                    Total Departments: {{ count($category ?? []) }}
                </span>
            </div>
        </div>
    </div>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-12">
					<div class="box department-card">
						<div class="box-header d-flex justify-content-between align-items-center">
							<h3 class="box-title mb-0">
								<i class="fas fa-list mr-2"></i>
								Department List
								<span class="badge badge-primary ml-2">{{ count($category ?? []) }}</span>
							</h3>
							<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewItemModal">
								<i class="fas fa-plus mr-2"></i>Add
							</button>
						</div>
					<!-- /.box-header -->
					<div class="box-body p-0">
						<div class="table-responsive">
							<table id="example1" class="table department-table table-hover display nowrap">
								<thead>
									<tr>
										<th style="width: 8%;"><i class="fas fa-hashtag mr-1"></i>ID</th>
										<th><i class="fas fa-building mr-1"></i>Department Name</th>
										<th style="width: 15%;"><i class="fas fa-cogs mr-1"></i>Actions</th>
									</tr>
								</thead>
						<tbody>
	 @foreach($category ?? [] as $key=>$item)
	 <tr>
        <td><span class="badge badge-light font-weight-bold text-dark">{{ $key + 1 }}</span></td>
                                        
		<td>
			<div class="d-flex align-items-center">
				<div class="mr-3">
					<div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">
						{{ mb_strtoupper(substr($item->department, 0, 1)) }}
					</div>
				</div>
				<div>
					<strong>{{ $item->department }}</strong>
				</div>
			</div>
		</td>
		
		<td>
			<div class="btn-group" role="group">
				<a href="{{ route('category.edit',$item->id) }}" class="btn btn-action btn-edit" title="Edit Department">
					<i class="fas fa-edit"></i> 
				</a>
				<a href="{{ route('category.delete',$item->id) }}" class="btn btn-action btn-delete" title="Delete Department" id="delete">
					<i class="fas fa-trash"></i>
				</a>
			</div>
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

<!-- Add New Item Modal -->
<div class="modal fade" id="addNewItemModal" tabindex="-1" aria-labelledby="addNewItemModalLabel" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="false">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-info text-white">
				<h5 class="modal-title" id="addNewItemModalLabel">
					<i class="fas fa-plus mr-2"></i>Add New Item
				</h5>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="post" action="{{ route('category.store') }}" class="needs-validation" novalidate>
				@csrf
				<div class="modal-body">
					<div class="form-group mb-4">
						<label for="new_item_name" class="form-label">
							<i class="fas fa-cube mr-2"></i>
							Item Name <span class="text-danger">*</span>
						</label>
						<input type="text" id="new_item_name" name="category_name_en" class="form-control" placeholder="Enter item name" required> 
						@error('category_name_en') 
						<div class="text-danger mt-2">{{ $message }}</div>
						@enderror 
						<div class="invalid-feedback">
							Please enter an item name.
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
						<i class="fas fa-times mr-2"></i>Cancel
					</button>
					<button type="submit" class="btn btn-info">
						<i class="fas fa-save mr-2"></i>Add Item
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
  



@endsection

@push('styles')
<style>
/* Fix modal z-index and interaction issues */
.modal {
    z-index: 9999 !important;
}

/* Completely disable backdrop */
.modal-backdrop {
    display: none !important;
}

.modal-dialog {
    z-index: 10000 !important;
    pointer-events: auto !important;
    position: fixed !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
}

.modal-content {
    z-index: 10001 !important;
    pointer-events: auto !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;
    border: 1px solid #dee2e6 !important;
    position: relative !important;
}

/* Ensure modal is clickable and inputs are focusable */
.modal.show {
    display: block !important;
    opacity: 1 !important;
}

.modal .form-control {
    pointer-events: auto !important;
    z-index: 10002 !important;
    position: relative !important;
    background: white !important;
    border: 1px solid #ced4da !important;
}

/* Fix any overlay issues */
.modal * {
    pointer-events: auto !important;
}

/* Ensure modal buttons are clickable */
.modal-footer .btn {
    pointer-events: auto !important;
    z-index: 10003 !important;
    position: relative !important;
    cursor: pointer !important;
}

/* Ensure modal header and body are clickable */
.modal-header, .modal-body {
    pointer-events: auto !important;
    z-index: 10002 !important;
    position: relative !important;
}

/* Remove debug border - clean look */
.modal-content {
    border: 1px solid #dee2e6 !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Category page loaded, initializing modal...');
    
    // Check if Bootstrap is available
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap is not loaded!');
        return;
    }
    
    // Initialize New Item Modal
    const newItemModalElement = document.getElementById('addNewItemModal');
    if (newItemModalElement) {
        const newItemModal = new bootstrap.Modal(newItemModalElement);
        console.log('New Item modal initialized successfully');
        
        // Add click event listener to new item button
        const addNewItemBtn = document.querySelector('[data-bs-target="#addNewItemModal"]');
        if (addNewItemBtn) {
            addNewItemBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Add New Item button clicked');
                newItemModal.show();
                
                // Force enable inputs after modal is shown
                setTimeout(() => {
                    const input = document.getElementById('new_item_name');
                    if (input) {
                        input.disabled = false;
                        input.readOnly = false;
                        input.focus();
                        console.log('New Item input field enabled and focused');
                    }
                }, 300);
            });
        }
        
        // Listen for new item modal shown event
        newItemModalElement.addEventListener('shown.bs.modal', function () {
            console.log('New Item modal is now shown');
            const input = document.getElementById('new_item_name');
            if (input) {
                input.disabled = false;
                input.readOnly = false;
                input.focus();
                console.log('New Item input field enabled on modal show');
            }
        });
    }
    
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});

// jQuery backup
$(document).ready(function() {
    console.log('jQuery ready, setting up modal backup...');
    
    // New Item modal backup
    $('[data-bs-target="#addNewItemModal"]').on('click', function(e) {
        e.preventDefault();
        $('#addNewItemModal').modal('show');
        
        // Force enable input with jQuery
        setTimeout(function() {
            $('#new_item_name').prop('disabled', false).prop('readonly', false).focus();
            console.log('jQuery: New Item input field enabled');
        }, 300);
    });
    
    // Also enable on modal show
    $('#addNewItemModal').on('shown.bs.modal', function () {
        $('#new_item_name').prop('disabled', false).prop('readonly', false).focus();
        console.log('jQuery: New Item input enabled on modal show');
    });
});
</script>
@endpush
