@extends('layouts.app')

@section('title','Review #'.$review->id)

@section('content')
<div class="container py-4">
    <h2>Review for Order #{{ $review->order->order_id ?? '—' }}</h2>
    <p><strong>Rating:</strong> {{ $review->rating }}</p>
    <p><strong>Comment:</strong><br>{{ $review->comment }}</p>
    <p><strong>Client:</strong> {{ $review->client->name ?? '—' }}</p>
</div>
@endsection
