@extends('layouts.app')

@section('title', $service->title)

@section('content')
<div class="container py-4">

    <div class="row g-4">

        {{-- LEFT --}}
        <div class="col-md-6">
            <img src="{{ asset('images/service-placeholder.jpg') }}"
                 class="w-100 rounded shadow"
                 style="height:380px; object-fit:cover">
        </div>

        {{-- RIGHT --}}
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $service->title }}</h2>

            <p class="text-muted mb-1">
                Category: {{ $service->category->name ?? '—' }}
            </p>

            <p class="text-muted mb-3">
                Artist: {{ $service->artist->name ?? '—' }}
            </p>

            <h4 class="fw-bold mb-3">
                Rp {{ number_format($service->base_price) }}
            </h4>

            <p class="mb-3">
                {{ $service->description }}
            </p>

            <p class="text-muted">
                ⏱ Estimated Duration:
                {{ $service->expected_duration ?? '—' }}
            </p>

            {{-- ORDER --}}
            <a href="{{ route('orders.wa', $service->id) }}"
               class="btn btn-success mt-3">
                Order via WhatsApp
            </a>

            {{-- ADMIN / ARTIST ACTION --}}
            @if(auth()->check() && (auth()->user()->role==='admin' || auth()->id()===$service->user_id))
                <div class="mt-3 d-flex gap-2">
                    <a href="{{ route('services.edit', $service) }}"
                       class="btn btn-sm btn-outline-primary">
                        Edit
                    </a>

                    <form action="{{ route('services.destroy', $service) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Delete service?')">
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
