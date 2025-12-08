@extends('layouts.app')

@section('title','Create User')

@section('content')
<div class="container py-4">
    <h2>Create User</h2>
    @if($errors->any())
        <div class="alert alert-danger">Please fix the errors below.</div>
    @endif
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="client">Client</option>
                <option value="artist">Artist</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Bio</label>
            <textarea name="bio" class="form-control">{{ old('bio') }}</textarea>
        </div>
        <div class="mb-3">
            <label>Avatar</label>
            <input type="file" name="avatar" class="form-control">
        </div>
        <button class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
