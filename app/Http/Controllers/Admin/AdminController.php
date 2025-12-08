<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\Payment;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard stats
    public function index()
    {
        $totalUsers    = User::count();
        $totalArtists  = User::where('role','artist')->count();
        $totalClients  = User::where('role','client')->count();
        $totalOrders   = Order::count();
        $ordersPending = Order::where('status','pending')->count();
        $totalServices = Service::count();
        $totalPayments = Payment::count();
        $totalReports  = Report::where('status','open')->count();

        return view('admin.dashboard', compact(
            'totalUsers','totalArtists','totalClients',
            'totalOrders','ordersPending','totalServices','totalPayments','totalReports'
        ));
    }

    // Example: manage users (index)
    public function users()
    {
        $users = User::orderBy('created_at','desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    // Example: manage orders (index)
    public function orders()
    {
        $orders = Order::with(['client','artist','service'])
            ->orderBy('created_at','desc')
            ->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }
}
