@extends('layouts.app')

@section('title', $artwork->title)

@section('content')
<div class="container-fluid py-4">

    <!-- Back Button -->
    <a href="{{ route('artworks.index') }}" class="btn btn-outline-secondary mb-4">
        <i class="fas fa-arrow-left"></i> Back to Artworks
    </a>

    <div class="row g-5">

        <!-- Artwork Image -->
        <div class="col-lg-6">
            <div class="card card-hover" style="border: none;">
                @if($artwork->image_url)
                    <img src="{{ asset('storage/'.$artwork->image_url) }}" 
                         class="rounded"
                         style="width: 100%; height: 500px; object-fit: cover;">
                @else
                    <div class="bg-dark d-flex align-items-center justify-content-center rounded"
                         style="height: 500px;">
                        <div class="text-center">
                            <i class="fas fa-image fa-4x text-muted mb-3"></i>
                            <p class="text-muted">No Image Available</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Artwork Info -->
        <div class="col-lg-6">

            <!-- Title -->
            <h1 class="fw-bold mb-4">{{ $artwork->title }}</h1>

            <!-- Artist Info -->
            @if($artwork->user)
                <div class="d-flex align-items-center gap-3 mb-4 pb-4 border-bottom border-dark">
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 45px; height: 45px;">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Artist</p>
                        <h6 class="mb-0">{{ $artwork->user->name }}</h6>
                    </div>
                </div>
            @endif

            <!-- Category & Tags -->
            @if($artwork->category || $artwork->created_at)
                <div class="mb-4">
                    <div class="d-flex gap-2 flex-wrap">
                        @if($artwork->category)
                            <span class="badge bg-success p-2">
                                <i class="fas fa-tag"></i> {{ $artwork->category->name }}
                            </span>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Description -->
            <div class="mb-5">
                <h6 class="text-light mb-3">Description</h6>
                <p class="text-muted" style="line-height: 1.6;">{{ $artwork->description }}</p>
            </div>

            <!-- Metadata -->
            <div class="mb-5 pb-4 border-bottom border-dark">
                <div class="row">
                    @if($artwork->created_at)
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small">Created</p>
                            <p class="fw-semibold">{{ $artwork->created_at->format('M d, Y') }}</p>
                        </div>
                    @endif
                    @if($artwork->updated_at)
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small">Updated</p>
                            <p class="fw-semibold">{{ $artwork->updated_at->format('M d, Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->id() === $artwork->user_id))
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('artworks.edit', $artwork) }}"
                       class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <form action="{{ route('artworks.destroy', $artwork) }}" 
                          method="POST" 
                          style="display:inline;"
                          onsubmit="return confirm('Delete this artwork?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-lg">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            @endif

        </div>

    </div>

</div>
@endsection
