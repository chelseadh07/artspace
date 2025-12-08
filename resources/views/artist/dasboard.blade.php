@extends('layouts.app')

@section('title', 'Artist Dashboard')

@section('content')
<div class="container py-4">

    <h2 class="text-light mb-3">Artist Dashboard</h2>
    <p class="text-secondary">Welcome back, {{ auth()->user()->name }} 🎨</p>

    <div class="row g-3">

        <!-- My Artworks -->
        <div class="col-md-4">
            <div class="card h-100 p-3">
                <div class="card-body">
                    <h5 class="card-title">My Artworks</h5>
                    <p class="text-muted mb-2">Upload and manage your artwork portfolio.</p>
                    <a href="{{ route('artworks.index') }}" class="btn btn-primary btn-sm">Manage Artworks</a>
                </div>
            </div>
        </div>

        <!-- My Services -->
        <div class="col-md-4">
            <div class="card h-100 p-3">
                <div class="card-body">
                    <h5 class="card-title">My Services</h5>
                    <p class="text-muted mb-2">Post services for clients to order.</p>
                    <a href="{{ route('services.index') }}" class="btn btn-primary btn-sm">Manage Services</a>
                </div>
            </div>
        </div>

        <!-- Order Requests -->
        <div class="col-md-4">
            <div class="card h-100 p-3">
                <div class="card-body">
                    <h5 class="card-title">Order Requests</h5>
                    <p class="text-muted mb-2">View orders from clients.</p>
                    <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">View Orders</a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
