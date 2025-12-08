@extends('layouts.app')

@section('title','Upload Artwork')

@section('content')
<div class="container py-4">
    <h2>Upload Artwork</h2>
    <form action="{{ route('artworks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control">
                <option value="">-- none --</option>
                @foreach($categories as $c)
                    <option value="{{ $c->category_id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection
