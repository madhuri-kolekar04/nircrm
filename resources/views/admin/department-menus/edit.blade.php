@extends('admin.admin_master')

@section('page-title', 'Edit Department Menu Assignments')

@section('content')
<div class="content-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h2 class="mb-1">Edit Menu Assignments</h2>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-building me-2"></i>
                                    {{ $department->department_name }}
                                </p>
                            </div>
                            <a href="{{ route('department-menus.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Departments
                            </a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('department-menus.update', $department->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-utensils me-2"></i>
                                        Available Menus
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($availableMenus as $key => $menu)
                                            <div class="col-md-6 col-lg-4 mb-3">
                                                <div class="card border {{ $assignedMenus->has($key) ? 'border-primary' : 'border-secondary' }} h-100">
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" 
                                                                   name="menus[{{ $key }}][assigned]" 
                                                                   id="menu_{{ $key }}" 
                                                                   value="1"
                                                                   {{ $assignedMenus->has($key) ? 'checked' : '' }}>
                                                            <label class="form-check-label d-block" for="menu_{{ $key }}">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <i class="{{ $menu['menu_icon'] }} me-2 text-primary"></i>
                                                                    <strong>{{ $menu['menu_title'] }}</strong>
                                                                </div>
                                                                <small class="text-muted d-block">{{ $menu['menu_route'] }}</small>
                                                            </label>
                                                            
                                                            <input type="hidden" name="menus[{{ $key }}][menu_key]" value="{{ $menu['menu_key'] }}">
                                                            <input type="hidden" name="menus[{{ $key }}][menu_title]" value="{{ $menu['menu_title'] }}">
                                                            <input type="hidden" name="menus[{{ $key }}][menu_icon]" value="{{ $menu['menu_icon'] }}">
                                                            <input type="hidden" name="menus[{{ $key }}][menu_route]" value="{{ $menu['menu_route'] }}">
                                                            
                                                            <div class="mt-2">
                                                                <label class="form-label small">Sort Order:</label>
                                                                <input type="number" 
                                                                       class="form-control form-control-sm" 
                                                                       name="menus[{{ $key }}][sort_order]" 
                                                                       value="{{ $assignedMenus->has($key) ? $assignedMenus->get($key)->sort_order : $loop->index }}"
                                                                       min="0" 
                                                                       placeholder="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Quick Actions
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="selectAllMenus()">
                                                <i class="fas fa-check-square me-2"></i>Select All Menus
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="deselectAllMenus()">
                                                <i class="fas fa-square me-2"></i>Deselect All Menus
                                            </button>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <button type="button" class="btn btn-outline-info btn-sm" onclick="resetSortOrders()">
                                                <i class="fas fa-sort-numeric-up me-2"></i>Reset Sort Orders
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('department-menus.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Menu Assignments
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function selectAllMenus() {
    document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.checked = true;
    });
}

function deselectAllMenus() {
    document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.checked = false;
    });
}

function resetSortOrders() {
    document.querySelectorAll('input[type="number"]').forEach(function(input, index) {
        input.value = index;
    });
}

// Add visual feedback when checkboxes are changed
document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        const card = this.closest('.card');
        if (this.checked) {
            card.classList.remove('border-secondary');
            card.classList.add('border-primary');
        } else {
            card.classList.remove('border-primary');
            card.classList.add('border-secondary');
        }
    });
});
</script>
@endsection
