@extends('admin.admin_master')

@section('title')
    Create Menu Item - Admin Panel
@endsection

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card">
                
                <div class="card-header">
                    <h3 class="card-title">Create Menu Item</h3>

                    <div class="card-tools">
                        <a href="{{ route('menu-controller.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <form action="{{ route('menu-controller.store') }}" method="POST">
                    @csrf

                    <div class="card-body">

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- First Row --}}
                        <div class="row">

                            {{-- Menu Name --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_name">
                                        Menu Name <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           class="form-control"
                                           id="menu_name"
                                           name="menu_name"
                                           value="{{ old('menu_name') }}"
                                           placeholder="Enter menu name"
                                           required>
                                </div>
                            </div>

                            {{-- Menu URL --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_url">
                                        Menu URL <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           class="form-control"
                                           id="menu_url"
                                           name="menu_url"
                                           value="{{ old('menu_url') }}"
                                           placeholder="e.g. attendance/dashboard"
                                           required>
                                </div>
                            </div>

                        </div>

                        {{-- Second Row --}}
                        <div class="row">

                            {{-- Menu Icon --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_icon">Menu Icon</label>

                                    <input type="text"
                                           class="form-control"
                                           id="menu_icon"
                                           name="menu_icon"
                                           value="{{ old('menu_icon') }}"
                                           placeholder="e.g. fas fa-home">

                                    <small class="text-muted">
                                        Enter Font Awesome icon class
                                    </small>
                                </div>
                            </div>

                            {{-- Menu Order --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_order">Menu Order</label>

                                    <input type="number"
                                           class="form-control"
                                           id="menu_order"
                                           name="menu_order"
                                           value="{{ old('menu_order', 0) }}"
                                           min="0">

                                    <small class="text-muted">
                                        Lower numbers appear first
                                    </small>
                                </div>
                            </div>

                        </div>

                        {{-- Third Row --}}
                        <div class="row">

                            {{-- Role --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role_id">
                                        Role <span class="text-danger">*</span>
                                    </label>

                                    <select class="form-control"
                                            id="role_id"
                                            name="role_id"
                                            required>

                                        <option value="">Select Role</option>

                                        @foreach($roles as $id => $role)
                                            <option value="{{ $id }}"
                                                {{ old('role_id') == $id ? 'selected' : '' }}>
                                                {{ $role }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            {{-- Visibility Status --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_visible">Status</label>

                                    <select class="form-control"
                                            id="is_visible"
                                            name="is_visible">

                                        <option value="1"
                                            {{ old('is_visible', 1) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>

                                        <option value="0"
                                            {{ old('is_visible') == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>

                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="card-footer">

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Menu Item
                        </button>

                        <a href="{{ route('menu-controller.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
@endsection