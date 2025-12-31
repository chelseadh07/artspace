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
            <div class="card bg-dark border-secondary rounded-3">
                <div class="card-body p-4">
                    <h2 class="card-title mb-4 text-light">
                        <i class="fas fa-file-invoice-dollar text-warning me-2"></i> Create Invoice
                    </h2>

                    <form action="{{ route('invoices.store', $order->order_id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-600 text-light">Order ID</label>
                            <input type="text" class="form-control form-control-lg bg-dark text-light border-secondary" 
                                   value="#{{ $order->order_id }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600 text-light">Service</label>
                            <input type="text" class="form-control form-control-lg bg-dark text-light border-secondary" 
                                   value="{{ $order->service->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600 text-light">Client</label>
                            <input type="text" class="form-control form-control-lg bg-dark text-light border-secondary" 
                                   value="{{ $order->client->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600 text-light">Amount</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-dark border-secondary text-light">Rp</span>
                                <input type="text" class="form-control form-control-lg bg-dark text-light border-secondary" 
                                       value="{{ number_format($order->price, 0, ',', '.') }}" disabled>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-600 text-light">Notes (Optional)</label>
                            <textarea class="form-control form-control-lg bg-dark text-light border-secondary" name="notes" 
                                      rows="4" placeholder="Invoice notes..." style="color: #e5e7eb;"></textarea>
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
