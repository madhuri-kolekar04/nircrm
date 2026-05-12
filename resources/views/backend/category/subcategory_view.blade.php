@extends('admin.admin_master')
@section('admin')


  <!-- Content Wrapper. Contains page content -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		 

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			<div class="col-8">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">SubCategory List <span class="badge badge-pill badge-danger"> {{ count($subcategory) }} </span> </h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
					<table id="example1" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
						<thead>
							<tr>
								<th>ID</th>
								<th>Category </th>
								<th>Sub_Category</th>
								
								<th>Controls</th>
								 
							</tr>
						</thead>
						<tbody>
	 @foreach($subcategory as $key=>$item)
	 <tr>
	 @if($key <= 010)
            <td>{{'0'.$key+1}}</td>
         @else
            <td>{{$key+1}}</td>
         @endif
		<td> {{ $item['category']['category_name_en'] }}  </td>  
		<td>{{ $item->subcategory_name_en }}</td>  
	
		<td width="30%">
 <a href="{{ route('subcategory.edit',$item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i> </a>

 <a href="{{ route('subcategory.delete',$item->id) }}" class="btn btn-danger" title="Delete Data" id="delete">
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


<!--   ------------ Add Category Page -------- -->


          <div class="col-4">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Add SubCategory </h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">


 <form method="post" action="{{ route('subcategory.store') }}" >
	 	@csrf
					   
		 <div class="form-group">
	<h5>Service Category Select <span class="text-danger">*</span></h5>
	<div class="controls">
		<select name="service_category" class="form-control"  >
			<option value="" selected="" disabled="">Select Service Category</option>
			@foreach($service_category  as $item)
			<option value="{{ $item->id }}">{{ $item->service_category_name }}</option>	
			@endforeach
		</select>
		@error('category_id') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	 </div>
		 </div>

		 
	 <div class="form-group">
	<h5>Category Select <span class="text-danger">*</span></h5>
	<div class="controls">
		<select name="category_id" class="form-control"  >
			<option value="" selected="" disabled="">Select Category</option>
		
		</select>
		@error('category_id') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	 </div>
		 </div>


	<div class="form-group">
		<h5>SubCategory<span class="text-danger">*</span></h5>
		<div class="controls">
	 <input type="text" name="subcategory_name_en" class="form-control" >
     @error('subcategory_name_en') 
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
  
	  <script type="text/javascript">
		
      $(document).ready(function() {
		$('select[name="service_category"]').on('change', function(){
            var service_category_id = $(this).val();
            if(service_category_id) {
                $.ajax({
                    url: "{{  url('/category/service_category/ajax') }}/"+service_category_id,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
						var d =$('select[name="category_id"]').empty();

					   
                          $.each(data, function(key, value){
							
                              $('select[name="category_id"]').append('<option value="'+ value.id +'">' + value.category_name_en + '</option>');
                          });
                    },
                });



			
		}
        });
	});
    </script>



@endsection
