@extends('layouts.app')

@section('title','Edit User')

@section('content')
<div class="container py-4">
    <h2>Edit User</h2>
    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>
        <div class="mb-3">
            <label>New Password (leave blank to keep)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="client" {{ $user->role==='client'?'selected':'' }}>Client</option>
                <option value="artist" {{ $user->role==='artist'?'selected':'' }}>Artist</option>
                <option value="admin" {{ $user->role==='admin'?'selected':'' }}>Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Bio</label>
            <textarea name="bio" class="form-control">{{ old('bio', $user->bio) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Avatar</label>
            <input type="file" name="avatar" class="form-control">
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
