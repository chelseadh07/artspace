@extends('layouts.app')

@section('title','Reviews')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="mb-4">
        <h1 class="fw-bold mb-1">
            <i class="fas fa-star"></i> Reviews
        </h1>
        <p class="text-muted mb-0">Browse and manage artwork reviews</p>
    </div>

    <!-- Reviews Table -->
    <div class="table-responsive">
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
            @forelse($reviews as $rv)
                <tr>
                    <td>
                        <span class="badge bg-info">{{ $rv->id }}</span>
                    </td>
                    <td>
                        <a href="{{ route('orders.show', $rv->order) }}" class="text-primary text-decoration-none">
                            #{{ $rv->order->order_id ?? '—' }}
                        </a>
                    </td>
                    <td>
                        <small>{{ $rv->client->name ?? '—' }}</small>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            @for($i = 0; $i < 5; $i++)
                                @if($i < $rv->rating)
                                    <i class="fas fa-star" style="color: #fbbf24;"></i>
                                @else
                                    <i class="fas fa-star" style="color: #6b7280;"></i>
                                @endif
                            @endfor
                            <span class="small">({{ $rv->rating }}/5)</span>
                        </div>
                    </td>
                    <td>
                        <small class="text-muted">{{ Str::limit($rv->comment, 60) }}</small>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('reviews.show', $rv) }}" 
                               class="btn btn-outline-primary" 
                               title="View review">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(auth()->check() && auth()->id() === $rv->client_id)
                                <a href="{{ route('reviews.edit', $rv) }}" 
                                   class="btn btn-outline-secondary" 
                                   title="Edit review">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('reviews.destroy', $rv) }}" 
                                      method="POST" 
                                      style="display:inline"
                                      onclick="return confirm('Delete this review?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger"
                                            title="Delete review">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                        <p class="text-muted">No reviews found</p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($reviews->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $reviews->links() }}
        </div>
    @endif

</div>
@endsection
