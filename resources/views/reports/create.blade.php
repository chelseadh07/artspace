@extends('layouts.app')

@section('title','New Report')

@section('content')
<div class="container py-4">
    <h2>Submit Report</h2>
    <form action="{{ route('reports.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Reported User</label>
            <select name="reported_user_id" class="form-control">
                @foreach($orders as $o)
                    @php $other = $o->client_id === auth()->id() ? $o->artist : $o->client; @endphp
                    <option value="{{ $other->user_id }}">{{ $other->name }} (Order #{{ $o->order_id }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Order (optional)</label>
            <select name="order_id" class="form-control">
                <option value="">-- none --</option>
                @foreach($orders as $o)
                    <option value="{{ $o->order_id }}">{{ $o->order_id }} ({{ $o->service->title ?? '—' }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Message</label>
            <textarea name="message" class="form-control">{{ old('message') }}</textarea>
        </div>
        <button class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
