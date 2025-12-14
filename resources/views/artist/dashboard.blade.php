@extends('layouts.app')

@section('title','Artist Dashboard')

@section('content')
<div class="container-fluid">

    <h2 class="fw-bold mb-1">Artist Dashboard</h2>
    <p class="text-muted mb-4">
        Welcome back, {{ auth()->user()->name }}
    </p>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card p-3 h-100">
                <h5>My Artworks</h5>
                <p class="text-muted small">Manage your portfolio</p>
                <a href="{{ route('artworks.index') }}" class="btn btn-primary btn-sm">
                    Manage Artworks
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 h-100">
                <h5>My Services</h5>
                <p class="text-muted small">Commission services</p>
                <a href="{{ route('services.index') }}" class="btn btn-primary btn-sm">
                    Manage Services
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 h-100">
                <h5>Orders</h5>
                <p class="text-muted small">Incoming orders</p>
                <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">
                    View Orders
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
