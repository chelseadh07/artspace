@extends('layouts.app')

@section('title', $service->title)

@section('content')
<div class="container">

    <div class="row g-5">

        <!-- Image -->
        <div class="col-md-6">
            @if($service->thumbnail)
                <img src="{{ asset('storage/'.$service->thumbnail) }}"
                     class="img-fluid rounded"
                     style="border:1px solid #27272a;">
            @else
                <div class="bg-dark d-flex align-items-center justify-content-center rounded"
                     style="height:300px;">
                    <span class="text-muted">No Image</span>
                </div>
            @endif
        </div>

        <!-- Info -->
        <div class="col-md-6">
            <h2 class="text-light mb-2">{{ $service->title }}</h2>

            <p class="text-muted">
                by {{ $service->artist->name ?? 'Artist' }}
            </p>

            <h4 class="text-light mb-3">
                Rp {{ number_format($service->price) }}
            </h4>

            <p class="text-muted">
                {{ $service->description }}
            </p>

            <div class="mt-4">
                <a href="{{ route('orders.create', $service) }}"
                   class="btn btn-primary btn-lg">
                    Order This Service
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
