@extends('layouts.app')

@section('title','Edit Artwork')

@section('content')
<div class="container py-4">
    <h2>Edit Artwork</h2>
    <form action="{{ route('artworks.update', $artwork) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $artwork->title) }}">
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $artwork->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control">
                <option value="">-- none --</option>
                @foreach($categories as $c)
                    <option value="{{ $c->category_id }}" {{ $artwork->category_id===$c->category_id? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Replace Image (optional)</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
