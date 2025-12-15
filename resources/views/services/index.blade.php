@extends('layouts.app')

@section('title', 'Services')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-1">
                <i class="fas fa-briefcase"></i> Art Services
            </h1>
            <p class="text-muted mb-0">Discover and commission artists for your artwork</p>
        </div>
        @if(auth()->check() && auth()->user()->role === 'artist')
            <a href="{{ route('services.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create Service
            </a>
        @endif
    </div>

    <!-- Search & Filter -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="q" class="form-control" placeholder="Search services..." value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="row g-4">
        @forelse($services as $service)
            <div class="col-md-4 col-sm-6">
                <div class="card card-hover h-100">
                    <!-- Thumbnail -->
                    <div style="position: relative; overflow: hidden; height: 220px;">
                        @if($service->thumbnail)
                            <img src="{{ asset('storage/'.$service->thumbnail) }}"
                                 class="w-100 h-100"
                                 style="object-fit: cover; transition: transform 0.3s ease;">
                        @else
                            <div class="bg-dark d-flex align-items-center justify-content-center w-100 h-100">
                                <div class="text-center">
                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                    <p class="text-muted">No Image</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column">
                        <!-- Title -->
                        <h5 class="card-title mb-2">{{ $service->title }}</h5>

                        <!-- Category & Artist -->
                        <div class="d-flex gap-2 mb-2">
                            @if($service->category)
                                <span class="badge bg-info">{{ $service->category->name }}</span>
                            @endif
                            @if($service->artist)
                                <span class="badge bg-secondary">
                                    <i class="fas fa-user"></i> {{ $service->artist->name }}
                                </span>
                            @endif
                        </div>

                        <!-- Description -->
                        <p class="text-muted small flex-grow-1">
                            {{ Str::limit($service->description, 80) }}
                        </p>

                        <!-- Price & Action -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top border-dark">
                            <span class="h5 mb-0" style="color: #a5b4fc;">
                                Rp {{ number_format($service->base_price) }}
                            </span>
                            <a href="{{ route('services.show', $service) }}"
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No services found</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($services->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $services->links() }}
        </div>
    @endif

</div>
@endsection
