<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->q;

        $reports = Report::with(['reported', 'reporter', 'order'])
            ->orderBy('created_at', 'desc');

        if ($q) {
            $reports->where('message', 'like', "%{$q}%");
        }

        $reports = $reports->paginate(12)->withQueryString();

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        // User boleh report hanya di order yang dia terlibat (client atau artist)
        $orders = Order::where('client_id', Auth::id())
            ->orWhere('artist_id', Auth::id())
            ->get();

        return view('reports.create', compact('orders'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'reported_user_id' => 'required|exists:users,user_id',
            'order_id'         => 'nullable|exists:orders,order_id',
            'message'          => 'required|string'
        ]);

        Report::create([
            'reported_user_id' => $r->reported_user_id,
            'reporter_user_id' => Auth::id(),
            'order_id'         => $r->order_id,
            'message'          => $r->message,
            'status'           => 'open'
        ]);

        return redirect()
            ->route('reports.index')
            ->with('success', 'Report submitted.');
    }

    public function updateStatus(Request $r, Report $report)
    {
        // hanya admin boleh ubah status laporan
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $r->validate([
            'status' => 'required|in:open,in_review,resolved'
        ]);

        $report->update([
            'status' => $r->status
        ]);

        return back()->with('success', 'Report status updated.');
    }

    public function destroy(Report $report)
    {
        // reporter & admin boleh hapus
        if (Auth::user()->role !== 'admin' && Auth::id() !== $report->reporter_user_id) {
            abort(403);
        }

        $report->delete();

        return back()->with('success', 'Report removed.');
    }
}
