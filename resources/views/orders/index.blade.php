@extends('layouts.app')

@section('title','Orders')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Orders</h2>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Create Order</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Service</th>
                <th>Client</th>
                <th>Artist</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $o)
            <tr>
                <td>{{ $o->order_id }}</td>
                <td>{{ $o->service->title ?? '—' }}</td>
                <td>{{ $o->client->name ?? '—' }}</td>
                <td>{{ $o->artist->name ?? '—' }}</td>
                <td>{{ $o->price }}</td>
                <td>{{ $o->status }}</td>
                <td>
                    <a href="{{ route('orders.show', $o) }}" class="btn btn-sm btn-outline-secondary">View</a>
                    <a href="{{ route('orders.edit', $o) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="{{ route('orders.destroy', $o) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection
