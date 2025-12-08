@extends('layouts.app')
@section('content')
<div class="container py-4">
  <h3 class="text-light">Orders</h3>
  <table class="table table-dark table-striped">
    <thead><tr><th>ID</th><th>Client</th><th>Artist</th><th>Service</th><th>Status</th><th>Created</th></tr></thead>
    <tbody>
      @foreach($orders as $o)
        <tr>
          <td>{{ $o->order_id }}</td>
          <td>{{ $o->client->name ?? '-' }}</td>
          <td>{{ $o->artist->name ?? '-' }}</td>
          <td>{{ $o->service->title ?? '-' }}</td>
          <td>{{ $o->status }}</td>
          <td>{{ $o->created_at->format('Y-m-d') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $orders->links() }}
</div>
@endsection
