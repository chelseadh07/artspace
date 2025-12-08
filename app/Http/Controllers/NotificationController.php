<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifs = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifs'));
    }

    public function markRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update([
            'is_read' => true
        ]);

        return back();
    }

    public function destroy(Notification $notification)
    {
        if (Auth::id() !== $notification->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $notification->delete();

        return back()->with('success', 'Notification removed.');
    }
}
