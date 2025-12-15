@extends('layouts.app')

@section('title','Checkout')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Left: Order Summary -->
        <div class="col-md-6">
            <h3 class="mb-4">Order Summary</h3>

            @if($service)
                <!-- Specific Service Checkout -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $service->title }}</h5>
                        <p class="text-muted">{{ $service->category->name ?? 'N/A' }}</p>
                        <p>{{ $service->description }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="h4 mb-0">Rp {{ number_format($service->base_price, 0, ',', '.') }}</span>
                            <span class="badge bg-success">Active</span>
                        </div>
                        <hr>
                        <p><strong>Service by:</strong> {{ $service->artist->name ?? '—' }}</p>
                    </div>
                </div>
            @else
                <!-- Browse & Select Service -->
                <div class="mb-4">
                    <label for="service_id" class="form-label"><strong>Choose Service</strong></label>
                    <select id="service_id" name="service_id" class="form-select form-select-lg" onchange="updateServiceInfo(this.value)">
                        <option value="">— Select a service —</option>
                        @foreach($services as $s)
                            <option value="{{ $s->service_id }}" data-price="{{ $s->base_price }}" data-title="{{ $s->title }}" data-artist="{{ $s->artist->name ?? 'N/A' }}" data-description="{{ $s->description }}">
                                {{ $s->title }} — Rp {{ number_format($s->base_price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="service_info" class="card mb-4" style="display: none;">
                    <div class="card-body">
                        <h5 id="info_title" class="card-title">—</h5>
                        <p id="info_description" class="text-muted">—</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span id="info_price" class="h4 mb-0">—</span>
                            <span id="info_artist" class="text-muted">—</span>
                        </div>
                    </div>
                </div>
            @endif

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

            <form action="{{ route('orders.store') }}" method="POST" id="checkout_form">
                @csrf

                <input type="hidden" id="hidden_service_id" name="service_id" value="{{ $service?->service_id ?? '' }}">

                <!-- Select Artist -->
                <div class="mb-4">
                    <label for="artist_id" class="form-label"><strong>Select Artist</strong></label>
                    <select id="artist_id" name="artist_id" class="form-select form-select-lg" required>
                        <option value="">— Choose artist —</option>
                        @foreach($artists as $a)
                            <option value="{{ $a->user_id }}" {{ $service && $service->artist_id === $a->user_id ? 'selected' : '' }}>
                                {{ $a->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Summary -->
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Service Price:</span>
                            <span id="summary_price">Rp 0</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong id="summary_total" class="h5 mb-0">Rp 0</strong>
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
                        <i class="bi bi-cart-check"></i> Proceed to Checkout
                    </button>
                    <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">
                        Continue Shopping
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateServiceInfo(serviceId) {
    const select = document.getElementById('service_id');
    const option = select.options[select.selectedIndex];
    const infoDiv = document.getElementById('service_info');
    const hiddenInput = document.getElementById('hidden_service_id');
    const summaryPrice = document.getElementById('summary_price');
    const summaryTotal = document.getElementById('summary_total');

    if (serviceId) {
        document.getElementById('info_title').textContent = option.dataset.title;
        document.getElementById('info_description').textContent = option.dataset.description;
        document.getElementById('info_price').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(option.dataset.price);
        document.getElementById('info_artist').textContent = 'by ' + option.dataset.artist;

        const price = parseInt(option.dataset.price);
        summaryPrice.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
        summaryTotal.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);

        hiddenInput.value = serviceId;
        infoDiv.style.display = 'block';
    } else {
        infoDiv.style.display = 'none';
        hiddenInput.value = '';
        summaryPrice.textContent = 'Rp 0';
        summaryTotal.textContent = 'Rp 0';
    }
}

// Initialize if service is pre-selected
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('service_id');
    if (select && select.value) {
        updateServiceInfo(select.value);
    }
});

// Form validation
document.getElementById('checkout_form').addEventListener('submit', function(e) {
    const serviceId = document.getElementById('hidden_service_id').value;
    const artistId = document.getElementById('artist_id').value;

    if (!serviceId) {
        e.preventDefault();
        alert('Please select a service');
        return false;
    }

    if (!artistId) {
        e.preventDefault();
        alert('Please select an artist');
        return false;
    }
});
</script>

<style>
    .card {
        border: 1px solid #27272a;
    }

    .form-select, .form-control {
        background-color: #18181b;
        border-color: #27272a;
        color: #e5e7eb;
    }

    .form-select option {
        background-color: #18181b;
        color: #e5e7eb;
    }

    .form-select:focus, .form-control:focus {
        background-color: #18181b;
        border-color: #6366f1;
        color: #e5e7eb;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    }

    .btn-primary {
        background-color: #6366f1;
        border: none;
    }

    .btn-primary:hover {
        background-color: #4f46e5;
    }

    .bg-light {
        background-color: #27272a !important;
    }
</style>
@endsection
