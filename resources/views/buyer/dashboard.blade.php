@extends('layouts.app')

@section('title', 'Buyer Dashboard')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <h2 class="text-light mb-1">Welcome back, {{ auth()->user()->name }}</h2>
        <p class="text-muted">
            Discover artists and commission your next artwork ✨
        </p>

        <a href="{{ route('services.index') }}" class="btn btn-primary">
            Browse Services
        </a>
    </div>

    <div class="row g-4">

        <!-- My Orders -->
        <div class="col-md-4">
            <div class="card card-hover h-100 p-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3">
                            🧾
                        </div>
                        <div>
                            <h6 class="mb-0">My Orders</h6>
                            <small class="text-muted">Your commissions</small>
                        </div>
                    </div>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-light btn-sm">
                        View Orders
                    </a>
                </div>
            </div>
        </div>

        <!-- My Reviews -->
        <div class="col-md-4">
            <div class="card card-hover h-100 p-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3">
                            ⭐
                        </div>
                        <div>
                            <h6 class="mb-0">My Reviews</h6>
                            <small class="text-muted">Feedback you gave</small>
                        </div>
                    </div>
                    <a href="{{ route('reviews.index') }}" class="btn btn-outline-light btn-sm">
                        View Reviews
                    </a>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="col-md-4">
            <div class="card card-hover h-100 p-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3">
                            🔔
                        </div>
                        <div>
                            <h6 class="mb-0">Notifications</h6>
                            <small class="text-muted">Order updates</small>
                        </div>
                    </div>
                    <a href="{{ route('notifications.index') }}" class="btn btn-outline-light btn-sm">
                        Open Notifications
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
