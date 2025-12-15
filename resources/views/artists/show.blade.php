@extends('layouts.app')

@section('title', $artist->name . ' - Artist Profile')

@section('content')
<div class="container-fluid py-4">

    <!-- Back Button -->
    <a href="javascript:history.back()" class="btn btn-outline-secondary mb-4">
        <i class="fas fa-arrow-left"></i> Back
    </a>

    <!-- Artist Header Card -->
    <div class="card card-hover mb-5">
        <div class="card-body p-5">
            <div class="row align-items-start">
                
                <!-- Artist Avatar & Info -->
                <div class="col-lg-4 text-center mb-4 mb-lg-0">
                    <div class="mb-4">
                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto"
                             style="width: 150px; height: 150px;">
                            <i class="fas fa-user text-white fa-4x"></i>
                        </div>
                    </div>

                    <h2 class="fw-bold mb-2">{{ $artist->name }}</h2>
                    
                    @if($artist->bio)
                        <p class="text-muted mb-3">{{ $artist->bio }}</p>
                    @endif

                    <!-- Contact Info -->
                    <div class="d-grid gap-2">
                        @if($artist->phone_number)
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $artist->phone_number) }}" 
                               class="btn btn-success" target="_blank">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        @endif
                        <a href="mailto:{{ $artist->email }}" class="btn btn-outline-primary">
                            <i class="fas fa-envelope"></i> Email
                        </a>
                    </div>
                </div>

                <!-- Stats -->
                <div class="col-lg-8">
                    <div class="row g-3 mb-5">
                        <!-- Services Count -->
                        <div class="col-md-4">
                            <div class="text-center p-3 rounded" style="background: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.2);">
                                <div class="mb-2">
                                    <i class="fas fa-briefcase fa-2x" style="color: #6366f1;"></i>
                                </div>
                                <p class="text-muted small mb-1">Services</p>
                                <h3 class="mb-0" style="color: #6366f1;">{{ $artist->services()->count() }}</h3>
                            </div>
                        </div>

                        <!-- Artworks Count -->
                        <div class="col-md-4">
                            <div class="text-center p-3 rounded" style="background: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2);">
                                <div class="mb-2">
                                    <i class="fas fa-palette fa-2x" style="color: #a855f7;"></i>
                                </div>
                                <p class="text-muted small mb-1">Artworks</p>
                                <h3 class="mb-0" style="color: #a855f7;">{{ $artist->artworks()->count() }}</h3>
                            </div>
                        </div>

                        <!-- Orders Completed -->
                        <div class="col-md-4">
                            <div class="text-center p-3 rounded" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2);">
                                <div class="mb-2">
                                    <i class="fas fa-check-circle fa-2x" style="color: #10b981;"></i>
                                </div>
                                <p class="text-muted small mb-1">Completed</p>
                                <h3 class="mb-0" style="color: #10b981;">{{ $artist->artistOrders()->where('status', 'finished')->count() }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- About Section -->
                    @if($artist->bio)
                        <div>
                            <h5 class="fw-bold mb-2">About</h5>
                            <p class="text-muted" style="line-height: 1.6;">{{ $artist->bio }}</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Services Section -->
    @if($services->count() > 0)
        <div class="mb-5">
            <h3 class="fw-bold mb-4">
                <i class="fas fa-briefcase"></i> Services
            </h3>

            <div class="row g-4">
                @foreach($services as $service)
                    <div class="col-md-4 col-sm-6">
                        <div class="card card-hover h-100">
                            <!-- Thumbnail -->
                            <div style="position: relative; overflow: hidden; height: 200px;">
                                @if($service->thumbnail)
                                    <img src="{{ asset('storage/'.$service->thumbnail) }}"
                                         class="w-100 h-100"
                                         style="object-fit: cover; transition: transform 0.3s ease;">
                                @else
                                    <div class="bg-dark d-flex align-items-center justify-content-center w-100 h-100">
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-2">{{ $service->title }}</h5>
                                <p class="text-muted small flex-grow-1">
                                    {{ Str::limit($service->description, 60) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top border-dark">
                                    <span style="color: #a5b4fc; font-weight: 600;">
                                        Rp {{ number_format($service->base_price) }}
                                    </span>
                                    <a href="{{ route('services.show', $service) }}"
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Artworks Section -->
    @if($artworks->count() > 0)
        <div class="mb-5">
            <h3 class="fw-bold mb-4">
                <i class="fas fa-palette"></i> Portfolio
            </h3>

            <div class="row g-4">
                @foreach($artworks as $artwork)
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
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title mb-2">{{ $artwork->title }}</h6>
                                @if($artwork->category)
                                    <span class="badge bg-success mb-2" style="width: fit-content;">
                                        {{ $artwork->category->name }}
                                    </span>
                                @endif
                                <p class="text-muted small flex-grow-1">
                                    {{ Str::limit($artwork->description, 50) }}
                                </p>
                                <a href="{{ route('artworks.show', $artwork) }}"
                                   class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if($services->count() === 0 && $artworks->count() === 0)
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                <p class="text-muted">No services or artworks yet</p>
            </div>
        </div>
    @endif

</div>
@endsection
