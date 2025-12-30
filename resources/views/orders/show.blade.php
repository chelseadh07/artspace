@extends('layouts.app')

@section('title', 'Order #' . $order->order_id)

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

        @if (auth()->id() === $order->client_id)
            <div class="d-flex gap-2">
                <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('orders.destroy', $order) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger" onclick="return confirm('Delete order?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        @elseif(auth()->user()->role === 'artist' && auth()->id() === $order->artist_id)
            <form action="{{ route('orders.destroy', $order) }}" method="POST">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger" onclick="return confirm('Delete order?')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        @elseif(auth()->user()->role === 'admin')
            <form action="{{ route('orders.destroy', $order) }}" method="POST">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger" onclick="return confirm('Delete order?')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        @endif
    </div>

    <div class="row g-4">

        <!-- ORDER DETAILS -->
        <div class="col-lg-6">
            <div class="card card-hover">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-box"></i> Order Details</h5>
                </div>
                <div class="card-body">

                    <div class="mb-4">
                        <p class="text-muted small mb-1">Service</p>
                        <h6 class="fw-bold">{{ $order->service->title ?? '—' }}</h6>
                    </div>

                    @if ($order->artist)
                        <div class="mb-4">
                            <p class="text-muted small mb-1">Artist</p>
                            <h6>{{ $order->artist->name }}</h6>
                        </div>
                    @endif

                    @if ($order->client)
                        <div class="mb-4">
                            <p class="text-muted small mb-1">Client</p>
                            <h6>{{ $order->client->name }}</h6>
                        </div>
                    @endif

                    @if ($order->description_request)
                        <div class="mb-4">
                            <p class="text-muted small mb-1">Special Request</p>
                            <p>{{ $order->description_request }}</p>
                        </div>
                    @endif

                    <hr>

                    <div class="mb-4">
                        <p class="text-muted small mb-1">Total Price</p>
                        <h3 class="fw-bold text-primary">
                            Rp {{ number_format($order->price) }}
                        </h3>
                    </div>

                    <p class="text-muted small mb-1">Order Status</p>
                    @if ($order->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif(in_array($order->status, ['completed','finished']))
                        <span class="badge bg-success">Completed</span>
                    @elseif($order->status === 'cancelled')
                        <span class="badge bg-danger">Cancelled</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                    @endif

                    @if (auth()->user()->role === 'artist' && auth()->id() === $order->artist_id)
                        <hr>
                        <form action="{{ route('orders.updateStatus', $order) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="status" class="form-select mb-2">
                                @foreach(['pending','accepted','in_progress','finished','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_',' ',$s)) }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>

        <!-- PAYMENT -->
        <div class="col-lg-6">
            <div class="card card-hover mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-wallet"></i> Payment Status</h5>
                </div>
                <div class="card-body">

                    @php $payment = $order->payment; @endphp

                    @if(!$payment)
                        <div class="alert alert-info">No payment submitted yet</div>

                        @if(auth()->id() === $order->client_id)
                            <a href="{{ route('payments.create', $order) }}" class="btn btn-success w-100">
                                <i class="fas fa-credit-card"></i> Proceed to Payment
                            </a>
                        @else
                            <p class="text-muted">Waiting for client payment</p>
                        @endif
                    @else
                        <p class="text-muted small">Amount Paid</p>
                        <h4>Rp {{ number_format($payment->amount) }}</h4>

                        <p class="text-muted small mt-3">Status</p>
                        <span class="badge bg-info">{{ ucfirst(str_replace('_',' ',$payment->payment_status)) }}</span>

                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-outline-primary w-100 mt-3">
                            <i class="fas fa-eye"></i> View Payment
                        </a>
                    @endif

                </div>
            </div>

            <!-- ACTIONS -->
            <div class="card card-hover">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Actions</h5>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('order_chat.index', ['order' => $order->order_id]) }}" class="btn btn-outline-info">
                        <i class="fas fa-comments"></i> Chat
                    </a>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <!-- INVOICE -->
        @if($order->invoice)
        <div class="col-lg-6">
            <div class="card card-hover">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-file-invoice"></i> Invoice</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ $order->invoice->invoice_number }}</strong></p>
                    <p>Rp {{ number_format($order->invoice->amount) }}</p>
                    <a href="{{ route('invoices.show', $order->invoice->invoice_id) }}"
                       class="btn btn-outline-primary w-100">
                        View Invoice
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
