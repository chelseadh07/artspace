@extends('layouts.app')

@section('title','Reviews')

@section('content')
<div class="container py-4">
    <h2>Reviews</h2>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Order</th>
                <th>Client</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($reviews as $rv)
            <tr>
                <td>{{ $rv->id }}</td>
                <td>{{ $rv->order->order_id ?? '—' }}</td>
                <td>{{ $rv->client->name ?? '—' }}</td>
                <td>{{ $rv->rating }}</td>
                <td>{{ Str::limit($rv->comment, 80) }}</td>
                <td>
                    <a href="{{ route('reviews.show', $rv) }}" class="btn btn-sm btn-outline-secondary">View</a>
                    @if(auth()->check() && auth()->id()===$rv->client_id)
                        <a href="{{ route('reviews.edit', $rv) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('reviews.destroy', $rv) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $reviews->links() }}
</div>
@endsection
