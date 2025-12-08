@extends('layouts.app')

@section('title','Admin Dashboard')

@section('content')
<div class="container py-4">
  <h2 class="mb-3 text-light">Admin Dashboard</h2>

  <div class="row g-3">
    <div class="col-md-3">
      <div class="card p-3">
        <div class="card-body">
          <h6>Total Users</h6>
          <h3>{{ $totalUsers }}</h3>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card p-3">
        <div class="card-body">
          <h6>Total Artists</h6>
          <h3>{{ $totalArtists }}</h3>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card p-3">
        <div class="card-body">
          <h6>Total Orders</h6>
          <h3>{{ $totalOrders }}</h3>
          <small class="text-muted">Pending: {{ $ordersPending }}</small>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card p-3">
        <div class="card-body">
          <h6>Open Reports</h6>
          <h3>{{ $totalReports }}</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-4">
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-light me-2">Manage Users</a>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-light">Manage Orders</a>
  </div>
</div>
@endsection
