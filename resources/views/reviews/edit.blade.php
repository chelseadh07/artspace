@extends('layouts.app')

@section('title','Edit Review')

@section('content')
<div class="container py-4">
    <h2>Edit Review #{{ $review->id }}</h2>
    <form action="{{ route('reviews.update', $review) }}" method="POST">@csrf @method('PUT')
        <div class="mb-3">
            <label>Rating</label>
            <select name="rating" class="form-control">
                @for($i=1;$i<=5;$i++)
                    <option value="{{ $i }}" {{ $review->rating===$i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="mb-3">
            <label>Comment</label>
            <textarea name="comment" class="form-control">{{ old('comment', $review->comment) }}</textarea>
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
