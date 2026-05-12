@extends('admin.admin_master')
@section('admin')

<style>
	td{
		font-size:24px !important;
		text-align:left !important;;

	}
    h3{
        
		text-transform:capitalize;
    }
	

</style>
<div class="container-full">
		<!-- Content Header (Page header) -->
		  

		<!-- Main content -->
		<section class="content">
 
		 <!-- Basic Forms -->
		<div class="" style="padding:10px;">
          <div class="row">
           
			<!-- /row -->


			
			<!-- /row -->
</div>
          </div>
<div class="box" style="padding:10px;"> 
            <div class="row">
			<div class="col-md-6">
			<div class="row" style="display:flex; align-item:center;justify-content:center;">
						<div class="col-11" >
<div class="form-group">

	<h2 style="text-align:center; font-size: 20px font-weight:900">Work Summary</h2>
	<div class="controls">
<textarea id="editor2" name="long_descp_en" rows="10" cols="80" disabled>
{!!  $product->long_descp_en !!} </textarea>  

	</div>
</div>
</div>
</div>
</div> <!-- end col md 6 -->
<div class="col-md-6"  >
					<!-- table start -->
					<div class="row"  >
			

						<div class="col-11" style="margin:auto 0;"  >
						<div >
						<h2 style="text-align:center; font-weight:900; font-size: 20px; color:white; background:#000 ;padding:10px 5px; border-radius: 5px 5px 0 0 ; !important; ">Work Details</h2>
						<table id="example1" class="table table-bordered table-striped  margin-top-10 w-p100">

<tbody >


	 <tr>
	     Ticket ID:  #{{ $product->id }} 
	     
	     	<h3 style="text-align:center;font-size: 16px"><b>Assign Date:</b> 
                                                 {{ $product->created_at->format('d/m/Y') }}
                                            </h3>
	   
	<td style="font-size: 16px !important; background:#FFFFF  !important; "><b>Priority </b></td>
	<td style="font-size: 16px !important; background:#FFFFF  !important;">: &nbsp;
    @foreach ($brands as $brand)
       @if($brand->id == $product->brand_id ? 'selected': '')
       {{ $brand->brand_name_en }}   
       @endif
                                        @endforeach                              
                                        </td>
	</tr>


	<tr>

	</tr>


	<tr>

	</tr>



	<tr>
	<td style="font-size: 16px !important; background:#FFFFF  !important; "><b>Service Category</b></td>
	<td style="font-size: 16px !important; background:#FFFFF  !important;">: &nbsp;&nbsp;
	@foreach ($service_category as $item)
       @if($item->id == $product->service_category_id ? 'selected': '')
          {{ $item->service_category_name }}   
        @endif
    @endforeach      
                     
    </td>
	</tr>

	<tr>
	<td style="font-size: 16px !important; background:#FFFFF  !important; "><b>Category </b></td>
	<td style="font-size: 16px !important; background:#FFFFF  !important;">: &nbsp;&nbsp;
                      @foreach ($categories as $category)
                      @if($category->id == $product->category_id ? 'selected': '' )
                      {{ $category->category_name_en }}
                      @endif
                                        @endforeach
                     
    </td>
	</tr>



	
	</tr>

	<tr>
	<td style="font-size: 16px !important; background:#FFFFF  !important;"><b>Stage </b></td>
	 <td style="font-size: 16px !important; background:#FFFFF  !important;">: &nbsp;&nbsp;

     @foreach ($stage as $item)
                      @if($item->id == $product->status ? 'selected': '' )
                      {{ $item->Ticket_status }}
                      @endif
                      @endforeach </td>
	</tr>

	<tr>
	<td style="font-size: 16px !important; background:#FFFFF  !important;"><b>Time </b></td>

     <td style="font-size: 16px !important; background:#FFFFF  !important;" id="timer">: &nbsp;&nbsp;
	 {{ \Carbon\Carbon::createFromTimeStamp(strtotime($product->created_at))->diffForHumans() }}
		 </td>

    
	</tr>




</tbody>
 
</table>



</div>
						</div>
					</div>
					
					  <!-- table end -->
        
                </div> <!-- end col md 6 -->
            </div>
</div>
 <!-- end col md 12 -->




<div class="box" style="padding:10px;">
                <div class="row">
				<div class="col-md-12">
				<div class="box bt-3 border-info">
				  <div class="box-header">
				  <h2 style="text-align:center;font-size: 20px; font-weight:900">Issued Images (Click on image to view it in Big size)</h2>
				  </div>

			
		<form method="post" action="" enctype="multipart/form-data">
        @csrf
			<div class="row row-sm"  style="padding:10px;">
			
				<div class="col-md-12">

<div class="card" style="padding: 10px; display: flex; flex-wrap: wrap;">

@foreach($multiImgs as $img)
  @if (in_array(pathinfo($img->photo_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
    <!-- Display the image -->
    <a href="{{ asset($img->photo_name) }}" target="_blank">
      <img src="{{ asset($img->photo_name) }}" class="card-img-top" style="height: 170px; width: 385px; object-fit: cover;">
    </a>
  @else
    <!-- Display file banner and provide download button -->
    <div style="width: 385px; height: 170px; background-color: #f0f0f0; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; position: relative;">
      <!-- File banner (generic file icon or banner) -->
      <img src="/path/to/generic-file-banner.png" style="max-width: 80px; max-height: 80px;">
      <br>
      <!-- Download button with icon -->
      <a href="{{ asset($img->photo_name) }}" class="btn btn-primary mt-2" download>
        <i class="fas fa-download"></i> Download
      </a>
    </div>
  @endif
@endforeach

</div>
</div>





<!-- attachment  start-->




<!-- attachment end -->


</div>


                <div class="row">
				<div class="col-md-12">
				<div class="box bt-3 border-info">
				  <div class="box-header">
				  <h2 style="text-align:center;font-size: 20px; font-weight:900">Attachments</h2>
				  </div>

			
		<form method="post" action="" enctype="multipart/form-data">
        @csrf
			<div class="row row-sm"  style="padding:10px;">
			
				<div class="col-md-12" >


<a href="" style="font-size:20px;background-color:#181823; color:white; "class="btn btn-info" title="Download Attachment">Download</a>

		 <!-- end col md 12 -->

                </div>

</section>
</div>
					
                    



@endsection

