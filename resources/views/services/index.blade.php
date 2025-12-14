@extends('layouts.app')

@section('title','Services')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Explore Services</h3>

        @if(auth()->check() && auth()->user()->role !== 'buyer')
            <a href="{{ route('services.create') }}" class="btn btn-primary">
                + Create Service
            </a>
        @endif
    </div>

    <div class="row g-4">
        @foreach($services as $s)
        <div class="col-xl-3 col-md-4 col-sm-6">
            <div class="card h-100 shadow-sm">

                {{-- Thumbnail (dummy kalau belum ada) --}}
                <img src="{{ asset('images/service-placeholder.jpg') }}"
                     class="card-img-top"
                     style="height:180px; object-fit:cover">

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold mb-1">{{ $s->title }}</h6>

                    <p class="text-muted small mb-2">
                        {{ Str::limit($s->description, 70) }}
                    </p>

                    <div class="mt-auto">
                        <div class="fw-bold mb-2">
                            Rp {{ number_format($s->base_price) }}
                        </div>

                        <a href="{{ route('services.show', $s) }}"
                           class="btn btn-sm btn-outline-dark w-100 mb-2">
                            View Details
                        </a>

                        @if(auth()->check() && (auth()->user()->role==='admin' || auth()->id()===$s->user_id))
                            <div class="d-flex gap-1">
                                <a href="{{ route('services.edit', $s) }}"
                                   class="btn btn-sm btn-outline-primary w-100">
                                    Edit
                                </a>
                                <form action="{{ route('services.destroy', $s) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger w-100"
                                            onclick="return confirm('Delete service?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $services->links() }}
    </div>

</div>
@endsection
