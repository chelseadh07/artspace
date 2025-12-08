@extends('layouts.app')
@section('content')
<div class="container py-4">
  <h3 class="text-light">Users</h3>
  <table class="table table-dark table-striped">
    <thead>
      <tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr>
    </thead>
    <tbody>
      @foreach($users as $u)
        <tr>
          <td>{{ $u->id }}</td>
          <td>{{ $u->name }}</td>
          <td>{{ $u->email }}</td>
          <td>{{ $u->role }}</td>
          <td>{{ $u->created_at->format('Y-m-d') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $users->links() }}
</div>
@endsection
