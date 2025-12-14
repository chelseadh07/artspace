@extends('layouts.app')

@section('title','Edit Service')

@section('content')
<div class="container py-4" style="max-width:700px">

    <h3 class="fw-bold mb-4">Edit Service</h3>

    <form action="{{ route('services.update', $service) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Service Title</label>
            <input type="text" name="title" class="form-control"
                   value="{{ $service->title }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ $service->description }}</textarea>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Base Price</label>
                <input type="number" name="base_price" class="form-control"
                       value="{{ $service->base_price }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Estimated Duration</label>
                <input type="text" name="expected_duration" class="form-control"
                       value="{{ $service->expected_duration }}">
            </div>
        </div>

        <div class="mt-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
                @foreach($categories as $c)
                    <option value="{{ $c->category_id }}"
                        {{ $service->category_id===$c->category_id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mt-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="active" {{ $service->status==='active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $service->status==='inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button class="btn btn-primary mt-4 w-100">
            Save Changes
        </button>
    </form>

</div>
@endsection
