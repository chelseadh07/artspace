@extends('layouts.app')

@section('title','Payments')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Payments</h2>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Order</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($payments as $p)
            <tr>
                <td>{{ $p->payment_id ?? $loop->iteration }}</td>
                <td>{{ $p->order->order_id ?? '—' }}</td>
                <td>{{ $p->amount }}</td>
                <td>{{ $p->payment_status }}</td>
                <td>
                    <a href="{{ route('payments.show', $p) }}" class="btn btn-sm btn-outline-secondary">View</a>
                    @if(auth()->check() && (auth()->user()->role==='admin' || auth()->id() === $p->order->client_id))
                        <form action="{{ route('payments.destroy', $p) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $payments->links() }}
</div>
@endsection
