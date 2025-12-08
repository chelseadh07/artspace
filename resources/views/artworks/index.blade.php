@extends('layouts.app')

@section('title','Artworks')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Artworks</h2>
        <a href="{{ route('artworks.create') }}" class="btn btn-primary">Upload Artwork</a>
    </div>

    <div class="row g-3">
        @foreach($arts as $art)
        <div class="col-md-3">
            <div class="card">
                @if($art->image_url)
                <img src="{{ asset('storage/'.$art->image_url) }}" class="card-img-top" style="height:180px;object-fit:cover">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $art->title }}</h5>
                    <p class="card-text">{{ Str::limit($art->description, 80) }}</p>
                    <a href="{{ route('artworks.show', $art) }}" class="btn btn-sm btn-outline-secondary">View</a>
                    @if(auth()->check() && (auth()->user()->role==='admin' || auth()->id()===$art->user_id))
                        <a href="{{ route('artworks.edit', $art) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('artworks.destroy', $art) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete artwork?')">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $arts->links() }}
</div>
@endsection
