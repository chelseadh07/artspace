@extends('layouts.app')

@section('title','Upload Artwork')

@section('content')
<div class="container-fluid py-4">

    <div style="max-width: 700px; margin: 0 auto;">

        <!-- Header -->
        <div class="mb-4">
            <h1 class="fw-bold mb-1">
                <i class="fas fa-upload"></i> Upload Artwork
            </h1>
            <p class="text-muted">Share your artwork with the community</p>
        </div>

        <!-- Form Card -->
        <div class="card card-hover">
            <div class="card-body p-5">
                <form action="{{ route('artworks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Title -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Artwork Title</label>
                        <input type="text" name="title" class="form-control form-control-lg" 
                               placeholder="Give your artwork a title" 
                               value="{{ old('title') }}" required>
                        @error('title')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="5" 
                                  placeholder="Describe your artwork..." 
                                  required>{{ old('description') }}</textarea>
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
                                <option value="{{ $c->category_id }}" {{ old('category_id') === (string)$c->category_id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Image</label>
                        <div class="input-group input-group-lg">
                            <input type="file" name="image" class="form-control" 
                                   accept="image/*" required>
                            <span class="input-group-text">
                                <i class="fas fa-image"></i>
                            </span>
                        </div>
                        <small class="text-muted d-block mt-2">Supported formats: JPG, PNG, GIF (Max 5MB)</small>
                        @error('image')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="mb-4" style="display: none;">
                        <label class="form-label fw-bold">Preview</label>
                        <img id="previewImg" src="" style="width: 100%; max-height: 300px; object-fit: contain; border-radius: 8px;">
                    </div>

                    <!-- Divider -->
                    <hr class="border-dark my-4">

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-check"></i> Upload Artwork
                        </button>
                        <a href="{{ route('artworks.index') }}" class="btn btn-outline-secondary">
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
