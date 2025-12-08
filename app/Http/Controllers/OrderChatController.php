<?php

namespace App\Http\Controllers;

use App\Models\OrderChat;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderChatController extends Controller
{
    public function index(Order $order)
    {
        // hanya client atau artist dari order ini yang boleh melihat chat
        if (Auth::id() !== $order->client_id && Auth::id() !== $order->artist_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $chats = $order->chats()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('order_chat.index', compact('order', 'chats'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'order_id'  => 'required|exists:orders,order_id',
            'message'   => 'nullable|string',
            'file'      => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:8192',
        ]);

        $order = Order::findOrFail($r->order_id);

        // izin kirim chat
        if (Auth::id() !== $order->client_id && Auth::id() !== $order->artist_id) {
            abort(403);
        }

        $file = null;
        if ($r->hasFile('file')) {
            $file = $r->file('file')->store('order_chat', 'public');
        }

        OrderChat::create([
            'order_id'  => $order->order_id,
            'sender_id' => Auth::id(),
            'message'   => $r->message,
            'file_url'  => $file,
        ]);

        return back();
    }

    public function destroy(OrderChat $orderChat)
    {
        // hanya pengirim atau admin yang boleh hapus
        if (Auth::id() !== $orderChat->sender_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($orderChat->file_url) {
            Storage::disk('public')->delete($orderChat->file_url);
        }

        $orderChat->delete();

        return back()->with('success', 'Message deleted.');
    }
}
