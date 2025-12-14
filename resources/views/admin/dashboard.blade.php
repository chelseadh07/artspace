@extends('layouts.app')

@section('title','Admin Dashboard')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold">Admin Dashboard</h2>
        <p class="text-muted">Overview sistem ArtSpace hari ini</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card p-3">
                <small class="text-muted">Total Users</small>
                <h2 class="fw-bold">{{ $totalUsers }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <small class="text-muted">Artists</small>
                <h2 class="fw-bold">{{ $totalArtists }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <small class="text-muted">Orders</small>
                <h2 class="fw-bold">{{ $totalOrders }}</h2>
                <span class="text-warning small">
                    Pending: {{ $ordersPending }}
                </span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <small class="text-muted">Reports</small>
                <h2 class="fw-bold">{{ $totalReports }}</h2>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light btn-sm">
            Manage Users
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light btn-sm">
            Manage Orders
        </a>
    </div>

</div>
@endsection
