<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->q;

        $payments = Payment::with('order')
            ->orderBy('created_at', 'desc');

        // search by order_id
        if ($q) {
            $payments->whereHas('order', function ($sub) use ($q) {
                $sub->where('order_id', $q);
            });
        }

        $payments = $payments->paginate(12)->withQueryString();

        return view('payments.index', compact('payments'));
    }

    public function create(Order $order)
    {
        // hanya client dari order yang boleh upload payment proof
        if (Auth::id() !== $order->client_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('payments.create', compact('order'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'order_id'        => 'required|exists:orders,order_id',
            'amount'          => 'nullable|numeric|min:0',
            'payment_proof'   => 'nullable|image|max:8192',
        ]);

        $order = Order::findOrFail($r->order_id);

        if (Auth::id() !== $order->client_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $proof = null;
        if ($r->hasFile('payment_proof')) {
            $proof = $r->file('payment_proof')->store('payments', 'public');
        }

        Payment::create([
            'order_id'       => $order->order_id,
            'amount'         => $r->amount,
            'method'         => $r->method ?? 'manual_whatsapp',
            'payment_status' => 'waiting_confirmation',
            'payment_proof'  => $proof,
            'payment_date'   => null
        ]);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment proof uploaded. Waiting for artist confirmation.');
    }

    public function show(Payment $payment)
    {
        // hanya client, artist dari order, dan admin yang boleh melihat detail
        $order = $payment->order;

        if (
            Auth::id() !== $order->client_id &&
            Auth::id() !== $order->artist_id &&
            Auth::user()->role !== 'admin'
        ) {
            abort(403);
        }

        return view('payments.show', compact('payment'));
    }

    public function confirm(Payment $payment)
    {
        $order = $payment->order;

        // hanya artist pemilik service atau admin
        if (Auth::id() !== $order->artist_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $payment->update([
            'payment_status' => 'paid',
            'payment_date'   => now(),
        ]);

        // ubah status order supaya masuk tahap pengerjaan
        $order->update(['status' => 'in_progress']);

        return back()->with('success', 'Payment confirmed successfully.');
    }

    public function destroy(Payment $payment)
    {
        $order = $payment->order;

        // client boleh hapus; admin juga boleh
        if (Auth::id() !== $order->client_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($payment->payment_proof) {
            Storage::disk('public')->delete($payment->payment_proof);
        }

        $payment->delete();

        return back()->with('success', 'Payment removed.');
    }
}
