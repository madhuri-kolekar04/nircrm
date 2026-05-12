@extends('admin.admin_master')

@section('admin')
@section('page-title', 'Services & Prices')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-tags text-primary"></i>
                        Services & Prices
                    </h4>
                    <a href="{{ route('services.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i>
                        Add New Service
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($services->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="servicesTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Service Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Pricing Type</th>
                                        <th>Timeline</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1; @endphp
                                    @foreach($services as $service)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>
                                            <strong>{{ $service->name }}</strong>
                                            @if($service->is_optional)
                                                <span class="badge bg-info ms-2">Optional</span>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($service->description, 100) }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $service->formatted_price }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $service->formatted_pricing_type }}</span>
                                        </td>
                                        <td>
                                            @if($service->timeline_weeks)
                                                <span class="badge bg-warning">{{ $service->timeline_weeks }} weeks</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($service->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('services.edit', $service->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Edit Service">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('services.destroy', $service->id) }}" 
                                                      method="POST" 
                                                      style="display: inline-block;"
                                                      onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete Service">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tags text-muted fa-3x mb-3"></i>
                            <h5 class="text-muted">No Services Found</h5>
                            <p class="text-muted">Start by adding your first service.</p>
                            <a href="{{ route('services.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Add First Service
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#servicesTable').DataTable({
        "pageLength": 25,
        "order": [[ 0, "desc" ]],
        "responsive": true,
        "language": {
            "emptyTable": "No services available"
        }
    });
});
</script>
@endsection
