@extends('layouts.app')

@section('title','Edit Artwork')

@section('content')
<div class="container-fluid py-4">

    <div style="max-width: 700px; margin: 0 auto;">

        <!-- Header -->
        <div class="mb-4">
            <a href="{{ route('artworks.show', $artwork) }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <h1 class="fw-bold mb-1">
                <i class="fas fa-edit"></i> Edit Artwork
            </h1>
            <p class="text-muted">Update your artwork information</p>
        </div>

        <!-- Form Card -->
        <div class="card card-hover">
            <div class="card-body p-5">
                <form action="{{ route('artworks.update', $artwork) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <!-- Title -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Artwork Title</label>
                        <input type="text" name="title" class="form-control form-control-lg" 
                               value="{{ old('title', $artwork->title) }}" required>
                        @error('title')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="5" required>{{ old('description', $artwork->description) }}</textarea>
                        @error('description')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Category</label>
                        <select name="category_id" class="form-select form-select-lg">
                            <option value="">-- Select a Category --</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->category_id }}" 
                                    {{ old('category_id', $artwork->category_id) == $c->category_id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Current Image -->
                    @if($artwork->image_url)
                        <div class="mb-4">
                            <label class="form-label fw-bold">Current Image</label>
                            <img src="{{ asset('storage/'.$artwork->image_url) }}" 
                                 style="width: 100%; max-height: 250px; object-fit: contain; border-radius: 8px;">
                        </div>
                    @endif

                    <!-- Replace Image -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Replace Image (Optional)</label>
                        <div class="input-group input-group-lg">
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <span class="input-group-text">
                                <i class="fas fa-image"></i>
                            </span>
                        </div>
                        <small class="text-muted d-block mt-2">Leave empty to keep current image</small>
                        @error('image')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="mb-4" style="display: none;">
                        <label class="form-label fw-bold">New Image Preview</label>
                        <img id="previewImg" src="" style="width: 100%; max-height: 300px; object-fit: contain; border-radius: 8px;">
                    </div>

                    <!-- Divider -->
                    <hr class="border-dark my-4">

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <a href="{{ route('artworks.show', $artwork) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>

</div>

<script>
    // Image preview script
    document.querySelector('input[name="image"]').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('previewImg').src = event.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
