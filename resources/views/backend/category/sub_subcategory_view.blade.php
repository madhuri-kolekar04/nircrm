@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Content Wrapper. Contains page content -->
  
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		 

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			<div class="col-8">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Item List <span class="badge badge-pill badge-danger"> {{ count($subsubcategory) }} </span></h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
					<table id="example1" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">

						<thead>
							<tr>
								
						     	<th>ID</th>
								<th>Category </th>
								<th>Sub_category</th>
								<th>Action</th>
								<th>Controls</th>
								 
							</tr>
						</thead>
		 				<tbody>
		
	 @foreach($subsubcategory as $key=>$item)
	 <tr>
	 @if($key <= 010)
            <td>{{'0'.$key+1}}</td>
         @else
            <td>{{$key+1}}</td>
         @endif

		<td> {{ $item['category']['category_name_en'] }}  </td>
		<td>{{ $item['subcategory']['subcategory_name_en'] }}</td>
		 <td>{{ $item->subsubcategory_name_en }}</td>
		<td width="30%">
 <a href="{{ route('subsubcategory.edit',$item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i> </a>

 <a href="{{ route('subsubcategory.delete',$item->id) }}" class="btn btn-danger" title="Delete Data" id="delete">
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
				  <h3 class="box-title">Add Action </h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">


 <form method="post" action="{{ route('subsubcategory.store') }}" >
	 	@csrf
				
		
		 <div class="form-group">
	<h5>Service Category Select <span class="text-danger">*</span></h5>
	<div class="controls">
		<select name="service_category"  class="form-control"  >
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
		<select name="category_id" id="category_id" class="form-control"  >
			<option value="" selected="" disabled="">Select Category</option>
		
		</select>
		@error('category_id') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	 </div>
		 </div>


		  <div class="form-group">
	<h5>SubCategory Select <span class="text-danger">*</span></h5>
	<div class="controls">
		<select name="subcategory_id" class="form-control"  >
			<option value="" selected="" disabled="">Select SubCategory</option>
			 
		</select>
		@error('subcategory_id') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	 </div>
		 </div>


	<div class="form-group">
		<h5>Action <span class="text-danger">*</span></h5>
		<div class="controls">
	 <input type="text" name="subsubcategory_name_en" class="form-control" >
     @error('subsubcategory_name_en') 
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

                       var d =$('select[name="subcategory_id"]').empty();
					   console.log(data);
					   $('select[name="category_id"]').append('<option value="">Select Category  </option>');

                          $.each(data, function(key, value){
							
                              $('select[name="category_id"]').append('<option value="'+ value.id +'">' + value.category_name_en + '</option>');
                          });
                    },
                });
				
				
         
            
            } else {
                alert('danger'+category_id);
            }


		});		
		
      


         $('select[name="category_id"]').on('change', function(){
			var category_id = $('select[name="category_id"]').val();
				// alert(category_id);
            if(category_id) {
                $.ajax({
                    url: "{{  url('/category/subcategory/ajax') }}/"+category_id,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
						
                       var d =$('select[name="subcategory_id"]').empty();
                          $.each(data, function(key, value){
                              $('select[name="subcategory_id"]').append('<option value="'+ value.id +'">' + value.subcategory_name_en + '</option>');
                          });
                    },
                });
            } else {
                alert('danger');
            }

         });
    });
    </script>


@endsection
