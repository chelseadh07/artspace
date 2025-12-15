@extends('layouts.app')

@section('title','Order #'.$order->order_id)

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-1">
                <i class="fas fa-receipt"></i> Order #{{ $order->order_id }}
            </h1>
            <small class="text-muted">
                <i class="fas fa-calendar"></i> {{ $order->created_at->format('d M Y H:i') }}
            </small>
        </div>
        @if(auth()->id() === $order->client_id || auth()->user()->role === 'admin')
            <div class="d-flex gap-2">
                <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger" onclick="return confirm('Delete order?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        @endif
    </div>

    <div class="row g-4">

        <!-- Order Details Card -->
        <div class="col-lg-6">
            <div class="card card-hover">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-box"></i> Order Details
                    </h5>
                </div>
                <div class="card-body">

                    <!-- Service -->
                    <div class="mb-4">
                        <p class="text-muted small mb-1">Service</p>
                        <h6 class="fw-bold">{{ $order->service->title ?? '—' }}</h6>
                    </div>

                    <!-- Artist -->
                    @if($order->artist)
                        <div class="mb-4">
                            <p class="text-muted small mb-1">Artist</p>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 32px; height: 32px;">
                                    <i class="fas fa-user text-white fa-sm"></i>
                                </div>
                                <h6 class="mb-0">{{ $order->artist->name }}</h6>
                            </div>
                        </div>
                    @endif

                    <!-- Client -->
                    @if($order->client)
                        <div class="mb-4">
                            <p class="text-muted small mb-1">Client</p>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 32px; height: 32px;">
                                    <i class="fas fa-user text-white fa-sm"></i>
                                </div>
                                <h6 class="mb-0">{{ $order->client->name }}</h6>
                            </div>
                        </div>
                    @endif

                    <!-- Request Notes -->
                    @if($order->description_request)
                        <div class="mb-4">
                            <p class="text-muted small mb-1">Special Request</p>
                            <p class="text-light" style="line-height: 1.5;">{{ $order->description_request }}</p>
                        </div>
                    @endif

                    <!-- Divider -->
                    <hr class="border-dark my-4">

                    <!-- Price -->
                    <div class="mb-4">
                        <p class="text-muted small mb-1">Total Price</p>
                        <h3 style="color: #a5b4fc; font-weight: 700;">
                            Rp {{ number_format($order->price) }}
                        </h3>
                    </div>

                    <!-- Status Badge -->
                    <div>
                        <p class="text-muted small mb-1">Order Status</p>
                        @if($order->status === 'pending')
                            <span class="badge bg-warning text-dark p-2">
                                <i class="fas fa-clock"></i> Pending
                            </span>
                        @elseif($order->status === 'completed' || $order->status === 'finished')
                            <span class="badge bg-success p-2">
                                <i class="fas fa-check"></i> Completed
                            </span>
                        @elseif($order->status === 'cancelled')
                            <span class="badge bg-danger p-2">
                                <i class="fas fa-times"></i> Cancelled
                            </span>
                        @else
                            <span class="badge bg-secondary p-2">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                        @endif
                    </div>

                    <!-- Artist Status Management -->
                    @if(auth()->user()->role === 'artist' && auth()->user()->user_id === $order->artist_id)
                        <hr class="border-dark my-4">
                        <div>
                            <p class="text-muted small mb-2">Update Status</p>
                            <form action="{{ route('orders.update', $order) }}" method="POST" class="d-flex gap-2">
                                @csrf @method('PUT')
                                <select name="status" class="form-select form-select-sm">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ $order->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="in_progress" {{ $order->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="finished" {{ $order->status === 'finished' ? 'selected' : '' }}>Finished</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary rounded-2">
                                    <i class="fas fa-save"></i> Update
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment & Actions Card -->
        <div class="col-lg-6">
            <div class="card card-hover mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-wallet"></i> Payment Status
                    </h5>
                </div>
                <div class="card-body">

                    @php
                        $payment = $order->payment;
                    @endphp

                    @if(!$payment)
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle"></i> No payment submitted yet
                        </div>

                        @if(auth()->id() === $order->client_id)
                            <a href="{{ route('payments.create', $order) }}" class="btn btn-success w-100 btn-lg">
                                <i class="fas fa-credit-card"></i> Proceed to Payment
                            </a>
                        @else
                            <p class="text-muted">
                                <i class="fas fa-hourglass-end"></i> Waiting for client to submit payment proof
                            </p>
                        @endif
                    @else
                        <!-- Amount -->
                        <div class="mb-4">
                            <p class="text-muted small mb-1">Amount Paid</p>
                            <h4 style="color: #a5b4fc;">Rp {{ number_format($payment->amount) }}</h4>
                        </div>

                        <!-- Payment Status -->
                        <div class="mb-4">
                            <p class="text-muted small mb-1">Payment Status</p>
                            @if($payment->payment_status === 'paid')
                                <span class="badge bg-success p-2">
                                    <i class="fas fa-check-circle"></i> Paid
                                </span>
                            @elseif($payment->payment_status === 'waiting_confirmation')
                                <span class="badge bg-warning text-dark p-2">
                                    <i class="fas fa-hourglass-half"></i> Waiting Confirmation
                                </span>
                            @elseif($payment->payment_status === 'unpaid')
                                <span class="badge bg-danger p-2">
                                    <i class="fas fa-times-circle"></i> Unpaid
                                </span>
                            @else
                                <span class="badge bg-secondary p-2">{{ ucfirst(str_replace('_', ' ', $payment->payment_status)) }}</span>
                            @endif
                        </div>

                        <!-- Method -->
                        @if($payment->method)
                            <div class="mb-4">
                                <p class="text-muted small mb-1">Payment Method</p>
                                <p class="text-light">{{ $payment->method }}</p>
                            </div>
                        @endif

                        <!-- Payment Date -->
                        @if($payment->payment_date)
                            <div class="mb-4">
                                <p class="text-muted small mb-1">Payment Date</p>
                                <p class="text-light">{{ $payment->payment_date->format('d M Y H:i') }}</p>
                            </div>
                        @endif

                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-eye"></i> View Payment Details
                        </a>
                    @endif

                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card card-hover">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-lightning-bolt"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('order-chat.index', $order) }}" class="btn btn-outline-info">
                            <i class="fas fa-comments"></i> Chat with {{ $order->artist->name ?? 'Artist' }}
                        </a>
                        <a href="{{ route('orders.wa', $order) }}" class="btn btn-success" target="_blank">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Invoice Card -->
        @if($order->invoice)
            <div class="col-lg-6">
                <div class="card card-hover">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-file-invoice-dollar text-warning"></i> Invoice
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p class="text-muted small mb-1">Invoice Number</p>
                            <h6 class="fw-bold">{{ $order->invoice->invoice_number }}</h6>
                        </div>

                        <div class="mb-3">
                            <p class="text-muted small mb-1">Amount</p>
                            <h4 class="text-success">Rp {{ number_format($order->invoice->amount, 0, ',', '.') }}</h4>
                        </div>

                        <div class="mb-3">
                            <p class="text-muted small mb-1">Status</p>
                            @if($order->invoice->status === 'pending')
                                <span class="badge bg-warning text-dark p-2">Pending</span>
                            @elseif($order->invoice->status === 'paid')
                                <span class="badge bg-success p-2">Paid</span>
                            @else
                                <span class="badge bg-danger p-2">Cancelled</span>
                            @endif
                        </div>

                        <a href="{{ route('invoices.show', $order->invoice->invoice_id) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-eye"></i> View Invoice
                        </a>
                    </div>
                </div>
            </div>
        @elseif(auth()->user()->role === 'artist' && auth()->user()->user_id === $order->artist_id && $order->status === 'finished')
            <div class="col-lg-6">
                <div class="card card-hover bg-info bg-opacity-10">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-3">
                            <i class="fas fa-file-invoice-dollar text-warning"></i> Create Invoice
                        </h6>
                        <p class="text-muted mb-3">Order is finished. Create an invoice for the client.</p>
                        <a href="{{ route('invoices.create', $order->order_id) }}" class="btn btn-success btn-lg rounded-2 w-100">
                            <i class="fas fa-plus me-2"></i> Create Invoice
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </div>

</div>
@endsection
