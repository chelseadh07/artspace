@extends('layouts.app')

@section('title','Create Review')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card bg-dark border-secondary rounded-3 mb-4">
                <div class="card-body p-4">
                    <h2 class="card-title text-light mb-4">
                        <i class="fas fa-star text-warning me-2"></i>Review Order #{{ $order->order_id }}
                    </h2>

                    <!-- Order Summary -->
                    <div class="card bg-darker border-secondary mb-4" style="background-color: #09090b;">
                        <div class="card-body">
                            <p class="text-light mb-2"><strong>Service:</strong> {{ $order->service->title }}</p>
                            <p class="text-light mb-0"><strong>Artist:</strong> {{ $order->artist->name }}</p>
                        </div>
                    </div>

                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                        <input type="hidden" id="ratingValue" name="rating" value="">

                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label text-light fw-600 d-block mb-3">Rating</label>
                            <div class="rating-stars d-flex gap-2" id="starRating">
                                @for($i=1;$i<=5;$i++)
                                    <i class="fas fa-star star-icon" data-rating="{{ $i }}" style="font-size: 2.5rem; cursor: pointer; color: #9ca3af; transition: color 0.2s ease;"></i>
                                @endfor
                            </div>
                            <div class="mt-2">
                                <span id="ratingText" class="text-warning fw-600">Select a rating</span>
                            </div>
                            @error('rating')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div class="mb-4">
                            <label class="form-label text-light fw-600">Comment (Optional)</label>
                            <textarea name="comment" class="form-control bg-dark text-light border-secondary" rows="5" placeholder="Share your experience...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-outline-secondary flex-grow-1">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-paper-plane me-2"></i>Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .star-icon {
        color: #9ca3af;
        transition: color 0.2s ease, text-shadow 0.2s ease;
    }

    .star-icon:hover {
        color: #fbbf24;
        text-shadow: 0 0 10px rgba(251, 191, 36, 0.5);
    }

    .star-icon.filled {
        color: #fbbf24;
    }

    .form-control {
        background-color: #18181b;
        border-color: #27272a;
        color: #e5e7eb;
    }

    .form-control:focus {
        background-color: #18181b;
        border-color: #6366f1;
        color: #e5e7eb;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    }

    .btn-primary {
        background-color: #6366f1;
        border: none;
    }

    .btn-primary:hover {
        background-color: #4f46e5;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-icon');
        const ratingValue = document.getElementById('ratingValue');
        const ratingText = document.getElementById('ratingText');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingValue.value = rating;

                // Update all stars
                stars.forEach(s => {
                    if (s.getAttribute('data-rating') <= rating) {
                        s.classList.add('filled');
                    } else {
                        s.classList.remove('filled');
                    }
                });

                // Update text
                ratingText.textContent = rating + ' Star' + (rating > 1 ? 's' : '');
            });

            // Hover effect
            star.addEventListener('mouseenter', function() {
                const hoverRating = this.getAttribute('data-rating');
                stars.forEach(s => {
                    if (s.getAttribute('data-rating') <= hoverRating) {
                        s.style.color = '#fbbf24';
                    } else {
                        s.style.color = '#9ca3af';
                    }
                });
            });
        });

        // Reset hover on mouse leave
        document.getElementById('starRating').addEventListener('mouseleave', function() {
            stars.forEach(s => {
                if (s.classList.contains('filled')) {
                    s.style.color = '#fbbf24';
                } else {
                    s.style.color = '#9ca3af';
                }
            });
        });

        // Restore old rating if form resubmitted with errors
        const savedRating = '{{ old('rating') }}';
        if (savedRating) {
            const star = document.querySelector('[data-rating="' + savedRating + '"]');
            if (star) {
                star.click();
            }
        }
    });
</script>
@endsection
