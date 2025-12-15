@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('orders.show', $order->order_id) }}" class="text-decoration-none">
            <i class="fas fa-arrow-left me-2"></i> Back to Order
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-file-invoice-dollar text-warning me-2"></i> Create Invoice
                    </h2>

                    <form action="{{ route('invoices.store', $order->order_id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-600">Order ID</label>
                            <input type="text" class="form-control form-control-lg bg-light" 
                                   value="#{{ $order->order_id }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Service</label>
                            <input type="text" class="form-control form-control-lg bg-light" 
                                   value="{{ $order->service->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Client</label>
                            <input type="text" class="form-control form-control-lg bg-light" 
                                   value="{{ $order->client->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Amount</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-0">Rp</span>
                                <input type="text" class="form-control form-control-lg bg-light" 
                                       value="{{ number_format($order->price, 0, ',', '.') }}" disabled>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-600">Notes (Optional)</label>
                            <textarea class="form-control form-control-lg" name="notes" 
                                      rows="4" placeholder="Invoice notes..."></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('orders.show', $order->order_id) }}" 
                               class="btn btn-outline-secondary btn-lg rounded-2 flex-grow-1">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg rounded-2 flex-grow-1">
                                <i class="fas fa-check me-2"></i> Create Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
