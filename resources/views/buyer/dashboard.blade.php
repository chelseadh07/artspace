@extends('layouts.app')

@section('title', 'Buyer Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="fw-bold mb-1">
            <i class="fas fa-shopping-bag"></i> Buyer Dashboard
        </h1>
        <p class="text-muted">Welcome back, {{ auth()->user()->name }}! Discover and commission amazing artwork ✨</p>
    </div>

    <!-- CTA Button -->
    <div class="mb-4">
        <a href="{{ route('services.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-search"></i> Browse Services & Artists
        </a>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="card card-hover h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">
                                <i class="fas fa-shopping-cart"></i> My Orders
                            </p>
                            <h2 class="stat-number">0</h2>
                        </div>
                        <div class="icon-box" style="background: rgba(99, 102, 241, 0.15); color: #6366f1;">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="card card-hover h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">
                                <i class="fas fa-star"></i> My Reviews
                            </p>
                            <h2 class="stat-number">0</h2>
                        </div>
                        <div class="icon-box" style="background: rgba(168, 85, 247, 0.15); color: #a855f7;">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="card card-hover h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">
                                <i class="fas fa-bell"></i> Notifications
                            </p>
                            <h2 class="stat-number">0</h2>
                        </div>
                        <div class="icon-box" style="background: rgba(34, 197, 94, 0.15); color: #22c55e;">
                            <i class="fas fa-bell"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Cards -->
    <div class="row g-4">
        <!-- My Orders -->
        <div class="col-md-4">
            <div class="card card-hover">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-shopping-cart fa-2x" style="color: #6366f1;"></i>
                    </div>
                    <h5 class="card-title">My Orders</h5>
                    <p class="text-muted small">Track your commissions and view order status</p>
                    <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-right"></i> View Orders
                    </a>
                </div>
            </div>
        </div>

        <!-- My Reviews -->
        <div class="col-md-4">
            <div class="card card-hover">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-star fa-2x" style="color: #a855f7;"></i>
                    </div>
                    <h5 class="card-title">My Reviews</h5>
                    <p class="text-muted small">View and manage your feedback on artists</p>
                    <a href="{{ route('reviews.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-right"></i> View Reviews
                    </a>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="col-md-4">
            <div class="card card-hover">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-bell fa-2x" style="color: #22c55e;"></i>
                    </div>
                    <h5 class="card-title">Notifications</h5>
                    <p class="text-muted small">Stay updated with order and message alerts</p>
                    <a href="{{ route('notifications.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-right"></i> View Notifications
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
