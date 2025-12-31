@extends('layouts.app')

@section('title','Checkout')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Left: Order Summary -->
        <div class="col-md-6">
            <h3 class="mb-4">Order Summary</h3>

            <!-- Service Details -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $service->title }}</h5>
                    <p>{{ $service->description }}</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="h4 mb-0" id="selectedPrice">Rp {{ number_format($service->base_price, 0, ',', '.') }}</span>
                        <span class="badge bg-success">Active</span>
                    </div>
                    <hr>
                    <p><strong>Service by:</strong> {{ $service->artist->name ?? '—' }}</p>
                </div>
            </div>

            <!-- Order Notes -->
            <div class="mb-4">
                <label for="description_request" class="form-label"><strong>Special Request / Notes (Optional)</strong></label>
                <textarea id="description_request" name="description_request" class="form-control" rows="4" placeholder="Tell the artist your requirements..."></textarea>
                <small class="form-text text-muted">e.g., specific colors, style, deadline, reference images, etc.</small>
            </div>
        </div>

        <!-- Right: Checkout Details -->
        <div class="col-md-6">
            <h3 class="mb-4">Checkout</h3>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <input type="hidden" name="service_id" value="{{ $service->service_id }}">

                <!-- Category Selection (if multiple categories) -->
                @if($service->categories && $service->categories->count() > 0)
                    <div class="mb-3">
                        <label for="category_id" class="form-label"><strong>Select Category</strong></label>
                        <select id="category_id" name="category_id" class="form-select bg-dark text-light border-secondary" required>
                            <option value="">-- Choose a category --</option>
                            @foreach($service->categories as $category)
                                <option value="{{ $category->category_id }}" data-price="{{ $category->pivot->price }}">
                                    {{ $category->name }} - Rp {{ number_format($category->pivot->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                @else
                    <!-- Fallback: use base price if no categories -->
                    <input type="hidden" name="category_id" value="">
                @endif

                <!-- Price Summary -->
                <div class="card bg-dark border-secondary mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Service Price:</span>
                            <span id="totalPrice">Rp {{ number_format($service->base_price, 0, ',', '.') }}</span>
                        </div>
                        <hr class="my-2 border-secondary">
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong class="h5 mb-0 text-primary" id="finalTotal">Rp {{ number_format($service->base_price, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-cart"></i> Place Order
                    </button>
                    <a href="{{ route('services.show', $service) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Service
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card {
        border: 1px solid #27272a;
    }

    .form-control {
        background-color: #18181b;
        border-color: #27272a;
        color: #e5e7eb;
    }

    .form-control:focus {
        background-color: #18181b;
        border-color: #6366f1;
        color: #e5e7eb;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    }

    .form-select {
        background-color: #18181b;
        border-color: #27272a;
        color: #e5e7eb;
    }

    .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    }

    .btn-primary {
        background-color: #6366f1;
        border: none;
    }

    .btn-primary:hover {
        background-color: #4f46e5;
    }
</style>

<script>
    const basePrice = {{ $service->base_price }};
    const categorySelect = document.getElementById('category_id');
    const totalPrice = document.getElementById('totalPrice');
    const finalTotal = document.getElementById('finalTotal');

    function formatCurrency(value) {
        return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            if (this.value) {
                const selectedOption = this.options[this.selectedIndex];
                const price = parseInt(selectedOption.getAttribute('data-price'));
                totalPrice.textContent = formatCurrency(price);
                finalTotal.textContent = formatCurrency(price);
            }
        });
    }
</script>
@endsection
