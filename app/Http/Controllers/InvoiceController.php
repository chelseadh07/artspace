<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    // List invoices untuk client
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'client') {
            $invoices = Invoice::where('client_id', $user->user_id)
                ->with(['order', 'artist'])
                ->latest('issued_at')
                ->paginate(10);
        } else {
            $invoices = Invoice::where('artist_id', $user->user_id)
                ->with(['order', 'client'])
                ->latest('issued_at')
                ->paginate(10);
        }

        return view('invoices.index', compact('invoices'));
    }

    // Create invoice (artist only, dari order yang finished)
    public function create(Order $order)
    {
        // Cek apakah order milik artist yang login
        if ($order->artist_id !== Auth::user()->user_id) {
            abort(403);
        }

        // Cek apakah sudah ada invoice
        if ($order->invoice) {
            return redirect()->route('invoices.show', $order->invoice->invoice_id);
        }

        return view('invoices.create', compact('order'));
    }

    // Store invoice
    public function store(Request $request, Order $order)
    {
        // Cek apakah order milik artist yang login
        if ($order->artist_id !== Auth::user()->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        // Generate invoice number
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(Invoice::count() + 1, 5, '0', STR_PAD_LEFT);

        $invoice = Invoice::create([
            'order_id' => $order->order_id,
            'artist_id' => $order->artist_id,
            'client_id' => $order->client_id,
            'invoice_number' => $invoiceNumber,
            'amount' => $order->price,
            'notes' => $validated['notes'],
            'issued_at' => now(),
        ]);

        return redirect()->route('invoices.show', $invoice->invoice_id)
            ->with('success', 'Invoice berhasil dibuat!');
    }

    // Show invoice detail
    public function show(Invoice $invoice)
    {
        // Cek apakah user adalah artist atau client dari invoice
        if (
            Auth::user()->user_id !== $invoice->artist_id &&
            Auth::user()->user_id !== $invoice->client_id
        ) {
            abort(403);
        }

        $invoice->load(['order', 'artist', 'client']);

        return view('invoices.show', compact('invoice'));
    }

    // Update invoice status (artist)
    public function updateStatus(Request $request, Invoice $invoice)
    {
        if ($invoice->artist_id !== Auth::user()->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        $invoice->update([
            'status' => $validated['status'],
            'paid_at' => $validated['status'] === 'paid' ? now() : null,
        ]);

        return redirect()->back()->with('success', 'Status invoice diperbarui!');
    }
}
