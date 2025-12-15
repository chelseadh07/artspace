@extends('layouts.app')

@section('title','Edit Review')

@section('content')
<div class="container-fluid py-4">

    <div style="max-width: 700px; margin: 0 auto;">

        <!-- Header -->
        <div class="mb-4">
            <a href="{{ route('reviews.show', $review) }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <h1 class="fw-bold mb-1">
                <i class="fas fa-edit"></i> Edit Review #{{ $review->id }}
            </h1>
            <p class="text-muted">Update your review for Order #{{ $review->order->order_id }}</p>
        </div>

        <!-- Form Card -->
        <div class="card card-hover">
            <div class="card-body p-5">
                <form action="{{ route('reviews.update', $review) }}" method="POST">
                    @csrf @method('PUT')

                    <!-- Rating -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Rating</label>
                        <div class="mb-3">
                            <div class="btn-group" role="group">
                                @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" class="btn-check" name="rating" id="rating{{ $i }}" 
                                           value="{{ $i }}" {{ $review->rating === $i ? 'checked' : '' }}>
                                    <label class="btn btn-outline-warning" for="rating{{ $i }}">
                                        @for($j = 0; $j < $i; $j++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </label>
                                @endfor
                            </div>
                        </div>
                        @error('rating')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Comment -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Your Comment</label>
                        <textarea name="comment" class="form-control" rows="6" placeholder="Share your thoughts about this service..." required>{{ old('comment', $review->comment) }}</textarea>
                        @error('comment')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Divider -->
                    <hr class="border-dark my-4">

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Save Review
                        </button>
                        <a href="{{ route('reviews.show', $review) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>

</div>

<style>
    .btn-check:checked + .btn-outline-warning {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        border-color: #f59e0b;
        color: white !important;
    }
</style>
@endsection
