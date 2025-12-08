@extends('layouts.app')

@section('title','Notifications')

@section('content')
<div class="container py-4">
    <h2>Notifications</h2>
    <ul class="list-group">
    @foreach($notifs as $n)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <div>{{ $n->message }}</div>
                <small class="text-muted">{{ $n->created_at }}</small>
            </div>
            <div>
                @if(!$n->is_read)
                    <form action="{{ route('notifications.read', $n) }}" method="POST" style="display:inline">@csrf
                        <button class="btn btn-sm btn-outline-primary">Mark read</button>
                    </form>
                @endif
                <form action="{{ route('notifications.destroy', $n) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </div>
        </li>
    @endforeach
    </ul>

    {{ $notifs->links() }}
</div>
@endsection
