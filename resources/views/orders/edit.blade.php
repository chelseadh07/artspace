@extends('layouts.app')

@section('title','Edit Order')

@section('content')
<div class="container-fluid py-4">

    <div style="max-width: 700px; margin: 0 auto;">

        <!-- Header -->
        <div class="mb-4">
            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <h1 class="fw-bold mb-1">
                <i class="fas fa-edit"></i> Edit Order #{{ $order->order_id }}
            </h1>
            <p class="text-muted">Update order information</p>
        </div>

        <!-- Form Card -->
        <div class="card card-hover">
            <div class="card-body p-5">
                <form action="{{ route('orders.update', $order) }}" method="POST">
                    @csrf @method('PUT')

                    <!-- Service Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Service</label>
                        <select name="service_id" class="form-select form-select-lg" required>
                            <option value="">-- Select Service --</option>
                            @foreach($services as $s)
                                <option value="{{ $s->service_id }}" 
                                    {{ $order->service_id === $s->service_id ? 'selected' : '' }}>
                                    {{ $s->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Artist Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Artist</label>
                        <select name="artist_id" class="form-select form-select-lg" required>
                            <option value="">-- Select Artist --</option>
                            @foreach($artists as $a)
                                <option value="{{ $a->user_id }}" 
                                    {{ $order->artist_id === $a->user_id ? 'selected' : '' }}>
                                    {{ $a->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('artist_id')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Price (Rp)</label>
                        <input type="number" name="price" step="0.01" class="form-control form-control-lg" 
                               value="{{ old('price', $order->price) }}" required>
                        @error('price')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select form-select-lg" required>
                            @foreach(['pending','accepted','in_progress','finished','cancelled'] as $s)
                                <option value="{{ $s }}" 
                                    {{ $order->status === $s ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $s)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Special Request -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Special Request / Notes</label>
                        <textarea name="description_request" class="form-control" rows="5" 
                                  placeholder="Any special requirements?">{{ old('description_request', $order->description_request) }}</textarea>
                        @error('description_request')
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
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>

</div>
@endsection
