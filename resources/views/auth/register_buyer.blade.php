<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Buyer - ArtSpace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0e0e0e 0%, #1a1a2e 100%);
            color: #e5e7eb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-card {
            background: rgba(24, 24, 27, 0.8);
            border: 1px solid #27272a;
            border-radius: 12px;
            padding: 2.5rem;
            max-width: 450px;
            width: 100%;
            backdrop-filter: blur(10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header .logo {
            font-size: 2.5rem;
            color: #6366f1;
            margin-bottom: 1rem;
        }

        .auth-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .auth-header .subtitle {
            color: #9ca3af;
            font-size: 0.95rem;
        }

        .auth-header .role-badge {
            display: inline-block;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid #6366f1;
            color: #a5b4fc;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #e5e7eb;
        }

        .form-control {
            background-color: #18181b;
            border: 1px solid #27272a;
            color: #e5e7eb;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .form-control:focus {
            background-color: #1a1a1d;
            border-color: #6366f1;
            color: #e5e7eb;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
            outline: none;
        }

        .form-control::placeholder {
            color: #6b7280;
        }

        .btn-register {
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            color: white;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #4f46e5, #6d28d9);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #27272a;
        }

        .auth-footer p {
            color: #9ca3af;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .auth-footer a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .auth-footer a:hover {
            color: #a855f7;
            text-decoration: underline;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
        }

        @media (max-width: 768px) {
            .auth-card {
                padding: 2rem;
            }

            .auth-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="logo">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h1>Register as Buyer</h1>
                <p class="subtitle">Start discovering amazing artwork</p>
                <span class="role-badge">
                    <i class="fas fa-user"></i> Buyer Account
                </span>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert">
                    <i class="fas fa-exclamation-circle"></i> 
                    <strong>Whoops! Something went wrong.</strong>
                    <ul style="margin-top: 0.5rem; margin-bottom: 0; padding-left: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.buyer') }}">
                @csrf

                <!-- Full Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" 
                        required 
                        autofocus 
                        placeholder="Enter your full name"
                    />
                    @error('name')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" 
                        required 
                        placeholder="Enter your email"
                    />
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control @error('password') is-invalid @enderror"
                        required 
                        placeholder="Create a password (min. 6 characters)"
                    />
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-control"
                        required 
                        placeholder="Confirm your password"
                    />
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-register">
                    <i class="fas fa-check-circle"></i> Create Buyer Account
                </button>

                <!-- Footer -->
                <div class="auth-footer">
                    <p>Want to sell your artwork instead?</p>
                    <a href="{{ route('register.artist') }}">
                        <i class="fas fa-paint-brush"></i> Register as Artist
                    </a>
                    <p style="margin-top: 1rem; margin-bottom: 0;">Already have an account?</p>
                    <a href="{{ route('login.page') }}">
                        <i class="fas fa-sign-in-alt"></i> Sign in here
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
