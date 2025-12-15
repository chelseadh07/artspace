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
        }

        if (Auth::user()->role === 'artist') {
            $orders->where('artist_id', Auth::id());
        }

        if ($q) {
            $orders->where('description_request', 'like', "%{$q}%");
        }

        $orders = $orders->paginate(12)->withQueryString();

        return view('orders.index', compact('orders'));
    }


    public function create(Service $service = null)
    {
        if (Auth::user()->role !== 'client') {
            abort(403, 'Only buyers can place orders.');
        }

        // Jika ada service spesifik yang di-klik (checkout flow)
        if ($service && $service->status !== 'active') {
            abort(404);
        }

        $services = Service::where('status', 'active')->get();
        $artists  = User::where('role', 'artist')->get();

        return view('orders.create', compact('services', 'artists', 'service'));
    }

    public function store(Request $r)
    {
        if (Auth::user()->role !== 'client') {
            abort(403);
        }

        $r->validate([
            'service_id'          => 'required|exists:services,service_id',
            'artist_id'           => 'required|exists:users,user_id',
            'description_request' => 'nullable|string',
        ]);

        $service = Service::findOrFail($r->service_id);

        $order = Order::create([
            'client_id'           => Auth::id(),
            'artist_id'           => $r->artist_id,
            'service_id'          => $r->service_id,
            'description_request' => $r->description_request,
            'price'               => $service->base_price, // gunakan harga dari service
            'status'              => 'pending',
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order created. Lanjutkan ke checkout untuk pembayaran.');
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $order->client_id) {
            abort(403);
        }

        $services = Service::all();
        $artists  = User::where('role', 'artist')->get();

        return view('orders.edit', compact('order', 'services', 'artists'));
    }

    public function update(Request $r, Order $order)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $order->client_id) {
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
        if (Auth::user()->role !== 'admin' && Auth::id() !== $order->client_id) {
            abort(403);
        }

        $order->delete();

        return back()->with('success', 'Order deleted.');
    }

    // Optional: generate WhatsApp payment link
    public function waLink(Order $order)
    {
        $phone = $order->artist->phone_number ?? '';
        $text  = urlencode("Halo kak, saya ingin konfirmasi pembayaran untuk order ID {$order->order_id}");

        return redirect()->away("https://wa.me/{$phone}?text={$text}");
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

    $order->update([
        'status' => $r->status
    ]);

    return back()->with('success', 'Order status updated.');
}

}
