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

                    <!-- Categories with Multiple Pricing -->
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

<script>
let categories = [];

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
    document.getElementById('categories_json').value = JSON.stringify(categories);
    
    // Render ulang list
    renderCategories();
    
    // Clear inputs
    categoryInput.value = '';
    priceInput.value = '';
    categoryInput.focus();
});

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
    document.getElementById('categories_json').value = JSON.stringify(categories);
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
@endsection
