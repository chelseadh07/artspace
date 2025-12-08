@extends('layouts.app')

@section('title', 'Buyer Dashboard')

@section('content')
<div class="container py-4">

    <h2 class="text-light mb-3">Buyer Dashboard</h2>
    <p class="text-secondary">Welcome back, {{ auth()->user()->name }} 👋</p>

    <div class="row g-3">

        <!-- My Orders -->
        <div class="col-md-4">
            <div class="card h-100 p-3">
                <div class="card-body">
                    <h5 class="card-title">My Orders</h5>
                    <p class="text-muted mb-2">View & manage your commissions.</p>
                    <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">Go to Orders</a>
                </div>
            </div>
        </div>

        <!-- My Reviews -->
        <div class="col-md-4">
            <div class="card h-100 p-3">
                <div class="card-body">
                    <h5 class="card-title">My Reviews</h5>
                    <p class="text-muted mb-2">See the reviews you have written.</p>
                    <a href="{{ route('reviews.index') }}" class="btn btn-primary btn-sm">View Reviews</a>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="col-md-4">
            <div class="card h-100 p-3">
                <div class="card-body">
                    <h5 class="card-title">Notifications</h5>
                    <p class="text-muted mb-2">Check updates regarding your orders.</p>
                    <a href="{{ route('notifications.index') }}" class="btn btn-primary btn-sm">Open Notifications</a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
