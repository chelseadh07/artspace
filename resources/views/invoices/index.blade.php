@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h1 class="mb-0">
            <i class="fas fa-file-invoice-dollar text-warning me-2"></i> Invoices
        </h1>
    </div>

    @if($invoices->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Belum ada invoice</p>
            </div>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover border-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Invoice #</th>
                        <th>{{ auth()->user()->role === 'client' ? 'Artist' : 'Client' }}</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Issued Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td>
                                <span class="badge bg-secondary">{{ $invoice->invoice_number }}</span>
                            </td>
                            <td>
                                <strong>
                                    {{ auth()->user()->role === 'client' ? $invoice->artist->name : $invoice->client->name }}
                                </strong>
                            </td>
                            <td>
                                <span class="fw-bold">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @if($invoice->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($invoice->status === 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $invoice->issued_at->format('d M Y') }}</small>
                            </td>
                            <td>
                                <a href="{{ route('invoices.show', $invoice->invoice_id) }}" 
                                   class="btn btn-sm btn-outline-primary rounded-2">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $invoices->links() }}
        </div>
    @endif
</div>
@endsection
