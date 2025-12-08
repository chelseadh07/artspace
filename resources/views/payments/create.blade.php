@extends('layouts.app')

@section('title','Upload Payment Proof')

@section('content')
<div class="container py-4">
    <h2>Upload Payment Proof for Order #{{ $order->order_id }}</h2>

    <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
        <div class="mb-3">
            <label>Amount</label>
            <input type="number" name="amount" step="0.01" class="form-control">
        </div>
        <div class="mb-3">
            <label>Payment Proof (image)</label>
            <input type="file" name="payment_proof" class="form-control">
        </div>
        <button class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection
