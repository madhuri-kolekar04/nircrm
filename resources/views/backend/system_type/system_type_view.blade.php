@extends('admin.admin_master')
@section('admin')

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
    $('#example4').DataTable({
        dom: 'Bfrtip',
       
    });
});

</script>
<!-- Content Wrapper. Contains page content -->

<div class="container-full">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
        <div class="row">



            <div class="col-8">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Groups List <span class="badge badge-pill badge-danger">
                                {{ count( $system_type) }} </span></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example4" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Group Type  </th>
                                       
                                        <th>Controls</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($system_type as $key=> $item)
                                    

                                     

                                    <tr>
                                    @if($key <= 010)
                                            <td>{{'0'.$key+1}}</td>
                                        @else
                                            <td>{{$key+1}}</td>
                                        @endif
                                        </td>
                                        <td>{{ $item->system_type_name }}</td>
                                       
                                        <td>
                                            <a href="{{ route('system_type.edit',$item->id) }}" class="btn btn-info"
                                                title="Edit Data"><i class="fa fa-pencil"></i> </a>
                                            <a href="{{ route('system_type.delete',$item->id) }}" class="btn btn-danger"
                                                title="Delete Data" id="delete">
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


            <!--   ------------ Add system_type Page -------- -->


            <div class="col-4">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Groups </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">


                            <form method="post" action="{{ route('system_type.store') }}" enctype="multipart/form-data">
                                @csrf


                                <div class="form-group">
                                    <h5>Group Type   <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="system_type_name_en" class="form-control">
                                        @error('system_type_name_en')
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                // Override the alert function to automatically dismiss the alert
                                window.alert = function(message) {
                                    console.log("Alert dismissed: " + message);
                                };

                                $(document).ready(function () {
                                    // Check if DataTable is already initialized and destroy if it is
                                    if ($.fn.DataTable.isDataTable('#example1')) {
                                        $('#example1').DataTable().destroy();
                                    }
                                    // Initialize DataTable
                                    $('#example1').DataTable({
                                        "paging": true,       // Enable pagination
                                        "pageLength": 99999,  // Set a high number to display all data on one page
                                        "lengthMenu": [[99999], ["All"]],  // Customize the length menu label
                                        "info": false         // Disable info text
                                    });
                                });
                            </script>



@endsection