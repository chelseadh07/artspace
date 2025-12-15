@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('invoices.index') }}" class="text-decoration-none">
            <i class="fas fa-arrow-left me-2"></i> Back to Invoices
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Invoice Card -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h2 class="card-title mb-1">
                                <i class="fas fa-file-invoice-dollar text-warning me-2"></i> 
                                {{ $invoice->invoice_number }}
                            </h2>
                            <small class="text-muted">Issued: {{ $invoice->issued_at->format('d M Y') }}</small>
                        </div>
                        <div class="text-end">
                            @if($invoice->status === 'pending')
                                <span class="badge bg-warning text-dark fs-6">Pending</span>
                            @elseif($invoice->status === 'paid')
                                <span class="badge bg-success fs-6">Paid</span>
                            @else
                                <span class="badge bg-danger fs-6">Cancelled</span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <!-- Invoice Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-600 mb-2">From:</h6>
                            <p class="mb-1">
                                <strong>{{ $invoice->artist->name }}</strong>
                            </p>
                            <small class="text-muted d-block">{{ $invoice->artist->email }}</small>
                            @if($invoice->artist->whatsapp_link)
                                <small class="text-muted d-block">
                                    <i class="fab fa-whatsapp"></i> 
                                    <a href="{{ $invoice->artist->whatsapp_link }}" target="_blank" class="text-reset">
                                        WhatsApp
                                    </a>
                                </small>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-600 mb-2">Bill To:</h6>
                            <p class="mb-1">
                                <strong>{{ $invoice->client->name }}</strong>
                            </p>
                            <small class="text-muted d-block">{{ $invoice->client->email }}</small>
                        </div>
                    </div>

                    <hr>

                    <!-- Order & Amount -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-600 mb-2">Order Details:</h6>
                            <p class="mb-1">
                                <small class="text-muted">Service:</small><br>
                                <strong>{{ $invoice->order->service->name }}</strong>
                            </p>
                            <p class="mb-0">
                                <small class="text-muted">Order ID:</small><br>
                                <strong>#{{ $invoice->order->order_id }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h6 class="fw-600 mb-2">Amount:</h6>
                            <h3 class="text-success mb-2">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</h3>
                            @if($invoice->paid_at)
                                <small class="text-muted">Paid on {{ $invoice->paid_at->format('d M Y') }}</small>
                            @endif
                        </div>
                    </div>

                    @if($invoice->notes)
                        <hr>
                        <h6 class="fw-600 mb-2">Notes:</h6>
                        <p class="text-muted">{{ $invoice->notes }}</p>
                    @endif
                </div>
            </div>

            <!-- Artist Actions (if artist viewing and invoice still pending) -->
            @if(auth()->user()->role === 'artist' && auth()->user()->user_id === $invoice->artist_id && $invoice->status !== 'paid')
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body p-4">
                        <h6 class="card-title fw-600 mb-3">
                            <i class="fas fa-cogs me-2"></i> Invoice Actions
                        </h6>

                        <form action="{{ route('invoices.updateStatus', $invoice->invoice_id) }}" method="POST" class="d-flex gap-2">
                            @csrf
                            <input type="hidden" name="status" value="paid">
                            <button type="submit" class="btn btn-success btn-sm rounded-2 flex-grow-1">
                                <i class="fas fa-check me-2"></i> Mark as Paid
                            </button>
                        </form>

                        <form action="{{ route('invoices.updateStatus', $invoice->invoice_id) }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="btn btn-danger btn-sm rounded-2 w-100">
                                <i class="fas fa-times me-2"></i> Cancel Invoice
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Client Payment Action (if client viewing and invoice pending) -->
            @if(auth()->user()->role === 'client' && auth()->user()->user_id === $invoice->client_id && $invoice->status === 'pending')
                <div class="card border-0 shadow-sm rounded-3 bg-info bg-opacity-10">
                    <div class="card-body p-4 text-center">
                        <h6 class="fw-600 mb-3">Ready to pay?</h6>
                        @if($invoice->artist->whatsapp_link)
                            <a href="{{ $invoice->artist->whatsapp_link }}" 
                               target="_blank"
                               class="btn btn-success rounded-2 btn-lg">
                                <i class="fab fa-whatsapp me-2"></i> Contact via WhatsApp
                            </a>
                        @else
                            <p class="text-muted mb-0">Seller belum menambahkan WhatsApp link</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
