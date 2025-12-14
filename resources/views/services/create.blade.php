@extends('layouts.app')

@section('title','Create Service')

@section('content')
<div class="container py-4" style="max-width:700px">

    <h3 class="fw-bold mb-4">Create New Service</h3>

    <form action="{{ route('services.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Service Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Base Price</label>
                <input type="number" name="base_price" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Estimated Duration</label>
                <input type="text" name="expected_duration" class="form-control">
            </div>
        </div>

        <div class="mt-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
                <option value="">-- Select Category --</option>
                @foreach($categories as $c)
                    <option value="{{ $c->category_id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary mt-4 w-100">
            Create Service
        </button>
    </form>

</div>
@endsection
