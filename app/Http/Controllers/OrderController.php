<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->q;

        $orders = Order::with(['client', 'artist', 'service'])
            ->orderBy('created_at', 'desc');

        if (Auth::user()->role === 'client') {
            $orders->where('client_id', Auth::id());
        } elseif (Auth::user()->role === 'artist') {
            $orders->where('artist_id', Auth::id());
        }

        if ($q) {
            $orders->where('description_request', 'like', "%{$q}%");
        }

        $orders = $orders->paginate(12)->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function create(Service $service)
    {
        if (Auth::user()->role !== 'client') {
            abort(403);
        }

        if ($service->status !== 'active') {
            abort(404, 'Service not available.');
        }

        return view('orders.create', compact('service'));
    }

    public function store(Request $r)
    {
        if (Auth::user()->role !== 'client') {
            abort(403);
        }

        $r->validate([
            'service_id'          => 'required|exists:services,service_id',
            'category_id'         => 'nullable|exists:categories,category_id',
            'description_request' => 'nullable|string',
        ]);

        $service = Service::findOrFail($r->service_id);

        $price = $service->base_price;
        if ($r->category_id) {
            $categoryPrice = $service->categories()
                ->where('categories.category_id', $r->category_id)
                ->first();

            if ($categoryPrice) {
                $price = $categoryPrice->pivot->price;
            }
        }

        $order = Order::create([
            'client_id'           => Auth::id(),
            'artist_id'           => $service->user_id,
            'service_id'          => $r->service_id,
            'description_request' => $r->description_request,
            'price'               => $price,
            'status'              => 'pending',
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order created. Lanjutkan ke checkout.');
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        if (
            Auth::user()->role !== 'admin' &&
            Auth::id() !== $order->client_id &&
            Auth::id() !== $order->artist_id
        ) {
            abort(403);
        }

        $services = Service::all();
        $artists  = User::where('role', 'artist')->get();

        return view('orders.edit', compact('order', 'services', 'artists'));
    }

    public function update(Request $r, Order $order)
    {
        if (
            Auth::user()->role !== 'admin' &&
            Auth::id() !== $order->client_id &&
            Auth::id() !== $order->artist_id
        ) {
            abort(403);
        }

        $r->validate([
            'description_request' => 'nullable|string',
            'price'               => 'nullable|numeric|min:0',
            'status'              => 'required|in:pending,accepted,in_progress,finished,cancelled',
        ]);

        $order->update($r->only(['description_request', 'price', 'status']));

        return redirect()->route('orders.index')->with('success', 'Order updated.');
    }

    public function destroy(Order $order)
    {
        if (
            Auth::user()->role !== 'admin' &&
            Auth::id() !== $order->client_id &&
            Auth::id() !== $order->artist_id
        ) {
            abort(403);
        }

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted.');
    }

    public function updateStatus(Request $r, Order $order)
    {
        if (
            !(Auth::user()->role === 'artist' && Auth::id() === $order->artist_id) &&
            Auth::user()->role !== 'admin'
        ) {
            abort(403);
        }

        $r->validate([
            'status' => 'required|in:pending,accepted,in_progress,finished,cancelled',
        ]);

        $order->update(['status' => $r->status]);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order status updated.');
    }

    public function waLink(Order $order)
    {
        // Redirect to artist's WhatsApp link with pre-filled message
        if (!$order->artist->whatsapp_link) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'Artist WhatsApp link not available.');
        }

        $message = "Halo! Saya ingin membayar untuk order #{$order->order_id}. Service: {$order->service->title}. Total: Rp " . number_format($order->price);
        $waLink = $order->artist->whatsapp_link . "?text=" . urlencode($message);

        return redirect()->away($waLink);
    }
}
