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

                @if(auth()->check() && (auth()->user()->id === $service->artist_id || auth()->user()->role === 'admin'))
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
                    <div class="col-6">
                        <p class="text-muted small">Service ID</p>
                        <p class="fw-semibold">{{ $service->id }}</p>
                    </div>
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

    <!-- Artist Portfolio / Artwork Gallery -->
    @if($service->artist && $service->artist->artworks()->count() > 0)
        <div class="mt-5 pt-5 border-top border-dark">
            <h3 class="fw-bold mb-4">
                <i class="fas fa-palette"></i> Artist's Portfolio
            </h3>

            <div class="row g-4">
                @foreach($service->artist->artworks()->limit(8)->get() as $artwork)
                    <div class="col-md-3 col-sm-6">
                        <div class="card card-hover h-100">
                            <!-- Artwork Image -->
                            <div style="position: relative; overflow: hidden; height: 220px;">
                                @if($artwork->image_url)
                                    <img src="{{ asset('storage/'.$artwork->image_url) }}"
                                         class="w-100 h-100"
                                         style="object-fit: cover; transition: transform 0.3s ease;">
                                @else
                                    <div class="bg-dark d-flex align-items-center justify-content-center w-100 h-100">
                                        <div class="text-center">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column">
                                <!-- Title -->
                                <h6 class="card-title mb-2">{{ $artwork->title }}</h6>

                                <!-- Category -->
                                @if($artwork->category)
                                    <span class="badge bg-success mb-2" style="width: fit-content;">
                                        {{ $artwork->category->name }}
                                    </span>
                                @endif

                                <!-- Description -->
                                <p class="text-muted small flex-grow-1">
                                    {{ Str::limit($artwork->description, 60) }}
                                </p>

                                <!-- View Button -->
                                <a href="{{ route('artworks.show', $artwork) }}"
                                   class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View Full Portfolio Link -->
            @if($service->artist->artworks()->count() > 8)
                <div class="text-center mt-4">
                    <a href="{{ route('artists.show', $service->artist) }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-images"></i> View Full Portfolio
                    </a>
                </div>
            @endif
        </div>
    @endif

</div>

<style>
    .card-hover-link:hover {
        background: rgba(99, 102, 241, 0.1) !important;
    }
</style>
@endsection
