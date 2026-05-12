@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- <style>
	#summarywrite {
		display:none;
	}
</style>
    -->

	

	  <div class="container-full">
		<!-- Content Header (Page header) -->
		  

		<!-- Main content -->
		<section class="content">
 
		 <!-- Basic Forms -->
		  <div class="box">
			<div class="box-header with-border">
			  <h4 class="box-title">Add Ticket </h4>
			   
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			  <div class="row">
				<div class="col">

  <form method="post" action="{{ route('product-storeuser') }}" enctype="multipart/form-data" >
		 	@csrf

					  <div class="row">
	<div class="col-12">	


		<div class="row"> <!-- start 1st row  -->


	   <div class="col-md-4" >

<div class="form-group">
<h5>Select  Department <span class="text-danger">*</span></h5>
<div class="controls">
<select name="Department_id" class="form-control" required="" >
@if($selectdepartment)
	   <option value="{{ $selectdepartment->id }}" selected disabled="">{{ $selectdepartment->department }}</option>
@endif
</select>
@error('Department_id') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
</div>

</div> <!-- end col md 4 -->



<div class="col-md-4">

<input style="display:none;" class="form-group" value="{{ $adminData->id }}" name="product_name_en"/>
@if($selectdepartment)
<input style="display:none;" class="form-group" value="{{ $selectdepartment->id }}" name="department_id"/>
@endif

<h5>Requester Name<span class="text-danger">*</span></h5>
    <div class="controls">
     <select name="requester_name" class="form-control" required="" >
	   <option value="{{ $adminData->id }}" selected  disabled="">{{ $adminData->name }}</option>
     </select>
		@error('product_name_en') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	</div>


</div> <!-- end col md 4 -->









			<div class="col-md-4">

	 <div class="form-group">
	<h5> Select Priority<span class="text-danger">*</span></h5>
	<div class="controls">
		<select name="brand_id" class="form-control" required="" >
			<option value="" selected="" disabled="">Select Priority</option>
			@foreach($brands as $brand)
 <option value="{{ $brand->id }}">{{ $brand->brand_name_en }}</option>	
			@endforeach
		</select>
		@error('brand_id') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	 </div>
		 </div>
				
			</div> <!-- end col md 4 -->


		



			
		</div> <!-- end 1st row  -->



<div class="row"> <!-- start 2nd row  -->

<div class="col-md-4">
		
		<div class="form-group">
	   <h5> System Type<span class="text-danger">*</span></h5>
	   <div class="controls">
		   <select name="system_type_id" class="form-control" required="" >
			   <option value="" selected="" disabled="">System Type</option>
			   @foreach($system_type as $item)
	<option value="{{ $item->id }}">{{ $item->system_type_name }}</option>	
			   @endforeach
		   </select>
		   @error('system_type_id') 
		<span class="text-danger">{{ $message }}</span>
		@enderror 
		</div>
			</div>
	   
			   </div> <!-- end col md 4 -->




			   <div class="col-md-4">
		
		<div class="form-group">
	   <h5> Operating System<span class="text-danger">*</span></h5>
	   <div class="controls">
		   <select name="operating_system_id" class="form-control" required="" >
			   <option value="" selected="" disabled="">Select Operating System</option>
			   @foreach($operating_system as $item)
	<option value="{{ $item->id }}">{{ $item->operating_system }}</option>	
			   @endforeach
		   </select>
		   @error('operating_system_id') 
		<span class="text-danger">{{ $message }}</span>
		@enderror 
		</div>
			</div>
	   
			   </div> <!-- end col md 4 -->

			   <div class="col-md-4">
		
		<div class="form-group">
	   <h5> Service  Category <span class="text-danger">*</span></h5>
	   <div class="controls">
		   <select name="service_category_id" class="form-control service_category" required="" >
			   <option value="" selected="" disabled="">Select Service Category</option>
			   @foreach($service_category as $item)
	                <option value="{{ $item->id }}">{{ $item->service_category_name }}</option>	
			   @endforeach
		   </select>
		   @error('service_category_id') 
		<span class="text-danger">{{ $message }}</span>
		@enderror 
		</div>
			</div>
	   
			   </div> <!-- end col md 4 -->

<div class="col-md-4">

<div class="form-group">
<h5> Select Category  <span class="text-danger">*</span></h5>
<div class="controls">
<select name="category_id" class="form-control" required="" >
<option value="" selected="" disabled="">Select Category</option>

</select>
@error('category_id') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
</div>

</div> <!-- end col md 4 -->





<div class="col-md-4">

				 <div class="form-group">
	<h5>Select SubCategory  <span class="text-danger">*</span></h5>
	<div class="controls">
		<select name="subcategory_id" class="form-control" required="" >
			<option value="" selected="" disabled="">Select SubCategory</option>
			 
		</select>
		@error('subcategory_id') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	 </div>
		 </div>
				
			</div> <!-- end col md 4 -->
			
			<div class="col-md-4">

	 <div class="form-group">
	<h5>Select Action  <span class="text-danger"></span></h5>
	<div class="controls">
		<select name="subsubcategory_id" class="form-control"  >
			<option value="" selected="" disabled="">Select Action</option>
			@foreach($Action as $item)
				<option value="{{ $item->id }}">{{ $item->action_name }}</option>	
				@endforeach
		</select>
		@error('subsubcategory_id') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	 </div>
		 </div>
				
			</div> <!-- end col md 4 -->















	<div style="display:none">
<input type="text" name="assign" value="NULL">
<input type="text"  name="Group_IT"  value="NULL">
</div>





<div class="col-md-4">

<div class="form-group">
<h5> Select Stage<span class="text-danger">*</span></h5>
<div class="controls">
   <select name="status" class="form-control" required="" >
	   <option value="" selected="" disabled="">Select Stage</option>
	 
<option value="6" Selected >Open</option>	


   </select>
   @error('brand_id') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
	</div>
		   
	   </div> <!-- end col md 4 -->


		</div> <!-- end 2nd row  -->



<div class="row"> <!-- start 6th row  -->


<div class="col-md-4">

<div class="form-group">
	<h5>Attachment </h5>
	<div class="controls">

<input type="file" name="file_attachment" class="form-control" id="customFile" />
@error('file_attachment') 
<span class="text-danger">{{ $message }}</span>
@enderror
<img src="" id="mainThmb">
	  </div>
</div>
		 
		
	</div> <!-- end col md 4 -->


	<div class="col-md-4">

<div class="form-group">
	<h5>Screenshots </h5>
	<div class="controls">
<input type="file" name="multi_img[]" class="form-control" multiple="" id="multiImg"  >
@error('multi_img') 
<span class="text-danger">{{ $message }}</span>
@enderror
<div class="row" id="preview_img"></div>

	  </div>
</div>
		 
		
	</div> <!-- end col md 4 -->
			
		</div> <!-- end 6th row  -->



		 
		 
	 
<div class="row"> <!-- start 8th row  -->
			<div class="col-md-12">

	    <div class="form-group">
			<h5> Description  <span class="text-danger">*</span></h5>
			<div class="controls">
	<textarea id="editor2" name="long_descp_en" rows="10" cols="80" required="">
		  Describe Your Query
						</textarea>  
	 		 </div>
		</div>
				
			</div> <!-- end col md 6 -->
			<div class="col-md-4" style="display:none">

<div class="form-group">
<h5> Select <span class="text-danger">*</span></h5>
<div class="controls">
<select name="Departmsent_id" class="form-control"  >
	
	@foreach($Department as $Department)
				<option value="{{ $Department->id }}"selected="" >{{ $Department->department }}</option>	
	@endforeach
</select>
@error('Department_id') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
</div>

</div>
 <!-- end col md 4 -->

			 
			
		</div> <!-- end 8th row  -->

	 
	 <hr>
 


	<div class="row">


			
						 
						<div class="text-xs-right">
<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Add Ticket">
						</div>
					</form>

				</div>
				<!-- /.col -->
			  </div>
			  <!-- /.row -->
			</div>
			<!-- /.box-body -->
		  </div>
		  <!-- /.box -->

		</section>
		<!-- /.content -->
	  </div>
 
 <script type="text/javascript">

$(document).ready(function() {
    $('.service_category').select2();
});
// const elementSelect = document.getElementById("ticketingstage");
// // const elementInput = document.getElementById("summarywrite");

// elementSelect.addEventListener("onload", function() {
//   if (this.value === "5") {
//     elementInput.style.display = "inline";
  
//   } else {
//     elementInput.style.display = "none";

//   }
// });


//------------------------------- service category

$('select[name="service_category_id"]').on('change', function(){

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
//------------------------------- service category end


        $('select[name="category_id"]').on('change', function(){
			
            var category_id = $(this).val();
            if(category_id) {
                $.ajax({
                    url: "{{  url('/category/subcategory/ajax') }}/"+category_id,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                    	
                       var d =$('select[name="subcategory_id"]').empty();
					   $('select[name="subcategory_id"]').append('<option value=""> Select Sub Category</option>');

                          $.each(data, function(key, value){
                              $('select[name="subcategory_id"]').append('<option value="'+ value.id +'">' + value.subcategory_name_en + '</option>');
                          });
                    },
                });
				var subcategory = $(this).val();
		
            if(subcategory) {
                $.ajax({
                    url: "{{  url('/category/sub-subcategory/ajax') }}/"+subcategory,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
						
                       var d =$('select[name="subsubcategory"]').empty();
                          $.each(data, function(key, value){
						 
                              $('select[name="subsubcategory"]').append('<option value="'+ value.id +'">' + value.subsubcategory_name_en + '</option>');
                          });
                    },
                });
			}
            } else {
                alert('danger');
            }
        });



//  $('select[name="subcategory_id"]').on('change', function(){

//             var subcategory_id = $(this).val();
		
//             if(subcategory_id) {
//                 $.ajax({
//                     url: "{{  url('/category/sub-subcategory/ajax') }}/"+subcategory_id,
//                     type:"GET",
//                     dataType:"json",
//                     success:function(data) {
						
//                        var d =$('select[name="subsubcategory_id"]').empty();
//                           $.each(data, function(key, value){
						 
//                               $('select[name="subsubcategory_id"]').append('<option value="'+ value.id +'">' + value.subsubcategory_name_en + '</option>');
//                           });
//                     },
//                 });
//             } else {
//                 alert('danger');
//             }
//         });


//   According to group select change it supporter name

$('select[name="Group_IT"]').on('change', function(){

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
 



	// According to department show emaoloyee





    </script>


<script type="text/javascript">
	function mainThamUrl(input){
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e){
				$('#mainThmb').attr('src',e.target.result).width(80).height(80);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}	
</script>


<script>
 
  $(document).ready(function(){
   $('#multiImg').on('change', function(){ //on file input change
      if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
      {
          var data = $(this)[0].files; //this file data
           
          $.each(data, function(index, file){ //loop though each file
              if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                  var fRead = new FileReader(); //new filereader
                  fRead.onload = (function(file){ //trigger function on successful read
                  return function(e) {
                      var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(80)
                  .height(80); //create image element 
                      $('#preview_img').append(img); //append image to output element
                  };
                  })(file);
                  fRead.readAsDataURL(file); //URL representing the file's data.
              }
          });
           
      }else{
          alert("Your browser doesn't support File API!"); //if File API is absent
      }
   });
  });
   
  </script>




@endsection


