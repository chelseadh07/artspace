@extends('layouts.app')

@section('title','Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="fw-bold mb-1">
            <i class="fas fa-crown text-warning"></i> Admin Dashboard
        </h1>
        <p class="text-muted">System overview and management</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card card-hover h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">
                                <i class="fas fa-users"></i> Total Users
                            </p>
                            <h2 class="stat-number">{{ $totalUsers }}</h2>
                        </div>
                        <div class="icon-box">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card card-hover h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">
                                <i class="fas fa-palette"></i> Artists
                            </p>
                            <h2 class="stat-number">{{ $totalArtists }}</h2>
                        </div>
                        <div class="icon-box" style="background: rgba(168, 85, 247, 0.15); color: #a855f7;">
                            <i class="fas fa-palette"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card card-hover h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">
                                <i class="fas fa-shopping-cart"></i> Orders
                            </p>
                            <h2 class="stat-number">{{ $totalOrders }}</h2>
                            <small class="badge bg-warning mt-2">
                                {{ $ordersPending }} pending
                            </small>
                        </div>
                        <div class="icon-box" style="background: rgba(34, 197, 94, 0.15); color: #22c55e;">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card card-hover h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">
                                <i class="fas fa-flag"></i> Reports
                            </p>
                            <h2 class="stat-number">{{ $totalReports }}</h2>
                        </div>
                        <div class="icon-box" style="background: rgba(239, 68, 68, 0.15); color: #ef4444;">
                            <i class="fas fa-flag"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Actions -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-hover">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-users fa-2x" style="color: #6366f1;"></i>
                    </div>
                    <h5 class="card-title">Manage Users</h5>
                    <p class="text-muted small">View, edit, and manage all users</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-right"></i> View Users
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-hover">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-shopping-cart fa-2x" style="color: #22c55e;"></i>
                    </div>
                    <h5 class="card-title">Manage Orders</h5>
                    <p class="text-muted small">Monitor and manage all orders</p>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-right"></i> View Orders
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-hover">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-chart-bar fa-2x" style="color: #a855f7;"></i>
                    </div>
                    <h5 class="card-title">System Status</h5>
                    <p class="text-muted small">Check system health and status</p>
                    <button class="btn btn-primary btn-sm" disabled>
                        <i class="fas fa-check"></i> All Systems Healthy
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
