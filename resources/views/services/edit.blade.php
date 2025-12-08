@extends('layouts.app')

@section('title','Edit Service')

@section('content')
<div class="container py-4">
    <h2>Edit Service</h2>
    <form action="{{ route('services.update', $service) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $service->title) }}">
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $service->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Base Price</label>
            <input type="number" name="base_price" step="0.01" class="form-control" value="{{ old('base_price', $service->base_price) }}">
        </div>
        <div class="mb-3">
            <label>Expected Duration</label>
            <input type="text" name="expected_duration" class="form-control" value="{{ old('expected_duration', $service->expected_duration) }}">
        </div>
        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control">
                <option value="">-- none --</option>
                @foreach($categories as $c)
                    <option value="{{ $c->category_id }}" {{ $service->category_id===$c->category_id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active" {{ $service->status==='active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $service->status==='inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
