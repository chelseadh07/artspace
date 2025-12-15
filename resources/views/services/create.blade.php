@extends('layouts.app')

@section('title','Create Service')

@section('content')
<div class="container-fluid py-4">

    <div style="max-width: 700px; margin: 0 auto;">

        <!-- Header -->
        <div class="mb-4">
            <h1 class="fw-bold mb-1">
                <i class="fas fa-plus-circle"></i> Create New Service
            </h1>
            <p class="text-muted">Offer your artistic services to buyers</p>
        </div>

        <!-- Form Card -->
        <div class="card card-hover">
            <div class="card-body p-5">
                <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Service Title -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Service Title</label>
                        <input type="text" name="title" class="form-control form-control-lg" placeholder="e.g., Custom Portrait Painting" required>
                        @error('title')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Describe what you offer..." required></textarea>
                        @error('description')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Price & Duration Row -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Base Price (Rp)</label>
                            <input type="number" name="base_price" class="form-control form-control-lg" placeholder="100000" required>
                            @error('base_price')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Estimated Duration</label>
                            <input type="text" name="expected_duration" class="form-control form-control-lg" placeholder="e.g., 3-5 days">
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
                                <option value="{{ $c->category_id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Divider -->
                    <hr class="border-dark my-4">

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-check"></i> Create Service
                        </button>
                        <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>

</div>
@endsection
