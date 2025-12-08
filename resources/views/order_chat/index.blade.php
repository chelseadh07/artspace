@extends('layouts.app')

@section('title','Order Chat #'.$order->order_id)

@section('content')
<div class="container py-4">
    <h2>Chat for Order #{{ $order->order_id }}</h2>

    <div class="mb-3">
        @foreach($chats as $c)
            <div class="mb-2">
                <strong>{{ $c->sender->name ?? '—' }}</strong>
                <small class="text-muted">{{ $c->created_at }}</small>
                <div>{{ $c->message }}</div>
                @if($c->file_url)
                    <div><a href="{{ asset('storage/'.$c->file_url) }}" target="_blank">Attachment</a></div>
                @endif
                @if(auth()->check() && (auth()->id()===$c->sender_id || auth()->user()->role==='admin'))
                    <form action="{{ route('order-chat.destroy', $c) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>

    <form action="{{ route('order-chat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
        <div class="mb-3">
            <textarea name="message" class="form-control" placeholder="Type a message..."></textarea>
        </div>
        <div class="mb-3">
            <input type="file" name="file" class="form-control">
        </div>
        <button class="btn btn-primary">Send</button>
    </form>
</div>
@endsection
