@extends('layouts.app')

@section('title','Review #'.$review->id)

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="mb-4">
        <a href="{{ route('reviews.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Reviews
        </a>
        <h1 class="fw-bold">
            <i class="fas fa-star"></i> Review for Order #{{ $review->order->order_id ?? '—' }}
        </h1>
    </div>

    <div class="row g-4">

        <!-- Review Details -->
        <div class="col-lg-8">
            <div class="card card-hover">
                <div class="card-body">

                    <!-- Rating Stars -->
                    <div class="mb-4">
                        <p class="text-muted small mb-2">Rating</p>
                        <div class="d-flex align-items-center gap-2">
                            <div>
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < $review->rating)
                                        <i class="fas fa-star fa-lg" style="color: #fbbf24;"></i>
                                    @else
                                        <i class="fas fa-star fa-lg" style="color: #6b7280;"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="h5 mb-0">{{ $review->rating }} out of 5</span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <hr class="border-dark my-4">

                    <!-- Comment -->
                    <div>
                        <p class="text-muted small mb-2">Comment</p>
                        <p class="text-light" style="line-height: 1.8;">{{ $review->comment }}</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">

            <!-- Client Info Card -->
            <div class="card card-hover mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Client</h5>
                </div>
                <div class="card-body">
                    @if($review->client)
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $review->client->name }}</h6>
                                <small class="text-muted">{{ $review->client->email }}</small>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">No client info available</p>
                    @endif
                </div>
            </div>

            <!-- Order Info Card -->
            <div class="card card-hover mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Order</h5>
                </div>
                <div class="card-body">
                    @if($review->order)
                        <div class="mb-3">
                            <p class="text-muted small mb-1">Order ID</p>
                            <a href="{{ route('orders.show', $review->order) }}" class="text-primary text-decoration-none">
                                <h6>#{{ $review->order->order_id }}</h6>
                            </a>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted small mb-1">Service</p>
                            <p class="text-light">{{ $review->order->service->title ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Date</p>
                            <p class="text-light">{{ $review->order->created_at->format('d M Y') }}</p>
                        </div>
                    @else
                        <p class="text-muted">No order info available</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            @if(auth()->check() && auth()->id() === $review->client_id)
                <div class="card card-hover">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-edit"></i> Actions</h5>
                    </div>
                    <div class="card-body d-grid gap-2">
                        <a href="{{ route('reviews.edit', $review) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-pencil"></i> Edit Review
                        </a>
                        <form action="{{ route('reviews.destroy', $review) }}" 
                              method="POST"
                              onsubmit="return confirm('Delete this review?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash"></i> Delete Review
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </div>

    </div>

</div>
@endsection
