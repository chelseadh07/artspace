<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtSpace - Showcase Your Art</title>
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

        /* Navbar */
        .navbar {
            background-color: rgba(17, 24, 39, 0.8);
            border-bottom: 1px solid #27272a;
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            color: #9ca3af !important;
            transition: color 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #6366f1 !important;
        }

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 70px);
            text-align: center;
            padding: 2rem;
            background: radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(168, 85, 247, 0.1) 0%, transparent 50%);
        }

        .hero-content h1 {
            font-size: clamp(2.5rem, 10vw, 4rem);
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ffffff, #d1d5db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }

        .hero-content .subtitle {
            font-size: 1.25rem;
            color: #9ca3af;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .btn-primary, .btn-outline-primary {
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4f46e5, #6d28d9);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .btn-outline-primary {
            border: 2px solid #6366f1;
            color: #6366f1;
        }

        .btn-outline-primary:hover {
            background: rgba(99, 102, 241, 0.1);
            transform: translateY(-2px);
        }

        /* Features Section */
        .features {
            padding: 4rem 2rem;
            background-color: rgba(17, 24, 39, 0.5);
            border-top: 1px solid #27272a;
        }

        .features h2 {
            text-align: center;
            margin-bottom: 3rem;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .feature-card {
            background: rgba(24, 24, 27, 0.8);
            border: 1px solid #27272a;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .feature-card:hover {
            border-color: #6366f1;
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.1);
        }

        .feature-icon {
            font-size: 3rem;
            color: #6366f1;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: #9ca3af;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            background-color: rgba(17, 24, 39, 0.8);
            border-top: 1px solid #27272a;
            padding: 2rem;
            text-align: center;
            color: #6b7280;
        }

        .gradient-text {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content .subtitle {
                font-size: 1rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-primary, .btn-outline-primary {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-palette"></i> ArtSpace
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex gap-2">
                    <a href="{{ route('login.page') }}" class="nav-link">Login</a>
                    <a href="{{ route('register.buyer') }}" class="nav-link">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Showcase Your Art to the World</h1>
            <p class="subtitle">Connect with buyers, sell your artwork, and grow your creative business on ArtSpace</p>

            <div class="cta-buttons">
                <a href="{{ route('register.buyer') }}" class="btn btn-outline-primary">
                    <i class="fas fa-shopping-cart"></i> Browse as Buyer
                </a>
                <a href="{{ route('register.artist') }}" class="btn btn-primary">
                    <i class="fas fa-paint-brush"></i> Register as Artist
                </a>
                <a href="{{ route('login.page') }}" class="btn btn-outline-primary">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2>Why Choose ArtSpace?</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3>Secure Transactions</h3>
                        <p>Your data is safe with us. We use industry-standard security protocols.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h3>Global Reach</h3>
                        <p>Connect with artists and buyers from around the world.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Grow Your Business</h3>
                        <p>Manage orders, track payments, and scale your artistic career.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3>24/7 Support</h3>
                        <p>Our team is here to help you succeed on ArtSpace.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 <span class="gradient-text">ArtSpace</span>. All rights reserved.</p>
            <small>Empowering artists and connecting them with buyers worldwide.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
