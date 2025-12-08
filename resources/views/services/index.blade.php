@extends('layouts.app')

@section('title','Services')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Services</h2>
        <a href="{{ route('services.create') }}" class="btn btn-primary">Create Service</a>
    </div>

    <div class="row g-3">
        @foreach($services as $s)
        <div class="col-md-4">
            <div class="card p-2">
                <div class="card-body">
                    <h5>{{ $s->title }}</h5>
                    <p>{{ Str::limit($s->description, 100) }}</p>
                    <p><strong>Price:</strong> {{ $s->base_price }}</p>
                    <a href="{{ route('services.show', $s) }}" class="btn btn-sm btn-outline-secondary">View</a>
                    @if(auth()->check() && (auth()->user()->role==='admin' || auth()->id()===$s->user_id))
                        <a href="{{ route('services.edit', $s) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('services.destroy', $s) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $services->links() }}
</div>
@endsection
