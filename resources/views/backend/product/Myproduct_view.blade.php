
@extends('admin.admin_master')
@section('admin')

<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> -->

<style>
.table > tbody > tr > td{
	padding:5px 5px;
	font-size:17px;
	text-align:center;
	
}
/* span{
	font-size:17px  !important;
} */
.dt-button{
	display:none;
}

.badge{

	min-width: 100px !important;

}
.disabled a{
	color:black !important;
}
</style>

<!-- ------------------------------model code------------------------------------ -->
<div class="modal fade"  id="modal-default" style="display: none;" aria-hidden="true">
	  <div class="modal-dialog" role="document" >
		<div class="modal-content" style="background-color:#fff ;border-radius:10px">
		  <div class="modal-header"style="background-color:#000;border-radius:10px 10px 0 	0px">
			<h4 class="modal-title" style="color:white">Forword work to next group</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span></button>
		  </div>
		  <form method="post" action="{{ route('userassignupdate') }}" enctype="multipart/form-data" >
		 	@csrf
		  <div class="modal-body">
		     	<!--------------------------------form data start-----------------  -->


          <div class="row">

				 <div class="col-md-6">
		
				 <div class="form-group">
				 <h5>Tier  <span class="text-danger">*</span></h5>
				<div class="controls">
				<select   id="userId" name="tiergroup" class="form-control" required="" >
			
		        </select>
				<input style="opacity:0;"   type="text" name="ticketid" value="" id="ticketid">


				
				</div>
				</div>

						

				</div> <!-- end col md 6 -->





         <div class="col-md-6">

						<div class="form-group">
			<h5>IT Technision Name <span class="text-danger">*</span></h5>
			<div class="controls">
				<select name="assign" class="form-control" required="" >
				
					
				</select>
			 
			</div>
				</div>
						
					</div> <!-- end col md 4 -->
			
					</div>



            <!-- --------------------------------form data ends-------------------- -->

		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-rounded btn-primary float-right">Submit</button>
		  </div>
		  </form>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
  </div>

		  <!-- ------------------------------------model closed--------------------------------- -->



  <!-- Content Wrapper. Contains page content -->
  
	  <div class="container-full">
		<!-- Content Header (Page header) -->
	
		@if ((auth()->user()->role == 2) || (auth()->user()->role == 1))
		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			<div class="col-12">

			 <div class="box">
				<div class="box-header with-border">
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
			

				@if ((auth()->user()->role == 2) || (auth()->user()->role == 1))

				
				
				<a href="{{ route('add-product') }}" style="float :right"class="btn btn-info" title="Add Ticket"><i class="fa-solid fa-plus"></i></a>

				@elseif(auth()->user()->role == 3)
					<a href="{{ route('add-productuser') }}" style="float :right"class="btn btn-info" title="Add Ticket"><i class="fa-solid fa-plus"></i></a>
				@else
				@endif

				<h3 class="box-title">Tickets <span class="badge badge-pill badge-danger"> {{ count($products) }} </span></h3>
				</div>
				<!-- /.box-header -->
				<div style="transform: scale(0.9);width: 110%; transform-origin: 0% 0% 0px;" class="box-body">
					<div class="table-responsive">
				
					<!-- <button class="btn btn-primary" name="hidebtn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapseExample" onclick="(function() { document.getElementById('collapse1').classList.remove('show'); })();">Dounload</button> -->
					<table id="example3" style="border:1px solid #000;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
        <thead>
            <tr>
                <th>Ticket_ID</th>
                <th>Emp_ID</th>
                <th>Main Note</th>
                <th>Project Details</th>
                <th>System</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>due_info</th>
                <th>Assigned To</th>
                <th>Time</th>
                <th>Priority</th>
                <th>Controls</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;?>
            @foreach($products as $item)
                <tr id="ticket-{{ $item->id }}">
                    <td>{{ $item->id }}</td>
                    <td><span class="badge">{{ $item['servicecategory']['service_category_name'] }}</span></td>
                    <td><span class="badge">{{ $item['category']['category_name_en'] }}</span></td>
                    <td><span class="badge">{{ $item['long_descp_en'] }}</span></td>
                    <td><span class="badge">{{ $item['subcategory']['subcategory_name_en'] }}</span></td>
                    <td><span class="badge">{{ $item['product_name_en'] }}</span></td>
                    <td class="end-date"><span class="badge">{{ $item->created_at->format('d/m/Y') }}</span></td>
                    <td class="due-info"><span class="badge">{{ $item['due_info'] }}</span></td>
                    @if($item->Assign !== NULL)
                        <td><span class="badge">{{ $item['assignusername']['name'] }}</span></td>
                    @elseif($item->Assign == NULL)
                        <td id="assignalert"><span class="badge badge-danger">Not Assigned</span></td>
                    @endif
                    <td><span class="badge">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($item->created_at))->diffForHumans() }}</span></td>
                    <td>
                        @if(str_contains(strtolower($item['due_info']), 'overdue'))
                            <span class="badge badge-danger">High</span>
                        @else
                            @if($item->brand_id == 1)
                                <span class="badge badge-danger">High</span>
                            @elseif($item->brand_id == 2)
                                <span class="badge" style="background-color:#F5EA5A">Low</span>
                            @else
                                <span class="badge" style="background-color:#F2921D">Medium</span>
                            @endif
                        @endif
                    </td>
                    <td>
                        <div style="width:250px">
                            <a href="{{ route('product.preview', $item->id) }}" class="btn btn-info" title="Preview Product"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('product.edit', $item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i></a>
                            <a href="{{ route('product.delete', $item->id) }}" class="btn btn-danger" title="Delete Data" id="delete"><i class="fa fa-trash"></i></a>
                            <button type="button" id="excelate" value="{{$item->id}}" data-toggle="modal" data-target="#modal-default" class="btn btn-info">Escalate</button>
                        </div>
                    </td>
                </tr>
                <?php $i++; ?>
            @endforeach
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('#example3 tbody tr');

            function calculateDueInfo(endDateStr) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                const [day, month, year] = endDateStr.split('/');
                const endDate = new Date(year, month - 1, day);
                endDate.setHours(0, 0, 0, 0);

                const timeDiff = endDate.getTime() - today.getTime();
                const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if (dayDiff < 0) {
                    return `Overdue by ${Math.abs(dayDiff)} days`;
                } else if (dayDiff === 0) {
                    return `Due today`;
                } else {
                    return `${dayDiff} days remaining`;
                }
            }

            rows.forEach(row => {
                const endDateElem = row.querySelector('.end-date .badge');
                const dueInfoBadge = row.querySelector('.due-info .badge');

                if (endDateElem && dueInfoBadge) {
                    dueInfoBadge.textContent = calculateDueInfo(endDateElem.textContent);
                }
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
		@else
		@endif


			
		@if ((auth()->user()->role == 3) )
		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			<div class="col-12">

			 <div class="box">
				<div class="box-header with-border">
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
				<a href="{{ route('add-productuser') }}" style="float :right"class="btn btn-info" title="Add Ticket"><i class="fa-solid fa-plus"></i></a>
				  <h3 class="box-title">Ticket List 
				  @if ( (auth()->user()->role == 2) || (auth()->user()->role == 4)) || (auth()->user()->role == 1))  )
				  <span class="badge badge-pill badge-danger"> {{ count($products) }} </span>
				@endif
				</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
				
					<table id="example1" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
						<thead>
							<tr>
							<th>Ticket ID </th>
								<!-- <th>Image </th> -->
								<th>Name</th>
								<th>Department</th>
								<th>Category</th>
								<th>Sub-Category</th>
								<th>Item</th>
								<th>Assign</th>
								<th>Priority</th>
								<th>Status </th>
								<th>Created At </th>
								
							
								 
							</tr>
						</thead>
					
						<tbody>
	 @foreach($userData as  $key=>$item)
	 <tr>
		
	 @if($key <= 010)
	   		<td>{{'0'.$key+1}}</td>
		@else
			<td>{{$key+1}}</td>
		@endif
		<!-- <td> <img src="{{ (!empty($item->product_thambnail))? asset($item->product_thambnail):url('upload/no_image.jpg') }}" style="width: 60px; height: 50px;">  </td> -->
		<td>{{ $item['usergetname']['name'] }}</td>
		<td>{{ $item['departmentfuc']['department'] }}</td>
		<td> {{ $item['category']['category_name_en'] }}  </td>
		<td> {{ $item['subcategory']['subcategory_name_en'] }} </td>
		<td> {{ $item['subsubcategory']['subsubcategory_name_en'] }}  </td>
		<td >@if($item->assign == null)
				<span class="badge badge-pill badge-danger"> Not Assign </span>
			@else
		{{ $item['assignusername']['name'] }}
	     @endif</td>
	
		 <td>
		@if( $item->brand_id == 1)
		 	<span class="badge badge-pill badge-danger"> High </span>
		 	@elseif($item->brand_id == 2)
			 <span class="badge badge-pill "style="background-color:#F5EA5A"> Low </span>
			 @else
			 <span class="badge badge-pill " style="background-color:#F2921D"> Medium </span>
		@endif
		</td>
		 <td>
		
				 @if($item->status == 1)
						<span class="badge badge-pill " style="background-color:#5BC0F8"> Started </span>	
						@elseif($item->status == 2)
						<span class="badge badge-pill" style="background-color:#BDCDD6"> In Process </span>
						@elseif($item->status == 4)
						<span class="badge badge-pill badge-danger"> Completed </span>
						@elseif($item->status == 3)
						<span class="badge badge-pill" style="background-color:#00FFD1"> OnHold </span>
						@elseif($item->status == 5)
						<span class="badge badge-pill" style="background-color:#F99417"> Not Started </span>
							@elseif($item->status == 6)
						<span class="badge badge-pill" style="background-color:#007BFF"> changes </span>
					
							@else
						<span class="badge badge-pill "style="background-color:#FFD4B2"> No status </span>
				@endif
		
		 </td>

		

		 <td id="timer">
		 {{ \Carbon\Carbon::createFromTimeStamp(strtotime($item->created_at))->diffForHumans() }}
		 </td>
		

		
<!-- @if($item->status == 1)
 <a href="{{ route('product.inactive',$item->id) }}"  style="padding:5px 10px; margin:5px 5px" class="btn btn-danger" title="Inactive Now"><i class="fa fa-arrow-down"></i> </a>
	 @else
 <a href="{{ route('product.active',$item->id) }}" style="padding:5px 10px; margin:5px 5px" class="btn btn-success" title="Active Now"><i class="fa fa-arrow-up"></i> </a>
	 @endif -->




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
		@else
		@endif
	  
	  </div>
  
<script type="text/javascript">
    var element = document.getElementsByClassName("dt-button");
    
    setInterval(function() {
        window.location.reload();
    }, 90000); // 90000 milliseconds is 1 minute and 30 seconds
</script>




<!-- 
<script>
var count = 3600;
var counter = setInterval(function timerDown() {
    count = count - 1;
    if (count === -1) {
        clearInterval(counter);
        return;
    }

    var seconds = count % 60,
        minutes = Math.floor(count / 60),
        hours = Math.floor(minutes / 60);
    minutes %= 60;
    hours %= 60;
  
  if ( minutes < 10) {
    
    minutes = '0' + minutes;
  }
  
  if ( hours < 10 ) {
    
    hours = '0' + hours;
  }
  
  if ( seconds < 10 ) {
    
    seconds = '0' + seconds;
  }  

    document.getElementById("countdown").innerHTML = hours + ":" + minutes + ":" + seconds; 
} , 1000); -->
<!-- 
</script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script> -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script>
$(document).ready(function() {
    $(document).on('click', '#excelate', function() {
        var ticket_id = $(this).val();
        $.ajax({
            type: 'GET',
            url: '/excalate/assign/' + ticket_id,
            success: function($getticketdata) {
                var d = $('select[name="tiergroup"]').empty();
                $.each($getticketdata.group, function(key, value) {
                    $('select[name="tiergroup"]').append('<option value="' + value.id + '">' + value.Group + '</option>');
                });
                $('#ticketid').val($getticketdata.ticket[0].id);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    $('select[name="tiergroup"]').on('change', function() {
        var Group_ID = $(this).val();
        if (Group_ID) {
            $.ajax({
                url: '/product/Ticket_IT_Supporter/ajax/' + Group_ID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var d = $('select[name="assign"]').empty();
                    $('select[name="assign"]').append('<option value="">Select Tier</option>');
                    $.each(data, function(key, value) {
                        $('select[name="assign"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        } else {
            alert('Please select a valid group.');
        }
    });
});
</script>


<script>
		
	// 	$('#example3').DataTable( {
	// 	dom: 'Bfrtip',
	// 	buttons: [
	// 		'copy', 'csv', 'excel', 'pdf', 'print'
	// 	],

	// } );
	
	// $('#example1').DataTable( {
	// 	dom: 'Bfrtip',
	// 	buttons: [
	// 		'copy', 'csv', 'excel', 'pdf', 'print'
	// 	],

	// } );
	
</script>





@endsection




