@extends('admin.admin_master')

@section('page-title', 'Monthly report')

@section('admin')

<div class="d-flex justify-content-center align-items-center">

    <div style="width: 90%;">

        <!-- Header Card -->
        <div class="card bg-primary bg-gradient text-white mb-4">
            <div class="card-body">
                <div class="row align-items-center">

                    <div class="col-md-8">
                        <h3 class="card-title mb-2">
                            Monthly Reporting
                        </h3>
                    </div>

                    <div class="col-md-4 text-end">
                        <a href="{{ route('project-updates.show', $project->id) }}"
                           class="btn btn-light">

                            <i class="fas fa-arrow-left"></i>
                            Invoice Details
                        </a>
                    </div>

                </div>
            </div>
        </div>

       

        <!-- Filter + Report Table -->
        <div class="card">

            <div class="card-header">
                <h5 class="mb-0">Past Reports</h5>
            </div>

            <div class="card-body">

                <!-- Filter Form -->
                <form method="GET" class="row mb-4">

                    <div class="col-md-4">
                        <label>Filter by Month</label>

                        <input type="month"
                               name="month"
                               value="{{ request('month') }}"
                               class="form-control">
                    </div> 

                    <div class="col-md-4 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-primary me-2">

                            Filter
                        </button>

                        <a href="{{ route('monthly-report.details', $project->id) }}"
                           class="btn btn-secondary me-2">

                            Reset
                        </a>

                        <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#addReportModal">
                            Add  Report
                        </button>

                    </div>

                </form>

                <!-- Reports Table -->
                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="table-dark">

                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Month</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($reports as $report)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $report->title }}</td>

                                    <td>{{ $report->month }}</td>

                                    <td>{{ $report->description }}</td>


                                    <td>
                                        {{ $report->created_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        <a href="#"
                                           class="btn btn-sm btn-warning editReportBtn" data-title="{{ $report->title }}" data-url="{{ route('monthly-report.update', $report->id) }}"
                                           data-month="{{ $report->month }}" data-description="{{ $report->description }}" data-id="{{ $report->id }}"
                                           data-bs-toggle="modal" data-bs-target="#editReportModal">
                                           <i class="fa fa-pencil"></i> </a>

                                        <form action="{{route('monthly-report.destroy', $report->id)}}" method="post" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you Sure you want to delete this report?')"><i class="fa fa-trash"></i></button>
                                        </form>

                                        <button type="button" class="btn btn-sm btn-info viewReportBtn" data-title="{{$report->title}}"
                                        data-month="{{$report->month}}"
                                        data-description="{{$report->description}}"
                                        data-created="{{$report->created_at->format('d M Y')}}"
                                        data-attachment="{{$report->attachment}}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewReportModal"><i class="fa fa-eye"></i></button>

                                        <a href="{{ route('monthly-report.sendMail', $report->id) }}" class="btn btn-sm btn-primary"
                                        onclick="return confirm('Send report to customer email?')">
                                        <i class="fa fa-envelope"></i></a>
                                                                                
                                    </td>

                                   

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="text-center">
                                        No reports found
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- new report form -->
<div class="modal fade" id="addReportModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Add Monthly Report</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <form action="{{ route('monthly-report.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="modal-body">

                    <input type="hidden" name="project_id" value="{{ $project->id }}">

                    <div class="mb-3">

                        <label>Report Title</label>

                        <input type="text" name="title" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label>Select Month</label>

                        <input type="month" name="month" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label>Description</label>

                        <textarea name="description"  class="form-control"  rows="5" required></textarea>

                    </div>

                    <div class="mb-3">

                        <label>Upload Attachment</label>

                        <input type="file" name="attachment" class="form-control">

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close</button>

                    <button type="submit"  class="btn btn-success"> Submit Report</button>

                </div>

            </form>

        </div>

    </div>

</div>




<!-- edit form -->

<div class="modal fade" id="editReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Edit Monthly Report
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <form id="editReportForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="modal-body">
                    <div class="mb-3">

                       <label>Report Title</label>
                       <input type="text" name="title" id="edit_title" class="form-control" >
                    </div>

                    <div class="mb-3">
                        <label>select Month</label>
                        <input type="month" name="month" id="edit_month" class="form-control" >
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="5" ></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Upload New Attachment</lable>
                        <input type="file" name="attachment" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update Report</button>
                </div>
            </form>

        </div>

    </div>

</div>


<!-- view Report -->
 <div class="modal" id="viewReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Report</h5>
                <button class="btn-close" type="submit" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="fw-bold">Title</label>
                    <p id="view_title"></p>
                </div>

                 <div class="mb-3">
                    <label class="fw-bold">Month</label>
                    <p id="view_month"></p>
                </div>

                 <div class="mb-3">
                    <label class="fw-bold">Description</label>
                    <p id="view_description"></p>
                </div>

                 <div class="mb-3">
                    <label class="fw-bold">Created Date</label>
                    <p id="view_created"></p>
                </div>

                 <div class="mb-3">
                    <label class="fw-bold">Attachment</label>
                    <p id="view_attachment"></p>
                </div>
            </div>
        </div>
    </div>

 </div>





<script>
    document.addEventListener('DOMContentLoaded',function(){

       const editButtons= document.querySelectorAll('.editReportBtn');

         editButtons.forEach(button=>{

           button.addEventListener('click',function (){
                
              let url= this.getAttribute('data-url');
              let title= this.getAttribute('data-title');
              let month= this.getAttribute('data-month');
              let description= this.getAttribute('data-description');

              document.getElementById('edit_title').value= title;
              document.getElementById('edit_month').value= month;
              document.getElementById('edit_description').value = description;
              document.getElementById('editReportForm').action = url;
           });
         });
    });


// view



document.addEventListener('DOMContentLoaded', function () {

    const viewButtons = document.querySelectorAll('.viewReportBtn');

    viewButtons.forEach(button => {

        button.addEventListener('click', function () {

            let title = this.getAttribute('data-title');
            let month = this.getAttribute('data-month');
            let description = this.getAttribute('data-description');
            let created = this.getAttribute('data-created');
            let attachment = this.getAttribute('data-attachment');

            document.getElementById('view_title').innerText = title;
            document.getElementById('view_month').innerText = month;
            document.getElementById('view_description').innerText = description;
            document.getElementById('view_created').innerText = created;

          if (attachment && attachment !== "null" && attachment !== "") {

    document.getElementById('view_attachment').innerHTML =
        `<a href="/storage/${attachment}" target="_blank" class="btn btn-primary btn-sm">
            View Attachment
        </a>`;

} else {

    document.getElementById('view_attachment').innerHTML =
        `<span class="text-danger fw-bold">No Attachment Uploaded</span>`;
}
        });

    });

});



</script>

@endsection