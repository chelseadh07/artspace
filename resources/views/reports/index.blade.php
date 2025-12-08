@extends('layouts.app')

@section('title','Reports')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Reports</h2>
        <a href="{{ route('reports.create') }}" class="btn btn-primary">New Report</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Reported</th>
                <th>Reporter</th>
                <th>Message</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($reports as $r)
            <tr>
                <td>{{ $r->report_id ?? $loop->iteration }}</td>
                <td>{{ $r->reported->name ?? '—' }}</td>
                <td>{{ $r->reporter->name ?? '—' }}</td>
                <td>{{ Str::limit($r->message, 80) }}</td>
                <td>{{ $r->status }}</td>
                <td>
                    <form action="{{ route('reports.updateStatus', $r) }}" method="POST" style="display:inline">@csrf
                        <select name="status" class="form-select d-inline-block" style="width:150px">
                            <option value="open" {{ $r->status==='open' ? 'selected' : '' }}>open</option>
                            <option value="in_review" {{ $r->status==='in_review' ? 'selected' : '' }}>in_review</option>
                            <option value="resolved" {{ $r->status==='resolved' ? 'selected' : '' }}>resolved</option>
                        </select>
                        <button class="btn btn-sm btn-outline-primary">Update</button>
                    </form>
                    <form action="{{ route('reports.destroy', $r) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $reports->links() }}
</div>
@endsection
