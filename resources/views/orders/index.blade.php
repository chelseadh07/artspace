@extends('layouts.app')

@section('title','Orders')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-1">
                <i class="fas fa-shopping-cart"></i> My Orders
            </h1>
            <p class="text-muted mb-0">Track and manage your orders</p>
        </div>
        @if(auth()->user()->role === 'client')
            <a href="{{ route('orders.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Order
            </a>
        @endif
    </div>

    <!-- Orders Table -->
    <div class="table-responsive">
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
            @forelse($orders as $o)
                <tr>
                    <td>
                        <span class="badge bg-info">{{ $o->order_id }}</span>
                    </td>
                    <td>
                        <strong>{{ $o->service->title ?? '—' }}</strong>
                    </td>
                    <td>
                        <small>{{ $o->client->name ?? '—' }}</small>
                    </td>
                    <td>
                        <small>{{ $o->artist->name ?? '—' }}</small>
                    </td>
                    <td>
                        <span style="color: #a5b4fc; font-weight: 600;">Rp {{ number_format($o->price) }}</span>
                    </td>
                    <td>
                        @if($o->status === 'pending')
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-clock"></i> Pending
                            </span>
                        @elseif($o->status === 'accepted')
                            <span class="badge bg-info">
                                <i class="fas fa-check"></i> Accepted
                            </span>
                        @elseif($o->status === 'in_progress')
                            <span class="badge bg-primary">
                                <i class="fas fa-spinner"></i> In Progress
                            </span>
                        @elseif($o->status === 'finished')
                            <span class="badge bg-success">
                                <i class="fas fa-check"></i> Finished
                            </span>
                        @elseif($o->status === 'cancelled')
                            <span class="badge bg-danger">
                                <i class="fas fa-times"></i> Cancelled
                            </span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $o->status)) }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('orders.show', $o) }}" 
                               class="btn btn-outline-primary" 
                               title="View order">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(auth()->user()->role === 'client' && auth()->id() === $o->client_id)
                                <a href="{{ route('orders.edit', $o) }}" 
                                   class="btn btn-outline-secondary" 
                                   title="Edit order">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endif
                            @if((auth()->user()->role === 'client' && auth()->id() === $o->client_id) || (auth()->user()->role === 'artist' && auth()->id() === $o->artist_id) || auth()->user()->role === 'admin')
                                <form action="{{ route('orders.destroy', $o) }}" 
                                      method="POST" 
                                      style="display:inline"
                                      onclick="return confirm('Delete this order?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger"
                                            title="Delete order">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                        <p class="text-muted">No orders found</p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif

</div>
@endsection
