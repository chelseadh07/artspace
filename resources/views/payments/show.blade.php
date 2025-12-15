@extends('layouts.app')

@section('title','Payment #'.$payment->payment_id)

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="mb-4">
        <a href="{{ route('orders.show', $payment->order) }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Order
        </a>
        <h1 class="fw-bold">
            <i class="fas fa-receipt"></i> Payment #{{ $payment->payment_id }}
        </h1>
    </div>

    <div class="row g-4">

        <!-- Payment Details Card -->
        <div class="col-lg-6">
            <div class="card card-hover">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Payment Details</h5>
                </div>
                <div class="card-body">

                    <!-- Order Info -->
                    <div class="mb-4">
                        <p class="text-muted small mb-1">Order ID</p>
                        <h6 class="fw-bold">
                            <a href="{{ route('orders.show', $payment->order) }}" class="text-primary text-decoration-none">
                                #{{ $payment->order->order_id ?? '—' }}
                            </a>
                        </h6>
                    </div>

                    <!-- Amount -->
                    <div class="mb-4">
                        <p class="text-muted small mb-1">Amount</p>
                        <h3 style="color: #a5b4fc; font-weight: 700;">
                            Rp {{ number_format($payment->amount) }}
                        </h3>
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

                    <!-- Payment Method -->
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

                    <!-- Created Date -->
                    @if($payment->created_at)
                        <div>
                            <p class="text-muted small mb-1">Created</p>
                            <p class="text-light">{{ $payment->created_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- Payment Proof Card -->
        <div class="col-lg-6">
            @if($payment->payment_proof)
                <div class="card card-hover mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-image"></i> Payment Proof</h5>
                    </div>
                    <div class="card-body">
                        <img src="{{ asset('storage/'.$payment->payment_proof) }}" 
                             class="img-fluid rounded"
                             style="max-height: 400px; width: 100%; object-fit: contain;">
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-image fa-3x text-muted mb-3 d-block"></i>
                        <p class="text-muted">No payment proof submitted</p>
                    </div>
                </div>
            @endif

            <!-- Admin Actions -->
            @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->id() === $payment->order->artist_id))
                <div class="card card-hover mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-lock"></i> Admin Actions</h5>
                    </div>
                    <div class="card-body">
                        @if($payment->payment_status !== 'paid')
                            <form action="{{ route('payments.confirm', $payment) }}" method="POST">
                                @csrf
                                <button class="btn btn-success w-100 btn-lg">
                                    <i class="fas fa-check"></i> Confirm Payment
                                </button>
                            </form>
                        @else
                            <div class="alert alert-success mb-0">
                                <i class="fas fa-check-circle"></i> Payment has been confirmed
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>

    </div>

</div>
@endsection
