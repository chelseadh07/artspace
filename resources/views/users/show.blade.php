@extends('layouts.app')

@section('title', 'User: ' . $user->name)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $user->name }}</h2>
        <div>
            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete user?')">Delete</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            @if($user->avatar)
                <img src="{{ asset('storage/'.$user->avatar) }}" class="img-fluid rounded">
            @else
                <div class="bg-light p-4 text-center">No avatar</div>
            @endif
        </div>
        <div class="col-md-9">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
            <p><strong>Bio:</strong><br>{{ $user->bio ?? '—' }}</p>
            <p><small class="text-muted">Created: {{ $user->created_at }}</small></p>
        </div>
    </div>
</div>
@endsection
