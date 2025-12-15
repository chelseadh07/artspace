@extends('layouts.app')

@section('title','Edit Service')

@section('content')
<div class="container-fluid py-4">

    <div style="max-width: 700px; margin: 0 auto;">

        <!-- Header -->
        <div class="mb-4">
            <a href="{{ route('services.show', $service) }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <h1 class="fw-bold mb-1">
                <i class="fas fa-edit"></i> Edit Service
            </h1>
            <p class="text-muted">Update your service information</p>
        </div>

        <!-- Form Card -->
        <div class="card card-hover">
            <div class="card-body p-5">
                <form action="{{ route('services.update', $service) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <!-- Service Title -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Service Title</label>
                        <input type="text" name="title" class="form-control form-control-lg"
                               value="{{ $service->title }}" required>
                        @error('title')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="5" required>{{ $service->description }}</textarea>
                        @error('description')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Price & Duration Row -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Base Price (Rp)</label>
                            <input type="number" name="base_price" class="form-control form-control-lg"
                                   value="{{ $service->base_price }}" required>
                            @error('base_price')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Estimated Duration</label>
                            <input type="text" name="expected_duration" class="form-control form-control-lg"
                                   value="{{ $service->expected_duration }}">
                            @error('expected_duration')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Category</label>
                        <select name="category_id" class="form-select form-select-lg">
                            <option value="">-- Select a Category --</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->category_id }}"
                                    {{ $service->category_id === $c->category_id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select form-select-lg">
                            <option value="active" {{ $service->status === 'active' ? 'selected' : '' }}>
                                <i class="fas fa-check"></i> Active
                            </option>
                            <option value="inactive" {{ $service->status === 'inactive' ? 'selected' : '' }}>
                                <i class="fas fa-pause"></i> Inactive
                            </option>
                        </select>
                        @error('status')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Divider -->
                    <hr class="border-dark my-4">

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <a href="{{ route('services.show', $service) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>

</div>
@endsection
