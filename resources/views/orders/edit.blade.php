@extends('layouts.app')

@section('title','Edit Order')

@section('content')
<div class="container py-4">
    <h2>Edit Order #{{ $order->order_id }}</h2>
    <form action="{{ route('orders.update', $order) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Service</label>
            <select name="service_id" class="form-control">
                @foreach($services as $s)
                    <option value="{{ $s->service_id }}" {{ $order->service_id===$s->service_id ? 'selected' : '' }}>{{ $s->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Artist</label>
            <select name="artist_id" class="form-control">
                @foreach($artists as $a)
                    <option value="{{ $a->user_id }}" {{ $order->artist_id===$a->user_id ? 'selected' : '' }}>{{ $a->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" step="0.01" class="form-control" value="{{ old('price', $order->price) }}">
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                @foreach(['pending','accepted','in_progress','finished','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status===$s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Request</label>
            <textarea name="description_request" class="form-control">{{ old('description_request', $order->description_request) }}</textarea>
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
