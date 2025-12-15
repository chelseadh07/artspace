@extends('layouts.app')

@section('title','Payment - Order #' . $order->order_id)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-4">Payment Details</h2>

            <!-- Order Summary Card -->
            <div class="card mb-4">
                <div class="card-header bg-dark">
                    <h5 class="mb-0">Order #{{ $order->order_id }}</h5>
                </div>
                <div class="card-body">
                    <!-- Service Info -->
                    <div class="mb-3">
                        <small class="text-muted">Service</small>
                        <h5>{{ $order->service->title ?? '—' }}</h5>
                    </div>

                    <!-- Artist Info -->
                    <div class="mb-3">
                        <small class="text-muted">Artist</small>
                        <p class="mb-0">{{ $order->artist->name ?? '—' }}</p>
                    </div>

                    <!-- Request Notes -->
                    @if($order->description_request)
                        <div class="mb-3">
                            <small class="text-muted">Your Request</small>
                            <p class="mb-0">{{ $order->description_request }}</p>
                        </div>
                    @endif

                    <hr>

                    <!-- Price Breakdown -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Service Price:</span>
                            <span>Rp {{ number_format($order->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Platform Fee:</span>
                            <span>Rp 0</span>
                        </div>
                    </div>

                    <hr>

                    <!-- Total Amount -->
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="h5 mb-0">Total Amount:</strong>
                        <span class="h4 mb-0 text-success">Rp {{ number_format($order->price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Status -->
            <div class="alert alert-info">
                <strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $order->status)) }}
            </div>
        </div>

        <!-- Right: Payment Method -->
        <div class="col-md-6">
            <h2 class="mb-4">Payment Method</h2>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="fab fa-whatsapp" style="font-size: 4rem; color: #25d366;"></i>
                    </div>

                    <h5 class="card-title text-center mb-3">Pay via WhatsApp</h5>

                    <div class="alert alert-info mb-4">
                        <p class="mb-2">
                            <strong>Artist:</strong> {{ $order->artist->name ?? 'Artist' }}
                        </p>
                        <p class="mb-0">
                            <strong>Amount:</strong> <span class="h5 text-success">Rp {{ number_format($order->price, 0, ',', '.') }}</span>
                        </p>
                    </div>

                    @if($order->artist->whatsapp_link)
                        <p class="text-muted text-center mb-3">Click below to open WhatsApp and confirm payment with the artist</p>

                        <a href="{{ $order->artist->whatsapp_link }}" 
                           target="_blank"
                           class="btn btn-success btn-lg w-100 rounded-2 mb-3">
                            <i class="fab fa-whatsapp me-2"></i> Open WhatsApp
                        </a>

                        <div class="card bg-light p-3 rounded-2">
                            <h6 class="mb-2">Next Steps:</h6>
                            <ol class="small mb-0 ps-3">
                                <li>Click "Open WhatsApp" above</li>
                                <li>Confirm payment amount with artist</li>
                                <li>Complete the transfer</li>
                                <li>Send proof screenshot to artist</li>
                            </ol>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> The artist hasn't set up their WhatsApp link yet.
                            <br><small>Please contact them through the order chat.</small>
                        </div>

                        <a href="{{ route('order-chat.index', $order) }}" class="btn btn-outline-primary btn-lg w-100 rounded-2">
                            <i class="fas fa-comments me-2"></i> Contact via Chat
                        </a>
                    @endif

                    <hr class="my-4">

                    <a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-outline-secondary w-100 rounded-2">
                        <i class="fas fa-arrow-left me-2"></i> Back to Order
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
