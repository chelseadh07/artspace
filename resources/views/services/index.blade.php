@extends('layouts.app')

@section('title', 'Services')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-light mb-1">Art Services</h2>
            <p class="text-muted mb-0">
                Commission artists for your next artwork
            </p>
        </div>
    </div>

    <div class="row g-4">

        @foreach($services as $service)
        <div class="col-md-4">
            <div class="card card-hover h-100">

                {{-- thumbnail --}}
                @if($service->thumbnail)
                    <img src="{{ asset('storage/'.$service->thumbnail) }}"
                         class="card-img-top"
                         style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-dark d-flex align-items-center justify-content-center"
                         style="height:200px;">
                        <span class="text-muted">No Image</span>
                    </div>
                @endif

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-light">
                        {{ $service->title }}
                    </h5>

                    <p class="text-muted small flex-grow-1">
                        {{ Str::limit($service->description, 80) }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fw-semibold text-light">
                            Rp {{ number_format($service->price) }}
                        </span>

                        <a href="{{ route('services.show', $service) }}"
                           class="btn btn-sm btn-primary">
                            View Details
                        </a>
                    </div>
                </div>

            </div>
        </div>
        @endforeach

    </div>

</div>
@endsection
