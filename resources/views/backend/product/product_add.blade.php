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

  <form method="post" action="{{ route('product-store') }}" enctype="multipart/form-data" >
		 	@csrf

					  <div class="row">
	<div class="col-12">	


		<div class="row"> <!-- start 1st row  -->
		@if ((auth()->user()->role == 2) || (auth()->user()->role == 1) || (auth()->user()->role == 5))
		<div class="col-md-4">
    <div class="form-group">
        <h5> Start time <span class="text-danger">*</span></h5>
        <div class="controls">
            <div class="row">
                <div class="col-md-6">
                    <input type="date" name="Department_id" id="Department_id"    class="form-control" required="">
				
                    @error('start_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div> <!-- end col md 4 -->



<div class="col-md-4">
    <div class="form-group">
        <h5>End Time <span class="text-danger">*</span></h5>
        <div class="controls">
            <div class="row">
                <div class="col-md-6">
                    <input type="date" name="product_name_en" id="product_name_en"  class="form-control" required="">
                    @error('end_date') 
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- end col md 4 -->

 <!-- end col md 4 -->

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






	   @elseif((auth()->user()->role == 3) )

			<div class="col-md-4">
		
	 <div class="form-group">
	<h5> Select Priority<span class="text-danger">*</span></h5>
	<div class="controls">
		<select name="name" class="form-control" required="" >
			<option value="" selected="" disabled="">Select Priority</option>
			@foreach($customer as $name)
 <option value="{{ $brand->id }}">{{ $customer->name }}</option>	
			@endforeach
		</select>
		@error('brand_id') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	 </div>
		 </div>
	
			</div> <!-- end col md 4 -->
			@else
@endif



		



			
		</div> <!-- end 1st row  -->



<div class="row"> <!-- start 2nd row  -->

 <!-- end col md 4 -->

			   <div class="col-md-4">
		
		<div class="form-group">
	   <h5> Service  Category <span class="text-danger">*</span></h5>
	   <div class="controls">
		   <select name="service_category_id" class="form-control" required="" >
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
	<h5>Select SubCategory  <span class="text-danger"></span></h5>
	<div class="controls">
		<select name="subcategory_id" class="form-control" onchange="myFunction2()" id="select-referral"  >
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

	<div class="controls">
	<div class="form-group">
    <h5>Overdue/Remaining Days</h5>
    <div class="controls">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="due_info" id="due_info" class="form-control" readonly>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const endDateInput = document.getElementById('product_name_en');
        const dueInfoInput = document.getElementById('due_info');

        endDateInput.addEventListener('change', calculateDueInfo);

        function calculateDueInfo() {
            const endDate = new Date(endDateInput.value);
            const today = new Date();

            const timeDiff = endDate.getTime() - today.getTime();
            const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

            if (dayDiff < 0) {
				
				dueInfoInput.value = `Overdue by ${Math.abs(dayDiff)} days`;
            } else if (dayDiff === 0) {
                dueInfoInput.value = `Due today`;
            } else {
             
				dueInfoInput.value = `${dayDiff} days remaining`;
            }
        }
    });
</script>


	 </div>
		 </div>
				
			</div> <!-- end col md 4 -->



	@if ((auth()->user()->role == 2) || (auth()->user()->role == 4) || (auth()->user()->role == 1) || (auth()->user()->role == 5))

<div class="col-md-4">
    <div class="form-group">
        <h5>Select Tier <span class="text-danger">*</span></h5>
        <div class="controls">
            <select name="Group_IT" class="form-control">
                <option value="">Select Tier</option>
                @foreach($Group as $item)
                    <option value="{{ $item->id }}">{{ $item->Group }}</option>
                @endforeach
            </select>
            @error('Group_IT')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div> <!-- end col md 4 -->

<div class="col-md-4">
    <div class="form-group">
        <h5>Assign To <span class="text-danger">*</span></h5>
        <div class="checkbox-container" id="checkbox-container">
            
            @error('assign')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>







 <!-- end col md 4 -->




<div class="col-md-4">

<div class="form-group">
<h5> Select Stage<span class="text-danger">*</span></h5>
<div class="controls">
   <select name="status" id="ticketingstage"class="form-control" required="" >
	   <option value="" selected="" disabled="">Select Stage</option>
	   @foreach($stage as $item)
<option value="{{ $item->id }}">{{ $item->Ticket_status}}</option>	

	   @endforeach
   </select>
   @error('brand_id') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
	</div>
		   
	   </div> <!-- end col md 4 -->


<div class="col-md-4">
    <div class="form-group">
        <h5>Group Name<span class="text-danger">*</span></h5>
        <div class="controls">
            <select name="system_type_id" id="systemTypeSelect" class="form-control" required="">
                <option value="" selected disabled>System Type</option>
                @php
                    $sortedSystemTypes = $reminder->unique('system_type_id')->sortBy('system_type_id');
                @endphp
                @foreach($sortedSystemTypes as $item)
                    <option value="{{ $item->system_type_id }}">{{ $item->system_type_id }}</option>
                @endforeach
            </select>
            @error('system_type_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <h5>Select Project<span class="text-danger">*</span></h5>
        <div class="controls">
            <select name="customerlist" id="customerList" class="form-control" required="">
                <option value="" selected disabled>Select Customer</option>
                @php
                    $sortedReminders = $reminder->sortBy('name');
                @endphp
                @foreach($sortedReminders as $item)
                    <option value="{{ $item->name }}" data-system-type="{{ $item->system_type_id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            @error('brand_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const systemTypeSelect = document.getElementById('systemTypeSelect');
    const customerList = document.getElementById('customerList');
    const originalOptions = Array.from(customerList.options);

    systemTypeSelect.addEventListener('change', function () {
        const selectedSystemType = this.value;

        // Clear current options
        customerList.innerHTML = '';

        // Add the default disabled option
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.selected = true;
        defaultOption.disabled = true;
        defaultOption.textContent = 'Select Customer';
        customerList.appendChild(defaultOption);

        // Filter and add new options
        originalOptions.forEach(option => {
            if (option.getAttribute('data-system-type') === selectedSystemType) {
                customerList.appendChild(option.cloneNode(true));
            }
        });
    });
});
</script>

	   
	  
</row>

<!-- 
	   <div class="col-md-12" id ="summarywrite">

<div class="form-group">
	<h5> Write Summary  <span class="text-danger">*</span></h5>
	<div class="controls">
<textarea id="editor1" name="Summary" class="summary" name="long_descp_en" rows="10" cols="60" required="">
 
				</textarea>  
	  </div>
</div> -->
		
	<!-- </div>  -->
	<!-- end col md 6 -->

@else
@endif

@if ((auth()->user()->role == 3) )
	<div style="display:none">
		<input type="text" name="assign[]" value="1">
		<input type="text"  name="Group_IT"  value="1">
	</div>





<div class="col-md-4">

<div class="form-group">
<h5> Select Stage<span class="text-danger">*</span></h5>
<div class="controls">
   <select name="status" class="form-control" required="" >
	   <option value="" selected="" disabled="">Select Stage</option>
        <option value="1" Selected >Open</option>	
   </select>
   @error('brand_id') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
	</div>
		   
	   </div> <!-- end col md 4 -->

	   @else
@endif
		</div> <!-- end 2nd row  -->



<div class="row"> <!-- start 6th row  -->


			<div class="col-md-4">

   <div class="form-group">
			<h5>Attachments </h5>
			<div class="controls">
	 <input type="file" name="multi_img[]" class="form-control" multiple="" id="multiImg"  >
     @error('multi_img') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror
	 <div class="row" id="preview_img"></div>

	 		 </div>
		</div>
				
			</div> <!-- end col md 4 -->


			<div class="col-md-4">

	 
				 
				
			</div> <!-- end col md 4 -->
			
		</div> <!-- end 6th row  -->



		 
		 
	 
<div class="row"> <!-- start 8th row  -->
			<div class="col-md-12" >

	    <div class="form-group">
			<h5> Description  <span class="text-danger">*</span></h5>
			<div class="controls">
	<textarea id="editor2" name="long_descp_en" rows="10" cols="80" >

						</textarea>  
	 		 </div>
		</div>
				
			</div> <!-- end col md 6 -->

			 
			
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



const elementSelect = document.getElementById("ticketingstage");
// const elementInput = document.getElementById("summarywrite");

elementSelect.addEventListener("onload", function() {
  if (this.value === "7") {
    elementInput.style.display = "inline";
  
  } else {
    elementInput.style.display = "none";

  }
});















		$(document).ready(function() {


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
                    	// $('select[name="subsubcategory_id"]').html('');
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
						 
                            //   $('select[name="subsubcategory"]').append('<option value="'+ value.id +'">' + value.subsubcategory_name_en + '</option>');
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
$(document).ready(function() {
    $('select[name="Group_IT"]').on('change', function() {
        var Group_ID = $(this).val();

        if (Group_ID) {
            $.ajax({
                url: "{{ url('/product/Ticket_IT_Supporter/ajax') }}/" + Group_ID,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var checkboxContainer = $('#checkbox-container').empty();
                    $.each(data, function(key, value) {
                        checkboxContainer.append('<div class="form-check"><input class="form-check-input" type="checkbox" name="assign[]" value="' + value.id + '" id="assign-' + value.id + '"><label class="form-check-label" for="assign-' + value.id + '">' + value.name + '</label></div>');
                    });
                },
            });
        } else {
            alert('danger');
        }
    });
});

 




	// According to department show emaoloyee



$('select[name="Department_id"]').on('change', function(){

var Department_id = $(this).val();

if(Department_id) {
	$.ajax({
		url: "{{  url('/product/Ticket/ajax/') }}/"+Department_id,
		type:"GET",
		dataType:"json",
		success:function(data) {
			
		   var d =$('select[name="product_name_en"]').empty();
			  $.each(data, function(key, value){
			 
				  $('select[name="product_name_en"]').append('<option value="'+ value.id +'">' + value.name + '</option>');
			  });
		},
	});
} else {
	alert('danger');
}
});


});
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
