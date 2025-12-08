@extends('layouts.app')

@section('title','Payment #'.$payment->payment_id)

@section('content')
<div class="container py-4">
    <h2>Payment #{{ $payment->payment_id }}</h2>
    <p><strong>Order:</strong> {{ $payment->order->order_id ?? '—' }}</p>
    <p><strong>Amount:</strong> {{ $payment->amount }}</p>
    <p><strong>Status:</strong> {{ $payment->payment_status }}</p>
    @if($payment->payment_proof)
        <div class="mb-3">
            <label>Proof</label>
            <img src="{{ asset('storage/'.$payment->payment_proof) }}" class="img-fluid">
        </div>
    @endif
    @if(auth()->check() && (auth()->user()->role==='admin' || auth()->id() === $payment->order->artist_id))
        <form action="{{ route('payments.confirm', $payment) }}" method="POST">@csrf
            <button class="btn btn-success">Confirm Payment</button>
        </form>
    @endif
</div>
@endsection
