@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="mb-4">
        <h1 class="fw-bold mb-1">
            <i class="fas fa-user-circle"></i> Profile Settings
        </h1>
        <small class="text-muted">Manage your account information</small>
    </div>

    <div class="row g-4">
        <!-- Profile Information Card -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-edit me-2"></i> Account Information
                    </h5>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label fw-600">Name</label>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Email</label>
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Bio</label>
                            <textarea class="form-control form-control-lg @error('bio') is-invalid @enderror" 
                                      name="bio" rows="3" placeholder="Tell us about yourself...">{{ old('bio', auth()->user()->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(auth()->user()->role === 'artist')
                            <div class="mb-4">
                                <label class="form-label fw-600">
                                    <i class="fab fa-whatsapp me-2"></i> WhatsApp Link
                                </label>
                                <input type="url" class="form-control form-control-lg @error('whatsapp_link') is-invalid @enderror" 
                                       name="whatsapp_link" 
                                       value="{{ old('whatsapp_link', auth()->user()->whatsapp_link) }}"
                                       placeholder="https://wa.me/62812345678">
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle"></i> Clients will use this to contact you for payments
                                </small>
                                @error('whatsapp_link')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-2">
                            <i class="fas fa-save me-2"></i> Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Security Card -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-lock me-2"></i> Change Password
                    </h5>

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-600">Current Password</label>
                            <input type="password" class="form-control form-control-lg @error('current_password') is-invalid @enderror" 
                                   name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">New Password</label>
                            <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   name="password" required>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-600">Confirm Password</label>
                            <input type="password" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" 
                                   name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-outline-primary btn-lg w-100 rounded-2">
                            <i class="fas fa-key me-2"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card border-0 shadow-sm rounded-3 border-danger">
                <div class="card-body p-4">
                    <h5 class="card-title text-danger mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i> Danger Zone
                    </h5>

                    <p class="text-muted small mb-3">
                        Once you delete your account, there is no going back. Please be certain.
                    </p>

                    <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg w-100 rounded-2">
                            <i class="fas fa-trash me-2"></i> Delete Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
