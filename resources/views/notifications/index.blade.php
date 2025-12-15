@extends('layouts.app')

@section('title','Notifications')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="mb-4">
        <h1 class="fw-bold mb-1">
            <i class="fas fa-bell"></i> Notifications
        </h1>
        <p class="text-muted mb-0">Stay updated with your activities</p>
    </div>

    <!-- Notifications List -->
    <div class="row g-3">
        @forelse($notifs as $n)
            <div class="col-12">
                @if($n->is_read)
                    <div class="card card-hover">
                @else
                    <div class="card card-hover" style="border-left: 4px solid #6366f1;">
                @endif
                    <div class="card-body">
                        <div class="row align-items-center">
                            <!-- Message -->
                            <div class="col">
                                <p class="mb-1">
                                    @if(!$n->is_read)
                                        <strong class="text-light">{{ $n->message }}</strong>
                                    @else
                                        <span class="text-muted">{{ $n->message }}</span>
                                    @endif
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> {{ $n->created_at->format('d M Y H:i') }}
                                </small>
                            </div>

                            <!-- Actions -->
                            <div class="col-auto">
                                <div class="d-flex gap-2">
                                    @if(!$n->is_read)
                                        <form action="{{ route('notifications.read', $n) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-primary" title="Mark as read">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('notifications.destroy', $n) }}" method="POST" style="display:inline;" onclick="return confirm('Delete notification?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No notifications</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifs->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $notifs->links() }}
        </div>
    @endif

</div>
@endsection
