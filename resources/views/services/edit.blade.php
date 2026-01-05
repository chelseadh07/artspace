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
                        <label class="form-label fw-bold">Categories (Optional - Add Multiple)</label>
                        <div class="mb-3">
                            <div class="d-flex gap-2 mb-2">
                                <input type="text" id="new_category" class="form-control form-control-lg" placeholder="Enter category name">
                                <input type="number" id="category_price" class="form-control form-control-lg" placeholder="Price (Rp)" min="0" step="0.01">
                                <button type="button" class="btn btn-outline-primary" id="add_category_btn">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                        <div id="categories_list" class="mt-3">
                            <!-- Kategori yang ditambahkan akan tampil di sini -->
                        </div>
                        <input type="hidden" id="categories_json" name="categories">
                        @error('categories')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Service Image -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Service Image</label>
                        @if($service->thumbnail)
                            <div class="mb-3">
                                <img src="{{ asset('storage/'.$service->thumbnail) }}" alt="{{ $service->title }}" class="img-thumbnail" style="max-width: 200px;">
                                <p class="text-muted mt-2">Current image</p>
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control form-control-lg" accept="image/*">
                        <small class="text-muted d-block mt-2">Accepted formats: JPEG, PNG, JPG, GIF (Max 2MB)</small>
                        @error('image')
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

<script>
let categories = [];

// Load existing categories
document.addEventListener('DOMContentLoaded', function() {
    @if($service->categories->count() > 0)
        categories = [
            @foreach($service->categories as $cat)
                {
                    name: '{{ $cat->name }}',
                    price: {{ $cat->pivot->price }}
                },
            @endforeach
        ];
        renderCategories();
        updateCategoriesJson();
    @endif
});

document.getElementById('add_category_btn').addEventListener('click', function() {
    const categoryInput = document.getElementById('new_category');
    const priceInput = document.getElementById('category_price');
    const categoryName = categoryInput.value.trim();
    const price = priceInput.value.trim();
    
    if (!categoryName) {
        alert('Please enter a category name');
        return;
    }
    
    if (!price) {
        alert('Please enter a price');
        return;
    }
    
    // Tambah ke array
    categories.push({
        name: categoryName,
        price: parseFloat(price)
    });
    
    // Update hidden input dengan JSON
    updateCategoriesJson();
    
    // Render ulang list
    renderCategories();
    
    // Clear inputs
    categoryInput.value = '';
    priceInput.value = '';
    categoryInput.focus();
});

function updateCategoriesJson() {
    document.getElementById('categories_json').value = JSON.stringify(categories);
}

function renderCategories() {
    const container = document.getElementById('categories_list');
    
    if (categories.length === 0) {
        container.innerHTML = '';
        return;
    }
    
    container.innerHTML = categories.map((cat, index) => `
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>${cat.name}</strong> - Rp ${new Intl.NumberFormat('id-ID').format(cat.price)}
            <button type="button" class="btn-close" onclick="removeCategory(${index})"></button>
        </div>
    `).join('');
}

function removeCategory(index) {
    categories.splice(index, 1);
    updateCategoriesJson();
    renderCategories();
}

// Allow Enter key to add category
document.getElementById('new_category').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('add_category_btn').click();
    }
});

document.getElementById('category_price').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('add_category_btn').click();
    }
});
</script>
