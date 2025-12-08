@extends('layouts.app')

@section('title','Create Order')

@section('content')
<div class="container py-4">
    <h2>Create Order</h2>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Service</label>
            <select name="service_id" class="form-control">
                @foreach($services as $s)
                    <option value="{{ $s->service_id }}">{{ $s->title }} — {{ $s->base_price }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Artist</label>
            <select name="artist_id" class="form-control">
                @foreach($artists as $a)
                    <option value="{{ $a->user_id }}">{{ $a->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Message / Request</label>
            <textarea name="description_request" class="form-control">{{ old('description_request') }}</textarea>
        </div>
        <div class="mb-3">
            <label>Price (optional)</label>
            <input type="number" name="price" class="form-control" step="0.01">
        </div>
        <button class="btn btn-primary">Create Order</button>
    </form>
</div>
@endsection
