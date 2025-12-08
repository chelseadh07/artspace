@extends('layouts.app')

@section('title','Create Review')

@section('content')
<div class="container py-4">
    <h2>Review Order #{{ $order->order_id }}</h2>
    <form action="{{ route('reviews.store') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
        <div class="mb-3">
            <label>Rating</label>
            <select name="rating" class="form-control">
                @for($i=1;$i<=5;$i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="mb-3">
            <label>Comment</label>
            <textarea name="comment" class="form-control">{{ old('comment') }}</textarea>
        </div>
        <button class="btn btn-primary">Submit Review</button>
    </form>
</div>
@endsection
