@extends('layouts.app')

@section('title', $artwork->title)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            @if($artwork->image_url)
                <img src="{{ asset('storage/'.$artwork->image_url) }}" class="img-fluid">
            @endif
        </div>
        <div class="col-md-6">
            <h2>{{ $artwork->title }}</h2>
            <p>{{ $artwork->description }}</p>
            <p>By: {{ $artwork->artist->name ?? '—' }}</p>
            <p>Category: {{ $artwork->category->name ?? '—' }}</p>
        </div>
    </div>
</div>
@endsection
