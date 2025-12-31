@extends('layouts.app')

@section('title', $service->title)

@section('content')
<div class="container-fluid py-4">

    <!-- Back Button -->
    <a href="{{ route('services.index') }}" class="btn btn-outline-secondary mb-4">
        <i class="fas fa-arrow-left"></i> Back to Services
    </a>

    <div class="row g-5">

        <!-- Thumbnail -->
        <div class="col-lg-6">
            <div class="card card-hover" style="border: none;">
                @if($service->thumbnail)
                    <img src="{{ asset('storage/'.$service->thumbnail) }}"
                         class="rounded"
                         style="width: 100%; height: 400px; object-fit: cover;">
                @else
                    <div class="bg-dark d-flex align-items-center justify-content-center rounded"
                         style="height: 400px;">
                        <div class="text-center">
                            <i class="fas fa-image fa-4x text-muted mb-3"></i>
                            <p class="text-muted">No Image Available</p>
                        </div>
                    </div>
                @endif
            </div>

            @if($service->category)
                <div class="mt-3">
                    <span class="badge bg-info p-2">
                        <i class="fas fa-tag"></i> {{ $service->category->name }}
                    </span>
                </div>
            @endif
        </div>

        <!-- Service Info -->
        <div class="col-lg-6">
            <!-- Header -->
            <h1 class="fw-bold mb-2">{{ $service->title }}</h1>

            <!-- Artist Info -->
            @if($service->artist)
                <a href="{{ route('artists.show', $service->artist) }}" class="text-decoration-none">
                    <div class="d-flex align-items-center gap-2 mb-4 pb-4 border-bottom border-dark card-hover-link" 
                         style="padding: 8px; border-radius: 6px; cursor: pointer; transition: background 0.3s ease;">
                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 40px; height: 40px;">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small">Artist</p>
                            <h6 class="mb-0 text-primary">{{ $service->artist->name }}</h6>
                        </div>
                        <i class="fas fa-arrow-right ms-auto text-primary"></i>
                    </div>
                </a>
            @endif

            <!-- Price Section -->
            <div class="mb-4">
                <p class="text-muted small">Base Price</p>
                <h2 style="color: #a5b4fc; font-weight: 700;">
                    Rp {{ number_format($service->base_price) }}
                </h2>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <h6 class="text-light mb-2">Description</h6>
                <p class="text-muted">{{ $service->description }}</p>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('orders.create', $service) }}"
                   class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-cart"></i> Order This Service
                </a>

                @if(auth()->check() && (auth()->id() === $service->user_id || auth()->user()->role === 'admin'))
                    <a href="{{ route('services.edit', $service) }}"
                       class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <form action="{{ route('services.destroy', $service) }}" 
                          method="POST" 
                          style="display:inline;"
                          onsubmit="return confirm('Delete this service?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-lg">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                @endif
            </div>

            <!-- Additional Info -->
            <div class="mt-5 pt-4 border-top border-dark">
                <div class="row">
                    @if($service->created_at)
                        <div class="col-6">
                            <p class="text-muted small">Created</p>
                            <p class="fw-semibold">{{ $service->created_at->format('M d, Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Reviews Section -->
    @php
        $reviews = $service->reviews()->with('client')->latest()->get();
        $averageRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0;
    @endphp

    <div class="mt-5 pt-5 border-top border-dark">
        <h3 class="fw-bold mb-4">
            <i class="fas fa-star text-warning"></i> Customer Reviews
            @if($averageRating > 0)
                <span class="text-muted" style="font-size: 0.7em;">
                    (@for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= round($averageRating) ? 'text-warning' : 'text-muted' }}"></i>
                    @endfor
                    {{ $averageRating }}/5 - {{ $reviews->count() }} review{{ $reviews->count() !== 1 ? 's' : '' }})
                </span>
            @else
                <span class="text-muted" style="font-size: 0.7em;">(No reviews yet)</span>
            @endif
        </h3>

        @if($reviews->count() > 0)
            <div class="row g-3">
                @foreach($reviews as $review)
                    <div class="col-md-6">
                        <div class="card bg-dark border-secondary">
                            <div class="card-body">
                                <!-- Rating Stars -->
                                <div class="mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                    <span class="text-light ms-2">{{ $review->rating }}.0</span>
                                </div>

                                <!-- Comment -->
                                @if($review->comment)
                                    <p class="text-light mb-3">{{ $review->comment }}</p>
                                @endif

                                <!-- Client Info -->
                                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top border-secondary">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 32px; height: 32px;">
                                            <i class="fas fa-user text-white fa-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-light mb-0 small fw-bold">{{ $review->client->name }}</p>
                                            <p class="text-muted mb-0 small">{{ $review->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No reviews yet. Be the first to review this service!
            </div>
        @endif
    </div>

</div>

<style>
    .card-hover-link:hover {
        background: rgba(99, 102, 241, 0.1) !important;
    }
</style>
@endsection
