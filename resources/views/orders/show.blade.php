@extends('layouts.app')

@section('title','Order #'.$order->order_id)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Order #{{ $order->order_id }}</h2>
        <div>
            <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete order?')">Delete</button>
            </form>
        </div>
    </div>

    <div class="card p-3">
        <div class="card-body">
            <p><strong>Service:</strong> {{ $order->service->title ?? '—' }}</p>
            <p><strong>Client:</strong> {{ $order->client->name ?? '—' }}</p>
            <p><strong>Artist:</strong> {{ $order->artist->name ?? '—' }}</p>
            <p><strong>Price:</strong> {{ $order->price ?? '—' }}</p>
            <p><strong>Status:</strong> {{ $order->status }}</p>
            <p><strong>Request:</strong><br>{{ $order->description_request ?? '—' }}</p>
        </div>
    </div>
</div>
@endsection
