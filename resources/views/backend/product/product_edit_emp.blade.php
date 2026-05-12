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
			  <h4 class="box-title">Edit Ticket </h4>
			   
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			  <div class="row">
				<div class="col">

  <form method="post" action="{{ route('product.updateemp') }}" enctype="multipart/form-data" >
		 	@csrf
<input type="text" style="opacity:0;"  name="product_id"value="{{ $products->id}}">
					  <div class="row">
	<div class="col-12">	


		<div class="row"> <!-- start 1st row  -->
	


	
 <!-- end col md 4 -->

	
<!-- end col md 4 -->


		



			
		</div> <!-- end 1st row  -->



<div class="row"> <!-- start 2nd row  -->




<!-- end col md 4 -->

			   <!-- end col md 4 -->

 <!-- end col md 4 -->





 <!-- end col md 4 -->
	
				



		
		  
<!-- Form -->
 <!-- end col md 4 -->
	<div class="col-12">	


		<div class="row"> <!-- start 1st row  -->
	

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


<!-- Hidden input to store the user's name -->




 <!-- end col md 4 -->
<!-- Hidden input to store the user's name -->
<input type="hidden" id="userName" value="{{ Auth::user()->name }}">

<div class="form-group">
    <h5>Change Log</h5>
    <div class="controls">
        <textarea id="changeLog" name="changeLog" class="form-control" rows="8" cols="80" readonly>{{ $products->changeLog }}</textarea>
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
            const logEntry = `Stage changed to "${selectedOption}" by ${userName} on ${currentDateTime}\n`;
            changeLog.value = logEntry + changeLog.value; // Prepend the new log entry
        });
    });
</script>



<div class="row"> <!-- start 8th row  -->
    <div class="col-md-12">
        <div class="form-group">
            <h5>Chatting <span class="text-danger">*</span></h5>
            <div class="controls">
                <p>Current User: <span id="username"><?php echo auth()->user()->name; ?></span></p>
                <div id="chatHistory" style="height: 200px; overflow-y: scroll;">
                    <textarea id="history" name="history" rows="10" cols="80" required readonly>{{ $products->history }}</textarea>
                </div>
                <input type="text" id="chatInput" rows="10" cols="80" placeholder="Type your message here...">
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>
</div>

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

        // Optionally, you can make an AJAX call to save the message to the server here
    }

    // Reload the page to refresh the chat
    location.reload();
}
</script>
	</div>

 <!-- end col md 4 -->


	   
<!-- <input type="file" name="product_thambnail" class="form-control" id="customFile"  value="{{ $products->product_thambnail}}"/> -->
	   <!-- <div class="col-md-4">

<div class="form-group">
<h5> Attachment<span class="text-danger">*</span></h5>
<div class="controls">
<input type="file" name="product_thambnail" value="{!! $products->product_thambnail !!}" class="form-control" id="customFile" /> -->
<!-- @foreach($stage as $item)
 <option value="{{ $item->id }}" {{ $item->id == $products->status ? 'selected': '' }} >{{ $item->Ticket_status }}</option>	
	   @endforeach -->

<!-- <a onclick="window.open('{{$products->product_thambnail}}')" class="btn btn-large pull-right"><i class="icon-download-alt"> </i> Download Brochure </a> -->
  
<!-- 
</select>
   @error('product_thambnail') 
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
	</div>
		   
	   </div>  -->
	   <!-- end col md 4 -->



	   


	   






		
		 
		
		 
	 

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



	






@endsection