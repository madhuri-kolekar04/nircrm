@extends('admin.admin_master')
@section('admin')


<!-- Content Wrapper. Contains page content -->

<div class="container-full">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
        <div class="row">



            <div class="col-8">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Customer Categories <span class="badge badge-pill badge-danger">
                                {{ count($operating_system) }} </span></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example4" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Categories List   </th>
                                        
                                       
                                        <th>Controls</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($operating_system as $key=> $item)
                                    

                                     

                                    <tr>
                                    @if($key <= 010)
                                            <td>{{'0'.$key+1}}</td>
                                        @else
                                            <td>{{$key+1}}</td>
                                        @endif
                                        </td>
                                        <td>{{ $item->operating_system }}</td>
                                        
                                       
                                        <td>
                                            <a href="{{ route('operating_system.edit',$item->id) }}" class="btn btn-info"
                                                title="Edit Data"><i class="fa fa-pencil"></i> </a>
                                            <a href="{{ route('operating_system.delete',$item->id) }}" class="btn btn-danger"
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


            <!--   ------------ Add operating_system Page -------- -->


           <div class="col-4">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add Categories List</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
          <form method="post" action="{{ route('operating_system.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <h5>Categories List</h5>
        <div class="controls">
            <input type="text" name="operating_system_name_en" class="form-control">
            @error('operating_system_name_en')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="text-xs-right">
        <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Submit">
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




@endsection