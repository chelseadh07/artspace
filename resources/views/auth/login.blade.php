<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ArtSpace</title>
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
            max-width: 400px;
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

        .auth-header p {
            color: #9ca3af;
            font-size: 0.95rem;
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

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #6366f1;
        }

        .remember-me label {
            color: #9ca3af;
            cursor: pointer;
            margin-bottom: 0;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .forgot-password {
            color: #6366f1;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #a855f7;
            text-decoration: underline;
        }

        .btn-login {
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

        .btn-login:hover {
            background: linear-gradient(135deg, #4f46e5, #6d28d9);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .btn-login:active {
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

        @media (max-width: 768px) {
            .auth-card {
                padding: 2rem;
            }

            .auth-header h1 {
                font-size: 1.5rem;
            }

            .form-actions {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="logo">
                    <i class="fas fa-palette"></i>
                </div>
                <h1>Welcome Back</h1>
                <p>Sign in to your ArtSpace account</p>
            </div>

            <!-- Session Status -->
            @if ($status = session('status'))
                <div class="alert">
                    <i class="fas fa-check-circle"></i> {{ $status }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

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
                        autofocus 
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
                        placeholder="Enter your password"
                    />
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="form-actions">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Remember me</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>

                <!-- Footer -->
                <div class="auth-footer">
                    <p>Don't have an account?</p>
                    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 0.75rem;">
                        <a href="{{ route('register.buyer') }}">
                            <i class="fas fa-shopping-cart"></i> Register as Buyer
                        </a>
                        <span style="color: #6b7280;">•</span>
                        <a href="{{ route('register.artist') }}">
                            <i class="fas fa-paint-brush"></i> Register as Artist
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
