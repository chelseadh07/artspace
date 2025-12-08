@extends('layouts.app')

@section('title', $service->title)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $service->title }}</h2>
        <div>
            @if(auth()->check() && (auth()->user()->role==='admin' || auth()->id()===$service->user_id))
                <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                <form action="{{ route('services.destroy', $service) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete service?')">Delete</button>
                </form>
            @endif
        </div>
    </div>

    <div class="card p-3">
        <div class="card-body">
            <p>{{ $service->description }}</p>
            <p><strong>Price:</strong> {{ $service->base_price }}</p>
            <p><strong>Duration:</strong> {{ $service->expected_duration ?? '—' }}</p>
            <p><strong>Category:</strong> {{ $service->category->name ?? '—' }}</p>
            <p><strong>Artist:</strong> {{ $service->artist->name ?? '—' }}</p>
            <p><strong>Status:</strong> {{ $service->status }}</p>
        </div>
    </div>
</div>
@endsection
