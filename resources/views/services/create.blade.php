@extends('layouts.app')

@section('title','Create Service')

@section('content')
<div class="container py-4">
    <h2>Create Service</h2>
    <form action="{{ route('services.store') }}" method="POST">
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
            <label>Base Price</label>
            <input type="number" name="base_price" class="form-control" value="{{ old('base_price') }}" step="0.01">
        </div>
        <div class="mb-3">
            <label>Expected Duration</label>
            <input type="text" name="expected_duration" class="form-control" value="{{ old('expected_duration') }}">
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
        <button class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
