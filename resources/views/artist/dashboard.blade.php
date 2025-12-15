@extends('layouts.app')

@section('title','Artist Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="fw-bold mb-1">
            <i class="fas fa-palette"></i> Artist Dashboard
        </h1>
        <p class="text-muted">Welcome back, {{ auth()->user()->name }}! 🎨</p>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="card card-hover h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">
                                <i class="fas fa-image"></i> Artworks
                            </p>
                            <h2 class="stat-number">0</h2>
                        </div>
                        <div class="icon-box" style="background: rgba(99, 102, 241, 0.15); color: #6366f1;">
                            <i class="fas fa-image"></i>
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
                                <i class="fas fa-briefcase"></i> Services
                            </p>
                            <h2 class="stat-number">0</h2>
                        </div>
                        <div class="icon-box" style="background: rgba(168, 85, 247, 0.15); color: #a855f7;">
                            <i class="fas fa-briefcase"></i>
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
                                <i class="fas fa-inbox"></i> Orders
                            </p>
                            <h2 class="stat-number">0</h2>
                        </div>
                        <div class="icon-box" style="background: rgba(34, 197, 94, 0.15); color: #22c55e;">
                            <i class="fas fa-inbox"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Cards -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-hover">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-image fa-2x" style="color: #6366f1;"></i>
                    </div>
                    <h5 class="card-title">My Artworks</h5>
                    <p class="text-muted small">Manage your portfolio and showcase your creations</p>
                    <a href="{{ route('artworks.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-right"></i> Manage Artworks
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-hover">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-briefcase fa-2x" style="color: #a855f7;"></i>
                    </div>
                    <h5 class="card-title">Commission Services</h5>
                    <p class="text-muted small">Create and manage your commission offerings</p>
                    <a href="{{ route('services.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-right"></i> Manage Services
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-hover">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-inbox fa-2x" style="color: #22c55e;"></i>
                    </div>
                    <h5 class="card-title">Incoming Orders</h5>
                    <p class="text-muted small">Track and manage your commission orders</p>
                    <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-right"></i> View Orders
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
