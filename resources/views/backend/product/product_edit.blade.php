@extends('admin.admin_master')
@section('admin')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"><style>
	#summarywrite {
		display:none;
	}






</style>

<style>
        .form-group {
            margin: 20px;
        }
        .form-group h5 {
            margin-bottom: 10px;
        }
        .controls {
            margin-bottom: 20px;
        }
        #username {
            font-weight: bold;
        }
    </style>
<div class="container-full">
		<!-- Content Header (Page header) -->
		  

		<!-- Main content -->
		<section class="content">
 
		 <!-- Basic Forms -->
		  <div class="box">
			<div class="box-header with-border">
			  <h4 class="box-title">Edit Task </h4><h4 class="box-title"> </h4>
			   
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			  <div class="row">
				<div class="col">

  <form method="post" action="{{ route('product.update') }}" enctype="multipart/form-data" >
		 	@csrf
<input type="text" style="opacity:0;"  name="product_id"value="{{ $products->id}}">
					  <div class="row">
	<div class="col-12">	


		<div class="row"> <!-- start 1st row  -->
	


		<div class="col-md-4">
    <div class="form-group">
        <h5> Start time <span class="text-danger">*</span></h5>
        <div class="controls">
            <div class="row">
                <div class="col-md-6">
                    <input type="date" name="Department_id" id="Department_id"  value="{{ $products->Department_id }}"  class="form-control" required="">
				
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
                    <input type="date" name="product_name_en" id="product_name_en" value="{{ $products->product_name_en }}" class="form-control" required="">
                    @error('end_date') 
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- end col md 4 -->

			<div class="col-md-4">

	 <div class="form-group">
	<h5> Select Priority<span class="text-danger">*</span></h5>
	<div class="controls">
		<select name="brand_id" class="form-control" required="" >
			<option value="" selected="" disabled="">Select Priority</option>
			@foreach($brands as $brand)
			@if($brand->id == $products->brand_id)
			  <option value="{{ $brand->id == $products->brand_id ? $brand->id : '' }}" selected  >{{ $brand->id == $products->brand_id ?  $brand->brand_name_en : '' }}</option>	
			@endif

	
			@endforeach
		</select>
		@error('brand_id') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	 </div>
		 </div>
				
</div>
<!-- end col md 4 -->


		



			
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
	<option value="{{ $item->id }}"{{ $item->id == $products->service_category_id ? 'selected': '' }} >{{ $item->service_category_name }}
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
@foreach($categories as $item)
	<option value="{{ $item->id }}"{{ $item->id == $products->category_id ? 'selected': '' }} >{{ $item->category_name_en }}
			   @endforeach
</select>
@error('category_id') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
</div>

</div> <!-- end col md 4 -->





<div class="col-md-4">

				 <div class="form-group">
	<h5> Select  SubCategory  <span class="text-danger">*</span></h5>
	<div class="controls">
		<select name="subcategory_id" class="form-control"  >
			<option value="" selected="" disabled="">Select SubCategory</option>
			@foreach($subcategory as $sub)
                  <option value="{{ $sub->id }}" {{ $sub->id == $products->subcategory_id ? 'selected': '' }} >{{ $sub->subcategory_name_en }}</option>	
			@endforeach
		</select>
		@error('subcategory_id') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	 </div>
		 </div>
				
			</div> <!-- end col md 4 -->
			
			<div class="col-md-4">

	 <div class="form-group">
	<h5> Select Tier  <span class="text-danger">*</span></h5>
	<div class="controls">
	<select name="Group_IT" class="form-control"  >
<option value="" selected="" disabled="">Select Tier</option>
@foreach($Group as $item)
<option value="{{ $item->id }}" {{ $item->id == $products->Group ? 'selected': '' }} >{{ $item->Group }}</option>	
@endforeach
</select>
		@error('subsubcategory_id') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	 </div>
		 </div>
				



		  @if ((auth()->user()->role == 2) || (auth()->user()->role == 1))
		  
		  
		  
<!-- Form -->
<div class="form-group">
    <h5>Assign To<span class="text-danger">*</span></h5>
    <div class="controls">
        <?php
            $assignedUsers = json_decode($products->Assign, true) ?? [];
        ?>

        @foreach($username as $user)
            @if($user->role == 2)
                <div class="form-check">
                    <input type="checkbox" name="assign[]" value="{{ $user->id }}" class="form-check-input"
                           {{ in_array($user->id, $assignedUsers) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $user->name }}</label>
                </div>
            @endif
        @endforeach

        @error('assign')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
</div>

<div class="col-md-4">

<div class="form-group">
<h5> Select Stage<span class="text-danger">*</span></h5>
<div class="controls">
<select name="status" id="ticketingstage" class="form-control" required="" >
	   <option value="" selected="" disabled="">Select Stage</option>
	   @foreach($stage as $item)
 <option value="{{ $item->id }}" {{ $item->id == $products->status ? 'selected': '' }} >{{ $item->Ticket_status }}</option>	
	   @endforeach

   </select>
		
		@error('assign') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	 </div>

</div>
  <div class="col-md-14">
    <div class="form-group">
        <h5>Group Name<span class="text-danger">*</span></h5>
        <div class="controls">
            <select name="system_type_id" id="system_type_id" class="form-control" required="">
                 <option value="" selected="" disabled="">Select Customer</option>
	     @foreach($system_type as $item)
                    @php
                        $value = is_numeric($products->system_type_id) ? $item->id : $item->system_type_name;
                        $selected = $value == $products->system_type_id ? 'selected' : '';
                    @endphp
                    <option value="{{ $value }}" {{ $selected }}>{{ $item->system_type_name }}</option>
                @endforeach
            </select>
            @error('system_type_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="col-md-14">

<div class="form-group">
<h5> Project Name<span class="text-danger">*</span></h5>
<div class="controls">
   <select name="customerlist" id="customerlist"class="form-control" required="" >
	   <option value="" selected="" disabled="">Select Customer</option>
	   @foreach($customer as $item)

 <option value="{{ $item->name }}" {{ $item->name == $products->customerlist ? 'selected': '' }} >{{ $item->name }}</option>

	   @endforeach
   </select>
   @error('brand_id') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
	</div>
		   
	   </div>
	   
	   
	

</row>



<!-- Hidden input to store the user's name -->
<input type="hidden" id="userName" value="{{ Auth::user()->name }}">


<div class="form-group">
    <h5>Change Log</h5>
    <div class="controls">
        <textarea id="changeLog" name="changeLog" class="form-control" rows="10" readonly>{{ $products->changeLog }}</textarea>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stageSelect = document.getElementById('ticketingstage');
        const changeLog = document.getElementById('changeLog');
        const userName = document.getElementById('userName').value;

        stageSelect.addEventListener('change', function() {
            const selectedOption = stageSelect.options[stageSelect.selectedIndex].text;
            const currentDateTime = new Date().toLocaleString(); // Get current date and time
            const logEntry = `Stage changed to "${selectedOption}" by ${userName} on ${currentDateTime}`;
            changeLog.value += logEntry + "\n" ;
        });
    });
</script>

@else
@endif


</div> <!-- end col md 4 -->
<div class="col-md-4">

<div class="form-group">
<h5> <span class="text-danger">*</span></h5>
<div class="controls">
<div class="row">
            <div class="col-md-6">
                <input type="text" name="due_info" id="due_info" value="{{ $products->due_info }}" class="form-control" readonly>
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
   @error('brand_id') 
<span class="text-danger">{{ $message }}</span>
@enderror 
</div>
	</div>
		   
	   </div> <!-- end col md 4 -->
	   
<div class="row"> <!-- start 8th row  -->
    <div class="col-md-12">
        <div class="form-group">
            <h5>Chatting <span class="text-danger">*</span></h5>
            <div class="controls">
                <p>Current User: <span id="username" ><?php echo auth()->user()->name; ?></span></p>
                <div id="chatHistory" style="height: 200px; overflow-y: scroll;">
                    <textarea id="history" name="history" rows="20" cols="80" readonly>{{ $products->history }}</textarea>
                </div>
                <input type="text" id="chatInput" placeholder="Type your message here..." maxlength="200" >
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>
</div>

<script>
    function validateInput() {
        var input = document.getElementById("chatInput");
        input.value = input.value.replace(/[^a-zA-Z0-9 ]/g, ''); // Allow only alphanumeric and space
    }

    function sendMessage() {
        var input = document.getElementById("chatInput");
        var message = input.value.trim();

        if (message === "") {
            alert("Message cannot be empty!");
            return;
        }

        // Add the message to chat history or perform the desired action
        var chatHistory = document.getElementById("chatHistory");
        chatHistory.innerHTML += "<p>" + message + "</p>";

        // Clear the input field after sending the message
        input.value = "";
    }
</script>


<script>
function sendMessage() {
    const chatInput = document.getElementById('chatInput');
    const chatHistory = document.getElementById('history');
    const username = document.getElementById('username').textContent;

    if (chatInput.value.trim() !== "") {
        // Format the new message
        const newMessage = `${username}: ${chatInput.value}`;

        // Prepend the new message to the chat history
        chatHistory.value = newMessage + (chatHistory.value ? '\n' : '') + chatHistory.value;

        // Scroll to the top of the chat history
        chatHistory.scrollTop = 0;

        // Clear the input field
        chatInput.value = "";
    }
}
</script>



	   
<div class="row"> <!-- start 6th row  -->


			<div class="col-md-12">

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

	   


	   

	   <div class="col-md-12" id ="summarywrite">

<div class="form-group">
	<h5> Write Summary  <span class="text-danger">*</span></h5>
	<div class="controls">
<textarea id="editor1" name="summary" class="summary"  rows="10" cols="60" >
{!! $products->Summary !!}
				</textarea>  
	  </div>
</div>
		
	</div> <!-- end col md 6 -->
		</div> <!-- end 2nd row  -->





		
		 
		
		 
	 
<div class="row"> <!-- start 3RD row  -->
			<div class="col-md-12">

	    <div class="form-group">
			<h5>Long Description  <span class="text-danger">*</span></h5>
			<div class="controls">
	             <textarea id="editor2" name="long_descp_en" rows="10" cols="80">
		           {!! $products->long_descp_en !!}
				 </textarea>  
	 		 </div>
		</div>
				
			</div> <!-- end col md 6 -->			
		</div> <!-- end 3th row  -->




	
				
			</div> <!-- end col md 6 -->

			 
			
		</div> <!-- end 8th row  -->

	 
	 <hr>
 


	<div class="row">



						 
						<div class="text-xs-right">
<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update Ticket">
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


		<!-- ///////////////// Start Multiple Image Update Area ///////// -->

 <section class="content">
 	<div class="row">

<div class="col-md-12">
				<div class="box bt-3 border-info">
				  <div class="box-header">
		 <h4 class="box-title"><strong>Screen Shots</strong></h4>
				  </div>

			
		<form method="post" action="{{ route('update-product-image') }}" enctype="multipart/form-data" style="padding-left: 20px !important;">
        @csrf
			<div class="row row-sm">
				@foreach($multiImgs as $img)
				<div class="col-md-3">

<div class="card">
<a href="{{ asset($img->photo_name) }}" target="_blank">
  <img src="{{ asset($img->photo_name) }}" class="card-img-top" style="height: 170px; width: 385px; padding-left:20px;">
  </a>
  <div class="card-body">
    <h5 class="card-title">
<a href="{{ route('product.multiimg.delete',$img->id) }}" class="btn btn-sm btn-danger" id="delete" title="Delete Data"><i class="fa fa-trash"></i> </a>
     </h5>
    <p class="card-text"> 
    	

		<div class="popup-image">
			<div style="position:relative; top:0; left:0; margin:20px 10px ; width:100%; height:100%;">
			<span><p><i class="mdi mdi-close"></i></p></span>
		  <img class="imgpreview" src="{{ asset($img->photo_name) }}" alt="">
		  </div>
    	</div> 
    </p>
  
  </div>
</div> 		
				


				</div><!--  end col md 3		 -->	
@endforeach



			</div>		

</div>
  <!--end image preview -->	

  <div class="row"> <!-- start 3RD row  -->
			<div class="col-md-12">

	    <div class="form-group">
			
			
		</div>
				
			</div> <!-- end col md 6 -->			
		</div> <!-- end 3th row  -->




		</form>		   



				</div>
			  </div>
 

 		
 	</div> <!-- // end row  -->
 	
 </section>
<!-- ///////////////// End Start Multiple Image Update Area ///////// -->




			
				
		</form>		   


	


				</div>
			  </div>
 

 		
 	</div> <!-- // end row  -->
	
 	
 </section>
<!-- ///////////////// End Start Thambnail Image Update Area ///////// -->



	  </div>

 <!-- <script type="text/javascript">
function previewimage(){
	document.querySelector('.popup-image').style.display = 'block';
	document.querySelector('.popup-image img').src = image.getAttribute('src');
}


document.querySelector('.popup-image span').onclick = ()=>{
   document.querySelector('.popup-image').style.display = 'none';
}

</script> -->





</section>
<!-- ///////////////// End Start Thambnail Image Update Area ///////// -->



	  </div>



	
 <script type="text/javascript">


const elementSelect = document.getElementById("ticketingstage");
const elementInput = document.getElementById("summarywrite");

elementSelect.addEventListener("change", function() {
  if (this.value === "7") {
    elementInput.style.display = "inline";
  
  } else {
    elementInput.style.display = "none";

  }
});

// function previewimagethambnail(){
// 	document.querySelector('.popup-images').style.display = 'block';
// 	document.querySelector('.popup-images img').src = image.getAttribute('src');
// }


// document.querySelector('.popup-images span').onclick = ()=>{
//    document.querySelector('.popup-images').style.display = 'none';
// }

</script>

 
 <script type="text/javascript">



      $(document).ready(function() {
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
                          $.each(data, function(key, value){
                              $('select[name="subcategory_id"]').append('<option value="'+ value.id +'">' + value.subcategory_name_en + '</option>');
                          });
                    },
                });
				var subcategory_id = $(this).val();
            if(subcategory_id) {
                $.ajax({
                    url: "{{  url('/category/sub-subcategory/ajax') }}/"+subcategory_id,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                       var d =$('select[name="subsubcategory_id"]').empty();
                          $.each(data, function(key, value){
                              $('select[name="subsubcategory_id"]').append('<option value="'+ value.id +'">' + value.subsubcategory_name_en + '</option>');
                          });
                    },
                });
            } else {
                alert('danger');
            }
            } else {
                alert('danger');
            }
        });



 $('select[name="subcategory_id"]').on('change', function(){
            var subcategory_id = $(this).val();
            if(subcategory_id) {
                $.ajax({
                    url: "{{  url('/category/sub-subcategory/ajax') }}/"+subcategory_id,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                    //    var d =$('select[name="subsubcategory_id"]').empty();
                          $.each(data, function(key, value){
                              $('select[name="subsubcategory_id"]').append('<option value="'+ value.id +'">' + value.subsubcategory_name_en + '</option>');
                          });
                    },
                });
            } else {
                alert('danger');
            }
        });
 

		 
//   According to group select change it supporter name

    $('select[name="Group_IT"]').on('change', function(){
        var Group_ID = $(this).val();

        if(Group_ID) {
            $.ajax({
                url: "{{ url('/product/Ticket_IT_Supporter/ajax') }}/" + Group_ID,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    // Clear previous checkboxes
                    $('.form-check').remove();

                    // Iterate through fetched data and populate checkboxes
                    $.each(data, function(key, value) {
                        var isChecked = ($.inArray(value.id.toString(), {!! json_encode($assignedUsers) !!} ) !== -1) ? 'checked' : '';
                        var checkbox = '<div class="form-check">' +
                                            '<input type="checkbox" name="assign[]" value="' + value.id + '" class="form-check-input" ' + isChecked + '>' +
                                            '<label class="form-check-label">' + value.name + '</label>' +
                                        '</div>';
                        $('.controls').append(checkbox);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data", error);
                }
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
			 
				  $('select[name="product_name_en"]').append('<option value="'+ value.id +'" >' + value.name + '</option>');
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

   $(document).ready(function(){
	$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})
});
    </script>


@endsection