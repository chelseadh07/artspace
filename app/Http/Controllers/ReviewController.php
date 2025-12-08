<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // list all reviews (opsional untuk admin)
    public function index()
    {
        $reviews = Review::with('order', 'client')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('reviews.index', compact('reviews'));
    }

    // form create review
    public function create(Order $order)
    {
        // hanya client dari order yang boleh memberi review
        if (Auth::id() !== $order->client_id) {
            abort(403);
        }

        // jika sudah pernah review, tidak boleh buat lagi
        if ($order->review) {
            return redirect()
                ->route('orders.show', $order->order_id)
                ->with('error', 'You have already submitted a review.');
        }

        return view('reviews.create', compact('order'));
    }

    // simpan review
    public function store(Request $r)
    {
        $r->validate([
            'order_id' => 'required|exists:orders,order_id',
            'rating'   => 'required|integer|min:1|max:5',
            'comment'  => 'nullable|string|max:2000',
        ]);

        $order = Order::findOrFail($r->order_id);

        if (Auth::id() !== $order->client_id) {
            abort(403);
        }

        // mencegah double review
        if ($order->review) {
            return back()->with('error', 'Review already exists.');
        }

        Review::create([
            'order_id'  => $order->order_id,
            'client_id' => Auth::id(),
            'rating'    => $r->rating,
            'comment'   => $r->comment,
        ]);

        return redirect()
            ->route('orders.show', $order->order_id)
            ->with('success', 'Thank you for your review!');
    }

    // lihat detail review
    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    // form edit review (hanya client yg punya review)
    public function edit(Review $review)
    {
        if (Auth::id() !== $review->client_id) {
            abort(403);
        }

        return view('reviews.edit', compact('review'));
    }

    // update review
    public function update(Request $r, Review $review)
    {
        if (Auth::id() !== $review->client_id) {
            abort(403);
        }

        $r->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $review->update([
            'rating'  => $r->rating,
            'comment' => $r->comment,
        ]);

        return redirect()
            ->route('reviews.show', $review->id)
            ->with('success', 'Review updated.');
    }

    // hapus review
    public function destroy(Review $review)
    {
        if (Auth::id() !== $review->client_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}
