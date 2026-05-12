@extends('admin.admin_master')

@section('admin')
@section('page-title', 'Edit Service')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-edit text-warning"></i>
                        Edit Service: {{ $service->name }}
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('services.update', $service->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Service Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $service->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price (₹) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', $service->price) }}" step="0.01" min="0" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pricing_type" class="form-label">Pricing Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('pricing_type') is-invalid @enderror" 
                                            id="pricing_type" name="pricing_type" required>
                                        <option value="">Select Pricing Type</option>
                                        @foreach($pricingTypes as $key => $type)
                                            <option value="{{ $key }}" {{ old('pricing_type', $service->pricing_type) == $key ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pricing_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="timeline_weeks" class="form-label">Timeline (Weeks)</label>
                                    <input type="number" class="form-control @error('timeline_weeks') is-invalid @enderror" 
                                           id="timeline_weeks" name="timeline_weeks" value="{{ old('timeline_weeks', $service->timeline_weeks) }}" min="1">
                                    @error('timeline_weeks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="key_features" class="form-label">Key Features (One per line)</label>
                            <textarea class="form-control" id="key_features" name="key_features" rows="3" 
                                      placeholder="Feature 1&#10;Feature 2&#10;Feature 3">{{ old('key_features', is_array($service->key_features) ? implode("\n", $service->key_features) : $service->key_features) }}</textarea>
                            <small class="text-muted">Enter each feature on a new line</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_optional" name="is_optional" 
                                           value="1" {{ old('is_optional', $service->is_optional) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_optional">
                                        Optional Service
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="status" name="status" 
                                           value="1" {{ old('status', $service->status) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('services.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Back to Services
                            </a>
                            <div>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i>
                                    Update Service
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
