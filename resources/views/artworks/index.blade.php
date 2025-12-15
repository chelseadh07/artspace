@extends('layouts.app')

@section('title','Artworks')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-1">
                <i class="fas fa-palette"></i> Artworks
            </h1>
            <p class="text-muted mb-0">Discover beautiful artwork from talented artists</p>
        </div>
        @if(auth()->check() && auth()->user()->role === 'artist')
            <a href="{{ route('artworks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Upload Artwork
            </a>
        @endif
    </div>

    <!-- Artworks Grid -->
    <div class="row g-4">
        @forelse($arts as $art)
            <div class="col-md-3 col-sm-6">
                <div class="card card-hover h-100">
                    <!-- Artwork Image -->
                    <div style="position: relative; overflow: hidden; height: 220px;">
                        @if($art->image_url)
                            <img src="{{ asset('storage/'.$art->image_url) }}"
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
                        <h5 class="card-title mb-2">{{ $art->title }}</h5>

                        <!-- Category & Artist -->
                        <div class="d-flex gap-2 mb-2 flex-wrap">
                            @if($art->category)
                                <span class="badge bg-success">{{ $art->category->name }}</span>
                            @endif
                            @if($art->user)
                                <span class="badge bg-secondary">
                                    <i class="fas fa-user"></i> {{ $art->user->name }}
                                </span>
                            @endif
                        </div>

                        <!-- Description -->
                        <p class="text-muted small flex-grow-1">
                            {{ Str::limit($art->description, 80) }}
                        </p>

                        <!-- Actions -->
                        <div class="d-flex gap-2 pt-3 border-top border-dark flex-wrap">
                            <a href="{{ route('artworks.show', $art) }}" 
                               class="btn btn-primary btn-sm flex-grow-1">
                                <i class="fas fa-eye"></i> View
                            </a>
                            @if(auth()->check() && (auth()->user()->role==='admin' || auth()->id()===$art->user_id))
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('artworks.edit', $art) }}" 
                                       class="btn btn-outline-secondary" 
                                       title="Edit artwork">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('artworks.destroy', $art) }}" 
                                          method="POST" 
                                          style="display:inline"
                                          onclick="return confirm('Delete this artwork?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger"
                                                title="Delete artwork">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No artworks found</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($arts->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $arts->links() }}
        </div>
    @endif

</div>
@endsection
